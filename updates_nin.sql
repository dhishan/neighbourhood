
-- neighbourhood update naimesh

ALTER TABLE `nextdoordb`.`neighbourhood` 
CHANGE COLUMN `name` `name` VARCHAR(40) NOT NULL ,
ADD COLUMN `nw_latitude` DECIMAL(9,6) NOT NULL AFTER `sw_latitude`,
ADD COLUMN `nw_longitude` DECIMAL(9,6) NOT NULL AFTER `nw_latitude`,
ADD COLUMN `se_latitude` DECIMAL(9,6) NOT NULL AFTER `nw_longitude`,
ADD COLUMN `se_longitude` DECIMAL(9,6) NOT NULL AFTER `se_latitude`;

