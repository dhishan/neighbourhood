select `threads`.`tid`,`threads`.`subject`
from `nextdoordb`.`user_login`,`nextdoordb`.`membership`,`nextdoordb`.`messages`,`nextdoordb`.`threads`
where `user_login`.`uid` = `membership`.`uid` and `uid` = 1 and `messages`.`postedat` > `user_login`.`last_login` and `threads`.`tid`=`messages`.`tid` and `threads`.`scope_id`=`membership`.`bid` and `threads`.`scope`= block	 




Error Code: 1052. Column 'tid' in field list is ambiguous
