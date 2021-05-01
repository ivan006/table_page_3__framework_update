CREATE TABLE `OSR_new_dates` (
`﻿id` int(11) ,
`date_from` text ,
`date_to` text
) ENGINE = InnoDB;

CREATE TABLE `OSR_new_dates2` (
`id` int(11) NOT NULL PRIMARY KEY ,
`date_from` datetime ,
`date_to` datetime
) ENGINE = InnoDB;

CREATE TABLE `how_currency_accounting_codes` (
`id` int(11) NOT NULL PRIMARY KEY ,
`name` varchar(256) NOT NULL ,
`description` text NOT NULL ,
`code` int(11) NOT NULL ,
`status` tinyint(4) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_currency_accounts_bank` (
`id` mediumint(9) NOT NULL auto_increment PRIMARY KEY ,
`name` varchar(64) NOT NULL ,
`position` mediumint(4) 0 NOT NULL ,
`status` tinyint(1) 1 NOT NULL ,
`bank_name` varchar(64) NOT NULL ,
`bank_branch` varchar(255) NOT NULL ,
`bank_branch_code` varchar(255) NOT NULL ,
`bank_town` varchar(255) NOT NULL ,
`bank_account_number` varchar(255) NOT NULL ,
`bank_account_name` varchar(255) NOT NULL ,
`bank_account_type` varchar(255) NOT NULL ,
`entity_type` varchar(255) NOT NULL ,
`entity_id` bigint(20) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_currency_accounts_bank_misc` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`bank_account_id` int(11) NOT NULL ,
`currency_id` int(11) ,
`tax_registered` tinyint(1) ,
`tax_rating` varchar(45) ,
`terms_day` int(11) ,
`terms_type_id` int(11) ,
`deposit_terms` tinyint(1) ,
`deposit_amount` float ,
`deposit_percentage` float ,
`deposit_due_days` int(11) ,
`default_currency` tinyint(1) NOT NULL ,
`deposit_terms_type_id` int(11) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_currency_accounts_credit_card` (
`id` mediumint(9) NOT NULL PRIMARY KEY ,
`name_on_card` varchar(255) NOT NULL ,
`expiry_month` varchar(10) NOT NULL ,
`expiry_year` int(4) NOT NULL ,
`masked_credit_card_num` bigint(16) NOT NULL ,
`credit_card_token` varchar(50) NOT NULL ,
`entity_type` varchar(255) NOT NULL ,
`entity_id` bigint(20) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_currency_countries` (
`id` int(11) NOT NULL PRIMARY KEY ,
`country_id` char(2) NOT NULL ,
`currency_name` varchar(32) NOT NULL ,
`conversion_co` int(5) NOT NULL ,
`comment` varchar(32) NOT NULL ,
`currency_symbol` varchar(15) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_currency_customers` (
`id` int(11) NOT NULL PRIMARY KEY ,
`customer_id` varchar(256) NOT NULL ,
`entity_type` int(11) 2 NOT NULL ,
`entity_id` int(11) NOT NULL ,
`bank_id` varchar(256) ,
`credit_id` varchar(256)
) ENGINE = InnoDB;

CREATE TABLE `how_currency_expenditure` (
`id` mediumint(9) NOT NULL PRIMARY KEY ,
`payment_date` varchar(32) NOT NULL ,
`entry_date` varchar(32) NOT NULL ,
`payment_method` mediumint(9) 1 NOT NULL ,
`currency_id` int(5) 1 NOT NULL ,
`amount` decimal(10,2) 0.00 NOT NULL ,
`plus_tax` double(10,2) 0.00 NOT NULL ,
`comment` text ,
`comment_internal` text ,
`user_id` mediumint(9) ,
`attachment` varchar(255) ,
`entity_type` int(5) 3 NOT NULL ,
`entity_id` bigint(20) 0 NOT NULL ,
`payee_entity_type` int(5) 3 NOT NULL ,
`payee_entity_id` bigint(20) 3 NOT NULL ,
`invoice_id` mediumint(9) 0 NOT NULL ,
`accounting_code` int(11) 3 NOT NULL ,
`status` enum('1','0') 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_currency_income` (
`id` mediumint(9) NOT NULL PRIMARY KEY ,
`payment_date` varchar(32) NOT NULL ,
`entry_date` varchar(32) NOT NULL ,
`payment_method` mediumint(9) 1 NOT NULL ,
`currency_id` int(5) 1 NOT NULL ,
`amount` decimal(10,2) 0.00 NOT NULL ,
`plus_tax` decimal(10,2) 0.00 NOT NULL ,
`comment` text NOT NULL ,
`comment_internal` text NOT NULL ,
`user_id` mediumint(9) ,
`attachment` varchar(255) ,
`entity_type` int(5) 3 NOT NULL ,
`entity_id` bigint(20) NOT NULL ,
`payee_entity_type` int(5) 3 NOT NULL ,
`payee_entity_id` bigint(20) NOT NULL ,
`invoice_id` mediumint(9) 0 NOT NULL ,
`accounting_code` int(11) 4 NOT NULL ,
`status` enum('1','0') 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_currency_invoices` (
`id` mediumint(9) NOT NULL PRIMARY KEY ,
`invoice_date` varchar(32) NOT NULL ,
`due_date` varchar(32) NOT NULL ,
`amount` decimal(10,2) 0.00 NOT NULL ,
`discount` decimal(10,2) 0.00 NOT NULL ,
`plus_tax` decimal(10,2) 0.00 NOT NULL ,
`currency_id` int(5) 1 NOT NULL ,
`payment_method` int(1) 0 NOT NULL ,
`comments` text NOT NULL ,
`comment_internal` text NOT NULL ,
`quote_id` mediumint(9) 0 NOT NULL ,
`entity_type` tinyint(255) NOT NULL ,
`entity_id` bigint(20) 0 NOT NULL ,
`invoicer_entity_type` tinyint(255) NOT NULL ,
`invoicer_entity_id` bigint(20) NOT NULL ,
`sent` tinyint(4) 0 NOT NULL ,
`status` tinyint(4) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_currency_invoices_items` (
`id` mediumint(9) NOT NULL PRIMARY KEY ,
`invoice_id` mediumint(12) 0 NOT NULL ,
`product_id` mediumint(12) 0 NOT NULL ,
`quantity` decimal(12,2) 0.00 NOT NULL ,
`amount` float 0 NOT NULL ,
`discount` decimal(12,2) 0.00 NOT NULL ,
`comments` varchar(128) NOT NULL ,
`status` tinyint(4) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_currency_invoices_queue` (
`id` bigint(20) NOT NULL PRIMARY KEY ,
`person_id` int(11) NOT NULL ,
`queued_date` timestamp current_timestamp() NOT NULL ,
`type` varchar(4) html NOT NULL ,
`sender` varchar(255) NOT NULL ,
`processed` enum('N','Y') N NOT NULL ,
`processed_date` timestamp ,
`invoice_body_html` text NOT NULL ,
`invoice_pdf_path` varchar(256) NOT NULL ,
`invoice_id` int(11) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_currency_payment_gateway_traffic` (
`id` int(11) NOT NULL PRIMARY KEY ,
`batch_id` varchar(128) NOT NULL ,
`payment_gateway_id` int(11) NOT NULL ,
`payee_entity_type` int(11) NOT NULL ,
`payee_entity_id` int(11) NOT NULL ,
`payer_entity_type` int(11) NOT NULL ,
`payer_entity_id` int(11) NOT NULL ,
`currency_id` int(11) 1 NOT NULL ,
`amount` double(10,2) NOT NULL ,
`gateway_response` text ,
`gateway_response_time` timestamp current_timestamp() NOT NULL ,
`comments` text
) ENGINE = InnoDB;

CREATE TABLE `how_currency_payment_methods` (
`id` int(11) NOT NULL PRIMARY KEY ,
`payment_type_name` varchar(128) NOT NULL ,
`payment_type_description` varchar(256) NOT NULL ,
`admin_only` tinyint(4) NOT NULL ,
`status` tinyint(4) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_currency_payment_terms` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`name` varchar(100) ,
`description` varchar(200) ,
`status` tinyint(4) 1
) ENGINE = InnoDB;

CREATE TABLE `how_currency_pos_settings` (
`id` int(11) NOT NULL PRIMARY KEY ,
`product_requirements` text NOT NULL ,
`logistics_include` tinyint(1) 0 NOT NULL ,
`payment_methods` varchar(50) NOT NULL ,
`api` varchar(50) NOT NULL ,
`api_public_key` varchar(512) NOT NULL ,
`api_secret_key` varchar(512) NOT NULL ,
`api_userId` varchar(512) NOT NULL ,
`api_channel` varchar(512) NOT NULL ,
`api_channel_recurring` varchar(512) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_currency_settings` (
`id` int(11) NOT NULL PRIMARY KEY ,
`value_name` varchar(256) NOT NULL ,
`value` text NOT NULL ,
`entity_type` int(11) ,
`entity_id` int(11)
) ENGINE = InnoDB;

CREATE TABLE `how_currency_settings_1` (
`id` smallint(6) NOT NULL PRIMARY KEY ,
`name` varchar(255) NOT NULL ,
`description` text NOT NULL ,
`status` tinyint(4) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_currency_settings_links` (
`id` smallint(6) NOT NULL PRIMARY KEY ,
`currency_setting_id` smallint(6) NOT NULL ,
`value` text NOT NULL ,
`entity_type` smallint(6) 3 NOT NULL ,
`entity_id` smallint(6) NOT NULL ,
`status` tinyint(4) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_currency_tax_rating_types` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`name` varchar(255) NOT NULL ,
`description` varchar(255) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_rates` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`what_rates_policies_id` int(11) ,
`rate_type` char(2) ,
`rate_category` char(3) ,
`age_category` char(2) ,
`price_pxb1` decimal(16,4) ,
`price_pxb2` decimal(16,4) ,
`price_pxb3` decimal(16,4) ,
`price_pxb4` decimal(16,4) ,
`price_pxb5` decimal(16,4) ,
`price_pxb6` decimal(16,4) ,
`price_pxb7` decimal(16,4) ,
`ex1` decimal(16,4) ,
`ex2` decimal(16,4) ,
`ex3` decimal(16,4) ,
`ex4` decimal(16,4) ,
`ex5` decimal(16,4) ,
`ss` decimal(16,4) ,
`tr` decimal(16,4) ,
`qr` decimal(16,4) ,
`add_adult1` decimal(16,4) ,
`tw` decimal(16,4) ,
`std_ext` char(1) ,
`pax_age_min` int(11) ,
`pax_age_max` int(11)
) ENGINE = InnoDB;

CREATE TABLE `how_rates_all` (
`osr_id` int(11) ,
`rate_type` char(2) ,
`rate_category` char(3) ,
`age_category` char(2) ,
`price_pxb1` decimal(16,4) ,
`price_pxb2` decimal(16,4) ,
`price_pxb3` decimal(16,4) ,
`price_pxb4` decimal(16,4) ,
`price_pxb5` decimal(16,4) ,
`price_pxb6` decimal(16,4) ,
`price_pxb7` decimal(16,4) ,
`ex1` decimal(16,4) ,
`ex2` decimal(16,4) ,
`ex3` decimal(16,4) ,
`ex4` decimal(16,4) ,
`ex5` decimal(16,4) ,
`ss` decimal(16,4) ,
`tr` decimal(16,4) ,
`qr` decimal(16,4) ,
`add_adult1` decimal(16,4) ,
`tw` decimal(16,4) ,
`std_ext` char(1) ,
`pax_age_min` int(11) ,
`pax_age_max` int(11) ,
`opd_id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`how_rates_policies_id` int(11)
) ENGINE = InnoDB;

CREATE TABLE `how_rates_duplicate` (
`osr_id` int(11) ,
`rate_type` char(2) ,
`rate_category` char(3) ,
`age_category` char(2) ,
`price_pxb1` decimal(16,4) ,
`price_pxb2` decimal(16,4) ,
`price_pxb3` decimal(16,4) ,
`price_pxb4` decimal(16,4) ,
`price_pxb5` decimal(16,4) ,
`price_pxb6` decimal(16,4) ,
`price_pxb7` decimal(16,4) ,
`ex1` decimal(16,4) ,
`ex2` decimal(16,4) ,
`ex3` decimal(16,4) ,
`ex4` decimal(16,4) ,
`ex5` decimal(16,4) ,
`ss` decimal(16,4) ,
`tr` decimal(16,4) ,
`qr` decimal(16,4) ,
`add_adult1` decimal(16,4) ,
`tw` decimal(16,4) ,
`std_ext` char(1) ,
`pax_age_min` int(11) ,
`pax_age_max` int(11) ,
`opd_id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`how_rates_policies_id` int(11)
) ENGINE = InnoDB;

CREATE TABLE `how_rates_policies` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`product_id` int(11) NOT NULL ,
`price_code` char(2) NOT NULL ,
`date_from` datetime NOT NULL ,
`date_to` datetime NOT NULL ,
`fixed_count` int(11) NOT NULL ,
`stay_type` varchar(20) NOT NULL ,
`sale_from` datetime NOT NULL ,
`sale_to` datetime NOT NULL ,
`rate_text` varchar(60) NOT NULL ,
`min_scu` int(11) NOT NULL ,
`max_scu` int(11) NOT NULL ,
`commissionable` char(1) NOT NULL ,
`comm_oride` decimal(8,4) NOT NULL ,
`prov` char(1) NOT NULL ,
`prefer` int(11) NOT NULL ,
`gross_nett` char(1) NOT NULL ,
`sell_code` char(1) NOT NULL ,
`buy_currency` char(3) NOT NULL ,
`sell_currency` char(3) NOT NULL ,
`apply_mon` bit(1) NOT NULL ,
`apply_tue` bit(1) NOT NULL ,
`apply_wed` bit(1) NOT NULL ,
`apply_thu` bit(1) NOT NULL ,
`apply_fri` bit(1) NOT NULL ,
`apply_sat` bit(1) NOT NULL ,
`apply_sun` bit(1) NOT NULL ,
`staypay_from` datetime NOT NULL ,
`staypay_to` datetime NOT NULL ,
`repeat_ind` char(1) NOT NULL ,
`repeat_times` int(11) NOT NULL ,
`stay1` int(11) NOT NULL ,
`free1` int(11) NOT NULL ,
`stay2` int(11) NOT NULL ,
`free2` int(11) NOT NULL ,
`stay3` int(11) NOT NULL ,
`free3` int(11) NOT NULL ,
`stay4` int(11) NOT NULL ,
`free4` int(11) NOT NULL ,
`stay5` int(11) NOT NULL ,
`free5` int(11) NOT NULL ,
`stay6` int(11) NOT NULL ,
`free6` int(11) NOT NULL ,
`stay7` int(11) NOT NULL ,
`free7` int(11) NOT NULL ,
`stay8` int(11) NOT NULL ,
`free8` int(11) NOT NULL ,
`stay9` int(11) NOT NULL ,
`free9` int(11) NOT NULL ,
`stay10` int(11) NOT NULL ,
`free10` int(11) NOT NULL ,
`vtext1` varchar(60) NOT NULL ,
`vtext2` varchar(60) NOT NULL ,
`vtext3` varchar(60) NOT NULL ,
`vtext4` varchar(60) NOT NULL ,
`vtext5` varchar(60) NOT NULL ,
`vtext6` varchar(60) NOT NULL ,
`vtext7` varchar(60) NOT NULL ,
`vtext8` varchar(60) NOT NULL ,
`vtext9` varchar(60) NOT NULL ,
`vtext10` varchar(60) NOT NULL ,
`editvtext1` bit(1) NOT NULL ,
`editvtext2` bit(1) NOT NULL ,
`editvtext3` bit(1) NOT NULL ,
`editvtext4` bit(1) NOT NULL ,
`editvtext5` bit(1) NOT NULL ,
`editvtext6` bit(1) NOT NULL ,
`editvtext7` bit(1) NOT NULL ,
`editvtext8` bit(1) NOT NULL ,
`editvtext9` bit(1) NOT NULL ,
`editvtext10` bit(1) NOT NULL ,
`splitrate` char(1) NOT NULL ,
`validate_min_max` bit(1) NOT NULL ,
`cancel_hours` int(11) NOT NULL ,
`exchange_mut_rate` decimal(16,8) NOT NULL ,
`exchange_div_rate` decimal(16,8) NOT NULL ,
`chargeextra1` bit(1) NOT NULL ,
`chargeextra2` bit(1) NOT NULL ,
`chargeextra3` bit(1) NOT NULL ,
`chargeextra4` bit(1) NOT NULL ,
`chargeextra5` bit(1) NOT NULL ,
`sellbeforetravel` int(11) NOT NULL ,
`sellbeforetype` char(1) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_rates_policies_duplicate` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`osr_id` int(11) NOT NULL ,
`product_id` int(11) ,
`price_code` char(2) ,
`date_from` datetime ,
`date_to` datetime ,
`fixed_count` int(11) ,
`stay_type` varchar(20) ,
`sale_from` datetime ,
`sale_to` datetime ,
`rate_text` varchar(60) ,
`min_scu` int(11) ,
`max_scu` int(11) ,
`commissionable` char(1) ,
`comm_oride` decimal(8,4) ,
`prov` char(1) ,
`prefer` int(11) ,
`gross_nett` char(1) ,
`sell_code` char(1) ,
`buy_currency` char(3) ,
`sell_currency` char(3) ,
`apply_mon` bit(1) ,
`apply_tue` bit(1) ,
`apply_wed` bit(1) ,
`apply_thu` bit(1) ,
`apply_fri` bit(1) ,
`apply_sat` bit(1) ,
`apply_sun` bit(1) ,
`staypay_from` datetime ,
`staypay_to` datetime ,
`repeat_ind` char(1) ,
`repeat_times` int(11) ,
`stay1` int(11) ,
`free1` int(11) ,
`stay2` int(11) ,
`free2` int(11) ,
`stay3` int(11) ,
`free3` int(11) ,
`stay4` int(11) ,
`free4` int(11) ,
`stay5` int(11) ,
`free5` int(11) ,
`stay6` int(11) ,
`free6` int(11) ,
`stay7` int(11) ,
`free7` int(11) ,
`stay8` int(11) ,
`free8` int(11) ,
`stay9` int(11) ,
`free9` int(11) ,
`stay10` int(11) ,
`free10` int(11) ,
`vtext1` varchar(60) ,
`vtext2` varchar(60) ,
`vtext3` varchar(60) ,
`vtext4` varchar(60) ,
`vtext5` varchar(60) ,
`vtext6` varchar(60) ,
`vtext7` varchar(60) ,
`vtext8` varchar(60) ,
`vtext9` varchar(60) ,
`vtext10` varchar(60) ,
`editvtext1` bit(1) ,
`editvtext2` bit(1) ,
`editvtext3` bit(1) ,
`editvtext4` bit(1) ,
`editvtext5` bit(1) ,
`editvtext6` bit(1) ,
`editvtext7` bit(1) ,
`editvtext8` bit(1) ,
`editvtext9` bit(1) ,
`editvtext10` bit(1) ,
`splitrate` char(1) ,
`validate_min_max` bit(1) ,
`cancel_hours` int(11) ,
`exchange_mut_rate` decimal(16,8) ,
`exchange_div_rate` decimal(16,8) ,
`chargeextra1` bit(1) ,
`chargeextra2` bit(1) ,
`chargeextra3` bit(1) ,
`chargeextra4` bit(1) ,
`chargeextra5` bit(1) ,
`sellbeforetravel` int(11) ,
`sellbeforetype` char(1)
) ENGINE = InnoDB;

CREATE TABLE `how_rates_policies_tp_osr_links` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`how_rates_policies_id` int(11) ,
`tp_osr_id` int(11)
) ENGINE = InnoDB;

CREATE TABLE `how_system_activity_log` (
`id` mediumint(9) NOT NULL auto_increment PRIMARY KEY ,
`activity_type_id` int(9) ,
`activity_description` text NOT NULL ,
`entity_type` mediumint(9) 0 NOT NULL ,
`entity_id` int(11) NOT NULL ,
`date_creation` timestamp current_timestamp() NOT NULL ,
`ip_address` varchar(24) NOT NULL ,
`table_row_id` int(11) NOT NULL ,
`deeplink` varchar(512) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_system_activity_types` (
`id` mediumint(9) NOT NULL PRIMARY KEY ,
`activity_type_name` varchar(64) NOT NULL ,
`activity_type_description` varchar(256) NOT NULL ,
`activity_type_group` varchar(64) NOT NULL ,
`icon_vector` varchar(255) NOT NULL ,
`icon_colour` varchar(6) 9B8686 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_system_components` (
`id` int(11) NOT NULL PRIMARY KEY ,
`name` varchar(255) NOT NULL ,
`description` text NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_system_controller_actions` (
`id` int(11) NOT NULL PRIMARY KEY ,
`name` varchar(25) NOT NULL ,
`description` text NOT NULL ,
`controller_id` int(11) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_system_dashboard_menus` (
`id` int(11) NOT NULL PRIMARY KEY ,
`theme` varchar(64) NOT NULL ,
`type` varchar(64) side_bar_menu NOT NULL ,
`menu_group` varchar(64) NOT NULL ,
`menu_sub_group` varchar(64) NOT NULL ,
`name` varchar(255) NOT NULL ,
`description` text ,
`url` varchar(255) ,
`background_colour` varchar(7) #666666 NOT NULL ,
`icon_vector` varchar(255) NOT NULL ,
`icon_colour` varchar(8) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_system_entity_types` (
`id` int(11) NOT NULL PRIMARY KEY ,
`entity_type` varchar(12) NOT NULL ,
`description` varchar(255) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_system_input_types` (
`id` int(11) NOT NULL PRIMARY KEY ,
`type` varchar(100) NOT NULL ,
`description` text NOT NULL ,
`status` tinyint(1) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_system_languages` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`code` varchar(3) ,
`name` varchar(100) ,
`status` int(11) 1
) ENGINE = InnoDB;

CREATE TABLE `how_system_menus` (
`id` int(11) NOT NULL PRIMARY KEY ,
`title` varchar(255) NOT NULL ,
`required` tinyint(1) 0 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_system_menus_items` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`type` varchar(25) NOT NULL ,
`entry_id` int(11) ,
`title` varchar(100) ,
`url` varchar(255) ,
`tag_id` varchar(255) ,
`class` varchar(255) ,
`target` varchar(50) ,
`parent_id` int(11) 0 NOT NULL ,
`navigation_id` int(11) NOT NULL ,
`subnav_visibility` enum('show','current_trail','hide') show ,
`hide` tinyint(1) 0 NOT NULL ,
`disable_current` tinyint(1) 0 NOT NULL ,
`disable_current_trail` tinyint(1) 0 NOT NULL ,
`sort` int(11) 0 NOT NULL ,
`icon_vector` varchar(255) fa fa-globe NOT NULL ,
`icon_colour` varchar(7) #0072FF NOT NULL ,
`description` varchar(256) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_system_module_controllers` (
`id` int(11) NOT NULL PRIMARY KEY ,
`name` varchar(255) NOT NULL ,
`description` text NOT NULL ,
`module_id` int(11) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_system_modules` (
`id` int(11) NOT NULL PRIMARY KEY ,
`name` varchar(255) NOT NULL ,
`component_id` int(11) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_system_notes` (
`id` mediumint(9) NOT NULL PRIMARY KEY ,
`note_type_id` int(9) ,
`note_content` varchar(1024) NOT NULL ,
`created_by_entity_type` mediumint(9) 0 NOT NULL ,
`created_by_entity_id` int(11) NOT NULL ,
`created_for_entity_type` mediumint(9) NOT NULL ,
`created_for_entity_id` int(11) NOT NULL ,
`attachment_url` varchar(255) ,
`attachment_original_filename` varchar(255) ,
`date_creation` timestamp current_timestamp() NOT NULL ,
`ip_address` varchar(24) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_system_notifications` (
`id` int(11) NOT NULL PRIMARY KEY ,
`date` datetime NOT NULL ,
`type` int(11) NOT NULL ,
`domain_id` int(11) ,
`user_id` int(11) NOT NULL ,
`org_id` int(11) ,
`status` varchar(125) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_system_notifications_types` (
`id` int(11) NOT NULL PRIMARY KEY ,
`name` varchar(125) NOT NULL ,
`group_id` int(11) NOT NULL ,
`domain_id` int(11) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_system_permissions` (
`id` int(11) NOT NULL PRIMARY KEY ,
`role_id` int(11) NOT NULL ,
`action_id` int(11) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_system_reports` (
`id` int(10) NOT NULL auto_increment PRIMARY KEY ,
`name` varchar(255) NOT NULL ,
`description` varchar(255) NOT NULL ,
`status` varchar(255) NOT NULL ,
`link_slug` varchar(255) NOT NULL ,
`type` varchar(255) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_system_settings` (
`id` int(11) NOT NULL PRIMARY KEY ,
`slug` varchar(50) NOT NULL ,
`value` varchar(255) NOT NULL ,
`module` varchar(50)
) ENGINE = InnoDB;

CREATE TABLE `how_system_snippets` (
`id` int(11) NOT NULL PRIMARY KEY ,
`title` varchar(50) NOT NULL ,
`snippet` text ,
`short_name` varchar(50) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_system_tickets` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`user_id` int(11) ,
`ticket_number` varchar(45) ,
`page_url` varchar(200) ,
`ticket_type` varchar(100) ,
`status` varchar(45) ,
`priority` varchar(20) ,
`subject` varchar(200) ,
`comments` text ,
`related_reference_number` varchar(45) ,
`date_created` datetime
) ENGINE = InnoDB;

CREATE TABLE `how_system_tickets_attachments` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`ticket_id` int(11) ,
`date_created` varchar(45) ,
`data` mediumblob ,
`name` varchar(200) ,
`mime_type` varchar(45)
) ENGINE = InnoDB;

CREATE TABLE `how_system_tickets_comments` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`ticket_id` int(11) ,
`user_id` int(11) ,
`order` int(11) ,
`comment` text ,
`date_created` datetime
) ENGINE = InnoDB;

CREATE TABLE `how_system_users` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`person_id` int(11) NOT NULL ,
`org_id` smallint(6) ,
`email` varchar(100) NOT NULL ,
`password` varchar(60) NOT NULL ,
`token` varchar(60) NOT NULL ,
`homepage_id` mediumint(9) 0 NOT NULL ,
`group_id` int(11) NOT NULL ,
`enabled` tinyint(1) 1 NOT NULL ,
`activated` tinyint(1) 1 NOT NULL ,
`activation_code` varchar(32) ,
`status` tinyint(1) 1 NOT NULL ,
`profile_picture` varchar(200) assets/files/images_user_profiles/Default.png NOT NULL ,
`last_login` datetime ,
`created_date` datetime ,
`ip_address` varchar(24)
) ENGINE = InnoDB;

CREATE TABLE `how_system_users_domains` (
`id` bigint(20) NOT NULL PRIMARY KEY ,
`user_id` bigint(20) 0 NOT NULL ,
`domain_id` bigint(20) 0 NOT NULL ,
`default_domain` enum('no','yes') no NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_system_users_roles` (
`id` int(11) NOT NULL PRIMARY KEY ,
`name` varchar(50) NOT NULL ,
`type` varchar(15) NOT NULL ,
`permissions` text ,
`required` tinyint(1) 0 NOT NULL ,
`modifiable_permissions` tinyint(1) 1 NOT NULL ,
`homepage_url` varchar(256) /my-dashboard/welcome NOT NULL ,
`private_theme_access` tinyint(1) 0 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_system_users_roles_links` (
`id` int(11) NOT NULL PRIMARY KEY ,
`role_id` int(11) NOT NULL ,
`person_id` int(11) NOT NULL ,
`notes` varchar(1024) NOT NULL ,
`status` tinyint(1) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_system_users_roles_menu_items_links` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`role_id` int(11) ,
`menu_item_id` int(11) ,
`status` int(11) 0
) ENGINE = InnoDB;

CREATE TABLE `how_system_users_tourplan_agent_links` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`user_id` int(11) ,
`agent` varchar(45)
) ENGINE = InnoDB;

CREATE TABLE `how_system_users_tourplan_user_links` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`user_id` int(11) ,
`tourplan_initials` varchar(45)
) ENGINE = InnoDB;

CREATE TABLE `how_system_views_custom` (
`id` int(11) NOT NULL PRIMARY KEY ,
`screen_name` varchar(256) NOT NULL ,
`path` varchar(512) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_system_widgets` (
`id` int(64) NOT NULL PRIMARY KEY ,
`type_id` mediumint(9) 0 NOT NULL ,
`widget_name` varchar(64) NOT NULL ,
`description` text NOT NULL ,
`view` text NOT NULL ,
`instantiator` text NOT NULL ,
`icon_colour` varchar(6) NOT NULL ,
`icon_vector` varchar(255) NOT NULL ,
`status` tinyint(1) 0 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `how_system_widgets_types` (
`id` mediumint(9) NOT NULL PRIMARY KEY ,
`name` varchar(64) NOT NULL ,
`description` varchar(255) NOT NULL ,
`icon_vector` varchar(255) fa fa-bars NOT NULL ,
`icon_colour` varchar(6) CCCCCC NOT NULL ,
`position` tinyint(4) 0 NOT NULL ,
`status` tinyint(1) 0 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_bookings` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`party_name` varchar(200) ,
`unit_id` int(11) NOT NULL ,
`itinerary_id` int(11) NOT NULL ,
`booking_status` varchar(100) ,
`booking_reference` varchar(25) NOT NULL ,
`travel_date` datetime NOT NULL ,
`departure_date` datetime NOT NULL ,
`agent` varchar(25) NOT NULL ,
`created_by` int(11) ,
`date_created` datetime ,
`budget` int(11) ,
`notes` text ,
`status` varchar(25) NOT NULL ,
`is_package` bit(1)
) ENGINE = InnoDB;

CREATE TABLE `what_bookings_costing` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`booking_id` int(11) ,
`total_cost` decimal(10,4) ,
`total_sell` decimal(10,4) ,
`total_retail` decimal(10,4) ,
`total_agent` decimal(10,4) ,
`markup_override_amount` decimal(10,4) ,
`markup_override_percentage` decimal(10,4) ,
`markup_override_reason` varchar(200) ,
`markup_override_reason_text` varchar(400) ,
`markup_override_total_retail` decimal(10,4) ,
`created_by` int(11) ,
`date_created` datetime ,
`updated_by` int(11) ,
`date_updated` datetime
) ENGINE = InnoDB;

CREATE TABLE `what_bookings_itineraries` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`day` int(11) ,
`sequence` int(11) ,
`service_type` varchar(45) ,
`service_description` text ,
`booking_id` int(11) NOT NULL ,
`product_id` int(11) NOT NULL ,
`supplier_id` int(11) ,
`pick_up_date` datetime NOT NULL ,
`pick_up_location` varchar(200) ,
`drop_off_date` datetime ,
`drop_off_location` varchar(200) ,
`status` varchar(45) ,
`price_code` varchar(45) ,
`remarks` varchar(400) ,
`reservation_number` varchar(100) ,
`created_by` int(11) ,
`created_date` datetime ,
`updated_by` int(11) ,
`updated_date` datetime
) ENGINE = InnoDB;

CREATE TABLE `what_bookings_itineraries_costing` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`itinerary_id` int(11) ,
`total_pax` int(11) ,
`fcu_quantity` int(11) ,
`scu_quantity` int(11) ,
`description` varchar(300) ,
`cost_price` decimal(10,4) ,
`sell_price` decimal(10,4) ,
`retail_price` decimal(10,4) ,
`agent_price` decimal(10,4) ,
`is_group_cost` bit(1) ,
`discount` decimal(10,4) ,
`status` tinyint(4) 1 ,
`total_cost` decimal(10,4) ,
`total_sell` decimal(10,4)
) ENGINE = InnoDB;

CREATE TABLE `what_bookings_itineraries_costing_breakdown` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`itinerary_costing_id` int(11) ,
`room_id` int(11) ,
`pax_id` int(11) ,
`status` tinyint(4) 1
) ENGINE = InnoDB;

CREATE TABLE `what_bookings_itineraries_costing_override` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`itinerary_id` int(11) ,
`cost_override_reason` varchar(100) ,
`cost_override_reason_text` text ,
`field_type` varchar(100) ,
`new_value` decimal(10,4) ,
`old_value` decimal(10,4) ,
`created_by` int(11) ,
`date_created` datetime ,
`updated_by` int(11) ,
`date_updated` datetime
) ENGINE = InnoDB;

CREATE TABLE `what_bookings_itineraries_extra` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`itinerary_id` int(11) ,
`name` varchar(300) ,
`extra_column_id` varchar(10) ,
`charge_type` char(1) ,
`charge_description` varchar(300) ,
`total_pax` int(11) ,
`cost_price` decimal(10,4) ,
`sell_price` decimal(10,4) ,
`total_cost` decimal(10,4) ,
`total_sell` decimal(10,4) ,
`created_by` int(11) ,
`date_created` datetime ,
`updated_by` int(11) ,
`date_updated` datetime ,
`status` tinyint(4) 1
) ENGINE = InnoDB;

CREATE TABLE `what_bookings_itineraries_extra_override` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`itinerary_id` int(11) ,
`extra_id` int(11) ,
`cost_override_reason` varchar(100) ,
`cost_override_reason_text` text ,
`field_type` varchar(100) ,
`new_value` decimal(10,4) ,
`old_value` decimal(10,4) ,
`created_by` int(11) ,
`date_created` datetime ,
`updated_by` int(11) ,
`date_updated` datetime
) ENGINE = InnoDB;

CREATE TABLE `what_bookings_itineraries_pax_config` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`booking_itineraries_id` int(11) ,
`itineraries_costing_id` int(11) ,
`link` int(11) ,
`pax_config_id` int(11) ,
`adult_count` int(11) ,
`child_count` int(11) ,
`child_share_count` int(11) ,
`infant_count` int(11) ,
`room_type` varchar(100) ,
`status` tinyint(4) 1
) ENGINE = InnoDB;

CREATE TABLE `what_bookings_pax_config` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`booking_id` int(11) ,
`party_name` varchar(200) ,
`adults` int(11) ,
`children` int(11) ,
`infants` int(11) ,
`single_rooms` int(11) ,
`double_rooms` int(11) ,
`triple_rooms` int(11) ,
`family_rooms` int(11) ,
`created_by` int(11) ,
`date_created` datetime ,
`status` int(11)
) ENGINE = InnoDB;

CREATE TABLE `what_bookings_rooms` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`booking_id` int(11) ,
`room_name` varchar(100) ,
`room_type` varchar(45) ,
`adults` int(11) ,
`children` int(11) ,
`infants` int(11) ,
`created_by` int(11) ,
`date_created` datetime ,
`updated_by` int(11) ,
`updated_date` datetime ,
`status` int(11) 1
) ENGINE = InnoDB;

