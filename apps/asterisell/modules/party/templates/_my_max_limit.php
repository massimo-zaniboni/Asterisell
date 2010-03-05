<?php
use_helper('Asterisell');
$maxLimit = $ar_party->getMaxLimit30();
if (is_null($maxLimit)) {
} else {
  echo format_for_locale($maxLimit);
}
?>
