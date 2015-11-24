delimiter //

create function login_check(userName varchar(10)) RETURNS int
DETERMINISTIC
BEGIN
    DECLARE val int;
    select COUNT(*) into val from `NextdoorDB`.`user_login` where `uid` = @userName;
    return (val);
END//


USE `NextdoorDB`;
DROP function IF EXISTS `validate_user`;

DELIMITER $$
USE `NextdoorDB`$$
CREATE FUNCTION `validate_user` (userName varchar(10))
RETURNS INTEGER
BEGIN
	DECLARE val int;
    select COUNT(*) into val from `NextdoorDB`.`user_login` where `uid` = userName;
RETURN (val);
END$$

DELIMITER ;