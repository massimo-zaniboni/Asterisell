<?php
use_helper('Markdown');
// Default culture is en_US
//
echo insertHelp('

## Price Category

You can classify Customers in different Price Category in order to apply different price list.

In case of a Vendor this field has no meaning / effect.

## Email

If you set an email it can be used to send invoices and other notifications directly to the customer.

You must always execute an explicit action before sending emails to customers. This prevent "spam effect".

## Cost Limit

If you set a limit of 0 (or NULL) then no cost limit check is made for a given Customer. Otherwise the administrator (but not the Customer) is advised when a customer does not respect it.

## CRM Code

The code associated to the customer in you Customer Relationship Management program.

## Address

If you manage customers using your CRM software you can freely left empty these fields.

');
//}

?>