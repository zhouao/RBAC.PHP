<?php
class member{
	public static $DEFAULT_NAME = "wangyuan";
	public $id;
	public $name;
	public $password;
	public $profile;
}
class profile{
	public $id;
	public $member_id;
	public $name;
	public $age;
	public $email;
	public $address;
}

$member = new member();
$member->id = 1;
$member->name = "zhouao";
$member->password = "123456";
?>