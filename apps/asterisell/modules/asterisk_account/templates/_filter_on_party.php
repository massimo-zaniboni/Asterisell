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
  if (isset($filters['filter_on_party'])) {
    $defaultChoice = $filters['filter_on_party'];
  }
  echo select_tag('filters[filter_on_party]', options_for_select($options, $defaultChoice));
}
?>