<?php

/* $LICENSE 2009, 2010, 2011:
 *
 * Copyright (C) 2009, 2010 Massimo Zaniboni <massimo.zaniboni@profitoss.com>
 *
 * This file is part of Asterisell.
 *
 * Asterisell is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * Asterisell is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Asterisell. If not, see <http://www.gnu.org/licenses/>.
 * $
 */


define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'asterisell');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

sfLoader::loadHelpers(array('I18N', 'Debug', 'Asterisell'));

sfContext::getInstance();

define('WEB_DIR', SF_ROOT_DIR.DIRECTORY_SEPARATOR.'web');

main($argc, $argv);

/**
 * Execute the JobProcessorQueue.
 *
 * Delete also LOCK files.
 * This is needed because during installation these files
 * have rights different from the lock files created
 * from the web server during normal/production execution.
 */
function runJobProcessorQueue() {
  $webDir = realpath(WEB_DIR);

  $culture = sfConfig::get('app_culture');
  $I18N = sfContext::getInstance()->getI18N();
  $I18N->setMessageSourceDir(SF_ROOT_DIR.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'i18n', $culture);
  $I18N->setCulture($culture);

  $processor = new JobQueueProcessor();
  $r = $processor->process($webDir);

  foreach (glob($webDir.DIRECTORY_SEPARATOR.'*.lock') as $filename) {
    unlink($filename);
  }
  
  if (is_null($r)) {
    echo "\nJobProcessorQueue has some problem reported on Asterisell error table.\n";
    echo "webDir=$webDir\n";
  } else {
    echo "\nJobProcessorQueue run on webDir=$webDir.\n";
  }
}

function myDelete($c, $t) {
  $query = "DELETE FROM $t";
  $s = $c->executeUpdate($query);
}

function deleteAllData() {
  echo "Deleting all data inside database.\n";

  // Delete all data from database.
  //
  $connection = Propel::getConnection();
  myDelete($connection, "ar_job_queue");
  myDelete($connection, "ar_invoice_creation");
  myDelete($connection, "ar_invoice");
  myDelete($connection, "ar_problem");
  myDelete($connection, "cdr");
  myDelete($connection, "ar_rate_incremental_info");
  myDelete($connection, "ar_rate");
  myDelete($connection, "ar_web_account");
  myDelete($connection, "ar_asterisk_account");
  myDelete($connection, "ar_office");
  myDelete($connection, "ar_party");
  myDelete($connection, "ar_telephone_prefix");
  myDelete($connection, "ar_rate_category");
  myDelete($connection, "ar_params");
}

/**
 * Create a date in the past.
 *
 * Note: seconds are setted according time()
 * so two invocation of the function using
 * the same number of $days do not return
 * the same result.
 */
function pastDays($days) {
  $t = time() - ($days * 24 * 60 * 60);
  return $t; 
}

function nextDays($days) {
  return pastDays(0 - $days);
}

function createPrefix($pType, $pPlace, $pPrefix) {
  $r = new ArTelephonePrefix();
  $r->setPrefix($pPrefix);
  $r->setName(null);
  $r->setGeographicLocation($pPlace);
  $r->setOperatorType($pType);
  $r->save();
}

function mergeCompletePrefix($prefix, $nation, $type, $operator) {

  $c = new Criteria();
  $c->add(ArTelephonePrefixPeer::PREFIX, $prefix);
  $r = ArTelephonePrefixPeer::doSelectOne($c);

  $msg = "";
  if (is_null($r)) {
    $msg .= "Create new entry ";
    createCompletePrefix($prefix, $nation, $type, $operator);
  } else {
    $msg .= "Update entry ";
    $r->setPrefix($prefix);
    $r->setName($operator);
    $r->setGeographicLocation($nation);
    $r->setOperatorType($type);
    $r->save();
  }
 
  $msg .= "\"$prefix\", \"$nation\", \"$type\", \"$operator\"";
  echo $msg . "\n";
}

function createCompletePrefix($prefix, $nation, $type, $operator) {
  $r = new ArTelephonePrefix();
  $r->setPrefix($prefix);
  $r->setName($operator);
  $r->setGeographicLocation($nation);
  $r->setOperatorType($type);
  $r->save();
}

function loadPrefixes($filename, $merge) {
  $nrOfColInLine = 5;
  $handle = fopen($filename, 'r');
  if ($handle == false) {
    echo "Error opening file \"$filename\"";
    exit(2);
  }

  echo "\nImport Telephone Prefixes: ";

  $ln = 0;
  while (($data = fgetcsv($handle, 5000, ",")) !== false) {
    $ln++;
    if ($ln % 250 == 0) {
      echo "#";
    }
    $prefix = trim($data[0]);
    $nation = trim($data[1]);
    $type = trim($data[2]);
    $operator = trim($data[3]);

    if ($merge) {
      mergeCompletePrefix($prefix, $nation, $type, $operator);
    } else {
      createCompletePrefix($prefix, $nation, $type, $operator);
    }
  }
}

function addNewTelephonePrefixes() {
  loadPrefixes("world_prefix_table.csv", TRUE);
}


/**
 * @return $defaultParamsId created
 */
function createDefaultParams() {
  $params = new ArParams();
  $params->setIsDefault(TRUE);
  $params->setName("Default");
  $params->setServiceName("Asterisell");
  $params->setServiceProviderWebsite("http://voipinfo.example.com");
  $params->setLegalWebsite("http://www.example.com");
  $params->setServiceProviderEmail("info@example.com");
  $params->setLogoImage("asterisell.png");
  $params->setLogoImageInInvoices("asterisell.jpeg");
  $params->setSlogan("open source web application for rating, showing to customers, and billing Asterisk VoIP calls.");
  $params->setFooter("<center>For info contact:<a href=\"mailto:info@example.com\">info@example.com</a></center>");
  $params->setUserMessage("");

  $params->setVatTaxPercAsPhpDecimal("20");

  $params->setLegalName("ACME Example VoIP Corporation");
  $params->setVat("WRLD12345678909876");
  $params->setLegalAddress("Street By Example");
  $params->setLegalCity("Soliera");
  $params->setLegalZipcode("41019");
  $params->setLegalStateProvince("Modena");
  $params->setLegalCountry("Italy");
  $params->setLegalEmail("acme@example.com");
  $params->setLegalPhone("+0 000-0000");

  $params->setSenderNameOnInvoicingEmails("ACME Corporation");
  $params->setInvoicingEmailAddress("sales@acme.example.com");
  $params->setSmtpHost("");
  $params->setSmtpPort();
  $params->setSmtpUsername("");
  $params->setSmtpPassword("");
  $params->setSmtpEncryption("");
  $params->setSmtpReconnectAfterNrOfMessages();
  $params->setSmtpSecondsOfPauseAfterReconnection();
  $params->save();
  
  return $params->getId();
}

/**
 * Return a list($defaultParamsId, $normalCategoryId, $discountedCategoryId, $defaultVendorId)
 */
