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
 * Remove old items from the various caches of the system.
 */
class CleanCacheFromOldItems extends FixedJobProcessor {

  /**
   * @return always TRUE. Errors are reported on the error table.
   */
  public function process() {
    // Profiling
    //
    $time1 = microtime_float();

    // Remove old job log items.
    //
    $oldMonths =   sfConfig::get('app_months_after_removing_a_job_log_entry');
    $oldDate = fromUnixTimestampToMySQLDate(strtotime("-$oldMonths month"));

    $connection = Propel::getConnection();
    $stmt = $connection->createStatement();
    $stmt->executeUpdate('DELETE FROM ar_job_queue WHERE created_at < ' . $oldDate);

    // Remove old files inside "web/generated_graphs" directory.
    //
    $oldTime = strtotime('-1 day'); 
    $dir = Mutex::getCompleteFileName('generated_graphs');
    if ($handle = opendir($dir)) {
      while (false !== ($file = readdir($handle))) {
	$completeFile = Mutex::getCompleteFileName("$dir/$file");
	if ($file[0] == '.' || is_dir($completeFile)) {
	  continue;
	}
	try {
	  $mtime = filemtime($completeFile);
	  if (filemtime($completeFile) < $oldTime) {
	    unlink($completeFile);
	  }
	} catch(Exception $e) {
	  // XXX add an error that says it was unable to process a certain file...
	}
      }
      closedir($handle);
    }

    // Profiling
    //
    $time2 = microtime_float();
    $totTime = $time2 - $time1;
    return "Clear Cache from old items executed in $totTime seconds.";
  }

}
?>