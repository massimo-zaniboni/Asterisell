<?php


abstract class BaseArAsteriskAccount extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $name;


	
	protected $account_code;


	
	protected $ar_party_id;

	
	protected $aArParty;

	
	protected $collCdrs;

	
	protected $lastCdrCriteria = null;

	
	protected $collArWebAccounts;

	
	protected $lastArWebAccountCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getName()
	{

		return $this->name;
	}

	
	public function getAccountCode()
	{

		return $this->account_code;
	}

	
	public function getArPartyId()
	{

		return $this->ar_party_id;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ArAsteriskAccountPeer::ID;
		}

	} 
	
	public function setName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = ArAsteriskAccountPeer::NAME;
		}

	} 
	
	public function setAccountCode($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->account_code !== $v) {
			$this->account_code = $v;
			$this->modifiedColumns[] = ArAsteriskAccountPeer::ACCOUNT_CODE;
		}

	} 
	
	public function setArPartyId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ar_party_id !== $v) {
			$this->ar_party_id = $v;
			$this->modifiedColumns[] = ArAsteriskAccountPeer::AR_PARTY_ID;
		}

		if ($this->aArParty !== null && $this->aArParty->getId() !== $v) {
			$this->aArParty = null;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->name = $rs->getString($startcol + 1);

			$this->account_code = $rs->getString($startcol + 2);

			$this->ar_party_id = $rs->getInt($startcol + 3);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 4; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ArAsteriskAccount object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArAsteriskAccountPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArAsteriskAccountPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArAsteriskAccountPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			$affectedRows = $this->doSave($con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	protected function doSave($con)
	{
		$affectedRows = 0; 		if (!$this->alreadyInSave) {
			$this->alreadyInSave = true;


												
			if ($this->aArParty !== null) {
				if ($this->aArParty->isModified()) {
					$affectedRows += $this->aArParty->save($con);
				}
				$this->setArParty($this->aArParty);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ArAsteriskAccountPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArAsteriskAccountPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collCdrs !== null) {
				foreach($this->collCdrs as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collArWebAccounts !== null) {
				foreach($this->collArWebAccounts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			$this->alreadyInSave = false;
		}
		return $affectedRows;
	} 
	
	protected $validationFailures = array();

	
	public function getValidationFailures()
	{
		return $this->validationFailures;
	}

	
	public function validate($columns = null)
	{
		$res = $this->doValidate($columns);
		if ($res === true) {
			$this->validationFailures = array();
			return true;
		} else {
			$this->validationFailures = $res;
			return false;
		}
	}

	
	protected function doValidate($columns = null)
	{
		if (!$this->alreadyInValidation) {
			$this->alreadyInValidation = true;
			$retval = null;

			$failureMap = array();


												
			if ($this->aArParty !== null) {
				if (!$this->aArParty->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aArParty->getValidationFailures());
				}
			}


			if (($retval = ArAsteriskAccountPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collCdrs !== null) {
					foreach($this->collCdrs as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collArWebAccounts !== null) {
					foreach($this->collArWebAccounts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArAsteriskAccountPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getName();
				break;
			case 2:
				return $this->getAccountCode();
				break;
			case 3:
				return $this->getArPartyId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArAsteriskAccountPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getAccountCode(),
			$keys[3] => $this->getArPartyId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArAsteriskAccountPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setName($value);
				break;
			case 2:
				$this->setAccountCode($value);
				break;
			case 3:
				$this->setArPartyId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArAsteriskAccountPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setAccountCode($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setArPartyId($arr[$keys[3]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArAsteriskAccountPeer::DATABASE_NAME);

		if ($this->isColumnModified(ArAsteriskAccountPeer::ID)) $criteria->add(ArAsteriskAccountPeer::ID, $this->id);
		if ($this->isColumnModified(ArAsteriskAccountPeer::NAME)) $criteria->add(ArAsteriskAccountPeer::NAME, $this->name);
		if ($this->isColumnModified(ArAsteriskAccountPeer::ACCOUNT_CODE)) $criteria->add(ArAsteriskAccountPeer::ACCOUNT_CODE, $this->account_code);
		if ($this->isColumnModified(ArAsteriskAccountPeer::AR_PARTY_ID)) $criteria->add(ArAsteriskAccountPeer::AR_PARTY_ID, $this->ar_party_id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArAsteriskAccountPeer::DATABASE_NAME);

		$criteria->add(ArAsteriskAccountPeer::ID, $this->id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{

		$copyObj->setName($this->name);

		$copyObj->setAccountCode($this->account_code);

		$copyObj->setArPartyId($this->ar_party_id);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getCdrs() as $relObj) {
				$copyObj->addCdr($relObj->copy($deepCopy));
			}

			foreach($this->getArWebAccounts() as $relObj) {
				$copyObj->addArWebAccount($relObj->copy($deepCopy));
			}

		} 

		$copyObj->setNew(true);

		$copyObj->setId(NULL); 
	}

	
	public function copy($deepCopy = false)
	{
				$clazz = get_class($this);
		$copyObj = new $clazz();
		$this->copyInto($copyObj, $deepCopy);
		return $copyObj;
	}

	
	public function getPeer()
	{
		if (self::$peer === null) {
			self::$peer = new ArAsteriskAccountPeer();
		}
		return self::$peer;
	}

	
	public function setArParty($v)
	{


		if ($v === null) {
			$this->setArPartyId(NULL);
		} else {
			$this->setArPartyId($v->getId());
		}


		$this->aArParty = $v;
	}


	
	public function getArParty($con = null)
	{
		if ($this->aArParty === null && ($this->ar_party_id !== null)) {
						include_once 'lib/model/om/BaseArPartyPeer.php';

			$this->aArParty = ArPartyPeer::retrieveByPK($this->ar_party_id, $con);

			
		}
		return $this->aArParty;
	}

	
	public function initCdrs()
	{
		if ($this->collCdrs === null) {
			$this->collCdrs = array();
		}
	}

	
	public function getCdrs($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseCdrPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCdrs === null) {
			if ($this->isNew()) {
			   $this->collCdrs = array();
			} else {

				$criteria->add(CdrPeer::ACCOUNTCODE, $this->getAccountCode());

				CdrPeer::addSelectColumns($criteria);
				$this->collCdrs = CdrPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(CdrPeer::ACCOUNTCODE, $this->getAccountCode());

				CdrPeer::addSelectColumns($criteria);
				if (!isset($this->lastCdrCriteria) || !$this->lastCdrCriteria->equals($criteria)) {
					$this->collCdrs = CdrPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastCdrCriteria = $criteria;
		return $this->collCdrs;
	}

	
	public function countCdrs($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseCdrPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(CdrPeer::ACCOUNTCODE, $this->getAccountCode());

		return CdrPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addCdr(Cdr $l)
	{
		$this->collCdrs[] = $l;
		$l->setArAsteriskAccount($this);
	}


	
	public function getCdrsJoinArTelephonePrefix($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseCdrPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCdrs === null) {
			if ($this->isNew()) {
				$this->collCdrs = array();
			} else {

				$criteria->add(CdrPeer::ACCOUNTCODE, $this->getAccountCode());

				$this->collCdrs = CdrPeer::doSelectJoinArTelephonePrefix($criteria, $con);
			}
		} else {
									
			$criteria->add(CdrPeer::ACCOUNTCODE, $this->getAccountCode());

			if (!isset($this->lastCdrCriteria) || !$this->lastCdrCriteria->equals($criteria)) {
				$this->collCdrs = CdrPeer::doSelectJoinArTelephonePrefix($criteria, $con);
			}
		}
		$this->lastCdrCriteria = $criteria;

		return $this->collCdrs;
	}


	
	public function getCdrsJoinArRateRelatedByIncomeArRateId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseCdrPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCdrs === null) {
			if ($this->isNew()) {
				$this->collCdrs = array();
			} else {

				$criteria->add(CdrPeer::ACCOUNTCODE, $this->getAccountCode());

				$this->collCdrs = CdrPeer::doSelectJoinArRateRelatedByIncomeArRateId($criteria, $con);
			}
		} else {
									
			$criteria->add(CdrPeer::ACCOUNTCODE, $this->getAccountCode());

			if (!isset($this->lastCdrCriteria) || !$this->lastCdrCriteria->equals($criteria)) {
				$this->collCdrs = CdrPeer::doSelectJoinArRateRelatedByIncomeArRateId($criteria, $con);
			}
		}
		$this->lastCdrCriteria = $criteria;

		return $this->collCdrs;
	}


	
	public function getCdrsJoinArRateRelatedByCostArRateId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseCdrPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCdrs === null) {
			if ($this->isNew()) {
				$this->collCdrs = array();
			} else {

				$criteria->add(CdrPeer::ACCOUNTCODE, $this->getAccountCode());

				$this->collCdrs = CdrPeer::doSelectJoinArRateRelatedByCostArRateId($criteria, $con);
			}
		} else {
									
			$criteria->add(CdrPeer::ACCOUNTCODE, $this->getAccountCode());

			if (!isset($this->lastCdrCriteria) || !$this->lastCdrCriteria->equals($criteria)) {
				$this->collCdrs = CdrPeer::doSelectJoinArRateRelatedByCostArRateId($criteria, $con);
			}
		}
		$this->lastCdrCriteria = $criteria;

		return $this->collCdrs;
	}

	
	public function initArWebAccounts()
	{
		if ($this->collArWebAccounts === null) {
			$this->collArWebAccounts = array();
		}
	}

	
	public function getArWebAccounts($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArWebAccountPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArWebAccounts === null) {
			if ($this->isNew()) {
			   $this->collArWebAccounts = array();
			} else {

				$criteria->add(ArWebAccountPeer::AR_ASTERISK_ACCOUNT_ID, $this->getId());

				ArWebAccountPeer::addSelectColumns($criteria);
				$this->collArWebAccounts = ArWebAccountPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArWebAccountPeer::AR_ASTERISK_ACCOUNT_ID, $this->getId());

				ArWebAccountPeer::addSelectColumns($criteria);
				if (!isset($this->lastArWebAccountCriteria) || !$this->lastArWebAccountCriteria->equals($criteria)) {
					$this->collArWebAccounts = ArWebAccountPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastArWebAccountCriteria = $criteria;
		return $this->collArWebAccounts;
	}

	
	public function countArWebAccounts($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseArWebAccountPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ArWebAccountPeer::AR_ASTERISK_ACCOUNT_ID, $this->getId());

		return ArWebAccountPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArWebAccount(ArWebAccount $l)
	{
		$this->collArWebAccounts[] = $l;
		$l->setArAsteriskAccount($this);
	}


	
	public function getArWebAccountsJoinArParty($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArWebAccountPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArWebAccounts === null) {
			if ($this->isNew()) {
				$this->collArWebAccounts = array();
			} else {

				$criteria->add(ArWebAccountPeer::AR_ASTERISK_ACCOUNT_ID, $this->getId());

				$this->collArWebAccounts = ArWebAccountPeer::doSelectJoinArParty($criteria, $con);
			}
		} else {
									
			$criteria->add(ArWebAccountPeer::AR_ASTERISK_ACCOUNT_ID, $this->getId());

			if (!isset($this->lastArWebAccountCriteria) || !$this->lastArWebAccountCriteria->equals($criteria)) {
				$this->collArWebAccounts = ArWebAccountPeer::doSelectJoinArParty($criteria, $con);
			}
		}
		$this->lastArWebAccountCriteria = $criteria;

		return $this->collArWebAccounts;
	}

} 