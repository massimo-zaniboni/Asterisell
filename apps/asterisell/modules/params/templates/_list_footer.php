<?php
use_helper('Markdown');
// Default culture is en_US
//
$str = <<<VERYLONGSTRING

Other important parameters are located inside the configuration file

  apps/asterisell/config/app.yml
  
VERYLONGSTRING;

echo insertHelp($str);

?>


