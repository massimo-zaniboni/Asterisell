<?php
$c = new Criteria();
$c->addAscendingOrderByColumn(ArPartyPeer::NAME);
$c->add(ArPartyPeer::CUSTOMER_OR_VENDOR, "V", Criteria::EQUAL);
$parties = ArPartyPeer::doSelect($c);
$options = array("" => __(""));
foreach($parties as $party) {
  $options[$party->getId() ] = $party->getFullName();
}
echo select_tag('filters[ar_party_id]', options_for_select($options, isset($filters['ar_party_id']) ? $filters['ar_party_id'] : ''));
?>