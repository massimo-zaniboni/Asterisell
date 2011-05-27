<?php
use_helper('Number');
use_helper('I18N');
use_helper('Date');

// Display error messages
//
if ($sf_request->hasErrors()) {
  $errorNames = $sf_request->getErrorNames();
  $message = '';
  foreach($errorNames as $errorName) {
    $errorDescr = $sf_request->getError($errorName);
    $message .= htmlentities($errorDescr) . '</br>';
  }
  echo '<div class="form-errors">';
  echo "<h2>$message</h2>";
  echo '</div>';
}

// Display login form
//
echo '<div id="asterisellLogin">';
echo form_tag('login/login');
echo '<table cellpadding="15" cellspacing="15">' . '<tr>' . '<td>' . __('Login:') . '</td>' . '<td>' . input_tag('login', $sf_params->get('login'), array('class' => 'text')) . '</td>' . '</tr>' . '<td>' . __('Password:') . '</td>' . '<td>' . input_password_tag('password', null, array('class' => 'text')) . '</td>' . '</tr>' . '<tr>' . '<td> </td>' . '<td>' . submit_tag(__('Login'), 'class="login"') . '</td>' . '</tr>' . '</table>';
echo input_hidden_tag('access_name', $sf_params->get('name'));
echo '</form>';
echo '</div>';
?>