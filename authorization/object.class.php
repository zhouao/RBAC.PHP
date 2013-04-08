<?php namespace com\authorization;

class object{
	public $id;
	public $parents;
	function __construct($id = 0, $parents = null){
		$this->id = $id;
		$this->parents = $parents;
	}
	//public $children;
}
?>