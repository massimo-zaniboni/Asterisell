<?php

require 'generator_header.php';

echo '<?php';

?>

  /**************************************************************
   !!!                                                        !!!
   !!! WARNING: This file is automatic generated.             !!!
   !!!                                                        !!!
   !!! In order to modify this file change the content of     !!!
   !!!                                                        !!!
   !!!    /module_template/call_report_template               !!!
   !!!                                                        !!!
   !!! and execute                                            !!!
   !!!                                                        !!!
   !!!    sh generate_modules.sh                              !!!     
   !!!                                                        !!!
   **************************************************************/
use_helper('I18N', 'Number', 'Asterisell');

// Variable defined from the template generator.
//
$moduleName = <?php echo "\"$moduleName\""; ?>;

<?php if ($generateForAdmin) { ?>

// Show if there are the problems to resolve
//
$c = new Criteria();
$c->addSelectColumn('COUNT(' . ArProblemPeer::ID . ')');
$rs = BasePeer::doSelect($c);
$nrOfProblems = 0;
foreach($rs as $r) {
  $nrOfProblems = $r[0];
}
if ($nrOfProblems > 0) {
  echo '<div id="allertMessage">' . __('Problems Table contains ') . $nrOfProblems . ' ' . __('problems to solve.') . '</div>';
}

<?php } else if ($generateForCustomer) { ?>
  // Calc the last 30 days limits for customer
  //
  $partyId = $sf_user->getPartyId();
  $party = ArPartyPeer::retrieveByPK($partyId);
  $partyTotLimit = $party->getMaxLimit30();
  if ($partyTotLimit > 0) {
    $partyTotLimitStr = format_from_db_decimal_to_currency_locale($partyTotLimit);
  } else {
    $partyTotLimitStr = ' -- ';
  }
  $checker = new CheckCallCostLimit();
  $partyTotCost = $checker->checkPartyLimits($partyId);
  $partyTotCostStr = format_from_db_decimal_to_currency_locale($partyTotCost);
<?php } ?>

$currency = sfConfig::get('app_currency');
// Show Summary Table Header
//
// For admin it has "CALLS, DURATION, INCOME, COST, EARN"
// For party is has "CALLS, DURATION, COST, MAX LIMIT, LAST 30 DAYS COST"
// For VoIP account it has "CALLS, DURATION, COST"
//
echo '<table cellspacing="0" class="sf_admin_list"><thead><tr>' . '<th>' . __('Calls') . '</th>' . '<th>' . __('Duration') . '</th>';

<?php if ($generateForAdmin) { ?>
  // Admin specific header
  //
  echo '<th>' . __('Customer Income') . '</th>' . '<th>' . __('Vendor Cost') . '</th>' . '<th>' . __('Earn') . '</th>';
  <?php } else if ($generateForCustomer) { ?>

  // Customer specific header
  //
  $last30LimitsStr = "";
  if (isCostLimitTimeFrame30Days()) {
    $last30LimitsStr = __('Last 30 days Limit');
  } else {
    $last30LimitsStr = __('Month Limit');
  }

  $lastCostLimitsStr = "";
  if (isCostLimitTimeFrame30Days()) {
    $lastCostLimitsStr = __('Last 30 days Cost'); 
  } else {
    $lastCostLimitsStr = __('Current Month Cost');
  }

  echo '<th>' . __('Cost') . '</th>' . '<th>' . $last30LimitsStr . '</th>' . '<th>' . $lastCostLimitsStr . '</th>';
<?php } else if ($generateForOffice) { ?>

  // Office specific header
  //
  echo '<th>' . __('Cost') . '</th>';
<?php } ?>

echo '</tr></thead>';

// Show totals
//
echo '<tbody><tr class="sf_admin_row_1">' . '<td>' . VariableFrame::$countOfRecords . '</td>' . '<td>' . format_minute(VariableFrame::$totSeconds) . '</td>' . '<td>' . format_from_db_decimal_to_currency_locale(VariableFrame::$totIncomes) . '</td>';

