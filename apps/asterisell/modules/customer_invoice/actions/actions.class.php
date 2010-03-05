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
class customer_invoiceActions extends autocustomer_invoiceActions {
  public function executeEdit() {
    if ($this->getRequestParameter('regenerate_invoice') || $this->getRequestParameter('send_email_to_customer')) {
      $this->ar_invoice = $this->getArInvoiceOrCreate();
      $this->updateArInvoiceFromRequest();
      $this->saveArInvoice($this->ar_invoice);
      $id = $this->ar_invoice->getId();
      $billEngine = new BillEngine();
      if ($this->getRequestParameter('regenerate_invoice')) {
        list($nr, $allOk) = $billEngine->bill(null, $this->ar_invoice);
        if ($allOk) {
          $prop = 'Invoice Generated';
        } else {
          $prop = 'Invoice not Generated. See Problems Table for more details.';
        }
        $this->setFlash('notice', $prop);
      } else if (($this->getRequestParameter('send_email_to_customer'))) {
        $isSent = BillEngine::sendEmailNow($this->ar_invoice);
        if ($isSent) {
          $prop = __('Email Sent');
        } else {
          $prop = __('Email not Sent');
        }
        $this->setFlash('notice', $prop);
      }
      return $this->redirect('customer_invoice/edit?id=' . $id);
    } else {
      parent::executeEdit();
    }
  }
}
