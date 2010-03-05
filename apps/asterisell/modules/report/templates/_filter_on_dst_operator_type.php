<?php
$c = new Criteria();
$c->addSelectColumn('DISTINCT(' . ArTelephonePrefixPeer::OPERATOR_TYPE . ')');
$c->addAscendingOrderByColumn(ArTelephonePrefixPeer::OPERATOR_TYPE);
$rs = BasePeer::doSelect($c);
$rs = BasePeer::doSelect($c);
// add a blank option
//
$options = array("" => "");
// add other options
//
foreach($rs as $r) {
  $options[$r[0]] = $r[0];
}
$defaultChoice = "";
if (isset($filters['filter_on_dst_operator_type'])) {
  $defaultChoice = $filters['filter_on_dst_operator_type'];
}
echo select_tag('filters[filter_on_dst_operator_type]', options_for_select($options, $defaultChoice));
?>