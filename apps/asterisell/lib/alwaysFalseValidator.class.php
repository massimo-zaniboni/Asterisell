<?php
/*
* Copyright (C) 2007 Massimo Zaniboni <massimo.zaniboni@profitoss.com>
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
/**
 * Two values are valid only if there is exactly one value with a no-null value.
 *
 * Validator params:
 *     check:  field
 *     msg:    error message
 */
class AlwaysFalseValidator extends sfValidator {
  /**
   * Executes this validator.
   *
   * @param mixed A file or parameter value/array
   * @param compare_error An error message reference
   *
   * @return bool true, if this validator executes successfully, otherwise false
   */
  public function execute(&$value, &$error) {
    $error = "errore";
    return false;
  }
  public function initialize($context, $parameters = null) {
    // initialize parent
    parent::initialize($context);
    return true;
  }
}
