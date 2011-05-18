<?php

/* $LICENSE 2010, 2011:
 *
 * Copyright (C) 2009, 2010 Massimo Zaniboni <massimo.zaniboni@profitoss.com>
 *
 * This file is part of Asterisell.
 *
 * Asterisell is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * Asterisell is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Asterisell. If not, see <http://www.gnu.org/licenses/>.
 * $
 */

sfLoader::loadHelpers(array('I18N', 'Debug', 'Date', 'Number', 'Debug'));

/**
 * This rate performs the initial classification of a CDR,
 * according customer needs. It is only a template. It must be customized.
 *
 * It works assuming that the configuration inside `apps/asterisell/config/app.yml`
 * `internal_external_telephone_numbers` is set to 3. According the notes on app.yml, these fields must be completed:
 *    - `cdr.ar_asterisk_account_id` (null if it is missing, and RateProcess will inform the user of the error);
 *    - `cdr.cached_internal_telephone_number`;
 *    - `cdr.cached_external_telephone_number`;
 *    - `cdr.cached_masked_external_telephone_number`, can be null (it is completed from the framework), or with an explicit value
 *    - `cdr.ar_telephone_prefix.id` can be null (it is completed from the framework),
 *       or with an explicit value, in this case number portability is not automatically transferred to the telephone prefix,
 *       and it must be explicitely managed from the CDR processor;
 */
abstract class CustomCDRProcessing extends PhpRate {

  /**
   * Rate a CDR using the services of `parseTelephoneNumber`.
   *
   * It must call `signalProblem` in case of problems.\
   *
   * @param $cdr the Cdr to process
   * @param $rateInfo do not use
   *
   * @return null if the processing was effective,
   *         thrown an exception in case of error in the CDR format
   */
  protected function rateCDR($cdr, $rateInfo = null) {
    $this->signalProblem($cdr, "rateCDR method is not implemented");
  }

  /**
   * Put special calls prefixes on the telephone prefix table.
   */
  static public function createSpecialPrefixTable() {
    //  The first 100 telephone prefixes are considered special system prefixes.
    //  I write them on the table
    // NOTE:  I do not delete because there can be relational integrity constraints on the database
    //
    self::insertTelephonePrefix(self::CLASSIFY_AS_LOCAL, "Local Calls", "Local", "Local");
    self::insertTelephonePrefix(self::CLASSIFY_AS_NATIONAL, "National Calls", "National", "National");
    self::insertTelephonePrefix(self::CLASSIFY_AS_MOBILE, "Mobile Calls", "Mobile", "Mobile - National");
    self::insertTelephonePrefix(self::CLASSIFY_AS_ON_NET, "On-Net Calls", "On-Net", "On-Net");
    self::insertTelephonePrefix(self::CLASSIFY_AS_1300, "1300 Calls", "1300", "1300");
    self::insertTelephonePrefix(self::CLASSIFY_AS_13, "13* Calls", "13*", "13*");
    self::insertTelephonePrefix(self::CLASSIFY_AS_1800, "1800 Free Calls", "1800", "1800");
    self::insertTelephonePrefix(self::CLASSIFY_AS_1223, "1223 National Directory Assistance", "1223 National Directory Assistance", "1223 National Directory Assistance");
    self::insertTelephonePrefix(self::CLASSIFY_AS_122, "122 Internatioanl Directory Assistance", "122 Internatioanl Directory Assistance", "122 Internatioanl Directory Assistance");

    // I force all other default prefixes starting from 100
    self::insertTelephonePrefix(self::LAST_CLASSIFY_ID, "", "", "");
  }

  ///////////////////////
  // SUPPORT FUNCTIONS //
  ///////////////////////

  /**
   * Call this method for stopping the single CDR processing, signaling a problem in the error table.
   *
   * @param <type> $cdr
   * @param <type> $message
   */
  protected function signalProblem($cdr, $message) {
      $id = $cdr->getId();
      $p = new ArProblem();
      $p->setDuplicationKey("system processing rate $id");
      $p->setDescription(get_class($this) . " is not able to process CDR.id = " . $id . ". " . $message);
      $p->setCreatedAt(date("c"));
      $p->setEffect("The CDR with the same problem will be not rated.");
      $p->setProposedSolution("Improve the rate method " . get_class($this) . " source code, in order to support also these type of CDRs.");
      throw (new ArProblemException($p));
  }

  protected function linkToArAsteriskAccount($cdr, $accountcode) {
    $account = VariableFrame::getArAsteriskAccountByCodeCache()->getArAsteriskAccountByCode($accountcode);
    if (is_null($account)) {
      $p = new ArProblem();
      $p->setDuplicationKey("unknown ArAsteriskAccount $accountcode");
      $p->setCreatedAt(date("c"));
      $p->setDescription("\"$accountcode\" Asterisk account code is used in CDR with id \"" . $cdr->getId() . "\", but it is not defined in ArAsteriskAccount table (VoIP Accounts).");
      $p->setEffect("All CDRs with this account will not rated.");
      $p->setProposedSolution("Complete the Asterisk Account table (VoIP accounts). The CDRs will be rated automatically at the next execution pass of Jobs.");
      throw (new ArProblemException($p));
    }
    $cdr->setArAsteriskAccountId($account->getId());
  }

  protected function throwErrorOnTelephonePrefixId($dstNumber) {
    // prepare a missing prefix key: it is a balance between displaying many errors for missing number prefix,
    // and avoid displaying all missing telephone numbers.
    //
    $maxLen = strlen($dstNumber);
    if ($maxLen >= 6) {
      $maxLen = 6;
    }
    $missingPrefix = substr($dstNumber, 0, $maxLen);

    $p = new ArProblem();
    $p->setDuplicationKey("no telephone operator prefix " . $missingPrefix);
    $p->setCreatedAt(date("c"));
    $p->setDescription('There is no a telephone operator prefix entry associated to the destination number ' . $dstNumber);
    $p->setEffect("CDRs with destination number of the same type will not be rated.");
    $p->setProposedSolution("Complete the Telephone Prefixes Table. If you are not interested to classification of calls according their operator, then you can also add an Empty Prefix matching all destination numbers and calling it None.");
    throw (new ArProblemException($p));
  }

  public function isForUnprocessedCDR() {
    return true;
  }

  public function getShortDescription() {
    $r = 'Initial CDR processing according class ' . get_class($this);
    return $r;
  }

  public function isApplicable($cdr, $rateInfo = null) {
    return 1;
  }

  public function getModuleName() {
    return "rate_based_on_phpcode";
  }

}

?>
