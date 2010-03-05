<?php
if ($sf_user->hasCredential('admin')) {

  $c = new Criteria();
  $c->addAscendingOrderByColumn(ArPartyPeer::NAME);
  $c->addAscendingOrderByColumn(ArOfficePeer::NAME);
  $offices = ArOfficePeer::doSelectJoinArParty($c);

  // add a blank option
  $options = array("" => "");
  foreach($offices as $office) {
    $party = $office->getArParty();
    $options[$office->getId()] = $party->getName() . ' - ' . $office->getName();
  }

  $defaultChoice = "";
  if (isset($filters['filter_on_party'])) {
    $defaultChoice = $filters['filter_on_party'];
  }
  echo select_tag('filters[filter_on_party]', options_for_select($options, $defaultChoice));
}
?>