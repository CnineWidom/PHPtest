<?php 
//连接数据库 
header('content-type:text/html;charset=utf-8');
$action=$_REQUEST['action'];
$user='wisdom';
$pass='';
$pdo=new PDO('mysql:host=192.168.75.128;port=3306;dbname=students', $user, $pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES'utf8';"));
$memcache=new Memcache;
$memcache->connect('192.168.75.128',11211);
 
