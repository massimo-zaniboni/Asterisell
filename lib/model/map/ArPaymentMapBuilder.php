<?php



class ArPaymentMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArPaymentMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('ar_payment');
		$tMap->setPhpName('ArPayment');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('AR_PARTY_ID', 'ArPartyId', 'int', CreoleTypes::INTEGER, 'ar_party', 'ID', false, null);

		$tMap->addColumn('DATE', 'Date', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('INVOICE_NR', 'InvoiceNr', 'string', CreoleTypes::VARCHAR, false, 20);

		$tMap->addColumn('PAYMENT_METHOD', 'PaymentMethod', 'string', CreoleTypes::VARCHAR, false, 1024);

		$tMap->addColumn('PAYMENT_REFERENCES', 'PaymentReferences', 'string', CreoleTypes::VARCHAR, false, 1024);

		$tMap->addColumn('AMOUNT', 'Amount', 'int', CreoleTypes::INTEGER, true, 20);

		$tMap->addColumn('NOTE', 'Note', 'string', CreoleTypes::LONGVARCHAR, false, null);

	} 
} 