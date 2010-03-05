<?php
use_helper('Asterisell');

$options1 = array();
$d = DestinationType::outgoing;
$options1[$d] = DestinationType::getName($d);
$d = DestinationType::incoming;
$options1[$d] = DestinationType::getName($d);
$d = DestinationType::internal;
$options1[$d] = DestinationType::getName($d);
$d = DestinationType::ignored;
$options1[$d] = DestinationType::getName($d);
$d = DestinationType::unprocessed;
$options1[$d] = DestinationType::getName($d);

echo select_tag('destination_type', options_for_select($options1, VariableFrame::$phpRate->destinationType));

?>