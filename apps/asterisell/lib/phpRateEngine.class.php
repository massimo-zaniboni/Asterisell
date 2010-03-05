<?php
/*
* Copyright (C) 2007, 2008, 2009
* by Massimo Zaniboni <massimo.zaniboni@profitoss.com>
*
*   This file is part of Asterisell.
*
*   Asterisell is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 3 of the License, or
*   (at your option) any later version.
*
*   Asterisell is distributed in the hope that it will be useful,
*   but WITHOUT ANY WARRANTY; without even the implied warranty of
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*   GNU General Public License for more details.
*
*   You should have received a copy of the GNU General Public License
*   along with Asterisell. If not, see <http://www.gnu.org/licenses/>.
*    
*/
sfLoader::loadHelpers(array('I18N', 'Debug', 'Date', 'Asterisell'));
/**
 * Rate all unrated CDR records.
 *
 * The algorithm mantains a cache of rate methods in order to speedup
 * theirs applications. Use a new instance of this clas for every rate process
 * in order to start with an empty cache and load rate method on demand.
 */
class PhpRateEngine {
  /**
   * Used to cache the PhpRate, 
   * otherwise they must be unserialized 
   * from database every time.
   *
   * It contains values of the type:
   *
   * > [ArRateCategory.id] -> [ArRate, PhpRate]
   *
   * with ArRateCategoryId to null in case of Vendor Rates
   */
  protected $rateCache = array();
  /**
   * Given a filter criteria rate all Cdr records respecting the criteria.
   *
   * @precondition: the $filter parameter must not contain condition
   * on disposition related fields.
   *
   * @return array(the number of rated calls, isAllOk),
   * in case of errors they are added to the Problems table.
   */
  public function rateCalls(Criteria $filter) {
    $isAllOk = TRUE;
    // Profiling
    //
    $time1 = microtime_float();
    $nrOfRates = 0;
    $cdrCondition = clone $filter;
    $cdrCondition->clearGroupByColumns();
    $cdrCondition->clearSelectColumns();
    $cdrCondition->clearOrderByColumns();
    $cdrCondition->addAscendingOrderByColumn(CdrPeer::CALLDATE);
    $cdrCondition->add(CdrPeer::INCOME, null, Criteria::EQUAL);
    CdrPeer::addSelectColumns($cdrCondition);
    $startcol2 = (CdrPeer::NUM_COLUMNS - CdrPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
    $cdrCondition->addJoin(CdrPeer::ACCOUNTCODE, ArAsteriskAccountPeer::ACCOUNT_CODE);
    ArAsteriskAccountPeer::addSelectColumns($cdrCondition);
    $startcol3 = $startcol2 + ArAsteriskAccountPeer::NUM_COLUMNS;
    $cdrCondition->addJoin(ArAsteriskAccountPeer::AR_PARTY_ID, ArPartyPeer::ID);
    ArPartyPeer::addSelectColumns($cdrCondition);
    $startcol4 = $startcol3 + ArPartyPeer::NUM_COLUMNS;
    $telephonePrefixCache = null;
    // Process every $cdr using doSelectRS that fetch only one object at once from DB,
    // this is a *must* because there are many CDRs records...
    //
    $rateCacheInitialized = false;
    $rs = CdrPeer::doSelectRS($cdrCondition);
    while ($rs->next()) {
      $cdr = new Cdr();
      $cdr->hydrate($rs);
      $account = new ArAsteriskAccount();
      $account->hydrate($rs, $startcol2);
      $party = new ArParty();
      $party->hydrate($rs, $startcol3);
      try {
        if ($this->isCdrToRate($cdr)) {
          if ($rateCacheInitialized == false) {
            try {
              // NOTE: cache is initalized now because only now we know the starting date
              //
              $this->rateCache_loadAll($cdr->getCallDate());
              $telephonePrefixCache = new PhpTelephonePrefixesCache();
              $rateCacheInitialized = true;
            }
            catch(ArProblemException $e) {
              $e->addThisProblemIntoDBOnlyIfNew();
              // Exit from rate process because nothing of useful is possible
              // with a bad rateCache
              //
              return array(0, FALSE);
            }
            catch(Exception $e) {
              $p = new ArProblem();
              $p->setDuplicationKey($e->getCode());
              $p->setDescription('During rateCache init ' . $e->getCode() . ': ' . $e->getMessage());
              $p->setCreatedAt(date("c"));
              $p->setEffect("Rating process will not start until the problem is fixed.");
              $p->setProposedSolution("Fix the rate and wait the next rate process or force a rerate of calls.");
              ArProblemException::addProblemIntoDBOnlyIfNew($p);
              // Exit from rate process because nothing of useful is possible
              // with a bad rateCache
              //
              return array(0, FALSE);
            }
          }
          // Assign a end-point-type (or NULL)
          //
          $dstNumber = $cdr->getActualDestinationNumber();
          if (is_null($dstNumber)) {
            $p = new ArProblem();
            $p->setDuplicationKey("no lastapp_valid_value - " . $cdr->getLaspapp());
            $p->setCreatedAt(date("c"));
            $p->setDescription($cdr->getLaspapp() . " is not an accepted value in config/app.yml:lastapp_accepted_values parameter");
            $p->setEffect("CDRs with the given lastapp will not be rated.");
            $p->setProposedSolution("Add the value to the config file after inspecting the correctness of CDR.lastdata field for corresponding records.");
            throw (new ArProblemException($p));
          }
	  
          // Associate the call to its Telephone Operator
          //
          $telephonePrefixId = $telephonePrefixCache->getTelephonePrefixId($dstNumber);
          if (is_null($telephonePrefixId)) {
            $p = new ArProblem();
            $p->setDuplicationKey("no telephone operator prefix");
            $p->setCreatedAt(date("c"));
            $p->setDescription('There is no a telephone operator prefix entry associated to the destination number ' . $dstNumber);
            $p->setEffect("CDRs with destination number of the same type will not be rated.");
            $p->setProposedSolution("Complete the Telephone Prefixes Table. If you are not interested to classification of calls according their operator, then you can also add an Empty Prefix matching all destination numbers and calling it None.");
            throw (new ArProblemException($p));
          }
          // Get the rate
          //
          list($rateCost, $phpRateCost) = $this->rateCache_getRate(null, $cdr);
          list($rateIncome, $phpRateIncome) = $this->rateCache_getRate($party->getArRateCategoryId(), $cdr);
          $costStr = $phpRateCost->getCallCost($cdr);
          $cost = $this->convertToDbMoney($costStr);
          $cdr->setCost($cost);
          $cdr->setCostArRateId($rateCost->getId());
          $cdr->setVendorId($rateCost->getArPartyId());
          $incomeStr = $phpRateIncome->getCallCost($cdr);
          $income = $this->convertToDbMoney($incomeStr);
          $cdr->setIncome($income);
          $cdr->setIncomeArRateId($rateIncome->getId());
          $cdr->setArTelephonePrefixId($telephonePrefixId);
          $cdr->save();
        } else {
          // case not $this->isCdrToRate($cdr)
          // set income and cost to 0 without any particular ar_rate associated
          // to them (null).
          //
          $cdr->setCost(0);
          $cdr->setIncome(0);
          $cdr->save();
        }
      }
      catch(ArProblemException $e) {
        $isAllOk = FALSE;
        $e->addThisProblemIntoDBOnlyIfNew();
      }
      catch(Exception $e) {
        $isAllOk = FALSE;
        $p = new ArProblem();
        $p->setDuplicationKey($e->getCode());
        $p->setDescription($e->getCode() . ': ' . $e->getMessage());
        ArProblemException::addProblemIntoDBOnlyIfNew($p);
      }
      $nrOfRates++;
    }
    // Profiling
    //
    if ($nrOfRates > 0) {
      $time2 = microtime_float();
      $meanTime = (($time2 - $time1) / $nrOfRates);
      $rateForSecond = 1 / $meanTime;
      log_message("Calls Rated: " . $nrOfRates, 'debug');
      log_message("Tot Seconds: " . ($time2 - $time1), 'debug');
      log_message("Mean time for rate: " . $meanTime, 'debug');
      log_message("Calls rated for second: " . $rateForSecond, 'debug');
    }
    return array($nrOfRates, $isAllOk);
  }
  /**
   * Put in rate cache all the rates applicable to cdrs
   * starting from calldate $firstDate.
   *
   * Note: this method is "efficent" because there are not many rates
   * and only valid rates at $cdr->getCalldate must be load.
   */
  protected function rateCache_loadAll($firstDate) {
    $rateCondition = new Criteria();
    $rateCondition1 = $rateCondition->getNewCriterion(ArRatePeer::END_TIME, null, Criteria::EQUAL);
    $rateCondition1->addOr($rateCondition->getNewCriterion(ArRatePeer::END_TIME, $firstDate, Criteria::GREATER_EQUAL));
    $rateCondition->add($rateCondition1);
    $rates = ArRatePeer::doSelect($rateCondition);
    foreach($rates as $rate) {
      $categoryIndex = $rate->getArRateCategoryId();
      $this->checkRateConstraints($rate);
      $phpRate = $rate->unserializePhpRateMethod();
      $this->rateCache[$categoryIndex][$rate->getId() ] = array($rate, $phpRate);
    }
  }
  /**
   * Search in RateCache the correct rate and apply it to $cdr.
   *
   * Remove also from RateCache the rates not applicable to cdrs
   * with calldate equal or greather than the $cdr calldate.
   *
   * @precondition: the rateCache is updated with current (respect $cdr) rates
   * @precondition: $cvIndex and $categoryIndex are coherent with $cdr values
   *
   * @param categoryIndex null for a Vendor Rate,
   * the ArRateCategory id of customers for a Customer rate
   * @param $cdr the call to rate
   *
   * @return an array (ArRate, PhpRate) with the applicable rate
   * @throw ArProblemException
   */
  protected function rateCache_getRate($categoryIndex, $cdr) {
    $resultRate = null;
    $resultPhpRate = null;
    $bestFitness = 0;
    $bestRateClass = "";
    $bestRateIsException = false;
    // start optimistic
    //
    $thereIsConflict = false;
    $cdrDate = $cdr->getCalldate();
    if (array_key_exists($categoryIndex, $this->rateCache)) {
      $arrRates = $this->rateCache[$categoryIndex];
      foreach($arrRates as $index => $rateAndPhpRate) {
        $rate = $rateAndPhpRate[0];
        $phpRate = $rateAndPhpRate[1];
        $rateClass = get_class($phpRate);
        $isException = $rate->getIsException();

        if (!is_null($rate->getEndTime()) && $rate->getEndTime() <= $cdrDate) {
          unset($this->rateCache[$categoryIndex][$index]);
        } else if ($rate->getStartTime() <= $cdrDate) {
          $fitness = $phpRate->isApplicable($cdr);
	  
          $isBestFit = false; // starts pessimistic
          if ($fitness != 0) {
            // if here then the rate is candidate
            // to be applied to cdr.
            // Test if there is a bestRate or a conflict
            //
            if (!$bestRateIsException && $isException) {
	      // if there then this rate is the first
	      // applicable exception rate
	      // and it has for sure priority on other (previous) rates.
	      //
	      // Delete also previous found exceptions because
	      // this rate remove other conflicts.
	      //
              $bestRateIsException = true;
              $isBestFit = true;
	      $thereIsConflict = false;
            } else if ($bestRateIsException == $isException) {
              // current rates and best rate having the same exception priority
              if ($bestFitness == 0) {
                $isBestFit = true;
              } else if (strcmp($rateClass, $bestRateClass) != 0) {
                // it is not admissible to have two different rates
                // of different type, matching on the same CDR
                //
                $thereIsConflict = true;
              } else if (strcmp($rateClass, $bestRateClass) == 0) {
                if ($bestFitness == $fitness) {
                  // it is not admissible to have two rates
                  // with the same fitness
                  //
                  $thereIsConflict = true;
                } else if ($fitness > $bestFitness) {
                  $isBestFit = true;
                }
              }
	    }
	  }
	  	    
          // update bestFitness rate
          //
          if ($isBestFit) {
            $bestFitness = $fitness;
            $bestRateClass = $rateClass;
            $resultPhpRate = $phpRate;
            $resultRate = $rate;
          }
        }
      }
    }
    if ($thereIsConflict || is_null($resultRate)) {
      $p = new ArProblem();
      if (is_null($categoryIndex)) {
        $categoryName = "VENDOR";
      } else {
        $categoryR = ArRateCategoryPeer::retrieveByPK($categoryIndex);
        $categoryName = $categoryR->getName();
      }
      $dateStr = date("Y-m-d", strtotime($cdr->getCalldate()));
      if (is_null($resultRate)) {
        $descr = "No Rate to apply";
      } else {
        $descr = "Too many Rate to apply";
      }
      $p->setDuplicationKey($descr . " - " . $dateStr . " - " . $categoryName . " - " . $cdr->getDstchannel());
      $p->setCreatedAt(date("c"));
      $p->setDescription($descr . " at date " . $dateStr . ", for category " . $categoryName . ", for called number " . $cdr->getActualDestinationNumber() . ", and for dstchannel " . $cdr->getDstchannel());
      $p->setEffect("CDRs in the given rate interval will not be rated.");
      $p->setProposedSolution("Complete the rate table and wait for the next rate pass.");
      throw (new ArProblemException($p));
      
      return null;
    } else {
      return array($resultRate, $resultPhpRate);
    }
  }
  /**
   * @throw ArProblemException
   */
  protected function isCdrToRate(Cdr $cdr) {
    // Malformed cdr
    //
    $cdrProblem = $cdr->isConsistent();
    if (!is_null($cdrProblem)) {
      $p = new ArProblem();
      $p->setDuplicationKey("CDR - " . $cdr->getId());
      $p->setDescription("CDR with id " . $cdr->getId() . " has problem: " . $cdrProblem);
      $p->setCreatedAt(date("c"));
      $p->setEffect("The CDR will not be rated.");
      $p->setProposedSolution("Inspect the CDR and solve the problem. Wait for the next rate pass.");
      throw (new ArProblemException($p));
    }
    // Check disposition field
    //
    $cdrDisposition = trim(strtoupper($cdr->getDisposition()));
    $isbillable = false;
    $arr = sfConfig::get('app_billable_cdr_disposition');
    foreach($arr as $nr => $disposition) {
      if (trim(strtoupper($disposition)) == $cdrDisposition) {
        $isbillable = true;
        break;
      }
    }
    $isnobillable = false;
    $arr = sfConfig::get('app_no_billable_cdr_disposition');
    foreach($arr as $nr => $disposition) {
      if (trim(strtoupper($disposition)) == $cdrDisposition) {
        $isnobillable = true;
        break;
      }
    }
    if (!($isbillable xor $isnobillable)) {
      if ($isbillable) {
        $reason = " is both billable and no-billable.";
      } else {
        $reason = " does not compare in billable config and does not compare in no-billable config.";
      }
      $p = new ArProblem();
      $p->setDuplicationKey('disposition ' . $cdrDisposition);
      $p->setDescription('CDR disposition ' . $cdrDisposition . $reason);
      $p->setCreatedAt(date("c"));
      $p->setEffect("CDR with this dispositions will not rated.");
      $p->setProposedSolution("Update apps/asterisell/config/app.ym and wait for next rate process. Remember to execute 'symfony cc'");
      throw (new ArProblemException($p));
    }
    if ($isbillable) {
      // Now check amaflags field (only if disposition was billable)
      //
      $cdrAmaflags = $cdr->getAmaflags();
      $isbillable = false;
      $arr = sfConfig::get('app_billable_cdr_amaflags');
      foreach($arr as $amaflags) {
        if ($amaflags == $cdrAmaflags) {
          $isbillable = true;
          break;
        }
      }
      $isnobillable = false;
      $arr = sfConfig::get('app_no_billable_cdr_amaflags');
      foreach($arr as $amaflags) {
        if ($amaflags == $cdrAmaflags) {
          $isnobillable = true;
          break;
        }
      }
      if (!($isbillable xor $isnobillable)) {
        $p = new ArProblem();
        if ($isbillable) {
          $reason = " is both billable and no-billable.";
        } else {
          $reason = " does not compare in billable config and does not compare in no-billable config.";
        }
        $p->setDuplicationKey("CDR " . $reason . " - " . $cdrAmaflags);
        $p->setDescription("CDR amaflags " . $cdrAmaflags . $reason);
        $p->setCreatedAt(date("c"));
        $p->setEffect("CDR with the given amaflags will not be rated..");
        $p->setProposedSolution("Update apps/asterisell/config/app.ym and wait for next rate process");
        throw (new ArProblemException($p));
      }
    }
    return $isbillable;
  }
  /**
   * @throw ArProblemException if the ArRate does not respect constraints
   */
  protected function checkRateConstraints(ArRate $rate) {
    if (is_null($rate->getPhpClassSerialization())) {
      $p = new ArProblem();
      $p->setDuplicationKey("Rate - " . $rate->getId());
      $p->setDescription("Rate with id " . $rate->getId() . " has NULL internal phpRate.");
      $p->setCreatedAt(date("c"));
      $p->setEffect("Rating process will not start until the problem is fixed.");
      $p->setProposedSolution("Fix the rate and wait the next rate process or force a rerate of calls.");
      throw (new ArProblemException($p));
    }
    $c = 0;
    if (!is_null($rate->getArPartyId())) {
      $c++;
    }
    if (!is_null($rate->getArRateCategoryId())) {
      $c++;
    }
    if ($c != 1) {
      $p = new ArProblem();
      $p->setDuplicationKey("Rate - " . $rate->getId());
      $p->setDescription("Rate with id " . $rate->getId() . " must be associated to a Customer Category OR to a Vendor, not both.");
      $p->setCreatedAt(date("c"));
      $p->setEffect("Rating process will not start until the problem is fixed.");
      $p->setProposedSolution("Fix the rate and wait the next rate process or force a rerate of calls.");
      throw (new ArProblemException($p));
    }
  }
  /**
   * @param $moneyStr a number without "." with the last PhpRate::calcPrecision digits
   * implicitely associated to the decimal part.
   * @return a integer with the last digit implicitely associated to the decimal part
   * according the number of decimal places associated into config/app.yml file.
   */
  protected function convertToDbMoneyAccordingRate($moneyStr) {
    $sourcePrecision = PhpRate::calcPrecision();
    return PhpRateEngine::convertToDbMoneyAccordingPrecision($moneyStr, $sourcePrecision);
  }
  /**
   * @param $moneyStr a money value with decimals (something like "12.345")
   * @return a integer with the last digits implicitely associated to the decimal part
   * according the number of decimal places specified in config/app.yml for the currency.
   */
  static public function convertToDbMoney($moneyStr) {
    $sourcePrecision = get_decimal_places_for_currency();
    $nr = number_format($moneyStr, $sourcePrecision, '', '');
    return PhpRateEngine::convertToDbMoneyAccordingPrecision($nr, $sourcePrecision);
  }
  /**
   * @param $moneyStr a number without "."
   * @param $sourcePrecisione number of decimals digits in $moneyStr (the last digits)
   *
   * @return a integer with the last digit implicitely associated to the decimal part
   * according the number of decimal places associated into config/app.yml file.
   */
  static public function convertToDbMoneyAccordingPrecision($moneyStr, $sourcePrecision) {
    $destPrecision = get_decimal_places_for_currency();
    $str = str_repeat("0", $sourcePrecision + 1) . trim($moneyStr);
    $sourceDecimalPart = substr($str, 0 - $sourcePrecision);
    $integerPart = substr($str, 0, strlen($str) - $sourcePrecision);
    if ($sourcePrecision >= $destPrecision) {
      $destDecimalPart = substr($sourceDecimalPart, 0, $destPrecision);
    } else {
      $destDecimalPart = $sourceDecimalPart . str_repeat("0", $destPrecision - $sourcePrecision);
    }
    $result = $integerPart . $destDecimalPart;
    return $result;
  }
  /**
   * Rate all unrated CDRs, test for limits and signals to the administrator
   * new errors via mail.
   *
   * @param $sendEmail true if an email must be sent in case of new
   * errors or old errors not already signaled.
   */
  public function rateAllAndTest($sendEmail) {
    $c = new Criteria();
    list($ratedCalls, $isAllOk) = $this->rateCalls($c);
    $costLimit = new PhpCostLimit();
    list($nrOfTotalViolations, $nrOfNewCostLimitViolations) = $costLimit->testCostLimitForAllCustomers();
    // If there were problems send email
    //
    if ($sendEmail) {
      $eol = "\r\n";
      // Notify violations of cost limits
      //
      $costLimitViolationMessage = '';
      if ($nrOfNewCostLimitViolations > 0) {
        $costLimitViolationMessage = $eol . 'There are ' . $nrOfNewCostLimitViolations . ' new customers with a total cost of calls greather than their limits!' . $eol . 'Please check their status and in case disable theirs accounts.';
      }
      // Check if there are new problems
      //
      $c = new Criteria();
      $c->add(ArProblemPeer::SIGNALED_TO_ADMIN, false);
      $rs = ArProblemPeer::doSelect($c);
      $nrOfNewProblems = 0;
      foreach($rs as $r) {
        $nrOfNewProblems++;
        $r->setSignaledToAdmin(true);
        $r->save();
      }
      // Notify new problems
      //
      $newProblemsNotifyMessage = '';
      if ($nrOfNewProblems > 0) {
        $newProblemsNotifyMessage = $eol . $eol . 'There are ' . $nrOfNewProblems . ' new problems related the Call Detail Records (CDRs) rate!' . $eol . ' Please check the Problem Table and correct the errors.';
      }
      // Send email to administrator if there are new problems
      //
      if (strlen($newProblemsNotifyMessage) > 0 || strlen($costLimitViolationMessage) > 0) {
        $mailAddress = sfConfig::get('app_service_provider_mail');
        $headers = 'From: ' . sfConfig::get('app_service_provider_mail') . '\r\n';
        $message = $newProblemsNotifyMessage . $eol . $eol . $costLimitViolationMessage . $eol . $eol . 'Details are accessible at ' . $eol . $eol . sfConfig::get('app_service_provider_customer_web_address') . $eol;
        $subject = 'Problems on Asterisell Database';
        mail($mailAddress, $subject, $message, $headers);
        log_message('SENT MAIL TO: ' . $mailAddress . ' with subject ' . $subject . ' with message: ' . $message, 'debug');
      }
    }
  }
}
?>