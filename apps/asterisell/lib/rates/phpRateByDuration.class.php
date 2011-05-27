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
 * Rate calls by duration plus additional parameters.
 */
class PhpRateByDuration extends PhpRateWithDstChannel {

  /**
   * False if the calls are rated by seconds,
   * True if the calls are rated by minutes.
   *
   * NOTE: costs are showed always by minute
   * because costs for seconds are too much little.
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
  /**
   * The external telephone prefix where the rate is applicable.
   */
  public $externalTelephonePrefix = "";

  /**
   * Discrete seconds increments to apply to the duration of the call.
   * For example, if the number is 10 seconds,
   * then it considers initially 10 seconds also for a call of 1 second,
   * after 10 seconds it considers 20 seconds and so on.
   * Then the resulting call duration is processed according other parameters of the rate method.
   * 0 for disabling this behaviour, and considering exactly the duration of the call.
   */
  public $discreteIncrements = 0;

  /**
   * The internal telephone number prefix of the call. 
   */
  public $internalTelephonePrefix = "";
  public function getShortDescription() {
    $r = PhpRateOnlyCalc::calcShortDescription($this->costForMinute, $this->costOnCall, $this->rateByMinute, $this->atLeastXSeconds, $this->whenRound_0_59, $this->discreteIncrements);
    $r.= ', ' . $this->getDstChannelShortDescription();
    if (strlen(trim($this->internalTelephonePrefix)) > 0) {
      $r.= ' and only if caller telephone number starts with "' . trim($this->internalTelephonePrefix) . '"';
    }
    if (strlen(trim($this->externalTelephonePrefix)) > 0) {
      $r.= ' and only if external telephone number starts with "' . trim($this->externalTelephonePrefix) . '"';
    }
    return $r;
  }

  public function getPriorityMethod() {
    return "Telephone Number";
  }

  /**
   * Priority of match depends from externalTelephonePrefix lenght,
   * in this way a rate with a more specific prefix is stronger
   * than a rate with a shorter prefix.
   *
   * @return 0 if it is no applicable,
   *         the lenght of externalTelephonePrefix + 1 otherwise.
   */
  public function isApplicable($cdr, $rateInfo = null) {
    if (parent::isApplicable($cdr) > 0) {
      // in this case the cdr respects the destination channel conditions
        
      if ($this->isPrefixOf($this->internalTelephonePrefix, $cdr->getCachedInternalTelephoneNumber()) >  0) {
        // in this case the cdr respects the internal telephone conditions

        // now calculate the fitness according external telephone number
        return $this->isPrefixOf($this->externalTelephonePrefix, $cdr->getCachedExternalTelephoneNumberWithAppliedPortability());
      }
    }

    // in this case the rate is not applicable
    return 0;
  }

  protected function rateCDR($cdr, $rateInfo = null) {
    return PhpRateOnlyCalc::calcCostByDuration($cdr, $this->costForMinute, $this->costOnCall, $this->rateByMinute, $this->atLeastXSeconds, $this->whenRound_0_59, $this->discreteIncrements);
  }

  public function getModuleName() {
    return "rate_by_duration";
  }

}
?>