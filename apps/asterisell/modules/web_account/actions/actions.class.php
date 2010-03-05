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
class web_accountActions extends autoweb_accountActions {
  protected function updateArWebAccountFromRequest() {
    // Manage buttons of Owner section,
    //
    if ($this->getRequestParameter('set_as_admin')) {
      $this->ar_web_account->setArPartyId(null);
      $this->ar_web_account->setArAsteriskAccountId(null);
    } else if ($this->getRequestParameter('change_customer')) {
      $this->ar_web_account->setArPartyId(null);
      $this->ar_web_account->setArAsteriskAccountId(null);
    } else if ($this->getRequestParameter('change_customer_or_voipaccount')) {
      $this->ar_web_account->setArPartyId($this->ar_web_account->getArAsteriskAccount()->getArPartyId());
      $this->ar_web_account->setArAsteriskAccountId(null);
    } else if ($this->getRequestParameter('mycustomer')) {
      $customerId = $this->getRequestParameter('mycustomer');
      if ($customerId == "") {
        $customerId = null;
      }
      $this->ar_web_account->setArPartyId($customerId);
      $this->ar_web_account->setArAsteriskAccountId(null);
    } else if ($this->getRequestParameter('myvoipaccount')) {
      $voipaccountId = $this->getRequestParameter('myvoipaccount');
      if ($voipaccountId == "") {
        $voipaccountId = null;
      }
      $this->ar_web_account->setArPartyId(null);
      $this->ar_web_account->setArAsteriskAccountId($voipaccountId);
    }
    parent::updateArWebAccountFromRequest();
  }
  /**
   * Override addSortCriteris in order to manage particular filter
   * not derivable from generator due to the strange model of ar_web_account
   */
  protected function addFiltersCriteria($c) {
    $applied = false;
    if ((!$applied) && isset($this->filters['filter_on_admin'])) {
      $onlyAdmin = $this->filters['filter_on_admin'];
      if ($onlyAdmin) {
        $c->add(ArWebAccountPeer::AR_ASTERISK_ACCOUNT_ID, null);
        $c->add(ArWebAccountPeer::AR_PARTY_ID, null);
        $applied = true;
      }
    }
    if ((!$applied) && isset($this->filters['filter_on_account'])) {
      // Select all the accounts related to the specified party
      //
      $partyId = $this->filters['filter_on_account'];
      if ($partyId != "") {
        $c->addJoin(ArWebAccountPeer::AR_ASTERISK_ACCOUNT_ID, ArAsteriskAccountPeer::ID);
        $c->add(ArAsteriskAccountPeer::AR_PARTY_ID, $partyId);
        $applied = true;
      }
    }
    if ((!$applied) && isset($this->filters['filter_on_party'])) {
      // Only if there is no a filter on account,
      // select the accounts related directly to the party
      //
      $partyId = $this->filters['filter_on_party'];
      if ($partyId != "") {
        $c->add(ArWebAccountPeer::AR_PARTY_ID, $partyId);
        $applied = true;
      }
    }
    parent::addFiltersCriteria($c);
  }
}
