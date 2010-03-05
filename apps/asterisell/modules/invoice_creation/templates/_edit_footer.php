<?php
use_helper('Markdown');
// Default culture is en_US
//
echo insertHelp('

## Generation

Generate invoices for every customer with at least a call in the given time-frame. 

The generated invoices are viewable in the **customer invoice** module.

The invoices will use successive numbers starting from the specified **first invoice nr**.

## email

Emails are sent only if the **Send email to customers** button is pressed.

## Locale / Culture

Emails and invoices are generated using the culture specified in "apps/asterisell/config/app.yml" configuration file.

## Rerate

If you re-rate already invoiced calls the invoices are not updated. You can force a regeneration of invoices using the **regenerate invoices** button.

');
?>