<?php
/*
* Copyright (C) 2007 Massimo Zaniboni - massimo.zaniboni@profitoss.com
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
class ExactlyOneNotNullValidator extends sfValidator {
  /**
   * Executes this validator.
   *
   * // XXX It does not return false...
   *
   * @param mixed A file or parameter value/array
   * @param compare_error An error message reference
   *
   * @return bool true, if this validator executes successfully, otherwise false
   */
  public function execute(&$value, &$error) {
    $check_param = $this->getParameterHolder()->get('check');
    $check_value = $this->getContext()->getRequest()->getParameter($check_param);
    $t = 0;
    if ((!is_null($value)) || (strlen(trim($value)) > 0)) {
      $t++;
    }
    if ((!is_null($check_value)) || (strlen(trim($check_value)) > 0)) {
      $t++;
    }
    if ($t == 1) {
      return true;
    } else {
      $error = $this->getParameterHolder()->get('msg');
      return false;
    }
  }
  public function initialize($context, $parameters = null) {
    // initialize parent
    parent::initialize($context);
    // set defaults
    $this->getParameterHolder()->set('compare_error', 'Invalid input');
    $this->getParameterHolder()->add($parameters);
    return true;
  }
}
