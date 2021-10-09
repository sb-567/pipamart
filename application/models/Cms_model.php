<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**

*

*/

class Cms_model extends CI_Model
{

    public function data_list($flag,$sort='ASC'){

      $this->db->select('*');
      $this->db->from('tbl_cms_contents'); 
      $this->db->where('flag',$flag); 
      $this->db->order_by('id', $sort);
      return $this->db->get()->result();
    }

    public function data_list_teams($sort='DESC'){

      $this->db->select('*');
      $this->db->from('tbl_teams'); 
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

    public function single_data($id){

      $this->db->select('*');
      $this->db->from('tbl_cms_contents');
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

        public function single_data_teams($id){

      $this->db->select('*');
      $this->db->from('tbl_teams');
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

    public function delete_data($id){

      $this->db->select('*');
      $this->db->from('tbl_cms_contents');
      $this->db->where('id', $id); 
      $this->db->limit(1);
      $query = $this->db->get();
      if($query -> num_rows() == 1){                 
          $row=$query->result();
          $this->db->where('id', $id);
          $this->db->delete('tbl_cms_contents');
          return 'success';
      }
      else{
          return 'failed';
      }
      
    }

    public function delete_team($id){

      $this->db->select('*');
      $this->db->from('tbl_teams');
      $this->db->where('id', $id); 
      $this->db->limit(1);
      $query = $this->db->get();
      if($query -> num_rows() == 1){                 
          $row=$query->result();
          $this->db->where('id', $id);
          $this->db->delete('tbl_teams');
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