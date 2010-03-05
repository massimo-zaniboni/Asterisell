<?php
use_helper('Asterisell');
if (is_null($cdr->getCostArRateId())) {
  echo __("to rate");
} else {
  echo format_for_locale($cdr->getCost());
}
?>