<?php
use_helper('Markdown');
if ($sf_user->hasCredential('admin')) {
  // Default culture is en_US
  //
  echo insertHelp('

## Customer View

A customer does not view call "costs" and associated "earns".

The exported CSV document of a Customer does not contain "costs" and "earns" fields.

A Customer does not view (obviously) this notes.

## Filter

Contrary to other modules, the **receiver** filter field accepts a string prefix and it add automatically "*" to it. If you insert something like "039" then all numbers like "0395", "039334" will be returned. This in order to simplify filter usage also for customer.

## Rate

When a customer open the module, first all his calls wich are not already rated are rated and then they are displayed.

Usually there are few calls to rate because there is a cronjob that periodically rate all unrated calls.

## Re-Rate

If you change current rates parameters then already rated calls are not automatically re-rated. You can force a re-rate using the **Recalc Selected Calls** button. You re-rate only the current filtered/selected calls. The effect of the button is to remove rate info from the selected calls. This will force a rerating.

## Bulk Rerate Problems

If there is a high number of calls to rate, the PHP process can use all available time and then stop. Then in the user view there will be some rates with undefined cost. 

This is not a big problem because every time you (or the user) open the page the remaining calls are rated.

If you have installed Asterisell properly then there is also a PHP rate process that starts regularly from the cronjob. This process has no ram and cpu constraints so it can rate many calls and all the remaining calls.

So calls can be rated using incremental steps.

## Update of Receiver Type

If you change the Telephone Prefixes table you must rerate the CDRs in order to recognize the new prefixes and join them with the CDRs.

## Cost Precision

Costs are displayed using the default currency precision but they are stored (and summed) using full precision. 

');
}
?>