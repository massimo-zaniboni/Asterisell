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
use_helper('Asterisell');

if ($cdr->isRated()) {
  $income = $cdr->getIncome();
  $cost = $cdr->getCost();
  echo format_from_db_decimal_to_call_report_currency(($income - $cost));
} else {
  echo __("?");
}
?>