<?php
use_helper('I18N', 'Date');

use_stylesheet('/sf/sf_admin/css/main');


echo '<div id="sf_admin_container">';

echo '<div id="sf_admin_header">';

include_partial('customer_ft_call_report/list_header');
include_partial('customer_ft_call_report/list_messages');

echo '</div>';

echo '<div id="sf_admin_bar">';

include_partial('filters', array('filters' => $filters));

echo '</div>';

echo '<div id="sf_admin_content">';

include_partial('customer_ft_call_report/list');

echo '</div>';

echo '<div id="sf_admin_footer">';

include_partial('customer_ft_call_report/list_footer');

echo '</div>';
echo '</div>';

