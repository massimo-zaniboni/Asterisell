<?php



class ArDocumentMapBuilder {

	
	const CLASS_NAME = 'lib.model.map.ArDocumentMapBuilder';

	
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

		$tMap = $this->dbMap->addTable('ar_document');
		$tMap->setPhpName('ArDocument');

		$tMap->setUseIdGenerator(true);

		$tMap->addPrimaryKey('ID', 'Id', 'int', CreoleTypes::INTEGER, true, null);

		$tMap->addForeignKey('AR_PARTY_ID', 'ArPartyId', 'int', CreoleTypes::INTEGER, 'ar_party', 'ID', false, null);

		$tMap->addColumn('DOCUMENT_NAME', 'DocumentName', 'string', CreoleTypes::VARCHAR, false, 128);

		$tMap->addColumn('DOCUMENT_DATE', 'DocumentDate', 'int', CreoleTypes::DATE, false, null);

		$tMap->addColumn('DOCUMENT', 'Document', 'string', CreoleTypes::BLOB, false, null);

		$tMap->addColumn('FILE_NAME', 'FileName', 'string', CreoleTypes::VARCHAR, false, 128);

		$tMap->addColumn('MIME_TYPE', 'MimeType', 'string', CreoleTypes::VARCHAR, false, 256);

		$tMap->addColumn('ALREADY_OPENED', 'AlreadyOpened', 'boolean', CreoleTypes::BOOLEAN, true, null);

	} 
} 