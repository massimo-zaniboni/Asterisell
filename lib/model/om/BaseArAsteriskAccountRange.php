<?php


abstract class BaseArAsteriskAccountRange extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $ar_office_id;


	
	protected $system_prefix;


	
	protected $system_suffix;


	
	protected $system_start_range;


	
	protected $system_end_range;


	
	protected $system_leading_zero;


	
	protected $is_delete = false;


	
	protected $is_physical_delete = false;


	
	protected $user_prefix;


	
	protected $user_suffix;


	
	protected $user_start_range;


	
	protected $generate_range_for_users = true;


	
	protected $user_leading_zero;


	
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

	
	public function getSystemPrefix()
	{

		return $this->system_prefix;
	}

	
	public function getSystemSuffix()
	{

		return $this->system_suffix;
	}

	
	public function getSystemStartRange()
	{

		return $this->system_start_range;
	}

	
	public function getSystemEndRange()
	{

		return $this->system_end_range;
	}

	
	public function getSystemLeadingZero()
	{

		return $this->system_leading_zero;
	}

	
	public function getIsDelete()
	{

		return $this->is_delete;
	}

	
	public function getIsPhysicalDelete()
	{

		return $this->is_physical_delete;
	}

	
	public function getUserPrefix()
	{

		return $this->user_prefix;
	}

	
	public function getUserSuffix()
	{

		return $this->user_suffix;
	}

	
	public function getUserStartRange()
	{

		return $this->user_start_range;
	}

	
	public function getGenerateRangeForUsers()
	{

		return $this->generate_range_for_users;
	}

	
	public function getUserLeadingZero()
	{

		return $this->user_leading_zero;
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
			$this->modifiedColumns[] = ArAsteriskAccountRangePeer::ID;
		}

	} 
	
	public function setArOfficeId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ar_office_id !== $v) {
			$this->ar_office_id = $v;
			$this->modifiedColumns[] = ArAsteriskAccountRangePeer::AR_OFFICE_ID;
		}

		if ($this->aArOffice !== null && $this->aArOffice->getId() !== $v) {
			$this->aArOffice = null;
		}

	} 
	
	public function setSystemPrefix($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->system_prefix !== $v) {
			$this->system_prefix = $v;
			$this->modifiedColumns[] = ArAsteriskAccountRangePeer::SYSTEM_PREFIX;
		}

	} 
	
	public function setSystemSuffix($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->system_suffix !== $v) {
			$this->system_suffix = $v;
			$this->modifiedColumns[] = ArAsteriskAccountRangePeer::SYSTEM_SUFFIX;
		}

	} 
	
	public function setSystemStartRange($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->system_start_range !== $v) {
			$this->system_start_range = $v;
			$this->modifiedColumns[] = ArAsteriskAccountRangePeer::SYSTEM_START_RANGE;
		}

	} 
	
	public function setSystemEndRange($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->system_end_range !== $v) {
			$this->system_end_range = $v;
			$this->modifiedColumns[] = ArAsteriskAccountRangePeer::SYSTEM_END_RANGE;
		}

	} 
	
	public function setSystemLeadingZero($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->system_leading_zero !== $v) {
			$this->system_leading_zero = $v;
			$this->modifiedColumns[] = ArAsteriskAccountRangePeer::SYSTEM_LEADING_ZERO;
		}

	} 
	
	public function setIsDelete($v)
	{

		if ($this->is_delete !== $v || $v === false) {
			$this->is_delete = $v;
			$this->modifiedColumns[] = ArAsteriskAccountRangePeer::IS_DELETE;
		}

	} 
	
	public function setIsPhysicalDelete($v)
	{

		if ($this->is_physical_delete !== $v || $v === false) {
			$this->is_physical_delete = $v;
			$this->modifiedColumns[] = ArAsteriskAccountRangePeer::IS_PHYSICAL_DELETE;
		}

	} 
	
	public function setUserPrefix($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->user_prefix !== $v) {
			$this->user_prefix = $v;
			$this->modifiedColumns[] = ArAsteriskAccountRangePeer::USER_PREFIX;
		}

	} 
	
	public function setUserSuffix($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->user_suffix !== $v) {
			$this->user_suffix = $v;
			$this->modifiedColumns[] = ArAsteriskAccountRangePeer::USER_SUFFIX;
		}

	} 
	
	public function setUserStartRange($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->user_start_range !== $v) {
			$this->user_start_range = $v;
			$this->modifiedColumns[] = ArAsteriskAccountRangePeer::USER_START_RANGE;
		}

	} 
	
	public function setGenerateRangeForUsers($v)
	{

		if ($this->generate_range_for_users !== $v || $v === true) {
			$this->generate_range_for_users = $v;
			$this->modifiedColumns[] = ArAsteriskAccountRangePeer::GENERATE_RANGE_FOR_USERS;
		}

	} 
	
	public function setUserLeadingZero($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->user_leading_zero !== $v) {
			$this->user_leading_zero = $v;
			$this->modifiedColumns[] = ArAsteriskAccountRangePeer::USER_LEADING_ZERO;
		}

	} 
	
	public function setUserNote($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->user_note !== $v) {
			$this->user_note = $v;
			$this->modifiedColumns[] = ArAsteriskAccountRangePeer::USER_NOTE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->ar_office_id = $rs->getInt($startcol + 1);

			$this->system_prefix = $rs->getString($startcol + 2);

			$this->system_suffix = $rs->getString($startcol + 3);

			$this->system_start_range = $rs->getString($startcol + 4);

			$this->system_end_range = $rs->getString($startcol + 5);

			$this->system_leading_zero = $rs->getInt($startcol + 6);

			$this->is_delete = $rs->getBoolean($startcol + 7);

			$this->is_physical_delete = $rs->getBoolean($startcol + 8);

			$this->user_prefix = $rs->getString($startcol + 9);

			$this->user_suffix = $rs->getString($startcol + 10);

			$this->user_start_range = $rs->getString($startcol + 11);

			$this->generate_range_for_users = $rs->getBoolean($startcol + 12);

			$this->user_leading_zero = $rs->getInt($startcol + 13);

			$this->user_note = $rs->getString($startcol + 14);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 15; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ArAsteriskAccountRange object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArAsteriskAccountRangePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArAsteriskAccountRangePeer::doDelete($this, $con);
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
			$con = Propel::getConnection(ArAsteriskAccountRangePeer::DATABASE_NAME);
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
					$pk = ArAsteriskAccountRangePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArAsteriskAccountRangePeer::doUpdate($this, $con);
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


			if (($retval = ArAsteriskAccountRangePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArAsteriskAccountRangePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getSystemPrefix();
				break;
			case 3:
				return $this->getSystemSuffix();
				break;
			case 4:
				return $this->getSystemStartRange();
				break;
			case 5:
				return $this->getSystemEndRange();
				break;
			case 6:
				return $this->getSystemLeadingZero();
				break;
			case 7:
				return $this->getIsDelete();
				break;
			case 8:
				return $this->getIsPhysicalDelete();
				break;
			case 9:
				return $this->getUserPrefix();
				break;
			case 10:
				return $this->getUserSuffix();
				break;
			case 11:
				return $this->getUserStartRange();
				break;
			case 12:
				return $this->getGenerateRangeForUsers();
				break;
			case 13:
				return $this->getUserLeadingZero();
				break;
			case 14:
				return $this->getUserNote();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArAsteriskAccountRangePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getArOfficeId(),
			$keys[2] => $this->getSystemPrefix(),
			$keys[3] => $this->getSystemSuffix(),
			$keys[4] => $this->getSystemStartRange(),
			$keys[5] => $this->getSystemEndRange(),
			$keys[6] => $this->getSystemLeadingZero(),
			$keys[7] => $this->getIsDelete(),
			$keys[8] => $this->getIsPhysicalDelete(),
			$keys[9] => $this->getUserPrefix(),
			$keys[10] => $this->getUserSuffix(),
			$keys[11] => $this->getUserStartRange(),
			$keys[12] => $this->getGenerateRangeForUsers(),
			$keys[13] => $this->getUserLeadingZero(),
			$keys[14] => $this->getUserNote(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArAsteriskAccountRangePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setSystemPrefix($value);
				break;
			case 3:
				$this->setSystemSuffix($value);
				break;
			case 4:
				$this->setSystemStartRange($value);
				break;
			case 5:
				$this->setSystemEndRange($value);
				break;
			case 6:
				$this->setSystemLeadingZero($value);
				break;
			case 7:
				$this->setIsDelete($value);
				break;
			case 8:
				$this->setIsPhysicalDelete($value);
				break;
			case 9:
				$this->setUserPrefix($value);
				break;
			case 10:
				$this->setUserSuffix($value);
				break;
			case 11:
				$this->setUserStartRange($value);
				break;
			case 12:
				$this->setGenerateRangeForUsers($value);
				break;
			case 13:
				$this->setUserLeadingZero($value);
				break;
			case 14:
				$this->setUserNote($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArAsteriskAccountRangePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setArOfficeId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSystemPrefix($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setSystemSuffix($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setSystemStartRange($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setSystemEndRange($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setSystemLeadingZero($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setIsDelete($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setIsPhysicalDelete($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setUserPrefix($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setUserSuffix($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setUserStartRange($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setGenerateRangeForUsers($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setUserLeadingZero($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setUserNote($arr[$keys[14]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArAsteriskAccountRangePeer::DATABASE_NAME);

		if ($this->isColumnModified(ArAsteriskAccountRangePeer::ID)) $criteria->add(ArAsteriskAccountRangePeer::ID, $this->id);
		if ($this->isColumnModified(ArAsteriskAccountRangePeer::AR_OFFICE_ID)) $criteria->add(ArAsteriskAccountRangePeer::AR_OFFICE_ID, $this->ar_office_id);
		if ($this->isColumnModified(ArAsteriskAccountRangePeer::SYSTEM_PREFIX)) $criteria->add(ArAsteriskAccountRangePeer::SYSTEM_PREFIX, $this->system_prefix);
		if ($this->isColumnModified(ArAsteriskAccountRangePeer::SYSTEM_SUFFIX)) $criteria->add(ArAsteriskAccountRangePeer::SYSTEM_SUFFIX, $this->system_suffix);
		if ($this->isColumnModified(ArAsteriskAccountRangePeer::SYSTEM_START_RANGE)) $criteria->add(ArAsteriskAccountRangePeer::SYSTEM_START_RANGE, $this->system_start_range);
		if ($this->isColumnModified(ArAsteriskAccountRangePeer::SYSTEM_END_RANGE)) $criteria->add(ArAsteriskAccountRangePeer::SYSTEM_END_RANGE, $this->system_end_range);
		if ($this->isColumnModified(ArAsteriskAccountRangePeer::SYSTEM_LEADING_ZERO)) $criteria->add(ArAsteriskAccountRangePeer::SYSTEM_LEADING_ZERO, $this->system_leading_zero);
		if ($this->isColumnModified(ArAsteriskAccountRangePeer::IS_DELETE)) $criteria->add(ArAsteriskAccountRangePeer::IS_DELETE, $this->is_delete);
		if ($this->isColumnModified(ArAsteriskAccountRangePeer::IS_PHYSICAL_DELETE)) $criteria->add(ArAsteriskAccountRangePeer::IS_PHYSICAL_DELETE, $this->is_physical_delete);
		if ($this->isColumnModified(ArAsteriskAccountRangePeer::USER_PREFIX)) $criteria->add(ArAsteriskAccountRangePeer::USER_PREFIX, $this->user_prefix);
		if ($this->isColumnModified(ArAsteriskAccountRangePeer::USER_SUFFIX)) $criteria->add(ArAsteriskAccountRangePeer::USER_SUFFIX, $this->user_suffix);
		if ($this->isColumnModified(ArAsteriskAccountRangePeer::USER_START_RANGE)) $criteria->add(ArAsteriskAccountRangePeer::USER_START_RANGE, $this->user_start_range);
		if ($this->isColumnModified(ArAsteriskAccountRangePeer::GENERATE_RANGE_FOR_USERS)) $criteria->add(ArAsteriskAccountRangePeer::GENERATE_RANGE_FOR_USERS, $this->generate_range_for_users);
		if ($this->isColumnModified(ArAsteriskAccountRangePeer::USER_LEADING_ZERO)) $criteria->add(ArAsteriskAccountRangePeer::USER_LEADING_ZERO, $this->user_leading_zero);
		if ($this->isColumnModified(ArAsteriskAccountRangePeer::USER_NOTE)) $criteria->add(ArAsteriskAccountRangePeer::USER_NOTE, $this->user_note);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArAsteriskAccountRangePeer::DATABASE_NAME);

		$criteria->add(ArAsteriskAccountRangePeer::ID, $this->id);

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

		$copyObj->setSystemPrefix($this->system_prefix);

		$copyObj->setSystemSuffix($this->system_suffix);

		$copyObj->setSystemStartRange($this->system_start_range);

		$copyObj->setSystemEndRange($this->system_end_range);

		$copyObj->setSystemLeadingZero($this->system_leading_zero);

		$copyObj->setIsDelete($this->is_delete);

		$copyObj->setIsPhysicalDelete($this->is_physical_delete);

		$copyObj->setUserPrefix($this->user_prefix);

		$copyObj->setUserSuffix($this->user_suffix);

		$copyObj->setUserStartRange($this->user_start_range);

		$copyObj->setGenerateRangeForUsers($this->generate_range_for_users);

		$copyObj->setUserLeadingZero($this->user_leading_zero);

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
			self::$peer = new ArAsteriskAccountRangePeer();
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