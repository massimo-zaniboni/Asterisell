<?php

/* $LICENSE 2009, 2010:
 *
 * Copyright (C) 2009, 2010 Massimo Zaniboni <massimo.zaniboni@profitoss.com>
 *
 * This file is part of Asterisell.
 *
 * Asterisell is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * Asterisell is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Asterisell. If not, see <http://www.gnu.org/licenses/>.
 * $
 */

/**
 * 
 * IMPORTANT: 
 *   * change "custom_rate_demoActions" with "your_module_nameActions"
 *   * change inherited "autoCustom_rate_demoActions" with "autoYour_module_nameActions"
 */
class rate_incommercialversionActions extends autorate_incommercialversionActions
{

  /**
   * This function read request parameters and update $phpRate according them.
   *
   * IMPORTANT: this function must be updated every time 
   * a new custom rate method is implemented.
   * It must be in synchro with the custom templates inside
   * directory "template" of this module, and with the fields
   * of the custom PhpRate class managed from this module.
   * 
   * Signals error using "$this->setErrorMessage("...")
   * and returning false.
   *
   * @param $phpRate the rate to update
   * @return FALSE if there were problems, TRUE otherwise.
   *
   */
  public function updatePhpRateWithFormFields(PhpRate $phpRate) {
    $allOk = TRUE;

    return $allOk;
  }

  /**
   * IMPORTANT: replace with the name of the module
   */
  public function handleErrorSave() {
    $this->redirect('rate_incommercialversion/edit?id=' . VariableFrame::$arRate->getId());
  }

  /**
   * Add an error message.
   */
  public function setErrorMessage($msg) {
    $this->setFlash('my_error', $msg);
  }

  ///////////////////////////////////
  // DO NOT MODIFY THESE FUNCTIONS //
  ///////////////////////////////////

  /**
   * IMPORTANT: do no modify this function.
   */
  public function validateSave() {
    $id = $this->getRequestParameter('id');
    $phpRate = PhpRate::initVariableFrameAndGetPhpRate($id);

    if (!is_null($phpRate)) {
      $validationOk = $this->updatePhpRateWithFormFields($phpRate);

      if ($validationOk) {
	$arRate = VariableFrame::$arRate;
	$arRate->setPhpClassSerialization(serialize($phpRate));
	$arRate->save();
      }
      return $validationOk;
    } else {
      $this->setErrorMessage('Unknown ar_rate. Probably a bug of the program. Contact the support.');
      return FALSE;
    }
  }

  /**
   * IMPORTANT: do no modify this function.
   */
  public function executeSave() {
    // note: this function is called only if
    // validateSave return TRUE.
    //
    $this->redirect('rate/edit?id='.VariableFrame::$arRate->getId());
  }

  /**
   * IMPORTANT: do no modify this function.
   */
  public function executeEdit() {
    $phpRate = PhpRate::initVariableFrameAndGetPhpRate($this->getRequestParameter('id'));
    if (is_null($phpRate)) {
      $this->forward404();
    }

    return parent::executeEdit();
  }

}
