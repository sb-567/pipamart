<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

    private $redirectUrl=NULL;

    public function __construct(){
        parent::__construct();
        check_login_user();
        $this->load->helper('image'); 
        $this->load->model('common_model');
        $this->load->model('Users_model');
        $this->load->model('Product_model');
        $this->load->model('Api_model','api_model');

        $this->load->library('user_agent');

        $this->load->library("CompressImage");

        $currentURL = current_url();
        $params   = $_SERVER['QUERY_STRING'];
        $this->redirectUrl = (!empty($params)) ? $currentURL . '?' . $params : $currentURL;
    }

    function index()
    {
        $data = array();
        $data['page_title'] = $this->lang->line('users_lbl');
        $data['current_page'] = $this->lang->line('users_lbl');

        if($this->input->get('search_value')!='')
        {
            $keyword=addslashes(trim($this->input->get('search_value')));
        }
        else{
            $keyword='';
        }

        $row=$this->Users_model->user_list('id', 'DESC', '', '', $keyword);

        $config = array();
        $config["base_url"] = base_url() . 'admin/users';
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
        $data['user_list'] = $this->Users_model->user_list('id', 'DESC', $config["per_page"], $page, $keyword);
        
        $data["redirectUrl"] = $this->redirectUrl;
        
        $this->template->load('admin/template', 'admin/page/users', $data); // :blush:
    } 

    function addForm()
    {
        $redirect=$_GET['redirect'].(isset($_GET['page']) ? '&page='.$_GET['page'] : '');

        $this->form_validation->set_rules('user_name', $this->lang->line('name_place_lbl'), 'trim|required');
        $this->form_validation->set_rules('user_email', $this->lang->line('email_place_lbl'), 'trim|required');
        $this->form_validation->set_rules('user_phone', $this->lang->line('phone_no_place_lbl'), 'trim|required');
        $this->form_validation->set_rules('user_password', $this->lang->line('password_place_lbl'), 'trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $messge = array('message' => $this->lang->line('input_required'),'class' => 'error');
                $this->session->set_flashdata('response_msg', $messge);
                
            if(isset($_GET['redirect'])){
                redirect($redirect, 'refresh');
            }
            else{
                redirect(base_url() . 'admin/users/add', 'refresh');
            }
        }
        else
        {

            $row_usr=$this->common_model->selectByids(array('user_type' => 'Normal','user_email' => $this->input->post('user_email')), 'tbl_users');

            //-- if valid
            if(empty($row_usr)){
                $config['upload_path'] =  'assets/images/users/';
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
                        redirect(base_url() . 'admin/users/add', 'refresh');
                    }

                } 
                else
                {  
                    $upload_data = $this->upload->data();
                }

                $this->load->helper("date");

                $data = array(
                    'user_name'  => $this->input->post('user_name'),
                    'user_email'  => $this->input->post('user_email'),
                    'user_phone'  => $this->input->post('user_phone'),
                    'user_password'  => md5($this->input->post('user_password')),
                    'user_image'  => $image,
                    'created_at'  =>  strtotime(date('d-m-Y h:i:s A'))
                );

                $data = $this->security->xss_clean($data);

                if($this->common_model->insert($data, 'tbl_users')){
                    $messge = array('message' => $this->lang->line('add_msg'),'class' => 'success');
                    $this->session->set_flashdata('response_msg', $messge);

                }
                else{
                    $messge = array('message' => $this->lang->line('add_error'),'class' => 'error');
                    $this->session->set_flashdata('response_msg', $messge);
                }
            }
            else{
                $messge = array('message' => $this->lang->line('email_exist_error'),'class' => 'error');
                $this->session->set_flashdata('response_msg', $messge);
            }

            if(isset($_GET['redirect'])){
                redirect($redirect, 'refresh');
            }
            else{
                redirect(base_url() . 'admin/users/add', 'refresh');
            }
        }
    }

    public function user_form()
    {
        $data = array();

        $id =  $this->uri->segment(4);

        $data['page_title'] = $this->lang->line('users_lbl');
        if($id=='')
        {
            $data['current_page'] = $this->lang->line('add_user_lbl');
        }
        else{
            $data['users'] = $this->Users_model->single_user($id);

            $data['current_page'] = $this->lang->line('edit_user_lbl');
        }
        $this->template->load('admin/template', 'admin/page/user_form', $data); // :blush:
    }



    //-- update users info
    public function editForm($id)
    {
        $redirect=$_GET['redirect'].(isset($_GET['page']) ? '&page='.$_GET['page'] : '');

        $data = $this->Users_model->single_user($id);

        $row_usr=$this->common_model->selectByids(array('user_type' => $data[0]->user_type, 'id <>' => $id,'user_email' => $this->input->post('user_email')), 'tbl_users');

        if(empty($row_usr))
        {
            if($_FILES['file_name']['error']!=4){
            
                if(file_exists('assets/images/users/'.$data[0]->user_image))
                {
                    unlink('assets/images/users/'.$data[0]->user_image);

                    $mask = $data[0]->id.'*_*';
                    array_map('unlink', glob('assets/images/users/thumbs/'.$mask));

                    $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $data[0]->user_image);
                    $mask = $thumb_img_nm.'*_*';
                    array_map('unlink', glob('assets/images/users/thumbs/'.$mask));
                }
                
                $config['upload_path'] =  'assets/images/users/';
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
                        redirect(base_url() . 'admin/users/edit/'.$id, 'refresh');
                    }
                }

            }
            else{
                $image=$data[0]->user_image;
            }

            $this->load->helper("date");

            $password='';
            if($this->input->post('user_password')!=''){
                $password=md5($this->input->post('user_password'));
            }
            else{
                $password=$data[0]->user_password;
            }

            $data = array(
                'user_name'  => $this->input->post('user_name'),
                'user_email'  => $this->input->post('user_email'),
                'user_phone'  => $this->input->post('user_phone'),
                'user_password'  => $password,
                'user_image'  => $image
            );

            $data = $this->security->xss_clean($data);

            if($this->common_model->update($data, $id,'tbl_users')){
                $messge = array('message' => $this->lang->line('update_msg'),'class' => 'success');
                $this->session->set_flashdata('response_msg', $messge);
            }
            else{
                $messge = array('message' => $this->lang->line('update_error'),'class' => 'error');
                $this->session->set_flashdata('response_msg', $messge);
            }
        }
        else
        {
            $messge = array('message' => $this->lang->line('email_exist_error'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $messge);
        }

        if(isset($_GET['redirect'])){
            redirect($redirect, 'refresh');
        }
        else{
            redirect(base_url() . 'admin/users/edit/'.$id, 'refresh');
        }
        
    }

    
    //-- active user
    public function active($id) 
    {
        $data = array(
            'status' => 1
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'tbl_users');
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
        $this->common_model->update($data, $id,'tbl_users');
        $response = array('message' => $this->lang->line('disable_msg'),'status' => '1','class' => 'success');
                            
        echo json_encode($response);
        exit;
    }

    //-- delete user
    public function delete($id)
    {
        echo $this->Users_model->delete($id);
    }

    public function user_profile()
    {
        $id =  $this->uri->segment(4);

        $data['page_title'] = $this->lang->line('users_lbl');
        
        $data['user'] = $this->Users_model->single_user($id);

        $data['wishlist_row'] = $this->api_model->get_wishlist($id);

        $data['cart_row'] = $this->api_model->get_cart($id);

        $data['order_row'] = $this->api_model->get_my_orders($id);

        $data['bank_details'] = $this->common_model->selectByids(array('user_id' => $id), 'tbl_bank_details');

        $data['address_data'] = $this->common_model->get_addresses($id);

        $where= array('user_id' => $id);

        $review=$this->common_model->selectByids($where, 'tbl_rating');
        
        $data['review_data'] = $review;

        $data['current_page'] = 'My Profile';

        $this->template->load('admin/template', 'admin/page/user_profile', $data); // :blush
    }   

    public function _create_thumbnail($path, $thumb_name, $fileName, $width, $height) 
    {
        $source_path = $path.$fileName;

        $ext = pathinfo($fileName, PATHINFO_EXTENSION);

        $thumb_name=$thumb_name.'_'.$width.'x'.$height.'.'.$ext;

        $thumb_path=$path.'thumbs/'.$thumb_name;

        if(!file_exists($thumb_path)){
            $this->load->library('image_lib');
            $config['image_library']  = 'gd2';
            $config['source_image']   = $source_path;       
            $config['new_image']      = $thumb_path;               
            $config['create_thumb']   = FALSE;
            $config['maintain_ratio'] = FALSE;
            $config['width']          = $width;
            $config['height']         = $height;
            $this->image_lib->initialize($config);
            if (! $this->image_lib->resize()) { 
                echo $this->image_lib->display_errors();
            }

            $file = base_url($thumb_path); //file that you wanna compress
            $new_name_image = $thumb_name; //name of new file compressed
            $quality = 70; // Value that I chose
            $pngQuality = 9; // Exclusive for PNG files
            $destination = base_url($path.'thumbs'); //This destination must be exist on your project

            $image_compress = new Compress($file, $new_name_image, $quality, $pngQuality, $destination);

            $image_res=$image_compress->compress_image();

            $image_compress = null;
        }

        return $thumb_path;
    } 

    public function remove_to_cart(){

        $id =  $this->uri->segment(4);

        if($this->common_model->delete($id, 'tbl_cart')){
            $messge = array('message' => $this->lang->line('remove_cart'),'class' => 'success');
            $this->session->set_flashdata('response_msg', $messge);

            redirect($this->agent->referrer());
        }
    }

    public function remove_to_wishlist(){

        $id =  $this->uri->segment(4);

        if($this->common_model->delete($id, 'tbl_wishlist')){
            $messge = array('message' => $this->lang->line('remove_wishlist'),'class' => 'success');
            $this->session->set_flashdata('response_msg', $messge);

            redirect($this->agent->referrer());
        }
    }

    public function remove_review(){

        $id =  $this->uri->segment(4);

        $row_img=$this->common_model->selectByids(array('parent_id' => $id, 'type' => 'review'), 'tbl_product_images');

        foreach ($row_img as $key => $value) {
            if(file_exists('assets/images/review_images/'.$value->image_file) && $value->image_file!=''){
                unlink('assets/images/review_images/'.$value->image_file);
              } 
        }

        $this->common_model->deleteByids(array('parent_id' => $id, 'type' => 'review'), 'tbl_product_images');

        if($this->common_model->delete($id, 'tbl_rating')){
            $messge = array('message' => $this->lang->line('delete_success'),'class' => 'success');
            $this->session->set_flashdata('response_msg', $messge);

            redirect($this->agent->referrer());
        }
    }

    public function remove_bank(){

        $id =  $this->uri->segment(4);

        $row=$this->common_model->selectByid($id,'tbl_bank_details');

        if($row->is_default=='1'){

            $data_arr=$this->common_model->selectByids(array('user_id'=>$row->user_id),'tbl_bank_details');

            if(count($data_arr) > 0){

                $this->common_model->delete($id,'tbl_bank_details');

                $data_arr1 = array(
                    'is_default' => '1'
                );

                $data_usr1 = $this->security->xss_clean($data_arr1);

                $where=array('user_id' => $row->user_id);

                $max_id=$this->common_model->getMaxId('tbl_bank_details',$where);

                $updated_id = $this->common_model->update($data_usr1, $max_id, 'tbl_bank_details');
            }
        }
        else{

            $this->common_model->delete($id, 'tbl_bank_details');
        }

        $messge = array('message' => $this->lang->line('bank_remove'),'class' => 'success');
        $this->session->set_flashdata('response_msg', $messge);
        redirect($this->agent->referrer());
    }

    public function remove_address(){

        $id =  $this->uri->segment(4);

        $row=$this->common_model->selectByid($id,'tbl_addresses');

        if($row->is_default=='true'){

            $data_arr=$this->common_model->selectByids(array('user_id'=>$row->user_id),'tbl_addresses');

            if(count($data_arr) > 0){

                $this->common_model->delete($id,'tbl_addresses');

                $data_arr1 = array(
                    'is_default' => 'true'
                );

                $data_usr1 = $this->security->xss_clean($data_arr1);

                $where=array('user_id' => $row->user_id);

                $max_id=$this->common_model->getMaxId('tbl_addresses',$where);

                $updated_id = $this->common_model->update($data_usr1, $max_id, 'tbl_addresses');
            }
        }
        else{

            $this->common_model->delete($id, 'tbl_addresses');
        }

        $messge = array('message' => $this->lang->line('delete_success'),'class' => 'success');
        $this->session->set_flashdata('response_msg', $messge);
        redirect($this->agent->referrer());
    }

    public function get_status_title($id){
        return $this->common_model->selectByidParam($id,'tbl_status_title','title');
    }

    

}