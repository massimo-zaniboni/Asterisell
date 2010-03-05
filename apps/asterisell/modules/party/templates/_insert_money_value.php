<?php
$value = from_db_decimal_to_locale_decimal($ar_party->getMaxLimit30());
echo input_tag('insert_money_value', $value);
?>