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

}
