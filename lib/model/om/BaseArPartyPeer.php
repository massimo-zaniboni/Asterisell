<?php


abstract class BaseArPartyPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'ar_party';

	
	const CLASS_DEFAULT = 'lib.model.ArParty';

	
	const NUM_COLUMNS = 19;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'ar_party.ID';

	
	const CUSTOMER_OR_VENDOR = 'ar_party.CUSTOMER_OR_VENDOR';

	
	const NAME = 'ar_party.NAME';

	
	const EXTERNAL_CRM_CODE = 'ar_party.EXTERNAL_CRM_CODE';

	
	const VAT = 'ar_party.VAT';

	
	const LEGAL_ADDRESS = 'ar_party.LEGAL_ADDRESS';

	
	const LEGAL_CITY = 'ar_party.LEGAL_CITY';

	
	const LEGAL_ZIPCODE = 'ar_party.LEGAL_ZIPCODE';

	
	const LEGAL_STATE_PROVINCE = 'ar_party.LEGAL_STATE_PROVINCE';

	
	const LEGAL_COUNTRY = 'ar_party.LEGAL_COUNTRY';

	
	const EMAIL = 'ar_party.EMAIL';

	
	const PHONE = 'ar_party.PHONE';

	
	const PHONE2 = 'ar_party.PHONE2';

	
	const FAX = 'ar_party.FAX';

	
	const AR_RATE_CATEGORY_ID = 'ar_party.AR_RATE_CATEGORY_ID';

	
	const AR_PARAMS_ID = 'ar_party.AR_PARAMS_ID';

	
	const MAX_LIMIT_30 = 'ar_party.MAX_LIMIT_30';

	
	const LAST_EMAIL_ADVISE_FOR_MAX_LIMIT_30 = 'ar_party.LAST_EMAIL_ADVISE_FOR_MAX_LIMIT_30';

	
	const IS_ACTIVE = 'ar_party.IS_ACTIVE';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'CustomerOrVendor', 'Name', 'ExternalCrmCode', 'Vat', 'LegalAddress', 'LegalCity', 'LegalZipcode', 'LegalStateProvince', 'LegalCountry', 'Email', 'Phone', 'Phone2', 'Fax', 'ArRateCategoryId', 'ArParamsId', 'MaxLimit30', 'LastEmailAdviseForMaxLimit30', 'IsActive', ),
		BasePeer::TYPE_COLNAME => array (ArPartyPeer::ID, ArPartyPeer::CUSTOMER_OR_VENDOR, ArPartyPeer::NAME, ArPartyPeer::EXTERNAL_CRM_CODE, ArPartyPeer::VAT, ArPartyPeer::LEGAL_ADDRESS, ArPartyPeer::LEGAL_CITY, ArPartyPeer::LEGAL_ZIPCODE, ArPartyPeer::LEGAL_STATE_PROVINCE, ArPartyPeer::LEGAL_COUNTRY, ArPartyPeer::EMAIL, ArPartyPeer::PHONE, ArPartyPeer::PHONE2, ArPartyPeer::FAX, ArPartyPeer::AR_RATE_CATEGORY_ID, ArPartyPeer::AR_PARAMS_ID, ArPartyPeer::MAX_LIMIT_30, ArPartyPeer::LAST_EMAIL_ADVISE_FOR_MAX_LIMIT_30, ArPartyPeer::IS_ACTIVE, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'customer_or_vendor', 'name', 'external_crm_code', 'vat', 'legal_address', 'legal_city', 'legal_zipcode', 'legal_state_province', 'legal_country', 'email', 'phone', 'phone2', 'fax', 'ar_rate_category_id', 'ar_params_id', 'max_limit_30', 'last_email_advise_for_max_limit_30', 'is_active', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'CustomerOrVendor' => 1, 'Name' => 2, 'ExternalCrmCode' => 3, 'Vat' => 4, 'LegalAddress' => 5, 'LegalCity' => 6, 'LegalZipcode' => 7, 'LegalStateProvince' => 8, 'LegalCountry' => 9, 'Email' => 10, 'Phone' => 11, 'Phone2' => 12, 'Fax' => 13, 'ArRateCategoryId' => 14, 'ArParamsId' => 15, 'MaxLimit30' => 16, 'LastEmailAdviseForMaxLimit30' => 17, 'IsActive' => 18, ),
		BasePeer::TYPE_COLNAME => array (ArPartyPeer::ID => 0, ArPartyPeer::CUSTOMER_OR_VENDOR => 1, ArPartyPeer::NAME => 2, ArPartyPeer::EXTERNAL_CRM_CODE => 3, ArPartyPeer::VAT => 4, ArPartyPeer::LEGAL_ADDRESS => 5, ArPartyPeer::LEGAL_CITY => 6, ArPartyPeer::LEGAL_ZIPCODE => 7, ArPartyPeer::LEGAL_STATE_PROVINCE => 8, ArPartyPeer::LEGAL_COUNTRY => 9, ArPartyPeer::EMAIL => 10, ArPartyPeer::PHONE => 11, ArPartyPeer::PHONE2 => 12, ArPartyPeer::FAX => 13, ArPartyPeer::AR_RATE_CATEGORY_ID => 14, ArPartyPeer::AR_PARAMS_ID => 15, ArPartyPeer::MAX_LIMIT_30 => 16, ArPartyPeer::LAST_EMAIL_ADVISE_FOR_MAX_LIMIT_30 => 17, ArPartyPeer::IS_ACTIVE => 18, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'customer_or_vendor' => 1, 'name' => 2, 'external_crm_code' => 3, 'vat' => 4, 'legal_address' => 5, 'legal_city' => 6, 'legal_zipcode' => 7, 'legal_state_province' => 8, 'legal_country' => 9, 'email' => 10, 'phone' => 11, 'phone2' => 12, 'fax' => 13, 'ar_rate_category_id' => 14, 'ar_params_id' => 15, 'max_limit_30' => 16, 'last_email_advise_for_max_limit_30' => 17, 'is_active' => 18, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/ArPartyMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.ArPartyMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = ArPartyPeer::getTableMap();
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
		return str_replace(ArPartyPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(ArPartyPeer::ID);

		$criteria->addSelectColumn(ArPartyPeer::CUSTOMER_OR_VENDOR);

		$criteria->addSelectColumn(ArPartyPeer::NAME);

		$criteria->addSelectColumn(ArPartyPeer::EXTERNAL_CRM_CODE);

		$criteria->addSelectColumn(ArPartyPeer::VAT);

		$criteria->addSelectColumn(ArPartyPeer::LEGAL_ADDRESS);

		$criteria->addSelectColumn(ArPartyPeer::LEGAL_CITY);

		$criteria->addSelectColumn(ArPartyPeer::LEGAL_ZIPCODE);

		$criteria->addSelectColumn(ArPartyPeer::LEGAL_STATE_PROVINCE);

		$criteria->addSelectColumn(ArPartyPeer::LEGAL_COUNTRY);

		$criteria->addSelectColumn(ArPartyPeer::EMAIL);

		$criteria->addSelectColumn(ArPartyPeer::PHONE);

		$criteria->addSelectColumn(ArPartyPeer::PHONE2);

		$criteria->addSelectColumn(ArPartyPeer::FAX);

		$criteria->addSelectColumn(ArPartyPeer::AR_RATE_CATEGORY_ID);

		$criteria->addSelectColumn(ArPartyPeer::AR_PARAMS_ID);

		$criteria->addSelectColumn(ArPartyPeer::MAX_LIMIT_30);

		$criteria->addSelectColumn(ArPartyPeer::LAST_EMAIL_ADVISE_FOR_MAX_LIMIT_30);

		$criteria->addSelectColumn(ArPartyPeer::IS_ACTIVE);

	}

	const COUNT = 'COUNT(ar_party.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT ar_party.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArPartyPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArPartyPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ArPartyPeer::doSelectRS($criteria, $con);
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
		$objects = ArPartyPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return ArPartyPeer::populateObjects(ArPartyPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			ArPartyPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = ArPartyPeer::getOMClass();
		$cls = Propel::import($cls);
				while($rs->next()) {
		
			$obj = new $cls();
			$obj->hydrate($rs);
			$results[] = $obj;
			
		}
		return $results;
	}

	
	public static function doCountJoinArRateCategory(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArPartyPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArPartyPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArPartyPeer::AR_RATE_CATEGORY_ID, ArRateCategoryPeer::ID);

		$rs = ArPartyPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinArParams(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArPartyPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArPartyPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArPartyPeer::AR_PARAMS_ID, ArParamsPeer::ID);

		$rs = ArPartyPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinArRateCategory(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ArPartyPeer::addSelectColumns($c);
		$startcol = (ArPartyPeer::NUM_COLUMNS - ArPartyPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ArRateCategoryPeer::addSelectColumns($c);

		$c->addJoin(ArPartyPeer::AR_RATE_CATEGORY_ID, ArRateCategoryPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArPartyPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ArRateCategoryPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getArRateCategory(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addArParty($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initArPartys();
				$obj2->addArParty($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinArParams(Criteria $c, $con = null)
	{
		$c = clone $c;

				if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ArPartyPeer::addSelectColumns($c);
		$startcol = (ArPartyPeer::NUM_COLUMNS - ArPartyPeer::NUM_LAZY_LOAD_COLUMNS) + 1;
		ArParamsPeer::addSelectColumns($c);

		$c->addJoin(ArPartyPeer::AR_PARAMS_ID, ArParamsPeer::ID);
		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArPartyPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ArParamsPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol);

			$newObject = true;
			foreach($results as $temp_obj1) {
				$temp_obj2 = $temp_obj1->getArParams(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
										$temp_obj2->addArParty($obj1); 					break;
				}
			}
			if ($newObject) {
				$obj2->initArPartys();
				$obj2->addArParty($obj1); 			}
			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAll(Criteria $criteria, $distinct = false, $con = null)
	{
		$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArPartyPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArPartyPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArPartyPeer::AR_RATE_CATEGORY_ID, ArRateCategoryPeer::ID);

		$criteria->addJoin(ArPartyPeer::AR_PARAMS_ID, ArParamsPeer::ID);

		$rs = ArPartyPeer::doSelectRS($criteria, $con);
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

		ArPartyPeer::addSelectColumns($c);
		$startcol2 = (ArPartyPeer::NUM_COLUMNS - ArPartyPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ArRateCategoryPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ArRateCategoryPeer::NUM_COLUMNS;

		ArParamsPeer::addSelectColumns($c);
		$startcol4 = $startcol3 + ArParamsPeer::NUM_COLUMNS;

		$c->addJoin(ArPartyPeer::AR_RATE_CATEGORY_ID, ArRateCategoryPeer::ID);

		$c->addJoin(ArPartyPeer::AR_PARAMS_ID, ArParamsPeer::ID);

		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArPartyPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);


					
			$omClass = ArRateCategoryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2 = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getArRateCategory(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addArParty($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj2->initArPartys();
				$obj2->addArParty($obj1);
			}


					
			$omClass = ArParamsPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj3 = new $cls();
			$obj3->hydrate($rs, $startcol3);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj3 = $temp_obj1->getArParams(); 				if ($temp_obj3->getPrimaryKey() === $obj3->getPrimaryKey()) {
					$newObject = false;
					$temp_obj3->addArParty($obj1); 					break;
				}
			}

			if ($newObject) {
				$obj3->initArPartys();
				$obj3->addArParty($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doCountJoinAllExceptArRateCategory(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArPartyPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArPartyPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArPartyPeer::AR_PARAMS_ID, ArParamsPeer::ID);

		$rs = ArPartyPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doCountJoinAllExceptArParams(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArPartyPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArPartyPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$criteria->addJoin(ArPartyPeer::AR_RATE_CATEGORY_ID, ArRateCategoryPeer::ID);

		$rs = ArPartyPeer::doSelectRS($criteria, $con);
		if ($rs->next()) {
			return $rs->getInt(1);
		} else {
						return 0;
		}
	}


	
	public static function doSelectJoinAllExceptArRateCategory(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ArPartyPeer::addSelectColumns($c);
		$startcol2 = (ArPartyPeer::NUM_COLUMNS - ArPartyPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ArParamsPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ArParamsPeer::NUM_COLUMNS;

		$c->addJoin(ArPartyPeer::AR_PARAMS_ID, ArParamsPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArPartyPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ArParamsPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getArParams(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addArParty($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initArPartys();
				$obj2->addArParty($obj1);
			}

			$results[] = $obj1;
		}
		return $results;
	}


	
	public static function doSelectJoinAllExceptArParams(Criteria $c, $con = null)
	{
		$c = clone $c;

								if ($c->getDbName() == Propel::getDefaultDB()) {
			$c->setDbName(self::DATABASE_NAME);
		}

		ArPartyPeer::addSelectColumns($c);
		$startcol2 = (ArPartyPeer::NUM_COLUMNS - ArPartyPeer::NUM_LAZY_LOAD_COLUMNS) + 1;

		ArRateCategoryPeer::addSelectColumns($c);
		$startcol3 = $startcol2 + ArRateCategoryPeer::NUM_COLUMNS;

		$c->addJoin(ArPartyPeer::AR_RATE_CATEGORY_ID, ArRateCategoryPeer::ID);


		$rs = BasePeer::doSelect($c, $con);
		$results = array();

		while($rs->next()) {

			$omClass = ArPartyPeer::getOMClass();

			$cls = Propel::import($omClass);
			$obj1 = new $cls();
			$obj1->hydrate($rs);

			$omClass = ArRateCategoryPeer::getOMClass();


			$cls = Propel::import($omClass);
			$obj2  = new $cls();
			$obj2->hydrate($rs, $startcol2);

			$newObject = true;
			for ($j=0, $resCount=count($results); $j < $resCount; $j++) {
				$temp_obj1 = $results[$j];
				$temp_obj2 = $temp_obj1->getArRateCategory(); 				if ($temp_obj2->getPrimaryKey() === $obj2->getPrimaryKey()) {
					$newObject = false;
					$temp_obj2->addArParty($obj1);
					break;
				}
			}

			if ($newObject) {
				$obj2->initArPartys();
				$obj2->addArParty($obj1);
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
		return ArPartyPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(ArPartyPeer::ID); 

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
			$comparison = $criteria->getComparison(ArPartyPeer::ID);
			$selectCriteria->add(ArPartyPeer::ID, $criteria->remove(ArPartyPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(ArPartyPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(ArPartyPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof ArParty) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(ArPartyPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(ArParty $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ArPartyPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ArPartyPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(ArPartyPeer::DATABASE_NAME, ArPartyPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = ArPartyPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(ArPartyPeer::DATABASE_NAME);

		$criteria->add(ArPartyPeer::ID, $pk);


		$v = ArPartyPeer::doSelect($criteria, $con);

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
			$criteria->add(ArPartyPeer::ID, $pks, Criteria::IN);
			$objs = ArPartyPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseArPartyPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/ArPartyMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.ArPartyMapBuilder');
}
