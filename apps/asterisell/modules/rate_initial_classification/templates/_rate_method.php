<?php
use_helper('Asterisell');

$phpRate = VariableFrame::$phpRate;

echo select_tag('rate_method', '<option value="s" ' . ($phpRate->rateByMinute ? '' : 'selected="selected"') . '>By Seconds</option> ' . '<option value="m" ' . ($phpRate->rateByMinute ? 'selected="selected"' : '') . '>By Minutes</option>');

?>