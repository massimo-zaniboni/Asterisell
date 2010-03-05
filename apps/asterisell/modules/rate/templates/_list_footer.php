<?php
use_helper('Markdown');
// Default culture is en_US
//
echo insertHelp('

## Cost

The cost is what you had to pay in order to route the call.

Every Call must have exactly one cost rate.

## Income 

The income is what your customer had to pay for the call.

Every Call must have exactly one income rate.

## Workflow

When Asterisk server manages a user call, it puts a new CDR record (call detail record) with all the details of the call on the CDR table.

A new CDR record starts with state "unprocessed". 

Classification rates work on records of type "unprocessed". They inspect mainly the "amaflags" and "disposition" fields where Asterisk server put billing hints/information. They decide the subsequent type of the call.

A classification rate classifies a call as "ignore", if it has no cost/income associated to it. It is also not displayed in the call report of customers. Typically, "ignored" calls are not answered calls, test calls and so on.

A classification rate classifies a call as "outgoing", if the call is made from the customer to an external telephone number, it and it can have a cost and an income, or it must be displayed in the call report.

A classification rate classifies a call as "incoming", it the call is from an external telephone number to the customer VoIP number, and it can have a cost and an income, or it must be displayed in the call report.

A classification rate classifies a call as "internal", if the call is made from the customer to an internal VoIP account, and it can have a cost and an icome, or it must be displayed in the call report.

Rates of type "oucoming", "incoming", "internal" are subsequent processed from the normal rates. Rates of type "ignore" are not further processed.

A rate is a cost rate if it assigns the cost of the rate, that is what you (as service provider) must pay to another VoIP service provider for routing the call.

A rate is an income rate if it assigns the income of the rate, that is what the customer must pay for it.

A call has no cost/income if it was processed from an income/cost rate wich assigned a cost/income of 0.

## Revenue Sharing

A call can have a negative cost. In this case there can be a revenue sharing between the telephone service vendor provider and you (as VoIP provider).

A call can have a negative income. In this case there can be a revenue sharing between your customer and you (as VoIP provider).

Separate invoices can be created for normal costs / incomes and revenue sharing costs / incomes.

So in order to create rates for revenue sharing, simply define rates with negative costs.

## Selecting Displayed Information

Incoming, outgoing and Internal calls can be displayed or not in the customer call report, according the settings of "apps/asterisell/config/app.yml". 

Note: for completeness reasons, the administrator report contains all the calls, and he can inspect also "ignored" calls.

## Problems / Conflicts

If there are no rates to apply or more than a rate to apply on a certain CDR record, then the call is not rated/processed and an error is signaled to the Asterisell administrator. 

The administrator can freely correct the problem updating this rate table. In the meantime Asterisell continues to work.

CDR records with problems are not displayed to customers, but they are only visibles to administrators.

When problems are resolved, the administrator can force a rerate of problematic calls.

');
//}

?>