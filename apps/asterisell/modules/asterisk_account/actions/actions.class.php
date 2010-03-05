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


class asterisk_accountActions extends autoasterisk_accountActions {

  /**
   * manage _customeronoffice field
   */
  protected function updateArAsteriskAccountFromRequest() {
    $this->ar_asterisk_account->setArOfficeId($this->getRequestParameter('mycustomeroffice'));
    parent::updateArAsteriskAccountFromRequest();
  }


  /** 
   * Manage _filter_on_party.
   */
  protected function addFiltersCriteria($c) {

    $applied = false;
    if ((!$applied) && isset($this->filters['filter_on_party'])) {
      $officeId = $this->filters['filter_on_party'];
      if ($officeId != "") {
        $c->add(ArAsteriskAccountPeer::AR_OFFICE_ID, $officeId);
        $applied = true;
      }
    }
    parent::addFiltersCriteria($c);
  }
}
