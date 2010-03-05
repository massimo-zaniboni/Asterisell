<?php
use_helper('Markdown');
// Default culture is en_US
//
echo insertHelp('

### Calls with Problems

If a call generate a problem during the rating process then it will not be rated until the problem is not resolved.

Subsequent **call report** opening will force the re-rate of the calls with problems.

### Problem Solution

If you correct a problem then you must delete it (or all the problems) from the table, open the call report module and check if there are other open problems inserted in the table. If a problem is not resolved it will be inserted again in the table.

If during problem solution you changed rates wich affected also already rated calls then remember to update them using the **rerate button** on the **call report** module.

### Test Cost Limit Violations

The test is performed periodically from the cronjob process, but you can launch the test also using the **test cost limit violations** button.

');
//}

?><?php
?>