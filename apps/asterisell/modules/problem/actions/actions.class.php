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

class problemActions extends autoproblemActions {

  public function executeDeleteProblems() {
    $connection = Propel::getConnection();
    $query = 'DELETE FROM ar_problem WHERE (NOT mantain) or mantain IS NULL';
    $statement = $connection->createStatement();
    $statement->executeUpdate($query);
    return $this->forward('problem', 'list');
  }

  public function executeRefreshView() {
    return $this->redirect('problem/list');
  }

  public function executeTestCostLimit() {
    $p = new CheckCallCostLimit();
    $p->checkAllLimits();

    return $this->forward('problem', 'list');
  }

  public function executeSeeWebsite() {
    $params = $this->getUser()->getParams();
    $params->setLastViewedFeedsMd5($params->getCurrentFeedsMd5());
    $params->save();

    $this->redirect('http://asterisell.profitoss.com');
  }

  public function executeRunProcessor() {

    $processor = new JobQueueProcessor();

    $allOk = $processor->process();
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

    return $this->redirect('problem/list');
  }

  public function executeCheckCostLimit() {
    $p = new CheckCallCostLimit();
    $p->checkAllLimits();

    return $this->forward('problem', 'list');
  }

  public function executeSeeJobQueue() {
    return $this->redirect('jobqueue/list');
  }

}
