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

		$tMap->addColumn('CLID', 'Clid', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('SRC', 'Src', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('DST', 'Dst', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('DCONTEXT', 'Dcontext', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('CHANNEL', 'Channel', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('DSTCHANNEL', 'Dstchannel', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('LASTAPP', 'Lastapp', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('LASTDATA', 'Lastdata', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('DURATION', 'Duration', 'int', CreoleTypes::INTEGER, true, 11);

		$tMap->addColumn('BILLSEC', 'Billsec', 'int', CreoleTypes::INTEGER, true, 11);

		$tMap->addColumn('DISPOSITION', 'Disposition', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('AMAFLAGS', 'Amaflags', 'int', CreoleTypes::INTEGER, true, 11);

		$tMap->addColumn('ACCOUNTCODE', 'Accountcode', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('UNIQUEID', 'Uniqueid', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('USERFIELD', 'Userfield', 'string', CreoleTypes::VARCHAR, true, 255);

		$tMap->addColumn('DESTINATION_TYPE', 'DestinationType', 'int', CreoleTypes::INTEGER, true, 1);

		$tMap->addForeignKey('AR_ASTERISK_ACCOUNT_ID', 'ArAsteriskAccountId', 'int', CreoleTypes::INTEGER, 'ar_asterisk_account', 'ID', false, null);

		$tMap->addForeignKey('INCOME_AR_RATE_ID', 'IncomeArRateId', 'int', CreoleTypes::INTEGER, 'ar_rate', 'ID', false, 20);

		$tMap->addColumn('INCOME', 'Income', 'int', CreoleTypes::INTEGER, false, 20);

		$tMap->addForeignKey('COST_AR_RATE_ID', 'CostArRateId', 'int', CreoleTypes::INTEGER, 'ar_rate', 'ID', false, 20);

		$tMap->addColumn('VENDOR_ID', 'VendorId', 'int', CreoleTypes::INTEGER, false, 20);

		$tMap->addColumn('COST', 'Cost', 'int', CreoleTypes::INTEGER, false, 20);

		$tMap->addForeignKey('AR_TELEPHONE_PREFIX_ID', 'ArTelephonePrefixId', 'int', CreoleTypes::INTEGER, 'ar_telephone_prefix', 'ID', false, null);

		$tMap->addColumn('CACHED_INTERNAL_TELEPHONE_NUMBER', 'CachedInternalTelephoneNumber', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CACHED_EXTERNAL_TELEPHONE_NUMBER', 'CachedExternalTelephoneNumber', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('EXTERNAL_TELEPHONE_NUMBER_WITH_APPLIED_PORTABILITY', 'ExternalTelephoneNumberWithAppliedPortability', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('CACHED_MASKED_EXTERNAL_TELEPHONE_NUMBER', 'CachedMaskedExternalTelephoneNumber', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('SOURCE_ID', 'SourceId', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('SOURCE_COST', 'SourceCost', 'int', CreoleTypes::INTEGER, false, 20);

		$tMap->addColumn('IS_EXPORTED', 'IsExported', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('SOURCE_DATA_TYPE', 'SourceDataType', 'string', CreoleTypes::VARCHAR, false, 255);

		$tMap->addColumn('SOURCE_DATA', 'SourceData', 'string', CreoleTypes::VARCHAR, false, 8000);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

	} 
} 