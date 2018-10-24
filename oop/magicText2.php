<?php 
/**
 * 魔术方法的测试 
 */
class A 
{
	public $name;
	private $age=12;
	
}

class B extends A
{
	public $sex;
	private $class;
	function __construct($name,$sex)
	{
		$this->name=$name;
		$this->sex=$sex;
	}

	public function text(){
		var_dump(get_object_vars($this));
		echo $this->age;
	}
}

$b=new B('刘亦菲','女');
$b->text();
