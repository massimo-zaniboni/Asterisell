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
use_helper('Markdown');
if ($sf_user->hasCredential('admin')) {
  // Default culture is en_US
  //
  echo insertHelp('

## Customer View

A customer does not view call "costs" and associated "earns".

The exported CSV document of a Customer does not contain "costs" and "earns" fields.

A customer does not view  "unprocessed" and "ignored" calls.

A customer does not view Office and VoIP Account field if he has only one office or only one VoIP Account.

A customer does not view filter conditions that do not make sense to him.

A Customer does not view (obviously) this notes.

## Filter

Contrary to other modules, the **receiver** filter field accepts a string prefix and it add automatically "*" to it. If you insert something like "039" then all numbers like "0395", "039334" will be returned. This in order to simplify filter usage also for customers.

## Channel Usage

This graph shows the number of concurrent calls. It is usefull in order to view the used resources. Only calls respecting the current filter are displayed in the graph.

## Reset Button

The reset button will delete the calls in the selected/filtered date range. All other filters are not applied. This is counterintuive, but it is usefull in order to reset calls containing errors and that are not joined with other records of the database, and also ignored calls. 

The reset processing is very slow, so if there are many calls to reset, it can be interrupt due to PHP time constraints. In this case you can press RELOAD-PAGE button one or more time and subsequent calls will be deleted. At the end of the proess the normal CALL REPORT PAGE will be displayed.

## Re-Rate

You can rerate the calls using the "Reset" button, and then forcing their re-rating. In any case, resetted calls will be rerated at the next execution of cron job process.

Changes in configuration/run-time parameters are applied only to new calls. This action allows to back-propagate these changes also to older calls.

If there is a high number of calls to rate, the PHP process can use all available time and then stop. The remaining calls will be rated from the cron job or if you press again the "rate all unrated calls" button.

## Update of Receiver Type

If you change the Telephone Prefixes table you must rerate the CDRs in order to recognize the new prefixes and join them with the CDRs. This operation will not affect the rated costs and incomes, but only the documentation information associated to calls.

## Cost Precision

Costs are displayed using the default currency precision but they are stored (and summed) using full precision, as setted in the configuration file.

Costs are rounded according "currency_decimal_places_in_invoices" parameter value. 

Costs rounding can cause some discrepancies in the call report when there are low numbers.

');
}
?>