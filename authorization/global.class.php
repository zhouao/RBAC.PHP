<?php namespace com\authorization;
class global_stack {
	public $objects;
	public $parent_ids;
}
const KEY_GLOBAL = "com.authorization.global_stack";
$global = apc_fetch(KEY_GLOBAL);
?>