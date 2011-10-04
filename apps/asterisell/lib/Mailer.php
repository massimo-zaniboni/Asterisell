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

class Mailer {

  /**
   * Mantains a list of already open SwiftMailers
   * according SMTP destination server and username.
   * In this way it is possible to send multiple emails to the same
   * STMP server using the same connection and using throtling and
   * other advanced tecniques.
   */
  protected static $from_stmpServer_username_to_SwiftMailer = array();

  /**
   * @param $params the params with the SMTP configuration.
   * @return TRUE if the mailer is properly configured and email can be sent.
   */
  public static function isConfigured($params) {
    $host = $params->getSmtpHost();

    if (is_null($host)) {
      return false;
    }

    if (strlen(trim($host)) == 0) {
      return false;
    }

    return true;
  }

  /**
   * This method allows to reuse the same open Swift_Mailers.
   *
   * @param $params the params with the SMTP configuration.
   * @return a configured / initialized Swift_Mailer.
   */
  public static function getNewInstance($params) {
    $host = $params->getSmtpHost();
    $username = $params->getSmtpUsername();

    // Return the cached value...
    //
    if (isset(self::$from_stmpServer_username_to_SwiftMailer[$host])) {
      if (isset(self::$from_stmpServer_username_to_SwiftMailer[$host][$username])) {
        return self::$from_stmpServer_username_to_SwiftMailer[$host][$username];
      }
    }

    // If not here, then create a new Mailer
    //
    $transport = Swift_SmtpTransport::newInstance()
            ->setHost($params->getSmtpHost())
            ->setPort($params->getSmtpPort())
            ->setUsername($username)
            ->setPassword($params->getSmtpPassword());

    if (!is_null($params->getSmtpEncryption())) {
      $encryption = trim(strtolower($params->getSmtpEncryption()));
      if ($encryption != 'plain') {
        $transport->setEncryption($encryption);
      }
    }

    $mailer = Swift_Mailer::newInstance($transport);

    $emailsLimit = $params->getSmtpReconnectAfterNrOfMessages();
    $pause = $params->getSmtpSecondsOfPauseAfterReconnection();

    if (!is_null($emailsLimit) && $emailsLimit != 0) {
      $plugin = new Swift_Plugins_AntiFloodPlugin();
      $plugin->setThreshold($emailsLimit);
      if (!is_null($pause) && $pause != 0) {
        $plugin->setSleepTime($pause);
      }
      $mailer->registerPlugin($plugin);
    }

    self::$from_stmpServer_username_to_SwiftMailer[$host][$username] = $mailer;

    return $mailer;
  }

}

?>