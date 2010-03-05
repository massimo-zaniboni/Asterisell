
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
	`clid` VARCHAR(80)  NOT NULL,
	`src` VARCHAR(80)  NOT NULL,
	`dst` VARCHAR(80)  NOT NULL,
	`dcontext` VARCHAR(80)  NOT NULL,
	`channel` VARCHAR(80),
	`dstchannel` VARCHAR(80)  NOT NULL,
	`lastapp` VARCHAR(80)  NOT NULL,
	`lastdata` VARCHAR(80)  NOT NULL,
	`duration` INTEGER(11)  NOT NULL,
	`billsec` INTEGER(11)  NOT NULL,
	`disposition` VARCHAR(45)  NOT NULL,
	`amaflags` INTEGER(11)  NOT NULL,
	`accountcode` VARCHAR(30)  NOT NULL,
	`uniqueid` VARCHAR(32) default '' NOT NULL,
	`userfield` VARCHAR(255)  NOT NULL,
	`income_ar_rate_id` INTEGER(20) default null,
	`income` INTEGER(20) default null,
	`cost_ar_rate_id` INTEGER(20) default null,
	`vendor_id` INTEGER(20) default null,
	`cost` INTEGER(20) default null,
	`ar_telephone_prefix_id` INTEGER,
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	PRIMARY KEY (`id`),
	KEY `cdr_calldate_index`(`calldate`),
	KEY `cdr_channel_index`(`channel`),
	KEY `cdr_accountcode_index`(`accountcode`),
	KEY `cdr_uniqueid_index`(`uniqueid`),
	KEY `cdr_income_ar_rate_id_index`(`income_ar_rate_id`),
	KEY `cdr_income_index`(`income`),
	KEY `cdr_cost_ar_rate_id_index`(`cost_ar_rate_id`),
	KEY `cdr_vendor_id_index`(`vendor_id`),
	KEY `cdr_cost_index`(`cost`),
	CONSTRAINT `cdr_FK_1`
		FOREIGN KEY (`accountcode`)
		REFERENCES `ar_asterisk_account` (`account_code`),
	INDEX `cdr_FI_2` (`ar_telephone_prefix_id`),
	CONSTRAINT `cdr_FK_2`
		FOREIGN KEY (`ar_telephone_prefix_id`)
		REFERENCES `ar_telephone_prefix` (`id`),
	CONSTRAINT `cdr_to_income_rate_key`
		FOREIGN KEY (`income_ar_rate_id`)
		REFERENCES `ar_rate` (`id`),
	CONSTRAINT `cdr_to_cost_rate_key`
		FOREIGN KEY (`cost_ar_rate_id`)
		REFERENCES `ar_rate` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_asterisk_account
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_asterisk_account`;


CREATE TABLE `ar_asterisk_account`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(160),
	`account_code` VARCHAR(30)  NOT NULL,
	`ar_party_id` INTEGER,
	PRIMARY KEY (`id`),
	KEY `ar_asterisk_account_account_code_index`(`account_code`),
	INDEX `ar_asterisk_account_FI_1` (`ar_party_id`),
	CONSTRAINT `ar_asterisk_account_FK_1`
		FOREIGN KEY (`ar_party_id`)
		REFERENCES `ar_party` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_rate_category
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_rate_category`;


