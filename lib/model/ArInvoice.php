<?php

/**
 * Subclass for representing a row from the 'ar_invoice' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ArInvoice extends BaseArInvoice
{

  /**
   * @return true if it is a customer invoice, false if it is a vendor invoice
   */
  public function isCustomer() {
    if ($this->getType() == "C") {
      return true;
    }  else {
      return false;
    }
  }

  /**
   * @return a PDF Invoice in binary format.
   */
  public function getBinaryPDFInvoice() {
    $r = $this->getPdfInvoice();
    if (! is_null($r)) {
      // note: CLOB are managed in a special way from Symfony framework...
      //
      return $r->getContents();
    }
    return null;
  }

  /**
   * @return a PDF Invoice in binary format.
   */
  public function getBinaryPDFCallReport() {
    $r = $this->getPdfCallReport();
    if (! is_null($r)) {
      // note: CLOB are managed in a special way from Symfony framework...
      //
      return $r->getContents();
    }
    return null;
  }

  /**
   * @return the previous invoice sent to the same customer
   */
  public function getPreviousInvoice() {
     $c = new Criteria();
     $c->add(ArInvoicePeer::INVOICE_DATE, $this->getInvoiceDate(), Criteria::LESS_THAN);
     $c->add(ArInvoicePeer::AR_PARTY_ID, $this->getArPartyId());
     $c->addDescendingOrderByColumn(ArInvoicePeer::INVOICE_DATE);
     $c->setLimit(1);

     return ArInvoicePeer::doSelectOne($c);
  }

}
