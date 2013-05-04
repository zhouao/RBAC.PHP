<?php namespace com\authorization;
/**
* name: 授权状
* description: 
* author: zhouao
* date: 2013/1/5
*/
class certifiable {
	public $session = null;
	public $detail = null;
	
	function __construct($detail = null, $session = null){
		$this->session = $session;
		if($detail == null){
			$detail = new certifiable_item(new object(0));
		}
		$this->detail = $detail;
	}
	
	public function get_id(){
		return $this->session->id;
	}

	public function add($item){
        if($item->object==null){
            return;
        }
		$current_node = $this->detail;
        if($item->object->parents!=null){
            foreach($item->object->parents as $parent){
                $parent_id = $parent->id;
                $current_node = &$current_node->children[$parent_id];
                if($current_node == null){
                    $current_node = new certifiable_item(new object($parent_id));
                }
            }
        }
		$target_node = &$current_node->children[$item->object->id];
		if ($target_node != null)
        {
            $item->children = $target_node->children;
        }
        $target_node = $item;
	}	
	
	public function get_permissions($path_ids){
		$current_node = $this->detail;
		$permissions = array();
		foreach($path_ids as $id){
			$current_node = $current_node->children[$id];
			if($current_node == null){
				break;
			}
			if($current_node->permissions!=null&&count($current_node->permissions)>0){
				foreach($current_node->permissions as $key=>$permission){
					$exist_permission = &$permissions[$key];
					if($exist_permission == null || !$exist_permission->is_forcedown){
						$exist_permission = $permission;
					}
				}
			}
		}
		return $permissions;
	}
	public function get($path_ids){
		return $this->get_opeartion_id($path_ids,null);
	}
	public function get_opeartion_id($path_ids, $operation_id){
		$current_node = $this->detail;
		foreach($path_ids as $id){
			$current_node = $current_node->children[$id];
			if($current_node == null){
				return null;
			}
			if($operation_id!=null){
				$permission = $current_node->permissions[$operation_id];
				if($permission!=null){
					if($permission->is_forcedown){
						break;
					}
				}
				
			}
		}
		return $current_node;
	}
	
	public function get_by_path($path){
		$ids = explode($path, ",");
		return $this->get($ids);
	}
}
?>
