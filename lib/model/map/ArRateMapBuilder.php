<?php



class ArRateMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArRateMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('ar_rate');
		$tMap->setPhpName('ArRate');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('DESTINATION_TYPE', 'DestinationType', 'int', CreoleTypes::INTEGER, true, 1);

		$tMap->addColumn('IS_EXCEPTION', 'IsException', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addForeignKey('AR_RATE_CATEGORY_ID', 'ArRateCategoryId', 'int', CreoleTypes::INTEGER, 'ar_rate_category', 'ID', false, null);

		$tMap->addForeignKey('AR_PARTY_ID', 'ArPartyId', 'int', CreoleTypes::INTEGER, 'ar_party', 'ID', false, null);

		$tMap->addColumn('START_TIME', 'StartTime', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('END_TIME', 'EndTime', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('PHP_CLASS_SERIALIZATION', 'PhpClassSerialization', 'string', CreoleTypes::CLOB, false, null);

		$tMap->addColumn('USER_INPUT', 'UserInput', 'string', CreoleTypes::CLOB, false, null);

		$tMap->addColumn('NOTE', 'Note', 'string', CreoleTypes::LONGVARCHAR, false, null);

	} 
} 