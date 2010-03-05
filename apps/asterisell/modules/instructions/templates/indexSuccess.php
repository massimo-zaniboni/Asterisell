<?php
use_helper('Markdown');
// Default culture is en_US
//
echo insertHelp('

## Module documentation

Every module has its documentation at the bottom of the page.

## Filters Usage

Use something like "abc*" to search all the strings starting with "abc".

## Asterisell Web Site 

For more info consult [Asterisell online documentation](http://asterisell.profitoss.com/).

## Internal vs External Telephone Numers

The internal telephone number is the VoIP account code, managed from the Asterisk server.

The external telephone number is the number residing on  external lines, reachable using the services of the VoIP service provider.

In an outgoing call, the internal telephone number is the source of the call.

In an incoming call, the internal telephone number is the destination of the call.

In an outgoing call, the external telephone number is the destination of the call.

In an incoming call, the external telephone number is the source of the call.

In Asterisell the distinction is between internal and external telephone numbers, not between call source and destination. This in order to make more coherent the management of both incoming and outgoing calls.

');
//}

?>


