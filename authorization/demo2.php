<?php namespace com\authorization;
require_once("object.class.php");
require_once("certifiable_item.class.php");
require_once("certifiable.class.php");
require_once("data_access.class.php");
require_once("permission.class.php");
require_once("authorizator.class.php");
require_once("io/storage.class.php");
require_once("storage_wrapper.class.php");
require_once("session.class.php");
require_once("user.class.php");
require_once("validator.class.php");
$storage = storage_wrapper::get_default();
$validator = validator::ge_tnew("20130112", $storage);

var_dump($validator);
exit;
class member{
    public static $DEFAULT_NAME = "wangyuan";
    public $id;
    public $name;
    public $password;
    public $profile;
	public $output_method;
	
    public function output(){
		echo self::$DEFAULT_NAME;
    }
}

$member = new member();
$member->id = "10086";
$member->name = "chinamobile";
$member->password = "123456";
$member->output();

define("NAME_EN", "John");
const NAME = "ZhouAo";

var_dump(NAME_EN);
var_dump(NAME);
var_dump($member);


$operation_parent_ids=array(
100 => 80,
80 => 60,
60 => 30,
30 => 10,
10 => 0
);

function get_operation_ids($id){
	global $operation_parent_ids;
	$ids = array();
	$pid = $id;		
	while($pid > 0){
		$ids[] = $pid;
		$pid = $operation_parent_ids[$pid];
	}
	return $ids;
}
var_dump(get_operation_ids(100));


interface i_car {
	public function run($name = null);
}

class fly_car implements i_car {
	public function run($name = "zhouao"){
		echo "<input value='".$name."'/>";
	}
}

$fly_car = new fly_car();
$fly_car->run();


require_once("data_access.class.php");

$users = data_access::get_new()->query("select * from rbac_users");
var_dump($users);
?>