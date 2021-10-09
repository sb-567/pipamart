<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class SubMenu extends CI_Controller {

    private $redirectUrl=NULL;

    public function __construct()
    {
        parent::__construct();

        check_login_user();
        $this->load->helper('image'); 
        $this->load->model('Category_model');
        $this->load->model('Sub_Category_model');
        $this->load->model('common_model');
        $this->load->model('Sub_menu_model');

        $currentURL = current_url();
        $params   = $_SERVER['QUERY_STRING'];
        $this->redirectUrl = (!empty($params)) ? $currentURL . '?' . $params : $currentURL;
    }

    function index()
    {
        $data = array();
        $data['page_title'] = "Sub Menu Headers";
        $data['current_page'] = 'products';

        if($this->input->get('search_value')!='')
        {
            $keyword=addslashes(trim($this->input->get('search_value')));
        }
        else{
            $keyword='';
        }
        
        $row=$this->Sub_menu_model->get_list('id','DESC', '', '', $keyword);

        $config = array();
        $config["base_url"] = base_url() . 'admin/sub-menu';
        $config["total_rows"] = count($row);
        $config["per_page"] = 12;

        $config['num_links'] = 2;
        $config['use_page_numbers'] = TRUE;
        $config['reuse_query_string'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
         
        $config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
         
        $config['last_link'] = '<i class="fa fa-angle-double-right"></i>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
         
        $config['next_link'] = '';
        $config['next_tag_open'] = '<span class="nextlink">';
        $config['next_tag_close'] = '</span>';

        $config['prev_link'] = '';
        $config['prev_tag_open'] = '<span class="prevlink">';
        $config['prev_tag_close'] = '</span>';

        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';

        $config['num_tag_open'] = '<li style="margin:3px">';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $page = ($this->input->get('page')) ? $this->input->get('page') : 1;

        $page=($page-1) * $config["per_page"];

        $data["links"] = $this->pagination->create_links();
        $data['list'] = $this->Sub_menu_model->get_list('id','DESC', $config["per_page"], $page, $keyword);

        $data["redirectUrl"] = $this->redirectUrl;

        $this->template->load('admin/template', 'admin/page/submenu_headers', $data); // :blush:
    }

       public function sub_category_form()
    {
        $data = array();

        $id =  $this->uri->segment(4);

        $data['current_page'] = 'products';

        $data['category_list'] = $this->Category_model->category_list();
        
        if($id==''){
            $data['page_title'] = "Add Submenu Header";
        }
        else{
            $data['sub_category'] = $this->Sub_menu_model->single($id);

            $data['page_title'] = "Edit Submenu Header";
        }
        $this->template->load('admin/template', 'admin/page/submenuheader_form', $data); // :blush:
    }

    function addForm()
    {

        $redirect=$_GET['redirect'].(isset($_GET['page']) ? '&page='.$_GET['page'] : '');
        
        $this->form_validation->set_rules('sub_cat_id', $this->lang->line('select_subcat_lbl'), 'required');
        $this->form_validation->set_rules('title', $this->lang->line('title_lbl'), 'trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $messge = array('message' => $this->lang->line('input_required'),'class' => 'error');
                $this->session->set_flashdata('response_msg', $messge);

            if(isset($_GET['redirect'])){
                redirect($redirect, 'refresh');
            }
            else{
                redirect(base_url() . 'admin/submenu-header/add', 'refresh');
            }
            
        }
        else
        {
           

            $this->load->helper("date");

            // $slug = url_title($this->input->post('title'), 'dash', TRUE);

            $data = array(
                'submenu_header' => $this->input->post('title'),
                'category_id' => $this->input->post('category_id'),
                'sub_category_id' => $this->input->post('sub_cat_id'),
                // 'sub_category_slug' => $slug,
                'created_at' => strtotime(date('d-m-Y h:i:s A',now())),
            );

            $data = $this->security->xss_clean($data);

            if($this->common_model->insert($data, 'tbl_submenu_headers')){
                $messge = array('message' => $this->lang->line('add_msg'),'class' => 'success');
                $this->session->set_flashdata('response_msg', $messge);

            }
            else{
                $messge = array('message' => $this->lang->line('add_error'),'class' => 'error');
                $this->session->set_flashdata('response_msg', $messge);
            }

            if(isset($_GET['redirect'])){
                redirect($redirect, 'refresh');
            }
            else{
                redirect(base_url() . 'admin/submenu-header/add', 'refresh');
            }
        }
    }

     public function editForm($id)
    {

        $redirect=$_GET['redirect'].(isset($_GET['page']) ? '&page='.$_GET['page'] : '');

        $data = $this->Sub_menu_model->single($id);

        

        $this->load->helper("date");

        // $slug = url_title($this->input->post('title'), 'dash', TRUE);

        $data = array(
            'category_id' => $this->input->post('category_id'),
            'sub_category_id' => $this->input->post('sub_cat_id'),
            'submenu_header' => $this->input->post('title'),
        );

        $data = $this->security->xss_clean($data);

        if($this->common_model->update($data, $id,'tbl_submenu_headers')){
            $messge = array('message' => $this->lang->line('update_msg'),'class' => 'success');
            $this->session->set_flashdata('response_msg', $messge);

        }
        else{
            $messge = array('message' => $this->lang->line('update_error'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $messge);
        }

        if(isset($_GET['redirect'])){
            redirect($redirect, 'refresh');
        }
        else{
            redirect(base_url() . 'admin/submenu-header/edit/'.$id, 'refresh');
        }


    }
     public function delete($id)
    {
        echo $this->Sub_menu_model->delete($id);
    }


    public function items()
    {
        $data = array();
        $data['page_title'] = "Sub Menu Items";
        $data['current_page'] = 'products';

        if($this->input->get('search_value')!='')
        {
            $keyword=addslashes(trim($this->input->get('search_value')));
        }
        else{
            $keyword='';
        }
        
        $row=$this->Sub_menu_model->get_list('id','DESC', '', '', $keyword);

        $config = array();
        $config["base_url"] = base_url() . 'admin/sub-menu-items';
        $config["total_rows"] = count($row);
        $config["per_page"] = 12;

        $config['num_links'] = 2;
        $config['use_page_numbers'] = TRUE;
        $config['reuse_query_string'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';

        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
         
        $config['first_link'] = '<i class="fa fa-angle-double-left"></i>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
         
        $config['last_link'] = '<i class="fa fa-angle-double-right"></i>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
         
        $config['next_link'] = '';
        $config['next_tag_open'] = '<span class="nextlink">';
        $config['next_tag_close'] = '</span>';

        $config['prev_link'] = '';
        $config['prev_tag_open'] = '<span class="prevlink">';
        $config['prev_tag_close'] = '</span>';

        $config['cur_tag_open'] = '<li class="active"><a href="#">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></a></li>';

        $config['num_tag_open'] = '<li style="margin:3px">';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);

        $page = ($this->input->get('page')) ? $this->input->get('page') : 1;

        $page=($page-1) * $config["per_page"];

        $data["links"] = $this->pagination->create_links();
        $data['list'] = $this->Sub_menu_model->get_list_item('id','DESC', $config["per_page"], $page, $keyword);

        $data["redirectUrl"] = $this->redirectUrl;

        $this->template->load('admin/template', 'admin/page/submenu_items', $data); // :blush:
    }

     public function item_sub_category_form()
    {
        $data = array();

        $id =  $this->uri->segment(4);

        $data['current_page'] = 'products';

        $data['category_list'] = $this->Category_model->category_list();
        
        if($id==''){
            $data['page_title'] = "Add Submenu Item";
        }
        else{
            $data['sub_category'] = $this->Sub_menu_model->single_item($id);

            $data['page_title'] = "Edit Submenu Item";
        }
        $this->template->load('admin/template', 'admin/page/submenu_item_form', $data); // :blush:
    }

     function addForm_item()
    {

        $redirect=$_GET['redirect'].(isset($_GET['page']) ? '&page='.$_GET['page'] : '');
        
        $this->form_validation->set_rules('sub_cat_id', $this->lang->line('select_subcat_lbl'), 'required');
        $this->form_validation->set_rules('title', $this->lang->line('title_lbl'), 'trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $messge = array('message' => $this->lang->line('input_required'),'class' => 'error');
                $this->session->set_flashdata('response_msg', $messge);

            if(isset($_GET['redirect'])){
                redirect($redirect, 'refresh');
            }
            else{
                redirect(base_url() . 'admin/submenu-header/add', 'refresh');
            }
            
        }
        else
        {
           

            $this->load->helper("date");

            $slug = url_title($this->input->post('title'), 'dash', TRUE);

            $data = array(
                'submenu_item_name' => $this->input->post('title'),
                'category_id' => $this->input->post('category_id'),
                'sub_category_id' => $this->input->post('sub_cat_id'),
                'submenu_header_id' => $this->input->post('submenu_header_id'),
                'submenu_item_name_slug' => $slug,
                'created_at' => strtotime(date('d-m-Y h:i:s A',now())),
            );

            $data = $this->security->xss_clean($data);

            if($this->common_model->insert($data, 'tbl_submenu_items')){
                $messge = array('message' => $this->lang->line('add_msg'),'class' => 'success');
                $this->session->set_flashdata('response_msg', $messge);

            }
            else{
                $messge = array('message' => $this->lang->line('add_error'),'class' => 'error');
                $this->session->set_flashdata('response_msg', $messge);
            }

            if(isset($_GET['redirect'])){
                redirect($redirect, 'refresh');
            }
            else{
                redirect(base_url() . 'admin/submenu-item/add', 'refresh');
            }
        }
    }

    public function editForm_item($id)
    {

        $redirect=$_GET['redirect'].(isset($_GET['page']) ? '&page='.$_GET['page'] : '');

        $data = $this->Sub_menu_model->single_item($id);

        

        $this->load->helper("date");

        // $slug = url_title($this->input->post('title'), 'dash', TRUE);

        $data = array(
            'category_id' => $this->input->post('category_id'),
            'sub_category_id' => $this->input->post('sub_cat_id'),
            'submenu_header_id' => $this->input->post('submenu_header_id'),
            'submenu_item_name' => $this->input->post('title'),
        );

        $data = $this->security->xss_clean($data);

        if($this->common_model->update($data, $id,'tbl_submenu_items')){
            $messge = array('message' => $this->lang->line('update_msg'),'class' => 'success');
            $this->session->set_flashdata('response_msg', $messge);

        }
        else{
            $messge = array('message' => $this->lang->line('update_error'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $messge);
        }

        if(isset($_GET['redirect'])){
            redirect($redirect, 'refresh');
        }
        else{
            redirect(base_url() . 'admin/submenu-item/edit/'.$id, 'refresh');
        }


    }
     public function delete_item($id)
    {
        echo $this->Sub_menu_model->delete_item($id);
    }




}

?>