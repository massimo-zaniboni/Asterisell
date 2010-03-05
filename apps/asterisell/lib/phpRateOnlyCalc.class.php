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
 * A Rate used internally only to calculate the cost.
 *
 * It stores prices using PHP float values
 * represented as Strings (arbitrary precision math).
 */
class PhpRateOnlyCalc extends PhpRate {
  /**
   * False if the calls are rated by seconds,
   * True if the calls are rated by minutes.
   *
   * NOTE: costs are showed always by minute
   * because costs for seconds are too much
   * little numbers.
   */
  public $rateByMinute = false;
  /**
   * The cost for minute.
   */
  public $costForMinute = 0;
  /**
   * The initial cost of the call.
   */
  public $costOnCall = 0;
  /**
   * The minimum billable duration (in seconds)
   * of a call. Call shorter than this duration will
   * be billed at least for this minimum duration.
   */
  public $atLeastXSeconds = 0;
  /**
   * How round to the next minute.
   * Applicable only if the call is billable by minute.
   */
  public $whenRound_0_59 = 0;
  public function getShortDescription() {
    return calcShortDescription_static($this->costForMinute, $this->costOnCall, $this->rateByMinute, $this->atLeastXSeconds, $this->whenRound_0_59);
  }
  static public function calcShortDescription($costForMinute, $costOnCall, $rateByMinute, $atLeastXSeconds, $whenRound_0_59) {
    $r = "";
    if ($costOnCall > 0) {
      $r = $r . PhpRate::formatCostAccordingCurrency($costOnCall) . ' + ';
    }
    $r.= PhpRate::formatCostAccordingCurrency($costForMinute) . " * " . __("minute");
    if ($rateByMinute) {
      $r = $r . ", " . __("rated by minute");
      $r = $r . "<br/>";
      $r = $r . $whenRound_0_59 . " " . __("remaining seconds ") . " " . ("rounded to next minute");
    } else {
      $r = $r . ", " . __("rated by seconds");
    }
    if ($atLeastXSeconds > 0) {
      $r = $r . "<br/>";
      $r = $r . __("minimum call is") . " " . $atLeastXSeconds . " " . __("seconds");
    }
    $r = $r . "<br/>";
    return $r;
  }
  public function isApplicable(Cdr $cdr) {
    return true;
  }
  public function getCallCost(Cdr $cdr) {
    return calcCostByDuration($this->costForMinute, $this->costOnCall, $this->rateByMinute, $this->atLeastXSeconds, $this->whenRound_0_59);
  }
  /**
   * The method used to calculate a telephone call
   * according its duration.
   *
   * This method is used from other classes and not only
   * from this class. This allows code reuse (Dont Repeat Yourself).
   */
  static public function calcCostByDuration($cdr, $costForMinute, $costOnCall, $isRateByMinute, $atLeastXSeconds, $whenRound_0_59) {
    $totSec = $cdr->getBillsec();
    if ($totSec < $atLeastXSeconds) {
      $totSec = $atLeastXSeconds;
    }
    $cost = 0;
    if ($isRateByMinute) {
      $min = floor($totSec / 60);
      $modSec = $totSec % 60;
      if ($modSec >= $whenRound_0_59) {
        $min = $min + 1;
      }
      $cost = bcmul($costForMinute, $min, PhpRate::calcPrecision());
    } else {
      $cost = bcmul($costForMinute, $totSec, PhpRate::calcPrecision());
      $cost = bcdiv($cost, "60", PhpRate::calcPrecision());
    }
    $cost = bcadd($costOnCall, $cost, PhpRate::calcPrecision());
    return $cost;
  }
  public function getHTMLForEditForm(ArRate $rate) {
    return "";
  }
  public function initAccordingEditForm(ArRate $arRate) {
    return true;
  }
}
?>