<?php


abstract class BaseArAsteriskAccountRangeCreation extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $ar_office_id;


	
	protected $prefix;


	
	protected $suffix;


	
	protected $start_range;


	
	protected $end_range;


	
	protected $leading_zero;


	
	protected $is_delete = false;


	
	protected $is_physical_delete = false;


	
	protected $user_note;

	
	protected $aArOffice;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getArOfficeId()
	{

		return $this->ar_office_id;
	}

	
	public function getPrefix()
	{

		return $this->prefix;
	}

	
	public function getSuffix()
	{

		return $this->suffix;
	}

	
	public function getStartRange()
	{

		return $this->start_range;
	}

	
	public function getEndRange()
	{

		return $this->end_range;
	}

	
	public function getLeadingZero()
	{

		return $this->leading_zero;
	}

	
	public function getIsDelete()
	{

		return $this->is_delete;
	}

	
	public function getIsPhysicalDelete()
	{

		return $this->is_physical_delete;
	}

	
	public function getUserNote()
	{

		return $this->user_note;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ArAsteriskAccountRangeCreationPeer::ID;
		}

	} 
	
	public function setArOfficeId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ar_office_id !== $v) {
			$this->ar_office_id = $v;
			$this->modifiedColumns[] = ArAsteriskAccountRangeCreationPeer::AR_OFFICE_ID;
		}

		if ($this->aArOffice !== null && $this->aArOffice->getId() !== $v) {
			$this->aArOffice = null;
		}

	} 
	
	public function setPrefix($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->prefix !== $v) {
			$this->prefix = $v;
			$this->modifiedColumns[] = ArAsteriskAccountRangeCreationPeer::PREFIX;
		}

	} 
	
	public function setSuffix($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->suffix !== $v) {
			$this->suffix = $v;
			$this->modifiedColumns[] = ArAsteriskAccountRangeCreationPeer::SUFFIX;
		}

	} 
	
	public function setStartRange($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->start_range !== $v) {
			$this->start_range = $v;
			$this->modifiedColumns[] = ArAsteriskAccountRangeCreationPeer::START_RANGE;
		}

	} 
	
	public function setEndRange($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->end_range !== $v) {
			$this->end_range = $v;
			$this->modifiedColumns[] = ArAsteriskAccountRangeCreationPeer::END_RANGE;
		}

	} 
	
	public function setLeadingZero($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->leading_zero !== $v) {
			$this->leading_zero = $v;
			$this->modifiedColumns[] = ArAsteriskAccountRangeCreationPeer::LEADING_ZERO;
		}

	} 
	
	public function setIsDelete($v)
	{

		if ($this->is_delete !== $v || $v === false) {
			$this->is_delete = $v;
			$this->modifiedColumns[] = ArAsteriskAccountRangeCreationPeer::IS_DELETE;
		}

	} 
	
	public function setIsPhysicalDelete($v)
	{

		if ($this->is_physical_delete !== $v || $v === false) {
			$this->is_physical_delete = $v;
			$this->modifiedColumns[] = ArAsteriskAccountRangeCreationPeer::IS_PHYSICAL_DELETE;
		}

	} 
	
	public function setUserNote($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->user_note !== $v) {
			$this->user_note = $v;
			$this->modifiedColumns[] = ArAsteriskAccountRangeCreationPeer::USER_NOTE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->ar_office_id = $rs->getInt($startcol + 1);

			$this->prefix = $rs->getString($startcol + 2);

			$this->suffix = $rs->getString($startcol + 3);

			$this->start_range = $rs->getInt($startcol + 4);

			$this->end_range = $rs->getInt($startcol + 5);

			$this->leading_zero = $rs->getInt($startcol + 6);

			$this->is_delete = $rs->getBoolean($startcol + 7);

			$this->is_physical_delete = $rs->getBoolean($startcol + 8);

			$this->user_note = $rs->getString($startcol + 9);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 10; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ArAsteriskAccountRangeCreation object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArAsteriskAccountRangeCreationPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArAsteriskAccountRangeCreationPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(ArAsteriskAccountRangeCreationPeer::DATABASE_NAME);
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


												
			if ($this->aArOffice !== null) {
				if ($this->aArOffice->isModified()) {
					$affectedRows += $this->aArOffice->save($con);
				}
				$this->setArOffice($this->aArOffice);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ArAsteriskAccountRangeCreationPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArAsteriskAccountRangeCreationPeer::doUpdate($this, $con);
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


												
			if ($this->aArOffice !== null) {
				if (!$this->aArOffice->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aArOffice->getValidationFailures());
				}
			}


			if (($retval = ArAsteriskAccountRangeCreationPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArAsteriskAccountRangeCreationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getArOfficeId();
				break;
			case 2:
				return $this->getPrefix();
				break;
			case 3:
				return $this->getSuffix();
				break;
			case 4:
				return $this->getStartRange();
				break;
			case 5:
				return $this->getEndRange();
				break;
			case 6:
				return $this->getLeadingZero();
				break;
			case 7:
				return $this->getIsDelete();
				break;
			case 8:
				return $this->getIsPhysicalDelete();
				break;
			case 9:
				return $this->getUserNote();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArAsteriskAccountRangeCreationPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getArOfficeId(),
			$keys[2] => $this->getPrefix(),
			$keys[3] => $this->getSuffix(),
			$keys[4] => $this->getStartRange(),
			$keys[5] => $this->getEndRange(),
			$keys[6] => $this->getLeadingZero(),
			$keys[7] => $this->getIsDelete(),
			$keys[8] => $this->getIsPhysicalDelete(),
			$keys[9] => $this->getUserNote(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArAsteriskAccountRangeCreationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setArOfficeId($value);
				break;
			case 2:
				$this->setPrefix($value);
				break;
			case 3:
				$this->setSuffix($value);
				break;
			case 4:
				$this->setStartRange($value);
				break;
			case 5:
				$this->setEndRange($value);
				break;
			case 6:
				$this->setLeadingZero($value);
				break;
			case 7:
				$this->setIsDelete($value);
				break;
			case 8:
				$this->setIsPhysicalDelete($value);
				break;
			case 9:
				$this->setUserNote($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArAsteriskAccountRangeCreationPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setArOfficeId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setPrefix($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSuffix($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setStartRange($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setEndRange($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setLeadingZero($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setIsDelete($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setIsPhysicalDelete($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setUserNote($arr[$keys[9]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArAsteriskAccountRangeCreationPeer::DATABASE_NAME);

		if ($this->isColumnModified(ArAsteriskAccountRangeCreationPeer::ID)) $criteria->add(ArAsteriskAccountRangeCreationPeer::ID, $this->id);
		if ($this->isColumnModified(ArAsteriskAccountRangeCreationPeer::AR_OFFICE_ID)) $criteria->add(ArAsteriskAccountRangeCreationPeer::AR_OFFICE_ID, $this->ar_office_id);
		if ($this->isColumnModified(ArAsteriskAccountRangeCreationPeer::PREFIX)) $criteria->add(ArAsteriskAccountRangeCreationPeer::PREFIX, $this->prefix);
		if ($this->isColumnModified(ArAsteriskAccountRangeCreationPeer::SUFFIX)) $criteria->add(ArAsteriskAccountRangeCreationPeer::SUFFIX, $this->suffix);
		if ($this->isColumnModified(ArAsteriskAccountRangeCreationPeer::START_RANGE)) $criteria->add(ArAsteriskAccountRangeCreationPeer::START_RANGE, $this->start_range);
		if ($this->isColumnModified(ArAsteriskAccountRangeCreationPeer::END_RANGE)) $criteria->add(ArAsteriskAccountRangeCreationPeer::END_RANGE, $this->end_range);
		if ($this->isColumnModified(ArAsteriskAccountRangeCreationPeer::LEADING_ZERO)) $criteria->add(ArAsteriskAccountRangeCreationPeer::LEADING_ZERO, $this->leading_zero);
		if ($this->isColumnModified(ArAsteriskAccountRangeCreationPeer::IS_DELETE)) $criteria->add(ArAsteriskAccountRangeCreationPeer::IS_DELETE, $this->is_delete);
		if ($this->isColumnModified(ArAsteriskAccountRangeCreationPeer::IS_PHYSICAL_DELETE)) $criteria->add(ArAsteriskAccountRangeCreationPeer::IS_PHYSICAL_DELETE, $this->is_physical_delete);
		if ($this->isColumnModified(ArAsteriskAccountRangeCreationPeer::USER_NOTE)) $criteria->add(ArAsteriskAccountRangeCreationPeer::USER_NOTE, $this->user_note);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArAsteriskAccountRangeCreationPeer::DATABASE_NAME);

		$criteria->add(ArAsteriskAccountRangeCreationPeer::ID, $this->id);

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

		$copyObj->setArOfficeId($this->ar_office_id);

		$copyObj->setPrefix($this->prefix);

		$copyObj->setSuffix($this->suffix);

		$copyObj->setStartRange($this->start_range);

		$copyObj->setEndRange($this->end_range);

		$copyObj->setLeadingZero($this->leading_zero);

		$copyObj->setIsDelete($this->is_delete);

		$copyObj->setIsPhysicalDelete($this->is_physical_delete);

		$copyObj->setUserNote($this->user_note);


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
			self::$peer = new ArAsteriskAccountRangeCreationPeer();
		}
		return self::$peer;
	}

	
	public function setArOffice($v)
	{


		if ($v === null) {
			$this->setArOfficeId(NULL);
		} else {
			$this->setArOfficeId($v->getId());
		}


		$this->aArOffice = $v;
	}


	
	public function getArOffice($con = null)
	{
		if ($this->aArOffice === null && ($this->ar_office_id !== null)) {
						include_once 'lib/model/om/BaseArOfficePeer.php';

			$this->aArOffice = ArOfficePeer::retrieveByPK($this->ar_office_id, $con);

			
		}
		return $this->aArOffice;
	}

} 