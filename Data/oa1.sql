

CREATE DATABASE IF NOT EXISTS `OA`;
USE `OA`;



CREATE TABLE IF NOT EXISTS `oa_member`(
	`id` int  AUTO_INCREMENT PRIMARY KEY,
	`name` char(32) NOT NULL,
	`pwd` varchar(255) NOT NULL,
	`Organization_id` int NOT NULL,      
	`Order` int NOT NULL DEFAULT 3,         
	`status` tinyint NOT NULL DEFAULT 0,
	`addtime` int NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=UTF8;


CREATE TABLE IF NOT EXISTS `oa_member_info`(
	`id` int  AUTO_INCREMENT PRIMARY KEY, 
	`uid` int NOT NULL,                  
	`tel` char(32) NOT NULL DEFAULT '110',
	`Leave_id` int NOT NULL,              
	`face` varchar(255) NOT NULL DEFAULT 'no.jpg',
	`updatetime` int  NOT NULL    
)ENGINE=InnoDB DEFAULT CHARSET=UTF8;



CREATE TABLE IF NOT EXISTS `oa_news`(
	`id` int  AUTO_INCREMENT PRIMARY KEY,
	`uid` int NOT NULL,  
	`title` varchar(255) DEFAULT '未知',
	`content` text,    
	`addtime` int NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=UTF8;


CREATE TABLE IF NOT EXISTS `oa_organization`(
	`id` int  AUTO_INCREMENT PRIMARY KEY,
	`pid`  int NOT NULL DEFAULT 0,
	`path` varchar(255) NOT NULL DEFAULT '0,',
	`name` varchar(255) NOT NULL,
	`addtime` int  NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=UTF8;


CREATE TABLE IF NOT EXISTS `oa_leave`(
	`id` int  AUTO_INCREMENT PRIMARY KEY, 
	`uid` int NOT NULL,  
	`p_uid` int NOT NULL, 
	`content` text,       
	`status` tinyint NOT NULL DEFAULT 0, 
	`addtime` int NOT NULL 
)ENGINE=InnoDB DEFAULT CHARSET=UTF8;


CREATE TABLE IF NOT EXISTS `oa_finance`(
	`id` int  AUTO_INCREMENT PRIMARY KEY, 
	`uid`  int NOT NULL,  
	`total` decimal(10,2) NOT NULL, 
	`content` text,  
	`status` tinyint NOT NULL DEFAULT 1,
	`addtime` int NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=UTF8;


CREATE TABLE IF NOT EXISTS `oa_activity`(
	`id` int  AUTO_INCREMENT PRIMARY KEY, 
	`uid`  int NOT NULL,  
	`starttime` int NOT NULL, 
	`content` text,   
	`Organization_id` int NOT NULL, 
	`addtime` int NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=UTF8;



CREATE TABLE IF NOT EXISTS `oa_customer`(
	`id` int  AUTO_INCREMENT PRIMARY KEY, 
	`uid`  int NOT NULL,  
	`status` tinyint NOT NULL DEFAULT 1, 
	`tel` varchar(255) NOT NULL, 
	`addtime` int NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=UTF8;










	