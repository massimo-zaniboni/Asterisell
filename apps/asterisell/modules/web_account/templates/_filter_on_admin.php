<?php
if ($sf_user->hasCredential('admin')) {
  if (isset($filters['filter_on_admin'])) {
    $defaultChoice = $filters['filter_on_admin'];
  } else {
    $defaultChoice = false;
  }
  echo checkbox_tag('filters[filter_on_admin]', true, $defaultChoice);
}
?>