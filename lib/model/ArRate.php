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
   * According ArRate schema documentation 
   * ArRate can have ArRateCategoryId to no-null if it is applicable to a whole Customer category,
   * or otherwise ArRate must have ArPartyId to no-null if it is applied to a vendor.
   */
  public function getCustomerOrVendor() {
    if (is_null($this->getArRateCategoryId())) {
      if (is_null($this->getArPartyId())) {
	trigger_error(__("ArRate with id ").$this->getId().__(" has bad format."));
      } else {
	return "V";
      }
    } else {
      if (is_null($this->getArPartyId())) {
	return "C";
      } else {
	trigger_error(__("ArRate with id ").$this->getId().__(" has bad format."));
      }
    }
  }

  public function getCVName() {
    if ($this->getCustomerOrVendor() == 'C') {
      return __("Customer");
    } else if ($this->getCustomerOrVendor() == 'V') {
      return __("Vendor");
    } else {
      trigger_error(__("ArRate with id ").$this->getId().__(" has bad format."));
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
