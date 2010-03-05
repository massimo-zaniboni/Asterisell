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
/**
 * A Asterisell user with proper data access policies.
 */
class myUser extends sfBasicSecurityUser {
  /**
   * Accept a ArWebAccount object and init the user.
   *
   * precondition: the user has supplied the correct password
   * and the account is valid
   */
  public function login($webAccount) {
    $this->setAuthenticated(true);
    $this->setAttribute('login', $webAccount->getLogin());
    $this->webAccountId = $webAccount->getId();
    $this->setAttribute('uniquePrefixCounter', 1);
    $this->setAttribute('uniquePrefixToRateId', array());
    $this->setCulture(sfConfig::get('app_culture'));
    $this->clearCredentials();
    if (is_null($webAccount->getArPartyId()) && is_null($webAccount->getArAsteriskAccountId())) {
      $this->addCredentials('admin');
      $this->setAttribute('partyId', NULL);
      $this->setAttribute('accountId', NULL);
    } else if ((!is_null($webAccount->getArPartyId())) && is_null($webAccount->getArAsteriskAccountId())) {
      $this->addCredentials('party');
      $this->setAttribute('partyId', $webAccount->getArPartyId());
      $this->setAttribute('accountId', NULL);
      $this->accountId = NULL;
    } else if (is_null($webAccount->getArPartyId()) && (!is_null($webAccount->getArAsteriskAccountId()))) {
      $this->addCredentials('account');
      $this->setAttribute('partyId', NULL);
      $this->setAttribute('accountId', $webAccount->getArAsteriskAccountId());
    } else {
      $this->logout();
      trigger_error(__("Incorrect WebAccount record with id ") . $this->accountId);
    }
  }
  public function logout() {
    $this->setAuthenticated(false);
    $this->clearCredentials();
  }
  public function getWebAccountId() {
    return $this->webAccountId;
  }
  /**
   * NULL if the user can not inspect a specific Party
   */
  public function getPartyId() {
    return $this->getAttribute('partyId');
  }
  /**
   * NULL if the user can not inspect a specific Asterisk Account.
   */
  public function getAccountId() {
    return $this->getAttribute('accountId');
  }
  public function getLogin() {
    return $this->getAttribute('login');
  }
  public function getLoginDescription() {
    return $this->getLogin();
  }
  public function getLanguage() {
    return sfConfig::get('app_culture');
  }
  public function getDateFormat() {
    return $this->getAttribute('date_format');
  }
  /**
   * @return true if the user can read data of the $accountId
   */
  public function hasCredentialOnAccount($accountId) {
    if ($this->hasCredential('admin')) {
      return true;
    } else if ((!is_null($this->getAccountId())) && $this->getAccountId() == $accountId) {
      return true;
    } else if (!is_null($this->getPartyId())) {
      $account = ArAsteriskAccountPeer::retrieveByPK($accountId);
      if ((!is_null($account)) && $account->getArPartyId() == $this->getPartyId()) {
        return true;
      }
    }
    return false;
  }
  public function hasCredentialOnParty($partyId) {
    if ($this->hasCredential('admin')) {
      return true;
    } else if ($this->getPartyId() == $partyId) {
      return true;
    }
    return false;
  }
  public function createUniquePrefixAssociatedToRateId($rateId) {
    $r = $this->getAttribute('uniquePrefixCounter');
    $r = $r + 1;
    $this->setAttribute('uniquePrefixCounter', $r);
    $prefix = 'prefix_' . $r;
    $a = $this->getAttribute('uniquePrefixToRateId');
    $a[$prefix] = $rateId;
    $this->setAttribute('uniquePrefixToRateId', $a);
    return $prefix;
  }
  public function getRateIdAssociatedToUniquePrefix($uniquePrefix) {
    $a = $this->getAttribute('uniquePrefixToRateId');
    if (array_key_exists($uniquePrefix, $a)) {
      return $a[$uniquePrefix];
    } else {
      $this->logout();
      trigger_error(__("Incorrect UniquePrefix ") . $uniquePrefix);
      return NULL;
    }
  }
  public function releaseUniquePrefix($uniquePrefix) {
    $a = $this->getAttribute('uniquePrefixToRateId');
    $a[$uniquePrefix] = NULL;
    $a = $this->setAttribute('uniquePrefixToRateId', $a);
  }
}
?>