<?php
use_helper('Markdown', 'OnlineManual');
// Default culture is en_US
//
echo insertHelp('

## Active Rates

By default this list display only current active rates.

A CDR is always rated using the rate active at the moment of its Call-Date.

If you want inspect the rating of a CDR rated in the past, you can  select the date of the CDR, for seeing the rates active when the CDR were rated.

## Cost

The cost is what you had to pay in order to route the call.

Every Call must have exactly one cost rate.

## Income 

The income is what your customer had to pay for the call.

Every Call must have exactly one income rate.

## Bundle Rates

Bundle Rates are applied both during CDR processing (for assigning cost/income to CDR), and during invoice generation for assigning cost to invoices.

A Bundle Rate is active on a period, typically corresponding to the invoice period.

Up to date, default invoice generation includes in the invoice all the bundle rate of the same category of the invoiced customer, that are active at the start date of the invoice.

Bundle Rate can be also used during generation of invoices related to vendor cost calculations. In this case they are applied to vendors instead to customers.

In case of VENDOR INVOICES, all the bundle rate costs, of the active customers of the params/reseller selected during invoice generation, are calculated.

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

## Rate Priorities

Exception rates have major priority respect other rates.

Bundle rates have major priority respect normal rates.

Every rate have a priority method. Two rates are comparable if they have the same priority method, and if they work on the same type of CDR (unprocessed/incoming/outcoming).

If there are no rates to apply on the same CDR, or more than a rate with the same priority, or two no comparable Rates on the same type of CDR, then the CDR is not rated/processed, and an error is signaled to the Asterisell administrator. The administrator can freely correct the problem updating this rate table. In the meantime Asterisell continues to work.

CDR records with problems are not displayed to customers, but they are only visibles to administrators in the `Unprocessed Calls` section. Note that in this section there are also the few CDR records, that were inserted in the CDR table, after the last cron-job processing job. After the nex rating process, they will be moved to `Call Report`.

CDR records that are correctly processed, but according classification rates are considered not important, are put insid `Ignored Calls` section.

In case of big reorganization of active rates, the administrator can force a re-rate of current CDR, in order to propagate changes also to already rated CDRs.

',
  array(array('rates', 'Initial Rates Configurations'),
        array('rating', 'Solving Problems in Rate Configurations')));

//}

?>