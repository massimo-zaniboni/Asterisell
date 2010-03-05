<?php
/* vim: set expandtab tabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP version 4.0                                                      |
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
// |                                                                      |
// +----------------------------------------------------------------------+//
// $Id: Country.php,v 1.4 2003/01/04 11:55:23 mj Exp $
require_once ('I18N/Common.php');
class I18N_Country extends I18N_Common {
  // {{ constructor
  
  /**
   * Save list of ISO-3166 two letter country code to country name mapping to its initiating object
   *
   * @return: void
   * @access: public
   */
  function I18N_Country() {
    // call constructor of parent class
    parent::_constructor();
    /**
     * List of ISO-3166
     * Two letter code to Country name mapping.
     * @type  : array
     * @access: private
     */
    $this->_codes = array('AF' => 'AFGHANISTAN', 'AL' => 'ALBANIA', 'DZ' => 'ALGERIA', 'AS' => 'AMERICAN SAMOA', 'AD' => 'ANDORRA', 'AO' => 'ANGOLA', 'AI' => 'ANGUILLA', 'AQ' => 'ANTARCTICA', 'AG' => 'ANTIGUA AND BARBUDA', 'AR' => 'ARGENTINA', 'AM' => 'ARMENIA', 'AW' => 'ARUBA', 'AU' => 'AUSTRALIA', 'AT' => 'AUSTRIA', 'AZ' => 'AZERBAIJAN', 'BS' => 'BAHAMAS', 'BH' => 'BAHRAIN', 'BD' => 'BANGLADESH', 'BB' => 'BARBADOS', 'BY' => 'BELARUS', 'BE' => 'BELGIUM', 'BZ' => 'BELIZE', 'BJ' => 'BENIN', 'BM' => 'BERMUDA', 'BT' => 'BHUTAN', 'BO' => 'BOLIVIA', 'BA' => 'BOSNIA AND HERZEGOWINA', 'BW' => 'BOTSWANA', 'BV' => 'BOUVET ISLAND', 'BR' => 'BRAZIL', 'IO' => 'BRITISH INDIAN OCEAN TERRITORY', 'BN' => 'BRUNEI DARUSSALAM', 'BG' => 'BULGARIA', 'BF' => 'BURKINA FASO', 'BI' => 'BURUNDI', 'KH' => 'CAMBODIA', 'CM' => 'CAMEROON', 'CA' => 'CANADA', 'CV' => 'CAPE VERDE', 'KY' => 'CAYMAN ISLANDS', 'CF' => 'CENTRAL AFRICAN REPUBLIC', 'TD' => 'CHAD', 'CL' => 'CHILE', 'CN' => 'CHINA', 'CX' => 'CHRISTMAS ISLAND', 'CC' => 'COCOS (KEELING) ISLANDS', 'CO' => 'COLOMBIA', 'KM' => 'COMOROS', 'CG' => 'CONGO', 'CD' => 'CONGO, THE DEMOCRATIC REPUBLIC OF THE', 'CK' => 'COOK ISLANDS', 'CR' => 'COSTA RICA', 'CI' => 'COTE D\'IVOIRE', 'HR' => 'CROATIA (local name: Hrvatska)', 'CU' => 'CUBA', 'CY' => 'CYPRUS', 'CZ' => 'CZECH REPUBLIC', 'DK' => 'DENMARK', 'DJ' => 'DJIBOUTI', 'DM' => 'DOMINICA', 'DO' => 'DOMINICAN REPUBLIC', 'TP' => 'EAST TIMOR', 'EC' => 'ECUADOR', 'EG' => 'EGYPT', 'SV' => 'EL SALVADOR', 'GQ' => 'EQUATORIAL GUINEA', 'ER' => 'ERITREA', 'EE' => 'ESTONIA', 'ET' => 'ETHIOPIA', 'FK' => 'FALKLAND ISLANDS (MALVINAS)', 'FO' => 'FAROE ISLANDS', 'FJ' => 'FIJI', 'FI' => 'FINLAND', 'FR' => 'FRANCE', 'FX' => 'FRANCE, METROPOLITAN', 'GF' => 'FRENCH GUIANA', 'PF' => 'FRENCH POLYNESIA', 'TF' => 'FRENCH SOUTHERN TERRITORIES', 'GA' => 'GABON', 'GM' => 'GAMBIA', 'GE' => 'GEORGIA', 'DE' => 'GERMANY', 'GH' => 'GHANA', 'GI' => 'GIBRALTAR', 'GR' => 'GREECE', 'GL' => 'GREENLAND', 'GD' => 'GRENADA', 'GP' => 'GUADELOUPE', 'GU' => 'GUAM', 'GT' => 'GUATEMALA', 'GN' => 'GUINEA', 'GW' => 'GUINEA-BISSAU', 'GY' => 'GUYANA', 'HT' => 'HAITI', 'HM' => 'HEARD AND MC DONALD ISLANDS', 'VA' => 'HOLY SEE (VATICAN CITY STATE)', 'HN' => 'HONDURAS', 'HK' => 'HONG KONG', 'HU' => 'HUNGARY', 'IS' => 'ICELAND', 'IN' => 'INDIA', 'ID' => 'INDONESIA', 'IR' => 'IRAN (ISLAMIC REPUBLIC OF)', 'IQ' => 'IRAQ', 'IE' => 'IRELAND', 'IL' => 'ISRAEL', 'IT' => 'ITALY', 'JM' => 'JAMAICA', 'JP' => 'JAPAN', 'JO' => 'JORDAN', 'KZ' => 'KAZAKHSTAN', 'KE' => 'KENYA', 'KI' => 'KIRIBATI', 'KP' => 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF', 'KR' => 'KOREA, REPUBLIC OF', 'KW' => 'KUWAIT', 'KG' => 'KYRGYZSTAN', 'LA' => 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC', 'LV' => 'LATVIA', 'LB' => 'LEBANON', 'LS' => 'LESOTHO', 'LR' => 'LIBERIA', 'LY' => 'LIBYAN ARAB JAMAHIRIYA', 'LI' => 'LIECHTENSTEIN', 'LT' => 'LITHUANIA', 'LU' => 'LUXEMBOURG', 'MO' => 'MACAU', 'MK' => 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF', 'MG' => 'MADAGASCAR', 'MW' => 'MALAWI', 'MY' => 'MALAYSIA', 'MV' => 'MALDIVES', 'ML' => 'MALI', 'MT' => 'MALTA', 'MH' => 'MARSHALL ISLANDS', 'MQ' => 'MARTINIQUE', 'MR' => 'MAURITANIA', 'MU' => 'MAURITIUS', 'YT' => 'MAYOTTE', 'MX' => 'MEXICO', 'FM' => 'MICRONESIA, FEDERATED STATES OF', 'MD' => 'MOLDOVA, REPUBLIC OF', 'MC' => 'MONACO', 'MN' => 'MONGOLIA', 'MS' => 'MONTSERRAT', 'MA' => 'MOROCCO', 'MZ' => 'MOZAMBIQUE', 'MM' => 'MYANMAR', 'NA' => 'NAMIBIA', 'NR' => 'NAURU', 'NP' => 'NEPAL', 'NL' => 'NETHERLANDS', 'AN' => 'NETHERLANDS ANTILLES', 'NC' => 'NEW CALEDONIA', 'NZ' => 'NEW ZEALAND', 'NI' => 'NICARAGUA', 'NE' => 'NIGER', 'NG' => 'NIGERIA', 'NU' => 'NIUE', 'NF' => 'NORFOLK ISLAND', 'MP' => 'NORTHERN MARIANA ISLANDS', 'NO' => 'NORWAY', 'OM' => 'OMAN', 'PK' => 'PAKISTAN', 'PW' => 'PALAU', 'PS' => 'PALESTINIAN TERRITORY, OCCUPIED', 'PA' => 'PANAMA', 'PG' => 'PAPUA NEW GUINEA', 'PY' => 'PARAGUAY', 'PE' => 'PERU', 'PH' => 'PHILIPPINES', 'PN' => 'PITCAIRN', 'PL' => 'POLAND', 'PT' => 'PORTUGAL', 'PR' => 'PUERTO RICO', 'QA' => 'QATAR', 'RE' => 'REUNION', 'RO' => 'ROMANIA', 'RU' => 'RUSSIAN FEDERATION', 'RW' => 'RWANDA', 'KN' => 'SAINT KITTS AND NEVIS', 'LC' => 'SAINT LUCIA', 'VC' => 'SAINT VINCENT AND THE GRENADINES', 'WS' => 'SAMOA', 'SM' => 'SAN MARINO', 'ST' => 'SAO TOME AND PRINCIPE', 'SA' => 'SAUDI ARABIA', 'SN' => 'SENEGAL', 'SC' => 'SEYCHELLES', 'SL' => 'SIERRA LEONE', 'SG' => 'SINGAPORE', 'SK' => 'SLOVAKIA (Slovak Republic)', 'SI' => 'SLOVENIA', 'SB' => 'SOLOMON ISLANDS', 'SO' => 'SOMALIA', 'ZA' => 'SOUTH AFRICA', 'GS' => 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS', 'ES' => 'SPAIN', 'LK' => 'SRI LANKA', 'SH' => 'ST. HELENA', 'PM' => 'ST. PIERRE AND MIQUELON', 'SD' => 'SUDAN', 'SR' => 'SURINAME', 'SJ' => 'SVALBARD AND JAN MAYEN ISLANDS', 'SZ' => 'SWAZILAND', 'SE' => 'SWEDEN', 'CH' => 'SWITZERLAND', 'SY' => 'SYRIAN ARAB REPUBLIC', 'TW' => 'TAIWAN, PROVINCE OF CHINA', 'TJ' => 'TAJIKISTAN', 'TZ' => 'TANZANIA, UNITED REPUBLIC OF', 'TH' => 'THAILAND', 'TG' => 'TOGO', 'TK' => 'TOKELAU', 'TO' => 'TONGA', 'TT' => 'TRINIDAD AND TOBAGO', 'TN' => 'TUNISIA', 'TR' => 'TURKEY', 'TM' => 'TURKMENISTAN', 'TC' => 'TURKS AND CAICOS ISLANDS', 'TV' => 'TUVALU', 'UG' => 'UGANDA', 'UA' => 'UKRAINE', 'AE' => 'UNITED ARAB EMIRATES', 'GB' => 'UNITED KINGDOM', 'US' => 'UNITED STATES', 'UM' => 'UNITED STATES MINOR OUTLYING ISLANDS', 'UY' => 'URUGUAY', 'UZ' => 'UZBEKISTAN', 'VU' => 'VANUATU', 'VE' => 'VENEZUELA', 'VN' => 'VIET NAM', 'VG' => 'VIRGIN ISLANDS (BRITISH)', 'VI' => 'VIRGIN ISLANDS (U.S.)', 'WF' => 'WALLIS AND FUTUNA ISLANDS', 'EH' => 'WESTERN SAHARA', 'YE' => 'YEMEN', 'YU' => 'YUGOSLAVIA', 'ZM' => 'ZAMBIA', 'ZW' => 'ZIMBABWE');
  }
  // }}
  // {{ fake constructor
  
  /**
   * call actual constructor
   *
   *  @return: void
   *  @access: private
   */
  function _constructor() {
    $this->I18N_Country();
  }
  // }}
  // {{ isValidCode()
  function isValidCode($code) {
    return isset($this->_codes[strtoupper($code) ]);
  }
  // }}
  // {{ getName()
  
  /**
   * Return name of the country for country code passed
   *
   *  @param : string     country code
   *
   *  @return: string     name of the country
   *  @access: public
   */
  function getName($code = '') {
    return $this->isValidCode($code = strtoupper($code)) ? $this->_codes[$code] : false;
  }
  // }}
  
}
?>
