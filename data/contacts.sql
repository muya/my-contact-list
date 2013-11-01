create table if not exists `contacts`(
	`id` int(11) unsigned primary key auto_increment,
	`name` varchar(50) default null,
	`phoneNumber` varchar(15) default null,
	`email` varchar(15) default null,
	`dateCreated` datetime not null,
	`dateModifed` timestamp not null default current_timestamp on update current_timestamp
) ENGINE=InnoDB;