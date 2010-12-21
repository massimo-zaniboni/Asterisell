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

use_helper('Form');
use_helper('I18N');

$d = NULL;

if (isset($filters['filter_on_calldate_to'])) {
  $d = $filters['filter_on_calldate_to'];
}

echo input_date_tag('filters[filter_on_calldate_to]', $d, array (
  'rich' => true,
  'withtime' => true,
  'calendar_button_img' => '/sf/sf_admin/images/date.png'));
?>
