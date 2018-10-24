<?php 
/*
*文本流的学习
*file的操作
*/
$fileload='file/testdownload.txt';
// $content=file_get_contents();
// echo $content;
$file=fopen($fileload,'rb') or exit('unable open file');
$content=fread($file,'10');
var_dump($content);
fclose($file);