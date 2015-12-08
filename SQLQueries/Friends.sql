-- listing all current friends
SELECT uid2 FROM `NextdoorDB`.`relationship` where type = 'friend' and uid1 = 1 
union SELECT uid1 FROM `NextdoorDB`.`relationship` where type = 'friend' and uid2 = 1;
 
-- listing all neighbours
SELECT uid2 FROM `NextdoorDB`.`relationship` where type = 'neighbour' and uid1 = /*current user*/;

-- sending friend request 
-- adding to the f_request table
INSERT INTO `NextdoorDB`.`f_request` (`uid_requested_by`, `uid_requested_of`, `status`)
VALUES ( 1, 6, 'waiting');


-- setting the status to the 'waiting'


-- accepting friend request

update `NextdoorDB`.`f_request` 
set status='accepted'
where uid_requested_by = 1 and uid_requested_of = 6;

insert into `nextdoordb`.`relationship` (`uid1`,`uid2`,`type`,`since`)
values(1,6,'friend',current_timestamp())

-- update the table from waiting to accepted
-- 

-- adding neighbour
