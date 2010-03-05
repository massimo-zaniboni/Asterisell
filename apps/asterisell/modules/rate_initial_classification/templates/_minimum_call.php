<?php
use_helper('Asterisell');

echo input_tag('minimum_call', VariableFrame::$phpRate->atLeastXSeconds, array('size' => 2, 'maxlength' => 2));

?>

