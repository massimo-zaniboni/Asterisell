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
 * Rate all unrated CDRs, test customers who does not respect cost limit
 * and signal problems to administrator through email (and the Problem table).
 */

define('SF_ROOT_DIR',    realpath(dirname(__FILE__).'/..'));
define('SF_APP',         'asterisell');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG',       false);

require_once(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'apps'.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'config'.DIRECTORY_SEPARATOR.'config.php');

sfContext::getInstance();

$webDir = realpath(SF_ROOT_DIR.DIRECTORY_SEPARATOR.'web');

// An external job must set explicitely the culture, because it isn't running
// inside a request.
//
$culture = sfConfig::get('app_culture');
$I18N = sfContext::getInstance()->getI18N();
$I18N->setMessageSourceDir(SF_ROOT_DIR.DIRECTORY_SEPARATOR.SF_APP.DIRECTORY_SEPARATOR.'i18n', $culture);
$I18N->setCulture($culture);

// Execute the jobs.
//
$processor = new JobQueueProcessor();
$r = $processor->process($webDir);

if (is_null($r)) {
  echo "Asterisell process_jobs: process was not started, because control file was locked.";
} else if ($r == FALSE) {
  echo "Asterisell process_jobs: there were errors. See problem table.";
} else {
  echo "Asterisell process_jobs: successfully executed.";
}

?>