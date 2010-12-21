<?php


abstract class BaseArRateIncrementalInfo extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $ar_party_id;


	
	protected $ar_rate_id;


	
	protected $period;


	
	protected $last_processed_cdr_date;


	
	protected $last_processed_cdr_id;


	
	protected $bundle_rate;

	
	protected $aArParty;

	
	protected $aArRate;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getArPartyId()
	{

		return $this->ar_party_id;
	}

	
	public function getArRateId()
	{

		return $this->ar_rate_id;
	}

	
	public function getPeriod()
	{

		return $this->period;
	}

	
	public function getLastProcessedCdrDate($format = 'Y-m-d H:i:s')
	{

		if ($this->last_processed_cdr_date === null || $this->last_processed_cdr_date === '') {
			return null;
		} elseif (!is_int($this->last_processed_cdr_date)) {
						$ts = strtotime($this->last_processed_cdr_date);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [last_processed_cdr_date] as date/time value: " . var_export($this->last_processed_cdr_date, true));
			}
		} else {
			$ts = $this->last_processed_cdr_date;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getLastProcessedCdrId()
	{

		return $this->last_processed_cdr_id;
	}

	
	public function getBundleRate()
	{

		return $this->bundle_rate;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ArRateIncrementalInfoPeer::ID;
		}

	} 
	
	public function setArPartyId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ar_party_id !== $v) {
			$this->ar_party_id = $v;
			$this->modifiedColumns[] = ArRateIncrementalInfoPeer::AR_PARTY_ID;
		}

		if ($this->aArParty !== null && $this->aArParty->getId() !== $v) {
			$this->aArParty = null;
		}

	} 
	
	public function setArRateId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ar_rate_id !== $v) {
			$this->ar_rate_id = $v;
			$this->modifiedColumns[] = ArRateIncrementalInfoPeer::AR_RATE_ID;
		}

		if ($this->aArRate !== null && $this->aArRate->getId() !== $v) {
			$this->aArRate = null;
		}

	} 
	
	public function setPeriod($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->period !== $v) {
			$this->period = $v;
			$this->modifiedColumns[] = ArRateIncrementalInfoPeer::PERIOD;
		}

	} 
	
	public function setLastProcessedCdrDate($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [last_processed_cdr_date] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->last_processed_cdr_date !== $ts) {
			$this->last_processed_cdr_date = $ts;
			$this->modifiedColumns[] = ArRateIncrementalInfoPeer::LAST_PROCESSED_CDR_DATE;
		}

	} 
	
	public function setLastProcessedCdrId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->last_processed_cdr_id !== $v) {
			$this->last_processed_cdr_id = $v;
			$this->modifiedColumns[] = ArRateIncrementalInfoPeer::LAST_PROCESSED_CDR_ID;
		}

	} 
	
	public function setBundleRate($v)
	{

								if ($v instanceof Lob && $v === $this->bundle_rate) {
			$changed = $v->isModified();
		} else {
			$changed = ($this->bundle_rate !== $v);
		}
		if ($changed) {
			if ( !($v instanceof Lob) ) {
				$obj = new Clob();
				$obj->setContents($v);
			} else {
				$obj = $v;
			}
			$this->bundle_rate = $obj;
			$this->modifiedColumns[] = ArRateIncrementalInfoPeer::BUNDLE_RATE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->ar_party_id = $rs->getInt($startcol + 1);

			$this->ar_rate_id = $rs->getInt($startcol + 2);

			$this->period = $rs->getString($startcol + 3);

			$this->last_processed_cdr_date = $rs->getTimestamp($startcol + 4, null);

			$this->last_processed_cdr_id = $rs->getInt($startcol + 5);

			$this->bundle_rate = $rs->getClob($startcol + 6);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 7; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ArRateIncrementalInfo object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArRateIncrementalInfoPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArRateIncrementalInfoPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(ArRateIncrementalInfoPeer::DATABASE_NAME);
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

			if ($this->aArRate !== null) {
				if ($this->aArRate->isModified()) {
					$affectedRows += $this->aArRate->save($con);
				}
				$this->setArRate($this->aArRate);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ArRateIncrementalInfoPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArRateIncrementalInfoPeer::doUpdate($this, $con);
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


												
			if ($this->aArParty !== null) {
				if (!$this->aArParty->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aArParty->getValidationFailures());
				}
			}

			if ($this->aArRate !== null) {
				if (!$this->aArRate->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aArRate->getValidationFailures());
				}
			}


			if (($retval = ArRateIncrementalInfoPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArRateIncrementalInfoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getArPartyId();
				break;
			case 2:
				return $this->getArRateId();
				break;
			case 3:
				return $this->getPeriod();
				break;
			case 4:
				return $this->getLastProcessedCdrDate();
				break;
			case 5:
				return $this->getLastProcessedCdrId();
				break;
			case 6:
				return $this->getBundleRate();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArRateIncrementalInfoPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getArPartyId(),
			$keys[2] => $this->getArRateId(),
			$keys[3] => $this->getPeriod(),
			$keys[4] => $this->getLastProcessedCdrDate(),
			$keys[5] => $this->getLastProcessedCdrId(),
			$keys[6] => $this->getBundleRate(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArRateIncrementalInfoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setArPartyId($value);
				break;
			case 2:
				$this->setArRateId($value);
				break;
			case 3:
				$this->setPeriod($value);
				break;
			case 4:
				$this->setLastProcessedCdrDate($value);
				break;
			case 5:
				$this->setLastProcessedCdrId($value);
				break;
			case 6:
				$this->setBundleRate($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArRateIncrementalInfoPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setArPartyId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setArRateId($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setPeriod($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setLastProcessedCdrDate($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setLastProcessedCdrId($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setBundleRate($arr[$keys[6]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArRateIncrementalInfoPeer::DATABASE_NAME);

		if ($this->isColumnModified(ArRateIncrementalInfoPeer::ID)) $criteria->add(ArRateIncrementalInfoPeer::ID, $this->id);
		if ($this->isColumnModified(ArRateIncrementalInfoPeer::AR_PARTY_ID)) $criteria->add(ArRateIncrementalInfoPeer::AR_PARTY_ID, $this->ar_party_id);
		if ($this->isColumnModified(ArRateIncrementalInfoPeer::AR_RATE_ID)) $criteria->add(ArRateIncrementalInfoPeer::AR_RATE_ID, $this->ar_rate_id);
		if ($this->isColumnModified(ArRateIncrementalInfoPeer::PERIOD)) $criteria->add(ArRateIncrementalInfoPeer::PERIOD, $this->period);
		if ($this->isColumnModified(ArRateIncrementalInfoPeer::LAST_PROCESSED_CDR_DATE)) $criteria->add(ArRateIncrementalInfoPeer::LAST_PROCESSED_CDR_DATE, $this->last_processed_cdr_date);
		if ($this->isColumnModified(ArRateIncrementalInfoPeer::LAST_PROCESSED_CDR_ID)) $criteria->add(ArRateIncrementalInfoPeer::LAST_PROCESSED_CDR_ID, $this->last_processed_cdr_id);
		if ($this->isColumnModified(ArRateIncrementalInfoPeer::BUNDLE_RATE)) $criteria->add(ArRateIncrementalInfoPeer::BUNDLE_RATE, $this->bundle_rate);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArRateIncrementalInfoPeer::DATABASE_NAME);

		$criteria->add(ArRateIncrementalInfoPeer::ID, $this->id);

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

		$copyObj->setArPartyId($this->ar_party_id);

		$copyObj->setArRateId($this->ar_rate_id);

		$copyObj->setPeriod($this->period);

		$copyObj->setLastProcessedCdrDate($this->last_processed_cdr_date);

		$copyObj->setLastProcessedCdrId($this->last_processed_cdr_id);

		$copyObj->setBundleRate($this->bundle_rate);


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
			self::$peer = new ArRateIncrementalInfoPeer();
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

	
	public function setArRate($v)
	{


		if ($v === null) {
			$this->setArRateId(NULL);
		} else {
			$this->setArRateId($v->getId());
		}


		$this->aArRate = $v;
	}


	
	public function getArRate($con = null)
	{
		if ($this->aArRate === null && ($this->ar_rate_id !== null)) {
						include_once 'lib/model/om/BaseArRatePeer.php';

			$this->aArRate = ArRatePeer::retrieveByPK($this->ar_rate_id, $con);

			
		}
		return $this->aArRate;
	}

} 