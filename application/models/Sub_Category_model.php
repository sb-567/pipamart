<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sub_Category_model extends CI_Model
{

    public function get_list($sortBy='id', $sort='ASC', $limit='', $start='', $keyword=''){

      $this->db->select('sub_cat.*');
      $this->db->select('cat.category_name');
      $this->db->from('tbl_sub_category sub_cat');
      $this->db->join('tbl_category cat','cat.id = sub_cat.category_id','LEFT');
      if($limit!=''){
        $this->db->limit($limit, $start);
      }
      if($keyword!=''){
        $this->db->like('cat.category_name',stripslashes($keyword));
        $this->db->or_like('sub_cat.sub_category_name',stripslashes($keyword));
      }
      $this->db->order_by('sub_cat.'.$sortBy,$sort);
      return $this->db->get()->result();

    }

    public function single($id){

      $this->db->select('*');
      $this->db->from('tbl_sub_category');
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

    public function get_submenuheaders($id, $limit='', $start=''){

      $where = array('header.sub_category_id ' => $id , 'sub_cat.status ' => '1');

      $this->db->select('header.*');
      $this->db->select('cat.category_name');
      $this->db->select('sub_cat.sub_category_name');
      $this->db->from('tbl_submenu_headers header');
      // $this->db->from('tbl_sub_category sub_cat');
      $this->db->join('tbl_sub_category sub_cat','sub_cat.id = header.sub_category_id','LEFT');
      $this->db->join('tbl_category cat','cat.id = sub_cat.category_id','LEFT');
      $this->db->where($where); 
      $this->db->order_by('header.id','ASC');
      if($limit!=''){
        $this->db->limit($limit, $start);
      }
      $query = $this->db->get();               
      return $query->result();

    }

    public function get_submenuitems($id, $limit='', $start=''){
      $where = array('items.submenu_header_id ' => $id);

      $this->db->select('items.*');
      $this->db->select('cat.category_name');
      $this->db->select('sub_cat.sub_category_name');
      // $this->db->select('header.submenu_header');
      $this->db->from('tbl_submenu_items items');
      // $this->db->from('tbl_submenu_headers header');
      // $this->db->from('tbl_sub_category sub_cat');
      $this->db->join('tbl_submenu_headers header','header.id = items.submenu_header_id','LEFT');
      $this->db->join('tbl_sub_category sub_cat','sub_cat.id = header.sub_category_id','LEFT');
      $this->db->join('tbl_category cat','cat.id = sub_cat.category_id','LEFT');
      $this->db->where($where); 
      $this->db->order_by('items.id','ASC');
      // echo "i reached";
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

      $this->db->select('*');
      $this->db->from('tbl_product');
      $this->db->where('sub_category_id', $id);
      $query = $this->db->get(); 
      foreach ($query->result_array() as $result) 
      {

          if(file_exists('assets/images/products/'.$result['featured_image'])){
            unlink('assets/images/products/'.$result['featured_image']);

            $mask = $result['product_slug'].'*_*';
            array_map('unlink', glob('assets/images/products/thumbs/'.$mask));

            $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $result['featured_image']);
            $mask = $thumb_img_nm.'*_*';
            array_map('unlink', glob('assets/images/products/thumbs/'.$mask));
          }

          if(file_exists('assets/images/products/'.$result['featured_image2'])){
            unlink('assets/images/products/'.$result['featured_image2']);
            
            $mask = $result['id'].'*_*';
            array_map('unlink', glob('assets/images/products/thumbs/'.$mask));
          }

          if($result['size_chart']!=''){
            unlink('assets/images/products/'.$result['size_chart']);
          }

          $where=array('parent_id' => $result['id'], 'type' => 'product');

          $this->db->select('*');
          $this->db->from('tbl_product_images');
          $this->db->where($where); 
          $query = $this->db->get();
          foreach ($query->result_array() as $result_gallery) 
          {
              unlink('assets/images/products/gallery/'.$result_gallery['image_file']);

              $mask = $result_gallery['image_file'].'*_*';
              array_map('unlink', glob('assets/images/products/gallery/thumbs/'.$mask));

              $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $result_gallery['image_file']);
              $mask = $thumb_img_nm.'*_*';
              array_map('unlink', glob('assets/images/products/gallery/thumbs/'.$mask));

          }

          $this->db->delete('tbl_product_images', $where);

          // remove review images

          $where = array('parent_id' => $id , 'type ' => 'review');

          $this->db->select('*');
          $this->db->from('tbl_product_images');
          $this->db->where($where); 
          $query = $this->db->get();
          $row=$query->result();

          foreach ($row as $key => $value) {

            if(file_exists('assets/images/review_images/'.$value->image_file)){
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

          $this->db->select('*');
          $this->db->where('find_in_set("'.$result['id'].'", product_ids) <> 0');
          $this->db->from('tbl_banner');
          $query = $this->db->get();

          foreach ($query->result_array() as $row_banner) 
          {

            $old_ids=explode(',', $row_banner['product_ids']);

            $key = array_search($result['id'], $old_ids);
            if (false !== $key) {
                unset($old_ids[$key]);
            }

            $ids=implode(',', $old_ids);

            $data=array('product_ids' => $ids);

            $this->db->where('id', $row_banner['id']);
            $result_updated = $this->db->update('tbl_banner',$data);

          }

      }

      $this->db->delete('tbl_product', array('sub_category_id' => $id));

      $this->db->select('*');
      $this->db->from('tbl_sub_category');
      $this->db->where('id', $id); 
      $this->db->limit(1);
      $query = $this->db->get();
      if($query -> num_rows() == 1){                 
          $row=$query->result();

          if(file_exists('assets/images/sub_category/'.$row[0]->sub_category_image)){
            unlink('assets/images/sub_category/'.$row[0]->sub_category_image);

            $mask = $row[0]->sub_category_slug.'*_*';
            array_map('unlink', glob('assets/images/sub_category/thumbs/'.$mask));

            $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row[0]->sub_category_image);
            $mask = $thumb_img_nm.'*_*';
            array_map('unlink', glob('assets/images/sub_category/thumbs/'.$mask));

          }

          $this->db->where('id', $id);
          $this->db->delete('tbl_sub_category');
          return 'success';
      }
      else{
          return 'failed';
      }
      
   }
   
}