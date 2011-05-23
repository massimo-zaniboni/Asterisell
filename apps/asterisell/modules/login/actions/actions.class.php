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

sfLoader::loadHelpers(array('I18N', 'Debug', 'Asterisell'));
class loginActions extends sfActions {
  /**
   * Executes index action
   *
   */
  public function executeIndex() {
  }

  public function executeLogin() {
    $c = new Criteria();
    $login = filterStrForSQLQuery($this->getRequestParameter('login'));
    $password = filterStrForSQLQuery($this->getRequestParameter('password'));
    $c->add(ArWebAccountPeer::LOGIN, $login);
    $webAccounts = ArWebAccountPeer::doSelect($c);

    if (count($webAccounts) == 0) {
    }

    if (count($webAccounts) > 1) {
      $this->getUser()->setAuthenticated(false);
      $this->getRequest()->setError('login', __('Account configured not correctly. Contact the administrator in order to resolve the problem.'));
      return $this->forward('login', 'index');
    } else if (count($webAccounts) == 0) {
      // There is no account with the given name
      //
      $this->getUser()->setAuthenticated(false);
      $this->getRequest()->setError('login', __('There is no Account with the given name.'));
      return $this->forward('login', 'index');
    } 

    // implicit case $webAccounts == 1
    //
    // NOTE: foreach in this case process only one element
    //
    $webAccount = NULL;
    foreach($webAccounts as $w) {
      $webAccount = $w;
    }

    if ($webAccount->getPassword() != $password) {
      $this->getUser()->logout();
      $this->getRequest()->setError('login', __('Password is not correct.'));
      return $this->forward('login', 'index');
    }

    if (is_null($webAccount->getActivateAt()) 
	|| strtotime($webAccount->getActivateAt()) > time()
        || ((! is_null($webAccount->getDeactivateAt())) && strtotime($webAccount->getDeactivateAt()) >= time())) {
      $this->getUser()->logout();
      $this->getRequest()->setError('login', __('Account is expired.'));
      return $this->forward('login', 'index');
    }

    $this->getUser()->login($webAccount);
    if ($this->getUser()->hasCredential('admin')) {
      return $this->redirect('problem/list');
    }

    // Select the best type of call report according the characteristics of the account.
    // 
    if ($this->getUser()->hasCredential('party')) {
      $showOffice = "t";
      $showAccount = "t";

      $reportType = ArParty::getSuggestedCallReportTypeForParty($this->getUser()->getPartyId());
      switch($reportType) {
	case ArParty::MANY_OFFICES_AND_MANY_VOIP:
	  $showOffice = "t";
	  $showAccount = "t";
	  break;
      case ArParty::MANY_OFFICES_ONE_VOIP:
	  $showOffice = "t";
	  $showAccount = "f";
	  break;
      case ArParty::ONE_OFFICE_MANY_VOIP:
	  $showOffice = "f";
	  $showAccount = "t";
	  break;
      case ArParty::ONE_OFFICE_ONE_VOIP:
	  $showOffice = "f";
	  $showAccount = "f";
	  break;
      default:
	$showOffice = "t";
	$showAccount = "t";
      }	

      $this->redirect('customer_' . $showOffice . $showAccount . '_call_report/list');
    }      
	
    if ($this->getUser()->hasCredential('office')) {
      $showOffice = "f";
      $showAccount = "t";
      
      $officeId = $this->getUser()->getOfficeId();
      $accountId = ArOffice::getUniqueArAsteriskAccountIdForOfficeId($officeId);
      if (!is_null($accountId)) {
	$showAccount = "f";
      }
      $this->redirect('office_' . $showOffice . $showAccount . '_call_report/list');
    }

    $this->getUser()->logout();
    $this->getRequest()->setError('login', __('Account of unknown type.'));
    return $this->forward('login', 'index');
  }

  public function executeLogout() {
    $params = $this->getUser()->getParams(NULL);
    $urn = $params->getLoginUrn();

    $this->getUser()->logout();
    
    if (!is_null($urn) && strlen(trim($urn)) > 0) {
      return $this->redirect('access/' . $urn);
    } else {
      return $this->redirect('login/index');
    }
  }

}
