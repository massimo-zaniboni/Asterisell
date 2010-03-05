<?php



class ArCallEndPointTypeMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArCallEndPointTypeMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('ar_call_end_point_type');
		$tMap->setPhpName('ArCallEndPointType');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('NAME', 'Name', 'string', CreoleTypes::VARCHAR, false, 80);

		$tMap->addColumn('CODE', 'Code', 'string', CreoleTypes::VARCHAR, false, 15);

	} 
} 