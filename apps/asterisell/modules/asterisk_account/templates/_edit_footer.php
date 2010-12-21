<?php
use_helper('Markdown');
// Default culture is en_US
//
echo insertHelp('

## Name Update

If you update the name of a VoIP account, it will take effect only on new processed calls.

In order to propagate this change also to old calls you must reset them, and force a re-rate.

## VoIP Account Constraints

VoIP accounts must be specified in a case-sensitive manner because PHP code manage them in case-sensitive way.

But they must be also unique, using their case-insensitive version, because some SQL queries are case-insensitive.

So there can not be VoIP account names like "my customer", "My customer", "MY CUSTOMER", because they are the same using a case-insensitive comparison.

');
//}

?>