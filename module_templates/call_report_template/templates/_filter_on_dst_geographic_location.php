<?php

/* * ************************************************************
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
 * ************************************************************ */

// Take in consideration only the geographic locations of current selected calls
//
$c2 = clone(VariableFrame::$filterCondition);
$c2->addSelectColumn('DISTINCT(' . ArTelephonePrefixPeer::GEOGRAPHIC_LOCATION . ')');
$c2->addAscendingOrderByColumn(ArTelephonePrefixPeer::GEOGRAPHIC_LOCATION);
$c2->addJoin(CdrPeer::AR_TELEPHONE_PREFIX_ID, ArTelephonePrefixPeer::ID);
$rs = CdrPeer::useCalldateIndex($c2);

// add a blank option
//
$options = array("" => "");
// add other options
//
foreach ($rs as $r) {
    $options[$r[0]] = $r[0];
}
$defaultChoice = "";
if (isset($filters['filter_on_dst_geographic_location'])) {
    $defaultChoice = $filters['filter_on_dst_geographic_location'];
}
echo select_tag('filters[filter_on_dst_geographic_location]', options_for_select($options, $defaultChoice));
?>