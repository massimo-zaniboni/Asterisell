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
sfLoader::loadHelpers(array('I18N', 'Debug', 'Date', 'Number', 'Debug'));
/**
 * Add a filter on Destination Channel.
 */
abstract class PhpRateWithDstChannel extends PhpRate {
  public $dstChannelPattern;
  public function getDstChannelShortDescription() {
    return PhpRateWithDstChannel::dstChannelShortDescription($this->dstChannelPattern);
  }
  public static function dstChannelShortDescription($chan) {
    if (!is_null($chan) && strlen(trim($chan)) > 0) {
      return __(' only if call channel start with ') . '"' . $chan . '" ';
    } else {
      return ' for all call channels';
    }
  }
  public function isApplicable(Cdr $cdr) {
    return PhpRateWithDstChannel::isPrefixOf($this->dstChannelPattern, $cdr->getDstchannel());
  }
  /**
   * Test if $prefix is prefix of $number
   * in case insensitive mode.
   *
   * @return 0 if $prefix is not a prefix of $number
   *         the lenght of $prefix + 1 in other case
   */
  public static function isPrefixOf($prefix, $number) {
    if (is_null($prefix)) {
      return 1;
      // a NULL channel is a NULL filter wich is applicable to every CDR
      
    }
    $prefix2 = trim($prefix);
    $prefixLen = strlen($prefix2);
    if ($prefixLen == 0) {
      return 1;
      // an empty channel is a filter wich is applicable to every CDR
      
    }
    if (substr_compare($prefix2, $number, 0, $prefixLen, TRUE) == 0) {
      return $prefixLen;
    } else {
      return 0;
    }
  }
}
?>