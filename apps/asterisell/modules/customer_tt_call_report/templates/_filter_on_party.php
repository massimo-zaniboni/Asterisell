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
if ($sf_user->hasCredential('admin')) {
  $c = new Criteria();
  $c->addAscendingOrderByColumn(ArPartyPeer::NAME);
  $c->add(ArPartyPeer::CUSTOMER_OR_VENDOR, 'C');
  $parties = ArPartyPeer::doSelect($c);
  // add a blank option
  $options = array("" => "");
  // add other options
  foreach($parties as $party) {
    $options[$party->getId()] = $party->getFullName();
  }
  $defaultChoice = "";
  if (isset($filters['filter_on_party'])) {
    $defaultChoice = $filters['filter_on_party'];
  }
  echo select_tag('filters[filter_on_party]', options_for_select($options, $defaultChoice));
} else {
  // Show a select with only the party
  // associated to the user because
  // only admin can choose a different party.
  //
  $partyId = null;
  if ($sf_user->hasCredential('party')) {
    $partyId = $sf_user->getPartyId();
  } else if ($sf_user->hasCredential('office')) {
    $officeId = $sf_user->getOfficeId();
    $office = ArOfficePeer::retrieveByPK($officeId);
    $partyId = $office->getArPartyId();
  }
  $party = ArPartyPeer::retrieveByPK($partyId);
  echo select_tag('filters[filter_on_party]', options_for_select(array($partyId => $party->getFullName()), $partyId));
 }

?>