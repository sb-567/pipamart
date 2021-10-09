<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model
{

    public function category_list($sortBy='id', $sort='ASC', $limit='', $start='', $keyword=''){

      $this->db->select('*');
      $this->db->from('tbl_category'); 
      if($limit!=''){
        $this->db->limit($limit, $start);
      }
      if($keyword!=''){
        $this->db->like('category_name',stripslashes($keyword));
      }
      
      $this->db->order_by($sortBy,$sort);
      return $this->db->get()->result();
    }

    public function single_category($id){

      $this->db->select('*');
      $this->db->from('tbl_category');
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



    public function insert($data){


       if($this->db->insert('tbl_category',$data))
       {
          return true;
       }
       else
       {
          return false;
       }

   }

   public function update($id,$data){

      $this->db->where('id',$id);
      $result = $this->db->update('tbl_category',$data);

      if($result)
      {
          return true;
      }
      else
      {
          return false;
      }

   }

   public function delete($id){

      $this->db->select('*');
      $this->db->from('tbl_sub_category');
      $this->db->where('category_id', $id); 
      $query = $this->db->get();
      foreach ($query->result_array() as $result) 
      {
          unlink('assets/images/sub_category/'.$result['sub_category_image']);
          $mask = $result['sub_category_slug'].'*_*';
          array_map('unlink', glob('assets/images/sub_category/thumbs/'.$mask));

          $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $result['sub_category_image']);
          $mask = $thumb_img_nm.'*_*';
          array_map('unlink', glob('assets/images/sub_category/thumbs/'.$mask));

      }
      $this->db->select('*');
      $this->db->from('tbl_product');
      $this->db->where('category_id', $id);
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

              $mask = $result_gallery['id'].'*_*';
              array_map('unlink', glob('assets/images/products/gallery/'.$mask));

              $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $result_gallery['image_file']);
              $mask = $thumb_img_nm.'*_*';
              array_map('unlink', glob('assets/images/products/gallery/'.$mask));

          }

          $this->db->delete('tbl_product_images', $where);

          $where=array('parent_id' => $result['id'], 'type' => 'review');

          $this->db->select('*');
          $this->db->from('tbl_product_images');
          $this->db->where($where); 
          $query = $this->db->get();
          foreach ($query->result_array() as $row_review) 
          {
              unlink('assets/images/review_images/'.$row_review->image_file);
              $mask = $row_review->id.'*_*';
              array_map('unlink', glob('assets/images/review_images/thumbs/'.$mask));

              $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row_review->image_file);
              $mask = $thumb_img_nm.'*_*';
              array_map('unlink', glob('assets/images/review_images/thumbs/'.$mask));
          }

          $this->db->delete('tbl_product_images', $where);

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

      $this->db->delete('tbl_sub_category', array('category_id' => $id)); 
      $this->db->delete('tbl_product', array('category_id' => $id));
      
      $this->db->select('*');
      $this->db->from('tbl_category');
      $this->db->where('id', $id); 
      $this->db->limit(1);
      $query = $this->db->get();
      if($query -> num_rows() == 1){                 
          $row=$query->result();

          if(file_exists('assets/images/category/'.$row[0]->category_image))
          {
              unlink('assets/images/category/'.$row[0]->category_image);

              $mask = $row[0]->category_slug.'*_*';
              array_map('unlink', glob('assets/images/category/thumbs/'.$mask));

              $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row[0]->category_image);
              $mask = $thumb_img_nm.'*_*';
              array_map('unlink', glob('assets/images/category/thumbs/'.$mask));
              
          }  
          $this->db->where('id', $id);
          $this->db->delete('tbl_category');
          return 'success';
      }
      else{
          return 'failed';
      }
      
   }



}