<?php
use_helper('Markdown', 'OnlineManual');

// Default culture is en_US
//
$str = <<<VERYLONGSTRING

VERYLONGSTRING;

echo insertHelp($str, array(array('main-configurations', 'Other Asterisell Configurations'),
                            array('asterisell-owner', 'Params Configurations')
                ));

?>


