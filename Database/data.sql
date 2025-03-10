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


CREATE TABLE user_tokens (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    token VARCHAR(255) NOT NULL,
    expires_at DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);