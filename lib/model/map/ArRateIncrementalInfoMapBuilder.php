<?php



class ArRateIncrementalInfoMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArRateIncrementalInfoMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('ar_rate_incremental_info');
		$tMap->setPhpName('ArRateIncrementalInfo');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('AR_PARTY_ID', 'ArPartyId', 'int', CreoleTypes::INTEGER, 'ar_party', 'ID', false, null);

		$tMap->addForeignKey('AR_RATE_ID', 'ArRateId', 'int', CreoleTypes::INTEGER, 'ar_rate', 'ID', false, null);

		$tMap->addColumn('PERIOD', 'Period', 'string', CreoleTypes::VARCHAR, false, 1024);

		$tMap->addColumn('LAST_PROCESSED_CDR_DATE', 'LastProcessedCdrDate', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('LAST_PROCESSED_CDR_ID', 'LastProcessedCdrId', 'int', CreoleTypes::INTEGER, false, 20);

		$tMap->addColumn('BUNDLE_RATE', 'BundleRate', 'string', CreoleTypes::CLOB, false, null);

	} 
} 