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

sfLoader::loadHelpers(array('I18N', 'Debug', 'Date', 'Number', 'Form', 'Asterisell'));

class rateActions extends autorateActions {

  public function executeEdit() {
    if ($this->getRequestParameter('change_rate_type')) {
      // update/reinit the phpClassSerialization field
      // and redisplay this edit form again,
      // because it is changed only the initial PhpRate associated to this 
      // ArRate.
      //
      $this->ar_rate = $this->getArRateOrCreate();
      $this->updateArRateFromRequest();
      $phpClassName = $this->getRequestParameter('php_rate_class_name');
      $phpClass = new $phpClassName();
      $this->ar_rate->setPhpClassSerialization(serialize($phpClass));
      $this->ar_rate->setUserInput(null);
      $this->saveArRate($this->ar_rate);

      $ar_rateId = $this->ar_rate->getId();
      $this->redirect('rate/edit?id=' . $ar_rateId);
    } else if (($this->getRequestParameter('change_rate_params'))) {
      // Open a form with the details of the custom PhpRate.
      // 
      $this->ar_rate = $this->getArRateOrCreate();
      $this->updateArRateFromRequest();
      $this->saveArRate($this->ar_rate);

      $this->forwardToPhpRateForm($this->ar_rate);
    } else {

      // these are standard requests, so they are managed
      // from standard code...
      //
      parent::executeEdit();
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
    $destinationType = $this->getRequestParameter('select_destination_type');
    $this->ar_rate->setDestinationType($destinationType);

    // XXX add a validation for both category and vendor
    parent::updateArRateFromRequest();
  }

  /**
   * Forward the request to the PhpRateForm.
   */
  protected function forwardToPhpRateForm(ArRate $rate) {
    $rateId = $rate->getId();
    $phpRate = $rate->unserializePhpRateMethod();

    // Create if not exists the ar_custom_rate_form_support
    //
    $dbForm = new ArCustomRateForm();
    $dbForm->setId($rateId);

    try {
      $dbForm->save();
    } catch (Exception $e) {
      // maybe it already exists. 
      // in this case the exception is not a problem.
    }

    $this->redirect($phpRate->getModuleName() . '/edit?id=' . $rateId);
  }


  /**
   * Override addSortCriteris in order to add a more strict filter.
   *
   * @ensure the resulting $c does not contain any select field
   * (required from the pager that adds its fields)
   */
  protected function addFiltersCriteria($c) {
    $fromDate = NULL;

    // Set default filter on date
    // 
    if (isset($this->filters['filter_on_end_time']) && trim($this->filters['filter_on_end_time']) != '') {
      $fromDate = fromSymfonyDateToUnixTimestamp($this->filters['filter_on_end_time']);
    } else {
      $fromDate = time();
    }
    $this->filters['filter_on_end_time'] = $fromDate;

    $filterFromDate = fromUnixTimestampToMySQLDate($fromDate);
    $c1 = $c->getNewCriterion(ArRatePeer::START_TIME, $filterFromDate, Criteria::LESS_EQUAL);
    $c2 = $c->getNewCriterion(ArRatePeer::END_TIME, $filterFromDate, Criteria::GREATER_THAN);
    $c3 = $c->getNewCriterion(ArRatePeer::END_TIME, null, Criteria::ISNULL);

    $c2->addOr($c3);

    $c1->addAnd($c2);

    $c->add($c1);

    parent::addFiltersCriteria($c);
  }



    protected function addSortCriteria($c)
    {
        // force a sort on ID for viewing all the calls in the LIMIT pagination

        parent::addSortCriteria($c);
        $c->addAscendingOrderByColumn(ArRatePeer::ID);
    }


}
