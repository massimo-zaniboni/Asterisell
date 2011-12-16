<?php

/* $LICENSE 2011:
 *
 * Copyright (C) 2011 Massimo Zaniboni <massimo.zaniboni@profitoss.com>
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

////////////////////////////////////
// INIT ENVIRONMENT AND CALL MAIN //
////////////////////////////////////

define('SF_ROOT_DIR', realpath(dirname(__FILE__)));
define('SF_APP', 'asterisell');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG', false);

require_once(SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'apps' . DIRECTORY_SEPARATOR . SF_APP . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php');

sfLoader::loadHelpers(array('I18N', 'Debug', 'Asterisell'));

sfContext::getInstance();

define('WEB_DIR', SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'web');

main($argc, $argv);

//////////////////////
// DATABASE UPGRADE //
//////////////////////

/**
 * Apply upgrade commands only if they are not already applied.
 *
 * @param $findNewCommands TRUE for applying only not already applied commands
 * @param $applyCommands TRUE for applying commands to SQL database
 * @param $storeCommands TRUE for storing in upgrade table the commands
 * @return TRUE if there were commands working on the CDR table
 */
function upgradeDatabase($findNewCommands, $applyCommands, $storeCommands)
{
    // commands to apply
    $r = array();
    $i = 1;

    $cdrCommandIndexes = array();

    // NOTE: the order and the key of the array is very important because it is used also as a key for recognizing
    // already executed commands. You should only add commands to this list.
    //
    $r[$i++] = "alter table ar_params modify column vat_tax_perc integer(20) not null default 0;";
    $r[$i++] = "alter table ar_params add `logo_image_in_invoices` VARCHAR(120);";
    $r[$i++] = "alter table ar_params add `invoice_notes` VARCHAR(2048);";
    $r[$i++] = "alter table ar_params add `invoice_payment_terms` VARCHAR(2048);";
    $r[$i++] = "alter table ar_params add `current_invoice_nr` INTEGER(11) default 1 NOT NULL;";
    $r[$i++] = "alter table ar_params drop column`pdf_call_report`;";
    $r[$i++] = "alter table ar_invoice add `pdf_call_report` LONGBLOB;";
    $r[$i++] = "alter table ar_invoice_creation add `ar_params_id` INTEGER;";
    $r[$i++] = "ALTER TABLE ar_invoice_creation ADD (KEY `ar_invoice_creation_FI_1` (`ar_params_id`), CONSTRAINT `ar_invoice_creation_FK_1` FOREIGN KEY (`ar_params_id`) REFERENCES `ar_params` (`id`));";
    $r[$i++] = "ALTER TABLE ar_invoice ADD `info_or_ads_image1` VARCHAR(1024);";
    $r[$i++] = "ALTER TABLE ar_invoice ADD `info_or_ads_image2` VARCHAR(1024);";
    $r[$i++] = "ALTER TABLE ar_invoice_creation ADD `info_or_ads_image1` VARCHAR(1024);";
    $r[$i++] = "ALTER TABLE ar_invoice_creation ADD `info_or_ads_image2` VARCHAR(1024);";
    $r[$i++] = "ALTER TABLE ar_params ADD `logo_html_color` VARCHAR(12);";
    $r[$i++] = "CREATE TABLE `ar_payment` (`id` int(11) NOT NULL AUTO_INCREMENT, `ar_party_id` int(11) DEFAULT NULL, `date` date DEFAULT NULL, `invoice_nr` varchar(20) DEFAULT NULL, `payment_method` varchar(1024) DEFAULT NULL, `payment_references` varchar(1024) DEFAULT NULL, `amount` int(20) NOT NULL DEFAULT 0, `note` text, PRIMARY KEY (`id`), KEY `ar_payment_date_index` (`date`), KEY `ar_payment_invoice_nr_index` (`invoice_nr`), KEY `ar_payment_amount_index` (`amount`), KEY `ar_payment_FI_1` (`ar_party_id`), CONSTRAINT `ar_payment_FK_1` FOREIGN KEY (`ar_party_id`) REFERENCES `ar_party` (`id`)) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $r[$i++] = "ALTER TABLE ar_invoice ADD `total_bundle_without_tax` int(20) DEFAULT 0;";
    $r[$i++] = "ALTER TABLE ar_invoice ADD `total_calls_without_tax` int(20) DEFAULT 0;";
    $r[$i++] = "CREATE TABLE `ar_rate_incremental_info` (`id` int(11) NOT NULL AUTO_INCREMENT, `ar_party_id` int(11) DEFAULT NULL, `ar_rate_id` int(11) DEFAULT NULL,  `period` varchar(1024) DEFAULT NULL,   `last_processed_cdr_date` datetime DEFAULT NULL,   `last_processed_cdr_id` int(20) DEFAULT NULL,   `bundle_rate` longtext,   PRIMARY KEY (`id`),   KEY `ar_rate_incremental_info_period_index` (`period`(767)),   KEY `ar_rate_incremental_info_FI_1` (`ar_party_id`),   KEY `ar_rate_incremental_info_FI_2` (`ar_rate_id`),   CONSTRAINT `ar_rate_incremental_info_FK_1` FOREIGN KEY (`ar_party_id`) REFERENCES `ar_party` (`id`),   CONSTRAINT `ar_rate_incremental_info_FK_2` FOREIGN KEY (`ar_rate_id`) REFERENCES `ar_rate` (`id`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $r[$i++] = "ALTER TABLE ar_asterisk_account ADD `is_active` int(11) NOT NULL DEFAULT 1;";
    $r[$i++] = "ALTER TABLE ar_invoice ADD `ar_params_id` int(11) DEFAULT NULL;";
    $r[$i++] = "ALTER TABLE ar_params ADD `payment_days` int(20) DEFAULT NULL;";
    $r[$i++] = "ALTER TABLE ar_params ADD `reconnection_fee` VARCHAR(50) DEFAULT NULL;";
    $r[$i++] = "ALTER TABLE ar_params ADD `info_telephone_number` varchar(512) DEFAULT NULL;";
    $r[$i++] = "ALTER TABLE ar_params ADD `late_payment_fee` VARCHAR(50) DEFAULT NULL;";
    $r[$i++] = "ALTER TABLE ar_params ADD `etf_bbs` varchar(512) DEFAULT NULL;";
    $r[$i++] = "ALTER TABLE ar_params ADD `etf_acc_no` varchar(512) DEFAULT NULL;";
    $r[$i++] = "ALTER TABLE ar_params ADD `account_department` varchar(512) DEFAULT NULL;";
    $r[$i++] = "ALTER TABLE ar_params ADD `direct_debit_payment_email` varchar(512) DEFAULT NULL;";
    $r[$i++] = "ALTER TABLE ar_params ADD `direct_debit_payment_telephone_number` varchar(512) DEFAULT NULL;";
    $r[$i++] = "CREATE TABLE `ar_lock`(`id` INTEGER  NOT NULL AUTO_INCREMENT, `name` CHAR(255)  NOT NULL, `time` DATETIME, `info` VARCHAR(1024), PRIMARY KEY (`id`), KEY `ar_lock_name_index`(`name`) ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";
    $r[$i++] = "ALTER TABLE ar_params ADD `login_urn` VARCHAR(512) DEFAULT NULL;";
    $r[$i++] = "ALTER TABLE `ar_asterisk_account` ADD `ar_rate_category_id` INTEGER;";
    $r[$i++] = "ALTER TABLE `ar_office` ADD `ar_rate_category_id` INTEGER;";
    $r[$i++] = "ALTER TABLE `ar_party` ADD `is_reseller` INTEGER default 0 NOT NULL;";
    $r[$i++] = "ALTER TABLE `ar_party` ADD `reseller_code` VARCHAR(80);";

    $cdrCommandIndexes[$i] = TRUE;
    $r[$i++] = "ALTER TABLE `cdr` ADD `source_cost` INTEGER(20) default null, ADD `is_exported` INTEGER default 0 NOT NULL, ADD `source_data_type` VARCHAR(1024), ADD `source_data` VARCHAR(10000), CHANGE COLUMN `source_id` `source_id` VARCHAR(255) DEFAULT NULL, ADD KEY `cdr_is_exported_index`(`is_exported`), ADD INDEX account_and_calldate_index(ar_asterisk_account_id, calldate), DROP KEY `cdr_source_id_index`, ADD KEY `cdr_source_id_index`(`source_id`);";

    $cdrCommandIndexes[$i] = TRUE;
    $r[$i++] = "ALTER TABLE `cdr` DROP KEY `cdr_channel_index`;";

    $cdrCommandIndexes[$i] = TRUE;
    $r[$i++] = "ALTER TABLE `cdr` DROP KEY `cdr_income_ar_rate_id_index`;";

    $cdrCommandIndexes[$i] = TRUE;
    $r[$i++] = "ALTER TABLE `cdr` DROP KEY `cdr_income_index`;";

    $cdrCommandIndexes[$i] = TRUE;
    $r[$i++] = "ALTER TABLE `cdr` DROP KEY `cdr_cost_ar_rate_id_index`;";

    $cdrCommandIndexes[$i] = TRUE;
    $r[$i++] = "ALTER TABLE `cdr` DROP KEY `cdr_vendor_id_index`;";

    $cdrCommandIndexes[$i] = TRUE;
    $r[$i++] = "ALTER TABLE `cdr` DROP KEY `cdr_cost_index`;";

    $cdrCommandIndexes[$i] = TRUE;
    $r[$i++] = "ALTER TABLE `cdr` DROP KEY `cdr_cached_internal_telephone_number_index`;";

    $cdrCommandIndexes[$i] = TRUE;
    $r[$i++] = "ALTER TABLE `cdr` DROP KEY `cdr_cached_external_telephone_number_index`;";

    $cdrCommandIndexes[$i] = TRUE;
    $r[$i++] = "ALTER TABLE `cdr` DROP KEY `cdr_external_telephone_number_with_applied_portability_index`;";

    $cdrCommandIndexes[$i] = TRUE;
    $r[$i++] = "ALTER TABLE `cdr` DROP KEY `cdr_cached_masked_external_telephone_number_index`;";

    $cdrCommandIndexes[$i] = TRUE;
    $r[$i++] = "ALTER TABLE cdr MODIFY COLUMN clid VARCHAR(255) NOT NULL, MODIFY COLUMN src VARCHAR(255) NOT NULL, MODIFY COLUMN dst VARCHAR(255) NOT NULL, MODIFY COLUMN dcontext VARCHAR(255) NOT NULL, MODIFY COLUMN channel VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN dstchannel VARCHAR(255) NOT NULL, MODIFY COLUMN lastapp VARCHAR(255) NOT NULL, MODIFY COLUMN lastdata VARCHAR(255) NOT NULL, MODIFY COLUMN disposition VARCHAR(255) NOT NULL, MODIFY COLUMN accountcode VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN uniqueid VARCHAR(255) DEFAULT '' NOT NULL, MODIFY COLUMN cached_internal_telephone_number VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN cached_external_telephone_number VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN external_telephone_number_with_applied_portability VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN cached_masked_external_telephone_number VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN source_data_type VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN source_data VARCHAR(8000) NULL DEFAULT NULL;";

    $r[$i++] = "ALTER TABLE ar_number_portability MODIFY COLUMN telephone_number VARCHAR(255) NOT NULL, MODIFY COLUMN ported_telephone_number VARCHAR(255) NOT NULL;";
    $r[$i++] = "ALTER TABLE ar_asterisk_account MODIFY COLUMN name VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN account_code VARCHAR(255) NOT NULL;";
    $r[$i++] = "ALTER TABLE ar_office MODIFY COLUMN name VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN description VARCHAR(255) NULL DEFAULT NULL;";
    $r[$i++] = "ALTER TABLE ar_party MODIFY COLUMN external_crm_code VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN vat VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN legal_address VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN legal_city VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN legal_zipcode VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN legal_state_province VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN legal_country VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN email VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN phone VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN phone2 VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN fax VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN reseller_code VARCHAR(255) NULL DEFAULT NULL;";
    $r[$i++] = "ALTER TABLE ar_params MODIFY COLUMN name VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN service_name VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN service_provider_website VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN service_provider_email VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN logo_image VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN slogan VARCHAR(1024) NULL DEFAULT NULL, MODIFY COLUMN logo_image_in_invoices VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN user_message VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN external_crm_code VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN vat VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN legal_address VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN legal_website VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN legal_city VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN legal_zipcode VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN legal_state_province VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN legal_country VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN legal_email VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN legal_phone VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN phone2 VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN legal_fax VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN invoice_notes VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN sender_name_on_invoicing_emails VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN invoicing_email_address VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN accountant_email_address VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN smtp_username VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN smtp_password VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN smtp_encryption VARCHAR(255) NULL DEFAULT NULL;";
    $r[$i++] = "ALTER TABLE ar_rate_category MODIFY COLUMN name VARCHAR(255) NULL DEFAULT NULL;";
    $r[$i++] = "ALTER TABLE ar_telephone_prefix MODIFY COLUMN prefix VARCHAR(255) NOT NULL, MODIFY COLUMN name VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN geographic_location VARCHAR(255) NULL DEFAULT NULL, MODIFY COLUMN operator_type VARCHAR(255) NULL DEFAULT NULL;";
    $r[$i++] = "ALTER TABLE ar_problem MODIFY COLUMN duplication_key VARCHAR(255) NOT NULL;";
    $r[$i++] = "ALTER TABLE ar_lock MODIFY COLUMN info VARCHAR(255) NULL DEFAULT NULL;";

    $r[$i++] = "CREATE TABLE ar_database_version (id INTEGER AUTO_INCREMENT NOT NULL, version VARCHAR(255) NULL DEFAULT NULL, installation_date DATETIME NULL DEFAULT NULL, PRIMARY KEY (id)) ENGINE=InnoDB;";

    $cdrCommandIndexes[$i] = TRUE;
    $r[$i++] = "ALTER TABLE cdr MODIFY COLUMN `source_id` VARCHAR(1024), MODIFY COLUMN  `source_data` TEXT;";

    $r[$i++] = "ALTER TABLE ar_invoice ADD `displayed_online` INTEGER;";

    $secondRunIndex = $i;
    $r[$i++] = "UPDATE ar_invoice SET displayed_online = 1 WHERE already_sent = 1;";

    // recent installation, with already upgrade table, but with a bug in notification process

    $firstRun = isUpgradeFromVeryOldVersion();
    $secondRun = isUpgradeFromOldVersion();

    $supressWarnings = $firstRun || $secondRun;

    // Upgrade the database
    $time1 = time();

    $cdrModified = FALSE;

    $connection = Propel::getConnection();

    foreach ($r as $key => $cmd) {
        $cmd_alreadyApplied = FALSE;
        $cmd_apply = $applyCommands;
        $cmd_testForModifiedCDR = FALSE;

        if ($findNewCommands) {
            $found = FALSE;

            if ($secondRun && $key < $secondRunIndex) {
                // all commands before this are already applied
                $found = TRUE;
            } else {
                $c = new Criteria();
                $c->add(ArDatabaseVersionPeer::VERSION, $key);
                $upg = ArDatabaseVersionPeer::doSelectOne($c);
                $found = !is_null($upg);
            }

            if ($found) {
                $cmd_alreadyApplied = TRUE;
                $cmd_apply = FALSE;
            } else {
                $cmd_alreadyApplied = FALSE;
                $cmd_testForModifiedCDR = TRUE;
            }
        } else {
            // all commands are (at least virtually) applied so test it
            $cmd_testForModifiedCDR = TRUE;
        }

        if ($cmd_testForModifiedCDR) {
            if (array_key_exists($key, $cdrCommandIndexes)) {
                $cdrModified = TRUE;
            }
        }

        $cmd_store = $storeCommands;

        if ($cmd_apply) {
            echo "\n$key:\n$cmd";

            try {
                $stm = $connection->prepareStatement($cmd);
                $stm->executeUpdate();
                echo "\nSUCCESS\n";
            } catch (Exception $e) {
                $cmd_store = FALSE;
                if ($supressWarnings) {
                    echo "\nERROR: this is the first upgrade using the new method, and the initial commands can generate some errors because they were already applied to the database. In this case this is not a problem.";
                } else {
                    echo "\nERROR: if you execute upgrade again, this command will be retried again. ";
                }
                echo "\nThe error message is: " . $e->getMessage() . "\n";
            }
        }

        if ($cmd_store) {
            markUpgradeCommand($key);
        }
    }

    // Show stats
    $time2 = time();

    if ($applyCommands) {
        echo "\n\nUpgrading started at " . date("r", $time1) . " and completed at " . date("r", $time2) . "\nDuring this time the dabase was locked.\n";
    }

    return $cdrModified;
}

