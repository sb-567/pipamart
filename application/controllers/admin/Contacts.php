<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contacts extends CI_Controller {

    private $redirectUrl=NULL;

    public function __construct(){
        parent::__construct();
        check_login_user();
        $this->load->helper('image'); 
        $this->load->model('common_model');
        $this->load->model('Contact_model');

        $currentURL = current_url();
        $params   = $_SERVER['QUERY_STRING'];
        $this->redirectUrl = (!empty($params)) ? $currentURL . '?' . $params : $currentURL;
    }

    function index(){
        $data = array();
        $data['page_title'] = $this->lang->line('contact_list_lbl');
        $data['current_page'] = $this->lang->line('contact_list_lbl');
        $data['subjects'] = $this->Contact_model->subject_list();
        $data['conatct_data'] = $this->Contact_model->contact_list();

        $data["redirectUrl"] = $this->redirectUrl;

        $this->template->load('admin/template', 'admin/page/contacts', $data); // :blush:
    } 

    function addForm()
    {
        $this->load->helper("date");

        foreach ($this->input->post('subject_title') as $key => $value) {
            $slug = url_title($value, 'dash', TRUE);

            $data = array(
                'title'  => $value,
                'title_slug'  => $slug,
                'created_at'  =>  strtotime(date('d-m-Y h:i:s A'))
            );   

            $data = $this->security->xss_clean($data);

            $this->common_model->insert($data, 'tbl_contact_sub');
        }

        $messge = array('message' => $this->lang->line('add_msg'),'class' => 'success');
        $this->session->set_flashdata('response_msg', $messge);
        

        redirect(base_url() . 'admin/contacts', 'refresh');
    }

    public function contact_form()
    {
        $data = array();

        $id =  $this->uri->segment(4);

        $data['page_title'] = $this->lang->line('contact_list_lbl');
        if($id==''){
            $data['current_page'] = $this->lang->line('add_subject');
        }
        else{
            $data['subjects'] = $this->Contact_model->single_subject($id);

            $data['current_page'] = $this->lang->line('edit_subject');
        }
        $this->template->load('admin/template', 'admin/page/subject_form', $data); // :blush:
    }



    //-- update users info
    public function editForm($id)
    {

        $this->load->helper("date");

        foreach ($this->input->post('subject_title') as $key => $value) {
            $slug = url_title($value, 'dash', TRUE);

            $data = array(
                'title'  => $value,
                'title_slug'  => $slug
            );   

            $data = $this->security->xss_clean($data);

            $this->common_model->update($data, $id,'tbl_contact_sub');
        }

        $messge = array('message' => $this->lang->line('update_msg'),'class' => 'success');
        $this->session->set_flashdata('response_msg', $messge);

        if(isset($_GET['redirect'])){
            redirect($_GET['redirect'], 'refresh');
        }
        else{
            redirect(base_url() . 'admin/contacts/edit/'.$id, 'refresh');
        }
    }


    //-- delete contact subject
    public function delete_subject($id)
    {
        echo $this->Contact_model->delete_subject($id);
    }   

    //-- delete contacts
    public function delete_contact($id)
    {
        echo $this->Contact_model->delete_contact($id);
    }

    //-- delete contacts
    public function delete_contact_multiple($ids)
    {
        echo $this->Contact_model->delete_contact_multiple($ids);
    }   


}