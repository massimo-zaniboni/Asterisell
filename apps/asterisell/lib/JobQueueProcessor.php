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
 * Process all queued jobs.
 *
 * A Job Queue allows to execute Jobs in a separate way respect
 * the direct execution inside the web-server session.
 *
 * This increase the efficiency and robustness of the application,
 * because an off-line work has no the memory and CPU time constraints.
 *
 * Another advantage is that the system is like a blackboard, where
 * developers can add new Jobs. Every Job is activated when it recognize
 * a certain event and it can generate other events.
 *
 * TODO: in PHP there can be errors that are not received from
 * error handler. So the job processor can be interrupted.
 * This behaviour is different from intended behaviour.
 * A better solution can be:
 *   - create a table containing all events;
 *   - generate for each event the jobs on it;
 *   - process pending jobs;
 *   - process the next event;
 *   - if there is an interrupted job then there is a bad-error and it is signaled;
 *   - normal errors are signaled;
 * This design is also more coherent with the division between events and jobs.
 * Up to date an hack is inserted: there is a job signaling a problem
 * if there are pending jobs, not executed correctly.
 *
 * @return TRUE if all Jobs are executed without problems,
 * FALSE otherwise. The probem description is put on the Problem table.
 */
class JobQueueProcessor
{

    const MUTEX_FILE_NAME = "jobqueueprocessor";

    public static $IS_WEB_PROCESS = FALSE;

    /**
     * The unix time stamp after the web jobs must stop
     */
    public static $MAX_EXECUTION_TIME = 0;

    protected $mutex = NULL;

    /**
     * Try acquiring a lock. This can be used internally or externally.
     * Call `unlock` at the end.
     *
     * @return TRUE if the lock was acquired.
     */
    public function lock($isCronProcess = TRUE) {

        // Only one processor can execute jobs because they can change the
        // external environment.
        // In any case if there is another job processor running, then
        // current jobs will be executed in any case so it is not a problem.
        //
        $mutex = new Mutex(JobQueueProcessor::MUTEX_FILE_NAME);
        $mutex->setIsCronProcess($isCronProcess);
        $acquired = $mutex->maybeLock();

        if ($acquired) {
            $this->mutex = $mutex;
        }

        return $acquired;
    }

    public function unlock() {
        if (!is_null($this->mutex)) {
            $this->mutex->unlock();
        }
    }

    public function forceUnlockOfHaltedWebProcess() {
        $mutex = new Mutex(JobQueueProcessor::MUTEX_FILE_NAME);
        $acquired = $mutex->maybeLock(TRUE);

        if ($acquired) {
            $mutex->unlock();
        }
    }

    /**
     * @return TRUE if there is time for other jobs,
     *         FALSE if there is no more time, and signal the problem to the user.
     */
    public static function isThereTimeForOtherJobs()
    {

        if (self::$IS_WEB_PROCESS) {

            $t = time();

            if ((self::$MAX_EXECUTION_TIME - $t) < 10) {

                $p = new ArProblem();
                $p->setDuplicationKey("remainTimeForOtherJobs - $t");
                $p->setDescription("There is no more time for execution of jobs invoked from web users.");
                $p->setEffect("Current jobs will be temporary suspended. They will start again, invoked from the cron job processor.");
                $p->setProposedSolution("Nothing to do: wait the cron job processor.");
                ArProblemException::addProblemIntoDBOnlyIfNew($p);

                return FALSE;
            }
        }

        return TRUE;
    }

    /**
     * Execute all pending jobs, from an administrator connected online.
     * In this working mode, new errors are sent to the error table, but they are not notified
     * via mail to administrators. This allows reducing noise.
     *
     * @param $lockFileDirectory NULL if it is invoked from a normal web-session,
     * otherwise use the path to asterisell/web directory,
     * if called from an external script.
     * This allows to use the same lock file of the running web application, and
     * also recognizing cron job processor invocation, that are managed a little differently.
     *
     * @return TRUE if it is all OK, FALSE if there are problems,
     * NULL if th job queue processor is already locked.
     *
     * NOTE: never add "string $lockFileDirectory" for parameter declaration
     * because it crash old version of PHP...
     */
    public function processOnline($lockFileDirectory = NULL)
    {
        ArProblemException::disableNotificationsToAdmin();
        self::$IS_WEB_PROCESS = TRUE;
        return $this->process($lockFileDirectory);
    }

