<?php
if ($sf_user->hasCredential('admin')) {
  $c = new Criteria();
  $c->addAscendingOrderByColumn(ArPartyPeer::NAME);
  $parties = ArPartyPeer::doSelect($c);
  // add a blank option
  $options = array("" => "");
  // add other options
  foreach($parties as $party) {
    $options[$party->getId() ] = $party->getFullName();
  }
  $defaultChoice = "";
  if (isset($filters['filter_on_account'])) {
    $defaultChoice = $filters['filter_on_account'];
  }
  echo select_tag('filters[filter_on_account]', options_for_select($options, $defaultChoice));
}
?>