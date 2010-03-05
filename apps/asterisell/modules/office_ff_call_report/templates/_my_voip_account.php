<?php
  /**************************************************************
   !!!                                                        !!!
   !!! WARNING: This file is automatic generated.             !!!
   !!!                                                        !!!
   !!! In order to modify this file change the content of     !!!
   !!!                                                        !!!
   !!!    /module_template/call_report_template               !!!
   !!!                                                        !!!
   !!! and execute                                            !!!
   !!!                                                        !!!
   !!!    sh generate_modules.sh                              !!!     
   !!!                                                        !!!
   **************************************************************/

$account = $cdr->getArAsteriskAccount();
$office = $account->getArOffice();

if ($sf_user->hasCredential('admin')) {
  $party = $office->getArParty();
  echo $party->getFullName() . ' - ';
}

echo $office->getName();
?>