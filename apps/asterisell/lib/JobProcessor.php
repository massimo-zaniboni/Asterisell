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

abstract class JobProcessor {

  /**
   * Execute a job processing a JobData. 
   *
   * The JobData can not be modified.
   *
   * The Job can add new jobs to the JobQueue in order 
   * to decompose a complex jobs in dependent jobs.
   *
   * @param JobData $jobData the data describing the job
   * @param $id the ArJobQueue.id 
   * @return TRUE if the JOB was sucessfulling processed.
   * FALSE if the JobData is not appropiated.
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
  public abstract function process(JobData $jobData, $jobId);


}
?>