<?php
use_helper('Markdown');
// Default culture is en_US
//
$str = <<<VERYLONGSTRING

## Partners

A Partner is a company collaborating with you, that uses your same Asterisell instance for selling VoIP calls to his customers.

## Configuration

The menu Params -> Params allows setting other administrators/params.

## Partners Capabilities

A Partner can have distinct:

* customers;
* invoices;
* custom login page with distinct logo/partner details;
* rates;

## Partners Limitations

Partner custom login page can be only a sub-page of main Asterisell instance. Something like

  https://www.example.com/partner-name

You must trust completely a Partner, because it can change all the settings of Asterisell instance.

## Differences between Partners and Resellers

A Partner knows all of you, and you know all of your partner, because you share the same
Asterisell instance.

A Reseller uses a distinct Asterisell instance, and he can hide to you his customers,
and applied rates.

VERYLONGSTRING;

echo insertHelp($str);

?>