CREATE TABLE `what_bookings_rooms_pax` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`booking_id` int(11) ,
`room_id` int(11) ,
`person_id` int(11) ,
`name` varchar(200) ,
`type` varchar(45) ,
`age` int(11) ,
`notes` text ,
`created_by` int(11) ,
`date_created` datetime ,
`updated_by` int(11) ,
`updated_date` datetime
) ENGINE = InnoDB;

CREATE TABLE `what_bookings_statuses` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`code` varchar(45) ,
`description` varchar(100)
) ENGINE = InnoDB;

CREATE TABLE `what_bookings_units` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`pax_config_id` int(11) NOT NULL ,
`person_id` int(11) NOT NULL ,
`status` int(11)
) ENGINE = InnoDB;

CREATE TABLE `what_packages` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`package_name` varchar(200) ,
`package_status` varchar(100) ,
`valid_from_date` datetime NOT NULL ,
`valid_to_date` datetime NOT NULL ,
`agent` varchar(25) NOT NULL ,
`price_code` varchar(45) ,
`markup_percentage` decimal(10,4) 0.0000 ,
`package_start_date` datetime ,
`package_end_date` datetime ,
`notes` text ,
`created_by` int(11) ,
`date_created` datetime ,
`updated_by` int(11) ,
`date_updated` datetime ,
`status` varchar(25)
) ENGINE = InnoDB;

