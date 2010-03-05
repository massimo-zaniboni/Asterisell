<?php
use_helper('Markdown');
// Default culture is en_US
//
echo insertHelp('

## Usage

Telephone prefixes allows to classify called telephone numbers. 

They are used in "Call Report" in order to inform the user on the destination of its calls.

The typical format is something like

"Wind Mobile(Italy)"

where 

"Wind Mobile" represents the "Operator Name" field 

and 

"Italy" the "Geographica Location.

If "Operator Name" is equal to "Geographic Location" then the "(...)" part is not displayed because it does not add additional informations.

## Rating

Telephone Prefix table is not used in rating process. Rate can use their prefix table.

Telephone Prefix table is used only for displaying information to users about called telephone numbers.

## Prefix Disambiguation

A prefix like "39" can be associated to a generic "Italian Operator".

A prefix like "393" can be associated to a generic (but more specific) "Mobile Italian Operator".

A prefix like "39328" can be associated to the specific "Wind Mobile Italian Operator".

A telephone number is associated to its more specific prefix. So "3944444" is associated to "Italian Operator", while "39344444" to "Mobile Italian Operator" and finally "393284444" to "Wind Mobile Italian Operator".

## Table Completition

It is possible to complete this table importing from a CSV file. Use the "import from a CSV file" rate method in "Rates" module.

## CDR rating

The association between a telephone call and the prefix of the destination number is done during CDR rating. If you update this table you must rerate the CDRs in order to propagate the effects.
');
?>