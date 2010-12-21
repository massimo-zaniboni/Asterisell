<?php


abstract class BaseArRateIncrementalInfoPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'ar_rate_incremental_info';

	
	const CLASS_DEFAULT = 'lib.model.ArRateIncrementalInfo';

	
	const NUM_COLUMNS = 7;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'ar_rate_incremental_info.ID';

	
	const AR_PARTY_ID = 'ar_rate_incremental_info.AR_PARTY_ID';

	
	const AR_RATE_ID = 'ar_rate_incremental_info.AR_RATE_ID';

	
	const PERIOD = 'ar_rate_incremental_info.PERIOD';

	
	const LAST_PROCESSED_CDR_DATE = 'ar_rate_incremental_info.LAST_PROCESSED_CDR_DATE';

	
	const LAST_PROCESSED_CDR_ID = 'ar_rate_incremental_info.LAST_PROCESSED_CDR_ID';

	
	const BUNDLE_RATE = 'ar_rate_incremental_info.BUNDLE_RATE';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'ArPartyId', 'ArRateId', 'Period', 'LastProcessedCdrDate', 'LastProcessedCdrId', 'BundleRate', ),
		BasePeer::TYPE_COLNAME => array (ArRateIncrementalInfoPeer::ID, ArRateIncrementalInfoPeer::AR_PARTY_ID, ArRateIncrementalInfoPeer::AR_RATE_ID, ArRateIncrementalInfoPeer::PERIOD, ArRateIncrementalInfoPeer::LAST_PROCESSED_CDR_DATE, ArRateIncrementalInfoPeer::LAST_PROCESSED_CDR_ID, ArRateIncrementalInfoPeer::BUNDLE_RATE, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'ar_party_id', 'ar_rate_id', 'period', 'last_processed_cdr_date', 'last_processed_cdr_id', 'bundle_rate', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'ArPartyId' => 1, 'ArRateId' => 2, 'Period' => 3, 'LastProcessedCdrDate' => 4, 'LastProcessedCdrId' => 5, 'BundleRate' => 6, ),
		BasePeer::TYPE_COLNAME => array (ArRateIncrementalInfoPeer::ID => 0, ArRateIncrementalInfoPeer::AR_PARTY_ID => 1, ArRateIncrementalInfoPeer::AR_RATE_ID => 2, ArRateIncrementalInfoPeer::PERIOD => 3, ArRateIncrementalInfoPeer::LAST_PROCESSED_CDR_DATE => 4, ArRateIncrementalInfoPeer::LAST_PROCESSED_CDR_ID => 5, ArRateIncrementalInfoPeer::BUNDLE_RATE => 6, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'ar_party_id' => 1, 'ar_rate_id' => 2, 'period' => 3, 'last_processed_cdr_date' => 4, 'last_processed_cdr_id' => 5, 'bundle_rate' => 6, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/ArRateIncrementalInfoMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.ArRateIncrementalInfoMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = ArRateIncrementalInfoPeer::getTableMap();
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
		return str_replace(ArRateIncrementalInfoPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(ArRateIncrementalInfoPeer::ID);

		$criteria->addSelectColumn(ArRateIncrementalInfoPeer::AR_PARTY_ID);

		$criteria->addSelectColumn(ArRateIncrementalInfoPeer::AR_RATE_ID);

		$criteria->addSelectColumn(ArRateIncrementalInfoPeer::PERIOD);

		$criteria->addSelectColumn(ArRateIncrementalInfoPeer::LAST_PROCESSED_CDR_DATE);

		$criteria->addSelectColumn(ArRateIncrementalInfoPeer::LAST_PROCESSED_CDR_ID);

		$criteria->addSelectColumn(ArRateIncrementalInfoPeer::BUNDLE_RATE);

	}

	const COUNT = 'COUNT(ar_rate_incremental_info.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT ar_rate_incremental_info.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArRateIncrementalInfoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArRateIncrementalInfoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ArRateIncrementalInfoPeer::doSelectRS($criteria, $con);
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
		$objects = ArRateIncrementalInfoPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return ArRateIncrementalInfoPeer::populateObjects(ArRateIncrementalInfoPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			ArRateIncrementalInfoPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = ArRateIncrementalInfoPeer::getOMClass();
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
			$criteria->addSelectColumn(ArRateIncrementalInfoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArRateIncrementalInfoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArRateIncrementalInfoPeer::AR_PARTY_ID, ArPartyPeer::ID);

		$rs = ArRateIncrementalInfoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinArRate(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArRateIncrementalInfoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArRateIncrementalInfoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArRateIncrementalInfoPeer::AR_RATE_ID, ArRatePeer::ID);

		$rs = ArRateIncrementalInfoPeer::doSelectRS($criteria, $con);
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

		ArRateIncrementalInfoPeer::addSelectColumns($c);
		$startcol = (ArRateIncrementalInfoPeer::NUM_COLUMNS - ArRateIncrementalInfoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ArPartyPeer::addSelectColumns($c);

		$c->addJoin(ArRateIncrementalInfoPeer::AR_PARTY_ID, ArPartyPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArRateIncrementalInfoPeer::getOMClass();

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
										$temp_obj2->addArRateIncrementalInfo($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initArRateIncrementalInfos();
				$obj2->addArRateIncrementalInfo($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinArRate(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ArRateIncrementalInfoPeer::addSelectColumns($c);
		$startcol = (ArRateIncrementalInfoPeer::NUM_COLUMNS - ArRateIncrementalInfoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ArRatePeer::addSelectColumns($c);

		$c->addJoin(ArRateIncrementalInfoPeer::AR_RATE_ID, ArRatePeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArRateIncrementalInfoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ArRatePeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getArRate(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addArRateIncrementalInfo($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initArRateIncrementalInfos();
				$obj2->addArRateIncrementalInfo($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArRateIncrementalInfoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArRateIncrementalInfoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArRateIncrementalInfoPeer::AR_PARTY_ID, ArPartyPeer::ID);

		$criteria->addJoin(ArRateIncrementalInfoPeer::AR_RATE_ID, ArRatePeer::ID);

		$rs = ArRateIncrementalInfoPeer::doSelectRS($criteria, $con);
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

		ArRateIncrementalInfoPeer::addSelectColumns($c);
		$startcol2 = (ArRateIncrementalInfoPeer::NUM_COLUMNS - ArRateIncrementalInfoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ArPartyPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ArPartyPeer::NUM_COLUMNS;

		ArRatePeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ArRatePeer::NUM_COLUMNS;

		$c->addJoin(ArRateIncrementalInfoPeer::AR_PARTY_ID, ArPartyPeer::ID);

		$c->addJoin(ArRateIncrementalInfoPeer::AR_RATE_ID, ArRatePeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArRateIncrementalInfoPeer::getOMClass();


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
					$temp_obj2->addArRateIncrementalInfo($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initArRateIncrementalInfos();
				$obj2->addArRateIncrementalInfo($obj1);
			}


					
			$omClass = ArRatePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getArRate(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addArRateIncrementalInfo($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initArRateIncrementalInfos();
				$obj3->addArRateIncrementalInfo($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptArParty(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArRateIncrementalInfoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArRateIncrementalInfoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArRateIncrementalInfoPeer::AR_RATE_ID, ArRatePeer::ID);

		$rs = ArRateIncrementalInfoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptArRate(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArRateIncrementalInfoPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArRateIncrementalInfoPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArRateIncrementalInfoPeer::AR_PARTY_ID, ArPartyPeer::ID);

		$rs = ArRateIncrementalInfoPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptArParty(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ArRateIncrementalInfoPeer::addSelectColumns($c);
		$startcol2 = (ArRateIncrementalInfoPeer::NUM_COLUMNS - ArRateIncrementalInfoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ArRatePeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ArRatePeer::NUM_COLUMNS;

		$c->addJoin(ArRateIncrementalInfoPeer::AR_RATE_ID, ArRatePeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArRateIncrementalInfoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ArRatePeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getArRate(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addArRateIncrementalInfo($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initArRateIncrementalInfos();
				$obj2->addArRateIncrementalInfo($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptArRate(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ArRateIncrementalInfoPeer::addSelectColumns($c);
		$startcol2 = (ArRateIncrementalInfoPeer::NUM_COLUMNS - ArRateIncrementalInfoPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ArPartyPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ArPartyPeer::NUM_COLUMNS;

		$c->addJoin(ArRateIncrementalInfoPeer::AR_PARTY_ID, ArPartyPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArRateIncrementalInfoPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ArPartyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getArParty(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addArRateIncrementalInfo($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initArRateIncrementalInfos();
				$obj2->addArRateIncrementalInfo($obj1);
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
		return ArRateIncrementalInfoPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(ArRateIncrementalInfoPeer::ID); 

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
			$comparison = $criteria->getComparison(ArRateIncrementalInfoPeer::ID);
			$selectCriteria->add(ArRateIncrementalInfoPeer::ID, $criteria->remove(ArRateIncrementalInfoPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(ArRateIncrementalInfoPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(ArRateIncrementalInfoPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof ArRateIncrementalInfo) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(ArRateIncrementalInfoPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(ArRateIncrementalInfo $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ArRateIncrementalInfoPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ArRateIncrementalInfoPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(ArRateIncrementalInfoPeer::DATABASE_NAME, ArRateIncrementalInfoPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = ArRateIncrementalInfoPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(ArRateIncrementalInfoPeer::DATABASE_NAME);

		$criteria->add(ArRateIncrementalInfoPeer::ID, $pk);


		$v = ArRateIncrementalInfoPeer::doSelect($criteria, $con);

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
			$criteria->add(ArRateIncrementalInfoPeer::ID, $pks, Criteria::IN);
			$objs = ArRateIncrementalInfoPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseArRateIncrementalInfoPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/ArRateIncrementalInfoMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.ArRateIncrementalInfoMapBuilder');
}
