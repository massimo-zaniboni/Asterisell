<?php


abstract class BaseArInvoiceCreation extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $ar_params_id;


	
	protected $type = 'C';


	
	protected $is_revenue_sharing = false;


	
	protected $first_nr;


	
	protected $invoice_date;


	
	protected $ar_cdr_from;


	
	protected $ar_cdr_to;

	
	protected $aArParams;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getArParamsId()
	{

		return $this->ar_params_id;
	}

	
	public function getType()
	{

		return $this->type;
	}

	
	public function getIsRevenueSharing()
	{

		return $this->is_revenue_sharing;
	}

	
	public function getFirstNr()
	{

		return $this->first_nr;
	}

	
	public function getInvoiceDate($format = 'Y-m-d')
	{

		if ($this->invoice_date === null || $this->invoice_date === '') {
			return null;
		} elseif (!is_int($this->invoice_date)) {
						$ts = strtotime($this->invoice_date);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [invoice_date] as date/time value: " . var_export($this->invoice_date, true));
			}
		} else {
			$ts = $this->invoice_date;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getArCdrFrom($format = 'Y-m-d')
	{

		if ($this->ar_cdr_from === null || $this->ar_cdr_from === '') {
			return null;
		} elseif (!is_int($this->ar_cdr_from)) {
						$ts = strtotime($this->ar_cdr_from);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [ar_cdr_from] as date/time value: " . var_export($this->ar_cdr_from, true));
			}
		} else {
			$ts = $this->ar_cdr_from;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getArCdrTo($format = 'Y-m-d')
	{

		if ($this->ar_cdr_to === null || $this->ar_cdr_to === '') {
			return null;
		} elseif (!is_int($this->ar_cdr_to)) {
						$ts = strtotime($this->ar_cdr_to);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [ar_cdr_to] as date/time value: " . var_export($this->ar_cdr_to, true));
			}
		} else {
			$ts = $this->ar_cdr_to;
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
			$this->modifiedColumns[] = ArInvoiceCreationPeer::ID;
		}

	} 
	
	public function setArParamsId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ar_params_id !== $v) {
			$this->ar_params_id = $v;
			$this->modifiedColumns[] = ArInvoiceCreationPeer::AR_PARAMS_ID;
		}

		if ($this->aArParams !== null && $this->aArParams->getId() !== $v) {
			$this->aArParams = null;
		}

	} 
	
	public function setType($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->type !== $v || $v === 'C') {
			$this->type = $v;
			$this->modifiedColumns[] = ArInvoiceCreationPeer::TYPE;
		}

	} 
	
	public function setIsRevenueSharing($v)
	{

		if ($this->is_revenue_sharing !== $v || $v === false) {
			$this->is_revenue_sharing = $v;
			$this->modifiedColumns[] = ArInvoiceCreationPeer::IS_REVENUE_SHARING;
		}

	} 
	
	public function setFirstNr($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->first_nr !== $v) {
			$this->first_nr = $v;
			$this->modifiedColumns[] = ArInvoiceCreationPeer::FIRST_NR;
		}

	} 
	
	public function setInvoiceDate($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [invoice_date] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->invoice_date !== $ts) {
			$this->invoice_date = $ts;
			$this->modifiedColumns[] = ArInvoiceCreationPeer::INVOICE_DATE;
		}

	} 
	
	public function setArCdrFrom($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [ar_cdr_from] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->ar_cdr_from !== $ts) {
			$this->ar_cdr_from = $ts;
			$this->modifiedColumns[] = ArInvoiceCreationPeer::AR_CDR_FROM;
		}

	} 
	
	public function setArCdrTo($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [ar_cdr_to] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->ar_cdr_to !== $ts) {
			$this->ar_cdr_to = $ts;
			$this->modifiedColumns[] = ArInvoiceCreationPeer::AR_CDR_TO;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->ar_params_id = $rs->getInt($startcol + 1);

			$this->type = $rs->getString($startcol + 2);

			$this->is_revenue_sharing = $rs->getBoolean($startcol + 3);

			$this->first_nr = $rs->getString($startcol + 4);

			$this->invoice_date = $rs->getDate($startcol + 5, null);

			$this->ar_cdr_from = $rs->getDate($startcol + 6, null);

			$this->ar_cdr_to = $rs->getDate($startcol + 7, null);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 8; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ArInvoiceCreation object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArInvoiceCreationPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArInvoiceCreationPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(ArInvoiceCreationPeer::DATABASE_NAME);
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


												
			if ($this->aArParams !== null) {
				if ($this->aArParams->isModified()) {
					$affectedRows += $this->aArParams->save($con);
				}
				$this->setArParams($this->aArParams);
			}


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ArInvoiceCreationPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArInvoiceCreationPeer::doUpdate($this, $con);
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


												
			if ($this->aArParams !== null) {
				if (!$this->aArParams->validate($columns)) {
					$failureMap = array_merge($failureMap, $this->aArParams->getValidationFailures());
				}
			}


			if (($retval = ArInvoiceCreationPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArInvoiceCreationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getArParamsId();
				break;
			case 2:
				return $this->getType();
				break;
			case 3:
				return $this->getIsRevenueSharing();
				break;
			case 4:
				return $this->getFirstNr();
				break;
			case 5:
				return $this->getInvoiceDate();
				break;
			case 6:
				return $this->getArCdrFrom();
				break;
			case 7:
				return $this->getArCdrTo();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArInvoiceCreationPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getArParamsId(),
			$keys[2] => $this->getType(),
			$keys[3] => $this->getIsRevenueSharing(),
			$keys[4] => $this->getFirstNr(),
			$keys[5] => $this->getInvoiceDate(),
			$keys[6] => $this->getArCdrFrom(),
			$keys[7] => $this->getArCdrTo(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArInvoiceCreationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setArParamsId($value);
				break;
			case 2:
				$this->setType($value);
				break;
			case 3:
				$this->setIsRevenueSharing($value);
				break;
			case 4:
				$this->setFirstNr($value);
				break;
			case 5:
				$this->setInvoiceDate($value);
				break;
			case 6:
				$this->setArCdrFrom($value);
				break;
			case 7:
				$this->setArCdrTo($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArInvoiceCreationPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setArParamsId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setType($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setIsRevenueSharing($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setFirstNr($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setInvoiceDate($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setArCdrFrom($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setArCdrTo($arr[$keys[7]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArInvoiceCreationPeer::DATABASE_NAME);

		if ($this->isColumnModified(ArInvoiceCreationPeer::ID)) $criteria->add(ArInvoiceCreationPeer::ID, $this->id);
		if ($this->isColumnModified(ArInvoiceCreationPeer::AR_PARAMS_ID)) $criteria->add(ArInvoiceCreationPeer::AR_PARAMS_ID, $this->ar_params_id);
		if ($this->isColumnModified(ArInvoiceCreationPeer::TYPE)) $criteria->add(ArInvoiceCreationPeer::TYPE, $this->type);
		if ($this->isColumnModified(ArInvoiceCreationPeer::IS_REVENUE_SHARING)) $criteria->add(ArInvoiceCreationPeer::IS_REVENUE_SHARING, $this->is_revenue_sharing);
		if ($this->isColumnModified(ArInvoiceCreationPeer::FIRST_NR)) $criteria->add(ArInvoiceCreationPeer::FIRST_NR, $this->first_nr);
		if ($this->isColumnModified(ArInvoiceCreationPeer::INVOICE_DATE)) $criteria->add(ArInvoiceCreationPeer::INVOICE_DATE, $this->invoice_date);
		if ($this->isColumnModified(ArInvoiceCreationPeer::AR_CDR_FROM)) $criteria->add(ArInvoiceCreationPeer::AR_CDR_FROM, $this->ar_cdr_from);
		if ($this->isColumnModified(ArInvoiceCreationPeer::AR_CDR_TO)) $criteria->add(ArInvoiceCreationPeer::AR_CDR_TO, $this->ar_cdr_to);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArInvoiceCreationPeer::DATABASE_NAME);

		$criteria->add(ArInvoiceCreationPeer::ID, $this->id);

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

		$copyObj->setArParamsId($this->ar_params_id);

		$copyObj->setType($this->type);

		$copyObj->setIsRevenueSharing($this->is_revenue_sharing);

		$copyObj->setFirstNr($this->first_nr);

		$copyObj->setInvoiceDate($this->invoice_date);

		$copyObj->setArCdrFrom($this->ar_cdr_from);

		$copyObj->setArCdrTo($this->ar_cdr_to);


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
			self::$peer = new ArInvoiceCreationPeer();
		}
		return self::$peer;
	}

	
	public function setArParams($v)
	{


		if ($v === null) {
			$this->setArParamsId(NULL);
		} else {
			$this->setArParamsId($v->getId());
		}


		$this->aArParams = $v;
	}


	
	public function getArParams($con = null)
	{
		if ($this->aArParams === null && ($this->ar_params_id !== null)) {
						include_once 'lib/model/om/BaseArParamsPeer.php';

			$this->aArParams = ArParamsPeer::retrieveByPK($this->ar_params_id, $con);

			
		}
		return $this->aArParams;
	}

} 