<?php

/**
 * Subclass for performing query and update operations on the 'ar_payment' table.
 */
class ArPaymentPeer extends BaseArPaymentPeer
{

  /**
   * @static
   * @param ArInvoice $invoice
   * @return the total payed for the specified invoice
   */
  public static function payedAmount(ArInvoice $invoice) {
    $c = new Criteria();
    $c->add(ArPaymentPeer::AR_PARTY_ID, $invoice->getArPartyId());
    $c->add(ArPaymentPeer::INVOICE_NR, $invoice->getNr());

    $c->clearSelectColumns();
    $c->addSelectColumn("SUM(" . ArPaymentPeer::AMOUNT . ")");

    $tot = 0;

    $rs = BasePeer::doSelect($c);
    while ($rs->next()) {
      $tot += $rs->getInt(1);
    }

    $rs->close();

    return $tot;
  }

}
