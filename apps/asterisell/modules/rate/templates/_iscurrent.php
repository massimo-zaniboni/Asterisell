<?php
use_helper('Form');
echo $ar_rate->isCurrent() ? image_tag(sfConfig::get('sf_admin_web_dir') . '/images/tick.png') : '&nbsp;';
?>