<?php
use_helper('I18N');
echo "<h2>";

echo __("Operation is not permitted.");

if (MyUser::isAppLockedForMaintanance()) {
    echo "<br/>" . MyUser::getMaintananceModeMessage();
}

echo "</h2>";
?>