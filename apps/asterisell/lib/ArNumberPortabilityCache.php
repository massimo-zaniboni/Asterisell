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
 * A cache containing all numbers under number portability.
 */
class ArNumberPortabilityCache {

  /**
   * An array of telephone numbers.
   */
  protected $cache = array();

  /**
   * Read all data from the table
   */
  function __construct() {
    $this->cache = array();

    $conn = Propel::getConnection();
    $query = "SELECT telephone_number as t FROM ar_number_portability;";
    $statement = $conn->prepareStatement($query);
    $rs = $statement->executeQuery();
    
    while ($rs->next()) {
      $this->cache[$rs->getString('t')] = TRUE;
    }
  }

  public function isUnderNumberPortability($number) {
    return isset($this->cache[$number]);
  }

}
?>
