<?php

/**
 * Subclass for performing query and update operations on the 'cdr' table.
 *
 * @package lib.model
 */ 
class CdrPeer extends BaseCdrPeer
{

  /**
   * Use a "doSelectJoinArAsteriskAccount" forcing a MyProxyConnection
   * in order to use an optimized version of the query.
   */
  public static function forceMyProxyConnection(Criteria $c, $con = null)
  {

    $wrappedCon = CdrPeer::createProxyConnection($c,$con);
    return BaseCdrPeer::doSelectJoinArAsteriskAccount($c, $wrappedCon);
  }

  /**
   * Use a "doSelectJoinArAsteriskAccount" forcing a MyProxyConnection
   * in order to use an optimized version of the query.
   */
  public static function forceMyProxyConnection2(Criteria $c, $con = null)
  {
    $wrappedCon = CdrPeer::createProxyConnection($c, $con);
    return BasePeer::doSelect($c, $wrappedCon);
  }

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
   * Display only a fixed number of results avoiding a separate count 
   * of all available results (slow query).
   */
  public static function doCount(Criteria $criteria, $distinct = false, $con = null)
  {
    return 5000;
  }
}

