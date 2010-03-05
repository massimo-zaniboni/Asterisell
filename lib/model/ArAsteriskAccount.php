<?php

/**
 * Subclass for representing a row from the 'ar_asterisk_account' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ArAsteriskAccount extends BaseArAsteriskAccount
{
  public function __toString() {
    return $this->getName();
  }

}
