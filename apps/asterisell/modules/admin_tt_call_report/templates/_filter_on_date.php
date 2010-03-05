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

echo input_date_range_tag('filters[specific_calldate]', isset($filters['specific_calldate']) ? $filters['specific_calldate'] : null, array (
  'rich' => true,
  'withtime' => false,
  'calendar_button_img' => '/sf/sf_admin/images/date.png',
														 ));
?>
