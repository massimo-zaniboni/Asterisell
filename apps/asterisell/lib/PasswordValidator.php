<?php

/* $LICENSE 2011:
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

sfLoader::loadHelpers(array('Asterisell'));

class PasswordValidator extends sfValidator
{
  public function execute (&$value, &$error)
  {
    if (areAllValidCharacters($value)) {
        return TRUE;
    } else {
       $error = $this->getParameter('password_error');
       return FALSE;
    }
  }
 
  public function initialize ($context, $parameters = null)
  {
    // Initialize parent
    parent::initialize($context);
 
    $this->setParameter('password_error', 'Field contains illegal characters.');
 
    // Set parameters
    $this->getParameterHolder()->add($parameters);
 
    return true;
  }
}
?>
