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

  public function executeIndexWithError() {
      $this->getRequest()->setError('login', __('Password is not correct.'));
      $this->forward('login', 'index');
  }

  protected function forceReloginWithError() {
    $urn = $this->getRequest()->getParameter('access_name');
    // NOTE: this parameter is read from the hidden field of the FORM
    // and not from the URL, because this action is executed after the SUBMIT
    // of the FORM.

    if (!is_null($urn) && strlen(trim($urn)) > 0) {
      $this->redirect('access-error/' . $urn);
    } else {
      $this->executeIndexWithError();
    }
  }

  public function executeLogin() {
    $c = new Criteria();
    $login = filterStrForSQLQuery($this->getRequestParameter('login'));
    $password = filterStrForSQLQuery($this->getRequestParameter('password'));
    $c->add(ArWebAccountPeer::LOGIN, $login);
    $webAccounts = ArWebAccountPeer::doSelect($c);

    if (count($webAccounts) > 1) {
      // Account configured not correctly.
      //
      $this->getUser()->setAuthenticated(false);

      $this->forceReloginWithError();
    } else if (count($webAccounts) == 0) {
      // There is no account with the given name
      //
      $this->getUser()->setAuthenticated(false);
      $this->forceReloginWithError();
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
      // Password is not correct.
      //
      $this->getUser()->logout();
      $this->forceReloginWithError();
    }

    if (is_null($webAccount->getActivateAt()) 
	|| strtotime($webAccount->getActivateAt()) > time()
        || ((! is_null($webAccount->getDeactivateAt())) && strtotime($webAccount->getDeactivateAt()) >= time())) {
      // Account is expired.
      $this->getUser()->logout();
      $this->forceReloginWithError();
    }

    $this->getUser()->login($webAccount);
    if ($this->getUser()->hasCredential('admin')) {
      return $this->redirect('problem/list');
    }

    // Select the best type of call report according the characteristics of the account.
    $module = getSuggestedCallReportModule($this->getUser());
    if (!is_null($module)) {
      $this->redirect($module);
    }  else {
        // Account of unknwon type
        $this->getUser()->logout();
        $this->forceReloginWithError();
    }
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
