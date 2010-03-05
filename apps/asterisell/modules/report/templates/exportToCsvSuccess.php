<?php
use_helper('I18N', 'Debug', 'Date', 'Asterisell');
// Header
//
echo csv_field(__('Customer'), true);
echo csv_field(__('Account'), false);
echo csv_field(__('Receiver'), false);
echo csv_field(__('Receiver connection type'), false);
echo csv_field(__('Receiver location'), false);
echo csv_field(__('Receiver telephone operator name'), false);
echo csv_field(__('Date'), false);
echo csv_field(__('Duration in sec.'), false);
echo csv_field(__('Cost Currency'), false);
echo csv_field(__('Cost'), false);
$isAdmin = $sf_user->hasCredential('admin');
if ($isAdmin) {
  echo csv_field(__('Vendor'), false);
  echo csv_field(__('Vendor Cost Currency'), false);
  echo csv_field(__('Vendor Cost'), false);
  echo csv_field(__('Earn'), false);
}
echo "\n";
// Init record set
//
$time1 = microtime_float();
$nrOfRates = 0;
$cdrCondition = clone VariableFrame::$filterCondition;
$cdrCondition->addAscendingOrderByColumn(CdrPeer::CALLDATE);
CdrPeer::addSelectColumns($cdrCondition);
$startcol2 = (CdrPeer::NUM_COLUMNS - CdrPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
$cdrCondition->addJoin(CdrPeer::ACCOUNTCODE, ArAsteriskAccountPeer::ACCOUNT_CODE);
ArAsteriskAccountPeer::addSelectColumns($cdrCondition);
$startcol3 = $startcol2 + ArAsteriskAccountPeer::NUM_COLUMNS;
$cdrCondition->addJoin(ArAsteriskAccountPeer::AR_PARTY_ID, ArPartyPeer::ID);
ArPartyPeer::addSelectColumns($cdrCondition);
$startcol4 = $startcol3 + ArPartyPeer::NUM_COLUMNS;
// Process every $cdr using doSelectRS that fetch only one object at once from DB
//
$rs = CdrPeer::doSelectRS($cdrCondition);
// Add content
//
while ($rs->next()) {
  $nrOfRates++;
  $cdr = new Cdr();
  $cdr->hydrate($rs);
  $account = new ArAsteriskAccount();
  $account->hydrate($rs, $startcol2);
  $party = new ArParty();
  $party->hydrate($rs, $startcol3);
  $costRate = VariableFrame::$rateCache->getRate($cdr->getCostArRateId());
  $incomeCurrency = sfConfig::get('app_currency');
  $costCurrency = sfConfig::get('app_currency');
  $dstNumber = $cdr->getActualDestinationNumber();
  
  echo csv_field($party->getFullName(), true);
  echo csv_field($account->getName(), false);
  echo csv_field(mask_dst($cdr->getDst()), false);
  
  $telephonePrefix = $cdr->getArTelephonePrefix();
  if (! is_null($telephonePrefix)) {
    echo csv_field($telephonePrefix->getOperatorType(), false);
    echo csv_field($telephonePrefix->getGeographicLocation(), false);
    echo csv_field($telephonePrefix->getName(), false);
  } else {
    echo csv_field("", false);
    echo csv_field("", false);
  }
  
  echo csv_field($cdr->getCalldate(), false);
  echo csv_field($cdr->getBillsec(), false);
  echo csv_field($incomeCurrency, false);
  echo csv_field(format_according_csv_export_currency($cdr->getIncome()), false);
  if ($isAdmin) {
    $vendorName = __('undef');
    if (!is_null($costRate)) {
      $vendorId = $costRate->getArPartyId();
      if (!is_null($vendorId)) {
        $vendor = VariableFrame::$vendorCache->getArParty($vendorId);
        $vendorName = $vendor->getFullName();
      }
    }
    echo csv_field($vendorName, false);
    echo csv_field($costCurrency, false);
    echo csv_field(format_according_csv_export_currency($cdr->getCost()), false);
    if ($incomeCurrency == $costCurrency) {
      echo csv_field(format_according_csv_export_currency(($cdr->getIncome() - $cdr->getCost())), false);
    } else {
      echo csv_field(__('undef'), false);
    }
  }
  echo "\n";
}
?>