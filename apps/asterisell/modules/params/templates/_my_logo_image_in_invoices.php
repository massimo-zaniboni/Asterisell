<?php
use_helper('sfMediaLibrary');

$value = $ar_params->getLogoImageInInvoices();
if (is_null($value)) {
  $value = '';
}

echo input_asset_tag('my_logo_image_in_invoices_file', $value);

?>