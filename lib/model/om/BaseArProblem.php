<?php


abstract class BaseArProblem extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $created_at;


	
	protected $duplication_key;


	
	protected $description;


	
	protected $effect;


	
	protected $proposed_solution;


	
	protected $user_notes;


	
	protected $mantain;


	
	protected $signaled_to_admin = false;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getCreatedAt($format = 'Y-m-d H:i:s')
	{

		if ($this->created_at === null || $this->created_at === '') {
			return null;
		} elseif (!is_int($this->created_at)) {
						$ts = strtotime($this->created_at);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse value of [created_at] as date/time value: " . var_export($this->created_at, true));
			}
		} else {
			$ts = $this->created_at;
		}
		if ($format === null) {
			return $ts;
		} elseif (strpos($format, '%') !== false) {
			return strftime($format, $ts);
		} else {
			return date($format, $ts);
		}
	}

	
	public function getDuplicationKey()
	{

		return $this->duplication_key;
	}

	
	public function getDescription()
	{

		return $this->description;
	}

	
	public function getEffect()
	{

		return $this->effect;
	}

	
	public function getProposedSolution()
	{

		return $this->proposed_solution;
	}

	
	public function getUserNotes()
	{

		return $this->user_notes;
	}

	
	public function getMantain()
	{

		return $this->mantain;
	}

	
	public function getSignaledToAdmin()
	{

		return $this->signaled_to_admin;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ArProblemPeer::ID;
		}

	} 
	
	public function setCreatedAt($v)
	{

		if ($v !== null && !is_int($v)) {
			$ts = strtotime($v);
			if ($ts === -1 || $ts === false) { 				throw new PropelException("Unable to parse date/time value for [created_at] from input: " . var_export($v, true));
			}
		} else {
			$ts = $v;
		}
		if ($this->created_at !== $ts) {
			$this->created_at = $ts;
			$this->modifiedColumns[] = ArProblemPeer::CREATED_AT;
		}

	} 
	
	public function setDuplicationKey($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->duplication_key !== $v) {
			$this->duplication_key = $v;
			$this->modifiedColumns[] = ArProblemPeer::DUPLICATION_KEY;
		}

	} 
	
	public function setDescription($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->description !== $v) {
			$this->description = $v;
			$this->modifiedColumns[] = ArProblemPeer::DESCRIPTION;
		}

	} 
	
	public function setEffect($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->effect !== $v) {
			$this->effect = $v;
			$this->modifiedColumns[] = ArProblemPeer::EFFECT;
		}

	} 
	
	public function setProposedSolution($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->proposed_solution !== $v) {
			$this->proposed_solution = $v;
			$this->modifiedColumns[] = ArProblemPeer::PROPOSED_SOLUTION;
		}

	} 
	
	public function setUserNotes($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->user_notes !== $v) {
			$this->user_notes = $v;
			$this->modifiedColumns[] = ArProblemPeer::USER_NOTES;
		}

	} 
	
	public function setMantain($v)
	{

		if ($this->mantain !== $v) {
			$this->mantain = $v;
			$this->modifiedColumns[] = ArProblemPeer::MANTAIN;
		}

	} 
	
	public function setSignaledToAdmin($v)
	{

		if ($this->signaled_to_admin !== $v || $v === false) {
			$this->signaled_to_admin = $v;
			$this->modifiedColumns[] = ArProblemPeer::SIGNALED_TO_ADMIN;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->created_at = $rs->getTimestamp($startcol + 1, null);

			$this->duplication_key = $rs->getString($startcol + 2);

			$this->description = $rs->getString($startcol + 3);

			$this->effect = $rs->getString($startcol + 4);

			$this->proposed_solution = $rs->getString($startcol + 5);

			$this->user_notes = $rs->getString($startcol + 6);

			$this->mantain = $rs->getBoolean($startcol + 7);

			$this->signaled_to_admin = $rs->getBoolean($startcol + 8);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 9; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ArProblem object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArProblemPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArProblemPeer::doDelete($this, $con);
			$this->setDeleted(true);
			$con->commit();
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public function save($con = null)
	{
    if ($this->isNew() && !$this->isColumnModified(ArProblemPeer::CREATED_AT))
    {
      $this->setCreatedAt(time());
    }

		if ($this->isDeleted()) {
			throw new PropelException("You cannot save an object that has been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArProblemPeer::DATABASE_NAME);
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
					$pk = ArProblemPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArProblemPeer::doUpdate($this, $con);
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


			if (($retval = ArProblemPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}



			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArProblemPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getCreatedAt();
				break;
			case 2:
				return $this->getDuplicationKey();
				break;
			case 3:
				return $this->getDescription();
				break;
			case 4:
				return $this->getEffect();
				break;
			case 5:
				return $this->getProposedSolution();
				break;
			case 6:
				return $this->getUserNotes();
				break;
			case 7:
				return $this->getMantain();
				break;
			case 8:
				return $this->getSignaledToAdmin();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArProblemPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getCreatedAt(),
			$keys[2] => $this->getDuplicationKey(),
			$keys[3] => $this->getDescription(),
			$keys[4] => $this->getEffect(),
			$keys[5] => $this->getProposedSolution(),
			$keys[6] => $this->getUserNotes(),
			$keys[7] => $this->getMantain(),
			$keys[8] => $this->getSignaledToAdmin(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArProblemPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setCreatedAt($value);
				break;
			case 2:
				$this->setDuplicationKey($value);
				break;
			case 3:
				$this->setDescription($value);
				break;
			case 4:
				$this->setEffect($value);
				break;
			case 5:
				$this->setProposedSolution($value);
				break;
			case 6:
				$this->setUserNotes($value);
				break;
			case 7:
				$this->setMantain($value);
				break;
			case 8:
				$this->setSignaledToAdmin($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArProblemPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCreatedAt($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setDuplicationKey($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setDescription($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setEffect($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setProposedSolution($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setUserNotes($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setMantain($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setSignaledToAdmin($arr[$keys[8]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArProblemPeer::DATABASE_NAME);

		if ($this->isColumnModified(ArProblemPeer::ID)) $criteria->add(ArProblemPeer::ID, $this->id);
		if ($this->isColumnModified(ArProblemPeer::CREATED_AT)) $criteria->add(ArProblemPeer::CREATED_AT, $this->created_at);
		if ($this->isColumnModified(ArProblemPeer::DUPLICATION_KEY)) $criteria->add(ArProblemPeer::DUPLICATION_KEY, $this->duplication_key);
		if ($this->isColumnModified(ArProblemPeer::DESCRIPTION)) $criteria->add(ArProblemPeer::DESCRIPTION, $this->description);
		if ($this->isColumnModified(ArProblemPeer::EFFECT)) $criteria->add(ArProblemPeer::EFFECT, $this->effect);
		if ($this->isColumnModified(ArProblemPeer::PROPOSED_SOLUTION)) $criteria->add(ArProblemPeer::PROPOSED_SOLUTION, $this->proposed_solution);
		if ($this->isColumnModified(ArProblemPeer::USER_NOTES)) $criteria->add(ArProblemPeer::USER_NOTES, $this->user_notes);
		if ($this->isColumnModified(ArProblemPeer::MANTAIN)) $criteria->add(ArProblemPeer::MANTAIN, $this->mantain);
		if ($this->isColumnModified(ArProblemPeer::SIGNALED_TO_ADMIN)) $criteria->add(ArProblemPeer::SIGNALED_TO_ADMIN, $this->signaled_to_admin);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArProblemPeer::DATABASE_NAME);

		$criteria->add(ArProblemPeer::ID, $this->id);

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

		$copyObj->setCreatedAt($this->created_at);

		$copyObj->setDuplicationKey($this->duplication_key);

		$copyObj->setDescription($this->description);

		$copyObj->setEffect($this->effect);

		$copyObj->setProposedSolution($this->proposed_solution);

		$copyObj->setUserNotes($this->user_notes);

		$copyObj->setMantain($this->mantain);

		$copyObj->setSignaledToAdmin($this->signaled_to_admin);


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
			self::$peer = new ArProblemPeer();
		}
		return self::$peer;
	}

} 