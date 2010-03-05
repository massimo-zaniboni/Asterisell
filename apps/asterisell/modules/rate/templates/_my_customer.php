<?php
$c = $ar_rate->getCustomerOrVendor();

if ($c == "C") {
  echo $ar_rate->getArRateCategory();
}
?>