function markUpgradeCommand($key)
{
    $c = new Criteria();
    $c->add(ArDatabaseVersionPeer::VERSION, $key);
    $rs = ArDatabaseVersionPeer::doSelectOne($c);
    if (is_null($rs)) {
        $upg = new ArDatabaseVersion();
        $upg->setVersion($key);
        $upg->setInstallationDate(time());
        $upg->save();
    } else {
        // command already inserted
    }
}

/**
 * @return TRUE if it an upgrade from a previous version without the upgrade table
 */
function isUpgradeFromVeryOldVersion()
{

    $connection = Propel::getConnection();
    $query = 'SELECT id FROM ar_database_version LIMIT 1';

    $stm = $connection->createStatement();

    try {
        $rs = $stm->executeQuery($query);
        while ($rs->next()) {
            // there is the ar_database_version table and it contain some data,
            // so it is not the first upgrade.
            return FALSE;
        }

        // there is the table, but it does not contain data, so it is the first upgrade
        return TRUE;

    } catch (Exception $e) {

        // there is no ar_database_table
        return TRUE;
    }
}

/**
 * @return TRUE if there is the upgrade table, but it is empty.
 * This situation never occur in last version of upgrade procedure because all commands are signaled
 * as applied, but it occurs in case of older versions.
 */
function isUpgradeFromOldVersion()
{

    $connection = Propel::getConnection();
    $query = 'SELECT id FROM ar_database_version LIMIT 1';

    $stm = $connection->createStatement();

    try {
        $rs = $stm->executeQuery($query);
        while ($rs->next()) {
            // there is the ar_database_version table and it contain some data,
            // so it is not the first upgrade.
            return FALSE;
        }

        // there is the table, but it does not contain data, so it is the first upgrade
        return TRUE;

    } catch (Exception $e) {

        // there is no ar_database_table, so this is a very old version
        return FALSE;
    }
}

/**
 * @return TRUE if there is a safe connection to the database
 */
function isSafeReadConnection()
{
    $connection = Propel::getConnection();
    $query = 'SELECT id FROM cdr LIMIT 1';

    $stm = $connection->createStatement();

    try {
        $rs = $stm->executeQuery($query);

        while ($rs->next()) {
        }
        return TRUE;
    } catch (Exception $e) {
        return FALSE;
    }
}

/**
 * @return TRUE if the database user can alter the database
 */
function isSafeAlterConnection()
{
    $connection = Propel::getConnection();
    $stm = $connection->createStatement();

    $s1 = "CREATE TABLE IF NOT EXISTS ar_check_upgrade_script (id INTEGER(1)) ENGINE=InnoDB;";
    $s2 = "ALTER TABLE ar_check_upgrade_script MODIFY COLUMN id INTEGER(5);";
    $s3 = "ALTER TABLE ar_check_upgrade_script MODIFY COLUMN id INTEGER(4);";

    try {
        $stm = $connection->prepareStatement($s1);
        $stm->executeUpdate();

        $stm = $connection->prepareStatement($s2);
        $stm->executeUpdate();

        $stm = $connection->prepareStatement($s3);
        $stm->executeUpdate();
        return TRUE;
    } catch (Exception $e) {
        return FALSE;
    }
}

////////////////////////////////////
// APPLICATION MANAGEMENT SECTION //
////////////////////////////////////

/**
 * Exit if the user does not confirm.
 *
 * @return void
 */
function explicitConfirmForDeletion($isInteractive = TRUE)
{
    if ($isInteractive) {
        $fh = fopen('php://stdin', 'r');

        list($database, $user, $password) = getDatabaseNameUserAndPassword();

        echo "\nWARNING: all data in database '$database' will be deleted. Are you sure? [y/N]";

        $next_line = trim(fgets($fh, 1024));
        if ($next_line === "y" || $next_line === "Y") {
        } else {
            exit(1);
        }
    }
}

function myExecute($comment, $cmd)
{
    echo "\n$comment";
    echo "\nexecute> $cmd\n";
    system($cmd, $result);
}

function explicitContinue()
{
    $fh = fopen('php://stdin', 'r');

    echo "\nPress Enter to continue...";
    echo "\n";

    $next_line = trim(fgets($fh, 1024));
}

function makeInstall()
{

    $fh = fopen('php://stdin', 'r');

    list($database, $user, $password) = getDatabaseNameUserAndPassword();

    echo "\nEnter the name of MySQL administrator user, or another MySQL user that can create new databases: ";
    $rootUser = trim(fgets($fh, 1024));

    echo "\nEnter the MySQL password of the user $rootUser:  ";
    $rootPassword = trim(fgets($fh, 1024));

    myExecute("Drop $database database", "mysqladmin -u $rootUser --password=$rootPassword drop --force $database");
    myExecute("Create $database database", "mysqladmin -u $rootUser --password=$rootPassword create $database");
    myExecute("Init $database database", "mysql -u $rootUser --password=$rootPassword $database < data/sql/lib.model.schema.sql");
    explicitContinue();
    makeActivate();

    // this in the first installation of the database, so all upgrades are already applied, and mark them according
    // this simplify other pass of uprade.
    upgradeDatabase(FALSE, FALSE, TRUE, TRUE);

    makeActivate();

    $password = 'root';
    $paramsId = initWithDemoData(3000);
    addRootUser($password, $paramsId);

    echo "\nLoaded some demo data. user: $password - password: $password \n";
}

function makeDatabaseBackup($isInteractive = TRUE)
{

    list($database, $user, $password) = getDatabaseNameUserAndPassword();

    $fileName = 'backup-' . date('Y-m-d_H-i-s') . '.sql';
    $cmd = "mysqldump -u $user --password=$password $database --single-transaction > $fileName";

    $makeBackup = TRUE;
    if ($isInteractive) {
        echo "\nThe database can be backuped using the command\n   > $cmd";
        echo "\nCould I perform first a backup of the current database, without locking it? [Y/n]";
        $fh = fopen('php://stdin', 'r');
        $next_line = trim(fgets($fh, 1024));
        if ($next_line === "n" || $next_line === "N") {
            $makeBackup = FALSE;
        }
    }

    if ($makeBackup) {
        myExecute("Make backup", $cmd);
    }
    echo "\nDone";
}

/**
 * Manage in a complete way the application upgrade procedure.
 *
 * @return the suggestion about next commands
 */
function makeAppUpgrade()
{
    $fh = fopen('php://stdin', 'r');

    echo "\nLock the application access to users, so code can be upgraded safely.";
    MyUser::lockCronForMaintanance();
    MyUser::lockAppForMaintanance();

    $cmd = sfConfig::get('app_git_upgrade_command');
    echo "\nConfirm the execution of `$cmd` for upgrading the source code? [y/N]";
    $next_line = trim(fgets($fh, 1024));
    if ($next_line === "y" || $next_line === "Y") {
        $continue = TRUE;
    }

    if ($continue) {
        myExecute("Update source code", $cmd);
        return "\nResolve conflicts in source code. Then `git commit -a`. Then `php asterisell.php data upgrade`\n";
    } else {
        return "";
    }
}

/**
 * Manage in a complete way the data upgrade procedure.
 * 
 * @return void
 */
