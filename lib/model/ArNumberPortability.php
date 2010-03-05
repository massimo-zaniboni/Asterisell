<?php

/* $LICENSE 2009, 2010:
 *
 * Copyright (C) 2009, 2010 Massimo Zaniboni <massimo.zaniboni@profitoss.com>
 * All Rights Reserved.
 *
 * Asterisell can be used, modified, distribuited according the terms and conditions of
 * the PROFITOSS-GENERAL-LICENSE - version 1.0, 12 June 2010.
 * You should have received a copy of the license along with Asterisell.
 * If not, see <http://www.profitoss.com/licenses>.
 * $
 */

/**
 * Subclass for representing a row from the 'ar_number_portability' table.
 */ 
class ArNumberPortability extends BaseArNumberPortability
{

  /**
   * @return the destination number, corrected
   * in case of number portability.
   */ 
  static public function checkPortability($sourceNumber, $date) {

    $c = new Criteria();
    $c->add(ArNumberPortabilityPeer::TELEPHONE_NUMBER, $sourceNumber);
    $c->add(ArNumberPortabilityPeer::FROM_DATE, $date, Criteria::LESS_EQUAL);
    $c->addAscendingOrderByColumn(ArNumberPortabilityPeer::FROM_DATE);

    $destinationNumber = $sourceNumber;

    $rs = ArNumberPortabilityPeer::doSelect($c);
    foreach($rs as $r) {
      $destinationNumber = $r->getPortedTelephoneNumber();
    }

    return $destinationNumber;
  }
}
