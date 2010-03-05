<?php
use_helper('Asterisell');
if ($ar_web_account->isAdmin()) {
  // Display a select control for changing to another party
  //
  $c = new Criteria();
  $c->addAscendingOrderByColumn(ArPartyPeer::NAME);
  $c->add(ArPartyPeer::CUSTOMER_OR_VENDOR, 'C');
  $parties = ArPartyPeer::doSelect($c);
  $options = array("" => __('Administrator'));
  foreach($parties as $party) {
    $options[$party->getId() ] = $party->getFullName();
  }
  echo select_tag('mycustomer', options_for_select($options, ""));
  echo "       ";
  echo submit_tag(__("Save"), array("name" => "save_selection"));
} else if ($ar_web_account->isParty()) {
  // For a party display its name and a button to change it
  //
  echo $ar_web_account->getArParty()->getFullName();
  echo "       ";
  echo submit_tag(__("Change"), array("name" => "change_customer"));
} else if ($ar_web_account->isOffice()) {
  // For an office show the current party
  //
  echo $ar_web_account->getArOffice()->getArParty()->getFullName();
}
?>