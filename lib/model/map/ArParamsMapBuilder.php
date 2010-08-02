<?php



class ArParamsMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArParamsMapBuilder';

	
	private $dbMap;

	
	public function isBuilt()
	{
		return ($this->dbMap !== null);
	}

	
	public function getDatabaseMap()
	{
		return $this->dbMap;
	}

	
	public function doBuild()
	{
		$this->dbMap = Propel::getDatabaseMap('propel');

		$tMap = $this->dbMap->addTable('ar_params');
		$tMap->setPhpName('ArParams');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 80);

		$tMap->addColumn('IS_DEFAULT', 'IsDefault', 'boolean', CreoleTypes::BOOLEAN, false, null);

		$tMap->addColumn('SERVICE_NAME', 'ServiceName', 'string', CreoleTypes::VARCHAR, false, 120);

		$tMap->addColumn('SERVICE_PROVIDER_WEBSITE', 'ServiceProviderWebsite', 'string', CreoleTypes::VARCHAR, false, 120);

		$tMap->addColumn('SERVICE_PROVIDER_EMAIL', 'ServiceProviderEmail', 'string', CreoleTypes::VARCHAR, false, 120);

		$tMap->addColumn('VAT_TAX_PERC', 'VatTaxPerc', 'int', CreoleTypes::INTEGER, true, 20);

		$tMap->addColumn('LOGO_IMAGE', 'LogoImage', 'string', CreoleTypes::VARCHAR, false, 120);

		$tMap->addColumn('SLOGAN', 'Slogan', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('LOGO_IMAGE_IN_INVOICES', 'LogoImageInInvoices', 'string', CreoleTypes::VARCHAR, false, 120);

		$tMap->addColumn('FOOTER', 'Footer', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('USER_MESSAGE', 'UserMessage', 'string', CreoleTypes::VARCHAR, false, 2048);

		$tMap->addColumn('LAST_VIEWED_FEEDS_MD5', 'LastViewedFeedsMd5', 'string', CreoleTypes::VARCHAR, false, 1024);

		$tMap->addColumn('CURRENT_FEEDS_MD5', 'CurrentFeedsMd5', 'string', CreoleTypes::VARCHAR, false, 1024);

		$tMap->addColumn('LEGAL_NAME', 'LegalName', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('EXTERNAL_CRM_CODE', 'ExternalCrmCode', 'string', CreoleTypes::VARCHAR, false, 40);

		$tMap->addColumn('VAT', 'Vat', 'string', CreoleTypes::VARCHAR, false, 40);

		$tMap->addColumn('LEGAL_ADDRESS', 'LegalAddress', 'string', CreoleTypes::VARCHAR, false, 120);

		$tMap->addColumn('LEGAL_WEBSITE', 'LegalWebsite', 'string', CreoleTypes::VARCHAR, false, 120);

		$tMap->addColumn('LEGAL_CITY', 'LegalCity', 'string', CreoleTypes::VARCHAR, false, 60);

		$tMap->addColumn('LEGAL_ZIPCODE', 'LegalZipcode', 'string', CreoleTypes::VARCHAR, false, 20);

		$tMap->addColumn('LEGAL_STATE_PROVINCE', 'LegalStateProvince', 'string', CreoleTypes::VARCHAR, false, 60);

		$tMap->addColumn('LEGAL_COUNTRY', 'LegalCountry', 'string', CreoleTypes::VARCHAR, false, 60);

		$tMap->addColumn('LEGAL_EMAIL', 'LegalEmail', 'string', CreoleTypes::VARCHAR, false, 60);

		$tMap->addColumn('LEGAL_PHONE', 'LegalPhone', 'string', CreoleTypes::VARCHAR, false, 60);

		$tMap->addColumn('PHONE2', 'Phone2', 'string', CreoleTypes::VARCHAR, false, 60);

		$tMap->addColumn('LEGAL_FAX', 'LegalFax', 'string', CreoleTypes::VARCHAR, false, 60);

		$tMap->addColumn('INVOICE_NOTES', 'InvoiceNotes', 'string', CreoleTypes::VARCHAR, false, 2048);

		$tMap->addColumn('INVOICE_PAYMENT_TERMS', 'InvoicePaymentTerms', 'string', CreoleTypes::VARCHAR, false, 2048);

		$tMap->addColumn('SENDER_NAME_ON_INVOICING_EMAILS', 'SenderNameOnInvoicingEmails', 'string', CreoleTypes::VARCHAR, false, 120);

		$tMap->addColumn('INVOICING_EMAIL_ADDRESS', 'InvoicingEmailAddress', 'string', CreoleTypes::VARCHAR, false, 120);

		$tMap->addColumn('ACCOUNTANT_EMAIL_ADDRESS', 'AccountantEmailAddress', 'string', CreoleTypes::VARCHAR, false, 120);

		$tMap->addColumn('SMTP_HOST', 'SmtpHost', 'string', CreoleTypes::VARCHAR, false, 250);

		$tMap->addColumn('SMTP_PORT', 'SmtpPort', 'int', CreoleTypes::INTEGER, false, 4);

		$tMap->addColumn('SMTP_USERNAME', 'SmtpUsername', 'string', CreoleTypes::VARCHAR, false, 60);

		$tMap->addColumn('SMTP_PASSWORD', 'SmtpPassword', 'string', CreoleTypes::VARCHAR, false, 60);

		$tMap->addColumn('SMTP_ENCRYPTION', 'SmtpEncryption', 'string', CreoleTypes::VARCHAR, false, 60);

		$tMap->addColumn('SMTP_RECONNECT_AFTER_NR_OF_MESSAGES', 'SmtpReconnectAfterNrOfMessages', 'int', CreoleTypes::INTEGER, false, 4);

		$tMap->addColumn('SMTP_SECONDS_OF_PAUSE_AFTER_RECONNECTION', 'SmtpSecondsOfPauseAfterReconnection', 'int', CreoleTypes::INTEGER, false, 2);

		$tMap->addColumn('CURRENT_INVOICE_NR', 'CurrentInvoiceNr', 'int', CreoleTypes::INTEGER, true, 11);

	} 
} 