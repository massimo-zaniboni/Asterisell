<?php

/**
 * Subclass for representing a row from the 'ar_party' table.
 *
 * @package lib.model
 */ 
class ArParty extends BaseArParty
{

  public function getFullName() {
    return $this->getName();
  } 

  public function __toString() {
    return ($this->getName());
  } 

}
