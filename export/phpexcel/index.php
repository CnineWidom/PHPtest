<?php 
$user='wisdom';
$pass='';
$network='192.168.75.128';
$memcache_part=11211;
$memcache=new Memcache;
$page=(int)$_REQUEST['page'];
$offset=20;
$pdo=new PDO("mysql:host=$network;port=3306;dbname=students", $user, $pass,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES'utf8';"));
$sql_count='select count(*) as count from student_girl';
$all_count=$pdo->query($sql_count)->fetch(PDO::FETCH_ASSOC);
$pagesize=ceil($all_count['count']/$offset);
if($page>$pagesize)$page=$pagesize;
if($page<=0)$page=1;
$page_start=($page-1)*$offset;
$page_arr=range(1, $pagesize);

if($memcache->connect($network,$memcache_part)){
	if($memcache->get($page)!=""){
		$res=$memcache->get($page);
	}else{
		$sql_resouse="select * from student_girl limit $page_start,$offset";
		if($res=$pdo->query($sql_resouse)->fetchAll(PDO::FETCH_ASSOC)){
			$memcache->set($page,$res,false,60);//定时可以很好的解决相关的问题
			//还有一个问题就是插入数据我得马上显示 就是插入的时候顺便更新memcache
		}
	}
}else{
	$sql_resouse="select * from student_girl limit $page_start,$offset";
	$res=$pdo->query($sql_resouse)->fetchAll(PDO::FETCH_ASSOC);
}
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>学生信息</title>
<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.0.js">
</script>
 </head>
 <style>
 .ul_1,.ul_2,ul{
 	margin:0 auto;
 	width: 50%;
 	padding-left: 0px;
 }
 li{
 	list-style: none;
 	margin-left: 1%;
 }
.ul_1 li{
	width: 100%;
	margin:0 auto;

	font-size: 15px;
	text-align: center;
	padding-top: 1%;
	padding-bottom: 1%;
	background: #E8EDF1;
}
.ul_1 li span{
	padding-left: 6%;
	padding-right: 6%;
}
.ul_1>li:first-child{
	background: #A9DDF3;
	border:none;
}

.ul_2>li{
	margin-top: 10px;
	list-style: none;
	font-size: 15px;
}
.ul_2>li span{
	cursor: pointer;
	background-color: #693;
	margin: 0 auto;
	text-align: center;
	padding-left: 1%;
	padding-right: 1%;
}
.div_1{
	width: 100%;
	text-align: center;
}
.button_1{
	width: 100px;
	height: 25px;
	font-size:15px;
	display: inline;
	margin-left: 5%;
}
</style>
<body>
	<ul class="ul_1">
		<li>
			<span>id</span>
			<span>姓名</span>
			<span>年龄</span>
			<span>年级</span>
			<span>班级</span>
			<span>社团</span>
		</li>
		<?php 
			foreach ($res as $key => $value) {
				echo "<li>
				<span>".$value['id']."</span>
				<span>".$value['name']."</span>
				<span>".$value['age']."</span>
				<span>".$value['group']."</span>
				<span>".$value['class']."</span>
				<span>".$value['community']."</span>
				</li>";
			}
		?>
	</ul>
		<ul id='ul_1' style="display: none;">
			<li>
				<span>姓名：<input type="text" name="name"  id="name"></span>
				<span>年龄：<input type="text" name="age" id="age"></span></br>
				<span>年级：<input type="text" name="group" id="group"></span>
				<span>班级：<input type="text" name="class" id="class"></span>
				<?php echo  "<input type='hidden' id='pagesize' name='class' value=".$pagesize.">";?>
				
				<span><input type="button" class="btn_3" value="取消"></span>
				<span><input type="submit" class="btn_4" id="btn_3" value="确定添加"></span>
			</li>
		</ul>
	<div class="div_1">
		<input class="button_1" id='export' type="button" value="导出全部">
		<input class="button_1" type="button" id='btn_2' value="添加人员">
		<input type="button" class="button_1" value="编辑">
	</div>
	<ul class="ul_2">
		<?php 
			echo "<li>
					<a href='?page=1'>首页</a>&nbsp;
					<a href='?page=".($page-1)."'>上一页</a>&nbsp;
					<a href='?page=".($page+1)."'>下一页</a>&nbsp;
					<a href='?page=".($pagesize)."'>尾页</a>
				</li>";
		 ?>
		<li>
			<?php  foreach ($page_arr as $key => $value){
				echo "<a href='?page=".$value."'><span>$value</span></a>";
			}?>
		</li>
	</ul>
 </body>
 </html>
 <script>

$('#export').click(function(){
	$.ajax({
		url:'phpExcel.php',
		type:'post',
		dataType:'json',
		data:{
			action:'export'
		},
		success:function(res){
			if(res.code==1){
				alert('导出成功')
			}
		}
	})
})
$('#btn_2').click(function(){
	$('#ul_1').fadeToggle();
})
$('.btn_3').click(function(){
	$('#ul_1').css({display:'none'})
})
$('#btn_3').click(function(){
	$.ajax({
		url:'addstudent.php',
		type:'post',
		dataType:'json',
		data:{
			name:$('#name').val(),
			age:$('#age').val(),
			group:$('#group').val(),
			class:$('#class').val(),
			pagesize:$('#pagesize').attr("value")
		},
		success:function(res){

		}
	})
})
 </script>