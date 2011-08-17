<?php

require 'generator_header.php';

echo '<?php';

?>
  /**************************************************************
   !!!                                                        !!!
   !!! WARNING: This file is automatic generated.             !!!
   !!!                                                        !!!
   !!! In order to modify this file change the content of     !!!
   !!!                                                        !!!
   !!!    /module_template/call_report_template               !!!
   !!!                                                        !!!
   !!! and execute                                            !!!
   !!!                                                        !!!
   !!!    sh generate_modules.sh                              !!!     
   !!!                                                        !!!
   **************************************************************/

$index = 'filter_on_show';

$options = array("" => "");
$options['10-calls'] = __("Calls details");

<?php if ($generateForAdmin == TRUE) { ?>
$options['20-customers'] = __("Group by customers");
<?php } ?>
  
<?php if ($generateForAdmin == TRUE || $generateForCustomer == TRUE) { ?>
$options['30-offices'] = __("Group by offices");
<?php } ?>

<?php if ($generateForAdmin == TRUE || $generateForCustomer == TRUE || $generateForOffice == TRUE) { ?>
$options['40-accounts'] = __("Group by VoIP accounts");
<?php } ?>

$defaultChoice = filterValue($filters, $index);
if (is_null($defaultChoice)) {
  $defaultChoice = '10-calls';
}

echo select_tag('filters[filter_on_show]', options_for_select($options, $defaultChoice));

<?php 
echo '?>' . "\n";f
?>
