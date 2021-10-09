<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Offers extends CI_Controller {

    private $redirectUrl=NULL;

    public function __construct()
    {
        parent::__construct();
        check_login_user();
        $this->load->helper('image'); 
        $this->load->model('common_model');
        $this->load->model('Offers_model');
        $this->load->model('Product_model');

        $currentURL = current_url();
        $params   = $_SERVER['QUERY_STRING'];
        $this->redirectUrl = (!empty($params)) ? $currentURL . '?' . $params : $currentURL;
    }

    function index()
    {
        $data = array();
        $data['page_title'] = $this->lang->line('offers_lbl');
        $data['current_page'] = 'products';

        if($this->input->get('search_value')!='')
        {
            $keyword=addslashes(trim($this->input->get('search_value')));
        }
        else{
            $keyword='';
        }

        $row=$this->Offers_model->offers_list('id','DESC', '', '', $keyword);

        $config = array();
        $config["base_url"] = base_url() . 'admin/offers';
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
        $data['offers_list'] = $this->Offers_model->offers_list('id','DESC', $config['per_page'], $page, $keyword);

        $data["redirectUrl"] = $this->redirectUrl;

        $this->template->load('admin/template', 'admin/page/offers', $data); // :blush:
    } 

    function addForm()
    {
        $redirect=$_GET['redirect'].(isset($_GET['page']) ? '&page='.$_GET['page'] : '');

        $this->form_validation->set_rules('offer_title', $this->lang->line('title_lbl'), 'trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $messge = array('message' => $this->lang->line('input_required'),'class' => 'error');
                $this->session->set_flashdata('response_msg', $messge);

            if(isset($_GET['redirect'])){
                redirect($redirect, 'refresh');
            }
            else{
                redirect(base_url() . 'admin/offers/add', 'refresh');
            }
        }
        else
        {
            $config['upload_path'] =  'assets/images/offers/';
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
                    redirect(base_url() . 'admin/offers/add', 'refresh');
                }
            } 
            else
            {  
                $upload_data = $this->upload->data();
            }

            $this->load->helper("date");

            $slug = url_title($this->input->post('offer_title'), 'dash', TRUE);

            $data = array(
                'offer_title'  => $this->input->post('offer_title'),
                'offer_slug'  => $slug,
                'offer_desc'  => $this->input->post('offer_desc'),
                'offer_percentage'  => $this->input->post('offer_per'),
                'offer_image'  => $image,
                'created_at'  =>  strtotime(date('d-m-Y h:i:s A'))
            );

            $data = $this->security->xss_clean($data);

            if($this->common_model->insert($data, 'tbl_offers')){
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
                redirect(base_url() . 'admin/offers/add', 'refresh');
            }
        }
    }

    public function offer_form()
    {
        $data = array();

        $id =  $this->uri->segment(4);

        $data['current_page'] = 'products';

        if($id==''){
            $data['page_title'] = $this->lang->line('add_offer_lbl');
        }
        else{
            $data['offer'] = $this->Offers_model->single_offer($id);

            $data['page_title'] = $this->lang->line('edit_offer_lbl');
        }
        $this->template->load('admin/template', 'admin/page/offer_form', $data); // :blush:
    }



    //-- update users info
    public function editForm($id)
    {
        $redirect=$_GET['redirect'].(isset($_GET['page']) ? '&page='.$_GET['page'] : '');

        $data = $this->Offers_model->single_offer($id);

        if($_FILES['file_name']['error']!=4){
            
            if(file_exists('assets/images/offers/'.$data->offer_image))
            {   
                unlink('assets/images/offers/'.$data->offer_image);

                $mask = $data->offer_slug.'*_*';
                array_map('unlink', glob('assets/images/offers/thumbs/'.$mask));

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $data->offer_image);
                $mask = $thumb_img_nm.'*_*';
                array_map('unlink', glob('assets/images/offers/thumbs/'.$mask)); 
            }
            
            // unlink('assets/images/offers/thumbs'.$data->offer_image);

            $config['upload_path'] =  'assets/images/offers/';
            $config['allowed_types'] = 'jpg|png|jpeg';

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
                    redirect(base_url() . 'admin/offers/edit/'.$id, 'refresh');
                }
            }

        }
        else{
            $image=$data->offer_image;
        }

        $this->load->helper("date");

        $slug = url_title($this->input->post('offer_title'), 'dash', TRUE);

        $data = array(
            'offer_title'  => $this->input->post('offer_title'),
            'offer_slug'  => $slug,
            'offer_desc'  => $this->input->post('offer_desc'),
            'offer_percentage'  => $this->input->post('offer_per'),
            'offer_image'  => $image
        );

        $data = $this->security->xss_clean($data);

        if($this->common_model->update($data, $id,'tbl_offers')){

            $offer_per=$this->input->post('offer_per');

            $where=array('offer_id' => $id);
            $row_data=$this->common_model->selectByids($where, 'tbl_product');

            if(count($row_data) > 0){
                // update product offers value

                foreach ($row_data as $key => $value) {
                    $mrp=$value->product_mrp;

                    $selling_price=round($mrp - (($offer_per/100) * $mrp),2);

                    $you_save_amt=round($mrp-$selling_price,2);

                    $data_arr = array(
                        'selling_price' => $selling_price,
                        'you_save_amt' => $you_save_amt,
                        'you_save_per' => $offer_per,
                    ); 

                    $data_arr = $this->security->xss_clean($data_arr);

                    $this->common_model->updateByids($data_arr, array('id' => $value->id),'tbl_product');

                }
            }

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
            redirect(base_url() . 'admin/offers/edit/'.$id, 'refresh');
        }
        
    }

    
    //-- active user
    public function active($id) 
    {
        $data = array(
            'status' => 1
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'tbl_offers');
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
        $this->common_model->update($data, $id,'tbl_offers');
        $response = array('message' => $this->lang->line('disable_msg'),'status' => '1','class' => 'success');
                            
        echo json_encode($response);
        exit;
    }

    //-- delete offer
    public function delete($id)
    {
        echo $this->Offers_model->delete($id);
    }   


}