CREATE TABLE `ar_rate_category`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`name` VARCHAR(128),
	PRIMARY KEY (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_party
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_party`;


CREATE TABLE `ar_party`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`customer_or_vendor` VARCHAR(1),
	`name` VARCHAR(255),
	`external_crm_code` VARCHAR(40),
	`vat` VARCHAR(40),
	`legal_address` VARCHAR(60),
	`legal_city` VARCHAR(60),
	`legal_zipcode` VARCHAR(20),
	`legal_state_province` VARCHAR(60),
	`legal_country` VARCHAR(60),
	`email` VARCHAR(60),
	`phone` VARCHAR(60),
	`phone2` VARCHAR(60),
	`fax` VARCHAR(60),
	`ar_rate_category_id` INTEGER,
	`max_limit_30` INTEGER(20) default null,
	PRIMARY KEY (`id`),
	KEY `ar_party_max_limit_30_index`(`max_limit_30`),
	INDEX `ar_party_FI_1` (`ar_rate_category_id`),
	CONSTRAINT `ar_party_FK_1`
		FOREIGN KEY (`ar_rate_category_id`)
		REFERENCES `ar_rate_category` (`id`)
)Type=InnoDB;

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
	`ar_asterisk_account_id` INTEGER,
	`activate_at` DATE,
	`deactivate_at` DATE,
	PRIMARY KEY (`id`),
	KEY `ar_web_account_login_index`(`login`),
	INDEX `ar_web_account_FI_1` (`ar_party_id`),
	CONSTRAINT `ar_web_account_FK_1`
		FOREIGN KEY (`ar_party_id`)
		REFERENCES `ar_party` (`id`),
	INDEX `ar_web_account_FI_2` (`ar_asterisk_account_id`),
	CONSTRAINT `ar_web_account_FK_2`
		FOREIGN KEY (`ar_asterisk_account_id`)
		REFERENCES `ar_asterisk_account` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_invoice
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_invoice`;


CREATE TABLE `ar_invoice`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`ar_party_id` INTEGER,
	`nr` VARCHAR(20)  NOT NULL,
	`invoice_date` DATE,
	`ar_cdr_from` DATE,
	`ar_cdr_to` DATE,
	`total_without_tax` INTEGER(20) default null,
	`vat_perc` INTEGER(20) default null,
	`total_vat` INTEGER(20) default null,
	`total` INTEGER(20) default null,
	`html_details` TEXT,
	`txt_details` TEXT,
	`pdf_invoice` TEXT,
	`already_sent` INTEGER,
	PRIMARY KEY (`id`),
	KEY `ar_invoice_nr_index`(`nr`),
	KEY `ar_invoice_total_without_tax_index`(`total_without_tax`),
	KEY `ar_invoice_vat_perc_index`(`vat_perc`),
	KEY `ar_invoice_total_vat_index`(`total_vat`),
	KEY `ar_invoice_total_index`(`total`),
	KEY `ar_invoice_index_1`(`ar_party_id`),
	CONSTRAINT `ar_invoice_FK_1`
		FOREIGN KEY (`ar_party_id`)
		REFERENCES `ar_party` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_invoice_creation
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_invoice_creation`;


CREATE TABLE `ar_invoice_creation`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`first_nr` VARCHAR(20),
	`invoice_date` DATE,
	`ar_cdr_from` DATE,
	`ar_cdr_to` DATE,
	PRIMARY KEY (`id`),
	KEY `ar_invoice_creation_index_1`(`invoice_date`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_rate
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_rate`;


CREATE TABLE `ar_rate`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`is_exception` INTEGER default 0 NOT NULL,
	`ar_rate_category_id` INTEGER,
	`ar_party_id` INTEGER,
	`start_time` DATETIME  NOT NULL,
	`end_time` DATETIME,
	`php_class_serialization` LONGTEXT,
	`user_input` LONGTEXT,
	`note` TEXT,
	PRIMARY KEY (`id`),
	KEY `ar_rate_start_time_index`(`start_time`),
	KEY `ar_rate_index_1`(`ar_party_id`),
	INDEX `ar_rate_FI_1` (`ar_rate_category_id`),
	CONSTRAINT `ar_rate_FK_1`
		FOREIGN KEY (`ar_rate_category_id`)
		REFERENCES `ar_rate_category` (`id`),
	CONSTRAINT `ar_rate_FK_2`
		FOREIGN KEY (`ar_party_id`)
		REFERENCES `ar_party` (`id`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_telephone_prefix
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_telephone_prefix`;


CREATE TABLE `ar_telephone_prefix`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`prefix` VARCHAR(40)  NOT NULL,
	`name` VARCHAR(80),
	`geographic_location` VARCHAR(80),
	`operator_type` VARCHAR(80),
	PRIMARY KEY (`id`),
	UNIQUE KEY `ar_telephone_prefix_prefix_unique` (`prefix`),
	KEY `ar_telephone_prefix_operator_type_index`(`operator_type`)
)Type=InnoDB;

#-----------------------------------------------------------------------------
#-- ar_problem
#-----------------------------------------------------------------------------

DROP TABLE IF EXISTS `ar_problem`;


CREATE TABLE `ar_problem`
(
	`id` INTEGER  NOT NULL AUTO_INCREMENT,
	`created_at` DATETIME,
	`duplication_key` VARCHAR(160)  NOT NULL,
	`description` TEXT,
	`effect` TEXT,
	`proposed_solution` TEXT,
	`user_notes` TEXT,
	`mantain` INTEGER,
	`signaled_to_admin` INTEGER default 0 NOT NULL,
	PRIMARY KEY (`id`),
	KEY `ar_problem_duplication_key_index`(`duplication_key`)
)Type=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
