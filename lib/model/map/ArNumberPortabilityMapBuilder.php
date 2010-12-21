<?php



class ArNumberPortabilityMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArNumberPortabilityMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('ar_number_portability');
		$tMap->setPhpName('ArNumberPortability');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('TELEPHONE_NUMBER', 'TelephoneNumber', 'string', CreoleTypes::VARCHAR, true, 256);

		$tMap->addColumn('PORTED_TELEPHONE_NUMBER', 'PortedTelephoneNumber', 'string', CreoleTypes::VARCHAR, true, 256);

		$tMap->addColumn('FROM_DATE', 'FromDate', 'int', CreoleTypes::TIMESTAMP, false, null);

	} 
} 