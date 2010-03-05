<?php
use_helper('Number');
use_helper('I18N');
use_helper('Date');
if ($sf_request->hasErrors()) {
  $errorNames = $sf_request->getErrorNames();
  foreach($errorNames as $errorName) {
    $errorDescr = $sf_request->getError($errorName);
    echo __("Error: ") . htmlentities($errorDescr);
    echo "\n<br/>";
    echo "\n<br/>";
  }
}
echo form_tag('login/login');
echo '<table cellpadding="15" cellspacing="15">' . '<tr>' . '<td>' . __('Account') . '</td>' . '<td>' . input_tag('login', $sf_params->get('login')) . '</td>' . '</tr>' . '<td>' . __('Password') . '</td>' . '<td>' . input_password_tag('password') . '</td>' . '</tr>' . '<tr>' . '<td>' . submit_tag(__('Submit'), 'class=default') . '</td>' . '</tr>' . '</table>';
echo '</form>';
?>