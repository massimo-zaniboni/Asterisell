<?php
use_helper('Asterisell');

$c = new Criteria();
$c->addAscendingOrderByColumn(ArPartyPeer::NAME);
$c->addAscendingOrderByColumn(ArOfficePeer::NAME);
$offices = ArOfficePeer::doSelectJoinArParty($c);

$options = array();
foreach($offices as $office) {
  $party = $office->getArParty();
  $options[$office->getId()] = $party->getName() . ' - ' . $office->getName();
}

echo select_tag('mycustomeroffice', options_for_select($options, $ar_asterisk_account->getArOfficeId()));
?>