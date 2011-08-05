<?php



class ArTelephonePrefixMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArTelephonePrefixMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('ar_telephone_prefix');
		$tMap->setPhpName('ArTelephonePrefix');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('PREFIX', 'Prefix', 'string', CreoleTypes::VARCHAR, true, 80);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 80);

		$tMap->addColumn('GEOGRAPHIC_LOCATION', 'GeographicLocation', 'string', CreoleTypes::VARCHAR, false, 80);

		$tMap->addColumn('OPERATOR_TYPE', 'OperatorType', 'string', CreoleTypes::VARCHAR, false, 80);

	} 
} 