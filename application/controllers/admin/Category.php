<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends CI_Controller {

    private $redirectUrl=NULL;

    public function __construct(){
        parent::__construct();
        check_login_user();
        $this->load->helper('image'); 
        $this->load->model('common_model');
        $this->load->model('Category_model');

        $currentURL = current_url();
        $params   = $_SERVER['QUERY_STRING'];
        $this->redirectUrl = (!empty($params)) ? $currentURL . '?' . $params : $currentURL;
    }

    function index()
    {
        $data = array();
        $data['page_title'] = $this->lang->line('category_lbl');
        $data['current_page'] = 'products';

        if($this->input->get('search_value')!='')
        {
            $keyword=addslashes(trim($this->input->get('search_value')));
        }
        else{
            $keyword='';
        }
        
        $row=$this->Category_model->category_list('id','DESC','','',$keyword);

        $config = array();
        $config["base_url"] = base_url() . 'admin/category';
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

        $data['category_list'] = $this->Category_model->category_list('id', 'DESC', $config["per_page"], $page, $keyword);

        $data["redirectUrl"] = $this->redirectUrl;

        $this->template->load('admin/template', 'admin/page/category', $data); // :blush:
    }    

    function addForm()
    {

        $redirect=$_GET['redirect'].(isset($_GET['page']) ? '&page='.$_GET['page'] : '');

        $this->form_validation->set_rules('title', $this->lang->line('title_place_lbl'), 'trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $messge = array('message' => $this->lang->line('input_required'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $messge);
            
            if(isset($_GET['redirect'])){
                redirect($redirect, 'refresh');
            }
            else{
                redirect(base_url() . 'admin/category/add');
            }
        }
        else
        {
            $config['upload_path'] =  'assets/images/category/';
            $config['allowed_types'] = 'jpg|png|jpeg|PNG|JPG|JPEG';

            $image = date('dmYhis').'_'.rand(0,99999).".".pathinfo($_FILES['file_name']['name'], PATHINFO_EXTENSION);

            $config['file_name'] = $image;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file_name')) {
                $messge = array('message' => $this->upload->display_errors(),'class' => 'error');
                $this->session->set_flashdata('response_msg', $messge);

                if(isset($_GET['redirect'])){
                    redirect($redirect, 'refresh');
                }
                else{
                    redirect(base_url() . 'admin/category/add');
                }
            } 
            else
            {  
                $upload_data = $this->upload->data();
            }

            $this->load->helper("date");

            $slug = url_title($this->input->post('title'), 'dash', TRUE);

            $data = array(
                'category_name' => $this->input->post('title'),
                'category_slug' => $slug,
                'category_image' => $image,
                'product_features' => ($this->input->post('product_features')!='') ? implode(',', $this->input->post('product_features')) : '',
                'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
            );

            $data = $this->security->xss_clean($data);

            if($this->common_model->insert($data, 'tbl_category')){
                $messge = array('message' => $this->lang->line('add_msg'),'class' => 'success');
                $this->session->set_flashdata('response_msg', $messge);

            }
            else{
                $messge = array('message' => $this->lang->line('error_add'),'class' => 'error');
                $this->session->set_flashdata('response_msg', $messge);
            }

            if(isset($_GET['redirect'])){
                redirect($redirect, 'refresh');
            }
            else{
                redirect(base_url() . 'admin/category/add');
            }
        }
    }


    public function get_category()
    {
        $data = array();
        $data['page_title'] = $this->lang->line('category_lbl');
        $data['current_page'] = 'products';
        $data['category_list'] = $this->Category_model->category_list();
        $this->template->load('admin/template', 'admin/page/category', $data); // :blush:
    }

    public function category_form()
    {
        $data = array();

        $id =  $this->uri->segment(4);

        $data['current_page'] = 'products';
        if($id==''){
            $data['page_title'] = $this->lang->line('add_category_lbl');;
        }
        else{
            $data['category'] = $this->Category_model->single_category($id);

            $data['page_title'] = $this->lang->line('edit_category_lbl');;
        }
        $this->template->load('admin/template', 'admin/page/category_form', $data); // :blush:
    }



    //-- update users info
    public function editForm($id)
    {

        $redirect=$_GET['redirect'].(isset($_GET['page']) ? '&page='.$_GET['page'] : '');

        $data = $this->Category_model->single_category($id);

        if($_FILES['file_name']['error']!=4){
            
            $config['upload_path'] =  'assets/images/category/';
            $config['allowed_types'] = 'jpg|png|jpeg|PNG|JPG|JPEG';

            if(file_exists('assets/images/category/'.$data[0]->category_image))
            {
                unlink('assets/images/category/'.$data[0]->category_image);

                $mask = $data[0]->category_slug.'*_*';
                array_map('unlink', glob('assets/images/category/thumbs/'.$mask));

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $data[0]->category_image);
                $mask = $thumb_img_nm.'*_*';
                array_map('unlink', glob('assets/images/category/thumbs/'.$mask));
            }

            $image = date('dmYhis').'_'.rand(0,99999).".".pathinfo($_FILES['file_name']['name'], PATHINFO_EXTENSION);

            $config['file_name'] = $image;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file_name')) {
                $messge = array('message' => $this->upload->display_errors(),'class' => 'error');
                $this->session->set_flashdata('response_msg', $messge);

                if(isset($_GET['redirect'])){
                    redirect($redirect, 'refresh');
                }
                else{
                    redirect(base_url() . 'admin/category/edit/'.$id, 'refresh');
                }
            }

        }
        else{
            $image=$data[0]->category_image;
        }

        $this->load->helper("date");

        $slug = url_title($this->input->post('title'), 'dash', TRUE);

        $data = array(
            'category_name' => $this->input->post('title'),
            'category_slug' => $slug,
            'category_image' => $image,
            'product_features' => ($this->input->post('product_features')!='') ? implode(',', $this->input->post('product_features')) : ''
        );

        $data = $this->security->xss_clean($data);

        if($this->common_model->update($data, $id,'tbl_category')){
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
            redirect(base_url() . 'admin/category/edit/'.$id, 'refresh');
        }
        
    }

    
    //-- active
    public function active($id) 
    {
        $data = array(
            'status' => 1
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'tbl_category');

        $response = array('message' => $this->lang->line('enable_msg'),'status' => '1','class' => 'success');
                            
        echo json_encode($response);
        exit;
    }

    //-- deactive
    public function deactive($id) 
    {
        $data = array(
            'status' => 0
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'tbl_category');
        $response = array('message' => $this->lang->line('disable_msg'),'status' => '1','class' => 'success');
                            
        echo json_encode($response);
        exit;
    }

    //-- deactive
    public function category_on_home() 
    {

        $data = array(
            'set_on_home' => $this->input->post('status')
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $this->input->post('id'),'tbl_category');
        
        if($this->input->post('status')==1){

            $messge = array('message' => $this->lang->line('category_show'),'class' => 'success');
            $this->session->set_flashdata('response_msg', $messge);

        }
        else{
            $messge = array('message' => $this->lang->line('category_remove'),'class' => 'success');
            $this->session->set_flashdata('response_msg', $messge);
        }
    }


    //-- delete category
    public function delete($id)
    {
        echo $this->Category_model->delete($id);
    }


}