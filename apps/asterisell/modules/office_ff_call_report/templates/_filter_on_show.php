<?php  /**************************************************************
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

$index = 'filter_on_show';

$options = array("" => "");
$options['10-calls'] = __("Calls details");

  

$options['40-accounts'] = __("Group by VoIP accounts");

$defaultChoice = filterValue($filters, $index);
if (is_null($defaultChoice)) {
  $defaultChoice = '10-calls';
}

echo select_tag('filters[filter_on_show]', options_for_select($options, $defaultChoice));

?>
