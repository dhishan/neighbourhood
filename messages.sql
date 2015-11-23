
-- Create a new thread and insert with autoincrement thread id, subject, the user selected, the scope, scope ID and the current time
INSERT INTO `NextdoorDB`.`threads` (`tid`, `subject`, `scope`, `scope_id`, `start_time`)
VALUES ( null, 'Test', 'personnel', '2', CURRENT_TIMESTAMP);

-- Get the last inserted thread ID which was auto incremented and then link that thread to the new message the user created with the text field in the CLOB
INSERT INTO `NextdoorDB`.`messages` (`mid`, `author`, `m_body`, `tid`, `postedat`, `image`, `latitude`, `longitude`) VALUES (null, 1, 'WElcome to neighbourhood.com', LAST_INSERT_ID(), CURRENT_TIMESTAMP,'','','');

-- Getting the thread id where the subject was the 'Test' into a variable val
select tid from threads where subject like 'Test' limit 1 into @val;

-- insert into the variable with val as the thread id.
INSERT INTO `NextdoorDB`.`messages` (`mid`, `author`, `m_body`, `tid`, `postedat`, `image`, `latitude`, `longitude`) VALUES (null, '1' , 'This is the second message', @val, CURRENT_TIMESTAMP,'','','');


-- Searching for messages with body containing keywords
select * from NextdoorDB.messages where m_body like '%is%';


