<?php


abstract class BaseArAsteriskAccountRangePeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'ar_asterisk_account_range';

	
	const CLASS_DEFAULT = 'lib.model.ArAsteriskAccountRange';

	
	const NUM_COLUMNS = 15;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'ar_asterisk_account_range.ID';

	
	const AR_OFFICE_ID = 'ar_asterisk_account_range.AR_OFFICE_ID';

	
	const SYSTEM_PREFIX = 'ar_asterisk_account_range.SYSTEM_PREFIX';

	
	const SYSTEM_SUFFIX = 'ar_asterisk_account_range.SYSTEM_SUFFIX';

	
	const SYSTEM_START_RANGE = 'ar_asterisk_account_range.SYSTEM_START_RANGE';

	
	const SYSTEM_END_RANGE = 'ar_asterisk_account_range.SYSTEM_END_RANGE';

	
	const SYSTEM_LEADING_ZERO = 'ar_asterisk_account_range.SYSTEM_LEADING_ZERO';

	
	const IS_DELETE = 'ar_asterisk_account_range.IS_DELETE';

	
	const IS_PHYSICAL_DELETE = 'ar_asterisk_account_range.IS_PHYSICAL_DELETE';

	
	const USER_PREFIX = 'ar_asterisk_account_range.USER_PREFIX';

	
	const USER_SUFFIX = 'ar_asterisk_account_range.USER_SUFFIX';

	
	const USER_START_RANGE = 'ar_asterisk_account_range.USER_START_RANGE';

	
	const GENERATE_RANGE_FOR_USERS = 'ar_asterisk_account_range.GENERATE_RANGE_FOR_USERS';

	
	const USER_LEADING_ZERO = 'ar_asterisk_account_range.USER_LEADING_ZERO';

	
	const USER_NOTE = 'ar_asterisk_account_range.USER_NOTE';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'ArOfficeId', 'SystemPrefix', 'SystemSuffix', 'SystemStartRange', 'SystemEndRange', 'SystemLeadingZero', 'IsDelete', 'IsPhysicalDelete', 'UserPrefix', 'UserSuffix', 'UserStartRange', 'GenerateRangeForUsers', 'UserLeadingZero', 'UserNote', ),
		BasePeer::TYPE_COLNAME => array (ArAsteriskAccountRangePeer::ID, ArAsteriskAccountRangePeer::AR_OFFICE_ID, ArAsteriskAccountRangePeer::SYSTEM_PREFIX, ArAsteriskAccountRangePeer::SYSTEM_SUFFIX, ArAsteriskAccountRangePeer::SYSTEM_START_RANGE, ArAsteriskAccountRangePeer::SYSTEM_END_RANGE, ArAsteriskAccountRangePeer::SYSTEM_LEADING_ZERO, ArAsteriskAccountRangePeer::IS_DELETE, ArAsteriskAccountRangePeer::IS_PHYSICAL_DELETE, ArAsteriskAccountRangePeer::USER_PREFIX, ArAsteriskAccountRangePeer::USER_SUFFIX, ArAsteriskAccountRangePeer::USER_START_RANGE, ArAsteriskAccountRangePeer::GENERATE_RANGE_FOR_USERS, ArAsteriskAccountRangePeer::USER_LEADING_ZERO, ArAsteriskAccountRangePeer::USER_NOTE, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'ar_office_id', 'system_prefix', 'system_suffix', 'system_start_range', 'system_end_range', 'system_leading_zero', 'is_delete', 'is_physical_delete', 'user_prefix', 'user_suffix', 'user_start_range', 'generate_range_for_users', 'user_leading_zero', 'user_note', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'ArOfficeId' => 1, 'SystemPrefix' => 2, 'SystemSuffix' => 3, 'SystemStartRange' => 4, 'SystemEndRange' => 5, 'SystemLeadingZero' => 6, 'IsDelete' => 7, 'IsPhysicalDelete' => 8, 'UserPrefix' => 9, 'UserSuffix' => 10, 'UserStartRange' => 11, 'GenerateRangeForUsers' => 12, 'UserLeadingZero' => 13, 'UserNote' => 14, ),
		BasePeer::TYPE_COLNAME => array (ArAsteriskAccountRangePeer::ID => 0, ArAsteriskAccountRangePeer::AR_OFFICE_ID => 1, ArAsteriskAccountRangePeer::SYSTEM_PREFIX => 2, ArAsteriskAccountRangePeer::SYSTEM_SUFFIX => 3, ArAsteriskAccountRangePeer::SYSTEM_START_RANGE => 4, ArAsteriskAccountRangePeer::SYSTEM_END_RANGE => 5, ArAsteriskAccountRangePeer::SYSTEM_LEADING_ZERO => 6, ArAsteriskAccountRangePeer::IS_DELETE => 7, ArAsteriskAccountRangePeer::IS_PHYSICAL_DELETE => 8, ArAsteriskAccountRangePeer::USER_PREFIX => 9, ArAsteriskAccountRangePeer::USER_SUFFIX => 10, ArAsteriskAccountRangePeer::USER_START_RANGE => 11, ArAsteriskAccountRangePeer::GENERATE_RANGE_FOR_USERS => 12, ArAsteriskAccountRangePeer::USER_LEADING_ZERO => 13, ArAsteriskAccountRangePeer::USER_NOTE => 14, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'ar_office_id' => 1, 'system_prefix' => 2, 'system_suffix' => 3, 'system_start_range' => 4, 'system_end_range' => 5, 'system_leading_zero' => 6, 'is_delete' => 7, 'is_physical_delete' => 8, 'user_prefix' => 9, 'user_suffix' => 10, 'user_start_range' => 11, 'generate_range_for_users' => 12, 'user_leading_zero' => 13, 'user_note' => 14, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/ArAsteriskAccountRangeMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.ArAsteriskAccountRangeMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = ArAsteriskAccountRangePeer::getTableMap();
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
		return str_replace(ArAsteriskAccountRangePeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(ArAsteriskAccountRangePeer::ID);

		$criteria->addSelectColumn(ArAsteriskAccountRangePeer::AR_OFFICE_ID);

		$criteria->addSelectColumn(ArAsteriskAccountRangePeer::SYSTEM_PREFIX);

		$criteria->addSelectColumn(ArAsteriskAccountRangePeer::SYSTEM_SUFFIX);

		$criteria->addSelectColumn(ArAsteriskAccountRangePeer::SYSTEM_START_RANGE);

		$criteria->addSelectColumn(ArAsteriskAccountRangePeer::SYSTEM_END_RANGE);

		$criteria->addSelectColumn(ArAsteriskAccountRangePeer::SYSTEM_LEADING_ZERO);

		$criteria->addSelectColumn(ArAsteriskAccountRangePeer::IS_DELETE);

		$criteria->addSelectColumn(ArAsteriskAccountRangePeer::IS_PHYSICAL_DELETE);

		$criteria->addSelectColumn(ArAsteriskAccountRangePeer::USER_PREFIX);

		$criteria->addSelectColumn(ArAsteriskAccountRangePeer::USER_SUFFIX);

		$criteria->addSelectColumn(ArAsteriskAccountRangePeer::USER_START_RANGE);

		$criteria->addSelectColumn(ArAsteriskAccountRangePeer::GENERATE_RANGE_FOR_USERS);

		$criteria->addSelectColumn(ArAsteriskAccountRangePeer::USER_LEADING_ZERO);

		$criteria->addSelectColumn(ArAsteriskAccountRangePeer::USER_NOTE);

	}

	const COUNT = 'COUNT(ar_asterisk_account_range.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT ar_asterisk_account_range.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArAsteriskAccountRangePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArAsteriskAccountRangePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ArAsteriskAccountRangePeer::doSelectRS($criteria, $con);
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
		$objects = ArAsteriskAccountRangePeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return ArAsteriskAccountRangePeer::populateObjects(ArAsteriskAccountRangePeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			ArAsteriskAccountRangePeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = ArAsteriskAccountRangePeer::getOMClass();
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
			$criteria->addSelectColumn(ArAsteriskAccountRangePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArAsteriskAccountRangePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArAsteriskAccountRangePeer::AR_OFFICE_ID, ArOfficePeer::ID);

		$rs = ArAsteriskAccountRangePeer::doSelectRS($criteria, $con);
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

		ArAsteriskAccountRangePeer::addSelectColumns($c);
		$startcol = (ArAsteriskAccountRangePeer::NUM_COLUMNS - ArAsteriskAccountRangePeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ArOfficePeer::addSelectColumns($c);

		$c->addJoin(ArAsteriskAccountRangePeer::AR_OFFICE_ID, ArOfficePeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArAsteriskAccountRangePeer::getOMClass();

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
										$temp_obj2->addArAsteriskAccountRange($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initArAsteriskAccountRanges();
				$obj2->addArAsteriskAccountRange($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArAsteriskAccountRangePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArAsteriskAccountRangePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArAsteriskAccountRangePeer::AR_OFFICE_ID, ArOfficePeer::ID);

		$rs = ArAsteriskAccountRangePeer::doSelectRS($criteria, $con);
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

		ArAsteriskAccountRangePeer::addSelectColumns($c);
		$startcol2 = (ArAsteriskAccountRangePeer::NUM_COLUMNS - ArAsteriskAccountRangePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ArOfficePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ArOfficePeer::NUM_COLUMNS;

		$c->addJoin(ArAsteriskAccountRangePeer::AR_OFFICE_ID, ArOfficePeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArAsteriskAccountRangePeer::getOMClass();


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
					$temp_obj2->addArAsteriskAccountRange($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initArAsteriskAccountRanges();
				$obj2->addArAsteriskAccountRange($obj1);
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
		return ArAsteriskAccountRangePeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(ArAsteriskAccountRangePeer::ID); 

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
			$comparison = $criteria->getComparison(ArAsteriskAccountRangePeer::ID);
			$selectCriteria->add(ArAsteriskAccountRangePeer::ID, $criteria->remove(ArAsteriskAccountRangePeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(ArAsteriskAccountRangePeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(ArAsteriskAccountRangePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof ArAsteriskAccountRange) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(ArAsteriskAccountRangePeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(ArAsteriskAccountRange $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ArAsteriskAccountRangePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ArAsteriskAccountRangePeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(ArAsteriskAccountRangePeer::DATABASE_NAME, ArAsteriskAccountRangePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = ArAsteriskAccountRangePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(ArAsteriskAccountRangePeer::DATABASE_NAME);

		$criteria->add(ArAsteriskAccountRangePeer::ID, $pk);


		$v = ArAsteriskAccountRangePeer::doSelect($criteria, $con);

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
			$criteria->add(ArAsteriskAccountRangePeer::ID, $pks, Criteria::IN);
			$objs = ArAsteriskAccountRangePeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseArAsteriskAccountRangePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/ArAsteriskAccountRangeMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.ArAsteriskAccountRangeMapBuilder');
}
