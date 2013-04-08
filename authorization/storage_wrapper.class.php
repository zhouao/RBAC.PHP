<?php namespace com\authorization;
use com\authorization\io\storage;

/**
* name: 存储器封装
* description: 
* author: zhouao
* date: 2013/1/10
*/
class storage_wrapper{
	protected $objects_storage;
	protected $operation_parents_storage;
	protected $certifiable_storage;
	protected $type = "default";
	protected $prefix = null;
	
	const KEY_CERTIFIABLE_PREFIX = "RBAC.CERTIFIABLE.NO_";
	const KEY_OBJECTS = "COM.AUTHORIZATION.GLOBAL_OBJECTS";
	const KEY_OPERATION_PARENT_IDS = "COM.AUTHORIZATION.GLOBAL_OPERATION_PARENT_IDS";
	
	function __construct($objects_storage, $operation_parents_storage, $certifiable_storage, $type = null){
		$this->objects_storage = $objects_storage;
		$this->operation_parents_storage = $operation_parents_storage;
		$this->certifiable_storage = $certifiable_storage;
		$this->type = $type;
		$this->prefix = strtoupper($this->type).":";
	}
	
	public static function get_default($type = null){		
		$objects_storage = storage::get_new("apc");
		$operation_parents_storage = $objects_storage;
		$certifiable_storage = storage::get_new("memcache");
		
		$objects_storage->start();
		$certifiable_storage->start();
		return new storage_wrapper($objects_storage, $operation_parents_storage, $certifiable_storage, $type);
	}
	
	public function is_objects_saved(){
		
	}
	
	public function get_objects(){
		return $this->certifiable_storage->read($this->prefix.self::KEY_OBJECTS);
	}
	
	public function save_objects($objects){
		return $this->operation_parents_storage->write($this->prefix.self::KEY_OBJECTS, $objects);
	}
	
	public function get_operation_parent_ids(){
		return $this->certifiable_storage->read($this->prefix.self::KEY_OPERATION_PARENT_IDS);
	}
	
	public function save_operation_parent_ids($operation_parent_ids){
		return $this->operation_parents_storage->write($this->prefix.self::KEY_OPERATION_PARENT_IDS, $operation_parent_ids);
	}
	
	public function get_certifiable($id){
		return $this->certifiable_storage->read($this->prefix.self::KEY_CERTIFIABLE_PREFIX.$id);
	}
	
	public function save_certifiable($certifiable, $id = null){
		if($id == null) {
			$id = $certifiable->get_id();
		}
		return $this->certifiable_storage->write($this->prefix.self::KEY_CERTIFIABLE_PREFIX.$id, $certifiable);
	}
}
?>