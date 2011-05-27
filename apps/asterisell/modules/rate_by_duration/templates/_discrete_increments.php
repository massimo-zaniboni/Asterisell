<?php
use_helper('Asterisell');

echo input_tag('discrete_increments', VariableFrame::$phpRate->discreteIncrements, array('size' => 3, 'maxlength' => 3));
?>
