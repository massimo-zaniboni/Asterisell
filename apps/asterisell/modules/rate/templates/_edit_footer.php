<?php
use_helper('Markdown');
// Default culture is en_US
//
echo insertHelp('

## Customer Category

Select this field only if this is an Income Rate applicable to Customers.

Customers are identified by the "accountcode" field of the CDR table. If you have correctly configured the "VoIP Account" module then all the work is already done.

## Vendor

Select this field only if this is a Cost Rate.

Vendors are typically identified by the "dstchannel" field of the CDR table. This field is set from the Asterisk server and it identifies the channel used to route the call.

If you have different Vendors then you must specify in the "rate method" the "dstchannel" associated to this rate. Call starting with a different "dstchannel" will not be rated from this rate. If you leave empty the "dstchannel" parameter then every call will match it.

## Applicable from / until

A rate can be applied to calls of a specified time frame.

If you do not specify a **Applicable until** timestamp then the rate is applicable to all the calls respecting the **Applicable from** timestamp.

## New Rates replacing Current Rates

Usually the current rates have the **applicable until** field empty.

When you know in advance new rates to apply, you can insert them specifying when they will be applicable using the **applicable from** field. Until this date they will be inactive.

Next you can change the **applicable until** field of current rates with the timestamp used in the **applicable from** field of the new inserted rates. So they will be remaining active until the switch date.

## Edit of Rate Parameters

Select a **Rate Method** then press the **Apply** button. Select **Change Rate Params** to define / change the parameters of the rate.

## Rerate of Calls

If you change the parameters of a rate then already rated calls are not automatically re-rated. The rate is applied only to new calls or to old calls unrated due to a rate problem. This permits to avoid rerate of already rated calls or worse of already invoiced calls. 

You can force a selective re-rate using the **Recalc Selected Calls** on the **Call Report** Module. You re-rate only the current filtered/selected calls. Be careful.

## Precision

Costs are stored with full digit precision (see the "apps/asterisell/config/app.yml" configuration file) but they are displayed using the default currency format so during visualization some precision can be lost. 

However if you edit rate parameters you see always rates parameters with full precision.
');
?>