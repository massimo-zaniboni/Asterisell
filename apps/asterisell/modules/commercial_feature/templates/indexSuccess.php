<?php
use_helper('Markdown');

$str = <<<VERYLONGSTRING

This feature is part of the Asterisell Commercial Release.

See <http://asterisell.profitoss.com> for more details.

VERYLONGSTRING;

echo insertHelp($str);

?>