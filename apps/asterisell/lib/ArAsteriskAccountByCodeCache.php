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

class ArAsteriskAccountByCodeCache {

  protected $cache = array();

  public function getArAsteriskAccountByCode($code) {
    if (!array_key_exists($code, $this->cache)) {
      $criteria = new Criteria(ArAsteriskAccountPeer::DATABASE_NAME);
      $criteria->add(ArAsteriskAccountPeer::ACCOUNT_CODE, $code);
      $account = ArAsteriskAccountPeer::doSelectOne($criteria);
      $this->cache[$code] = $account;
    }
    return $this->cache[$code];
  }
}
?>
