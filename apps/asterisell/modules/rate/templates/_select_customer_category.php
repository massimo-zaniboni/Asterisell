<?php
$c = new Criteria();
$c->addAscendingOrderByColumn(ArRateCategoryPeer::NAME);
$categories = ArRateCategoryPeer::doSelect($c);
$options = array("" => __(""));
foreach($categories as $category) {
  $options[$category->getId() ] = $category->getName();
}
$default = $ar_rate->getArRateCategoryId();
if (is_null($default)) {
  $default = "";
}
echo select_tag('select_customer_category', options_for_select($options, $default));
?>