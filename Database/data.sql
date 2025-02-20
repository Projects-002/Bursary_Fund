create table users(
SN int auto_increment primary key,
First_Name varchar(100),
Last_Name varchar(100),
Phone varchar(50) unique default null,
Email varchar(100) unique,
Avatar varchar (2000),
Pass varchar(255),
 Reg_Date datetime default now()
);

