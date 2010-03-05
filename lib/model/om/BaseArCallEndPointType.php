<?php


abstract class BaseArCallEndPointType extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $name;


	
	protected $code;

	
	protected $collCdrs;

	
	protected $lastCdrCriteria = null;

	
	protected $collArFromNumberToEndPointTypes;

	
	protected $lastArFromNumberToEndPointTypeCriteria = null;

	
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

	
	public function getCode()
	{

		return $this->code;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ArCallEndPointTypePeer::ID;
		}

	} 
	
	public function setName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = ArCallEndPointTypePeer::NAME;
		}

	} 
	
	public function setCode($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->code !== $v) {
			$this->code = $v;
			$this->modifiedColumns[] = ArCallEndPointTypePeer::CODE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->name = $rs->getString($startcol + 1);

			$this->code = $rs->getString($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ArCallEndPointType object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArCallEndPointTypePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArCallEndPointTypePeer::doDelete($this, $con);
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
			$con = Propel::getConnection(ArCallEndPointTypePeer::DATABASE_NAME);
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
					$pk = ArCallEndPointTypePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArCallEndPointTypePeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collCdrs !== null) {
				foreach($this->collCdrs as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collArFromNumberToEndPointTypes !== null) {
				foreach($this->collArFromNumberToEndPointTypes as $referrerFK) {
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


			if (($retval = ArCallEndPointTypePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collCdrs !== null) {
					foreach($this->collCdrs as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collArFromNumberToEndPointTypes !== null) {
					foreach($this->collArFromNumberToEndPointTypes as $referrerFK) {
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
		$pos = ArCallEndPointTypePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getCode();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArCallEndPointTypePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getCode(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArCallEndPointTypePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setCode($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArCallEndPointTypePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setCode($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArCallEndPointTypePeer::DATABASE_NAME);

		if ($this->isColumnModified(ArCallEndPointTypePeer::ID)) $criteria->add(ArCallEndPointTypePeer::ID, $this->id);
		if ($this->isColumnModified(ArCallEndPointTypePeer::NAME)) $criteria->add(ArCallEndPointTypePeer::NAME, $this->name);
		if ($this->isColumnModified(ArCallEndPointTypePeer::CODE)) $criteria->add(ArCallEndPointTypePeer::CODE, $this->code);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArCallEndPointTypePeer::DATABASE_NAME);

		$criteria->add(ArCallEndPointTypePeer::ID, $this->id);

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

		$copyObj->setCode($this->code);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getCdrs() as $relObj) {
				$copyObj->addCdr($relObj->copy($deepCopy));
			}

			foreach($this->getArFromNumberToEndPointTypes() as $relObj) {
				$copyObj->addArFromNumberToEndPointType($relObj->copy($deepCopy));
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
			self::$peer = new ArCallEndPointTypePeer();
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

				$criteria->add(CdrPeer::AR_CALL_END_POINT_TYPE_ID, $this->getId());

				CdrPeer::addSelectColumns($criteria);
				$this->collCdrs = CdrPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(CdrPeer::AR_CALL_END_POINT_TYPE_ID, $this->getId());

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

		$criteria->add(CdrPeer::AR_CALL_END_POINT_TYPE_ID, $this->getId());

		return CdrPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addCdr(Cdr $l)
	{
		$this->collCdrs[] = $l;
		$l->setArCallEndPointType($this);
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

				$criteria->add(CdrPeer::AR_CALL_END_POINT_TYPE_ID, $this->getId());

				$this->collCdrs = CdrPeer::doSelectJoinArAsteriskAccount($criteria, $con);
			}
		} else {
									
			$criteria->add(CdrPeer::AR_CALL_END_POINT_TYPE_ID, $this->getId());

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

				$criteria->add(CdrPeer::AR_CALL_END_POINT_TYPE_ID, $this->getId());

				$this->collCdrs = CdrPeer::doSelectJoinArRateRelatedByIncomeArRateId($criteria, $con);
			}
		} else {
									
			$criteria->add(CdrPeer::AR_CALL_END_POINT_TYPE_ID, $this->getId());

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

				$criteria->add(CdrPeer::AR_CALL_END_POINT_TYPE_ID, $this->getId());

				$this->collCdrs = CdrPeer::doSelectJoinArRateRelatedByCostArRateId($criteria, $con);
			}
		} else {
									
			$criteria->add(CdrPeer::AR_CALL_END_POINT_TYPE_ID, $this->getId());

			if (!isset($this->lastCdrCriteria) || !$this->lastCdrCriteria->equals($criteria)) {
				$this->collCdrs = CdrPeer::doSelectJoinArRateRelatedByCostArRateId($criteria, $con);
			}
		}
		$this->lastCdrCriteria = $criteria;

		return $this->collCdrs;
	}

	
	public function initArFromNumberToEndPointTypes()
	{
		if ($this->collArFromNumberToEndPointTypes === null) {
			$this->collArFromNumberToEndPointTypes = array();
		}
	}

	
	public function getArFromNumberToEndPointTypes($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArFromNumberToEndPointTypePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArFromNumberToEndPointTypes === null) {
			if ($this->isNew()) {
			   $this->collArFromNumberToEndPointTypes = array();
			} else {

				$criteria->add(ArFromNumberToEndPointTypePeer::AR_CALL_END_POINT_TYPE_ID, $this->getId());

				ArFromNumberToEndPointTypePeer::addSelectColumns($criteria);
				$this->collArFromNumberToEndPointTypes = ArFromNumberToEndPointTypePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArFromNumberToEndPointTypePeer::AR_CALL_END_POINT_TYPE_ID, $this->getId());

				ArFromNumberToEndPointTypePeer::addSelectColumns($criteria);
				if (!isset($this->lastArFromNumberToEndPointTypeCriteria) || !$this->lastArFromNumberToEndPointTypeCriteria->equals($criteria)) {
					$this->collArFromNumberToEndPointTypes = ArFromNumberToEndPointTypePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastArFromNumberToEndPointTypeCriteria = $criteria;
		return $this->collArFromNumberToEndPointTypes;
	}

	
	public function countArFromNumberToEndPointTypes($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseArFromNumberToEndPointTypePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ArFromNumberToEndPointTypePeer::AR_CALL_END_POINT_TYPE_ID, $this->getId());

		return ArFromNumberToEndPointTypePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArFromNumberToEndPointType(ArFromNumberToEndPointType $l)
	{
		$this->collArFromNumberToEndPointTypes[] = $l;
		$l->setArCallEndPointType($this);
	}

} 