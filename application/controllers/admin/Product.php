<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {

    private $redirectUrl=NULL;

    public function __construct(){
        parent::__construct();
        check_login_user();
        $this->load->helper('image'); 
        $this->load->model('Category_model');
        $this->load->model('Sub_Category_model');
        $this->load->model('Brand_model');
        $this->load->model('Offers_model');
        $this->load->model('common_model');
        $this->load->model('Product_model');

        $currentURL = current_url();
        $params   = $_SERVER['QUERY_STRING'];
        $this->redirectUrl = (!empty($params)) ? $currentURL . '?' . $params : $currentURL;
    }

    public function get_category_info($id, $param)
    {
        $data= $this->Category_model->single_category($id);
        if(!empty($data)){
            return $data[0]->$param;    
        }else{
            return '';
        }
    }

    public function get_single_info($ids, $param, $table_nm)
    {
        $data= $this->common_model->selectByids($ids, $table_nm);
        if(!empty($data)){
            return $data[0]->$param;    
        }else{
            return '';
        }
    }

    public function get_sub_category_info($id, $param)
    {
        $data= $this->Sub_Category_model->single($id);
        if(!empty($data)){
            return $data[0]->$param;    
        }else{
            return '';
        }
    }

    public function get_brand_info($id, $param)
    {
        $data= $this->Brand_model->single_brand($id);
        if(!empty($data)){
            return $data[0]->$param;    
        }else{
            return '';
        }
    }

    public function get_sub_category($id)
    {
        $data = $this->Sub_Category_model->get_subcategories($id);
        $opt='';
        foreach ($data as $key => $row) {
            $opt.='<option value="'.$row->id.'">'.$row->sub_category_name.'</option>';
        }
        echo $opt;
    }
    public function get_submenu_header($id)
    {
        $data = $this->Sub_Category_model->get_submenuheaders($id);
        $opt='';
        foreach ($data as $key => $row) {
            $opt.='<option value="'.$row->id.'">'.$row->submenu_header.'</option>';
        }
        echo $opt;
    }

     public function get_submenu_items($id)
    {
        $data = $this->Sub_Category_model->get_submenuitems($id);
        $opt='';
        foreach ($data as $key => $row) {
            $opt.='<option value="'.$row->id.'">'.$row->submenu_item_name.'</option>';
        }
        echo $opt;
    }

    public function get_brands($ids)
    {
        $data = $this->Brand_model->get_brands($ids);
        $opt='';

        if(!empty($data)){
            foreach ($data as $key => $row) {
                $opt.='<option value="'.$row->id.'">'.$row->brand_name.'</option>';
            }
            echo $opt;    
        }
        else{
            $data = $this->Brand_model->get_list();
            foreach ($data as $key => $row) {
                $opt.='<option value="'.$row->id.'">'.$row->brand_name.'</option>';
            }
            echo $opt; 
        }
        
    }

    public function get_featured($id)
    {
        echo $this->get_category_info($id,'product_features');
    }

    public function get_color_products(){

        $response=array();

        $cat_id=$this->input->post('cat_id');
        $brand_id=$this->input->post('brand_id');

        $features=explode(',', $this->get_category_info($cat_id,'product_features'));

        if(in_array('color', $features)){

            if($this->input->post('curr_id')!=0)
                $ids=array('category_id'=>$cat_id, 'brand_id'=>$brand_id, 'id !='=>$this->input->post('curr_id'));
            else
                $ids=array('category_id'=>$cat_id, 'brand_id'=>$brand_id);

            $opt='';

            if($row=$this->common_model->selectByids($ids, 'tbl_product')){
                
                foreach ($row as $key => $value) {
                    $opt.='<option value="'.$value->id.'">'.$value->product_title.'</option>';
                } 
                $response['status']=1; 
            }
            else{
                $response['status']=0;
            }

            $response['data']=$opt;

        }
        else{
            $response['status']=0;
        }

        echo json_encode($response);

    }


    public function calculate_offer($offer_id,$mrp)
    {
        $res=array();
        if($offer_id!=0){
            $offer = $this->Offers_model->single_offer($offer_id);
            $res['selling_price']=round($mrp - (($offer->offer_percentage/100) * $mrp),2);

            $res['you_save']=round($mrp-$res['selling_price'],2);
            $res['you_save_per']=$offer->offer_percentage;    
        }
        else{
            $res['selling_price']=$mrp;
            $res['you_save']=0;
            $res['you_save_per']=0;
        }
        echo json_encode($res);
    }

    function index(){

        $data = array();
        $data['page_title'] = $this->lang->line('products_lbl');
        $data['current_page'] = 'products';

        if($this->input->get('search_value')!='')
        {
            $keyword=addslashes(trim($this->input->get('search_value')));
        }
        else{
            $keyword='';
        }

        if($this->input->get('category')){

            if($this->input->get('offers')){

                if($this->input->get('brands')){

                    $row=$this->Product_model->filter_product_list($this->input->get('category'),$this->input->get('offers'),$this->input->get('brands'),'','', $keyword);
                }
                else{
                    $row=$this->Product_model->filter_product_list($this->input->get('category'),$this->input->get('offers'),0,'','', $keyword);
                }

            }
            else if($this->input->get('brands')){
                $row=$this->Product_model->filter_product_list($this->input->get('category'),0,$this->input->get('brands'),'','', $keyword);
            }
            else{
                $row=$this->Product_model->filter_product_list($this->input->get('category'),0,0,'','', $keyword);
            }
            
        }
        else if($this->input->get('offers')){

            if($this->input->get('brands')){

                $row=$this->Product_model->filter_product_list(0,$this->input->get('offers'),$this->input->get('brands'),'','', $keyword);
            }
            else{
                $row=$this->Product_model->filter_product_list(0,$this->input->get('offers'),0,'','', $keyword);
            }
        }
        else if($this->input->get('brands')){
            $row=$this->Product_model->filter_product_list(0,0,$this->input->get('brands'),'','', $keyword);
        }
        else{
            $row=$this->Product_model->filter_product_list(0,0,0,'','',$keyword);
        }

        $config = array();
        $config["base_url"] = base_url() . 'admin/products';
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

        if($this->input->get('category')){

            if($this->input->get('offers')){

                if($this->input->get('brands')){

                    $row=$this->Product_model->filter_product_list($this->input->get('category'),$this->input->get('offers'),$this->input->get('brands'), $config["per_page"], $page, $keyword);
                }
                else{
                    $row=$this->Product_model->filter_product_list($this->input->get('category'),$this->input->get('offers'),0,$config["per_page"], $page, $keyword);
                }

            }
            else if($this->input->get('brands')){

                $row=$this->Product_model->filter_product_list($this->input->get('category'),0,$this->input->get('brands'), $config["per_page"], $page, $keyword);

            }
            else{
                $row=$this->Product_model->filter_product_list($this->input->get('category'),0,0,$config["per_page"], $page, $keyword);
            }

            $data["links"] = $this->pagination->create_links();
            
        }
        else if($this->input->get('offers')){

            if($this->input->get('brands')){

                $row=$this->Product_model->filter_product_list(0,$this->input->get('offers'),$this->input->get('brands'),$config["per_page"], $page, $keyword);
            }
            else{
                $row=$this->Product_model->filter_product_list(0,$this->input->get('offers'),0,$config["per_page"], $page, $keyword);
            }

            $data["links"] = $this->pagination->create_links();

        }
        else if($this->input->get('brands')){

            $row=$this->Product_model->filter_product_list(0,0,$this->input->get('brands'), $config["per_page"], $page, $keyword);

            $data["links"] = $this->pagination->create_links();

        }
        else
        {
            $data["links"] = $this->pagination->create_links();  
            $row=$this->Product_model->filter_product_list(0,0,0,$config["per_page"], $page, $keyword);
        }

        $data['products'] = $row;

        $data['category_list'] = $this->Category_model->category_list();

        $data['brands'] = $this->Brand_model->get_list();

        $data['offer_list'] = $this->Offers_model->offers_list();

        $data["redirectUrl"] = $this->redirectUrl;

        $this->template->load('admin/template', 'admin/page/products', $data); // :blush:
    }

    function addForm()
    {
        
        $this->form_validation->set_rules('category_id', $this->lang->line('select_cat_lbl'), 'required');
        $this->form_validation->set_rules('title', $this->lang->line('title_place_lbl'), 'trim|required');
        $this->form_validation->set_rules('product_desc', $this->lang->line('sort_desc_place_lbl'), 'trim|required');

        $this->form_validation->set_rules('product_mrp', $this->lang->line('product_mrp_place_lbl'), 'trim|required');

        $redirect=$_GET['redirect'].(isset($_GET['category']) ? '&category='.$_GET['category'] : '').(isset($_GET['brands']) ? '&brands='.$_GET['brands'] : '').(isset($_GET['offers']) ? '&offers='.$_GET['offers'] : '');

        if($this->form_validation->run() == FALSE)
        {
            $messge = array('message' => $this->lang->line('input_required'),'class' => 'error');
                $this->session->set_flashdata('response_msg', $messge);
                
            if(isset($_GET['redirect'])){
                redirect($redirect, 'refresh');
            }
            else{
                redirect(base_url() . 'admin/products/add', 'refresh');
            }
        }
        else
        {
            $config['upload_path'] =  'assets/images/products/';
            $config['allowed_types'] = 'jpg|png|jpeg|PNG|JPG|JPEG';

            $image1 = date('dmYhis').'_'.rand(0,99999).".".pathinfo($_FILES['file_name']['name'], PATHINFO_EXTENSION);

            $config['file_name'] = $image1;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file_name')) {
                $messge = array('message' => $this->upload->display_errors(),'class' => 'error');
                $this->session->set_flashdata('response_msg', $messge);

                if(isset($_GET['redirect'])){
                    redirect($redirect, 'refresh');
                }
                else{
                    redirect(base_url() . 'admin/products/add', 'refresh');
                }
            } 
            else
            {  
                $upload_data = $this->upload->data();
            }

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file_name2')) {
                $messge = array('message' => $this->upload->display_errors(),'class' => 'error');
                $this->session->set_flashdata('response_msg', $messge);

                if(isset($_GET['redirect'])){
                    redirect($redirect, 'refresh');
                }
                else{
                    redirect(base_url() . 'admin/products/add', 'refresh');
                }
            } 
            else
            {  
                $upload_data = $this->upload->data();

                $image2=$upload_data['file_name'];
            }

            if($_FILES['size_chart']['error']!=4){
                if (!$this->upload->do_upload('size_chart')) {
                    $messge = array('message' => $this->upload->display_errors(),'class' => 'error');
                    $this->session->set_flashdata('response_msg', $messge);

                    if(isset($_GET['redirect'])){
                        redirect($redirect, 'refresh');
                    }
                    else{
                        redirect(base_url() . 'admin/products/add', 'refresh');
                    }
                } 
                else
                {  
                    $upload_data = $this->upload->data();

                    $size_chart=$upload_data['file_name'];
                } 
            }
            else{
                $size_chart='';
            }

            $this->load->helper("date");

            $color=$this->input->post('product_color').'/'.$this->input->post('color_code');

            $other_color_product='';
            if($this->input->post('other_color_product')!=''){
                $other_color_product=implode(',', $this->input->post('other_color_product'));
            }

            $slug = url_title($this->input->post('title'), 'dash', TRUE);

            $data = array(
                'category_id' => $this->input->post('category_id'),
                'sub_category_id' => $this->input->post('sub_cat_id'),
                'submenu_header_id' => $this->input->post('submenu_header_id'),
                'submenu_item_id' => $this->input->post('submenu_item_id'),
                'brand_id' => $this->input->post('brand_id'),
                'offer_id' => $this->input->post('offer_id'),
                'product_title' => $this->input->post('title'),
                'product_slug' => $slug,
                'product_desc' => strip_tags($this->input->post('product_desc')),
                'product_features' => addslashes($this->input->post('product_features_desc')),
                'featured_image' => $image1,
                'featured_image2' => $image2,
                'size_chart' => $size_chart,
                'product_mrp' => $this->input->post('product_mrp'),
                'selling_price' => $this->input->post('selling_price') ? $this->input->post('selling_price') : '0',
                'you_save_amt' => $this->input->post('you_save') ? $this->input->post('you_save') : '0',
                'you_save_per' => $this->input->post('you_save_per') ? $this->input->post('you_save_per') : '0',
                'other_color_product' => $other_color_product,
                'color' => $color,
                'product_size' => $this->input->post('product_size'),
                'product_quantity' => $this->input->post('product_quantity'),
                'max_unit_buy' => $this->input->post('max_unit_buy'),
                'delivery_charge' => $this->input->post('delivery_charge'),
                'seo_title' => $this->input->post('seo_title'),
                'seo_meta_description' => $this->input->post('seo_meta_description'),
                'seo_keywords' => $this->input->post('seo_keywords'),
                'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
            );

            $data = $this->security->xss_clean($data);
            $last_id=$this->common_model->insert($data, 'tbl_product');

            if($last_id){

                $files = $_FILES;
                $cpt = count($_FILES['product_images']['name']);
                for($i=0; $i<$cpt; $i++)
                {           
                    $_FILES['product_images']['name']= $files['product_images']['name'][$i];
                    $_FILES['product_images']['type']= $files['product_images']['type'][$i];
                    $_FILES['product_images']['tmp_name']= $files['product_images']['tmp_name'][$i];
                    $_FILES['product_images']['error']= $files['product_images']['error'][$i];
                    $_FILES['product_images']['size']= $files['product_images']['size'][$i];    

                    // File upload configuration
                    $uploadPath = 'assets/images/products/gallery/';
                    $config['upload_path'] = $uploadPath;
                    $config['allowed_types'] = 'jpg|png|jpeg|PNG|JPG|JPEG';

                    // Load and initialize upload library
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    // Upload file to server
                    if($this->upload->do_upload('product_images')){
                        // Uploaded file data
                        $imageData = $this->upload->data();
                        $imageFile= $imageData['file_name'];

                        $data = array(
                            'parent_id' => $last_id,
                            'image_file' => $imageFile,
                            'type' => 'product'
                        );

                        $data = $this->security->xss_clean($data);
                        $this->common_model->insert($data, 'tbl_product_images');

                    }
                }


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
                redirect(base_url() . 'admin/products/add', 'refresh');
            }
            
        }
    }

    public function product_form()
    {
        $data = array();

        $id =  $this->uri->segment(4);

        $data['current_page'] = 'products';

        $data['category_list'] = $this->Category_model->category_list();

        $data['brands'] = $this->Brand_model->get_list();

        $data['offer_list'] = $this->Offers_model->offers_list();
        
        if($id==''){
            $data['page_title'] = $this->lang->line('add_product_lbl');
        }
        else{
            $data['product'] = $this->Product_model->single_product($id,false);

            $data['product_photos'] = $this->Product_model->get_gallery($id);

            $data['page_title'] = $this->lang->line('edit_product_lbl');
        }
        $this->template->load('admin/template', 'admin/page/product_form', $data); // :blush:
    }

    public function clone_product()
    {
        $data = array();

        $product_slug =  $this->uri->segment(4);

        $where=array('product_slug' => $product_slug);

        $id =  $this->common_model->getIdBySlug($where, 'tbl_product');

        $data['page_title'] = $this->lang->line('products_lbl');

        $data['category_list'] = $this->Category_model->category_list();

        $data['brands'] = $this->Brand_model->get_list();

        $data['offer_list'] = $this->Offers_model->offers_list();
        
        $data['product'] = $this->Product_model->single_product($id,false);

        $data['product_photos'] = $this->Product_model->get_gallery($id);

        $data['current_page'] = $this->lang->line('duplicate_product_lbl');

        $this->template->load('admin/template', 'admin/page/duplicate_product_form', $data); // :blush:
    }

    //-- update users info
    public function editForm($id)
    {
        $data = $this->Product_model->single_product($id,false);

        $config['upload_path'] =  'assets/images/products/';
        $config['allowed_types'] = 'jpg|png|jpeg|PNG|JPG|JPEG';

        $redirect=$_GET['redirect'].(isset($_GET['category']) ? '&category='.$_GET['category'] : '').(isset($_GET['brands']) ? '&brands='.$_GET['brands'] : '').(isset($_GET['offers']) ? '&offers='.$_GET['offers'] : '');

        if($_FILES['file_name']['error']!=4){
            
            if(file_exists('assets/images/products/'.$data[0]->featured_image))
            {
                unlink('assets/images/products/'.$data[0]->featured_image);

                $mask = $data[0]->product_slug.'*_*';
                array_map('unlink', glob('assets/images/products/thumbs/'.$mask));

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $data[0]->featured_image);
                $mask = $thumb_img_nm.'*_*';
                array_map('unlink', glob('assets/images/products/thumbs/'.$mask));
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
                    redirect(base_url() . 'admin/products/edit'.$id, 'refresh');
                }
            }
        }
        else{
            $image=$data[0]->featured_image;
        }

        if($_FILES['file_name2']['error']!=4){
            
            if(file_exists('assets/images/products/'.$data[0]->featured_image2))
            {
                unlink('assets/images/products/'.$data[0]->featured_image2);

                $mask = $data[0]->id.'*_*';
                array_map('unlink', glob('assets/images/products/thumbs/'.$mask));
            }


            $image2 = date('dmYhis').'_'.rand(0,99999)."_2_.".pathinfo($_FILES['file_name2']['name'], PATHINFO_EXTENSION);

            $config['file_name'] = $image2;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('file_name2')) {
                $messge = array('message' => $this->upload->display_errors(),'class' => 'error');
                $this->session->set_flashdata('response_msg', $messge);

                if(isset($_GET['redirect'])){
                    redirect($redirect, 'refresh');
                }
                else{
                    redirect(base_url() . 'admin/products/edit'.$id, 'refresh');
                }
            }
        }
        else{
            $image2=$data[0]->featured_image2;
        }

        if($_FILES['size_chart']['error']!=4){
            
            if(file_exists('assets/images/products/'.$data[0]->size_chart)){
                unlink('assets/images/products/'.$data[0]->size_chart);
            }

            $size_chart = date('dmYhis').'_'.rand(0,99999)."_3_.".pathinfo($_FILES['size_chart']['name'], PATHINFO_EXTENSION);

            $config['file_name'] = $size_chart;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('size_chart')) {
                $messge = array('message' => $this->upload->display_errors(),'class' => 'error');
                $this->session->set_flashdata('response_msg', $messge);

                if(isset($_GET['redirect'])){
                    redirect($redirect, 'refresh');
                }
                else{
                    redirect(base_url() . 'admin/products/edit'.$id, 'refresh');
                }
            }
        }
        else
        {
            $size_chart=$data[0]->size_chart;
        }

        $this->load->helper("date");

        $color=$this->input->post('product_color').'/'.$this->input->post('color_code');

        $other_color_product='';
        if($this->input->post('other_color_product')!=''){
            $other_color_product=implode(',', $this->input->post('other_color_product'));
        }

        $slug = url_title($this->input->post('title'), 'dash', TRUE);

        $data = array(
            'category_id' => $this->input->post('category_id'),
            'sub_category_id' => $this->input->post('sub_cat_id'),
            'submenu_header_id' => $this->input->post('submenu_header_id'),
            'submenu_item_id' => $this->input->post('submenu_item_id'),
            'brand_id' => $this->input->post('brand_id'),
            'offer_id' => $this->input->post('offer_id'),
            'product_title' => $this->input->post('title'),
            'product_slug' => $slug,
            'product_desc' => $this->input->post('product_desc'),
            'product_features' => $this->input->post('product_features_desc'),
            'featured_image' => $image,
            'featured_image2' => $image2,
            'size_chart' => $size_chart,
            'product_mrp' => trim($this->input->post('product_mrp')),
            'selling_price' => $this->input->post('selling_price') ? $this->input->post('selling_price') : '0',
            'you_save_amt' => $this->input->post('you_save') ? $this->input->post('you_save') : '0',
            'you_save_per' => $this->input->post('you_save_per') ? $this->input->post('you_save_per') : '0',
            'other_color_product' => $other_color_product,
            'color' => $color,
            'product_size' => $this->input->post('product_size'),
            'product_quantity' => $this->input->post('product_quantity'),
            'max_unit_buy' => $this->input->post('max_unit_buy'),
            'delivery_charge' => $this->input->post('delivery_charge'),
            'seo_title' => $this->input->post('seo_title'),
            'seo_meta_description' => $this->input->post('seo_meta_description'),
            'seo_keywords' => $this->input->post('seo_keywords'),
        );

        $data = $this->security->xss_clean($data);
        $last_id=$this->common_model->update($data, $id, 'tbl_product');

        if($last_id){

            $files = $_FILES;
            $cpt = count($_FILES['product_images']['name']);

            if($cpt > 0){

                $row_img=$this->Product_model->get_gallery($id);

                foreach ($row_img as $key1 => $val1)
                {
                    $mask = $val1->id.'*_*';
                    array_map('unlink', glob('assets/images/products/gallery/thumbs/'.$mask));     
                }

                for($i=0; $i<$cpt; $i++)
                {
                    $_FILES['product_images']['name']= $files['product_images']['name'][$i];
                    $_FILES['product_images']['type']= $files['product_images']['type'][$i];
                    $_FILES['product_images']['tmp_name']= $files['product_images']['tmp_name'][$i];
                    $_FILES['product_images']['error']= $files['product_images']['error'][$i];
                    $_FILES['product_images']['size']= $files['product_images']['size'][$i];    

                    // File upload configuration
                    $uploadPath = 'assets/images/products/gallery/';
                    $config['upload_path'] = $uploadPath;
                    $config['allowed_types'] = 'jpg|png|jpeg|PNG|JPG|JPEG';

                    $imageFile = date('dmYhis').'_'.rand(0,99999)."_2_.".pathinfo($files['product_images']['name'][$i], PATHINFO_EXTENSION);

                    $config['file_name'] = $imageFile;

                    // Load and initialize upload library
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);

                    // Upload file to server
                    if($this->upload->do_upload('product_images')){

                        $data = array(
                            'parent_id' => $id,
                            'image_file' => $imageFile,
                            'type' => 'product'
                        );

                        $data = $this->security->xss_clean($data);
                        $this->common_model->insert($data, 'tbl_product_images');

                    }
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
            redirect(base_url() . 'admin/products/edit'.$id, 'refresh');
        }


    }
    
    //-- active product
    public function active($id) 
    {
        $data = array(
            'status' => 1
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'tbl_product');

        $data_cart = array(
            'cart_status' => 1
        );
        $data_cart = $this->security->xss_clean($data_cart);

        $this->common_model->updateByids($data_cart, array('product_id' => $id),'tbl_cart');
        $this->common_model->updateByids($data_cart, array('product_id' => $id),'tbl_cart_tmp');

        $response = array('message' => $this->lang->line('enable_msg'),'status' => '1','class' => 'success');
                            
        echo json_encode($response);
        exit;
    }

    //-- deactive product
    public function deactive($id) 
    {
        $data = array(
            'status' => 0
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'tbl_product');

        $data_cart = array(
            'cart_status' => 0
        );
        $data_cart = $this->security->xss_clean($data_cart);

        $this->common_model->updateByids($data_cart, array('product_id' => $id),'tbl_cart');
        $this->common_model->updateByids($data_cart, array('product_id' => $id),'tbl_cart_tmp');

        $response = array('message' => $this->lang->line('disable_msg'),'status' => '1','class' => 'success');
                            
        echo json_encode($response);
        exit;
    }

    //-- active product
    public function active_today($id) 
    {
        $this->load->helper("date");

        $data = array(
            'today_deal' => 1,
            'today_deal_date' => strtotime(date('d-m-Y h:i:s A',now()))
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'tbl_product');
        $messge = array('message' => $this->lang->line('today_enable_msg'),'class' => 'success');
        $this->session->set_flashdata('response_msg', $messge);

    }

    //-- deactive product
    public function deactive_today($id,$direct=false) 
    {
        $data = array(
            'today_deal' => 0,
            'today_deal_date' => 0,
        );
        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $id,'tbl_product');
        if(!$direct){
            $messge = array('message' => $this->lang->line('today_disable_msg'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $messge);    
        }
        
    }

    //-- delete product
    public function delete($id)
    {
        echo $this->Product_model->delete($id);
    }

    //-- delete product
    public function remove($id)
    {
        echo $this->Product_model->remove_img($id);
    }

    public function number_format_short($n, $precision = 1)
    {
        if ($n < 900) {
            // 0 - 900
            $n_format = number_format($n, $precision);
            $suffix = '';
        } else if ($n < 900000) {
            // 0.9k-850k
            $n_format = number_format($n / 1000, $precision);
            $suffix = 'K';
        } else if ($n < 900000000) {
            // 0.9m-850m
            $n_format = number_format($n / 1000000, $precision);
            $suffix = 'M';
        } else if ($n < 900000000000) {
            // 0.9b-850b
            $n_format = number_format($n / 1000000000, $precision);
            $suffix = 'B';
        } else {
            // 0.9t+
            $n_format = number_format($n / 1000000000000, $precision);
            $suffix = 'T';
        }

        if ( $precision > 0 ) {
            $dotzero = '.' . str_repeat( '0', $precision );
            $n_format = str_replace( $dotzero, '', $n_format );
        }
        return $n_format . $suffix;
    }
}