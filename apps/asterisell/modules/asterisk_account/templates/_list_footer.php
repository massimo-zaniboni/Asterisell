<?php
use_helper('Markdown');
// Default culture is en_US
//
echo insertHelp('

## Important

Create a **VoIP Account** for **each corresponding Asterisk account code**, otherwise related calls will not be stored on the CDR table. 

## Account Code

Every call is associated to a VoIP Account wich is identified by the "accountcode" generated from the Asterisk server (configure it properly).

## Customer

Every VoIP Account is associated to a Customer who is the responsible of his calls cost.

A Customer can view all the calls of his VoIP Accounts. A VoIP account can view only his calls if he has an associated web account.

A Customer can have more than one VoIP account. 

');
//}

?>