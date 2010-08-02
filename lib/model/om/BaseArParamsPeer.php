<?php


abstract class BaseArParamsPeer {

	
	const DATABASE_NAME = 'propel';

	
	const TABLE_NAME = 'ar_params';

	
	const CLASS_DEFAULT = 'lib.model.ArParams';

	
	const NUM_COLUMNS = 38;

	
	const NUM_LAZY_LOAD_COLUMNS = 0;


	
	const ID = 'ar_params.ID';

	
	const NAME = 'ar_params.NAME';

	
	const IS_DEFAULT = 'ar_params.IS_DEFAULT';

	
	const SERVICE_NAME = 'ar_params.SERVICE_NAME';

	
	const SERVICE_PROVIDER_WEBSITE = 'ar_params.SERVICE_PROVIDER_WEBSITE';

	
	const SERVICE_PROVIDER_EMAIL = 'ar_params.SERVICE_PROVIDER_EMAIL';

	
	const VAT_TAX_PERC = 'ar_params.VAT_TAX_PERC';

	
	const LOGO_IMAGE = 'ar_params.LOGO_IMAGE';

	
	const SLOGAN = 'ar_params.SLOGAN';

	
	const LOGO_IMAGE_IN_INVOICES = 'ar_params.LOGO_IMAGE_IN_INVOICES';

	
	const FOOTER = 'ar_params.FOOTER';

	
	const USER_MESSAGE = 'ar_params.USER_MESSAGE';

	
	const LAST_VIEWED_FEEDS_MD5 = 'ar_params.LAST_VIEWED_FEEDS_MD5';

	
	const CURRENT_FEEDS_MD5 = 'ar_params.CURRENT_FEEDS_MD5';

	
	const LEGAL_NAME = 'ar_params.LEGAL_NAME';

	
	const EXTERNAL_CRM_CODE = 'ar_params.EXTERNAL_CRM_CODE';

	
	const VAT = 'ar_params.VAT';

	
	const LEGAL_ADDRESS = 'ar_params.LEGAL_ADDRESS';

	
	const LEGAL_WEBSITE = 'ar_params.LEGAL_WEBSITE';

	
	const LEGAL_CITY = 'ar_params.LEGAL_CITY';

	
	const LEGAL_ZIPCODE = 'ar_params.LEGAL_ZIPCODE';

	
	const LEGAL_STATE_PROVINCE = 'ar_params.LEGAL_STATE_PROVINCE';

	
	const LEGAL_COUNTRY = 'ar_params.LEGAL_COUNTRY';

	
	const LEGAL_EMAIL = 'ar_params.LEGAL_EMAIL';

	
	const LEGAL_PHONE = 'ar_params.LEGAL_PHONE';

	
	const PHONE2 = 'ar_params.PHONE2';

	
	const LEGAL_FAX = 'ar_params.LEGAL_FAX';

	
	const SENDER_NAME_ON_INVOICING_EMAILS = 'ar_params.SENDER_NAME_ON_INVOICING_EMAILS';

	
	const INVOICING_EMAIL_ADDRESS = 'ar_params.INVOICING_EMAIL_ADDRESS';

	
	const ACCOUNTANT_EMAIL_ADDRESS = 'ar_params.ACCOUNTANT_EMAIL_ADDRESS';

	
	const SMTP_HOST = 'ar_params.SMTP_HOST';

	
	const SMTP_PORT = 'ar_params.SMTP_PORT';

	
	const SMTP_USERNAME = 'ar_params.SMTP_USERNAME';

	
	const SMTP_PASSWORD = 'ar_params.SMTP_PASSWORD';

	
	const SMTP_ENCRYPTION = 'ar_params.SMTP_ENCRYPTION';

	
	const SMTP_RECONNECT_AFTER_NR_OF_MESSAGES = 'ar_params.SMTP_RECONNECT_AFTER_NR_OF_MESSAGES';

	
	const SMTP_SECONDS_OF_PAUSE_AFTER_RECONNECTION = 'ar_params.SMTP_SECONDS_OF_PAUSE_AFTER_RECONNECTION';

	
	const CURRENT_INVOICE_NR = 'ar_params.CURRENT_INVOICE_NR';

	
	private static $phpNameMap = null;


	
	private static $fieldNames = array (
		BasePeer::TYPE_PHPNAME => array ('Id', 'Name', 'IsDefault', 'ServiceName', 'ServiceProviderWebsite', 'ServiceProviderEmail', 'VatTaxPerc', 'LogoImage', 'Slogan', 'LogoImageInInvoices', 'Footer', 'UserMessage', 'LastViewedFeedsMd5', 'CurrentFeedsMd5', 'LegalName', 'ExternalCrmCode', 'Vat', 'LegalAddress', 'LegalWebsite', 'LegalCity', 'LegalZipcode', 'LegalStateProvince', 'LegalCountry', 'LegalEmail', 'LegalPhone', 'Phone2', 'LegalFax', 'SenderNameOnInvoicingEmails', 'InvoicingEmailAddress', 'AccountantEmailAddress', 'SmtpHost', 'SmtpPort', 'SmtpUsername', 'SmtpPassword', 'SmtpEncryption', 'SmtpReconnectAfterNrOfMessages', 'SmtpSecondsOfPauseAfterReconnection', 'CurrentInvoiceNr', ),
		BasePeer::TYPE_COLNAME => array (ArParamsPeer::ID, ArParamsPeer::NAME, ArParamsPeer::IS_DEFAULT, ArParamsPeer::SERVICE_NAME, ArParamsPeer::SERVICE_PROVIDER_WEBSITE, ArParamsPeer::SERVICE_PROVIDER_EMAIL, ArParamsPeer::VAT_TAX_PERC, ArParamsPeer::LOGO_IMAGE, ArParamsPeer::SLOGAN, ArParamsPeer::LOGO_IMAGE_IN_INVOICES, ArParamsPeer::FOOTER, ArParamsPeer::USER_MESSAGE, ArParamsPeer::LAST_VIEWED_FEEDS_MD5, ArParamsPeer::CURRENT_FEEDS_MD5, ArParamsPeer::LEGAL_NAME, ArParamsPeer::EXTERNAL_CRM_CODE, ArParamsPeer::VAT, ArParamsPeer::LEGAL_ADDRESS, ArParamsPeer::LEGAL_WEBSITE, ArParamsPeer::LEGAL_CITY, ArParamsPeer::LEGAL_ZIPCODE, ArParamsPeer::LEGAL_STATE_PROVINCE, ArParamsPeer::LEGAL_COUNTRY, ArParamsPeer::LEGAL_EMAIL, ArParamsPeer::LEGAL_PHONE, ArParamsPeer::PHONE2, ArParamsPeer::LEGAL_FAX, ArParamsPeer::SENDER_NAME_ON_INVOICING_EMAILS, ArParamsPeer::INVOICING_EMAIL_ADDRESS, ArParamsPeer::ACCOUNTANT_EMAIL_ADDRESS, ArParamsPeer::SMTP_HOST, ArParamsPeer::SMTP_PORT, ArParamsPeer::SMTP_USERNAME, ArParamsPeer::SMTP_PASSWORD, ArParamsPeer::SMTP_ENCRYPTION, ArParamsPeer::SMTP_RECONNECT_AFTER_NR_OF_MESSAGES, ArParamsPeer::SMTP_SECONDS_OF_PAUSE_AFTER_RECONNECTION, ArParamsPeer::CURRENT_INVOICE_NR, ),
		BasePeer::TYPE_FIELDNAME => array ('id', 'name', 'is_default', 'service_name', 'service_provider_website', 'service_provider_email', 'vat_tax_perc', 'logo_image', 'slogan', 'logo_image_in_invoices', 'footer', 'user_message', 'last_viewed_feeds_md5', 'current_feeds_md5', 'legal_name', 'external_crm_code', 'vat', 'legal_address', 'legal_website', 'legal_city', 'legal_zipcode', 'legal_state_province', 'legal_country', 'legal_email', 'legal_phone', 'phone2', 'legal_fax', 'sender_name_on_invoicing_emails', 'invoicing_email_address', 'accountant_email_address', 'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password', 'smtp_encryption', 'smtp_reconnect_after_nr_of_messages', 'smtp_seconds_of_pause_after_reconnection', 'current_invoice_nr', ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, )
	);

	
	private static $fieldKeys = array (
		BasePeer::TYPE_PHPNAME => array ('Id' => 0, 'Name' => 1, 'IsDefault' => 2, 'ServiceName' => 3, 'ServiceProviderWebsite' => 4, 'ServiceProviderEmail' => 5, 'VatTaxPerc' => 6, 'LogoImage' => 7, 'Slogan' => 8, 'LogoImageInInvoices' => 9, 'Footer' => 10, 'UserMessage' => 11, 'LastViewedFeedsMd5' => 12, 'CurrentFeedsMd5' => 13, 'LegalName' => 14, 'ExternalCrmCode' => 15, 'Vat' => 16, 'LegalAddress' => 17, 'LegalWebsite' => 18, 'LegalCity' => 19, 'LegalZipcode' => 20, 'LegalStateProvince' => 21, 'LegalCountry' => 22, 'LegalEmail' => 23, 'LegalPhone' => 24, 'Phone2' => 25, 'LegalFax' => 26, 'SenderNameOnInvoicingEmails' => 27, 'InvoicingEmailAddress' => 28, 'AccountantEmailAddress' => 29, 'SmtpHost' => 30, 'SmtpPort' => 31, 'SmtpUsername' => 32, 'SmtpPassword' => 33, 'SmtpEncryption' => 34, 'SmtpReconnectAfterNrOfMessages' => 35, 'SmtpSecondsOfPauseAfterReconnection' => 36, 'CurrentInvoiceNr' => 37, ),
		BasePeer::TYPE_COLNAME => array (ArParamsPeer::ID => 0, ArParamsPeer::NAME => 1, ArParamsPeer::IS_DEFAULT => 2, ArParamsPeer::SERVICE_NAME => 3, ArParamsPeer::SERVICE_PROVIDER_WEBSITE => 4, ArParamsPeer::SERVICE_PROVIDER_EMAIL => 5, ArParamsPeer::VAT_TAX_PERC => 6, ArParamsPeer::LOGO_IMAGE => 7, ArParamsPeer::SLOGAN => 8, ArParamsPeer::LOGO_IMAGE_IN_INVOICES => 9, ArParamsPeer::FOOTER => 10, ArParamsPeer::USER_MESSAGE => 11, ArParamsPeer::LAST_VIEWED_FEEDS_MD5 => 12, ArParamsPeer::CURRENT_FEEDS_MD5 => 13, ArParamsPeer::LEGAL_NAME => 14, ArParamsPeer::EXTERNAL_CRM_CODE => 15, ArParamsPeer::VAT => 16, ArParamsPeer::LEGAL_ADDRESS => 17, ArParamsPeer::LEGAL_WEBSITE => 18, ArParamsPeer::LEGAL_CITY => 19, ArParamsPeer::LEGAL_ZIPCODE => 20, ArParamsPeer::LEGAL_STATE_PROVINCE => 21, ArParamsPeer::LEGAL_COUNTRY => 22, ArParamsPeer::LEGAL_EMAIL => 23, ArParamsPeer::LEGAL_PHONE => 24, ArParamsPeer::PHONE2 => 25, ArParamsPeer::LEGAL_FAX => 26, ArParamsPeer::SENDER_NAME_ON_INVOICING_EMAILS => 27, ArParamsPeer::INVOICING_EMAIL_ADDRESS => 28, ArParamsPeer::ACCOUNTANT_EMAIL_ADDRESS => 29, ArParamsPeer::SMTP_HOST => 30, ArParamsPeer::SMTP_PORT => 31, ArParamsPeer::SMTP_USERNAME => 32, ArParamsPeer::SMTP_PASSWORD => 33, ArParamsPeer::SMTP_ENCRYPTION => 34, ArParamsPeer::SMTP_RECONNECT_AFTER_NR_OF_MESSAGES => 35, ArParamsPeer::SMTP_SECONDS_OF_PAUSE_AFTER_RECONNECTION => 36, ArParamsPeer::CURRENT_INVOICE_NR => 37, ),
		BasePeer::TYPE_FIELDNAME => array ('id' => 0, 'name' => 1, 'is_default' => 2, 'service_name' => 3, 'service_provider_website' => 4, 'service_provider_email' => 5, 'vat_tax_perc' => 6, 'logo_image' => 7, 'slogan' => 8, 'logo_image_in_invoices' => 9, 'footer' => 10, 'user_message' => 11, 'last_viewed_feeds_md5' => 12, 'current_feeds_md5' => 13, 'legal_name' => 14, 'external_crm_code' => 15, 'vat' => 16, 'legal_address' => 17, 'legal_website' => 18, 'legal_city' => 19, 'legal_zipcode' => 20, 'legal_state_province' => 21, 'legal_country' => 22, 'legal_email' => 23, 'legal_phone' => 24, 'phone2' => 25, 'legal_fax' => 26, 'sender_name_on_invoicing_emails' => 27, 'invoicing_email_address' => 28, 'accountant_email_address' => 29, 'smtp_host' => 30, 'smtp_port' => 31, 'smtp_username' => 32, 'smtp_password' => 33, 'smtp_encryption' => 34, 'smtp_reconnect_after_nr_of_messages' => 35, 'smtp_seconds_of_pause_after_reconnection' => 36, 'current_invoice_nr' => 37, ),
		BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, )
	);

	
	public static function getMapBuilder()
	{
		include_once 'lib/model/map/ArParamsMapBuilder.php';
		return BasePeer::getMapBuilder('lib.model.map.ArParamsMapBuilder');
	}
	
	public static function getPhpNameMap()
	{
		if (self::$phpNameMap === null) {
			$map = ArParamsPeer::getTableMap();
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
		return str_replace(ArParamsPeer::TABLE_NAME.'.', $alias.'.', $column);
	}

	
	public static function addSelectColumns(Criteria $criteria)
	{

		$criteria->addSelectColumn(ArParamsPeer::ID);

		$criteria->addSelectColumn(ArParamsPeer::NAME);

		$criteria->addSelectColumn(ArParamsPeer::IS_DEFAULT);

		$criteria->addSelectColumn(ArParamsPeer::SERVICE_NAME);

		$criteria->addSelectColumn(ArParamsPeer::SERVICE_PROVIDER_WEBSITE);

		$criteria->addSelectColumn(ArParamsPeer::SERVICE_PROVIDER_EMAIL);

		$criteria->addSelectColumn(ArParamsPeer::VAT_TAX_PERC);

		$criteria->addSelectColumn(ArParamsPeer::LOGO_IMAGE);

		$criteria->addSelectColumn(ArParamsPeer::SLOGAN);

		$criteria->addSelectColumn(ArParamsPeer::LOGO_IMAGE_IN_INVOICES);

		$criteria->addSelectColumn(ArParamsPeer::FOOTER);

		$criteria->addSelectColumn(ArParamsPeer::USER_MESSAGE);

		$criteria->addSelectColumn(ArParamsPeer::LAST_VIEWED_FEEDS_MD5);

		$criteria->addSelectColumn(ArParamsPeer::CURRENT_FEEDS_MD5);

		$criteria->addSelectColumn(ArParamsPeer::LEGAL_NAME);

		$criteria->addSelectColumn(ArParamsPeer::EXTERNAL_CRM_CODE);

		$criteria->addSelectColumn(ArParamsPeer::VAT);

		$criteria->addSelectColumn(ArParamsPeer::LEGAL_ADDRESS);

		$criteria->addSelectColumn(ArParamsPeer::LEGAL_WEBSITE);

		$criteria->addSelectColumn(ArParamsPeer::LEGAL_CITY);

		$criteria->addSelectColumn(ArParamsPeer::LEGAL_ZIPCODE);

		$criteria->addSelectColumn(ArParamsPeer::LEGAL_STATE_PROVINCE);

		$criteria->addSelectColumn(ArParamsPeer::LEGAL_COUNTRY);

		$criteria->addSelectColumn(ArParamsPeer::LEGAL_EMAIL);

		$criteria->addSelectColumn(ArParamsPeer::LEGAL_PHONE);

		$criteria->addSelectColumn(ArParamsPeer::PHONE2);

		$criteria->addSelectColumn(ArParamsPeer::LEGAL_FAX);

		$criteria->addSelectColumn(ArParamsPeer::SENDER_NAME_ON_INVOICING_EMAILS);

		$criteria->addSelectColumn(ArParamsPeer::INVOICING_EMAIL_ADDRESS);

		$criteria->addSelectColumn(ArParamsPeer::ACCOUNTANT_EMAIL_ADDRESS);

		$criteria->addSelectColumn(ArParamsPeer::SMTP_HOST);

		$criteria->addSelectColumn(ArParamsPeer::SMTP_PORT);

		$criteria->addSelectColumn(ArParamsPeer::SMTP_USERNAME);

		$criteria->addSelectColumn(ArParamsPeer::SMTP_PASSWORD);

		$criteria->addSelectColumn(ArParamsPeer::SMTP_ENCRYPTION);

		$criteria->addSelectColumn(ArParamsPeer::SMTP_RECONNECT_AFTER_NR_OF_MESSAGES);

		$criteria->addSelectColumn(ArParamsPeer::SMTP_SECONDS_OF_PAUSE_AFTER_RECONNECTION);

		$criteria->addSelectColumn(ArParamsPeer::CURRENT_INVOICE_NR);

	}

	const COUNT = 'COUNT(ar_params.ID)';
	const COUNT_DISTINCT = 'COUNT(DISTINCT ar_params.ID)';

	
	public static function doCount(Criteria $criteria, $distinct = false, $con = null)
	{
				$criteria = clone $criteria;

				$criteria->clearSelectColumns()->clearOrderByColumns();
		if ($distinct || in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
			$criteria->addSelectColumn(ArParamsPeer::COUNT_DISTINCT);
		} else {
			$criteria->addSelectColumn(ArParamsPeer::COUNT);
		}

				foreach($criteria->getGroupByColumns() as $column)
		{
			$criteria->addSelectColumn($column);
		}

		$rs = ArParamsPeer::doSelectRS($criteria, $con);
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
		$objects = ArParamsPeer::doSelect($critcopy, $con);
		if ($objects) {
			return $objects[0];
		}
		return null;
	}
	
	public static function doSelect(Criteria $criteria, $con = null)
	{
		return ArParamsPeer::populateObjects(ArParamsPeer::doSelectRS($criteria, $con));
	}
	
	public static function doSelectRS(Criteria $criteria, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if (!$criteria->getSelectColumns()) {
			$criteria = clone $criteria;
			ArParamsPeer::addSelectColumns($criteria);
		}

				$criteria->setDbName(self::DATABASE_NAME);

						return BasePeer::doSelect($criteria, $con);
	}
	
	public static function populateObjects(ResultSet $rs)
	{
		$results = array();
	
				$cls = ArParamsPeer::getOMClass();
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
		return ArParamsPeer::CLASS_DEFAULT;
	}

	
	public static function doInsert($values, $con = null)
	{
		if ($con === null) {
			$con = Propel::getConnection(self::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} else {
			$criteria = $values->buildCriteria(); 		}

		$criteria->remove(ArParamsPeer::ID); 

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
			$comparison = $criteria->getComparison(ArParamsPeer::ID);
			$selectCriteria->add(ArParamsPeer::ID, $criteria->remove(ArParamsPeer::ID), $comparison);

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
			$affectedRows += BasePeer::doDeleteAll(ArParamsPeer::TABLE_NAME, $con);
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
			$con = Propel::getConnection(ArParamsPeer::DATABASE_NAME);
		}

		if ($values instanceof Criteria) {
			$criteria = clone $values; 		} elseif ($values instanceof ArParams) {

			$criteria = $values->buildPkeyCriteria();
		} else {
						$criteria = new Criteria(self::DATABASE_NAME);
			$criteria->add(ArParamsPeer::ID, (array) $values, Criteria::IN);
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

	
	public static function doValidate(ArParams $obj, $cols = null)
	{
		$columns = array();

		if ($cols) {
			$dbMap = Propel::getDatabaseMap(ArParamsPeer::DATABASE_NAME);
			$tableMap = $dbMap->getTable(ArParamsPeer::TABLE_NAME);

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

		$res =  BasePeer::doValidate(ArParamsPeer::DATABASE_NAME, ArParamsPeer::TABLE_NAME, $columns);
    if ($res !== true) {
        $request = sfContext::getInstance()->getRequest();
        foreach ($res as $failed) {
            $col = ArParamsPeer::translateFieldname($failed->getColumn(), BasePeer::TYPE_COLNAME, BasePeer::TYPE_PHPNAME);
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

		$criteria = new Criteria(ArParamsPeer::DATABASE_NAME);

		$criteria->add(ArParamsPeer::ID, $pk);


		$v = ArParamsPeer::doSelect($criteria, $con);

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
			$criteria->add(ArParamsPeer::ID, $pks, Criteria::IN);
			$objs = ArParamsPeer::doSelect($criteria, $con);
		}
		return $objs;
	}

} 
if (Propel::isInit()) {
			try {
		BaseArParamsPeer::getMapBuilder();
	} catch (Exception $e) {
		Propel::log('Could not initialize Peer: ' . $e->getMessage(), Propel::LOG_ERR);
	}
} else {
			require_once 'lib/model/map/ArParamsMapBuilder.php';
	Propel::registerMapBuilder('lib.model.map.ArParamsMapBuilder');
}
