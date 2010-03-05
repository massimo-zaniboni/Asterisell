<?php
/*
* Copyright (C) 2007, 2008, 2009
* Massimo Zaniboni <massimo.zaniboni@profitoss.com>
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
 * Mantain a cache of ArParty.
 */
class ArPartyCache {
  /**
   * An array from ArParty.ID to Rate
   */
  protected $cache = array();
  /**
   * @param $id the ArParty.id to retrieve
   * @return ArParty with the given $id
   */
  public function getArParty($id) {
    if (!array_key_exists($id, $this->cache)) {
      $party = ArPartyPeer::retrieveByPK($id);
      $this->cache[$id] = $party;
    }
    return $this->cache[$id];
  }
}
?>
