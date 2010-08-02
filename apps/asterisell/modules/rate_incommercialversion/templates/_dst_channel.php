<?php
use_helper('Asterisell');

# NOTE: VariableFrame::$phpRate is always configured from the Asterisell "framework"
# with the value of the current phpRate.

echo input_tag('dst_channel', VariableFrame::$phpRate->dstChannelPattern);

?>