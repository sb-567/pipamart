<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//LOCATION : application - controller - Auth.php

class Auth extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('admin_model');

    }

    public function index(){
        $data = array();

        if($this->session->userdata('is_login') == TRUE){
            redirect(base_url() . 'admin/dashboard', 'refresh');
        }

        $data['page_title'] = 'Login';
        $data['current_page'] = 'login';
        $this->load->view('admin/page/login', $data);
    }

    public function login(){ 
  
        $this->form_validation->set_rules('username', 'Username', 'required');  
        $this->form_validation->set_rules('password', 'Password', 'required'); 

        if($this->form_validation->run())  
        {
             if($_POST)
             { 
                $query = $this->admin_model->validate_admin();
                
                //-- if valid
                if($query){
                    $data = array();
                    foreach($query as $row){
                        $data = array(
                            'id' => $row->id,
                            'username' => $row->username,
                            'email' =>$row->email,
                            'is_login' => TRUE
                        );
                        $this->session->set_userdata($data);
                        $url = base_url('dashboard');
                    }
                    redirect(base_url() . 'admin/dashboard', 'refresh');
                }else{

                    $message = array('message' => $this->lang->line('invalid_login_msg'),'class' => 'alert-danger');
                    $this->session->set_flashdata('response_msg', $message);
                    $this->index();
                }
                
            }
            else{
                redirect(base_url() . 'admin', 'refresh');
            }
        }
        else  
        {  
            $message = array('message' => $this->lang->line('input_required'),'class' => 'alert-danger');
            $this->session->set_flashdata('response_msg', $message);
            redirect(base_url() . 'admin');
        }
    }

    function logout(){

        $array_items = array('id', 'username', 'email', 'is_login');

        $this->session->unset_userdata($array_items);

        redirect(base_url() . 'admin', 'refresh');
    }

}