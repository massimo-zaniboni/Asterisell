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
$options = array('0' => __('specific date range'), '1' => __('today'), '2' => __('last 2 days'), '3' => __('last 7 days'), '4' => __('last 14 days'), '5' => __('last 30 days'), '20' => __('this month'), '21' => __('last month'), '6' => __('last 60 days'), '7' => __('last 4 months'),);
$group = 'filters[filter_on_timeframe]';
if (isset($filters['filter_on_timeframe'])) {
  $defaultChoice = $filters['filter_on_timeframe'];
} else {
  $defaultChoice = 0;
  $filters['filter_on_timeframe'] = $defaultChoice;
}
echo select_tag('filters[filter_on_timeframe]', options_for_select($options, $defaultChoice));
?>