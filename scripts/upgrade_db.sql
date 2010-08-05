alter table ar_params modify column vat_tax_perc integer(20) not null default 0;
alter table ar_params add `logo_image_in_invoices` VARCHAR(120);
alter table ar_params add `invoice_notes` VARCHAR(2048);
alter table ar_params add `invoice_payment_terms` VARCHAR(2048);
alter table ar_params add `current_invoice_nr` INTEGER(11) default 1 NOT NULL;
alter table ar_params drop column`pdf_call_report`;
alter table ar_invoice add `pdf_call_report` LONGBLOB;
alter table ar_invoice_creation add `ar_params_id` INTEGER;
ALTER TABLE ar_invoice_creation ADD (KEY `ar_invoice_creation_FI_1` (`ar_params_id`), CONSTRAINT `ar_invoice_creation_FK_1` FOREIGN KEY (`ar_params_id`) REFERENCES `ar_params` (`id`));
