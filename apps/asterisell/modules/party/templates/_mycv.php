<?php
if ($ar_party->getCustomerOrVendor() == "C") {
  echo __("Customer");
} else if ($ar_party->getCustomerOrVendor() == "V") {
  echo __("Vendor");
} else {
  $p = new ArProblem();
  $p->setDuplicationKey('ar_party malformed: ' . $ar_party->getId());
  $p->setDescription('ar_party has customer_or_vendor field that does not contain C or V');
  ArProblemException::addProblemIntoDBOnlyIfNew($p);
  echo __('Unknow');
}
?>