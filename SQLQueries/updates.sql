ALTER TABLE `NextdoorDB`.`neighbourhood` 
CHANGE COLUMN `nid` `nid` INT(6) NOT NULL AUTO_INCREMENT;


ALTER TABLE `NextdoorDB`.`messages` 
CHANGE COLUMN `mid` `mid` BIGINT(20) NOT NULL ,
ADD COLUMN `ReadFlag` TINYINT(1) NULL DEFAULT 0 AFTER `longitude`;

ALTER TABLE `NextdoorDB`.`membership` 
DROP FOREIGN KEY `bid_ubfk_2`,
DROP FOREIGN KEY `uid_ibfk_1`;
ALTER TABLE `NextdoorDB`.`membership` 
ADD INDEX `membership_ibfk_2_idx` (`bid` ASC),
DROP INDEX `bid_ubfk_2_idx` ;
ALTER TABLE `NextdoorDB`.`membership` 
ADD CONSTRAINT `membership_ibfk_1`
  FOREIGN KEY (`uid`)
  REFERENCES `NextdoorDB`.`user` (`uid`)
  ON DELETE CASCADE
  ON UPDATE NO ACTION,
ADD CONSTRAINT `membership_ibfk_2`
  FOREIGN KEY (`bid`)
  REFERENCES `NextdoorDB`.`blocks` (`bid`)
  ON DELETE CASCADE
  ON UPDATE NO ACTION;
  
-- stored function for calling uname check
  
  USE `NextdoorDB`;
DROP function IF EXISTS `uname_check`;

DELIMITER $$
USE `NextdoorDB`$$
CREATE FUNCTION `uname_check` (cuname VARCHAR(10))
RETURNS INTEGER
BEGIN
DECLARE ret INTEGER;
SELECT COUNT(*) INTO ret FROM `user_login` where uname = cuname;
RETURN ret;
END$$

DELIMITER ;

-- email field 80


USE `NextdoorDB`;
DROP function IF EXISTS `check_email`;

DELIMITER $$
USE `NextdoorDB`$$
CREATE FUNCTION `check_email` (email1 VARCHAR(80))
RETURNS INTEGER
BEGIN
DECLARE val INTEGER;
SELECT COUNT(*) INTO val from `user` where email=email1;
RETURN val;
END$$

DELIMITER ;

-- changing the order of the neighbourhood for insert
ALTER TABLE `NextdoorDB`.`neighbourhood` 
CHANGE COLUMN `nw_latitude` `nw_latitude` DECIMAL(9,6) NOT NULL AFTER `name`,
CHANGE COLUMN `nw_longitude` `nw_longitude` DECIMAL(9,6) NOT NULL AFTER `nw_latitude`,
CHANGE COLUMN `sw_latitude` `sw_latitude` DECIMAL(9,6) NOT NULL AFTER `se_longitude`,
CHANGE COLUMN `sw_longitude` `sw_longitude` DECIMAL(9,6) NOT NULL AFTER `sw_latitude`;

-- changing the order of the blocks for insert
ALTER TABLE `NextdoorDB`.`blocks` 
CHANGE COLUMN `nw_latitude` `nw_latitude` DECIMAL(9,6) NOT NULL AFTER `ne_longitude`,
CHANGE COLUMN `nw_longitude` `nw_longitude` DECIMAL(9,6) NOT NULL AFTER `nw_latitude`,
CHANGE COLUMN `sw_latitude` `sw_latitude` DECIMAL(9,6) NOT NULL AFTER `nw_longitude`,
CHANGE COLUMN `se_latitude` `se_latitude` DECIMAL(9,6) NOT NULL AFTER `sw_longitude`;
