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
 * @return the root directory where Asterisell is installed.
 */
function getAsterisellRootDirectory() {
    return sfConfig::get('sf_root_dir');
}  

/**
 * @return TRUE if configuratiohn "safe_limit_for_concurrent_calls" is equal to "30",
 * FALSE if it is equal to "m".
 */
function isCostLimitTimeFrame30Days() {
    if (trim(sfConfig::get('app_max_cost_limit_timeframe')) === 'm') {
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
 * @param dateStr a date formatted according the current Symfony application locale/culture
 * @return a unix timestamp, or NULL if $dateStr is not a valid date
 */
function fromSymfonyTimestampToUnixTimestamp($dateStr) {

    $context = sfContext::getInstance();

    $culture = $context->getUser()->getCulture();

    return $context->getI18N()->getTimestampForCulture($dateStr, $culture);
}

/**
 * @param $d a date in unix timestamp numeric format
 * @return a date string formatted according current Symfony locale/culture setting
 */
function fromUnixTimestampToSymfonyStrDate($d) {
    return format_date($d, 's');
}

/**
 * @param $d a date in unix timestamp numeric format
 * @return a date string formatted according current Symfony locale/culture setting
 */
function fromUnixTimestampToSymfonyStrTimestamp($d) {
    return format_date($d, 's');
}

/**
 * Note: there is difference between a MySQL timestamp (date + time),
 * and a date.
 *
 * @param  $d a unix timestamp
 * @return string in Y-m-d format recognized from MySQL.
 *
 */
function fromUnixTimestampToMySQLDate($d) {
    return date('Y-m-d', $d);
}

/**
 * Note: there is difference between a MySQL timestamp (date + time),
 * and a date.
 *
 * @param  $d a unix timestamp
 * @return a timestamp in a format recognized from MySQL.
 *
 */
function fromUnixTimestampToMySQLTimestamp($d) {
    return date('Y-m-d H:i:s', $d);
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
    if (!is_null($b)) {
        if (strlen(trim($b)) > 0) {
            return $a . $b . $c;
        }
    }
    return "";
}

/**
 * @return the number of lines inside the string.
 */
function number_of_lines($s) {
    $lines = explode("\n", $s);
    $c = count($lines);

    if ($c > 0) {
        // if the last line is an empty line, then remove it from the count of lines...
        //
    $l = $lines[$c - 1];
        if (strlen(trim($l)) == 0) {
            $c = $c - 1;
        }
    }
    return $c + 1;
}

function format_zip_city_address($zipCode, $city, $stateProvince, $country) {
    $culture = sfConfig::get('app_culture');
    if ($culture === "it_IT") {
        return $zipCode . " " . $city . maybeAdd(" (", $stateProvince, ")") . maybeAdd(" - ", $country, "");
    } else {
        return $city . "\n" . maybeAdd("", $stateProvince, "\n") . $zipCode . maybeAdd("\n", $country, "");
    }
}

/**
 * @return seconds with microsecond resolution
 */
function microtime_float() {
    list($usec, $sec) = explode(" ", microtime());
    return ((float) $usec + (float) $sec);
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
 * Similar to standard PHP function `str_getcsv`.
 * I'm not using it, because it is shipped only with PHP >= 5.3.0
 * 
 * @param type $input
 * @param type $delimiter
 * @param type $enclosure
 * @param type $escape
 * @return type 
 */
function csv2array($input,$delimiter=',',$enclosure='"',$escape='\\'){ 
    $fields=explode($enclosure.$delimiter.$enclosure,substr($input,1,-1)); 
    foreach ($fields as $key=>$value) {
        $fields[$key]=str_replace($escape.$enclosure,$enclosure,$value); 
    }
    return($fields); 
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

function from_php_decimal_to_pdf_txt_decimal($value) {
    return get_currency_ascii_char() . from_php_decimal_to_invoice_decimal($value);
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
    return number_format($moneyStr, $sourcePrecision, '', '');
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

// taken from http://stackoverflow.com/questions/231057/how-to-round-ceil-floor-a-bcmath-number-in-php/231171#231171
function bcFloor($x)
{
    $result = bcmul($x, '1', 0);
    if ((bccomp($result, '0', 0) == -1) && bccomp($x, $result, 1))
        $result = bcsub($result, 1, 0);

    return $result;
}

function bcCeil($x)
{
    $floor = bcFloor($x);
    return bcadd($floor, ceil(bcsub($x, $floor)), 0);
}

function bcRound($x)
{
    $floor = bcFloor($x);
    return bcadd($floor, round(bcsub($x, $floor)), 0);
}

/**
 * @param  $totIncome a number in db_decimal format
 * @param  $vatPerc the vat perc in PHP decimal format
 * @return list($totalVat, $totalWithVat) in db_decimal format, with the precision needed for invoices
 */
function invoice_amount_with_vat($totIncome, $vatPerc) {
    $totIncome = round_db_decimal_according_invoice_decimal($totIncome);
    $totalVat1 = bcmul($totIncome, $vatPerc, 0);
    $totalVat = round_db_decimal_according_invoice_decimal(bcdiv($totalVat1, 100, 0));
    $totalWithVat = round_db_decimal_according_invoice_decimal(bcadd($totIncome, $totalVat, 0));

    return array($totalVat, $totalWithVat);
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
    for ($i = 0; $i < $n; $i++) {
        $w .= filterCharForSQLQuery(substr($str, $i, 1));
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

function areAllValidCharacters($str) {
  for ($i = 0, $j = strlen($str); $i < $j; $i++) {
    if (filterCharForSQLQuery($str[$i]) === "") {
      return FALSE;
    }
  }
  return TRUE;
}

/**
 * A string with '\n' and other special characters, substituted with new lines.
 */
function from_user_string_to_php_string($str) {
    return str_replace("\\n", "\n", $str);
}

/**
 * @param string $urlPath a path to a file, reachable from the current web-server.
 * It is typically the value returned from `insert_asset _tag` function.
 *
 * @return a path to the same file inside the file system, or null if it is not specified, or the files does not exists
 */
function uploadedImageFilePath($urlPath) {
    if (is_null($urlPath)) {
        return null;
    }

    if (strlen(trim($urlPath)) == 0) {
        return null;
    }

    $base = sfConfig::get('app_sfMediaLibrary_upload_dir');

    $path = strstr(trim($urlPath), $base);

    $file = sfConfig::get('sf_web_dir') . '/' . $path;

    if (file_exists($file)) {
        return $file;
    } else {
        return null;
    }
}

/**
 * Convert a string like "#(hex_red)(hex_green)(hex_blue) to an array with r,g,b integer values.
 *
 * @return NULL if format is not correct
 */
function html2rgb($color) {


    if (is_null($color)) {
        return null;
    }

    $color = trim($color);

    if (strlen($color) == 0) {
        return null;
    }

    if ($color[0] === '#')
        $color = substr($color, 1);

    if (strlen($color) == 6)
        list($r, $g, $b) = array($color[0] . $color[1],
            $color[2] . $color[3],
            $color[4] . $color[5]);
    elseif (strlen($color) == 3)
        list($r, $g, $b) = array($color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2]);
    else
        return null;

    $r = hexdec($r);
    $g = hexdec($g);
    $b = hexdec($b);

    return array($r, $g, $b);
}

/**
 * Test if $prefix is prefix of $number in case insensitive mode.
 *
 * @return true if $prefix is a prefix of $number, false otherwise.
 */
function isPrefixOf($prefix, $number) {
    $prefix = trim($prefix);
    $prefixLen = strlen($prefix);

    if ($prefixLen == 0) {
        return true;
    }

    if (substr_compare($prefix, $number, 0, $prefixLen, TRUE) == 0) {
        return true;
    } else {
        return false;
    }
}

/**
 *
 * @param type $filters
 * @param type $index 
 * @return null if the filter is not selected. Its value otherwise.
 */
function filterValue($filters, $index) {
    $r = NULL;
    if (isset($filters[$index])
            && (!is_null($filters[$index]))
            && (strlen(trim($filters[$index])) != 0)
            && ($filters[$index] != -1)) {
        $r = $filters[$index];
    }

    return $r;
}

/**
 * Reset the cost of the calls in the timeframe.
 * The resetted CDR will be signaled as to re-export again.
 * CDR exported again will replace old exported CDR.
 *
 * @param $fromDate a from date (inclusive) in unix-time-stamp format
 * @param $toDate a to date (exclusive) in unix-timestamp format,
 *        or NULL for resetting all calls after $fromDate
 *
 * Signal the operation (or the errors) on the problem-table.
 *
 */
function resetCallsCostInTimeFrame($fromDate, $toDate)
{
    $setToUnprocessed = "UPDATE cdr FORCE INDEX (cdr_calldate_index) SET destination_type = " . DestinationType::unprocessed
                        . ", is_exported = 0 "
                        . " WHERE calldate >= \"" . fromUnixTimestampToMySQLTimestamp($fromDate) . "\"";


    if (is_null($toDate)) {
    } else {
        $setToUnprocessed .= " AND calldate < \"" . fromUnixTimestampToMySQLTimestamp($toDate) . "\"";
    }

    $conn = Propel::getConnection();
    $nr1 = $conn->executeUpdate($setToUnprocessed);

    $p = new ArProblem();
    $p->setDuplicationKey("Reset of calls at " . date('c'));
    $p->setDescription("The administrator reset (and forced recalculations) of " . $nr1 . " calls (physical and merged calls), using query " . $setToUnprocessed . ", and query " . $removeMergedCDRs);
    $p->setEffect("This in not an error, only an informative message. The calls were rerated under this PHP process. If there is a timeout, then the rest of calls will be rated at next execution of cron process. User will not see unrated calls, in the meantime. ");
    $p->setProposedSolution("");
    ArProblemException::addProblemIntoDBOnlyIfNew($p);
}

/**
 * Reset the cost of the calls in the timeframe, and recalc costs.
 * The resetted CDR will be signaled as to re-export again.
 * CDR exported again will replace old exported CDR.
 *
 * @param $fromDate a from date (inclusive) in unix-time-stamp format
 * @param $toDate a to date (exclusive) in unix-timestamp format,
 *        or NULL for resetting all calls after $fromDate
 *
 * Signal the operation (or the errors) on the problem-table.
 *
 */
function resetCallsCostInTimeFrameAndRecalc($fromDate, $toDate)
{

    resetCallsCostInTimeFrame($fromDate, $toDate);

    // Rerate calls.
    //
    $re = new JobQueueProcessor();
    $re->processOnline();
}


/**
 * @return unix-timestamp of the max/last Cdr Call Date
 * NOTE: for sure this is a fast query that does not scan the table
 */
function getMaxCdrCallDate() {
    $connection = Propel::getConnection();
    $stm = $connection->createStatement();
    $rs = $stm->executeQuery('SELECT calldate FROM cdr force index (cdr_calldate_index) order by calldate desc limit 1');
    while ($rs->next()) {
        $r = $rs->getTimestamp('calldate');
    }

    return strtotime($r);
}


?>
