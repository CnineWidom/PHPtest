<?php 
	include_once 'comment.php';
	header("Content-Type:text/html;charset=utf-8");
	$user='wisdom';
	$pass='';
	$network='192.168.75.128';
	$memcache_part=11211;
	$memcache=new Memcache;

	$name=$_POST['name'];
	$age=(int)$_POST['age'];
	$group=(int)$_POST['group'];
	$class=(int)$_POST['class'];
	$pagesize=(int)$_POST['pagesize'];
	if(empty($name)){
		response_error(-1,'请输入名称');
		exit;
	}	
	//防止sql注入
	//1.从入口开始筛选 2.从sql用法  比如用预定义语句 防止sql注入
 	if (!get_magic_quotes_gpc()) // 判断magic_quotes_gpc是否为打开     
    {     
        $name = addslashes($name); // 进行magic_quotes_gpc没有打开的情况对提交数据的过滤     
    }  
    $name=str_replace('_','\_',$name);
    $name=str_replace('%','\%',$name);
    $name=htmlspecialchars($name);//html标记转换
	$pdo=new PDO("mysql:host=$network;port=3306;dbname=students", $user, $pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES'utf8';"));
	$sql="select count(*) as count from student_girl where name=:name";
    $stmt=$pdo->prepare($sql);
    $stmt->execute(array(':name'=>$name));
    $res=$stmt->fetchAll();
    if($res[0]->count>=1){
    	response_error(-1,'已经有该名称');exit;
    }elseif ($res[0]->count==0) {
    	$insert_sql="insert into student_girl (name,age,`group`,class,community) values (?,?,?,?,0)";
    	$array=[$name,$age,$group,$class];
    	$inset_stmt=$pdo->prepare($insert_sql);
    	$res=$inset_stmt->execute($array);
    	if($inset_stmt){
    		if($memcache->connect($network,$memcache_part)){
	    		$memcache->set($pagesize,'');
    		}
    		response_ok('插入成功');
    	}
    	else{
    		response_error(-1);
    	}
    }
 ?>