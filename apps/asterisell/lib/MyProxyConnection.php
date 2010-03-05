<?php
/*
* Copyright (C) 2007, 2008, 2009
* Massimo Zaniboni <massimo.zaniboni@profitoss.com>
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
sfLoader::loadHelpers(array('I18N', 'Debug', 'Date', 'Asterisell'));
/**
 * Apply a MySQL specific optimization.
 *
 * Add "FROM cdr FORCE INDEX ( cdr_calldate_index )" to MySQL queries
 * then performs like a proxy for all other requests.
 */
class MyProxyConnection implements Connection {
  protected $wrappedConn = null;
  public function setWrappedConnection(Connection $c) {
    $this->wrappedConn = $c;
  }
  // Wrap Method
  protected function wrapSql($sql) {
    // Source query is something like:
    //
    // > SELECT cdr.CALLDATE, cdr.CLID, cdr.SRC, ...
    // > FROM cdr, ar_asterisk_account, ...
    // > WHERE cdr.INCOME IS NULL AND cdr.CALLDATE>='2009-01-20' ...
    //
    $wrappedSql = str_ireplace(" cdr,", " cdr FORCE INDEX (cdr_calldate_index),", $sql);
    return $wrappedSql;
  }
  // Overwritten methods
  
  /**
   * If $sql is a query containing a condition on cdr.calldate
   * then force the usage of the the cdr_calldate_index.
   */
  function executeQuery($sql, $fetchmode = null) {
    $wrappedSql = $this->wrapSql($sql);
    return $this->wrappedConn->executeQuery($wrappedSql, $fetchmode);
  }
  function applyLimit(&$sql, $offset, $limit) {
    return $this->wrappedConn->applyLimit($sql, $offset, $limit);
  }
  function close() {
    return $this->wrappedConn->close();
  }
  function commit() {
    return $this->wrappedConn->commit();
  }
  function connect($dsn, $flags = 0) {
    return $this->wrappedConn->connect($dsn, $flags);
  }
  public function isConnected() {
    return $this->wrappedConn->isConnected();
  }
  public function createStatement() {
    return $this->wrappedConn->createStatement();
  }
  public function executeUpdate($sql) {
    return $this->wrappedConn->executeUpdate($sql);
  }
  public function getAutoCommit() {
    return $this->wrappedConn->getAutoCommit();
  }
  public function begin() {
    return $this->wrappedConn->begin();
  }
  public function getDatabaseInfo() {
    return $this->wrappedConn->getDatabaseInfo();
  }
  public function getDSN() {
    return $this->wrappedConn->getDSN();
  }
  public function getFlags() {
    return $this->wrappedConn->getFlags();
  }
  public function getIdGenerator() {
    return $this->wrappedConn->getIdGenerator();
  }
  public function getResource() {
    return $this->wrappedConn->getResource();
  }
  public function getUpdateCount() {
    return $this->wrappedConn->getUpdateCount();
  }
  public function prepareCall($sql) {
    $wrappedSql = $this->wrapSql($sql);
    return $this->wrappedConn->prepareCall($wrappedSql);
  }
  public function prepareStatement($sql) {
    $wrappedSql = $this->wrapSql($sql);
    return $this->wrappedConn->prepareStatement($wrappedSql);
  }
  public function rollback() {
    return $this->wrappedConn->rollback();
  }
  public function setAutoCommit($bit) {
    return $this->wrappedConn->setAutoCommit($bit);
  }
}
?>