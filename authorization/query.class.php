<?php namespace com\authorization;

class query{
	public $object_id = 0;
	public $operation_id = 0;
	public $range = null; // example: array(array("begin"=>0,"end"=>100),array("begin"=>200,"end"=>400))
	public $items = null;
}
?>