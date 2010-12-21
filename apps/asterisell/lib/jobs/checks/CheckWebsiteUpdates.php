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

sfLoader::loadHelpers(array('I18N', 'Debug', 'Date', 'Asterisell'));

/**
 * Check if there are updates on the Asterisell Website.
 */
class CheckWebsiteUpdates extends FixedJobProcessor {

  /**
   * This file contains the date of last check 
   */
  const FILE_WITH_LAST_CHECK_DATE = "last_check_website_updates.lock";

  /**
   * How often (in days) check updates on the website.
   */
  const HOW_OFTEN_CHECK = 1;

  const WEBSITE_FEEDS = 'http://asterisell.profitoss.com/rss.xml';

  /**
   * Check cost limits only if last check was done before the 
   * "check_cost_limits_after_minutes" time frame.
   *
   * Inform the CUSTOMER via MAIL 
   * if there are customers that are not respecting these limits.
   *
   * Add an ERROR also on the ERROR TABLE in order to inform
   * the administrator of the system.
   *
   * @return always TRUE. Errors are reported on the error table.
   */
  public function process() {
    $checkFile = Mutex::getCompleteFileName(self::FILE_WITH_LAST_CHECK_DATE);

    if (! file_exists($checkFile)) {
      $f = fopen($checkFile, "w");
      fclose($f);
    }

    $lastCheck = filemtime($checkFile);
    $checkLimit = strtotime("-" . self::HOW_OFTEN_CHECK . " days");

    if ($checkLimit > $lastCheck) {
      $handle = fopen(self::WEBSITE_FEEDS, "r");

      if ($handle != FALSE) {
	$feeds = fread($handle, 1024*200);

	if ($feeds != FALSE) {
	  $md5 = md5($feeds);

	  // Update the feeds on all params
	  // 
	  $c = new Criteria();
	  $params = ArParamsPeer::doSelect($c);
	  foreach ($params as $param) {
	    if ($param->getCurrentFeedsMd5() != $md5) {
	      $param->setCurrentFeedsMd5($md5);
	      $param->save();
	    }
	  }
	
	  // Update the file date in order to check later
	  // the feeds.
	  //
	  touch($checkFile);
	  return "Checked " . self::WEBSITE_FEEDS;
	} else {
	  return "Problems reading " . self::WEBSITE_FEEDS . ". It will be checked later.";
	}
      } else {
	return "Problems reading " . self::WEBSITE_FEEDS . ". It will be checked later.";
      }
    } else {
      return "Check postponed according settings.";
    }
  }
}
?>