<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<?php echo include_http_metas() ?>
<?php echo include_metas() ?>

<?php echo include_title() ?>

</head>
<body>

<div id="userInfoBlock">

<?php
use_helper('Number', 'I18N', 'Date');
$logoImageName = sfConfig::get('app_asterisell_template_header_icon');
$headerText = sfConfig::get('app_asterisell_template_header_text');
$footerText = sfConfig::get('app_asterisell_template_footer_text');
echo '<table width="100%">';
echo '<tr>';
echo '<td>';
echo image_tag($logoImageName);
echo '</td>';
echo '<td> <p class="loginData">';
if ($sf_user->isAuthenticated()) {
  echo $sf_user->getLoginDescription();
  echo '   (';
  if ($sf_user->hasCredential('admin')) {
    echo __('Administrator');
  } else if ($sf_user->hasCredential('party')) {
    echo __('Customer');
  } else if ($sf_user->hasCredential('account')) {
    echo __('VoIP account');
  }
  echo ')';
}
echo '</p></td>';
echo '</tr>';
echo '<tr>';
echo '<td>';
echo $headerText;
echo '</td>';
echo '<td><p class="loginData">';
if ($sf_user->isAuthenticated()) {
  echo link_to(__('Disconnect'), 'login/logout');
}
echo '</p></td>';
echo '</tr>';
echo '</table>';
if ($sf_user->hasCredential('admin')) {
  echo '<p class="menu">' . ' [' . link_to(__('Instructions'), 'instructions/index') . '] ' . ' [' . link_to(__('PHPInfo'), 'phpinfo/index') . '] ' . ' [' . link_to(__('WEB Access Accounts'), 'web_account/list') . '] ' . ' [' . link_to(__('VoIP Accounts'), 'asterisk_account/list') . '] ' . ' [' . link_to(__('Customer Categories'), 'rate_category/list') . '] ' . ' [' . link_to(__('Customers and Vendors'), 'party/list') . '] ' . ' ['. link_to(__('Telephone Prefixes'), 'telephone_prefix/list') . '] ' .' [' . link_to(__('Rates'), 'rate/list') . '] ' . ' [' . link_to(__('Customer Invoices'), 'customer_invoice/list') . '] ' . ' [' . link_to(__('Invoice Creations'), 'invoice_creation/list') . '] ' . ' [' . link_to(__('CDR list'), 'cdr/list') . '] ' . ' [' . link_to(__('Call Report'), 'report/list') . '] ' . ' [' . link_to(__('Problems'), 'problem/list') . '] ' . '</p>';
}
?>

<hr/>
</div>

<?php echo $sf_data->getRaw('sf_content') ?>

<div id="asterisellFooter">

<hr/>

<?php echo $footerText; ?>

</div>

</body>
</html>