function makeDataUpgrade()
{
    $fh = fopen('php://stdin', 'r');

    // Advise if the CDR table is involved
    $continue = FALSE;
    if (isUpgradeFromVeryOldVersion() || upgradeDatabase(TRUE, FALSE, FALSE, FALSE)) {
        echo "\nWARNING: The CDR table must be upgraded!";
        echo "\n";
        echo "\nThis is a slow operation, and during upgrading the CDR table will be locked, and it can not be written.";
        echo "\nIn case of CDR table with 1 milion of records, this operation can require also 1-2 hours.";
        echo "\nIf CALLS are inserted dynamically in the table from the VoIP server, then during upgrading process ";
        echo "\nthey will be lost, and they must be retrieved from VoIP server log files.";
        echo "\n ";
        echo "\nThis command will display the starting and ending time, when the CDR table were locked.";
        echo "\n ";
        echo "\nContinue upgrading? [y/N]";
        $next_line = trim(fgets($fh, 1024));
        if ($next_line === "y" || $next_line === "Y") {
            $continue = TRUE;
        }
    } else {
        echo "\nThis upgrading does not involve the CDR table, so there is no dangerous locking, or interruption of service.";
        echo "\n ";
        echo "\nContinue upgrading? [y/N]";
        $next_line = trim(fgets($fh, 1024));
        if ($next_line === "y" || $next_line === "Y") {
            $continue = TRUE;
        }
    }

    if ($continue) {
        makeDatabaseBackup(TRUE);

        if (isUpgradeFromVeryOldVersion()) {
            // note: it does not store anything, because maybe there is no the safe upgrade table yet
            upgradeDatabase(FALSE, TRUE, FALSE);

            // then store all the commands, without applying them.
            upgradeDatabase(FALSE, FALSE, TRUE);
        } else {
            upgradeDatabase(TRUE, TRUE, TRUE);
        }

        makeActivate();
    }
}

function makeActivate()
{
    myExecute("Create default directories", "mkdir -p cache");
    myExecute("Create default directories", "mkdir -p log");
    myExecute("Create default directories", "mkdir -p web/generated_graphs");

    // Create VERSION file
    $fh = fopen("VERSION-TYPE", "r");
    $f1 = fgets($fh);
    fclose($fh);
    $fh = fopen("VERSION-NR", "r");
    $f2 = fgets($fh);
    fclose($fh);
    $fh = fopen("VERSION", "w");
    $version = "asterisell-$f1-$f2";
    fwrite($fh, $version);
    fclose($fh);

    // Assign the user group
    $user = sfConfig::get('app_web_server_user');
    $cmd = 'chown -R :' . $user . ' web/ apps/ ext_libs/';
    echo "\nFix files ownership with command `$cmd`, assuming you are running as super user? [y/N] ";
    $fh = fopen('php://stdin', 'r');
    $next_line = trim(fgets($fh, 1024));
    if ($next_line === "y" || $next_line === "Y") {
        myExecute("Fix ownerships", $cmd);
        explicitContinue();
    }

    myExecute("Clear symfony cache, in order to enable new settings.", "./symfony cc");
    myExecute("Fix Permissions", "./symfony fix-perms");
    myExecute("Fix Permissions", "chmod -R ug+rwx web/");
    myExecute("Fix Permissions", "chmod -R ug+rx ext_libs/");
    myExecute("Fix Permissions", "chmod -R ug+rx apps/");
    myExecute("Remove old lock files", "rm -f web/*.lock");

    myExecute("Regenerate modules depending from the new cache values.", "cd module_templates; php generate.php");
    myExecute("Clear symfony cache, in order to enable new settings.", "./symfony cc");

    echo "\n\nGenerated VERSION $version";
    echo "\n";
}

/**
 * @return list(database name, user, password)
 */
function getDatabaseNameUserAndPassword()
{
    $value = sfYaml::load(file_get_contents(SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'databases.yml'));
    $r = $value['all']['propel']['param'];

    return array($r['database'], $r['username'], $r['password']);
}

///////////////////////////////////////////////
// ADD INITIAL AND DEMO DATA TO THE DATABASE //
///////////////////////////////////////////////

/**
 * Execute the JobProcessorQueue.
 *
 * Delete also LOCK files.
 * This is needed because during installation these files
 * have rights different from the lock files created
 * from the web server during normal/production execution.
 */
function runJobProcessorQueue()
{
    $webDir = realpath(WEB_DIR);

    $culture = sfConfig::get('app_culture');
    $I18N = sfContext::getInstance()->getI18N();
    $I18N->setMessageSourceDir(SF_ROOT_DIR . DIRECTORY_SEPARATOR . SF_APP . DIRECTORY_SEPARATOR . 'i18n', $culture);
    $I18N->setCulture($culture);

    $processor = new JobQueueProcessor();
    $r = $processor->process($webDir);

    foreach (glob($webDir . DIRECTORY_SEPARATOR . '*.lock') as $filename) {
        unlink($filename);
    }
}

function myDelete($c, $t)
{
    $query = "DELETE FROM $t";
    $s = $c->executeUpdate($query);
}

function deleteAllData()
{
    echo "Deleting all data inside database.\n";

    // Delete all data from database, except upgrade table
    //
    $connection = Propel::getConnection();
    myDelete($connection, "ar_job_queue");
    myDelete($connection, "ar_invoice_creation");
    myDelete($connection, "ar_invoice");
    myDelete($connection, "ar_problem");
    myDelete($connection, "cdr");
    myDelete($connection, "ar_rate_incremental_info");
    myDelete($connection, "ar_rate");
    myDelete($connection, "ar_web_account");
    myDelete($connection, "ar_asterisk_account");
    myDelete($connection, "ar_office");
    myDelete($connection, "ar_party");
    myDelete($connection, "ar_telephone_prefix");
    myDelete($connection, "ar_rate_category");
    myDelete($connection, "ar_params");
}

/**
 * Create a date in the past.
 *
 * Note: seconds are setted according time()
 * so two invocation of the function using
 * the same number of $days do not return
 * the same result.
 */
function pastDays($days)
{
    $t = time() - ($days * 24 * 60 * 60);
    return $t;
}

function nextDays($days)
{
    return pastDays(0 - $days);
}

function createPrefix($pType, $pPlace, $pPrefix)
{
    $r = new ArTelephonePrefix();
    $r->setPrefix($pPrefix);
    $r->setName(null);
    $r->setGeographicLocation($pPlace);
    $r->setOperatorType($pType);
    $r->save();
}

function mergeCompletePrefix($prefix, $nation, $type, $operator)
{

    $c = new Criteria();
    $c->add(ArTelephonePrefixPeer::PREFIX, $prefix);
    $r = ArTelephonePrefixPeer::doSelectOne($c);

    $msg = "";
    if (is_null($r)) {
        $msg .= "Create new entry ";
        createCompletePrefix($prefix, $nation, $type, $operator);
    } else {
        $msg .= "Update entry ";
        $r->setPrefix($prefix);
        $r->setName($operator);
        $r->setGeographicLocation($nation);
        $r->setOperatorType($type);
        $r->save();
    }

    $msg .= "\"$prefix\", \"$nation\", \"$type\", \"$operator\"";
    echo $msg . "\n";
}

function createCompletePrefix($prefix, $nation, $type, $operator)
{
    $r = new ArTelephonePrefix();
    $r->setPrefix($prefix);
    $r->setName($operator);
    $r->setGeographicLocation($nation);
    $r->setOperatorType($type);
    $r->save();
}

function loadPrefixes($filename, $merge)
{
    $nrOfColInLine = 5;
    $handle = fopen($filename, 'r');
    if ($handle == false) {
        echo "Error opening file \"$filename\"";
        exit(2);
    }

    echo "\nImport Telephone Prefixes: ";

    $ln = 0;
    while (($data = fgetcsv($handle, 5000, ",")) !== false) {
        $ln++;
        if ($ln % 250 == 0) {
            echo "#";
        }
        $prefix = trim($data[0]);
        $nation = trim($data[1]);
        $type = trim($data[2]);
        $operator = trim($data[3]);

        if ($merge) {
            mergeCompletePrefix($prefix, $nation, $type, $operator);
        } else {
            createCompletePrefix($prefix, $nation, $type, $operator);
        }
    }
}

function addNewTelephonePrefixes()
{
    loadPrefixes("scripts/world_prefix_table.csv", TRUE);
}


/**
 * @return $defaultParamsId created
 */
function createDefaultParams()
{
    $params = new ArParams();
    $params->setIsDefault(TRUE);
    $params->setName("Default");
    $params->setServiceName("Asterisell");
    $params->setServiceProviderWebsite("http://voipinfo.example.com");
    $params->setLegalWebsite("http://www.example.com");
    $params->setServiceProviderEmail("info@example.com");
    $params->setLogoImage("asterisell.png");
    $params->setLogoImageInInvoices("asterisell.jpeg");
    $params->setSlogan("web application for rating, displaying, and billing VoIP calls.");
    $params->setFooter("<center>For info contact:<a href=\"mailto:info@example.com\">info@example.com</a></center>");
    $params->setUserMessage("");

    $params->setVatTaxPercAsPhpDecimal("20");

    $params->setLegalName("ACME Example VoIP Corporation");
    $params->setVat("WRLD12345678909876");
    $params->setLegalAddress("Street By Example");
    $params->setLegalCity("Soliera");
    $params->setLegalZipcode("41019");
    $params->setLegalStateProvince("Modena");
    $params->setLegalCountry("Italy");
    $params->setLegalEmail("acme@example.com");
    $params->setLegalPhone("+0 000-0000");

    $params->setSenderNameOnInvoicingEmails("ACME Corporation");
    $params->setInvoicingEmailAddress("sales@acme.example.com");
    $params->setSmtpHost("");
    $params->setSmtpPort("");
    $params->setSmtpUsername("");
    $params->setSmtpPassword("");
    $params->setSmtpEncryption("");
    $params->setSmtpReconnectAfterNrOfMessages("");
    $params->setSmtpSecondsOfPauseAfterReconnection(0);
    $params->save();

    return $params->getId();
}

/**
 * Return a list($defaultParamsId, $normalCategoryId, $discountedCategoryId, $defaultVendorId)
 */
