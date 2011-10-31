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
 * @param $section NULL for home page of manual
 * @param $name the name to display to user
 * @return a HTML link to a section of online manual
 */
function link_to_online_manual($section, $name) {
   $r =  '<a href="' . _compute_public_path('index', 'help', 'html', true);
   if (!is_null($section)) {
       $r .= '#' . $section;
   }
   $r .=  '" target="_blank">' . $name . '</a>';

   return $r;
}

?>
