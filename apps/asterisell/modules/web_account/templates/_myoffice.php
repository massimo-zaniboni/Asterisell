<?php
use_helper('Asterisell');
if ($ar_web_account->isAdmin()) {
  echo "Admin can view calls of all VoIP accounts";
 } else if ($ar_web_account->isParty()) {
  // For a party permit to restrict web account to a specific Office account
  //
  $partyId = $ar_web_account->getArPartyId();
  $c = new Criteria();
  $c->addAscendingOrderByColumn(ArOfficePeer::NAME);
  $c->add(ArOfficePeer::AR_PARTY_ID, $partyId);
  $accounts = ArOfficePeer::doSelect($c);
  $options = array("" => __('View all calls of its VoIP accounts'));
  foreach($accounts as $account) {
    $options[$account->getId() ] = $account->getName();
  }
  echo select_tag('myoffice', options_for_select($options, ""));
  echo "       ";
  echo submit_tag(__("Save"), array("name" => "save_selection"));
} else if ($ar_web_account->isOffice()) {
  // For an office show data with a button to change party/account
  //
  // NOTE: in this way it is not possible to change both party and account
  // selecting an account not related to the given party.
  //
  $account = $ar_web_account->getArOffice();
  echo $account->getName();
  echo "       ";
  echo submit_tag(__("Change"), array("name" => "change_customer_or_office"));
}
?>