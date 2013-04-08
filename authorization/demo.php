<?php namespace com\authorization;
require_once("data.class.php");
require_once("authorizator.class.php");
require_once("io/storage.class.php");
require_once("storage_wrapper.class.php");
require_once("session.class.php");

error_reporting(E_WARNING | E_ERROR);
/*
$db = data_access::get_new();


$objects = array((object)array("id"=>0));
$certifiable = new certifiable($objects[0]);


$rows = $db->query("select * from rbac_objects");
foreach($rows as $row){
	$object = new object($row->id);
	if($row->parent_id > 0 && $row->parents_path > ""){
		$parent_ids = explode(",", $row->parents_path);
		foreach($parent_ids as $parent_id){
			$object->parents[] = &$objects[$parent_id];
		}
	}
	$objects[$object->id] = $object;
}

//print_r($objects);exit;

$certifiable_items = array();

$permissions = array();//以permission.id为索引
$rows = $db->query("select * from rbac_permissions");
foreach($rows as $row){
	$permission = new permission();
	$permission->is_forcedown = (bool)$row->is_forcedown;
	$permission->is_denied = (bool)$row->is_forcedown;
	$certifiable_item = &$certifiable_items[$row->object_id];
	if($certifiable_item == null){
       // if($objects[$row->id]){echo $row->object_id;exit;}
        $object = &$objects[$row->object_id];
        if($object == null){
            $object = new object($row->object_id);
        }
		$certifiable_item = new certifiable_item($object);
	}
	//$certifiable_item->add_permission($row->operation_id, null, $permission->is_forcedown, $permission->is_denied);
	$certifiable_item->add_permission($row->operation_id, $permission);
	$permissions[$row->id] = $permission;
}

foreach($certifiable_items as $certifiable_item){
	$certifiable->add($certifiable_item);
}

$rows = $db->query("select * from rbac_permission_scopes");
foreach($rows as $row){
	$permission = & $permissions[$row->permission_id];
	if($permission == null){
		$permission = new permission();
	}
	if($permission->scopes == null){
		$permission->scopes = array();
	}
	$scope = new permission_scope();
	if($row->begin != null || $row->end != null){
		$scope->range = (object)array("begin" => $row->begin, "end" => $row->end);
	}

	if($row->items != null){
		$scope->items = explode(",", $row->items);
	}
	$scope->is_denied = (bool)$row->is_denied;
	$permission->scopes[] = $scope;
}

//var_dump($certifiable);

*/

$data = data::create_by_user(14,1);
$storage = storage_wrapper::get_default();
$authorizator = authorizator::get_new("20130112", $storage);
if(!$authorizator->is_logined()){
    $data->load_certifiable();
    $authorizator->set_certifiable($data->certifiable);
    $authorizator->set_session(array("username"=>"cccccc", "email"=>"zhouao@zhouao.com"));
    $authorizator->save();
}else{
    //print_r($authorizator);
    print_r($authorizator);
    echo $authorizator->is_allowed($data->get_path_ids("personal.basic.myaccount"),0);

}
?>