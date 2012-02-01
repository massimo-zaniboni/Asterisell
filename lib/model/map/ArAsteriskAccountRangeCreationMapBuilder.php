<?php



class ArAsteriskAccountRangeCreationMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArAsteriskAccountRangeCreationMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('ar_asterisk_account_range_creation');
		$tMap->setPhpName('ArAsteriskAccountRangeCreation');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('AR_OFFICE_ID', 'ArOfficeId', 'int', CreoleTypes::INTEGER, 'ar_office', 'ID', false, null);

		$tMap->addColumn('PREFIX', 'Prefix', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('SUFFIX', 'Suffix', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('START_RANGE', 'StartRange', 'int', CreoleTypes::INTEGER, true, 10);

		$tMap->addColumn('END_RANGE', 'EndRange', 'int', CreoleTypes::INTEGER, true, 10);

		$tMap->addColumn('LEADING_ZERO', 'LeadingZero', 'int', CreoleTypes::INTEGER, true, 3);

		$tMap->addColumn('IS_DELETE', 'IsDelete', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('IS_PHYSICAL_DELETE', 'IsPhysicalDelete', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('USER_NOTE', 'UserNote', 'string', CreoleTypes::LONGVARCHAR, false, null);

	} 
} 