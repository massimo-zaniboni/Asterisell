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

  protected function updateArParamsFromRequest() {
    $this->ar_params->setLogoImage($this->getRequestParameter('my_logo_image_file'));
    $this->ar_params->setLogoImageInInvoices($this->getRequestParameter('my_logo_image_in_invoices_file'));
    parent::updateArParamsFromRequest();
  }

  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    $this->forward('default', 'module');
  }
}
