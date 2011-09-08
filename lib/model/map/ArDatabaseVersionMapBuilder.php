<?php



class ArDatabaseVersionMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArDatabaseVersionMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('ar_database_version');
		$tMap->setPhpName('ArDatabaseVersion');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('VERSION', 'Version', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('INSTALLATION_DATE', 'InstallationDate', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 