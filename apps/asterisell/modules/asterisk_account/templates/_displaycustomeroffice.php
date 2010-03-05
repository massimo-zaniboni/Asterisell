<?php
$office = $ar_asterisk_account->getArOffice();
$party = $office->getArParty();
$name = $party->getName() . " - " . $office->getName();
echo "$name";
?>