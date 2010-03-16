<?php

/*
* Copyright (C) 2010 Massimo Zaniboni <massimo.zaniboni@profitoss.com>
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
 * Subclass for performing query and update operations on the 'cdr' table.
 *
 * @package lib.model
 */ 
class CdrPeer extends BaseCdrPeer
{

  /**
   * Return a "doSelectJoinAllExceptVendor" forcing a MyProxyConnection
   * in order to use an optimized version of the query, that uses
   * the "Calldate" index. This allows to speedup MySQL queries.
   */
  public static function doSelectJoinAllExceptVendorUsingCalldateIndex(Criteria $c, $con = null)
  {
    $wrappedCon = CdrPeer::createProxyConnection($c,$con);
    return CdrPeer::doSelectJoinAllExceptVendor($c, $wrappedCon);
  }

  /**
   * Return the query result, forcing a MyProxyConnection
   * in order to use an optimized version of the query, that uses
   * the "Calldate" index. This allows to speedup MySQL queries.
   */
 public static function useCalldateIndex(Criteria $c, $con = null)
 {
   $wrappedCon = CdrPeer::createProxyConnection($c, $con);
   return BasePeer::doSelect($c, $wrappedCon);
 }

 /**
  * Use a connection optimizing MySQL queries.
  */
  protected static function createProxyConnection(Criteria $c, $con) 
  {
    if ($con === null) {
      $con = Propel::getConnection(self::DATABASE_NAME);
    }

    $wrappedCon = new MyProxyConnection();
    $wrappedCon->setWrappedConnection($con);

    return $wrappedCon;
  }

  /**
   * Update $c with the Criteria used from self::doSelectJoinAllExceptVendor.
   * It adds only join conditions.
   */
  public static function addAllJoinsExceptVendorCondition(Criteria $c) {

    // Add joins
    //
    // (do not join with VENDOR_ID) but they can be cached efficiently)
    // 
    $c->addJoin(CdrPeer::AR_TELEPHONE_PREFIX_ID, ArTelephonePrefixPeer::ID);
    $c->addJoin(CdrPeer::AR_ASTERISK_ACCOUNT_ID, ArAsteriskAccountPeer::ID);
    $c->addJoin(ArAsteriskAccountPeer::AR_OFFICE_ID, ArOfficePeer::ID);
    $c->addJoin(ArOfficePeer::AR_PARTY_ID, ArPartyPeer::ID);

    return $c;
  }

  /**
   * Create a query retrieving in one SQL call pass all the records
   * to display in call report view.
   *
   * This avoid the usage of caches.
   *
   * Only VENDOR_ID is not joined because this AR_PARTY conflict with
   * the AR_PARTY associated to the ACCOUNT.
   */
  public static function doSelectJoinAllExceptVendor(Criteria $c, $con = null) {

    $c = clone $c;

    if ($c->getDbName() == Propel::getDefaultDB()) {
      $c->setDbName(self::DATABASE_NAME);
    }

    // Add selects
    //
    CdrPeer::addSelectColumns($c);

    ArTelephonePrefixPeer::addSelectColumns($c);
    $startTelephonePrefixCol = (CdrPeer::NUM_COLUMNS - CdrPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
    $newCols = ArTelephonePrefixPeer::NUM_COLUMNS;
    $lastCols = $startTelephonePrefixCol;
    
    ArAsteriskAccountPeer::addSelectColumns($c);
    $startAsteriskAccountCol = $lastCols + $newCols;
    $newCols = ArAsteriskAccountPeer::NUM_COLUMNS;
    $lastCols = $startAsteriskAccountCol;

    ArPartyPeer::addSelectColumns($c);
    $startPartyCol = $lastCols + $newCols;
    $newCols = ArPartyPeer::NUM_COLUMNS;
    $lastCols = $startPartyCol;

    ArOfficePeer::addSelectColumns($c);
    $startOfficeCol = $lastCols + $newCols;
    $newCols = ArOfficePeer::NUM_COLUMNS;
    $lastCols = $startOfficeCol;
    
    // add Joins
    //
    self::addAllJoinsExceptVendorCondition($c);

    // Create objects corresponding to query result.
    // Create ojbects only if not already created in order
    // to reduce heavy operations on objects.
    //
    $rs = BasePeer::doSelect($c, $con);
    $results = array();
    
    while($rs->next()) {

      $omClass = CdrPeer::getOMClass();
      $cls = Propel::import($omClass);
      $objCdr = new $cls();
      $objCdr->hydrate($rs);

      $omClass = ArTelephonePrefixPeer::getOMClass();
      $cls = Propel::import($omClass);
      $objArTelephonePrefix = new $cls();
      $objArTelephonePrefix->hydrate($rs, $startTelephonePrefixCol);
      $objArTelephonePrefix->initCdrs();
      $objArTelephonePrefix->addCdr($objCdr);

      $omClass = ArAsteriskAccountPeer::getOMClass();
      $cls = Propel::import($omClass);
      $objArAsteriskAccount = new $cls();
      $objArAsteriskAccount->hydrate($rs, $startAsteriskAccountCol);
      $objArAsteriskAccount->initCdrs();
      $objArAsteriskAccount->addCdr($objCdr);

      $omClass = ArOfficePeer::getOMClass();
      $cls = Propel::import($omClass);
      $objArOffice = new $cls();
      $objArOffice->hydrate($rs, $startOfficeCol);
      $objArOffice->initArAsteriskAccounts();
      $objArOffice->addArAsteriskAccount($objArAsteriskAccount);

      $omClass = ArPartyPeer::getOMClass();
      $cls = Propel::import($omClass);
      $objArParty = new $cls();
      $objArParty->hydrate($rs, $startPartyCol);
      $objArParty->initArOffices();
      $objArParty->addArOffice($objArOffice);
 
      $results[] = $objCdr;
    }

    return $results;
  }

}