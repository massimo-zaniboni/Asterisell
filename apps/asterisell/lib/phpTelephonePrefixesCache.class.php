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
 * Speed up retrieving of telephone prefix membership for telephone numbers
 * storing all prefixes in a cache in RAM
 * instead of quering the database each time.
 * Prefixes are read during initialization of the cache using a query
 * on all elements of ar_telephone_prefix table.
 */
class PhpTelephonePrefixesCache {
  /**
   * Associate a Prefix to the telephone_operator.id
   */
  protected $prefixes;
  /**
   * Read all prefixes from the table
   */
  function __construct() {
    $c = new Criteria();
    $rs = ArTelephonePrefixPeer::doSelect($c);
    $this->prefixes = array();
    foreach($rs as $r) {
      $key = $r->getPrefix();
      if (is_null($key)) {
        $key = '';
      }
      // add the prefix to the table.
      //
      $this->prefixes[$key] = $r->getId();
    }
  }
  public function existsPrefix($number) {
    return array_key_exists($number, $this->prefixes);
  }
  /**
   * @param $arr an array of prefixes
   * @param $number the complete number
   * @return the best matching prefix/index inside the $arr,
   *         or NULL if it does not exists
   */
  static public function getPrefixMatch($arr, $number) {
    $c = strlen($number);
    $r = null;
    $again = true;
    while ($again) {
      if ($c <= 0) {
        $again = false;
      } else {
        $i = substr($number, 0, $c);
        $c--;
        if (array_key_exists($i, $arr)) {
          $r = $i;
          $again = false;
        }
      }
    }
    return $r;
  }
  /**
   * @param $number a telephone number
   * @return the value associated to the best prefix match
   * or NULL if it does not exists
   */
  public function getTelephonePrefixId($number) {
    $i = PhpTelephonePrefixesCache::getPrefixMatch($this->prefixes, $number);
    if (is_null($i)) {
      return null;
    } else {
      return $this->prefixes[$i];
    }
  }
}
?>