<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_menu_model extends CI_Model
{

    public function get_list($sortBy='id', $sort='ASC', $limit='', $start='', $keyword=''){

      $this->db->select('header.*');
      $this->db->select('cat.category_name');
      $this->db->select('sub_cat.sub_category_name');
      $this->db->from('tbl_submenu_headers header');
      // $this->db->from('tbl_sub_category sub_cat');
      $this->db->join('tbl_sub_category sub_cat','sub_cat.id = header.sub_category_id','LEFT');
      $this->db->join('tbl_category cat','cat.id = sub_cat.category_id','LEFT');
      if($limit!=''){
        $this->db->limit($limit, $start);
      }
      if($keyword!=''){
        $this->db->like('cat.category_name',stripslashes($keyword));
        $this->db->or_like('sub_cat.sub_category_name',stripslashes($keyword));
        $this->db->or_like('header.submenu_header',stripslashes($keyword));
      }
      $this->db->order_by('header.'.$sortBy,$sort);
      return $this->db->get()->result();

    }

    public function single($id){

      $this->db->select('*');
      $this->db->from('tbl_submenu_headers');
      $this->db->where('id', $id); 
      $this->db->limit(1);
      $query = $this->db->get();
      if($query -> num_rows() == 1){                 
          return $query->result();
      }
      else{
          return false;
      }

    }

    public function get_subcategories($id, $limit='', $start=''){

      $where = array('sub_cat.category_id ' => $id , 'sub_cat.status ' => '1');

      $this->db->select('sub_cat.*');
      $this->db->select('cat.category_name');
      $this->db->from('tbl_sub_category sub_cat');
      $this->db->join('tbl_category cat','cat.id = sub_cat.category_id','LEFT');
      $this->db->where($where); 
      $this->db->order_by('sub_cat.id','DESC');
      if($limit!=''){
        $this->db->limit($limit, $start);
      }
      $query = $this->db->get();               
      return $query->result();

    }

    public function get_home_subcategories($id, $limit){

      $where = array('sub_cat.category_id ' => $id , 'sub_cat.status ' => '1', 'cat.status ' => '1', 'product.status ' => '1');

      $this->db->select('sub_cat.`id`,sub_cat.`sub_category_name`,sub_cat.`sub_category_slug`');
      $this->db->from('tbl_sub_category sub_cat');
      $this->db->join('tbl_category cat','cat.`id` = sub_cat.`category_id`','LEFT');
      $this->db->join('tbl_product product','sub_cat.`id` = product.`sub_category_id`','LEFT');
      $this->db->where($where); 
      $this->db->group_by('sub_cat.id','DESC');
      $this->db->order_by('sub_cat.id','DESC');
      $this->db->limit($limit);
      $query = $this->db->get();

      return $query->result();

    }

   public function delete($id){

      $this->db->where('id', $id);
      $this->db->delete('tbl_submenu_headers');
      return 'success';

     
      
   }

       public function get_list_item($sortBy='id', $sort='ASC', $limit='', $start='', $keyword=''){

      $this->db->select('item.*');
      $this->db->select('cat.category_name');
      $this->db->select('sub_cat.sub_category_name');
      $this->db->select('header.submenu_header');
      $this->db->from('tbl_submenu_items item');
      // $this->db->from('tbl_submenu_headers header');
      // $this->db->from('tbl_sub_category sub_cat');
      $this->db->join('tbl_submenu_headers header','header.id = item.submenu_header_id','LEFT');
      $this->db->join('tbl_sub_category sub_cat','sub_cat.id = header.sub_category_id','LEFT');
      $this->db->join('tbl_category cat','cat.id = sub_cat.category_id','LEFT');
      if($limit!=''){
        $this->db->limit($limit, $start);
      }
      if($keyword!=''){
        $this->db->like('cat.category_name',stripslashes($keyword));
        $this->db->or_like('sub_cat.sub_category_name',stripslashes($keyword));
        $this->db->or_like('header.submenu_header',stripslashes($keyword));
        $this->db->or_like('item.submenu_item_name',stripslashes($keyword));
      }
      $this->db->order_by('header.'.$sortBy,$sort);
      return $this->db->get()->result();

    }

     public function single_item($id){

      $this->db->select('*');
      $this->db->from('tbl_submenu_items');
      $this->db->where('id', $id); 
      $this->db->limit(1);
      $query = $this->db->get();
      if($query -> num_rows() == 1){                 
          return $query->result();
      }
      else{
          return false;
      }

    }

   public function delete_item($id){

      $this->db->where('id', $id);
      $this->db->delete('tbl_submenu_items');
      return 'success';

     
      
   }
   
}