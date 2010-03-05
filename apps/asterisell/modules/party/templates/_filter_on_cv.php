<?php
use_helper('Asterisell');
$defaultValue = null;
if (isset($filters['filter_on_cv'])) {
  $defaultValue = $filters['filter_on_cv'];
}
echo select_customer_or_vendor_tag('filters[filter_on_cv]', $defaultValue, true);
?>