DROP TABLE IF EXISTS `_activity_log`;

#
# Table structure for table '_activity_log'
#

CREATE TABLE `_activity_log` (
  `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT,
  `record_table_and_id` varchar(255) NOT NULL,
  `timestamp` datetime NOT NULL,
  `last_activity_type` varchar(255) NOT NULL,
  `owner` int(11) NOT NULL DEFAULT 2,
  `editability` varchar(2) NOT NULL,
  `visibility` varchar(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `record_table_and_id` (`record_table_and_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
