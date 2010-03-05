<?php


abstract class BaseCdr extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $calldate;


	
	protected $clid;


	
	protected $src;


	
	protected $dst;


	
	protected $dcontext;


	
	protected $channel;


	
	protected $dstchannel;


	
	protected $lastapp;


	
	protected $lastdata;


	
	protected $duration;


	
	protected $billsec;


	
	protected $disposition;


	
	protected $amaflags;


	
	protected $accountcode;


	
	protected $uniqueid = '';


	
	protected $userfield;


	
	protected $income_ar_rate_id = 0;


	
	protected $income = 0;


	
	protected $cost_ar_rate_id = 0;


	
	protected $vendor_id = 0;


	
	protected $cost = 0;


	
	protected $ar_telephone_prefix_id;


	
	protected $id;

	
	protected $aArAsteriskAccount;

	
	protected $aArTelephonePrefix;

	
	protected $aArRateRelatedByIncomeArRateId;

	
	protected $aArRateRelatedByCostArRateId;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getCalldate($format = 'Y-m-d H:i:s')
	{

		if ($this->calldate === null || $this->calldate === '') {
			return null;
		} elseif (!is_int($this->calldate)) {
						$ts = strtotime($this->calldate);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [calldate] as date/time value: " . var_export($this->calldate, true));
			}
		} else {
			$ts = $this->calldate;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getClid()
	{

		return $this->clid;
	}

	
	public function getSrc()
	{

		return $this->src;
	}

	
	public function getDst()
	{

		return $this->dst;
	}

	
	public function getDcontext()
	{

		return $this->dcontext;
	}

	
	public function getChannel()
	{

		return $this->channel;
	}

	
	public function getDstchannel()
	{

		return $this->dstchannel;
	}

	
	public function getLastapp()
	{

		return $this->lastapp;
	}

	
	public function getLastdata()
	{

		return $this->lastdata;
	}

	
	public function getDuration()
	{

		return $this->duration;
	}

	
	public function getBillsec()
	{

		return $this->billsec;
	}

	
	public function getDisposition()
	{

		return $this->disposition;
	}

	
	public function getAmaflags()
	{

		return $this->amaflags;
	}

	
	public function getAccountcode()
	{

		return $this->accountcode;
	}

	
	public function getUniqueid()
	{

		return $this->uniqueid;
	}

	
	public function getUserfield()
	{

		return $this->userfield;
	}

	
	public function getIncomeArRateId()
	{

		return $this->income_ar_rate_id;
	}

	
	public function getIncome()
	{

		return $this->income;
	}

	
	public function getCostArRateId()
	{

		return $this->cost_ar_rate_id;
	}

	
	public function getVendorId()
	{

		return $this->vendor_id;
	}

	
	public function getCost()
	{

		return $this->cost;
	}

	
	public function getArTelephonePrefixId()
	{

		return $this->ar_telephone_prefix_id;
	}

	
	public function getId()
	{

		return $this->id;
	}

	
	public function setCalldate($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [calldate] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->calldate !== $ts) {
			$this->calldate = $ts;
			$this->modifiedColumns[] = CdrPeer::CALLDATE;
		}

	} 
	
	public function setClid($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->clid !== $v) {
			$this->clid = $v;
			$this->modifiedColumns[] = CdrPeer::CLID;
		}

	} 
	
	public function setSrc($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->src !== $v) {
			$this->src = $v;
			$this->modifiedColumns[] = CdrPeer::SRC;
		}

	} 
	
	public function setDst($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->dst !== $v) {
			$this->dst = $v;
			$this->modifiedColumns[] = CdrPeer::DST;
		}

	} 
	
	public function setDcontext($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->dcontext !== $v) {
			$this->dcontext = $v;
			$this->modifiedColumns[] = CdrPeer::DCONTEXT;
		}

	} 
	
	public function setChannel($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->channel !== $v) {
			$this->channel = $v;
			$this->modifiedColumns[] = CdrPeer::CHANNEL;
		}

	} 
	
	public function setDstchannel($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->dstchannel !== $v) {
			$this->dstchannel = $v;
			$this->modifiedColumns[] = CdrPeer::DSTCHANNEL;
		}

	} 
	
	public function setLastapp($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->lastapp !== $v) {
			$this->lastapp = $v;
			$this->modifiedColumns[] = CdrPeer::LASTAPP;
		}

	} 
	
	public function setLastdata($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->lastdata !== $v) {
			$this->lastdata = $v;
			$this->modifiedColumns[] = CdrPeer::LASTDATA;
		}

	} 
	
	public function setDuration($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->duration !== $v) {
			$this->duration = $v;
			$this->modifiedColumns[] = CdrPeer::DURATION;
		}

	} 
	
	public function setBillsec($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->billsec !== $v) {
			$this->billsec = $v;
			$this->modifiedColumns[] = CdrPeer::BILLSEC;
		}

	} 
	
	public function setDisposition($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->disposition !== $v) {
			$this->disposition = $v;
			$this->modifiedColumns[] = CdrPeer::DISPOSITION;
		}

	} 
	
	public function setAmaflags($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->amaflags !== $v) {
			$this->amaflags = $v;
			$this->modifiedColumns[] = CdrPeer::AMAFLAGS;
		}

	} 
	
	public function setAccountcode($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->accountcode !== $v) {
			$this->accountcode = $v;
			$this->modifiedColumns[] = CdrPeer::ACCOUNTCODE;
		}

		if ($this->aArAsteriskAccount !== null && $this->aArAsteriskAccount->getAccountCode() !== $v) {
			$this->aArAsteriskAccount = null;
		}

	} 
	
	public function setUniqueid($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->uniqueid !== $v || $v === '') {
			$this->uniqueid = $v;
			$this->modifiedColumns[] = CdrPeer::UNIQUEID;
		}

	} 
	
	public function setUserfield($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->userfield !== $v) {
			$this->userfield = $v;
			$this->modifiedColumns[] = CdrPeer::USERFIELD;
		}

	} 
	
	public function setIncomeArRateId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->income_ar_rate_id !== $v || $v === 0) {
			$this->income_ar_rate_id = $v;
			$this->modifiedColumns[] = CdrPeer::INCOME_AR_RATE_ID;
		}

		if ($this->aArRateRelatedByIncomeArRateId !== null && $this->aArRateRelatedByIncomeArRateId->getId() !== $v) {
			$this->aArRateRelatedByIncomeArRateId = null;
		}

	} 
	
	public function setIncome($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->income !== $v || $v === 0) {
			$this->income = $v;
			$this->modifiedColumns[] = CdrPeer::INCOME;
		}

	} 
	
	public function setCostArRateId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->cost_ar_rate_id !== $v || $v === 0) {
			$this->cost_ar_rate_id = $v;
			$this->modifiedColumns[] = CdrPeer::COST_AR_RATE_ID;
		}

		if ($this->aArRateRelatedByCostArRateId !== null && $this->aArRateRelatedByCostArRateId->getId() !== $v) {
			$this->aArRateRelatedByCostArRateId = null;
		}

	} 
	
	public function setVendorId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->vendor_id !== $v || $v === 0) {
			$this->vendor_id = $v;
			$this->modifiedColumns[] = CdrPeer::VENDOR_ID;
		}

	} 
	
	public function setCost($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->cost !== $v || $v === 0) {
			$this->cost = $v;
			$this->modifiedColumns[] = CdrPeer::COST;
		}

	} 
	
	public function setArTelephonePrefixId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ar_telephone_prefix_id !== $v) {
			$this->ar_telephone_prefix_id = $v;
			$this->modifiedColumns[] = CdrPeer::AR_TELEPHONE_PREFIX_ID;
		}

		if ($this->aArTelephonePrefix !== null && $this->aArTelephonePrefix->getId() !== $v) {
			$this->aArTelephonePrefix = null;
		}

	} 
	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = CdrPeer::ID;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->calldate = $rs->getTimestamp($startcol + 0, null);

			$this->clid = $rs->getString($startcol + 1);

			$this->src = $rs->getString($startcol + 2);

			$this->dst = $rs->getString($startcol + 3);

			$this->dcontext = $rs->getString($startcol + 4);

			$this->channel = $rs->getString($startcol + 5);

			$this->dstchannel = $rs->getString($startcol + 6);

			$this->lastapp = $rs->getString($startcol + 7);

			$this->lastdata = $rs->getString($startcol + 8);

			$this->duration = $rs->getInt($startcol + 9);

			$this->billsec = $rs->getInt($startcol + 10);

			$this->disposition = $rs->getString($startcol + 11);

			$this->amaflags = $rs->getInt($startcol + 12);

			$this->accountcode = $rs->getString($startcol + 13);

			$this->uniqueid = $rs->getString($startcol + 14);

			$this->userfield = $rs->getString($startcol + 15);

			$this->income_ar_rate_id = $rs->getInt($startcol + 16);

			$this->income = $rs->getInt($startcol + 17);

			$this->cost_ar_rate_id = $rs->getInt($startcol + 18);

			$this->vendor_id = $rs->getInt($startcol + 19);

			$this->cost = $rs->getInt($startcol + 20);

			$this->ar_telephone_prefix_id = $rs->getInt($startcol + 21);

			$this->id = $rs->getInt($startcol + 22);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 23; 
		} catch (Exception $e) {
			throw new PropelException("Error populating Cdr object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(CdrPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			CdrPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(CdrPeer::DATABASE_NAME);
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


												
			if ($this->aArAsteriskAccount !== null) {
				if ($this->aArAsteriskAccount->isModified()) {
					$affectedRows += $this->aArAsteriskAccount->save($con);
				}
				$this->setArAsteriskAccount($this->aArAsteriskAccount);
			}

			if ($this->aArTelephonePrefix !== null) {
				if ($this->aArTelephonePrefix->isModified()) {
					$affectedRows += $this->aArTelephonePrefix->save($con);
				}
				$this->setArTelephonePrefix($this->aArTelephonePrefix);
			}

			if ($this->aArRateRelatedByIncomeArRateId !== null) {
				if ($this->aArRateRelatedByIncomeArRateId->isModified()) {
					$affectedRows += $this->aArRateRelatedByIncomeArRateId->save($con);
				}
				$this->setArRateRelatedByIncomeArRateId($this->aArRateRelatedByIncomeArRateId);
			}

			if ($this->aArRateRelatedByCostArRateId !== null) {
				if ($this->aArRateRelatedByCostArRateId->isModified()) {
					$affectedRows += $this->aArRateRelatedByCostArRateId->save($con);
				}
				$this->setArRateRelatedByCostArRateId($this->aArRateRelatedByCostArRateId);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = CdrPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += CdrPeer::doUpdate($this, $con);
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


												
			if ($this->aArAsteriskAccount !== null) {
				if (!$this->aArAsteriskAccount->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aArAsteriskAccount->getValidationFailures());
				}
			}

			if ($this->aArTelephonePrefix !== null) {
				if (!$this->aArTelephonePrefix->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aArTelephonePrefix->getValidationFailures());
				}
			}

			if ($this->aArRateRelatedByIncomeArRateId !== null) {
				if (!$this->aArRateRelatedByIncomeArRateId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aArRateRelatedByIncomeArRateId->getValidationFailures());
				}
			}

			if ($this->aArRateRelatedByCostArRateId !== null) {
				if (!$this->aArRateRelatedByCostArRateId->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aArRateRelatedByCostArRateId->getValidationFailures());
				}
			}


			if (($retval = CdrPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = CdrPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getCalldate();
				break;
			case 1:
				return $this->getClid();
				break;
			case 2:
				return $this->getSrc();
				break;
			case 3:
				return $this->getDst();
				break;
			case 4:
				return $this->getDcontext();
				break;
			case 5:
				return $this->getChannel();
				break;
			case 6:
				return $this->getDstchannel();
				break;
			case 7:
				return $this->getLastapp();
				break;
			case 8:
				return $this->getLastdata();
				break;
			case 9:
				return $this->getDuration();
				break;
			case 10:
				return $this->getBillsec();
				break;
			case 11:
				return $this->getDisposition();
				break;
			case 12:
				return $this->getAmaflags();
				break;
			case 13:
				return $this->getAccountcode();
				break;
			case 14:
				return $this->getUniqueid();
				break;
			case 15:
				return $this->getUserfield();
				break;
			case 16:
				return $this->getIncomeArRateId();
				break;
			case 17:
				return $this->getIncome();
				break;
			case 18:
				return $this->getCostArRateId();
				break;
			case 19:
				return $this->getVendorId();
				break;
			case 20:
				return $this->getCost();
				break;
			case 21:
				return $this->getArTelephonePrefixId();
				break;
			case 22:
				return $this->getId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = CdrPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getCalldate(),
			$keys[1] => $this->getClid(),
			$keys[2] => $this->getSrc(),
			$keys[3] => $this->getDst(),
			$keys[4] => $this->getDcontext(),
			$keys[5] => $this->getChannel(),
			$keys[6] => $this->getDstchannel(),
			$keys[7] => $this->getLastapp(),
			$keys[8] => $this->getLastdata(),
			$keys[9] => $this->getDuration(),
			$keys[10] => $this->getBillsec(),
			$keys[11] => $this->getDisposition(),
			$keys[12] => $this->getAmaflags(),
			$keys[13] => $this->getAccountcode(),
			$keys[14] => $this->getUniqueid(),
			$keys[15] => $this->getUserfield(),
			$keys[16] => $this->getIncomeArRateId(),
			$keys[17] => $this->getIncome(),
			$keys[18] => $this->getCostArRateId(),
			$keys[19] => $this->getVendorId(),
			$keys[20] => $this->getCost(),
			$keys[21] => $this->getArTelephonePrefixId(),
			$keys[22] => $this->getId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = CdrPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setCalldate($value);
				break;
			case 1:
				$this->setClid($value);
				break;
			case 2:
				$this->setSrc($value);
				break;
			case 3:
				$this->setDst($value);
				break;
			case 4:
				$this->setDcontext($value);
				break;
			case 5:
				$this->setChannel($value);
				break;
			case 6:
				$this->setDstchannel($value);
				break;
			case 7:
				$this->setLastapp($value);
				break;
			case 8:
				$this->setLastdata($value);
				break;
			case 9:
				$this->setDuration($value);
				break;
			case 10:
				$this->setBillsec($value);
				break;
			case 11:
				$this->setDisposition($value);
				break;
			case 12:
				$this->setAmaflags($value);
				break;
			case 13:
				$this->setAccountcode($value);
				break;
			case 14:
				$this->setUniqueid($value);
				break;
			case 15:
				$this->setUserfield($value);
				break;
			case 16:
				$this->setIncomeArRateId($value);
				break;
			case 17:
				$this->setIncome($value);
				break;
			case 18:
				$this->setCostArRateId($value);
				break;
			case 19:
				$this->setVendorId($value);
				break;
			case 20:
				$this->setCost($value);
				break;
			case 21:
				$this->setArTelephonePrefixId($value);
				break;
			case 22:
				$this->setId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = CdrPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setCalldate($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setClid($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setSrc($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setDst($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setDcontext($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setChannel($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setDstchannel($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setLastapp($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setLastdata($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setDuration($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setBillsec($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setDisposition($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setAmaflags($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setAccountcode($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setUniqueid($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setUserfield($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setIncomeArRateId($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setIncome($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setCostArRateId($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setVendorId($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setCost($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setArTelephonePrefixId($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setId($arr[$keys[22]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(CdrPeer::DATABASE_NAME);

		if ($this->isColumnModified(CdrPeer::CALLDATE)) $criteria->add(CdrPeer::CALLDATE, $this->calldate);
		if ($this->isColumnModified(CdrPeer::CLID)) $criteria->add(CdrPeer::CLID, $this->clid);
		if ($this->isColumnModified(CdrPeer::SRC)) $criteria->add(CdrPeer::SRC, $this->src);
		if ($this->isColumnModified(CdrPeer::DST)) $criteria->add(CdrPeer::DST, $this->dst);
		if ($this->isColumnModified(CdrPeer::DCONTEXT)) $criteria->add(CdrPeer::DCONTEXT, $this->dcontext);
		if ($this->isColumnModified(CdrPeer::CHANNEL)) $criteria->add(CdrPeer::CHANNEL, $this->channel);
		if ($this->isColumnModified(CdrPeer::DSTCHANNEL)) $criteria->add(CdrPeer::DSTCHANNEL, $this->dstchannel);
		if ($this->isColumnModified(CdrPeer::LASTAPP)) $criteria->add(CdrPeer::LASTAPP, $this->lastapp);
		if ($this->isColumnModified(CdrPeer::LASTDATA)) $criteria->add(CdrPeer::LASTDATA, $this->lastdata);
		if ($this->isColumnModified(CdrPeer::DURATION)) $criteria->add(CdrPeer::DURATION, $this->duration);
		if ($this->isColumnModified(CdrPeer::BILLSEC)) $criteria->add(CdrPeer::BILLSEC, $this->billsec);
		if ($this->isColumnModified(CdrPeer::DISPOSITION)) $criteria->add(CdrPeer::DISPOSITION, $this->disposition);
		if ($this->isColumnModified(CdrPeer::AMAFLAGS)) $criteria->add(CdrPeer::AMAFLAGS, $this->amaflags);
		if ($this->isColumnModified(CdrPeer::ACCOUNTCODE)) $criteria->add(CdrPeer::ACCOUNTCODE, $this->accountcode);
		if ($this->isColumnModified(CdrPeer::UNIQUEID)) $criteria->add(CdrPeer::UNIQUEID, $this->uniqueid);
		if ($this->isColumnModified(CdrPeer::USERFIELD)) $criteria->add(CdrPeer::USERFIELD, $this->userfield);
		if ($this->isColumnModified(CdrPeer::INCOME_AR_RATE_ID)) $criteria->add(CdrPeer::INCOME_AR_RATE_ID, $this->income_ar_rate_id);
		if ($this->isColumnModified(CdrPeer::INCOME)) $criteria->add(CdrPeer::INCOME, $this->income);
		if ($this->isColumnModified(CdrPeer::COST_AR_RATE_ID)) $criteria->add(CdrPeer::COST_AR_RATE_ID, $this->cost_ar_rate_id);
		if ($this->isColumnModified(CdrPeer::VENDOR_ID)) $criteria->add(CdrPeer::VENDOR_ID, $this->vendor_id);
		if ($this->isColumnModified(CdrPeer::COST)) $criteria->add(CdrPeer::COST, $this->cost);
		if ($this->isColumnModified(CdrPeer::AR_TELEPHONE_PREFIX_ID)) $criteria->add(CdrPeer::AR_TELEPHONE_PREFIX_ID, $this->ar_telephone_prefix_id);
		if ($this->isColumnModified(CdrPeer::ID)) $criteria->add(CdrPeer::ID, $this->id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(CdrPeer::DATABASE_NAME);

		$criteria->add(CdrPeer::ID, $this->id);

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

		$copyObj->setCalldate($this->calldate);

		$copyObj->setClid($this->clid);

		$copyObj->setSrc($this->src);

		$copyObj->setDst($this->dst);

		$copyObj->setDcontext($this->dcontext);

		$copyObj->setChannel($this->channel);

		$copyObj->setDstchannel($this->dstchannel);

		$copyObj->setLastapp($this->lastapp);

		$copyObj->setLastdata($this->lastdata);

		$copyObj->setDuration($this->duration);

		$copyObj->setBillsec($this->billsec);

		$copyObj->setDisposition($this->disposition);

		$copyObj->setAmaflags($this->amaflags);

		$copyObj->setAccountcode($this->accountcode);

		$copyObj->setUniqueid($this->uniqueid);

		$copyObj->setUserfield($this->userfield);

		$copyObj->setIncomeArRateId($this->income_ar_rate_id);

		$copyObj->setIncome($this->income);

		$copyObj->setCostArRateId($this->cost_ar_rate_id);

		$copyObj->setVendorId($this->vendor_id);

		$copyObj->setCost($this->cost);

		$copyObj->setArTelephonePrefixId($this->ar_telephone_prefix_id);


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
			self::$peer = new CdrPeer();
		}
		return self::$peer;
	}

	
	public function setArAsteriskAccount($v)
	{


		if ($v === null) {
			$this->setAccountcode(NULL);
		} else {
			$this->setAccountcode($v->getAccountCode());
		}


		$this->aArAsteriskAccount = $v;
	}


	
	public function getArAsteriskAccount($con = null)
	{
		if ($this->aArAsteriskAccount === null && (($this->accountcode !== "" && $this->accountcode !== null))) {
						include_once 'lib/model/om/BaseArAsteriskAccountPeer.php';

			$this->aArAsteriskAccount = ArAsteriskAccountPeer::retrieveByPK($this->accountcode, $con);

			
		}
		return $this->aArAsteriskAccount;
	}

	
	public function setArTelephonePrefix($v)
	{


		if ($v === null) {
			$this->setArTelephonePrefixId(NULL);
		} else {
			$this->setArTelephonePrefixId($v->getId());
		}


		$this->aArTelephonePrefix = $v;
	}


	
	public function getArTelephonePrefix($con = null)
	{
		if ($this->aArTelephonePrefix === null && ($this->ar_telephone_prefix_id !== null)) {
						include_once 'lib/model/om/BaseArTelephonePrefixPeer.php';

			$this->aArTelephonePrefix = ArTelephonePrefixPeer::retrieveByPK($this->ar_telephone_prefix_id, $con);

			
		}
		return $this->aArTelephonePrefix;
	}

	
	public function setArRateRelatedByIncomeArRateId($v)
	{


		if ($v === null) {
			$this->setIncomeArRateId('null');
		} else {
			$this->setIncomeArRateId($v->getId());
		}


		$this->aArRateRelatedByIncomeArRateId = $v;
	}


	
	public function getArRateRelatedByIncomeArRateId($con = null)
	{
		if ($this->aArRateRelatedByIncomeArRateId === null && ($this->income_ar_rate_id !== null)) {
						include_once 'lib/model/om/BaseArRatePeer.php';

			$this->aArRateRelatedByIncomeArRateId = ArRatePeer::retrieveByPK($this->income_ar_rate_id, $con);

			
		}
		return $this->aArRateRelatedByIncomeArRateId;
	}

	
	public function setArRateRelatedByCostArRateId($v)
	{


		if ($v === null) {
			$this->setCostArRateId('null');
		} else {
			$this->setCostArRateId($v->getId());
		}


		$this->aArRateRelatedByCostArRateId = $v;
	}


	
	public function getArRateRelatedByCostArRateId($con = null)
	{
		if ($this->aArRateRelatedByCostArRateId === null && ($this->cost_ar_rate_id !== null)) {
						include_once 'lib/model/om/BaseArRatePeer.php';

			$this->aArRateRelatedByCostArRateId = ArRatePeer::retrieveByPK($this->cost_ar_rate_id, $con);

			
		}
		return $this->aArRateRelatedByCostArRateId;
	}

} 