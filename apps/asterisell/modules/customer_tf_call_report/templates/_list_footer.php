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

## Re-rate Button

The re-rate button will reset the calls in the selected timeframe. Other filters are not take in consideration: only the timeframe. 

This behaviour is counterintuive, but it is usefull in order to reset calls containing errors and that are not joined with other records of the database, and also ignored calls. 

The resetted calls will be rated, so there is no permanent loss of information.
If there is a high number of calls to rate, the PHP process can use all available time and then stop. The remaining calls will be rated from the cron job at the next step, or can be forced using the Job Log button.

All the error messages generated during the re-rating are put inside the "Current Problems" table, but they are (intentionally) not emailed to administrators, in order to avoid sending warning emails, during the work of an administrator on the system.

## Cost Precision

Costs are displayed using the default currency precision but they are stored (and summed) using full precision, as setted in the configuration file.

Costs are rounded according "currency_decimal_places_in_invoices" parameter value. 

Costs rounding can cause some discrepancies in the call report when there are low numbers.

');
}
?>