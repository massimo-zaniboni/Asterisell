<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP version 5.0                                                      |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997, 1998, 1999, 2000, 2001, 2002, 2003 The PHP Group       |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Authors: Naoki Shima <murahachibu@php.net>                           |
// +----------------------------------------------------------------------+//
// $Id: Negotiator.php,v 1.4 2003/01/04 11:55:25 mj Exp $
//
// CHANGES
//
//  Massimo Zaniboni:
//    converted from PHP 4.0 to PHP 5.0
//    adapted to symfony framework

/**
 *
 * //instantiate Locale_Negotiator
 * $negotiator       = new I18N_Negotiator();
 *
 * //define which language[s] your site supports :: optional
 * $supportLangs     = array('fr','jp');
 *
 * //find first matched language
 * $lang             =  $negotiator->getLanguageMatch($supportedLangs);
 *
 * //define which countries your site supports :: optional
 * $supportCountries = array('gb','us');
 *
 * //find first matched Country
 * $countryCode      = $negotiator->getCountryMatch($lang,$supportCountries);
 *
 * echo 'Language Code: '.$lang.'
 * Language Name: '.$negotiator->getLanguageName($lang).'
 * Country Code: '.$countryCode.'
 * Country Name: '.$negotiator->getCountryName($countryCode);
 */
class I18N_Negotiator {
  // {{{ properties
  protected $_country;
  /**
   * Save default country code.
   *
   * @type  : string
   * @access: private
   */
  protected $_defaultCountry;
  /**
   * Save default language code.
   *
   * @type  : string
   * @access: private
   */
  protected $_defaultLanguage;
  /**
   * Save default charset code.
   *
   * @type  : string
   * @access: private
   */
  protected $_defaultCharset;
  // }}}
  // {{{ constructor
  
  /**
   * Find language code, country code, charset code, and dialect or variant
   * of Locale setting in user's browser from $HTTP_ACCEPT_LANGUAGE,
   * $LANGUAGE_ACCEPT_CHARSET
   *
   * @param : string   Default Language
   * @param : string   Default Charset
   * @param : string   Default Country
   */
  function I18N_Negotiator($defaultLanguage = "en", $defaultCharset = "ISO-8859-1", $defaultCountry = "") {
    if ($_SERVER) {
      $HTTP_ACCEPT_LANGUAGE = (in_array("HTTP_ACCEPT_LANGUAGE", array_keys($_SERVER))) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : "";
      $HTTP_ACCEPT_CHARSET = (in_array("HTTP_ACCEPT_CHARSET", array_keys($_SERVER))) ? $_SERVER['HTTP_ACCEPT_CHARSET'] : "";
    } else {
      global $HTTP_ACCEPT_LANGUAGE, $HTTP_ACCEPT_CHARSET;
    }
    $this->_defaultCountry = $defaultCountry;
    $this->_defaultLanguage = $defaultLanguage;
    $this->_defaultCharset = $defaultCharset;
    $langs = explode(',', $HTTP_ACCEPT_LANGUAGE);
    foreach($langs AS $lang_tag) {
      // Cut off any q-value that might come after a semi-colon
      if ($pos = strpos($lang_tag, ';')) {
        $lang_tag = trim(substr($lang_tag, 0, $pos));
      }
      $lang = $lang_tag;
      if ($pos = strpos($lang_tag, '-')) {
        $primary_tag = substr($lang_tag, 0, $pos);
        $sub_tag = substr($lang_tag, ($pos + 1));
        if ($primary_tag == 'i') {
          /**
           * Language not listed in ISO 639 that are not variants
           * of any listed language, which can be registerd with the
           * i-prefix, such as i-cherokee
           */
          $lang = $sub_tag;
        } else {
          $lang = $primary_tag;
          if ($this->isValidCountryCode($sub_tag)) {
            $this->_country[$lang][] = $sub_tag;
          } else {
            /**
             * Dialect or variant information such as no-nynorsk or
             * en-cockney.
             * Script variations, such as az-arabic and az-cyrillic
             */
            $this->_lang_variation[$lang][] = $sub_tag;
          }
        }
      }
      $this->_acceptLanguage[] = $lang;
    }
    $this->_acceptCharset = explode(',', $HTTP_ACCEPT_CHARSET);
  }
  // }}}
  // {{{ _constructor();
  
  /**
   * Dummy constructor
   * call actual constructor
   */
  function _constructor() {
    $this->I18N_Negotiator();
  }
  // }}}
  // {{{ destructor
  
  /**
   * It does nothing right now
   */
  function _I18N_Negotiater() {
  }
  // }}}
  // {{{ getCountryMatch()
  
  /**
   * Find Country Match
   *
   * @param : string
   * @param : array
   *
   * @return: array
   * @access: public
   */
  function getCountryMatch($lang = '', $countries = '') {
    if (!$lang) {
      return FALSE;
    }
    return $this->_getMatch($countries, $this->_country[$lang], $this->_defaultCountry);
  }
  // }}}
  // {{{ getVariantInfo()
  
  /**
   * Return variant info for passed parameter.
   *
   * @param : string
   *
   * @return: string
   * @access: public
   */
  function getVariantInfo($lang) {
    return $this->_lang_variation[$lang];
  }
  // }}}
  // {{{ getCharsetMatch()
  
  /**
   * Find Charset match
   *
   * @param : array
   *
   * @return: string
   * @access: public
   */
  function getCharsetMatch($chasets = '') {
    return $this->_getMatch($charsets, $this->_acceptCharset, $this->_defaultCharset);
  }
  // }}}
  // {{{ getLanguageMatch()
  
  /**
   * Find Language match
   *
   * @param : array
   *
   * @return: string
   * @access: public
   */
  function getLanguageMatch($langs = '') {
    return $this->_getMatch($langs, $this->_acceptLanguage, $this->_defaultLanguage);
  }
  // }}}
  // {{{ _getMatch()
  
  /**
   * Return first matched value from first and second parameter.
   * If there is no match found, then return third parameter.
   *
   * @param : array
   * @param : array
   * @param : string
   *
   * @return: string
   * @access: private
   */
  function _getMatch($needle, $heystack, $default = '') {
    if (!$heystack) {
      return $default;
    }
    if (!$needle) {
      return array_shift($heystack);
    }
    $temp1 = array_intersect($heystack, $needle);
    $result = array_shift($temp1);
    if ($result) {
      return $result;
    }
    return $default;
  }
  /**
   * Find Country name for country code passed
   *
   * @param : string   country code
   */
  public function getCountryName($code) {
    // TODO: use a table country code --> country name
    return $code;
  }
  /**
   * Find Country name for country code passed
   *
   * @param : string   country code
   */
  public function getLanguageName($code) {
    return sfI18N::getNativeName($code);
  }
  /**
   * Check if I18N_Country class has been instantiated and set to $this->_lc
   * If it's not, it will load the script and instantiate I18N_Country class
   *
   * @return: void
   */
  private function isValidCountryCode($code) {
    // TODO: prepare a table with country-code --> country name
    // and use to test the code
    return true;
  }
}
?>
