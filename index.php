<?php
	header("content-type:text/html;charset=utf-8");


	//定义一个项目的目录
	define('APP_PATH','./OA/');

	//开启调试模式
	define('APP_DEBUG',true);

	//包含框架的入口文件
	require './ThinkPHP/ThinkPHP.php';

?>