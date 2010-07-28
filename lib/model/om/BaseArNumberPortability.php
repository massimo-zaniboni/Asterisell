<?php


abstract class BaseArNumberPortability extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $telephone_number;


	
	protected $ported_telephone_number;


	
	protected $from_date;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getTelephoneNumber()
	{

		return $this->telephone_number;
	}

	
	public function getPortedTelephoneNumber()
	{

		return $this->ported_telephone_number;
	}

	
	public function getFromDate($format = 'Y-m-d H:i:s')
	{

		if ($this->from_date === null || $this->from_date === '') {
			return null;
		} elseif (!is_int($this->from_date)) {
						$ts = strtotime($this->from_date);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [from_date] as date/time value: " . var_export($this->from_date, true));
			}
		} else {
			$ts = $this->from_date;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ArNumberPortabilityPeer::ID;
		}

	} 
	
	public function setTelephoneNumber($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->telephone_number !== $v) {
			$this->telephone_number = $v;
			$this->modifiedColumns[] = ArNumberPortabilityPeer::TELEPHONE_NUMBER;
		}

	} 
	
	public function setPortedTelephoneNumber($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->ported_telephone_number !== $v) {
			$this->ported_telephone_number = $v;
			$this->modifiedColumns[] = ArNumberPortabilityPeer::PORTED_TELEPHONE_NUMBER;
		}

	} 
	
	public function setFromDate($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [from_date] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->from_date !== $ts) {
			$this->from_date = $ts;
			$this->modifiedColumns[] = ArNumberPortabilityPeer::FROM_DATE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->telephone_number = $rs->getString($startcol + 1);

			$this->ported_telephone_number = $rs->getString($startcol + 2);

			$this->from_date = $rs->getTimestamp($startcol + 3, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 4; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ArNumberPortability object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArNumberPortabilityPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArNumberPortabilityPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(ArNumberPortabilityPeer::DATABASE_NAME);
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
					$pk = ArNumberPortabilityPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArNumberPortabilityPeer::doUpdate($this, $con);
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


			if (($retval = ArNumberPortabilityPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArNumberPortabilityPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getTelephoneNumber();
				break;
			case 2:
				return $this->getPortedTelephoneNumber();
				break;
			case 3:
				return $this->getFromDate();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArNumberPortabilityPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getTelephoneNumber(),
			$keys[2] => $this->getPortedTelephoneNumber(),
			$keys[3] => $this->getFromDate(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArNumberPortabilityPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setTelephoneNumber($value);
				break;
			case 2:
				$this->setPortedTelephoneNumber($value);
				break;
			case 3:
				$this->setFromDate($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArNumberPortabilityPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setTelephoneNumber($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setPortedTelephoneNumber($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setFromDate($arr[$keys[3]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArNumberPortabilityPeer::DATABASE_NAME);

		if ($this->isColumnModified(ArNumberPortabilityPeer::ID)) $criteria->add(ArNumberPortabilityPeer::ID, $this->id);
		if ($this->isColumnModified(ArNumberPortabilityPeer::TELEPHONE_NUMBER)) $criteria->add(ArNumberPortabilityPeer::TELEPHONE_NUMBER, $this->telephone_number);
		if ($this->isColumnModified(ArNumberPortabilityPeer::PORTED_TELEPHONE_NUMBER)) $criteria->add(ArNumberPortabilityPeer::PORTED_TELEPHONE_NUMBER, $this->ported_telephone_number);
		if ($this->isColumnModified(ArNumberPortabilityPeer::FROM_DATE)) $criteria->add(ArNumberPortabilityPeer::FROM_DATE, $this->from_date);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArNumberPortabilityPeer::DATABASE_NAME);

		$criteria->add(ArNumberPortabilityPeer::ID, $this->id);

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

		$copyObj->setTelephoneNumber($this->telephone_number);

		$copyObj->setPortedTelephoneNumber($this->ported_telephone_number);

		$copyObj->setFromDate($this->from_date);


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
			self::$peer = new ArNumberPortabilityPeer();
		}
		return self::$peer;
	}

} 