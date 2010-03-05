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

sfLoader::loadHelpers(array('I18N', 'Debug', 'Date', 'Asterisell'));

/**
 * Check Customers reaching their limits about cost of calls
 * and inform them.
 *
 * The check is performed according 'check_cost_limits_after_minutes' configuration parameter,
 * and emails are sent according 'repeat_advise_of_high_cost_limit_after_days' configuration parameter.
 *
 * Produce a "CustomerHasHighCallCostEvent" event.
 */
class CheckCallCostLimit extends FixedJobProcessor {

  /**
   * This file contains the date of last check of call cost limits.
   */
  const FILE_WITH_LAST_CHECK_DATE = "last_check_call_cost_limit.lock";

  /**
   * Check cost limits only if last check was done before the 
   * "check_cost_limits_after_minutes" time frame.
   *
   * Inform the CUSTOMER via MAIL 
   * if there are customers that are not respecting these limits.
   *
   * Add an ERROR also on the ERROR TABLE in order to inform
   * the administrator of the system.
   *
   * @return always TRUE. Errors are reported on the error table.
   */
  public function process() {
    return "This feature is part of the Asterisell Commercial Release. See http://asterisell.profitoss.com for more details.";
  }

  /**
   * Execute the check of all parties
   */
  public function checkAllLimits() {
    return $this->checkLimits(NULL);
  }

  /**
   * Execute the check of a Party
   * 
   * @param $partyId the party to check
   * @return the sum of cost of the last 300 days
   */
  public function checkPartyLimits($partyId) {
    return $this->checkLimits($partyId);
  }

  /**
   * Execute the check. 
   * 
   * @param $partyId NULL if all parties must be checked,
   * the ar_party.id to check otherwise
   * @return NULL if $partyId == NULL, 
   * the sum of costs associated to the party otherwise.
   */
  private function checkLimits($partyId) {
    $nowDate = date("c");

    $method = trim(sfConfig::get('app_max_cost_limit_timeframe'));

    $timeframeDescription = "";

    if ($method == '30') {
      $timeframe = date("c", strtotime("-30 day"));
      $timeframeDescription = "in the last 30 days";
    } else {
      $timeframe = date('Y') . '-' . date('m') . '-' . '01';
      $timeframeDescription = "on current month";
    }

    $sendEmailAfterDays = sfConfig::get('app_repeat_advise_of_high_cost_limit_after_days');
    $isCustomerAdviseEnabled = TRUE;
    if ($sendEmailAfterDays == 0) {
      $isCustomerAdviseEnabled = FALSE;
    } else {
      $adviseTimeFrame = date("c", strtotime("-$sendEmailAfterDays day"));
    }

    $connection = Propel::getConnection();
    $query = 'SELECT ar_party.id as party_id, ar_party.max_limit_30 as max_limit_30, SUM(cdr.income) as total_cost FROM ar_party, ar_office, ar_asterisk_account, cdr WHERE cdr.accountcode = ar_asterisk_account.account_code AND ar_asterisk_account.ar_office_id = ar_office.id AND ar_office.ar_party_id = ar_party.id AND cdr.calldate >= ? ';

    if (! is_null($partyId)) {
      $query .= ' AND ar_party.id = ' . $partyId;
    }

    $query .= ' GROUP BY ar_party.id;';

    $statement = $connection->prepareStatement($query);
    $statement->setString(1, $timeframe);
    $rs = $statement->executeQuery();

    $lastCost = 0;

    while($rs->next()) {
      $costLimit = $rs->getInt('max_limit_30');
      $effectiveCost = $rs->getInt('total_cost');
      
      $lastCost = $effectiveCost;

      if (!is_null($costLimit)) {
	if ($costLimit > 0 && $effectiveCost > $costLimit) {
	  $id = $rs->getInt('party_id');

	  $party = ArPartyPeer::retrieveByPk($id);

	  $p = new ArProblem();
	  $p->setCreatedAt(date("c"));
	  $p->setDuplicationKey("Cost Limits for party " . $id);
	  $p->setDescription("Party with id \"$id\" and name \"" . $party->getFullName() . "\" has spent " . from_db_decimal_to_monetary_txt_according_locale($effectiveCost) . " instead of allowed " . from_db_decimal_to_monetary_txt_according_locale($costLimit) . ' (according his cost limit) ' . $timeframeDescription . '.');
	  $p->setEffect("An event of type \"CustomerHasHighCallCostEvent\" is generated. If the option \"repeat_advise_of_high_cost_limit_after_days\" in \"apps/asterisell/config/app.yml\" is enabled, then also the customer is warned by email. ");
	  $p->setProposedSolution("Inspect the CDRs in order to see if there is something of anomalous/suspect.");
	  ArProblemException::addProblemIntoDBOnlyIfNew($p);
	  
	  // Advise the customer via mail only at a certain interval.
	  //
	  if ($isCustomerAdviseEnabled == TRUE) {
	    if ($party->getLastEmailAdviseForMaxLimit30() < $adviseTimeFrame) {
	      $d = new CustomerHasHighCallCostEvent();
	      $d->arPartyId = $id;
	      $d->effectiveCost = $effectiveCost;
	      $d->costLimit = $costLimit;
	      $d->fromDate = $timeframe;
	      $d->toDate = $nowDate;
	      
	      ArJobQueue::addNew($d, NULL);
	      
	      // NOTE: $party->getLastEmailAdviseForMaxLimit30 is updated
	      // ad the moment of email sending.
	    }
	  }
	}
      }
    }

    if (is_null($partyId)) {
      return NULL;
    } else {
      return $lastCost;
    }

  }
}
?>