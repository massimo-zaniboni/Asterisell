<?php
use_helper('Markdown', 'OnlineManual');
// Default culture is en_US
//
echo insertHelp('

## Important Note on Unprocessed CDRs

In this section there can be also the few CDRs that were inserted in the CDR table, after the last cron-job processing job. After the next rating process, they will be moved to the call report.

');

?>