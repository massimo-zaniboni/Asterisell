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

use_helper('Asterisell');

$partyId = VariableFrame::$filterOnPartyId;
$officeId = VariableFrame::$filterOnOfficeId;
$accountId = VariableFrame::$filterOnAccountId;

// The final setting of the filter
//
$options = array();
$defaultChoice = NULL;

if (!is_null($officeId)) {
    // a filter on account can be selected only after an office was selected
    
    $c = new Criteria();
    $c->addAscendingOrderByColumn(ArAsteriskAccountPeer::NAME);
    $c->add(ArAsteriskAccountPeer::AR_OFFICE_ID, $officeId);
    $accounts = ArAsteriskAccountPeer::doSelect($c);

    $options = array("" => "");
    foreach($accounts as $account) {
      $options[$account->getId() ] = $account->getName();
    }

    $defaultChoice = "";
    if (!is_null($accountId)) {
        $defaultChoice = $accountId;
    }
    
} else {
  $options[-1] = __('-- first select an Office --');
  $defaultChoice = -1;
}

echo select_tag('filters[filter_on_account]', options_for_select($options, $defaultChoice));

?>