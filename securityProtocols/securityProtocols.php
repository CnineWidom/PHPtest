<?php 
namespace test\securityProtocols ;

include_once '../export/phpexcel/comment.php';
header('Content-type:text/html;charset=utf-8');
define('TOKEN','API');
$tiemstamp=$_GET['t'];
$rand=$_GET['r'];
$signature=$_GET['s'];
$_signature=artical_sig($tiemstamp,$rand);
if($signature!=$_signature){
	response_error('访问错误');
	exit;
}
else{
	$arr=[
		'name'=>'刘亦菲',
		'age'=>'22',
		'sex'=>'女',
	];
	response_ok($arr);
}
//这里的算法规则可以自己修改
function artical_sig($tiemstamp,$rand){
	$arr['tiemstamp']=$tiemstamp;
	$arr['rand']=$rand;
	$arr['TOKEN']=TOKEN;
	sort($arr,SORT_STRING);
	$str=implode($arr);
	$signature= strtoupper(md5(sha1($str)));
	return $signature;
}