<?php


abstract class BaseArTelephonePrefix extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $prefix;


	
	protected $name;


	
	protected $geographic_location;


	
	protected $operator_type;


	
	protected $never_mask_number = false;

	
	protected $collCdrs;

	
	protected $lastCdrCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getPrefix()
	{

		return $this->prefix;
	}

	
	public function getName()
	{

		return $this->name;
	}

	
	public function getGeographicLocation()
	{

		return $this->geographic_location;
	}

	
	public function getOperatorType()
	{

		return $this->operator_type;
	}

	
	public function getNeverMaskNumber()
	{

		return $this->never_mask_number;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ArTelephonePrefixPeer::ID;
		}

	} 
	
	public function setPrefix($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->prefix !== $v) {
			$this->prefix = $v;
			$this->modifiedColumns[] = ArTelephonePrefixPeer::PREFIX;
		}

	} 
	
	public function setName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = ArTelephonePrefixPeer::NAME;
		}

	} 
	
	public function setGeographicLocation($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->geographic_location !== $v) {
			$this->geographic_location = $v;
			$this->modifiedColumns[] = ArTelephonePrefixPeer::GEOGRAPHIC_LOCATION;
		}

	} 
	
	public function setOperatorType($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->operator_type !== $v) {
			$this->operator_type = $v;
			$this->modifiedColumns[] = ArTelephonePrefixPeer::OPERATOR_TYPE;
		}

	} 
	
	public function setNeverMaskNumber($v)
	{

		if ($this->never_mask_number !== $v || $v === false) {
			$this->never_mask_number = $v;
			$this->modifiedColumns[] = ArTelephonePrefixPeer::NEVER_MASK_NUMBER;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->prefix = $rs->getString($startcol + 1);

			$this->name = $rs->getString($startcol + 2);

			$this->geographic_location = $rs->getString($startcol + 3);

			$this->operator_type = $rs->getString($startcol + 4);

			$this->never_mask_number = $rs->getBoolean($startcol + 5);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 6; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ArTelephonePrefix object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArTelephonePrefixPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArTelephonePrefixPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(ArTelephonePrefixPeer::DATABASE_NAME);
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
					$pk = ArTelephonePrefixPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArTelephonePrefixPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collCdrs !== null) {
				foreach($this->collCdrs as $referrerFK) {
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


			if (($retval = ArTelephonePrefixPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collCdrs !== null) {
					foreach($this->collCdrs as $referrerFK) {
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
		$pos = ArTelephonePrefixPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getPrefix();
				break;
			case 2:
				return $this->getName();
				break;
			case 3:
				return $this->getGeographicLocation();
				break;
			case 4:
				return $this->getOperatorType();
				break;
			case 5:
				return $this->getNeverMaskNumber();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArTelephonePrefixPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getPrefix(),
			$keys[2] => $this->getName(),
			$keys[3] => $this->getGeographicLocation(),
			$keys[4] => $this->getOperatorType(),
			$keys[5] => $this->getNeverMaskNumber(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArTelephonePrefixPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setPrefix($value);
				break;
			case 2:
				$this->setName($value);
				break;
			case 3:
				$this->setGeographicLocation($value);
				break;
			case 4:
				$this->setOperatorType($value);
				break;
			case 5:
				$this->setNeverMaskNumber($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArTelephonePrefixPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setPrefix($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setGeographicLocation($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setOperatorType($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setNeverMaskNumber($arr[$keys[5]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArTelephonePrefixPeer::DATABASE_NAME);

		if ($this->isColumnModified(ArTelephonePrefixPeer::ID)) $criteria->add(ArTelephonePrefixPeer::ID, $this->id);
		if ($this->isColumnModified(ArTelephonePrefixPeer::PREFIX)) $criteria->add(ArTelephonePrefixPeer::PREFIX, $this->prefix);
		if ($this->isColumnModified(ArTelephonePrefixPeer::NAME)) $criteria->add(ArTelephonePrefixPeer::NAME, $this->name);
		if ($this->isColumnModified(ArTelephonePrefixPeer::GEOGRAPHIC_LOCATION)) $criteria->add(ArTelephonePrefixPeer::GEOGRAPHIC_LOCATION, $this->geographic_location);
		if ($this->isColumnModified(ArTelephonePrefixPeer::OPERATOR_TYPE)) $criteria->add(ArTelephonePrefixPeer::OPERATOR_TYPE, $this->operator_type);
		if ($this->isColumnModified(ArTelephonePrefixPeer::NEVER_MASK_NUMBER)) $criteria->add(ArTelephonePrefixPeer::NEVER_MASK_NUMBER, $this->never_mask_number);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArTelephonePrefixPeer::DATABASE_NAME);

		$criteria->add(ArTelephonePrefixPeer::ID, $this->id);

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

		$copyObj->setPrefix($this->prefix);

		$copyObj->setName($this->name);

		$copyObj->setGeographicLocation($this->geographic_location);

		$copyObj->setOperatorType($this->operator_type);

		$copyObj->setNeverMaskNumber($this->never_mask_number);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getCdrs() as $relObj) {
				$copyObj->addCdr($relObj->copy($deepCopy));
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
			self::$peer = new ArTelephonePrefixPeer();
		}
		return self::$peer;
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

				$criteria->add(CdrPeer::AR_TELEPHONE_PREFIX_ID, $this->getId());

				CdrPeer::addSelectColumns($criteria);
				$this->collCdrs = CdrPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(CdrPeer::AR_TELEPHONE_PREFIX_ID, $this->getId());

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

		$criteria->add(CdrPeer::AR_TELEPHONE_PREFIX_ID, $this->getId());

		return CdrPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addCdr(Cdr $l)
	{
		$this->collCdrs[] = $l;
		$l->setArTelephonePrefix($this);
	}


	
	public function getCdrsJoinArAsteriskAccount($criteria = null, $con = null)
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

				$criteria->add(CdrPeer::AR_TELEPHONE_PREFIX_ID, $this->getId());

				$this->collCdrs = CdrPeer::doSelectJoinArAsteriskAccount($criteria, $con);
			}
		} else {
									
			$criteria->add(CdrPeer::AR_TELEPHONE_PREFIX_ID, $this->getId());

			if (!isset($this->lastCdrCriteria) || !$this->lastCdrCriteria->equals($criteria)) {
				$this->collCdrs = CdrPeer::doSelectJoinArAsteriskAccount($criteria, $con);
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

				$criteria->add(CdrPeer::AR_TELEPHONE_PREFIX_ID, $this->getId());

				$this->collCdrs = CdrPeer::doSelectJoinArRateRelatedByIncomeArRateId($criteria, $con);
			}
		} else {
									
			$criteria->add(CdrPeer::AR_TELEPHONE_PREFIX_ID, $this->getId());

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

				$criteria->add(CdrPeer::AR_TELEPHONE_PREFIX_ID, $this->getId());

				$this->collCdrs = CdrPeer::doSelectJoinArRateRelatedByCostArRateId($criteria, $con);
			}
		} else {
									
			$criteria->add(CdrPeer::AR_TELEPHONE_PREFIX_ID, $this->getId());

			if (!isset($this->lastCdrCriteria) || !$this->lastCdrCriteria->equals($criteria)) {
				$this->collCdrs = CdrPeer::doSelectJoinArRateRelatedByCostArRateId($criteria, $con);
			}
		}
		$this->lastCdrCriteria = $criteria;

		return $this->collCdrs;
	}

} 