<?php namespace com\authorization;

/**
* name: 验证器
* description: 
* author: zhouao
* date: 2013/1/5
*/
class validator {
	
	protected $certifiable;
	public $storage;
	protected $checked = false;
	
	public static $objects;
	public static $operation_parent_ids;
	
	function __construct($id, $storage = null){
		$this->storage = $storage;
		$this->load($id);
	}
	
	public static function getnew($id, $storage = null){
		if($storage == null){			
			$storage = storage_wrapper::get_default();
		}
		$validator = new validator($id, $storage);
		return $validator;
	}
	
	public function load($id, $objects = null, $operation_parent_ids = null){
		$this->certifiable = $this->storage->get_certifiable($id);
		$this->checked = $this->is_valid();
		if(self::$objects == null){
			self::$objects = $this->storage->get_objects();
		}
		if(self::$operation_parent_ids == null){
			self::$operation_parent_ids = $this->storage->get_operation_parent_ids();
		}
	}
	
	protected function is_valid(){
		return (
			($certifiable = $this->certifiable) != null && 
			($detail = $certifiable->detail) != null && 
			($session = $certifiable->session) != null && 
			$session->is_valid()
		);
	}
	
	public function is_allow($object_id, $operation_id, $range = null , $items = null){
		if($this->checked == false){
			return false;
		}
		$apply_object = $this->get_object($object_id);
		$operation_ids = $this->get_operation_ids($operation_id);
		$is_allow = false;
		$is_forcedown = null;

		foreach($apply_object->parents as $object){
			$current_certifiable_item = &$this->certifiable->children[$object->id];
			foreach($operation_ids as $opid){				
				$permission = $current_certifiable_item->permissions[$opid];
				if($permission != null){
					if($permission->is_denied){
						$is_allow = !$permission->is_denied;
					}
					if($permission->is_forcedown || $object_id == $object->id){
						if($is_allow){
							foreach($permission->scopes as $scope){
								if($range != null){
									if($scope->is_deined == ($range->begin <= $scope->range->begin && $range->end >= $scope->range->end)){
										return false;
									}
								}
								if($items !=null){
									if($scope->is_denied == (array_intersect($items, $scope->items) == count($items))){
										return false;
									}
								}
							}
							return true;
						}else{
							return false;
						}					
					}
				}else{
					$is_allow = false;
				}
			}
		}
		return $is_allow;
	}	
	
	public function get_permissions($object_id){
		$ids = array_keys($this->get_object($object_id)->parents);
		$ids[] = $object_id;
		return $this->certifiable->get($ids)->permissions;
	}
	
	public function get_object($id){
		return self::$objects[$id];
	}
	
	public function get_operation_ids($id){
		$ids = array($id);
		$pid = $id;
		while(($pid = self::$operation_parent_ids[$pid]) >= 0){
			$ids[] = $pid;
		}
		return $ids;
	}
}
?>