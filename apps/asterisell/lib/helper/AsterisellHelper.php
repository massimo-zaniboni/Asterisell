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

sfLoader::loadHelpers(array('Form', 'Number', 'Date'));

/**
 * @return TRUE if configuratiohn "safe_limit_for_concurrent_calls" is equal to "30",
 * FALSE if it is equal to "m".
 */
function isCostLimitTimeFrame30Days() {
  if (trim(sfConfig::get('app_max_cost_limit_timeframe')) == 'm') {
    return FALSE;
  } else {
    return TRUE;
  }
}

function getConcurrentCallsSafeLimit() {
  return sfConfig::get('app_safe_limit_for_concurrent_calls');
}

/**
 * @param dateStr a date formatted according the current Symfony application locale/culture
 * @return a unix timestamp, or NULL if $dateStr is not a valid date
 */
function fromSymfonyDateToUnixTimestamp($dateStr) {

  $context = sfContext::getInstance();

  $culture = $context->getUser()->getCulture();
  
  $dmy = $context->getI18N()->getDateForCulture($dateStr, $culture);

  if (is_null($dmy)) {
    return NULL;
  }

  list($d, $m, $y) = $dmy;

  if (!checkdate($m, $d, $y)) {
    return NULL;
  }
 
  return strtotime("$y-$m-$d 00:00");
}

/**
 * @param $d a date in unix timestamp numeric format
 * @return a date string formatted according current Symfony locale/culture setting
 */
function fromUnixTimestampToSymfonyStrDate($d) {
  return format_date($d, 's');
}

function fromUnixTimestampToMySQLDate($d) {
  return date('Y-m-d', $d);
}

/**
 * @return Number of days between two date in timestamp format.
 */
function getDaysBetween($timestamp1, $timestamp2) {
  $delta = $timestamp2 - $timestamp1;
  return round(($delta / 86400), 0);
}

/**
 * @return "$a . $b . $c" if $b is not null and it is not empty
 */
function maybeAdd($a, $b, $c) {
  if (! is_null($b)) {
    if (strlen(trim($b)) > 0) {
      return $a . $b . $c;
    }
  }
  return "";
}

function format_zip_city_address($zipCode, $city, $stateProvince, $country) {
  return $zipCode . " " . $city . maybeAdd(" (", $stateProvince, ")") . maybeAdd(" - ", $country, "");
}

/**
 * @return seconds with microsecond resolution
 */
function microtime_float() {
  list($usec, $sec) = explode(" ", microtime());
  return ((float)$usec + (float)$sec);
}
/**
 * Format a date in universal format.
 * This is the format to use in debug message for the administrator.
 */
function format_date_for_debug_msg($dateToFormat) {
  if (is_null($dateToFormat)) {
    $d = time();
  } else {
    $d = $dateToFormat;
  }
  $dateStr = strftime("%Y/%m/%d", $d);
  return $dateStr;
}

/**
 * Format a date/timestamp in CALL REPORT 
 * according the parameters of the configuration file.
 */
function format_date_according_config($dateToFormat) {
  $format = sfConfig::get('app_date_format');
  return date($format, strtotime($dateToFormat));
}

/**
 * Format a date for INVOCES according the parameters 
 * of the configuration file.
 * 
 * @param $dateFormat a date in DB format
 */
function format_invoice_date_according_config($dateToFormat) {
  $format = sfConfig::get('app_invoice_date_format');
  return date($format, strtotime($dateToFormat));
}

/**
 * Format a date for INVOCES according the parameters 
 * of the configuration file.
 * 
 * @param $dateFormat a date in UNIX timestamp format
 */
function format_invoice_timestamp_according_config($dateToFormat) {
  $format = sfConfig::get('app_invoice_date_format');
  return date($format, $dateToFormat);
}

/**
 * Permit to select one of the app_available_cultures defined in
 * config/app.yml.
 */
function select_available_culture_tag($name, $culture) {
  $cultures = sfConfig::get('app_available_cultures');
  $pos = array_search($culture, $cultures);
  if ($pos == FALSE) {
    echo select_tag($name, options_for_select(array_values($cultures)));
  } else {
    echo select_tag($name, options_for_select(array_values($cultures), $pos));
  }
}
function select_customer_or_vendor_tag($name, $cv, $enableEmpty = false) {
  if ($enableEmpty) {
    $arr = array("" => "", "C" => __("Customer"), "V" => __("Vendor"));
  } else {
    $arr = array("C" => __("Customer"), "V" => __("Vendor"));
  }
  if (is_null($cv)) {
    echo select_tag($name, options_for_select($arr));
  } else {
    echo select_tag($name, options_for_select($arr, $cv));
  }
}
/**
 * @param $seconds time in seconds
 * @return a string with elapsed minutes and seconds
 */
