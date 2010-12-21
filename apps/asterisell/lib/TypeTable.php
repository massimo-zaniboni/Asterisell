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
 * Describe different types associated to the records
 * of database.
 */
abstract class TypeTable {

  static public $processingStateType_toProcess = 0;
  static public $processingStateType_toRate = 1;
  static public $processingStateType_rated = 2;
  static public $processingStateType_error = 3;

  static public $destinationType_unknown = 0;
  static public $destinationType_incoming = 1;
  static public $destinationType_outgoing = 2;
  static public $destinationType_internal = 3;
  static public $destinationType_ignore = 4;

  static public $types = array(
    "processing_state_type" => array(
             0 => "unprocessed",
				     1 => "unrated",
				     2 => "rated",
				     3 => "error"),

    "destination_type" => array(
        0 => "unknown",
				1 => "incoming",
				2 => "outgoing",
				3 => "internal",
				4 => "ignore"));


  /**
   * @param $typeName "processing_state_type" or "destination_type"
   * @return the user readable name of the type.
   */
  static public function getName($typeName, $typeValue) {
    $a = TypeTable::$types[$typeName];
    return $a[$typeValue];
  }
}
?>