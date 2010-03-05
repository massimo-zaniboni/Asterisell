<?php



class ArFromNumberToEndPointTypeMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArFromNumberToEndPointTypeMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('ar_from_number_to_end_point_type');
		$tMap->setPhpName('ArFromNumberToEndPointType');

		$tMap->setUseIdGenerator(true);

		$tMap->addColumn('NUMBER_PREFIX', 'NumberPrefix', 'string', CreoleTypes::VARCHAR, false, 40);

		$tMap->addForeignKey('AR_CALL_END_POINT_TYPE_ID', 'ArCallEndPointTypeId', 'int', CreoleTypes::INTEGER, 'ar_call_end_point_type', 'ID', false, null);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

	} 
} 