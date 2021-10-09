<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model
{

    public function user_list($sortBy='id', $sort='ASC', $limit='', $start='', $keyword=''){

      $this->db->select('*');
      $this->db->from('tbl_users'); 
      if($limit!=''){
        $this->db->limit($limit, $start);
      }
      if($keyword!=''){
        $this->db->like('user_name',$keyword);
        $this->db->or_like('user_email',$keyword);
        $this->db->or_like('user_phone',$keyword);
      }

      $this->db->order_by($sortBy,$sort);
      return $this->db->get()->result();
    }

    public function single_user($id){

      $this->db->select('*');
      $this->db->from('tbl_users');
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
      $this->db->from('tbl_users');
      $this->db->where('id', $id); 
      $this->db->limit(1);
      $query = $this->db->get();
      if($query -> num_rows() == 1){                 
          $row=$query->result();

          $where=array('user_id' => $id);

          $this->db->delete('tbl_cart', $where);
          $this->db->delete('tbl_cart_tmp', $where);
          $this->db->delete('tbl_wishlist', $where);
          $this->db->delete('tbl_order_details', $where); 
          $this->db->delete('tbl_order_items', $where); 
          $this->db->delete('tbl_order_status', $where); 
          $this->db->delete('tbl_transaction', $where); 
          $this->db->delete('tbl_refund', $where);
          $this->db->delete('tbl_recent_viewed', $where);

          $this->db->delete('tbl_addresses', array('user_id' => $id));
          $this->db->delete('tbl_bank_details', array('user_id' => $id));

          if(file_exists('assets/images/users/'.$row[0]->user_image) && $row[0]->user_image!='')
          {

            unlink('assets/images/users/'.$row[0]->user_image);

            $mask = $row[0]->id.'*_*';
            array_map('unlink', glob('assets/images/users/thumbs/'.$mask));

            $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row[0]->user_image);
            $mask = $thumb_img_nm.'*_*';
            array_map('unlink', glob('assets/images/users/thumbs/'.$mask));

          }  

          $this->db->where('id', $id);
          $this->db->delete('tbl_users');

          $this->db->select('*');
          $this->db->from('tbl_rating');
          $this->db->where($where); 
          $query = $this->db->get();
          $row=$query->result();

          foreach ($row as $value_pro)
          {
            $where = array('parent_id' => $value_pro->product_id , 'type ' => 'review');

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

          }
          return 'success';
      }
      else{
          return 'failed';
      }
      
    }

    //-- check valid user
    function validate_user(){            
        
        $this->db->select('*');
        $this->db->from('tbl_users');
        $this->db->where('user_email', $this->input->post('email')); 
        $this->db->where('user_password', md5($this->input->post('password')));
        $this->db->limit(1);
        $query = $this->db->get();   
        
        if($query->num_rows() == 1){                 
           return $query->result();
        }
        else{
            return false;
        }
    }

}