--数据库的名字是:OA

CREATE DATABASE IF NOT EXISTS `OA`;
USE `OA`;


-- 用户表
CREATE TABLE IF NOT EXISTS `oa_member`(
	`id` int  AUTO_INCREMENT PRIMARY KEY, --主键
	`name` char(32) NOT NULL,
	`pwd` varchar(255) NOT NULL,
	`Organization_id` int NOT NULL,       --部门id
	`Order` int NOT NULL DEFAULT 3,       -- 权限 0 为部门老大 1位 总监 2为 组长 3 为员工  
	`status` tinyint NOT NULL DEFAULT 0,--1 正常 0 禁用
	`addtime` int NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=UTF8;

-- 用户详情表
CREATE TABLE IF NOT EXISTS `oa_member_info`(
	`id` int  AUTO_INCREMENT PRIMARY KEY, --主键
	`uid` int NOT NULL,                   --上一个表的ID
	`tel` char(32) NOT NULL DEFAULT '110',
	`Leave_id` int NOT NULL,              -- 要审批的假条的ID
	`face` varchar(255) NOT NULL DEFAULT 'no.jpg',
	`updatetime` int  NOT NULL    --完善时间
)ENGINE=InnoDB DEFAULT CHARSET=UTF8;


--新闻表
CREATE TABLE IF NOT EXISTS `oa_news`(
	`id` int  AUTO_INCREMENT PRIMARY KEY, --主键
	`uid` int NOT NULL,  
	`title` varchar(255) DEFAULT '未知', ---标题
	`content` text,      --新闻内容 
	`addtime` int NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=UTF8;

-- 组织表
CREATE TABLE IF NOT EXISTS `oa_organization`(
	`id` int  AUTO_INCREMENT PRIMARY KEY, --主键
	`pid`  int NOT NULL DEFAULT 0,
	`path` varchar(255) NOT NULL DEFAULT '0,',
	`name` varchar(255) NOT NULL,
	`addtime` int  NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=UTF8;

-- 请假表
CREATE TABLE IF NOT EXISTS `oa_leave`(
	`id` int  AUTO_INCREMENT PRIMARY KEY, --主键
	`uid` int NOT NULL,  --请假人的ID
	`p_uid` int NOT NULL, --审批人的ID
	`content` text,       --请假的内容
	`status` tinyint NOT NULL DEFAULT 0, --1代表已经审批 0 代表未审批
	`addtime` int NOT NULL  --请假时间 
)ENGINE=InnoDB DEFAULT CHARSET=UTF8;

-- 财务表
CREATE TABLE IF NOT EXISTS `oa_finance`(
	`id` int  AUTO_INCREMENT PRIMARY KEY, --主键
	`uid`  int NOT NULL,  --支出人的ID
	`total` decimal(10,2) NOT NULL, --金额
	`content` text,   -- 支出凭证
	`status` tinyint NOT NULL DEFAULT 1, --1 收入 0 支出
	`addtime` int NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=UTF8;

-- 活动表
CREATE TABLE IF NOT EXISTS `oa_activity`(
	`id` int  AUTO_INCREMENT PRIMARY KEY, --主键
	`uid`  int NOT NULL,  --发起人的ID
	`starttime` int NOT NULL, --开始时间
	`content` text,   -- 内容
	`Organization_id` int NOT NULL, -- 参加组织的id 
	`addtime` int NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=UTF8;


-- 客户表
CREATE TABLE IF NOT EXISTS `oa_customer`(
	`id` int  AUTO_INCREMENT PRIMARY KEY, --主键
	`uid`  int NOT NULL,  --添加人的ID
	`status` tinyint NOT NULL DEFAULT 1, --1 潜在客户 0 目标客户
	`tel` varchar(255) NOT NULL, --客户的电话
	`addtime` int NOT NULL
)ENGINE=InnoDB DEFAULT CHARSET=UTF8;










	