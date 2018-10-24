<?php 
/*
*练习断点续传
*@autor 朱镕坤
*/
$fileName="../file/testdowmload.txt";
$path='../file/';
$realname='testdowmload.txt';
$size=filesize($fileName);
$size2=(int)$size/5;
$range=0;
set_time_limit(0);
if(!file_exists($fileName))die('文件不存在');
echo $_SERVER['HTTP_RANGE'];
if(isset($_SERVER['HTTP_RANGE'])){
    header('HTTP /1.1 206 Partial Content');    
    $range = str_replace('=','-',$_SERVER['HTTP_RANGE']);    
    $range = explode('-',$range);    
    $range = trim($range[1]);   
    header('Content-Length:'.$size2);    
    header('Content-Range: bytes '.$range.'-'.$size2.'/'.$size);
}
else{
	header('Content-Length:'.$size);//传输的长度
    header('Content-Range: bytes 0-'.$size2.'/'.$size);//
}
header('Accenpt-Ranges: bytes');  
header('Content-Type: application/octet-stream');  //强制二进制传输
header("Cache-control: public"); //缓存控制
header("Pragma: public");//启用缓存 默认为no-cash

$ua=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/MSIE/',$ua)) {    //表示正在使用 Internet Explorer。    
	$ie_filename = str_replace('+','%20',urlencode($file));    
	header('Content-Disposition:attachment; filename='.$ie_filename);  
}else{    
		header('Content-Disposition:attachment; filename='.$realname);
	}
$fp = fopen($real,'rb+');  
fseek($fp,$range);                //fseek:在打开的文件中定位,该函数把文件指针从当前位置向前或向后移动到新的位置，新位置从文件头开始以字节数度量。成功则返回 0；否则返回 -1。注意，移动到 EOF 之后的位置不会产生错误。  
while(!feof($fp)) {               //feof:检测是否已到达文件末尾 (eof)    
	set_time_limit(0);              //注释①    
	print(fread($fp,1024));         //读取文件（可安全用于二进制文件,第二个参数:规定要读取的最大字节数）    
	ob_flush();                     //刷新PHP自身的缓冲区     
	flush();
}                      
fclose($fp);

?>