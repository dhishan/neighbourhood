


-- Create a new thread and insert with autoincrement thread id, subject, the user selected, the scope, scope ID and the current time
INSERT INTO `NextdoorDB`.`threads` (`tid`, `subject`, `scope`, `scope_id`, `start_time`)
VALUES ( null, 'Test Message 2', 'Friends', null , CURRENT_TIMESTAMP);

-- Get the last inserted thread ID which was auto incremented and then link that thread to the new message the user created with the text field in the CLOB
INSERT INTO `NextdoorDB`.`messages` (`mid`, `author`, `m_body`, `tid`, `postedat`, `image`, `latitude`, `longitude`) VALUES (null, 1, 'Reply to first Message ', 13, CURRENT_TIMESTAMP,'','','');

-- Getting the thread id where the subject was the 'Test' into a variable val
select tid from `NextdoorDB`.`threads` where subject like 'Test Message 1' limit 1;

-- insert into the variable with val as the thread id.
INSERT INTO `NextdoorDB`.`messages` (`mid`, `author`, `m_body`, `tid`, `postedat`, `image`, `latitude`, `longitude`) VALUES (null, '1' , 'This is the second message', @val, CURRENT_TIMESTAMP,'','','');


-- Searching for messages with body containing keywords
select * from NextdoorDB.messages where m_body like '%first%';


