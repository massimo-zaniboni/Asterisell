<?php
/*
* Copyright (C) 2007, 2008, 2009
* by Massimo Zaniboni <massimo.zaniboni@profitoss.com>
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
 * Mantain a cache of unserialized PhpRate
 * in order to speedup rating process.
 */
class PhpRateCache {
  /**
   * An array from ArRate.ID to
   * (1 => ArRate,
   *  2 => PhpRate unserialized object,
   * )
   */
  protected $cache = array();
  /**
   * Retrieve or calculate the value corresponding
   * to the $rateId.
   *
   * @param $rateId the ArRate.Id to retrive.
   * @return the corresponding element of the array.
   */
  protected function get($rateId) {
    $value = null;
    if (!array_key_exists($rateId, $this->cache)) {
      $rate = ArRatePeer::retrieveByPK($rateId);
      $value = array(1 => $rate);
      $this->cache[$rateId] = $value;
    } else {
      $value = $this->cache[$rateId];
    }
    return $value;
  }
  /**
   * @param $key the ArRate.id to retrieve
   * @return ArRate with the given $id
   */
  public function getRate($key) {
    $v = $this->get($key);
    return $v[1];
  }
  public function getPhpRate($key) {
    $v = $this->get($key);
    // Mantain a separate cache for unserialized PhpRate classes
    // because they occupy a lot of space and they are not always
    // needed.
    //
    if (!array_key_exists(2, $v)) {
      $phpRate = $rate->unserializePhpRateMethod();
      $this->cache[$key][2] = $phpRate;
      return $phpRate;
    } else {
      return $v[2];
    }
  }
}
?>