<?php namespace com\authorization;

class certifiable_item{
	//array
	public $object;
	public $permissions;
	public $children = array();
	
	function __construct(&$object = null, $permissions = array()) {
		$this->object = &$object;
		$this->permissions = $permissions;
	}
	
	public function add_permission($operation_id, $permission){
		$this->permissions[$operation_id] = $permission;
	}

	/*public function add_permission($operation_id, $scopes, $is_forcedown, $is_denied) {
		$permission = &$this->permissions[$operation_id];
		if($permission == null){
			$permission = new permission();
		}
		$permission->scopes = $scopes;
		if(!$permission->is_forcedown){
			$permission->is_forcedown = $is_forcedown;
		}
		if(!$permission->is_denied){
			$permission->is_denied = $is_denied;
		}
	}*/
	
	/*
	public function to_expression_string(){
		
	}
	
	public function to_xml_string(){
	
	
		$xml = "<data>";
		
		$xml .= "<objects>";
		foreach($this->objects as $object){
			$xml .= "<object id=\"".$object->id."\"/>";
		}
		$xml .= "</objects>";
		
		$xml .="<permissions>";
		foreach($this->permissions as $permission){
			$xml .= "<permission id='".$permission->id."'/>";
		}
		$xml .="</permissions>";
		
		$xml .="</data>";
		
	}
	*/
}
?>