<?php

/* $LICENSE 2009, 2010:
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

sfLoader::loadHelpers(array('Asterisell'));

/**
 * A rate assignes a cost or an income to every call.
 *
 * NOTE: every concrete rate method (subclass) must be also specified
 * in apps/myApp/config/app.yml:all:available: phpRates: [..]
 * in order to permit administrators to select it in the user interface.
 *
 * NOTE: math calcs should be done using bcmath functions of PHP,
 * working on numbers represented as strings and with arbitrary precision.
 * You can use/study the phpRateOnlyCalc class.
 */
abstract class PhpRate {

  /**
   * Nr. of decimal places to use in money math.
   * It is the double of "currency_decimal_places" values
   * in configuration file.
   *
   * See bcscale function of PHP library.
   */
  public static function calcPrecision() {
    $p = sfConfig::get('app_currency_decimal_places');
    return $p * 2;
  }

  ////////////////////////////////////////////////////////////////////
  // Abstract functions that must be overridden from custom PhpRate //
  ////////////////////////////////////////////////////////////////////

  /**
   * @return TRUE if this Rate is applicable only to "unprocessed" CDRs.
   * This type of RATES are usually low-level system rates
   * used to classify CDRs before rating them.
   */
  public abstract function isForUnprocessedCDR();

  /**
   * Return a compact description in html
   * of the rate details in order to display it on a list view.
   * The description must contains the details of the specific parameters,
   * for example something like:
   *
   * "EUR 0.10 on answer plus EUR 0.05/sec"
   */
  public abstract function getShortDescription();

  /**
   * Two rates return comparable priority numbers only if they have
   * the same priority method.
   *
   * @return a string describing the priority method
   */
  public function getPriorityMethod() {
    return "custom for " . get_class($this);
  }

  /**
   * Test if the rate is applicable to this specific CDR.
   *
   * The test must not include "isForUnprocessedCDR" conformance
   * because it is already checked from the framework.
   *
   * The RateCalls Job that is resposable to call this method
   * checks also other conformance conditions like the Cdr date,
   * its customer category and so on. All these checked fields
   * are however part of the Rate Record fields.
   *
   * @param $cdr
   * @param BundleRateIncrementalInfo $rateInfo
   * @return 0 if the rate is not applicable,
   *         1,2, 3... if it is applicable.
   * If two or more rates of the same type are applicable to the same CDR, then
   * the rate with the maximum fitness is selected.
   * The rates must be of the same type and there can not be two equal fitness
   * values.
   * Exception rates have major priority respect all other rates.
   * Bundle rates have major priority respect normal rates.
   *
   */
  public abstract function isApplicable($cdr, $rateInfo = null);
  
  /**
   * It must update all CDR fields (if it is the case)
   * except the COST-related fields, because they are update
   * from "processCDR" according this method result
   * (in order to factor-out income/cost differences).
   *
   * @require when possible CDR are rated according the $cdr->getCallDate()
   *
   * @ensure calculations are done using PHP bcmath library,
   * using PhpRate::calcPrecision().
   *
   * @param Cdr $cdr the CDR to process
   * @param BundleRateIncrementalInfo  $rateInfo the incremental rate info, when the rate is of type BundleRate
   * @return NULL if the Rate does not must change/update the COST (typical of CDR processing rates),
   * the proper cost otherwise.
   */
  protected abstract function rateCDR($cdr, $rateInfo = null);

  /**
   * @return the module name implementing the user-interface/form part
   * of ths PhpRate. This module must respect the template of "custom_demo_rate"
   * module.
   */
  abstract public function getModuleName();

  /////////////////////////////////////////////////////////
  // Helper Functions used from the Asterisell framework //
  /////////////////////////////////////////////////////////

  /**
   * Return PhpRate associated to custom rate editor form.
   *
   * Initialize also VariableFrame values.
   *
   * Helper function used from the framework, do not modify it.
   *
   * @param $arRateId the id of the ArRate containing the PhpRate to edit.
   * @return the PhpRate, NULL if there are problems.
   */
  static public function initVariableFrameAndGetPhpRate($arRateId) {
    VariableFrame::$arRate = NULL;
    VariableFrame::$phpRate = NULL;

    $arRate = ArRatePeer::retrieveByPk($arRateId);

    if (is_null($arRate)) {
      return NULL;
    }

    VariableFrame::$arRate = $arRate;

    $phpRate = $arRate->unserializePhpRateMethod();

    if (is_null($phpRate)) {
      return NULL;
    }

    VariableFrame::$phpRate = $phpRate;

    return $phpRate;
  }

  /**
   * Process the CDR and eventually update the CDR cost/income related fields.
   * Update also the incremental info in case of Bundle Rate.
   *
   * @precondition: isApplicable($cdr) == true
   *
   * @param $cdr the $cdr to process
   * @param ArRate  $rate
   * @param PhpRate $phpRate
   * @param $arPartyId the id of customer or vendor
   * @param BundleRateIncrementalInfo  $bundleRateInfo null if it is not a bundle rate, the bundle rate incremental info otherwise
   * @param $isCost NULL if the rate is a isForUnprocessedCDR
   *                TRUE if rate must update the cost related fields,
   *                FALSE if the rate must update the income related fields.
   */
  public function processCDR($cdr, $rate, $phpRate, $arPartyId, $bundleRateInfo, $isCost) {
    $vStr = $this->rateCDR($cdr, $bundleRateInfo);
    if ((!is_null($isCost)) && (!is_null($vStr))) {
      $v = convertToDbMoney($vStr);
      if ($isCost) {
        $cdr->setCost($v);
        $cdr->setCostArRateId($rate->getId());
        $cdr->setVendorId($rate->getArPartyId());
      } else {
        $cdr->setIncome($v);
        $cdr->setIncomeArRateId($rate->getId());
      }
    }

    if ($phpRate instanceof BundleRate) {
      $phpRate->updateIncrementalInfo($rate->getId(), $phpRate->getPeriod(strtotime($cdr->getCalldate())), $cdr, $bundleRateInfo);
    }
  }

}
?>