function format_minute($seconds) {
  $min = floor($seconds / 60);
  $sec = $seconds - ($min * 60);
  $hour = floor($min / 60);
  $min = $min - ($hour * 60);
  if ($hour > 0) {
    return ($hour . 'h:' . $min . 'm:' . $sec . 's');
  } else if ($min > 0) {
    return ($min . 'm:' . $sec . 's');
  } else {
    return ($sec . 's');
  }
}

function csv_field($val, $isFirst) {
  if ($isFirst) {
    $r = "";
  } else {
    $r = ",";
  }
  $r = $r . '"' . $val . '"';
  return $r;
}


/**
 * The max precision (decimal places) of a currency.
 * This precision is used to store data inside CDR table
 * and during computations.
 */
function get_decimal_places_for_currency() {
  return sfConfig::get('app_currency_decimal_places');
}

/**
 * @param $value a number like "123456" where the last digits are decimal parts.
 * @return a string like "EUR 123,56" with the current locale number format.
 * The format string is in HTML format.
 */
function format_from_db_decimal_to_currency_locale($value) {
  return format_from_db_decimal_to_call_report_currency($value);
}

/**
 * $param $value a number like "123456" where the last digits are decimal parts.
 * @return a string like "EUR 123,56" with the current locale number format.
 * The format string is in HTML format.
 * The value round/truncation is done according the needs of CALL REPORT.
 */
function format_from_db_decimal_to_call_report_currency($value) {
  $decimalValue = from_db_decimal_to_invoice_decimal($value);

  $currency = sfConfig::get('app_currency');
  $culture = sfConfig::get('app_culture');
  return format_currency($decimalValue, $currency, $culture);
}

/**
 * @param $value a number like "123456" where the last digits are decimal parts.
 * @return a number like "12.3456" in case there 4 precision/decimal digits.
 */
function from_db_decimal_to_php_decimal($value) {
  if (is_null($value)) {
    return "0";
  }

  $decimalPlaces = get_decimal_places_for_currency();
  $scaleFactor = bcpow(10, $decimalPlaces);
  return bcdiv($value, $scaleFactor, $decimalPlaces);
}

/** 
 * Like `from_db_decimal_to_php_decimal` but eliminating
 * non necessary decimal digits. For example "19.5" instead of "19.5000"
 */
function from_db_decimal_to_smart_php_decimal($value) {
  $d = from_db_decimal_to_php_decimal($value);
  $d = $d + "0";
  return sprintf($d);
}

/**
 * @param $value a number like "12.3456" with an arbitrary number of precision digits.
 * @return a number like "12.35" with the "currency_decimal_places_in_invoices" 
 * number of precision digits.
 */
function from_php_decimal_to_invoice_decimal($value) {
  $l = sfConfig::get('app_currency_decimal_places_in_invoices');
  $decimalValue = round($value, $l);
  return sprintf("%." . $l . "F", $decimalValue);
}

/**
 * $param $value a number like "123456" where the last digits are decimal parts.
 * @return a php decimal value, rounded to the invoice precision digits.
 */
function from_db_decimal_to_invoice_decimal($value) {
  $value2 = from_db_decimal_to_php_decimal($value);
  return from_php_decimal_to_invoice_decimal($value2);
}

/**
 * $param $value a number like "123456" where the last digits are decimal parts.
 * @return a number in the same format, but rounded according invoice
 * required decimals.
 */
function round_db_decimal_according_invoice_decimal($value) {
  $value2 = from_db_decimal_to_invoice_decimal($value);
  return convertToDbMoney($value2);
}

/**
 * @param $value a number like "101234" where the last digits are the decimal part.
 * In this case can be a number like "10.1234" if get_decimal_places_for_currency == 4
 * @return a string like "123.56" without currency simbol but
 * with the correct number of decimal places. The number is formatted according locale/culture.
 */
function from_db_decimal_to_locale_decimal($value) {
  $culture = sfConfig::get('app_culture');
  return format_number(from_db_decimal_to_invoice_decimal($value), $culture);
}

