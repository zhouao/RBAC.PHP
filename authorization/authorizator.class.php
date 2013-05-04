<?php namespace com\authorization;

/**
* name: 授权器
* description: 
* author: zhouao
* date: 2013/1/5
*/
class authorizator {
	
	protected $certifiable;
	public $session_id;
	public $session;
	public $storage;
	
	function __construct($session_id = null, $certifiable = null, $storage = null){
		$this->session_id = $session_id;
		$this->set_certifiable($certifiable);
		$this->storage = $storage;
	}
	
	public static function get_new($session_id, $storage){
		$certifiable = $storage->get_certifiable($session_id);
		$authorizator = new authorizator($session_id, $certifiable, $storage);
		$authorizator->session = $certifiable->session;
		return $authorizator;
	}

	public function is_allowed($path_ids, $operation_id = 0){
		if($path_ids!=null){
			$permissions = $this->certifiable->get_permissions($path_ids);
			$permission = $permissions[$operation_id];
			return $permission!=null && !$permission->is_denied;
		}
		return false;
	}

	public function is_available(){
		return $this->is_saved() && time() < $this->certifiable->session->expire_time;
	}

	public function is_saved(){
		return $this->certifiable != null;
	}


	public function set_session($identity, $identity_type = 0, $roles = null, $timeout = 3600){
		$this->session = new session($this->session_id, $identity, $identity_type, $roles, time() + $timeout);
	}

	public function get_certifiable(){
		return $this->certifiable;
	}
	
	public function set_certifiable($certifiable){
		$this->certifiable = $certifiable;
	}
	
	public function save($storage = null){
		if($storage == null){
			if($this->storage == null){
				$this->storage = storage_wrapper::get_default();
			}
			$storage = $this->storage;
		}
		$certifiable = $this->certifiable;
		$certifiable->session = $this->session;
		$storage->save_certifiable($certifiable);
	}

	public function clear($storage = null){
		if($storage == null){
			if($this->storage == null){
				$this->storage = storage_wrapper::get_default();
			}
			$storage = $this->storage;
		}
		$storage->delete_certifiable($this->session_id);
	}
}
?>
