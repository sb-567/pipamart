<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**

*

*/

class Site_model extends CI_Model
{
    private $res_setting = null;

    public function __construct()
    {
      $CI =& get_instance();

      $CI->load->model('Setting_model', 'settings');

      $this->res_setting = $CI->settings->get_details();

    }

    // categry wise products list
    public function productList_cat_sub($cat_id, $sub_cat_id=0, $limit='', $start='', $brands=''){

      if($sub_cat_id==0 || $sub_cat_id==''){
        $where = array('product.category_id ' => $cat_id , 'product.status ' => '1', 'cat.status ' => '1');
      }
      else{
        $where = array('product.category_id ' => $cat_id,'product.sub_category_id ' => $sub_cat_id , 'product.status ' => '1', 'cat.status ' => '1', 'sub_cat.status ' => '1');
      }

      $this->db->select('product.*');
      $this->db->select('cat.category_name');
      $this->db->select('sub_cat.sub_category_name');
      $this->db->from('tbl_product product');
      $this->db->where($where); 
      if($brands!=''){
      	$ids=implode(',', $brands);
      	$this->db->where_in('product.brand_id', $ids);
      }
      if($limit!=0){
        $this->db->limit($limit, $start);
      }
      $this->db->join('tbl_category cat','cat.id = product.category_id','LEFT');
      $this->db->join('tbl_sub_category sub_cat','sub_cat.id = product.sub_category_id','LEFT');
      
      // echo $this->db->last_query();

      return $this->db->get()->result();
    }
}