CREATE TABLE `what_packages_costing` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`package_id` int(11) ,
`total_cost` decimal(10,4) ,
`total_sell` decimal(10,4) ,
`total_retail` decimal(10,4) ,
`total_agent` decimal(10,4) ,
`markup_override_amount` decimal(10,4) ,
`markup_override_percentage` decimal(10,4) ,
`markup_override_reason` varchar(200) ,
`markup_override_reason_text` varchar(400) ,
`markup_override_total_retail` decimal(10,4) ,
`created_by` int(11) ,
`date_created` datetime ,
`updated_by` int(11) ,
`date_updated` datetime
) ENGINE = InnoDB;

CREATE TABLE `what_packages_itineraries` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`day` int(11) ,
`sequence` int(11) ,
`package_id` varchar(45) ,
`service_type` varchar(45) ,
`service_description` text ,
`product_id` int(11) NOT NULL ,
`supplier_id` int(11) ,
`pick_up_date` datetime NOT NULL ,
`pick_up_location` varchar(200) ,
`drop_off_date` datetime ,
`drop_off_location` varchar(200) ,
`status` varchar(45) ,
`price_code` varchar(45) ,
`remarks` varchar(400) ,
`created_by` int(11) ,
`created_date` datetime ,
`updated_by` int(11) ,
`updated_date` datetime
) ENGINE = InnoDB;

