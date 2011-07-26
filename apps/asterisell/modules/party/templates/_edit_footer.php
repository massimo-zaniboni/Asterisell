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

');
?>