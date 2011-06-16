<?php

/* * ************************************************************
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
 * ************************************************************ */

use_helper('Asterisell');

$partyId = VariableFrame::$filterOnPartyId;
$officeId = VariableFrame::$filterOnOfficeId;
$accountId = VariableFrame::$filterOnAccountId;

// The final setting of the filter
//
$options = array();
$defaultChoice = NULL;

if ($sf_user->hasCredential('office')) {
    // A OFFICE user can not select anything else except itself...
    //
    $officeId = $sf_user->getOfficeId();
    $office = ArOfficePeer::retrieveByPK($officeId);
    $options[$officeId] = $office->getName();
    $defaultChoice = $officeId;
} else {
    if (!is_null($partyId)) {
        // If there is a selected Party, then the user can select one of its account
        // 
        $c = new Criteria();
        $c->addAscendingOrderByColumn(ArOfficePeer::NAME);
        $c->add(ArOfficePeer::AR_PARTY_ID, $partyId);
        $offices = ArOfficePeer::doSelect($c);
        $options = array("" => "");
        foreach ($offices as $office) {
            $options[$office->getId()] = $office->getName();
        }
        $defaultChoice = "";
        if (!is_null($officeId)) {
            $defaultChoice = $officeId;
        }
    } else {
        $options[-1] = __('-- first select a Customer --');
        $defaultChoice = -1;
    }
}

echo select_tag('filters[filter_on_office]', options_for_select($options, $defaultChoice));

?>