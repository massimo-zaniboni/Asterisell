<?php



class ArCurrencyConversionMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArCurrencyConversionMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('ar_currency_conversion');
		$tMap->setPhpName('ArCurrencyConversion');

		$tMap->setUseIdGenerator(true);

		$tMap->addColumn('SOURCE_CURRENCY', 'SourceCurrency', 'string', CreoleTypes::VARCHAR, true, 20);

		$tMap->addColumn('DEST_CURRENCY', 'DestCurrency', 'string', CreoleTypes::VARCHAR, false, 3);

		$tMap->addColumn('CONVERSION_FACTOR', 'ConversionFactor', 'string', CreoleTypes::VARCHAR, false, 20);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

	} 
} 