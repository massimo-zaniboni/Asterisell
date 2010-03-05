<?php

if ($argc == 2) {

  $password = $argv[1];

  define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
  define('SF_APP',         'asterisell');
  define('SF_ENVIRONMENT', 'prod');
  define('SF_DEBUG',       true);
  
  require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');
  
  sfContext::getInstance();

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

  try {
    
    $w = new ArWebAccount();
    $w->setLogin("root");
    $w->setPassword($password);
    $w->setArPartyId(null);
    $w->setArAsteriskAccountId(null);
    $w->setActivateAt(date("c"));
    $w->setDeactivateAt(null);
    $w->save();
    
  } catch (PropelException $e) {
    echo "Caught exceptio: " . $e->getMessage() . "\n";
  }

  echo 'Created root user with login "root" and password "' . $password . '"' . "\n";

} else {
  echo "Usage: php create_root some-password-to-use-for-root-user" . "\n";
  echo "WARNING: all data will be deleted from the database.\n";
}

function myDelete($c, $t) {
  $query = "DELETE FROM $t";
  $s = $c->executeUpdate($query);
}
?>
