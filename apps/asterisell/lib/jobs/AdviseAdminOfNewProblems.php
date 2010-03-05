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

    $r = "";

    $eol = "\r\n";

    // are there problems?
    // NOTE: chek only problems that are not marked as NOT DELETE,
    // this because these problems are well known to administrator.
    // 
    $mc = new Criteria();
    $mc->add(ArProblemPeer::MANTAIN, 1, Criteria::NOT_EQUAL);
    $alreadyAdvised = ArProblemPeer::doCount($mc);

    $nrOfProblems = ArProblemPeer::doCount(new Criteria());
    if ($nrOfProblems == 0) {
      return "There were no problems";
    }

    // send an email to every administrator 
    //
    $allParams = ArParamsPeer::doSelect(new Criteria());
    foreach($allParams as $params) {
      $emailAddress = trim($params->getServiceProviderEmail());
      if (!is_null($emailAddress) && strlen($emailAddress) > 0) {
	// is admin already advised?
	//
	$advisedAdminKey = "advise admin " . $params->getId() . " of new problems";
	$c = new Criteria();
	$c->add(ArProblemPeer::DUPLICATION_KEY, $advisedAdminKey);
	$alreadyAdvised = ArProblemPeer::doCount($c);
	
	if ($alreadyAdvised == 0) {
	  $subject = $params->getServiceProviderWebsite() . " - automatic problem notification";
	  $body = "There are problems on Asterisell website: " . $eol . $eol . "  " . $params->getServiceProviderWebsite() . $eol . $eol . "The Problem Table on the website, contains all the details.";
	  $message = Swift_Message::newInstance($subject, $body);
          $message->setFrom(array($emailAddress => $params->getServiceName()));
	  $message->setTo(array($emailAddress => $params->getServiceName()));
	  $mailer = Mailer::getNewInstance($params);
	  $numSent = $mailer->send($message);
	  
	  if ($numSent > 0) {
	    $p = new ArProblem();
	    $p->setDuplicationKey($advisedAdminKey);
	    $p->setDescription("An email was sent to " . $emailAddress . " for advsing of new problems.");
	    $p->setProposedSolution("Check problems. Delete all problems from the table in order to be advised if there will be new problems.");
	    ArProblemException::addProblemIntoDBOnlyIfNew($p);
	  } else {
	    $p = new ArProblem();
	    $p->setDuplicationKey("sending email " . $emailAddress);
	    $p->setDescription("Problems sending email " . $emailAddress);
	    ArProblemException::addProblemIntoDBOnlyIfNew($p);
	  }

	  $r .= "Administrator $emailAddress advised of new problems. ";
	} else {
	}
      } else {
	$r .= "Administrator with params " . $param->getName() . " was not advised because it has not configured email address. ";
      }
    }
    return $r;
  }
}
?>