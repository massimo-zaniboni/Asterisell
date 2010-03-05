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
 * Manage creation of invoices.
 */
class BillEngine {
  /**
   * Generate invoices.
   * It can work on a set of calls or on a specific invoice.
   *
   * @param $ar_invoice_creation null or all the invoices to generate
   * @param $ar_invoice null if generate a bill for every customer,
   *        otherwise the invoice to regenerate
   * @return array(the number of generated invoices, isAllOk),
   * in case of errors they are added to the Problems table.
   */
  public function bill($ar_invoice_creation, $ar_invoice) {
    $eol = "\r\n";
    // Save the user culture
    //
    $originalUserCulture = sfContext::getInstance()->getUser()->getCulture();
    // Init vars
    //
    $time1 = microtime_float();
    $nrOfInvoices = 0;
    $allOk = TRUE;
    if (is_null($ar_invoice)) {
      $actionName = 'Invoices creation';
      $nr = $ar_invoice_creation->getFirstNr();
      $invoiceDate = $ar_invoice_creation->getInvoiceDate();
      $arCdrFrom = $ar_invoice_creation->getArCdrFrom();
      $arCdrTo = $ar_invoice_creation->getArCdrTo();
    } else {
      $actionName = 'Emails sending';
      $nr = $ar_invoice->getNr();
      $invoiceDate = $ar_invoice->getInvoiceDate();
      $arCdrFrom = $ar_invoice->getArCdrFrom();
      $arCdrTo = $ar_invoice->getArCdrTo();
    }
    // Select the CDRs with the proper call date
    //
    $startCriteria = new Criteria();
    $crit = $startCriteria->getNewCriterion(CdrPeer::CALLDATE, $arCdrFrom, Criteria::GREATER_EQUAL);
    $crit->addAnd($startCriteria->getNewCriterion(CdrPeer::CALLDATE, $arCdrTo, Criteria::LESS_THAN));
    $startCriteria->add($crit);
    // Rate all unrated CDRs
    //
    $rateEngine = new PhpRateEngine();
    $rateEngine->rateCalls($startCriteria);
    // Generate an invoice for every Party
    //
    // NOTE: the join on INCOME_AR_RATE_ID permits to select only CDRs
    // wich are rated.
    //
    $c = clone ($startCriteria);
    $c->clearSelectColumns();
    $c->addSelectColumn(ArPartyPeer::ID);
    $c->addSelectColumn('COUNT(' . CdrPeer::ID . ')');
    $c->addSelectColumn('SUM(' . CdrPeer::BILLSEC . ')');
    $c->addSelectColumn('SUM(' . CdrPeer::INCOME . ')');
    $c->addSelectColumn(ArTelephonePrefixPeer::GEOGRAPHIC_LOCATION);
    $c->addSelectColumn(ArTelephonePrefixPeer::OPERATOR_TYPE);
    $index_party = 1;
    $index_count = 2;
    $index_billSec = 3;
    $index_income = 4;
    $index_geographic_location = 5;
    $index_operator_type = 6;
    $c->addJoin(CdrPeer::ACCOUNTCODE, ArAsteriskAccountPeer::ACCOUNT_CODE);
    $c->addJoin(ArAsteriskAccountPeer::AR_PARTY_ID, ArPartyPeer::ID);
    $c->addJoin(CdrPeer::AR_TELEPHONE_PREFIX_ID, ArTelephonePrefixPeer::ID);
    $c->addGroupByColumn(ArPartyPeer::ID);
    $c->addGroupByColumn(ArTelephonePrefixPeer::GEOGRAPHIC_LOCATION);
    $c->addGroupByColumn(ArTelephonePrefixPeer::OPERATOR_TYPE);
    if (!is_null($ar_invoice)) {
      $c->add(ArPartyPeer::ID, $ar_invoice->getArPartyId());
    }
    $ri = BasePeer::doSelect($c);
    $isThereNextPartyId = $ri->next();
    while ($isThereNextPartyId) {
      // Global invoice info
      //
      $partyId = $ri->get($index_party);
      $party = ArPartyPeer::retrieveByPK($partyId);
      $totCalls = 0;
      $totSeconds = 0;
      $totIncome = 0;
      // NOTE: up to date I have not found a method to force
      // the i18N helper __('') to use a particular culture
      // (in this case the culture of the party receiving the invoice)
      // so I force the global culture... a very dangerous things
      // if there is an exception and the program exit this loop
      // before the restore section...
      //
      $partyCulture = sfConfig::get('app_culture');
      sfContext::getInstance()->getUser()->setCulture($partyCulture);
      $decimalPlaces = get_decimal_places_for_currency();
      $htmlInvoiceLines = '<table border="1"><tr>' . '<th> </th>' . '<th>' . __('Calls') . '</th>' . '<th>' . __('Minutes') . '</th>' . '<th>' . __('Amount') . '</th>' . '</tr>';
      $txtInvoiceLines = __('Calls') . "\t" . __('Minutes') . "\t\t\t" . __('Amount') . $eol;
      // Generate a line for each detail
      //
      $isThereNextDetail = true;
      while ($isThereNextDetail) {
        try {
          $partialCalls = $ri->get($index_count);
          $partialSec = $ri->get($index_billSec);
          $partialIncome = $ri->get($index_income);
          $partialGeographicLocation = $ri->get($index_geographic_location);
          $partialOperatorType = $ri->get($index_operator_type);
          $totCalls+= $partialCalls;
          $totSeconds+= $partialSec;
          $totIncome+= $partialIncome;
          if (sfConfig::get('app_bills_with_partial_totals') == true) {
            $descr = ArTelephonePrefix::calcDescriptiveName($partialOperatorType, $partialGeographicLocation, null);
            $htmlInvoiceLines.= '<tr>' . '<td>' . $descr . '</td>' . '<td>' . $partialCalls . '</td>' . '<td>' . format_minute($partialSec) . '</td>' . '<td>' . format_for_locale($partialIncome) . '</td>' . '</tr>';
            $txtInvoiceLines.= $this->tabFormat($descr, 3) . $this->tabFormat($partialCalls, 1) . $this->tabFormat(format_minute($partialSec), 3) . $this->tabFormat(format_for_txt_locale($partialIncome), 1) . $eol;
          }
          $isThereNextPartyId = $ri->next();
          if (!$isThereNextPartyId) {
            $isThereNextDetail = false;
          } else {
            if ($ri->get($index_party) != $partyId) {
              $isThereNextDetail = false;
            } else {
              $isThereNextDetail = true;
            }
          }
          if (!$isThereNextDetail) {
            // Generate a line for the totals
            //
            $htmlInvoiceLines.= '<tr>' . '<td>' . __('Totals') . '</td>' . '<td>' . $totCalls . '</td>' . '<td>' . format_minute($totSeconds) . '</td>' . '<td>' . format_for_locale($totIncome) . '</td>' . '</tr>';
            $htmlInvoiceLines.= '</table>';
            $txtInvoiceLines.= $this->tabFormat("", 3) . $this->tabFormat($totCalls, 1) . $this->tabFormat(format_minute($totSeconds), 3) . $this->tabFormat(format_for_txt_locale($totIncome), 1) . $eol;
            // Retrieve or create the invoice with the given nr.
            //
            $c3 = new Criteria();
            $c3->add(ArInvoicePeer::NR, $nr);
            $findInvoiceRS = ArInvoicePeer::doSelect($c3);
            $invoice = null;
            foreach($findInvoiceRS as $invF) {
              if (is_null($invoice)) {
                $invoice = $invF;
              } else {
                $p = new ArProblem();
                $p->setDuplicationKey('Invoice with repeated nr ' . $nr);
                $p->setDescription('During ' . $actionName . ' were found two or more invoices with nr ' . $nr);
                $p->setProposedSolution('Correct the Invoice nr. and rexecute the action');
                throw (new ArProblemException($p));
              }
            }
            if (is_null($invoice)) {
              $invoice = new ArInvoice();
            }
            // Save the invoice
            //
            $invoice->setArPartyId($partyId);
            $invoice->setAlreadySent(false);
            $invoice->setNr($nr);
            $invoice->setInvoiceDate($invoiceDate);
            $invoice->setArCdrFrom($arCdrFrom);
            $invoice->setArCdrTo($arCdrTo);
            $vatPerc = sfConfig::get('app_vat_perc');
            $totalVat1 = bcmul($totIncome, $vatPerc, 0);
            $totalVat = bcdiv($totalVat1, 100, 0);
            $totalWithVat = bcadd($totIncome, $totalVat, 0);
            $invoice->setVatPerc(PhpRateEngine::convertToDbMoney($vatPerc));
            $invoice->setTotalWithoutTax($totIncome);
            $invoice->setTotalVat($totalVat);
            $invoice->setTotal($totalWithVat);
            $invoice->setHtmlDetails($htmlInvoiceLines);
            $invoice->setTxtDetails($txtInvoiceLines);
            $invoice->save();
            $nrOfInvoices++;
            $nr++;
          }
        }
        catch(ArProblemException $e) {
          $isThereNextDetail = false;
          $allOk = FALSE;
          $e->addThisProblemIntoDBOnlyIfNew();
        }
        catch(Exception $e) {
          $isThereNextDetail = false;
          $allOk = FALSE;
          $p = new ArProblem();
          $p->setDuplicationKey($e->getCode());
          $p->setDescription('During ' . $actionName . ' error: ' . $e->getCode() . ' - ' . $e->getMessage());
          ArProblemException::addProblemIntoDBOnlyIfNew($p);
        }
      }
    } // $isThereNextPartyId
    // Replace the user culture
    //
    sfContext::getInstance()->getUser()->setCulture($originalUserCulture);
    //  Show the speed of invoice creation
    //
    if ($nrOfInvoices > 0) {
      $time2 = microtime_float();
      $meanTime = (($time2 - $time1) / $nrOfInvoices);
      $rateForSecond = 1 / $meanTime;
      log_message("Invoices Generated: " . $nrOfInvoices, 'debug');
      log_message("Tot Seconds: " . ($time2 - $time1), 'debug');
      log_message("Mean time for invoice creation: " . $meanTime, 'debug');
    }
    return array($nrOfInvoices, $allOk);
  }
  /**
   * Return the string with a number of tabs characters according
   * to a lenght of $nrOfTabs * 8
   */
  protected function tabFormat($str1, $nrOfTabs) {
    $l = strlen($str1);
    $maxLen = $nrOfTabs * 8;
    $remainingLen = $maxLen - $l;
    $remainingTabs = floor($remainingLen / 8);
    return $str1 . str_repeat("\t", $remainingTabs + 1);
  }
  /**
   * Send the email to the customer only if it has a valid address.
   * Set the AlreadySent field to TRUE if the email was sent correctly.
   *
   * @return true if the invoice was sent, false otherwise
   */
  static public function sendEmailNow($invoice) {
    $party = $invoice->getArParty();
    $mailAddress = $party->getEmail();
    if ((!is_null($mailAddress)) && (strlen(trim($mailAddress)) > 0)) {
      $party = $invoice->getArParty();
      $mailGenName = sfConfig::get('app_email_with_invoice_generator');
      $mailGen = new $mailGenName();
      list($subject, $message) = $mailGen->getEmailContent($party, $invoice);
      $headers = 'From: ' . sfConfig::get('app_service_provider_mail') . " \r\n";
      log_message('SEND MAIL TO: ' . $mailAddress . ' with subject ' . $subject . ' with message: ' . $message, 'debug');
      $result = mail($mailAddress, $subject, $message, $headers);
      if ($result) {
        $invoice->setAlreadySent(true);
        $invoice->save();
      }
      return $result;
    } else {
      return false;
    }
  }
}
