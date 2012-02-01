<?php


abstract class BaseArAsteriskAccountRangeCreationPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'ar_asterisk_account_range_creation';

	
	const CLASS_DEFAULT = 'lib.model.ArAsteriskAccountRangeCreation';

	
	const NUM_COLUMNS = 10;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'ar_asterisk_account_range_creation.ID';

	
	const AR_OFFICE_ID = 'ar_asterisk_account_range_creation.AR_OFFICE_ID';

	
	const PREFIX = 'ar_asterisk_account_range_creation.PREFIX';

	
	const SUFFIX = 'ar_asterisk_account_range_creation.SUFFIX';

	
	const START_RANGE = 'ar_asterisk_account_range_creation.START_RANGE';

	
	const END_RANGE = 'ar_asterisk_account_range_creation.END_RANGE';

	
	const LEADING_ZERO = 'ar_asterisk_account_range_creation.LEADING_ZERO';

	
	const IS_DELETE = 'ar_asterisk_account_range_creation.IS_DELETE';

	
	const IS_PHYSICAL_DELETE = 'ar_asterisk_account_range_creation.IS_PHYSICAL_DELETE';

	
	const USER_NOTE = 'ar_asterisk_account_range_creation.USER_NOTE';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'ArOfficeId', 'Prefix', 'Suffix', 'StartRange', 'EndRange', 'LeadingZero', 'IsDelete', 'IsPhysicalDelete', 'UserNote', ),
		BasePeer::TYPE_COLNAME => array (ArAsteriskAccountRangeCreationPeer::ID, ArAsteriskAccountRangeCreationPeer::AR_OFFICE_ID, ArAsteriskAccountRangeCreationPeer::PREFIX, ArAsteriskAccountRangeCreationPeer::SUFFIX, ArAsteriskAccountRangeCreationPeer::START_RANGE, ArAsteriskAccountRangeCreationPeer::END_RANGE, ArAsteriskAccountRangeCreationPeer::LEADING_ZERO, ArAsteriskAccountRangeCreationPeer::IS_DELETE, ArAsteriskAccountRangeCreationPeer::IS_PHYSICAL_DELETE, ArAsteriskAccountRangeCreationPeer::USER_NOTE, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'ar_office_id', 'prefix', 'suffix', 'start_range', 'end_range', 'leading_zero', 'is_delete', 'is_physical_delete', 'user_note', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'ArOfficeId' => 1, 'Prefix' => 2, 'Suffix' => 3, 'StartRange' => 4, 'EndRange' => 5, 'LeadingZero' => 6, 'IsDelete' => 7, 'IsPhysicalDelete' => 8, 'UserNote' => 9, ),
		BasePeer::TYPE_COLNAME => array (ArAsteriskAccountRangeCreationPeer::ID => 0, ArAsteriskAccountRangeCreationPeer::AR_OFFICE_ID => 1, ArAsteriskAccountRangeCreationPeer::PREFIX => 2, ArAsteriskAccountRangeCreationPeer::SUFFIX => 3, ArAsteriskAccountRangeCreationPeer::START_RANGE => 4, ArAsteriskAccountRangeCreationPeer::END_RANGE => 5, ArAsteriskAccountRangeCreationPeer::LEADING_ZERO => 6, ArAsteriskAccountRangeCreationPeer::IS_DELETE => 7, ArAsteriskAccountRangeCreationPeer::IS_PHYSICAL_DELETE => 8, ArAsteriskAccountRangeCreationPeer::USER_NOTE => 9, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'ar_office_id' => 1, 'prefix' => 2, 'suffix' => 3, 'start_range' => 4, 'end_range' => 5, 'leading_zero' => 6, 'is_delete' => 7, 'is_physical_delete' => 8, 'user_note' => 9, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/ArAsteriskAccountRangeCreationMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.ArAsteriskAccountRangeCreationMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = ArAsteriskAccountRangeCreationPeer::getTableMap();
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
		return str_replace(ArAsteriskAccountRangeCreationPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(ArAsteriskAccountRangeCreationPeer::ID);

		$criteria->addSelectColumn(ArAsteriskAccountRangeCreationPeer::AR_OFFICE_ID);

		$criteria->addSelectColumn(ArAsteriskAccountRangeCreationPeer::PREFIX);

		$criteria->addSelectColumn(ArAsteriskAccountRangeCreationPeer::SUFFIX);

		$criteria->addSelectColumn(ArAsteriskAccountRangeCreationPeer::START_RANGE);

		$criteria->addSelectColumn(ArAsteriskAccountRangeCreationPeer::END_RANGE);

		$criteria->addSelectColumn(ArAsteriskAccountRangeCreationPeer::LEADING_ZERO);

		$criteria->addSelectColumn(ArAsteriskAccountRangeCreationPeer::IS_DELETE);

		$criteria->addSelectColumn(ArAsteriskAccountRangeCreationPeer::IS_PHYSICAL_DELETE);

		$criteria->addSelectColumn(ArAsteriskAccountRangeCreationPeer::USER_NOTE);

	}

	const COUNT = 'COUNT(ar_asterisk_account_range_creation.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT ar_asterisk_account_range_creation.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArAsteriskAccountRangeCreationPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArAsteriskAccountRangeCreationPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ArAsteriskAccountRangeCreationPeer::doSelectRS($criteria, $con);
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
		$objects = ArAsteriskAccountRangeCreationPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return ArAsteriskAccountRangeCreationPeer::populateObjects(ArAsteriskAccountRangeCreationPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			ArAsteriskAccountRangeCreationPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = ArAsteriskAccountRangeCreationPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinArOffice(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArAsteriskAccountRangeCreationPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArAsteriskAccountRangeCreationPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArAsteriskAccountRangeCreationPeer::AR_OFFICE_ID, ArOfficePeer::ID);

		$rs = ArAsteriskAccountRangeCreationPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinArOffice(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ArAsteriskAccountRangeCreationPeer::addSelectColumns($c);
		$startcol = (ArAsteriskAccountRangeCreationPeer::NUM_COLUMNS - ArAsteriskAccountRangeCreationPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ArOfficePeer::addSelectColumns($c);

		$c->addJoin(ArAsteriskAccountRangeCreationPeer::AR_OFFICE_ID, ArOfficePeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArAsteriskAccountRangeCreationPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ArOfficePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getArOffice(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addArAsteriskAccountRangeCreation($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initArAsteriskAccountRangeCreations();
				$obj2->addArAsteriskAccountRangeCreation($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArAsteriskAccountRangeCreationPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArAsteriskAccountRangeCreationPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArAsteriskAccountRangeCreationPeer::AR_OFFICE_ID, ArOfficePeer::ID);

		$rs = ArAsteriskAccountRangeCreationPeer::doSelectRS($criteria, $con);
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

		ArAsteriskAccountRangeCreationPeer::addSelectColumns($c);
		$startcol2 = (ArAsteriskAccountRangeCreationPeer::NUM_COLUMNS - ArAsteriskAccountRangeCreationPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ArOfficePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ArOfficePeer::NUM_COLUMNS;

		$c->addJoin(ArAsteriskAccountRangeCreationPeer::AR_OFFICE_ID, ArOfficePeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArAsteriskAccountRangeCreationPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = ArOfficePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getArOffice(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addArAsteriskAccountRangeCreation($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initArAsteriskAccountRangeCreations();
				$obj2->addArAsteriskAccountRangeCreation($obj1);
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
		return ArAsteriskAccountRangeCreationPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(ArAsteriskAccountRangeCreationPeer::ID); 

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
			$comparison = $criteria->getComparison(ArAsteriskAccountRangeCreationPeer::ID);
			$selectCriteria->add(ArAsteriskAccountRangeCreationPeer::ID, $criteria->remove(ArAsteriskAccountRangeCreationPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(ArAsteriskAccountRangeCreationPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(ArAsteriskAccountRangeCreationPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof ArAsteriskAccountRangeCreation) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(ArAsteriskAccountRangeCreationPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(ArAsteriskAccountRangeCreation $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ArAsteriskAccountRangeCreationPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ArAsteriskAccountRangeCreationPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(ArAsteriskAccountRangeCreationPeer::DATABASE_NAME, ArAsteriskAccountRangeCreationPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = ArAsteriskAccountRangeCreationPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(ArAsteriskAccountRangeCreationPeer::DATABASE_NAME);

		$criteria->add(ArAsteriskAccountRangeCreationPeer::ID, $pk);


		$v = ArAsteriskAccountRangeCreationPeer::doSelect($criteria, $con);

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
			$criteria->add(ArAsteriskAccountRangeCreationPeer::ID, $pks, Criteria::IN);
			$objs = ArAsteriskAccountRangeCreationPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseArAsteriskAccountRangeCreationPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/ArAsteriskAccountRangeCreationMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.ArAsteriskAccountRangeCreationMapBuilder');
}
