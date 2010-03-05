<?php



class ArWebAccountMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArWebAccountMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('ar_web_account');
		$tMap->setPhpName('ArWebAccount');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('LOGIN', 'Login', 'string', CreoleTypes::VARCHAR, true, 20);

		$tMap->addColumn('PASSWORD', 'Password', 'string', CreoleTypes::VARCHAR, false, 40);

		$tMap->addForeignKey('AR_PARTY_ID', 'ArPartyId', 'int', CreoleTypes::INTEGER, 'ar_party', 'ID', false, null);

		$tMap->addForeignKey('AR_OFFICE_ID', 'ArOfficeId', 'int', CreoleTypes::INTEGER, 'ar_office', 'ID', false, null);

		$tMap->addColumn('ACTIVATE_AT', 'ActivateAt', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('DEACTIVATE_AT', 'DeactivateAt', 'int', CreoleTypes::DATE, false, null);

		$tMap->addForeignKey('AR_PARAMS_ID', 'ArParamsId', 'int', CreoleTypes::INTEGER, 'ar_params', 'ID', false, null);

	} 
} 