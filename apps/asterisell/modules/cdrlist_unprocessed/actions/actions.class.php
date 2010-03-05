<?php
sfLoader::loadHelpers(array('I18N', 'Debug', 'Asterisell'));

class cdrlist_unprocessedActions extends autocdrlist_unprocessedActions {

  /**
   * Override addSortCriteris in order to add a more strict filter.
   */
  protected function addFiltersCriteria($c) {
    $c->add(CdrPeer::DESTINATION_TYPE, DestinationType::unprocessed);
  }
}

?>
