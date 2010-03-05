<?php

/**
 * Subclass for representing a row from the 'ar_job_queue' table.
 *
 * @package lib.model
 */ 
class ArJobQueue extends BaseArJobQueue
{

  const TODO = 0;
  const RUNNING = 1;
  const DONE = 2;
  const ERROR = 3;

  public function getTypeDescription() {
    $t = $this->getState();
    if ($t == ArJobQueue::TODO) {
      return "TODO";
    } else if ($t == ArJobQueue::RUNNING) {
      return "RUNNING";
    } else if ($t == ArJobQueue::DONE) {
      return "DONE";
    } else if ($t == ArJobQueue::ERROR) {
      return "ERROR";
    } else {
      return "!!!";
    }
  }


  /**
   * Add a new job on the queue.
   * @param JobData $d the data describing the job.
   * @param $parentId the ArJobQueue.id of the main job, NULL if this job is already a main (top-level) job.
   * @return the created job
   */
  static public function addNewWithStateAndDescription(JobData $d, $parentId, $state, $description) {
    $job = new ArJobQueue();
    $job->setState($state);
    $job->setCreatedAt(date("c"));
    $job->setDescription($description);
    $job->setPhpDataJobSerialization(serialize($d));
    $job->setIsPartOf($parentId);
    $job->save();

    if (is_null($parentId)) {
      $newParentId = $job->getId();
      $job->setIsPartOf($newParentId);
      $job->save();
    }

    return $job;
  }


  /**
   * Add a new job on the queue.
   * @param JobData $d the data describing the job.
   * @param $parentId the ArJobQueue.id of the main job, NULL if this job is already a main (top-level) job.
   * @return the created job
   */
  static public function addNew(JobData $d, $parentId) {
    return self::addNewWithStateAndDescription($d, $parentId, self::TODO, $d->getDescription());
  }

  /**
   * @return an unserialized DataJob
   * null if it does not exists or it is in a bad format.
   */
  public function unserializeDataJob() {
    $d = null;

    $r = $this->getPhpDataJobSerialization();
    if (! is_null($r)) {

      // note: it is a LONGTEXT and it is managed
      // from Symfony in a different way respect strings.
      //
      $ds = $r->getContents();
      if (! is_null($ds)) {
        $d = unserialize($ds);
        if ($d == false) {
          $d = null;
        }
      }
    }
    return $d;
  }

}
?>