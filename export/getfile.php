<?php 
/*
*用的是源码不用插件 
*上传excel到mysql
*/
header('content-type:text/html;charset=utf-8');
$action=$_REQUEST['action'];

$user='root';
$pass='';
$pdo=new PDO('mysql:host=localhost;dbname=school', $user, $pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES'utf8';"));

$sql="select * from student_girl";
$res=$pdo->query($sql);
$action=$_REQUEST['action'];
$fileres=$_FILES['file'];

$name=iconv("UTF-8","gb2312", $fileres['name']);//防止乱码


if(file_exists('file/'.$name)){
	unlink('file/'.$name);
	$result=move_uploaded_file($fileres['tmp_name'], 'file/'.$name);
}
else{
	$result=move_uploaded_file($fileres['tmp_name'], 'file/'.$name);
}
//上传成功
if($result){
	$file=fopen('file/'.$name, 'r');

	$row = fgets($file);
	// $row=iconv('UTF-8','gb2312',$row);
	var_dump($row);
}
 ?>
