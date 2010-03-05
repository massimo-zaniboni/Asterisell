<?php
use_helper('Form');
use_helper('I18N');
$options = array('0' => '', '1' => __('today'), '2' => __('last two days'), '3' => __('this week'), '4' => __('last two weeks'), '5' => __('last 30 days'), '6' => __('last two months'), '7' => __('last four months'),);
$group = 'filters[filter_on_timeframe]';
if (isset($filters['filter_on_timeframe'])) {
  $defaultChoice = $filters['filter_on_timeframe'];
} else {
  $defaultChoice = VariableFrame::$defaultTimeFrameValue;
  $filters['filter_on_timeframe'] = $defaultChoice;
}
echo select_tag('filters[filter_on_timeframe]', options_for_select($options, $defaultChoice));
?>