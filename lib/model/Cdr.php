<?php

/**
 * Subclass for representing a row from the 'cdr' table.
 *
 * @package lib.model
 */ 
class Cdr extends BaseCdr
{

  /**
   * @return the actual destination number according
   * the application settings.
   * NULL if "cdr.lastapp" is not a value 
   * of "app_lastapp_accepted_values".
   *
   * NOTE: use always this function instead of getDst().
   *
   * See application configuration file "app.yml" for more details.
   */
  public function getActualDestinationNumber() {
    $lastappAcceptedValues = sfConfig::get('app_lastapp_accepted_values');

    if (count($lastappAcceptedValues) == 0) {
      return $this->getDst();
    }

    if (in_array($this->getLastapp(), $lastappAcceptedValues)) {
      return $this->getLastdata();
    } else {
      return NULL;
    }
  }

  /**
   * @return null if the Cdr is consistent, 
   * a mesage error in english describing the problem otherwise.
   */
  public function isConsistent() {
    if (is_null($this->getCalldate())) {
      return ("CALLDATE field is NULL");
    }

    if (is_null($this->getChannel())) {
      return ("CHANNEL field is NULL");
    }
    
    if (is_null($this->getAccountcode())) {
      return ("ACCOUNTCODE field is NULL");
    }

    if (is_null($this->getDstchannel())) {
      return ("DSTCHANNEL field is NULL");
    }

    if (is_null($this->getDisposition())) {
      return ("DISPOSITION field is NULL");
    }

    if (is_null($this->getAmaflags())) {
      return ("AMAFLAGS field is NULL");
    }

    return null;

  }

  public function resetCost() {
      $this->setIncome(null);
      $this->setCost(null);
      $this->setIncomeArRateId(null);
      $this->setCostArRateId(null);
  }



  
}
