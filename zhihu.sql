create TABLE user(
id int(10) not null auto_increment,
username varchar(100),
password varchar(255) not null,
primary key (id)

)engine=innodb;