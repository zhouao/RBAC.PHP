<?php namespace com\authorization\io;
interface i_storage{
    //启动存储器
    public function start();
    
    //根据key读取数据
    public function read($key);
    
    //按key写入数据
    public function write($key, $value, $timeout = 0);
    
    //根据key删除数据
    public function delete($key);
    
    //清除数据
    public function clear();
    
    //保存到存储设备
    public function save();
    
    //停止存储器
    public function stop();
}

class storage implements i_storage{
    protected $proxy;
    const DEFAULT_PROVIDER_SCHEME = "Memcache";
    
    function __construct($provider){
        $this->proxy = $provider;
    }
    
	public static function get_new($scheme = null){
		if($scheme == null || $scheme <= ""){
            $scheme = self::DEFAULT_PROVIDER_SCHEME;
        }
        switch($scheme){
            case "memcache":
                $provider = new memcache_storage();
            break;
			case "apc":
				$provider = new apc_storage();
				break;
            case "mysql":
                $provider = new mysql_storage();
            break;
            case "file":
                $provider = new file_storage();
            break;
            default:
				if($scheme == null || $scheme <= ""){
                    $provider = new variable_storage();
                }else{
                    $provider_classvname = $scheme."storage";
                    $provider = new $provider_class_name();
                }
            break;
        }
        return new storage($provider);
    }
    
    public function start(){
        return $this->proxy->start();
    }

    public function read($key){
        return $this->proxy->read($key);
    }
    
    public function write($key, $value, $timeout = 0){
        return $this->proxy->write($key, $value, $timeout);
    }
    
    public function delete($key){
        return $this->proxy->delete($key);
    }
    
    public function clear(){
        return $this->proxy->clear();
    }
    
    public function save(){
        return $this->proxy->save();
    }
    
    public function stop(){
        return $this->proxy->stop();
    }
}

class memcache_storage implements i_storage {
	protected $connection = null;
    protected $hostname = null;
    protected $port = 11211;

    public function start(){
        $this->connection = new \Memcache;
        $this->connection->connect($this->hostname, $this->port);
    }

    public function read($key){
        return $this->connection->get($key);
    }
    
    public function write($key, $value, $timeout = 0){
        return $this->connection->set($key, $value, $timeout);
    }
    
    public function delete($key){
        return $this->connection->delete($key);
    }
    
    public function clear(){
        return $this->connection->flush();
    }
    
    public function save(){
       return true;
    }
    
    public function stop(){
       $this->connection->close();
       return true;
    }
}

class mysql_storage {
    protected $connection;
    protected $hostname = null;
    protected $port = 3306;
    protected $database = "rbac";
    protected $username = null;
    protected $password = null; 
    
    const TINY_INT_TYPE = 1;
    const MIDDLE_INT_TYPE = 2;
    const BIG_INT_VALUE = 3;
    
    const TINY_MIXED_TYPE = 4;
    const MIDDLE_MIXED_TYPE = 5;
    const BIG_MIXED_TYPE = 6;
    
    const TINY_STRING_TYPE = 7;
    const MIDDLE_STRING_TYPE = 8;
    const BIG_STRING_TYPE = 9;
    
    public static $type_field_names = array(
		self::TINY_INT_TYPE			=> "tiny_int_value",
		self::MIDDLE_INT_TYPE		=> "middle_int_value",
		self::BIG_INT_TYPE			=> "bigint_value",
		self::TINY_MIXED_TYPE		=> "tiny_mixed_value",
		self::MIDDLE_MIXED_TYPE		=> "middle_mixed_value",
		self::BIG_MIXED_TYPE		=> "big_mixed_value",    
		self::TINY_STRING_TYPE		=> "tiny_string_value",
		self::MIDDLE_STRING_TYPE	=> "middle_string_value",
		self::BIG_STRING_TYPE		=> "big_string_value"
    );

    public function start(){
        $this->connection = new mysqli($this->hostname, $this->username, $this->password, $this->database);
    }
    
	public function read($key){
		$result = $this->connection->query("SELECT * FROM tempstorage WHERE key='".$key."' LIMIT 1");
		$return_value = null;
		if ($row = $result->fetch_assoc())
		{
		   $type = intval($row["type"]);
		   $field_name = self::$type_field_names[$type];
		   $return_value = $row[$field_name];
			if ($return_value != null && $type == TINY_MIXED_TYPE && $type == MIDDLE_MIXED_TYPE && $type == BIG_MIXED_TYPE)
			{
			   $retrn_value=json_decode($return_value);
			}           
		}
		$result->free();
		return $return_value;
	}
    
    public function write($key, $value, $timeout = 0){
    }
    
    public function delete($key){
    }
    
    public function clear(){
    }
    
    public function save(){
    }
    
    public function stop(){
    }
}

class apc_storage {
	//启动存储器
	public function start(){
	}
	
	//根据key读取数据
	public function read($key){
		return apc_fetch($key);
	}
	
	//按key写入数据
	public function write($key, $value, $timeout = 0){
		return apc_store($key, $value, $timeout);
	}
	
	//根据key删除数据
	public function delete($key){
		return apc_delete($key);
	}
	
	//清除数据
	public function clear(){
		return apc_clear();
	}
	
	//保存到存储设备
	public function save(){
	}
	
	//停止存储器
	public function stop(){
	}
}

?>