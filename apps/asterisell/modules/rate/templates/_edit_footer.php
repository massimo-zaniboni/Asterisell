<?php
use_helper('Markdown', 'OnlineManual');
// Default culture is en_US
//
echo insertHelp('

## Precision

Costs are stored with full digit precision (see the "apps/asterisell/config/app.yml" configuration file) but they are displayed using the default currency format so during visualization some precision can be lost. 

However if you edit rate parameters you see always rates parameters with full precision.
'
    , array(array('rates', 'Initial Rates Configurations'),
        array('rating', 'Solving Problems in Rate Configurations'),
        array('rates-updating', 'Rates Updating'))
);

?>