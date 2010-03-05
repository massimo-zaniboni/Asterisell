<?php
/*
* Copyright (C) 2007 Massimo Zaniboni - massimo.zaniboni@profitoss.com
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
class loginActions extends sfActions {
  /**
   * Executes index action
   *
   */
  public function executeIndex() {
  }
  public function executeLogin() {
    $c = new Criteria();
    $login = $this->filterStrForSQLQuery($this->getRequestParameter('login'));
    $password = $this->filterStrForSQLQuery($this->getRequestParameter('password'));
    $c->add(ArWebAccountPeer::LOGIN, $login);
    $webAccounts = ArWebAccountPeer::doSelect($c);
    if (count($webAccounts) > 1) {
      // Problem: there are two different web_accounts with the same login
      //
      $this->getUser()->setAuthenticated(false);
      $this->getRequest()->setError('login', __('Account configured not correctly. Contact the administrator in order to resolve the problem.'));
      return $this->forward('login', 'index');
    } else if (count($webAccounts) == 0) {
      // There is no account with the given name
      //
      $this->getUser()->setAuthenticated(false);
      $this->getRequest()->setError('login', __('There is no Account with the given name.'));
      return $this->forward('login', 'index');
    } else if (count($webAccounts) == 1) {
      // NOTE: foreach in this case process only one element
      //
      foreach($webAccounts as $webAccount) {
        if ($webAccount->getPassword() != $password) {
          $this->getUser()->logout();
          $this->getRequest()->setError('login', __('Password is not correct.'));
          return $this->forward('login', 'index');
        } else {
          if ((!is_null($webAccount->getActivateAt()) && (strtotime($webAccount->getActivateAt()) <= time()) && (is_null($webAccount->getDeactivateAt()) || (strtotime($webAccount->getDeactivateAt()) > time())))) {
            $this->getUser()->login($webAccount);
            if ($this->getUser()->hasCredential('admin')) {
              return $this->redirect('problem/list');
            } else {
              return $this->redirect('report/list');
            }
          } else {
            $this->getUser()->logout();
            $this->getRequest()->setError('login', __('Account is expired.'));
            return $this->forward('login', 'index');
          }
        }
      }
    }
  }
  public function executeLogout() {
    $this->getUser()->logout();
    // Use the default language indicated from the browser
    //
    require_once ('I18N/I18N_Negotiator.class.php');
    $negotiator = new I18N_Negotiator();
    $cultureName = $negotiator->getLanguageMatch();
    $this->getUser()->setCulture($cultureName);
    return $this->redirect('login/index');
  }
  /**
   * @return ch1 if it is a number / alpha / "-" / "+" / "/" char,
   * "" otherwise
   */
  protected function filterCharForSQLQuery($ch1) {
    $pos = strpos('0123456789 abcdefghijklmnopqrstuvzwxyABCDEFGHILMNOPQSTUVZKJWXY-+/:@', $ch1);
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
      $w.= $this->filterCharForSQLQuery($str[$i]);
    }
    return $w;
  }
}
