<?php


abstract class BaseArWebAccountPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'ar_web_account';

	
	const CLASS_DEFAULT = 'lib.model.ArWebAccount';

	
	const NUM_COLUMNS = 7;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'ar_web_account.ID';

	
	const LOGIN = 'ar_web_account.LOGIN';

	
	const PASSWORD = 'ar_web_account.PASSWORD';

	
	const AR_PARTY_ID = 'ar_web_account.AR_PARTY_ID';

	
	const AR_ASTERISK_ACCOUNT_ID = 'ar_web_account.AR_ASTERISK_ACCOUNT_ID';

	
	const ACTIVATE_AT = 'ar_web_account.ACTIVATE_AT';

	
	const DEACTIVATE_AT = 'ar_web_account.DEACTIVATE_AT';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Login', 'Password', 'ArPartyId', 'ArAsteriskAccountId', 'ActivateAt', 'DeactivateAt', ),
		BasePeer::TYPE_COLNAME => array (ArWebAccountPeer::ID, ArWebAccountPeer::LOGIN, ArWebAccountPeer::PASSWORD, ArWebAccountPeer::AR_PARTY_ID, ArWebAccountPeer::AR_ASTERISK_ACCOUNT_ID, ArWebAccountPeer::ACTIVATE_AT, ArWebAccountPeer::DEACTIVATE_AT, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'login', 'password', 'ar_party_id', 'ar_asterisk_account_id', 'activate_at', 'deactivate_at', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Login' => 1, 'Password' => 2, 'ArPartyId' => 3, 'ArAsteriskAccountId' => 4, 'ActivateAt' => 5, 'DeactivateAt' => 6, ),
		BasePeer::TYPE_COLNAME => array (ArWebAccountPeer::ID => 0, ArWebAccountPeer::LOGIN => 1, ArWebAccountPeer::PASSWORD => 2, ArWebAccountPeer::AR_PARTY_ID => 3, ArWebAccountPeer::AR_ASTERISK_ACCOUNT_ID => 4, ArWebAccountPeer::ACTIVATE_AT => 5, ArWebAccountPeer::DEACTIVATE_AT => 6, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'login' => 1, 'password' => 2, 'ar_party_id' => 3, 'ar_asterisk_account_id' => 4, 'activate_at' => 5, 'deactivate_at' => 6, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/ArWebAccountMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.ArWebAccountMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = ArWebAccountPeer::getTableMap();
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
		return str_replace(ArWebAccountPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(ArWebAccountPeer::ID);

		$criteria->addSelectColumn(ArWebAccountPeer::LOGIN);

		$criteria->addSelectColumn(ArWebAccountPeer::PASSWORD);

		$criteria->addSelectColumn(ArWebAccountPeer::AR_PARTY_ID);

		$criteria->addSelectColumn(ArWebAccountPeer::AR_ASTERISK_ACCOUNT_ID);

		$criteria->addSelectColumn(ArWebAccountPeer::ACTIVATE_AT);

		$criteria->addSelectColumn(ArWebAccountPeer::DEACTIVATE_AT);

	}

	const COUNT = 'COUNT(ar_web_account.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT ar_web_account.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArWebAccountPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArWebAccountPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ArWebAccountPeer::doSelectRS($criteria, $con);
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
		$objects = ArWebAccountPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return ArWebAccountPeer::populateObjects(ArWebAccountPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			ArWebAccountPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = ArWebAccountPeer::getOMClass();
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
			$criteria->addSelectColumn(ArWebAccountPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArWebAccountPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArWebAccountPeer::AR_PARTY_ID, ArPartyPeer::ID);

		$rs = ArWebAccountPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinArAsteriskAccount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArWebAccountPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArWebAccountPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArWebAccountPeer::AR_ASTERISK_ACCOUNT_ID, ArAsteriskAccountPeer::ID);

		$rs = ArWebAccountPeer::doSelectRS($criteria, $con);
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

		ArWebAccountPeer::addSelectColumns($c);
		$startcol = (ArWebAccountPeer::NUM_COLUMNS - ArWebAccountPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ArPartyPeer::addSelectColumns($c);

		$c->addJoin(ArWebAccountPeer::AR_PARTY_ID, ArPartyPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArWebAccountPeer::getOMClass();

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
										$temp_obj2->addArWebAccount($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initArWebAccounts();
				$obj2->addArWebAccount($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinArAsteriskAccount(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ArWebAccountPeer::addSelectColumns($c);
		$startcol = (ArWebAccountPeer::NUM_COLUMNS - ArWebAccountPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ArAsteriskAccountPeer::addSelectColumns($c);

		$c->addJoin(ArWebAccountPeer::AR_ASTERISK_ACCOUNT_ID, ArAsteriskAccountPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArWebAccountPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ArAsteriskAccountPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getArAsteriskAccount(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addArWebAccount($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initArWebAccounts();
				$obj2->addArWebAccount($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArWebAccountPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArWebAccountPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArWebAccountPeer::AR_PARTY_ID, ArPartyPeer::ID);

		$criteria->addJoin(ArWebAccountPeer::AR_ASTERISK_ACCOUNT_ID, ArAsteriskAccountPeer::ID);

		$rs = ArWebAccountPeer::doSelectRS($criteria, $con);
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

		ArWebAccountPeer::addSelectColumns($c);
		$startcol2 = (ArWebAccountPeer::NUM_COLUMNS - ArWebAccountPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ArPartyPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ArPartyPeer::NUM_COLUMNS;

		ArAsteriskAccountPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ArAsteriskAccountPeer::NUM_COLUMNS;

		$c->addJoin(ArWebAccountPeer::AR_PARTY_ID, ArPartyPeer::ID);

		$c->addJoin(ArWebAccountPeer::AR_ASTERISK_ACCOUNT_ID, ArAsteriskAccountPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArWebAccountPeer::getOMClass();


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
					$temp_obj2->addArWebAccount($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initArWebAccounts();
				$obj2->addArWebAccount($obj1);
			}


					
			$omClass = ArAsteriskAccountPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getArAsteriskAccount(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addArWebAccount($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initArWebAccounts();
				$obj3->addArWebAccount($obj1);
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
			$criteria->addSelectColumn(ArWebAccountPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArWebAccountPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArWebAccountPeer::AR_ASTERISK_ACCOUNT_ID, ArAsteriskAccountPeer::ID);

		$rs = ArWebAccountPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptArAsteriskAccount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArWebAccountPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArWebAccountPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArWebAccountPeer::AR_PARTY_ID, ArPartyPeer::ID);

		$rs = ArWebAccountPeer::doSelectRS($criteria, $con);
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

		ArWebAccountPeer::addSelectColumns($c);
		$startcol2 = (ArWebAccountPeer::NUM_COLUMNS - ArWebAccountPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ArAsteriskAccountPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ArAsteriskAccountPeer::NUM_COLUMNS;

		$c->addJoin(ArWebAccountPeer::AR_ASTERISK_ACCOUNT_ID, ArAsteriskAccountPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArWebAccountPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ArAsteriskAccountPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getArAsteriskAccount(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addArWebAccount($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initArWebAccounts();
				$obj2->addArWebAccount($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptArAsteriskAccount(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ArWebAccountPeer::addSelectColumns($c);
		$startcol2 = (ArWebAccountPeer::NUM_COLUMNS - ArWebAccountPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ArPartyPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ArPartyPeer::NUM_COLUMNS;

		$c->addJoin(ArWebAccountPeer::AR_PARTY_ID, ArPartyPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArWebAccountPeer::getOMClass();

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
					$temp_obj2->addArWebAccount($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initArWebAccounts();
				$obj2->addArWebAccount($obj1);
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
		return ArWebAccountPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(ArWebAccountPeer::ID); 

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
			$comparison = $criteria->getComparison(ArWebAccountPeer::ID);
			$selectCriteria->add(ArWebAccountPeer::ID, $criteria->remove(ArWebAccountPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(ArWebAccountPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(ArWebAccountPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof ArWebAccount) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(ArWebAccountPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(ArWebAccount $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ArWebAccountPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ArWebAccountPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(ArWebAccountPeer::DATABASE_NAME, ArWebAccountPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = ArWebAccountPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(ArWebAccountPeer::DATABASE_NAME);

		$criteria->add(ArWebAccountPeer::ID, $pk);


		$v = ArWebAccountPeer::doSelect($criteria, $con);

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
			$criteria->add(ArWebAccountPeer::ID, $pks, Criteria::IN);
			$objs = ArWebAccountPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseArWebAccountPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/ArWebAccountMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.ArWebAccountMapBuilder');
}
