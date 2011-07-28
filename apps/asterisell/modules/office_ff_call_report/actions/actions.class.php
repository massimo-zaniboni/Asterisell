<?php
  /**************************************************************
   !!!                                                        !!!
   !!! WARNING: This file is automatic generated.             !!!
   !!!                                                        !!!
   !!! In order to modify this file change the content of     !!!
   !!!                                                        !!!
   !!!    /module_template/call_report_template               !!!
   !!!                                                        !!!
   !!! and execute                                            !!!
   !!!                                                        !!!
   !!!    sh generate_modules.sh                              !!!
   !!!                                                        !!!
   **************************************************************/

sfLoader::loadHelpers(array('I18N', 'Debug', 'Asterisell'));
class office_ff_call_reportActions extends autoOffice_ff_call_reportActions {

  protected $cachedStartDate = NULL;
  protected $cachedEndDate = NULL;
  protected $areDateCached = FALSE;

  public function executeExportToCsv() {
    return $this->redirect('commercial_feature/index');
  }

  public function executeExportToExcel() {
    return $this->redirect('commercial_feature/index');
  }

  public function executeGetSvg() {
    // execute templates/getSvgSuccess.php
    //
    // NOTE: I'm using this method for retrieving files
    // in order to set the http header
    // "content-type" to "image/svg+xml" as required
    // from the browser for SVG files.
    //
    return sfView::SUCCESS;
  }

  public function executeShowChannelUsage() {
    return $this->redirect('commercial_feature/index');
  }

  public function executeHideChannelUsage() {
    $this->setFlash('show_channel_usage', FALSE);
    return $this->forward('admin_tt_call_report', 'list');
  }

  /**
   * Call this function before call other functions on filters.
   */
  protected function initBeforeCalcCondition() {
    $this->processSort();
    $this->processFilters();
    $this->filters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/cdr/filters');
  }

  /**
   * @pre call first self::initBeforeCalcCondition()
   * @return a Condition
   */
  protected function calcConditionWithoutJoins() {
    $fullCondition = new Criteria();
    $this->addFiltersCriteria($fullCondition);
    return $fullCondition;
  }

  /**
   * @pre call first self::initBeforeCalcCondition()
   */
  protected function addJoinsToCondition($c) {
    CdrPeer::addAllJoinsExceptVendorCondition($c);
  }

  /**
   * @pre call first self::initBeforeCalcCondition()
   */
  protected function addOrder($c) {
    $this->addSortCriteria($c);
  }

