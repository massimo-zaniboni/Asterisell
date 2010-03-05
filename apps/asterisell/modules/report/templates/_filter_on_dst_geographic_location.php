<?php
$c = new Criteria();
$c->addSelectColumn('DISTINCT(' . ArTelephonePrefixPeer::GEOGRAPHIC_LOCATION . ')');
$c->addAscendingOrderByColumn(ArTelephonePrefixPeer::GEOGRAPHIC_LOCATION);
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
if (isset($filters['filter_on_dst_geographic_location'])) {
  $defaultChoice = $filters['filter_on_dst_geographic_location'];
}
echo select_tag('filters[filter_on_dst_geographic_location]', options_for_select($options, $defaultChoice));
?>