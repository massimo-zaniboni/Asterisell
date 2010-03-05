<?php
/*
* Copyright (C) 2007, 2008, 2009
* by Massimo Zaniboni <massimo.zaniboni@profitoss.com>
*
*   This file is part of Asterisell.
*
*   Asterisell is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 3 of the License, or
*   (at your option) any later version.
*
*   Asterisell is distributed in the hope that it will be useful,
*   but WITHOUT ANY WARRANTY; without even the implied warranty of
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*   GNU General Public License for more details.
*
*   You should have received a copy of the GNU General Public License
*   along with Asterisell. If not, see <http://www.gnu.org/licenses/>.
*    
*/
sfLoader::loadHelpers(array('I18N', 'Debug', 'Date', 'Number', 'Form'));
class rateActions extends autorateActions {
  public function executeEdit() {
    if ($this->getRequestParameter('change_rate_type')) {
      // update the phpClassSerialization field
      // and jump to edit form again
      //
      $this->ar_rate = $this->getArRateOrCreate();
      $this->updateArRateFromRequest();
      $phpClassName = $this->getRequestParameter('php_rate_class_name');
      $phpClass = new $phpClassName();
      $this->ar_rate->setPhpClassSerialization(serialize($phpClass));
      $this->saveArRate($this->ar_rate);
      $ar_rateId = $this->ar_rate->getId();
      $this->redirect('rate/edit?id=' . $ar_rateId);
    } else if (($this->getRequestParameter('change_rate_params'))) {
      // Init "rate" related data
      //
      $this->ar_rate = $this->getArRateOrCreate();
      $this->updateArRateFromRequest();
      $this->saveArRate($this->ar_rate);
      // jump to template/editPhpRateForm
      // and pass to it this values as parameters.
      //
      VariableFrame::$arRate = $this->ar_rate;
      VariableFrame::$phpRate = null;
      return 'PhpRateFormSuccess';
    } else {
      parent::executeEdit();
    }
  }
  public function executePhpRateEdit() {
    $rateId = $this->getRequestParameter('rate_id');
    if ($this->getRequestParameter('cancel')) {
      // display details of the rate.
      //
      $this->redirect('rate/edit?id=' . $rateId);
    } else if ($this->getRequestParameter('save')) {
      // note: creating an object in this way is very fast
      // respect "serialization" and "deserialization"
      // because the phpRate can contains many data.
      //
      $phpRateClassName = $this->getRequestParameter('php_rate_class_name');
      $phpRate = new $phpRateClassName();
      // $phpRate is directly responsable to process form data.
      //
      $arRate = ArRatePeer::retrieveByPk($rateId);
      $isOk = $phpRate->initAccordingEditForm($arRate);
      if ($isOk == true) {
        // Save $phpRate serialization on the database.
        //
        $ser = serialize($phpRate);
        $arRate->setPhpClassSerialization($ser);
        $arRate->save();
        // display details of the arRate.
        //
        $this->redirect('rate/edit?id=' . $rateId);
      } else {
        // display again the details forms
        // with (presumabily) the error messages
        // and the current (partial edited) values
        // of $phpRate.
        VariableFrame::$arRate = $arRate;
        VariableFrame::$phpRate = $phpRate;
        $this->setTemplate('editPhpRateForm');
        return '';
      }
    } else {
      $this->logMessage('executeSimpleEditSave unrecognized parameter', 'err');
      $this->forward404(__m("Internal Error"));
    }
  }
  /**
   * Read data on the user form and update ArRate model on db.
   */
  protected function updateArRateFromRequest() {
    $category = $this->getRequestParameter('select_customer_category');
    $vendor = $this->getRequestParameter('select_vendor');
    if (strlen(trim($category)) == 0) {
      $this->ar_rate->setArRateCategoryId(null);
    } else {
      $this->ar_rate->setArRateCategoryId($category);
    }
    if (strlen(trim($vendor)) == 0) {
      $this->ar_rate->setArPartyId(null);
    } else {
      $this->ar_rate->setArPartyId($vendor);
    }
    // XXX add a validation for both category and vendor
    parent::updateArRateFromRequest();
  }
}