function initWithDefaultData()
{
    try {
        deleteAllData();

        // Create dates starting from current time.
        // This allows to create more "user friendly"
        // demo-data.
        //
        $past = pastDays(365 * 2);

        // Create default params
        //
        echo "\nCreating default Params";
        $defaultParamsId = createDefaultParams();

        echo "\nCreating Categories and Parties";

        $r = new ArRateCategory();
        $r->setName("Normal");
        $r->save();
        $normalCategoryId = $r->getId();

        $r = new ArRateCategory();
        $r->setName("Discounted");
        $r->save();
        $discountedCategoryId = $r->getId();

        $r = new ArParty();
        $r->setCustomerOrVendor("V");
        $r->setName("Default Vendor");
        $r->setExternalCrmCode("");
        $r->setArRateCategoryId(null);
        $r->setArParamsId($defaultParamsId);
        $r->save();
        $defaultVendorId = $r->getId();

        echo "\nCreating Rates";

        // ANSWERED --> outgoing
        //
        $rm = new PhpCDRProcessing();
        $rm->dstChannel = "";
        $rm->disposition = "ANSWERED";
        $rm->amaflags = 0;
        $rm->destinationType = DestinationType::outgoing;

        $r = new ArRate();
        $r->setDestinationType(DestinationType::unprocessed);
        $r->setArRateCategoryId(null);
        $r->setArPartyId(null);
        $r->setStartTime($past);
        $r->setEndTime(null);
        $r->setIsException(false);
        $r->setPhpClassSerialization(serialize($rm));
        $r->save();

        $rm = new PhpCDRProcessing();
        $rm->dstChannel = "";
        $rm->disposition = "ANSWERED";
        $rm->amaflags = 3;
        $rm->destinationType = DestinationType::outgoing;

        $r = new ArRate();
        $r->setDestinationType(DestinationType::unprocessed);
        $r->setArRateCategoryId(null);
        $r->setArPartyId(null);
        $r->setStartTime($past);
        $r->setEndTime(null);
        $r->setIsException(false);
        $r->setPhpClassSerialization(serialize($rm));
        $r->save();

        // NO ANSWERED --> IGNORED
        //
        $rm = new PhpCDRProcessing();
        $rm->dstChannel = "";
        $rm->disposition = "NO ANSWERED";
        $rm->amaflags = 5;
        $rm->destinationType = DestinationType::ignored;

        $r = new ArRate();
        $r->setDestinationType(DestinationType::unprocessed);
        $r->setArRateCategoryId(null);
        $r->setArPartyId(null);
        $r->setStartTime($past);
        $r->setEndTime(null);
        $r->setIsException(false);
        $r->setPhpClassSerialization(serialize($rm));
        $r->save();

        // NO ANSWER --> IGNORED
        //
        $rm = new PhpCDRProcessing();
        $rm->dstChannel = "";
        $rm->disposition = "NO ANSWER";
        $rm->amaflags = 5;
        $rm->destinationType = DestinationType::ignored;

        $r = new ArRate();
        $r->setDestinationType(DestinationType::unprocessed);
        $r->setArRateCategoryId(null);
        $r->setArPartyId(null);
        $r->setStartTime($past);
        $r->setEndTime(null);
        $r->setIsException(false);
        $r->setPhpClassSerialization(serialize($rm));
        $r->save();

        // BUSY --> IGNORED
        //
        $rm = new PhpCDRProcessing();
        $rm->dstChannel = "";
        $rm->disposition = "BUSY";
        $rm->amaflags = 5;
        $rm->destinationType = DestinationType::ignored;

        $r = new ArRate();
        $r->setDestinationType(DestinationType::unprocessed);
        $r->setArRateCategoryId(null);
        $r->setArPartyId(null);
        $r->setStartTime($past);
        $r->setEndTime(null);
        $r->setIsException(false);
        $r->setPhpClassSerialization(serialize($rm));
        $r->save();

        // FAILED --> IGNORED
        //
        $rm = new PhpCDRProcessing();
        $rm->dstChannel = "";
        $rm->disposition = "BUSY";
        $rm->amaflags = 5;
        $rm->destinationType = DestinationType::ignored;

        $r = new ArRate();
        $r->setDestinationType(DestinationType::unprocessed);
        $r->setArRateCategoryId(null);
        $r->setArPartyId(null);
        $r->setStartTime($past);
        $r->setEndTime(null);
        $r->setIsException(false);
        $r->setPhpClassSerialization(serialize($rm));
        $r->save();

        // some test income for all outgoing and normal-category
        //
        $rm = new PhpRateByDuration();
        $rm->dstChannelPattern = "";
        $rm->rateByMinute = false;
        $rm->costForMinute = 1;
        $rm->costOnCall = 0;
        $rm->atLeastXSeconds = 0;
        $rm->whenRound_0_59 = 0;
        $rm->externalTelephonePrefix = "";
        $rm->internalTelephonePrefix = "";

        $r = new ArRate();
        $r->setDestinationType(DestinationType::outgoing);
        $r->setArRateCategoryId($normalCategoryId);
        $r->setArPartyId(null);
        $r->setStartTime($past);
        $r->setEndTime(null);
        $r->setIsException(false);
        $r->setPhpClassSerialization(serialize($rm));
        $r->save();

        // some income for all outgoing and discounted-category
        //
        $rm = new PhpRateByDuration();
        $rm->dstChannelPattern = "";
        $rm->rateByMinute = false;
        $rm->costForMinute = 0.8;
        $rm->costOnCall = 0;
        $rm->atLeastXSeconds = 0;
        $rm->whenRound_0_59 = 0;
        $rm->externalTelephonePrefix = "";
        $rm->internalTelephonePrefix = "";

        $r = new ArRate();
        $r->setDestinationType(DestinationType::outgoing);
        $r->setArRateCategoryId($discountedCategoryId);
        $r->setArPartyId(null);
        $r->setStartTime($past);
        $r->setEndTime(null);
        $r->setIsException(false);
        $r->setPhpClassSerialization(serialize($rm));
        $r->save();

        // some cost for all outgoing
        //
        $rm = new PhpRateByDuration();
        $rm->dstChannelPattern = "";
        $rm->rateByMinute = false;
        $rm->costForMinute = 0.5;
        $rm->costOnCall = 0;
        $rm->atLeastXSeconds = 0;
        $rm->whenRound_0_59 = 0;
        $rm->externalTelephonePrefix = "";
        $rm->internalTelephonePrefix = "";

        $r = new ArRate();
        $r->setDestinationType(DestinationType::outgoing);
        $r->setArRateCategoryId(null);
        $r->setArPartyId($defaultVendorId);
        $r->setStartTime($past);
        $r->setEndTime(null);
        $r->setIsException(false);
        $r->setPhpClassSerialization(serialize($rm));
        $r->save();

        // Add prefix table
        //
        loadPrefixes("scripts/world_prefix_table.csv", FALSE);

        return array($defaultParamsId, $normalCategoryId, $discountedCategoryId, $defaultVendorId);

    } catch (Exception $e) {
        echo "Caught exceptio: " . $e->getMessage() . "\n";
        echo $e->getTraceAsString();
    }
}

function addRootUser($password, $defaultParamsId)
{
    $w = new ArWebAccount();
    $w->setLogin("root");
    $w->setPassword($password);
    $w->setArPartyId(null);
    $w->setArOfficeId(null);
    $w->setActivateAt(date("c"));
    $w->setDeactivateAt(null);
    $w->setArParamsId($defaultParamsId);
    $w->save();

    echo "\nCreated root user with name \"root\" and password \"$password\".\n";
}


/**
 * Insert regression data
 */
