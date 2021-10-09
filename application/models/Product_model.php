<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model
{

    public function product_list($sortBy='id', $sort='ASC', $limit='', $start='', $keyword=''){

      $this->db->select('product.*');
      $this->db->select('cat.category_name');
      $this->db->select('sub_cat.sub_category_name');
      $this->db->from('tbl_product product');
      $this->db->join('tbl_category cat','cat.id = product.category_id','LEFT');
      $this->db->join('tbl_sub_category sub_cat','sub_cat.id = product.sub_category_id','LEFT');
      if($limit!=''){
        $this->db->limit($limit, $start);
      }
      if($keyword!=''){
        $this->db->like('product.product_title',stripslashes($keyword));
        $this->db->or_like('cat.category_name',stripslashes($keyword));
        $this->db->or_like('sub_cat.sub_category_name',stripslashes($keyword));
      }
      $this->db->order_by('product.'.$sortBy,$sort);

      // echo $this->db->last_query();

      return $this->db->get()->result();

    }

    public function filter_product_list($category_id=0, $offer_id=0, $brand_id=0, $limit='', $start='', $keyword=''){

      $this->db->select('product.*');
      $this->db->select('cat.category_name');
      $this->db->select('sub_cat.sub_category_name');
      $this->db->from('tbl_product product');
      $this->db->join('tbl_category cat','cat.id = product.category_id','LEFT');
      $this->db->join('tbl_sub_category sub_cat','sub_cat.id = product.sub_category_id','LEFT');
      if($limit!=''){
        $this->db->limit($limit, $start);
      }

      if($category_id!=0){
        $this->db->where('product.category_id',$category_id);
      }

      if($offer_id!=0){
        $this->db->where('product.offer_id',$offer_id);
      }

      if($brand_id!=0){
        $this->db->where('product.brand_id',$brand_id);
      }

      if($keyword!=''){
        $this->db->group_start();
        $this->db->like('product.product_title',stripslashes($keyword));
        $this->db->or_like('cat.category_name',stripslashes($keyword));
        $this->db->or_like('sub_cat.sub_category_name',stripslashes($keyword));
        $this->db->group_end();
      }

      $this->db->order_by('product.id','DESC');

      /*echo $this->db->last_query();*/

      return $this->db->get()->result();

    }

    public function get_products(){

      $this->db->select('product.id, product.product_title');
      $this->db->from('tbl_product product');
      return $this->db->get()->result();

    }

    public function banner_products($ids){

      $this->db->select('product.id, product.product_title, product.product_slug, product.featured_image');
      $this->db->from('tbl_product product');
      $this->db->where_in('id', $ids);
      return $this->db->get()->result();

    }

    public function single_product($id,$flag_status=true){
      
      $where = array('product.id ' => $id);

      $this->db->select('product.*');
      $this->db->select('cat.category_name');
      $this->db->select('sub_cat.sub_category_name');
      $this->db->from('tbl_product product');
      $this->db->where($where); 
      $this->db->join('tbl_category cat','cat.id = product.category_id','LEFT');
      $this->db->join('tbl_sub_category sub_cat','sub_cat.id = product.sub_category_id','LEFT');
      
      $query = $this->db->get();
      if($query -> num_rows() == 1){                 
          return $query->result();
      }
      else{
          return false;
      }
    }

    public function get_gallery($id){

      $where = array('parent_id' => $id , 'type ' => 'product');

      $this->db->select('*');
      $this->db->from('tbl_product_images');
      $this->db->where($where); 
      $query = $this->db->get();
      return $query->result();
    }

    public function delete($id){

      $this->db->select('*');
      $this->db->from('tbl_product');
      $this->db->where('id', $id); 
      $this->db->limit(1);
      $query = $this->db->get();
      if($query -> num_rows() == 1){                 
          $row=$query->result();

          $where=array('product_id' => $id);
          
          $this->db->delete('tbl_cart', $where);
          $this->db->delete('tbl_cart_tmp', $where);
          $this->db->delete('tbl_wishlist', $where);
          $this->db->delete('tbl_order_items', $where); 
          $this->db->delete('tbl_order_status', $where);
          $this->db->delete('tbl_rating', $where);

          $this->db->delete('tbl_recent_viewed', $where);

          if(file_exists('assets/images/products/'.$row[0]->featured_image))
          {
            unlink('assets/images/products/'.$row[0]->featured_image);
            
            $mask = $row[0]->product_slug.'*_*';
            array_map('unlink', glob('assets/images/products/thumbs/'.$mask));

            $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row[0]->featured_image);
            $mask = $thumb_img_nm.'*_*';
            array_map('unlink', glob('assets/images/products/thumbs/'.$mask));
          }

          if(file_exists('assets/images/products/'.$row[0]->featured_image2))
          {
            unlink('assets/images/products/'.$row[0]->featured_image2);
            
            $mask = $row[0]->id.'*_*';
            array_map('unlink', glob('assets/images/products/thumbs/'.$mask));
          }

          if($row[0]->size_chart!='')
          {
            unlink('assets/images/products/'.$row[0]->size_chart);
          } 
          
          $this->db->select('*');
          $this->db->where('find_in_set("'.$row[0]->id.'", product_ids) <> 0');
          $this->db->from('tbl_banner');
          $query = $this->db->get();

          foreach ($query->result_array() as $row_banner) 
          {

            $old_ids=explode(',', $row_banner['product_ids']);

            $key = array_search($row[0]->id, $old_ids);
            if (false !== $key) {
                unset($old_ids[$key]);
            }

            $ids=implode(',', $old_ids);

            $data=array('product_ids' => $ids);

            $this->db->where('id', $row_banner['id']);
            $result_updated = $this->db->update('tbl_banner',$data);

          }

          $where = array('parent_id' => $id , 'type ' => 'product');

          $this->db->select('*');
          $this->db->from('tbl_product_images');
          $this->db->where($where); 
          $query = $this->db->get();
          $row=$query->result();

          foreach ($row as $key => $value) {

            if(file_exists('assets/images/products/gallery/'.$value->image_file)){
                unlink('assets/images/products/gallery/'.$value->image_file);

                $mask = $value->id.'*_*';
                array_map('unlink', glob('assets/images/products/gallery/thumbs/'.$mask));

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->image_file);
                $mask = $thumb_img_nm.'*_*';
                array_map('unlink', glob('assets/images/products/gallery/thumbs/'.$mask));
            } 
          }

          $this->db->where($where);
          $this->db->delete('tbl_product_images');

          // remove review images

          $where = array('parent_id' => $id , 'type ' => 'review');

          $this->db->select('*');
          $this->db->from('tbl_product_images');
          $this->db->where($where); 
          $query = $this->db->get();
          $row=$query->result();

          foreach ($row as $key => $value) {

            if(file_exists('assets/images/review_images/'.$value->image_file))
            {
                unlink('assets/images/review_images/'.$value->image_file);

                $mask = $value->id.'*_*';
                array_map('unlink', glob('assets/images/review_images/thumbs/'.$mask));

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->image_file);
                $mask = $thumb_img_nm.'*_*';
                array_map('unlink', glob('assets/images/review_images/thumbs/'.$mask));
            } 
          }

          $this->db->where($where);
          $this->db->delete('tbl_product_images');

          $this->db->where('id', $id);
          $this->db->delete('tbl_product');
          
          return 'success';
      }
      else{
          return 'failed';
      }
      
   }

   public function remove_img($id){

      $this->db->select('*');
      $this->db->from('tbl_product_images');
      $this->db->where('id', $id); 
      $this->db->limit(1);
      $query = $this->db->get();

      if($query -> num_rows() == 1){                 
          $row=$query->result();

          if(file_exists('assets/images/products/gallery/'.$row[0]->image_file)){
              unlink('assets/images/products/gallery/'.$row[0]->image_file);

              $mask = $row[0]->id.'*_*';
              array_map('unlink', glob('assets/images/products/gallery/thumbs/'.$mask));

              $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row[0]->image_file);
              $mask = $thumb_img_nm.'*_*';
              array_map('unlink', glob('assets/images/products/gallery/thumbs/'.$mask));
          }

          $this->db->where('id', $id);
          $this->db->delete('tbl_product_images');

          return 'success';
      }
      else{
          return 'failed';
      }
      
   }

   // for increment product views
  public function _set_view($id){
    $this->db->set('total_views', 'total_views+1', FALSE);
    $this->db->where('id', $id);
    $this->db->update('tbl_product');
  }

  // for increment product views
  public function updateTotalSale($id){
    $this->db->set('total_sale', 'total_sale+1', FALSE);
    $this->db->where('id', $id);
    $this->db->update('tbl_product');
  }


  // set or get product rate
  public function set_product_review($product_id,$for='add')
  {
    $this->db->select('*');
    $this->db->from('tbl_rating');
    $this->db->where('product_id', $product_id); 
    $query = $this->db->get();
    $row=$query->result();


    foreach ($row as $key => $value) {
          $rate_db[] = $value;
          $sum_rates[] = $value->rating;
    }

    if(count($rate_db)){
        $rate_times = count($rate_db);
        $sum_rates = array_sum($sum_rates);
        $rate_value = $sum_rates/$rate_times;
        $rate_bg = (($rate_value)/5)*100;
    }else{
        $rate_times = 0;
        $rate_value = 0;
        $rate_bg = 0;
    }

    $rate_avg=round($rate_value); 

    if(strcmp($for, 'add')==0)
      $sql="UPDATE tbl_product SET `total_rate`=`total_rate` + 1,`rate_avg`='$rate_avg' WHERE id='".$product_id."'";
    else
      $sql="UPDATE tbl_product SET `total_rate`=$rate_times,`rate_avg`='$rate_avg' WHERE id='".$product_id."'";

    if($query = $this->db->query($sql))
      return 'success';
    else
      return 'failed';

  }

}