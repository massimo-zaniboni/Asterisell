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
sfLoader::loadHelpers(array('I18N', 'Debug', 'Asterisell'));
class reportActions extends autoReportActions {
  public function executeExportToCsv() {
    // execute list operation and then invoke templates/exportToCsvSuccess.php
    //
    return $this->executeList();
  }
  public function executeExportToExcel() {
    // execute list operation and then invoke templates/exportToExcelSuccess.php
    //
    return $this->executeList();
  }
  public function executeList() {
    $this->processSort();
    $this->processFilters();
    $this->filters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/cdr/filters');
    $fullCondition = new Criteria();
    $this->addSortCriteria($fullCondition);
    $this->addFiltersCriteria($fullCondition);
    // Rate the pending CDRs viewable from the current web account
    //
    $rateEngine = new PhpRateEngine();
    list($nr, $isAllOk) = $rateEngine->rateCalls($fullCondition);
    VariableFrame::$filterCondition = $fullCondition;
    VariableFrame::$rateCache = new PhpRateCache();
    VariableFrame::$vendorCache = new ArPartyCache();
    // pager
    //
    // NOTE: use a personalized "forceMyProxyConnection" of "lib/model/CdrPeer.php"
    // in order to create an optimized version of MySQL query associated
    // to the current filter.
    //
    $c = clone ($fullCondition);
    $this->pager = new sfPropelPager('Cdr', 30);
    $this->pager->setCriteria($c);
    $this->pager->setPage($this->getRequestParameter('page', 1));
    $this->pager->setPeerMethod('forceMyProxyConnection');
    $this->pager->init();
  }
  /**
   * Add to $c a filter on curret web accounts CDR
   * in order to display only CDRs viewable from
   * proper accounts.
   */
  protected function addCurrentAccountViewableCdrsCriteria($c) {
    if ($this->getUser()->hasCredential('admin')) {
      // no filter to apply
      
    } else if (!is_null($this->getUser()->getPartyId())) {
      $partyId = $this->getUser()->getPartyId();
      $c->add(ArPartyPeer::ID, $partyId);
      $c->addJoin(ArPartyPeer::ID, ArAsteriskAccountPeer::AR_PARTY_ID);
      $c->addJoin(CdrPeer::ACCOUNTCODE, ArAsteriskAccountPeer::ACCOUNT_CODE);
    } else if (!is_null($this->getUser()->getAccountId())) {
      $accountId = $this->getUser()->getAccountId();
      $c->add(ArAsteriskAccountPeer::ID, $accountId);
      $c->addJoin(CdrPeer::ACCOUNTCODE, ArAsteriskAccountPeer::ACCOUNT_CODE);
    } else {
      trigger_error(__("error during addFiltersCriteria: ") . " getPartyId()==" . $this->getUser()->getPartyId() . " getAccountId()==" . $this->getUser()->getAccountId());
      $this->forward404();
    }
  }
  /**
   * Override addSortCriteris in order to add a more strict filter.
   */
  protected function addFiltersCriteria($c) {
    // Show all Cdr with the configured viewable disposition...
    //
    $dispositions = sfConfig::get('app_billable_cdr_disposition');
    $lastCriterion = null;
    foreach($dispositions as $nr => $disposition) {
      $criterion = $c->getNewCriterion(CdrPeer::DISPOSITION, $disposition);
      $criterion->setIgnoreCase(true);
      if (!is_null($lastCriterion)) {
        $criterion->addOr($lastCriterion);
      }
      $lastCriterion = $criterion;
    }
    $dispositionCriterion = $lastCriterion;
    // ... and with specified amaflags...
    //
    $lastCriterion = null;
    $amaflags = sfConfig::get('app_billable_cdr_amaflags');
    foreach($amaflags as $nr => $amaflag) {
      $criterion = $c->getNewCriterion(CdrPeer::AMAFLAGS, $amaflag);
      if (!is_null($lastCriterion)) {
        $criterion->addOr($lastCriterion);
      }
      $lastCriterion = $criterion;
    }
    $amaflagsCriterion = $lastCriterion;
    // ... combine disposition and amaflags criterion...
    //
    $viewableCriterion = null;
    if ((!is_null($dispositionCriterion)) && is_null($amaflagsCriterion)) {
      $viewableCriterion = $dispositionCriterion;
    } else if (is_null($dispositionCriterion) && (!is_null($amaflagsCriterion))) {
      $viewableCriterion = $amaflagsCriterion;
    } else if (is_null($dispositionCriterion) && is_null($amaflagsCriterion)) {
      $viewableCriterion = null;
    } else {
      $dispositionCriterion->addAnd($amaflagsCriterion);
      $viewableCriterion = $dispositionCriterion;
    }
    // ... or with an income > 0
    // NOTE: if there is no $viewableCriterion then
    // all CDRs are viewable.
    //
    if (!is_null($viewableCriterion)) {
      $criterion = $c->getNewCriterion(CdrPeer::INCOME, 0, Criteria::GREATER_THAN);
      $criterion->addOr($viewableCriterion);
      $c->add($criterion);
    }
    // Process filter_on_party
    //
    $filterOnPartyApplied = false;
    if (isset($this->filters['filter_on_party'])) {
      $partyId = $this->filters['filter_on_party'];
      if ($partyId != "") {
        if ($this->getUser()->hasCredentialOnParty($partyId)) {
          $c->add(ArPartyPeer::ID, $partyId);
          $c->addJoin(ArPartyPeer::ID, ArAsteriskAccountPeer::AR_PARTY_ID);
          $filterOnPartyApplied = true;
        } else {
          unset($this->filters['filter_on_party']);
        }
      }
    }
    // Process filter_on_account
    //
    $filterOnAccountApplied = false;
    if (isset($this->filters['filter_on_account'])) {
      $accountId = $this->filters['filter_on_account'];
      if ($accountId != "") {
        if ($this->getUser()->hasCredentialOnAccount($accountId)) {
          $c->add(ArAsteriskAccountPeer::ID, $accountId);
          $filterOnAccountApplied = true;
        } else {
          unset($this->filters['filter_on_account']);
        }
      }
    }
    // Process filter_on_vendor
    //
    if (isset($this->filters['filter_on_vendor'])) {
      $partyId = $this->filters['filter_on_vendor'];
      if ($partyId != "") {
        $c->add(CdrPeer::VENDOR_ID, $partyId);
      } else {
        unset($this->filters['filter_on_vendor']);
      }
    }
    // Process filter_on_timeframe
    //
    // In order to reduce the number of calls to process
    // the default is a two-week time-frame for a party
    // and last two days for an admin.
    //
    if (isset($this->filters['filter_on_timeframe'])) {
      $frame = $this->filters['filter_on_timeframe'];
    } else {
      if ($this->getUser()->hasCredential('admin')) {
        VariableFrame::$defaultTimeFrameValue = '2';
      } else {
        VariableFrame::$defaultTimeFrameValue = '4';
      }
      $frame = VariableFrame::$defaultTimeFrameValue;
    }
    $timestamp = null;
    switch ($frame) {
      case '0':
        $timestamp = null;
      break;
      case '1':
        $timestamp = strtotime("today");
      break;
      case '2':
        $timestamp = strtotime("-1 day");
      break;
      case '3':
        $timestamp = strtotime("-1 week");
      break;
      case '4':
        $timestamp = strtotime("-2 week");
      break;
      case '5':
        $timestamp = strtotime("-1 month");
      break;
      case '6':
        $timestamp = strtotime("-2 month");
      break;
      case '7':
        $timestamp = strtotime("-4 month");
      break;
      default:
        trigger_error(__("timestamp filter not recognized") . ":" . $frame);
        $this->forward404();
    }
    if (!is_null($timestamp)) {
      $filterDate = date('Y-m-d', $timestamp);
      $c->add(CdrPeer::CALLDATE, $filterDate, Criteria::GREATER_EQUAL);
    }
    // Remove potential dangerous characters from input string
    //
    if (isset($this->filters['filter_on_dst']) && strlen(trim($this->filters['filter_on_dst'])) != 0) {
      $w = $this->filterStrForSQLQuery($this->filters['filter_on_dst']) . '%';
      $c->add(CdrPeer::DST, $w, Criteria::LIKE);
    }
    // A paranoic filter for date input string
    //
    if (isset($this->filters['calldate']['from']) && $this->filters['calldate']['from'] !== '') {
      $this->filters['calldate']['from'] = $this->filterStrForSQLQuery($this->filters['calldate']['from']);
    }
    if (isset($this->filters['calldate']['to']) && $this->filters['calldate']['to'] !== '') {
      $this->filters['calldate']['to'] = $this->filterStrForSQLQuery($this->filters['calldate']['to']);
    }
    // Filter on type of destination number according prefix table
    //
    $addArTelephonePrefixJoin = false;

    if (isset($this->filters['filter_on_dst_operator_type'])) {
      $loc = $this->filters['filter_on_dst_operator_type'];
      if (strlen(trim($loc)) != 0) {
        $addArTelephonePrefixJoin = true;
        $c->add(ArTelephonePrefixPeer::OPERATOR_TYPE, $loc);
      }
    }
    if (isset($this->filters['filter_on_dst_geographic_location'])) {
      $loc = $this->filters['filter_on_dst_geographic_location'];
      if (strlen(trim($loc)) != 0) {
        $addArTelephonePrefixJoin = true;
        $c->add(ArTelephonePrefixPeer::GEOGRAPHIC_LOCATION, $loc);
      }
    }
    
    // Note: add the join on telephone prefix table only if necessary 
    // because otherwise unrated calls are not displayed/calculated
    // due to missing join condition.
    //
    if ($addArTelephonePrefixJoin == true) {
      $c->addJoin(CdrPeer::AR_TELEPHONE_PREFIX_ID, ArTelephonePrefixPeer::ID);
    }

    // This filter is always needed
    //
    $c->addJoin(CdrPeer::ACCOUNTCODE, ArAsteriskAccountPeer::ACCOUNT_CODE);
    // Show only proper calls for administrator/party/account
    // in the case no relevant filter on it is applied
    //
    if (!($filterOnAccountApplied || $filterOnPartyApplied)) {
      $this->addCurrentAccountViewableCdrsCriteria($c);
    }
    parent::addFiltersCriteria($c);
  }
  /**
   * Set to null all the income fields of selected cdrs forcing a re-rate.
   */
  public function executeRecalcCallsCost() {
    $this->processFilters();
    $this->filters = $this->getUser()->getAttributeHolder()->getAll('sf_admin/cdr/filters');
    $c = new Criteria();
    $this->addFiltersCriteria($c);
    CdrPeer::addSelectColumns($c);
    $rs = CdrPeer::doSelectRS($c);
    $totNr = 0;
    $notDeletedNr = 0;
    while ($rs->next()) {
      try {
        $totNr++;
        $cdr = new Cdr();
        $cdr->hydrate($rs);
        $cdr->resetCost();
        $cdr->save();
      }
      catch(Exception $e) {
        $notDeletedNr++;
        // Display only the first error message
        //
        if ($notDeletedNr == 1) {
          $p = new ArProblem();
          $p->setDuplicationKey($e->getCode());
          $p->setDescription('Error during reset of Calls Cost ' . $e->getCode() . ': ' . $e->getMessage());
          ArProblemException::addProblemIntoDBOnlyIfNew($p);
        }
      }
    }
    if ($notDeletedNr > 0) {
      $p = new ArProblem();
      $p->setDuplicationKey('Error during delete of CDRs');
      $p->setDescription($notDeletedNr . ' CDRs were not deleted/rerated for various problems.');
      ArProblemException::addProblemIntoDBOnlyIfNew($p);
    }
    // The list page rate the calls
    //
    return $this->redirect('report/list');
  }
  /**
   * @return ch1 if it is a number / alpha / "-" / "+" / "/" char,
   * "" otherwise
   */
  protected function filterCharForSQLQuery($ch1) {
    $pos = strpos('0123456789 abcdefghijklmnopqrstuvzwyABCDEFGHILMNOPQSTUVZKJWY-+/:', $ch1);
    if ($pos === false) {
      return '';
    } else {
      return $ch1;
    }
  }
  protected function filterStrForSQLQuery($str) {
    $n = strlen($str);
    $w = '';
    for ($i = 0;$i < $n;$i++) {
      $w.= $this->filterCharForSQLQuery(substr($str,$i,1));
    }
    return $w;
  }
}
