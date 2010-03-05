<?php
echo submit_tag(__('(Re)Generate Invoices'), array('name' => 'regenerate_invoices'));
echo '  ';
echo submit_tag(__('Send emails to customers'), array('name' => 'send_emails_to_customers'));
?>