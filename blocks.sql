SELECT count(*) FROM NextdoorDB.membership where bid = '';
select * from NextdoorDB.user where uid = '';
UPDATE `NextdoorDB`.`user` SET
`uid` = <{uid: }>,
`email` = <{email: }>,
`fullname` = <{fullname: }>,
`streetadr1` = <{streetadr1: }>,
`streetadr2` = <{streetadr2: }>,
`city` = <{city: }>,
`state` = <{state: }>,
`zip` = <{zip: }>,
`intro` = <{intro: }>,
`ppic` = <{ppic: }>
WHERE `uid` = <{expr}>;


