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
// $Id: Language.php,v 1.2 2003/01/04 11:55:25 mj Exp $
require_once ('I18N/Common.php');
class I18N_Language extends I18N_Common {
  // {{ constructor
  
  /**
   * Save list of ISO-639-1 two letter language code to language name mapping to its initiating object
   *
   * @return: void
   * @access: public
   */
  function I18N_Language() {
    // call constructor of parent class
    parent::_constructor();
    /**
     * List of ISO-639-1.
     * Two letter code to Language mapping
     * If you need three letter code to Language mappng,
     * then fetch ISO-639-2
     * @type  : array
     * @access: private
     */
    $this->_codes = array('aa' => 'Afar', 'ab' => 'Abkhazian', 'af' => 'Afrikaans', 'am' => 'Amharic', 'ar' => 'Arabic', 'as' => 'Assamese', 'ay' => 'Aymara', 'az' => 'Azerbaijani', 'ba' => 'Bashkir', 'be' => 'Byelorussian', 'bg' => 'Bulgarian', 'bh' => 'Bihari', 'bi' => 'Bislama', 'bn' => 'Bengali; Bangla', 'bo' => 'Tibetan', 'br' => 'Breton', 'ca' => 'Catalan', 'co' => 'Corsican', 'cs' => 'Czech', 'cy' => 'Welsh', 'da' => 'Danish', 'de' => 'German', 'dz' => 'Bhutani', 'el' => 'Greek', 'en' => 'English', 'eo' => 'Esperanto', 'es' => 'Spanish', 'et' => 'Estonian', 'eu' => 'Basque', 'fa' => 'Persian', 'fi' => 'Finnish', 'fj' => 'Fiji', 'fo' => 'Faeroese', 'fr' => 'French', 'fy' => 'Frisian', 'ga' => 'Irish', 'gd' => 'Scots Gaelic', 'gl' => 'Galician', 'gn' => 'Guarani', 'gu' => 'Gujarati', 'ha' => 'Hausa', 'hi' => 'Hindi', 'hr' => 'Croatian', 'hu' => 'Hungarian', 'hy' => 'Armenian', 'ia' => 'Interlingua', 'ie' => 'Interlingue', 'ik' => 'Inupiak', 'in' => 'Indonesian', 'is' => 'Icelandic', 'it' => 'Italian', 'iw' => 'Hebrew', 'ja' => 'Japanese', 'ji' => 'Yiddish', 'jw' => 'Javanese', 'ka' => 'Georgian', 'kk' => 'Kazakh', 'kl' => 'Greenlandic', 'km' => 'Cambodian', 'kn' => 'Kannada', 'ko' => 'Korean', 'ks' => 'Kashmiri', 'ku' => 'Kurdish', 'ky' => 'Kirghiz', 'la' => 'Latin', 'ln' => 'Lingala', 'lo' => 'Laothian', 'lt' => 'Lithuanian', 'lv' => 'Latvian, Lettish', 'mg' => 'Malagasy', 'mi' => 'Maori', 'mk' => 'Macedonian', 'ml' => 'Malayalam', 'mn' => 'Mongolian', 'mo' => 'Moldavian', 'mr' => 'Marathi', 'ms' => 'Malay', 'mt' => 'Maltese', 'my' => 'Burmese', 'na' => 'Nauru', 'ne' => 'Nepali', 'nl' => 'Dutch', 'no' => 'Norwegian', 'oc' => 'Occitan', 'om' => '(Afan) Oromo', 'or' => 'Oriya', 'pa' => 'Punjabi', 'pl' => 'Polish', 'ps' => 'Pashto, Pushto', 'pt' => 'Portuguese', 'qu' => 'Quechua', 'rm' => 'Rhaeto-Romance', 'rn' => 'Kirundi', 'ro' => 'Romanian', 'ru' => 'Russian', 'rw' => 'Kinyarwanda', 'sa' => 'Sanskrit', 'sd' => 'Sindhi', 'sg' => 'Sangro', 'sh' => 'Serbo-Croatian', 'si' => 'Singhalese', 'sk' => 'Slovak', 'sl' => 'Slovenian', 'sm' => 'Samoan', 'sn' => 'Shona', 'so' => 'Somali', 'sq' => 'Albanian', 'sr' => 'Serbian', 'ss' => 'Siswati', 'st' => 'Sesotho', 'su' => 'Sundanese', 'sv' => 'Swedish', 'sw' => 'Swahili', 'ta' => 'Tamil', 'te' => 'Tegulu', 'tg' => 'Tajik', 'th' => 'Thai', 'ti' => 'Tigrinya', 'tk' => 'Turkmen', 'tl' => 'Tagalog', 'tn' => 'Setswana', 'to' => 'Tonga', 'tr' => 'Turkish', 'ts' => 'Tsonga', 'tt' => 'Tatar', 'tw' => 'Twi', 'uk' => 'Ukrainian', 'ur' => 'Urdu', 'uz' => 'Uzbek', 'vi' => 'Vietnamese', 'vo' => 'Volapuk', 'wo' => 'Wolof', 'xh' => 'Xhosa', 'yo' => 'Yoruba', 'zh' => 'Chinese', 'zu' => 'Zulu');
  }
  // }}
  // {{ _constructor()
  
  /**
   * fake constructor. calls actual constructor
   *
   * @return: void
   * @access: private
   * /
   function _constructor()
   {
   $this->I18N_Language();
   }
   // }}
   // {{ _I18N_Language()
   /**
   * destructor. does nothing now.
   *
   * @return: void
   * @access: private
   * /
   function _I18N_Language()
   {
   }
   // }}
   // {{ isValidCode()
   /**
   * Check to see if passed Language code is valid meaning
   * defined in ISO-639-1.
   *
   * @param : string    Language code to check
   *
   * @return: boolean
   * @access: public
   * /
   function isValidCode($code)
   {
   return in_array(strtolower($code),array_keys($this->_codes));
   }
   // }}
   // {{ getName()
   /**
   * Return name of the language for language code passed
   *
   *  @param : string     language code
   *
   *  @return: string     name of the language
   *  @access: public
   */
  function getName($code = '') {
    if (($code = strtolower($code)) && in_array($code, array_keys($this->_codes))) {
      return $this->_codes[$code];
    }
    return FALSE;
  }
  // }}
  
}
?>
