<?php 
/*
*导入excel
*/
//连接数据库 
header('content-type:text/html;charset=utf-8');
$action=$_REQUEST['action'];
$user='root';
$pass='';

$memcache=new Memcache;
if($memcache->connect('localhost',11211)){
    if($memcache->get('res')==""){
        $pdo=new PDO('mysql:host=localhost;port=3306;dbname=school', $user, $pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES'utf8';"));
        $sql="select * from student_girl";
        $res=$pdo->query($sql);
        $res = $res->fetchAll(PDO::FETCH_ASSOC);
        $memcache->set('res',$res);
    }
    else{
        $res=$memcache->get('res');
    }
}
else{
    $pdo=new PDO('mysql:host=localhost;dbname=school', $user, $pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES'utf8';"));
    $sql="select * from student_girl";
    $res=$pdo->query($sql);
    $res = $res->fetchAll(PDO::FETCH_ASSOC);
}
var_dump($res);
exit;

$filename='student_mamual';
$filetitle='girl';
set_time_limit(10000);
ini_set('memory_limit','300M');
header('Content-Type: application/vnd.ms-excel;charset=utf-8');
$name=$filename.".xls";
header('Content-Disposition: attachment;filename='.$name.'');//下载
// header('Cache-Control: max-age=0');

//开启句柄 直接输入到浏览器
$fp = fopen('php://output', 'a');
$p_new_lines = array("\r\n", "\n","\t","\r","\r\n", "<pre>","</pre>","<br>","</br>","<br/>");

$cnt = 0;
$limit = 100000;

$str="<table><tr><td>id</td><td>姓名</td><td>年龄</td><td>年级</td><td>班级</td><td>社团</td></tr>";
$str1="";
foreach ($res as $key => $value) {
	$cnt ++;
    if ($limit == $cnt) { //刷新一下输出buffer，防止由于数据过多造成问题 
        ob_flush();
        flush();
        $cnt = 0;
    }
    $str1.="<tr><td>".$value['id']."</td>
    <td>".$value['name']."</td>
    <td>".$value['age']."</td>
    <td>".$value['group']."</td>
    <td>".$value['class']."</td>
    <td>".$value['community']."</td></tr>";
}
$str3=iconv("UTF-8", "GBK", $str.$str1."</table>");
echo $str3;
/*这里也可以输出成html格式 当然慢慢优化也是可以的  不过这种方式数据大的时候不行而且也不能用样式 借助phpexcel*/
?>
