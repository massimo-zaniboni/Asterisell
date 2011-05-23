<?php

/**
 * Subclass for representing a row from the 'ar_web_account' table.
 *
 * @package lib.model
 */ 
class ArWebAccount extends BaseArWebAccount
{
  /**
   * @return true if the web account is for an administrator
   */
  public function isAdmin() {
    return (is_null($this->getArPartyId()) && is_null($this->getArOfficeId()));
  }

  public function isParty() {
    return (!is_null($this->getArPartyId()) && is_null($this->getArOfficeId()));
  }

  public function isOffice() {
    return (!is_null($this->getArPartyId()) && !is_null($this->getArOfficeId()));
  }

  public function getInheritedArParamsId() {
      $id = NULL;
      $id = $this->getArParamsId();
      if (is_null($id)) {
          $partyId = $this->getArPartyId();
          if (!is_null($partyId)) {
              $party = $this->getArParty();
              $id = $party->getArParamsId();
          }
      }
      return $id;
  }
}
