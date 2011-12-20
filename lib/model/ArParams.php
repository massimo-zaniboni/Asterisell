<?php

sfLoader::loadHelpers(array('Asterisell'));

/**
 * Subclass for representing a row from the 'ar_params' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ArParams extends BaseArParams
{
  public function __toString() {
    return $this->getName(); 
  }

  public function getVatTaxPercAsPhpDecimal() {
    return from_db_decimal_to_smart_php_decimal($this->getVatTaxPerc());
  }

  public function setVatTaxPercAsPhpDecimal($d) {
    $this->setVatTaxPerc(from_php_decimal_to_db_decimal($d));
  }

  /**
   * @return true if the SMTP is configured, and emails con be sent
   */
  public function isSMTPConfigured() {
      if (is_null($this->getSmtpHost())) {
          return FALSE;
      }

      if (strlen(trim($this->getSmtpHost())) == 0) {
          return FALSE;
      }

      return TRUE;
  }

}
