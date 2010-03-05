<?php



class ArJobQueueMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArJobQueueMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('ar_job_queue');
		$tMap->setPhpName('ArJobQueue');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('IS_PART_OF', 'IsPartOf', 'int', CreoleTypes::INTEGER, true, 11);

		$tMap->addColumn('STATE', 'State', 'int', CreoleTypes::INTEGER, true, 1);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('START_AT', 'StartAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('END_AT', 'EndAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('DESCRIPTION', 'Description', 'string', CreoleTypes::VARCHAR, true, 12000);

		$tMap->addColumn('PHP_DATA_JOB_SERIALIZATION', 'PhpDataJobSerialization', 'string', CreoleTypes::CLOB, false, null);

	} 
} 