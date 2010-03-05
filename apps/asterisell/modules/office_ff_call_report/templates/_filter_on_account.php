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

// The final setting of the filter
//
$options = array();
$defaultChoice = NULL;

// Accounts can be selected only after an officeId and partyId is selected.
//
$officeId = null;

if (isset($filters['filter_on_office']) && (!is_null($filters['filter_on_office'])) && (strlen(trim($filters['filter_on_office'])) != 0) && ($filters['filter_on_office'] != -1)) {

  $partyIsSelected = false;

  if ($sf_user->hasCredential('admin')) {
    $partyIsSelected =  (isset($filters['filter_on_party']) && (!is_null($filters['filter_on_party'])) && (strlen(trim($filters['filter_on_party'])) != 0) && ($filters['filter_on_party'] != -1));
  } else {
    $partyIsSelected = true;
  }
    
  if ($partyIsSelected == true) {
    $officeId = $filters['filter_on_office'];
  }
}

// A Office user can be only of its office.
//
if ($sf_user->hasCredential('office')) {
  $officeId = $sf_user->getOfficeId();
}

if (!is_null($officeId)) {
    $c = new Criteria();
    $c->addAscendingOrderByColumn(ArAsteriskAccountPeer::NAME);
    $c->add(ArAsteriskAccountPeer::AR_OFFICE_ID, $officeId);
    $accounts = ArAsteriskAccountPeer::doSelect($c);

    $options = array("" => "");
    foreach($accounts as $account) {
      $options[$account->getId() ] = $account->getName();
    }

    $defaultChoice = "";
    if (isset($filters['filter_on_account'])) {
      if (array_key_exists($filters['filter_on_account'], $options)) {
        $defaultChoice = $filters['filter_on_account'];
      }
    }
} else {
  $options[-1] = __('-- first select an Office --');
  $defaultChoice = -1;
}

echo select_tag('filters[filter_on_account]', options_for_select($options, $defaultChoice));

?>