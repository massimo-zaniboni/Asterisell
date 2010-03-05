<?php
if ($sf_user->hasCredential('admin')) {
  $c = new Criteria();
  $c->add(ArPartyPeer::CUSTOMER_OR_VENDOR, 'V');
  $c->addAscendingOrderByColumn(ArPartyPeer::NAME);
  $parties = ArPartyPeer::doSelect($c);
  // add a blank option
  $options = array("" => "");
  // add other options
  foreach($parties as $party) {
    $options[$party->getId() ] = $party->getFullName();
  }
  $defaultChoice = "";
  if (isset($filters['filter_on_vendor'])) {
    $defaultChoice = $filters['filter_on_vendor'];
  }
  echo select_tag('filters[filter_on_vendor]', options_for_select($options, $defaultChoice));
} else {
  // Show an empty select
  //
  $options = array("" => "");
  echo select_tag('filters[filter_on_vendor]', options_for_select($options, ""));
}
?>