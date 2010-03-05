<?php
$c = new Criteria();
$c->addAscendingOrderByColumn(ArPartyPeer::NAME);
$c->add(ArPartyPeer::CUSTOMER_OR_VENDOR, "V", Criteria::EQUAL);
$parties = ArPartyPeer::doSelect($c);
$options = array("" => __(""));
foreach($parties as $party) {
  $options[$party->getId() ] = $party->getFullName();
}
$default = $ar_rate->getArPartyId();
if (is_null($default)) {
  $default = "";
}
echo select_tag('select_vendor', options_for_select($options, $default));
?>