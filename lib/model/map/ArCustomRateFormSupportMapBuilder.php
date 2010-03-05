<?php



class ArCustomRateFormSupportMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArCustomRateFormSupportMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('ar_custom_rate_form_support');
		$tMap->setPhpName('ArCustomRateFormSupport');

		$tMap->setUseIdGenerator(false);

		$tMap->addForeignPrimaryKey('OWNER_AR_RATE_ID', 'OwnerArRateId', 'int' , CreoleTypes::INTEGER, 'ar_rate', 'ID', true, 20);

	} 
} 