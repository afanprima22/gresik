<?php

class My_Model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    function check_exist_user($username, $password){
        $this->db->select('a.*');
        $this->db->from('users a');
        $this->db->where("user_username ='".$username."' AND user_password = md5('".$password."')");

        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row();
        else return false;
    }

    function check_username_exist($username){
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where("username ='".$username."'");

        $query = $this->db->get();

        if($query->num_rows() > 0)
            return $query->row();
        else return false;
    }
    
    function select($select = NULL,$table = NULL,$limit = NULL,$like = NULL,$order = NULL,$join = NULL,$where = NULL,$where2 = NULL,$group_by = NULL) {
        $this->db->select($select);
        $this->db->from($table);
        if ($join) {
            for ($i=0; $i<sizeof($join['data']) ; $i++) { 
                $this->db->join($join['data'][$i]['table'],$join['data'][$i]['join'],$join['data'][$i]['type']);
            }
        }
        if ($where) {
            for ($i=0; $i<sizeof($where['data']) ; $i++) { 
                $this->db->where($where['data'][$i]['column'],$where['data'][$i]['param']);
            }
        }
        if ($where2) {
            $this->db->where($where2);
        }
        if ($like) {
            for ($i=0; $i<sizeof($like['data']) ; $i++) { 
                $this->db->like('CONCAT_WS(" ", '.$like['data'][$i]['column'].')',$like['data'][$i]['param']);
            }
        }
        if ($limit) {
            $this->db->limit($limit['finish'],$limit['start']);
        }
        if ($order) {
            for ($i=0; $i<sizeof($order['data']) ; $i++) { 
                $this->db->order_by($order['data'][$i]['column'], $order['data'][$i]['type']);
            }
        }
        if ($group_by) {
            $this->db->group_by($group_by);
        }
        
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query;
        else
            return false;
    }
    
    function insert_data_table($table, $where, $data){
        if ($where) {
            for ($i=0; $i<sizeof($where['data']) ; $i++) { 
                $this->db->where($where['data'][$i]['column'],$where['data'][$i]['param']);
            }
        }
        $this->db->insert($table, $data);
        $error = $this->db->error();
        $result = new stdclass();
        if ($this->db->affected_rows() > 0 or $error['code']==0){
            $result->status = true;
            $result->output = $this->db->insert_id();
        }
        else{
            $result->status = false;
            // if($error['code'] <> 0)
            $result->output = $error['code'].': '.$error['message'];
        }

        return $result;
    }
    
    function update_data_table($table, $where, $data,$where2 = NULL){
        if ($where) {
            for ($i=0; $i<sizeof($where['data']) ; $i++) { 
                $this->db->where($where['data'][$i]['column'],$where['data'][$i]['param']);
            }
        }

        if ($where2) {
            $this->db->where($where2);
        }

        $this->db->update($table, $data);
        $error = $this->db->error();
        $result = new stdclass();
        if ($this->db->affected_rows() > 0 or $error['code']==0){
            $result->status = true;
            // $result->output = $this->db->insert_id();
        }
        else{
            $result->status = false;
            $result->output = $error['code'].': '.$error['message'];
        }

        return $result;
    }
    
    function delete_data_table($table, $where){
        if ($where) {
            for ($i=0; $i<sizeof($where['data']) ; $i++) { 
                $this->db->where($where['data'][$i]['column'],$where['data'][$i]['param']);
            }
        }
        $this->db->delete($table);
        $error = $this->db->error();
        $result = new stdclass();
        if ($this->db->affected_rows() > 0 or $error['code']==0){
            $result->status = true;
            // $result->output = $this->db->insert_id();
        }
        else{
            $result->status = false;
            $result->output = $error['code'].': '.$error['message'];
        }

        return $result;
    }

    function list_menu_lv1($id) {
        $query = "select a.* from side_menus a where a.side_menu_level = $id 
                  ";
        $query = $this->db->query($query);
        //query();
        if ($query->num_rows() == 0)
            return array();
        $data = $query->result_array();
        foreach ($data as $index => $row) {}
        return $data;
    }
    
    function parent_menu($id,$parent_id) {
        $query = "select b.permit_acces,c.* from users a
                  join permits b on b.user_type_id = a.user_type_id
                  join side_menus c on c.side_menu_id = b.side_menu_id
                  where a.user_id = $id and c.side_menu_parent = $parent_id and b.permit_acces != '' 
                  ";
                  
        $query = $this->db->query($query);
        
        //query();
        if ($query->num_rows() == 0)
            return array();
        $data = $query->result_array();
        foreach ($data as $index => $row) {}
        return $data;
    }

    function read_employee_id($id) {
        $query = "select a.employee_id from employees a 
                  join users b on b.employee_id = a.employee_id
                  where user_id = $id 
                  ";
                  
        $query = $this->db->query($query);
        
        //query();
        $result = null;
        foreach ($query->result_array() as $row) $result = ($row);
        return $result['employee_id'];
    }

    function get_user_acces($id,$menu_id) {
        $query = "select a.*,b.permit_acces,c.side_menu_type_parent from users a
                  join permits b on b.user_type_id = a.user_type_id
                  join side_menus c on c.side_menu_id = b.side_menu_id
                  where a.user_id = $id and b.side_menu_id = $menu_id
                  ";
        $query = $this->db->query($query);
        $result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
        foreach($query->result_array() as $row) $result = ($row); // render dulu dunk!
        return $result; 
    }

    function get_img($table, $column, $param){

        $sql = "select $column as result from $table where $param";
        
        $query = $this->db->query($sql);
        
        $result = null;
        foreach ($query->result_array() as $row) $result = ($row);
        return $result['result'];
    }

    function update_data_stock($tbl,$columb_stock,$columb_where,$value,$id,$where2 = NULL){
        $sql = "update $tbl set $columb_stock = $columb_stock - $value where $columb_where = $id $where2";
        $this->db->query($sql);
    }

    function read_data($select,$table,$columb,$id,$columb2 = NULL,$id2 = NULL)
    {
        $this->db->select($select, 1); // ambil seluruh data
        $this->db->where($columb, $id);
        if ($columb2) {
            $this->db->where($columb2, $id2);
        }
        $query = $this->db->get($table, 1); // parameter limit harus 1
        $result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
        foreach($query->result_array() as $row) $result = ($row); // render dulu dunk!
        return $result; 
    }

    function list_menu($id) {
        $query = "select a.* from side_menus a where a.side_menu_parent = $id 
                  ";
        $query = $this->db->query($query);
        //query();
        if ($query->num_rows() == 0)
            return array();
        $data = $query->result_array();
        foreach ($data as $index => $row) {}
        return $data;
    }

    function select_manual($sql = NULL) {
        $query = $this->db->query($sql);
        $result = null; // inisialisasi variabel. biasakanlah, untuk mencegah warning dari php.
        foreach($query->result_array() as $row) $result = ($row); // render dulu dunk!
        return $result; 
    }

    function select_manual_for($sql = NULL) {
        $query = $this->db->query($sql);
        if($query->num_rows() > 0)
            return $query;
        else
            return false;
    }

}