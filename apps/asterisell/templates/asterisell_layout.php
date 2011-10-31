<?php
use_helper('Number', 'I18N', 'Date', 'OnlineManual');

// Manage params, and ask for a reseller-specific login form if it is specified
//
$params = $sf_user->getParams($sf_params->get('name'));
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo include_http_metas() ?>
<?php echo include_metas() ?>
<title> <?php echo $params->getServiceName() ?> </title>

</head>

<body>

<div id="userInfoBlock">

<?php
// Login and LOGO
//
echo '<table width="100%">';
echo '<tr>';
echo '<td>';
echo image_tag($params->getLogoImage());
echo '</td>';
echo '<td> <p class="loginData">';
if ($sf_user->isAuthenticated()) {
  echo __('User:') . ' ' . $sf_user->getLoginDescription() . ' - ' . link_to(__('Logout'), 'login/logout');
}
echo '</p></td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo '<p class="asterisellSlogan">' . $params->getSlogan() . '</p>';
echo '</td>';
echo '</tr>';
echo '</table>';
?>

<?php

// Menu
//
if ($sf_user->hasCredential('admin')) {

  echo "\n";
  echo '<div class="appmenu">'. "\n";
  echo '<ul>'. "\n";

  echo '<li><a href="" target="_self" >' . __('Params') . '</a>'. "\n";
  echo '<ul>'. "\n";
  echo '<li>' . link_to(__('Params'), 'params/list') . '</li>'. "\n";
  echo '<li>' . link_to_online_manual('partners', __('Partners')) . '</li>'. "\n";
  echo '<li>' . link_to_online_manual('resellers', __('Resellers')) . '</li>'. "\n";
  echo '<li>' . link_to(__('Upload Files'), 'sfMediaLibrary/index') . '</li>'. "\n";
  echo '<li>' . link_to(__('Price Categories'), 'rate_category/list') . '</li>'. "\n";
  echo '<li>' . link_to(__('Telephone Prefixes'), 'telephone_prefix/list') . '</li>'. "\n";
  echo '<li>' . link_to(__('Number Portability'), 'commercial_feature/index') . '</li>'. "\n";
  echo '<li>' . link_to(__('Rates'), 'rate/list') . '</li>'. "\n";
  echo '</ul>'. "\n";
  echo '</li>'. "\n";

  echo '<li><a href="" target="_self" >' . __('Parties') . '</a>'. "\n";
  echo '<ul>'. "\n";
  echo '<li>' . link_to(__('Customers / Vendors'), 'party/list') . '</li>'. "\n";
  echo '<li>' . link_to(__('Customer Offices'), 'office/list') . '</li>'. "\n";
  echo '<li>' . link_to(__('VoIP Accounts'), 'asterisk_account/list') . '</li>'. "\n";
  echo '<li>' . link_to(__('Website Accounts'), 'web_account/list') . '</li>'. "\n";
  echo '<li>' . link_to(__('VoIP Batch Creation'), 'commercial_feature/index') . '</li>'. "\n";
  echo '</ul>'. "\n";
  echo '</li>'. "\n";


  echo '<li><a href="" target="_self" >' . __('Calls') . '</a>'. "\n";
  echo '<ul>'. "\n";
  echo '<li>' . link_to(__('Calls Report'), 'admin_tt_call_report/list') . '</li>'. "\n";
  echo '<li>' . link_to(__('Ignored Calls'), 'cdrlist_ignored/list') . '</li>'. "\n";
  echo '<li>' . link_to(__('Unprocessed Calls'), 'cdrlist_unprocessed/list') . '</li>'. "\n";
  echo '</ul>'. "\n";
  echo '</li>'. "\n";

  echo '<li><a href="" target="_self" >' . __('Accounting') . '</a>'. "\n";
  echo '<ul>'. "\n";
  echo '<li>' . link_to(__('Customer Invoices'), 'commercial_feature/index') . '</li>'. "\n";
  echo '<li>' . link_to(__('Vendor Invoices'), 'commercial_feature/index') . '</li>'. "\n";
  echo '<li>' . link_to(__('Batch Invoice Creation'), 'commercial_feature/index') . '</li>'. "\n";
  echo '<li>' . link_to(__('Customer Payments'), 'commercial_feature/index') . '</li>'. "\n";
  echo '</ul>'. "\n";
  echo '</li>'. "\n";

  echo '<li><a href="" target="_self" >' . __('System Details') . '</a>'. "\n";
  echo '<ul>'. "\n";
  echo '<li>' . link_to(__('Job Log'), 'jobqueue/list') . '</li>'. "\n";
  echo '<li>' . link_to(__('Current Problems'), 'problem/list') . '</li>'. "\n";
  echo '</ul>'. "\n";
  echo '</li>'. "\n";

  echo '<li><a href="" target="_self" >' . __('Help') . '</a>'. "\n";
  echo '<ul>'. "\n";
  echo '<li>' . link_to_online_manual(NULL, __('Instructions')) . '</li>'. "\n";
  echo '<li><a href="' . _compute_public_path('Asterisell', 'help', 'pdf', true) . '">' . __('Instructions as PDF') . '</a></li>'. "\n";
  echo '<li>' . link_to(__('PHP-Info'), 'phpinfo/index') . '</li>'. "\n";
  echo '<li>' . link_to(__('APC-Info'), 'apcinfo/index') . '</li>'. "\n";
  echo '<li>' . link_to(__('Asterisell Website'), 'http://asterisell.profitoss.com') . '</li>'. "\n";
  echo '<li>' . link_to(__('About'), 'about/index') . '</li>'. "\n";

  echo '</ul>'. "\n";
  echo '</li>'. "\n";

  echo '</ul>'. "\n";
  echo '</div>'. "\n";
}
?>

</div>

<hr/>

<?php echo $sf_data->getRaw('sf_content') ?>

<div id="asterisellFooter">

<hr/>

<?php echo $params->getFooter(); ?>

</div>

</body>
</html>
