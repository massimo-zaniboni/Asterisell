<?php
use_helper('I18N', 'Form');
echo '<table>';
echo '<tr>';
echo '<td>';
echo form_tag('problem/deleteProblems');
echo submit_tag(__('Delete all Problems'));
echo "</form>";
echo '</td>';
echo '<td>';
echo form_tag('problem/testCostLimit');
echo submit_tag(__('Test Cost Limit Violations'));
echo "</form>";
echo '</td>';
echo '</tr>';
echo '</table>';
?>