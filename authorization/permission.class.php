<?php namespace com\authorization;
class permission{
	//public $id = 0;
	//public $operation_id = 0;
	public $scopes;
	public $is_forcedown = false;
	public $is_denied = true;
}
class permission_scope{
	public $range; // array("begin"=>1,"end"=>1000)
	public $items;
	public $is_denied;
	function __construct($range = null, $items = null, $is_denied = true) {
		$this->range = $range;
		$this->items = $items;
		$this->is_denied = $is_denied;
	}
}
?>