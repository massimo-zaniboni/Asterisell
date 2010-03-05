<?php


abstract class BaseArRate extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $destination_type = 0;


	
	protected $is_exception = false;


	
	protected $ar_rate_category_id;


	
	protected $ar_party_id;


	
	protected $start_time;


	
	protected $end_time;


	
	protected $php_class_serialization;


	
	protected $user_input;


	
	protected $note;

	
	protected $aArRateCategory;

	
	protected $aArParty;

	
	protected $collCdrsRelatedByIncomeArRateId;

	
	protected $lastCdrRelatedByIncomeArRateIdCriteria = null;

	
	protected $collCdrsRelatedByCostArRateId;

	
	protected $lastCdrRelatedByCostArRateIdCriteria = null;

	
	protected $collArCustomRateForms;

	
	protected $lastArCustomRateFormCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getDestinationType()
	{

		return $this->destination_type;
	}

	
	public function getIsException()
	{

		return $this->is_exception;
	}

	
	public function getArRateCategoryId()
	{

		return $this->ar_rate_category_id;
	}

	
	public function getArPartyId()
	{

		return $this->ar_party_id;
	}

	
	public function getStartTime($format = 'Y-m-d H:i:s')
	{

		if ($this->start_time === null || $this->start_time === '') {
			return null;
		} elseif (!is_int($this->start_time)) {
						$ts = strtotime($this->start_time);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [start_time] as date/time value: " . var_export($this->start_time, true));
			}
		} else {
			$ts = $this->start_time;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getEndTime($format = 'Y-m-d H:i:s')
	{

		if ($this->end_time === null || $this->end_time === '') {
			return null;
		} elseif (!is_int($this->end_time)) {
						$ts = strtotime($this->end_time);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [end_time] as date/time value: " . var_export($this->end_time, true));
			}
		} else {
			$ts = $this->end_time;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getPhpClassSerialization()
	{

		return $this->php_class_serialization;
	}

	
	public function getUserInput()
	{

		return $this->user_input;
	}

	
	public function getNote()
	{

		return $this->note;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ArRatePeer::ID;
		}

	} 
	
	public function setDestinationType($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->destination_type !== $v || $v === 0) {
			$this->destination_type = $v;
			$this->modifiedColumns[] = ArRatePeer::DESTINATION_TYPE;
		}

	} 
	
	public function setIsException($v)
	{

		if ($this->is_exception !== $v || $v === false) {
			$this->is_exception = $v;
			$this->modifiedColumns[] = ArRatePeer::IS_EXCEPTION;
		}

	} 
	
	public function setArRateCategoryId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ar_rate_category_id !== $v) {
			$this->ar_rate_category_id = $v;
			$this->modifiedColumns[] = ArRatePeer::AR_RATE_CATEGORY_ID;
		}

		if ($this->aArRateCategory !== null && $this->aArRateCategory->getId() !== $v) {
			$this->aArRateCategory = null;
		}

	} 
	
	public function setArPartyId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ar_party_id !== $v) {
			$this->ar_party_id = $v;
			$this->modifiedColumns[] = ArRatePeer::AR_PARTY_ID;
		}

		if ($this->aArParty !== null && $this->aArParty->getId() !== $v) {
			$this->aArParty = null;
		}

	} 
	
	public function setStartTime($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [start_time] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->start_time !== $ts) {
			$this->start_time = $ts;
			$this->modifiedColumns[] = ArRatePeer::START_TIME;
		}

	} 
	
	public function setEndTime($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [end_time] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->end_time !== $ts) {
			$this->end_time = $ts;
			$this->modifiedColumns[] = ArRatePeer::END_TIME;
		}

	} 
	
	public function setPhpClassSerialization($v)
	{

								if ($v instanceof Lob && $v === $this->php_class_serialization) {
			$changed = $v->isModified();
		} else {
			$changed = ($this->php_class_serialization !== $v);
		}
		if ($changed) {
			if ( !($v instanceof Lob) ) {
				$obj = new Clob();
				$obj->setContents($v);
			} else {
				$obj = $v;
			}
			$this->php_class_serialization = $obj;
			$this->modifiedColumns[] = ArRatePeer::PHP_CLASS_SERIALIZATION;
		}

	} 
	
	public function setUserInput($v)
	{

								if ($v instanceof Lob && $v === $this->user_input) {
			$changed = $v->isModified();
		} else {
			$changed = ($this->user_input !== $v);
		}
		if ($changed) {
			if ( !($v instanceof Lob) ) {
				$obj = new Clob();
				$obj->setContents($v);
			} else {
				$obj = $v;
			}
			$this->user_input = $obj;
			$this->modifiedColumns[] = ArRatePeer::USER_INPUT;
		}

	} 
	
	public function setNote($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->note !== $v) {
			$this->note = $v;
			$this->modifiedColumns[] = ArRatePeer::NOTE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->destination_type = $rs->getInt($startcol + 1);

			$this->is_exception = $rs->getBoolean($startcol + 2);

			$this->ar_rate_category_id = $rs->getInt($startcol + 3);

			$this->ar_party_id = $rs->getInt($startcol + 4);

			$this->start_time = $rs->getTimestamp($startcol + 5, null);

			$this->end_time = $rs->getTimestamp($startcol + 6, null);

			$this->php_class_serialization = $rs->getClob($startcol + 7);

			$this->user_input = $rs->getClob($startcol + 8);

			$this->note = $rs->getString($startcol + 9);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 10; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ArRate object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArRatePeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArRatePeer::doDelete($this, $con);
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
			$con = Propel::getConnection(ArRatePeer::DATABASE_NAME);
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


												
			if ($this->aArRateCategory !== null) {
				if ($this->aArRateCategory->isModified()) {
					$affectedRows += $this->aArRateCategory->save($con);
				}
				$this->setArRateCategory($this->aArRateCategory);
			}

			if ($this->aArParty !== null) {
				if ($this->aArParty->isModified()) {
					$affectedRows += $this->aArParty->save($con);
				}
				$this->setArParty($this->aArParty);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ArRatePeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArRatePeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collCdrsRelatedByIncomeArRateId !== null) {
				foreach($this->collCdrsRelatedByIncomeArRateId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collCdrsRelatedByCostArRateId !== null) {
				foreach($this->collCdrsRelatedByCostArRateId as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collArCustomRateForms !== null) {
				foreach($this->collArCustomRateForms as $referrerFK) {
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


												
			if ($this->aArRateCategory !== null) {
				if (!$this->aArRateCategory->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aArRateCategory->getValidationFailures());
				}
			}

			if ($this->aArParty !== null) {
				if (!$this->aArParty->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aArParty->getValidationFailures());
				}
			}


			if (($retval = ArRatePeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collCdrsRelatedByIncomeArRateId !== null) {
					foreach($this->collCdrsRelatedByIncomeArRateId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collCdrsRelatedByCostArRateId !== null) {
					foreach($this->collCdrsRelatedByCostArRateId as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collArCustomRateForms !== null) {
					foreach($this->collArCustomRateForms as $referrerFK) {
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
		$pos = ArRatePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getDestinationType();
				break;
			case 2:
				return $this->getIsException();
				break;
			case 3:
				return $this->getArRateCategoryId();
				break;
			case 4:
				return $this->getArPartyId();
				break;
			case 5:
				return $this->getStartTime();
				break;
			case 6:
				return $this->getEndTime();
				break;
			case 7:
				return $this->getPhpClassSerialization();
				break;
			case 8:
				return $this->getUserInput();
				break;
			case 9:
				return $this->getNote();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArRatePeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getDestinationType(),
			$keys[2] => $this->getIsException(),
			$keys[3] => $this->getArRateCategoryId(),
			$keys[4] => $this->getArPartyId(),
			$keys[5] => $this->getStartTime(),
			$keys[6] => $this->getEndTime(),
			$keys[7] => $this->getPhpClassSerialization(),
			$keys[8] => $this->getUserInput(),
			$keys[9] => $this->getNote(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArRatePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setDestinationType($value);
				break;
			case 2:
				$this->setIsException($value);
				break;
			case 3:
				$this->setArRateCategoryId($value);
				break;
			case 4:
				$this->setArPartyId($value);
				break;
			case 5:
				$this->setStartTime($value);
				break;
			case 6:
				$this->setEndTime($value);
				break;
			case 7:
				$this->setPhpClassSerialization($value);
				break;
			case 8:
				$this->setUserInput($value);
				break;
			case 9:
				$this->setNote($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArRatePeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setDestinationType($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setIsException($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setArRateCategoryId($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setArPartyId($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setStartTime($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setEndTime($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setPhpClassSerialization($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setUserInput($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setNote($arr[$keys[9]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArRatePeer::DATABASE_NAME);

		if ($this->isColumnModified(ArRatePeer::ID)) $criteria->add(ArRatePeer::ID, $this->id);
		if ($this->isColumnModified(ArRatePeer::DESTINATION_TYPE)) $criteria->add(ArRatePeer::DESTINATION_TYPE, $this->destination_type);
		if ($this->isColumnModified(ArRatePeer::IS_EXCEPTION)) $criteria->add(ArRatePeer::IS_EXCEPTION, $this->is_exception);
		if ($this->isColumnModified(ArRatePeer::AR_RATE_CATEGORY_ID)) $criteria->add(ArRatePeer::AR_RATE_CATEGORY_ID, $this->ar_rate_category_id);
		if ($this->isColumnModified(ArRatePeer::AR_PARTY_ID)) $criteria->add(ArRatePeer::AR_PARTY_ID, $this->ar_party_id);
		if ($this->isColumnModified(ArRatePeer::START_TIME)) $criteria->add(ArRatePeer::START_TIME, $this->start_time);
		if ($this->isColumnModified(ArRatePeer::END_TIME)) $criteria->add(ArRatePeer::END_TIME, $this->end_time);
		if ($this->isColumnModified(ArRatePeer::PHP_CLASS_SERIALIZATION)) $criteria->add(ArRatePeer::PHP_CLASS_SERIALIZATION, $this->php_class_serialization);
		if ($this->isColumnModified(ArRatePeer::USER_INPUT)) $criteria->add(ArRatePeer::USER_INPUT, $this->user_input);
		if ($this->isColumnModified(ArRatePeer::NOTE)) $criteria->add(ArRatePeer::NOTE, $this->note);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArRatePeer::DATABASE_NAME);

		$criteria->add(ArRatePeer::ID, $this->id);

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

		$copyObj->setDestinationType($this->destination_type);

		$copyObj->setIsException($this->is_exception);

		$copyObj->setArRateCategoryId($this->ar_rate_category_id);

		$copyObj->setArPartyId($this->ar_party_id);

		$copyObj->setStartTime($this->start_time);

		$copyObj->setEndTime($this->end_time);

		$copyObj->setPhpClassSerialization($this->php_class_serialization);

		$copyObj->setUserInput($this->user_input);

		$copyObj->setNote($this->note);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getCdrsRelatedByIncomeArRateId() as $relObj) {
				$copyObj->addCdrRelatedByIncomeArRateId($relObj->copy($deepCopy));
			}

			foreach($this->getCdrsRelatedByCostArRateId() as $relObj) {
				$copyObj->addCdrRelatedByCostArRateId($relObj->copy($deepCopy));
			}

			foreach($this->getArCustomRateForms() as $relObj) {
				$copyObj->addArCustomRateForm($relObj->copy($deepCopy));
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
			self::$peer = new ArRatePeer();
		}
		return self::$peer;
	}

	
	public function setArRateCategory($v)
	{


		if ($v === null) {
			$this->setArRateCategoryId(NULL);
		} else {
			$this->setArRateCategoryId($v->getId());
		}


		$this->aArRateCategory = $v;
	}


	
	public function getArRateCategory($con = null)
	{
		if ($this->aArRateCategory === null && ($this->ar_rate_category_id !== null)) {
						include_once 'lib/model/om/BaseArRateCategoryPeer.php';

			$this->aArRateCategory = ArRateCategoryPeer::retrieveByPK($this->ar_rate_category_id, $con);

			
		}
		return $this->aArRateCategory;
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

	
	public function initCdrsRelatedByIncomeArRateId()
	{
		if ($this->collCdrsRelatedByIncomeArRateId === null) {
			$this->collCdrsRelatedByIncomeArRateId = array();
		}
	}

	
	public function getCdrsRelatedByIncomeArRateId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseCdrPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCdrsRelatedByIncomeArRateId === null) {
			if ($this->isNew()) {
			   $this->collCdrsRelatedByIncomeArRateId = array();
			} else {

				$criteria->add(CdrPeer::INCOME_AR_RATE_ID, $this->getId());

				CdrPeer::addSelectColumns($criteria);
				$this->collCdrsRelatedByIncomeArRateId = CdrPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(CdrPeer::INCOME_AR_RATE_ID, $this->getId());

				CdrPeer::addSelectColumns($criteria);
				if (!isset($this->lastCdrRelatedByIncomeArRateIdCriteria) || !$this->lastCdrRelatedByIncomeArRateIdCriteria->equals($criteria)) {
					$this->collCdrsRelatedByIncomeArRateId = CdrPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastCdrRelatedByIncomeArRateIdCriteria = $criteria;
		return $this->collCdrsRelatedByIncomeArRateId;
	}

	
	public function countCdrsRelatedByIncomeArRateId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseCdrPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(CdrPeer::INCOME_AR_RATE_ID, $this->getId());

		return CdrPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addCdrRelatedByIncomeArRateId(Cdr $l)
	{
		$this->collCdrsRelatedByIncomeArRateId[] = $l;
		$l->setArRateRelatedByIncomeArRateId($this);
	}


	
	public function getCdrsRelatedByIncomeArRateIdJoinArAsteriskAccount($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseCdrPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCdrsRelatedByIncomeArRateId === null) {
			if ($this->isNew()) {
				$this->collCdrsRelatedByIncomeArRateId = array();
			} else {

				$criteria->add(CdrPeer::INCOME_AR_RATE_ID, $this->getId());

				$this->collCdrsRelatedByIncomeArRateId = CdrPeer::doSelectJoinArAsteriskAccount($criteria, $con);
			}
		} else {
									
			$criteria->add(CdrPeer::INCOME_AR_RATE_ID, $this->getId());

			if (!isset($this->lastCdrRelatedByIncomeArRateIdCriteria) || !$this->lastCdrRelatedByIncomeArRateIdCriteria->equals($criteria)) {
				$this->collCdrsRelatedByIncomeArRateId = CdrPeer::doSelectJoinArAsteriskAccount($criteria, $con);
			}
		}
		$this->lastCdrRelatedByIncomeArRateIdCriteria = $criteria;

		return $this->collCdrsRelatedByIncomeArRateId;
	}


	
	public function getCdrsRelatedByIncomeArRateIdJoinArTelephonePrefix($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseCdrPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCdrsRelatedByIncomeArRateId === null) {
			if ($this->isNew()) {
				$this->collCdrsRelatedByIncomeArRateId = array();
			} else {

				$criteria->add(CdrPeer::INCOME_AR_RATE_ID, $this->getId());

				$this->collCdrsRelatedByIncomeArRateId = CdrPeer::doSelectJoinArTelephonePrefix($criteria, $con);
			}
		} else {
									
			$criteria->add(CdrPeer::INCOME_AR_RATE_ID, $this->getId());

			if (!isset($this->lastCdrRelatedByIncomeArRateIdCriteria) || !$this->lastCdrRelatedByIncomeArRateIdCriteria->equals($criteria)) {
				$this->collCdrsRelatedByIncomeArRateId = CdrPeer::doSelectJoinArTelephonePrefix($criteria, $con);
			}
		}
		$this->lastCdrRelatedByIncomeArRateIdCriteria = $criteria;

		return $this->collCdrsRelatedByIncomeArRateId;
	}

	
	public function initCdrsRelatedByCostArRateId()
	{
		if ($this->collCdrsRelatedByCostArRateId === null) {
			$this->collCdrsRelatedByCostArRateId = array();
		}
	}

	
	public function getCdrsRelatedByCostArRateId($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseCdrPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCdrsRelatedByCostArRateId === null) {
			if ($this->isNew()) {
			   $this->collCdrsRelatedByCostArRateId = array();
			} else {

				$criteria->add(CdrPeer::COST_AR_RATE_ID, $this->getId());

				CdrPeer::addSelectColumns($criteria);
				$this->collCdrsRelatedByCostArRateId = CdrPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(CdrPeer::COST_AR_RATE_ID, $this->getId());

				CdrPeer::addSelectColumns($criteria);
				if (!isset($this->lastCdrRelatedByCostArRateIdCriteria) || !$this->lastCdrRelatedByCostArRateIdCriteria->equals($criteria)) {
					$this->collCdrsRelatedByCostArRateId = CdrPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastCdrRelatedByCostArRateIdCriteria = $criteria;
		return $this->collCdrsRelatedByCostArRateId;
	}

	
	public function countCdrsRelatedByCostArRateId($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseCdrPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(CdrPeer::COST_AR_RATE_ID, $this->getId());

		return CdrPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addCdrRelatedByCostArRateId(Cdr $l)
	{
		$this->collCdrsRelatedByCostArRateId[] = $l;
		$l->setArRateRelatedByCostArRateId($this);
	}


	
	public function getCdrsRelatedByCostArRateIdJoinArAsteriskAccount($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseCdrPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCdrsRelatedByCostArRateId === null) {
			if ($this->isNew()) {
				$this->collCdrsRelatedByCostArRateId = array();
			} else {

				$criteria->add(CdrPeer::COST_AR_RATE_ID, $this->getId());

				$this->collCdrsRelatedByCostArRateId = CdrPeer::doSelectJoinArAsteriskAccount($criteria, $con);
			}
		} else {
									
			$criteria->add(CdrPeer::COST_AR_RATE_ID, $this->getId());

			if (!isset($this->lastCdrRelatedByCostArRateIdCriteria) || !$this->lastCdrRelatedByCostArRateIdCriteria->equals($criteria)) {
				$this->collCdrsRelatedByCostArRateId = CdrPeer::doSelectJoinArAsteriskAccount($criteria, $con);
			}
		}
		$this->lastCdrRelatedByCostArRateIdCriteria = $criteria;

		return $this->collCdrsRelatedByCostArRateId;
	}


	
	public function getCdrsRelatedByCostArRateIdJoinArTelephonePrefix($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseCdrPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collCdrsRelatedByCostArRateId === null) {
			if ($this->isNew()) {
				$this->collCdrsRelatedByCostArRateId = array();
			} else {

				$criteria->add(CdrPeer::COST_AR_RATE_ID, $this->getId());

				$this->collCdrsRelatedByCostArRateId = CdrPeer::doSelectJoinArTelephonePrefix($criteria, $con);
			}
		} else {
									
			$criteria->add(CdrPeer::COST_AR_RATE_ID, $this->getId());

			if (!isset($this->lastCdrRelatedByCostArRateIdCriteria) || !$this->lastCdrRelatedByCostArRateIdCriteria->equals($criteria)) {
				$this->collCdrsRelatedByCostArRateId = CdrPeer::doSelectJoinArTelephonePrefix($criteria, $con);
			}
		}
		$this->lastCdrRelatedByCostArRateIdCriteria = $criteria;

		return $this->collCdrsRelatedByCostArRateId;
	}

	
	public function initArCustomRateForms()
	{
		if ($this->collArCustomRateForms === null) {
			$this->collArCustomRateForms = array();
		}
	}

	
	public function getArCustomRateForms($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArCustomRateFormPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArCustomRateForms === null) {
			if ($this->isNew()) {
			   $this->collArCustomRateForms = array();
			} else {

				$criteria->add(ArCustomRateFormPeer::ID, $this->getId());

				ArCustomRateFormPeer::addSelectColumns($criteria);
				$this->collArCustomRateForms = ArCustomRateFormPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArCustomRateFormPeer::ID, $this->getId());

				ArCustomRateFormPeer::addSelectColumns($criteria);
				if (!isset($this->lastArCustomRateFormCriteria) || !$this->lastArCustomRateFormCriteria->equals($criteria)) {
					$this->collArCustomRateForms = ArCustomRateFormPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastArCustomRateFormCriteria = $criteria;
		return $this->collArCustomRateForms;
	}

	
	public function countArCustomRateForms($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseArCustomRateFormPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ArCustomRateFormPeer::ID, $this->getId());

		return ArCustomRateFormPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArCustomRateForm(ArCustomRateForm $l)
	{
		$this->collArCustomRateForms[] = $l;
		$l->setArRate($this);
	}

} 