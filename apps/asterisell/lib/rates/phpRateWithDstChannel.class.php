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

sfLoader::loadHelpers(array('I18N', 'Debug', 'Date', 'Number', 'Debug'));
/**
 * Add a filter on Destination Channel.
 */
abstract class PhpRateWithDstChannel extends PhpRate {

  public function isForUnprocessedCDR() {
    return false;
  }

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

  ////////////////////////////////
  // PHP RATE INTERFACE SUPPORT //
  ////////////////////////////////

  public function getProcessingStateType() {
    return TypeTable::$processingStateType_toRate;
  }

  public function getPriorityMethod() {
    return "Dst Channel";
  }

  public function isApplicable($cdr, $rateInfo = null) {
    return PhpRateWithDstChannel::isPrefixOf($this->dstChannelPattern, $cdr->getDstchannel(), true);
  }

  /**
   * Test if $prefix is prefix of $number
   * in case insensitive mode.
   *
   * @return 0 if $prefix is not a prefix of $number
   *         the lenght of $prefix + 1 in other case
   */
  public static function isPrefixOf($prefix, $number, $useRegex = false) {

    if (is_null($prefix)) {
      return 1;
      // a NULL channel is a NULL filter wich is applicable to every CDR
    }

    $prefix = trim($prefix);

    $isRegex = false;
    if ($useRegex && (strlen($prefix) > 2) && ($prefix[0] == '%' && $prefix[1] == '%')) {
        $isRegex = true;
        $prefix = substr($prefix, 2, strlen($prefix) - 2);
    } 

    $prefixLen = strlen($prefix);

    if ($prefixLen == 0) {
      return 1;
      // an empty channel is a filter wich is applicable to every CDR
    }

    if ($isRegex) {
        $matches = false;
        if (preg_match($prefix, $number, $matches) > 0) {
	    return strlen($matches[0]) + 1;
        } else {
            return 0;
	}
    } else {
      if (substr_compare($prefix, $number, 0, $prefixLen, TRUE) == 0) {
        return $prefixLen + 1;
      } else {
        return 0;
      }
    }
  }
}
?>
