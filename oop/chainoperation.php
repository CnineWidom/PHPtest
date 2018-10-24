<?php 
/*
*链式操作
*顺便熟悉对象的操作
*公有 属性和方法  
*私有和保护的属性和方法 私有方法的内部调用也有几种 self::get_pro();  $this->get_pro();  
  $this::get_pro();都是可以的   

*私有属性的调用 只能在类内部调用 $this->age;只能这样调用 没有双冒号的方式
*私有属性的赋值 可以有几种方法 1是在类内命名一个函数专门负责赋值 类似__construct() 或者使用魔术方法__set()__get()

*常量 （无法改变值） 可以在类内外访问 类内有两种访问方式  self:CONST;$this->sex 不管是声明还是调用都不需要加$
*/
class chainoperation
{

	private $age;//私有属性  只能在类内被调用 （@ 1）
	private $classname;
	public $name;//公有属性 可以在类内也可以在类外直接被调用(@ 2)
	protected $height;
	const sex='男';

	function __construct($str,$name)
	{
		$this->age=$str;
		$this->name=$name;
	}

	private function get_pro(){//私有函数只能在类内部使用
		var_dump(get_object_vars($this));
	}
//__call方法是指当对象调用了类内没有的方法以后会自动触发该函数  有两个参数 一个是name  是指函数的名字 也就是对象调用的方法名 一个是参数  该方法的参数
	public function __call($name,$ages){
		$this->name=call_user_func($name,$this->age,$ages[0]);
		$this::get_pro();//如此调用私有方法
		return $this;
	}
/*	
*私有属性可以 以这种方式来改变 @3	
	public function publicname($age,$name){
		echo $this->age; 
		echo $this->name;
		$this->age=$age;
		$this->name=$name;
		echo $this->age; 
		echo $this->name;
	}
*/
/*
当给一个无访问权限或不存在的属性赋值时，__set()魔术方法会自动调用，并传入两个参数：属性和属性值

*/
	public function __set($name,$process){
		echo $name."123<br>";
		echo $process."<br>";
		$this->$name=$process;
	}
/*
当我们调用一个权限上不允许访问的属性或者是不存在的属性时，__get()魔术方法会自动调用，并且自动传参，参数名是属性名
*/
	public function __get($name){
		if(isset($this->$name)){
			$this->$name=$name;
		}
		else{
			$this->$name='14564';
		}
		return $this->$name;
	}
/*
*__sleep() 就表示当你执行serialize()这个序列化函数之前时的事情，就像一个回调函数  返回的是需要序列化的数据 
  如果没有则默认全部属性
*/
	public function __sleep()
	{
		// $this->name="你猜猜我用的是什么";
		return array('name','age');
	}

	public function __wakeup()
	{
		$this->name="返回来了";
	}


	public function test(){
		// echo self::sex;
		echo $this->age;
		// self::get_pro();
		// $this->get_pro();
		// var_dump($this);
	}
}

$chainoperation=new chainoperation('22','刘亦菲');
// echo $chainoperation->trim('你')->name;//__call的作用
// $chainoperation->timestamp='一班';//__set
// echo $chainoperation->timestamp;//__get

$content=serialize($chainoperation);
echo $content;
$chainoperation->test()."<br>";
var_dump(unserialize($content));
$chainoperation->test()."<br>";

/*@1 
*类外直接调用会报错
*echo $chainoperation->age;
*/

/*@2 
*类外直接调用
*echo $chainoperation->name;
*/

/*
@3 通过内部使用 公有方法修改类内的私有属性来达到类外修改私有属性的功能 当然__construct()也可以
$chainoperation->publicname(11,'刘亦菲');
*/

/*
*获取对象的属性和方法 有两种方法
*1 通过get_object_vars()
*2 通过反射机制 ReflectionClass()
*/
