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
/**
 * A rate assigning a cost or an income to every call.
 *
 * NOTE: every concrete rate method (subclass) must be also specified
 * in apps/myApp/config/app.yml:all:available: phpRates: [..]
 * in order to permit administrators to select it as rate method to use.
 *
 * NOTE: math calcs should be done using bcmath functions of PHP,
 * working on numbers represented as strings and with arbitrary precision.
 */
abstract class PhpRate {
  /**
   * Nr. of decimal places to use in money math.
   * It is the double of "currency_decimal_places" values
   * in configuration file.
   *
   * See bcscale function of PHP library.
   */
  static public function calcPrecision() {
    $p = sfConfig::get('app_currency_decimal_places');
    return $p * 2;
  }
  /**
   * @param $numberAsString the number to convert
   * @param $decimalSeparator the decimal separator symbol used inside $numberAsString
   * @return a number represented as a String with the correct "." decimal separator symbol,
   *         null if $numberAsString is not a number.
   */
  static public function convertToArbitraryPrecisionFloat($numberAsString, $decimalSeparator) {
    $s1 = trim($numberAsString);
    if ($decimalSeparator != '.') {
      $s2 = str_replace($decimalSeparator, '.', $s1);
    } else {
      $s2 = $s1;
    }
    if (is_numeric($s2)) {
      return $s2;
    } else {
      return null;
    }
  }
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
   * Test if the rate is applicable to this specific CDR.
   *
   * PhpRateEngine filter the rate according common fields like
   * ar_rate_gategory and customer/vendor, start/end date.
   * This method apply a filter on other fields like
   * channel/dstchannel/src/dst etc..
   *
   * @param $cdr
   * @return 0 if the rate is not applicable,
   *         1 or more if it is applicable.
   * If two or more rates of the same type
   * are applicable to the same CDR, then
   * the rate with the maximum fitness
   * is selected.
   * The rates must be of the same type
   * and there can not be two equal fitness
   * values.
   */
  public abstract function isApplicable(Cdr $cdr);
  /**
   * The cost of the call.
   *
   * @precondition: isApplicable($cdr) == true
   * @param $cdr
   *
   * @return a String with the cost of call,
   * computed with arbitrary precision mathematics via BCMath functions,
   * and with a bcscale factor of PhpRate::bcscale
   */
  public abstract function getCallCost(Cdr $cdr);
  /**
   * @param $cost a cost like "12.345"
   * @return something like "12.3450" respecting the number of decimal places
   * used in computations.
   */
  public static function formatCostAccordingCurrency($cost) {
    $money = PhpRateEngine::convertToDbMoney($cost);
    return format_according_locale($money);
  }
  /**
   * @param $rate the rate to edit
   * @return the HTML code to insert in the edit form.
   *
   * NOTE: the HTML code is inserted inside a HTML Form already
   * created from the framework.
   *
   * NOTE: 'rate_id' input_hidden_tag is reserved from the framework.
   * NOTE: 'php_rate_class_name' input_hidden_tag is reserved from the framework.
   */
  abstract public function getHTMLForEditForm(ArRate $rate);
  /**
   * Read the result of form processing (@getHTMLForEditForm)
   * using it to setup its fields.
   *
   * The object is saved on the database from the framework,
   * so this method must only update $this object fields.
   *
   * @return true if the processing is ok, false if there were an error.
   *
   * Errors can be reported using
   *
   * > sfContext::getInstance()->getRequest()->setError('name', 'description');
   *
   */
  abstract public function initAccordingEditForm(ArRate $arRate);
}
?>