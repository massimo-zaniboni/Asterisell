<?php  /**************************************************************
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


$options = array("" => "");


    // ADMINISTRATOR

    $d = DestinationType::outgoing;
    $options[$d] = DestinationType::getName($d);
    
    $d = DestinationType::incoming;
    $options[$d] = DestinationType::getName($d);
    
    $d = DestinationType::internal;
    $options[$d] = DestinationType::getName($d);
    



$defaultChoice = "";
if (isset($filters['filter_on_destination_type'])) {
  $defaultChoice = $filters['filter_on_destination_type'];
}
echo select_tag('filters[filter_on_destination_type]', options_for_select($options, $defaultChoice));

?>
