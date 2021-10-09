
<?php
class Admin_model extends CI_Model {


    // check valid user by id
    public function validate_id($id){
        $this->db->select('*');
        $this->db->from('tbl_admin');
        $this->db->where('md5(id)', $id); 
        $this->db->limit(1);
        $query = $this->db->get();
        if($query -> num_rows() == 1){                 
            return $query->result();
        }
        else{
            return false;
        }
    }

    //-- get admin data
    function get_data($id){            
        
        $this->db->select('*');
        $this->db->from('tbl_admin');
        $this->db->where('id', $id); 
        $this->db->limit(1);

        $res=$this->db->get()->result();
        return $res[0];
    }


    //-- check valid user
    function validate_admin(){            
        
        $this->db->select('*');
        $this->db->from('tbl_admin');
        $this->db->where('username', $this->input->post('username')); 
        $this->db->where('password', md5($this->input->post('password')));
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