function initWithRegressionData()
{
    deleteAllData();

    $defaultParamsId = createDefaultParams();

    createPrefix("Fixed line", "Italy", "39");
    createPrefix("Mobile line", "Italy", "393");
    createPrefix("Fixed line", "Albania", "355");
    createPrefix("Mobile line", "Albania", "35567");
    createPrefix("Mobile line", "Albania", "35568");
    createPrefix("Mobile line", "Albania", "35569");

    createPrefix("Fixed line", "American Samoa", "1684");
    createPrefix("Fixed line", "American Samoa", "684");
    createPrefix("Mobile line", "American Samoa", "1684252");
    createPrefix("Mobile line", "American Samoa", "1684254");
    createPrefix("Mobile line", "American Samoa", "1684258");
    createPrefix("Fixed line", "Andorra", "376");
    createPrefix("Mobile line", "Andorra", "3763");
    createPrefix("Mobile line", "Andorra", "3764");
    createPrefix("Mobile line", "Andorra", "3766");

    // Create dates starting from current time.
    // This allows to create more "user friendly"
    // demo-data.
    //
    $days60 = pastDays(60);
    $days55 = pastDays(55);
    $days50 = pastDays(50);
    $days45 = pastDays(45);
    $days40 = pastDays(40);
    $days35 = pastDays(35);
    $days30 = pastDays(30);
    $days25 = pastDays(25);
    $days20 = pastDays(20);
    $days15 = pastDays(15);
    $days12 = pastDays(12);
    $days11 = pastDays(11);
    $days10 = pastDays(10);
    $days9 = pastDays(9);
    $days5 = pastDays(5);
    $days2 = pastDays(2);
    $days1 = pastDays(1);
    $days0 = pastDays(0);

    // Special numbers
    //
    $tnItalyFixed1 = "391111111";
    $tnItalyFixed2 = "392222222";
    $tnItalyMobile1 = "39333333";
    $tnItalyMobile2 = "39344444";
    $tnItalyMobile2Special = "39344445";
    $tnAlbaniaFixed1 = "35563333";
    $tnAlbaniaMobile1 = "3556888";

    $prefixItaly = "39";
    $prefixItalyMobie = "393";

    $r = new ArRateCategory();
    $r->setName("Normal");
    $r->save();
    $normalCategoryId = $r->getId();

    $r = new ArRateCategory();
    $r->setName("Discounted");
    $r->save();
    $discountedCategoryId = $r->getId();

    $r = new ArParty();
    $r->setCustomerOrVendor("C");
    $r->setName("Acme");
    $r->setExternalCrmCode("-");
    $r->setArRateCategoryId($normalCategoryId);
    $r->setArParamsId($defaultParamsId);
    $r->save();
    $acmePartyId = $r->getId();

    $r = new ArParty();
    $r->setCustomerOrVendor("C");
    $r->setName("Disco");
    $r->setExternalCrmCode("-");
    $r->setArRateCategoryId($discountedCategoryId);
    $r->setArParamsId($defaultParamsId);
    $r->save();
    $discountedPartyId = $r->getId();

    $r = new ArParty();
    $r->setCustomerOrVendor("V");
    $r->setName("Acme VOIP Provider");
    $r->setExternalCrmCode("-");
    $r->setArRateCategoryId(null);
    $r->setArParamsId($defaultParamsId);
    $r->save();
    $safeVoipProviderId = $r->getId();

    $r = new ArParty();
    $r->setCustomerOrVendor("V");
    $r->setName("Cheap VOIP Provider");
    $r->setExternalCrmCode("-");
    $r->setArRateCategoryId(null);
    $r->setArParamsId($defaultParamsId);
    $r->save();
    $cheapVoipProviderId = $r->getId();

    $r = new ArOffice();
    $r->setArPartyId($acmePartyId);
    $r->setName("Headquarter");
    $r->setDescription("Headquarter");
    $r->save();
    $acmeOfficeId1 = $r->getId();

    $r = new ArOffice();
    $r->setArPartyId($acmePartyId);
    $r->setName("Support");
    $r->setDescription("Support Office");
    $r->save();
    $acmeOfficeId2 = $r->getId();

    $r = new ArOffice();
    $r->setArPartyId($discountedPartyId);
    $r->setName("Main");
    $r->setDescription("Main Building");
    $r->save();
    $discountedOfficeId = $r->getId();

    $r = new ArAsteriskAccount();
    $accountCode1 = "a01";
    $r->setName("Acme 01");
    $r->setAccountcode($accountCode1);
    $r->setArOfficeId($acmeOfficeId1);
    $r->save();
    $acme01Id = $r->getId();

    $r = new ArAsteriskAccount();
    $accountCode1 = "a02";
    $r->setName("Acme 02");
    $r->setAccountcode($accountCode1);
    $r->setArOfficeId($acmeOfficeId2);
    $r->save();
    $acme02Id = $r->getId();

    $r = new ArAsteriskAccount();
    $accountCode1 = "a03";
    $r->setName("Acme 03");
    $r->setAccountcode($accountCode1);
    $r->setArOfficeId($acmeOfficeId1);
    $r->save();

    $r = new ArAsteriskAccount();
    $discountCode1 = "d01";
    $r->setName("Disco 01");
    $r->setAccountcode($discountCode1);
    $r->setArOfficeId($discountedOfficeId);
    $r->save();
    $discountedParty01Id = $r->getId();

    $r = new ArWebAccount();
    $r->setLogin("acme");
    $r->setPassword("acme");
    $r->setArPartyId($acmePartyId);
    $r->setArOfficeId(null);
    $r->setActivateAt($days15);
    $r->setDeactivateAt(null);
    $r->save();

    $r = new ArWebAccount();
    $r->setLogin("acme01");
    $r->setPassword("acme01");
    $r->setArPartyId($acmePartyId);
    $r->setArOfficeId($acmeOfficeId1);
    $r->setActivateAt($days15);
    $r->setDeactivateAt(null);
    $r->save();

    $r = new ArWebAccount();
    $r->setLogin("acme02");
    $r->setPassword("acme02");
    $r->setArPartyId($acmePartyId);
    $r->setArOfficeId($acmeOfficeId2);
    $r->setActivateAt($days15);
    $r->setDeactivateAt($days2);
    $r->save();

    // Process CDRs
    //
    $rm = new PhpCDRProcessing();
    $rm->dstChannel = "";
    $rm->disposition = "ANSWERED";
    $rm->amaflags = 0;
    $rm->destinationType = DestinationType::outgoing;

    $r = new ArRate();
    $r->setDestinationType(DestinationType::unprocessed);
    $r->setArRateCategoryId(null);
    $r->setArPartyId(null);
    $r->setStartTime($days60);
    $r->setEndTime(null);
    $r->setIsException(false);
    $r->setPhpClassSerialization(serialize($rm));
    $r->save();

    $rm = new PhpCDRProcessing();
    $rm->dstChannel = "";
    $rm->disposition = "ANSWERED";
    $rm->amaflags = 5;
    $rm->destinationType = DestinationType::ignored;

    $r = new ArRate();
    $r->setDestinationType(DestinationType::unprocessed);
    $r->setArRateCategoryId(null);
    $r->setArPartyId(null);
    $r->setStartTime($days60);
    $r->setEndTime(null);
    $r->setIsException(false);
    $r->setPhpClassSerialization(serialize($rm));
    $r->save();

    $rm = new PhpCDRProcessing();
    $rm->dstChannel = "";
    $rm->disposition = "NO ANSWERED";
    $rm->amaflags = 0;
    $rm->destinationType = DestinationType::ignored;

    $r = new ArRate();
    $r->setDestinationType(DestinationType::unprocessed);
    $r->setArRateCategoryId(null);
    $r->setArPartyId(null);
    $r->setStartTime($days60);
    $r->setEndTime(null);
    $r->setIsException(false);
    $r->setPhpClassSerialization(serialize($rm));
    $r->save();

    // Customer rate (income)
    //
    $rm = new PhpRateByDuration();
    $rm->dstChannelPattern = "good";
    $rm->rateByMinute = false;
    $rm->costForMinute = 10;
    $rm->costOnCall = 5;
    $rm->atLeastXSeconds = 5;
    $rm->whenRound_0_59 = 0;
    $rm->externalTelephonePrefix = "";
    $rm->internalTelephonePrefix = "";

    $r = new ArRate();
    $r->setDestinationType(DestinationType::outgoing);
    $r->setArRateCategoryId($normalCategoryId);
    $r->setArPartyId(null);
    $r->setStartTime($days10);
    $r->setEndTime($days5);
    $r->setIsException(false);
    $r->setPhpClassSerialization(serialize($rm));
    $r->save();

    // test a rate with a more specific destination
    // number.
    //
    $rm = new PhpRateByDuration();
    $rm->dstChannelPattern = "good";
    $rm->rateByMinute = false;
    $rm->costForMinute = 20;
    $rm->costOnCall = 5;
    $rm->atLeastXSeconds = 5;
    $rm->whenRound_0_59 = 0;
    $rm->externalTelephonePrefix = $tnItalyMobile2Special;
    $rm->internalTelephonePrefix = "";

    $r = new ArRate();
    $r->setDestinationType(DestinationType::outgoing);
    $r->setArRateCategoryId($normalCategoryId);
    $r->setArPartyId(null);
    $r->setStartTime($days10);
    $r->setEndTime($days5);
    $r->setIsException(false);
    $r->setPhpClassSerialization(serialize($rm));
    $r->save();

    // test a rate that is an exception
    //
    $rm = new PhpRateByDuration();
    $rm->dstChannelPattern = "good-exception"; // <- exception point in order to no apply to all other CDRs
    $rm->rateByMinute = false;
    $rm->costForMinute = 50;
    $rm->costOnCall = 50;
    $rm->atLeastXSeconds = 5;
    $rm->whenRound_0_59 = 0;
    $rm->externalTelephonePrefix = $tnItalyMobile2Special; // <- conflict with previous rate
    $rm->internalTelephonePrefix = "";

    $r = new ArRate();
    $r->setDestinationType(DestinationType::outgoing);
    $r->setArRateCategoryId($normalCategoryId);
    $r->setArPartyId(null);
    $r->setStartTime($days10);
    $r->setEndTime($days5);
    $r->setIsException(true); // <- it is an exception, otherwise there is a conflict
    $r->setPhpClassSerialization(serialize($rm));
    $r->save();

    // complex calculation of rates by minute
    //
    $rm = new PhpRateByDuration();
    $rm->dstChannelPattern = "good";
    $rm->rateByMinute = true;
    $rm->costForMinute = 25;
    $rm->costOnCall = 15;
    $rm->atLeastXSeconds = 30;
    $rm->whenRound_0_59 = 5;
    $rm->externalTelephonePrefix = $prefixItaly;
    $rm->internalTelephonePrefix = "";

    $r = new ArRate();
    $r->setDestinationType(DestinationType::outgoing);
    $r->setArRateCategoryId($normalCategoryId);
    $r->setArPartyId(null);
    $r->setStartTime($days5);
    $r->setEndTime(null);
    $r->setIsException(false);
    $r->setPhpClassSerialization(serialize($rm));
    $r->save();

    // rates on "discount" category of costumer
    //
    $rm = new PhpRateByDuration();
    $rm->dstChannelPattern = "good";
    $rm->rateByMinute = true;
    $rm->costForMinute = 3;
    $rm->costOnCall = 0;
    $rm->atLeastXSeconds = 30;
    $rm->whenRound_0_59 = 5;
    $rm->externalTelephonePrefix = $prefixItaly;
    $rm->internalTelephonePrefix = "";

    $r = new ArRate();
    $r->setDestinationType(DestinationType::outgoing);
    $r->setArRateCategoryId($discountedCategoryId);
    $r->setArPartyId(null);
    $r->setStartTime($days5);
    $r->setEndTime(null);
    $r->setIsException(false);
    $r->setPhpClassSerialization(serialize($rm));
    $r->save();

    // Vendor rate (cost)
    // These rates do not change.
    //
    $rm = new PhpRateByDuration();
    $rm->dstChannelPattern = "good";
    $rm->rateByMinute = false;
    $rm->costForMinute = 5;
    $rm->costOnCall = 0;
    $rm->atLeastXSeconds = 5;
    $rm->whenRound_0_59 = 0;
    $rm->externalTelephonePrefix = "";
    $rm->internalTelephonePrefix = "";

    $r = new ArRate();
    $r->setDestinationType(DestinationType::outgoing);
    $r->setArRateCategoryId(null);
    $r->setArPartyId($safeVoipProviderId);
    $r->setStartTime($days10);
    $r->setEndTime($days5);
    $r->setIsException(false);
    $r->setPhpClassSerialization(serialize($rm));
    $r->save();

    $rm = new PhpRateByDuration();
    $rm->dstChannelPattern = "good";
    $rm->rateByMinute = false;
    $rm->costForMinute = 4;
    $rm->costOnCall = 0;
    $rm->atLeastXSeconds = 0;
    $rm->whenRound_0_59 = 0;
    $rm->externalTelephonePrefix = "";
    $rm->internalTelephonePrefix = "";

    $r = new ArRate();
    $r->setDestinationType(DestinationType::outgoing);
    $r->setArRateCategoryId(null);
    $r->setArPartyId($safeVoipProviderId);
    $r->setStartTime($days5);
    $r->setEndTime(null);
    $r->setIsException(false);
    $r->setPhpClassSerialization(serialize($rm));
    $r->save();


    //////////////
    // Add CDRs //
    //////////////

    // "good" channel and from $days5 and $days10
    // there are safe rates
    $cdr = new Cdr();
    $cdr->setAccountcode("a01");
    $cdr->setCalldate($days9);
    $cdr->setChannel("good");
    $cdr->setClid("-");
    $cdr->setSrc($tnItalyFixed2);
    $cdr->setDst($tnItalyFixed1);
    $cdr->setDcontext("-");
    $cdr->setDstchannel("good");
    $cdr->setLastapp("-");
    $cdr->setLastdata("-");
    $cdr->setDuration(200);
    $cdr->setBillsec(60);
    $cdr->setDisposition("ANSWERED");
    $cdr->setAmaflags(0);
    $cdr->setUserfield("100000");
    $cdr->save();

    $cdr = new Cdr();
    $cdr->setAccountcode("a01");
    $cdr->setCalldate($days9);
    $cdr->setChannel("-");
    $cdr->setClid("-");
    $cdr->setSrc($tnItalyFixed2);
    $cdr->setDst($tnItalyFixed2);
    $cdr->setDcontext("-");
    $cdr->setDstchannel("good");
    $cdr->setLastapp("-");
    $cdr->setLastdata("-");
    $cdr->setDuration(200);
    $cdr->setBillsec(60);
    $cdr->setDisposition("ANSWERED");
    $cdr->setAmaflags(0);
    $cdr->setUserfield(0);
    $cdr->setUserfield("100000"); // earns = income - cost
    $cdr->save();

    $cdr = new Cdr();
    $cdr->setAccountcode("a01");
    $cdr->setCalldate($days9);
    $cdr->setChannel("-");
    $cdr->setClid("-");
    $cdr->setSrc($tnItalyFixed2);
    $cdr->setDst($tnItalyMobile1);
    $cdr->setDcontext("-");
    $cdr->setDstchannel("good");
    $cdr->setLastapp("-");
    $cdr->setLastdata("-");
    $cdr->setDuration(200);
    $cdr->setBillsec(60);
    $cdr->setDisposition("ANSWERED");
    $cdr->setAmaflags(0);
    $cdr->setUserfield("100000");
    $cdr->save();

    $cdr = new Cdr();
    $cdr->setAccountcode("a01");
    $cdr->setCalldate($days9);
    $cdr->setChannel("-");
    $cdr->setClid("-");
    $cdr->setSrc($tnItalyFixed2);
    $cdr->setDst($tnItalyFixed2);
    $cdr->setDcontext("-");
    $cdr->setDstchannel("good");
    $cdr->setLastapp("-");
    $cdr->setLastdata("-");
    $cdr->setDuration(200);
    $cdr->setBillsec(80);
    $cdr->setDisposition("ANSWERED");
    $cdr->setAmaflags(0);
    $cdr->setUserfield("116666");
    $cdr->save();

    // test more specific prefix rate
    //
    $cdr = new Cdr();
    $cdr->setAccountcode("a01");
    $cdr->setCalldate($days9);
    $cdr->setChannel("-");
    $cdr->setClid("-");
    $cdr->setSrc($tnItalyFixed2);
    $cdr->setDst($tnItalyMobile2Special);
    $cdr->setDcontext("-");
    $cdr->setDstchannel("good");
    $cdr->setLastapp("-");
    $cdr->setLastdata("-");
    $cdr->setDuration(200);
    $cdr->setBillsec(78);
    $cdr->setDisposition("ANSWERED");
    $cdr->setAmaflags(0);
    $cdr->setUserfield("245000");
    $cdr->save();

    // test exception rate
    // and dstChannel matching
    //
    $cdr = new Cdr();
    $cdr->setAccountcode("a01");
    $cdr->setCalldate($days9);
    $cdr->setChannel("-");
    $cdr->setClid("-");
    $cdr->setSrc($tnItalyFixed2);
    $cdr->setDst($tnItalyMobile2Special);
    $cdr->setDcontext("-");
    $cdr->setDstchannel("good-exception"); // <- exception channel
    $cdr->setLastapp("-");
    $cdr->setLastdata("-");
    $cdr->setDuration(200);
    $cdr->setBillsec(90);
    $cdr->setDisposition("ANSWERED");
    $cdr->setAmaflags(0);
    $cdr->setUserfield("1175000");
    $cdr->save();

    // test if DISPOSITION is checked
    //
    $cdr = new Cdr();
    $cdr->setAccountcode("a01");
    $cdr->setCalldate($days9);
    $cdr->setChannel("-");
    $cdr->setClid("-");
    $cdr->setSrc($tnItalyFixed2);
    $cdr->setDst($tnItalyMobile2Special);
    $cdr->setDcontext("-");
    $cdr->setDstchannel("good");
    $cdr->setLastapp("-");
    $cdr->setLastdata("-");
    $cdr->setDuration(200);
    $cdr->setBillsec(90);
    $cdr->setDisposition("NO ANSWERED"); // <- no billable disposition
    $cdr->setAmaflags(0);
    $cdr->setUserfield(null);
    $cdr->save();

    // test if AMAFLAGS is checked
    //
    $cdr = new Cdr();
    $cdr->setAccountcode("a01");
    $cdr->setCalldate($days9);
    $cdr->setChannel("-");
    $cdr->setClid("-");
    $cdr->setSrc($tnItalyFixed2);
    $cdr->setDst($tnItalyMobile2Special);
    $cdr->setDcontext("-");
    $cdr->setDstchannel("good");
    $cdr->setLastapp("-");
    $cdr->setLastdata("-");
    $cdr->setDuration(200);
    $cdr->setBillsec(90);
    $cdr->setDisposition("ANSWERED");
    $cdr->setAmaflags(5); // <- no billable amaflags
    $cdr->setUserfield(null);
    $cdr->save();

    // test complex calculations
    // and limit start/end of rate application
    //
    $cdr = new Cdr();
    $cdr->setAccountcode("a01");
    $cdr->setCalldate($days5); // <- where one rate end and another start
    $cdr->setChannel("-");
    $cdr->setClid("-");
    $cdr->setSrc($tnItalyFixed2);
    $cdr->setDst($tnItalyFixed1);
    $cdr->setDcontext("-");
    $cdr->setDstchannel("good");
    $cdr->setLastapp("-");
    $cdr->setLastdata("-");
    $cdr->setDuration(200);
    $cdr->setBillsec(90);
    $cdr->setDisposition("ANSWERED");
    $cdr->setAmaflags(0);
    $cdr->setUserfield("590000");
    $cdr->save();

    $cdr = new Cdr();
    $cdr->setAccountcode("a01");
    $cdr->setCalldate($days5); // <- where one rate end and another start
    $cdr->setChannel("-");
    $cdr->setClid("-");
    $cdr->setSrc($tnItalyFixed2);
    $cdr->setDst($tnItalyFixed1);
    $cdr->setDcontext("-");
    $cdr->setDstchannel("good");
    $cdr->setLastapp("-");
    $cdr->setLastdata("-");
    $cdr->setDuration(200);
    $cdr->setBillsec(123);
    $cdr->setDisposition("ANSWERED");
    $cdr->setAmaflags(0);
    $cdr->setUserfield("568000");
    $cdr->save();

    $cdr = new Cdr();
    $cdr->setAccountcode("a01");
    $cdr->setCalldate($days1); // <- where one rate end and another start
    $cdr->setChannel("-");
    $cdr->setClid("-");
    $cdr->setSrc($tnItalyFixed2);
    $cdr->setDst($tnItalyFixed1);
    $cdr->setDcontext("-");
    $cdr->setDstchannel("good");
    $cdr->setLastapp("-");
    $cdr->setLastdata("-");
    $cdr->setDuration(200);
    $cdr->setBillsec(124);
    $cdr->setDisposition("ANSWERED");
    $cdr->setAmaflags(0);
    $cdr->setUserfield("567333");
    $cdr->save();

    $cdr = new Cdr();
    $cdr->setAccountcode("a01");
    $cdr->setCalldate($days5); // <- where one rate end and another start
    $cdr->setChannel("-");
    $cdr->setClid("-");
    $cdr->setSrc($tnItalyFixed2);
    $cdr->setDst($tnItalyFixed1);
    $cdr->setDcontext("-");
    $cdr->setDstchannel("good");
    $cdr->setLastapp("-");
    $cdr->setLastdata("-");
    $cdr->setDuration(200);
    $cdr->setBillsec(125);
    $cdr->setDisposition("ANSWERED");
    $cdr->setAmaflags(0);
    $cdr->setUserfield("816667");
    $cdr->save();

    $cdr = new Cdr();
    $cdr->setAccountcode("a01");
    $cdr->setCalldate($days1);
    $cdr->setChannel("-");
    $cdr->setClid("-");
    $cdr->setSrc($tnItalyFixed2);
    $cdr->setDst($tnItalyFixed1);
    $cdr->setDcontext("-");
    $cdr->setDstchannel("good");
    $cdr->setLastapp("-");
    $cdr->setLastdata("-");
    $cdr->setDuration(200);
    $cdr->setBillsec(5);
    $cdr->setDisposition("ANSWERED");
    $cdr->setAmaflags(0);
    $cdr->setUserfield("396667");
    $cdr->save();

    // test the filter on discounted costumer category
    //
    $cdr = new Cdr();
    $cdr->setAccountcode($discountCode1);
    $cdr->setCalldate($days0);
    $cdr->setChannel("-");
    $cdr->setClid("-");
    $cdr->setSrc($tnItalyFixed2);
    $cdr->setDst($tnItalyFixed1);
    $cdr->setDcontext("-");
    $cdr->setDstchannel("good");
    $cdr->setLastapp("-");
    $cdr->setLastdata("-");
    $cdr->setDuration(200);
    $cdr->setBillsec(15);
    $cdr->setDisposition("ANSWERED");
    $cdr->setAmaflags(0);
    $cdr->setUserfield("20000");
    $cdr->save();

    $cdr = new Cdr();
    $cdr->setAccountcode($discountCode1);
    $cdr->setCalldate($days0);
    $cdr->setChannel("-");
    $cdr->setClid("-");
    $cdr->setSrc($tnItalyFixed2);
    $cdr->setDst($tnItalyMobile1);
    $cdr->setDcontext("-");
    $cdr->setDstchannel("good");
    $cdr->setLastapp("-");
    $cdr->setLastdata("-");
    $cdr->setDuration(200);
    $cdr->setBillsec(657);
    $cdr->setDisposition("ANSWERED");
    $cdr->setAmaflags(0);
    $cdr->setUserfield("-108000"); // <- negative value
    $cdr->save();

    $cdr = new Cdr();
    $cdr->setAccountcode($accountCode1);
    $cdr->setCalldate($days0);
    $cdr->setChannel("-");
    $cdr->setClid("-");
    $cdr->setSrc($tnItalyFixed2);
    $cdr->setDst($tnItalyMobile1);
    $cdr->setDcontext("-");
    $cdr->setDstchannel("good");
    $cdr->setLastapp("-");
    $cdr->setLastdata("-");
    $cdr->setDuration(200);
    $cdr->setBillsec(657);
    $cdr->setDisposition("ANSWERED");
    $cdr->setAmaflags(0);
    $cdr->setUserfield("2462000"); // <- negative value
    $cdr->save();

    $cdr = new Cdr();
    $cdr->setAccountcode($accountCode1);
    $cdr->setCalldate($days0);
    $cdr->setChannel("-");
    $cdr->setClid("-");
    $cdr->setSrc($tnItalyFixed2);
    $cdr->setDst($tnItalyMobile1);
    $cdr->setDcontext("-");
    $cdr->setDstchannel("good");
    $cdr->setLastapp("-");
    $cdr->setLastdata("-");
    $cdr->setDuration(200);
    $cdr->setBillsec(956);
    $cdr->setDisposition("ANSWERED");
    $cdr->setAmaflags(0);
    $cdr->setUserfield("3512667"); // <- negative value
    $cdr->save();

    $cdr = new Cdr();
    $cdr->setAccountcode($accountCode1);
    $cdr->setCalldate($days1);
    $cdr->setChannel("-");
    $cdr->setClid("-");
    $cdr->setSrc($tnItalyFixed1);
    $cdr->setDst($tnItalyMobile2);
    $cdr->setDcontext("-");
    $cdr->setDstchannel("good");
    $cdr->setLastapp("-");
    $cdr->setLastdata("-");
    $cdr->setDuration(200);
    $cdr->setBillsec(45);
    $cdr->setDisposition("ANSWERED");
    $cdr->setAmaflags(0);
    $cdr->setUserfield("370000"); // <- negative value
    $cdr->save();

    return $defaultParamsId;
}

