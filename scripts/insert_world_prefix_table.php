<?php

define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'asterisell');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       true);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

sfContext::getInstance();

// Delete all data from database.
//
$connection = Propel::getConnection();

$r = new ArRate();

$fileName = "world_prefix_table.csv";
$fd = fopen($fileName, "r");
$rm = new PhpRateImportFromCSV();

$rm->isThereHeader = false;
$rm->isThereNameOfOperator = true;
$rm->isThereTypeOfOperator = true;
$rm->isThereGeographicalLocation = true;
$rm->rateByMinute = false; 
$rm->isThereMinimumBillableSeconds = false;
$rm->isThereCostOnCall = false;
$rm->isThereWhenRound_0_59 = false;
$rm->updatePrefixTable = true;
$rm->decimalSeparatorSymbol = ".";

$isOk = $rm->processCSVFile($fd, $r, true);
if ($isOk) {
  echo "\nImport successful";
} else {
  echo "\nError during importing of $fileName";
}
fclose($fd);
?>