CREATE TABLE `what_packages_itineraries_costing` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`itinerary_id` int(11) ,
`total_pax` int(11) ,
`fcu_quantity` int(11) ,
`scu_quantity` int(11) ,
`description` varchar(300) ,
`cost_price` decimal(10,4) ,
`sell_price` decimal(10,4) ,
`retail_price` decimal(10,4) ,
`agent_price` decimal(10,4) ,
`is_group_cost` bit(1) ,
`discount` decimal(10,4) ,
`status` tinyint(4) 1 ,
`total_cost` decimal(10,4) ,
`total_sell` decimal(10,4)
) ENGINE = InnoDB;

CREATE TABLE `what_packages_itineraries_costing_breakdown` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`itinerary_costing_id` int(11) ,
`room_id` int(11) ,
`pax_id` int(11) ,
`status` tinyint(4) 1
) ENGINE = InnoDB;

CREATE TABLE `what_packages_itineraries_costing_override` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`itinerary_id` int(11) ,
`cost_override_reason` varchar(100) ,
`cost_override_reason_text` text ,
`field_type` varchar(100) ,
`new_value` decimal(10,4) ,
`old_value` decimal(10,4) ,
`created_by` int(11) ,
`date_created` datetime ,
`updated_by` int(11) ,
`date_updated` datetime
) ENGINE = InnoDB;

CREATE TABLE `what_packages_pax_config` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`booking_id` int(11) ,
`party_name` varchar(200) ,
`adults` int(11) ,
`children` int(11) ,
`infants` int(11) ,
`single_rooms` int(11) ,
`double_rooms` int(11) ,
`triple_rooms` int(11) ,
`family_rooms` int(11) ,
`created_by` int(11) ,
`date_created` datetime ,
`status` int(11)
) ENGINE = InnoDB;

CREATE TABLE `what_packages_rooms` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`package_id` int(11) ,
`room_name` varchar(100) ,
`room_type` varchar(45) ,
`adults` int(11) ,
`children` int(11) ,
`infants` int(11) ,
`created_by` int(11) ,
`date_created` datetime ,
`updated_by` int(11) ,
`updated_date` datetime ,
`status` int(11) 1
) ENGINE = InnoDB;

CREATE TABLE `what_packages_rooms_pax` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`package_id` int(11) ,
`room_id` int(11) ,
`person_id` int(11) ,
`name` varchar(200) ,
`type` varchar(45) ,
`age` int(11) ,
`notes` text ,
`created_by` int(11) ,
`date_created` datetime ,
`updated_by` int(11) ,
`updated_date` datetime
) ENGINE = InnoDB;

CREATE TABLE `what_product_policies` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`start_monday` tinyint(1) 1 ,
`start_tuesday` tinyint(1) 1 ,
`start_wednesday` tinyint(1) 1 ,
`start_thursday` tinyint(1) 1 ,
`start_friday` tinyint(1) 1 ,
`start_saturday` tinyint(1) 1 ,
`start_sunday` tinyint(1) 1 ,
`include_monday` tinyint(1) 0 ,
`include_tuesday` tinyint(1) 0 ,
`include_wednesday` tinyint(1) 0 ,
`include_thursday` tinyint(1) 0 ,
`include_friday` tinyint(1) 0 ,
`include_saturday` tinyint(1) 0 ,
`include_sunday` tinyint(1) 0 ,
`single_max` int(11) 0 ,
`twin_max` int(11) 0 ,
`double_max` int(11) 0 ,
`triple_max` int(11) 0 ,
`family_max` int(11) ,
`other_max` int(11) ,
`infant_from` int(11) ,
`infant_to` int(11) ,
`child_from` int(11) ,
`child_to` int(11) ,
`adult_from` int(11) ,
`adult_to` int(11) ,
`cross_season_type` int(11) ,
`single_available` tinyint(1) 1 ,
`single_adult_max` int(11) ,
`twin_available` tinyint(1) 1 ,
`twin_adult_max` int(11) ,
`double_available` tinyint(1) 1 ,
`double_adult_max` int(11) ,
`triple_available` tinyint(1) 0 ,
`triple_adult_max` int(11) ,
`family_available` tinyint(1) 0 ,
`family_adult_max` int(11) ,
`other_available` tinyint(1) 0 ,
`other_adult_max` int(11) ,
`peak_supplements` text ,
`cancellation_policy` text ,
`override` tinyint(1) ,
`created_by` int(11) ,
`date_created` datetime ,
`updated_by` int(11) ,
`date_updated` datetime ,
`status` int(11) 1
) ENGINE = InnoDB;

