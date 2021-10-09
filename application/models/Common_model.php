<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model {

    // get table count
    public function get_count($table){

        return $this->db->count_all($table);
    }

    // get id by slug
    public function getIdBySlug($where,$table){

        $this->db->select('id');
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        $row=$query->result();
        return $row[0]->id;
    }

    public function getMaxId($table,$where=''){
        if($where==''){
            $this->db->select_max('id');
            $this->db->from($table);
            $query = $this->db->get();
            $row=$query->result();
            return $row[0]->id; 
        }
        else{
            $this->db->select_max('id');
            $this->db->from($table);
            $this->db->where($where);
            $query = $this->db->get();
            $row=$query->result();
            return $row[0]->id; 
        }
        
    }

    // get table count
    public function get_count_by_ids($where,$table){
        $this->db->from($table);
        $this->db->where($where);
        return $num_rows = $this->db->count_all_results();
    }


    //-- insert function
	public function insert($data,$table){
        $this->db->insert($table,$data);        
        return $this->db->insert_id();
    }

    //-- edit function
    function edit_option($action, $id, $table){
        $this->db->where('id',$id);
        $this->db->update($table,$action);
        return;
    } 

    //-- update function
    function update($action, $id, $table){
        $this->db->where('id',$id);
        $this->db->update($table,$action);
        return true;

    } 

    // update by multiple ids
    function updateByids($data, $ids, $table){
        $this->db->where($ids);
        $this->db->update($table,$data);
        return true;
    } 

    // update by in Operator
    function updateByIn($data, $ids, $table){
        $this->db->where_in('id', $ids);
        $this->db->update($table,$data);
        // echo $this->db->last_query();
        return true;
    } 

    //-- delete function
    function delete($id,$table){
        $this->db->delete($table, array('id' => $id));
        return true;
    }

    //-- delete by ids
    function deleteByids($where,$table){
        $this->db->delete($table, $where);
        return true;
    }

    //-- select function
    function select($table,$sort='ASC'){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->order_by('id',$sort);
        $query = $this->db->get();
        $row=$query->result();  
        return $row;
    }

    //-- select function
    function selectWhere($table,$where,$sort='ASC',$sort_by='id'){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        $this->db->order_by($sort_by,$sort);
        $query = $this->db->get();
        $row=$query->result();  
        return $row;
    }

    //-- select by id
    function selectByid($id,$table){

        $this->db->select();
        $this->db->from($table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        $row=$query->result();
        if(!empty($row))
            return $row[0];
        else
            return false;
    }

    // select by in operator
    function selectByidsIN($ids,$table, $limit='', $start='', $brands='',$order_by=''){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where_in('status', '1');
        $this->db->where_in('id', $ids);
        if($brands!=''){
            $ids=explode(',', $brands);
            $this->db->where_in('brand_id', $ids);
        }
        if($limit!=0 OR $limit!=''){
          $this->db->limit($limit, $start);
        }
        
        $query = $this->db->get();

        // echo $this->db->last_query();

        return $row=$query->result();
    }

    // select by in operator
    function selectByidsINWhere($ids,$table, $limit='', $start=''){
        $this->db->select('*');
        $this->db->from($table);
        if($limit!=0){
          $this->db->limit($limit, $start);
        }
        $query = $this->db->get();
        
        // echo $this->db->last_query();

        return $row=$query->result();
    }

     //-- select by id with parametes
    function selectByidParam($id,$table,$param){
        $this->db->select();
        $this->db->from($table);
        $this->db->where('id', $id);
        $query = $this->db->get();
        $row=$query->result();
        if($row)
            return $row[0]->$param;
        else
            return '';
    }

    //-- select by ids with parametes
    function selectByidsParam($ids,$table,$param){
        $this->db->select();
        $this->db->from($table);
        $this->db->where($ids);
        $query = $this->db->get();
        $row=$query->result();
        if($row)
            return $row[0]->$param;
        else
            return '';
        
    }

    //-- select by ids
    function selectByids($ids,$table,$sort_by='',$sort='DESC', $limit=0, $start=''){
        $this->db->select();
        $this->db->from($table);
        $this->db->where($ids);
        if($sort_by!=''){
            $this->db->order_by($sort_by,$sort);
        }
        if($limit!=0){
          $this->db->limit($limit, $start);
        }
        $query = $this->db->get();
        $query = $query->result(); 

        // echo $this->db->last_query();

        return $query;
    } 

    public function check_email($email, $type='Normal', $auth_id=NULL){

        if(is_null($auth_id)){
            $sql = "SELECT * FROM `tbl_users` WHERE `user_type` LIKE '$type' AND `user_email` = '$email' LIMIT 1";
        }
        else{
            $sql = "SELECT * FROM `tbl_users` WHERE `user_type` LIKE '$type' AND (`user_email` = '$email' OR `auth_id` = '$auth_id') LIMIT 1";
        }

        $query = $this->db->query($sql);
        if($query->num_rows() == 1) {
            return $query->result();
        }else{
            return false;
        }
    }

    public function get_addresses($user_id,$is_default=false){

        if($is_default)
            $where = array('user_id' => $user_id,'is_default' => 'true');
        else
            $where = array('user_id' => $user_id);

        $this->db->select('*');
        $this->db->from('tbl_addresses');
        $this->db->where($where);
        $this->db->order_by('is_default','DESC');
        $query = $this->db->get();

        // echo $this->db->last_query();
        
        return $query->result();
    }

    public function check_cart($cart_ids){

        $this->db->select('*');
        $this->db->from('tbl_cart');
        $this->db->where_in('id', $cart_ids);
        $query = $this->db->get();
        return $row=$query->result();
    }

    public function cart_items($product_id, $user_id){

        $where = array('product_id ' => $product_id , 'user_id' => $user_id);

        $this->db->select('*');
        $this->db->from('tbl_cart');
        $this->db->where($where);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function cart_item($cart_id){
        $where = array('id' => $cart_id);
        $this->db->select('*');
        $this->db->from('tbl_cart');
        $this->db->where($where);
        $query = $this->db->get();
        if($row=$query->result()){
            return $row[0];    
        }
        else
            return false;
        
    }

    public function cart_tmp_item($cart_id){
        $where = array('id' => $cart_id);
        $this->db->select('*');
        $this->db->from('tbl_cart_tmp');
        $this->db->where($where);
        $query = $this->db->get();
        $row=$query->result();
        if($row=$query->result()){
            return $row[0];    
        }
        else
            return false;
    }


    

}