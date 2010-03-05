<?php


abstract class BaseArFromNumberToEndPointTypePeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'ar_from_number_to_end_point_type';

	
	const CLASS_DEFAULT = 'lib.model.ArFromNumberToEndPointType';

	
	const NUM_COLUMNS = 3;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const NUMBER_PREFIX = 'ar_from_number_to_end_point_type.NUMBER_PREFIX';

	
	const AR_CALL_END_POINT_TYPE_ID = 'ar_from_number_to_end_point_type.AR_CALL_END_POINT_TYPE_ID';

	
	const ID = 'ar_from_number_to_end_point_type.ID';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('NumberPrefix', 'ArCallEndPointTypeId', 'Id', ),
		BasePeer::TYPE_COLNAME => array (ArFromNumberToEndPointTypePeer::NUMBER_PREFIX, ArFromNumberToEndPointTypePeer::AR_CALL_END_POINT_TYPE_ID, ArFromNumberToEndPointTypePeer::ID, ),
		BasePeer::TYPE_FIELDNAME => array ('number_prefix', 'ar_call_end_point_type_id', 'id', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('NumberPrefix' => 0, 'ArCallEndPointTypeId' => 1, 'Id' => 2, ),
		BasePeer::TYPE_COLNAME => array (ArFromNumberToEndPointTypePeer::NUMBER_PREFIX => 0, ArFromNumberToEndPointTypePeer::AR_CALL_END_POINT_TYPE_ID => 1, ArFromNumberToEndPointTypePeer::ID => 2, ),
		BasePeer::TYPE_FIELDNAME => array ('number_prefix' => 0, 'ar_call_end_point_type_id' => 1, 'id' => 2, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/ArFromNumberToEndPointTypeMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.ArFromNumberToEndPointTypeMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = ArFromNumberToEndPointTypePeer::getTableMap();
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
		return str_replace(ArFromNumberToEndPointTypePeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(ArFromNumberToEndPointTypePeer::NUMBER_PREFIX);

		$criteria->addSelectColumn(ArFromNumberToEndPointTypePeer::AR_CALL_END_POINT_TYPE_ID);

		$criteria->addSelectColumn(ArFromNumberToEndPointTypePeer::ID);

	}

	const COUNT = 'COUNT(ar_from_number_to_end_point_type.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT ar_from_number_to_end_point_type.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArFromNumberToEndPointTypePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArFromNumberToEndPointTypePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ArFromNumberToEndPointTypePeer::doSelectRS($criteria, $con);
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
		$objects = ArFromNumberToEndPointTypePeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return ArFromNumberToEndPointTypePeer::populateObjects(ArFromNumberToEndPointTypePeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			ArFromNumberToEndPointTypePeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = ArFromNumberToEndPointTypePeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinArCallEndPointType(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArFromNumberToEndPointTypePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArFromNumberToEndPointTypePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArFromNumberToEndPointTypePeer::AR_CALL_END_POINT_TYPE_ID, ArCallEndPointTypePeer::ID);

		$rs = ArFromNumberToEndPointTypePeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinArCallEndPointType(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ArFromNumberToEndPointTypePeer::addSelectColumns($c);
		$startcol = (ArFromNumberToEndPointTypePeer::NUM_COLUMNS - ArFromNumberToEndPointTypePeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ArCallEndPointTypePeer::addSelectColumns($c);

		$c->addJoin(ArFromNumberToEndPointTypePeer::AR_CALL_END_POINT_TYPE_ID, ArCallEndPointTypePeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArFromNumberToEndPointTypePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ArCallEndPointTypePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getArCallEndPointType(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addArFromNumberToEndPointType($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initArFromNumberToEndPointTypes();
				$obj2->addArFromNumberToEndPointType($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArFromNumberToEndPointTypePeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArFromNumberToEndPointTypePeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArFromNumberToEndPointTypePeer::AR_CALL_END_POINT_TYPE_ID, ArCallEndPointTypePeer::ID);

		$rs = ArFromNumberToEndPointTypePeer::doSelectRS($criteria, $con);
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

		ArFromNumberToEndPointTypePeer::addSelectColumns($c);
		$startcol2 = (ArFromNumberToEndPointTypePeer::NUM_COLUMNS - ArFromNumberToEndPointTypePeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ArCallEndPointTypePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ArCallEndPointTypePeer::NUM_COLUMNS;

		$c->addJoin(ArFromNumberToEndPointTypePeer::AR_CALL_END_POINT_TYPE_ID, ArCallEndPointTypePeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArFromNumberToEndPointTypePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = ArCallEndPointTypePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getArCallEndPointType(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addArFromNumberToEndPointType($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initArFromNumberToEndPointTypes();
				$obj2->addArFromNumberToEndPointType($obj1);
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
		return ArFromNumberToEndPointTypePeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(ArFromNumberToEndPointTypePeer::ID); 

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
			$comparison = $criteria->getComparison(ArFromNumberToEndPointTypePeer::ID);
			$selectCriteria->add(ArFromNumberToEndPointTypePeer::ID, $criteria->remove(ArFromNumberToEndPointTypePeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(ArFromNumberToEndPointTypePeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(ArFromNumberToEndPointTypePeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof ArFromNumberToEndPointType) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(ArFromNumberToEndPointTypePeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(ArFromNumberToEndPointType $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ArFromNumberToEndPointTypePeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ArFromNumberToEndPointTypePeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(ArFromNumberToEndPointTypePeer::DATABASE_NAME, ArFromNumberToEndPointTypePeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = ArFromNumberToEndPointTypePeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(ArFromNumberToEndPointTypePeer::DATABASE_NAME);

		$criteria->add(ArFromNumberToEndPointTypePeer::ID, $pk);


		$v = ArFromNumberToEndPointTypePeer::doSelect($criteria, $con);

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
			$criteria->add(ArFromNumberToEndPointTypePeer::ID, $pks, Criteria::IN);
			$objs = ArFromNumberToEndPointTypePeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseArFromNumberToEndPointTypePeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/ArFromNumberToEndPointTypeMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.ArFromNumberToEndPointTypeMapBuilder');
}
