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
