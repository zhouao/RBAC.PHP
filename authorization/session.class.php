<?php namespace com\authorization;
//session:会话主要对应身份
class session{
	public $id = null;
	public $user = null;
	public $roles = null;
	//会话创建时间，使用时间戳
	public $created_time = null;
	//会话过期时间，使用时间戳
	public $expire_time = null;
	
	function __construct($id, $identity, $identity_type, $roles, $expire_time){
        $this->id = $id;
		$this->user = new user($identity, $identity_type);
		$this->roles = $roles;
		$this->created_time = time();
		$this->expire_time = $expire_time;
	}
	
	public function is_valid(){
		return $this->user != null && !$this->is_expired();
	}
	
	public function is_expired(){
		return time() > $this->expire_time;
	}
}
?>