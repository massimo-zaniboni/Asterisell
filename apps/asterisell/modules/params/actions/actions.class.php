<?php

/**
 * params actions.
 *
 * @package    asterisell
 * @subpackage params
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class paramsActions extends autoparamsActions
{

  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    $this->forward('default', 'module');
  }
}
