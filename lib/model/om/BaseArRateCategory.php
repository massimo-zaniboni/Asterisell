<?php


abstract class BaseArRateCategory extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $name;

	
	protected $collArPartys;

	
	protected $lastArPartyCriteria = null;

	
	protected $collArRates;

	
	protected $lastArRateCriteria = null;

	
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

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ArRateCategoryPeer::ID;
		}

	} 
	
	public function setName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = ArRateCategoryPeer::NAME;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->name = $rs->getString($startcol + 1);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 2; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ArRateCategory object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArRateCategoryPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArRateCategoryPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(ArRateCategoryPeer::DATABASE_NAME);
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


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ArRateCategoryPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArRateCategoryPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collArPartys !== null) {
				foreach($this->collArPartys as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collArRates !== null) {
				foreach($this->collArRates as $referrerFK) {
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


			if (($retval = ArRateCategoryPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collArPartys !== null) {
					foreach($this->collArPartys as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collArRates !== null) {
					foreach($this->collArRates as $referrerFK) {
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
		$pos = ArRateCategoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArRateCategoryPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArRateCategoryPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArRateCategoryPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArRateCategoryPeer::DATABASE_NAME);

		if ($this->isColumnModified(ArRateCategoryPeer::ID)) $criteria->add(ArRateCategoryPeer::ID, $this->id);
		if ($this->isColumnModified(ArRateCategoryPeer::NAME)) $criteria->add(ArRateCategoryPeer::NAME, $this->name);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArRateCategoryPeer::DATABASE_NAME);

		$criteria->add(ArRateCategoryPeer::ID, $this->id);

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


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getArPartys() as $relObj) {
				$copyObj->addArParty($relObj->copy($deepCopy));
			}

			foreach($this->getArRates() as $relObj) {
				$copyObj->addArRate($relObj->copy($deepCopy));
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
			self::$peer = new ArRateCategoryPeer();
		}
		return self::$peer;
	}

	
	public function initArPartys()
	{
		if ($this->collArPartys === null) {
			$this->collArPartys = array();
		}
	}

	
	public function getArPartys($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArPartyPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArPartys === null) {
			if ($this->isNew()) {
			   $this->collArPartys = array();
			} else {

				$criteria->add(ArPartyPeer::AR_RATE_CATEGORY_ID, $this->getId());

				ArPartyPeer::addSelectColumns($criteria);
				$this->collArPartys = ArPartyPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArPartyPeer::AR_RATE_CATEGORY_ID, $this->getId());

				ArPartyPeer::addSelectColumns($criteria);
				if (!isset($this->lastArPartyCriteria) || !$this->lastArPartyCriteria->equals($criteria)) {
					$this->collArPartys = ArPartyPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastArPartyCriteria = $criteria;
		return $this->collArPartys;
	}

	
	public function countArPartys($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseArPartyPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ArPartyPeer::AR_RATE_CATEGORY_ID, $this->getId());

		return ArPartyPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArParty(ArParty $l)
	{
		$this->collArPartys[] = $l;
		$l->setArRateCategory($this);
	}

	
	public function initArRates()
	{
		if ($this->collArRates === null) {
			$this->collArRates = array();
		}
	}

	
	public function getArRates($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArRatePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArRates === null) {
			if ($this->isNew()) {
			   $this->collArRates = array();
			} else {

				$criteria->add(ArRatePeer::AR_RATE_CATEGORY_ID, $this->getId());

				ArRatePeer::addSelectColumns($criteria);
				$this->collArRates = ArRatePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArRatePeer::AR_RATE_CATEGORY_ID, $this->getId());

				ArRatePeer::addSelectColumns($criteria);
				if (!isset($this->lastArRateCriteria) || !$this->lastArRateCriteria->equals($criteria)) {
					$this->collArRates = ArRatePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastArRateCriteria = $criteria;
		return $this->collArRates;
	}

	
	public function countArRates($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseArRatePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ArRatePeer::AR_RATE_CATEGORY_ID, $this->getId());

		return ArRatePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArRate(ArRate $l)
	{
		$this->collArRates[] = $l;
		$l->setArRateCategory($this);
	}


	
	public function getArRatesJoinArParty($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArRatePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArRates === null) {
			if ($this->isNew()) {
				$this->collArRates = array();
			} else {

				$criteria->add(ArRatePeer::AR_RATE_CATEGORY_ID, $this->getId());

				$this->collArRates = ArRatePeer::doSelectJoinArParty($criteria, $con);
			}
		} else {
									
			$criteria->add(ArRatePeer::AR_RATE_CATEGORY_ID, $this->getId());

			if (!isset($this->lastArRateCriteria) || !$this->lastArRateCriteria->equals($criteria)) {
				$this->collArRates = ArRatePeer::doSelectJoinArParty($criteria, $con);
			}
		}
		$this->lastArRateCriteria = $criteria;

		return $this->collArRates;
	}

} 