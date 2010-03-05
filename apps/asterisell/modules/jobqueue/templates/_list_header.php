<?php
use_helper('I18N', 'Form', 'Asterisell');

echo '<table>';

echo '<tr>';
echo '<td>';
echo form_tag('jobqueue/refreshView');
echo submit_tag(__('Refresh View'));
echo "</form>";
echo '</td>';

echo '<td>';
echo form_tag('jobqueue/seeProblems') . submit_tag(__('See Problems')) . '</form>';
echo '</td>';
echo '</tr>';

echo '<tr>';
echo '<td>';
echo form_tag('jobqueue/runProcessor');
echo submit_tag(__('Execute Jobs'));
echo "</form>";
echo '</td>';
echo '<td>';
echo form_tag('jobqueue/checkCostLimit') . submit_tag(__('Check Call Cost Limits')) . '</form>';
echo '</td>';
echo '</tr>';

echo '</tr>';
echo '</table>';
?>