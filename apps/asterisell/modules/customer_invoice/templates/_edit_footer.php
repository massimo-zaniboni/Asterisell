<?php
use_helper('Markdown');
// Default culture is en_US
//
echo insertHelp('

## email

Email is sent only if the **Send email to customer** button is pressed and the customer has an email associated.

## Locale / Culture

Emails and invoices are generated using the culture specified in "apps/asterisell/config/app.yml" file.
');
?>