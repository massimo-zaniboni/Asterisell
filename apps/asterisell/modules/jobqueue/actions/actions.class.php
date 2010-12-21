<?php

/**
 * jobqueue actions.
 *
 * @package    asterisell
 * @subpackage jobqueue
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class jobqueueActions extends autojobqueueActions
{
  /**
   * Executes index action
   *
   */
  public function executeIndex()
  {
    $this->forward('default', 'module');
  }

  public function executeRunProcessor() {

    $processor = new JobQueueProcessor();

    $allOk = $processor->processOnline();
    if (is_null($allOk)) {
      $prop = 'JobQueue processor is already running.';
    } else if ($allOk == TRUE) {
      $prop = 'No errors';
    } else if ($allOk == FALSE) {
      $prop = 'There were problems during the execution of the action. See Problem Table for more details.';
    } else {
      $prop = 'Unknown result.';
    }

    $this->setFlash('notice', $prop);

    return $this->redirect('jobqueue/list');
  }

  public function executeRefreshView() {
    return $this->redirect('jobqueue/list');
  }

  public function executeCheckCostLimit() {
    $p = new CheckCallCostLimit();
    $p->checkAllLimits();

    return $this->forward('jobqueue', 'list');
  }

  public function executeSeeProblems() {
    return $this->redirect('problem/list');
  }


}
