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

sfLoader::loadHelpers(array('I18N', 'Debug', 'Date', 'Number', 'Debug'));

/**
 * A Rate that works on a set of consecutive CDRs instead of at a CDR at a time.
 * The Rate stores incremental info about CDR processing on an external BundelRateIncrementalInfo class,
 * that can be freely defined from specific BundleRate instances.
 *
 * The rate can return a cost associated to the period, usually fixed.
 *
 */
interface BundleRate {

  /**
   * @param  $timestamp a PHP date/timestamp
   * @return a string identifing uniquely the period associated to this timestamp
   */
  public function getPeriod($timestamp);

  /**
   * @param  $period a string identifing a period of the bundle.
   * @return the timestamp of the first cdr that can be inside the period
   */
  public function getPeriodStartDate($period);

  /**
   * @param  $period a string identifing a period of the bundle.
   * @return the timestamp of the last cdr that can be inside the period, this value is exclusive
   */
  public function getPeriodEndDate($period);

  /**
   *
   * @param  $partyId the party associated to the bundle, always a customer
   * @param  $arRateId the arate id where the bundle is stored
   * @param  $period a string identifing a period of the bundle.
   * @param  $incrementalInfo period incremental info associated to the rate
   * @param  $isVendor true if the calculation is done for calculating the bundle cost of a Vendor,
   *         false for a Customer. For a Vendor the total bundle cost, is the sum of all bundle cost
   *         of its customer. It is the framework that call this method for each customer, so $partyId
   *         is always a customer. This parameter can be used from the rate method for deciding if it is the case
   *         of considering COST (usually for vendors) or INCOME (usually for customers) CDR fields.
   * @return a PHP float number identifing the cost/income of the period not stored inside single CDR cost,
   * but that is a "fixed" part of the rate.
   */
  public function getPeriodCost($partyId, $arRateId, $period, $incrementalInfo, $isVendor);

  /**
   * @return a BundleRateIncrementalInfo object to store as initial incremental info value
   */
  public function getEmptyIncrementalInfo($partyId, $arRateId, $period);

  /**
   * Used for updating the $incrementalInfo with the new rated CDR.
   *
   * This method must only update $incrementalInfo object.
   * All other updated of database and caches are done automatically from the framework.
   *
   * @require it is called only if the rate is applied to the CDR
   *
   * @param  $arRateId
   * @param  $period
   * @param  Cdr $cdr
   * @param  BundleRateIncrementalInfo  $incrementalInfo it is updated in place, with the new information
   * @return nothing
   */
  public function updateIncrementalInfo($arRateId, $period, $cdr, $incrementalInfo);

}

?>