CREATE TABLE `what_production_events_fields` (
`id` int(11) NOT NULL PRIMARY KEY ,
`label` varchar(150) NOT NULL ,
`type_id` int(11) NOT NULL ,
`status` tinyint(1) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_production_events_logs` (
`id` int(11) NOT NULL PRIMARY KEY ,
`event_type_id` int(11) NOT NULL ,
`production_process_id` int(11) NOT NULL ,
`production_item_id` int(11) NOT NULL ,
`date_created` datetime NOT NULL ,
`status` int(11) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_production_events_types` (
`id` int(11) NOT NULL PRIMARY KEY ,
`name` varchar(100) NOT NULL ,
`description` text NOT NULL ,
`status` tinyint(1) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_production_events_types_fields` (
`id` int(11) NOT NULL PRIMARY KEY ,
`events_types_id` int(11) NOT NULL ,
`events_fields_id` int(11) NOT NULL ,
`status` tinyint(1) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_production_events_types_links` (
`id` int(11) NOT NULL PRIMARY KEY ,
`process_id` int(11) NOT NULL ,
`events_types_id` int(11) NOT NULL ,
`position` int(11) NOT NULL ,
`status` tinyint(1) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_production_events_values` (
`id` int(11) NOT NULL PRIMARY KEY ,
`events_logs_id` int(11) NOT NULL ,
`events_fields_id` int(11) NOT NULL ,
`value` varchar(2000) NOT NULL ,
`status` int(11) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_production_groups` (
`id` int(11) NOT NULL PRIMARY KEY ,
`name` varchar(100) NOT NULL ,
`description` text NOT NULL ,
`process_id` int(11) NOT NULL ,
`colour` varchar(30) #ffffff NOT NULL ,
`status` tinyint(1) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_production_groups_items` (
`id` int(11) NOT NULL PRIMARY KEY ,
`group_id` int(11) NOT NULL ,
`item_id` int(11) NOT NULL ,
`position` int(11) NOT NULL ,
`status` tinyint(1) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_production_items_1` (
`id` int(11) NOT NULL PRIMARY KEY ,
`product_id` int(11) NOT NULL ,
`stock_entry_id` int(11) NOT NULL ,
`id_code` varchar(100) NOT NULL ,
`birth_date` date ,
`gender` varchar(1) NOT NULL ,
`weight` int(11) NOT NULL ,
`comments` text NOT NULL ,
`status` tinyint(1) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_production_items_1_weight` (
`id` int(11) NOT NULL PRIMARY KEY ,
`product_id` int(11) NOT NULL ,
`weight` decimal(8,2) NOT NULL ,
`weigh_date` date NOT NULL ,
`status` int(11) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_production_items_2` (
`id` int(11) NOT NULL PRIMARY KEY ,
`product_id` int(11) NOT NULL ,
`stock_entry_id` int(11) NOT NULL ,
`id_code` varchar(100) NOT NULL ,
`birth_date` date ,
`gender` varchar(1) NOT NULL ,
`weight` int(11) NOT NULL ,
`comments` text NOT NULL ,
`status` tinyint(1) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_production_items_places` (
`id` int(11) NOT NULL PRIMARY KEY ,
`process_id` int(11) NOT NULL ,
`item_id` int(11) NOT NULL ,
`group_id` int(11) ,
`place_id` int(11) NOT NULL ,
`time_arrival` datetime NOT NULL ,
`time_departure` datetime
) ENGINE = InnoDB;

CREATE TABLE `what_production_processes` (
`id` int(11) NOT NULL PRIMARY KEY ,
`name` varchar(100) NOT NULL ,
`description` text NOT NULL ,
`status` tinyint(1) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_production_products_processes` (
`id` int(11) NOT NULL PRIMARY KEY ,
`product_id` int(11) NOT NULL ,
`process_id` int(11) NOT NULL ,
`status` tinyint(1) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_production_report_charts` (
`id` int(11) NOT NULL PRIMARY KEY ,
`report_id` int(11) ,
`name` varchar(100) ,
`type` varchar(45) ,
`chart_order` int(11)
) ENGINE = InnoDB;

CREATE TABLE `what_production_report_groups` (
`id` int(11) NOT NULL PRIMARY KEY ,
`name` varchar(45) ,
`visible` tinyint(4) ,
`group_order` int(11)
) ENGINE = InnoDB;

CREATE TABLE `what_production_report_settings` (
`id` int(11) NOT NULL PRIMARY KEY ,
`report_id` varchar(45) ,
`name` varchar(100) ,
`value` varchar(200)
) ENGINE = InnoDB;

CREATE TABLE `what_production_reports` (
`id` int(11) NOT NULL PRIMARY KEY ,
`name` varchar(100) ,
`last_run_by` varchar(100) ,
`last_run_date` datetime ,
`report_group_id` int(11) ,
`report_order` int(11)
) ENGINE = InnoDB;

CREATE TABLE `what_production_stock` (
`id` int(11) NOT NULL PRIMARY KEY ,
`product_id` mediumint(9) NOT NULL ,
`quantity` smallint(6) NOT NULL ,
`date_received` date 0000-00-00 ,
`date_supplied` date 0000-00-00 ,
`recipient_entity_type` tinyint(4) ,
`recipient_entity_id` mediumint(9) ,
`supplier_entity_type` tinyint(4) ,
`supplier_entity_id` mediumint(9) ,
`delivery_code` varchar(256) ,
`serial_number` varchar(256) ,
`batch_id` varchar(256) ,
`comments` text NOT NULL ,
`current_total` int(11) NOT NULL ,
`process_id` int(11) 0 NOT NULL ,
`status` tinyint(4) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_production_stock_recipe_ingredients` (
`id` int(11) NOT NULL PRIMARY KEY ,
`recipe_id` int(11) NOT NULL ,
`product_id` int(11) NOT NULL ,
`quantity` decimal(10,3) 0.000 NOT NULL ,
`unit_measurement` smallint(6) 0 NOT NULL ,
`status` tinyint(4) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_production_stock_recipes` (
`id` int(11) NOT NULL PRIMARY KEY ,
`product_id` int(11) NOT NULL ,
`entity_type` tinyint(4) NOT NULL ,
`entity_id` smallint(6) NOT NULL ,
`status` tinyint(4) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_products` (
`id` mediumint(9) NOT NULL auto_increment PRIMARY KEY ,
`name` varchar(64) NOT NULL ,
`description` text NOT NULL ,
`unit_measures` mediumint(9) 1 NOT NULL ,
`dimensions` varchar(15) NOT NULL ,
`packshot_small` varchar(255) default_thumbnail.jpg NOT NULL ,
`packshot_large` varchar(255) NOT NULL ,
`price` decimal(10,2) 0.00 NOT NULL ,
`code` varchar(255) NOT NULL ,
`barcode` varchar(128) ,
`status` tinyint(1) 1 NOT NULL ,
`position` mediumint(4) 0 NOT NULL ,
`taxable` tinyint(1) 1 NOT NULL ,
`entity_id` bigint(9) 0 NOT NULL ,
`entity_type` tinyint(255) NOT NULL ,
`product_type_id` mediumint(9) 0 ,
`product_range_id` int(11) 0 NOT NULL ,
`rating` varchar(45)
) ENGINE = InnoDB;

CREATE TABLE `what_products_1_departments` (
`id` mediumint(9) NOT NULL PRIMARY KEY ,
`name` varchar(64) NOT NULL ,
`position` float 0 NOT NULL ,
`status` tinyint(1) 1 NOT NULL ,
`description` text ,
`icon_vector` varchar(255) fa fa-cube NOT NULL ,
`icon_colour` varchar(10) DA6C2A NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_products_2_aisles` (
`id` mediumint(9) NOT NULL PRIMARY KEY ,
`name` varchar(64) NOT NULL ,
`description` varchar(255) NOT NULL ,
`icon_bitmap` varchar(255) ,
`icon_vector` varchar(255) fa fa-shopping-cart NOT NULL ,
`icon_colour` varchar(10) EA925D NOT NULL ,
`position` float 0 NOT NULL ,
`status` tinyint(1) 1 NOT NULL ,
`department` mediumint(9)
) ENGINE = InnoDB;

CREATE TABLE `what_products_3_shelves` (
`id` mediumint(9) NOT NULL auto_increment PRIMARY KEY ,
`name` varchar(64) NOT NULL ,
`description` varchar(255) NOT NULL ,
`icon_bitmap` varchar(255) ,
`icon_vector` varchar(255) fa fa-bars NOT NULL ,
`icon_colour` varchar(10) FB9457 NOT NULL ,
`product_type_id` mediumint(9) ,
`position` float 0 NOT NULL ,
`status` tinyint(1) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_products_4_ranges` (
`id` int(11) NOT NULL PRIMARY KEY ,
`org_id` int(11) NOT NULL ,
`range_name` varchar(255) NOT NULL ,
`status` tinyint(4) 1 NOT NULL ,
`icon` varchar(255) ,
`icon_colour` varchar(20) ,
`icon_vector` varchar(255)
) ENGINE = InnoDB;

CREATE TABLE `what_products_5_range_links` (
`product_id` int(11) ,
`range_id` int(11)
) ENGINE = InnoDB;

CREATE TABLE `what_products_certifications` (
`id` int(11) NOT NULL PRIMARY KEY ,
`name` varchar(64) NOT NULL ,
`description` text NOT NULL ,
`org_id` int(11) NOT NULL ,
`icon_bitmap` varchar(255) images/blank.gif NOT NULL ,
`position` mediumint(4) 0 NOT NULL ,
`status` tinyint(1) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_products_certifications_links` (
`id` bigint(20) NOT NULL PRIMARY KEY ,
`prod_id` bigint(20) 0 NOT NULL ,
`certification_id` mediumint(9) 0 NOT NULL ,
`date_created` varchar(20) ,
`status` int(11) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_products_dimensions` (
`id` smallint(6) NOT NULL PRIMARY KEY ,
`name` varchar(256) NOT NULL ,
`description` text NOT NULL ,
`status` tinyint(4) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_products_information` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`product_id` int(11) NOT NULL ,
`information` text ,
`information_dutch` text
) ENGINE = InnoDB;

CREATE TABLE `what_products_logistics` (
`id` bigint(20) NOT NULL PRIMARY KEY ,
`recurring_id` bigint(20) ,
`place_id` int(11) NOT NULL ,
`day_recurring` varchar(24) Tuesday ,
`time_recurring` varchar(64) ,
`date_once_off` varchar(64) ,
`time_once_off` varchar(64) ,
`invoice_id` int(11)
) ENGINE = InnoDB;

CREATE TABLE `what_products_logistics_delivery_status` (
`id` bigint(20) NOT NULL PRIMARY KEY ,
`recurring_id` bigint(20) NOT NULL ,
`delivery_date` varchar(255) NOT NULL ,
`delivery_time` varchar(64) NOT NULL ,
`order_status` enum('0','1') 0 NOT NULL ,
`note_id` int(11) 0 NOT NULL ,
`invoice_id` int(11)
) ENGINE = InnoDB;

CREATE TABLE `what_products_places` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`product_id` int(11) ,
`place_id` int(11)
) ENGINE = InnoDB;

CREATE TABLE `what_products_range_link` (
`id` int(11) NOT NULL PRIMARY KEY ,
`range_id` int(11) ,
`product_id` int(11)
) ENGINE = InnoDB;

CREATE TABLE `what_products_recurring` (
`id` bigint(20) NOT NULL PRIMARY KEY ,
`frequency` enum('Monthly','Every 3 Months','Every 6 Months') Monthly NOT NULL ,
`delivery_option` enum('Once A Week','Once Every Second Week','Once A Month') Once A Week NOT NULL ,
`start_date` date NOT NULL ,
`end_date` date ,
`payment_method` int(1) NOT NULL ,
`currency_id` tinyint(5) 1 NOT NULL ,
`entity_type` tinyint(4) NOT NULL ,
`entity_id` bigint(20) 0 NOT NULL ,
`invoicer_entity_type` tinyint(255) NOT NULL ,
`invoicer_entity_id` bigint(20) NOT NULL ,
`comments` text NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_products_recurring_links` (
`id` int(11) NOT NULL PRIMARY KEY ,
`recurring_id` int(11) NOT NULL ,
`product_id` int(11) NOT NULL ,
`product_quantity` int(11) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_products_tp_opt_links` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`product_id` int(11) ,
`tp_opt_id` int(11)
) ENGINE = InnoDB;

CREATE TABLE `what_system_dbsync_settings` (
`id` int(11) NOT NULL PRIMARY KEY ,
`name` varchar(100) NOT NULL ,
`value` varchar(200) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_table_result` (
`id` int(6) unsigned NOT NULL PRIMARY KEY ,
`folder` varchar(255) NOT NULL ,
`file` varchar(255) NOT NULL ,
`status` int(11) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `what_travelguide_permissions` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`booking_reference` varchar(45) ,
`password` varchar(60) ,
`date_created` datetime ,
`created_by` int(11) ,
`date_updated` datetime ,
`updated_by` int(11) ,
`status` tinyint(4) 1
) ENGINE = InnoDB;

CREATE TABLE `when_events` (
`id` int(11) NOT NULL PRIMARY KEY ,
`event_name` varchar(100) NOT NULL ,
`event_description` varchar(800) NOT NULL ,
`event_location_id` int(11) NOT NULL ,
`event_image` varchar(255) NOT NULL ,
`event_start` datetime NOT NULL ,
`event_end` datetime NOT NULL ,
`event_address` varchar(500) NOT NULL ,
`event_gps1` varchar(10) NOT NULL ,
`event_gps2` varchar(10) NOT NULL ,
`type_id` int(11) NOT NULL ,
`status` tinyint(4) 1
) ENGINE = InnoDB;

CREATE TABLE `when_events_types` (
`id` int(11) NOT NULL PRIMARY KEY ,
`name` varchar(45) NOT NULL ,
`color` varchar(20) NOT NULL ,
`status` tinyint(4) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `where_countries` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`code` char(3) NOT NULL PRIMARY KEY ,
`IdLanguage` int(10) unsigned 0 NOT NULL PRIMARY KEY ,
`name` varchar(140) NOT NULL ,
`currency_id` int(5) NOT NULL ,
`status` int(11) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `where_destinations` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`destination_name` varchar(128) NOT NULL ,
`destination_description` text NOT NULL ,
`destination_description_dutch` text
) ENGINE = InnoDB;

CREATE TABLE `where_destinations_locations` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`name` varchar(45) ,
`destination_id` int(11) ,
`description` text ,
`description_dutch` text
) ENGINE = InnoDB;

CREATE TABLE `where_destinations_locations_places` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`location_id` int(11) ,
`place_id` int(11)
) ENGINE = InnoDB;

CREATE TABLE `where_destinations_places` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`destination_id` int(11) ,
`place_id` int(11)
) ENGINE = InnoDB;

CREATE TABLE `where_destinations_tp_dst_links` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`destination_id` int(11) ,
`tp_code` varchar(45)
) ENGINE = InnoDB;

CREATE TABLE `where_excursions` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`excursion_name` varchar(100) ,
`destination_description` text
) ENGINE = InnoDB;

CREATE TABLE `where_places` (
`id` bigint(20) NOT NULL auto_increment PRIMARY KEY ,
`place_name` varchar(255) NOT NULL ,
`unit_number` varchar(20) NOT NULL ,
`street` varchar(255) NOT NULL ,
`suburb` varchar(128) NOT NULL ,
`town` varchar(255) NOT NULL ,
`region_id` int(11) NOT NULL ,
`country_id` int(11) NOT NULL ,
`latitude` double ,
`longitude` double NOT NULL ,
`status` tinyint(1) 1 NOT NULL ,
`postal_code` varchar(20) NOT NULL ,
`pobox` varchar(255) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `where_places_entities_links` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`place_id` int(11) NOT NULL ,
`entity_type` int(11) NOT NULL ,
`entity_id` int(11) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `where_places_suppliers` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`place_id` int(11) ,
`tp_supplier_code` varchar(45)
) ENGINE = InnoDB;

CREATE TABLE `where_places_types` (
`id` int(11) NOT NULL PRIMARY KEY ,
`place_type_name` varchar(64) Place Type Name NOT NULL ,
`place_type_description` varchar(1024) Place Type Description NOT NULL ,
`icon_vector` varchar(64) fa fa-building NOT NULL ,
`icon_colour` int(6) 333333 NOT NULL ,
`status` tinyint(4) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `where_places_types_links` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`place_id` int(11) NOT NULL ,
`place_type_id` int(11) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `where_regions` (
`id` bigint(20) NOT NULL PRIMARY KEY ,
`region_name` varchar(64) NOT NULL ,
`country_id` int(3) NOT NULL ,
`status` smallint(6) 0 NOT NULL ,
`position` int(11) 0 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_lists` (
`id` int(11) NOT NULL PRIMARY KEY ,
`name` varchar(256) NOT NULL ,
`description` text NOT NULL ,
`type` varchar(512) NOT NULL ,
`owner_id` int(11) NOT NULL ,
`owner_type` tinyint(4) NOT NULL ,
`source_file` varchar(256) NOT NULL ,
`status` tinyint(1) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_lists_field_types` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`name` varchar(100)
) ENGINE = InnoDB;

CREATE TABLE `who_lists_fields` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`code` varchar(5) NOT NULL ,
`field_type_id` int(11) ,
`name` varchar(256) NOT NULL ,
`icon` varchar(45) ,
`status` tinyint(1) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_lists_fields_lookups` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`field_id` int(11) ,
`lookup_table` varchar(100) ,
`lookup_column` varchar(100) ,
`lookup_values` mediumtext
) ENGINE = InnoDB;

CREATE TABLE `who_lists_modifiers` (
`id` int(11) NOT NULL PRIMARY KEY ,
`js_function_body` varchar(512) NOT NULL ,
`description` varchar(256) NOT NULL ,
`field_id` int(11) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_lists_roles` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`list_id` int(11) ,
`role_id` int(11) ,
`function_id` int(11)
) ENGINE = InnoDB;

CREATE TABLE `who_lists_values` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`list_id` int(11) NOT NULL ,
`row_id` int(11) NOT NULL ,
`entity_type` int(11) ,
`entity_id` int(11) ,
`field_id` int(11) NOT NULL ,
`value` varchar(512) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_orgs` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`org_name` varchar(255) NOT NULL ,
`org_type_legal` int(9) NOT NULL ,
`org_description` text ,
`tel_num` varchar(15) NOT NULL ,
`fax_num` varchar(15) NOT NULL ,
`cell_num` varchar(15) NOT NULL ,
`contact` varchar(64) NOT NULL ,
`email` varchar(64) ,
`contact_email` varchar(64) NOT NULL ,
`accounts_contact` varchar(64) NOT NULL ,
`accounts_email` varchar(64) NOT NULL ,
`logo_path` varchar(255) assets/files/images_orgs_logos/Default.png NOT NULL ,
`vat_num` varchar(64) NOT NULL ,
`status` tinyint(1) 1 NOT NULL ,
`website` varchar(256) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_orgs_alerts` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`org_id` int(11) ,
`message` text ,
`start_date` datetime ,
`end_date` datetime ,
`created_by` int(11) ,
`date_created` datetime ,
`updated_by` int(11) ,
`date_updated` datetime ,
`status` int(11) 1
) ENGINE = InnoDB;

CREATE TABLE `who_orgs_amenities` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`amenity_type` int(11) ,
`description` varchar(200) ,
`icon` varchar(100) ,
`status` int(11)
) ENGINE = InnoDB;

CREATE TABLE `who_orgs_amenities_links` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`org_id` int(11) NOT NULL ,
`amenity_id` int(11) ,
`other` varchar(250) ,
`status` int(11)
) ENGINE = InnoDB;

CREATE TABLE `who_orgs_amenities_types` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`name` varchar(100)
) ENGINE = InnoDB;

CREATE TABLE `who_orgs_application_status` (
`id` int(11) NOT NULL PRIMARY KEY ,
`status` varchar(125) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_orgs_chains` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`name` varchar(200) ,
`created_by` int(11) ,
`date_created` datetime ,
`updated_by` int(11) ,
`date_updated` datetime ,
`status` tinyint(4) 1
) ENGINE = InnoDB;

CREATE TABLE `who_orgs_close_out_dates` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`org_id` int(11) ,
`name` varchar(200) NOT NULL ,
`start_date` datetime ,
`end_date` datetime ,
`created_by` int(11) ,
`date_created` datetime ,
`updated_by` int(11) ,
`date_updated` datetime ,
`status` int(11) 1
) ENGINE = InnoDB;

CREATE TABLE `who_orgs_content` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`org_id` int(11) NOT NULL ,
`content_item_id` int(11) NOT NULL ,
`content_type` varchar(50) ,
`file_name` varchar(100) ,
`content_url` varchar(300) ,
`date_created` datetime ,
`created_by` varchar(45) ,
`status` int(11)
) ENGINE = InnoDB;

CREATE TABLE `who_orgs_domain_links` (
`id` tinyint(4) NOT NULL PRIMARY KEY ,
`domain_id` tinyint(4) NOT NULL ,
`org_id` smallint(4) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_orgs_external_systems` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`name` varchar(100) ,
`description` varchar(200) ,
`created_by` int(11) ,
`date_created` datetime ,
`updated_by` int(11) ,
`date_updated` datetime ,
`status` tinyint(4)
) ENGINE = InnoDB;

CREATE TABLE `who_orgs_external_systems_links` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`org_id` int(11) NOT NULL ,
`external_system_id` int(11) NOT NULL ,
`value` text NOT NULL ,
`created_by` int(11) NOT NULL ,
`date_created` datetime NOT NULL ,
`updated_by` int(11) ,
`date_updated` datetime ,
`status` tinyint(4)
) ENGINE = InnoDB;

CREATE TABLE `who_orgs_function_links` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`organisation_id` int(11) NOT NULL ,
`function_id` int(11) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_orgs_misc` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`org_id` int(11) NOT NULL ,
`supplier_code` varchar(10) ,
`is_master` tinyint(4) ,
`master_id` int(11) ,
`chain_id` int(11) ,
`language_id` int(11) ,
`tour_operator_id` int(11) ,
`account_number` varchar(50) ,
`emergency_number` varchar(50) ,
`star_grading` int(11) ,
`route_description` text ,
`route_description_dutch` text ,
`org_description_dutch` text ,
`destination_id` int(11) NOT NULL ,
`location_id` int(11) NOT NULL ,
`has_contract` tinyint(1) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_orgs_people_imports` (
`id` int(11) NOT NULL PRIMARY KEY ,
`organisation` varchar(100) NOT NULL ,
`category` varchar(100) NOT NULL ,
`last_name` varchar(100) NOT NULL ,
`first_name` varchar(100) NOT NULL ,
`mobile_number` varchar(100) NOT NULL ,
`telephone_number` varchar(100) NOT NULL ,
`fax_number` varchar(100) NOT NULL ,
`email_address` varchar(100) NOT NULL ,
`date_imported` timestamp current_timestamp() NOT NULL ,
`session_id` varchar(32) NOT NULL ,
`user_id` int(11) NOT NULL ,
`sanity` tinyint(1) NOT NULL ,
`org_id` int(11) ,
`person_id` int(11)
) ENGINE = InnoDB;

CREATE TABLE `who_orgs_price_codes` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`entity_id` int(11) ,
`price_code` varchar(5) ,
`sequence` int(11) ,
`tp_code` varchar(45)
) ENGINE = InnoDB;

CREATE TABLE `who_orgs_products_policies_links` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`org_id` int(11) NOT NULL ,
`policy_id` int(11) NOT NULL ,
`created_by` int(11) NOT NULL ,
`date_created` int(11) NOT NULL ,
`updated_by` int(11) ,
`date_updated` int(11) ,
`status` tinyint(4)
) ENGINE = InnoDB;

