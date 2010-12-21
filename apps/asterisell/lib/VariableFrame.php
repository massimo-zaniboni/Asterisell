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
 * Contains static variables references.
 * I am using this class to transfer variables
 * because report/actions.class.php does not support
 * the traditional way to pass variable from action to view,
 * or I haven't found a suitable method for doing this...
 */
class VariableFrame {
  public static $arRate;
  public static $phpRate;

  protected static $rateCache;

  // Call report related
  //
  public static $showChannelUsage;
  public static $filterCondition;
  public static $filterConditionWithOrder;
  public static $startFilterDate;
  public static $endFilterDate;
  public static $defaultTimeFrameValue;
  public static $countOfRecords;
  public static $totSeconds;
  public static $totIncomes;
  public static $totCosts;
  public static $totEarn;


  protected static $vendorCache = null;

  static public function getVendorCache() {
    if (is_null(VariableFrame::$vendorCache)) {
      VariableFrame::$vendorCache = new ArPartyCache();
    }

    return VariableFrame::$vendorCache;
  }

  protected static $officeCache = null;

  static public function getOfficeCache() {
    if (is_null(VariableFrame::$officeCache)) {
      VariableFrame::$officeCache = new ArOfficeCache();
    }

    return VariableFrame::$officeCache;
  }

  protected static $arAsteriskAccountByCodeCache = null;

  static public function getArAsteriskAccountByCodeCache() {
    if (is_null(VariableFrame::$arAsteriskAccountByCodeCache)) {
      VariableFrame::$arAsteriskAccountByCodeCache = new ArAsteriskAccountByCodeCache();
    }

    return VariableFrame::$arAsteriskAccountByCodeCache;
  }

  protected static $arAsteriskAccountByIdCache = null;

  static public function getArAsteriskAccountByIdCache() {
    if (is_null(VariableFrame::$arAsteriskAccountByIdCache)) {
      VariableFrame::$arAsteriskAccountByIdCache = new ArAsteriskAccountByIdCache();
    }

    return VariableFrame::$arAsteriskAccountByIdCache;
  }

  protected static $numberPortabilityCache = null;

  static public function getNumberPortabilityCache() {
    if (is_null(VariableFrame::$numberPortabilityCache)) {
      VariableFrame::$numberPortabilityCache = new ArNumberPortabilityCache();
    }

    return VariableFrame::$numberPortabilityCache;
  }

  protected static $telephonePrefixCache= null;

    static public function getTelephonePrefixCache() {
      if (is_null(VariableFrame::$telephonePrefixCache)) {
        VariableFrame::$telephonePrefixCache = new PhpTelephonePrefixesCache();
      }

      return VariableFrame::$telephonePrefixCache;
    }



}