/**
 * @param $value a number like "101234" where the last digits are the decimal part.
 * In this case can be a number like "10.1234" if get_decimal_places_for_currency == 4
 * @return a string like "123.567" without currency simbol but
 * with all the decimal digits and formatted according locale/culture.
 */
function from_db_decimal_to_locale_decimal_with_full_precision($value) {
  $culture = sfConfig::get('app_culture');
  return format_number(from_db_decimal_to_php_decimal($value), $culture);
}

/**
 * @return a string like "1256E-4" in scientific notation in order
 * to produce unanbigous numbers.
 */
function from_db_decimal_to_scientific_notation($value) {
  if (is_null($value)) {
    return NULL;
  } else {
    $decimalPlaces = get_decimal_places_for_currency();
    return $value . 'E-' . $decimalPlaces;
  }
}

/**
 * @param $value a VAT % with implicit get_decimal_places_for_currency() decimals.
 *
 * @return a number with the proper decimals, in the default culture format.
 */
function from_db_decimal_to_vat_perc_according_culture($value) {
  $culture = sfConfig::get('app_culture');

  $value = from_db_decimal_to_smart_php_decimal($value);
  return format_number($value, $culture);
}

/**
 * @param $value a monetary value without explicit decimal but with
 * implicit get_decimal_places_for_currency() decimals.
 * Sometinhg like "123456" for a number like "12.3456"  with 4 
 * decimal places.
 *
 * @return a string like "EUR 123,56" with EUR in text form
 * and the monetary value in the culture format.
 */
function from_db_decimal_to_monetary_txt_according_locale($value) {
  $currency = sfConfig::get('app_currency');
  return sfConfig::get('app_currency') . ' ' . from_db_decimal_to_locale_decimal($value);
}

/**
 * Return the ASCII char for the currency symbol.
 */
function get_currency_ascii_char() {
  return chr(sfConfig::get('app_currency_ascii_char'));
}

/**
 * @param $value a monetary value without explicit decimal but with
 * implicit get_decimal_places_for_currency() decimals.
 * Sometinhg like "123456" for a number like "12.3456"  with 4 
 * decimal places.
 *
 * @return a string like "$123,56" where "$" is the currency symbol.
 */
function from_db_decimal_to_pdf_txt_decimal($value) {
  return get_currency_ascii_char() . from_db_decimal_to_locale_decimal($value);
}

/**
 * @param $moneyStr a money value with decimals (something like "12.345")
 * @return a integer with the last digits implicitely associated to the decimal part
 * according the number of decimal places specified in config/app.yml for the currency.
 */
function convertToDbMoney($moneyStr) {
  $sourcePrecision = get_decimal_places_for_currency();
  return  number_format($moneyStr, $sourcePrecision, '', '');
}

/**
 * Synonimous for `convertToDbMoney`
 */
function from_php_decimal_to_db_decimal($v) {
  return convertToDbMoney($v);
}

/**
 * @param $cost a cost like "12.345"
 * @return an HTML representation of the cost, with the currency symbol.
 * NOTE: this function is used for representing Rate method, so it uses
 * all the precision and does not format according standard currency locales.
 * used in computations.
 */
function formatCostAccordingCurrency($cost) {
  $currencySymbol = sfConfig::get('app_currency');
  $culture = sfConfig::get('app_culture');
  $n = format_number($cost, $culture);
  return $currencySymbol . " " . $n;
}

/**
 * @param $numberAsString the number to convert
 * @param $decimalSeparator the decimal separator symbol used inside $numberAsString
 * @return a number represented as a String with the correct "." decimal separator symbol,
 *         null if $numberAsString is not a number.
 */
function convertToArbitraryPrecisionFloat($numberAsString, $decimalSeparator) {
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
 * Use an additional security layer for filtering user input data.
 * In theory this is not needed because Symfony uses already Creole
 * that performs this type of filtering before sending queries
 * to MySQL database.
 */
function filterStrForSQLQuery($str) {
  $n = strlen($str);
  $w = '';
  for ($i = 0;$i < $n;$i++) {
    $w.= filterCharForSQLQuery(substr($str, $i ,1));
  }
  return $w;
}

/**
 * @return ch1 if it is a number / alpha / "-" / "+" / "/" char,
 * "" otherwise
 */
function filterCharForSQLQuery($ch1) {
  $pos = strpos('0123456789 abcdefghijklmnopqrstuvzwxyABCDEFGHILMNOPQSTUVZKJWXY-+/:@', $ch1);
  if ($pos === false) {
    return '';
  } else {
    return $ch1;
  }
}


?>