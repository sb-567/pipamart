<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cms extends CI_Controller {

    private $redirectUrl=NULL;

    public function __construct(){
        parent::__construct();
        check_login_user();
        $this->load->helper('image'); 
        $this->load->model('common_model');
        $this->load->model('Cms_model');

        $currentURL = current_url();
        $params   = $_SERVER['QUERY_STRING'];
        $this->redirectUrl = (!empty($params)) ? $currentURL . '?' . $params : $currentURL;
    }

    // function index($flag='terms'){

    //     $data = array();
    //     if($flag == "terms"){

    //         $data['page_title'] = "Terms and Conditions";
    //         $data['current_page'] = "Terms and Conditions";
    //     }
    //     if($flag == "privacy"){

    //         $data['page_title'] = "Privacy Policy";
    //         $data['current_page'] = "Privacy Policy";
    //     }
    //     $data['data'] = $this->Cms_model->data_list($flag);

    //     $data["redirectUrl"] = $this->redirectUrl;
    //     $data["flag"] = $flag;

    //     $this->template->load('admin/template', 'admin/page/cms', $data); // :blush:
    // }
    function listing($flag='terms'){

        $data = array();
        if($flag == "terms"){

            $data['current_page'] = "CMS";
            $data['page_title'] = "Terms and Conditions";
        }
        if($flag == "privacy"){

            $data['current_page'] = "CMS";
            $data['page_title'] = "Privacy Policy";
        }
        if($flag == "refund"){

            $data['current_page'] = "CMS";
            $data['page_title'] = "Refund Policy";
        }
        if($flag == "cancellation"){

            $data['current_page'] = "CMS";
            $data['page_title'] = "Cancellation Policy";
        }
        if($flag == "shipping"){

            $data['current_page'] = "CMS";
            $data['page_title'] = "Shipping Delivery";
        }
        if($flag == "career"){

            $data['current_page'] = "CMS";
            $data['page_title'] = "Career";
        }
        $data['data'] = $this->Cms_model->data_list($flag);

        $data["redirectUrl"] = $this->redirectUrl;
        $data["flag"] = $flag;

        $this->template->load('admin/template', 'admin/page/cms', $data); // :blush:
    }



    function addForm()
    {
        $this->load->helper("date");
        $title = $this->input->post('title');
        $description = $this->input->post('description');
        $flag = $this->input->post('flag');
            $slug = url_title($value, 'dash', TRUE);

            $data = array(
                'title'  => $title,
                'description'  => $description,
                'flag'  => $flag,
                'created_at'  =>  strtotime(date('d-m-Y h:i:s A'))
            );   

            $data = $this->security->xss_clean($data);

            $this->common_model->insert($data, 'tbl_cms_contents');
        

        $messge = array('message' => $this->lang->line('add_msg'),'class' => 'success');
        $this->session->set_flashdata('response_msg', $messge);
        

        redirect(base_url() . 'admin/cms/data/'.$flag, 'refresh');
    }

    public function contact_form()
    {
        $data = array();

        $id =  $this->uri->segment(4);

        $data['data'] = $this->Cms_model->single_data($id);

        $flag = $data['data'][0]->flag;

       if($flag == "terms"){

            $data['current_page'] = "CMS";
            $data['page_title'] = "Terms and Conditions";
        }
        if($flag == "privacy"){

            $data['current_page'] = "CMS";
            $data['page_title'] = "Privacy Policy";
        }
        if($flag == "refund"){

            $data['current_page'] = "CMS";
            $data['page_title'] = "Refund Policy";
        }
        if($flag == "cancellation"){

            $data['current_page'] = "CMS";
            $data['page_title'] = "Cancellation Policy";
        }
        if($flag == "shipping"){

            $data['current_page'] = "CMS";
            $data['page_title'] = "Shipping Delivery";
        }
        // $data['page_title'] = $this->lang->line('contact_list_lbl');
       
            $data['page_title'] = "Edit ".$data['page_title'];

        
        $this->template->load('admin/template', 'admin/page/cms_form', $data); // :blush:
    }

    public function add_form($flag="terms")
    {
        $data = array();

       if($flag == "terms"){

            $data['current_page'] = "CMS";
            $data['page_title'] = "Terms and Conditions";
        }
        if($flag == "privacy"){

            $data['current_page'] = "CMS";
            $data['page_title'] = "Privacy Policy";
        }
        if($flag == "refund"){

            $data['current_page'] = "CMS";
            $data['page_title'] = "Refund Policy";
        }
        if($flag == "cancellation"){

            $data['current_page'] = "CMS";
            $data['page_title'] = "Cancellation Policy";
        }
        if($flag == "shipping"){

            $data['current_page'] = "CMS";
            $data['page_title'] = "Shipping Delivery";
        }
         if($flag == "carrer"){

            $data['current_page'] = "CMS";
            $data['page_title'] = "Career";
        }
        

        // $data['page_title'] = $this->lang->line('contact_list_lbl');
       
            $data['page_title'] = "Add ".$data['page_title'];
            $data['flag'] =$flag;
        
        $this->template->load('admin/template', 'admin/page/cms_form', $data); // :blush:
    }



    //-- update users info
    public function editForm($id)
    {

        $this->load->helper("date");
        $title = $this->input->post('title');
        $description = $this->input->post('description');
        // $id = $this->input->post('id');

            $slug = url_title($value, 'dash', TRUE);

            $data = array(
                'title'  => $title,
                'description'  => $description
            );   

            $data = $this->security->xss_clean($data);

            $this->common_model->update($data, $id,'tbl_cms_contents');
        

        $messge = array('message' => $this->lang->line('update_msg'),'class' => 'success');
        $this->session->set_flashdata('response_msg', $messge);

        if(isset($_GET['redirect'])){
            redirect($_GET['redirect'], 'refresh');
        }
        else{
            redirect(base_url() . 'admin/cms/edit/'.$id, 'refresh');
        }
    }


    //-- delete contact subject
    public function delete_data($id)
    {
        echo $this->Cms_model->delete_data($id);
    }   

    //-- delete contacts
    public function delete_team($id)
    {
        echo $this->Cms_model->delete_team($id);
    }

    //-- delete contacts
    public function delete_contact_multiple($ids)
    {
        echo $this->Cms_model->delete_contact_multiple($ids);
    }   


    function teams(){

        $data['data'] = $this->Cms_model->data_list_teams();
        $data["redirectUrl"] = $this->redirectUrl;

            $data['page_title'] = "Teams";
            $data['current_page'] = "Teams";


        $this->template->load('admin/template', 'admin/page/teams', $data); // :blush:
    }
    public function addteam(){
        $data = array();

        $id =  $this->uri->segment(4);
        // echo $id;die;

        if($id ==''){
            $data['page_title'] = "Add Team";
            $data['current_page'] = "Teams";
        }else{
            $data['page_title'] = "Edit Team";
            $data['current_page'] = "Teams";
            $data['data'] = $this->Cms_model->single_data_teams($id);
        }
        $data["redirectUrl"] = $this->redirectUrl;


        
        $this->template->load('admin/template', 'admin/page/teams_form', $data); // :blush:
    }

        function addFormTeams()
    {
        $this->load->helper("date");
        $name = $this->input->post('name');
        $content = $this->input->post('description');
            $slug = url_title($value, 'dash', TRUE);

            $data = array(
                'name'  => $name,
                'content'  => $content,
                'created_at'  =>  strtotime(date('d-m-Y h:i:s A'))
            );  
                 if ($_FILES['image']['error'] != 4) {
                   

                    $config['upload_path'] =  'assets/images/';
                    $config['allowed_types'] = 'jpg|png|jpeg|PNG|JPG|JPEG';

                    $image = date('dmYhis') . '_' . rand(0, 99999) . "." . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

                    $config['file_name'] = $image;

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('image')) {
                        $message = array('message' => $this->upload->display_errors(), 'class' => 'error');
                        $this->session->set_flashdata('response_msg', $message);

                        redirect(base_url() . 'admin/cms/teams', 'refresh');
                    }

                    $data = array_merge($data, array("image" => $image));
                } 

            $data = $this->security->xss_clean($data);

            $this->common_model->insert($data, 'tbl_teams');
        

        $messge = array('message' => $this->lang->line('add_msg'),'class' => 'success');
        $this->session->set_flashdata('response_msg', $messge);
        

        redirect(base_url() . 'admin/cms/teams', 'refresh');
    }

      public function editFormTeams($id)
    {

        $this->load->helper("date");
        $name = $this->input->post('name');
        $content = $this->input->post('description');
        // $id = $this->input->post('id');


            $data = array(
                'name'  => $name,
                'content'  => $content
            );   

            if ($_FILES['image']['error'] != 4) {
                   

                    $config['upload_path'] =  'assets/images/';
                    $config['allowed_types'] = 'jpg|png|jpeg|PNG|JPG|JPEG';

                    $image = date('dmYhis') . '_' . rand(0, 99999) . "." . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

                    $config['file_name'] = $image;

                    $this->load->library('upload', $config);

                    if (!$this->upload->do_upload('image')) {
                        $message = array('message' => $this->upload->display_errors(), 'class' => 'error');
                        $this->session->set_flashdata('response_msg', $message);

                        redirect(base_url() . 'admin/cms/teams', 'refresh');
                    }

                    $data = array_merge($data, array("image" => $image));
                } 

            $data = $this->security->xss_clean($data);

            $this->common_model->update($data, $id,'tbl_teams');
        

        $messge = array('message' => $this->lang->line('update_msg'),'class' => 'success');
        $this->session->set_flashdata('response_msg', $messge);

        if(isset($_GET['redirect'])){
            redirect($_GET['redirect'], 'refresh');
        }
        else{
            redirect(base_url() . 'admin/cms/edit/'.$id, 'refresh');
        }
    }


}