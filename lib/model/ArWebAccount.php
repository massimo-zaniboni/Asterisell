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
    return (is_null($this->getArPartyId()) && is_null($this->getArAsteriskAccountId()));
  }

}
