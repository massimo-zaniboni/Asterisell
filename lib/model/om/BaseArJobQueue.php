<?php


abstract class BaseArJobQueue extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $is_part_of;


	
	protected $state = 0;


	
	protected $created_at;


	
	protected $start_at;


	
	protected $end_at;


	
	protected $description;


	
	protected $php_data_job_serialization;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getIsPartOf()
	{

		return $this->is_part_of;
	}

	
	public function getState()
	{

		return $this->state;
	}

	
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->created_at === null || $this->created_at === '') {
			return null;
		} elseif (!is_int($this->created_at)) {
						$ts = strtotime($this->created_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [created_at] as date/time value: " . var_export($this->created_at, true));
			}
		} else {
			$ts = $this->created_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getStartAt($format = 'Y-m-d H:i:s')
	{

		if ($this->start_at === null || $this->start_at === '') {
			return null;
		} elseif (!is_int($this->start_at)) {
						$ts = strtotime($this->start_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [start_at] as date/time value: " . var_export($this->start_at, true));
			}
		} else {
			$ts = $this->start_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getEndAt($format = 'Y-m-d H:i:s')
	{

		if ($this->end_at === null || $this->end_at === '') {
			return null;
		} elseif (!is_int($this->end_at)) {
						$ts = strtotime($this->end_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [end_at] as date/time value: " . var_export($this->end_at, true));
			}
		} else {
			$ts = $this->end_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getDescription()
	{

		return $this->description;
	}

	
	public function getPhpDataJobSerialization()
	{

		return $this->php_data_job_serialization;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ArJobQueuePeer::ID;
		}

	} 
	
	public function setIsPartOf($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->is_part_of !== $v) {
			$this->is_part_of = $v;
			$this->modifiedColumns[] = ArJobQueuePeer::IS_PART_OF;
		}

	} 
	
	public function setState($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->state !== $v || $v === 0) {
			$this->state = $v;
			$this->modifiedColumns[] = ArJobQueuePeer::STATE;
		}

	} 
	
	public function setCreatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [created_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->created_at !== $ts) {
			$this->created_at = $ts;
			$this->modifiedColumns[] = ArJobQueuePeer::CREATED_AT;
		}

	} 
	
	public function setStartAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [start_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->start_at !== $ts) {
			$this->start_at = $ts;
			$this->modifiedColumns[] = ArJobQueuePeer::START_AT;
		}

	} 
	
	public function setEndAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [end_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->end_at !== $ts) {
			$this->end_at = $ts;
			$this->modifiedColumns[] = ArJobQueuePeer::END_AT;
		}

	} 
	
	public function setDescription($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = ArJobQueuePeer::DESCRIPTION;
		}

	} 
	
	public function setPhpDataJobSerialization($v)
	{

								if ($v instanceof Lob && $v === $this->php_data_job_serialization) {
			$changed = $v->isModified();
		} else {
			$changed = ($this->php_data_job_serialization !== $v);
		}
		if ($changed) {
			if ( !($v instanceof Lob) ) {
				$obj = new Clob();
				$obj->setContents($v);
			} else {
				$obj = $v;
			}
			$this->php_data_job_serialization = $obj;
			$this->modifiedColumns[] = ArJobQueuePeer::PHP_DATA_JOB_SERIALIZATION;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->is_part_of = $rs->getInt($startcol + 1);

			$this->state = $rs->getInt($startcol + 2);

			$this->created_at = $rs->getTimestamp($startcol + 3, null);

			$this->start_at = $rs->getTimestamp($startcol + 4, null);

			$this->end_at = $rs->getTimestamp($startcol + 5, null);

			$this->description = $rs->getString($startcol + 6);

			$this->php_data_job_serialization = $rs->getClob($startcol + 7);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 8; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ArJobQueue object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArJobQueuePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArJobQueuePeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(ArJobQueuePeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArJobQueuePeer::DATABASE_NAME);
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
					$pk = ArJobQueuePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArJobQueuePeer::doUpdate($this, $con);
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


			if (($retval = ArJobQueuePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArJobQueuePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getIsPartOf();
				break;
			case 2:
				return $this->getState();
				break;
			case 3:
				return $this->getCreatedAt();
				break;
			case 4:
				return $this->getStartAt();
				break;
			case 5:
				return $this->getEndAt();
				break;
			case 6:
				return $this->getDescription();
				break;
			case 7:
				return $this->getPhpDataJobSerialization();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArJobQueuePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getIsPartOf(),
			$keys[2] => $this->getState(),
			$keys[3] => $this->getCreatedAt(),
			$keys[4] => $this->getStartAt(),
			$keys[5] => $this->getEndAt(),
			$keys[6] => $this->getDescription(),
			$keys[7] => $this->getPhpDataJobSerialization(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArJobQueuePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setIsPartOf($value);
				break;
			case 2:
				$this->setState($value);
				break;
			case 3:
				$this->setCreatedAt($value);
				break;
			case 4:
				$this->setStartAt($value);
				break;
			case 5:
				$this->setEndAt($value);
				break;
			case 6:
				$this->setDescription($value);
				break;
			case 7:
				$this->setPhpDataJobSerialization($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArJobQueuePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setIsPartOf($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setState($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setCreatedAt($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setStartAt($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setEndAt($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setDescription($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setPhpDataJobSerialization($arr[$keys[7]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArJobQueuePeer::DATABASE_NAME);

		if ($this->isColumnModified(ArJobQueuePeer::ID)) $criteria->add(ArJobQueuePeer::ID, $this->id);
		if ($this->isColumnModified(ArJobQueuePeer::IS_PART_OF)) $criteria->add(ArJobQueuePeer::IS_PART_OF, $this->is_part_of);
		if ($this->isColumnModified(ArJobQueuePeer::STATE)) $criteria->add(ArJobQueuePeer::STATE, $this->state);
		if ($this->isColumnModified(ArJobQueuePeer::CREATED_AT)) $criteria->add(ArJobQueuePeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(ArJobQueuePeer::START_AT)) $criteria->add(ArJobQueuePeer::START_AT, $this->start_at);
		if ($this->isColumnModified(ArJobQueuePeer::END_AT)) $criteria->add(ArJobQueuePeer::END_AT, $this->end_at);
		if ($this->isColumnModified(ArJobQueuePeer::DESCRIPTION)) $criteria->add(ArJobQueuePeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(ArJobQueuePeer::PHP_DATA_JOB_SERIALIZATION)) $criteria->add(ArJobQueuePeer::PHP_DATA_JOB_SERIALIZATION, $this->php_data_job_serialization);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArJobQueuePeer::DATABASE_NAME);

		$criteria->add(ArJobQueuePeer::ID, $this->id);

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

		$copyObj->setIsPartOf($this->is_part_of);

		$copyObj->setState($this->state);

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setStartAt($this->start_at);

		$copyObj->setEndAt($this->end_at);

		$copyObj->setDescription($this->description);

		$copyObj->setPhpDataJobSerialization($this->php_data_job_serialization);


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
			self::$peer = new ArJobQueuePeer();
		}
		return self::$peer;
	}

} 