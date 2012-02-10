<?php


abstract class BaseArDocumentPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'ar_document';

	
	const CLASS_DEFAULT = 'lib.model.ArDocument';

	
	const NUM_COLUMNS = 8;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'ar_document.ID';

	
	const AR_PARTY_ID = 'ar_document.AR_PARTY_ID';

	
	const DOCUMENT_NAME = 'ar_document.DOCUMENT_NAME';

	
	const DOCUMENT_DATE = 'ar_document.DOCUMENT_DATE';

	
	const DOCUMENT = 'ar_document.DOCUMENT';

	
	const FILE_NAME = 'ar_document.FILE_NAME';

	
	const MIME_TYPE = 'ar_document.MIME_TYPE';

	
	const ALREADY_OPENED = 'ar_document.ALREADY_OPENED';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'ArPartyId', 'DocumentName', 'DocumentDate', 'Document', 'FileName', 'MimeType', 'AlreadyOpened', ),
		BasePeer::TYPE_COLNAME => array (ArDocumentPeer::ID, ArDocumentPeer::AR_PARTY_ID, ArDocumentPeer::DOCUMENT_NAME, ArDocumentPeer::DOCUMENT_DATE, ArDocumentPeer::DOCUMENT, ArDocumentPeer::FILE_NAME, ArDocumentPeer::MIME_TYPE, ArDocumentPeer::ALREADY_OPENED, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'ar_party_id', 'document_name', 'document_date', 'document', 'file_name', 'mime_type', 'already_opened', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'ArPartyId' => 1, 'DocumentName' => 2, 'DocumentDate' => 3, 'Document' => 4, 'FileName' => 5, 'MimeType' => 6, 'AlreadyOpened' => 7, ),
		BasePeer::TYPE_COLNAME => array (ArDocumentPeer::ID => 0, ArDocumentPeer::AR_PARTY_ID => 1, ArDocumentPeer::DOCUMENT_NAME => 2, ArDocumentPeer::DOCUMENT_DATE => 3, ArDocumentPeer::DOCUMENT => 4, ArDocumentPeer::FILE_NAME => 5, ArDocumentPeer::MIME_TYPE => 6, ArDocumentPeer::ALREADY_OPENED => 7, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'ar_party_id' => 1, 'document_name' => 2, 'document_date' => 3, 'document' => 4, 'file_name' => 5, 'mime_type' => 6, 'already_opened' => 7, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/ArDocumentMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.ArDocumentMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = ArDocumentPeer::getTableMap();
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
		return str_replace(ArDocumentPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(ArDocumentPeer::ID);

		$criteria->addSelectColumn(ArDocumentPeer::AR_PARTY_ID);

		$criteria->addSelectColumn(ArDocumentPeer::DOCUMENT_NAME);

		$criteria->addSelectColumn(ArDocumentPeer::DOCUMENT_DATE);

		$criteria->addSelectColumn(ArDocumentPeer::DOCUMENT);

		$criteria->addSelectColumn(ArDocumentPeer::FILE_NAME);

		$criteria->addSelectColumn(ArDocumentPeer::MIME_TYPE);

		$criteria->addSelectColumn(ArDocumentPeer::ALREADY_OPENED);

	}

	const COUNT = 'COUNT(ar_document.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT ar_document.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArDocumentPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArDocumentPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ArDocumentPeer::doSelectRS($criteria, $con);
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
		$objects = ArDocumentPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return ArDocumentPeer::populateObjects(ArDocumentPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			ArDocumentPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = ArDocumentPeer::getOMClass();
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
			$criteria->addSelectColumn(ArDocumentPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArDocumentPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArDocumentPeer::AR_PARTY_ID, ArPartyPeer::ID);

		$rs = ArDocumentPeer::doSelectRS($criteria, $con);
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

		ArDocumentPeer::addSelectColumns($c);
		$startcol = (ArDocumentPeer::NUM_COLUMNS - ArDocumentPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ArPartyPeer::addSelectColumns($c);

		$c->addJoin(ArDocumentPeer::AR_PARTY_ID, ArPartyPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArDocumentPeer::getOMClass();

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
										$temp_obj2->addArDocument($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initArDocuments();
				$obj2->addArDocument($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArDocumentPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArDocumentPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArDocumentPeer::AR_PARTY_ID, ArPartyPeer::ID);

		$rs = ArDocumentPeer::doSelectRS($criteria, $con);
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

		ArDocumentPeer::addSelectColumns($c);
		$startcol2 = (ArDocumentPeer::NUM_COLUMNS - ArDocumentPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ArPartyPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ArPartyPeer::NUM_COLUMNS;

		$c->addJoin(ArDocumentPeer::AR_PARTY_ID, ArPartyPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArDocumentPeer::getOMClass();


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
					$temp_obj2->addArDocument($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initArDocuments();
				$obj2->addArDocument($obj1);
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
		return ArDocumentPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(ArDocumentPeer::ID); 

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
			$comparison = $criteria->getComparison(ArDocumentPeer::ID);
			$selectCriteria->add(ArDocumentPeer::ID, $criteria->remove(ArDocumentPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(ArDocumentPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(ArDocumentPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof ArDocument) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(ArDocumentPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(ArDocument $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ArDocumentPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ArDocumentPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(ArDocumentPeer::DATABASE_NAME, ArDocumentPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = ArDocumentPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(ArDocumentPeer::DATABASE_NAME);

		$criteria->add(ArDocumentPeer::ID, $pk);


		$v = ArDocumentPeer::doSelect($criteria, $con);

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
			$criteria->add(ArDocumentPeer::ID, $pks, Criteria::IN);
			$objs = ArDocumentPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseArDocumentPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/ArDocumentMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.ArDocumentMapBuilder');
}
