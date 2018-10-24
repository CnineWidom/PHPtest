<?php 
/*
*并发测试 只适合单机并发的情况  当有多个或者分布式的并发时 可以考虑用cats和adds方法
*@author 朱镕坤
*
*/
include_once "connectmysql.php";

$key='in_num';
define('KEY','IN_NUM');
$sql='select in_num as num from inventory order by in_id desc limit 1';
$query=$pdo->query($sql);
$res=$query->fetch(PDO::FETCH_ASSOC);
$num=(int)$res['num'];
if($num>0){
	if(get_Lock($memcache,KEY)){
		$sql_1="insert into inventory (`in_num`) values($num-1)";
		$flag=$pdo->exec($sql_1);
		if($flag){
			echo '购买成功';
		}
		else{
			echo '购买失败';
		}
	}
	else{
		echo '稍后再试';
		exit;
	}
	release_Lock($memcache,KEY);
}
else{
	echo '没有库存了';
}
//获取锁
function get_Lock($memcache,$key,$time=3){
	if($memcache->add($key,1,false,$time)){
		return true;
	}
	else{
		return false;
	}
}

//释放锁
function release_Lock($memcache,$key){
	return $memcache->delete($key);
}