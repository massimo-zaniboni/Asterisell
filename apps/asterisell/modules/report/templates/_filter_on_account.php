<?php
if ($sf_user->hasCredential('account')) {
  // An account can not select anything else except itself...
  //
  $accountId = $sf_user->getAccountId();
  $account = ArAsteriskAccountPeer::retrieveByPK($accountId);
  echo select_tag('filters[filter_on_account]', options_for_select(array($accountId => $account->getName()), $accountId));
} else {
  $partyId = $sf_user->getPartyId();
  if ($sf_user->hasCredential('admin') && isset($filters['filter_on_party']) && (!is_null($filters['filter_on_party'])) && (strlen(trim($filters['filter_on_party'])) != 0)) {
    $partyId = $filters['filter_on_party'];
  }
  // If there is a Party selected then the user can select one of its account
  //
  if (!is_null($partyId)) {
    $c = new Criteria();
    $c->addAscendingOrderByColumn(ArAsteriskAccountPeer::NAME);
    $c->add(ArAsteriskAccountPeer::AR_PARTY_ID, $partyId);
    $accounts = ArAsteriskAccountPeer::doSelect($c);
    $options = array("" => "");
    foreach($accounts as $account) {
      $options[$account->getId() ] = $account->getName();
    }
    $defaultChoice = "";
    if (isset($filters['filter_on_account'])) {
      if (array_key_exists($filters['filter_on_account'], $options)) {
        $defaultChoice = $filters['filter_on_account'];
      }
    }
    echo select_tag('filters[filter_on_account]', options_for_select($options, $defaultChoice));
  } else {
    // Before to select an account you must select a partyId
    //
    echo select_tag('filters[filter_on_account]', array());
  }
}
?>