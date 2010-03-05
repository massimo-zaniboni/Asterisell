<?php
echo submit_tag(__('Regenerate Invoice'), array('name' => 'regenerate_invoice'));
echo '  ';
echo submit_tag(__('Send email to customer'), array('name' => 'send_email_to_customer'));
?>