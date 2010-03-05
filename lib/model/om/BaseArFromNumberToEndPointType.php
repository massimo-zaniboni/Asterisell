<?php


abstract class BaseArFromNumberToEndPointType extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $number_prefix;


	
	protected $ar_call_end_point_type_id;


	
	protected $id;

	
	protected $aArCallEndPointType;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getNumberPrefix()
	{

		return $this->number_prefix;
	}

	
	public function getArCallEndPointTypeId()
	{

		return $this->ar_call_end_point_type_id;
	}

	
	public function getId()
	{

		return $this->id;
	}

	
	public function setNumberPrefix($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->number_prefix !== $v) {
			$this->number_prefix = $v;
			$this->modifiedColumns[] = ArFromNumberToEndPointTypePeer::NUMBER_PREFIX;
		}

	} 
	
	public function setArCallEndPointTypeId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ar_call_end_point_type_id !== $v) {
			$this->ar_call_end_point_type_id = $v;
			$this->modifiedColumns[] = ArFromNumberToEndPointTypePeer::AR_CALL_END_POINT_TYPE_ID;
		}

		if ($this->aArCallEndPointType !== null && $this->aArCallEndPointType->getId() !== $v) {
			$this->aArCallEndPointType = null;
		}

	} 
	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ArFromNumberToEndPointTypePeer::ID;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->number_prefix = $rs->getString($startcol + 0);

			$this->ar_call_end_point_type_id = $rs->getInt($startcol + 1);

			$this->id = $rs->getInt($startcol + 2);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 3; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ArFromNumberToEndPointType object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArFromNumberToEndPointTypePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArFromNumberToEndPointTypePeer::doDelete($this, $con);
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
			$con = Propel::getConnection(ArFromNumberToEndPointTypePeer::DATABASE_NAME);
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


												
			if ($this->aArCallEndPointType !== null) {
				if ($this->aArCallEndPointType->isModified()) {
					$affectedRows += $this->aArCallEndPointType->save($con);
				}
				$this->setArCallEndPointType($this->aArCallEndPointType);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ArFromNumberToEndPointTypePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArFromNumberToEndPointTypePeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

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


												
			if ($this->aArCallEndPointType !== null) {
				if (!$this->aArCallEndPointType->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aArCallEndPointType->getValidationFailures());
				}
			}


			if (($retval = ArFromNumberToEndPointTypePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArFromNumberToEndPointTypePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getNumberPrefix();
				break;
			case 1:
				return $this->getArCallEndPointTypeId();
				break;
			case 2:
				return $this->getId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArFromNumberToEndPointTypePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getNumberPrefix(),
			$keys[1] => $this->getArCallEndPointTypeId(),
			$keys[2] => $this->getId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArFromNumberToEndPointTypePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setNumberPrefix($value);
				break;
			case 1:
				$this->setArCallEndPointTypeId($value);
				break;
			case 2:
				$this->setId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArFromNumberToEndPointTypePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setNumberPrefix($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setArCallEndPointTypeId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setId($arr[$keys[2]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArFromNumberToEndPointTypePeer::DATABASE_NAME);

		if ($this->isColumnModified(ArFromNumberToEndPointTypePeer::NUMBER_PREFIX)) $criteria->add(ArFromNumberToEndPointTypePeer::NUMBER_PREFIX, $this->number_prefix);
		if ($this->isColumnModified(ArFromNumberToEndPointTypePeer::AR_CALL_END_POINT_TYPE_ID)) $criteria->add(ArFromNumberToEndPointTypePeer::AR_CALL_END_POINT_TYPE_ID, $this->ar_call_end_point_type_id);
		if ($this->isColumnModified(ArFromNumberToEndPointTypePeer::ID)) $criteria->add(ArFromNumberToEndPointTypePeer::ID, $this->id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArFromNumberToEndPointTypePeer::DATABASE_NAME);

		$criteria->add(ArFromNumberToEndPointTypePeer::ID, $this->id);

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

		$copyObj->setNumberPrefix($this->number_prefix);

		$copyObj->setArCallEndPointTypeId($this->ar_call_end_point_type_id);


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
			self::$peer = new ArFromNumberToEndPointTypePeer();
		}
		return self::$peer;
	}

	
	public function setArCallEndPointType($v)
	{


		if ($v === null) {
			$this->setArCallEndPointTypeId(NULL);
		} else {
			$this->setArCallEndPointTypeId($v->getId());
		}


		$this->aArCallEndPointType = $v;
	}


	
	public function getArCallEndPointType($con = null)
	{
				include_once 'lib/model/om/BaseArCallEndPointTypePeer.php';

		if ($this->aArCallEndPointType === null && ($this->ar_call_end_point_type_id !== null)) {

			$this->aArCallEndPointType = ArCallEndPointTypePeer::retrieveByPK($this->ar_call_end_point_type_id, $con);

			
		}
		return $this->aArCallEndPointType;
	}

} 