CREATE TABLE `who_orgs_settings` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`org_id` int(11) NOT NULL ,
`name` varchar(100) ,
`value` varchar(200)
) ENGINE = InnoDB;

CREATE TABLE `who_orgs_social_handlers` (
`id` smallint(5) unsigned NOT NULL PRIMARY KEY ,
`org_id` smallint(5) unsigned NOT NULL ,
`facebook` varchar(256) ,
`instagram` varchar(256) ,
`twitter` varchar(256) ,
`pinterest` varchar(256) NOT NULL ,
`youtube` varchar(256) ,
`status` tinyint(4) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_orgs_temp` (
`id` int(11) NOT NULL PRIMARY KEY ,
`org_name` varchar(255) NOT NULL ,
`org_type_legal` int(9) NOT NULL ,
`org_description` text NOT NULL ,
`tel_num` varchar(15) NOT NULL ,
`fax_num` varchar(15) NOT NULL ,
`cell_num` varchar(15) NOT NULL ,
`person_id` varchar(64) NOT NULL ,
`email` varchar(1024) NOT NULL ,
`accounts_contact` varchar(64) NOT NULL ,
`accounts_email` varchar(64) NOT NULL ,
`logo_path` varchar(255) NOT NULL ,
`vat_num` varchar(64) NOT NULL ,
`status` tinyint(1) NOT NULL ,
`user_id` mediumint(9) NOT NULL ,
`date_creation` date NOT NULL ,
`ip_address` varchar(24) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_orgs_tp_crm_links` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`org_id` int(11) ,
`tp_code` varchar(45)
) ENGINE = InnoDB;

CREATE TABLE `who_orgs_tp_drm_links` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`org_id` int(11) ,
`tp_code` varchar(45)
) ENGINE = InnoDB;

