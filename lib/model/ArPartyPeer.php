<?php

/**
 * Subclass for performing query and update operations on the 'ar_party' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ArPartyPeer extends BaseArPartyPeer
{
  static public function getOnlyCustomers() {
    return ArPartyPeer::getOnlyCustomersOrVendors("C");
  }

  static public function getOnlyVendors() {
    return ArPartyPeer::getOnlyCustomersOrVendors("V");
  }

  static public function getOnlyCustomersOrVendors($type) {
    $c = new Criteria();
    $c->addAscendingOrderByColumn(ArPartyPeer::NAME);
    $c->add(ArPartyPeer::CUSTOMER_OR_VENDOR, $type, Criteria::EQUAL);
    return ArPartyPeer::doSelect($c);
  }

}
