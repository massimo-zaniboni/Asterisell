<?php

/* $LICENSE 2009, 2010:
 *
 * Copyright (C) 2009, 2010 Massimo Zaniboni <massimo.zaniboni@profitoss.com>
 *
 * This file is part of Asterisell.
 *
 * Asterisell is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * Asterisell is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Asterisell. If not, see <http://www.gnu.org/licenses/>.
 * $
 */

sfLoader::loadHelpers(array('I18N', 'Debug', 'Date', 'Asterisell'));

/**
 * Rate all unrated CDR records.
 */
class RateCalls extends FixedJobProcessor {

  /**
   * Used to cache the PhpRate, 
   * otherwise they must be unserialized 
   * from database every time.
   *
   * It contains values of the type:
   *
   * > (DestinationType) => (ArRateCategory.id) => (ArRate.Id) => (ArRate, PhpRate)
   *
   * with ArRateCategoryId equals to null in case of Vendor Rates or System Rates.
   */
  protected $rateCache = array();

  /**
   * Rate all pending CDRs.
   *
   * @return always TRUE. Errors are reported on the error table.
   */
  public function process() {

    // Profiling
    //
    $time1 = microtime_float();
    $nrOfRates = 0;

    // Retrieve the CDR to process
    //
    $cdrCondition = new Criteria();
    CdrPeer::addSelectColumns($cdrCondition);
    $cdrCondition->addAscendingOrderByColumn(CdrPeer::CALLDATE);
    // NOTE: this ascending order is very important because the
    // alghoritm access the rate cache according the order of calls.
    $cdrCondition->add(CdrPeer::DESTINATION_TYPE, DestinationType::unprocessed, Criteria::EQUAL);

    // Start with an empty telephone prefix cache
    //
    $telephonePrefixCache = null;

    // Process every $cdr using doSelectRS that fetch only one object at once from DB,
    // this is a *must* because there can be many CDRs records to process.
    //
    $rateCacheInitialized = false;
    $rs = CdrPeer::doSelectRS($cdrCondition);
    while ($rs->next()) {
      $cdr = new Cdr();
      $cdr->hydrate($rs);

      // Try to process the $cdr.
      // NOTE: the implicit contracts is that any problem 
      // is thrown by an exception (from this code and other called functions)
      // and signaled to the user in the catch part.
      // Then the processing continue with another $cdr.
      // 
      try {

        // Test for malformed cdr
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

        if ($rateCacheInitialized == false) {
          try {
            // NOTE: cache is initalized now because only now we know the starting date
            // and because in this way we can init it only when it is really necessary.
            //
            $this->rateCache_loadAll($cdr->getCallDate());
            $telephonePrefixCache = new PhpTelephonePrefixesCache();
	    $numberPortabilityCache = new ArNumberPortabilityCache();
            $rateCacheInitialized = true;
          } catch(ArProblemException $e) {
              $e->addThisProblemIntoDBOnlyIfNew();
              // Exit from rate process because nothing of useful is possible
              // with a bad rateCache
              //
              return TRUE;
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
              return TRUE;
            }
	}

	// Link CDR to its ArAsteriskAccount
	//
	$accountcode = $cdr->getAccountcode();
	$account = VariableFrame::getArAsteriskAccountByCodeCache()->getArAsteriskAccountByCode($accountcode);
	if (is_null($account)) {
	  $p = new ArProblem();
	  $p->setDuplicationKey("unknown ArAsteriskAccount $accountcode");
	  $p->setCreatedAt(date("c"));
	  $p->setDescription("\"$accountcode\" Asterisk account code is used in CDR with id \"" . $cdr->getId() . "\", but it is not defined in ArAsteriskAccount table (VoIP Accounts).");
	  $p->setEffect("All CDRs with this account will not rated.");
	  $p->setProposedSolution("Complete the Asterisk Account table (VoIP accounts). The CDRs will be rated automatically at the next execution pass of Jobs.");
	  throw (new ArProblemException($p));
	}
	$cdr->setArAsteriskAccountId($account->getId());

	$office = VariableFrame::getOfficeCache()->getArOffice($account->getArOfficeId());
	$party = VariableFrame::getVendorCache()->getArParty($office->getArPartyId());

	// Assign internal and external telephone numbers
	//
	// NOTE: wait to assign masked telephone number because
	// it depends also from the type of the call
	// and up to date it is not setted.
	//
	$cdr->setCachedInternalTelephoneNumber($cdr->getInternalTelephoneNumber());
	$cdr->setCachedExternalTelephoneNumber($cdr->getExternalTelephoneNumber());

	// Assign a end-point-type (or NULL)
	//
	$dstNumber = $cdr->getExternalTelephoneNumber();
	if (is_null($dstNumber)) {
	  $p = new ArProblem();
	  $p->setDuplicationKey("CDR without external telephone number " . $cdr->getId());
	  $p->setCreatedAt(date("c"));
	  $p->setDescription("The CDR record with id " . $cdr->getId() . " has no external telephone number.");
	  $p->setEffect("The CDR is not rated.");
	  $p->setProposedSolution("The problem can reside in the CDR record or in the application configuration. If you change a lot the configuration, you must force a reset and rerate of old calls in order to propagate the effects.");
	  throw (new ArProblemException($p));
	}

	// Apply number portability
	//
	if ($numberPortabilityCache->isUnderNumberPortability($dstNumber)) {
	  $dstNumber = ArNumberPortability::checkPortability($dstNumber, $cdr->getCalldate());
	}

        $cdr->setExternalTelephoneNumberWithAppliedPortability($dstNumber);

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
	$cdr->setArTelephonePrefixId($telephonePrefixId);

	// First apply a rate of type "isForUnprocessedCDR"
	//
	if ($cdr->getDestinationType() == DestinationType::unprocessed) {
	  list($rate, $phpRate) = $this->getPhpRate($cdr, null);
	  $phpRate->processCDR($cdr, $rate, false);

	  // Signal a problem if $cdr is again in unprocessed state.
	  //
	  if ($cdr->getDestinationType() == DestinationType::unprocessed) {
	    $p = new ArProblem();
	    $p->setDuplicationKey("CDR - " . $cdr->getId());
	    $p->setDescription("CDR with id " . $cdr->getId() . " was processed from rate with id " . $rate->getId() . " but CDR.destination_type is still \"unprocessed\".");
	    $p->setCreatedAt(date("c"));
	    $p->setEffect("The CDR will not be rated.");
	    $p->setProposedSolution("Inspect the rates configurations, and solve the problem. Wait for the next rate pass.");
	    throw (new ArProblemException($p));
	  }
        }

	// Now that the rate is classified, calculate also the masked external telephone number
	//
	$cdr->setCachedMaskedExternalTelephoneNumber($cdr->getMaskedExternalTelephoneNumber());

	// Rate the processed CDR
	//
	if ($cdr->getDestinationType() == DestinationType::ignored) {
          // this $cdr is makerd as "ignored" so its cost/income is simply 0.
          //
          $cdr->setCost(0);
          $cdr->setIncome(0);
        } else {
	  // calc cost
	  //
	  list($rate, $phpRate) = $this->getPhpRate($cdr, null);
	  $phpRate->processCDR($cdr, $rate, true);

	  // calc income
	  //
	  list($rate, $phpRate) = $this->getPhpRate($cdr, $party->getArRateCategoryId());
	  $phpRate->processCDR($cdr, $rate, false);
	}
	
        // NOTE: if there were problems an exception were be raised from "getPhpRate".

	// Save the CDR if it is completely processed
	// NOTE: the code signals exceptions for unrated CDRs
	// during previous calls.
	//
	$cdr->save();

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
    $time2 = microtime_float();
    $totTime = $time2 - $time1;
    $meanTime = "n.c.";
    $rateForSecond = "n.c.";
    if ($nrOfRates > 0) {
      $meanTime = $totTime / $nrOfRates;
      if ($meanTime > 0) {
	$rateForSecond = 1 / $meanTime;
      }
    }

    return "$nrOfRates calls rated, $rateForSecond calls rated for second, $totTime seconds as total execution time";

  }
  /**
   * Put in rate cache all the rates applicable to cdrs
   * starting from calldate $firstDate.
   *
   * Return an exception in case of problems.
   *
   * Note: this method is "efficent" because there are not many rates
   * and only valid rates at $cdr->getCalldate must be loaded in the cache.
   */
  protected function rateCache_loadAll($firstDate) {
    $rateCondition = new Criteria();
    $rateCondition1 = $rateCondition->getNewCriterion(ArRatePeer::END_TIME, null, Criteria::EQUAL);
    $rateCondition1->addOr($rateCondition->getNewCriterion(ArRatePeer::END_TIME, $firstDate, Criteria::GREATER_EQUAL));
    $rateCondition->add($rateCondition1);
    $rates = ArRatePeer::doSelect($rateCondition);
    foreach($rates as $rate) {
      $destinationType = $rate->getDestinationType();
      $categoryIndex = $rate->getArRateCategoryId();
      $this->checkRateConstraints($rate);
      $phpRate = $rate->unserializePhpRateMethod();

      // (DestinationType) => (ArRateCategory.id) => (ArRate.Id) => (ArRate, PhpRate)
      //       
      $this->rateCache[$destinationType][$categoryIndex][$rate->getId()] = array($rate, $phpRate);
    }
  }
  /**
   * Search in RateCache the correct rate and apply it to $cdr.
   *
   * @precondition: the rateCache is updated with current (respect $cdr) rates
   * @precondition: $cvIndex and $categoryIndex are coherent with $cdr values
   *
   * @param $cdr the $cdr to wich the rate must be applied
   * @param categoryIndex null for a Vendor Rate (cost calculation) or unprocessed CDR,
   * the ArRateCategory id of customers for a Customer rate (income calculation).
   *
   * @return an array (ArRate, PhpRate) with the applicable rate
   * @throw ArProblemException in case of missing or not unique rates to apply.
   *
   */
  protected function getPhpRate(Cdr $cdr, $categoryIndex) {
    $destinationType = $cdr->getDestinationType();
    $resultRate = null;
    $resultPhpRate = null;
    $bestFitness = 0;
    $bestRateClass = "";
    $bestRateIsException = false;

    // start optimistic
    //
    $thereIsConflict = false;
    $cdrDate = $cdr->getCalldate();

    // Search the rate in the cache with format
    //
    // > (DestinationType) => (ArRateCategory.id) => (ArRate.Id) => (ArRate, PhpRate)
    //
    $arrRates = null;
    if (array_key_exists($destinationType, $this->rateCache)) {
      $arrRates1 = $this->rateCache[$destinationType];
      if (array_key_exists($categoryIndex, $arrRates1)) {
        $arrRates = $arrRates1[$categoryIndex];
      }
    }

    if (!is_null($arrRates)) {
      foreach($arrRates as $index => $rateAndPhpRate) {
        $rate = $rateAndPhpRate[0];
        $phpRate = $rateAndPhpRate[1];
        $rateClass = get_class($phpRate);
        $isException = $rate->getIsException();

        if ($cdrDate >= $rate->getStartTime() && (is_null($rate->getEndTime()) || $cdrDate < $rate->getEndTime())) {

          $fitness = $phpRate->isApplicable($cdr);

          $isBestFit = false; // starts pessimistic
          if ($fitness != 0) {
  
            // if here, then the rate is candidate
            // to be applied to cdr.
            // Test if there is a bestRate or a conflict
            //
            if (!$bestRateIsException && $isException) {
	      // if there, then this rate is the first
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

      // These variables are used in order to set duplication-key.
      //
      $startOfDescr = '';
      $categoryName = '';
      $dateStr = date("Y-m-d", strtotime($cdr->getCalldate()));

      // Create the error descritpion and initialize duplication-key
      // variables.
      //
      if (is_null($resultRate)) {
        $startOfDescr = "No Rate to apply";
      } else {
        $startOfDescr = "Too many Rate to apply";
      }

      $descr = $startOfDescr;
      $descr .= " at date " . $dateStr;

      $descr .= ' on CDR with id "' . $cdr->getId() . '", and destination_type "' . DestinationType::getUntraslatedName($cdr->getDestinationType()) . '" ';
      if ($cdr->getDestinationType() != DestinationType::unprocessed) {
        if (is_null($categoryIndex)) {
          $categoryName = 'vendor';
        } else {
          $categoryR = ArRateCategoryPeer::retrieveByPK($categoryIndex);
          $categoryName = $categoryR->getName();
        }
        $descr .= ' for category "' . $categoryName . '"';
      }
      $descr .= ' for external telephone number "' . $cdr->getExternalTelephoneNumber() . '" (with number portability applied it is "' . $cdr->getExternalTelephoneNumberWithAppliedPortability() . '"), and for dstchannel "' . $cdr->getDstchannel() . '"';

      $p->setDescription($descr);
      $p->setDuplicationKey($startOfDescr . " - " . $dateStr . " - " . $categoryName . " - " . $cdr->getDstchannel());
      $p->setCreatedAt(date("c"));
      $p->setEffect("CDRs in the given rate interval will not be rated.");
      $p->setProposedSolution("Complete the rate table and wait for the next rate pass.");
      throw (new ArProblemException($p));
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
    return true;
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
   
    if ($rate->getDestinationType() == DestinationType::unprocessed && $c != 0) {
      $p = new ArProblem();
      $p->setDuplicationKey("Rate - " . $rate->getId());
      $p->setDescription("Rate with id " . $rate->getId() . " can not be associated to a customer category or to a vendor because it works on unprocessed CDRs.");
      $p->setCreatedAt(date("c"));
      $p->setEffect("Rating process will not start until the problem is fixed.");
      $p->setProposedSolution("Fix the rate and wait the next rate process or force a rerate of calls.");
      throw (new ArProblemException($p));
    }

    if ($rate->getDestinationType() != DestinationType::unprocessed && $c != 1) {
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
   * Rate all unrated CDRs, test for limits and signals to the administrator
   * new errors via mail.
   *
   * @param $sendEmail true if an email must be sent in case of new
   * errors or old errors not already signaled.
   */
  public function rateAllAndTest($sendEmail) {
    list($ratedCalls, $isAllOk) = $this->rateCalls();
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