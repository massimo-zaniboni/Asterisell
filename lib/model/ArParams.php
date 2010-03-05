<?php

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
}
