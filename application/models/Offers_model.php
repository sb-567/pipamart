<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Offers_model extends CI_Model
{

    public function offers_list($sortBy='id', $sort='ASC', $limit='', $start='', $keyword=''){

      $this->db->select('*');
      $this->db->from('tbl_offers'); 
      if($limit!=''){
        $this->db->limit($limit, $start);
      }
      if($keyword!=''){
        $this->db->like('offer_title',stripslashes($keyword));
      }

      $this->db->order_by($sortBy,$sort);
      
      return $this->db->get()->result();
    }

    public function single_offer($id){

      $this->db->select('*');
      $this->db->from('tbl_offers');
      $this->db->where('id', $id); 
      $this->db->limit(1);
      $query = $this->db->get();
      if($query -> num_rows() == 1){                 
          $row=$query->result();
          return $row[0];
      }
      else{
          return false;
      }
    }

    public function delete($id){

      $this->db->select('*');
      $this->db->from('tbl_offers');
      $this->db->where('id', $id); 
      $this->db->limit(1);
      $query = $this->db->get();
      if($query -> num_rows() == 1){                 
          $row=$query->result();

          if(file_exists('assets/images/offers/'.$row[0]->offer_image))
          {
              unlink('assets/images/offers/'.$row[0]->offer_image);

              $mask = $row[0]->offer_slug.'*_*';
              array_map('unlink', glob('assets/images/offers/thumbs/'.$mask));

              $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row[0]->offer_image);
              $mask = $thumb_img_nm.'*_*';
              array_map('unlink', glob('assets/images/offers/thumbs/'.$mask));              
          }

          $this->db->where('id', $id);
          $this->db->delete('tbl_offers');
          return 'success';
      }
      else{
          return 'failed';
      }
      
    }

}