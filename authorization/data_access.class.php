<?php namespace com\authorization;
interface i_data_access {
	public function initialize($connection = null);
	public function query($expression);
	public function close();
}

class data_access implements i_data_access {
	public $database_scheme = "mysqli";
	
	public $db_proxy;
	
	protected static $instance;
	
	public static function get_new($use_cache = false, $is_initialize = true){
		if($use_cache && self::$instance !=null){
			return self::$instance;
		}		
		$instance = new mysqli_data_access();
		if($is_initialize){
			$instance->initialize();
		}
		if($use_cache){
			self::$instance = $instance;
		}
		return $instance;
	}
	
	public function initialize($connection = null){
		return $this->db_proxy->initialize();
	}
	
	public function query($expression){
		return $this->db_proxy->query($exprsesion);
	}
	
	public function close(){
		return $this->db_proxy->close();
	}
}

class mysqli_data_access implements i_data_access {
	protected $connection;
	protected $hostname = null;
	protected $username = null;
	protected $password = null;
	protected $database = "rbac";
	
	public function initialize($connection = null){
		if($connection == null){
			$connection = new \mysqli($this->hostname, $this->username, $this->password, $this->database);
		}
		$this->connection = $connection;
		$this->connection->query("set names utf8;");
	}
	public function query($expression){
		$query = $this->connection->query($expression);
		if($query == null){
			return null;
		}
		if(is_scalar($query)){
			return $query;
		}
		if(is_object($query)){
			$rows = array();
			while($row = $query->fetch_object()){
				$rows[] = $row;
			}
			return $rows;
		}
		return null;
	}
	public function close(){
		$this->connection->close();
	}
}

class mysql_data_access implements i_data_access {
	protected $connection;
	protected $hostname = null;
	protected $username = null;
	protected $password = null;
	protected $database = "rbac";
	
	public function initialize($connection = null){
		if($connection == null){
			$connection = mysql_connect($this->hostname, $this->username, $this->password);
		}
		$this->connection = $connection;
		mysql_select_db($this->database, $connection);
		mysql_query("set names utf8;", $this->connection);
	}
	public function query($expression){
		$query = mysql_query($expression, $this->connection);
		if($query == null){
			return null;
		}
		if(is_scalar($query)){
			return $query;
		}
		if($query){
			$rows = array();
			while($row = mysql_fetch_assoc($query)){
				$rows[] = (object)$row;
			}
			return $rows;
		}
		return null;
	}
	public function close(){
		mysql_close($this->connection);
	}
}
?>