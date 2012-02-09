<?php



class ArAsteriskAccountRangeMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArAsteriskAccountRangeMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('ar_asterisk_account_range');
		$tMap->setPhpName('ArAsteriskAccountRange');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('AR_OFFICE_ID', 'ArOfficeId', 'int', CreoleTypes::INTEGER, 'ar_office', 'ID', false, null);

		$tMap->addColumn('SYSTEM_PREFIX', 'SystemPrefix', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('SYSTEM_SUFFIX', 'SystemSuffix', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('SYSTEM_START_RANGE', 'SystemStartRange', 'string', CreoleTypes::VARCHAR, true, 18);

		$tMap->addColumn('SYSTEM_END_RANGE', 'SystemEndRange', 'string', CreoleTypes::VARCHAR, true, 18);

		$tMap->addColumn('SYSTEM_LEADING_ZERO', 'SystemLeadingZero', 'int', CreoleTypes::INTEGER, true, 4);

		$tMap->addColumn('IS_DELETE', 'IsDelete', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('IS_PHYSICAL_DELETE', 'IsPhysicalDelete', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('USER_PREFIX', 'UserPrefix', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('USER_SUFFIX', 'UserSuffix', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('USER_START_RANGE', 'UserStartRange', 'string', CreoleTypes::VARCHAR, true, 18);

		$tMap->addColumn('GENERATE_RANGE_FOR_USERS', 'GenerateRangeForUsers', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('USER_LEADING_ZERO', 'UserLeadingZero', 'int', CreoleTypes::INTEGER, true, 4);

		$tMap->addColumn('USER_NOTE', 'UserNote', 'string', CreoleTypes::VARCHAR, false, 6048);

	} 
} 