<?php 
$memcache=new Memcache;
$memcache->connect('localhost',11211);
$memcache->set('key','test');

echo $memcache->get('key');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<ul>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
		<li></li>
	</ul>
</body>
</html>