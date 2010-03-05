<?php


abstract class BaseArCustomRateFormSupport extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $owner_ar_rate_id;

	
	protected $aArRate;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getOwnerArRateId()
	{

		return $this->owner_ar_rate_id;
	}

	
	public function setOwnerArRateId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->owner_ar_rate_id !== $v) {
			$this->owner_ar_rate_id = $v;
			$this->modifiedColumns[] = ArCustomRateFormSupportPeer::OWNER_AR_RATE_ID;
		}

		if ($this->aArRate !== null && $this->aArRate->getId() !== $v) {
			$this->aArRate = null;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->owner_ar_rate_id = $rs->getInt($startcol + 0);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 1; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ArCustomRateFormSupport object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArCustomRateFormSupportPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArCustomRateFormSupportPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(ArCustomRateFormSupportPeer::DATABASE_NAME);
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


												
			if ($this->aArRate !== null) {
				if ($this->aArRate->isModified()) {
					$affectedRows += $this->aArRate->save($con);
				}
				$this->setArRate($this->aArRate);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ArCustomRateFormSupportPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setNew(false);
				} else {
					$affectedRows += ArCustomRateFormSupportPeer::doUpdate($this, $con);
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


												
			if ($this->aArRate !== null) {
				if (!$this->aArRate->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aArRate->getValidationFailures());
				}
			}


			if (($retval = ArCustomRateFormSupportPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArCustomRateFormSupportPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getOwnerArRateId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArCustomRateFormSupportPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getOwnerArRateId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArCustomRateFormSupportPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setOwnerArRateId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArCustomRateFormSupportPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setOwnerArRateId($arr[$keys[0]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArCustomRateFormSupportPeer::DATABASE_NAME);

		if ($this->isColumnModified(ArCustomRateFormSupportPeer::OWNER_AR_RATE_ID)) $criteria->add(ArCustomRateFormSupportPeer::OWNER_AR_RATE_ID, $this->owner_ar_rate_id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArCustomRateFormSupportPeer::DATABASE_NAME);

		$criteria->add(ArCustomRateFormSupportPeer::OWNER_AR_RATE_ID, $this->owner_ar_rate_id);

		return $criteria;
	}

	
	public function getPrimaryKey()
	{
		return $this->getOwnerArRateId();
	}

	
	public function setPrimaryKey($key)
	{
		$this->setOwnerArRateId($key);
	}

	
	public function copyInto($copyObj, $deepCopy = false)
	{


		$copyObj->setNew(true);

		$copyObj->setOwnerArRateId(NULL); 
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
			self::$peer = new ArCustomRateFormSupportPeer();
		}
		return self::$peer;
	}

	
	public function setArRate($v)
	{


		if ($v === null) {
			$this->setOwnerArRateId(NULL);
		} else {
			$this->setOwnerArRateId($v->getId());
		}


		$this->aArRate = $v;
	}


	
	public function getArRate($con = null)
	{
		if ($this->aArRate === null && ($this->owner_ar_rate_id !== null)) {
						include_once 'lib/model/om/BaseArRatePeer.php';

			$this->aArRate = ArRatePeer::retrieveByPK($this->owner_ar_rate_id, $con);

			
		}
		return $this->aArRate;
	}

} 