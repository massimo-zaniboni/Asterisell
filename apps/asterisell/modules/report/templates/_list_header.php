<?php
use_helper('I18N', 'Number', 'Asterisell');
// Show if there are the problems to resolve
//
if ($sf_user->hasCredential('admin')) {
  $c = new Criteria();
  $c->addSelectColumn('COUNT(' . ArProblemPeer::ID . ')');
  $rs = BasePeer::doSelect($c);
  $nrOfProblems = 0;
  foreach($rs as $r) {
    $nrOfProblems = $r[0];
  }
  if ($nrOfProblems > 0) {
    echo '<div id="allertMessage">' . __('Problems Table contains ') . $nrOfProblems . __(' problems to resolve.') . '</div>';
  }
}
// Calc the last 30 days limits
//
if ($sf_user->hasCredential('party')) {
  $partyId = $sf_user->getPartyId();
  $party = ArPartyPeer::retrieveByPK($partyId);
  $partyTotLimit = $party->getMaxLimit30();
  if ($partyTotLimit > 0) {
    $partyTotLimitStr = format_for_locale($partyTotLimit);
  } else {
    $partyTotLimitStr = ' -- ';
  }
  $phpCostLimit = new PhpCostLimit();
  $partyTotCost = $phpCostLimit->getPartyTotCost($partyId);
  $partyTotCostStr = format_for_locale($partyTotCost);
}
// Count Calls and billed seconds
//
$c = VariableFrame::$filterCondition;
$c2 = clone ($c);
$c2->clearSelectColumns();
$c2->addSelectColumn('COUNT(' . CdrPeer::ID . ')'); // field 0
$c2->addSelectColumn('SUM(' . CdrPeer::BILLSEC . ')'); // field 1
$c2->addSelectColumn('SUM(' . CdrPeer::INCOME . ')'); // field 2
$c2->addSelectColumn('SUM(' . CdrPeer::COST . ')'); // field 3
$rs = CdrPeer::forceMyProxyConnection2($c2);
//
// NOTE: use a personalized "forceMyProxyConnection2" of "lib/model/CdrPeer.php"
// in order to create an optimized version of MySQL query associated
// to the current filter.
foreach($rs as $rec) {
  $totCalls = $rec[0];
  $totSeconds = $rec[1];
  $totIncomes = $rec[2];
  $totCosts = $rec[3];
  $totEarn = $totIncomes - $totCosts;
}
$currency = sfConfig::get('app_currency');
// Show Summary Table Header
//
// For admin it has "CALLS, DURATION, INCOME, COST, EARN"
// For party is has "CALLS, DURATION, COST, MAX LIMIT, LAST 30 DAYS COST"
// For VoIP account it has "CALLS, DURATION, COST"
//
echo '<table cellspacing="0" class="sf_admin_list"><thead><tr>' . '<th>' . __('Calls') . '</th>' . '<th>' . __('Duration') . '</th>';
if ($sf_user->hasCredential('admin')) {
  echo '<th>' . __('Customer Income') . '</th>' . '<th>' . __('Vendor Cost') . '</th>' . '<th>' . __('Earn') . '</th>';
} else if ($sf_user->hasCredential('party')) {
  echo '<th>' . __('Cost') . '</th>' . '<th>' . __('Last 30 days Limit') . '</th>' . '<th>' . __('Last 30 days Cost') . '</th>';
} else if ($sf_user->hasCredential('account')) {
  echo '<th>' . __('Cost') . '</th>';
}
echo '</tr></thead>';
// Show totals
//
echo '<tbody><tr class="sf_admin_row_1">' . '<td>' . $totCalls . '</td>' . '<td>' . format_minute($totSeconds) . '</td>' . '<td>' . format_for_locale($totIncomes) . '</td>';
if ($sf_user->hasCredential('admin')) {
  echo '<td>' . format_for_locale($totCosts) . '</td>';
  echo '<td>' . format_for_locale($totEarn) . '</td>';
} else if ($sf_user->hasCredential('party')) {
  echo '<td>' . $partyTotLimitStr . '</td>' . '<td>' . $partyTotCostStr . '</td>';
} else if ($sf_user->hasCredential('account')) {
  // Nothing to skip...
  
}
echo '</tr>';
// Add buttons to the table
//
echo '<tr class="sf_admin_row_0">';
if ($sf_user->hasCredential('admin') || ($sf_user->hasCredential('party'))) {
  echo '<td></td><td></td>';
}
echo '<td>' . form_tag('report/exportToCsv') . submit_tag(__('Export to CSV')) . '</form>' . '</td>' . '<td>' . form_tag('report/exportToExcel') . submit_tag(__('Export to MS Excel')) . '</form>' . '</td>';
if ($sf_user->hasCredential('admin')) {
  echo '<td>' . form_tag('report/recalcCallsCost') . submit_tag(__('Recalc Selected Calls')) . '</form>' . '</td>';
  echo '<td></td>';
} else if ($sf_user->hasCredential('party')) {
  echo '<td></td>';
  echo '<td></td>';
} else {
  echo '<td></td>';
}
echo '</tr>';
// End of table
//
echo '</tbody></table>';
echo '<br/>';
?>