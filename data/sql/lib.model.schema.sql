
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

#-----------------------------------------------------------------------------
#-- cdr
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `cdr`;


CREATE TABLE `cdr`
(
	`calldate` DATETIME  NOT NULL,
	`clid` VARCHAR(255)  NOT NULL,
	`src` VARCHAR(255)  NOT NULL,
	`dst` VARCHAR(255)  NOT NULL,
	`dcontext` VARCHAR(255)  NOT NULL,
	`channel` VARCHAR(255),
	`dstchannel` VARCHAR(255)  NOT NULL,
	`lastapp` VARCHAR(255)  NOT NULL,
	`lastdata` VARCHAR(255)  NOT NULL,
	`duration` INTEGER(11)  NOT NULL,
	`billsec` INTEGER(11)  NOT NULL,
	`disposition` VARCHAR(255)  NOT NULL,
	`amaflags` INTEGER(11)  NOT NULL,
	`accountcode` VARCHAR(255),
	`uniqueid` VARCHAR(255) default '' NOT NULL,
	`userfield` VARCHAR(255)  NOT NULL,
	`destination_type` INTEGER(1) default 0 NOT NULL,
	`ar_asterisk_account_id` INTEGER,
	`income_ar_rate_id` INTEGER(20) default null,
	`income` INTEGER(20) default null,
	`cost_ar_rate_id` INTEGER(20) default null,
	`vendor_id` INTEGER(20) default null,
	`cost` INTEGER(20) default null,
	`ar_telephone_prefix_id` INTEGER,
	`cached_internal_telephone_number` VARCHAR(255),
	`cached_external_telephone_number` VARCHAR(255),
	`external_telephone_number_with_applied_portability` VARCHAR(255),
	`cached_masked_external_telephone_number` VARCHAR(255),
	`source_id` VARCHAR(1024),
	`source_cost` INTEGER(20) default null,
	`is_exported` INTEGER default 0 NOT NULL,
	`source_data_type` VARCHAR(255),
	`source_data` TEXT,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`id`),
	KEY `cdr_calldate_index`(`calldate`),
	KEY `cdr_uniqueid_index`(`uniqueid`),
	KEY `cdr_destination_type_index`(`destination_type`),
	KEY `cdr_source_id_index`(`source_id`),
	KEY `cdr_is_exported_index`(`is_exported`),
	KEY `account_and_calldate_index`(`ar_asterisk_account_id`, `calldate`),
	CONSTRAINT `cdr_FK_1`
		FOREIGN KEY (`ar_asterisk_account_id`)
		REFERENCES `ar_asterisk_account` (`id`),
	INDEX `cdr_FI_2` (`ar_telephone_prefix_id`),
	CONSTRAINT `cdr_FK_2`
		FOREIGN KEY (`ar_telephone_prefix_id`)
		REFERENCES `ar_telephone_prefix` (`id`),
	INDEX `FI__to_income_rate_key` (`income_ar_rate_id`),
	CONSTRAINT `cdr_to_income_rate_key`
		FOREIGN KEY (`income_ar_rate_id`)
		REFERENCES `ar_rate` (`id`),
	INDEX `FI__to_cost_rate_key` (`cost_ar_rate_id`),
	CONSTRAINT `cdr_to_cost_rate_key`
		FOREIGN KEY (`cost_ar_rate_id`)
		REFERENCES `ar_rate` (`id`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_number_portability
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_number_portability`;


CREATE TABLE `ar_number_portability`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`telephone_number` VARCHAR(255)  NOT NULL,
	`ported_telephone_number` VARCHAR(255)  NOT NULL,
	`from_date` DATETIME,
	PRIMARY KEY (`id`),
	KEY `ar_number_portability_telephone_number_index`(`telephone_number`),
	KEY `ar_number_portability_from_date_index`(`from_date`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_asterisk_account
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_asterisk_account`;


CREATE TABLE `ar_asterisk_account`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255),
	`account_code` VARCHAR(255)  NOT NULL,
	`ar_office_id` INTEGER,
	`is_active` INTEGER default 1 NOT NULL,
	`ar_rate_category_id` INTEGER,
	PRIMARY KEY (`id`),
	KEY `ar_asterisk_account_account_code_index`(`account_code`),
	INDEX `ar_asterisk_account_FI_1` (`ar_office_id`),
	CONSTRAINT `ar_asterisk_account_FK_1`
		FOREIGN KEY (`ar_office_id`)
		REFERENCES `ar_office` (`id`),
	INDEX `ar_asterisk_account_FI_2` (`ar_rate_category_id`),
	CONSTRAINT `ar_asterisk_account_FK_2`
		FOREIGN KEY (`ar_rate_category_id`)
		REFERENCES `ar_rate_category` (`id`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_office
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_office`;


CREATE TABLE `ar_office`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255),
	`description` VARCHAR(255),
	`ar_party_id` INTEGER,
	`ar_rate_category_id` INTEGER,
	PRIMARY KEY (`id`),
	INDEX `ar_office_FI_1` (`ar_party_id`),
	CONSTRAINT `ar_office_FK_1`
		FOREIGN KEY (`ar_party_id`)
		REFERENCES `ar_party` (`id`),
	INDEX `ar_office_FI_2` (`ar_rate_category_id`),
	CONSTRAINT `ar_office_FK_2`
		FOREIGN KEY (`ar_rate_category_id`)
		REFERENCES `ar_rate_category` (`id`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_party
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_party`;


CREATE TABLE `ar_party`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`customer_or_vendor` CHAR(1) default 'C' NOT NULL,
	`name` VARCHAR(255),
	`external_crm_code` VARCHAR(255),
	`vat` VARCHAR(255),
	`legal_address` VARCHAR(255),
	`legal_city` VARCHAR(255),
	`legal_zipcode` VARCHAR(255),
	`legal_state_province` VARCHAR(255),
	`legal_country` VARCHAR(255),
	`email` VARCHAR(255),
	`phone` VARCHAR(255),
	`phone2` VARCHAR(255),
	`fax` VARCHAR(255),
	`ar_rate_category_id` INTEGER,
	`ar_params_id` INTEGER,
	`max_limit_30` INTEGER(20) default null,
	`last_email_advise_for_max_limit_30` DATETIME,
	`is_active` INTEGER default 1 NOT NULL,
	`is_reseller` INTEGER default 0 NOT NULL,
	`reseller_code` VARCHAR(255),
	PRIMARY KEY (`id`),
	KEY `ar_party_customer_or_vendor_index`(`customer_or_vendor`),
	KEY `ar_party_is_active_index`(`is_active`),
	KEY `ar_party_is_reseller_index`(`is_reseller`),
	INDEX `ar_party_FI_1` (`ar_rate_category_id`),
	CONSTRAINT `ar_party_FK_1`
		FOREIGN KEY (`ar_rate_category_id`)
		REFERENCES `ar_rate_category` (`id`),
	INDEX `ar_party_FI_2` (`ar_params_id`),
	CONSTRAINT `ar_party_FK_2`
		FOREIGN KEY (`ar_params_id`)
		REFERENCES `ar_params` (`id`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_params
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_params`;


CREATE TABLE `ar_params`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255),
	`is_default` INTEGER,
	`service_name` VARCHAR(255),
	`service_provider_website` VARCHAR(255),
	`service_provider_email` VARCHAR(255),
	`vat_tax_perc` INTEGER(20) default 0 NOT NULL,
	`logo_image` VARCHAR(255),
	`slogan` VARCHAR(1024),
	`logo_image_in_invoices` VARCHAR(255),
	`footer` VARCHAR(255),
	`user_message` VARCHAR(255),
	`legal_name` VARCHAR(255),
	`external_crm_code` VARCHAR(255),
	`vat` VARCHAR(255),
	`legal_address` VARCHAR(255),
	`legal_website` VARCHAR(255),
	`legal_city` VARCHAR(255),
	`legal_zipcode` VARCHAR(255),
	`legal_state_province` VARCHAR(255),
	`legal_country` VARCHAR(255),
	`legal_email` VARCHAR(255),
	`legal_phone` VARCHAR(255),
	`phone2` VARCHAR(255),
	`legal_fax` VARCHAR(255),
	`invoice_notes` VARCHAR(255),
	`invoice_payment_terms` VARCHAR(2048),
	`sender_name_on_invoicing_emails` VARCHAR(255),
	`invoicing_email_address` VARCHAR(255),
	`accountant_email_address` VARCHAR(255),
	`smtp_host` VARCHAR(250),
	`smtp_port` INTEGER(4),
	`smtp_username` VARCHAR(255),
	`smtp_password` VARCHAR(255),
	`smtp_encryption` VARCHAR(255),
	`smtp_reconnect_after_nr_of_messages` INTEGER(4),
	`smtp_seconds_of_pause_after_reconnection` INTEGER(2),
	`current_invoice_nr` INTEGER(11) default 1 NOT NULL,
	`logo_html_color` VARCHAR(12),
	`payment_days` INTEGER(20) default null,
	`reconnection_fee` VARCHAR(40),
	`info_telephone_number` VARCHAR(512),
	`late_payment_fee` VARCHAR(40),
	`etf_bbs` VARCHAR(512),
	`etf_acc_no` VARCHAR(512),
	`account_department` VARCHAR(512),
	`direct_debit_payment_email` VARCHAR(512),
	`direct_debit_payment_telephone_number` VARCHAR(512),
	`login_urn` VARCHAR(512),
	PRIMARY KEY (`id`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_web_account
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_web_account`;


CREATE TABLE `ar_web_account`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`login` VARCHAR(20)  NOT NULL,
	`password` VARCHAR(40),
	`ar_party_id` INTEGER,
	`ar_office_id` INTEGER,
	`activate_at` DATE,
	`deactivate_at` DATE,
	`ar_params_id` INTEGER,
	PRIMARY KEY (`id`),
	KEY `ar_web_account_login_index`(`login`),
	INDEX `ar_web_account_FI_1` (`ar_party_id`),
	CONSTRAINT `ar_web_account_FK_1`
		FOREIGN KEY (`ar_party_id`)
		REFERENCES `ar_party` (`id`),
	INDEX `ar_web_account_FI_2` (`ar_office_id`),
	CONSTRAINT `ar_web_account_FK_2`
		FOREIGN KEY (`ar_office_id`)
		REFERENCES `ar_office` (`id`),
	INDEX `ar_web_account_FI_3` (`ar_params_id`),
	CONSTRAINT `ar_web_account_FK_3`
		FOREIGN KEY (`ar_params_id`)
		REFERENCES `ar_params` (`id`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_invoice
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_invoice`;


CREATE TABLE `ar_invoice`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`ar_party_id` INTEGER,
	`type` CHAR(1) default 'C' NOT NULL,
	`is_revenue_sharing` INTEGER default 0 NOT NULL,
	`nr` VARCHAR(20)  NOT NULL,
	`invoice_date` DATE,
	`ar_cdr_from` DATE,
	`ar_cdr_to` DATE,
	`total_bundle_without_tax` INTEGER(20) default 0,
	`total_calls_without_tax` INTEGER(20) default 0,
	`total_without_tax` INTEGER(20) default null,
	`vat_perc` INTEGER(20) default null,
	`total_vat` INTEGER(20) default null,
	`total` INTEGER(20) default null,
	`html_details` TEXT,
	`pdf_invoice` LONGBLOB,
	`pdf_call_report` LONGBLOB,
	`email_subject` VARCHAR(1024),
	`email_message` TEXT,
	`already_sent` INTEGER,
	`displayed_online` INTEGER,
	`info_or_ads_image1` VARCHAR(1024),
	`info_or_ads_image2` VARCHAR(1024),
	`ar_params_id` INTEGER,
	PRIMARY KEY (`id`),
	KEY `ar_invoice_type_index`(`type`),
	KEY `ar_invoice_is_revenue_sharing_index`(`is_revenue_sharing`),
	KEY `ar_invoice_nr_index`(`nr`),
	KEY `ar_invoice_invoice_date_index`(`invoice_date`),
	INDEX `ar_invoice_FI_1` (`ar_party_id`),
	CONSTRAINT `ar_invoice_FK_1`
		FOREIGN KEY (`ar_party_id`)
		REFERENCES `ar_party` (`id`),
	INDEX `ar_invoice_FI_2` (`ar_params_id`),
	CONSTRAINT `ar_invoice_FK_2`
		FOREIGN KEY (`ar_params_id`)
		REFERENCES `ar_params` (`id`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_invoice_creation
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_invoice_creation`;


CREATE TABLE `ar_invoice_creation`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`ar_params_id` INTEGER,
	`type` CHAR(1) default 'C' NOT NULL,
	`is_revenue_sharing` INTEGER default 0 NOT NULL,
	`first_nr` VARCHAR(20),
	`invoice_date` DATE,
	`ar_cdr_from` DATE,
	`ar_cdr_to` DATE,
	`info_or_ads_image1` VARCHAR(1024),
	`info_or_ads_image2` VARCHAR(1024),
	PRIMARY KEY (`id`),
	KEY `ar_invoice_creation_type_index`(`type`),
	KEY `ar_invoice_creation_is_revenue_sharing_index`(`is_revenue_sharing`),
	KEY `ar_invoice_creation_invoice_date_index`(`invoice_date`),
	INDEX `ar_invoice_creation_FI_1` (`ar_params_id`),
	CONSTRAINT `ar_invoice_creation_FK_1`
		FOREIGN KEY (`ar_params_id`)
		REFERENCES `ar_params` (`id`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_payment
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_payment`;


CREATE TABLE `ar_payment`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`ar_party_id` INTEGER,
	`date` DATE,
	`invoice_nr` VARCHAR(20),
	`payment_method` VARCHAR(1024),
	`payment_references` VARCHAR(1024),
	`amount` INTEGER(20) default 0 NOT NULL,
	`note` TEXT,
	PRIMARY KEY (`id`),
	KEY `ar_payment_date_index`(`date`),
	KEY `ar_payment_invoice_nr_index`(`invoice_nr`),
	INDEX `ar_payment_FI_1` (`ar_party_id`),
	CONSTRAINT `ar_payment_FK_1`
		FOREIGN KEY (`ar_party_id`)
		REFERENCES `ar_party` (`id`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_rate_category
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_rate_category`;


CREATE TABLE `ar_rate_category`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(255),
	PRIMARY KEY (`id`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_rate
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_rate`;


CREATE TABLE `ar_rate`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`destination_type` INTEGER(1) default 0 NOT NULL,
	`is_exception` INTEGER default 0 NOT NULL,
	`ar_rate_category_id` INTEGER,
	`ar_party_id` INTEGER,
	`start_time` DATETIME  NOT NULL,
	`end_time` DATETIME,
	`php_class_serialization` LONGTEXT,
	`user_input` LONGTEXT,
	`note` TEXT,
	PRIMARY KEY (`id`),
	KEY `ar_rate_destination_type_index`(`destination_type`),
	KEY `ar_rate_start_time_index`(`start_time`),
	INDEX `ar_rate_FI_1` (`ar_rate_category_id`),
	CONSTRAINT `ar_rate_FK_1`
		FOREIGN KEY (`ar_rate_category_id`)
		REFERENCES `ar_rate_category` (`id`),
	INDEX `ar_rate_FI_2` (`ar_party_id`),
	CONSTRAINT `ar_rate_FK_2`
		FOREIGN KEY (`ar_party_id`)
		REFERENCES `ar_party` (`id`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_rate_incremental_info
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_rate_incremental_info`;


CREATE TABLE `ar_rate_incremental_info`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`ar_party_id` INTEGER,
	`ar_rate_id` INTEGER,
	`period` VARCHAR(1024),
	`last_processed_cdr_date` DATETIME,
	`last_processed_cdr_id` INTEGER(20),
	`bundle_rate` LONGTEXT,
	PRIMARY KEY (`id`),
	KEY `ar_rate_incremental_info_period_index`(`period`),
	INDEX `ar_rate_incremental_info_FI_1` (`ar_party_id`),
	CONSTRAINT `ar_rate_incremental_info_FK_1`
		FOREIGN KEY (`ar_party_id`)
		REFERENCES `ar_party` (`id`),
	INDEX `ar_rate_incremental_info_FI_2` (`ar_rate_id`),
	CONSTRAINT `ar_rate_incremental_info_FK_2`
		FOREIGN KEY (`ar_rate_id`)
		REFERENCES `ar_rate` (`id`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_telephone_prefix
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_telephone_prefix`;


CREATE TABLE `ar_telephone_prefix`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`prefix` VARCHAR(255)  NOT NULL,
	`name` VARCHAR(255),
	`geographic_location` VARCHAR(255),
	`operator_type` VARCHAR(255),
	PRIMARY KEY (`id`),
	UNIQUE KEY `ar_telephone_prefix_prefix_unique` (`prefix`),
	KEY `ar_telephone_prefix_operator_type_index`(`operator_type`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_problem
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_problem`;


CREATE TABLE `ar_problem`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`created_at` DATETIME,
	`duplication_key` VARCHAR(255)  NOT NULL,
	`description` TEXT,
	`effect` TEXT,
	`proposed_solution` TEXT,
	`user_notes` TEXT,
	`mantain` INTEGER,
	`signaled_to_admin` INTEGER default 0 NOT NULL,
	PRIMARY KEY (`id`),
	KEY `ar_problem_duplication_key_index`(`duplication_key`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_job_queue
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_job_queue`;


CREATE TABLE `ar_job_queue`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`is_part_of` INTEGER(11)  NOT NULL,
	`state` INTEGER(1) default 0 NOT NULL,
	`created_at` DATETIME,
	`start_at` DATETIME,
	`end_at` DATETIME,
	`description` VARCHAR(12000)  NOT NULL,
	`php_data_job_serialization` LONGTEXT,
	PRIMARY KEY (`id`),
	KEY `ar_job_queue_is_part_of_index`(`is_part_of`),
	KEY `ar_job_queue_state_index`(`state`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_custom_rate_form
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_custom_rate_form`;


CREATE TABLE `ar_custom_rate_form`
(
	`id` INTEGER(20)  NOT NULL,
	PRIMARY KEY (`id`),
	KEY `ar_custom_rate_form_id_index`(`id`),
	CONSTRAINT `ar_custom_rate_form_FK_1`
		FOREIGN KEY (`id`)
		REFERENCES `ar_rate` (`id`)
		ON DELETE CASCADE
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_lock
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_lock`;


CREATE TABLE `ar_lock`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` CHAR(255)  NOT NULL,
	`time` DATETIME,
	`info` VARCHAR(255),
	PRIMARY KEY (`id`),
	KEY `ar_lock_name_index`(`name`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_database_version
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_database_version`;


CREATE TABLE `ar_database_version`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`version` VARCHAR(255),
	`installation_date` DATETIME,
	PRIMARY KEY (`id`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_asterisk_account_range
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_asterisk_account_range`;


CREATE TABLE `ar_asterisk_account_range`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`ar_office_id` INTEGER,
	`system_prefix` VARCHAR(255),
	`system_suffix` VARCHAR(255),
	`system_start_range` VARCHAR(18)  NOT NULL,
	`system_end_range` VARCHAR(18)  NOT NULL,
	`system_leading_zero` INTEGER(4)  NOT NULL,
	`is_delete` INTEGER default 0 NOT NULL,
	`is_physical_delete` INTEGER default 0 NOT NULL,
	`user_prefix` VARCHAR(255),
	`user_suffix` VARCHAR(255),
	`user_start_range` VARCHAR(18)  NOT NULL,
	`generate_range_for_users` INTEGER default 1 NOT NULL,
	`user_leading_zero` INTEGER(4)  NOT NULL,
	`user_note` VARCHAR(6048),
	PRIMARY KEY (`id`),
	INDEX `ar_asterisk_account_range_FI_1` (`ar_office_id`),
	CONSTRAINT `ar_asterisk_account_range_FK_1`
		FOREIGN KEY (`ar_office_id`)
		REFERENCES `ar_office` (`id`)
)Engine=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_document
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_document`;


CREATE TABLE `ar_document`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`ar_party_id` INTEGER,
	`document_name` VARCHAR(128),
	`document_date` DATE,
	`document` LONGBLOB,
	`mime_type` VARCHAR(256),
	`already_opened` INTEGER default 0 NOT NULL,
	PRIMARY KEY (`id`),
	INDEX `ar_document_FI_1` (`ar_party_id`),
	CONSTRAINT `ar_document_FK_1`
		FOREIGN KEY (`ar_party_id`)
		REFERENCES `ar_party` (`id`)
)Engine=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
