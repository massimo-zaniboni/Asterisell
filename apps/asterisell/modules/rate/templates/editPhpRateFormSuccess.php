<?php
use_helper('Form');
$arRate = VariableFrame::$arRate;
$phpRate = VariableFrame::$phpRate;
$ar_rateId = $arRate->getId();
if (is_null($phpRate)) {
  $phpRate = $arRate->unserializePhpRateMethod();
}
// Display error messages
//
if ($sf_request->hasErrors()) {
  echo '<div id="asterisellError">Please correct the following errors:<ul>';
  foreach($sf_request->getErrors() as $name => $error) {
    echo '<li>' . $error . '</li>';
  }
  echo '</ul></div>';
}
echo '<br/>';
// Open the generic form
//
echo form_tag('rate/phpRateEdit', 'multipart=true');
// use these hidden parameters to communicate
// important information when the form is processed.
//
echo input_hidden_tag('rate_id', $ar_rateId);
echo input_hidden_tag('php_rate_class_name', get_class($phpRate));
// insert the form specific part related to the php rate.
//
echo $phpRate->getHTMLForEditForm($arRate);
echo '<br/>';
// close the form.
//
echo submit_tag('Save', array('name' => 'save')) . '  ' . submit_tag('Cancel', array('name' => 'cancel'));
echo '</form>';
?>