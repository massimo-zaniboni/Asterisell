<?php
if ($ar_web_account->isAdmin()) {
  echo __("Admin");
 } else if ($ar_web_account->isParty()) {
  $partyId = $ar_web_account->getArPartyId();
  $party = ArPartyPeer::retrieveByPk($partyId);
  // echo link_to($party->getFullName(), 'party/edit?id=' . $party->getId());
  echo $party->getFullName();
 } else if ($ar_web_account->isOffice()) {
  $partyId = $ar_web_account->getArPartyId();
  $party = ArPartyPeer::retrieveByPk($partyId);
  $officeId = $ar_web_account->getArOfficeId();
  $office = ArOfficePeer::retrieveByPk($officeId);
  // echo link_to($party->getName() . ' - ' . $office->getName(), 'office/edit?id=' . $office->getId());
  echo $party->getName() . ' - ' . $office->getName();
}
?>