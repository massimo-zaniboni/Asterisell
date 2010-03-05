<?php
use_helper('Markdown');
// Default culture is en_US
//
echo insertHelp('

## Vendor

Vendors are typically identified by the "dstchannel" field of the CDR table. This field is set from the Asterisk server and it identifies the channel used to route the call.

If you have different Vendors then you must specify in the "rate method" the "dstchannel" associated to this rate. Call starting with a different "dstchannel" will not be rated from this rate. If you leave empty the "dstchannel" parameter then every call will match it.

## Rate Updating

Usually the current rates have the **applicable until** field empty.

When there are new rates, you can update / specify the validity period of old and new rates. When there will be calls with a date inside the new rates applicability timeframe, new rates will be used instead of old rates.

## Rerate of Calls

If you change the parameters of a rate then already rated calls are not automatically re-rated. The rate is applied only to new calls or to old calls unrated due to a rate problem. This permits to avoid rerate of already rated calls or worse of already invoiced calls. 

You can force a selective re-rate using the **Recalc Selected Calls** on the **Call Report** Module. You re-rate only the current filtered/selected calls. Be careful.

## Precision

Costs are stored with full digit precision (see the "apps/asterisell/config/app.yml" configuration file) but they are displayed using the default currency format so during visualization some precision can be lost. 

However if you edit rate parameters you see always rates parameters with full precision.
');
?>