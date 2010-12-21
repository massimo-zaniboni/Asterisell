<?php

use_helper('Form');
use_helper('I18N');

$d = NULL;

if (isset($filters['filter_on_end_time'])) {
  $d = $filters['filter_on_end_time'];
}

echo input_date_tag('filters[filter_on_end_time]', $d, array (
  'rich' => true,
  'withtime' => true,
  'calendar_button_img' => '/sf/sf_admin/images/date.png'));

?>