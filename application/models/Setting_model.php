<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**

*

*/
class Setting_model extends CI_Model {
    
    public function get_details(){
    	
      $this->db->select('*');
      $this->db->from('tbl_settings');
      $this->db->where('tbl_settings.id', '1'); 
      $this->db->limit(1);
      $res=$this->db->get()->result();
      return $res[0];
    }

    public function get_web_details(){
      
      $this->db->select('*');
      $this->db->from('tbl_web_settings');
      $this->db->where('tbl_web_settings.id', '1'); 
      $this->db->limit(1);
      $res=$this->db->get()->result();
      return $res[0];
    }

    public function get_android_details(){
      
      $this->db->select('*');
      $this->db->from('tbl_android_settings');
      $this->db->where('tbl_android_settings.id', '1'); 
      $this->db->limit(1);
      $res=$this->db->get()->result();
      return $res[0];
    }

    public function get_verify_details(){
      
      $this->db->select('*');
      $this->db->from('tbl_verify');
      $this->db->where('tbl_verify.id', '1'); 
      $this->db->limit(1);
      $res=$this->db->get()->result();
      return $res[0];
    }

    public function get_smtp_settings(){
    	
      $this->db->select('*');
      $this->db->from('tbl_smtp_settings');
      $this->db->where('tbl_smtp_settings.id', '1'); 
      $this->db->limit(1);
      $res=$this->db->get()->result();
      return $res[0];
    }
}