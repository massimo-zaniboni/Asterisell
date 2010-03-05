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
/**
 * Contains static variables references.
 * I am using this class to transfer variables
 * because report/actions.class.php does not support
 * the traditional way to pass variable from action to view.
 */
class VariableFrame {
  public static $filterCondition;
  public static $rateCache;
  public static $vendorCache;
  public static $defaultTimeFrameValue;
  public static $arRate;
  public static $phpRate;
}
