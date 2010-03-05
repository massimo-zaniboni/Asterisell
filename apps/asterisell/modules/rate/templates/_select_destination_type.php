<?php

$phpRate = $ar_rate->unserializePhpRateMethod();

$options = array();

$defaultOptions = false;

if (is_null($phpRate)){
  $defaultOptions = true;
} else {
  if (!$phpRate->isForUnprocessedCDR()) {
    $defaultOptions = true;
  }
 }

$defaultOption = $ar_rate->getDestinationType();

if ($defaultOptions) {
  $d = DestinationType::outgoing;
  $options[$d] = DestinationType::getName($d);
  
  $d = DestinationType::incoming;
  $options[$d] = DestinationType::getName($d);

  $d = DestinationType::internal;
  $options[$d] = DestinationType::getName($d);
} else {
  $d = DestinationType::unprocessed;
  $options[$d] = DestinationType::getName($d);
  $defaultOption = $d; 
}

echo select_tag('select_destination_type', options_for_select($options, $defaultOption));

?>