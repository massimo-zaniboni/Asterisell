<?php
use_helper('Markdown');
// Default culture is en_US
//
echo insertHelp('

## Web Site Appareance

Web Site Appereance can be further customized changing "apps/asterisell/templates/asterisell_layout.php" and "web/css" content.

Logo images must be loaded inside "web/images" directory.

## Behaviour Params

Other behaviour params are located inside "apps/asterisell/config/app.yml" file. 

## Customers with different Params

Params can be used as an hack in order to assign different web site appareances to different customers.

## Emails

If SMTP params are left incomplete, then Asterisell will simply not send emails, and it does not consider this an error.

SMTP parameters are also used for sending to administrators, error reports.

If SMTP params are not correct then Asterisell signal the problem inside problem table.

Asterisell signal a problem for every mail that it was not able sending.

Emails with invoices are sent only to customers with a configured email address, and only when explicitely requested from the Asterisell administrator, so configuring SMTP parameters has no unintended side effects.

');

?>