  public function executeList() {
  
    $this->initBeforeCalcCondition();
    $filterWithJoins = $this->calcConditionWithoutJoins();
    $this->addJoinsToCondition($filterWithJoins);
    list(VariableFrame::$filterOnPartyId, VariableFrame::$filterOnOfficeId, VariableFrame::$filterOnAccountId) = $this->getFiltersOnCallReport($this->filters);
    $this->updateVariableFrameWithHeaderInfo($filterWithJoins);
    
    // NOTE: I don't need sanitize `filter_on_show` because:
    //   * CDRs with proper party/office are already filtered from other part of the framework, 
    //   according security concerns;
    //   * a logged user can see only the proper `filter_on_show` parameters;
    //   * if a malicious user insert wrong `filter_on_show` parameters, 
    //   then he see only one group of his CDRs, and he doesn't see the CDRs 
    //   of other users;
    //
    VariableFrame::$filterOnShow = filterValue($this->filters, 'filter_on_show');
    if (is_null(VariableFrame::$filterOnShow)) {
      VariableFrame::$filterOnShow = '10-calls';
    }  
    
  }

  
  /**
   * Put in VariableFrame information that will be used both
   * from _list_header and _list module.
   * This allows to compute some values only once.
   *
   * @param $c the filter condition used
   */
  protected function updateVariableFrameWithHeaderInfo($c) {

    VariableFrame::$filterCondition = clone($c);

    $filterWithOrder = clone($c);
    $this->addOrder($filterWithOrder);

    VariableFrame::$filterConditionWithOrder = $filterWithOrder;

    list($startDate, $endDate) = $this->getAndUpdateTimeFrame();
    VariableFrame::$startFilterDate = $startDate;
    VariableFrame::$endFilterDate = $endDate;

    VariableFrame::$showChannelUsage = $this->getFlash('show_channel_usage');
    if (is_null(VariableFrame::$showChannelUsage)) {
      VariableFrame::$showChannelUsage = FALSE;
    }

    // Compute values

    $c2 = clone($c);
    $c2->clearSelectColumns();
    $c2->addSelectColumn('COUNT(' . CdrPeer::ID . ')');     // field 0
    $c2->addSelectColumn('SUM(' . CdrPeer::BILLSEC . ')');  // field 1
    $c2->addSelectColumn('SUM(' . CdrPeer::INCOME . ')');   // field 2
    $c2->addSelectColumn('SUM(' . CdrPeer::COST . ')');     // field 3
    $rs = CdrPeer::useCalldateIndex($c2);
    //
    // NOTE: use a personalized "useCalldateIndex" of "lib/model/CdrPeer.php"
    // in order to create an optimized version of MySQL query associated
    // to the current filter.

    $totCalls = 0;
    $totSeconds = 0;
    $totIncomes = 0;
    $totCosts = 0;
    $totEarn = 0;

    foreach($rs as $rec) {
      $totCalls += $rec[0];
      $totSeconds += $rec[1];
      $totIncomes += $rec[2];
      $totCosts += $rec[3];
      $totEarn += $totIncomes - $totCosts;
    }

    VariableFrame::$countOfRecords = $totCalls;
    VariableFrame::$totSeconds = $totSeconds;
    VariableFrame::$totIncomes = $totIncomes;
    VariableFrame::$totCosts = $totCosts;
    VariableFrame::$totEarn = $totEarn;
  }


