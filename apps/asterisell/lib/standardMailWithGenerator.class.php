<?php
/*
* Copyright (C) 2007, 2008, 2009
* by Massimo Zaniboni <massimo.zaniboni@profitoss.com>
*
*   This file is part of Asterisell.
*
*   Asterisell is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 3 of the License, or
*   (at your option) any later version.
*
*   Asterisell is distributed in the hope that it will be useful,
*   but WITHOUT ANY WARRANTY; without even the implied warranty of
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*   GNU General Public License for more details.
*
*   You should have received a copy of the GNU General Public License
*   along with Asterisell. If not, see <http://www.gnu.org/licenses/>.
*    
*/
sfLoader::loadHelpers(array('I18N', 'Debug', 'Date', 'Asterisell'));
/**
 * This class does not generate a full invoice
 * but only info about the billed calls.
 */
class StandardMailWithInvoiceGenerator extends MailWithInvoiceGenerator {
  public function getEmailContent(ArParty $party, ArInvoice $invoice) {
    $eol = "\r\n";
    $providerName = sfConfig::get('app_service_provider_name');
    $culture = sfConfig::get('app_culture');
    $currency = sfConfig::get('app_currency');
    $subject = '';
    $r = '';
    if ($culture == 'it_IT') {
      $r.= 'Spettabile ' . $party->getFullName() . ', ' . $eol . $eol . 'la informiamo che ricevera` presto una fattura da parte di ' . $providerName . $eol . 'relativa al traffico telefonico da noi gestito contenente i seguenti dati:' . $eol . $eol . "Numero Fattura:\t\t" . $invoice->getNr() . $eol . "Data Fattura:\t\t" . format_date($invoice->getInvoiceDate(), "d", $culture) . $eol . "Periodo considerato:\t" . format_date($invoice->getArCdrFrom(), "d", $culture) . " - " . format_date($invoice->getArCdrTo(), "d", $culture) . $eol . $eol . $eol . $eol . "Dettagli chiamate: " . $eol . $eol . $invoice->getTxtDetails() . $eol . $eol . "Importo totale (escluso IVA):\t" . format_for_txt_locale($invoice->getTotalWithoutTax()) . $eol . "Aliquota IVA:\t\t\t" . format_according_locale($invoice->getVatPerc()) . '%' . $eol . "Totale IVA:\t\t\t" . format_for_txt_locale($invoice->getTotalVat()) . $eol . "Importo Totale:\t\t\t" . format_for_txt_locale($invoice->getTotal()) . $eol . $eol . $eol . "Per maggiori informazioni consulti il sito web " . $eol . $eol . sfConfig::get("app_service_provider_customer_web_address") . $eol . $eol . "o ci contatti all'indirizzo " . $eol . $eol . sfConfig::get("app_service_provider_mail") . $eol . $eol . "Cordiali Saluti," . $eol . $providerName . ".";
      $subject = "Anticipo dettagli fattura";
    } else {
      $r.= $party->getFullName() . ", " . $eol . $eol . "you will receive and invoice from " . $providerName . $eol . "about the managed telephone calls, with these details: " . $eol . $eol . "Invoice Number: " . $invoice->getNr() . $eol . "Invoice Date: " . format_date($invoice->getInvoiceDate(), "d", $culture) . $eol . "Invoiced Period: " . format_date($invoice->getArCdrFrom(), "d", $culture) . " - " . format_date($invoice->getArCdrTo(), "d", $culture) . $eol . $eol . $eol . $eol . "Traffic Details: " . $eol . $eol . $invoice->getTxtDetails() . $eol . $eol . "Total Amount (tax not included):\t" . format_for_txt_locale($invoice->getTotalWithoutTax()) . $eol . "VAT %:\t\t\t\t\t" . $invoice->getVatPerc() . "%" . $eol . "Total VAT:\t\t\t\t" . format_for_txt_locale($invoice->getTotalVat()) . $eol . "Total Amount:\t\t\t\t" . format_for_txt_locale($invoice->getTotal()) . $eol . $eol . $eol . "For more informations consult  " . $eol . $eol . sfConfig::get("app_service_provider_customer_web_address") . $eol . $eol . "or send an email to " . $eol . $eol . sfConfig::get("app_service_provider_mail") . $eol . $eol . "Best Regards," . $eol . $providerName . ".";
      $subject = "Invoice Notification";
    }
    return array($subject, $r);
  }
}
?>