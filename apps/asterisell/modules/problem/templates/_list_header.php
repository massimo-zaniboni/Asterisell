<?php
use_helper('I18N', 'Form');

echo '<table>';

echo '<tr>';
echo '<td>';
echo form_tag('problem/refreshView');
echo submit_tag(__('Refresh View'));
echo "</form>";
echo '</td>';

echo '<td>';
echo form_tag('problem/seeJobQueue');
echo submit_tag(__('See Job Log'));
echo '</form>';
echo '</td>';

echo '<td>';
$params = $sf_user->getParams();
if ($params->getLastViewedFeedsMd5() != $params->getCurrentFeedsMd5()) {
  echo form_tag('problem/seeWebsite');
  echo submit_tag(__('There are news on Asterisell website'));
  echo '</form>';
} else {
  /*
  echo form_tag('problem/seeWebsite');
  echo submit_tag(__('There are no news on Asterisell website'));
  echo '</form>';
  */
}
echo '</td>';
echo '</tr>';

echo '<tr>';
echo '<td>';
echo form_tag('problem/deleteProblems');
echo submit_tag(__('Delete all Problems'));
echo "</form>";
echo '</td>';

echo '<td>';
echo form_tag('problem/runProcessor');
echo submit_tag(__('Rate New/Unprocessed Calls'));
echo "</form>";
echo '</td>';

echo '<td>';
echo form_tag('problem/testCostLimit');
echo submit_tag(__('Check Call Cost Limits'));
echo "</form>";
echo '</td>';
echo '</tr>';

echo '</table>';
?>