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
$c->addAscendingOrderByColumn(ArParamsPeer::NAME);
$params = ArParamsPeer::doSelect($c);

// add a blank option
$options = array("" => "");
foreach($params as $p) {
  $options[$p->getId()] = $p->getName();
}
$defaultChoice = "";
if (isset($filters['filter_on_params'])) {
  $defaultChoice = $filters['filter_on_params'];
 }
echo select_tag('filters[filter_on_params]', options_for_select($options, $defaultChoice));
?>