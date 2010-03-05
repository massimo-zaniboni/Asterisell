<?php
use_helper('Asterisell');
$maxLimit = $ar_party->getMaxLimit30();
if (is_null($maxLimit)) {
} else {
  echo format_from_db_decimal_to_currency_locale($maxLimit);
}
?>
