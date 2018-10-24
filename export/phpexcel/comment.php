<?php 
/*
*@autor 朱镕坤
* 公共方法或者
*/
if(!function_exists(resonse_ok)){
	function response_ok($res,$msg='ok'){
		$arr=array(
			'code'=>0,
			'msg'=>$msg,
			'res'=>$res
		);
		echo  json_encode($arr);
	}
}
if(!function_exists(response_error)){
	function response_error($code,$msg='false'){
		$arr=array(
			'code'=>$code,
			'msg'=>$msg,
		);
		echo  json_encode($arr);	
		
	}
}


 ?>