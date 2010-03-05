<?php
use_helper('Markdown');
// Default culture is en_US
//
echo insertHelp('

## Cost

The cost is what you had to pay in order to route the call.

Every Call must have exactly one cost rate.

## Income 

The income is what your customer had to pay for the call.

Every Call must have exactly one income rate.

## Asterisk Billing Fields

The Asterisk server put in "amaflags" and "disposition" fields of CDR table specific billing related values.

You must set the the "apps/asterisell/config/app.yml" Asterisell configuration file with the proper values according your Asterisk configuration.

## Problems 

If there are no rates to apply or more than a rate or unrecognized "disposition" / "amaflags" values then the call is not rated and an error is signaled to the Asterisell administrator. 

The administrator can freely correct the problem updating this rate table. In the meantime Asterisell continues to work.


');
//}

?>