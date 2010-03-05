<?php


abstract class BaseArParty extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $customer_or_vendor;


	
	protected $name;


	
	protected $external_crm_code;


	
	protected $vat;


	
	protected $legal_address;


	
	protected $legal_city;


	
	protected $legal_zipcode;


	
	protected $legal_state_province;


	
	protected $legal_country;


	
	protected $email;


	
	protected $phone;


	
	protected $phone2;


	
	protected $fax;


	
	protected $ar_rate_category_id;


	
	protected $max_limit_30 = 0;

	
	protected $aArRateCategory;

	
	protected $collArAsteriskAccounts;

	
	protected $lastArAsteriskAccountCriteria = null;

	
	protected $collArWebAccounts;

	
	protected $lastArWebAccountCriteria = null;

	
	protected $collArInvoices;

	
	protected $lastArInvoiceCriteria = null;

	
	protected $collArRates;

	
	protected $lastArRateCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getCustomerOrVendor()
	{

		return $this->customer_or_vendor;
	}

	
	public function getName()
	{

		return $this->name;
	}

	
	public function getExternalCrmCode()
	{

		return $this->external_crm_code;
	}

	
	public function getVat()
	{

		return $this->vat;
	}

	
	public function getLegalAddress()
	{

		return $this->legal_address;
	}

	
	public function getLegalCity()
	{

		return $this->legal_city;
	}

	
	public function getLegalZipcode()
	{

		return $this->legal_zipcode;
	}

	
	public function getLegalStateProvince()
	{

		return $this->legal_state_province;
	}

	
	public function getLegalCountry()
	{

		return $this->legal_country;
	}

	
	public function getEmail()
	{

		return $this->email;
	}

	
	public function getPhone()
	{

		return $this->phone;
	}

	
	public function getPhone2()
	{

		return $this->phone2;
	}

	
	public function getFax()
	{

		return $this->fax;
	}

	
	public function getArRateCategoryId()
	{

		return $this->ar_rate_category_id;
	}

	
	public function getMaxLimit30()
	{

		return $this->max_limit_30;
	}

	
	public function setId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ArPartyPeer::ID;
		}

	} 
	
	public function setCustomerOrVendor($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->customer_or_vendor !== $v) {
			$this->customer_or_vendor = $v;
			$this->modifiedColumns[] = ArPartyPeer::CUSTOMER_OR_VENDOR;
		}

	} 
	
	public function setName($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = ArPartyPeer::NAME;
		}

	} 
	
	public function setExternalCrmCode($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->external_crm_code !== $v) {
			$this->external_crm_code = $v;
			$this->modifiedColumns[] = ArPartyPeer::EXTERNAL_CRM_CODE;
		}

	} 
	
	public function setVat($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->vat !== $v) {
			$this->vat = $v;
			$this->modifiedColumns[] = ArPartyPeer::VAT;
		}

	} 
	
	public function setLegalAddress($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->legal_address !== $v) {
			$this->legal_address = $v;
			$this->modifiedColumns[] = ArPartyPeer::LEGAL_ADDRESS;
		}

	} 
	
	public function setLegalCity($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->legal_city !== $v) {
			$this->legal_city = $v;
			$this->modifiedColumns[] = ArPartyPeer::LEGAL_CITY;
		}

	} 
	
	public function setLegalZipcode($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->legal_zipcode !== $v) {
			$this->legal_zipcode = $v;
			$this->modifiedColumns[] = ArPartyPeer::LEGAL_ZIPCODE;
		}

	} 
	
	public function setLegalStateProvince($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->legal_state_province !== $v) {
			$this->legal_state_province = $v;
			$this->modifiedColumns[] = ArPartyPeer::LEGAL_STATE_PROVINCE;
		}

	} 
	
	public function setLegalCountry($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->legal_country !== $v) {
			$this->legal_country = $v;
			$this->modifiedColumns[] = ArPartyPeer::LEGAL_COUNTRY;
		}

	} 
	
	public function setEmail($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->email !== $v) {
			$this->email = $v;
			$this->modifiedColumns[] = ArPartyPeer::EMAIL;
		}

	} 
	
	public function setPhone($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->phone !== $v) {
			$this->phone = $v;
			$this->modifiedColumns[] = ArPartyPeer::PHONE;
		}

	} 
	
	public function setPhone2($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->phone2 !== $v) {
			$this->phone2 = $v;
			$this->modifiedColumns[] = ArPartyPeer::PHONE2;
		}

	} 
	
	public function setFax($v)
	{

		
		
		if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->fax !== $v) {
			$this->fax = $v;
			$this->modifiedColumns[] = ArPartyPeer::FAX;
		}

	} 
	
	public function setArRateCategoryId($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->ar_rate_category_id !== $v) {
			$this->ar_rate_category_id = $v;
			$this->modifiedColumns[] = ArPartyPeer::AR_RATE_CATEGORY_ID;
		}

		if ($this->aArRateCategory !== null && $this->aArRateCategory->getId() !== $v) {
			$this->aArRateCategory = null;
		}

	} 
	
	public function setMaxLimit30($v)
	{

		
		
		if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->max_limit_30 !== $v || $v === 0) {
			$this->max_limit_30 = $v;
			$this->modifiedColumns[] = ArPartyPeer::MAX_LIMIT_30;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->customer_or_vendor = $rs->getString($startcol + 1);

			$this->name = $rs->getString($startcol + 2);

			$this->external_crm_code = $rs->getString($startcol + 3);

			$this->vat = $rs->getString($startcol + 4);

			$this->legal_address = $rs->getString($startcol + 5);

			$this->legal_city = $rs->getString($startcol + 6);

			$this->legal_zipcode = $rs->getString($startcol + 7);

			$this->legal_state_province = $rs->getString($startcol + 8);

			$this->legal_country = $rs->getString($startcol + 9);

			$this->email = $rs->getString($startcol + 10);

			$this->phone = $rs->getString($startcol + 11);

			$this->phone2 = $rs->getString($startcol + 12);

			$this->fax = $rs->getString($startcol + 13);

			$this->ar_rate_category_id = $rs->getInt($startcol + 14);

			$this->max_limit_30 = $rs->getInt($startcol + 15);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 16; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ArParty object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArPartyPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArPartyPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(ArPartyPeer::DATABASE_NAME);
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


						if ($this->isModified()) {
				if ($this->isNew()) {
					$pk = ArPartyPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArPartyPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collArAsteriskAccounts !== null) {
				foreach($this->collArAsteriskAccounts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collArWebAccounts !== null) {
				foreach($this->collArWebAccounts as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collArInvoices !== null) {
				foreach($this->collArInvoices as $referrerFK) {
					if (!$referrerFK->isDeleted()) {
						$affectedRows += $referrerFK->save($con);
					}
				}
			}

			if ($this->collArRates !== null) {
				foreach($this->collArRates as $referrerFK) {
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


			if (($retval = ArPartyPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collArAsteriskAccounts !== null) {
					foreach($this->collArAsteriskAccounts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collArWebAccounts !== null) {
					foreach($this->collArWebAccounts as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collArInvoices !== null) {
					foreach($this->collArInvoices as $referrerFK) {
						if (!$referrerFK->validate($columns)) {
							$failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
						}
					}
				}

				if ($this->collArRates !== null) {
					foreach($this->collArRates as $referrerFK) {
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
		$pos = ArPartyPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getCustomerOrVendor();
				break;
			case 2:
				return $this->getName();
				break;
			case 3:
				return $this->getExternalCrmCode();
				break;
			case 4:
				return $this->getVat();
				break;
			case 5:
				return $this->getLegalAddress();
				break;
			case 6:
				return $this->getLegalCity();
				break;
			case 7:
				return $this->getLegalZipcode();
				break;
			case 8:
				return $this->getLegalStateProvince();
				break;
			case 9:
				return $this->getLegalCountry();
				break;
			case 10:
				return $this->getEmail();
				break;
			case 11:
				return $this->getPhone();
				break;
			case 12:
				return $this->getPhone2();
				break;
			case 13:
				return $this->getFax();
				break;
			case 14:
				return $this->getArRateCategoryId();
				break;
			case 15:
				return $this->getMaxLimit30();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArPartyPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getCustomerOrVendor(),
			$keys[2] => $this->getName(),
			$keys[3] => $this->getExternalCrmCode(),
			$keys[4] => $this->getVat(),
			$keys[5] => $this->getLegalAddress(),
			$keys[6] => $this->getLegalCity(),
			$keys[7] => $this->getLegalZipcode(),
			$keys[8] => $this->getLegalStateProvince(),
			$keys[9] => $this->getLegalCountry(),
			$keys[10] => $this->getEmail(),
			$keys[11] => $this->getPhone(),
			$keys[12] => $this->getPhone2(),
			$keys[13] => $this->getFax(),
			$keys[14] => $this->getArRateCategoryId(),
			$keys[15] => $this->getMaxLimit30(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArPartyPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setCustomerOrVendor($value);
				break;
			case 2:
				$this->setName($value);
				break;
			case 3:
				$this->setExternalCrmCode($value);
				break;
			case 4:
				$this->setVat($value);
				break;
			case 5:
				$this->setLegalAddress($value);
				break;
			case 6:
				$this->setLegalCity($value);
				break;
			case 7:
				$this->setLegalZipcode($value);
				break;
			case 8:
				$this->setLegalStateProvince($value);
				break;
			case 9:
				$this->setLegalCountry($value);
				break;
			case 10:
				$this->setEmail($value);
				break;
			case 11:
				$this->setPhone($value);
				break;
			case 12:
				$this->setPhone2($value);
				break;
			case 13:
				$this->setFax($value);
				break;
			case 14:
				$this->setArRateCategoryId($value);
				break;
			case 15:
				$this->setMaxLimit30($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArPartyPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setCustomerOrVendor($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setExternalCrmCode($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setVat($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setLegalAddress($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setLegalCity($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setLegalZipcode($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setLegalStateProvince($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setLegalCountry($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setEmail($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setPhone($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setPhone2($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setFax($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setArRateCategoryId($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setMaxLimit30($arr[$keys[15]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArPartyPeer::DATABASE_NAME);

		if ($this->isColumnModified(ArPartyPeer::ID)) $criteria->add(ArPartyPeer::ID, $this->id);
		if ($this->isColumnModified(ArPartyPeer::CUSTOMER_OR_VENDOR)) $criteria->add(ArPartyPeer::CUSTOMER_OR_VENDOR, $this->customer_or_vendor);
		if ($this->isColumnModified(ArPartyPeer::NAME)) $criteria->add(ArPartyPeer::NAME, $this->name);
		if ($this->isColumnModified(ArPartyPeer::EXTERNAL_CRM_CODE)) $criteria->add(ArPartyPeer::EXTERNAL_CRM_CODE, $this->external_crm_code);
		if ($this->isColumnModified(ArPartyPeer::VAT)) $criteria->add(ArPartyPeer::VAT, $this->vat);
		if ($this->isColumnModified(ArPartyPeer::LEGAL_ADDRESS)) $criteria->add(ArPartyPeer::LEGAL_ADDRESS, $this->legal_address);
		if ($this->isColumnModified(ArPartyPeer::LEGAL_CITY)) $criteria->add(ArPartyPeer::LEGAL_CITY, $this->legal_city);
		if ($this->isColumnModified(ArPartyPeer::LEGAL_ZIPCODE)) $criteria->add(ArPartyPeer::LEGAL_ZIPCODE, $this->legal_zipcode);
		if ($this->isColumnModified(ArPartyPeer::LEGAL_STATE_PROVINCE)) $criteria->add(ArPartyPeer::LEGAL_STATE_PROVINCE, $this->legal_state_province);
		if ($this->isColumnModified(ArPartyPeer::LEGAL_COUNTRY)) $criteria->add(ArPartyPeer::LEGAL_COUNTRY, $this->legal_country);
		if ($this->isColumnModified(ArPartyPeer::EMAIL)) $criteria->add(ArPartyPeer::EMAIL, $this->email);
		if ($this->isColumnModified(ArPartyPeer::PHONE)) $criteria->add(ArPartyPeer::PHONE, $this->phone);
		if ($this->isColumnModified(ArPartyPeer::PHONE2)) $criteria->add(ArPartyPeer::PHONE2, $this->phone2);
		if ($this->isColumnModified(ArPartyPeer::FAX)) $criteria->add(ArPartyPeer::FAX, $this->fax);
		if ($this->isColumnModified(ArPartyPeer::AR_RATE_CATEGORY_ID)) $criteria->add(ArPartyPeer::AR_RATE_CATEGORY_ID, $this->ar_rate_category_id);
		if ($this->isColumnModified(ArPartyPeer::MAX_LIMIT_30)) $criteria->add(ArPartyPeer::MAX_LIMIT_30, $this->max_limit_30);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArPartyPeer::DATABASE_NAME);

		$criteria->add(ArPartyPeer::ID, $this->id);

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

		$copyObj->setCustomerOrVendor($this->customer_or_vendor);

		$copyObj->setName($this->name);

		$copyObj->setExternalCrmCode($this->external_crm_code);

		$copyObj->setVat($this->vat);

		$copyObj->setLegalAddress($this->legal_address);

		$copyObj->setLegalCity($this->legal_city);

		$copyObj->setLegalZipcode($this->legal_zipcode);

		$copyObj->setLegalStateProvince($this->legal_state_province);

		$copyObj->setLegalCountry($this->legal_country);

		$copyObj->setEmail($this->email);

		$copyObj->setPhone($this->phone);

		$copyObj->setPhone2($this->phone2);

		$copyObj->setFax($this->fax);

		$copyObj->setArRateCategoryId($this->ar_rate_category_id);

		$copyObj->setMaxLimit30($this->max_limit_30);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getArAsteriskAccounts() as $relObj) {
				$copyObj->addArAsteriskAccount($relObj->copy($deepCopy));
			}

			foreach($this->getArWebAccounts() as $relObj) {
				$copyObj->addArWebAccount($relObj->copy($deepCopy));
			}

			foreach($this->getArInvoices() as $relObj) {
				$copyObj->addArInvoice($relObj->copy($deepCopy));
			}

			foreach($this->getArRates() as $relObj) {
				$copyObj->addArRate($relObj->copy($deepCopy));
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
			self::$peer = new ArPartyPeer();
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

	
	public function initArAsteriskAccounts()
	{
		if ($this->collArAsteriskAccounts === null) {
			$this->collArAsteriskAccounts = array();
		}
	}

	
	public function getArAsteriskAccounts($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArAsteriskAccountPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArAsteriskAccounts === null) {
			if ($this->isNew()) {
			   $this->collArAsteriskAccounts = array();
			} else {

				$criteria->add(ArAsteriskAccountPeer::AR_PARTY_ID, $this->getId());

				ArAsteriskAccountPeer::addSelectColumns($criteria);
				$this->collArAsteriskAccounts = ArAsteriskAccountPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArAsteriskAccountPeer::AR_PARTY_ID, $this->getId());

				ArAsteriskAccountPeer::addSelectColumns($criteria);
				if (!isset($this->lastArAsteriskAccountCriteria) || !$this->lastArAsteriskAccountCriteria->equals($criteria)) {
					$this->collArAsteriskAccounts = ArAsteriskAccountPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastArAsteriskAccountCriteria = $criteria;
		return $this->collArAsteriskAccounts;
	}

	
	public function countArAsteriskAccounts($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseArAsteriskAccountPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ArAsteriskAccountPeer::AR_PARTY_ID, $this->getId());

		return ArAsteriskAccountPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArAsteriskAccount(ArAsteriskAccount $l)
	{
		$this->collArAsteriskAccounts[] = $l;
		$l->setArParty($this);
	}

	
	public function initArWebAccounts()
	{
		if ($this->collArWebAccounts === null) {
			$this->collArWebAccounts = array();
		}
	}

	
	public function getArWebAccounts($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArWebAccountPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArWebAccounts === null) {
			if ($this->isNew()) {
			   $this->collArWebAccounts = array();
			} else {

				$criteria->add(ArWebAccountPeer::AR_PARTY_ID, $this->getId());

				ArWebAccountPeer::addSelectColumns($criteria);
				$this->collArWebAccounts = ArWebAccountPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArWebAccountPeer::AR_PARTY_ID, $this->getId());

				ArWebAccountPeer::addSelectColumns($criteria);
				if (!isset($this->lastArWebAccountCriteria) || !$this->lastArWebAccountCriteria->equals($criteria)) {
					$this->collArWebAccounts = ArWebAccountPeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastArWebAccountCriteria = $criteria;
		return $this->collArWebAccounts;
	}

	
	public function countArWebAccounts($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseArWebAccountPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ArWebAccountPeer::AR_PARTY_ID, $this->getId());

		return ArWebAccountPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArWebAccount(ArWebAccount $l)
	{
		$this->collArWebAccounts[] = $l;
		$l->setArParty($this);
	}


	
	public function getArWebAccountsJoinArAsteriskAccount($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArWebAccountPeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArWebAccounts === null) {
			if ($this->isNew()) {
				$this->collArWebAccounts = array();
			} else {

				$criteria->add(ArWebAccountPeer::AR_PARTY_ID, $this->getId());

				$this->collArWebAccounts = ArWebAccountPeer::doSelectJoinArAsteriskAccount($criteria, $con);
			}
		} else {
									
			$criteria->add(ArWebAccountPeer::AR_PARTY_ID, $this->getId());

			if (!isset($this->lastArWebAccountCriteria) || !$this->lastArWebAccountCriteria->equals($criteria)) {
				$this->collArWebAccounts = ArWebAccountPeer::doSelectJoinArAsteriskAccount($criteria, $con);
			}
		}
		$this->lastArWebAccountCriteria = $criteria;

		return $this->collArWebAccounts;
	}

	
	public function initArInvoices()
	{
		if ($this->collArInvoices === null) {
			$this->collArInvoices = array();
		}
	}

	
	public function getArInvoices($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArInvoicePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArInvoices === null) {
			if ($this->isNew()) {
			   $this->collArInvoices = array();
			} else {

				$criteria->add(ArInvoicePeer::AR_PARTY_ID, $this->getId());

				ArInvoicePeer::addSelectColumns($criteria);
				$this->collArInvoices = ArInvoicePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArInvoicePeer::AR_PARTY_ID, $this->getId());

				ArInvoicePeer::addSelectColumns($criteria);
				if (!isset($this->lastArInvoiceCriteria) || !$this->lastArInvoiceCriteria->equals($criteria)) {
					$this->collArInvoices = ArInvoicePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastArInvoiceCriteria = $criteria;
		return $this->collArInvoices;
	}

	
	public function countArInvoices($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseArInvoicePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ArInvoicePeer::AR_PARTY_ID, $this->getId());

		return ArInvoicePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArInvoice(ArInvoice $l)
	{
		$this->collArInvoices[] = $l;
		$l->setArParty($this);
	}

	
	public function initArRates()
	{
		if ($this->collArRates === null) {
			$this->collArRates = array();
		}
	}

	
	public function getArRates($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArRatePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArRates === null) {
			if ($this->isNew()) {
			   $this->collArRates = array();
			} else {

				$criteria->add(ArRatePeer::AR_PARTY_ID, $this->getId());

				ArRatePeer::addSelectColumns($criteria);
				$this->collArRates = ArRatePeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArRatePeer::AR_PARTY_ID, $this->getId());

				ArRatePeer::addSelectColumns($criteria);
				if (!isset($this->lastArRateCriteria) || !$this->lastArRateCriteria->equals($criteria)) {
					$this->collArRates = ArRatePeer::doSelect($criteria, $con);
				}
			}
		}
		$this->lastArRateCriteria = $criteria;
		return $this->collArRates;
	}

	
	public function countArRates($criteria = null, $distinct = false, $con = null)
	{
				include_once 'lib/model/om/BaseArRatePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		$criteria->add(ArRatePeer::AR_PARTY_ID, $this->getId());

		return ArRatePeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArRate(ArRate $l)
	{
		$this->collArRates[] = $l;
		$l->setArParty($this);
	}


	
	public function getArRatesJoinArRateCategory($criteria = null, $con = null)
	{
				include_once 'lib/model/om/BaseArRatePeer.php';
		if ($criteria === null) {
			$criteria = new Criteria();
		}
		elseif ($criteria instanceof Criteria)
		{
			$criteria = clone $criteria;
		}

		if ($this->collArRates === null) {
			if ($this->isNew()) {
				$this->collArRates = array();
			} else {

				$criteria->add(ArRatePeer::AR_PARTY_ID, $this->getId());

				$this->collArRates = ArRatePeer::doSelectJoinArRateCategory($criteria, $con);
			}
		} else {
									
			$criteria->add(ArRatePeer::AR_PARTY_ID, $this->getId());

			if (!isset($this->lastArRateCriteria) || !$this->lastArRateCriteria->equals($criteria)) {
				$this->collArRates = ArRatePeer::doSelectJoinArRateCategory($criteria, $con);
			}
		}
		$this->lastArRateCriteria = $criteria;

		return $this->collArRates;
	}

} 