function initWithDefaultData() {
try {
  deleteAllData();

  // Create dates starting from current time.
  // This allows to create more "user friendly"
  // demo-data.
  //
  $past= pastDays(365*2);

  // Create default params
  //
  echo "\nCreating default Params";
  $defaultParamsId = createDefaultParams();

  echo "\nCreating Categories and Parties";

  $r = new ArRateCategory();
  $r->setName("Normal");
  $r->save();
  $normalCategoryId = $r->getId();

  $r = new ArRateCategory();
  $r->setName("Discounted");
  $r->save();
  $discountedCategoryId = $r->getId();

  $r = new ArParty();
  $r->setCustomerOrVendor("V");
  $r->setName("Default Vendor");
  $r->setExternalCrmCode("");
  $r->setArRateCategoryId(null);
  $r->setArParamsId($defaultParamsId);
  $r->save();
  $defaultVendorId = $r->getId();

  echo "\nCreating Rates";

  // ANSWERED --> outgoing
  //
  $rm = new PhpCDRProcessing();
  $rm->dstChannel = "";
  $rm->disposition = "ANSWERED";
  $rm->amaflags = 0;
  $rm->destinationType = DestinationType::outgoing;

  $r = new ArRate();
  $r->setDestinationType(DestinationType::unprocessed);
  $r->setArRateCategoryId(null);
  $r->setArPartyId(null);
  $r->setStartTime($past);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  $rm = new PhpCDRProcessing();
  $rm->dstChannel = "";
  $rm->disposition = "ANSWERED";
  $rm->amaflags = 3;
  $rm->destinationType = DestinationType::outgoing;

  $r = new ArRate();
  $r->setDestinationType(DestinationType::unprocessed);
  $r->setArRateCategoryId(null);
  $r->setArPartyId(null);
  $r->setStartTime($past);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  // NO ANSWERED --> IGNORED
  //
  $rm = new PhpCDRProcessing();
  $rm->dstChannel = "";
  $rm->disposition = "NO ANSWERED";
  $rm->amaflags = 5;
  $rm->destinationType = DestinationType::ignored;

  $r = new ArRate();
  $r->setDestinationType(DestinationType::unprocessed);
  $r->setArRateCategoryId(null);
  $r->setArPartyId(null);
  $r->setStartTime($past);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  // NO ANSWER --> IGNORED
  //
  $rm = new PhpCDRProcessing();
  $rm->dstChannel = "";
  $rm->disposition = "NO ANSWER";
  $rm->amaflags = 5;
  $rm->destinationType = DestinationType::ignored;

  $r = new ArRate();
  $r->setDestinationType(DestinationType::unprocessed);
  $r->setArRateCategoryId(null);
  $r->setArPartyId(null);
  $r->setStartTime($past);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  // BUSY --> IGNORED
  //
  $rm = new PhpCDRProcessing();
  $rm->dstChannel = "";
  $rm->disposition = "BUSY";
  $rm->amaflags = 5;
  $rm->destinationType = DestinationType::ignored;

  $r = new ArRate();
  $r->setDestinationType(DestinationType::unprocessed);
  $r->setArRateCategoryId(null);
  $r->setArPartyId(null);
  $r->setStartTime($past);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  // FAILED --> IGNORED
  //
  $rm = new PhpCDRProcessing();
  $rm->dstChannel = "";
  $rm->disposition = "BUSY";
  $rm->amaflags = 5;
  $rm->destinationType = DestinationType::ignored;

  $r = new ArRate();
  $r->setDestinationType(DestinationType::unprocessed);
  $r->setArRateCategoryId(null);
  $r->setArPartyId(null);
  $r->setStartTime($past);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  // some test income for all outgoing and normal-category
  //
  $rm = new PhpRateByDuration();
  $rm->dstChannelPattern = "";
  $rm->rateByMinute = false;
  $rm->costForMinute = 1;
  $rm->costOnCall = 0;
  $rm->atLeastXSeconds = 0;
  $rm->whenRound_0_59 = 0;
  $rm->externalTelephonePrefix = "";
  $rm->internalTelephonePrefix = "";
  
  $r = new ArRate();
  $r->setDestinationType(DestinationType::outgoing);
  $r->setArRateCategoryId($normalCategoryId);
  $r->setArPartyId(null);
  $r->setStartTime($past);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  // some income for all outgoing and discounted-category
  //
  $rm = new PhpRateByDuration();
  $rm->dstChannelPattern = "";
  $rm->rateByMinute = false;
  $rm->costForMinute = 0.8;
  $rm->costOnCall = 0;
  $rm->atLeastXSeconds = 0;
  $rm->whenRound_0_59 = 0;
  $rm->externalTelephonePrefix = "";
  $rm->internalTelephonePrefix = "";
  
  $r = new ArRate();
  $r->setDestinationType(DestinationType::outgoing);
  $r->setArRateCategoryId($discountedCategoryId);
  $r->setArPartyId(null);
  $r->setStartTime($past);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  // some cost for all outgoing 
  //
  $rm = new PhpRateByDuration();
  $rm->dstChannelPattern = "";
  $rm->rateByMinute = false;
  $rm->costForMinute = 0.5;
  $rm->costOnCall = 0;
  $rm->atLeastXSeconds = 0;
  $rm->whenRound_0_59 = 0;
  $rm->externalTelephonePrefix = "";
  $rm->internalTelephonePrefix = "";
  
  $r = new ArRate();
  $r->setDestinationType(DestinationType::outgoing);
  $r->setArRateCategoryId(null);
  $r->setArPartyId($defaultVendorId);
  $r->setStartTime($past);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  // Add prefix table
  //
  loadPrefixes("world_prefix_table.csv", FALSE);

  return array($defaultParamsId, $normalCategoryId, $discountedCategoryId, $defaultVendorId);

} catch (Exception $e) {
    echo "Caught exceptio: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
}

function addRootUser($password, $defaultParamsId) {
  $w = new ArWebAccount();
  $w->setLogin("root");
  $w->setPassword($password);
  $w->setArPartyId(null);
  $w->setArOfficeId(null);
  $w->setActivateAt(date("c"));
  $w->setDeactivateAt(null);
  $w->setArParamsId($defaultParamsId);
  $w->save();

  echo "\nCreated root user with name \"root\" and password \"$password\".\n";
}


/**
 * Insert regression data 
 */
function initWithRegressionData() {
  deleteAllData();

  $defaultParamsId = createDefaultParams();

  createPrefix("Fixed line", "Italy", "39");
  createPrefix("Mobile line", "Italy", "393");
  createPrefix("Fixed line" , "Albania" ,  "355");
  createPrefix("Mobile line" , "Albania" ,  "35567");
  createPrefix("Mobile line" , "Albania" ,  "35568");
  createPrefix("Mobile line" , "Albania" ,  "35569");

  createPrefix("Fixed line" , "American Samoa" ,  "1684");
  createPrefix("Fixed line" , "American Samoa" ,  "684");
  createPrefix("Mobile line" , "American Samoa" ,  "1684252");
  createPrefix("Mobile line" , "American Samoa" ,  "1684254");
  createPrefix("Mobile line" , "American Samoa" ,  "1684258");
  createPrefix("Fixed line" , "Andorra" ,  "376");
  createPrefix("Mobile line" , "Andorra" ,  "3763");
  createPrefix("Mobile line" , "Andorra" ,  "3764");
  createPrefix("Mobile line" , "Andorra" ,  "3766");

  // Create dates starting from current time.
  // This allows to create more "user friendly"
  // demo-data.
  //
  $days60= pastDays(60);
  $days55= pastDays(55);
  $days50= pastDays(50);
  $days45= pastDays(45);
  $days40 = pastDays(40);
  $days35 = pastDays(35);
  $days30 = pastDays(30);
  $days25 = pastDays(25);
  $days20 = pastDays(20);
  $days15 = pastDays(15);
  $days12 = pastDays(12);
  $days11 = pastDays(11);
  $days10 = pastDays(10);
  $days9 = pastDays(9);
  $days5 = pastDays(5);
  $days2 = pastDays(2);
  $days1 = pastDays(1);
  $days0 = pastDays(0);

  // Special numbers
  //
  $tnItalyFixed1 = "391111111";
  $tnItalyFixed2 = "392222222";
  $tnItalyMobile1 = "39333333";
  $tnItalyMobile2 = "39344444";
  $tnItalyMobile2Special = "39344445";
  $tnAlbaniaFixed1 = "35563333";
  $tnAlbaniaMobile1 = "3556888";

  $prefixItaly = "39";
  $prefixItalyMobie = "393";

  $r = new ArRateCategory();
  $r->setName("Normal");
  $r->save();
  $normalCategoryId = $r->getId();

  $r = new ArRateCategory();
  $r->setName("Discounted");
  $r->save();
  $discountedCategoryId = $r->getId();

  $r = new ArParty();
  $r->setCustomerOrVendor("C");
  $r->setName("Acme");
  $r->setExternalCrmCode("-");
  $r->setArRateCategoryId($normalCategoryId);
  $r->setArParamsId($defaultParamsId);
  $r->save();
  $acmePartyId = $r->getId();

  $r = new ArParty();
  $r->setCustomerOrVendor("C");
  $r->setName("Disco");
  $r->setExternalCrmCode("-");
  $r->setArRateCategoryId($discountedCategoryId);
  $r->setArParamsId($defaultParamsId);
  $r->save();
  $discountedPartyId = $r->getId();

  $r = new ArParty();
  $r->setCustomerOrVendor("V");
  $r->setName("Acme VOIP Provider");
  $r->setExternalCrmCode("-");
  $r->setArRateCategoryId(null);
  $r->setArParamsId($defaultParamsId);
  $r->save();
  $safeVoipProviderId = $r->getId();

  $r = new ArParty();
  $r->setCustomerOrVendor("V");
  $r->setName("Cheap VOIP Provider");
  $r->setExternalCrmCode("-");
  $r->setArRateCategoryId(null);
  $r->setArParamsId($defaultParamsId);
  $r->save();
  $cheapVoipProviderId = $r->getId();

  $r = new ArOffice();
  $r->setArPartyId($acmePartyId);
  $r->setName("Headquarter");
  $r->setDescription("Headquarter");
  $r->save();
  $acmeOfficeId1 = $r->getId();

  $r = new ArOffice();
  $r->setArPartyId($acmePartyId);
  $r->setName("Support");
  $r->setDescription("Support Office");
  $r->save();
  $acmeOfficeId2 = $r->getId();

  $r = new ArOffice();
  $r->setArPartyId($discountedPartyId);
  $r->setName("Main");
  $r->setDescription("Main Building");
  $r->save();
  $discountedOfficeId = $r->getId();

  $r = new ArAsteriskAccount();
  $accountCode1 = "a01";
  $r->setName("Acme 01");
  $r->setAccountcode($accountCode1);
  $r->setArOfficeId($acmeOfficeId1);
  $r->save();
  $acme01Id = $r->getId();

  $r = new ArAsteriskAccount();
  $accountCode1 = "a02";
  $r->setName("Acme 02");
  $r->setAccountcode($accountCode1);
  $r->setArOfficeId($acmeOfficeId2);
  $r->save();
  $acme02Id = $r->getId();

  $r = new ArAsteriskAccount();
  $accountCode1 = "a03";
  $r->setName("Acme 03");
  $r->setAccountcode($accountCode1);
  $r->setArOfficeId($acmeOfficeId1);
  $r->save();

  $r = new ArAsteriskAccount();
  $discountCode1 = "d01";
  $r->setName("Disco 01");
  $r->setAccountcode($discountCode1);
  $r->setArOfficeId($discountedOfficeId);
  $r->save();
  $discountedParty01Id = $r->getId();

  $r = new ArWebAccount();
  $r->setLogin("acme");
  $r->setPassword("acme");
  $r->setArPartyId($acmePartyId);
  $r->setArOfficeId(null);
  $r->setActivateAt($days15);
  $r->setDeactivateAt(null);
  $r->save();

  $r = new ArWebAccount();
  $r->setLogin("acme01");
  $r->setPassword("acme01");
  $r->setArPartyId($acmePartyId);
  $r->setArOfficeId($acmeOfficeId1);
  $r->setActivateAt($days15);
  $r->setDeactivateAt(null);
  $r->save();

  $r = new ArWebAccount();
  $r->setLogin("acme02");
  $r->setPassword("acme02");
  $r->setArPartyId($acmePartyId);
  $r->setArOfficeId($acmeOfficeId2);
  $r->setActivateAt($days15);
  $r->setDeactivateAt($days2);
  $r->save();

  // Process CDRs
  //
  $rm = new PhpCDRProcessing();
  $rm->dstChannel = "";
  $rm->disposition = "ANSWERED";
  $rm->amaflags = 0;
  $rm->destinationType = DestinationType::outgoing;

  $r = new ArRate();
  $r->setDestinationType(DestinationType::unprocessed);
  $r->setArRateCategoryId(null);
  $r->setArPartyId(null);
  $r->setStartTime($days60);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  $rm = new PhpCDRProcessing();
  $rm->dstChannel = "";
  $rm->disposition = "ANSWERED";
  $rm->amaflags = 5;
  $rm->destinationType = DestinationType::ignored;

  $r = new ArRate();
  $r->setDestinationType(DestinationType::unprocessed);
  $r->setArRateCategoryId(null);
  $r->setArPartyId(null);
  $r->setStartTime($days60);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  $rm = new PhpCDRProcessing();
  $rm->dstChannel = "";
  $rm->disposition = "NO ANSWERED";
  $rm->amaflags = 0;
  $rm->destinationType = DestinationType::ignored;

  $r = new ArRate();
  $r->setDestinationType(DestinationType::unprocessed);
  $r->setArRateCategoryId(null);
  $r->setArPartyId(null);
  $r->setStartTime($days60);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  // Customer rate (income)
  //
  $rm = new PhpRateByDuration();
  $rm->dstChannelPattern = "good";
  $rm->rateByMinute = false;
  $rm->costForMinute = 10;
  $rm->costOnCall = 5;
  $rm->atLeastXSeconds = 5;
  $rm->whenRound_0_59 = 0;
  $rm->externalTelephonePrefix = "";
  $rm->internalTelephonePrefix = "";
  
  $r = new ArRate();
  $r->setDestinationType(DestinationType::outgoing);
  $r->setArRateCategoryId($normalCategoryId);
  $r->setArPartyId(null);
  $r->setStartTime($days10);
  $r->setEndTime($days5);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  // test a rate with a more specific destination
  // number. 
  //
  $rm = new PhpRateByDuration();
  $rm->dstChannelPattern = "good";
  $rm->rateByMinute = false;
  $rm->costForMinute = 20;
  $rm->costOnCall = 5;
  $rm->atLeastXSeconds = 5;
  $rm->whenRound_0_59 = 0;
  $rm->externalTelephonePrefix = $tnItalyMobile2Special;
  $rm->internalTelephonePrefix = "";
  
  $r = new ArRate();
  $r->setDestinationType(DestinationType::outgoing);
  $r->setArRateCategoryId($normalCategoryId);
  $r->setArPartyId(null);
  $r->setStartTime($days10);
  $r->setEndTime($days5);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  // test a rate that is an exception
  //
  $rm = new PhpRateByDuration();
  $rm->dstChannelPattern = "good-exception";  // <- exception point in order to no apply to all other CDRs
  $rm->rateByMinute = false;
  $rm->costForMinute = 50;
  $rm->costOnCall = 50;
  $rm->atLeastXSeconds = 5;
  $rm->whenRound_0_59 = 0;
  $rm->externalTelephonePrefix = $tnItalyMobile2Special; // <- conflict with previous rate
  $rm->internalTelephonePrefix = "";
  
  $r = new ArRate();
  $r->setDestinationType(DestinationType::outgoing);
  $r->setArRateCategoryId($normalCategoryId);
  $r->setArPartyId(null);
  $r->setStartTime($days10);
  $r->setEndTime($days5);
  $r->setIsException(true); // <- it is an exception, otherwise there is a conflict
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  // complex calculation of rates by minute
  //
  $rm = new PhpRateByDuration();
  $rm->dstChannelPattern = "good";
  $rm->rateByMinute = true;
  $rm->costForMinute = 25;
  $rm->costOnCall = 15;
  $rm->atLeastXSeconds = 30;
  $rm->whenRound_0_59 = 5;
  $rm->externalTelephonePrefix = $prefixItaly;
  $rm->internalTelephonePrefix = "";
  
  $r = new ArRate();
  $r->setDestinationType(DestinationType::outgoing);
  $r->setArRateCategoryId($normalCategoryId);
  $r->setArPartyId(null);
  $r->setStartTime($days5);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();  

  // rates on "discount" category of costumer
  //
  $rm = new PhpRateByDuration();
  $rm->dstChannelPattern = "good";
  $rm->rateByMinute = true;
  $rm->costForMinute = 3;
  $rm->costOnCall = 0;
  $rm->atLeastXSeconds = 30;
  $rm->whenRound_0_59 = 5;
  $rm->externalTelephonePrefix = $prefixItaly;
  $rm->internalTelephonePrefix = "";
  
  $r = new ArRate();
  $r->setDestinationType(DestinationType::outgoing);
  $r->setArRateCategoryId($discountedCategoryId);
  $r->setArPartyId(null);
  $r->setStartTime($days5);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();  

  // Vendor rate (cost)
  // These rates do not change.
  //
  $rm = new PhpRateByDuration();
  $rm->dstChannelPattern = "good";
  $rm->rateByMinute = false;
  $rm->costForMinute = 5;
  $rm->costOnCall = 0;
  $rm->atLeastXSeconds = 5;
  $rm->whenRound_0_59 = 0;
  $rm->externalTelephonePrefix = "";
  $rm->internalTelephonePrefix = "";
  
  $r = new ArRate();
  $r->setDestinationType(DestinationType::outgoing);
  $r->setArRateCategoryId(null);
  $r->setArPartyId($safeVoipProviderId);
  $r->setStartTime($days10);
  $r->setEndTime($days5);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  $rm = new PhpRateByDuration();
  $rm->dstChannelPattern = "good";
  $rm->rateByMinute = false;
  $rm->costForMinute = 4;
  $rm->costOnCall = 0;
  $rm->atLeastXSeconds = 0;
  $rm->whenRound_0_59 = 0;
  $rm->externalTelephonePrefix = "";
  $rm->internalTelephonePrefix = "";
  
  $r = new ArRate();
  $r->setDestinationType(DestinationType::outgoing);
  $r->setArRateCategoryId(null);
  $r->setArPartyId($safeVoipProviderId);
  $r->setStartTime($days5);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();


  //////////////
  // Add CDRs //
  //////////////  

  // "good" channel and from $days5 and $days10
  // there are safe rates
  $cdr = new Cdr();
  $cdr->setAccountcode("a01");
  $cdr->setCalldate($days9);
  $cdr->setChannel("good");
  $cdr->setClid("-");
  $cdr->setSrc($tnItalyFixed2);
  $cdr->setDst($tnItalyFixed1);
  $cdr->setDcontext("-");
  $cdr->setDstchannel("good");
  $cdr->setLastapp("-");
  $cdr->setLastdata("-");
  $cdr->setDuration(200);
  $cdr->setBillsec(60);
  $cdr->setDisposition("ANSWERED");
  $cdr->setAmaflags(0);
  $cdr->setUserfield("100000");  
  $cdr->save();

  $cdr = new Cdr();
  $cdr->setAccountcode("a01");
  $cdr->setCalldate($days9);
  $cdr->setChannel("-");
  $cdr->setClid("-");
  $cdr->setSrc($tnItalyFixed2);
  $cdr->setDst($tnItalyFixed2);
  $cdr->setDcontext("-");
  $cdr->setDstchannel("good");
  $cdr->setLastapp("-");
  $cdr->setLastdata("-");
  $cdr->setDuration(200);
  $cdr->setBillsec(60);
  $cdr->setDisposition("ANSWERED");
  $cdr->setAmaflags(0);
  $cdr->setUserfield(0);
  $cdr->setUserfield("100000");  // earns = income - cost
  $cdr->save();

  $cdr = new Cdr();
  $cdr->setAccountcode("a01");
  $cdr->setCalldate($days9);
  $cdr->setChannel("-");
  $cdr->setClid("-");
  $cdr->setSrc($tnItalyFixed2);
  $cdr->setDst($tnItalyMobile1);
  $cdr->setDcontext("-");
  $cdr->setDstchannel("good");
  $cdr->setLastapp("-");
  $cdr->setLastdata("-");
  $cdr->setDuration(200);
  $cdr->setBillsec(60);
  $cdr->setDisposition("ANSWERED");
  $cdr->setAmaflags(0);
  $cdr->setUserfield("100000");  
  $cdr->save();

  $cdr = new Cdr();
  $cdr->setAccountcode("a01");
  $cdr->setCalldate($days9);
  $cdr->setChannel("-");
  $cdr->setClid("-");
  $cdr->setSrc($tnItalyFixed2);
  $cdr->setDst($tnItalyFixed2);
  $cdr->setDcontext("-");
  $cdr->setDstchannel("good");
  $cdr->setLastapp("-");
  $cdr->setLastdata("-");
  $cdr->setDuration(200);
  $cdr->setBillsec(80);
  $cdr->setDisposition("ANSWERED");
  $cdr->setAmaflags(0);
  $cdr->setUserfield("116666");  
  $cdr->save();
  
  // test more specific prefix rate
  //
  $cdr = new Cdr();
  $cdr->setAccountcode("a01");
  $cdr->setCalldate($days9);
  $cdr->setChannel("-");
  $cdr->setClid("-");
  $cdr->setSrc($tnItalyFixed2);
  $cdr->setDst($tnItalyMobile2Special);
  $cdr->setDcontext("-");
  $cdr->setDstchannel("good");
  $cdr->setLastapp("-");
  $cdr->setLastdata("-");
  $cdr->setDuration(200);
  $cdr->setBillsec(78);
  $cdr->setDisposition("ANSWERED");
  $cdr->setAmaflags(0);
  $cdr->setUserfield("245000");  
  $cdr->save();

  // test exception rate
  // and dstChannel matching
  //
  $cdr = new Cdr();
  $cdr->setAccountcode("a01");
  $cdr->setCalldate($days9);
  $cdr->setChannel("-");
  $cdr->setClid("-");
  $cdr->setSrc($tnItalyFixed2);
  $cdr->setDst($tnItalyMobile2Special);
  $cdr->setDcontext("-");
  $cdr->setDstchannel("good-exception"); // <- exception channel
  $cdr->setLastapp("-");
  $cdr->setLastdata("-");
  $cdr->setDuration(200);
  $cdr->setBillsec(90);
  $cdr->setDisposition("ANSWERED");
  $cdr->setAmaflags(0);
  $cdr->setUserfield("1175000");  
  $cdr->save();

  // test if DISPOSITION is checked
  //
  $cdr = new Cdr();
  $cdr->setAccountcode("a01");
  $cdr->setCalldate($days9);
  $cdr->setChannel("-");
  $cdr->setClid("-");
  $cdr->setSrc($tnItalyFixed2);
  $cdr->setDst($tnItalyMobile2Special);
  $cdr->setDcontext("-");
  $cdr->setDstchannel("good"); 
  $cdr->setLastapp("-");
  $cdr->setLastdata("-");
  $cdr->setDuration(200);
  $cdr->setBillsec(90);
  $cdr->setDisposition("NO ANSWERED"); // <- no billable disposition
  $cdr->setAmaflags(0);
  $cdr->setUserfield(null);
  $cdr->save();

  // test if AMAFLAGS is checked
  //
  $cdr = new Cdr();
  $cdr->setAccountcode("a01");
  $cdr->setCalldate($days9);
  $cdr->setChannel("-");
  $cdr->setClid("-");
  $cdr->setSrc($tnItalyFixed2);
  $cdr->setDst($tnItalyMobile2Special);
  $cdr->setDcontext("-");
  $cdr->setDstchannel("good"); 
  $cdr->setLastapp("-");
  $cdr->setLastdata("-");
  $cdr->setDuration(200);
  $cdr->setBillsec(90);
  $cdr->setDisposition("ANSWERED"); 
  $cdr->setAmaflags(5); // <- no billable amaflags
  $cdr->setUserfield(null);
  $cdr->save();

  // test complex calculations
  // and limit start/end of rate application
  //
  $cdr = new Cdr();
  $cdr->setAccountcode("a01");
  $cdr->setCalldate($days5); // <- where one rate end and another start
  $cdr->setChannel("-");
  $cdr->setClid("-");
  $cdr->setSrc($tnItalyFixed2);
  $cdr->setDst($tnItalyFixed1);
  $cdr->setDcontext("-");
  $cdr->setDstchannel("good"); 
  $cdr->setLastapp("-");
  $cdr->setLastdata("-");
  $cdr->setDuration(200);
  $cdr->setBillsec(90);
  $cdr->setDisposition("ANSWERED"); 
  $cdr->setAmaflags(0);
  $cdr->setUserfield("590000");
  $cdr->save();

  $cdr = new Cdr();
  $cdr->setAccountcode("a01");
  $cdr->setCalldate($days5); // <- where one rate end and another start
  $cdr->setChannel("-");
  $cdr->setClid("-");
  $cdr->setSrc($tnItalyFixed2);
  $cdr->setDst($tnItalyFixed1);
  $cdr->setDcontext("-");
  $cdr->setDstchannel("good"); 
  $cdr->setLastapp("-");
  $cdr->setLastdata("-");
  $cdr->setDuration(200);
  $cdr->setBillsec(123);
  $cdr->setDisposition("ANSWERED"); 
  $cdr->setAmaflags(0); 
  $cdr->setUserfield("568000");
  $cdr->save();

  $cdr = new Cdr();
  $cdr->setAccountcode("a01");
  $cdr->setCalldate($days1); // <- where one rate end and another start
  $cdr->setChannel("-");
  $cdr->setClid("-");
  $cdr->setSrc($tnItalyFixed2);
  $cdr->setDst($tnItalyFixed1);
  $cdr->setDcontext("-");
  $cdr->setDstchannel("good"); 
  $cdr->setLastapp("-");
  $cdr->setLastdata("-");
  $cdr->setDuration(200);
  $cdr->setBillsec(124);
  $cdr->setDisposition("ANSWERED"); 
  $cdr->setAmaflags(0); 
  $cdr->setUserfield("567333");
  $cdr->save();

  $cdr = new Cdr();
  $cdr->setAccountcode("a01");
  $cdr->setCalldate($days5); // <- where one rate end and another start
  $cdr->setChannel("-");
  $cdr->setClid("-");
  $cdr->setSrc($tnItalyFixed2);
  $cdr->setDst($tnItalyFixed1);
  $cdr->setDcontext("-");
  $cdr->setDstchannel("good"); 
  $cdr->setLastapp("-");
  $cdr->setLastdata("-");
  $cdr->setDuration(200);
  $cdr->setBillsec(125);
  $cdr->setDisposition("ANSWERED"); 
  $cdr->setAmaflags(0); 
  $cdr->setUserfield("816667");
  $cdr->save();

  $cdr = new Cdr();
  $cdr->setAccountcode("a01");
  $cdr->setCalldate($days1); 
  $cdr->setChannel("-");
  $cdr->setClid("-");
  $cdr->setSrc($tnItalyFixed2);
  $cdr->setDst($tnItalyFixed1);
  $cdr->setDcontext("-");
  $cdr->setDstchannel("good"); 
  $cdr->setLastapp("-");
  $cdr->setLastdata("-");
  $cdr->setDuration(200);
  $cdr->setBillsec(5);
  $cdr->setDisposition("ANSWERED"); 
  $cdr->setAmaflags(0); 
  $cdr->setUserfield("396667");
  $cdr->save();

  // test the filter on discounted costumer category
  //
  $cdr = new Cdr();
  $cdr->setAccountcode($discountCode1);
  $cdr->setCalldate($days0); 
  $cdr->setChannel("-");
  $cdr->setClid("-");
  $cdr->setSrc($tnItalyFixed2);
  $cdr->setDst($tnItalyFixed1);
  $cdr->setDcontext("-");
  $cdr->setDstchannel("good"); 
  $cdr->setLastapp("-");
  $cdr->setLastdata("-");
  $cdr->setDuration(200);
  $cdr->setBillsec(15);
  $cdr->setDisposition("ANSWERED"); 
  $cdr->setAmaflags(0); 
  $cdr->setUserfield("20000");
  $cdr->save();
  
  $cdr = new Cdr();
  $cdr->setAccountcode($discountCode1);
  $cdr->setCalldate($days0); 
  $cdr->setChannel("-");
  $cdr->setClid("-");
  $cdr->setSrc($tnItalyFixed2);
  $cdr->setDst($tnItalyMobile1);
  $cdr->setDcontext("-");
  $cdr->setDstchannel("good"); 
  $cdr->setLastapp("-");
  $cdr->setLastdata("-");
  $cdr->setDuration(200);
  $cdr->setBillsec(657);
  $cdr->setDisposition("ANSWERED"); 
  $cdr->setAmaflags(0); 
  $cdr->setUserfield("-108000");  // <- negative value
  $cdr->save();
  
  $cdr = new Cdr();
  $cdr->setAccountcode($accountCode1);
  $cdr->setCalldate($days0); 
  $cdr->setChannel("-");
  $cdr->setClid("-");
  $cdr->setSrc($tnItalyFixed2);
  $cdr->setDst($tnItalyMobile1);
  $cdr->setDcontext("-");
  $cdr->setDstchannel("good"); 
  $cdr->setLastapp("-");
  $cdr->setLastdata("-");
  $cdr->setDuration(200);
  $cdr->setBillsec(657);
  $cdr->setDisposition("ANSWERED"); 
  $cdr->setAmaflags(0); 
  $cdr->setUserfield("2462000");  // <- negative value
  $cdr->save();

  $cdr = new Cdr();
  $cdr->setAccountcode($accountCode1);
  $cdr->setCalldate($days0); 
  $cdr->setChannel("-");
  $cdr->setClid("-");
  $cdr->setSrc($tnItalyFixed2);
  $cdr->setDst($tnItalyMobile1);
  $cdr->setDcontext("-");
  $cdr->setDstchannel("good"); 
  $cdr->setLastapp("-");
  $cdr->setLastdata("-");
  $cdr->setDuration(200);
  $cdr->setBillsec(956);
  $cdr->setDisposition("ANSWERED"); 
  $cdr->setAmaflags(0); 
  $cdr->setUserfield("3512667");  // <- negative value
  $cdr->save();

  $cdr = new Cdr();
  $cdr->setAccountcode($accountCode1);
  $cdr->setCalldate($days1); 
  $cdr->setChannel("-");
  $cdr->setClid("-");
  $cdr->setSrc($tnItalyFixed1);
  $cdr->setDst($tnItalyMobile2);
  $cdr->setDcontext("-");
  $cdr->setDstchannel("good"); 
  $cdr->setLastapp("-");
  $cdr->setLastdata("-");
  $cdr->setDuration(200);
  $cdr->setBillsec(45);
  $cdr->setDisposition("ANSWERED"); 
  $cdr->setAmaflags(0); 
  $cdr->setUserfield("370000");  // <- negative value
  $cdr->save();

  return $defaultParamsId;
}

/**
 * Check if added CDRs respect regression tests.
 */
function checkRegressionData() {

  // Rate all calls
  //
  $rateCalls = new RateCalls();
  $rateCalls->process();

  $c = new Criteria();
  $cdrs = CdrPeer::doSelect($c);
 
  $tot = 0;
  $bad = 0;
 
  foreach ($cdrs as $cdr) {
    $tot++;
    $id = $cdr->getId();
    $income = $cdr->getIncome();
    $cost = $cdr->getCost();
    $calcEarn = $cdr->getUserfield();
    
    if (! is_null($income)) {
      $earn = $income - $cost;
      
      if ($earn != $calcEarn) {
        echo "\nCDR with id $id has earned $earn different from expected $calcEarn";
	$bad++;
      }
    } else {
      if (! is_null($calcEarn)) {
        echo "\nCDR with id $id has rate error different from expected $calcEarn";
	$bad++;
      }
    }
  }
  
  echo "\nChecked $tot cdrs and there are $bad errors\n";
}

/**
 * Reset the DB and add demo data useful for starting Asterisell with Demo Data.
 *
 * @return the default paramsId
 */
function initWithDemoData($recordsToAdd) {
try {
  deleteAllData();

  // Create dates starting from current time.
  // This allows to create more "user friendly"
  // demo-data.
  //
  $past = pastDays(365*2);

  // Create default params
  //
  echo "\nCreating default Params";
  $defaultParamsId = createDefaultParams();

  echo "\nCreating Categories and Parties";

  $r = new ArRateCategory();
  $r->setName("Normal");
  $r->save();
  $normalCategoryId = $r->getId();

  $r = new ArRateCategory();
  $r->setName("Discounted");
  $r->save();
  $discountedCategoryId = $r->getId();

  $r = new ArParty();
  $r->setCustomerOrVendor("V");
  $r->setName("VoIP Provider");
  $r->setArRateCategoryId(null);
  $r->setArParamsId($defaultParamsId);
  $r->setVat("WRLD1111115555"); 
  $r->setLegalAddress("Street Edison, 2");
  $r->setLegalCity("Someplace");
  $r->setLegalZipcode("41055");
  $r->setLegalStateProvince("Texas");
  $r->setLegalCountry("USA");
  $r->setEmail("alpha@example.com");
  $r->save();
  $defaultVendorId = $r->getId();

  echo "\nCreating Rates";

  //////////////////
  // System rates //
  //////////////////
  //
  // disposition ANSWERED
  //             NO ANSWERED
  //
  // dstChannel incoming    => incoming
  //            outgoing    => outgoing
  //            internal    => internal
  //
  // amaflags   always 0 

  $rm = new PhpCDRProcessing();
  $rm->dstChannel = "outgoing";
  $rm->disposition = "ANSWERED";
  $rm->amaflags = 0;
  $rm->destinationType = DestinationType::outgoing;
  $r = new ArRate();
  $r->setDestinationType(DestinationType::unprocessed);
  $r->setArRateCategoryId(null);
  $r->setArPartyId(null);
  $r->setStartTime($past);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();
  
  $rm = new PhpCDRProcessing();
  $rm->dstChannel = "incoming";
  $rm->disposition = "ANSWERED";
  $rm->amaflags = 0;
  $rm->destinationType = DestinationType::incoming;
  $r = new ArRate();
  $r->setDestinationType(DestinationType::unprocessed);
  $r->setArRateCategoryId(null);
  $r->setArPartyId(null);
  $r->setStartTime($past);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  $rm = new PhpCDRProcessing();
  $rm->dstChannel = "internal";
  $rm->disposition = "ANSWERED";
  $rm->amaflags = 0;
  $rm->destinationType = DestinationType::internal;
  $r = new ArRate();
  $r->setDestinationType(DestinationType::unprocessed);
  $r->setArRateCategoryId(null);
  $r->setArPartyId(null);
  $r->setStartTime($past);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  $rm = new PhpCDRProcessing();
  $rm->dstChannel = "";
  $rm->disposition = "NO ANSWERED";
  $rm->amaflags = 0;
  $rm->destinationType = DestinationType::ignored;
  $r = new ArRate();
  $r->setDestinationType(DestinationType::unprocessed);
  $r->setArRateCategoryId(null);
  $r->setArPartyId(null);
  $r->setStartTime($past);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  //////////////////
  // Normal Rates //
  //////////////////

  $rm = new PhpRateByDuration();
  $rm->dstChannelPattern = "";
  $rm->rateByMinute = false;
  $rm->costForMinute = 1;
  $rm->costOnCall = 0;
  $rm->atLeastXSeconds = 0;
  $rm->whenRound_0_59 = 0;
  $rm->externalTelephonePrefix = "";
  $rm->internalTelephonePrefix = "";
  $r = new ArRate();
  $r->setDestinationType(DestinationType::outgoing);
  $r->setArRateCategoryId($normalCategoryId);
  $r->setArPartyId(null);
  $r->setStartTime($past);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  $rm = new PhpRateByDuration();
  $rm->dstChannelPattern = "";
  $rm->rateByMinute = false;
  $rm->costForMinute = 0.8;
  $rm->costOnCall = 0;
  $rm->atLeastXSeconds = 0;
  $rm->whenRound_0_59 = 0;
  $rm->externalTelephonePrefix = "";
  $rm->internalTelephonePrefix = "";
  $r = new ArRate();
  $r->setDestinationType(DestinationType::outgoing);
  $r->setArRateCategoryId($discountedCategoryId);
  $r->setArPartyId(null);
  $r->setStartTime($past);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  $rm = new PhpRateByDuration();
  $rm->dstChannelPattern = "";
  $rm->rateByMinute = false;
  $rm->costForMinute = 0.5;
  $rm->costOnCall = 0;
  $rm->atLeastXSeconds = 0;
  $rm->whenRound_0_59 = 0;
  $rm->externalTelephonePrefix = "";
  $rm->internalTelephonePrefix = "";
    $r = new ArRate();
  $r->setDestinationType(DestinationType::outgoing);
  $r->setArRateCategoryId(null);
  $r->setArPartyId($defaultVendorId);
  $r->setStartTime($past);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  $rm = new PhpRateByDuration();
  $rm->dstChannelPattern = "";
  $rm->rateByMinute = false;
  $rm->costForMinute = 0;
  $rm->costOnCall = 0;
  $rm->atLeastXSeconds = 0;
  $rm->whenRound_0_59 = 0;
  $rm->externalTelephonePrefix = "";
  $rm->internalTelephonePrefix = "";
  $r = new ArRate();
  $r->setDestinationType(DestinationType::internal);
  $r->setArRateCategoryId(null);
  $r->setArPartyId($defaultVendorId);
  $r->setStartTime($past);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  $rm = new PhpRateByDuration();
  $rm->dstChannelPattern = "";
  $rm->rateByMinute = false;
  $rm->costForMinute = 0;
  $rm->costOnCall = 0;
  $rm->atLeastXSeconds = 0;
  $rm->whenRound_0_59 = 0;
  $rm->externalTelephonePrefix = "";
  $rm->internalTelephonePrefix = "";
  $r = new ArRate();
  $r->setDestinationType(DestinationType::internal);
  $r->setArRateCategoryId($normalCategoryId);
  $r->setArPartyId(null);
  $r->setStartTime($past);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  $rm = new PhpRateByDuration();
  $rm->dstChannelPattern = "";
  $rm->rateByMinute = false;
  $rm->costForMinute = 0;
  $rm->costOnCall = 0;
  $rm->atLeastXSeconds = 0;
  $rm->whenRound_0_59 = 0;
  $rm->externalTelephonePrefix = "";
  $rm->internalTelephonePrefix = "";
  $r = new ArRate();
  $r->setDestinationType(DestinationType::internal);
  $r->setArRateCategoryId($discountedCategoryId);
  $r->setArPartyId(null);
  $r->setStartTime($past);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  $rm = new PhpRateByDuration();
  $rm->dstChannelPattern = "";
  $rm->rateByMinute = false;
  $rm->costForMinute = 0;
  $rm->costOnCall = -0.05;
  $rm->atLeastXSeconds = 0;
  $rm->whenRound_0_59 = 0;
  $rm->externalTelephonePrefix = "";
  $rm->internalTelephonePrefix = "";
  $r = new ArRate();
  $r->setDestinationType(DestinationType::incoming);
  $r->setArRateCategoryId($normalCategoryId);
  $r->setArPartyId(null);
  $r->setStartTime($past);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  $rm = new PhpRateByDuration();
  $rm->dstChannelPattern = "";
  $rm->rateByMinute = false;
  $rm->costForMinute = 0;
  $rm->costOnCall = -0.05;
  $rm->atLeastXSeconds = 0;
  $rm->whenRound_0_59 = 0;
  $rm->externalTelephonePrefix = "";
  $rm->internalTelephonePrefix = "";
  $r = new ArRate();
  $r->setDestinationType(DestinationType::incoming);
  $r->setArRateCategoryId($discountedCategoryId);
  $r->setArPartyId(null);
  $r->setStartTime($past);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  $rm = new PhpRateByDuration();
  $rm->dstChannelPattern = "";
  $rm->rateByMinute = false;
  $rm->costForMinute = 0;
  $rm->costOnCall = -0.1;
  $rm->atLeastXSeconds = 0;
  $rm->whenRound_0_59 = 0;
  $rm->externalTelephonePrefix = "";
  $rm->internalTelephonePrefix = "";
  $r = new ArRate();
  $r->setDestinationType(DestinationType::incoming);
  $r->setArRateCategoryId(null);
  $r->setArPartyId($defaultVendorId);
  $r->setStartTime($past);
  $r->setEndTime(null);
  $r->setIsException(false);
  $r->setPhpClassSerialization(serialize($rm));
  $r->save();

  ////////////////////////
  // Add prefixes table //
  ////////////////////////

  loadPrefixes("world_prefix_table.csv", FALSE);

  // Special numbers
  //
  $tnItalyFixed1 = "391111111";
  $tnItalyFixed2 = "392222222";
  $tnItalyMobile1 = "39333333";
  $tnItalyMobile2 = "39344444";
  $tnItalyMobile2Special = "39344445";
  $tnAlbaniaFixed1 = "35563333";
  $tnAlbaniaMobile1 = "3556888";

  $prefixItaly = "39";
  $prefixItalyMobie = "393";

  ///////////////////////////
  // CUSTOMERS AND VENDORS //
  ///////////////////////////

  $r = new ArParty();
  $r->setCustomerOrVendor("C");
  $r->setName("Alpha");
  $r->setExternalCrmCode("");
  $r->setArRateCategoryId($normalCategoryId);
  $r->setArParamsId($defaultParamsId);
  $r->setVat("WRLD1111113333"); 
  $r->setLegalAddress("Street Avenue, 1");
  $r->setLegalCity("Soliera");
  $r->setLegalZipcode("41019");
  $r->setLegalStateProvince("Modena");
  $r->setLegalCountry("Italy");
  $r->setEmail("alpha@example.com");
  $r->save();
  $alphaPartyId = $r->getId();

  $r = new ArParty();
  $r->setCustomerOrVendor("C");
  $r->setName("Beta");
  $r->setExternalCrmCode("");
  $r->setArRateCategoryId($normalCategoryId);
  $r->setArParamsId($defaultParamsId);
  $r->setVat("WRLD1111113333"); 
  $r->setLegalAddress("Street Avenue, 12");
  $r->setLegalCity("Soliera");
  $r->setLegalZipcode("41019");
  $r->setLegalStateProvince("Modena");
  $r->setLegalCountry("Italy");
  $r->setEmail("beta@example.com");
  $r->save();
  $betaPartyId = $r->getId();

  $r = new ArParty();
  $r->setCustomerOrVendor("C");
  $r->setName("Gamma");
  $r->setExternalCrmCode("");
  $r->setArRateCategoryId($discountedCategoryId);
  $r->setArParamsId($defaultParamsId);
  $r->setVat("WRLD1111117777"); 
  $r->setLegalAddress("Street Avenue, 123");
  $r->setLegalCity("Soliera");
  $r->setLegalZipcode("41019");
  $r->setLegalStateProvince("Modena");
  $r->setLegalCountry("Italy");
  $r->setEmail("gamma@example.com");
  $r->save();
  $gammaPartyId = $r->getId();

  /////////////
  // OFFICES //
  /////////////
  
  $r = new ArOffice();
  $r->setArPartyId($alphaPartyId);
  $r->setName("Main");
  $r->save();
  $alphaOfficeId1 = $r->getId();

  $r = new ArOffice();
  $r->setArPartyId($betaPartyId);
  $r->setName("Store");
  $r->save();
  $betaOfficeId1 = $r->getId();

  $r = new ArOffice();
  $r->setArPartyId($betaPartyId);
  $r->setName("Administration");
  $r->save();
  $betaOfficeId2 = $r->getId();

  $r = new ArOffice();
  $r->setArPartyId($gammaPartyId);
  $r->setName("Store");
  $r->save();
  $gammaOfficeId1 = $r->getId();

  $r = new ArOffice();
  $r->setArPartyId($gammaPartyId);
  $r->setName("Administration");
  $r->save();
  $gammaOfficeId2 = $r->getId();


  ///////////////////////
  // ASTERISK ACCOUNTS //
  ///////////////////////

  $r = new ArAsteriskAccount();
  $r->setName("alpha1");
  $r->setAccountcode("alpha1");
  $r->setArOfficeId($alphaOfficeId1);
  $r->save();
  $alphaAccount1Id = $r->getId();

  $r = new ArAsteriskAccount();
  $r->setName("beta1");
  $r->setAccountcode("beta1");
  $r->setArOfficeId($betaOfficeId1);
  $r->save();
  $betaAccount1Id = $r->getId();

  $r = new ArAsteriskAccount();
  $r->setName("beta2");
  $r->setAccountcode("beta2");
  $r->setArOfficeId($betaOfficeId2);
  $r->save();
  $betaAccount2Id = $r->getId();

  $r = new ArAsteriskAccount();
  $r->setName("gamma1");
  $r->setAccountcode("gamma1");
  $r->setArOfficeId($gammaOfficeId1);
  $r->save();
  $gammaAccount1Id = $r->getId();

  $r = new ArAsteriskAccount();
  $r->setName("gamma2");
  $r->setAccountcode("gamma2");
  $r->setArOfficeId($gammaOfficeId2);
  $r->save();
  $gammaAccount2Id = $r->getId();

  $r = new ArAsteriskAccount();
  $r->setName("gamma3");
  $r->setAccountcode("gamma3");
  $r->setArOfficeId($gammaOfficeId2);
  $r->save();
  $gammaAccount3Id = $r->getId();

  /////////////////////////
  // WEB ACCESS ACCOUNTS //
  /////////////////////////

  $r = new ArWebAccount();
  $r->setLogin("admin");
  $r->setPassword("admin");
  $r->setArPartyId(null);
  $r->setArOfficeId(null);
  $r->setActivateAt($past);
  $r->setDeactivateAt(null);
  $r->save();

  $r = new ArWebAccount();
  $r->setLogin("alpha");
  $r->setPassword("alpha");
  $r->setArPartyId($alphaPartyId);
  $r->setArOfficeId(null);
  $r->setActivateAt($past);
  $r->setDeactivateAt(null);
  $r->save();

  $r = new ArWebAccount();
  $r->setLogin("beta");
  $r->setPassword("beta");
  $r->setArPartyId($betaPartyId);
  $r->setArOfficeId(null);
  $r->setActivateAt($past);
  $r->setDeactivateAt(null);
  $r->save();

  $r = new ArWebAccount();
  $r->setLogin("gamma");
  $r->setPassword("gamma");
  $r->setArPartyId($gammaPartyId);
  $r->setArOfficeId(null);
  $r->setActivateAt($past);
  $r->setDeactivateAt(null);
  $r->save();

  $r = new ArWebAccount();
  $r->setLogin("store");
  $r->setPassword("store");
  $r->setArPartyId($gammaPartyId);
  $r->setArOfficeId($gammaOfficeId1);
  $r->setActivateAt($past);
  $r->setDeactivateAt(null);
  $r->save();

  //////////////
  // Add CDRs //
  //////////////  

  $telephone_numbers = array("3905956565656", 
			   "3905194234234",
			   "3932894234234",
			   "3933394234234",
			   "3944894234234",
			   "545494234234234",
			   "54544234234234",
			   "54541111122333",
			   "545491234333",
			   "559872342333",
			   "5599721234333",
			   "559993423423423",
			   "559993423423423",
			   "55999342342423",
			   "559993422368",
			   "5599934239999",
			   "17094234234234",
			   "17077824234234",
			   "17077824234234",
			   "17077824666544",
			   "17077824456453",
			   "861893345345345",
			   "861893345234234",
			   "861893343333",
			   "86189334534434",
			   "8622242342344",
			   "8623423442444",
			   "86234234424234",
			   "8623423442898",
			   "8623423442978",
			   "454288234234",
			   "454288234234",
			   "4542882344563",
			   "45428823466467",
			   "45428823426868",
			   "454253811231234",
			   "454253811231234",
			   "4542538112334534",
			   "33607345345345",
			   "3360734534523423",
			   "336073453453345",
			   "33607345345666",
			   "33607345348887",
			   "3360734534598989",
			   "33607345345385645",
			   "33677222343434",
			   "3367722555664",
			   "33677222366546",
			   "336772223466565");

  $ar_asterisk_accounts = array("alpha1", "beta1", "beta2", "gamma1", "gamma2", "gamma3");
  $ar_channels = array("incoming", "outgoing", "internal");
  $ar_dispositions = array("ANSWERED", "NO ANSWERED");
  $ar_amaflags = array(0);

  $daysRange = 30*2;

  for($i = 1; $i <= $recordsToAdd; $i++) {
    if ($i % 1000 == 0) {
      echo "\nAdded $i CDR demo records\n";
    }
    addRandomCDR(
      $ar_asterisk_accounts,
      $daysRange,
      $ar_channels,
      $ar_dispositions,
      $ar_amaflags,
      $telephone_numbers);
  }

  echo "\nAdded $recordsToAdd CDR demo records.\n";

  
} catch (Exception $e) {
    echo "Caught exceptio: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
}

/**
 * @return a random element of an array
 */
function my_array_rand($arr) {
  $k = array_rand($arr);
  return $arr[$k];
}

/**
 * Generate a random CDR
 */
function addRandomCDR(
  $ar_asterisk_accounts,
  $daysRange,
  $ar_channels,
  $ar_dispositions,
  $ar_amaflags,
  $telephone_numbers) {

  $secs = rand(0, $daysRange * 24 * 60 * 60);
  $date = time() - $secs;
  $duration = rand(0, 60*5);

  $cdr = new Cdr();
  $cdr->setCalldate($date);
  $cdr->setAccountcode(my_array_rand($ar_asterisk_accounts));
  $cdr->setDst(my_array_rand($telephone_numbers));
  $cdr->setDstchannel(my_array_rand($ar_channels));
  $cdr->setDisposition(my_array_rand($ar_dispositions));
  $cdr->setAmaflags(my_array_rand($ar_amaflags));
  $cdr->setBillsec($duration);
  $cdr->setDuration($duration);
  $cdr->save();
}


function displayUsage() {
    echo "\nUsage:";
    echo "\n  php reset_db_and_init_data.php root <some-password>";
    echo "\n      add a root user, with some-password to an existing database";
    echo "\n";
    echo "\n  php reset_db_and_init_data.php init <some-password>";
    echo "\n      create an empty DB with minimal initial data, and a root user with some-password\n";
    echo "\n";
    echo "\n  php reset_db_and_init_data.php demo <some-password>";
    echo "\n      create an empty DB with demo data, and a root user with some-password\n";
    echo "\n";
    echo "\n  php reset_db_and_init_data.php stress-demo-data <some-password> <nr-of-cdr-records>";
    echo "\n      create a demo database with (many) random CDR records. NOTE that database speed depends not from total number of CDRs, but from the CDRs in the last 2-30 days, because all other CDRs are rarely accessed from queries.\n";
    echo "\n";
    echo "\n  php reset_db_and_init_data.php regression <some-password>";
    echo "\n      create an empty DB with regression data, and a root user with some-password\n";
    echo "\n";
    echo "\n  php reset_db_and_init_data.php reset <some-password>";
    echo "\n      reset all the content of current db without loading any data.\n";
    echo "\n";
    echo "\n  php reset_db_and_init_data.php merge-telephone-prefixes ";
    echo "\n      add new telephone prefixes to the telephone prefix table.\n";
    echo "\n";

}

/**
 * The entry point of the script.
 */
function main($argc, $argv) {

  $command = $argv[1];
  $password = $argv[2];
  $options = $argv[3];

  if ($command === "root") {
    $paramsId = createDefaultParams();
    addRootUser($password, $paramsId);
  } else if ($command === "init") {
    list($paramsId, $normalCategoryId, $discountedCategoryId, $defaultVendorId) = initWithDefaultData();
    addRootUser($password, $paramsId);
  } else if ($command === "demo") {
    $paramsId = initWithDemoData(3000);
    addRootUser($password, $paramsId);
  } else if ($command === "stress-demo-data") {
    $paramsId = initWithDemoData(intval($options));
    addRootUser($password, $paramsId);
  } else if ($command === "regression") {
    if (trim(sfConfig::get('app_internal_external_telephone_numbers')) === "3") {
      echo "\napp_internal_external_telephone_numbers must be 0 for regression tests\n";
      echo "\nTests are not performed!\n";
      exit(0);
    }
    $paramsId = initWithRegressionData();
    checkRegressionData();
    addRootUser($password, $paramsId);
  } else if ($command === "reset") {
    deleteAllData();
  } else if ($command === "merge-telephone-prefixes") {
    addNewTelephonePrefixes();
  } else {
    displayUsage();
    exit(1);
  }

  echo "\nExecute all pending jobs.\n";
  
  runJobProcessorQueue();

  echo "\n";

}

?>