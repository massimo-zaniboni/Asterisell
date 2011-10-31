<?php
use_helper('Markdown', 'OnlineManual');
// Default culture is en_US
//
echo insertHelp('

## Problems

This is a list only of current/new problems. 

A new problem is not inserted in the list if a similar problem is already inside.

A resolved problem is not automatically removed from the list. The user must explicitly delete the list of problems, then re-execute jobs, in order to see what problems are not completely resolved.

A "Known Problem" is not removed from the list.

## Calls with Problems

If a call generate a problem during the rating process then it will not be rated until the problem is not resolved.

Subsequent **call report** opening will force the re-rate of the calls with problems.

## Re-rating

If during problem solution, you changed rates which affected also already rated calls then remember to update them using the **re-rate button** on the **call report** module.

## Advise of Problems

The administrator is advised if there are new problems not marked as "known problem".

## Test Cost Limit Violations

The test is performed periodically from the cronjob process, but you can launch the test also using the **test cost limit violations** button.

', array(array('rating', 'Rating Errors')));
?>