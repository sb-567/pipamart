<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coupon_model extends CI_Model
{

    public function coupon_list($sortBy='id', $sort='ASC', $limit='', $start='', $keyword=''){

      $this->db->select('*');
      $this->db->from('tbl_coupon'); 
      if($limit!=''){
        $this->db->limit($limit, $start);
      }
      if($keyword!=''){
        $this->db->like('coupon_code',stripslashes($keyword));
        $this->db->or_like('coupon_desc',stripslashes($keyword));
        $this->db->or_like('coupon_per',stripslashes($keyword));
        $this->db->or_like('coupon_amt',stripslashes($keyword));
      }
      
      $this->db->order_by($sortBy,$sort);
      return $this->db->get()->result();
    }

    public function single_coupon($id){

      $this->db->select('*');
      $this->db->from('tbl_coupon');
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
      $this->db->from('tbl_coupon');
      $this->db->where('id', $id); 
      $this->db->limit(1);
      $query = $this->db->get();
      if($query -> num_rows() == 1){                 
          $row=$query->result();

          if(file_exists('assets/images/coupons/'.$row[0]->coupon_image))
          {
              unlink('assets/images/coupons/'.$row[0]->coupon_image);

              $mask = $row[0]->id.'*_*';
              array_map('unlink', glob('assets/images/coupons/thumbs/'.$mask));

              $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row[0]->coupon_image);
              $mask = $thumb_img_nm.'*_*';
              array_map('unlink', glob('assets/images/coupons/thumbs/'.$mask));              
          }

          $this->db->where('id', $id);
          $this->db->delete('tbl_coupon');
          return 'success';
      }
      else{
          return 'failed';
      } 
    }

}