<?php

/**
 * Subclass for representing a row from the 'ar_rate_incremental_info' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ArRateIncrementalInfo extends BaseArRateIncrementalInfo {

  /**
   * @return an unserialized BundleRate as PHP Object,
   * null if it does not exists or it is in a bad format.
   */
  public function unserializeBundleRate() {
    $phpRate = null;

    $r = $this->getBundleRate();
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
