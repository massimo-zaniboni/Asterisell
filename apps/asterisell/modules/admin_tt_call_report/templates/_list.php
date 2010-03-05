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

//////////////////
// Table header //
//////////////////

$moduleName = 'admin_tt_call_report';

echo '<table cellspacing="0" class="sf_admin_list">';
echo '<thead>';
echo '<tr>';

include_partial('list_th_tabular');

echo '</tr>';
echo '</thead>';
echo '<tfoot>';
echo '<tr><th colspan="13" >';
echo '<div class="float-right">';

////////////////
// Pagination //
////////////////

$currPage = $sf_request->getParameter('page', 1);

$nrOfRecords = VariableFrame::$countOfRecords;
$recordsPerPage = sfConfig::get('app_how_many_calls_in_call_report');
$nrOfPages = ceil($nrOfRecords / $recordsPerPage);
$lastPage = $nrOfPages;

$haveToPaginate = ($nrOfPages > 1);

// How many indexed pages in the navigation bar.
//
// <prev - 1 - 2 - 3 - 4 - 5 - next>
//
$pagesInTheBar = 5;

$centerPagesinInTheBar = ceil($pagesInTheBar / 2);
$leftmostPage = $currPage - $centerPagesinInTheBar;
if ($leftmostPage < 1) {
  $leftmostPage = 1;
}

$prevPage = $currPage - 1;
if ($prevPage < 1) {
  $prevPage = 1;
}

$nextPage = $currPage + 1;
if ($nextPage > $nrOfPages) {
  $nextPage = $nrOfPages;
}

if ($haveToPaginate) {

  echo link_to(image_tag(sfConfig::get('sf_admin_web_dir').'/images/first.png', array('align' => 'absmiddle', 'alt' => __('First'), 'title' => __('First'))), $moduleName . '/list?page=1');

  echo link_to(image_tag(sfConfig::get('sf_admin_web_dir').'/images/previous.png', array('align' => 'absmiddle', 'alt' => __('Previous'), 'title' => __('Previous'))), $moduleName . '/list?page='.$prevPage);

  for($i = $leftmostPage, $checkRecords = ($leftmostPage - 1) * $recordsPerPage; $i <= $leftmostPage + $pagesInTheBar; $i++, $checkRecords += $recordsPerPage) {
    if ($checkRecords < $nrOfRecords) {
      echo link_to_unless($i == $currPage, '  ' . $i . '  ', $moduleName . '/list?page='.$i);
    }
  }

  echo link_to(image_tag(sfConfig::get('sf_admin_web_dir').'/images/next.png', array('align' => 'absmiddle', 'alt' => __('Next'), 'title' => __('Next'))), $moduleName . '/list?page='.$nextPage);

  echo link_to(image_tag(sfConfig::get('sf_admin_web_dir').'/images/last.png', array('align' => 'absmiddle', 'alt' => __('Last'), 'title' => __('Last'))), $moduleName . '/list?page='.$lastPage);
}

echo '</div>';

echo format_number_choice('[0] no result|[1] 1 result|(1,+Inf] %1% results', array('%1%' => $nrOfRecords), $nrOfRecords);

echo '</th></tr></tfoot><tbody>';

///////////
// Calls //
///////////

$c = clone VariableFrame::$filterConditionWithOrder;

$c->addJoin(CdrPeer::AR_ASTERISK_ACCOUNT_ID, ArAsteriskAccountPeer::ID);
$c->addJoin(ArAsteriskAccountPeer::AR_OFFICE_ID, ArOfficePeer::ID);
$c->addJoin(ArOfficePeer::AR_PARTY_ID, ArPartyPeer::ID);
$c->addJoin(CdrPeer::AR_TELEPHONE_PREFIX_ID, ArTelephonePrefixPeer::ID);

// Values to retrieve
//
$i = 0;
$c->clearSelectColumns();

$partyNameIndex = $i++;
$c->addSelectColumn(ArPartyPeer::NAME);

$officeNameIndex = $i++;
$c->addSelectColumn(ArOfficePeer::NAME);

$internalNumberIndex = $i++;
$c->addSelectColumn(CdrPeer::CACHED_INTERNAL_TELEPHONE_NUMBER);

$externalNumberIndex = $i++;
$c->addSelectColumn(CdrPeer::CACHED_MASKED_EXTERNAL_TELEPHONE_NUMBER);

$calldateIndex = $i++;
$c->addSelectColumn(CdrPeer::CALLDATE);

$typeIndex = $i++;
$c->addSelectColumn(CdrPeer::DESTINATION_TYPE);

$billsecIndex = $i++;
$c->addSelectColumn(CdrPeer::BILLSEC);

$incomeIndex = $i++;
$c->addSelectColumn(CdrPeer::INCOME);

$costIndex = $i++;
$c->addSelectColumn(CdrPeer::COST);

$vendorIdIndex = $i++;
$c->addSelectColumn(CdrPeer::VENDOR_ID);

$geographicLocationIndex = $i++;
$c->addSelectColumn(ArTelephonePrefixPeer::GEOGRAPHIC_LOCATION);

$operatorTypeIndex = $i++;
$c->addSelectColumn(ArTelephonePrefixPeer::OPERATOR_TYPE);

$c->setOffset(($currPage - 1) * $recordsPerPage);
$c->setLimit($recordsPerPage);

$currency = sfConfig::get('app_currency');

$rs = CdrPeer::useCalldateIndex($c);
//
// NOTE: use a personalized "useCalldateIndex" of "lib/model/CdrPeer.php"
// in order to create an optimized version of MySQL query associated
// to the current filter.
// 
// All the results will be read and put in an array: they are not many values
// due to pagination.

// Process every record
//
$ln = 1;
foreach($rs as $r) {

  // use a different color for odd rows
  $odd = fmod(++$ln, 2);

  echo '<tr class="sf_admin_row_' . $odd . '">';

    echo '<td>' . $r[$partyNameIndex] . '</td>';
  
    echo '<td>' . $r[$officeNameIndex] . '</td>';
  
    echo '<td>' . $r[$internalNumberIndex] . '</td>';
  
    echo '<td>' . DestinationType::getSymbol($r[$typeIndex]) . '</td>';
  
  echo '<td>' . $r[$externalNumberIndex] . '</td>';

  echo '<td>' . $r[$geographicLocationIndex] . '</td>';

  echo '<td>' . $r[$operatorTypeIndex] . '</td>';

  echo '<td>' . format_date_according_config($r[$calldateIndex]) . '</td>';

  echo '<td>' . format_minute($r[$billsecIndex]) . '</td>';

  // is a rated call?
  //
  if (!is_null($r[$incomeIndex] && !is_null($r[$costIndex]))) {
    echo '<td>' . format_from_db_decimal_to_call_report_currency($r[$incomeIndex]) . '</td>';

        echo '<td>' . format_from_db_decimal_to_call_report_currency($r[$costIndex]) . '</td>';
    $earn = $r[$incomeIndex] - $r[$costIndex];
    echo '<td>' . format_from_db_decimal_to_call_report_currency($earn) . '</td>';
    
    $vendor = VariableFrame::getVendorCache()->getArParty($r[$vendorIdIndex]);
    if (!is_null($vendor)) {
      echo '<td>' . $vendor->getFullName() . '</td>';
    } else {
      echo '<td></td>';
    }
    
  } else {
    echo '<td>?</td>';

        echo '<td>?</td>';
    echo '<td>?</td>';
    echo '<td>?</td>';
      }

  echo '</tr>';

}

echo '</tbody>';
echo '</table>';

