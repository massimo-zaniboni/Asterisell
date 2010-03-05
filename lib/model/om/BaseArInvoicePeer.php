<?php


abstract class BaseArInvoicePeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'ar_invoice';

	
	const CLASS_DEFAULT = 'lib.model.ArInvoice';

	
	const NUM_COLUMNS = 14;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'ar_invoice.ID';

	
	const AR_PARTY_ID = 'ar_invoice.AR_PARTY_ID';

	
	const NR = 'ar_invoice.NR';

	
	const INVOICE_DATE = 'ar_invoice.INVOICE_DATE';

	
	const AR_CDR_FROM = 'ar_invoice.AR_CDR_FROM';

	
	const AR_CDR_TO = 'ar_invoice.AR_CDR_TO';

	
	const TOTAL_WITHOUT_TAX = 'ar_invoice.TOTAL_WITHOUT_TAX';

	
	const VAT_PERC = 'ar_invoice.VAT_PERC';

	
	const TOTAL_VAT = 'ar_invoice.TOTAL_VAT';

	
	const TOTAL = 'ar_invoice.TOTAL';

	
	const HTML_DETAILS = 'ar_invoice.HTML_DETAILS';

	
	const TXT_DETAILS = 'ar_invoice.TXT_DETAILS';

	
	const PDF_INVOICE = 'ar_invoice.PDF_INVOICE';

	
	const ALREADY_SENT = 'ar_invoice.ALREADY_SENT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'ArPartyId', 'Nr', 'InvoiceDate', 'ArCdrFrom', 'ArCdrTo', 'TotalWithoutTax', 'VatPerc', 'TotalVat', 'Total', 'HtmlDetails', 'TxtDetails', 'PdfInvoice', 'AlreadySent', ),
		BasePeer::TYPE_COLNAME => array (ArInvoicePeer::ID, ArInvoicePeer::AR_PARTY_ID, ArInvoicePeer::NR, ArInvoicePeer::INVOICE_DATE, ArInvoicePeer::AR_CDR_FROM, ArInvoicePeer::AR_CDR_TO, ArInvoicePeer::TOTAL_WITHOUT_TAX, ArInvoicePeer::VAT_PERC, ArInvoicePeer::TOTAL_VAT, ArInvoicePeer::TOTAL, ArInvoicePeer::HTML_DETAILS, ArInvoicePeer::TXT_DETAILS, ArInvoicePeer::PDF_INVOICE, ArInvoicePeer::ALREADY_SENT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'ar_party_id', 'nr', 'invoice_date', 'ar_cdr_from', 'ar_cdr_to', 'total_without_tax', 'vat_perc', 'total_vat', 'total', 'html_details', 'txt_details', 'pdf_invoice', 'already_sent', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'ArPartyId' => 1, 'Nr' => 2, 'InvoiceDate' => 3, 'ArCdrFrom' => 4, 'ArCdrTo' => 5, 'TotalWithoutTax' => 6, 'VatPerc' => 7, 'TotalVat' => 8, 'Total' => 9, 'HtmlDetails' => 10, 'TxtDetails' => 11, 'PdfInvoice' => 12, 'AlreadySent' => 13, ),
		BasePeer::TYPE_COLNAME => array (ArInvoicePeer::ID => 0, ArInvoicePeer::AR_PARTY_ID => 1, ArInvoicePeer::NR => 2, ArInvoicePeer::INVOICE_DATE => 3, ArInvoicePeer::AR_CDR_FROM => 4, ArInvoicePeer::AR_CDR_TO => 5, ArInvoicePeer::TOTAL_WITHOUT_TAX => 6, ArInvoicePeer::VAT_PERC => 7, ArInvoicePeer::TOTAL_VAT => 8, ArInvoicePeer::TOTAL => 9, ArInvoicePeer::HTML_DETAILS => 10, ArInvoicePeer::TXT_DETAILS => 11, ArInvoicePeer::PDF_INVOICE => 12, ArInvoicePeer::ALREADY_SENT => 13, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'ar_party_id' => 1, 'nr' => 2, 'invoice_date' => 3, 'ar_cdr_from' => 4, 'ar_cdr_to' => 5, 'total_without_tax' => 6, 'vat_perc' => 7, 'total_vat' => 8, 'total' => 9, 'html_details' => 10, 'txt_details' => 11, 'pdf_invoice' => 12, 'already_sent' => 13, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/ArInvoiceMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.ArInvoiceMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = ArInvoicePeer::getTableMap();
			$columns = $map->getColumns();
			$nameMap = array();
			foreach ($columns as $column) {
				$nameMap[$column->getPhpName()] = $column->getColumnName();
			}
			self::$phpNameMap = $nameMap;
		}
		return self::$phpNameMap;
	}
	
	static public function translateFieldName($name, $fromType, $toType)
	{
		$toNames = self::getFieldNames($toType);
		$key = isset(self::$fieldKeys[$fromType][$name]) ? self::$fieldKeys[$fromType][$name] : null;
		if ($key === null) {
			throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(self::$fieldKeys[$fromType], true));
		}
		return $toNames[$key];
	}

	

	static public function getFieldNames($type = BasePeer::TYPE_PHPNAME)
	{
		if (!array_key_exists($type, self::$fieldNames)) {
			throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants TYPE_PHPNAME, TYPE_COLNAME, TYPE_FIELDNAME, TYPE_NUM. ' . $type . ' was given.');
		}
		return self::$fieldNames[$type];
	}

	
	public static function alias($alias, $column)
	{
		return str_replace(ArInvoicePeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(ArInvoicePeer::ID);

		$criteria->addSelectColumn(ArInvoicePeer::AR_PARTY_ID);

		$criteria->addSelectColumn(ArInvoicePeer::NR);

		$criteria->addSelectColumn(ArInvoicePeer::INVOICE_DATE);

		$criteria->addSelectColumn(ArInvoicePeer::AR_CDR_FROM);

		$criteria->addSelectColumn(ArInvoicePeer::AR_CDR_TO);

		$criteria->addSelectColumn(ArInvoicePeer::TOTAL_WITHOUT_TAX);

		$criteria->addSelectColumn(ArInvoicePeer::VAT_PERC);

		$criteria->addSelectColumn(ArInvoicePeer::TOTAL_VAT);

		$criteria->addSelectColumn(ArInvoicePeer::TOTAL);

		$criteria->addSelectColumn(ArInvoicePeer::HTML_DETAILS);

		$criteria->addSelectColumn(ArInvoicePeer::TXT_DETAILS);

		$criteria->addSelectColumn(ArInvoicePeer::PDF_INVOICE);

		$criteria->addSelectColumn(ArInvoicePeer::ALREADY_SENT);

	}

	const COUNT = 'COUNT(ar_invoice.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT ar_invoice.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArInvoicePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArInvoicePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ArInvoicePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}
	
	public static function doSelectOne(Criteria $criteria, $con = null)
	{
		$critcopy = clone $criteria;
		$critcopy->setLimit(1);
		$objects = ArInvoicePeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return ArInvoicePeer::populateObjects(ArInvoicePeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			ArInvoicePeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = ArInvoicePeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinArParty(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArInvoicePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArInvoicePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArInvoicePeer::AR_PARTY_ID, ArPartyPeer::ID);

		$rs = ArInvoicePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinArParty(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ArInvoicePeer::addSelectColumns($c);
		$startcol = (ArInvoicePeer::NUM_COLUMNS - ArInvoicePeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ArPartyPeer::addSelectColumns($c);

		$c->addJoin(ArInvoicePeer::AR_PARTY_ID, ArPartyPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArInvoicePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ArPartyPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getArParty(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addArInvoice($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initArInvoices();
				$obj2->addArInvoice($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArInvoicePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArInvoicePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArInvoicePeer::AR_PARTY_ID, ArPartyPeer::ID);

		$rs = ArInvoicePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAll(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ArInvoicePeer::addSelectColumns($c);
		$startcol2 = (ArInvoicePeer::NUM_COLUMNS - ArInvoicePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ArPartyPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ArPartyPeer::NUM_COLUMNS;

		$c->addJoin(ArInvoicePeer::AR_PARTY_ID, ArPartyPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArInvoicePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = ArPartyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getArParty(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addArInvoice($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initArInvoices();
				$obj2->addArInvoice($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}

	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return ArInvoicePeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(ArInvoicePeer::ID); 

				$criteria->setDbName(self::DATABASE_NAME);

		try {
									$con->begin();
			$pk = BasePeer::doInsert($criteria, $con);
			$con->commit();
		} catch(PropelException $e) {
			$con->rollback();
			throw $e;
		}

		return $pk;
	}

	
	public static function doUpdate($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$selectCriteria = new Criteria(self::DATABASE_NAME);

		if ($values instanceof Criteria) {
			$criteria = clone $values; 
			$comparison = $criteria->getComparison(ArInvoicePeer::ID);
			$selectCriteria->add(ArInvoicePeer::ID, $criteria->remove(ArInvoicePeer::ID), $comparison);

		} else { 			$criteria = $values->buildCriteria(); 			$selectCriteria = $values->buildPkeyCriteria(); 		}

				$criteria->setDbName(self::DATABASE_NAME);

		return BasePeer::doUpdate($selectCriteria, $criteria, $con);
	}

	
	public static function doDeleteAll($con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}
		$affectedRows = 0; 		try {
									$con->begin();
			$affectedRows += BasePeer::doDeleteAll(ArInvoicePeer::TABLE_NAME, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	 public static function doDelete($values, $con = null)
	 {
		if ($con === null) {
			$con = Propel::getConnection(ArInvoicePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof ArInvoice) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(ArInvoicePeer::ID, (array) $values, Criteria::IN);
		}

				$criteria->setDbName(self::DATABASE_NAME);

		$affectedRows = 0; 
		try {
									$con->begin();
			
			$affectedRows += BasePeer::doDelete($criteria, $con);
			$con->commit();
			return $affectedRows;
		} catch (PropelException $e) {
			$con->rollback();
			throw $e;
		}
	}

	
	public static function doValidate(ArInvoice $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ArInvoicePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ArInvoicePeer::TABLE_NAME);

			if (! is_array($cols)) {
				$cols = array($cols);
			}

			foreach($cols as $colName) {
				if ($tableMap->containsColumn($colName)) {
					$get = 'get' . $tableMap->getColumn($colName)->getPhpName();
					$columns[$colName] = $obj->$get();
				}
			}
		} else {

		}

		$res =  BasePeer::doValidate(ArInvoicePeer::DATABASE_NAME, ArInvoicePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = ArInvoicePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
            $request->setError($col, $failed->getMessage());
        }
    }

    return $res;
	}

	
	public static function retrieveByPK($pk, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$criteria = new Criteria(ArInvoicePeer::DATABASE_NAME);

		$criteria->add(ArInvoicePeer::ID, $pk);


		$v = ArInvoicePeer::doSelect($criteria, $con);

		return !empty($v) > 0 ? $v[0] : null;
	}

	
	public static function retrieveByPKs($pks, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		$objs = null;
		if (empty($pks)) {
			$objs = array();
		} else {
			$criteria = new Criteria();
			$criteria->add(ArInvoicePeer::ID, $pks, Criteria::IN);
			$objs = ArInvoicePeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseArInvoicePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/ArInvoiceMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.ArInvoiceMapBuilder');
}
