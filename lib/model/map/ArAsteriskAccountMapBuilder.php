<?php



class ArAsteriskAccountMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArAsteriskAccountMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('ar_asterisk_account');
		$tMap->setPhpName('ArAsteriskAccount');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 160);

		$tMap->addColumn('ACCOUNT_CODE', 'AccountCode', 'string', CreoleTypes::VARCHAR, true, 30);

		$tMap->addForeignKey('AR_OFFICE_ID', 'ArOfficeId', 'int', CreoleTypes::INTEGER, 'ar_office', 'ID', false, null);

		$tMap->addColumn('IS_ACTIVE', 'IsActive', 'boolean', CreoleTypes::BOOLEAN, true, null);

	} 
} 