<?php
if ($ar_web_account->isAdmin()) {
  echo __("Admin");
} else if (!is_null($ar_web_account->getArPartyId())) {
  $partyId = $ar_web_account->getArPartyId();
  $party = ArPartyPeer::retrieveByPk($partyId);
  echo link_to($party->getFullName(), 'party/edit?id=' . $party->getId());
} else if (!is_null($ar_web_account->getArAsteriskAccountId())) {
  $accountId = $ar_web_account->getArAsteriskAccountId();
  $account = ArAsteriskAccountPeer::retrieveByPk($accountId);
  echo link_to($account->getName(), 'asterisk_account/edit?id=' . $account->getId());
}
?>