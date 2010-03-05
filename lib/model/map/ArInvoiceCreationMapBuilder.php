<?php



class ArInvoiceCreationMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArInvoiceCreationMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('ar_invoice_creation');
		$tMap->setPhpName('ArInvoiceCreation');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addColumn('FIRST_NR', 'FirstNr', 'string', CreoleTypes::VARCHAR, false, 20);

		$tMap->addColumn('INVOICE_DATE', 'InvoiceDate', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('AR_CDR_FROM', 'ArCdrFrom', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('AR_CDR_TO', 'ArCdrTo', 'int', CreoleTypes::DATE, false, null);

	} 
} 