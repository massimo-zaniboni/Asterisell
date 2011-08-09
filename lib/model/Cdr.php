<?php

/**
 * Subclass for representing a row from the 'cdr' table.
 *
 * @package lib.model
 */
class Cdr extends BaseCdr {

  public function calcExternalTelephoneNumber() {
    $destinationType = $this->getDestinationType();

    $telephoneNumbersConfig = sfConfig::get('app_internal_external_telephone_numbers');

    switch ($telephoneNumbersConfig) {
      case 0:
        return $this->getActualDestinationNumber();
        break;
      case 1:
        switch ($destinationType) {
          case DestinationType::incoming:
            return $this->getActualDestinationNumber();
            break;
          case DestinationType::outgoing:
            return $this->getSrc();
            break;
          default:
            return $this->getActualDestinationNumber();
            break;
        }
        break;
      case 2:
        return $this->getActualDestinationNumber();
        break;
      case 3:
        die("When \"app_internal_external_telephone_numbers\" field is 3, the cached_external_telephone_number must be always setted." . $telephoneNumbersConfig);
        break;
      default:
        die("Unrecognized \"app_internal_external_telephone_numbers\" field value: " . $telephoneNumbersConfig);
        break;
    }
  }

  public function calcInternalTelephoneNumber() {
    $destinationType = $this->getDestinationType();
    $telephoneNumbersConfig = sfConfig::get('app_internal_external_telephone_numbers');

    switch ($telephoneNumbersConfig) {
      case 0:
        $account = VariableFrame::getArAsteriskAccountByCodeCache()->getArAsteriskAccountByCode($this->getAccountcode());
        return $account->getName();
        break;
      case 1:
        switch ($destinationType) {
          case DestinationType::incoming:
            return $this->getSrc();
            break;
          case DestinationType::outgoing:
            return $this->getActualDestinationNumber();
            break;
          default:
            return $this->getSrc();
            break;
        }
        break;
      case 2:
        return $this->getSrc();
        break;
      case 3:
        die("When \"app_internal_external_telephone_numbers\" field is 3, the cahed_internal_telephone_number must be always setted." . $telephoneNumbersConfig);
        break;
      default:
        die("Unrecognized \"app_internal_external_telephone_numbers\" field value: " . $telephoneNumbersConfig);
        break;
    }
  }


  public function calcMaskedTelephoneNumber($unmasked) {
    $destinationType = $this->getDestinationType();
    
    // Remove common/default prefix
    //
    $commonPrefix = sfConfig::get('app_not_displayed_telephone_prefix');
    if ($commonPrefix != "-") {
      if (strlen($unmasked) > strlen($commonPrefix)) {
        if (substr($unmasked, 0, strlen($commonPrefix)) === $commonPrefix) {
          $unmasked = substr($unmasked, strlen($commonPrefix));
        }
      }
    }

    // Apply mask
    //
    $mask = sfConfig::get('app_mask_for_external_telephone_number');

    if ($destinationType == DestinationType::internal) {
      return $unmasked;
    }

    if (!is_null($unmasked)) {
      $unmasked = trim($unmasked);
      $len = strlen($unmasked);
      if ($len > $mask) {
        return substr($unmasked, 0, $len - $mask) . str_repeat("X", $mask);
      }
    }

    return $unmasked;
  }

  /**
   * @return the actual destination number according
   * the application settings.
   * NULL if "cdr.lastapp" is not a value
   * of "app_lastapp_accepted_values".
   *
   * See application configuration file "app.yml" for more details.
   */
  protected function getActualDestinationNumber() {
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
   * @return a user-readable name identifying the type of Call (incoming/outgoing/internal)
   */
  public function getTypeName() {
    return DestinationType::getName($this->getDestinationType());
  }

  public function getTypeSymbol() {
    return DestinationType::getSymbol($this->getDestinationType());
  }

  /**
   * @return null if the Cdr is consistent,
   * a string desccribing the problem otherwise.
   */
  public function isConsistent() {
    if (is_null($this->getCalldate())) {
      return ("CALLDATE field is NULL");
    }

    if (is_null($this->getAccountcode())) {
      return ("ACCOUNTCODE field is NULL");
    }

    return null;
  }

  public function resetCost() {
    $this->setIncome(null);
    $this->setCost(null);
    $this->setIncomeArRateId(null);
    $this->setCostArRateId(null);
    $this->setVendorId(null);
  }

  public function resetAll() {
    $this->setDestinationType(DestinationType::unprocessed);
    $this->resetCost();
    $this->setArAsteriskAccountId(NULL);
    $this->setCachedExternalTelephoneNumber(NULL);
    $this->setCachedInternalTelephoneNumber(NULL);
    $this->setCachedMaskedExternalTelephoneNumber(NULL);
    $this->setExternalTelephoneNumberWithAppliedPortability(NULL);
    $this->setArTelephonePrefixId(NULL);
    $this->setIsExported(FALSE);
    // note: cdr.source_id field maintains its value, 
    // because it can depend from an external job processor...
  }

  /**
   * @return TRUE if the Cdr is correctly rated.
   */
  public function isRated() {

    if (is_null($this->getIncome())) {
      return false;
    }

    if (is_null($this->getCost())) {
      return false;
    }

    if (is_null($this->getIncomeArRateId())) {
      return false;
    }

    if (is_null($this->getCostArRateId())) {
      return false;
    }

    if (is_null($this->getVendorId())) {
      return false;
    }

    if (is_null($this->getArAsteriskAccountId())) {
      return false;
    }

    if (is_null($this->getCachedMaskedExternalTelephoneNumber())) {
      return false;
    }

    if (is_null($this->getCachedExternalTelephoneNumber())) {
      return false;
    }

    if (is_null($this->getCachedInternalTelephoneNumber())) {
      return false;
    }

    return true;
  }

  /**
   * A synonimous of getExternalTelephoneNumberWithAppliedPortability()
   */
  public function getCachedExternalTelephoneNumberWithAppliedPortability() {
    return $this->getExternalTelephoneNumberWithAppliedPortability();
  }

  public function setCachedExternalTelephoneNumberWithAppliedPortability($v) {
    $this->setExternalTelephoneNumberWithAppliedPortability($v);
  }

}
