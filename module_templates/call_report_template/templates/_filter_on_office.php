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

if ($sf_user->hasCredential('office')) {
  // A OFFICE user can not select anything else except itself...
  //
  $officeId = $sf_user->getOfficeId();
  $office = ArOfficePeer::retrieveByPK($officeId);
  $options[$officeId] = $office->getName();
  $defaultChoice = $officeId;
} else {

  // a PARTY user can only be "filter" its own party
  //
  $partyId = $sf_user->getPartyId();

  // an ADMIN user can select different parties..
  //
  if ($sf_user->hasCredential('admin') && isset($filters['filter_on_party']) && (!is_null($filters['filter_on_party'])) && (strlen(trim($filters['filter_on_party'])) != 0) && ($filters['filter_on_party'] != -1)) {
    $partyId = $filters['filter_on_party'];
  }

  // If there is a Party selected then the user can select one of its account
  // otherwise it must be first select a party...
  //
  if (!is_null($partyId)) {
    $c = new Criteria();
    $c->addAscendingOrderByColumn(ArOfficePeer::NAME);
    $c->add(ArOfficePeer::AR_PARTY_ID, $partyId);
    $offices = ArOfficePeer::doSelect($c);
    $options = array("" => "");
    foreach($offices as $office) {
      $options[$office->getId()] = $office->getName();
    }
    $defaultChoice = "";
    if (isset($filters['filter_on_office'])) {
      if (array_key_exists($filters['filter_on_office'], $options)) {
        $defaultChoice = $filters['filter_on_office'];
      }
    }
  } else {
    $options[-1] = __('-- first select a Customer --');
    $defaultChoice = -1;
  }
}

echo select_tag('filters[filter_on_office]', options_for_select($options, $defaultChoice));

?>