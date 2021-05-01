CREATE TABLE `events` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`event_bedding_resources_link_children` BIGINT UNSIGNED ,
`event_personal_resources_link_children` BIGINT UNSIGNED ,
`event_food_resources_link_children` BIGINT UNSIGNED ,
`event_place_link_children` BIGINT UNSIGNED ,
`event_person_link_children` BIGINT UNSIGNED ,
`name` character varying(100) NOT NULL ,
`time` character varying(100) NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `bedding_resources` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`event_resource_link_children` BIGINT UNSIGNED ,
`name` character varying(100) NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `personal_resources` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`event_resource_link_children` BIGINT UNSIGNED ,
`name` character varying(100) NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `food_resources` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`event_resource_link_children` BIGINT UNSIGNED ,
`name` character varying(100) NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `places` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`event_place_link_children` BIGINT UNSIGNED ,
`name` character varying(100) NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `persons` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`event_person_link_children` BIGINT UNSIGNED ,
`name` character varying(100) NOT NULL ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `event_bedding_resources_links` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`event_id` BIGINT UNSIGNED ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `event_personal_resources_links` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`event_id` BIGINT UNSIGNED ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `event_food_resources_links` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`event_id` BIGINT UNSIGNED ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `event_place_links` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`event_id` BIGINT UNSIGNED ,
`place_id` BIGINT UNSIGNED ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB;

CREATE TABLE `event_person_links` (
`id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT ,
`event_id` BIGINT UNSIGNED ,
`person_id` BIGINT UNSIGNED ,
PRIMARY KEY (`id`)
) ENGINE = InnoDB;
