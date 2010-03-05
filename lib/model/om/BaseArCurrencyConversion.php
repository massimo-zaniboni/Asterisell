<?php


abstract class BaseArCurrencyConversion extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $source_currency;


	
	protected $dest_currency;


	
	protected $conversion_factor;


	
	protected $id;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getSourceCurrency()
	{

		return $this->source_currency;
	}

	
	public function getDestCurrency()
	{

		return $this->dest_currency;
	}

	
	public function getConversionFactor()
	{

		return $this->conversion_factor;
	}

	
	public function getId()
	{

		return $this->id;
	}

	
	public function setSourceCurrency($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->source_currency !== $v) {
			$this->source_currency = $v;
			$this->modifiedColumns[] = ArCurrencyConversionPeer::SOURCE_CURRENCY;
		}

	} 
	
	public function setDestCurrency($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->dest_currency !== $v) {
			$this->dest_currency = $v;
			$this->modifiedColumns[] = ArCurrencyConversionPeer::DEST_CURRENCY;
		}

	} 
	
	public function setConversionFactor($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->conversion_factor !== $v) {
			$this->conversion_factor = $v;
			$this->modifiedColumns[] = ArCurrencyConversionPeer::CONVERSION_FACTOR;
		}

	} 
	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ArCurrencyConversionPeer::ID;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->source_currency = $rs->getString($startcol + 0);

			$this->dest_currency = $rs->getString($startcol + 1);

			$this->conversion_factor = $rs->getString($startcol + 2);

			$this->id = $rs->getInt($startcol + 3);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 4; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ArCurrencyConversion object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArCurrencyConversionPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArCurrencyConversionPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(ArCurrencyConversionPeer::DATABASE_NAME);
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
					$pk = ArCurrencyConversionPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArCurrencyConversionPeer::doUpdate($this, $con);
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


			if (($retval = ArCurrencyConversionPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArCurrencyConversionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getSourceCurrency();
				break;
			case 1:
				return $this->getDestCurrency();
				break;
			case 2:
				return $this->getConversionFactor();
				break;
			case 3:
				return $this->getId();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArCurrencyConversionPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getSourceCurrency(),
			$keys[1] => $this->getDestCurrency(),
			$keys[2] => $this->getConversionFactor(),
			$keys[3] => $this->getId(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArCurrencyConversionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setSourceCurrency($value);
				break;
			case 1:
				$this->setDestCurrency($value);
				break;
			case 2:
				$this->setConversionFactor($value);
				break;
			case 3:
				$this->setId($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArCurrencyConversionPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setSourceCurrency($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setDestCurrency($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setConversionFactor($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setId($arr[$keys[3]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArCurrencyConversionPeer::DATABASE_NAME);

		if ($this->isColumnModified(ArCurrencyConversionPeer::SOURCE_CURRENCY)) $criteria->add(ArCurrencyConversionPeer::SOURCE_CURRENCY, $this->source_currency);
		if ($this->isColumnModified(ArCurrencyConversionPeer::DEST_CURRENCY)) $criteria->add(ArCurrencyConversionPeer::DEST_CURRENCY, $this->dest_currency);
		if ($this->isColumnModified(ArCurrencyConversionPeer::CONVERSION_FACTOR)) $criteria->add(ArCurrencyConversionPeer::CONVERSION_FACTOR, $this->conversion_factor);
		if ($this->isColumnModified(ArCurrencyConversionPeer::ID)) $criteria->add(ArCurrencyConversionPeer::ID, $this->id);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArCurrencyConversionPeer::DATABASE_NAME);

		$criteria->add(ArCurrencyConversionPeer::ID, $this->id);

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

		$copyObj->setSourceCurrency($this->source_currency);

		$copyObj->setDestCurrency($this->dest_currency);

		$copyObj->setConversionFactor($this->conversion_factor);


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
			self::$peer = new ArCurrencyConversionPeer();
		}
		return self::$peer;
	}

} 