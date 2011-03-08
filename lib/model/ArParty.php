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

  const MANY_OFFICES_AND_MANY_VOIP = 0;
  const MANY_OFFICES_ONE_VOIP = 1;
  const ONE_OFFICE_MANY_VOIP = 2;
  const ONE_OFFICE_ONE_VOIP = 3;

  /**
   * @return NULL if the party has two or more associated offices,
   *         the OfficeId if the party has only one single associated office.
   */
  public function getUniqueOfficeId() {
       $officeId = null;

       $c = new Criteria();
       $c->add(ArOfficePeer::AR_PARTY_ID, $this->getId());
       $results = ArOfficePeer::doSelect($c);

       $countOffices = 0;
       foreach($results as $office) {
         $countOffices++;
         $officeId = $office->getId();
       }

       if ($countOffices == 1) {
           return $officeId;
       } else {
           return null;
       }
  }

  public function getSuggestedCallReportType() {
    return self::getSuggestedCallReportTypeForParty($this->getId());
  }

  /**
   * @param $partyId the party to inspect
   * @return 0 if the party has many Offices and many VoIP accounts,
   *         1 if the party has many Offices and each Office as only one VoIP account,
   *         2 if the party has one Office with many VoIP accounts,
   *         3 if the party has one Office with one VoIP account.
   */
  static public function getSuggestedCallReportTypeForParty($partyId) {

    try {
      $conn = Propel::getConnection();
      $query = "SELECT COUNT(ar_asterisk_account.id) as c FROM ar_asterisk_account, ar_office WHERE ar_office.ar_party_id = $partyId AND ar_asterisk_account.ar_office_id = ar_office.id GROUP BY ar_office.id";
      $statement = $conn->prepareStatement($query);
      $rs = $statement->executeQuery();

      $countOffices = 0;
      $maxAccounts = 0;
      while ($rs->next()) {
	$nrOfAccounts = $rs->getInt('c');
	$countOffices++;
	if ($nrOfAccounts > $maxAccounts) {
	  $maxAccounts = $nrOfAccounts;
	}
      }

      if ($countOffices <= 1) {
	if ($maxAccounts <= 1) {
	  return self::ONE_OFFICE_ONE_VOIP;
	} else {
	  return self::ONE_OFFICE_MANY_VOIP;
	}
      } else {
	if ($maxAccounts <= 1) {
	  return self::MANY_OFFICES_ONE_VOIP;
	} else {
	  return self::MANY_OFFICES_AND_MANY_VOIP;
	}
      }
    } catch(Exception $e) {
      return self::MANY_OFFICES_AND_MANY_VOIP;
      //
      // in case of problems use a conservative choice
    }

    return self::MANY_OFFICES_AND_MANY_VOIP;
  }



}
