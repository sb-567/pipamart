<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banner extends CI_Controller {

    private $redirectUrl=NULL;

    public function __construct()
    {
        parent::__construct();
        check_login_user();
        $this->load->helper('image'); 
        $this->load->model('common_model');
        $this->load->model('Banner_model');
        $this->load->model('Product_model');

        $currentURL = current_url();
        $params   = $_SERVER['QUERY_STRING'];
        $this->redirectUrl = (!empty($params)) ? $currentURL . '?' . $params : $currentURL;
    }

    function index()
    {
        $data = array();
        $data['page_title'] = $this->lang->line('banners_lbl');
        $data['current_page'] = $this->lang->line('banners_lbl');

        if($this->input->get('search_value')!='')
        {
            $keyword=addslashes(trim($this->input->get('search_value')));
        }
        else{
            $keyword='';
        }

        $row=$this->Banner_model->banner_list('id','DESC','','', $keyword);

        $config = array();
        $config["base_url"] = base_url() . 'admin/banner';
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
        $data['banner_list'] = $this->Banner_model->banner_list('id', 'DESC', $config["per_page"], $page, $keyword);

        $data["redirectUrl"] = $this->redirectUrl;
        
        $this->template->load('admin/template', 'admin/page/banner', $data); // :blush:
    }

    public function get_products()
    {
        $data= $this->Product_model->get_products();
        if(!empty($data)){
            return $data;    
        }else{
            return '';
        }
    } 
    public function productById($id)
    {
        $data= $this->Product_model->single_product($id);
        if(!empty($data)){
            return $data;    
        }else{
            return '';
        }
    }

    public function product_list($ids)
    {

        $ids=explode(',', $ids);

        $data= $this->Product_model->banner_products($ids);
        if(!empty($data)){
            return $data;    
        }else{
            return '';
        }
    }

    private function get_offer_products($offer_id)
    {
        $row=$this->common_model->selectByids(array('offer_id' => $offer_id, 'status' => '1'),'tbl_product','id');

        foreach ($row as $key => $value) {
            $ids[]=$value->id;    
        }
        
        return $ids=implode(',', $ids);

    }  

    function addForm()
    {

        $redirect=$_GET['redirect'].(isset($_GET['page']) ? '&page='.$_GET['page'] : '');

        $this->form_validation->set_rules('title', 'Enter Banner Title', 'trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $messge = array('message' => $this->upload->display_errors(),'class' => 'error');
                $this->session->set_flashdata('response_msg', $messge);

            if(isset($_GET['redirect'])){
                redirect($redirect, 'refresh');
            }
            else{
                redirect(base_url() . 'admin/banner/add', 'refresh');
            }
        }
        else
        {
            $config['upload_path'] =  'assets/images/banner/';
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
                    redirect(base_url() . 'admin/banner/add', 'refresh');
                }
            } 
            else
            {  
                $upload_data = $this->upload->data();
            }

            $this->load->helper("date");

            $slug = url_title($this->input->post('title'), 'dash', TRUE);

            $product_ids=($this->input->post('product_ids')!='') ? implode(',', $this->input->post('product_ids')) : '';

            if($this->input->post('offer_id')!=0){
                $product_ids=$this->get_offer_products($this->input->post('offer_id'));;
            }

            $data = array(
                'banner_title'  => $this->input->post('title'),
                'banner_slug'  => $slug,
                'banner_desc'  => $this->input->post('banner_desc'),
                'banner_image'  => $image,
                'offer_id'  => $this->input->post('offer_id'),
                'product_ids'  =>  $product_ids,
                'created_at'  =>  strtotime(date('d-m-Y h:i:s A'))
            );

            $data = $this->security->xss_clean($data);

            if($this->common_model->insert($data, 'tbl_banner')){
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
                redirect(base_url() . 'admin/banner/add', 'refresh');
            }
        }
    }

    public function banner_form()
    {
        $data = array();

        $id =$this->uri->segment(4);

        $data['page_title'] = $this->lang->line('banners_lbl');

        $data['products'] = $this->common_model->selectWhere('tbl_product', array('status' => '1'), 'DESC', 'id');

        $data['offers'] = $this->common_model->selectWhere('tbl_offers', array('status' => '1'), 'DESC', 'id');

        if($id==''){
            $data['current_page'] = 'Add Banner';
        }
        else{
            $data['banner'] = $this->Banner_model->single_banner($id);

            $data['current_page'] = 'Edit Banner';
        }
        $this->template->load('admin/template', 'admin/page/banner_form', $data); // :blush:
    }

    public function banner_products()
    {
        $data = array();

        $id =$this->uri->segment(4);

        $data['page_title'] = $this->lang->line('banners_lbl');
        $data['current_page'] = "Banner's Products";
        $data['banner'] = $this->Banner_model->single_banner($id);

        $this->template->load('admin/template', 'admin/page/banner_products', $data); // :blush:
    }



    //-- update users info
    public function editForm($id)
    {
        $redirect=$_GET['redirect'].(isset($_GET['page']) ? '&page='.$_GET['page'] : '');

        $data = $this->Banner_model->single_banner($id);

        if($_FILES['file_name']['error']!=4){
            
            if(file_exists('assets/images/banner/'.$data[0]->banner_image))
            {
                unlink('assets/images/banner/'.$data[0]->banner_image);
                $mask = $data[0]->banner_slug.'*_*';
                array_map('unlink', glob('assets/images/banner/thumbs/'.$mask));

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $data[0]->banner_image);
                $mask = $thumb_img_nm.'*_*';
                array_map('unlink', glob('assets/images/banner/thumbs/'.$mask));
            }

            $config['upload_path'] =  'assets/images/banner/';
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
                    redirect(base_url() . 'admin/banner/edit/'.$id, 'refresh');
                }
            }

        }
        else{
            $image=$data[0]->banner_image;
        }

        $this->load->helper("date");

        $slug = url_title($this->input->post('title'), 'dash', TRUE);

        $product_ids=($this->input->post('product_ids')!='') ? implode(',', $this->input->post('product_ids')) : '';

        if($this->input->post('offer_id')!=0){
            $product_ids=$this->get_offer_products($this->input->post('offer_id'));;
        }

        $data = array(
            'banner_title'  => $this->input->post('title'),
            'banner_slug'  => $slug,
            'banner_desc'  => $this->input->post('banner_desc'),
            'banner_image'  => $image,
            'offer_id'  => $this->input->post('offer_id'),
            'product_ids'  =>  $product_ids
        );

        $data = $this->security->xss_clean($data);

        if($this->common_model->update($data, $id,'tbl_banner')){
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
            redirect(base_url() . 'admin/banner/edit/'.$id, 'refresh');
        }
        
    }

    
    //-- active user
    public function active($id) 
    {
        $data = array(
            'status' => 1
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'tbl_banner');
        $response = array('message' => $this->lang->line('enable_msg'),'status' => '1','class' => 'success');
                            
        echo json_encode($response);
        exit;
    }

    //-- deactive user
    public function deactive($id) 
    {
        $data = array(
            'status' => 0
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'tbl_banner');
        $response = array('message' => $this->lang->line('disable_msg'),'status' => '1','class' => 'success');
                            
        echo json_encode($response);
        exit;
    }

    //-- delete banner
    public function delete($id)
    {
        echo $this->Banner_model->delete($id);
    }

    //-- remove banner products
    public function remove_product($id)
    {
        $banner_id =$this->uri->segment(4);
        $product_id =$this->uri->segment(5);
        if($this->Banner_model->remove_product($banner_id,$product_id)){
            $messge = array('message' => $this->lang->line('product_remove_banner_msg'),'status' => '1','class' => 'success');
        }
        else{
            $messge = array('message' => $this->lang->line('no_data'),'status' => '1','class' => 'error');
        }
                            
        $this->session->set_flashdata('response_msg', $messge);
        exit;
    }

}