<?php

/**
 * Subclass for representing a row from the 'ar_office' table.
 *
 * 
 *
 * @package lib.model
 */ 
class ArOffice extends BaseArOffice
{

  /**
   * @return the unique ar_asterisk_account.id associated to the ArOffice,
   * or NULL if there are more than one account associated.
   */
  public function getUniqueArAsteriskAccountId() {
    return self::getUniqueArAsteriskAccountIdForOfficeId($this->getId());
  }

  /**
   * @return the unique ar_asterisk_account.id associated to the ArOffice,
   * or NULL if there are more than one account associated.
   */
  static public function getUniqueArAsteriskAccountIdForOfficeId($officeId) {
    $pc = new Criteria();
    $pc->add(ArAsteriskAccountPeer::AR_OFFICE_ID, $officeId);
    $accounts = ArAsteriskAccountPeer::doSelect($pc);
    $accountId = null;
    $counter = 0;
    foreach($accounts as $account) {
      $accountId = $account->getId();
      $counter++;
    }
    if ($counter == 1) {
      return $accountId;
    } else {
      return NULL;
    }
  }


}
