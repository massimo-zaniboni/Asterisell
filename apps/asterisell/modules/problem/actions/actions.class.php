<?php
/*
* Copyright (C) 2007 Massimo Zaniboni - massimo.zaniboni@profitoss.com
*
*   This file is part of Asterisell.
*
*   Asterisell is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 3 of the License, or
*   (at your option) any later version.
*
*   Asterisell is distributed in the hope that it will be useful,
*   but WITHOUT ANY WARRANTY; without even the implied warranty of
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
*   GNU General Public License for more details.
*
*   You should have received a copy of the GNU General Public License
*   along with Asterisell. If not, see <http://www.gnu.org/licenses/>.
*    
*/
class problemActions extends autoproblemActions {
  public function executeDeleteProblems() {
    $connection = Propel::getConnection();
    $query = 'DELETE FROM ar_problem WHERE (NOT mantain) or mantain IS NULL';
    $statement = $connection->createStatement();
    $statement->executeUpdate($query);
    return $this->forward('problem', 'list');
  }
  public function executeTestCostLimit() {
    $engine = new PhpRateEngine();
    // XXX
    // $engine->rateAllAndTest(false);
    $engine->rateAllAndTest(true);
    return $this->forward('problem', 'list');
  }
}
