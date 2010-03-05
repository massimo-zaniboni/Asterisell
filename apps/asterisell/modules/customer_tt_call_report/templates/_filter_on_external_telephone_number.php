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
$defaultValue = '';
if (isset($filters['filter_on_external_telephone_number'])) {
  $defaultValue = $filters['filter_on_external_telephone_number'];
}
echo input_tag('filters[filter_on_external_telephone_number]', $defaultValue);
?>