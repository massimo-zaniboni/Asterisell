<?php
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
$moduleName = "customer_ft_call_report";

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

$currency = sfConfig::get('app_currency');
// Show Summary Table Header
//
// For admin it has "CALLS, DURATION, INCOME, COST, EARN"
// For party is has "CALLS, DURATION, COST, MAX LIMIT, LAST 30 DAYS COST"
// For VoIP account it has "CALLS, DURATION, COST"
//
echo '<table cellspacing="0" class="sf_admin_list"><thead><tr>' . '<th>' . __('Calls') . '</th>' . '<th>' . __('Duration') . '</th>';


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

echo '</tr></thead>';

// Show totals
//
echo '<tbody><tr class="sf_admin_row_1">' . '<td>' . VariableFrame::$countOfRecords . '</td>' . '<td>' . format_minute(VariableFrame::$totSeconds) . '</td>' . '<td>' . format_from_db_decimal_to_currency_locale(VariableFrame::$totIncomes) . '</td>';

  echo '<td>' . $partyTotLimitStr . '</td>' . '<td>' . $partyTotCostStr . '</td>';

echo '</tr>';

// Add buttons to the table
//
echo '<tr class="sf_admin_row_0">';

  echo '<td></td>';

  echo '<td>' . form_tag("$moduleName/exportToCsv") .  submit_tag(__('Export to CSV')) . '</form>' . '</td>';

  echo '<td>' . form_tag("$moduleName/exportToExcel") .  submit_tag(__('Export to MS Excel')) . '</form>' . '</td>';

  echo '<td></td>';
  echo '<td></td>';

echo '</tr>';

// End of table
//
echo '</tbody></table>';
echo '<br/>';



?>
