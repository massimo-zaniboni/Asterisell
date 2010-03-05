<?php
echo '<?php';
?>

  /**************************************************************
   !!!                                                        !!!
   !!! WARNING: This file is automatic generated.             !!!
   !!!                                                        !!!
   !!! In order to modify this file change the content of     !!!
   !!!                                                        !!!
   !!!    /module_template/about_template                     !!!
   !!!                                                        !!!
   !!! and execute                                            !!!
   !!!                                                        !!!
   !!!    sh generate_modules.sh                              !!! 
   !!!                                                        !!!
   **************************************************************/

use_helper('Markdown');

$str = <<<VERYLONGSTRING

## Version

<?php include("../../VERSION"); ?>

## Authors / Contributors

<?php include("../../AUTHORS"); ?>

## Copyright Owner

<?php

// add 4 spaces to each line of license in order to force CODE formatting
//
$h = fopen("../../COPYRIGHT", "r");

if ($h) {
  while (!feof($h)) {
    $l = fgets($h);
    echo "    " . $l;
  }

  fclose($h);
}

echo "\n";
?>

## License

<?php 

// add 4 spaces to each line of license in order to force CODE formatting
//
$h = fopen("../../LICENSE", "r");

if ($h) {
  while (!feof($h)) {
    $l = fgets($h);
    echo "    " . $l;
  }

  fclose($h);
}

echo "\n";
?>

VERYLONGSTRING;

echo insertHelp($str);

<?php 
echo '?>' . "\n";
?>
