<?php
sfLoader::loadHelpers(array('I18N', 'Debug', 'Asterisell'));

class cdrlist_ignoredActions extends autocdrlist_ignoredActions {

  /**
   * Override addSortCriteris in order to add a more strict filter.
   */
  protected function addFiltersCriteria($c) {
    $c->add(CdrPeer::DESTINATION_TYPE, DestinationType::ignored);
    return parent::addFiltersCriteria($c);
  }
}

?>
