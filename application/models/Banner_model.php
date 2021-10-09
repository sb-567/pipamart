<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Banner_model extends CI_Model
{

    public function banner_list($sortBy='id', $sort='ASC', $limit='', $start='', $keyword=''){

      $this->db->select('*');
      $this->db->from('tbl_banner'); 
      if($limit!=''){
        $this->db->limit($limit, $start);
      }
      if($keyword!=''){
        $this->db->like('banner_title',stripslashes($keyword));
      }
      
      $this->db->order_by($sortBy,$sort);
      return $this->db->get()->result();
    }

    public function single_banner($id){

      $this->db->select('*');
      $this->db->from('tbl_banner');
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

    public function delete($id){

      $this->db->select('*');
      $this->db->from('tbl_banner');
      $this->db->where('id', $id); 
      $this->db->limit(1);
      $query = $this->db->get();
      if($query -> num_rows() == 1){                 
          $row=$query->result();

          if(file_exists('assets/images/banner/'.$row[0]->banner_image))
          {
            unlink('assets/images/banner/'.$row[0]->banner_image);
            $mask = $row[0]->banner_slug.'*_*';
            array_map('unlink', glob('assets/images/banner/thumbs/'.$mask));

            $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row[0]->banner_image);
            $mask = $thumb_img_nm.'*_*';
            array_map('unlink', glob('assets/images/banner/thumbs/'.$mask));
          }

          $this->db->where('id', $id);
          $this->db->delete('tbl_banner');
          return 'success';
      }
      else{
          return 'failed';
      }
      
    }

    public function remove_product($banner_id, $product_id){

      $this->db->select('*');
      $this->db->from('tbl_banner');
      $this->db->where('id', $banner_id); 
      $this->db->limit(1);
      $query = $this->db->get();
      if($query -> num_rows() == 1){                 
          $row=$query->result();
          
          $products=explode(',', $row[0]->product_ids);

          if(in_array($product_id, $products)) 
          {
            unset($products[array_search($product_id,$products)]);
          }

          $products_new=implode(',', $products);

          $data = array(
            'product_ids'  =>  $products_new
          );  

          $this->db->where('id',$banner_id);
          $result = $this->db->update('tbl_banner',$data);

          return true;

      }
      else{
        return false;
      }

    }



}