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
  const FILE_WITH_LAST_CHECK_DATE = "last_check_website_updates";

  /**
   * How often (in days) check updates on the website.
   */
  const HOW_OFTEN_CHECK = 1;

  const WEBSITE_FEEDS = 'http://asterisell.profitoss.com/rss-f.xml';

  const WEBSITE_HOMEPAGE = 'http://asterisell.profitoss.com';

  public function process() {
    $checkFile = self::FILE_WITH_LAST_CHECK_DATE;

    $checkLimit = strtotime("-" . self::HOW_OFTEN_CHECK . " days");

    $mutex = new Mutex($checkFile);

    if ($mutex->maybeTouch($checkLimit)) {
      $handle = fopen(self::WEBSITE_FEEDS, "r");

      if ($handle != FALSE) {
	$feeds = fread($handle, 1024*200);

	if ($feeds != FALSE) {
	  $md5 = md5($feeds);
          $oldmd5 = $mutex->getTagInfo();

          if ($md5 !== $oldmd5) {
            $mutex->setTagInfo($md5);
            $p = new ArProblem();
            $p->setDuplicationKey("New RSS Feeds " . $md5);
            $p->setDescription("There are news on Asterisell web-site: " . self::WEBSITE_HOMEPAGE);
            $p->setEffect("The news can be about discovered and fixed bugs.");
            $p->setProposedSolution("Read " . self::WEBSITE_HOMEPAGE);
            ArProblemException::addProblemIntoDBOnlyIfNew($p);
          }

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