    /**
     * Execute all pending jobs.
     *
     * @param $lockFileDirectory NULL if it is invoked from a normal web-session,
     * otherwise use the path to asterisell/web directory,
     * if called from an external script.
     * This allows to use the same lock file of the running web application, and
     * also recognizing cron job processor invocation, that are managed a little differently.
     *
     * @return TRUE if it is all OK, FALSE if there are problems,
     * NULL if th job queue processor is already locked.
     *
     * NOTE: never add "string $lockFileDirectory" for parameter declaration
     * because it crash old version of PHP...
     *
     */
    public function process($lockFileDirectory = NULL)
    {

        $isCronProcess = FALSE;
        if (!is_null($lockFileDirectory)) {
            $isCronProcess = TRUE;
        }

        if ($isCronProcess) {
            self::$MAX_EXECUTION_TIME = strtotime("+1 year");
        } else {
            $t = ini_get('max_execution_time');
            if ($t === FALSE) {
                $t = 60;
            }
            if ($t == 0) {
                // infinite time
                self::$MAX_EXECUTION_TIME = strtotime("+1 year");
            } else {
                self::$MAX_EXECUTION_TIME = strtotime("+$t seconds");
            }
        }

        $isLocked = $this->lock($isCronProcess);

        // exit if there is no acquired lock
        // (another job-queue-processor is running).
        //
        if (!$isLocked) return NULL;

        // NOTE: online jobs started from the administrator can always start
        //
        if ($isCronProcess && MyUser::isCronLockedForMaintanance()) return NULL;

        // Signal the problem if some old job were not completely executed.
        //
        $this->areThereAbortedJobs();

        $allOk = TRUE;

        // Intercept all errors.
        //
        try {
            // First execute "always_scheduled_jobs"
            // following their order of declaration.
            //
            // These are FixedJobProcessor.
            //
            // An error in one of this Job does not block the chain,
            // because all the fixed jobs are important and must be
            // executed.
            //
            $jobs = sfConfig::get('app_available_always_scheduled_jobs');
            foreach ($jobs as $jobClass) {
                if (JobQueueProcessor::isThereTimeForOtherJobs()) {
                    try {
                        $jobLog = NULL;
                        $job = new $jobClass();

                        $jobData = new NullJobData();
                        $jobLog = ArJobQueue::addNewWithStateAndDescription($jobData, NULL, ArJobQueue::RUNNING, $jobClass);

                        $msg = $job->process();

                        $jobLog->setState(ArJobQueue::DONE);
                        $jobLog->setDescription($jobLog->getDescription() . ": " . $msg);
                        $jobLog->setEndAt(date("c"));
                        $jobLog->save();
                    } catch (Exception $e) {
                        if (!is_null($jobLog)) {
                            $jobLog->setState(ArJobQueue::ERROR);
                            $jobLog->setEndAt(date("c"));
                            $jobLog->save();
                        }

                        $allOk = FALSE;

                        $p = new ArProblem();
                        $p->setDuplicationKey("FixedJobs Processor " . $jobClass);
                        $p->setDescription("Error during the execution of always_scheduled_job $jobClass . The error message is: " . $e->getMessage() . ". Stack trace: " . $e->getTraceAsString());
                        $p->setEffect("This error prevent the execution of the specified jobs, but not the execution of other always-scheduled and normal jobs.");
                        $p->setProposedSolution("Fix the problem. If you change the configuration file, you should probably re-rate all previous calls in order to back-propagate changes.");
                        ArProblemException::addProblemIntoDBOnlyIfNew($p);
                    }
                }
            }

            // Query the jobs-data / events to process.
            // Note: the ascending order on is_part_of allows ordering
            // jobs according their dependencies.
            //
            $c = new Criteria();
            $c->addAscendingOrderByColumn(ArJobQueuePeer::IS_PART_OF);
            $c->add(ArJobQueuePeer::STATE, ArJobQueue::TODO);

            $jobProcessors = null;

            $again = TRUE;
            while ($again && JobQueueProcessor::isThereTimeForOtherJobs()) {

                $job = ArJobQueuePeer::doSelectOne($c);
                //
                // NOTE: re-execute the query because a Job can add new jobs
                // inside the queue.

                if (is_null($job)) {
                    $again = FALSE;
                } else {
                    // init "$jobProcessors"
                    // only if there are
                    // jobs to execute.
                    //
                    if (is_null($jobProcessors)) {
                        $jobProcessors = array();
                        $processors = sfConfig::get('app_available_jobs');
                        foreach ($processors as $processorClass) {
                            $processor = new $processorClass();
                            array_push($jobProcessors, $processor);
                        }
                    }

                    // Intercept errors specific of current job processing.
                    // These errors block only current job.
                    //
                    $report = $job->getDescription();
                    try {
                        $job->setStartAt(date('c'));
                        $job->setState(ArJobQueue::RUNNING);
                        $job->save();

                        $jobData = $job->unserializeDataJob();

                        $report .= " (Jobs executed for event \"" . get_class($jobData) . "\":";

                        foreach ($jobProcessors as $process) {
                            $applied = $process->process($jobData, $job->getId());
                            if ($applied == TRUE) {
                                $report .= ' "' . get_class($process) . '"';
                            }
                        }

                        $report .= ')';

                        $job->setState(ArJobQueue::DONE);
                        $job->setDescription($report);
                        $job->setEndAt(date('c'));
                        $job->save();

                    } catch (Exception $e) {
                        $allOk = FALSE;

                        $report .= ')';

                        $job->setState(ArJobQueue::ERROR);
                        $job->setDescription($report);
                        $job->setEndAt(date('c'));
                        $job->save();

                        $p = new ArProblem();
                        $p->setDuplicationKey('job ' . $job->getId() . ' - ' . $e->getCode());
                        $p->setDescription("Error on job " . $job->getId() . ": " . $e->getCode() . ' - ' . $e->getMessage());
                        ArProblemException::addProblemIntoDBOnlyIfNew($p);
                    }
                } // if
            } // while
        } catch (Exception $e) {
            $allOk = FALSE;

            $p = new ArProblem();
            $p->setDuplicationKey("job queue processor - " . $e->getCode());
            $p->setDescription("Error during job queue processing: " . $e->getCode() . ' - ' . $e->getMessage());
            $p->setEffect("This error prevent the execution of all other jobs.");
            ArProblemException::addProblemIntoDBOnlyIfNew($p);
        }

        // Release the resources.
        //
        // NOTE: it is very important to release the lock in case of error,
        // otherwise the system will be blocked!!!
        //
        $this->unlock();

        return $allOk;
    }