<?php if ($generateForAdmin) { ?>
  echo '<td>' . format_from_db_decimal_to_currency_locale(VariableFrame::$totCosts) . '</td>';
  echo '<td>' . format_from_db_decimal_to_currency_locale(VariableFrame::$totEarn) . '</td>';
<?php } else if ($generateForCustomer) { ?>
  echo '<td>' . $partyTotLimitStr . '</td>' . '<td>' . $partyTotCostStr . '</td>';
<?php } else if ($generateForOffice) { ?>
  // Nothing to skip...
<?php } ?>

echo '</tr>';

// Add buttons to the table
//
echo '<tr class="sf_admin_row_0">';
<?php if ($generateForAdmin) { ?>

  if (VariableFrame::$showChannelUsage) {
    $l = __('Hide Stats');
    $act = "hideChannelUsage";
  } else {
    $l = __('Show Stats');
    $act = "showChannelUsage";
  }

  echo '<td>' . form_tag("$moduleName/$act") .  submit_tag($l) . '</form>' . '</td>';

  echo '<td>' . form_tag("$moduleName/exportToCsv") . submit_tag(__('Export to CSV')) . '</form>' . '</td>';

  echo '<td>' . form_tag("$moduleName/exportToExcel") . submit_tag(__('Export to MS Excel')) . '</form>' . '</td>';

  echo '<td>' . form_tag("$moduleName/resetCallsCost") .submit_tag(__('Re-rate Calls in Timeframe (see Help)')) . '</form>' . '</td>';

  echo '<td></td>';

<?php } else { ?>

  echo '<td></td>';

  echo '<td>' . form_tag("$moduleName/exportToCsv") .  submit_tag(__('Export to CSV')) . '</form>' . '</td>';

  echo '<td>' . form_tag("$moduleName/exportToExcel") .  submit_tag(__('Export to MS Excel')) . '</form>' . '</td>';

  echo '<td></td>';
  echo '<td></td>';

<?php
}
?>
echo '</tr>';

// End of table
//
echo '</tbody></table>';
echo '<br/>';


<?php if ($generateForAdmin) { ?>

  if (VariableFrame::$showChannelUsage) {
    // load this heavy helper only when needed
    //
    use_helper('Number', 'ChannelUsage');

    $stats = new StatsOnCalls(VariableFrame::$filterCondition, VariableFrame::$startFilterDate, VariableFrame::$endFilterDate);

    if (!$stats->isEmpty()) {
      echo '<h2>Total calls, respecting the filter/condition: ' . $stats->totCalls .' (' . $stats->getMeanCalls() . ' calls per ' . $stats->numDays . ' days)</h2>';

      echo '<h2>Max number of concurrent calls: ' . $stats->maxNrOfConcurrentCalls . ' (safe limit is ' . $stats->concurrentCallsSafeLimit .')</h2>';

      echo '<h2>Number of Calls above the safe limit: ' . $stats->dangerousCalls . ' (' . $stats->getDangerousCallsPerc() . '% of ' . $stats->totCalls . ' total calls)</h2>';

      $graph1 = new CalculatedDistributionGraph(__('Concurrent Calls Grouped by Occurrence'), __('Show the number of calls, performed when there were already a certain number of active calls. This graph shows the typical bandwidth usage/requirements.'), $stats->concurrentCallsDistribution, $stats->concurrentCallsSafeLimit);
      echo $graph1->getGraphInsert();
  
      $graph2 = new CalculatedGraph(__('Concurrent Calls'), __('Show for each day, the max number of active concurrent calls. This allows to inspect the maximum bandwidth usage over time.'),  $stats->nrOfConcurrentCalls, $stats->concurrentCallsSafeLimit);
      echo $graph2->getGraphInsert();

      $graph3 = new CalculatedGraph(__('Total Calls'), __('Show for each day, the total number of processed calls.'), $stats->nrOfTotCalls);
      echo $graph3->getGraphInsert();
    }
  }
<?php } ?>

<?php 
echo '?>' . "\n";
?>
