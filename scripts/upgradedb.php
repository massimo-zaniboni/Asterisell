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


define('SF_ROOT_DIR', realpath(dirname(__FILE__) . '/..'));
define('SF_APP', 'asterisell');
define('SF_ENVIRONMENT', 'prod');
define('SF_DEBUG', false);

require_once(SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'apps' . DIRECTORY_SEPARATOR . SF_APP . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php');

sfLoader::loadHelpers(array('I18N', 'Debug', 'Asterisell'));

sfContext::getInstance();

define('WEB_DIR', SF_ROOT_DIR . DIRECTORY_SEPARATOR . 'web');

main();

/**
 * Apply upgrade commands only if they are not already applied.
 *
 * @param $findNewCommands TRUE for applying only not already applied commands
 * @param $applyCommands TRUE for applying commands to SQL database
 * @param $storeCommands TRUE for storing in upgrade table the commands
 * @return void
 */
function upgradeDatabase($findNewCommands, $applyCommands, $storeCommands, $firstRun)
{
    $r = array();
    $i = 1;

    // NOTE: the order and the key of the array is very important because it is used also as a key for recognizing
    // already executed commands.
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
    $r[$i++] = "ALTER TABLE `cdr` ADD `source_cost` INTEGER(20) default null, ADD `is_exported` INTEGER default 0 NOT NULL, ADD `source_data_type` VARCHAR(1024), ADD `source_data` VARCHAR(10000), CHANGE COLUMN `source_id` `source_id` VARCHAR(255) DEFAULT NULL, ADD KEY `cdr_is_exported_index`(`is_exported`), ADD INDEX account_and_calldate_index(ar_asterisk_account_id, calldate), DROP KEY `cdr_source_id_index`, ADD KEY `cdr_source_id_index`(`source_id`);";
    $r[$i++] = "ALTER TABLE `cdr` DROP KEY `cdr_channel_index`;";
    $r[$i++] = "ALTER TABLE `cdr` DROP KEY `cdr_income_ar_rate_id_index`;";
    $r[$i++] = "ALTER TABLE `cdr` DROP KEY `cdr_income_index`;";
    $r[$i++] = "ALTER TABLE `cdr` DROP KEY `cdr_cost_ar_rate_id_index`;";
    $r[$i++] = "ALTER TABLE `cdr` DROP KEY `cdr_vendor_id_index`;";
    $r[$i++] = "ALTER TABLE `cdr` DROP KEY `cdr_cost_index`;";
    $r[$i++] = "ALTER TABLE `cdr` DROP KEY `cdr_cached_internal_telephone_number_index`;";
    $r[$i++] = "ALTER TABLE `cdr` DROP KEY `cdr_cached_external_telephone_number_index`;";
    $r[$i++] = "ALTER TABLE `cdr` DROP KEY `cdr_external_telephone_number_with_applied_portability_index`;";
    $r[$i++] = "ALTER TABLE `cdr` DROP KEY `cdr_cached_masked_external_telephone_number_index`;";
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
    $r[$i++] = "ALTER TABLE cdr MODIFY COLUMN `source_id` VARCHAR(1024), MODIFY COLUMN  `source_data` TEXT;";

    // Upgrade the database
    $time1 = time();

    $connection = Propel::getConnection();

    foreach ($r as $key => $cmd) {
        $cmd_alreadyApplied = FALSE;
        $cmd_apply = $applyCommands;

        if ($findNewCommands) {
            $c = new Criteria();
            $c->add(ArDatabaseVersionPeer::VERSION, $key);
            $upg = ArDatabaseVersionPeer::doSelectOne($c);

            if (!is_null($upg)) {
                $cmd_alreadyApplied = TRUE;
                $cmd_apply = FALSE;
            } else {
                $cmd_alreadyApplied = FALSE;
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
                if ($firstRun) {
                    echo "\nERROR: this is the first upgrade using the new method, and the initial commands can generate some errors because they were already applied to the database. In this case this is not a problem.";
                } else {
                    echo "\nERROR: if you execute upgrade again, this command will be retried again. ";
                }
                echo "\nThe error message is: " . $e->getMessage() . "\n";
            }
        }

        if ($cmd_store && (!$cmd_alreadyApplied)) {
            $upg = new ArDatabaseVersion();
            $upg->setVersion($key);
            $upg->setInstallationDate(time());
            $upg->save();
        }
    }

    // Show stats
    $time2 = time();

    if ($applyCommands) {
        echo "\n\nUpgrading started at " . date("r", $time1) . " and completed at " . date("r", $time2) . "\nDuring this time the dabase was locked.\n";
    }
}

/**
 * @return TRUE if it is the first time this upgrade procedure is called.
 */
function isFirstUpgrade()
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

function main()
{
    if (!isSafeReadConnection()) {
        echo "\nConnection to MySQL database can not be established. Check your database configurations. ";
        exit(1);
    }

    if (!isSafeAlterConnection()) {
        echo "\nMySQL database user have no alter table privileges. Check your database configurations. ";
        exit(1);
    }

    echo "\n!!WARNING!!: During upgrading the involved MySQL tables will be locked, and they can not be written.";
    echo "\n             This is a fast operation in case of all tables, except CDR table containing all made calls.";
    echo "\n             So if you upgrade the same database where Asterisell is running, some calls will be not inserted ";
    echo "\n             inside CDR table during this operation.";
    echo "\n             In case of CDR tables with 1 milion of records, this operation can require also 1-2 hours.";
    echo "\n             Usually in the AsteriSell website there are information about the upgrade, and you will informed if it involves the CDR table.";
    echo "\n             When it does not involve the CDR table, you can apply it freely because it is a very fast process.";
    echo "\n ";
    echo "\n The command will display the required time";
    echo "\nContinue upgrading? [y/n]";
    $fh = fopen('php://stdin', 'r');
    $next_line = trim(fgets($fh, 1024));
    if ($next_line === "y" || $next_line === "Y") {

        $isFirstUpg = isFirstUpgrade();

        if ($isFirstUpg) {
            // note: it does not store anything, because maybe there is no the safe upgrade table yet
            upgradeDatabase(FALSE, TRUE, FALSE, TRUE);

            // then store all the commands, without applying them.
            upgradeDatabase(FALSE, FALSE, TRUE, TRUE);
        } else {
            upgradeDatabase(TRUE, TRUE, TRUE, FALSE);
        }
    }
}

?>
