<?php


abstract class BaseArDocument extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $ar_party_id;


	
	protected $document_name;


	
	protected $document_date;


	
	protected $document;


	
	protected $mime_type;

	
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

	
	public function getDocumentName()
	{

		return $this->document_name;
	}

	
	public function getDocumentDate($format = 'Y-m-d')
	{

		if ($this->document_date === null || $this->document_date === '') {
			return null;
		} elseif (!is_int($this->document_date)) {
						$ts = strtotime($this->document_date);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [document_date] as date/time value: " . var_export($this->document_date, true));
			}
		} else {
			$ts = $this->document_date;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getDocument()
	{

		return $this->document;
	}

	
	public function getMimeType()
	{

		return $this->mime_type;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ArDocumentPeer::ID;
		}

	} 
	
	public function setArPartyId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ar_party_id !== $v) {
			$this->ar_party_id = $v;
			$this->modifiedColumns[] = ArDocumentPeer::AR_PARTY_ID;
		}

		if ($this->aArParty !== null && $this->aArParty->getId() !== $v) {
			$this->aArParty = null;
		}

	} 
	
	public function setDocumentName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->document_name !== $v) {
			$this->document_name = $v;
			$this->modifiedColumns[] = ArDocumentPeer::DOCUMENT_NAME;
		}

	} 
	
	public function setDocumentDate($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [document_date] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->document_date !== $ts) {
			$this->document_date = $ts;
			$this->modifiedColumns[] = ArDocumentPeer::DOCUMENT_DATE;
		}

	} 
	
	public function setDocument($v)
	{

								if ($v instanceof Lob && $v === $this->document) {
			$changed = $v->isModified();
		} else {
			$changed = ($this->document !== $v);
		}
		if ($changed) {
			if ( !($v instanceof Lob) ) {
				$obj = new Blob();
				$obj->setContents($v);
			} else {
				$obj = $v;
			}
			$this->document = $obj;
			$this->modifiedColumns[] = ArDocumentPeer::DOCUMENT;
		}

	} 
	
	public function setMimeType($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->mime_type !== $v) {
			$this->mime_type = $v;
			$this->modifiedColumns[] = ArDocumentPeer::MIME_TYPE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->ar_party_id = $rs->getInt($startcol + 1);

			$this->document_name = $rs->getString($startcol + 2);

			$this->document_date = $rs->getDate($startcol + 3, null);

			$this->document = $rs->getBlob($startcol + 4);

			$this->mime_type = $rs->getString($startcol + 5);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 6; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ArDocument object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArDocumentPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArDocumentPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(ArDocumentPeer::DATABASE_NAME);
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
					$pk = ArDocumentPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArDocumentPeer::doUpdate($this, $con);
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


			if (($retval = ArDocumentPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArDocumentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				return $this->getDocumentName();
				break;
			case 3:
				return $this->getDocumentDate();
				break;
			case 4:
				return $this->getDocument();
				break;
			case 5:
				return $this->getMimeType();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArDocumentPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getArPartyId(),
			$keys[2] => $this->getDocumentName(),
			$keys[3] => $this->getDocumentDate(),
			$keys[4] => $this->getDocument(),
			$keys[5] => $this->getMimeType(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArDocumentPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
				$this->setDocumentName($value);
				break;
			case 3:
				$this->setDocumentDate($value);
				break;
			case 4:
				$this->setDocument($value);
				break;
			case 5:
				$this->setMimeType($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArDocumentPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setArPartyId($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDocumentName($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setDocumentDate($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setDocument($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setMimeType($arr[$keys[5]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArDocumentPeer::DATABASE_NAME);

		if ($this->isColumnModified(ArDocumentPeer::ID)) $criteria->add(ArDocumentPeer::ID, $this->id);
		if ($this->isColumnModified(ArDocumentPeer::AR_PARTY_ID)) $criteria->add(ArDocumentPeer::AR_PARTY_ID, $this->ar_party_id);
		if ($this->isColumnModified(ArDocumentPeer::DOCUMENT_NAME)) $criteria->add(ArDocumentPeer::DOCUMENT_NAME, $this->document_name);
		if ($this->isColumnModified(ArDocumentPeer::DOCUMENT_DATE)) $criteria->add(ArDocumentPeer::DOCUMENT_DATE, $this->document_date);
		if ($this->isColumnModified(ArDocumentPeer::DOCUMENT)) $criteria->add(ArDocumentPeer::DOCUMENT, $this->document);
		if ($this->isColumnModified(ArDocumentPeer::MIME_TYPE)) $criteria->add(ArDocumentPeer::MIME_TYPE, $this->mime_type);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArDocumentPeer::DATABASE_NAME);

		$criteria->add(ArDocumentPeer::ID, $this->id);

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

		$copyObj->setDocumentName($this->document_name);

		$copyObj->setDocumentDate($this->document_date);

		$copyObj->setDocument($this->document);

		$copyObj->setMimeType($this->mime_type);


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
			self::$peer = new ArDocumentPeer();
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