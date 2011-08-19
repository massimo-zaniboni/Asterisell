<?php



class ArProblemMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArProblemMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('ar_problem');
		$tMap->setPhpName('ArProblem');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('CREATED_AT', 'CreatedAt', 'int', CreoleTypes::TIMESTAMP, false, null);

		$tMap->addColumn('DUPLICATION_KEY', 'DuplicationKey', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('DESCRIPTION', 'Description', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('EFFECT', 'Effect', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('PROPOSED_SOLUTION', 'ProposedSolution', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('USER_NOTES', 'UserNotes', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('MANTAIN', 'Mantain', 'boolean', CreoleTypes::BOOLEAN, false, null);

		$tMap->addColumn('SIGNALED_TO_ADMIN', 'SignaledToAdmin', 'boolean', CreoleTypes::BOOLEAN, true, null);

	} 
} 