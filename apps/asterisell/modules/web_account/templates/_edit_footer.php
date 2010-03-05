<?php
use_helper('Markdown');
// Default culture is en_US
//
echo insertHelp('

## Validity

An account is enabled only if the current date is between "created at" and "disabled at" (if specified).

## Security

Passwords are sent in clear text on normal http socket connections. So make sure to follow the Asterisell suggested installation in order to force https secure socket connections.

## Owner

He is the VoIP Account / Customer / Administrator associated to the Web Account.

Administrator is the account used to administer Asterisell. It can view and change everything.

A Customer can view all its VoIP accounts, but obviously not VoIP accounts associated to other customers.

A Web Access Account can be associated also to a single VoIP account. In this case it can inspect all its calls but not the calls made from other VoIP accounts of the same Customer.

After owner selection use the **Save** button in order to save the choice. Then you can select specific VoIP accounts.
');
?>