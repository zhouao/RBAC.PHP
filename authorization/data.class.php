<?php namespace com\authorization;
require_once("object.class.php");
require_once("certifiable_item.class.php");
require_once("certifiable.class.php");
require_once("permission.class.php");
require_once("user.class.php");
require_once("data_access.class.php");
//use com\authorization\data_access;

/**
 * name: 统一数据模型
 * description:
 * author: zhouao
 * date: 2013/3/30
 */
class data {
    public $objects = null;
    public $certifiable = null;
    public $certifiable_items = array();
    public $permissions = array(); //以permission.id为索引
    public $owner = null;
    public $roles = null;
    public $role_type = 11;

    public $db = null;
    private function __construct(){
        $this->objects = array((object)array("id"=>0));
        $this->certifiable = new certifiable($this->objects[0]);
        $this->db = data_access::get_new();
    }

    public static function create_by_user($identity, $identity_type){
        $data = new data();
        $data->owner = new user($identity, $identity_type);
        return $data;
    }

    public static function create_by_session($session){
        $data = self::create_by_user($session->user->identity, $session->user->identity_type);
        $data->roles = $session->roles;
        return $data;
    }
    private function get_role_ids(){
        $ids = null;
        if($this->roles!=null){
            foreach($this->roles as $role){
                $ids[] = $role->id;
            }
        }
        return $ids;
    }

    public function load_objects(){
        $object_ids = array_keys($this->objects);
        $sql="select parents_path from rbac_objects where id in (".(join(",",$object_ids)).")";
        $rows = $this->db->query($sql);
        foreach($rows as $row){
            if($row->parents_path<=""){continue;}
            $ids = explode(",",$row->parents_path);
            if($ids==null){continue;}
            foreach($ids as $id){
                $object_ids[] = $id;
            }
        }
        $object_ids = array_unique($object_ids);
        $sql="select * from rbac_objects where id in (".(join(",",$object_ids)).")";
        //print_r($object_ids);exit;
        $rows = $this->db->query($sql);
        foreach($rows as $row){
            $object = new object($row->id);
            if($row->parent_id > 0 && $row->parents_path > ""){
                $parent_ids = explode(",", $row->parents_path);
                foreach($parent_ids as $parent_id){
                    $object->parents[] = &$this->objects[$parent_id];
                }
            }
            $this->objects[$object->id] = $object;
        }
        //print_r($this->objects);
    }

    public function load_permissions(){
        $sql ="select * from rbac_permissions where (owner_id='{$this->owner->identity->id}' and owner_type='{$this->owner->identity_type}')";
        $role_ids = $this->get_role_ids();
        if($role_ids!=null){
            $sql.=" or (owner_id in ('".(join(',',$role_ids))."') and owner_type='{$this->role_type}')";
        }
        $rows = $this->db->query($sql);
        foreach($rows as $row){
            $permission = new permission();
            $permission->is_forcedown = (bool)$row->is_forcedown;
            $permission->is_denied = (bool)$row->is_denied;
            $certifiable_item = &$this->certifiable_items[$row->object_id];
            if($certifiable_item == null){
                $object = &$this->objects[$row->object_id];
                //if($object == null){
                //    $object = new object($row->object_id);
                //}
                $certifiable_item = new certifiable_item($object);
            }
            $certifiable_item->add_permission($row->operation_id, $permission);
            $this->permissions[$row->id] = $permission;
        }
    }

    public function load_permission_scopes(){
        $sql="select * from rbac_permission_scopes where (owner_id='{$this->owner->identity->id}' and owner_type='{$this->owner->identity_type}')";
        $role_ids = $this->get_role_ids();
        if($role_ids!=null){
            $sql.=" or (owner_id in ('".(join(',',$role_ids))."') and owner_type='{$this->role_type}')";
        }
        $rows = $this->db->query($sql);
        foreach($rows as $row){
            $permission = & $this->permissions[$row->permission_id];
            if($permission == null){
                $permission = new permission();
            }
            if($permission->scopes == null){
                $permission->scopes = array();
            }
            $scope = new permission_scope();
            if($row->begin != null || $row->end != null){
                $scope->range = (object)array("begin" => $row->begin, "end" => $row->end);
            }

            if($row->items != null){
                $scope->items = explode(",", $row->items);
            }
            $scope->is_denied = (bool)$row->is_denied;
            $permission->scopes[] = $scope;
        }
    }

    public function load_certifiable(){
        //$this->load_objects();
        $this->load_permissions();
        $this->load_objects();
        //print_r($this->objects);exit;
        $this->load_permission_scopes();
        foreach($this->certifiable_items as $certifiable_item){
            $this->certifiable->add($certifiable_item);
        }
    }

    public function get_path_ids($key){
        $row = $this->db->query("select id,parents_path from rbac_objects where `key`='$key' limit 1")[0];
        if($row!=null && $row->parents_path>""){
            return explode(",", trim($row->parents_path.",".$row->id,','));
        }else{
            return null;
        }
    }
}
?>