<?php
if ($sf_user->hasCredential('admin')) {
  $c = new Criteria();
  $c->addAscendingOrderByColumn(ArPartyPeer::NAME);
  $c->add(ArPartyPeer::CUSTOMER_OR_VENDOR, 'C');
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
} else {
  // Show a select with only the party
  //
  if ($sf_user->hasCredential('party')) {
    $partyId = $sf_user->getPartyId();
  } else {
    $accountId = $sf_user->getAccountId();
    $account = ArAsteriskAccountPeer::retrieveByPK($accountId);
    $partyId = $account->getArPartyId();
  }
  $party = ArPartyPeer::retrieveByPK($partyId);
  echo select_tag('filters[filter_on_party]', options_for_select(array($partyId => $party->getFullName()), $partyId));
}
?>