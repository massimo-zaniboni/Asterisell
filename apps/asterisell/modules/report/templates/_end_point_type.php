<?php
use_helper('Asterisell');
$p = $cdr->getArTelephonePrefix();
if (!is_null($p)) {
  echo $p->getDescriptiveName();
}
?>