  /**
   * Override addSortCriteris in order to add a more strict filter.
   *
   * POSTCONDITION: the resulting $c does not contain any select field
   * (required from the pager that adds its fields)
   *
   *
   * POSTCONDITION: filters are checked for sanity/security constraints according
   * the privileges of the logged user.
   * 
   * NOTE: the enabled/disabled filters must the same configured in
   * generator.yml, filters section.
   *
   */
  protected function addFiltersCriteria($c) {
    // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    // IMPORTANT: if you change this code, make sure that logged users
    // can view only their CDR records, and not use only filter parameters,
    // because they can be faked. So use always also logged user criteria.
    // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
  
    list($partyId, $officeId, $accountId) = $this->getFiltersOnCallReport($this->filters);
  
    // NOTE: the joins are already added/processed from
    // "lib/model/CdrPeer::doSelectJoinAllExceptVendor()"
    //
    if (!is_null($accountId)) {
      $c->add(ArAsteriskAccountPeer::ID, $accountId);    
    } 
    if (!is_null($officeId)) {
      $c->add(ArAsteriskAccountPeer::AR_OFFICE_ID, $officeId);    
      $c->add(ArOfficePeer::ID, $officeId);
    }
    if (!is_null($partyId)) {
      $c->add(ArOfficePeer::AR_PARTY_ID, $partyId);    
      $c->add(ArPartyPeer::ID, $partyId);
    }
    
    $filterOnPartyApplied = !is_null($partyId);
    $filterOnOfficeApplied = !is_null($officeId);
    $filterOnAccountApplied = !is_null($accountId);


    // Process filter_on_destination_type
    //
    $filterOnDestinationTypeApplied = false;

          // Normal users do not see unprocessed/ignored calls
      //
      if (!$filterOnDestinationTypeApplied) {
	DestinationType::addCustomerFiltersAccordingConfiguration($c);
      }
    
    // NOTE: filter_on_account and filter_on_office are enabled
    // only if it is enabled also filter_on_party

    // Process filter_on_vendor
    //

    // Manage time frame
    //
    $this->addFilterOnTimeFrame($c);

    // Filter on type of destination number according prefix table
    //
    $loc = filterValue($this->filters, 'filter_on_dst_operator_type');
    if (!is_null($loc)) {
        $c->add(ArTelephonePrefixPeer::OPERATOR_TYPE, $loc);
    }

    $loc = filterValue($this->filters, 'filter_on_dst_geographic_location');
    if (!is_null($loc)) {
      $c->add(ArTelephonePrefixPeer::GEOGRAPHIC_LOCATION, $loc);
    }

    $loc = filterValue($this->filters, 'filter_on_external_telephone_number');
    if (!is_null($loc)) {
        $c->add(CdrPeer::CACHED_MASKED_EXTERNAL_TELEPHONE_NUMBER, $loc .'%', Criteria::LIKE);
    }

    parent::addFiltersCriteria($c);
  }

/**
 * Compute the filter conditions of CALL-REPORT related to party, office and account.
 * Enforce the respect of security access.
 * Only logged users can access this method, due to security.yml. 
 * So this method must check only the correct type of logged user.
 * 
 * @param $filters an array containing all filter parameters of CALL-REPORT.
 * 
 * @return list($partyId, $officeId, $voipAccountId), 
 * with is_null($partyId) if there is no filter specified on the field,
 * and so on for other vars of the result.
 *  
 */
function getFiltersOnCallReport($filters) {

    $partyId = NULL;
    $officeId = NULL;
    $accountId = NULL;

    $sf_user = sfContext::getInstance()->getUser();

    if ($sf_user->hasCredential('admin')) {
        $partyId = filterValue($filters, 'filter_on_party');
    } else {
        // a logged customer has always a specific party associated  
        $partyId = $sf_user->getPartyId();
    }

    if (!is_null($partyId)) {

        if ($sf_user->hasCredential('office')) {
            // a logged office customer, has always a specific office associated 
            $officeId = $sf_user->getOfficeId();
        } else {
            $officeId = filterValue($filters, 'filter_on_office');

            // Test if the office was an old filter associated to a different party
            if (!is_null($officeId)) {
              $office = ArOfficePeer::retrieveByPK($officeId);
              if ($office->getArPartyId() != $partyId) {
                  $officeId = NULL;
              }
            }
            
            if (is_null($officeId)) {
                // test if the party has only one office.          
                $party = ArPartyPeer::retrieveByPK($partyId);
                $officeId = $party->getUniqueOfficeId();
            }
        }

        if (!is_null($officeId)) {
            $accountId = filterValue($filters, 'filter_on_account');

            // Test if the account was an old filter associated to a different office
            if (!is_null($accountId)) {
              $account = ArAsteriskAccountPeer::retrieveByPK($accountId);
              if ($account->getArOfficeId() != $officeId) {
                  $accountId = NULL;
              }
            }
            
            if (is_null($accountId)) {
                // test if the office has only one VoIP account
                $accountId = ArOffice::getUniqueArAsteriskAccountIdForOfficeId($officeId);
            }
        }
    }

    return array($partyId, $officeId, $accountId);
}

  


