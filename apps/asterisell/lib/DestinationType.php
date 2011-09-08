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

sfLoader::loadHelpers(array('I18N'));


/**
 * Describe different types associated to the Call Detail Records.
 */
abstract class DestinationType {

  const unprocessed = 0;
  const incoming = 1;
  const outgoing = 2;
  const internal = 3;
  const ignored = 4;
  const known_error = 5;
  // used during rating-processing for signaling a known (already signaled)
  // problem. It will never be stored inside the CDR in the database,
  // it is only a comunication value.

  static public $names = array(0 => "unprocessed",
			       1 => "incoming",
			       2 => "outgoing",
			       3 => "internal",
			       4 => "ignored");

  /**
   * HTML symbols for each type of calls.
   * They are displayed mainly in CALL REPORT.
   */
  static public $symbols = array(0 => "unprocessed",
			         1 => "&larr;",
			         2 => "&rarr;",
 			         3 => "&harr;",
			         4 => "ignored");

  /**
   * @return the user readable name of the type.
   */
  static public function getName($typeValue) {
    return __(DestinationType::$names[$typeValue]);
  }

  static public function getSymbol($typeValue) {
    return DestinationType::$symbols[$typeValue];
  }

  static public function getUntraslatedName($typeValue) {
    return DestinationType::$names[$typeValue];
  }

  /**
   * Add to the condition the implicit filters on destination type
   * according "show_incoming/outgoing/internal_calls" settings.
   */
  static public function addCustomerFiltersAccordingConfiguration($c) {
    $allowedTypes = array();

    if (sfConfig::get('app_show_incoming_calls')) {
      array_push($allowedTypes, DestinationType::incoming);
    }

    if (sfConfig::get('app_show_outgoing_calls')) {
      array_push($allowedTypes, DestinationType::outgoing);
    }

    if (sfConfig::get('app_show_internal_calls')) {
      array_push($allowedTypes, DestinationType::internal);
    }

    $c2 = NULL;
    foreach($allowedTypes as $dt) {
      if (is_null($c2)) {
	$c2  = $c->getNewCriterion(CdrPeer::DESTINATION_TYPE, $dt, Criteria::EQUAL);
      } else {
	$c2->addOr($c->getNewCriterion(CdrPeer::DESTINATION_TYPE, $dt, Criteria::EQUAL));
      }
    }

    if (! is_null($c2)) {
      $c->add($c2);
    }
  }

  /**
   * Add to the condition the implicit filters on destination type
   * according the needs of the admin. 
   */
  static public function addAdminFiltersAccordingConfiguration($c) {
    $allowedTypes = array();

    array_push($allowedTypes, DestinationType::incoming);
    array_push($allowedTypes, DestinationType::outgoing);
    array_push($allowedTypes, DestinationType::internal);

    $c2 = NULL;
    foreach($allowedTypes as $dt) {
      if (is_null($c2)) {
	$c2  = $c->getNewCriterion(CdrPeer::DESTINATION_TYPE, $dt, Criteria::EQUAL);
      } else {
	$c2->addOr($c->getNewCriterion(CdrPeer::DESTINATION_TYPE, $dt, Criteria::EQUAL));
      }
    }

    if (! is_null($c2)) {
      $c->add($c2);
    }
  }


}
?>