/**
 * Check if added CDRs respect regression tests.
 */
function checkRegressionData()
{

    // Rate all calls
    //
    $rateCalls = new RateCalls();
    $rateCalls->process();

    $c = new Criteria();
    $cdrs = CdrPeer::doSelect($c);

    $tot = 0;
    $bad = 0;

    foreach ($cdrs as $cdr) {
        $tot++;
        $id = $cdr->getId();
        $income = $cdr->getIncome();
        $cost = $cdr->getCost();
        $calcEarn = $cdr->getUserfield();

        if (!is_null($income)) {
            $earn = $income - $cost;

            if ($earn != $calcEarn) {
                echo "\nCDR with id $id has earned $earn different from expected $calcEarn";
                $bad++;
            }
        } else {
            if (!is_null($calcEarn)) {
                echo "\nCDR with id $id has rate error different from expected $calcEarn";
                $bad++;
            }
        }
    }

    echo "\nChecked $tot cdrs and there are $bad errors\n";
}

/**
 * Reset the DB and add demo data useful for starting Asterisell with Demo Data.
 *
 * @return the default paramsId
 */
function initWithDemoData($recordsToAdd)
{
    try {
        deleteAllData();

        // Create dates starting from current time.
        // This allows to create more "user friendly"
        // demo-data.
        //
        $past = pastDays(365 * 2);

        // Create default params
        //
        echo "\nCreating default Params";
        $defaultParamsId = createDefaultParams();

        echo "\nCreating Categories and Parties";

        $r = new ArRateCategory();
        $r->setName("Normal");
        $r->save();
        $normalCategoryId = $r->getId();

        $r = new ArRateCategory();
        $r->setName("Discounted");
        $r->save();
        $discountedCategoryId = $r->getId();

        $r = new ArParty();
        $r->setCustomerOrVendor("V");
        $r->setName("VoIP Provider");
        $r->setArRateCategoryId(null);
        $r->setArParamsId($defaultParamsId);
        $r->setVat("WRLD1111115555");
        $r->setLegalAddress("Street Edison, 2");
        $r->setLegalCity("Someplace");
        $r->setLegalZipcode("41055");
        $r->setLegalStateProvince("Texas");
        $r->setLegalCountry("USA");
        $r->setEmail("alpha@example.com");
        $r->save();
        $defaultVendorId = $r->getId();

        echo "\nCreating Rates";

        //////////////////
        // System rates //
        //////////////////
        //
        // disposition ANSWERED
        //             NO ANSWERED
        //
        // dstChannel incoming    => incoming
        //            outgoing    => outgoing
        //            internal    => internal
        //
        // amaflags   always 0

        $rm = new PhpCDRProcessing();
        $rm->dstChannel = "outgoing";
        $rm->disposition = "ANSWERED";
        $rm->amaflags = 0;
        $rm->destinationType = DestinationType::outgoing;
        $r = new ArRate();
        $r->setDestinationType(DestinationType::unprocessed);
        $r->setArRateCategoryId(null);
        $r->setArPartyId(null);
        $r->setStartTime($past);
        $r->setEndTime(null);
        $r->setIsException(false);
        $r->setPhpClassSerialization(serialize($rm));
        $r->save();

        $rm = new PhpCDRProcessing();
        $rm->dstChannel = "incoming";
        $rm->disposition = "ANSWERED";
        $rm->amaflags = 0;
        $rm->destinationType = DestinationType::incoming;
        $r = new ArRate();
        $r->setDestinationType(DestinationType::unprocessed);
        $r->setArRateCategoryId(null);
        $r->setArPartyId(null);
        $r->setStartTime($past);
        $r->setEndTime(null);
        $r->setIsException(false);
        $r->setPhpClassSerialization(serialize($rm));
        $r->save();

        $rm = new PhpCDRProcessing();
        $rm->dstChannel = "internal";
        $rm->disposition = "ANSWERED";
        $rm->amaflags = 0;
        $rm->destinationType = DestinationType::internal;
        $r = new ArRate();
        $r->setDestinationType(DestinationType::unprocessed);
        $r->setArRateCategoryId(null);
        $r->setArPartyId(null);
        $r->setStartTime($past);
        $r->setEndTime(null);
        $r->setIsException(false);
        $r->setPhpClassSerialization(serialize($rm));
        $r->save();

        $rm = new PhpCDRProcessing();
        $rm->dstChannel = "";
        $rm->disposition = "NO ANSWERED";
        $rm->amaflags = 0;
        $rm->destinationType = DestinationType::ignored;
        $r = new ArRate();
        $r->setDestinationType(DestinationType::unprocessed);
        $r->setArRateCategoryId(null);
        $r->setArPartyId(null);
        $r->setStartTime($past);
        $r->setEndTime(null);
        $r->setIsException(false);
        $r->setPhpClassSerialization(serialize($rm));
        $r->save();

        //////////////////
        // Normal Rates //
        //////////////////

        $rm = new PhpRateByDuration();
        $rm->dstChannelPattern = "";
        $rm->rateByMinute = false;
        $rm->costForMinute = 1;
        $rm->costOnCall = 0;
        $rm->atLeastXSeconds = 0;
        $rm->whenRound_0_59 = 0;
        $rm->externalTelephonePrefix = "";
        $rm->internalTelephonePrefix = "";
        $r = new ArRate();
        $r->setDestinationType(DestinationType::outgoing);
        $r->setArRateCategoryId($normalCategoryId);
        $r->setArPartyId(null);
        $r->setStartTime($past);
        $r->setEndTime(null);
        $r->setIsException(false);
        $r->setPhpClassSerialization(serialize($rm));
        $r->save();

        $rm = new PhpRateByDuration();
        $rm->dstChannelPattern = "";
        $rm->rateByMinute = false;
        $rm->costForMinute = 0.8;
        $rm->costOnCall = 0;
        $rm->atLeastXSeconds = 0;
        $rm->whenRound_0_59 = 0;
        $rm->externalTelephonePrefix = "";
        $rm->internalTelephonePrefix = "";
        $r = new ArRate();
        $r->setDestinationType(DestinationType::outgoing);
        $r->setArRateCategoryId($discountedCategoryId);
        $r->setArPartyId(null);
        $r->setStartTime($past);
        $r->setEndTime(null);
        $r->setIsException(false);
        $r->setPhpClassSerialization(serialize($rm));
        $r->save();

        $rm = new PhpRateByDuration();
        $rm->dstChannelPattern = "";
        $rm->rateByMinute = false;
        $rm->costForMinute = 0.5;
        $rm->costOnCall = 0;
        $rm->atLeastXSeconds = 0;
        $rm->whenRound_0_59 = 0;
        $rm->externalTelephonePrefix = "";
        $rm->internalTelephonePrefix = "";
        $r = new ArRate();
        $r->setDestinationType(DestinationType::outgoing);
        $r->setArRateCategoryId(null);
        $r->setArPartyId($defaultVendorId);
        $r->setStartTime($past);
        $r->setEndTime(null);
        $r->setIsException(false);
        $r->setPhpClassSerialization(serialize($rm));
        $r->save();

        $rm = new PhpRateByDuration();
        $rm->dstChannelPattern = "";
        $rm->rateByMinute = false;
        $rm->costForMinute = 0;
        $rm->costOnCall = 0;
        $rm->atLeastXSeconds = 0;
        $rm->whenRound_0_59 = 0;
        $rm->externalTelephonePrefix = "";
        $rm->internalTelephonePrefix = "";
        $r = new ArRate();
        $r->setDestinationType(DestinationType::internal);
        $r->setArRateCategoryId(null);
        $r->setArPartyId($defaultVendorId);
        $r->setStartTime($past);
        $r->setEndTime(null);
        $r->setIsException(false);
        $r->setPhpClassSerialization(serialize($rm));
        $r->save();

        $rm = new PhpRateByDuration();
        $rm->dstChannelPattern = "";
        $rm->rateByMinute = false;
        $rm->costForMinute = 0;
        $rm->costOnCall = 0;
        $rm->atLeastXSeconds = 0;
        $rm->whenRound_0_59 = 0;
        $rm->externalTelephonePrefix = "";
        $rm->internalTelephonePrefix = "";
        $r = new ArRate();
        $r->setDestinationType(DestinationType::internal);
        $r->setArRateCategoryId($normalCategoryId);
        $r->setArPartyId(null);
        $r->setStartTime($past);
        $r->setEndTime(null);
        $r->setIsException(false);
        $r->setPhpClassSerialization(serialize($rm));
        $r->save();

        $rm = new PhpRateByDuration();
        $rm->dstChannelPattern = "";
        $rm->rateByMinute = false;
        $rm->costForMinute = 0;
        $rm->costOnCall = 0;
        $rm->atLeastXSeconds = 0;
        $rm->whenRound_0_59 = 0;
        $rm->externalTelephonePrefix = "";
        $rm->internalTelephonePrefix = "";
        $r = new ArRate();
        $r->setDestinationType(DestinationType::internal);
        $r->setArRateCategoryId($discountedCategoryId);
        $r->setArPartyId(null);
        $r->setStartTime($past);
        $r->setEndTime(null);
        $r->setIsException(false);
        $r->setPhpClassSerialization(serialize($rm));
        $r->save();

        $rm = new PhpRateByDuration();
        $rm->dstChannelPattern = "";
        $rm->rateByMinute = false;
        $rm->costForMinute = 0;
        $rm->costOnCall = -0.05;
        $rm->atLeastXSeconds = 0;
        $rm->whenRound_0_59 = 0;
        $rm->externalTelephonePrefix = "";
        $rm->internalTelephonePrefix = "";
        $r = new ArRate();
        $r->setDestinationType(DestinationType::incoming);
        $r->setArRateCategoryId($normalCategoryId);
        $r->setArPartyId(null);
        $r->setStartTime($past);
        $r->setEndTime(null);
        $r->setIsException(false);
        $r->setPhpClassSerialization(serialize($rm));
        $r->save();

        $rm = new PhpRateByDuration();
        $rm->dstChannelPattern = "";
        $rm->rateByMinute = false;
        $rm->costForMinute = 0;
        $rm->costOnCall = -0.05;
        $rm->atLeastXSeconds = 0;
        $rm->whenRound_0_59 = 0;
        $rm->externalTelephonePrefix = "";
        $rm->internalTelephonePrefix = "";
        $r = new ArRate();
        $r->setDestinationType(DestinationType::incoming);
        $r->setArRateCategoryId($discountedCategoryId);
        $r->setArPartyId(null);
        $r->setStartTime($past);
        $r->setEndTime(null);
        $r->setIsException(false);
        $r->setPhpClassSerialization(serialize($rm));
        $r->save();

        $rm = new PhpRateByDuration();
        $rm->dstChannelPattern = "";
        $rm->rateByMinute = false;
        $rm->costForMinute = 0;
        $rm->costOnCall = -0.1;
        $rm->atLeastXSeconds = 0;
        $rm->whenRound_0_59 = 0;
        $rm->externalTelephonePrefix = "";
        $rm->internalTelephonePrefix = "";
        $r = new ArRate();
        $r->setDestinationType(DestinationType::incoming);
        $r->setArRateCategoryId(null);
        $r->setArPartyId($defaultVendorId);
        $r->setStartTime($past);
        $r->setEndTime(null);
        $r->setIsException(false);
        $r->setPhpClassSerialization(serialize($rm));
        $r->save();

        ////////////////////////
        // Add prefixes table //
        ////////////////////////

        loadPrefixes("scripts/world_prefix_table.csv", FALSE);

        // Special numbers
        //
        $tnItalyFixed1 = "391111111";
        $tnItalyFixed2 = "392222222";
        $tnItalyMobile1 = "39333333";
        $tnItalyMobile2 = "39344444";
        $tnItalyMobile2Special = "39344445";
        $tnAlbaniaFixed1 = "35563333";
        $tnAlbaniaMobile1 = "3556888";

        $prefixItaly = "39";
        $prefixItalyMobie = "393";

        ///////////////////////////
        // CUSTOMERS AND VENDORS //
        ///////////////////////////

        $r = new ArParty();
        $r->setCustomerOrVendor("C");
        $r->setName("Alpha");
        $r->setExternalCrmCode("");
        $r->setArRateCategoryId($normalCategoryId);
        $r->setArParamsId($defaultParamsId);
        $r->setVat("WRLD1111113333");
        $r->setLegalAddress("Street Avenue, 1");
        $r->setLegalCity("Soliera");
        $r->setLegalZipcode("41019");
        $r->setLegalStateProvince("Modena");
        $r->setLegalCountry("Italy");
        $r->setEmail("alpha@example.com");
        $r->save();
        $alphaPartyId = $r->getId();

        $r = new ArParty();
        $r->setCustomerOrVendor("C");
        $r->setName("Beta");
        $r->setExternalCrmCode("");
        $r->setArRateCategoryId($normalCategoryId);
        $r->setArParamsId($defaultParamsId);
        $r->setVat("WRLD1111113333");
        $r->setLegalAddress("Street Avenue, 12");
        $r->setLegalCity("Soliera");
        $r->setLegalZipcode("41019");
        $r->setLegalStateProvince("Modena");
        $r->setLegalCountry("Italy");
        $r->setEmail("beta@example.com");
        $r->save();
        $betaPartyId = $r->getId();

        $r = new ArParty();
        $r->setCustomerOrVendor("C");
        $r->setName("Gamma");
        $r->setExternalCrmCode("");
        $r->setArRateCategoryId($discountedCategoryId);
        $r->setArParamsId($defaultParamsId);
        $r->setVat("WRLD1111117777");
        $r->setLegalAddress("Street Avenue, 123");
        $r->setLegalCity("Soliera");
        $r->setLegalZipcode("41019");
        $r->setLegalStateProvince("Modena");
        $r->setLegalCountry("Italy");
        $r->setEmail("gamma@example.com");
        $r->save();
        $gammaPartyId = $r->getId();

        /////////////
        // OFFICES //
        /////////////

        $r = new ArOffice();
        $r->setArPartyId($alphaPartyId);
        $r->setName("Main");
        $r->save();
        $alphaOfficeId1 = $r->getId();

        $r = new ArOffice();
        $r->setArPartyId($betaPartyId);
        $r->setName("Store");
        $r->save();
        $betaOfficeId1 = $r->getId();

        $r = new ArOffice();
        $r->setArPartyId($betaPartyId);
        $r->setName("Administration");
        $r->save();
        $betaOfficeId2 = $r->getId();

        $r = new ArOffice();
        $r->setArPartyId($gammaPartyId);
        $r->setName("Store");
        $r->save();
        $gammaOfficeId1 = $r->getId();

        $r = new ArOffice();
        $r->setArPartyId($gammaPartyId);
        $r->setName("Administration");
        $r->save();
        $gammaOfficeId2 = $r->getId();


        ///////////////////////
        // ASTERISK ACCOUNTS //
        ///////////////////////

        $r = new ArAsteriskAccount();
        $r->setName("alpha1");
        $r->setAccountcode("alpha1");
        $r->setArOfficeId($alphaOfficeId1);
        $r->save();
        $alphaAccount1Id = $r->getId();

        $r = new ArAsteriskAccount();
        $r->setName("beta1");
        $r->setAccountcode("beta1");
        $r->setArOfficeId($betaOfficeId1);
        $r->save();
        $betaAccount1Id = $r->getId();

        $r = new ArAsteriskAccount();
        $r->setName("beta2");
        $r->setAccountcode("beta2");
        $r->setArOfficeId($betaOfficeId2);
        $r->save();
        $betaAccount2Id = $r->getId();

        $r = new ArAsteriskAccount();
        $r->setName("gamma1");
        $r->setAccountcode("gamma1");
        $r->setArOfficeId($gammaOfficeId1);
        $r->save();
        $gammaAccount1Id = $r->getId();

        $r = new ArAsteriskAccount();
        $r->setName("gamma2");
        $r->setAccountcode("gamma2");
        $r->setArOfficeId($gammaOfficeId2);
        $r->save();
        $gammaAccount2Id = $r->getId();

        $r = new ArAsteriskAccount();
        $r->setName("gamma3");
        $r->setAccountcode("gamma3");
        $r->setArOfficeId($gammaOfficeId2);
        $r->save();
        $gammaAccount3Id = $r->getId();

        /////////////////////////
        // WEB ACCESS ACCOUNTS //
        /////////////////////////

        $r = new ArWebAccount();
        $r->setLogin("admin");
        $r->setPassword("admin");
        $r->setArPartyId(null);
        $r->setArOfficeId(null);
        $r->setActivateAt($past);
        $r->setDeactivateAt(null);
        $r->save();

        $r = new ArWebAccount();
        $r->setLogin("alpha");
        $r->setPassword("alpha");
        $r->setArPartyId($alphaPartyId);
        $r->setArOfficeId(null);
        $r->setActivateAt($past);
        $r->setDeactivateAt(null);
        $r->save();

        $r = new ArWebAccount();
        $r->setLogin("beta");
        $r->setPassword("beta");
        $r->setArPartyId($betaPartyId);
        $r->setArOfficeId(null);
        $r->setActivateAt($past);
        $r->setDeactivateAt(null);
        $r->save();

        $r = new ArWebAccount();
        $r->setLogin("gamma");
        $r->setPassword("gamma");
        $r->setArPartyId($gammaPartyId);
        $r->setArOfficeId(null);
        $r->setActivateAt($past);
        $r->setDeactivateAt(null);
        $r->save();

        $r = new ArWebAccount();
        $r->setLogin("store");
        $r->setPassword("store");
        $r->setArPartyId($gammaPartyId);
        $r->setArOfficeId($gammaOfficeId1);
        $r->setActivateAt($past);
        $r->setDeactivateAt(null);
        $r->save();

        //////////////
        // Add CDRs //
        //////////////

        $telephone_numbers = array("3905956565656",
                                   "3905194234234",
                                   "3932894234234",
                                   "3933394234234",
                                   "3944894234234",
                                   "545494234234234",
                                   "54544234234234",
                                   "54541111122333",
                                   "545491234333",
                                   "559872342333",
                                   "5599721234333",
                                   "559993423423423",
                                   "559993423423423",
                                   "55999342342423",
                                   "559993422368",
                                   "5599934239999",
                                   "17094234234234",
                                   "17077824234234",
                                   "17077824234234",
                                   "17077824666544",
                                   "17077824456453",
                                   "861893345345345",
                                   "861893345234234",
                                   "861893343333",
                                   "86189334534434",
                                   "8622242342344",
                                   "8623423442444",
                                   "86234234424234",
                                   "8623423442898",
                                   "8623423442978",
                                   "454288234234",
                                   "454288234234",
                                   "4542882344563",
                                   "45428823466467",
                                   "45428823426868",
                                   "454253811231234",
                                   "454253811231234",
                                   "4542538112334534",
                                   "33607345345345",
                                   "3360734534523423",
                                   "336073453453345",
                                   "33607345345666",
                                   "33607345348887",
                                   "3360734534598989",
                                   "33607345345385645",
                                   "33677222343434",
                                   "3367722555664",
                                   "33677222366546",
                                   "336772223466565");

        $ar_asterisk_accounts = array("alpha1", "beta1", "beta2", "gamma1", "gamma2", "gamma3");
        $ar_channels = array("incoming", "outgoing", "internal");
        $ar_dispositions = array("ANSWERED", "NO ANSWERED");
        $ar_amaflags = array(0);

        $daysRange = 30 * 2;

        for ($i = 1; $i <= $recordsToAdd; $i++) {
            if ($i % 1000 == 0) {
                echo "\nAdded $i CDR demo records\n";
            }
            addRandomCDR(
                $ar_asterisk_accounts,
                $daysRange,
                $ar_channels,
                $ar_dispositions,
                $ar_amaflags,
                $telephone_numbers);
        }

        echo "\nAdded $recordsToAdd CDR demo records.\n";


    } catch (Exception $e) {
        echo "Caught exceptio: " . $e->getMessage() . "\n";
        echo $e->getTraceAsString();
    }
}