  /**
   * @return list($startDate, $endDate) in unix timestamp format.
   * @pre call first $this->initBeforeCalcCondition();
   */
  protected function getAndUpdateTimeFrame() {
    if ($this->areDateCached == TRUE) {
      return array($this->cachedStartDate, $this->cachedEndDate);
    }

    $fromDate = null;
    $toDate = null;

    $fromDate1 = filterValue($this->filters, 'filter_on_calldate_from');
    if (!is_null($fromDate1)) {
      $fromDate = fromSymfonyTimestampToUnixTimestamp($fromDate1);
    }

    $toDate1 = filterValue($this->filters, 'filter_on_calldate_to');
    if (!is_null($toDate1)) {
      $toDate = fromSymfonyTimestampToUnixTimestamp($toDate1);
    }

    $frame = filterValue($this->filters, 'filter_on_timeframe');
    if (is_null($frame)) {
      $frame = 0;
    }

    // start from today, removing the time...
    //
    $baseDate = strtotime(fromUnixTimestampToMySQLDate(time()));

    switch ($frame) {
      case '0':
	if (is_null($fromDate)) {
	  // set a default timeframe in order to avoid the processing
	  // of all made calls.
	  //
	  if ($this->getUser()->hasCredential('admin')) {
	    // only 2 days for an admin because he sees the calls
	    // of all his customers and so it is a lot of data.
	    //
	    $fromDate = strtotime("-1 day", $baseDate);
      $toDate = null;

	    $this->filters['filter_on_timeframe'] = '2';
	  } else {
	    // a reasonable default for a customer
	    //
	    $fromDate = strtotime("-2 week", $baseDate);
      $toDate = null;

	    $this->filters['filter_on_timeframe'] = '4';
	  }
	}
	break;
      case '1':
        $fromDate = strtotime("today");
        $toDate = null;
      break;
      case '2':
        $fromDate = strtotime("-1 day", $baseDate);
        $toDate = null;

      break;
      case '3':
        $fromDate = strtotime("-1 week", $baseDate);
        $toDate = null;

      break;
      case '4':
        $fromDate = strtotime("-2 week", $baseDate);
        $toDate = null;

      break;
      case '5':
        $fromDate = strtotime("-1 month", $baseDate);
        $toDate = null;

      break;
      case '6':
        $fromDate = strtotime("-2 month", $baseDate);
        $toDate = null;

      break;
      case '7':
        $fromDate = strtotime("-4 month", $baseDate);
        $toDate = null;
      break;
      case '20':
	// this month
	//
	$now = time();
	$mm = date('m', $now);
	$yy = date('Y', $now);
	$dd = date('t', $now);
	$fromDate = strtotime("$yy-$mm-01");
	$toDate = strtotime("$yy-$mm-$dd");
	$toDate = strtotime("+1 day", $toDate);
	break;
      case '21':
	// last month
	//
	$now = time();
	$mm = date('m', $now);
	$yy = date('Y', $now);

	$mm--;
	if ($mm < 1) {
	  $mm = 12;
	  $yy--;
	}
	$fromDate = strtotime("$yy-$mm-01");
	$dd = date('t', $fromDate);
	$toDate = strtotime("$yy-$mm-$dd");
	$toDate = strtotime("+1 day", $toDate);
	break;
      default:
        trigger_error(__("timestamp filter not recognized") . ":" . $frame);
        $this->forward404();
    }

    $this->cachedStartDate = $fromDate;
    $this->cachedEndDate = $toDate;
    $this->areDateCached = TRUE;

    return array($fromDate, $toDate);
  }

  /**
   * Apply a filter on time frame.
   *
   * @param $c the initial condition
   * @return $c the final condition with the new constraints
   */
  protected function addFilterOnTimeFrame($c) {
    list($fromDate, $toDate) = $this->getAndUpdateTimeFrame();

    if (is_null($toDate)) {
      $filterFromDate = fromUnixTimestampToMySQLTimestamp($fromDate);
      $c->add(CdrPeer::CALLDATE, $filterFromDate, Criteria::GREATER_EQUAL);
    } else {
      $filterFromDate = fromUnixTimestampToMySQLTimestamp($fromDate);
      $filterToDate = fromUnixTimestampToMySQLTimestamp($toDate);

      $c2  = $c->getNewCriterion(CdrPeer::CALLDATE, $filterFromDate, Criteria::GREATER_EQUAL);
      $c2->addAnd($c->getNewCriterion(CdrPeer::CALLDATE, $filterToDate, Criteria::LESS_THAN));
      $c->add($c2);
    }

    $this->filters['filter_on_calldate_to'] =  fromUnixTimestampToSymfonyStrDate($toDate);
    $this->filters['filter_on_calldate_from'] = fromUnixTimestampToSymfonyStrDate($fromDate);
  }

}

?>
