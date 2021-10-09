<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Brand_model extends CI_Model
{

    public function get_list($sortBy='id', $sort='ASC', $limit='', $start='', $keyword=''){

      $this->db->select('*');
      $this->db->from('tbl_brands'); 
      if($limit!=''){
        $this->db->limit($limit, $start);
      }
      if($keyword!=''){
        $this->db->like('brand_name',stripslashes($keyword));
      }
      $this->db->order_by($sortBy,$sort);
      return $this->db->get()->result();
    }

    public function single_brand($id){

      $this->db->select('*');
      $this->db->from('tbl_brands');
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

    public function get_brands($cat_id){

      $column='';
      $cat_ids=explode(',', $cat_id); 

      if(!empty($cat_ids)){
          foreach ($cat_ids as $key => $value) {
            $column.='FIND_IN_SET('.$value.', `category_id`) OR ';
          }
          $column=rtrim($column,'OR ');
      }
      else{
          $column='FIND_IN_SET('.$cat_id.', `category_id`)';
      }

      $column=rtrim($column,'OR ');

      $this->db->select('*');
      $this->db->from('tbl_brands'); 
      $this->db->where($column);
      $this->db->order_by('id', 'DESC');
      return $this->db->get()->result();
    }

    public function insert($data){

       if($this->db->insert('tbl_brands',$data))
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
      $result = $this->db->update('tbl_brands',$data);

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
      $this->db->from('tbl_brands');
      $this->db->where('id', $id); 
      $this->db->limit(1);
      $query = $this->db->get();
      if($query -> num_rows() == 1){                 
          $row=$query->result();

          if(file_exists('assets/images/brand/'.$row[0]->brand_image))
          {
            unlink('assets/images/brand/'.$row[0]->brand_image);
            $mask = $row[0]->brand_slug.'*_*';
            array_map('unlink', glob('assets/images/brand/thumbs/'.$mask));

            $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row[0]->brand_image);
            $mask = $thumb_img_nm.'*_*';
            array_map('unlink', glob('assets/images/brand/thumbs/'.$mask));
          }

          $this->db->where('id', $id);
          $this->db->delete('tbl_brands');
          return 'success';
      }
      else{
          return 'failed';
      }
      
   }



}