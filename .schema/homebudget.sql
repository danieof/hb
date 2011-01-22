DROP TABLE IF EXISTS `accounts`;
DROP TABLE IF EXISTS `subaccounts`;
DROP TABLE IF EXISTS `users`;
DROP TABLE IF EXISTS `account_users`;
DROP TABLE IF EXISTS `privileges`;
DROP TABLE IF EXISTS `names_comments`;
DROP TABLE IF EXISTS `account_type`;
DROP TABLE IF EXISTS `account_subtype`;
DROP TABLE IF EXISTS `transactions`;

CREATE TABLE IF NOT EXISTS  `accounts` 
(
	`number` INT UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT PRIMARY KEY
);

CREATE TABLE IF NOT EXISTS  `subaccounts`
(
	`ID` INT UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`account_number` INT UNSIGNED ZEROFILL NOT NULL,
	`type_id` INT UNSIGNED ZEROFILL NOT NULL,
	`parent_id` INT UNSIGNED ZEROFILL NOT NULL,
	`modify_privilege_id` INT UNSIGNED ZEROFILL NOT NULL,
	`default` BOOL NOT NULL DEFAULT 0,
	`names_comments_id` INT UNSIGNED ZEROFILL NOT NULL,
	INDEX ( `account_number` , `parent_id` )
);

CREATE TABLE IF NOT EXISTS  `account_users`
(
	`ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`subaccount_id` INT NOT NULL,
	`user_id` INT NOT NULL,
	`privilege_id` INT NOT NULL,
	INDEX ( `subaccount_id` , `user_id` , `privilege_id` )
);

CREATE TABLE IF NOT EXISTS  `privileges`
(
	`ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`privilege_name` VARCHAR( 32 ) NOT NULL,
	`priority` INT NOT NULL
);

CREATE TABLE IF NOT EXISTS  `names_comments`
(
	`ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`name` TEXT NOT NULL ,
	`comment` TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS  `account_type`
(
	`ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
	`typename` VARCHAR( 64 ) NOT NULL
);

CREATE TABLE IF NOT EXISTS `account_subtype`
(
	`ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`subtypename` VARCHAR( 64 ) NOT NULL,
	`parent_type_id` INT NOT NULL
);

CREATE TABLE IF NOT EXISTS  `transactions`
(
	`ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	`from_subaccount` INT NOT NULL,
	`to_subaccount` INT NOT NULL,
	`tvalue` DOUBLE NOT NULL,
	`tdate` DATE NOT NULL,
	`tname_comment_id` INT NULL,
	INDEX ( `from_subaccount` , `to_subaccount` , `tvalue` )
);