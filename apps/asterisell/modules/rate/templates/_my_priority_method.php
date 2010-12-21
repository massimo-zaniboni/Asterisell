<?php
$phpRate = $ar_rate->unserializePhpRateMethod();
if (is_null($phpRate)) {
  echo __("Nothing");
} else {
  echo $phpRate->getPriorityMethod($ar_rate);
}
?>