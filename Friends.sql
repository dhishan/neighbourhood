-- listing all current friends
SELECT uid2 FROM `NextdoorDB`.`relationship` where type = 'friend' and uid1 = /*current user*/
union SELECT uid1 FROM `NextdoorDB`.`relationship` where type = 'friend' and uid2 = /*current user*/;
 
-- listing all neighbours
SELECT uid2 FROM `NextdoorDB`.`relationship` where type = 'neighbour' and uid1 = /*current user*/;

-- sending friend request 
-- adding to the f_request table
INSERT INTO `NextdoorDB`.`f_request` (`uid_requested_by`, `uid_requested_of`, `status`)
VALUES ( , , );


-- setting the status to the 'waiting'


-- accepting friend request
-- update the table from waiting to accepted
-- 

-- adding neighbour
