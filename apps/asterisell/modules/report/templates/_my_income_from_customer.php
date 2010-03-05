<?php
use_helper('Asterisell');
if (is_null($cdr->getIncomeArRateId())) {
  echo __("to rate");
} else {
  echo format_for_locale($cdr->getIncome());
}
?>