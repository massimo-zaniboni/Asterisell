<?php

  // Load default parameters, used for generating a module.

// Load Symfony/Asterisell Environment
//
define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/../..'));
define('SF_APP',         'asterisell');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

sfContext::getInstance();

$generateForCustomer = FALSE;
$generateForAdmin = FALSE;
$generateForOffice = FALSE;

$parentClassName = "";
$prefixParentClassName = "";
$className = "";
$prefixClassName = "";
$middleClassName = "";
$suffixClassName = "call_reportActions";

$moduleName = "";

$modulePrefix = "";
$moduleMiddle = "";
$moduleSuffix = "call_report";

if ($argv[1] == "customer") {
  $generateForCustomer = TRUE;
  $prefixClassName = "customer";
  $prefixParentClassName = "autoCustomer";
  $modulePrefix = "customer";
 } else if ($argv[1] == "office") {
  $generateForOffice = TRUE;
  $prefixClassName = "office";
  $prefixParentClassName = "autoOffice";
  $modulePrefix = "office";
} else if ($argv[1] == "admin") {
  $generateForAdmin = TRUE;
  $prefixClassName = "admin";
  $prefixParentClassName = "autoAdmin";
  $modulePrefix = "admin";
} else {
  die("Invalid first parameter. Use \"customer\" or \"admin\" or \"office\"");
}

if ($argv[2] == "t") {
  $showOffice = TRUE;
  $middleClassName .= "t";
  $moduleMiddle .= "t";
} else if ($argv[2] == "f") {
  $showOffice = FALSE;
  $middleClassName .= "f";
  $moduleMiddle .= "f";
} else {
  die("Invalid second parameter. Use \"t\" or \"f\"");
}

if ($argv[3] == "t") {
  $showAccount = TRUE;
  $middleClassName .= "t";
  $moduleMiddle .= "t";
} else if ($argv[3] == "f") {
  $showAccount = FALSE;
  $middleClassName .= "f";
  $moduleMiddle .= "f";
} else {
  die("Invalid third parameter. Use \"t\" or \"f\"");
}

$className = $prefixClassName . "_" . $middleClassName . "_" . $suffixClassName;
$parentClassName = $prefixParentClassName . "_" . $middleClassName . "_" . $suffixClassName;

$moduleName = $modulePrefix . "_" . $moduleMiddle . "_" . $moduleSuffix;

if (sfConfig::get('app_show_call_direction')) {
  $displayCallDirection = TRUE;
} else {
  $displayCallDirection = FALSE;
}

if (sfConfig::get('app_show_filter_on_call_direction')) {
  $displayFilterOnCallDirection  = TRUE;
} else {
  $displayFilterOnCallDirection = FALSE;
}

// an admin must view always the call direction
//
if ($generateForAdmin) {
  $displayCallDirection = TRUE;
  $displayFilterOnCallDirection = TRUE;
}

?>
