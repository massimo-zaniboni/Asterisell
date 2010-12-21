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
 * Check if there are new problems,
 * and advise the administrator.
 */
class AdviseAdminOfNewProblems extends FixedJobProcessor {

  public function process() {

    $eol = "\r\n";

    // Select only new problems...
    //
    $c = new Criteria();
    ArProblemPeer::addSelectColumns($c);
    $c->add(ArProblemPeer::SIGNALED_TO_ADMIN, 1, Criteria::NOT_EQUAL);
    $rs = ArProblemPeer::doSelectRS($c);

    // Prepare a string describing the problems
    //
    $limit = 50;
    $countProblems = 0;
    $d = "";
    while ($rs->next()) {
      $countProblems++;

      if ($countProblems <= $limit) {

        $problem = new ArProblem();
        $problem->hydrate($rs);

        $d .= "    Problem no. " . $countProblems . " - " . fromUnixTimestampToSymfonyStrDate($problem->getCreatedAt())
                . $eol
                . $eol
                . "Description: " . $problem->getDescription()
                . $eol
                . $eol
                . "Effect: " . $problem->getEffect()
                . $eol
                . $eol
                . "Suggested Solution: " . $problem->getProposedSolution()
                . $eol
                . $eol;
      }
    }
    $rs->close();

    // Stop here if there are no problems to signal
    //
    if ($countProblems == 0) {
      return "No new problems to signal.";
    }

    $sentAllMails = true;
    $allParams = ArParamsPeer::doSelect(new Criteria());
    $status = "";
    foreach ($allParams as $params) {
      $emailAddress = trim($params->getServiceProviderEmail());
      if ((!is_null($emailAddress)) && strlen($emailAddress) > 0 && Mailer::isConfigured($params)) {
        $subject = "[" . $params->getServiceProviderWebsite() . "] " . $countProblems . " new problems";

        $body = "There are " . $countProblems . " new problems on Asterisell website " . $params->getServiceProviderWebsite()
                . $eol
                . $eol;

        if ($countProblems > $limit) {
          $body .= "Only the first " . $limit . " new problems will be inserted into this notification."
                  . $eol
                  . $eol;
        }

        $body .= $d;

        $message = Swift_Message::newInstance($subject, $body);
        $message->setFrom(array($emailAddress => $params->getServiceName()));
        $message->setTo(array($emailAddress => $params->getServiceName()));
        $mailer = Mailer::getNewInstance($params);
        $numSent = $mailer->send($message);

        if ($numSent == 0) {
          $sentAllMails = false;
          $p = new ArProblem();
          $p->setDuplicationKey("sending email " . $emailAddress);
          $p->setDescription("Problems sending email to <" . $emailAddress . "> inside job AdviseAdminOfNewProblems.");
          ArProblemException::addProblemIntoDBOnlyIfNew($p);
        } else {
          $status .= " Administrator <$emailAddress> advised of new problems. ";
        }
      } else {
        $status .= "Administrator with params " . $params->getName() . " was not advised because it has not configured email address. ";
      }
    }

    // Signal the problems as already sent
    //
    if ($sentAllMails == true) {
      self::setAllProblemsAsSignaled();
    }

    return $status;
  }

  static public function setAllProblemsAsSignaled() {
    $connection = Propel::getConnection();
    $query = "UPDATE ar_problem SET signaled_to_admin = 1;";
    $connection->executeUpdate($query);
  }

}

?>