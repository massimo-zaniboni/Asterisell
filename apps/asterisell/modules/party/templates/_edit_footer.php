<?php
use_helper('Markdown');
// Default culture is en_US
//
echo insertHelp('

## Resellers

A reseller is a customer who resells VoIP calls to his own customers, wich are unknown to this Asterisell installation.

This Asterisell installation send to the reseller, using CSV files, all the CDR data of VoIP calls made from accountcode associated to the reseller.
Then the reseller can use another private instance of Asterisell for importing CDR data, and associating to each accountcode the proper customer.

Each reseller has a short and unique code. This code is used for naming files and directories used for exporting the CDR data. 
Given a reseller with a name like "YZ", then CSV files are "cdr-exported-to-resellers/YZ/cdr-x.csv", where "x" is a unix-timestamp number.
Directories will be created from Asterisell, if they are missing.

This Asterisell installation, act like the VoIP provider of the reseller Asterisell installation.

NOTE: if you enable a customer as reseller then all his previous CDR will be sent to the reseller instance of Asterisell.
This is acceptable because usually you create a new/fresh customer/voip-account for a reseller, and you do not reuse
a VoIP account with many CDRs in the past.

In case of re-rating, the modified CDRs will be sent again to the reseller instance of Asterisell.
So he views always the last and correct values.

Ignored calls will be not sent to Asterisell reseller instance, 
because an ignored call is not assigned to any specific account.
A conseguence of this, it is that if you change the classification criteria for ignored calls,
and this influence the classification of old rated CDRs already sent to a reseller,
he will not be change them to ignored because he will not receive them with the new ignored state.
This is acceptable because ignored call classification is a low-level, system-related
setting, and it does not change very often, and it does not influence usually the past
classification of CDRs.

');
?>