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
 * Implement a MUTEX using a file as mutex/lock.
 * If the file exits, then a Job process is running, and no other Job processor can start.
 *
 * In order to prevent infinite locking to a fault Job Processor, existed without releasing the lock/mutex,
 * a lock can persist for only two pass of scheduled Job Processor. The considerations are:
 *   - it is very unlikely that a job processor takes more than the scheduled time;
 *   - if a job processor takes more than the scheduled time, then it is likely that there were a fault error;
 *   - in any case, it is not a big problem if there two or more job processors running contemporaney;
 * 
 * NOTE: previous code was using `flock` PHP instruction, but it does not work, because
 * in Unix its behaviour is not mandatory.
 */
class Mutex {

  /**
   * Where files will be created/open.
   * Usually this field is setted-up from JobQueueProcessor before starting job processing.
   * NULL if the current directory or web environment is usued.
   */
  public static $baseDirectory = NULL;

  protected $name = NULL;

  protected $fileName = NULL;

  protected $isLocked = FALSE;
  
  /**
   * Init a mutex with a given name.
   *
   * @param $name the name of the lock, without the ".lock" suffix.
   */
  public function __construct($name) {
    $this->name = $name;
    $this->fileName =  Mutex::getCompleteFileName($name);
    $this->isLocked = FALSE;
  }

  /**
   * Release always the locked resources on mutex destruction.
   */
  public function __destruct() {
    $this->unlock();
  }

  /**
   * @param $fileName the name of file
   * @return a complete file name according Mutex::$baseDirectory
   */
  public static function getCompleteFileName($fileName) {
    $dir = "";
    if (!is_null(Mutex::$baseDirectory)) {
      $dir = Mutex::$baseDirectory . DIRECTORY_SEPARATOR;
    }
    return $dir . $fileName . '.lock';
  }

  /**
   * If the file were unlocked, lock it and return TRUE.
   * If the file is already locked return FALSE.
   * In case of CRON processor, delete the lock file if it exists.
   *
   * @return TRUE if the lock can be acquired, FALSE otherwise.
   */
  public function maybeLock($isCronProcess) {
    $h = fopen($this->fileName, "x");

    if ($h == FALSE) {
      // file already exists, and lock can not be acquired
      //
      if ($isCronProcess) {
        $this->forceUnlock();
      }

      return FALSE;
       
    } else {
      // ok file was created, and lock acquired!
      //
      fclose($h);

      // Allows other process to delete the file.
      // This is usefull, because some time the job processor can be executed from the root user, 
      // and scheduled jobs from http user.
      chmod($this->fileName, 0666); // uga+rw

      $this->isLocked = TRUE;
      return TRUE;
    }
  }

  /**
   * @param $fileName
   * @param $maxAge max allowed age of the file, in unix timestamp
   * 
   * @return TRUE if the file is expired and in this case touch again the file, FALSE otherwise.
   */
  public function maybeTouch($maxAge) {
    $checkFile = $this->fileName;
    $checkLimit = $maxAge;

    if (! file_exists($checkFile)) {
      $f = fopen($checkFile, "w");
      fclose($f);
      chmod($checkFile, 0666); // uga+rw

      return TRUE;
    }

    $lastCheck = filemtime($checkFile);

    if ($checkLimit > $lastCheck) {
      touch($checkFile);
      return TRUE;
    } else {
      return FALSE;
    }
  }

  /**
   * Release the lock on the file.
   */
  public function unlock() {
    if ($this->isLocked == TRUE) {
      $this->forceUnlock();
      $this->isLocked = FALSE;
    }
  }

  public function forceUnlock() {
    $u = unlink($this->fileName);
    if ($u == FALSE) {
      if (file_exists($this->fileName)) {
        // sometime is directly the CRON job processor deleting the lock file,
        // so before generating the error, test it!
        //
        $p = new ArProblem();
        $p->setDuplicationKey("Unable to delete lock file");
        $p->setDescription("The lock file " . $this->fileName . " can not be deleted.");
        $p->setEffect("Probably the Job Processor can not start. So all update functions of Asterisell are blocked. New CDR are not processed.");
        $p->setProposedSolution('Delete the problem table. Check if the problem persist. Check the JOB LOG. See if new jobs are processed. In case of errors check using a ssh connnection to the server the problems with the lock file. Maybe there access rights, related problems.');
        ArProblemException::addProblemIntoDBOnlyIfNew($p);
      }
    }

  }

}

?>