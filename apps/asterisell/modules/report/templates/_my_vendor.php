<?php
if (!is_null($cdr->getCostArRateId())) {
  $rate = VariableFrame::$rateCache->getRate($cdr->getCostArRateId());
  $vendorId = $rate->getArPartyId();
  if (!is_null($vendorId)) {
    $vendor = VariableFrame::$vendorCache->getArParty($vendorId);
    echo $vendor->getFullName();
  }
}
?>