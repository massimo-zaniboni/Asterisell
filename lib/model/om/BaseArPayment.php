<?php


abstract class BaseArPayment extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $ar_party_id;


	
	protected $date;


	
	protected $invoice_nr;


	
	protected $payment_method;


	
	protected $payment_references;


	
	protected $amount = 0;


	
	protected $note;

	
	protected $aArParty;

	
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

	
	public function getDate($format = 'Y-m-d')
	{

		if ($this->date === null || $this->date === '') {
			return null;
		} elseif (!is_int($this->date)) {
						$ts = strtotime($this->date);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [date] as date/time value: " . var_export($this->date, true));
			}
		} else {
			$ts = $this->date;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getInvoiceNr()
	{

		return $this->invoice_nr;
	}

	
	public function getPaymentMethod()
	{

		return $this->payment_method;
	}

	
	public function getPaymentReferences()
	{

		return $this->payment_references;
	}

	
	public function getAmount()
	{

		return $this->amount;
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
			$this->modifiedColumns[] = ArPaymentPeer::ID;
		}

	} 
	
	public function setArPartyId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ar_party_id !== $v) {
			$this->ar_party_id = $v;
			$this->modifiedColumns[] = ArPaymentPeer::AR_PARTY_ID;
		}

		if ($this->aArParty !== null && $this->aArParty->getId() !== $v) {
			$this->aArParty = null;
		}

	} 
	
	public function setDate($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [date] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->date !== $ts) {
			$this->date = $ts;
			$this->modifiedColumns[] = ArPaymentPeer::DATE;
		}

	} 
	
	public function setInvoiceNr($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->invoice_nr !== $v) {
			$this->invoice_nr = $v;
			$this->modifiedColumns[] = ArPaymentPeer::INVOICE_NR;
		}

	} 
	
	public function setPaymentMethod($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->payment_method !== $v) {
			$this->payment_method = $v;
			$this->modifiedColumns[] = ArPaymentPeer::PAYMENT_METHOD;
		}

	} 
	
	public function setPaymentReferences($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->payment_references !== $v) {
			$this->payment_references = $v;
			$this->modifiedColumns[] = ArPaymentPeer::PAYMENT_REFERENCES;
		}

	} 
	
	public function setAmount($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->amount !== $v || $v === 0) {
			$this->amount = $v;
			$this->modifiedColumns[] = ArPaymentPeer::AMOUNT;
		}

	} 
	
	public function setNote($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->note !== $v) {
			$this->note = $v;
			$this->modifiedColumns[] = ArPaymentPeer::NOTE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->ar_party_id = $rs->getInt($startcol + 1);

			$this->date = $rs->getDate($startcol + 2, null);

			$this->invoice_nr = $rs->getString($startcol + 3);

			$this->payment_method = $rs->getString($startcol + 4);

			$this->payment_references = $rs->getString($startcol + 5);

			$this->amount = $rs->getInt($startcol + 6);

			$this->note = $rs->getString($startcol + 7);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 8; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ArPayment object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArPaymentPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArPaymentPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(ArPaymentPeer::DATABASE_NAME);
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


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ArPaymentPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArPaymentPeer::doUpdate($this, $con);
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


			if (($retval = ArPaymentPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArPaymentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getDate();
				break;
			case 3:
				return $this->getInvoiceNr();
				break;
			case 4:
				return $this->getPaymentMethod();
				break;
			case 5:
				return $this->getPaymentReferences();
				break;
			case 6:
				return $this->getAmount();
				break;
			case 7:
				return $this->getNote();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArPaymentPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getArPartyId(),
			$keys[2] => $this->getDate(),
			$keys[3] => $this->getInvoiceNr(),
			$keys[4] => $this->getPaymentMethod(),
			$keys[5] => $this->getPaymentReferences(),
			$keys[6] => $this->getAmount(),
			$keys[7] => $this->getNote(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArPaymentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setDate($value);
				break;
			case 3:
				$this->setInvoiceNr($value);
				break;
			case 4:
				$this->setPaymentMethod($value);
				break;
			case 5:
				$this->setPaymentReferences($value);
				break;
			case 6:
				$this->setAmount($value);
				break;
			case 7:
				$this->setNote($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArPaymentPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setArPartyId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDate($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setInvoiceNr($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setPaymentMethod($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setPaymentReferences($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setAmount($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setNote($arr[$keys[7]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArPaymentPeer::DATABASE_NAME);

		if ($this->isColumnModified(ArPaymentPeer::ID)) $criteria->add(ArPaymentPeer::ID, $this->id);
		if ($this->isColumnModified(ArPaymentPeer::AR_PARTY_ID)) $criteria->add(ArPaymentPeer::AR_PARTY_ID, $this->ar_party_id);
		if ($this->isColumnModified(ArPaymentPeer::DATE)) $criteria->add(ArPaymentPeer::DATE, $this->date);
		if ($this->isColumnModified(ArPaymentPeer::INVOICE_NR)) $criteria->add(ArPaymentPeer::INVOICE_NR, $this->invoice_nr);
		if ($this->isColumnModified(ArPaymentPeer::PAYMENT_METHOD)) $criteria->add(ArPaymentPeer::PAYMENT_METHOD, $this->payment_method);
		if ($this->isColumnModified(ArPaymentPeer::PAYMENT_REFERENCES)) $criteria->add(ArPaymentPeer::PAYMENT_REFERENCES, $this->payment_references);
		if ($this->isColumnModified(ArPaymentPeer::AMOUNT)) $criteria->add(ArPaymentPeer::AMOUNT, $this->amount);
		if ($this->isColumnModified(ArPaymentPeer::NOTE)) $criteria->add(ArPaymentPeer::NOTE, $this->note);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArPaymentPeer::DATABASE_NAME);

		$criteria->add(ArPaymentPeer::ID, $this->id);

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

		$copyObj->setDate($this->date);

		$copyObj->setInvoiceNr($this->invoice_nr);

		$copyObj->setPaymentMethod($this->payment_method);

		$copyObj->setPaymentReferences($this->payment_references);

		$copyObj->setAmount($this->amount);

		$copyObj->setNote($this->note);


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
			self::$peer = new ArPaymentPeer();
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

} 