INSERT INTO `NextdoorDB`.`threads` (`tid`, `subject`, `scope`, `scope_id`, `start_time`)
VALUES ( null, 'Test', 'personnel', '2', CURRENT_TIMESTAMP);

SELECT LAST_INSERT_ID();


INSERT INTO `NextdoorDB`.`messages` (`mid`, `author`, `m_body`, `tid`, `postedat`, `image`, `latitude`, `longitude`) VALUES (null, 1, 'WElcome to neighbourhood.com', LAST_INSERT_ID(), CURRENT_TIMESTAMP,'','','');

select tid from threads where subject like 'Test' limit 1 into @val;

INSERT INTO `NextdoorDB`.`messages` (`mid`, `author`, `m_body`, `tid`, `postedat`, `image`, `latitude`, `longitude`) VALUES (null, '1' , 'This is the second message', @val, CURRENT_TIMESTAMP,'','','');

select * from NextdoorDB.messages where m_body like '%is%';

