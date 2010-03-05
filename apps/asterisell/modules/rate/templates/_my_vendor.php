<?php
$c = $ar_rate->getCustomerOrVendor();

if ($c == "V") {
  echo $ar_rate->getArParty()->getFullName();
}
?>