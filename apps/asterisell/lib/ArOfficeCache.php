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
 * Mantain a cache of ArOffice.
 */
class ArOfficeCache {
  /**
   * An array from ArOffice.ID to ArOffice object.
   */
  protected $cache = array();
  /**
   * @param $id the ArOffice.id to retrieve
   * @return ArOffice with the given $id
   */
  public function getArOffice($id) {
    if (!array_key_exists($id, $this->cache)) {
      $office = ArOfficePeer::retrieveByPK($id);
      $this->cache[$id] = $office;
    }
    return $this->cache[$id];
  }
}
?>
