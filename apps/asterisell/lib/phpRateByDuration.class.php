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
   * The destination telephone prefix where the rate is applicable.
   */
  public $destinationTelephonePrefix = "";
  /**
   * The telephone prefix of the call source where the
   * rate is applicable.
   */
  public $sourceTelephonePrefix = "";
  public function getShortDescription() {
    $r = PhpRateOnlyCalc::calcShortDescription($this->costForMinute, $this->costOnCall, $this->rateByMinute, $this->atLeastXSeconds, $this->whenRound_0_59);
    $r.= ', ' . $this->getDstChannelShortDescription();
    if (strlen(trim($this->sourceTelephonePrefix)) > 0) {
      $r.= ' and only if caller telephone number starts with "' . trim($this->sourceTelephonePrefix) . '"';
    }
    if (strlen(trim($this->destinationTelephonePrefix)) > 0) {
      $r.= ' and only if destination telephone number starts with "' . trim($this->destinationTelephonePrefix) . '"';
    }
    return $r;
  }
  /**
   * Priority of match depends from destinationTelephonePrefix lenght,
   * in this way a rate with a more specific prefix is stronger
   * than a rate with a shorter prefix.
   *
   * @return 0 if it is no applicable,
   *         the lenght of destinationTelephonePrefix + 1 otherwise.
   */
  public function isApplicable(Cdr $cdr) {
    if (parent::isApplicable($cdr) != 0 && $this->isPrefixOf($this->sourceTelephonePrefix, $cdr->getSrc()) != 0) {
      return $this->isPrefixOf($this->destinationTelephonePrefix, $cdr->getActualDestinationNumber());
    } else {
      return 0;
    }
  }
  public function getCallCost(Cdr $cdr) {
    return PhpRateOnlyCalc::calcCostByDuration($cdr, $this->costForMinute, $this->costOnCall, $this->rateByMinute, $this->atLeastXSeconds, $this->whenRound_0_59);
  }
  public function getHTMLForEditForm(ArRate $rate) {
    $r = __('NOTE: use a format like ') . (123.45) . ' ' . __('for monetary values.');
    $r.= "<br/>";
    $r.= __("Destination Channel (case insensitive) starts with: ") . input_tag('dst_channel', $this->dstChannelPattern) . '<br/>' . __("Source telephone number has prefix (empty for no filter): ") . input_tag('source_prefix', $this->sourceTelephonePrefix) . '<br/>' . __("Destination telephone number has prefix (empty for no filter): ") . input_tag('destination_prefix', $this->destinationTelephonePrefix) . __(". In case of rates with shorter or longer prefixes, the rate with the longest matching prefix is selected. Ambigous configurations are signaled in the error report.") . '<br/>' . __("Cost on Call: ") . input_tag('cost_on_call', $this->costOnCall) . '<br/>' . __("Cost for Minute: ") . input_tag('cost_for_minute', $this->costForMinute) . '<br/>' . __("Minimum call duration is ") . " " . input_tag('minimum_call', $this->atLeastXSeconds, array('size' => 2, 'maxlength' => 2)) . " " . __("seconds") . '<br/>' . __("Rate") . " " . select_tag('rate_method', '<option value="s" ' . ($this->rateByMinute ? '' : 'selected="selected"') . '>By Seconds</option> ' . '<option value="m" ' . ($this->rateByMinute ? 'selected="selected"' : '') . '>By Minutes</option>') . ". " . "<br/>" . __("When remaining seconds are equal or greater to (0-60)") . " " . input_tag('when_round', $this->whenRound_0_59, array('size' => 4, 'maxlength' => 4)) . " " . __("seconds then round to the next minute (NOTE: applicable only for rates by minute).") . '<br/>';
    return $r;
  }
  public function initAccordingEditForm(ArRate $arRate) {
    $rateMethod = sfContext::getInstance()->getRequest()->getParameter('rate_method');
    $dstChannel = sfContext::getInstance()->getRequest()->getParameter('dst_channel');
    $sourceTelephonePrefix = sfContext::getInstance()->getRequest()->getParameter('source_prefix');
    $destinationTelephonePrefix = sfContext::getInstance()->getRequest()->getParameter('destination_prefix');
    $costOnCall = sfContext::getInstance()->getRequest()->getParameter('cost_on_call');
    $costForMinute = sfContext::getInstance()->getRequest()->getParameter('cost_for_minute');
    $whenRound = sfContext::getInstance()->getRequest()->getParameter('when_round');
    $atLeastXSeconds = sfContext::getInstance()->getRequest()->getParameter('minimum_call');
    $this->dstChannelPattern = $dstChannel;
    $this->costOnCall = $costOnCall;
    $this->costForMinute = $costForMinute;
    $this->whenRound_0_59 = $whenRound;
    $this->atLeastXSeconds = $atLeastXSeconds;
    $this->sourceTelephonePrefix = $sourceTelephonePrefix;
    $this->destinationTelephonePrefix = $destinationTelephonePrefix;
    if ($rateMethod == "m") {
      $this->rateByMinute = true;
    } else {
      $this->rateByMinute = false;
    }
    return true;
  }
}
?>