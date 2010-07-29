<?php



class ArInvoiceMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArInvoiceMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('ar_invoice');
		$tMap->setPhpName('ArInvoice');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('AR_PARTY_ID', 'ArPartyId', 'int', CreoleTypes::INTEGER, 'ar_party', 'ID', false, null);

		$tMap->addColumn('TYPE', 'Type', 'string', CreoleTypes::CHAR, true, 1);

		$tMap->addColumn('IS_REVENUE_SHARING', 'IsRevenueSharing', 'boolean', CreoleTypes::BOOLEAN, true, null);

		$tMap->addColumn('NR', 'Nr', 'string', CreoleTypes::VARCHAR, true, 20);

		$tMap->addColumn('INVOICE_DATE', 'InvoiceDate', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('AR_CDR_FROM', 'ArCdrFrom', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('AR_CDR_TO', 'ArCdrTo', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('TOTAL_WITHOUT_TAX', 'TotalWithoutTax', 'int', CreoleTypes::INTEGER, false, 20);

		$tMap->addColumn('VAT_PERC', 'VatPerc', 'int', CreoleTypes::INTEGER, false, 20);

		$tMap->addColumn('TOTAL_VAT', 'TotalVat', 'int', CreoleTypes::INTEGER, false, 20);

		$tMap->addColumn('TOTAL', 'Total', 'int', CreoleTypes::INTEGER, false, 20);

		$tMap->addColumn('HTML_DETAILS', 'HtmlDetails', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('PDF_INVOICE', 'PdfInvoice', 'string', CreoleTypes::BLOB, false, null);

		$tMap->addColumn('PDF_CALL_REPORT', 'PdfCallReport', 'string', CreoleTypes::BLOB, false, null);

		$tMap->addColumn('EMAIL_SUBJECT', 'EmailSubject', 'string', CreoleTypes::VARCHAR, false, 1024);

		$tMap->addColumn('EMAIL_MESSAGE', 'EmailMessage', 'string', CreoleTypes::LONGVARCHAR, false, null);

		$tMap->addColumn('ALREADY_SENT', 'AlreadySent', 'boolean', CreoleTypes::BOOLEAN, false, null);

	} 
} 