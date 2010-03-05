<?php

define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'asterisell');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

sfContext::getInstance();

testAllCdrs();

function testAllCdrs() {
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

?>
