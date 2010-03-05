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
sfLoader::loadHelpers(array('Form', 'Number', 'Date'));
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
 * Format a date according the parameters of the configuration
 * file.
 */
function format_date_according_config($dateToFormat) {
  $format = sfConfig::get('app_date_format');
  return date($format, strtotime($dateToFormat));
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
 * Mask the last 3 characters of the string.
 */
function mask_dst($str1) {
  if (!is_null($str1)) {
    $str1 = trim($str1);
    $len = strlen($str1);
    if ($len > 3) {
      $str2 = substr($str1, 0, $len - 3) . "XXX";
    } else {
      $str2 = $str1;
    }
    return $str2;
  }
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
 * @return a string like "EUR 123,56" with the current locale number format.
 */
function format_for_locale($value) {
  $culture = sfConfig::get('app_culture');
  $currency = sfConfig::get('app_currency');
  if (is_null($value)) {
    return NULL;
  } else {
    $decimalPlaces = get_decimal_places_for_currency();
    $valuePadded = str_pad(trim($value), $decimalPlaces + 1, "0", STR_PAD_LEFT);
    $len = strlen($valuePadded);
    $pos = $len - $decimalPlaces;
    $valueWithDecimals = substr($valuePadded, 0, $pos) . "." . substr($valuePadded, $pos, $decimalPlaces);
    return format_currency($valueWithDecimals, $currency);
  }
}
/**
 * @param $value a number like "101234" where the last digits are the decimal part.
 * In this case can be a number like "10.1234" if get_decimal_places_for_currency == 4
 * @return a string like "123.56" without currency simbol but
 * with the correct number of decimal places
 */
function format_according_locale($value) {
  $culture = sfConfig::get('app_culture');
  $currency = sfConfig::get('app_currency');
  if (is_null($value)) {
    return "";
  } else {
    $decimalPlaces = get_decimal_places_for_currency();
    $valuePadded = str_pad($value, $decimalPlaces + 1, "0", STR_PAD_LEFT);
    $len = strlen($valuePadded);
    $pos = $len - $decimalPlaces;
    $valueWithDecimals = substr($valuePadded, 0, $pos) . "." . substr($valuePadded, $pos, $decimalPlaces);
    return format_number($valueWithDecimals, $culture);
  }
}
/**
 * @return a string like "1256E-4" in scientific notation in order
 * to produce unanbigous numbers.
 */
function format_according_csv_export_currency($value) {
  if (is_null($value)) {
    return NULL;
  } else {
    $decimalPlaces = get_decimal_places_for_currency();
    return $value . 'E-' . $decimalPlaces;
  }
}
/**
 * @param $value a monetary value without explicit decimal but with
 * implicit get_decimal_places_for_currency() decimals.
 *
 * @return a string like "EUR 123,56" with EUR in text form
 * and the monetary value in the culture format.
 */
function format_for_txt_locale($value) {
  $culture = sfConfig::get('app_culture');
  $currency = sfConfig::get('app_currency');
  $valueWithDecimals = format_according_locale($value);
  $decimalPlaces = sfConfig::get('app_currency_decimal_places_in_invoices');
  $valueRounded = round($valueWithDecimals, $decimalPlaces);
  $r = format_number($valueRounded, $culture);
  return sfConfig::get('app_currency') . ' ' . $r;
}
?>