<?php
$c = $ar_rate->getCustomerOrVendor();

if ($c == "C") {
  echo "Customer of category: " . $ar_rate->getArRateCategory();
} elseif ($c == "V") {
  echo "Vendor: " . $ar_rate->getArParty();
} else {
  echo "Call state: " . $ar_rate->getCVName();
}
?>