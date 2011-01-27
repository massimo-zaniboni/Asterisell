<?php



class ArLockMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArLockMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('ar_lock');
		$tMap->setPhpName('ArLock');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::CHAR, true, 255);

		$tMap->addColumn('TIME', 'Time', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('INFO', 'Info', 'string', CreoleTypes::VARCHAR, false, 1024);

	} 
} 