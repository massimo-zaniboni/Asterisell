<?php
/*
* Copyright (C) 2007 Massimo Zaniboni - massimo.zaniboni@profitoss.com
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
 * Generate an email with an invoice.
 */
abstract class MailWithInvoiceGenerator {
  /**
   * @param $party the customer
   * @param $invoice the invoice to send
   * @return array($subject, $content) containing the subject and content of the mail
   *
   * @precondition: $invoice->getArPartyId == $party->getId()
   */
  abstract public function getEmailContent(ArParty $arParty, ArInvoice $invoice);
}
?>