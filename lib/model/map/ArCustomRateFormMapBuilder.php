<?php



class ArCustomRateFormMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArCustomRateFormMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('ar_custom_rate_form');
		$tMap->setPhpName('ArCustomRateForm');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('ID', 'Id', 'int' , CreoleTypes::INTEGER, 'ar_rate', 'ID', true, 20);

	} 
} 