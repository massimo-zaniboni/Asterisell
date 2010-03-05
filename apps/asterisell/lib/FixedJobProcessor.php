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
 * A JobProcessor that starts without any event firing it.
 * It is typically used for system/maintanance jobs.
 */
abstract class FixedJobProcessor {

  /**
   * Execute a job. 
   * 
   * @return a String describing briefly the job execution in case of success
   * @throw an Exception in case of an error during JOB processing.
   *
   * Exception must be throwed in this way:
   *
   * > $p = new ArProblem();
   * > $p->setDuplicationKey(...);
   * > $p->setDescription(...);
   * > $p->setCreatedAt(...);
   * > $p->setEffect(...);
   * > $p->setProposedSolution(...);
   * > throw (new ArProblemException($p));
   *
   * Non blocking problems can be signaled only with a message
   * on the problem report:
   *
   * > $p = new ArProblem();
   * > ...
   * > ArProblemException::addProblemIntoDBOnlyIfNew($p);
   *
   */
  public abstract function process();


}
?>