<?php


abstract class BaseArOffice extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $name;


	
	protected $description;


	
	protected $ar_party_id;


	
	protected $ar_rate_category_id;

	
	protected $aArParty;

	
	protected $aArRateCategory;

	
	protected $collArAsteriskAccounts;

	
	protected $lastArAsteriskAccountCriteria = null;

	
	protected $collArWebAccounts;

	
	protected $lastArWebAccountCriteria = null;

	
	protected $collArAsteriskAccountRanges;

	
	protected $lastArAsteriskAccountRangeCriteria = null;

	
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

	
	public function getDescription()
	{

		return $this->description;
	}

	
	public function getArPartyId()
	{

		return $this->ar_party_id;
	}

	
	public function getArRateCategoryId()
	{

		return $this->ar_rate_category_id;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ArOfficePeer::ID;
		}

	} 
	
	public function setName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = ArOfficePeer::NAME;
		}

	} 
	
	public function setDescription($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = ArOfficePeer::DESCRIPTION;
		}

	} 
	
	public function setArPartyId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ar_party_id !== $v) {
			$this->ar_party_id = $v;
			$this->modifiedColumns[] = ArOfficePeer::AR_PARTY_ID;
		}

		if ($this->aArParty !== null && $this->aArParty->getId() !== $v) {
			$this->aArParty = null;
		}

	} 
	
	public function setArRateCategoryId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ar_rate_category_id !== $v) {
			$this->ar_rate_category_id = $v;
			$this->modifiedColumns[] = ArOfficePeer::AR_RATE_CATEGORY_ID;
		}

		if ($this->aArRateCategory !== null && $this->aArRateCategory->getId() !== $v) {
			$this->aArRateCategory = null;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->name = $rs->getString($startcol + 1);

			$this->description = $rs->getString($startcol + 2);

			$this->ar_party_id = $rs->getInt($startcol + 3);

			$this->ar_rate_category_id = $rs->getInt($startcol + 4);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 5; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ArOffice object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArOfficePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArOfficePeer::doDelete($this, $con);
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
			$con = Propel::getConnection(ArOfficePeer::DATABASE_NAME);
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

			if ($this->aArRateCategory !== null) {
				if ($this->aArRateCategory->isModified()) {
					$affectedRows += $this->aArRateCategory->save($con);
				}
				$this->setArRateCategory($this->aArRateCategory);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ArOfficePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArOfficePeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collArAsteriskAccounts !== null) {
				foreach($this->collArAsteriskAccounts as $referrerFK) {
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

			if ($this->collArAsteriskAccountRanges !== null) {
				foreach($this->collArAsteriskAccountRanges as $referrerFK) {
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

			if ($this->aArRateCategory !== null) {
				if (!$this->aArRateCategory->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aArRateCategory->getValidationFailures());
				}
			}


			if (($retval = ArOfficePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collArAsteriskAccounts !== null) {
					foreach($this->collArAsteriskAccounts as $referrerFK) {
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

				if ($this->collArAsteriskAccountRanges !== null) {
					foreach($this->collArAsteriskAccountRanges as $referrerFK) {
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
		$pos = ArOfficePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getDescription();
				break;
			case 3:
				return $this->getArPartyId();
				break;
			case 4:
				return $this->getArRateCategoryId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArOfficePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getDescription(),
			$keys[3] => $this->getArPartyId(),
			$keys[4] => $this->getArRateCategoryId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArOfficePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setDescription($value);
				break;
			case 3:
				$this->setArPartyId($value);
				break;
			case 4:
				$this->setArRateCategoryId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArOfficePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDescription($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setArPartyId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setArRateCategoryId($arr[$keys[4]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArOfficePeer::DATABASE_NAME);

		if ($this->isColumnModified(ArOfficePeer::ID)) $criteria->add(ArOfficePeer::ID, $this->id);
		if ($this->isColumnModified(ArOfficePeer::NAME)) $criteria->add(ArOfficePeer::NAME, $this->name);
		if ($this->isColumnModified(ArOfficePeer::DESCRIPTION)) $criteria->add(ArOfficePeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(ArOfficePeer::AR_PARTY_ID)) $criteria->add(ArOfficePeer::AR_PARTY_ID, $this->ar_party_id);
		if ($this->isColumnModified(ArOfficePeer::AR_RATE_CATEGORY_ID)) $criteria->add(ArOfficePeer::AR_RATE_CATEGORY_ID, $this->ar_rate_category_id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArOfficePeer::DATABASE_NAME);

		$criteria->add(ArOfficePeer::ID, $this->id);

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

		$copyObj->setDescription($this->description);

		$copyObj->setArPartyId($this->ar_party_id);

		$copyObj->setArRateCategoryId($this->ar_rate_category_id);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getArAsteriskAccounts() as $relObj) {
				$copyObj->addArAsteriskAccount($relObj->copy($deepCopy));
			}

			foreach($this->getArWebAccounts() as $relObj) {
				$copyObj->addArWebAccount($relObj->copy($deepCopy));
			}

			foreach($this->getArAsteriskAccountRanges() as $relObj) {
				$copyObj->addArAsteriskAccountRange($relObj->copy($deepCopy));
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
			self::$peer = new ArOfficePeer();
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

	
	public function setArRateCategory($v)
	{


		if ($v === null) {
			$this->setArRateCategoryId(NULL);
		} else {
			$this->setArRateCategoryId($v->getId());
		}


		$this->aArRateCategory = $v;
	}


	
	public function getArRateCategory($con = null)
	{
		if ($this->aArRateCategory === null && ($this->ar_rate_category_id !== null)) {
						include_once 'lib/model/om/BaseArRateCategoryPeer.php';

			$this->aArRateCategory = ArRateCategoryPeer::retrieveByPK($this->ar_rate_category_id, $con);

			
		}
		return $this->aArRateCategory;
	}

	
	public function initArAsteriskAccounts()
	{
		if ($this->collArAsteriskAccounts === null) {
			$this->collArAsteriskAccounts = array();
		}
	}

	
	public function getArAsteriskAccounts($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArAsteriskAccountPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArAsteriskAccounts === null) {
			if ($this->isNew()) {
			   $this->collArAsteriskAccounts = array();
			} else {

				$criteria->add(ArAsteriskAccountPeer::AR_OFFICE_ID, $this->getId());

				ArAsteriskAccountPeer::addSelectColumns($criteria);
				$this->collArAsteriskAccounts = ArAsteriskAccountPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArAsteriskAccountPeer::AR_OFFICE_ID, $this->getId());

				ArAsteriskAccountPeer::addSelectColumns($criteria);
				if (!isset($this->lastArAsteriskAccountCriteria) || !$this->lastArAsteriskAccountCriteria->equals($criteria)) {
					$this->collArAsteriskAccounts = ArAsteriskAccountPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastArAsteriskAccountCriteria = $criteria;
		return $this->collArAsteriskAccounts;
	}

	
	public function countArAsteriskAccounts($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseArAsteriskAccountPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ArAsteriskAccountPeer::AR_OFFICE_ID, $this->getId());

		return ArAsteriskAccountPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArAsteriskAccount(ArAsteriskAccount $l)
	{
		$this->collArAsteriskAccounts[] = $l;
		$l->setArOffice($this);
	}


	
	public function getArAsteriskAccountsJoinArRateCategory($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArAsteriskAccountPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArAsteriskAccounts === null) {
			if ($this->isNew()) {
				$this->collArAsteriskAccounts = array();
			} else {

				$criteria->add(ArAsteriskAccountPeer::AR_OFFICE_ID, $this->getId());

				$this->collArAsteriskAccounts = ArAsteriskAccountPeer::doSelectJoinArRateCategory($criteria, $con);
			}
		} else {
									
			$criteria->add(ArAsteriskAccountPeer::AR_OFFICE_ID, $this->getId());

			if (!isset($this->lastArAsteriskAccountCriteria) || !$this->lastArAsteriskAccountCriteria->equals($criteria)) {
				$this->collArAsteriskAccounts = ArAsteriskAccountPeer::doSelectJoinArRateCategory($criteria, $con);
			}
		}
		$this->lastArAsteriskAccountCriteria = $criteria;

		return $this->collArAsteriskAccounts;
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

				$criteria->add(ArWebAccountPeer::AR_OFFICE_ID, $this->getId());

				ArWebAccountPeer::addSelectColumns($criteria);
				$this->collArWebAccounts = ArWebAccountPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArWebAccountPeer::AR_OFFICE_ID, $this->getId());

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

		$criteria->add(ArWebAccountPeer::AR_OFFICE_ID, $this->getId());

		return ArWebAccountPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArWebAccount(ArWebAccount $l)
	{
		$this->collArWebAccounts[] = $l;
		$l->setArOffice($this);
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

				$criteria->add(ArWebAccountPeer::AR_OFFICE_ID, $this->getId());

				$this->collArWebAccounts = ArWebAccountPeer::doSelectJoinArParty($criteria, $con);
			}
		} else {
									
			$criteria->add(ArWebAccountPeer::AR_OFFICE_ID, $this->getId());

			if (!isset($this->lastArWebAccountCriteria) || !$this->lastArWebAccountCriteria->equals($criteria)) {
				$this->collArWebAccounts = ArWebAccountPeer::doSelectJoinArParty($criteria, $con);
			}
		}
		$this->lastArWebAccountCriteria = $criteria;

		return $this->collArWebAccounts;
	}


	
	public function getArWebAccountsJoinArParams($criteria = null, $con = null)
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

				$criteria->add(ArWebAccountPeer::AR_OFFICE_ID, $this->getId());

				$this->collArWebAccounts = ArWebAccountPeer::doSelectJoinArParams($criteria, $con);
			}
		} else {
									
			$criteria->add(ArWebAccountPeer::AR_OFFICE_ID, $this->getId());

			if (!isset($this->lastArWebAccountCriteria) || !$this->lastArWebAccountCriteria->equals($criteria)) {
				$this->collArWebAccounts = ArWebAccountPeer::doSelectJoinArParams($criteria, $con);
			}
		}
		$this->lastArWebAccountCriteria = $criteria;

		return $this->collArWebAccounts;
	}

	
	public function initArAsteriskAccountRanges()
	{
		if ($this->collArAsteriskAccountRanges === null) {
			$this->collArAsteriskAccountRanges = array();
		}
	}

	
	public function getArAsteriskAccountRanges($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArAsteriskAccountRangePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArAsteriskAccountRanges === null) {
			if ($this->isNew()) {
			   $this->collArAsteriskAccountRanges = array();
			} else {

				$criteria->add(ArAsteriskAccountRangePeer::AR_OFFICE_ID, $this->getId());

				ArAsteriskAccountRangePeer::addSelectColumns($criteria);
				$this->collArAsteriskAccountRanges = ArAsteriskAccountRangePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArAsteriskAccountRangePeer::AR_OFFICE_ID, $this->getId());

				ArAsteriskAccountRangePeer::addSelectColumns($criteria);
				if (!isset($this->lastArAsteriskAccountRangeCriteria) || !$this->lastArAsteriskAccountRangeCriteria->equals($criteria)) {
					$this->collArAsteriskAccountRanges = ArAsteriskAccountRangePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastArAsteriskAccountRangeCriteria = $criteria;
		return $this->collArAsteriskAccountRanges;
	}

	
	public function countArAsteriskAccountRanges($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseArAsteriskAccountRangePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ArAsteriskAccountRangePeer::AR_OFFICE_ID, $this->getId());

		return ArAsteriskAccountRangePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArAsteriskAccountRange(ArAsteriskAccountRange $l)
	{
		$this->collArAsteriskAccountRanges[] = $l;
		$l->setArOffice($this);
	}

} 