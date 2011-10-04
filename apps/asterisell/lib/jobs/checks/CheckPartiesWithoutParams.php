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
 * Check Parties without a specified Params.
 * Last version of Asterisell force this parameter, later version no.
 * So the need for this check.
 */
class CheckPartiesWithoutParams extends FixedJobProcessor {
    /**
     * This file contains the date of last check of call cost limits.
     */
    const FILE_WITH_LAST_CHECK_DATE = "last_CheckPartiesWithoutParams";

    public function process() {
        $timeFrameInMinutes = 30;

        $checkFile = CheckCallCostLimit::FILE_WITH_LAST_CHECK_DATE;
        $checkLimit = strtotime("-$timeFrameInMinutes minutes");
        $mutex = new Mutex($checkFile);
        if ($mutex->maybeTouch($checkLimit)) {
            $this->checkAll();
            touch($checkFile);
        }
    }

    /**
     * Execute the check of all parties
     */
    public function checkAll() {
        $c = new Criteria();
        $c->add(ArPartyPeer::AR_PARAMS_ID, NULL);
        $parties = ArPartyPeer::doSelect($c);

        $thereIsError = FALSE;
        $d = "";
        foreach ($parties as $party) {
            if ($thereIsError) {
                $d .= ", ";
            }
            $thereIsError = TRUE;

            $d .= $party->getFullName();
        }

        if ($thereIsError) {
            $p = new ArProblem();
            $p->setCreatedAt(date("c"));
            $p->setDuplicationKey("parties with null params");
            $p->setDescription("There are parties associated to no params/company. They are: " . $d . ".");
            $p->setEffect("Filters working on certain params/companies will not include all parties.");
            $p->setProposedSolution("Specify the correct param/company for these parties.");
            ArProblemException::addProblemIntoDBOnlyIfNew($p);
        }
    }

}

?>