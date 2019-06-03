CREATE DATABASE IF NOT EXISTS `mm_admin`;
USE mm_admin;
CREATE TABLE IF NOT EXISTS `accounts` (
	`username` varchar(32) NOT NULL,
	`password` varchar(32) NOT NULL,
	`permission` tinyint(4) UNSIGNED NOT NULL DEFAULT 0,
	PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
INSERT IGNORE INTO `accounts` (`username`, `password`, `permission`) VALUES ("moyu", "moyu@123", 1);
CREATE TABLE IF NOT EXISTS `history` (
	`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`act_id` int(11) UNSIGNED NOT NULL,
	`act_name` varchar(64) NOT NULL,
	`act_result` int(11) UNSIGNED NOT NULL DEFAULT 0,
	`act_account` varchar(32) NOT NULL,
	`act_time` DATETIME DEFAULT CURRENT_TIMESTAMP,
	`detail` varchar(1024) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `history` ADD INDEX index_act_id(act_id);
ALTER TABLE `history` ADD INDEX index_act_name(act_name);
ALTER TABLE `history` ADD INDEX index_act_account(act_account);