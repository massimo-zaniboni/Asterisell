<?php


abstract class BaseArHeader extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $image_file_name;


	
	protected $title;


	
	protected $message;

	
	protected $collArPartys;

	
	protected $lastArPartyCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getImageFileName()
	{

		return $this->image_file_name;
	}

	
	public function getTitle()
	{

		return $this->title;
	}

	
	public function getMessage()
	{

		return $this->message;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ArHeaderPeer::ID;
		}

	} 
	
	public function setImageFileName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->image_file_name !== $v) {
			$this->image_file_name = $v;
			$this->modifiedColumns[] = ArHeaderPeer::IMAGE_FILE_NAME;
		}

	} 
	
	public function setTitle($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->title !== $v) {
			$this->title = $v;
			$this->modifiedColumns[] = ArHeaderPeer::TITLE;
		}

	} 
	
	public function setMessage($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->message !== $v) {
			$this->message = $v;
			$this->modifiedColumns[] = ArHeaderPeer::MESSAGE;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->image_file_name = $rs->getString($startcol + 1);

			$this->title = $rs->getString($startcol + 2);

			$this->message = $rs->getString($startcol + 3);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 4; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ArHeader object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArHeaderPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArHeaderPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(ArHeaderPeer::DATABASE_NAME);
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
					$pk = ArHeaderPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArHeaderPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collArPartys !== null) {
				foreach($this->collArPartys as $referrerFK) {
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


			if (($retval = ArHeaderPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collArPartys !== null) {
					foreach($this->collArPartys as $referrerFK) {
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
		$pos = ArHeaderPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getImageFileName();
				break;
			case 2:
				return $this->getTitle();
				break;
			case 3:
				return $this->getMessage();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArHeaderPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getImageFileName(),
			$keys[2] => $this->getTitle(),
			$keys[3] => $this->getMessage(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArHeaderPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setImageFileName($value);
				break;
			case 2:
				$this->setTitle($value);
				break;
			case 3:
				$this->setMessage($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArHeaderPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setImageFileName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setTitle($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setMessage($arr[$keys[3]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArHeaderPeer::DATABASE_NAME);

		if ($this->isColumnModified(ArHeaderPeer::ID)) $criteria->add(ArHeaderPeer::ID, $this->id);
		if ($this->isColumnModified(ArHeaderPeer::IMAGE_FILE_NAME)) $criteria->add(ArHeaderPeer::IMAGE_FILE_NAME, $this->image_file_name);
		if ($this->isColumnModified(ArHeaderPeer::TITLE)) $criteria->add(ArHeaderPeer::TITLE, $this->title);
		if ($this->isColumnModified(ArHeaderPeer::MESSAGE)) $criteria->add(ArHeaderPeer::MESSAGE, $this->message);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArHeaderPeer::DATABASE_NAME);

		$criteria->add(ArHeaderPeer::ID, $this->id);

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

		$copyObj->setImageFileName($this->image_file_name);

		$copyObj->setTitle($this->title);

		$copyObj->setMessage($this->message);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getArPartys() as $relObj) {
				$copyObj->addArParty($relObj->copy($deepCopy));
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
			self::$peer = new ArHeaderPeer();
		}
		return self::$peer;
	}

	
	public function initArPartys()
	{
		if ($this->collArPartys === null) {
			$this->collArPartys = array();
		}
	}

	
	public function getArPartys($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArPartyPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArPartys === null) {
			if ($this->isNew()) {
			   $this->collArPartys = array();
			} else {

				$criteria->add(ArPartyPeer::AR_HEADER_ID, $this->getId());

				ArPartyPeer::addSelectColumns($criteria);
				$this->collArPartys = ArPartyPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArPartyPeer::AR_HEADER_ID, $this->getId());

				ArPartyPeer::addSelectColumns($criteria);
				if (!isset($this->lastArPartyCriteria) || !$this->lastArPartyCriteria->equals($criteria)) {
					$this->collArPartys = ArPartyPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastArPartyCriteria = $criteria;
		return $this->collArPartys;
	}

	
	public function countArPartys($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseArPartyPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ArPartyPeer::AR_HEADER_ID, $this->getId());

		return ArPartyPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArParty(ArParty $l)
	{
		$this->collArPartys[] = $l;
		$l->setArHeader($this);
	}


	
	public function getArPartysJoinArRateCategory($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArPartyPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArPartys === null) {
			if ($this->isNew()) {
				$this->collArPartys = array();
			} else {

				$criteria->add(ArPartyPeer::AR_HEADER_ID, $this->getId());

				$this->collArPartys = ArPartyPeer::doSelectJoinArRateCategory($criteria, $con);
			}
		} else {
									
			$criteria->add(ArPartyPeer::AR_HEADER_ID, $this->getId());

			if (!isset($this->lastArPartyCriteria) || !$this->lastArPartyCriteria->equals($criteria)) {
				$this->collArPartys = ArPartyPeer::doSelectJoinArRateCategory($criteria, $con);
			}
		}
		$this->lastArPartyCriteria = $criteria;

		return $this->collArPartys;
	}

} 