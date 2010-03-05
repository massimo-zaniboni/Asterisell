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

    $this->setAttribute('webAccountId', $webAccount->getId());
    $this->setAttribute('paramsId', $webAccount->getArParamsId());

    $this->setCulture(sfConfig::get('app_culture'));
    $this->clearCredentials();

    if (is_null($webAccount->getArPartyId()) && is_null($webAccount->getArOfficeId())) {
      $this->addCredentials('admin');
      $this->setAttribute('partyId', NULL);
      $this->setAttribute('officeId', NULL);
    } else if ((!is_null($webAccount->getArPartyId())) && is_null($webAccount->getArOfficeId())) {
      $this->addCredentials('party');
      $this->setAttribute('partyId', $webAccount->getArPartyId());
      $this->setAttribute('officeId', NULL);
      $this->accountId = NULL;
    } else if (!is_null($webAccount->getArPartyId()) && (!is_null($webAccount->getArOfficeId()))) {
      $this->addCredentials('office');
      $this->setAttribute('partyId', $webAccount->getArPartyId());
      $this->setAttribute('officeId', $webAccount->getArOfficeId());
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
    return $this->getAttribute('webAccountId');
  }

  public function getParamsId() {
    if ($this->isAuthenticated()) {
      return $this->getAttribute('paramsId');
    } else {
      return NULL;
    }
  }

  /**
   * Return params (or create if they do not exist)
   * for the current account/customer. 
   * This methods works also for the initial form.
   *
   * @return an ArParams object
   */
  function getParams() {

    $params = NULL;

    $id = $this->getParamsId();
    if (!is_null($id)) { 
      $params = ArParamsPeer::retrieveByPk($id);
    } 
  
    if (is_null($params)) {
      $c = new Criteria();
      $c->add(ArParamsPeer::IS_DEFAULT, TRUE);
      $params = ArParamsPeer::doSelectOne($c);
      
      if (is_null($params)) {
	$params = new ArParams();
	$params->setIsDefault(TRUE);
	$params->setName("Default");
	$params->setServiceName("Asterisell");
	$params->setServiceProviderWebsite("http://voipinfo.example.com");
	$params->setLegalWebsite("http://www.example.com");
	$params->setServiceProviderEmail("info@example.com");
	$params->setLogoImage("asterisell.png");
	$params->setSlogan("open source web application for rating, showing to customers, and billing Asterisk VoIP calls.");
	$params->setFooter("<center>For info contact:<a href=\"mailto:info@example.com\">info@example.com</a></center>");
	$params->setUserMessage("");
	$params->save();
      }
    }

    return $params;
  }

  /**
   * NULL if the user can not inspect a specific Party
   */
  public function getPartyId() {
    return $this->getAttribute('partyId');
  }
  /**
   * NULL if the user can not inspect a specific Office
   */
  public function getOfficeId() {
    return $this->getAttribute('officeId');
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
   * @return true if the user can read data of the $officeId
   */
  public function hasCredentialOnOffice($officeId) {
    if ($this->hasCredential('admin')) {
      return true;
    } else if ((!is_null($this->getOfficeId())) && $this->getOfficeId() == $officeId) {
      return true;
    } else if (!is_null($this->getPartyId())) {
      $office = ArOfficePeer::retrieveByPK($officeId);
      if ((!is_null($office)) && $office->getArPartyId() == $this->getPartyId()) {
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
}
?>