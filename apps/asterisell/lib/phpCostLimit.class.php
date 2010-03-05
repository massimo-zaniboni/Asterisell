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
 * Check if the Customer has reached its max limit.
 */
class PhpCostLimit {
  public function getParty($partyId) {
    return ArPartyPeer::retrieveByPK($partyId);
  }
  /**
   * @param $partyId
   * @return the total cost of the last 30 days
   */
  public function getPartyTotCost($partyId) {
    $party = $this->getParty($partyId);
    // Calc the sum of all customer cost
    //
    $c = new Criteria();
    $c->addSelectColumn('SUM(' . CdrPeer::INCOME . ')');
    $c->addJoin(CdrPeer::ACCOUNTCODE, ArAsteriskAccountPeer::ACCOUNT_CODE);
    $c->add(ArAsteriskAccountPeer::AR_PARTY_ID, $partyId);
    $c->add(CdrPeer::CALLDATE, date("c", strtotime("-30 day")), Criteria::GREATER_THAN);
    $rs = BasePeer::doSelect($c);
    $tot = 0;
    foreach($rs as $r) {
      $tot1 = $r[0];
      $tot = bcadd($tot, $tot1);
    }
    return $tot;
  }
  /**
   * @return true if the party respect the limit
   *
   * NOTE: reexecute all the calc again
   */
  public function doesPartyRespectLimit($partyId) {
    $party = $this->getParty($partyId);
    $limit = $party->getMaxLimit30();
    if ($limit > 0) {
      $tot = $this->getPartyTotCost($partyId);
      return ($tot <= $limit);
    } else {
      return true;
    }
  }
  /**
   * Test if there are customers who has spent more than their limit.
   * Add found customers into the problem table.
   *
   * @return array($nrOfTotalViolations, $nrOfNewViolations)
   */
  public function testCostLimitForAllCustomers() {
    // How many problems there are before the test
    //
    $c = new Criteria();
    $c->addSelectColumn('COUNT(' . ArProblemPeer::ID . ')');
    $rs = BasePeer::doSelect($c);
    $nrOfProblemsAtStart = 0;
    foreach($rs as $r) {
      $nrOfProblemsAtStart = $r[0];
    }
    // The list of customers to test
    //
    $c = new Criteria();
    $c->add(ArPartyPeer::MAX_LIMIT_30, 0, Criteria::GREATER_THAN);
    $c->addSelectColumn(ArPartyPeer::ID);
    $parties = BasePeer::doSelect($c);
    $nrOfTotalViolations = 0;
    foreach($parties as $partyR) {
      $partyId = $partyR[0];
      if (!$this->doesPartyRespectLimit($partyId)) {
        $nrOfTotalViolations++;
        $party = $this->getParty($partyId);
        $costLimit = $party->getMaxLimit30();
        $cost = $this->getPartyTotCost($partyId);
        $p = new ArProblem();
        $p->setDuplicationKey('Cost Limit ' . $partyId);
        $p->setDescription('Customer ' . $party->getFullName() . ' has spent ' . format_for_currency($cost) . ' instead of ' . format_for_currency($costLimit) . ' in the last 30 days');
        $p->setProposedSolution('Increase the limit or block the customer account. Remember to delete this problem when the problems is resolved.');
        ArProblemException::addProblemIntoDBOnlyIfNew($p);
      }
    }
    // How many problems there are after the test
    //
    $c = new Criteria();
    $c->addSelectColumn('COUNT(' . ArProblemPeer::ID . ')');
    $rs = BasePeer::doSelect($c);
    $nrOfProblemsAtEnd = 0;
    foreach($rs as $r) {
      $nrOfProblemsAtEnd = $r[0];
    }
    return array($nrOfTotalViolations, $nrOfProblemsAtEnd - $nrOfProblemsAtStart);
  }
}
?>