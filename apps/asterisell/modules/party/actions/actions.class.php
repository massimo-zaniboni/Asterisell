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
 * party actions.
 *
 * @package    asterisell
 * @subpackage party
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2288 2006-10-02 15:22:13Z fabien $
 */
class partyActions extends autopartyActions {
  protected function updateArPartyFromRequest() {
    $this->ar_party->setCustomerOrVendor($this->getRequestParameter('editcv'));
    $limit30_str = $this->getRequestParameter('insert_money_value');
    $limit30 = PhpRateEngine::convertToDbMoney($limit30_str, sfConfig::get('app_currency'));
    $this->ar_party->setMaxLimit30($limit30);
    parent::updateArPartyFromRequest();
  }
  protected function addFiltersCriteria($c) {
    $applied = false;
    if ((!$applied) && isset($this->filters['filter_on_cv'])) {
      $cv = $this->filters['filter_on_cv'];
      if ($cv != "") {
        $c->add(ArPartyPeer::CUSTOMER_OR_VENDOR, $cv);
        $applied = true;
      }
    }
    parent::addFiltersCriteria($c);
  }
}
