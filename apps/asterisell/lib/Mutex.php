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
 * Implement a MUTEX using "flock" PHP function.
 *
 * This class guarantee that all lock files generated
 * have the ".lock" suffix.
 */
class Mutex {

  /**
   * Where files will be created/open.
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
    $this->fileName =  Mutex::getCompleteFileName($name . '.lock');
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
    return $dir . $fileName;
  }

  /**
   * If the file were unlocked, lock it and return TRUE.
   * If the file is already locked return FALSE.
   */
  public function maybeLock() {

    if (! file_exists($this->fileName)) {
      $f = fopen($this->fileName, "w");
    } else {
      $f = fopen($this->fileName, "r+");
    }
  
    if ($f != FALSE) {
      if (flock($f, LOCK_EX | LOCK_NB)) {
        $this->isLocked = TRUE;
        return TRUE;
	// NOTE: does not close the file because 
	// it will release the lock...
      } else {
	fclose($f);
        return FALSE;
      }
    } else {
      return FALSE;
    }
  }

  /**
   * Release the lock on the file.
   */
  public function unlock() {
    if ($this->isLocked == TRUE) {
      $f = fopen($this->fileName, "r+");
      if ($f != FALSE) {
	flock($f, LOCK_UN);
	fclose($f);
      }
      $this->isLocked = FALSE;
    }
  }

}

?>