<?php



class CdrMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.CdrMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('cdr');
		$tMap->setPhpName('Cdr');

		$tMap->setUseIdGenerator(true);

		$tMap->addColumn('CALLDATE', 'Calldate', 'int', CreoleTypes::TIMESTAMP, true, null);

		$tMap->addColumn('CLID', 'Clid', 'string', CreoleTypes::VARCHAR, true, 80);

		$tMap->addColumn('SRC', 'Src', 'string', CreoleTypes::VARCHAR, true, 80);

		$tMap->addColumn('DST', 'Dst', 'string', CreoleTypes::VARCHAR, true, 80);

		$tMap->addColumn('DCONTEXT', 'Dcontext', 'string', CreoleTypes::VARCHAR, true, 80);

		$tMap->addColumn('CHANNEL', 'Channel', 'string', CreoleTypes::VARCHAR, false, 80);

		$tMap->addColumn('DSTCHANNEL', 'Dstchannel', 'string', CreoleTypes::VARCHAR, true, 80);

		$tMap->addColumn('LASTAPP', 'Lastapp', 'string', CreoleTypes::VARCHAR, true, 80);

		$tMap->addColumn('LASTDATA', 'Lastdata', 'string', CreoleTypes::VARCHAR, true, 80);

		$tMap->addColumn('DURATION', 'Duration', 'int', CreoleTypes::INTEGER, true, 11);

		$tMap->addColumn('BILLSEC', 'Billsec', 'int', CreoleTypes::INTEGER, true, 11);

		$tMap->addColumn('DISPOSITION', 'Disposition', 'string', CreoleTypes::VARCHAR, true, 45);

		$tMap->addColumn('AMAFLAGS', 'Amaflags', 'int', CreoleTypes::INTEGER, true, 11);

		$tMap->addForeignKey('ACCOUNTCODE', 'Accountcode', 'string', CreoleTypes::VARCHAR, 'ar_asterisk_account', 'ACCOUNT_CODE', true, 30);

		$tMap->addColumn('UNIQUEID', 'Uniqueid', 'string', CreoleTypes::VARCHAR, true, 32);

		$tMap->addColumn('USERFIELD', 'Userfield', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addForeignKey('INCOME_AR_RATE_ID', 'IncomeArRateId', 'int', CreoleTypes::INTEGER, 'ar_rate', 'ID', false, 20);

		$tMap->addColumn('INCOME', 'Income', 'int', CreoleTypes::INTEGER, false, 20);

		$tMap->addForeignKey('COST_AR_RATE_ID', 'CostArRateId', 'int', CreoleTypes::INTEGER, 'ar_rate', 'ID', false, 20);

		$tMap->addColumn('VENDOR_ID', 'VendorId', 'int', CreoleTypes::INTEGER, false, 20);

		$tMap->addColumn('COST', 'Cost', 'int', CreoleTypes::INTEGER, false, 20);

		$tMap->addForeignKey('AR_TELEPHONE_PREFIX_ID', 'ArTelephonePrefixId', 'int', CreoleTypes::INTEGER, 'ar_telephone_prefix', 'ID', false, null);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

	} 
} 