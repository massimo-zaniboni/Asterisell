<?php
$defaultValue = '';
if (isset($filters['filter_on_dst'])) {
  $defaultValue = $filters['filter_on_dst'];
}
echo input_tag('filters[filter_on_dst]', $defaultValue);
?>