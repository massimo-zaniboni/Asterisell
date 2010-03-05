<?php
  /**************************************************************
   !!!                                                        !!!
   !!! WARNING: This file is automatic generated.             !!!
   !!!                                                        !!!
   !!! In order to modify this file change the content of     !!!
   !!!                                                        !!!
   !!!    /module_template/call_report_template               !!!
   !!!                                                        !!!
   !!! and execute                                            !!!
   !!!                                                        !!!
   !!!    sh generate_modules.sh                              !!!     
   !!!                                                        !!!
   **************************************************************/
$c = new Criteria();
$c->addSelectColumn('DISTINCT(' . ArTelephonePrefixPeer::OPERATOR_TYPE . ')');
$c->addAscendingOrderByColumn(ArTelephonePrefixPeer::OPERATOR_TYPE);
$rs = BasePeer::doSelect($c);

// add a blank option
//
$options = array("" => "");

// add other options
//
foreach($rs as $r) {
  $options[$r[0]] = __(trim($r[0]));
}
$defaultChoice = "";
if (isset($filters['filter_on_dst_operator_type'])) {
  $defaultChoice = $filters['filter_on_dst_operator_type'];
}
echo select_tag('filters[filter_on_dst_operator_type]', options_for_select($options, $defaultChoice));
?>