/**
 * @return a random element of an array
 */
function my_array_rand($arr)
{
    $k = array_rand($arr);
    return $arr[$k];
}

/**
 * Generate a random CDR
 */
function addRandomCDR(
    $ar_asterisk_accounts,
    $daysRange,
    $ar_channels,
    $ar_dispositions,
    $ar_amaflags,
    $telephone_numbers)
{

    $secs = rand(0, $daysRange * 24 * 60 * 60);
    $date = time() - $secs;
    $duration = rand(0, 60 * 5);

    $cdr = new Cdr();
    $cdr->setCalldate($date);
    $cdr->setAccountcode(my_array_rand($ar_asterisk_accounts));
    $cdr->setDst(my_array_rand($telephone_numbers));
    $cdr->setDstchannel(my_array_rand($ar_channels));
    $cdr->setDisposition(my_array_rand($ar_dispositions));
    $cdr->setAmaflags(my_array_rand($ar_amaflags));
    $cdr->setBillsec($duration);
    $cdr->setDuration($duration);
    $cdr->save();
}

//////////////////
// SYSTEM TESTS //
//////////////////

/**
 * Wait some time, for free cron job, otherwise exit.
 *
 * @return the processor with the lock.
 */
function waitCronJob()
{

    $waitSeconds = 5;

    $webDir = realpath(SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'web');

    $processor = new JobQueueProcessor();

    $continue = TRUE;
    $retryCount = 50;
    while ($continue) {
        $retryCount--;
        if ($retryCount == 0) {
            echo "\nBAD: there are still running Jobs. The process can not continue.";
            echo "\nYou could try with command `php asterisell.php app unlock-halted-jobs`\n";
            exit(1);
        }

        $r = $processor->lock($webDir);
        if ($r == TRUE) {
            echo "\nOk: there are no running Jobs, and other Jobs will be locked.\n";
            $continue = FALSE;
        } else {
            echo "\nWaiting: there are running Jobs. I will sleep for $waitSeconds seconds, and try other $retryCount times.\n";
            sleep($waitSeconds);
        }
    }

    return $processor;
}

