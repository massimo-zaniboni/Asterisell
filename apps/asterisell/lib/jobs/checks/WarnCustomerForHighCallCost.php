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

require_once 'ext_libs/SwiftMailer/swift_required.php';

require_once 'Mailer.php';

/**
 * Send an Email to a customer about high call costs.
 */
class WarnCustomerForHighCallCost extends JobProcessor
{

    public function process(JobData $jobData, $parentJobId)
    {

        if (!($jobData instanceof WarnCustomerForHighCallCostEvent)) {
            return FALSE;
        }

        $party = PartyPeer::retrieveByPk($jobData->arPartyId);
        $params = $party->getArParams();

        $message = Swift_Message::newInstance()
                ->setSubject($jobData->mailSubject)
                ->setFrom(array(trim($jobData->$mailFromAddress) => $params->getServiceName()))
                ->setTo(array($jobData->$mailToAddress => $party->getFullName()))
                ->setBody($jobData->mailContent);

        $mailer = Mailer::getNewInstance($params);
        $numSent = $mailer->send($message);

        if ($numSent > 0) {
            $party->setLastEmailAdviseForMaxLimit30(date("c"));
            $party->save();
        } else {
            throw new Exception('Problems sending mail to customer "' . $party->getFullName() . '" at email address "' . $jobData->mailToAddress . '"');
        }

        return TRUE;
    }
}

?>