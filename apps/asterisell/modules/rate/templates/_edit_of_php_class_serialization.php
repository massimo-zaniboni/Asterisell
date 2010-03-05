<?php
// All the available rate methods
//
$phpClassOptions = sfConfig::get('app_available_phpRates');
$options = array();
foreach($phpClassOptions as $rateName => $rateDescription) {
  $options[$rateName] = __($rateDescription);
}
// Select in the list the current rate method.
//
if (is_null($ar_rate->getPhpClassSerialization())) {
  $rate = null;
  $optionsForSelect = options_for_select($options);
} else {
  $rate = $ar_rate->unserializePhpRateMethod();
  if ($rate == null) {
    $optionsForSelect = options_for_select($options);
    // display error
    //
    echo '<div id="asterisellError">Rate serialization has a bad format:<br/> ' . $ar_rate->getPhpClassSerialization() . '</div>';
  } else {
    // Is the current rate method available?
    //
    $currentRateClassName = get_class($rate);
    if (!array_key_exists($currentRateClassName, $options)) {
      // use the class name as description
      //
      $options[$currentRateClassName] = $currentRateClassName;
    }
    $optionsForSelect = options_for_select($options, $currentRateClassName);
  }
}
echo select_tag('php_rate_class_name', $optionsForSelect);
echo '  ';
echo submit_tag(__('Apply'), array('name' => 'change_rate_type'));
echo '<br/>';
echo '<br/>';
if (is_null($rate)) {
  echo __('Nothing');
} else {
  echo $rate->getShortDescription($ar_rate);
  echo '  ';
  echo submit_tag(__('Change Rate Params'), array('name' => 'change_rate_params'));
}
?>