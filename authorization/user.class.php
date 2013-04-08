<?php namespace com\authorization;
class user{
	public $identity = null;
	public $identity_type = null;
	function __construct($identity, $identity_type = 0){
		$this->identity = $identity;
		$this->identity_type = $identity_type;
	}
}
class identity_object{
    public $id;
    function __construct($id = 0){
        $this->id = $id;
    }
}
?>