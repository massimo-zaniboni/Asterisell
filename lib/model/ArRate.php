<?php

sfLoader::loadHelpers('I18N');

/**
 * Subclass for representing a row from the 'ar_rate' table.
 *
 * @package lib.model
 */ 
class ArRate extends BaseArRate
{

  /**
   * @return "C" if the rate is applicable to customers of a certain category,
   *         "V" if the rate is applied to a vendor,
   *         "S" if the rate is applied to unprocessed CDRs.
   *         "X" if the rate has bad format.
   *
   */
  public function getRateType() {
    if ($this->getDestinationType() == DestinationType::unprocessed) {
      if (is_null($this->getArRateCategoryId()) && is_null($this->getArPartyId())) {
          return "S";
      }
    } else {
      if (is_null($this->getArPartyId())) {
          return "C";
      } else {
          return "V";
      }
    }

    return "X";
  }

  /**
   * A synonimous of getRateType(), used for compatibility with old code.
   * 
   */
  public function getCustomerOrVendor() {
      return $this->getRateType();
  }

  public function getCVName() {
    $c = $this->getRateType();

    if ($c == 'C') {
      return __("Customer");
    } else if ($c == 'V') {
      return __("Vendor");
    } else if ($c == "S") {
      return __("Process CDR");
    } else { 
      return __("Bad Forma!!");
    }
  }

  public function isCurrent() {
    if ((!is_null($this->getStartTime())
	 && (strtotime($this->getStartTime()) <= time())
	 && (is_null($this->getEndTime())
	     || (strtotime($this->getEndTime()) > time()
		 )
	     ))) {
      return true;
    } else {
      return false;
    }
  }

  /**
   * @return an unserialized rate method, 
   * null if it does not exists or it is in a bad format.
   */
  public function unserializePhpRateMethod() {
    $phpRate = null;

    $r = $this->getPhpClassSerialization();
    if (! is_null($r)) {

      // note: php_class_serialization is a LONGTEXT and it is managed
      // from Symfony in a different way respect strings.
      //
      $phpRateString = $r->getContents();
      if (! is_null($phpRateString)) {
        $phpRate = unserialize($phpRateString);
        if ($phpRate == false) {
          $phpRate = null;
        }
      }
    }
    return $phpRate;
  }
}
