<?php



class ArPartyMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArPartyMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('ar_party');
		$tMap->setPhpName('ArParty');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CUSTOMER_OR_VENDOR', 'CustomerOrVendor', 'string', CreoleTypes::VARCHAR, false, 1);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('EXTERNAL_CRM_CODE', 'ExternalCrmCode', 'string', CreoleTypes::VARCHAR, false, 40);

		$tMap->addColumn('VAT', 'Vat', 'string', CreoleTypes::VARCHAR, false, 40);

		$tMap->addColumn('LEGAL_ADDRESS', 'LegalAddress', 'string', CreoleTypes::VARCHAR, false, 60);

		$tMap->addColumn('LEGAL_CITY', 'LegalCity', 'string', CreoleTypes::VARCHAR, false, 60);

		$tMap->addColumn('LEGAL_ZIPCODE', 'LegalZipcode', 'string', CreoleTypes::VARCHAR, false, 20);

		$tMap->addColumn('LEGAL_STATE_PROVINCE', 'LegalStateProvince', 'string', CreoleTypes::VARCHAR, false, 60);

		$tMap->addColumn('LEGAL_COUNTRY', 'LegalCountry', 'string', CreoleTypes::VARCHAR, false, 60);

		$tMap->addColumn('EMAIL', 'Email', 'string', CreoleTypes::VARCHAR, false, 60);

		$tMap->addColumn('PHONE', 'Phone', 'string', CreoleTypes::VARCHAR, false, 60);

		$tMap->addColumn('PHONE2', 'Phone2', 'string', CreoleTypes::VARCHAR, false, 60);

		$tMap->addColumn('FAX', 'Fax', 'string', CreoleTypes::VARCHAR, false, 60);

		$tMap->addForeignKey('AR_RATE_CATEGORY_ID', 'ArRateCategoryId', 'int', CreoleTypes::INTEGER, 'ar_rate_category', 'ID', false, null);

		$tMap->addColumn('MAX_LIMIT_30', 'MaxLimit30', 'int', CreoleTypes::INTEGER, false, 20);

	} 
} 