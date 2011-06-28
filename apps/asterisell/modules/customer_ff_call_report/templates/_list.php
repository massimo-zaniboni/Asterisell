<?php
$generateForAdmin = false;
$generateForCustomer = true;
$generateForOffice = false;
$showOffice = false;
$showAccount = false;
$displayCallDirection = false;

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

use_helper('Markdown');
   
$showType = VariableFrame::$filterOnShow;

// Calculate the number of columns in the table
//
if ($showType === '10-calls') {
  if ($generateForAdmin) {
    $nrOfCols = 13;
  } else {
    $nrOfCols = 6;
    if ($displayCallDirection) {
      $nrOfCols++;
    }
    if ($showOffice) {
      $nrOfCols++;
    }
    if ($showAccount) {
      $nrOfCols++;
    }
  }
} else {

  // Calculate wich fields to display
  //
  $showCustomerField = TRUE;
  $showOfficeField = FALSE;
  $showAccountField = FALSE;
  if ($showType === '30-offices') {
    $showOfficeField = TRUE;
  } else if ($showType === '40-accounts'){
    $showOfficeField = TRUE;
    $showAccountField = TRUE;
  }
  
  if ($generateForCustomer) {
    // when a specific customer is logged, there is no need to display his name
    $showCustomerField = FALSE;
  }
  
  if ($generateForOffice) {
    // when a specific office is logged, there is no need to display his name
    $showCustomerField = FALSE;    
    $showOfficeField = FALSE;
  }

  // Display headers
  //
  $nrOfCols = 0;  
  if ($showCustomerField) {
    $nrOfCols++;
  }
  
  if ($showOfficeField) {
    $nrOfCols++;
  }
  
  if ($showAccountField) {
    $nrOfCols++;
  }  
  
  $nrOfCols += 3;
  
  } 
   
//////////////////
// Table header //
//////////////////

$moduleName = 'customer_ff_call_report';

echo '<table cellspacing="0" class="sf_admin_list">';
echo '<thead>';
echo '<tr>';
    
if ($showType === '10-calls') {    
  include_partial('list_th_tabular');
} else {
  
  if ($showCustomerField) {
    echo '<th>' . __('Customer') . '</th>';
  }
  
  if ($showOfficeField) {
    echo '<th>' . __('Office') . '</th>';
  }
  
  if ($showAccountField) {
    echo '<th>' . __('VoIP Account') . '</th>';
  }  
  
  echo '<th>' . __('Calls') . '</th>';
  echo '<th>' . __('Duration') . '</th>';

  
    echo '<th>' . __('Cost') . '</th>';
  }

echo '</tr>';
echo '</thead>';
echo '<tfoot>';
echo '<tr><th colspan="' . $nrOfCols . '"/>';
echo '<div class="float-right">';

////////////////
// Pagination //
////////////////
    
if ($showType === '10-calls') {
  $currPage = $sf_request->getParameter('page', 1);
  displayCalls($moduleName, $currPage);
  echo '</tbody>';
  echo '</table>';
} else {
  echo '</tbody>';
  echo '</table>';

  $str = <<<VERYLONGSTRING

This feature is part of the Asterisell Commercial Release.

See <http://asterisell.profitoss.com> for more details.

NOTE: this is an informative message, only for Asterisell administrators.
Users without administrator privileges, will not see this message, and the
corresponding filter options.

VERYLONGSTRING;

  echo insertHelp($str);
}  

function displayCalls($moduleName, $currPage) {


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

  
  
  
  
  echo '<td>' . $r[$externalNumberIndex] . '</td>';

  echo '<td>' . $r[$geographicLocationIndex] . '</td>';

  echo '<td>' . $r[$operatorTypeIndex] . '</td>';

  echo '<td>' . format_date_according_config($r[$calldateIndex]) . '</td>';

  echo '<td>' . format_minute($r[$billsecIndex]) . '</td>';

  // is a rated call?
  //
  if (!is_null($r[$incomeIndex] && !is_null($r[$costIndex]))) {
    echo '<td>' . format_from_db_decimal_to_call_report_currency($r[$incomeIndex]) . '</td>';

    
  } else {
    echo '<td>?</td>';

      }

  echo '</tr>';
}
}


