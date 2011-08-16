<?php
use_helper('Markdown');
// Default culture is en_US
//
$str = <<<VERYLONGSTRING
## Resellers

A Reseller is a company selling VoIP calls to his customers, and where you play the role of the VoIP vendor.

Resellers are supported only in commercial version of AsteriSell.

## Installation and Configuration

In case of Resellers, there are two running instances of Asterisell:

- Main-Instance (your Asterisell instance);
- Reseller-Instance;

Main-Instance and Reseller-Instance can resides on different computers/network.
They can be two separate instances from every point of view.

In Main-Instance you configure one of your customer as Reseller. 
It is an option of Customer/Vendor form.

HINT: you can apply to a reseller discount prices, because he is selling VoIP calls
to other customers. So you can set him to some "reseller" price category,
and you can configure rates for "reseller" price category according.

All CDRs associated to the Reseller customer (in other words all the CDRs of his offices/VoIP accounts) 
will be also exported to CSV files, that there will be imported from the Reseller-Instance.

Resellers CSV files will be put inside directories like

    cdr-exported-to-resellers/some-reseller-short-code

inside Main-Instance root directory. Directories are created automatically, and the CSV file
has a name like

    cdr-12345678.csv
  
where "123456789" is a unique and progressive number. 

Reseller-Instance must configure inside 

    apps/asterisell/config/app.yml
  
configuration file, the directory where resides the CSV files with reseller CDRs.

HINT: if the two instances are put on separated computers/network you must create some
script copying new CSV files between the Main-Instance and the Reseller-Instance.

Imported CSV files will be put inside Reseller-Instance directory

    imported-cdr/processed
  
For a Reseller-Instance, you are the VoIP provider/vendor. 

He creates vendor rates equals to the "reseller" rates on Main-Instance side. 

Reseller-Instance must activate the system rate 

  ProcessImportedCDR
  
recognizing imported CDRs.

CDRs imported on the Reseller-Instance will be checked and the Reseller will be
informed if there is some difference between the cost of VoIP calls calculated
from Main-Instance, and the cost calculated from Reseller-Instance, applying the
Vendor Rates. This is similar to Main-Instance, calculating the cost of VoIP calls
respect his VoIP vendor.

## VoIP Accounts Management

If Reseller has a customer Customer-A, with Office-A, and VoIP accounts ACC-1, ACC-2, 
he must ask to Main-Instance to activate VoIP accounts

- ACC-1
- ACC-2

Main-Instance must create ACC-1, and ACC-2 as VoIP accounts associated to the Reseller
customer. He must not know the final (reseller) customer associated to these accounts, as
he does not inform his VoIP provider of his customers.

All CDRs associated to ACC-1 and ACC-2, will be exported to CSV files associated to
the reseller customer, because they are on Main-Instance, VoIP accounts of the reseller.

Reseller-Instance, must create

* Customer-A/Office-A/ACC-1
* Customer-A/Office-B/ACC-2

and manage them in the usual way.

If Reseller-Instance, configure Customer-A/Office-A/ACC-1 after Main-Instance, it is not a problem
because CDRs will be imported, but they will not rated, until the VoIP account is created,
and the usual Asterisell error message will be notified to Reseller-Instance administrator.

## Invoicing/Billing

Main-Instance will produce a unique invoice with all the calls of the VoIP accounts associated
to the Reseller. This is the usual Asterisel work-flow, because a Reseller is a normal customer
inside Main-Instance.

Reseller-Instance will produce an invoice for each of his customers. This is the normal
Asterisell work-flow, because every Reseller customer, is a normal customer inside
Reseller-Instance.

## Rerating of CDRs

If already exported CDRs will be rated again (for example after chaning rates, or fixing errors), they will be exported
again to the reseller, and Reseller-Instance will update the old CDRs with new values,
without creating duplicated/conflicting CDRs.

Reseller-Instance can recognize all events like:

* a CDR changes cost/income;
* a CDR changes VoIP account;
* a CDR changes outgoing/incoming/internal state;
* a CDR changes destination/source telephone number;
* and so on..;

Reseller-Instance can not recognize the cange from "outgoing/incoming/internal" state to "ignored" state,
and vice-versa. This because "ignored" CDRs are not sent to resellers. Usually rules about classification
of CDRs to ignore are not changed often, so it is not a big problem.

## Reseller License

Reseller-Instance is another instance of Asterisell, so it requires another commercial license. 
Ask for discounts.

VERYLONGSTRING;

echo insertHelp($str);
?>


