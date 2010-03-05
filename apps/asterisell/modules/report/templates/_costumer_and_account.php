<?php
$partyId = $cdr->getArAsteriskAccount()->getArPartyId();
$party = VariableFrame::$vendorCache->getArParty($partyId);
echo $party->getFullName() . ':' . $cdr->getArAsteriskAccount()->getName();
?>