/**
 * NOTE: it is not mandatory
 *
 * @return void
 */
function unlockCronJob($processor)
{
    $processor->unlock;
}

/**
 * Wait some time, for free cron job, otherwise exit.
 *
 * @return the processor with the lock.
 */
function unlockHaltedJobs()
{
    $processor = new JobQueueProcessor();
    $processor->forceUnlockOfHaltedWebProcess();
}

function showMaintananceMode() {

    if (MyUser::isCronLockedForMaintanance()) {
        echo "\nWARNING:";
        echo "\n  Up to date all cron jobs are locked, because the application is in maintanance mode.";
        echo "\n  You can enable it again with command `php asterisell.php cron enable`";
    }

    if (MyUser::isAppLockedForMaintanance()) {
        echo "\nWARNING:";
        echo "\n  Up to date Asterisell Web application can be accessed only from administrators, because it is in maintanance mode.";
        echo "\n  You can enable Asterisell again with command `php asterisell.php app enable`";
    }
}

//////////////////////
// MAIN ENTRY POINT //
//////////////////////

function displayUsage()
{
    echo "\nUsage:\n";
    echo "\nphp asterisell.php help";
    echo "\n  this help";
    echo "\n";
    echo "\nphp asterisell.php activate";
    echo "\n  clear cache, set directories, and other common and safe management operations";
    echo "\n";
    echo "\nphp asterisell.php app upgrade";
    echo "\n  upgrade safely a running instance to a new version";
    echo "\n";
    echo "\nphp asterisell.php data upgrade";
    echo "\n  upgrade safely data to the current new version (call after `app upgrade`)";
    echo "\n";
    echo "\nphp asterisell.php cron disable";
    echo "\n  disable cron job processor";
    echo "\n";
    echo "\nphp asterisell.php cron enable";
    echo "\n  enable cron job processor";
    echo "\n";
    echo "\nphp asterisell.php app disable";
    echo "\n  disable access to the application to normal users and to cron processor";
    echo "\n";
    echo "\nphp asterisell.php app enable";
    echo "\n  enable access to the application, calling activate by default";
    echo "\n";
    echo "\nphp asterisell.php app unlock-halted-jobs";
    echo "\n  remove locks about jobs started from the administrator on the web";
    echo "\n";
    echo "\nphp asterisell.php install";
    echo "\n  initial install";
    echo "\n";
    echo "\nphp asterisell.php data backup";
    echo "\n  make a backup of the database";
    echo "\n";
    echo "\nphp asterisell.php data root <some-password>";
    echo "\n  add a root user, with some-password to an existing database";
    echo "\n";
    echo "\nphp asterisell.php data init <some-password>";
    echo "\n  create an empty DB with minimal initial data, and a root user with some-password";
    echo "\n";
    echo "\nphp asterisell.php data demo <some-password>";
    echo "\n  create an empty DB with demo data, and a root user with some-password";
    echo "\n";
    echo "\nphp asterisell.php data stress-demo-data <some-password> <nr-of-cdr-records>";
    echo "\n  create a demo database with (many) random CDR records.";
    echo "\n  NOTE: database speed depends not from total number of CDRs, but only from the CDRs in the last 2-30 days,";
    echo "\n  because all other CDRs are rarely accessed from queries.";
    echo "\n";
    echo "\nphp asterisell.php data regression <some-password>";
    echo "\n  create an empty DB with regression data, and a root user with some-password";
    echo "\n";
    echo "\nphp asterisell.php data reset";
    echo "\n  reset all the content of current db without loading any data.";
    echo "\n";
    echo "\nphp asterisell.php data merge-telephone-prefixes ";
    echo "\n  add new telephone prefixes to the telephone prefix table.";
    echo "\n";

    showMaintananceMode();
    echo "\n";
}


function main($argc, $argv)
{

    $mainCommand = trim($argv[1]);
    $subCommand = trim($argv[2]);
    $password = trim($argv[3]);
    $options = trim($argv[4]);

    ///////////////////
    // INITIAL TESTS //
    ///////////////////

    $connectionError = "\nMySQL database user have no alter table privileges, or read privileges. Follow installation instructions of the manual. Check your database configurations inside `config/databases.yml` file. ";

    if (!isSafeAlterConnection()) {
        // signal that the connection is not ok
        echo $connectionError;
        exit(1);
    }

    if (!isSafeReadConnection()) {
        // signal that the connection is not ok
        echo $connectionError;
        exit(1);
    }

    ////////////////////
    // QUICK COMMANDS //
    ////////////////////

    if ($mainCommand === "help" || $mainCommand == "") {
        displayUsage();
        exit(0);
    } else if ($mainCommand == "app" && $subCommand === "unlock-halted-jobs") {
        unlockHaltedJobs();

        showMaintananceMode();
        echo "\n";

        exit(0);
    }

    //////////////
    // COMMANDS //
    //////////////

    $lock = waitCronJob();

    $suggestion = "";

    if ($mainCommand === "install") {
        explicitConfirmForDeletion();
        makeInstall();
    } else  if ($mainCommand === "activate") {
        makeActivate();
    } else if ($mainCommand === "app") {
        if ($subCommand === "enable") {
            MyUser::unlockAppForMaintanance();
        } else if ($subCommand === "disable") {
            MyUser::lockAppForMaintanance();
        } else if ($subCommand === "upgrade") {
            $suggestion = makeAppUpgrade();
        } else {
            displayUsage();
            exit(1);
        }
    } else if ($mainCommand === "cron") {
        if ($subCommand === "enable") {
            MyUser::unlockCronForMaintanance();
        } else if ($subCommand === "disable") {
            MyUser::lockCronForMaintanance();
        } else {
            displayUsage();
            exit(1);
        }
    } else if ($mainCommand === "data") {
        if ($subCommand === "root") {
            $paramsId = createDefaultParams();
            addRootUser($password, $paramsId);
        } else if ($subCommand === "init") {
            explicitConfirmForDeletion();
            list($paramsId, $normalCategoryId, $discountedCategoryId, $defaultVendorId) = initWithDefaultData();
            addRootUser($password, $paramsId);
        } else if ($subCommand === "demo") {
            explicitConfirmForDeletion();
            $paramsId = initWithDemoData(3000);
            addRootUser($password, $paramsId);
        } else if ($subCommand === "stress-demo-data") {
            explicitConfirmForDeletion();
            $paramsId = initWithDemoData(intval($options));
            addRootUser($password, $paramsId);
        } else if ($subCommand === "regression") {
            explicitConfirmForDeletion();
            if (trim(sfConfig::get('app_internal_external_telephone_numbers')) === "3") {
                echo "\napp_internal_external_telephone_numbers must be 0 for regression tests\n";
                echo "\nTests are not performed!\n";
                exit(0);
            }
            $paramsId = initWithRegressionData();
            checkRegressionData();
            addRootUser($password, $paramsId);
        } else if ($subCommand === "reset") {
            explicitConfirmForDeletion();
            deleteAllData();
        } else if ($subCommand === "merge-telephone-prefixes") {
            addNewTelephonePrefixes();
        } else if ($subCommand === "backup") {
            makeDatabaseBackup(TRUE);
        } else if ($subCommand === "upgrade") {
            makeDataUpgrade();
        } else {
            displayUsage();
            exit(1);
        }

    } else {
        displayUsage();
        exit(1);
    }

    unlockCronJob($lock);

    echo "\nExecute pending jobs.";
    runJobProcessorQueue();
    echo "\nDone";
    
    echo "\n";
    showMaintananceMode();
    echo "\n";

    echo $suggestion;
}

?>
