<?php

/**
 * Subclass for representing a row from the 'ar_rate_category' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ArRateCategory extends BaseArRateCategory
{

  public function __toString() {
    return $this->getName(); 
  }

}
