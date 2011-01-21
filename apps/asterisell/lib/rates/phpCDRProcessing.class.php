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
 * This rate performs the initial classification of a CDR.
 *
 */
class PhpCDRProcessing extends PhpRate {

  public function isForUnprocessedCDR() {
    return true;
  }

  public $dstChannel = "";
  public $disposition = "ANSWERED";
  public $amaflags = 0;

  /**
   * Wich destination type write if condition are meet.
   */
  public $destinationType = 0;

  public function getShortDescription() {
    $r = 'Set destinationType to "' . DestinationType::getName($this->destinationType) . '" if CDR.destination_channel starts with "' . $this->dstChannel . '" and CDR.disposition is "' . $this->disposition . '" and CDR.amaflags is "' . $this->amaflags .'"';

    return $r;
  }

  public function getPriorityMethod() {
    return "Dst Channel";
  }
  
  public function isApplicable($cdr, $rateInfo = null) {
    if (($this->disposition === $cdr->getDisposition()) &&
        ($this->amaflags === $cdr->getAmaflags())) {
        return PhpRateWithDstChannel::isPrefixOf($this->dstChannel, $cdr->getDstchannel(), true);
    } else {    
      return 0;
    }
  }

  protected function rateCDR($cdr, $rateInfo = null) {
    $cdr->setDestinationType($this->destinationType);
    return null;
  }
  
  public function getModuleName() {
    return "rate_initial_classification";
  }

}
?>
