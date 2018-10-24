<?php 
include '../../phpexcel/PHPExcel-1.8/PHPExcel-1.8/Classes/PHPExcel.php';
include '../../phpexcel/PHPExcel-1.8/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
include '../../phpexcel/PHPExcel-1.8/PHPExcel-1.8/Classes/PHPExcel/Reader/Excel5.php';
$action=$_POST['action'];
$user='wisdom';
$pass='';
$network='192.168.75.128';
$memcache_part=11211;
$memcache=new Memcache;
if($action=='export'){
	header('Content-Type: application/vnd.ms-excel;charset=utf-8');
	if($memcache->connect($network,$memcache_part)){
		if($memcache->get('res')!=""){
			$res=$memcache->get('res');
		}else{
			$pdo=new PDO("mysql:host=$network;port=3306;dbname=students", $user, $pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES'utf8';"));
			$sql='select * from student_girl';
			$res=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
			$memcache->set('res',$res,false,60);
		}
	}else{
		$pdo=new PDO('mysql:host=192.168.75.128;port=3306;dbname=students', $user, $pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES'utf8';"));
		$sql='select * from student_girl';
			$res=$pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
	}
	$objPHPExcel = new PHPExcel();
	if($res){
		$objPHPExcel1=$objPHPExcel->getProperties();
		$objPHPExcel1->setcreator('wisdom')
				 ->setlastModifiedBy('wisdom')
				 ->settitle('学生手册')
				 ->setdescription('学生信息描述')
				 ->setsubject('学生信息详细')
				 ->setkeywords('学生');
		$objPHPExcel->getActiveSheet()->setTitle('学生信息');
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1','id')
			->setCellValue('B1','姓名')
			->setCellValue('C1','年龄')
			->setCellValue('D1','年级')
			->setCellValue('E1','班级')
			->setCellValue('F1','社团');
		foreach ($res as $key => $value) {
			$objPHPExcel->setActiveSheetIndex(0)
						->setCellValue('A'.($key+2),$value['id'])
						->setCellValue('B'.($key+2),$value['name'])
						->setCellValue('C'.($key+2),$value['age'])
						->setCellValue('D'.($key+2),$value['group'])
						->setCellValue('E'.($key+2),$value['class'])
						->setCellValue('F'.($key+2),$value['community']);
		}
	}else{
		$respon_array=array(
		'code'=>0,
		'msg'=>'no',
	);
		echo json_encode($respon_array);exit;
	}
	$objWriter  = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$name='学生信息';
	$name=iconv('UTF-8','gb2312',$name);
	$file_load="../file/$name.xlsx";
	$objWriter ->save($file_load);

	$name=iconv('gb2312','UTF-8',$name);
	$respon_array=array(
		'code'=>1,
		'msg'=>'OK',
		'filename'=>$name
	);
	echo json_encode($respon_array);
}