CREATE TABLE `who_orgs_type_function` (
`id` mediumint(9) NOT NULL PRIMARY KEY ,
`name` varchar(64) NOT NULL ,
`description` varchar(255) NOT NULL ,
`position` mediumint(4) 0 NOT NULL ,
`icon` varchar(255) NOT NULL ,
`icon_vector` varchar(256) fa fa-user NOT NULL ,
`icon_colour` varchar(7) #666666 NOT NULL ,
`status` tinyint(4) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_orgs_type_legal` (
`id` mediumint(9) NOT NULL PRIMARY KEY ,
`name` varchar(64) NOT NULL ,
`description` varchar(255) NOT NULL ,
`position` mediumint(4) 0 NOT NULL ,
`icon` varchar(255) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_orgs_where_places` (
`id` smallint(5) unsigned NOT NULL PRIMARY KEY ,
`org_id` smallint(5) unsigned ,
`place_id` smallint(5) unsigned
) ENGINE = InnoDB;

CREATE TABLE `who_people` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`title` varchar(64) NOT NULL ,
`first_name` varchar(255) NOT NULL ,
`last_name` varchar(255) NOT NULL ,
`phone` varchar(50) ,
`fax_num` varchar(50) ,
`cell_num` varchar(50) ,
`email` varchar(100) ,
`notes` varchar(1024) NOT NULL ,
`address` varchar(225) ,
`address2` varchar(100) ,
`city` varchar(100) ,
`state` varchar(100) ,
`zip` varchar(15) ,
`region_id` varchar(64) NOT NULL ,
`status` tinyint(1) 1 NOT NULL ,
`user_id` mediumint(9) ,
`date_creation` varchar(32) ,
`ip_address` varchar(24) ,
`gender` enum('male','female','unknown') unknown NOT NULL ,
`profile_picture` varchar(255) assets/files/images_people/Default.png NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_people_bookings` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`person_id` int(11) ,
`booking_reference` varchar(50) ,
`date_created` datetime ,
`created_by` int(11) ,
`updated_by` int(11) ,
`date_updated` datetime ,
`status` tinyint(4) 1
) ENGINE = InnoDB;

CREATE TABLE `who_people_browsing_history` (
`id` int(11) NOT NULL PRIMARY KEY ,
`person_id` int(11) ,
`url` text
) ENGINE = InnoDB;

CREATE TABLE `who_people_contact_details` (
`id` int(11) NOT NULL PRIMARY KEY ,
`person_id` int(11) NOT NULL ,
`contact_type` varchar(255) NOT NULL ,
`contact_details` varchar(255) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_people_destinations` (
`id` int(11) NOT NULL PRIMARY KEY ,
`person_id` int(11) NOT NULL ,
`destination` varchar(200) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_people_experiences` (
`id` int(11) NOT NULL PRIMARY KEY ,
`person_id` int(11) NOT NULL ,
`experience` varchar(200) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_people_flights` (
`id` int(11) NOT NULL PRIMARY KEY ,
`person_id` int(11) NOT NULL ,
`flights_booked` varchar(20) NOT NULL ,
`arrival_date` datetime ,
`nights` int(11) ,
`currency` varchar(200) NOT NULL ,
`budget` int(11) NOT NULL ,
`country` varchar(200) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_people_health_birth_departure` (
`id` int(11) NOT NULL PRIMARY KEY ,
`person_id` int(11) NOT NULL ,
`id_number` varchar(256) NOT NULL ,
`date_birth` date ,
`weight_birth` decimal(5,2) NOT NULL ,
`place_birth` varchar(256) NOT NULL ,
`date_departure` date ,
`cause_departure` text NOT NULL ,
`place_departure` varchar(256) NOT NULL ,
`user_id` int(11) NOT NULL ,
`date_creation` timestamp current_timestamp() NOT NULL ,
`status` tinyint(1) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_people_issues` (
`id` bigint(20) NOT NULL PRIMARY KEY ,
`issue_id` int(11) NOT NULL ,
`person_id` bigint(20) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_people_orgs` (
`id` bigint(20) NOT NULL auto_increment PRIMARY KEY ,
`person_id` bigint(20) 0 NOT NULL ,
`org_id` bigint(20) ,
`person_email` varchar(255) NOT NULL ,
`person_tel` varchar(255) NOT NULL ,
`status` tinyint(4) 1 NOT NULL ,
`start` timestamp current_timestamp() NOT NULL ,
`end` timestamp 0000-00-00 00:00:00 NOT NULL ,
`position_id` bigint(20) 0 NOT NULL ,
`position_adhoc` varchar(255) NOT NULL ,
`sort_order` tinyint(2) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_people_orgs_tp_pbk_links` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`person_id` int(11) ,
`tp_pbk_id` int(11)
) ENGINE = InnoDB;

CREATE TABLE `who_people_partners` (
`id` int(11) NOT NULL PRIMARY KEY ,
`person_id` int(11) NOT NULL ,
`partner_type` varchar(200) NOT NULL ,
`amount` int(11) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_people_people` (
`id` int(11) NOT NULL PRIMARY KEY ,
`type` tinyint(4) NOT NULL ,
`person_id` mediumint(9) NOT NULL ,
`other_person_id` mediumint(9) NOT NULL ,
`status` tinyint(4) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_people_people_types` (
`id` smallint(6) NOT NULL PRIMARY KEY ,
`type` varchar(512) NOT NULL ,
`person` varchar(512) NOT NULL ,
`other_person` varchar(512) NOT NULL ,
`status` tinyint(4) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `who_people_positions` (
`id` mediumint(9) NOT NULL PRIMARY KEY ,
`name` varchar(255) NOT NULL ,
`description` text NOT NULL ,
`position` mediumint(4) 0 NOT NULL ,
`status` tinyint(1) 1 NOT NULL ,
`icon_vector` varchar(256) fa fa-user NOT NULL ,
`icon_colour` varchar(7) #666666 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_builder_metadata` (
`id` int(11) NOT NULL PRIMARY KEY ,
`parent_id` int(11) ,
`key` varchar(255) NOT NULL ,
`value` mediumtext
) ENGINE = InnoDB;

CREATE TABLE `why_builder_page` (
`id` int(11) NOT NULL PRIMARY KEY ,
`domain_id` int(11) NOT NULL ,
`title` varchar(255) NOT NULL ,
`link` varchar(255) NOT NULL ,
`page_id` int(11) ,
`status` enum('published','draft') published NOT NULL ,
`author` int(11) NOT NULL ,
`seo_description` varchar(512) ,
`seo_keywords` varchar(512) ,
`created_date` timestamp current_timestamp() NOT NULL ,
`modify_date` timestamp 0000-00-00 00:00:00 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_builder_structure` (
`id` int(11) NOT NULL PRIMARY KEY ,
`domain_id` int(11) ,
`parent_id` int(11) ,
`type` enum('page','layout','widget','element','partial') page NOT NULL ,
`metadata_id` int(11) ,
`name` varchar(255) ,
`revision` int(11) 0 NOT NULL ,
`revision_of_id` int(11) ,
`order` int(11) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_builder_style` (
`id` int(11) NOT NULL PRIMARY KEY ,
`name` varchar(45) NOT NULL ,
`type` enum('id','class') class NOT NULL ,
`metadata_id` int(11) ,
`domain_id` int(11) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_campaigns` (
`id` int(11) NOT NULL PRIMARY KEY ,
`name` varchar(256) NOT NULL ,
`description` text NOT NULL ,
`entity_id` int(11) NOT NULL ,
`entity_type` tinyint(4) NOT NULL ,
`html` text NOT NULL ,
`design_background` varchar(256) NOT NULL ,
`sending_interval` tinyint(4) 0 NOT NULL ,
`batch_size` int(11) NOT NULL ,
`date_created` timestamp current_timestamp() NOT NULL ,
`last_edited` timestamp ,
`approval_status` tinyint(4) 0 NOT NULL ,
`status` tinyint(1) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_campaigns_batches` (
`id` int(11) NOT NULL PRIMARY KEY ,
`campaign_id` int(11) NOT NULL ,
`batch_size` int(11) NOT NULL ,
`merged` smallint(6) NOT NULL ,
`prep_start` timestamp ,
`prep_complete` timestamp ,
`send_date` timestamp ,
`sent_date` timestamp
) ENGINE = InnoDB;

CREATE TABLE `why_campaigns_lists_links` (
`id` int(11) NOT NULL PRIMARY KEY ,
`campaign_id` int(11) NOT NULL ,
`list_id` int(11) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_campaigns_logistics` (
`id` int(11) NOT NULL PRIMARY KEY ,
`campaign_id` int(11) NOT NULL ,
`sender_first_name` varchar(256) NOT NULL ,
`sender_last_name` varchar(256) NOT NULL ,
`letter_address` varchar(512) NOT NULL ,
`letter_address_2` varchar(512) NOT NULL ,
`letter_city` varchar(256) NOT NULL ,
`letter_state` varchar(256) NOT NULL ,
`letter_zip` varchar(256) NOT NULL ,
`letter_email` varchar(256) NOT NULL ,
`letter_phone` varchar(50) NOT NULL ,
`ship` tinyint(1) 0 NOT NULL ,
`shipping_address` text NOT NULL ,
`unstamped` tinyint(1) 0 NOT NULL ,
`special_requests` text NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_brand_guide` (
`id` int(11) NOT NULL PRIMARY KEY ,
`selector` varchar(120) NOT NULL ,
`label` varchar(64) NOT NULL ,
`selector_type` int(11) NOT NULL ,
`value` varchar(300) NOT NULL ,
`comments` tinytext ,
`name` varchar(45) NOT NULL ,
`display` varchar(45) ,
`domain_id` int(11) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_categories` (
`id` int(11) NOT NULL PRIMARY KEY ,
`category_group_id` int(11) NOT NULL ,
`parent_id` int(11) 0 NOT NULL ,
`title` varchar(255) NOT NULL ,
`url_title` varchar(255) NOT NULL ,
`description` text ,
`tag_id` varchar(255) ,
`class` varchar(255) ,
`target` varchar(50) ,
`subcategories_visibility` enum('show','current_trail','hide') show ,
`hide` tinyint(1) 0 NOT NULL ,
`sort` int(11) 0 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_categories_entries` (
`id` int(11) NOT NULL PRIMARY KEY ,
`category_id` int(11) NOT NULL ,
`entry_id` int(11) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_categories_groups` (
`id` int(11) NOT NULL PRIMARY KEY ,
`title` varchar(255) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_chats` (
`id` int(11) NOT NULL PRIMARY KEY ,
`chat_id` int(11) NOT NULL ,
`support_id` smallint(6) ,
`chat_name` varchar(50) NOT NULL ,
`message` varchar(500) NOT NULL ,
`time` timestamp current_timestamp() NOT NULL ,
`user_id` int(11) NOT NULL ,
`avatar_url` varchar(200) NOT NULL ,
`attachment_url` varchar(50) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_chats_groups` (
`id` int(11) NOT NULL PRIMARY KEY ,
`chat_topic` varchar(100) NOT NULL ,
`created_by` int(11) NOT NULL ,
`created_date` timestamp current_timestamp() NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_cta` (
`id` int(11) NOT NULL PRIMARY KEY ,
`cta_name` varchar(256) NOT NULL ,
`cta_message` varchar(256) NOT NULL ,
`cta_button` varchar(64) NOT NULL ,
`cta_url` varchar(256) NOT NULL ,
`cta_content_col_1` text NOT NULL ,
`cta_content_col_2_image` text NOT NULL ,
`cta_content_col_2` text NOT NULL ,
`cta_hero_image` varchar(1024) NOT NULL ,
`cta_custom_css` text NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_cta_relation` (
`id` int(11) NOT NULL PRIMARY KEY ,
`cta_id` int(11) NOT NULL ,
`cta_tag_id` int(11) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_cta_revisions` (
`id` int(11) NOT NULL PRIMARY KEY ,
`cta_id` int(11) ,
`author_id` varchar(45) ,
`revision_number` int(11) ,
`revision_date` varchar(45) ,
`cta_message` varchar(256) ,
`cta_button` varchar(64) ,
`cta_url` varchar(256) ,
`cta_content_col_1` text ,
`cta_content_col_2` text
) ENGINE = InnoDB;

CREATE TABLE `why_content_cta_tags` (
`id` int(11) NOT NULL PRIMARY KEY ,
`tag` varchar(255) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_databases` (
`id` int(11) NOT NULL PRIMARY KEY ,
`db_name` varchar(25) NOT NULL ,
`db_login` varchar(64) NOT NULL ,
`db_pass` varchar(32) NOT NULL ,
`status` tinyint(1) 1 NOT NULL ,
`db_server` varchar(255) NOT NULL ,
`db_port` varchar(10) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_domains` (
`id` int(11) NOT NULL PRIMARY KEY ,
`name` varchar(128) NOT NULL ,
`protocol` varchar(256) http NOT NULL ,
`db_name` varchar(25) NOT NULL ,
`db_login` varchar(64) NOT NULL ,
`db_passf` varchar(32) NOT NULL ,
`db_passw` varchar(32) NOT NULL ,
`db_passr` varchar(32) NOT NULL ,
`ftp_user` varchar(32) NOT NULL ,
`ftp_pass` varchar(32) NOT NULL ,
`dir` varchar(64) NOT NULL ,
`status` tinyint(1) 1 NOT NULL ,
`db_server` varchar(255) NOT NULL ,
`date_started` varchar(32) ,
`date_ended` varchar(32) RUNNING NOT NULL ,
`comments` text NOT NULL ,
`ftp_server` varchar(250) NOT NULL ,
`ftp_path` varchar(250) NOT NULL ,
`db_port` varchar(10) 3306 NOT NULL ,
`mail_host` varchar(256) ,
`mail_username` varchar(256) ,
`mail_password` varchar(256) ,
`mail_from` varchar(256) ,
`mail_from_name` varchar(256) ,
`entity_group` varchar(255) NOT NULL ,
`entity_id` bigint(20) NOT NULL ,
`icon_vector` varchar(255) fa fa-globe NOT NULL ,
`icon_colour` varchar(6) 526BA4 NOT NULL ,
`suffix` varchar(10) http NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_domains_users` (
`id` int(11) NOT NULL PRIMARY KEY ,
`domain_id` int(11) NOT NULL ,
`user_id` int(11) NOT NULL ,
`status` tinyint(4) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_galleries` (
`id` int(11) NOT NULL PRIMARY KEY ,
`title` varchar(100) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_galleries_files` (
`id` int(11) NOT NULL PRIMARY KEY ,
`title` varchar(100) NOT NULL ,
`filename` varchar(100) NOT NULL ,
`gallery_id` int(11) NOT NULL ,
`description` varchar(250) ,
`alt` varchar(250) ,
`hide` tinyint(1) 0 NOT NULL ,
`sort` int(11) 0 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_items` (
`id` bigint(20) NOT NULL auto_increment PRIMARY KEY ,
`item_content` text NOT NULL ,
`item_url` varchar(255) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_items_categories` (
`id` int(4) NOT NULL auto_increment PRIMARY KEY ,
`name` varchar(100) ,
`category_order` int(4) ,
`icon_bitmap` varchar(255) NOT NULL ,
`icon_bitmap_mouseover` varchar(256) NOT NULL ,
`icon_vector` varchar(255) NOT NULL ,
`icon_colour` varchar(7) NOT NULL ,
`upper_cat_id` int(11) NOT NULL ,
`position` int(11) NOT NULL ,
`status` tinyint(1) 1 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_items_categories_links` (
`id` int(4) NOT NULL auto_increment PRIMARY KEY ,
`item_id` int(4) ,
`category_id` int(4)
) ENGINE = InnoDB;

CREATE TABLE `why_content_items_files` (
`id` bigint(20) NOT NULL auto_increment PRIMARY KEY ,
`item_id` bigint(20) 0 NOT NULL ,
`file_name` varchar(255) NOT NULL ,
`file_name_original` varchar(255) NOT NULL ,
`file_description` varchar(255) NOT NULL ,
`file_type_id` bigint(20) 0 NOT NULL ,
`file_location` varchar(255) NOT NULL ,
`file_size` varchar(255) NOT NULL ,
`file_width` int(11) NOT NULL ,
`file_height` int(11) NOT NULL ,
`position` int(11) 0 NOT NULL ,
`status` smallint(6) 0 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_items_files_types` (
`id` bigint(20) NOT NULL PRIMARY KEY ,
`file_type_name` varchar(255) NOT NULL ,
`file_type_group_id` int(11) 0 NOT NULL ,
`icon_bitmap` varchar(255) NOT NULL ,
`icon_vector` varchar(255) NOT NULL ,
`icon_colour` varchar(6) NOT NULL ,
`value` varchar(255) NOT NULL ,
`position` int(11) 0 NOT NULL ,
`status` tinyint(1) 0 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_items_files_types_groups` (
`id` bigint(20) NOT NULL PRIMARY KEY ,
`name` varchar(255) NOT NULL ,
`status` smallint(6) 1 NOT NULL ,
`position` int(11) 0 NOT NULL ,
`icon_vector` varchar(255) fa fa-file NOT NULL ,
`icon_colour` varchar(6) CCCCCC NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_items_info_countries` (
`id` int(11) NOT NULL PRIMARY KEY ,
`id_why_content_item` int(11) NOT NULL ,
`insider_info` text NOT NULL ,
`when_to_travel` text NOT NULL ,
`getting_there` text NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_items_tags_domains` (
`id` bigint(20) NOT NULL PRIMARY KEY ,
`item_id` bigint(20) 0 NOT NULL ,
`domain_id` bigint(20) 0 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_items_tags_domains_pages` (
`id` bigint(20) NOT NULL PRIMARY KEY ,
`item_id` bigint(20) 0 NOT NULL ,
`page_id` bigint(20) 0 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_items_tags_prods_1` (
`id` bigint(20) NOT NULL PRIMARY KEY ,
`content_item_id` bigint(20) 0 NOT NULL ,
`department_id` bigint(20) 0 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_items_tags_topics` (
`id` bigint(20) NOT NULL PRIMARY KEY ,
`item_id` bigint(20) 0 NOT NULL ,
`topic_id` bigint(20) 0 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_menus` (
`id` int(11) NOT NULL PRIMARY KEY ,
`title` varchar(255) NOT NULL ,
`required` tinyint(1) 0 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_menus_items` (
`id` int(11) NOT NULL PRIMARY KEY ,
`type` varchar(25) NOT NULL ,
`entry_id` int(11) ,
`title` varchar(100) ,
`url` varchar(255) ,
`tag_id` varchar(255) ,
`class` varchar(255) ,
`target` varchar(50) ,
`parent_id` int(11) 0 NOT NULL ,
`navigation_id` int(11) NOT NULL ,
`subnav_visibility` enum('show','current_trail','hide') show ,
`hide` tinyint(1) 0 NOT NULL ,
`disable_current` tinyint(1) 0 NOT NULL ,
`disable_current_trail` tinyint(1) 0 NOT NULL ,
`sort` int(11) 0 NOT NULL ,
`icon_vector` varchar(255) fa fa-globe NOT NULL ,
`icon_colour` varchar(6) 0072FF NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_pages` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`title` varchar(100) NOT NULL ,
`slug` varchar(255) ,
`url_title` varchar(100) ,
`required` tinyint(1) 0 NOT NULL ,
`content_type_id` int(11) NOT NULL ,
`status` enum('published','draft') published NOT NULL ,
`meta_title` varchar(65) ,
`meta_description` text ,
`meta_keywords` text ,
`created_date` datetime ,
`modified_date` datetime ,
`author_id` int(11)
) ENGINE = InnoDB;

CREATE TABLE `why_content_pages_content` (
`id` int(11) NOT NULL PRIMARY KEY ,
`entry_id` int(11) NOT NULL ,
`field_id_1` text ,
`field_id_2` text ,
`field_id_3` text ,
`field_id_4` text
) ENGINE = InnoDB;

CREATE TABLE `why_content_pages_content_revisions` (
`id` int(11) NOT NULL PRIMARY KEY ,
`revision_resource_type_id` int(11) NOT NULL ,
`resource_id` int(11) NOT NULL ,
`content_type_id` int(11) ,
`author_id` int(11) NOT NULL ,
`author_name` varchar(150) NOT NULL ,
`revision_date` datetime NOT NULL ,
`revision_data` longtext NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_pages_content_revisions_types` (
`id` int(11) NOT NULL PRIMARY KEY ,
`name` varchar(50) NOT NULL ,
`key_name` varchar(50) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_pages_layout` (
`id` int(11) NOT NULL PRIMARY KEY ,
`content_type_id` int(11) NOT NULL ,
`content_field_type_id` int(11) NOT NULL ,
`label` varchar(50) NOT NULL ,
`short_tag` varchar(50) NOT NULL ,
`required` tinyint(1) 0 NOT NULL ,
`options` text ,
`settings` text ,
`sort` int(11) 0 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_pages_layout_types` (
`id` int(11) NOT NULL PRIMARY KEY ,
`title` varchar(50) NOT NULL ,
`model_name` varchar(50) NOT NULL ,
`datatype` varchar(50) text NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_symbols` (
`id` int(11) NOT NULL PRIMARY KEY ,
`symbol_name` varchar(128) NOT NULL ,
`symbol_type` varchar(128) NOT NULL ,
`symbol_path` text NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_types` (
`id` int(11) NOT NULL PRIMARY KEY ,
`title` varchar(255) NOT NULL ,
`short_name` varchar(50) NOT NULL ,
`layout` text ,
`page_head` text ,
`theme_layout` varchar(50) ,
`dynamic_route` varchar(255) ,
`required` tinyint(1) 0 NOT NULL ,
`access` tinyint(1) 0 NOT NULL ,
`restrict_to` text ,
`restrict_admin_access` tinyint(1) 0 NOT NULL ,
`enable_versioning` tinyint(1) 0 NOT NULL ,
`max_revisions` int(11) 0 NOT NULL ,
`entries_allowed` int(11) ,
`category_group_id` int(11)
) ENGINE = InnoDB;

CREATE TABLE `why_content_types_admin_groups` (
`id` int(11) NOT NULL PRIMARY KEY ,
`content_type_id` int(11) NOT NULL ,
`group_id` int(11) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_widgets` (
`id` int(64) NOT NULL PRIMARY KEY ,
`name` varchar(64) NOT NULL ,
`description` text NOT NULL ,
`code` text NOT NULL ,
`mod_code` varchar(25) ,
`img_path` varchar(255) NOT NULL ,
`type_id` mediumint(9) 0 NOT NULL ,
`constructor` text NOT NULL ,
`destructor` text NOT NULL ,
`notes_designer` text NOT NULL ,
`notes_developer` text NOT NULL ,
`popup_path` varchar(64) NOT NULL ,
`visible` tinyint(1) 0 NOT NULL ,
`owners` text NOT NULL ,
`content_editor` varchar(64) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_content_widgets_type` (
`id` mediumint(9) NOT NULL PRIMARY KEY ,
`name` varchar(64) NOT NULL ,
`description` varchar(255) NOT NULL ,
`img_path` varchar(255) NOT NULL ,
`pos` tinyint(4) 0 NOT NULL ,
`status` tinyint(1) 0 NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_docbuilder_blocks` (
`id` int(10) unsigned NOT NULL auto_increment PRIMARY KEY ,
`document_id` int(11) ,
`content` mediumtext ,
`content_height` int(11) ,
`original_template` varchar(200) ,
`order` int(11)
) ENGINE = InnoDB;

CREATE TABLE `why_docbuilder_documents` (
`id` int(10) unsigned NOT NULL auto_increment PRIMARY KEY ,
`user_id` int(11) ,
`booking_reference` varchar(45) ,
`language` varchar(5) ,
`document_type` varchar(45) ,
`date_created` datetime ,
`date_updated` datetime ,
`sent` tinyint(4) ,
`date_sent` datetime
) ENGINE = InnoDB;

CREATE TABLE `why_messaging_messages` (
`id` bigint(20) NOT NULL auto_increment PRIMARY KEY ,
`title` varchar(255) NOT NULL ,
`pivot_mail` enum('no','yes') no NOT NULL ,
`pivot_url` varchar(255) NOT NULL ,
`pivot_link_text` varchar(255) NOT NULL ,
`subject` varchar(255) NOT NULL ,
`content` longtext NOT NULL ,
`email_to_go` longtext NOT NULL ,
`last_update_by` int(11) NOT NULL ,
`last_update_date` timestamp current_timestamp() NOT NULL ,
`delete_flag` tinyint(4) 0 NOT NULL ,
`a_mime_type` varchar(50) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_messaging_messages_attachments` (
`id` int(11) NOT NULL PRIMARY KEY ,
`template_id` int(11) NOT NULL ,
`filename` varchar(255) NOT NULL ,
`uploaded_date` timestamp current_timestamp() NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_messaging_messages_org_links` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`template_id` int(11) ,
`org_id` int(11)
) ENGINE = InnoDB;

CREATE TABLE `why_messaging_messages_queue` (
`id` bigint(20) NOT NULL PRIMARY KEY ,
`template_id` int(11) NOT NULL ,
`person_id` int(11) NOT NULL ,
`queued_date` timestamp current_timestamp() NOT NULL ,
`type` varchar(4) html NOT NULL ,
`sender` varchar(255) NOT NULL ,
`processed` enum('N','Y') N NOT NULL ,
`processed_date` timestamp
) ENGINE = InnoDB;

CREATE TABLE `why_messaging_messages_vault` (
`id` bigint(20) NOT NULL PRIMARY KEY ,
`template_id` int(11) NOT NULL ,
`person_id` int(11) NOT NULL ,
`sent_date` timestamp current_timestamp() NOT NULL ,
`who` varchar(255) NOT NULL ,
`sender` varchar(255) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_messaging_outlook_tokens` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`user_id` int(11) ,
`token` text ,
`date_created` datetime ,
`last_accessed` datetime ,
`status` bit(1) b'1'
) ENGINE = InnoDB;

CREATE TABLE `why_messaging_settings` (
`id` int(11) NOT NULL PRIMARY KEY ,
`value_name` varchar(256) NOT NULL ,
`value` text NOT NULL ,
`entity_type` int(11) NOT NULL ,
`entity_id` int(11) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_pages` (
`id` int(11) NOT NULL PRIMARY KEY ,
`title` varchar(100) NOT NULL ,
`slug` varchar(255) ,
`content_type` varchar(30) NOT NULL ,
`status` varchar(30) NOT NULL ,
`meta_title` varchar(65) ,
`meta_description` text ,
`meta_keywords` text ,
`created_date` datetime ,
`modified_date` datetime ,
`author_id` int(11)
) ENGINE = InnoDB;

CREATE TABLE `why_pages_content` (
`id` int(11) NOT NULL PRIMARY KEY ,
`page_id` int(11) NOT NULL ,
`content` text ,
`header_content` text ,
`footer_content` text
) ENGINE = InnoDB;

CREATE TABLE `why_pages_packages` (
`id` int(11) NOT NULL auto_increment PRIMARY KEY ,
`name` varchar(11) NOT NULL ,
`package_id` varchar(11) NOT NULL ,
`slug` varchar(11) NOT NULL ,
`deleted` int(11) NOT NULL ,
`created_date` date NOT NULL ,
`author_id` int(11) NOT NULL
) ENGINE = InnoDB;

CREATE TABLE `why_topics` (
`id` bigint(20) NOT NULL PRIMARY KEY ,
`name` varchar(255) NOT NULL ,
`status` tinyint(4) 0 NOT NULL ,
`icon_bitmap` varchar(255) NOT NULL ,
`icon_vector` varchar(255) fa fa-tag NOT NULL ,
`icon_colour` varchar(6) 5491A7 NOT NULL
) ENGINE = InnoDB;
