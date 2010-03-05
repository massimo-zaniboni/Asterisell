<?php


abstract class BaseArTelephonePrefixPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'ar_telephone_prefix';

	
	const CLASS_DEFAULT = 'lib.model.ArTelephonePrefix';

	
	const NUM_COLUMNS = 5;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'ar_telephone_prefix.ID';

	
	const PREFIX = 'ar_telephone_prefix.PREFIX';

	
	const NAME = 'ar_telephone_prefix.NAME';

	
	const GEOGRAPHIC_LOCATION = 'ar_telephone_prefix.GEOGRAPHIC_LOCATION';

	
	const OPERATOR_TYPE = 'ar_telephone_prefix.OPERATOR_TYPE';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Prefix', 'Name', 'GeographicLocation', 'OperatorType', ),
		BasePeer::TYPE_COLNAME => array (ArTelephonePrefixPeer::ID, ArTelephonePrefixPeer::PREFIX, ArTelephonePrefixPeer::NAME, ArTelephonePrefixPeer::GEOGRAPHIC_LOCATION, ArTelephonePrefixPeer::OPERATOR_TYPE, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'prefix', 'name', 'geographic_location', 'operator_type', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Prefix' => 1, 'Name' => 2, 'GeographicLocation' => 3, 'OperatorType' => 4, ),
		BasePeer::TYPE_COLNAME => array (ArTelephonePrefixPeer::ID => 0, ArTelephonePrefixPeer::PREFIX => 1, ArTelephonePrefixPeer::NAME => 2, ArTelephonePrefixPeer::GEOGRAPHIC_LOCATION => 3, ArTelephonePrefixPeer::OPERATOR_TYPE => 4, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'prefix' => 1, 'name' => 2, 'geographic_location' => 3, 'operator_type' => 4, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/ArTelephonePrefixMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.ArTelephonePrefixMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = ArTelephonePrefixPeer::getTableMap();
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
		return str_replace(ArTelephonePrefixPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(ArTelephonePrefixPeer::ID);

		$criteria->addSelectColumn(ArTelephonePrefixPeer::PREFIX);

		$criteria->addSelectColumn(ArTelephonePrefixPeer::NAME);

		$criteria->addSelectColumn(ArTelephonePrefixPeer::GEOGRAPHIC_LOCATION);

		$criteria->addSelectColumn(ArTelephonePrefixPeer::OPERATOR_TYPE);

	}

	const COUNT = 'COUNT(ar_telephone_prefix.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT ar_telephone_prefix.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArTelephonePrefixPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArTelephonePrefixPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ArTelephonePrefixPeer::doSelectRS($criteria, $con);
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
		$objects = ArTelephonePrefixPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return ArTelephonePrefixPeer::populateObjects(ArTelephonePrefixPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			ArTelephonePrefixPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = ArTelephonePrefixPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}
	
	public static function getTableMap()
	{
		return Propel::getDatabaseMap(self::DATABASE_NAME)->getTable(self::TABLE_NAME);
	}

	
	public static function getOMClass()
	{
		return ArTelephonePrefixPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(ArTelephonePrefixPeer::ID); 

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
			$comparison = $criteria->getComparison(ArTelephonePrefixPeer::ID);
			$selectCriteria->add(ArTelephonePrefixPeer::ID, $criteria->remove(ArTelephonePrefixPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(ArTelephonePrefixPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(ArTelephonePrefixPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof ArTelephonePrefix) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(ArTelephonePrefixPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(ArTelephonePrefix $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ArTelephonePrefixPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ArTelephonePrefixPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(ArTelephonePrefixPeer::DATABASE_NAME, ArTelephonePrefixPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = ArTelephonePrefixPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(ArTelephonePrefixPeer::DATABASE_NAME);

		$criteria->add(ArTelephonePrefixPeer::ID, $pk);


		$v = ArTelephonePrefixPeer::doSelect($criteria, $con);

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
			$criteria->add(ArTelephonePrefixPeer::ID, $pks, Criteria::IN);
			$objs = ArTelephonePrefixPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseArTelephonePrefixPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/ArTelephonePrefixMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.ArTelephonePrefixMapBuilder');
}
