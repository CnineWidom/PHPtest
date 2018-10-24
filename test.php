<?php 
$a1=array_fill(1,4,"blue");//从1开始填充四个 值为blue的数组  递增

$a3=['a','b','d','c'];
// $a2=array_fill_keys($a3,'45');
// echo md5('123');
// function get_a($v){
// 	if($v=='b'){
// 		return false;
// 	}
// 	else{
// 		return $v;
// 	}
// }
// function checkNum($number)
//  {
//  if($number>1)
//   {
//   	throw new Exception("Value must be 1 or below");//抛出异常
//   }
//  return true;
//  }
// // $b=array_rand($a3,2);
//  ksort($a3);
// var_dump($a3);
//trigger exception
// checkNum(2);
// echo md5('123');
$a4=[1,2,3,4,5,6];
// foreach ($a3 as &$key ) {
// 	echo $key."<br>";
// }
// foreach ($a3 as $key) {
// 	echo $key."<br>";
// }
$a="12\r456";
$b=$a;

 xdebug_debug_zval('a');
 // PHP_EOL;


 $arr=[
 	'4561_A',
 	'4561_B',
 	'456A_A',
 	'456A_B',
 	'AC61_A',
 	'AC62_B',
 	'AC61A',
 	'4D61_C',
 	'4B61_D',
 	'4A61_V',
 	'4B61_A',
 	'4B61_B',
 ];
$newstr = substr($arr[0],-1); 
array_walk($arr, function($v,$k){
	$su=substr($v, -1);
	echo $su."^^";
});
// var_dump($newstr);