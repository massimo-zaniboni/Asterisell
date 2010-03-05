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
class invoice_creationActions extends autoinvoice_creationActions {
  public function executeEdit() {
    if ($this->getRequestParameter('regenerate_invoices') || $this->getRequestParameter('send_emails_to_customers')) {
      $this->ar_invoice_creation = $this->getArInvoiceCreationOrCreate();
      $this->updateArInvoiceCreationFromRequest();
      $this->saveArInvoiceCreation($this->ar_invoice_creation);
      $id = $this->ar_invoice_creation->getId();
      $billEngine = new BillEngine();
      if ($this->getRequestParameter('regenerate_invoices')) {
        list($nrOfInvoices, $allOk) = $billEngine->bill($this->ar_invoice_creation, null);
        if ($allOk) {
          $prop = ' all ';
          $end = '';
        } else {
          $prop = ' only ';
          $end = __(' - See Problems table for details ');
        }
        $msg = __('Generated ') . $prop . $nrOfInvoices . __(' invoices') . $end;
        $this->setFlash('notice', $msg);
      } else if (($this->getRequestParameter('send_emails_to_customers'))) {
        list($nrOfSent, $nrOfUnsent) = $this->sendAllUnsentInvoices($this->ar_invoice_creation);
        if ($nrOfUnsent == 0) {
          $prop = ' all ';
          $end = '';
        } else {
          $prop = ' only ';
          $end = ' and there were problems on ' . $nrOfUnsent . ' emails.';
        }
        $msg = 'Sent ' . $prop . $nrOfSent . ' emails' . $end;
        $this->setFlash('notice', $msg);
      }
      return $this->redirect('invoice_creation/edit?id=' . $id);
    } else {
      parent::executeEdit();
    }
  }
  /**
   * Send an email to all unsent invoices of this invoice-creations set.
   *
   * @return array(nrOfSent, nrOfUnsent) the number of sent emails
   * and the number of unsent for various problems.
   */
  protected function sendAllUnsentInvoices($invoiceCreation) {
    $c = new Criteria();
    $c->addJoin(ArInvoicePeer::AR_PARTY_ID, ArPartyPeer::ID);
    $c->add(ArInvoicePeer::ALREADY_SENT, false);
    $c->add(ArPartyPeer::EMAIL, NULL, Criteria::NOT_EQUAL);
    $c->add(ArInvoicePeer::INVOICE_DATE, $invoiceCreation->getInvoiceDate());
    $c->add(ArInvoicePeer::AR_CDR_FROM, $invoiceCreation->getArCdrFrom());
    $c->add(ArInvoicePeer::AR_CDR_TO, $invoiceCreation->getArCdrTo());
    $totSent = 0;
    $totUnsent = 0;
    $rs = ArInvoicePeer::doSelect($c);
    foreach($rs as $invoice) {
      $isSent = BillEngine::sendEmailNow($invoice);
      if ($isSent) {
        $totSent++;
      } else {
        $totUnsent++;
      }
    }
    return array($totSent, $totUnsent);
  }
}
