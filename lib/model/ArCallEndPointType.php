<?php

/**
 * Subclass for representing a row from the 'ar_call_end_point_type' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ArCallEndPointType extends BaseArCallEndPointType
{

  public function __toString() {
    return ($this->getName());
  } 

}
