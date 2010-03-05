<?php
use_helper('Markdown');
// Default culture is en_US
//
echo insertHelp('

## Security

Passwords are sent in clear text on normal http socket connections. So make sure to follow the Asterisell suggested installation in order to force https secure socket connections.

## Access privileges

Administrator is the account used to administer Asterisell. It can view and change everything.

A Customer web account can inspect all calls of its offices / VoIP accounts, but obviously not VoIP accounts associated to other customers.

An office web account can inspect all its calls, but not the calls made from other offices / VoIP accounts of the same customer.
');
?>