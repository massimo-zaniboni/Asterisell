<?php


abstract class BaseArParams extends BaseObject  implements Persistent {


	
	protected static $peer;


	
	protected $id;


	
	protected $name;


	
	protected $is_default;


	
	protected $service_name;


	
	protected $service_provider_website;


	
	protected $service_provider_email;


	
	protected $vat_tax_perc = 0;


	
	protected $logo_image;


	
	protected $slogan;


	
	protected $logo_image_in_invoices;


	
	protected $logo_image_dpi_in_invoices = 72;


	
	protected $footer;


	
	protected $user_message;


	
	protected $last_viewed_feeds_md5;


	
	protected $current_feeds_md5;


	
	protected $legal_name;


	
	protected $external_crm_code;


	
	protected $vat;


	
	protected $legal_address;


	
	protected $legal_website;


	
	protected $legal_city;


	
	protected $legal_zipcode;


	
	protected $legal_state_province;


	
	protected $legal_country;


	
	protected $legal_email;


	
	protected $legal_phone;


	
	protected $phone2;


	
	protected $legal_fax;


	
	protected $sender_name_on_invoicing_emails;


	
	protected $invoicing_email_address;


	
	protected $accountant_email_address;


	
	protected $smtp_host;


	
	protected $smtp_port;


	
	protected $smtp_username;


	
	protected $smtp_password;


	
	protected $smtp_encryption;


	
	protected $smtp_reconnect_after_nr_of_messages;


	
	protected $smtp_seconds_of_pause_after_reconnection;


	
	protected $current_invoice_nr = 1;

	
	protected $collArPartys;

	
	protected $lastArPartyCriteria = null;

	
	protected $collArWebAccounts;

	
	protected $lastArWebAccountCriteria = null;

	
	protected $alreadyInSave = false;

	
	protected $alreadyInValidation = false;

	
	public function getId()
	{

		return $this->id;
	}

	
	public function getName()
	{

		return $this->name;
	}

	
	public function getIsDefault()
	{

		return $this->is_default;
	}

	
	public function getServiceName()
	{

		return $this->service_name;
	}

	
	public function getServiceProviderWebsite()
	{

		return $this->service_provider_website;
	}

	
	public function getServiceProviderEmail()
	{

		return $this->service_provider_email;
	}

	
	public function getVatTaxPerc()
	{

		return $this->vat_tax_perc;
	}

	
	public function getLogoImage()
	{

		return $this->logo_image;
	}

	
	public function getSlogan()
	{

		return $this->slogan;
	}

	
	public function getLogoImageInInvoices()
	{

		return $this->logo_image_in_invoices;
	}

	
	public function getLogoImageDpiInInvoices()
	{

		return $this->logo_image_dpi_in_invoices;
	}

	
	public function getFooter()
	{

		return $this->footer;
	}

	
	public function getUserMessage()
	{

		return $this->user_message;
	}

	
	public function getLastViewedFeedsMd5()
	{

		return $this->last_viewed_feeds_md5;
	}

	
	public function getCurrentFeedsMd5()
	{

		return $this->current_feeds_md5;
	}

	
	public function getLegalName()
	{

		return $this->legal_name;
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

	
	public function getLegalWebsite()
	{

		return $this->legal_website;
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

	
	public function getLegalEmail()
	{

		return $this->legal_email;
	}

	
	public function getLegalPhone()
	{

		return $this->legal_phone;
	}

	
	public function getPhone2()
	{

		return $this->phone2;
	}

	
	public function getLegalFax()
	{

		return $this->legal_fax;
	}

	
	public function getSenderNameOnInvoicingEmails()
	{

		return $this->sender_name_on_invoicing_emails;
	}

	
	public function getInvoicingEmailAddress()
	{

		return $this->invoicing_email_address;
	}

	
	public function getAccountantEmailAddress()
	{

		return $this->accountant_email_address;
	}

	
	public function getSmtpHost()
	{

		return $this->smtp_host;
	}

	
	public function getSmtpPort()
	{

		return $this->smtp_port;
	}

	
	public function getSmtpUsername()
	{

		return $this->smtp_username;
	}

	
	public function getSmtpPassword()
	{

		return $this->smtp_password;
	}

	
	public function getSmtpEncryption()
	{

		return $this->smtp_encryption;
	}

	
	public function getSmtpReconnectAfterNrOfMessages()
	{

		return $this->smtp_reconnect_after_nr_of_messages;
	}

	
	public function getSmtpSecondsOfPauseAfterReconnection()
	{

		return $this->smtp_seconds_of_pause_after_reconnection;
	}

	
	public function getCurrentInvoiceNr()
	{

		return $this->current_invoice_nr;
	}

	
	public function setId($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->id !== $v) {
			$this->id = $v;
			$this->modifiedColumns[] = ArParamsPeer::ID;
		}

	} 
	
	public function setName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->name !== $v) {
			$this->name = $v;
			$this->modifiedColumns[] = ArParamsPeer::NAME;
		}

	} 
	
	public function setIsDefault($v)
	{

		if ($this->is_default !== $v) {
			$this->is_default = $v;
			$this->modifiedColumns[] = ArParamsPeer::IS_DEFAULT;
		}

	} 
	
	public function setServiceName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->service_name !== $v) {
			$this->service_name = $v;
			$this->modifiedColumns[] = ArParamsPeer::SERVICE_NAME;
		}

	} 
	
	public function setServiceProviderWebsite($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->service_provider_website !== $v) {
			$this->service_provider_website = $v;
			$this->modifiedColumns[] = ArParamsPeer::SERVICE_PROVIDER_WEBSITE;
		}

	} 
	
	public function setServiceProviderEmail($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->service_provider_email !== $v) {
			$this->service_provider_email = $v;
			$this->modifiedColumns[] = ArParamsPeer::SERVICE_PROVIDER_EMAIL;
		}

	} 
	
	public function setVatTaxPerc($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->vat_tax_perc !== $v || $v === 0) {
			$this->vat_tax_perc = $v;
			$this->modifiedColumns[] = ArParamsPeer::VAT_TAX_PERC;
		}

	} 
	
	public function setLogoImage($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->logo_image !== $v) {
			$this->logo_image = $v;
			$this->modifiedColumns[] = ArParamsPeer::LOGO_IMAGE;
		}

	} 
	
	public function setSlogan($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->slogan !== $v) {
			$this->slogan = $v;
			$this->modifiedColumns[] = ArParamsPeer::SLOGAN;
		}

	} 
	
	public function setLogoImageInInvoices($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->logo_image_in_invoices !== $v) {
			$this->logo_image_in_invoices = $v;
			$this->modifiedColumns[] = ArParamsPeer::LOGO_IMAGE_IN_INVOICES;
		}

	} 
	
	public function setLogoImageDpiInInvoices($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->logo_image_dpi_in_invoices !== $v || $v === 72) {
			$this->logo_image_dpi_in_invoices = $v;
			$this->modifiedColumns[] = ArParamsPeer::LOGO_IMAGE_DPI_IN_INVOICES;
		}

	} 
	
	public function setFooter($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->footer !== $v) {
			$this->footer = $v;
			$this->modifiedColumns[] = ArParamsPeer::FOOTER;
		}

	} 
	
	public function setUserMessage($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->user_message !== $v) {
			$this->user_message = $v;
			$this->modifiedColumns[] = ArParamsPeer::USER_MESSAGE;
		}

	} 
	
	public function setLastViewedFeedsMd5($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->last_viewed_feeds_md5 !== $v) {
			$this->last_viewed_feeds_md5 = $v;
			$this->modifiedColumns[] = ArParamsPeer::LAST_VIEWED_FEEDS_MD5;
		}

	} 
	
	public function setCurrentFeedsMd5($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->current_feeds_md5 !== $v) {
			$this->current_feeds_md5 = $v;
			$this->modifiedColumns[] = ArParamsPeer::CURRENT_FEEDS_MD5;
		}

	} 
	
	public function setLegalName($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->legal_name !== $v) {
			$this->legal_name = $v;
			$this->modifiedColumns[] = ArParamsPeer::LEGAL_NAME;
		}

	} 
	
	public function setExternalCrmCode($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->external_crm_code !== $v) {
			$this->external_crm_code = $v;
			$this->modifiedColumns[] = ArParamsPeer::EXTERNAL_CRM_CODE;
		}

	} 
	
	public function setVat($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->vat !== $v) {
			$this->vat = $v;
			$this->modifiedColumns[] = ArParamsPeer::VAT;
		}

	} 
	
	public function setLegalAddress($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->legal_address !== $v) {
			$this->legal_address = $v;
			$this->modifiedColumns[] = ArParamsPeer::LEGAL_ADDRESS;
		}

	} 
	
	public function setLegalWebsite($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->legal_website !== $v) {
			$this->legal_website = $v;
			$this->modifiedColumns[] = ArParamsPeer::LEGAL_WEBSITE;
		}

	} 
	
	public function setLegalCity($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->legal_city !== $v) {
			$this->legal_city = $v;
			$this->modifiedColumns[] = ArParamsPeer::LEGAL_CITY;
		}

	} 
	
	public function setLegalZipcode($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->legal_zipcode !== $v) {
			$this->legal_zipcode = $v;
			$this->modifiedColumns[] = ArParamsPeer::LEGAL_ZIPCODE;
		}

	} 
	
	public function setLegalStateProvince($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->legal_state_province !== $v) {
			$this->legal_state_province = $v;
			$this->modifiedColumns[] = ArParamsPeer::LEGAL_STATE_PROVINCE;
		}

	} 
	
	public function setLegalCountry($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->legal_country !== $v) {
			$this->legal_country = $v;
			$this->modifiedColumns[] = ArParamsPeer::LEGAL_COUNTRY;
		}

	} 
	
	public function setLegalEmail($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->legal_email !== $v) {
			$this->legal_email = $v;
			$this->modifiedColumns[] = ArParamsPeer::LEGAL_EMAIL;
		}

	} 
	
	public function setLegalPhone($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->legal_phone !== $v) {
			$this->legal_phone = $v;
			$this->modifiedColumns[] = ArParamsPeer::LEGAL_PHONE;
		}

	} 
	
	public function setPhone2($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->phone2 !== $v) {
			$this->phone2 = $v;
			$this->modifiedColumns[] = ArParamsPeer::PHONE2;
		}

	} 
	
	public function setLegalFax($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->legal_fax !== $v) {
			$this->legal_fax = $v;
			$this->modifiedColumns[] = ArParamsPeer::LEGAL_FAX;
		}

	} 
	
	public function setSenderNameOnInvoicingEmails($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->sender_name_on_invoicing_emails !== $v) {
			$this->sender_name_on_invoicing_emails = $v;
			$this->modifiedColumns[] = ArParamsPeer::SENDER_NAME_ON_INVOICING_EMAILS;
		}

	} 
	
	public function setInvoicingEmailAddress($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->invoicing_email_address !== $v) {
			$this->invoicing_email_address = $v;
			$this->modifiedColumns[] = ArParamsPeer::INVOICING_EMAIL_ADDRESS;
		}

	} 
	
	public function setAccountantEmailAddress($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->accountant_email_address !== $v) {
			$this->accountant_email_address = $v;
			$this->modifiedColumns[] = ArParamsPeer::ACCOUNTANT_EMAIL_ADDRESS;
		}

	} 
	
	public function setSmtpHost($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->smtp_host !== $v) {
			$this->smtp_host = $v;
			$this->modifiedColumns[] = ArParamsPeer::SMTP_HOST;
		}

	} 
	
	public function setSmtpPort($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->smtp_port !== $v) {
			$this->smtp_port = $v;
			$this->modifiedColumns[] = ArParamsPeer::SMTP_PORT;
		}

	} 
	
	public function setSmtpUsername($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->smtp_username !== $v) {
			$this->smtp_username = $v;
			$this->modifiedColumns[] = ArParamsPeer::SMTP_USERNAME;
		}

	} 
	
	public function setSmtpPassword($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->smtp_password !== $v) {
			$this->smtp_password = $v;
			$this->modifiedColumns[] = ArParamsPeer::SMTP_PASSWORD;
		}

	} 
	
	public function setSmtpEncryption($v)
	{

						if ($v !== null && !is_string($v)) {
			$v = (string) $v; 
		}

		if ($this->smtp_encryption !== $v) {
			$this->smtp_encryption = $v;
			$this->modifiedColumns[] = ArParamsPeer::SMTP_ENCRYPTION;
		}

	} 
	
	public function setSmtpReconnectAfterNrOfMessages($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->smtp_reconnect_after_nr_of_messages !== $v) {
			$this->smtp_reconnect_after_nr_of_messages = $v;
			$this->modifiedColumns[] = ArParamsPeer::SMTP_RECONNECT_AFTER_NR_OF_MESSAGES;
		}

	} 
	
	public function setSmtpSecondsOfPauseAfterReconnection($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->smtp_seconds_of_pause_after_reconnection !== $v) {
			$this->smtp_seconds_of_pause_after_reconnection = $v;
			$this->modifiedColumns[] = ArParamsPeer::SMTP_SECONDS_OF_PAUSE_AFTER_RECONNECTION;
		}

	} 
	
	public function setCurrentInvoiceNr($v)
	{

						if ($v !== null && !is_int($v) && is_numeric($v)) {
			$v = (int) $v;
		}

		if ($this->current_invoice_nr !== $v || $v === 1) {
			$this->current_invoice_nr = $v;
			$this->modifiedColumns[] = ArParamsPeer::CURRENT_INVOICE_NR;
		}

	} 
	
	public function hydrate(ResultSet $rs, $startcol = 1)
	{
		try {

			$this->id = $rs->getInt($startcol + 0);

			$this->name = $rs->getString($startcol + 1);

			$this->is_default = $rs->getBoolean($startcol + 2);

			$this->service_name = $rs->getString($startcol + 3);

			$this->service_provider_website = $rs->getString($startcol + 4);

			$this->service_provider_email = $rs->getString($startcol + 5);

			$this->vat_tax_perc = $rs->getInt($startcol + 6);

			$this->logo_image = $rs->getString($startcol + 7);

			$this->slogan = $rs->getString($startcol + 8);

			$this->logo_image_in_invoices = $rs->getString($startcol + 9);

			$this->logo_image_dpi_in_invoices = $rs->getInt($startcol + 10);

			$this->footer = $rs->getString($startcol + 11);

			$this->user_message = $rs->getString($startcol + 12);

			$this->last_viewed_feeds_md5 = $rs->getString($startcol + 13);

			$this->current_feeds_md5 = $rs->getString($startcol + 14);

			$this->legal_name = $rs->getString($startcol + 15);

			$this->external_crm_code = $rs->getString($startcol + 16);

			$this->vat = $rs->getString($startcol + 17);

			$this->legal_address = $rs->getString($startcol + 18);

			$this->legal_website = $rs->getString($startcol + 19);

			$this->legal_city = $rs->getString($startcol + 20);

			$this->legal_zipcode = $rs->getString($startcol + 21);

			$this->legal_state_province = $rs->getString($startcol + 22);

			$this->legal_country = $rs->getString($startcol + 23);

			$this->legal_email = $rs->getString($startcol + 24);

			$this->legal_phone = $rs->getString($startcol + 25);

			$this->phone2 = $rs->getString($startcol + 26);

			$this->legal_fax = $rs->getString($startcol + 27);

			$this->sender_name_on_invoicing_emails = $rs->getString($startcol + 28);

			$this->invoicing_email_address = $rs->getString($startcol + 29);

			$this->accountant_email_address = $rs->getString($startcol + 30);

			$this->smtp_host = $rs->getString($startcol + 31);

			$this->smtp_port = $rs->getInt($startcol + 32);

			$this->smtp_username = $rs->getString($startcol + 33);

			$this->smtp_password = $rs->getString($startcol + 34);

			$this->smtp_encryption = $rs->getString($startcol + 35);

			$this->smtp_reconnect_after_nr_of_messages = $rs->getInt($startcol + 36);

			$this->smtp_seconds_of_pause_after_reconnection = $rs->getInt($startcol + 37);

			$this->current_invoice_nr = $rs->getInt($startcol + 38);

			$this->resetModified();

			$this->setNew(false);

						return $startcol + 39; 
		} catch (Exception $e) {
			throw new PropelException("Error populating ArParams object", $e);
		}
	}

	
	public function delete($con = null)
	{
		if ($this->isDeleted()) {
			throw new PropelException("This object has already been deleted.");
		}

		if ($con === null) {
			$con = Propel::getConnection(ArParamsPeer::DATABASE_NAME);
		}

		try {
			$con->begin();
			ArParamsPeer::doDelete($this, $con);
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
			$con = Propel::getConnection(ArParamsPeer::DATABASE_NAME);
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
					$pk = ArParamsPeer::doInsert($this, $con);
					$affectedRows += 1; 										 										 
					$this->setId($pk);  
					$this->setNew(false);
				} else {
					$affectedRows += ArParamsPeer::doUpdate($this, $con);
				}
				$this->resetModified(); 			}

			if ($this->collArPartys !== null) {
				foreach($this->collArPartys as $referrerFK) {
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


			if (($retval = ArParamsPeer::doValidate($this, $columns)) !== true) {
				$failureMap = array_merge($failureMap, $retval);
			}


				if ($this->collArPartys !== null) {
					foreach($this->collArPartys as $referrerFK) {
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


			$this->alreadyInValidation = false;
		}

		return (!empty($failureMap) ? $failureMap : true);
	}

	
	public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArParamsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->getByPosition($pos);
	}

	
	public function getByPosition($pos)
	{
		switch($pos) {
			case 0:
				return $this->getId();
				break;
			case 1:
				return $this->getName();
				break;
			case 2:
				return $this->getIsDefault();
				break;
			case 3:
				return $this->getServiceName();
				break;
			case 4:
				return $this->getServiceProviderWebsite();
				break;
			case 5:
				return $this->getServiceProviderEmail();
				break;
			case 6:
				return $this->getVatTaxPerc();
				break;
			case 7:
				return $this->getLogoImage();
				break;
			case 8:
				return $this->getSlogan();
				break;
			case 9:
				return $this->getLogoImageInInvoices();
				break;
			case 10:
				return $this->getLogoImageDpiInInvoices();
				break;
			case 11:
				return $this->getFooter();
				break;
			case 12:
				return $this->getUserMessage();
				break;
			case 13:
				return $this->getLastViewedFeedsMd5();
				break;
			case 14:
				return $this->getCurrentFeedsMd5();
				break;
			case 15:
				return $this->getLegalName();
				break;
			case 16:
				return $this->getExternalCrmCode();
				break;
			case 17:
				return $this->getVat();
				break;
			case 18:
				return $this->getLegalAddress();
				break;
			case 19:
				return $this->getLegalWebsite();
				break;
			case 20:
				return $this->getLegalCity();
				break;
			case 21:
				return $this->getLegalZipcode();
				break;
			case 22:
				return $this->getLegalStateProvince();
				break;
			case 23:
				return $this->getLegalCountry();
				break;
			case 24:
				return $this->getLegalEmail();
				break;
			case 25:
				return $this->getLegalPhone();
				break;
			case 26:
				return $this->getPhone2();
				break;
			case 27:
				return $this->getLegalFax();
				break;
			case 28:
				return $this->getSenderNameOnInvoicingEmails();
				break;
			case 29:
				return $this->getInvoicingEmailAddress();
				break;
			case 30:
				return $this->getAccountantEmailAddress();
				break;
			case 31:
				return $this->getSmtpHost();
				break;
			case 32:
				return $this->getSmtpPort();
				break;
			case 33:
				return $this->getSmtpUsername();
				break;
			case 34:
				return $this->getSmtpPassword();
				break;
			case 35:
				return $this->getSmtpEncryption();
				break;
			case 36:
				return $this->getSmtpReconnectAfterNrOfMessages();
				break;
			case 37:
				return $this->getSmtpSecondsOfPauseAfterReconnection();
				break;
			case 38:
				return $this->getCurrentInvoiceNr();
				break;
			default:
				return null;
				break;
		} 	}

	
	public function toArray($keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArParamsPeer::getFieldNames($keyType);
		$result = array(
			$keys[0] => $this->getId(),
			$keys[1] => $this->getName(),
			$keys[2] => $this->getIsDefault(),
			$keys[3] => $this->getServiceName(),
			$keys[4] => $this->getServiceProviderWebsite(),
			$keys[5] => $this->getServiceProviderEmail(),
			$keys[6] => $this->getVatTaxPerc(),
			$keys[7] => $this->getLogoImage(),
			$keys[8] => $this->getSlogan(),
			$keys[9] => $this->getLogoImageInInvoices(),
			$keys[10] => $this->getLogoImageDpiInInvoices(),
			$keys[11] => $this->getFooter(),
			$keys[12] => $this->getUserMessage(),
			$keys[13] => $this->getLastViewedFeedsMd5(),
			$keys[14] => $this->getCurrentFeedsMd5(),
			$keys[15] => $this->getLegalName(),
			$keys[16] => $this->getExternalCrmCode(),
			$keys[17] => $this->getVat(),
			$keys[18] => $this->getLegalAddress(),
			$keys[19] => $this->getLegalWebsite(),
			$keys[20] => $this->getLegalCity(),
			$keys[21] => $this->getLegalZipcode(),
			$keys[22] => $this->getLegalStateProvince(),
			$keys[23] => $this->getLegalCountry(),
			$keys[24] => $this->getLegalEmail(),
			$keys[25] => $this->getLegalPhone(),
			$keys[26] => $this->getPhone2(),
			$keys[27] => $this->getLegalFax(),
			$keys[28] => $this->getSenderNameOnInvoicingEmails(),
			$keys[29] => $this->getInvoicingEmailAddress(),
			$keys[30] => $this->getAccountantEmailAddress(),
			$keys[31] => $this->getSmtpHost(),
			$keys[32] => $this->getSmtpPort(),
			$keys[33] => $this->getSmtpUsername(),
			$keys[34] => $this->getSmtpPassword(),
			$keys[35] => $this->getSmtpEncryption(),
			$keys[36] => $this->getSmtpReconnectAfterNrOfMessages(),
			$keys[37] => $this->getSmtpSecondsOfPauseAfterReconnection(),
			$keys[38] => $this->getCurrentInvoiceNr(),
		);
		return $result;
	}

	
	public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
	{
		$pos = ArParamsPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
		return $this->setByPosition($pos, $value);
	}

	
	public function setByPosition($pos, $value)
	{
		switch($pos) {
			case 0:
				$this->setId($value);
				break;
			case 1:
				$this->setName($value);
				break;
			case 2:
				$this->setIsDefault($value);
				break;
			case 3:
				$this->setServiceName($value);
				break;
			case 4:
				$this->setServiceProviderWebsite($value);
				break;
			case 5:
				$this->setServiceProviderEmail($value);
				break;
			case 6:
				$this->setVatTaxPerc($value);
				break;
			case 7:
				$this->setLogoImage($value);
				break;
			case 8:
				$this->setSlogan($value);
				break;
			case 9:
				$this->setLogoImageInInvoices($value);
				break;
			case 10:
				$this->setLogoImageDpiInInvoices($value);
				break;
			case 11:
				$this->setFooter($value);
				break;
			case 12:
				$this->setUserMessage($value);
				break;
			case 13:
				$this->setLastViewedFeedsMd5($value);
				break;
			case 14:
				$this->setCurrentFeedsMd5($value);
				break;
			case 15:
				$this->setLegalName($value);
				break;
			case 16:
				$this->setExternalCrmCode($value);
				break;
			case 17:
				$this->setVat($value);
				break;
			case 18:
				$this->setLegalAddress($value);
				break;
			case 19:
				$this->setLegalWebsite($value);
				break;
			case 20:
				$this->setLegalCity($value);
				break;
			case 21:
				$this->setLegalZipcode($value);
				break;
			case 22:
				$this->setLegalStateProvince($value);
				break;
			case 23:
				$this->setLegalCountry($value);
				break;
			case 24:
				$this->setLegalEmail($value);
				break;
			case 25:
				$this->setLegalPhone($value);
				break;
			case 26:
				$this->setPhone2($value);
				break;
			case 27:
				$this->setLegalFax($value);
				break;
			case 28:
				$this->setSenderNameOnInvoicingEmails($value);
				break;
			case 29:
				$this->setInvoicingEmailAddress($value);
				break;
			case 30:
				$this->setAccountantEmailAddress($value);
				break;
			case 31:
				$this->setSmtpHost($value);
				break;
			case 32:
				$this->setSmtpPort($value);
				break;
			case 33:
				$this->setSmtpUsername($value);
				break;
			case 34:
				$this->setSmtpPassword($value);
				break;
			case 35:
				$this->setSmtpEncryption($value);
				break;
			case 36:
				$this->setSmtpReconnectAfterNrOfMessages($value);
				break;
			case 37:
				$this->setSmtpSecondsOfPauseAfterReconnection($value);
				break;
			case 38:
				$this->setCurrentInvoiceNr($value);
				break;
		} 	}

	
	public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
	{
		$keys = ArParamsPeer::getFieldNames($keyType);

		if (array_key_exists($keys[0], $arr)) $this->setId($arr[$keys[0]]);
		if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
		if (array_key_exists($keys[2], $arr)) $this->setIsDefault($arr[$keys[2]]);
		if (array_key_exists($keys[3], $arr)) $this->setServiceName($arr[$keys[3]]);
		if (array_key_exists($keys[4], $arr)) $this->setServiceProviderWebsite($arr[$keys[4]]);
		if (array_key_exists($keys[5], $arr)) $this->setServiceProviderEmail($arr[$keys[5]]);
		if (array_key_exists($keys[6], $arr)) $this->setVatTaxPerc($arr[$keys[6]]);
		if (array_key_exists($keys[7], $arr)) $this->setLogoImage($arr[$keys[7]]);
		if (array_key_exists($keys[8], $arr)) $this->setSlogan($arr[$keys[8]]);
		if (array_key_exists($keys[9], $arr)) $this->setLogoImageInInvoices($arr[$keys[9]]);
		if (array_key_exists($keys[10], $arr)) $this->setLogoImageDpiInInvoices($arr[$keys[10]]);
		if (array_key_exists($keys[11], $arr)) $this->setFooter($arr[$keys[11]]);
		if (array_key_exists($keys[12], $arr)) $this->setUserMessage($arr[$keys[12]]);
		if (array_key_exists($keys[13], $arr)) $this->setLastViewedFeedsMd5($arr[$keys[13]]);
		if (array_key_exists($keys[14], $arr)) $this->setCurrentFeedsMd5($arr[$keys[14]]);
		if (array_key_exists($keys[15], $arr)) $this->setLegalName($arr[$keys[15]]);
		if (array_key_exists($keys[16], $arr)) $this->setExternalCrmCode($arr[$keys[16]]);
		if (array_key_exists($keys[17], $arr)) $this->setVat($arr[$keys[17]]);
		if (array_key_exists($keys[18], $arr)) $this->setLegalAddress($arr[$keys[18]]);
		if (array_key_exists($keys[19], $arr)) $this->setLegalWebsite($arr[$keys[19]]);
		if (array_key_exists($keys[20], $arr)) $this->setLegalCity($arr[$keys[20]]);
		if (array_key_exists($keys[21], $arr)) $this->setLegalZipcode($arr[$keys[21]]);
		if (array_key_exists($keys[22], $arr)) $this->setLegalStateProvince($arr[$keys[22]]);
		if (array_key_exists($keys[23], $arr)) $this->setLegalCountry($arr[$keys[23]]);
		if (array_key_exists($keys[24], $arr)) $this->setLegalEmail($arr[$keys[24]]);
		if (array_key_exists($keys[25], $arr)) $this->setLegalPhone($arr[$keys[25]]);
		if (array_key_exists($keys[26], $arr)) $this->setPhone2($arr[$keys[26]]);
		if (array_key_exists($keys[27], $arr)) $this->setLegalFax($arr[$keys[27]]);
		if (array_key_exists($keys[28], $arr)) $this->setSenderNameOnInvoicingEmails($arr[$keys[28]]);
		if (array_key_exists($keys[29], $arr)) $this->setInvoicingEmailAddress($arr[$keys[29]]);
		if (array_key_exists($keys[30], $arr)) $this->setAccountantEmailAddress($arr[$keys[30]]);
		if (array_key_exists($keys[31], $arr)) $this->setSmtpHost($arr[$keys[31]]);
		if (array_key_exists($keys[32], $arr)) $this->setSmtpPort($arr[$keys[32]]);
		if (array_key_exists($keys[33], $arr)) $this->setSmtpUsername($arr[$keys[33]]);
		if (array_key_exists($keys[34], $arr)) $this->setSmtpPassword($arr[$keys[34]]);
		if (array_key_exists($keys[35], $arr)) $this->setSmtpEncryption($arr[$keys[35]]);
		if (array_key_exists($keys[36], $arr)) $this->setSmtpReconnectAfterNrOfMessages($arr[$keys[36]]);
		if (array_key_exists($keys[37], $arr)) $this->setSmtpSecondsOfPauseAfterReconnection($arr[$keys[37]]);
		if (array_key_exists($keys[38], $arr)) $this->setCurrentInvoiceNr($arr[$keys[38]]);
	}

	
	public function buildCriteria()
	{
		$criteria = new Criteria(ArParamsPeer::DATABASE_NAME);

		if ($this->isColumnModified(ArParamsPeer::ID)) $criteria->add(ArParamsPeer::ID, $this->id);
		if ($this->isColumnModified(ArParamsPeer::NAME)) $criteria->add(ArParamsPeer::NAME, $this->name);
		if ($this->isColumnModified(ArParamsPeer::IS_DEFAULT)) $criteria->add(ArParamsPeer::IS_DEFAULT, $this->is_default);
		if ($this->isColumnModified(ArParamsPeer::SERVICE_NAME)) $criteria->add(ArParamsPeer::SERVICE_NAME, $this->service_name);
		if ($this->isColumnModified(ArParamsPeer::SERVICE_PROVIDER_WEBSITE)) $criteria->add(ArParamsPeer::SERVICE_PROVIDER_WEBSITE, $this->service_provider_website);
		if ($this->isColumnModified(ArParamsPeer::SERVICE_PROVIDER_EMAIL)) $criteria->add(ArParamsPeer::SERVICE_PROVIDER_EMAIL, $this->service_provider_email);
		if ($this->isColumnModified(ArParamsPeer::VAT_TAX_PERC)) $criteria->add(ArParamsPeer::VAT_TAX_PERC, $this->vat_tax_perc);
		if ($this->isColumnModified(ArParamsPeer::LOGO_IMAGE)) $criteria->add(ArParamsPeer::LOGO_IMAGE, $this->logo_image);
		if ($this->isColumnModified(ArParamsPeer::SLOGAN)) $criteria->add(ArParamsPeer::SLOGAN, $this->slogan);
		if ($this->isColumnModified(ArParamsPeer::LOGO_IMAGE_IN_INVOICES)) $criteria->add(ArParamsPeer::LOGO_IMAGE_IN_INVOICES, $this->logo_image_in_invoices);
		if ($this->isColumnModified(ArParamsPeer::LOGO_IMAGE_DPI_IN_INVOICES)) $criteria->add(ArParamsPeer::LOGO_IMAGE_DPI_IN_INVOICES, $this->logo_image_dpi_in_invoices);
		if ($this->isColumnModified(ArParamsPeer::FOOTER)) $criteria->add(ArParamsPeer::FOOTER, $this->footer);
		if ($this->isColumnModified(ArParamsPeer::USER_MESSAGE)) $criteria->add(ArParamsPeer::USER_MESSAGE, $this->user_message);
		if ($this->isColumnModified(ArParamsPeer::LAST_VIEWED_FEEDS_MD5)) $criteria->add(ArParamsPeer::LAST_VIEWED_FEEDS_MD5, $this->last_viewed_feeds_md5);
		if ($this->isColumnModified(ArParamsPeer::CURRENT_FEEDS_MD5)) $criteria->add(ArParamsPeer::CURRENT_FEEDS_MD5, $this->current_feeds_md5);
		if ($this->isColumnModified(ArParamsPeer::LEGAL_NAME)) $criteria->add(ArParamsPeer::LEGAL_NAME, $this->legal_name);
		if ($this->isColumnModified(ArParamsPeer::EXTERNAL_CRM_CODE)) $criteria->add(ArParamsPeer::EXTERNAL_CRM_CODE, $this->external_crm_code);
		if ($this->isColumnModified(ArParamsPeer::VAT)) $criteria->add(ArParamsPeer::VAT, $this->vat);
		if ($this->isColumnModified(ArParamsPeer::LEGAL_ADDRESS)) $criteria->add(ArParamsPeer::LEGAL_ADDRESS, $this->legal_address);
		if ($this->isColumnModified(ArParamsPeer::LEGAL_WEBSITE)) $criteria->add(ArParamsPeer::LEGAL_WEBSITE, $this->legal_website);
		if ($this->isColumnModified(ArParamsPeer::LEGAL_CITY)) $criteria->add(ArParamsPeer::LEGAL_CITY, $this->legal_city);
		if ($this->isColumnModified(ArParamsPeer::LEGAL_ZIPCODE)) $criteria->add(ArParamsPeer::LEGAL_ZIPCODE, $this->legal_zipcode);
		if ($this->isColumnModified(ArParamsPeer::LEGAL_STATE_PROVINCE)) $criteria->add(ArParamsPeer::LEGAL_STATE_PROVINCE, $this->legal_state_province);
		if ($this->isColumnModified(ArParamsPeer::LEGAL_COUNTRY)) $criteria->add(ArParamsPeer::LEGAL_COUNTRY, $this->legal_country);
		if ($this->isColumnModified(ArParamsPeer::LEGAL_EMAIL)) $criteria->add(ArParamsPeer::LEGAL_EMAIL, $this->legal_email);
		if ($this->isColumnModified(ArParamsPeer::LEGAL_PHONE)) $criteria->add(ArParamsPeer::LEGAL_PHONE, $this->legal_phone);
		if ($this->isColumnModified(ArParamsPeer::PHONE2)) $criteria->add(ArParamsPeer::PHONE2, $this->phone2);
		if ($this->isColumnModified(ArParamsPeer::LEGAL_FAX)) $criteria->add(ArParamsPeer::LEGAL_FAX, $this->legal_fax);
		if ($this->isColumnModified(ArParamsPeer::SENDER_NAME_ON_INVOICING_EMAILS)) $criteria->add(ArParamsPeer::SENDER_NAME_ON_INVOICING_EMAILS, $this->sender_name_on_invoicing_emails);
		if ($this->isColumnModified(ArParamsPeer::INVOICING_EMAIL_ADDRESS)) $criteria->add(ArParamsPeer::INVOICING_EMAIL_ADDRESS, $this->invoicing_email_address);
		if ($this->isColumnModified(ArParamsPeer::ACCOUNTANT_EMAIL_ADDRESS)) $criteria->add(ArParamsPeer::ACCOUNTANT_EMAIL_ADDRESS, $this->accountant_email_address);
		if ($this->isColumnModified(ArParamsPeer::SMTP_HOST)) $criteria->add(ArParamsPeer::SMTP_HOST, $this->smtp_host);
		if ($this->isColumnModified(ArParamsPeer::SMTP_PORT)) $criteria->add(ArParamsPeer::SMTP_PORT, $this->smtp_port);
		if ($this->isColumnModified(ArParamsPeer::SMTP_USERNAME)) $criteria->add(ArParamsPeer::SMTP_USERNAME, $this->smtp_username);
		if ($this->isColumnModified(ArParamsPeer::SMTP_PASSWORD)) $criteria->add(ArParamsPeer::SMTP_PASSWORD, $this->smtp_password);
		if ($this->isColumnModified(ArParamsPeer::SMTP_ENCRYPTION)) $criteria->add(ArParamsPeer::SMTP_ENCRYPTION, $this->smtp_encryption);
		if ($this->isColumnModified(ArParamsPeer::SMTP_RECONNECT_AFTER_NR_OF_MESSAGES)) $criteria->add(ArParamsPeer::SMTP_RECONNECT_AFTER_NR_OF_MESSAGES, $this->smtp_reconnect_after_nr_of_messages);
		if ($this->isColumnModified(ArParamsPeer::SMTP_SECONDS_OF_PAUSE_AFTER_RECONNECTION)) $criteria->add(ArParamsPeer::SMTP_SECONDS_OF_PAUSE_AFTER_RECONNECTION, $this->smtp_seconds_of_pause_after_reconnection);
		if ($this->isColumnModified(ArParamsPeer::CURRENT_INVOICE_NR)) $criteria->add(ArParamsPeer::CURRENT_INVOICE_NR, $this->current_invoice_nr);

		return $criteria;
	}

	
	public function buildPkeyCriteria()
	{
		$criteria = new Criteria(ArParamsPeer::DATABASE_NAME);

		$criteria->add(ArParamsPeer::ID, $this->id);

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

		$copyObj->setName($this->name);

		$copyObj->setIsDefault($this->is_default);

		$copyObj->setServiceName($this->service_name);

		$copyObj->setServiceProviderWebsite($this->service_provider_website);

		$copyObj->setServiceProviderEmail($this->service_provider_email);

		$copyObj->setVatTaxPerc($this->vat_tax_perc);

		$copyObj->setLogoImage($this->logo_image);

		$copyObj->setSlogan($this->slogan);

		$copyObj->setLogoImageInInvoices($this->logo_image_in_invoices);

		$copyObj->setLogoImageDpiInInvoices($this->logo_image_dpi_in_invoices);

		$copyObj->setFooter($this->footer);

		$copyObj->setUserMessage($this->user_message);

		$copyObj->setLastViewedFeedsMd5($this->last_viewed_feeds_md5);

		$copyObj->setCurrentFeedsMd5($this->current_feeds_md5);

		$copyObj->setLegalName($this->legal_name);

		$copyObj->setExternalCrmCode($this->external_crm_code);

		$copyObj->setVat($this->vat);

		$copyObj->setLegalAddress($this->legal_address);

		$copyObj->setLegalWebsite($this->legal_website);

		$copyObj->setLegalCity($this->legal_city);

		$copyObj->setLegalZipcode($this->legal_zipcode);

		$copyObj->setLegalStateProvince($this->legal_state_province);

		$copyObj->setLegalCountry($this->legal_country);

		$copyObj->setLegalEmail($this->legal_email);

		$copyObj->setLegalPhone($this->legal_phone);

		$copyObj->setPhone2($this->phone2);

		$copyObj->setLegalFax($this->legal_fax);

		$copyObj->setSenderNameOnInvoicingEmails($this->sender_name_on_invoicing_emails);

		$copyObj->setInvoicingEmailAddress($this->invoicing_email_address);

		$copyObj->setAccountantEmailAddress($this->accountant_email_address);

		$copyObj->setSmtpHost($this->smtp_host);

		$copyObj->setSmtpPort($this->smtp_port);

		$copyObj->setSmtpUsername($this->smtp_username);

		$copyObj->setSmtpPassword($this->smtp_password);

		$copyObj->setSmtpEncryption($this->smtp_encryption);

		$copyObj->setSmtpReconnectAfterNrOfMessages($this->smtp_reconnect_after_nr_of_messages);

		$copyObj->setSmtpSecondsOfPauseAfterReconnection($this->smtp_seconds_of_pause_after_reconnection);

		$copyObj->setCurrentInvoiceNr($this->current_invoice_nr);


		if ($deepCopy) {
									$copyObj->setNew(false);

			foreach($this->getArPartys() as $relObj) {
				$copyObj->addArParty($relObj->copy($deepCopy));
			}

			foreach($this->getArWebAccounts() as $relObj) {
				$copyObj->addArWebAccount($relObj->copy($deepCopy));
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
			self::$peer = new ArParamsPeer();
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

				$criteria->add(ArPartyPeer::AR_PARAMS_ID, $this->getId());

				ArPartyPeer::addSelectColumns($criteria);
				$this->collArPartys = ArPartyPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArPartyPeer::AR_PARAMS_ID, $this->getId());

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

		$criteria->add(ArPartyPeer::AR_PARAMS_ID, $this->getId());

		return ArPartyPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArParty(ArParty $l)
	{
		$this->collArPartys[] = $l;
		$l->setArParams($this);
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

				$criteria->add(ArPartyPeer::AR_PARAMS_ID, $this->getId());

				$this->collArPartys = ArPartyPeer::doSelectJoinArRateCategory($criteria, $con);
			}
		} else {
									
			$criteria->add(ArPartyPeer::AR_PARAMS_ID, $this->getId());

			if (!isset($this->lastArPartyCriteria) || !$this->lastArPartyCriteria->equals($criteria)) {
				$this->collArPartys = ArPartyPeer::doSelectJoinArRateCategory($criteria, $con);
			}
		}
		$this->lastArPartyCriteria = $criteria;

		return $this->collArPartys;
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

				$criteria->add(ArWebAccountPeer::AR_PARAMS_ID, $this->getId());

				ArWebAccountPeer::addSelectColumns($criteria);
				$this->collArWebAccounts = ArWebAccountPeer::doSelect($criteria, $con);
			}
		} else {
						if (!$this->isNew()) {
												

				$criteria->add(ArWebAccountPeer::AR_PARAMS_ID, $this->getId());

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

		$criteria->add(ArWebAccountPeer::AR_PARAMS_ID, $this->getId());

		return ArWebAccountPeer::doCount($criteria, $distinct, $con);
	}

	
	public function addArWebAccount(ArWebAccount $l)
	{
		$this->collArWebAccounts[] = $l;
		$l->setArParams($this);
	}


	
	public function getArWebAccountsJoinArParty($criteria = null, $con = null)
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

				$criteria->add(ArWebAccountPeer::AR_PARAMS_ID, $this->getId());

				$this->collArWebAccounts = ArWebAccountPeer::doSelectJoinArParty($criteria, $con);
			}
		} else {
									
			$criteria->add(ArWebAccountPeer::AR_PARAMS_ID, $this->getId());

			if (!isset($this->lastArWebAccountCriteria) || !$this->lastArWebAccountCriteria->equals($criteria)) {
				$this->collArWebAccounts = ArWebAccountPeer::doSelectJoinArParty($criteria, $con);
			}
		}
		$this->lastArWebAccountCriteria = $criteria;

		return $this->collArWebAccounts;
	}


	
	public function getArWebAccountsJoinArOffice($criteria = null, $con = null)
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

				$criteria->add(ArWebAccountPeer::AR_PARAMS_ID, $this->getId());

				$this->collArWebAccounts = ArWebAccountPeer::doSelectJoinArOffice($criteria, $con);
			}
		} else {
									
			$criteria->add(ArWebAccountPeer::AR_PARAMS_ID, $this->getId());

			if (!isset($this->lastArWebAccountCriteria) || !$this->lastArWebAccountCriteria->equals($criteria)) {
				$this->collArWebAccounts = ArWebAccountPeer::doSelectJoinArOffice($criteria, $con);
			}
		}
		$this->lastArWebAccountCriteria = $criteria;

		return $this->collArWebAccounts;
	}

} 