    /**
     * Signal if there are aborted jobs.
     *
     * @return TRUE if there are aborted jobs.
     */
    protected function areThereAbortedJobs()
    {
        $c = new Criteria();
        $c->add(ArJobQueuePeer::STATE, ArJobQueue::RUNNING);
        $jobs = ArJobQueuePeer::doSelect($c);

        // Set PEDING JOBS to ERROR
        //
        $signalProblem = FALSE;
        foreach ($jobs as $job) {
            $signalProblem = TRUE;

            $job->setState(ArJobQueue::ERROR);
            $job->setDescription($job->getDescription() . ": an uncaught fatal error interrupted this job.");
            $job->setEndAt(date('c'));
            $job->save();
        }

        // Signal the problem in the problem table
        //
        if ($signalProblem == TRUE) {
            $p = new ArProblem();
            $p->setDuplicationKey("AdviseIfThereAreUnprocessedJobs run");
            $p->setDescription("There are jobs causing a severe/fatal PHP error. These jobs are listed in JobLog as ERROR.");
            $p->setEffect("The job uncaught exception/fatal error, block the execution of this jobs, but also the execution of all following jobs. This halt the normal behaviour of the system.");
            $p->setProposedSolution('Execute the JobProcessor inside a shell. Use something like "cd /<asterisell-dir>/scripts; sudo -u <www-user> php process_jobs.php", in order to display PHP errors. Make sure that xdebug extension is installed, otherwise the call-stack-trace will not be displayed. Usually these problems are related to bad PHP syntax or usage of NULL pointer/objects, etc.. Normal errors/exceptions are already managed from Asterisell application.');
            ArProblemException::addProblemIntoDBOnlyIfNew($p);
        }

        return $signalProblem;
    }



}
?>