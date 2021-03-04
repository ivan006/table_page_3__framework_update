DROP TABLE IF EXISTS `_activity_log`;

#
# Table structure for table '_activity_log'
#

CREATE TABLE `_activity_log` (
  `record_table_and_id` varchar(255) NOT NULL,
  `timestamp` datetime NOT NULL,
  `user_group` int(11) NOT NULL,
  PRIMARY KEY (`record_table_and_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
