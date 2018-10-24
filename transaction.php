<?php 
	include_once "connectmysql.php";
	$sql='select * from student_girl';
	$res=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	$pdo->exec('set autocommit =0');
	//处理事务
	$pdo->beginTransaction();

	$sth=$pdo->exec('insert into student_money (`sm_id`,`sm_stu_id`,`sm_money`) value(1,2,1000)');
	if($sth){
		$pdo->commit();
		echo 'ok';

	}
	else{
		$pdo->rollback();
		echo 'no';
	}
 ?>