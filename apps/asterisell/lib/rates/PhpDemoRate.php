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
 * A minimalistic, demo rate used as a template for other real rates.
 * In particular it is usefult to study "rate_demo" module.
 */
class PhpDemoRate extends PhpRateWithDstChannel {

  /**
   * A fixed cost to assign to each call.
   */
  public $cost = 0;

  /**
   * The destination telephone prefix where the rate is applicable.
   */
  public $calledTelephoneNumber = "";

  public function getModuleName() {
    return "rate_demo";
  }

  public function getShortDescription() {
    $r = formatCostAccordingCurrency($this->cost) . ', ' . $this->getDstChannelShortDescription() . ' and only if called telephone number starts with "' . trim($this->calledTelephoneNumber) . '"';
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
      return $this->isPrefixOf($this->$calledTelephoneNumber, $cdr->getExternalTelephoneNumberWithAppliedPortability());
    } else {
      return 0;
    }
  }

  protected function rateCDR(Cdr $cdr) {
    return PhpRateOnlyCalc::calcCostByDuration($cdr, 0, $this->cost, 0, 0, 0);
  }


}
?>