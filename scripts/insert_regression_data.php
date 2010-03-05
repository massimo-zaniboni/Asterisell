<?php

define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'asterisell');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

sfContext::getInstance();

makeTest();

function myDelete($c, $t) {
  $query = "DELETE FROM $t";
  $s = $c->executeUpdate($query);
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

function deleteAllData() {
  // Delete all data from database.
  //
  $connection = Propel::getConnection();
  myDelete($connection, "ar_invoice_creation");
  myDelete($connection, "ar_invoice");
  myDelete($connection, "ar_problem");
  myDelete($connection, "cdr");
  myDelete($connection, "ar_rate");
  myDelete($connection, "ar_web_account");
  myDelete($connection, "ar_asterisk_account");
  myDelete($connection, "ar_party");
  myDelete($connection, "ar_telephone_prefix");
  myDelete($connection, "ar_rate_category");
}


function createPrefix($pType, $pPlace, $pPrefix) {
  $r = new ArTelephonePrefix();
  $r->setPrefix($pPrefix);
  $r->setName(null);
  $r->setGeographicLocation($pPlace);
  $r->setOperatorType($pType);
  $r->save();
}

function createPrefixes() {
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
}


function makeTest() {

  deleteAllData();
  createPrefixes();

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
  $r->save();
  $acmePartyId = $r->getId();

  $r = new ArParty();
  $r->setCustomerOrVendor("C");
  $r->setName("Disco");
  $r->setExternalCrmCode("-");
  $r->setArRateCategoryId($discountedCategoryId);
  $r->save();
  $discountedPartyId = $r->getId();

  $r = new ArParty();
  $r->setCustomerOrVendor("V");
  $r->setName("Acme VOIP Provider");
  $r->setExternalCrmCode("-");
  $r->setArRateCategoryId(null);
  $r->save();
  $safeVoipProviderId = $r->getId();

  $r = new ArParty();
  $r->setCustomerOrVendor("V");
  $r->setName("Cheap VOIP Provider");
  $r->setExternalCrmCode("-");
  $r->setArRateCategoryId(null);
  $r->save();
  $cheapVoipProviderId = $r->getId();

  $r = new ArAsteriskAccount();
  $accountCode1 = "a01";
  $r->setName("Acme 01");
  $r->setAccountcode($accountCode1);
  $r->setArPartyId($acmePartyId);
  $r->save();
  $acme01Id = $r->getId();

  $r = new ArAsteriskAccount();
  $accountCode1 = "a02";
  $r->setName("Acme 02");
  $r->setAccountcode($accountCode1);
  $r->setArPartyId($acmePartyId);
  $r->save();
  $acme02Id = $r->getId();

  $r = new ArAsteriskAccount();
  $accountCode1 = "a03";
  $r->setName("Acme 03");
  $r->setAccountcode($accountCode1);
  $r->setArPartyId($acmePartyId);
  $r->save();

  $r = new ArAsteriskAccount();
  $discountCode1 = "d01";
  $r->setName("Disco 01");
  $r->setAccountcode($discountCode1);
  $r->setArPartyId($discountedPartyId);
  $r->save();
  $discountedParty01Id = $r->getId();

  $r = new ArWebAccount();
  $r->setLogin("root");
  $r->setPassword("root");
  $r->setArPartyId(null);
  $r->setArAsteriskAccountId(null);
  $r->setActivateAt($days15);
  $r->setDeactivateAt(null);
  $r->save();

  $r = new ArWebAccount();
  $r->setLogin("acme");
  $r->setPassword("acme");
  $r->setArPartyId($acmePartyId);
  $r->setArAsteriskAccountId(null);
  $r->setActivateAt($days15);
  $r->setDeactivateAt(null);
  $r->save();

  $r = new ArWebAccount();
  $r->setLogin("acme01");
  $r->setPassword("acme01");
  $r->setArPartyId(null);
  $r->setArAsteriskAccountId($acme01Id);
  $r->setActivateAt($days15);
  $r->setDeactivateAt(null);
  $r->save();

  $r = new ArWebAccount();
  $r->setLogin("acme02");
  $r->setPassword("acme02");
  $r->setArPartyId(null);
  $r->setArAsteriskAccountId($acme02Id);
  $r->setActivateAt($days15);
  $r->setDeactivateAt($days2);
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
  $rm->destinationTelephonePrefix = "";
  $rm->sourceTelephonePrefix = "";
  
  $r = new ArRate();
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
  $rm->destinationTelephonePrefix = $tnItalyMobile2Special;
  $rm->sourceTelephonePrefix = "";
  
  $r = new ArRate();
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
  $rm->destinationTelephonePrefix = $tnItalyMobile2Special; // <- conflict with previous rate
  $rm->sourceTelephonePrefix = "";
  
  $r = new ArRate();
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
  $rm->destinationTelephonePrefix = $prefixItaly;
  $rm->sourceTelephonePrefix = "";
  
  $r = new ArRate();
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
  $rm->destinationTelephonePrefix = $prefixItaly;
  $rm->sourceTelephonePrefix = "";
  
  $r = new ArRate();
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
  $rm->destinationTelephonePrefix = "";
  $rm->sourceTelephonePrefix = "";
  
  $r = new ArRate();
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
  $rm->destinationTelephonePrefix = "";
  $rm->sourceTelephonePrefix = "";
  
  $r = new ArRate();
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


}
?>