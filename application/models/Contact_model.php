<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**

*

*/

class Contact_model extends CI_Model
{

    public function subject_list($sort='DESC'){

      $this->db->select('*');
      $this->db->from('tbl_contact_sub'); 
      $this->db->order_by('id', $sort);
      return $this->db->get()->result();
    }

    public function contact_list($sort='DESC'){

      $this->db->select('tbl_contact_list.*');
      $this->db->select('tbl_contact_sub.title');
      $this->db->from('tbl_contact_list');
      $this->db->join('tbl_contact_sub','tbl_contact_sub.id = tbl_contact_list.contact_subject','LEFT');
      $this->db->order_by('id', $sort);
      return $this->db->get()->result();
    }

    // public function contact_list($sort='DESC'){

    //   $this->db->select('tbl_contact_list.*');
    //   $this->db->select('tbl_contact_sub.title');
    //   $this->db->from('tbl_contact_list');
    //   $this->db->join('tbl_contact_sub','tbl_contact_sub.id = tbl_contact_list.contact_subject','LEFT');
    //   $this->db->order_by('id', $sort);
    //   return $this->db->get()->result();
    // }

    public function single_subject($id){

      $this->db->select('*');
      $this->db->from('tbl_contact_sub');
      $this->db->where('id', $id); 
      $this->db->limit(1);
      $query = $this->db->get();
      if($query -> num_rows() == 1){                 
          return $row=$query->result();
      }
      else{
          return false;
      }
    }

    public function delete_subject($id){

      $this->db->select('*');
      $this->db->from('tbl_contact_sub');
      $this->db->where('id', $id); 
      $this->db->limit(1);
      $query = $this->db->get();
      if($query -> num_rows() == 1){                 
          $row=$query->result();
          $this->db->where('id', $id);
          $this->db->delete('tbl_contact_sub');
          return 'success';
      }
      else{
          return 'failed';
      }
      
    }

    public function delete_contact($id){

      $this->db->select('*');
      $this->db->from('tbl_contact_list');
      $this->db->where('id', $id); 
      $this->db->limit(1);
      $query = $this->db->get();
      if($query -> num_rows() == 1){                 
          $row=$query->result();
          $this->db->where('id', $id);
          $this->db->delete('tbl_contact_list');
          return 'success';
      }
      else{
          return 'failed';
      }
      
    }

    public function delete_contact_multiple($ids){

      $this->db->where_in('id', explode(',', $ids));
      $this->db->delete('tbl_contact_list');
      // echo $this->db->last_query();
      return 'success';
      
    }

}