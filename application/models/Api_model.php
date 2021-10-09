<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Api_model extends CI_Model
{
    private $res_setting = null;
    private $web_setting = null;
    private $app_setting = null;

    public function __construct()
    {
      $CI =& get_instance();

      $CI->load->model('Setting_model', 'settings');

      $this->res_setting = $CI->settings->get_details();
      $this->web_setting = $CI->settings->get_web_details();
      $this->app_setting = $CI->settings->get_android_details();

    }

    public function products_filter($type, $id='', $limit='', $start='', $brands='',$min='', $max='',$order_by='',$size='', $keyword='', $user_id='',$category='',$colors=''){

      switch ($type) {
        case 'latest_products':
          {
              $where = array('cat.status ' => '1');

              $this->db->select('product.id AS `product_id`,product.`product_title`, product.`category_id`, product.`sub_category_id`, product.`brand_id`, product.`offer_id`, product.`product_slug`, product.`product_desc`, product.`featured_image`, product.`featured_image2`, product.`product_mrp`, product.`selling_price`, product.`you_save_amt`, product.`you_save_per`, product.`total_views`, product.`delivery_charge`,product.`max_unit_buy`, product.`product_size`, product.`today_deal`, product.`today_deal_date`, product.`rate_avg`, product.`total_rate`, product.`status`,product.`color`');
              $this->db->select('cat.category_name');
              $this->db->select('sub_cat.sub_category_name');
              $this->db->from('tbl_product product');
              $this->db->join('tbl_category cat','cat.id = product.category_id','LEFT');
              $this->db->join('tbl_sub_category sub_cat','sub_cat.id = product.sub_category_id','LEFT');
          }
          break;

        case 'top_rated_products':
          {
              $where = array('product.total_rate >=' => $this->res_setting->min_rate, 'cat.status ' => '1');

              $this->db->select('product.id AS `product_id`,product.`product_title`, product.`category_id`, product.`sub_category_id`, product.`brand_id`, product.`offer_id`, product.`product_slug`, product.`product_desc`, product.`featured_image`, product.`featured_image2`, product.`product_mrp`, product.`selling_price`, product.`you_save_amt`, product.`you_save_per`, product.`total_views`,product.`color`, product.`delivery_charge`,product.`max_unit_buy`, product.`product_size`, product.`today_deal`, product.`today_deal_date`, product.`rate_avg`, product.`total_rate`, product.`status`');
              $this->db->select('cat.category_name');
              $this->db->select('sub_cat.sub_category_name');
              $this->db->from('tbl_product product');
              $this->db->join('tbl_category cat','cat.id = product.category_id','LEFT');
              $this->db->join('tbl_sub_category sub_cat','sub_cat.id = product.sub_category_id','LEFT');
          }
          break;

        case 'productList_cat_sub':
          {
              $where = array('product.sub_category_id ' => $id, 'cat.status ' => '1');

              $this->db->select('product.id AS `product_id`,product.`product_title`, product.`category_id`, product.`sub_category_id`, product.`brand_id`, product.`offer_id`, product.`product_slug`, product.`product_desc`, product.`featured_image`, product.`featured_image2`, product.`product_mrp`, product.`selling_price`, product.`you_save_amt`, product.`you_save_per`, product.`total_views`,product.`color`, product.`delivery_charge`,product.`max_unit_buy`, product.`product_size`, product.`today_deal`, product.`today_deal_date`, product.`rate_avg`, product.`total_rate`, product.`status`');
              $this->db->select('cat.category_name');
              $this->db->select('sub_cat.sub_category_name');
              $this->db->from('tbl_product product');
              $this->db->join('tbl_category cat','cat.id = product.category_id','LEFT');
              $this->db->join('tbl_sub_category sub_cat','sub_cat.id = product.sub_category_id','LEFT');
          }
          break;

        case 'productList_cat':
          {
              $where = array('product.category_id ' => $id, 'cat.status ' => '1');

              $this->db->select('product.id AS `product_id`,product.`product_title`, product.`category_id`, product.`sub_category_id`, product.`brand_id`, product.`offer_id`, product.`product_slug`, product.`product_desc`, product.`featured_image`, product.`featured_image2`, product.`product_mrp`, product.`selling_price`, product.`you_save_amt`, product.`you_save_per`, product.`total_views`,product.`color`, product.`delivery_charge`,product.`max_unit_buy`, product.`product_size`, product.`today_deal`, product.`today_deal_date`, product.`rate_avg`, product.`total_rate`, product.`status`');
              $this->db->select('cat.category_name');
              $this->db->select('sub_cat.sub_category_name');
              $this->db->from('tbl_product product');
              $this->db->join('tbl_category cat','cat.id = product.category_id','LEFT');
              $this->db->join('tbl_sub_category sub_cat','sub_cat.id = product.sub_category_id','LEFT');
          }
          break;
        case 'productList_item':
          {
              $where = array('product.submenu_item_id ' => $id);

              $this->db->select('product.id AS `product_id`,product.`product_title`, product.`category_id`, product.`sub_category_id`, product.`brand_id`, product.`offer_id`, product.`product_slug`, product.`product_desc`, product.`featured_image`, product.`featured_image2`, product.`product_mrp`, product.`selling_price`, product.`you_save_amt`, product.`you_save_per`, product.`total_views`,product.`color`, product.`delivery_charge`,product.`max_unit_buy`, product.`product_size`, product.`today_deal`, product.`today_deal_date`, product.`rate_avg`, product.`total_rate`, product.`status`');
              $this->db->select('cat.category_name');
              $this->db->select('sub_cat.sub_category_name');
              $this->db->from('tbl_product product');
              $this->db->join('tbl_category cat','cat.id = product.category_id','LEFT');
              $this->db->join('tbl_sub_category sub_cat','sub_cat.id = product.sub_category_id','LEFT');
          }
          break;

        case 'banner':
          {

              $where=array();

              $this->db->select('product_ids');
              $this->db->from('tbl_banner'); 
              $this->db->where('id', $id);
              $res=$this->db->get()->result();

              $ids=explode(',', $res[0]->product_ids);

              $this->db->select('product.id AS `product_id`,product.`product_title`, product.`category_id`, product.`sub_category_id`, product.`brand_id`, product.`offer_id`, product.`product_slug`, product.`product_desc`, product.`featured_image`, product.`featured_image2`, product.`product_mrp`, product.`selling_price`, product.`you_save_amt`, product.`you_save_per`, product.`total_views`,product.`color`, product.`delivery_charge`,product.`max_unit_buy`, product.`product_size`, product.`today_deal`, product.`today_deal_date`, product.`rate_avg`, product.`total_rate`, product.`status`');
              $this->db->from('tbl_product product');
              $this->db->where_in('id', $ids);
          }
          break;

        case 'brand':
          {
              if($id!=0){
                $where = array('product.brand_id ' => $id, 'brand.status ' => '1');
              }
              else{
                $where = array('brand.status ' => '1'); 
              }

              $this->db->select('product.id AS `product_id`,product.`product_title`, product.`category_id`, product.`sub_category_id`, product.`brand_id`, product.`offer_id`, product.`product_slug`, product.`product_desc`, product.`featured_image`, product.`featured_image2`, product.`product_mrp`, product.`selling_price`, product.`you_save_amt`, product.`you_save_per`, product.`total_views`,product.`color`, product.`delivery_charge`,product.`max_unit_buy`, product.`product_size`, product.`today_deal`, product.`today_deal_date`, product.`rate_avg`, product.`total_rate`, product.`status`');
              $this->db->select('brand.brand_name');
              $this->db->from('tbl_product product');
              $this->db->join('tbl_brands brand','brand.id = product.brand_id','LEFT');
          }
          break;

        case 'offer':
          {
              $where = array('product.offer_id ' => $id);

              $this->db->select('product.id AS `product_id`,product.`product_title`, product.`category_id`, product.`sub_category_id`, product.`brand_id`, product.`offer_id`, product.`product_slug`, product.`product_desc`, product.`featured_image`, product.`featured_image2`, product.`product_mrp`, product.`selling_price`, product.`you_save_amt`, product.`you_save_per`, product.`total_views`,product.`color`, product.`delivery_charge`,product.`max_unit_buy`, product.`product_size`, product.`today_deal`, product.`today_deal_date`, product.`rate_avg`, product.`total_rate`, product.`status`');
              $this->db->from('tbl_product product');
          }
          break;

        case 'today_deal':
          {
            $pre_date=strtotime(date('d-m-Y h:i:s A',strtotime("-1 days")));
            $curr_date=strtotime(date('d-m-Y h:i:s A'));

            $where= array("product.`today_deal` >=" => 1,"product.`today_deal_date` >=" => $pre_date, "product.`today_deal_date` <=" => $curr_date);

            $this->db->select('product.id AS `product_id`,product.`product_title`, product.`category_id`, product.`sub_category_id`, product.`brand_id`, product.`offer_id`, product.`product_slug`, product.`product_desc`, product.`featured_image`, product.`featured_image2`, product.`product_mrp`, product.`selling_price`, product.`you_save_amt`, product.`you_save_per`, product.`total_views`,product.`color`, product.`delivery_charge`,product.`max_unit_buy`, product.`product_size`, product.`today_deal`, product.`today_deal_date`, product.`rate_avg`, product.`total_rate`, product.`status`');
            $this->db->select('cat.category_name');
            $this->db->select('sub_cat.sub_category_name');
            $this->db->from('tbl_product product');
            $this->db->join('tbl_category cat','cat.id = product.category_id','LEFT');
            $this->db->join('tbl_sub_category sub_cat','sub_cat.id = product.sub_category_id','LEFT');
          }
          break;

        case 'recent_viewed_products':
          {
              $where = array('recent.user_id' => $user_id);

              $this->db->select('recent.*');
              $this->db->select('product.id AS `product_id`,product.`product_title`, product.`category_id`, product.`sub_category_id`, product.`brand_id`, product.`offer_id`, product.`product_slug`, product.`product_desc`, product.`featured_image`, product.`featured_image2`, product.`product_mrp`, product.`selling_price`, product.`you_save_amt`, product.`you_save_per`, product.`total_views`,product.`color`, product.`delivery_charge`,product.`max_unit_buy`, product.`product_size`, product.`rate_avg`, product.`total_rate`, product.`status`');
              $this->db->from('tbl_recent_viewed recent');
              $this->db->join('tbl_product product','recent.`product_id` = product.`id`','LEFT');
          }
          break;

        case 'search':
          {
              if($category==''){
                $where=array();  
              }
              else{
                $where=array('product.category_id' => $category);   
              }

              $this->db->select('product.id AS `product_id`,product.`product_title`, product.`category_id`, product.`sub_category_id`, product.`brand_id`, product.`offer_id`, product.`product_slug`, product.`product_desc`, product.`featured_image`, product.`featured_image2`, product.`product_mrp`, product.`selling_price`, product.`you_save_amt`, product.`you_save_per`, product.`total_views`,product.`color`, product.`delivery_charge`,product.`max_unit_buy`, product.`product_size`, product.`rate_avg`, product.`total_rate`, product.`status`');
              $this->db->select('cat.category_name,cat.category_slug');
              $this->db->select('sub_cat.sub_category_name');
              $this->db->from('tbl_product product');
              $this->db->join('tbl_category cat','cat.id = product.category_id','LEFT');
              $this->db->join('tbl_sub_category sub_cat','sub_cat.id = product.sub_category_id','LEFT');
              $this->db->join('tbl_brands brand','brand.id = product.brand_id','LEFT');
              $this->db->where($where);
              
              $this->db->group_start();
              $this->db->like('product.product_title',stripslashes($keyword));
              $this->db->or_like('product.product_slug',stripslashes($keyword));
              $this->db->or_like('product.color',stripslashes($keyword));
              $this->db->or_like('cat.category_name',stripslashes($keyword));
              $this->db->or_like('cat.category_slug',stripslashes($keyword));
              $this->db->or_like('sub_cat.sub_category_name',stripslashes($keyword));
              $this->db->or_like('sub_cat.sub_category_slug',stripslashes($keyword));
              $this->db->or_like('brand.brand_name',stripslashes($keyword));
              $this->db->or_like('brand.brand_slug',stripslashes($keyword));
              $this->db->group_end();
          }
          break;
        
        default:
          # code...
          break;
      }

      if(!empty($colors)){
        $allcolors = explode(",",$colors);
        $this->db->group_start();
        foreach ($allcolors as $singlecolor) {
          $this->db->or_like('product.color',$singlecolor);
        }
        $this->db->group_end();
      }

      if($size!=''){

        $ids=explode(',', $size);
        
        $column='(';
        foreach ($ids as $key => $value) {
          $column.="FIND_IN_SET('".$value."', REPLACE(`product`.`product_size`, ' ', ',')) OR ";
        }

        $column=rtrim($column,'OR ').')';

        $this->db->where($column);
        
      }

      if($brands!=''){

        $this->db->where_in('product.brand_id', $brands);
      }

      if($min!='' && $max!=''){

        $this->db->where('product.`selling_price` BETWEEN '.$min.' AND '.$max);
      }

      $this->db->where($where);

      if($limit!=0){
        $this->db->limit($limit, $start);
      }

      if($order_by !='' ){
        if(strcmp($order_by, 'low-high')==0){
          $this->db->order_by("product.selling_price", "ASC");
        }
        else if(strcmp($order_by, 'high-low')==0){
          $this->db->order_by("product.selling_price", "DESC");
        }
        else if(strcmp($order_by, 'top')==0){
          $this->db->order_by("product.total_sale", "DESC");
        }
        else if(strcmp($order_by, 'newest')==0){
          $this->db->order_by("product.id", "DESC");
        }
      }
      else
      {
        if($type=='recent_viewed_products'){
          $this->db->order_by("recent.created_at", "DESC");
        }
        else{
          $this->db->order_by("product.id", "DESC");
        }
      }

      /*echo $this->db->last_query();*/

      $resultSet=$this->db->get()->result();

      if($type=='today_deal'){
          if(empty($resultSet))
          {
            $this->db->set(array('today_deal' => 0, 'today_deal_date' => 0));
            $this->db->update('tbl_product');   
          }
      }
      
      // echo $this->db->last_query();
      return $resultSet;
    }
	
    // category list
    public function category_list($limit='', $start=''){

      $this->db->select('*');
      $this->db->from('tbl_category'); 
      $this->db->where('status', '1'); 
      if($limit!='' OR $limit!=0){
        $this->db->limit($limit, $start);
      }
      $this->db->order_by($this->app_setting->api_cat_order_by, $this->app_setting->api_cat_post_order_by);
      
      return $this->db->get()->result();
    }

    // category list
    public function sub_category_list($id, $limit='', $start=''){

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

    //brands list
    public function brand_list($limit='', $start=''){

      $this->db->select('*');
      $this->db->from('tbl_brands'); 
      $this->db->where('status', '1');
      $this->db->order_by('id', 'DESC');
      if($limit!='' OR $limit!=0){
        $this->db->limit($limit, $start);
      }
      return $this->db->get()->result();
    }

    // offers list
    public function offers_list($limit='', $start=''){

      $this->db->select('*');
      $this->db->from('tbl_offers'); 
      $this->db->where('status', '1'); 
      $this->db->order_by('id', 'DESC');
      if($limit!='' OR $limit!=0){
        $this->db->limit($limit, $start);
      }
      return $this->db->get()->result();
    }

    // banner list
    public function banner_list($limit='', $start=''){

      $this->db->select('*');
      $this->db->from('tbl_banner'); 
      $this->db->where('status', '1'); 
      if($limit!='' OR $limit!=0){
        $this->db->limit($limit, $start);
      }
      $this->db->order_by('id', 'DESC');
      return $this->db->get()->result();
    }

    // coupon list
    public function coupon_list($limit='', $start=''){

      $this->db->select('*');
      $this->db->from('tbl_coupon'); 
      $this->db->where('status', '1'); 
      if($limit!='' OR $limit!=0){
        $this->db->limit($limit, $start);
      }
      $this->db->order_by('id', 'DESC');
      return $this->db->get()->result();
    }

    // product list
    public function product_list(){

      $this->db->select('*');
      $this->db->from('tbl_product'); 
      $this->db->where('status', '1'); 
      $this->db->order_by('id', 'DESC');
      return $this->db->get()->result();
    }


    public function get_cart($user_id, $cart_ids='',$order_by='DESC',$limit=0, $extraParam=NULL){

        $where = array('user_id' => $user_id);

        if(!is_null($extraParam)){
            $where=array_merge($where, $extraParam);
        }

        if($cart_ids==''){

            $this->db->select('cart.*');
            $this->db->select('product.`product_title`,product.`product_slug`, product.`featured_image`, product.`product_mrp`, product.`selling_price`,product.`you_save_amt`,product.you_save_per,  product.`delivery_charge`, product.`max_unit_buy`');
            $this->db->from('tbl_cart cart');
            $this->db->join('tbl_product product','cart.product_id = product.id','LEFT');
            $this->db->where($where);
            $this->db->order_by('cart.id',$order_by);
            if($limit!=0){
              $this->db->limit($limit);
            }
            $query = $this->db->get();
            return $query->result();
        }
        else{

            $this->db->select('cart.*');
            $this->db->select('product.product_title,product.product_slug, product.featured_image, product.product_mrp, product.selling_price,product.you_save_amt,product.you_save_per, product.delivery_charge,product.max_unit_buy');
            $this->db->from('tbl_cart_tmp cart');
            $this->db->join('tbl_product product','cart.product_id = product.id','LEFT');
            $this->db->where($where);
            $this->db->where_in('cart.id', $cart_ids);
            $this->db->order_by('cart.id',$order_by);
            if($limit!=0){
              $this->db->limit($limit);
            }
            $query = $this->db->get();
            return $query->result();
        }
    }

    public function get_user_cart($user_id, $cart_ids=''){

        $where = array('user_id' => $user_id);

        $this->db->select('cart.*');
        $this->db->select('product.`product_title`,product.`product_slug`, product.`featured_image`, product.`product_mrp`, product.`selling_price`,product.`you_save_amt`,product.you_save_per,  product.`delivery_charge`, product.`max_unit_buy`');
        $this->db->from('tbl_cart cart');
        $this->db->join('tbl_product product','cart.product_id = product.id','LEFT');
        $this->db->where($where);
        if($cart_ids!=''){
          $this->db->where_in('cart.id', $cart_ids);
        }
        $this->db->order_by('cart.id','DESC');
        $query = $this->db->get();
        return $query->result();
    }


    // my order list

    public function get_my_orders($user_id, $limit='', $start='', $on_home=false){

      $this->db->select('*');
      $this->db->from('tbl_order_details'); 
      if(!$on_home){
        $this->db->where(array('user_id' => $user_id, 'order_status != ' => '-1')); 
      }
      else{
        $this->db->where(array('user_id' => $user_id, 'order_status != ' => '-1', 'order_status < ' => '4'));  
      }
      
      if($limit!=0){
        $this->db->limit($limit, $start);
      }

      $this->db->order_by('id', 'DESC');
      return $this->db->get()->result();
    }

    // my single order

    public function get_order($order_unique_id, $product_id=0){

      if($product_id==0)
        $where = array('order_unique_id' => $order_unique_id);
      else
        $where = array('order_unique_id' => $order_unique_id, 'product_id' => $product_id);

      $this->db->select('tbl_order_details.*, tbl_order_items.`order_id`, tbl_order_items.`product_id`, tbl_order_items.`product_title`, tbl_order_items.`product_qty`, tbl_order_items.`product_mrp`, tbl_order_items.`product_price`, tbl_order_items.`you_save_amt`, tbl_order_items.`product_size`, tbl_order_items.`total_price`, tbl_order_items.`pro_order_status`');
      $this->db->from('tbl_order_details');
      $this->db->join('tbl_order_items','tbl_order_details.id = tbl_order_items.order_id','LEFT');
      $this->db->where($where);
      $this->db->order_by('tbl_order_items.id', 'DESC');
      return $this->db->get()->result();

    }

    public function get_order_other_product($order_unique_id, $product_id){

      $where = array('order_unique_id' => $order_unique_id, 'product_id <>' => $product_id);

      $this->db->select('tbl_order_details.*, tbl_order_items.`order_id`, tbl_order_items.`product_id`, tbl_order_items.`product_title`, tbl_order_items.`product_qty`, tbl_order_items.`product_price`, tbl_order_items.`product_size`, tbl_order_items.`total_price`, tbl_order_items.`pro_order_status`');
      $this->db->from('tbl_order_details');
      $this->db->join('tbl_order_items','tbl_order_details.id = tbl_order_items.order_id','LEFT');
      $this->db->where($where);
      $this->db->order_by('tbl_order_items.id', 'DESC');
      return $this->db->get()->result();
    }


    public function get_wishlist($user_id, $limit='', $start=''){

        $where = array('user_id' => $user_id);

        $this->db->select('wishlist.*');
        $this->db->select('product.id AS product_id,product.product_title, product.category_id, product.sub_category_id, product.brand_id, product.offer_id, product.product_slug, product.product_desc, product.featured_image, product.product_mrp, product.selling_price, product.you_save_amt, product.you_save_per, product.total_views, product.delivery_charge,product.max_unit_buy, product.status');
        $this->db->from('tbl_wishlist wishlist');
        $this->db->join('tbl_product product','wishlist.product_id = product.id','LEFT');
        $this->db->where($where);
        if($limit!='' OR $limit!=0){
          $this->db->limit($limit, $start);
        }
        $this->db->order_by('wishlist.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_recent_viewed_products($user_id, $limit='', $start='', $brands='',$order_by=''){

        $where = array('recent.user_id' => $user_id, 'product.status' => 1);

        $this->db->select('recent.*');
        $this->db->select('product.id AS product_id,product.product_title, product.category_id, product.sub_category_id, product.brand_id, product.offer_id, product.product_slug, product.product_desc, product.featured_image, product.featured_image2, product.product_mrp, product.selling_price, product.you_save_amt, product.you_save_per, product.total_views, product.delivery_charge,product.max_unit_buy');
        $this->db->from('tbl_recent_viewed recent');
        $this->db->join('tbl_product product','recent.product_id = product.id','LEFT');
        $this->db->where($where);
        if($limit!='' OR $limit!=0){
          $this->db->limit($limit, $start);
        }

        if($order_by !='' ){
          if(strcmp($order_by, 'low-high')==0){
            $this->db->order_by("product.selling_price", "ASC");
          }
          else if(strcmp($order_by, 'high-low')==0){
            $this->db->order_by("product.selling_price", "DESC");
          }
          else if(strcmp($order_by, 'top')==0){
            $this->db->order_by("product.total_sale", "DESC");
          }
          else if(strcmp($order_by, 'newest')==0){
            $this->db->order_by("product.id", "DESC");
          }
        }
        else{
          $this->db->order_by('recent.id', 'DESC');
        }

        
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $query->result();
    }

    // get product review
    public function get_product_review($product_id, $sort='', $limit='', $start=''){

        $where = array('rating.product_id' => $product_id);

        $this->db->select('rating.*');
        $this->db->select('product.product_title');
        $this->db->select('user.user_name');
        $this->db->from('tbl_rating rating');
        $this->db->join('tbl_product product','rating.product_id = product.id','LEFT');
        $this->db->join('tbl_users user','rating.user_id = user.id','LEFT');
        $this->db->where($where);
        if($limit!='' OR $limit!=0){
          $this->db->limit($limit, $start);
        }
        if($sort!=''){
          switch ($sort) {
            case 'oldest':
                  $this->db->order_by('rating.id', 'ASC');
              break;
            case 'newest':
                  $this->db->order_by('rating.id', 'DESC');
              break;
            case 'negative':
                  $this->db->order_by('rating.rating', 'ASC');
              break;
            case 'positive':
                  $this->db->order_by('rating.rating', 'DESC');
              break;
            
            default:
              # code...
              break;
          }
        }
        else{
          $this->db->order_by('rating.id', 'DESC');
        }
        $query = $this->db->get();

        // echo $this->db->last_query();

        return $query->result();
    }


    // get product filters

    function productsFilters($ids,$table, $limit='', $start='',$min='', $max='',$brands='', $order_by=''){
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where_in('id', $ids);
        
        if($min!='' && $max!=''){
          $this->db->where('`selling_price` BETWEEN '.$min.' AND '.$max);
        }
        if($brands!=''){
            $ids=explode(',', $brands);
            $this->db->where_in('brand_id', $ids);
        }
        if($limit!=0){
          $this->db->limit($limit, $start);
        }

        if($order_by !='' ){
          if(strcmp($order_by, 'low-high')==0){
            $this->db->order_by("selling_price", "ASC");
          }
          else if(strcmp($order_by, 'high-low')==0){
            $this->db->order_by("selling_price", "DESC");
          }
          else if(strcmp($order_by, 'top')==0){
            $this->db->order_by("total_sale", "DESC");
          }
          else if(strcmp($order_by, 'newest')==0){
            $this->db->order_by("id", "DESC");
          }

        }
        else{
          $this->db->order_by("id", "DESC");
        }

        $query = $this->db->get();
        
        // echo $this->db->last_query();

        return $row=$query->result();
    }


    // get setting details
    public function app_details(){
    	
      $this->db->select('tbl_settings.*');
      $this->db->from('tbl_settings');
      $this->db->where('tbl_settings.id', '1'); 
      $this->db->limit(1);
      $res=$this->db->get()->result();
      return $res[0];
    }

    public function android_details(){
      
      $this->db->select('tbl_android_settings.*');
      $this->db->from('tbl_android_settings');
      $this->db->where('tbl_android_settings.id', '1'); 
      $this->db->limit(1);
      $res=$this->db->get()->result();
      return $res[0];
    }

    public function web_details(){
      
      $this->db->select('tbl_web_settings.*');
      $this->db->from('tbl_web_settings');
      $this->db->where('tbl_web_settings.id', '1'); 
      $this->db->limit(1);
      $res=$this->db->get()->result();
      return $res[0];
    }

    // get app details
    public function get_unseen_orders($limit=0){
      
      $this->db->select('order.*, user.`user_name`');
      $this->db->from('tbl_order_details order');
      $this->db->join('tbl_users user','order.user_id = user.id','LEFT');
      $this->db->where(array('is_seen' => '0', 'order_status <>' => '-1')); 
      // $this->db->where(array('order_status <>' => '-1')); 
      if($limit!=0)
        $this->db->limit($limit);
      $query = $this->db->get();
      return $row=$query->result();
    }

     // get smtp setting
    public function smtp_settings(){
      
      $this->db->select('*');
      $this->db->from('tbl_smtp_settings');
      $this->db->where('tbl_smtp_settings.id', '1'); 
      $this->db->limit(1);
      $res=$this->db->get()->result();
      return $res[0];
    }


    // get product review
    public function get_refund_data($order_id=0, $groupBy='')
    {
        $where = array('refund.gateway !=' => 'cod');

        $this->db->select('refund.*');
        $this->db->select('user.user_name, user.user_email');
        $this->db->select('bank.bank_holder_name, bank.bank_holder_phone, bank.bank_holder_email, bank.account_no, bank.account_type, bank.bank_ifsc, bank.bank_name');
        $this->db->from('tbl_refund refund');
        $this->db->join('tbl_users user','refund.user_id = user.id','LEFT');
        $this->db->join('tbl_bank_details bank','refund.bank_id = bank.id','LEFT');
        $this->db->where($where);

        $this->db->order_by("refund.id", "DESC");
        $query = $this->db->get();
        return $query->result();
    }

    public function get_refund_products($order_unique_id=0)
    {
        $where = array('refund.gateway !=' => 'cod', 'refund.order_unique_id' => $order_unique_id);

        $this->db->select('refund.*');
        $this->db->select('product.product_title, product.featured_image');
        $this->db->from('tbl_refund refund');
        $this->db->join('tbl_product product','refund.product_id = product.id','LEFT');
        $this->db->where($where);
        $this->db->order_by("refund.id", "DESC");
        $query = $this->db->get();
        return $query->result();
    }

    public function top_selling_products($falg=false, $limit='', $start='', $keyword='')
    {

      $where=array('product.total_sale <> '=> '0');

      if(!$falg){

        $this->db->select('product.`product_title`, product.`total_sale`');
        $this->db->from('tbl_product product');
        $this->db->where($where);
        $this->db->order_by('product.total_sale', 'DESC');
        $this->db->limit(10);
        $query = $this->db->get();
        return $query->result();
      }
      else{
        
        $this->db->select('product.*');
        $this->db->select('cat.category_name');
        $this->db->select('sub_cat.sub_category_name');
        $this->db->from('tbl_product product');
        $this->db->join('tbl_category cat','cat.id = product.category_id','LEFT');
        $this->db->join('tbl_sub_category sub_cat','sub_cat.id = product.sub_category_id','LEFT');
        $this->db->where($where);
        if($limit!=''){
          $this->db->limit($limit, $start);
        }
        if($keyword!=''){
          $this->db->like('product.product_title',stripslashes($keyword));
          $this->db->or_like('cat.category_name',stripslashes($keyword));
          $this->db->or_like('sub_cat.sub_category_name',stripslashes($keyword));
        }

        return $this->db->get()->result();

      }

    }

    public function todays_orders()
    {
      $where=array("order.order_status <> "=> "-1", "DATE_FORMAT(FROM_UNIXTIME(order.order_date), '%d-%m-%Y') =" => date('d-m-Y'));

      $this->db->select('order.order_unique_id, order.payable_amt, order.order_status, address.name');
      $this->db->from('tbl_order_details order');
      $this->db->join('tbl_addresses address','order.order_address= address.`id`','LEFT');
      $this->db->where($where);
      $this->db->order_by('order.id', 'DESC');
      $this->db->limit(10);
      $query = $this->db->get();
      return $query->result();
    }
}