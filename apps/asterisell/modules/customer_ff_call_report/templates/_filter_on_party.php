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

if ($sf_user->hasCredential('admin')) {
    
  // an admin can select different parties
    
  $c = new Criteria();
  $c->addAscendingOrderByColumn(ArPartyPeer::NAME);
  $c->add(ArPartyPeer::CUSTOMER_OR_VENDOR, 'C');
  
  $paramsId = filterValue($filters, 'filter_on_params');
  if (!is_null($paramsId)) {
    $c->add(ArPartyPeer::AR_PARAMS_ID, $paramsId);
  }
  
  $parties = ArPartyPeer::doSelect($c);
  
  // add a blank option
  $options = array("" => "");
  
  // add other options
  foreach($parties as $party) {
    $options[$party->getId()] = $party->getFullName();
  }
  $defaultChoice = "";
  if (!is_null($partyId)) {
    $defaultChoice = $partyId;
  }
  
  echo select_tag('filters[filter_on_party]', options_for_select($options, $defaultChoice));
  
} else {
    
  // a logged customer, have only one party to select
  
  $party = ArPartyPeer::retrieveByPK($partyId);
  echo select_tag('filters[filter_on_party]', options_for_select(array($partyId => $party->getFullName()), $partyId));
 }

?>