<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//LOCATION : application - controller - Auth.php

class Site extends CI_Controller 
{

    private $app_logo;

    private $app_name;

    private $contact_email;

    private $order_email;

    private $google_login_status;
    private $facebook_status;
    private $email_otp_status;

    private $google_client;

    private $page_limit=20;

    public function __construct(){

        ini_set('MAX_EXECUTION_TIME', '-1');

        parent::__construct();
        $this->load->model('Common_model','common_model');
        $this->load->model('Api_model','api_model');
        $this->load->model('Coupon_model');
        $this->load->model('Offers_model');
        $this->load->model('Banner_model');
        $this->load->model('Product_model');
        $this->load->model('Sub_Category_model');
        $this->load->model('Users_model');
        $this->load->model('Order_model');
        $this->load->model('Setting_model');
        $this->load->library('user_agent');
        $this->load->library('pagination');

        $this->load->library("CompressImage");

        $this->load->helper("date");

        $app_setting = $this->api_model->app_details();

        $web_setting = $this->Setting_model->get_web_details();

        $smtp_setting = $this->api_model->smtp_settings();

        $this->app_name=$app_setting->app_name;
        $this->contact_email=$app_setting->app_email;
        $this->order_email=$app_setting->app_order_email;

        define('APP_CURRENCY', $app_setting->app_currency_code);
        define('CURRENCY_CODE', $app_setting->app_currency_html_code);

        $this->google_login_status=$app_setting->google_login_status;
        $this->facebook_status=$app_setting->facebook_status;
        $this->email_otp_status=$app_setting->email_otp_op_status;

        if($this->session->userdata('user_id')){
            check_user_login();
        }

        $curr_date=date('d-m-Y');

        $row_temp_cart=$this->common_model->deleteByids(array("DATE_FORMAT(FROM_UNIXTIME(`created_at`), '%e-%l-%Y') <" => $curr_date), 'tbl_cart_tmp');

    }

    private function get_random_code()
    {
        $code_feed = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyv0123456789";
        $code_length = 8;  // Set this to be your desired code length
        $final_code = "";
        $feed_length = strlen($code_feed);

        for($i = 0; $i < $code_length; $i ++) {
            $feed_selector = rand(0,$feed_length-1);
            $final_code .= substr($code_feed,$feed_selector,1);
        }
        return $final_code;
    }

    public function get_status_title($id){
        return $this->common_model->selectByidParam($id,'tbl_status_title','title');
    }

    public function getCount($table,$where=''){

        if($where=='')
            return $this->common_model->get_count($table);
        else
            return $this->common_model->get_count_by_ids($where,$table);
    }

    public function number_format_short( $n, $precision = 1 ) {
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
      // Remove unecessary zeroes after decimal. "1.0" -> "1"; "1.00" -> "1"
      // Intentionally does not affect partials, eg "1.50" -> "1.50"
        if ( $precision > 0 ) {
            $dotzero = '.' . str_repeat( '0', $precision );
            $n_format = str_replace( $dotzero, '', $n_format );
        }
        return $n_format . $suffix;
    }

    public function index()
    {

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        $data = array();
        $data['page_title'] = $this->lang->line('home_lbl');
        $data['current_page'] = $this->lang->line('home_lbl');

        $data['brands_list'] = $this->api_model->brand_list();

        $data['category_list'] = $this->api_model->category_list();

        $data['offers_list'] = $this->api_model->offers_list();

        $data['banner_list'] = $this->api_model->banner_list();

        $data['todays_deal'] = $this->api_model->products_filter('today_deal','0');

        $data['home_categories'] = $this->common_model->selectByids(array('set_on_home' => '1','status' => '1'),'tbl_category','category_name','ASC');

        $data['latest_products'] = $this->api_model->products_filter('latest_products','',10,0);

        $data['top_rated_products'] = $this->api_model->products_filter('top_rated_products','',10,0);

        $data['recent_viewed_products'] = $this->api_model->products_filter('recent_viewed_products','',10,0,'','','','','','',$user_id);
        $data['web_settings'] = $this->db->get_where('tbl_web_settings', array('id' => '1'))->row();
        // if($_SERVER['REMOTE_ADDR'] =='157.38.106.236'){
        //     echo "<pre>";
        //     print_r($data);die;
        // }
        
        $this->template->load('site/template', 'site/pages/home', $data); // :blush:
    }
    
    public function deal_of_the_day(){

        // $this->load->model('Setting_model');

        $data = array();
        $data['page_title'] = 'Deal Of The Day';
        $data['current_page'] = 'Deal Of The Day';
         $data['todays_deal'] = $this->api_model->products_filter('today_deal','0');
        $this->template->load('site/template2', 'site/pages/deal_of_the_day', $data); // :blush:
    }
    
    public function brand_of_week(){
        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        $data = array();
        $data['page_title'] = $this->lang->line('home_lbl');
        $data['current_page'] = $this->lang->line('home_lbl');

        // $data['brands_list'] = $this->api_model->brand_list();

        // $data['category_list'] = $this->api_model->category_list();

        // $data['offers_list'] = $this->api_model->offers_list();

        $data['banner_list'] = $this->api_model->banner_list();

        // $data['todays_deal'] = $this->api_model->products_filter('today_deal','0');

        // $data['home_categories'] = $this->common_model->selectByids(array('set_on_home' => '1','status' => '1'),'tbl_category','category_name','ASC');

        // $data['latest_products'] = $this->api_model->products_filter('latest_products','',10,0);

        // $data['top_rated_products'] = $this->api_model->products_filter('top_rated_products','',10,0);

        // $data['recent_viewed_products'] = $this->api_model->products_filter('recent_viewed_products','',10,0,'','','','','','',$user_id);
        if($_SERVER['REMOTE_ADDR'] =='157.38.71.139'){
            // echo "<pre>";
            // print_r($data);die;
        }
        
        $this->template->load('site/template', 'site/pages/brand_of_week', $data); // :blush:
    }

    public function page_not_found(){
        $data = array();
        $data['page_title'] = $this->lang->line('page_not_found_lbl');
        $data['current_page'] = $this->lang->line('page_not_found_lbl');
        $this->template->load('site/template2', 'site/pages/404', $data); // :blush:
    }

    public function banners(){
        $data = array();
        $data['page_title'] = $this->lang->line('banner_lbl');
        $data['current_page'] = $this->lang->line('banner_lbl');
        $data['banner_list'] = $this->api_model->banner_list();
        $this->template->load('site/template2', 'site/pages/banners', $data); // :blush:

    }

    public function offers(){
        $data = array();
        $data['page_title'] = $this->lang->line('offer_lbl');
        $data['current_page'] = $this->lang->line('offer_lbl');
        $data['offers_list'] = $this->api_model->offers_list();

        $this->template->load('site/template2', 'site/pages/offers', $data); // :blush:
    }

    public function category(){

        $data = array();
        $data['page_title'] = $this->lang->line('category_lbl');
        $data['current_page'] = $this->lang->line('category_lbl');
        $data['category_list'] = $this->api_model->category_list();
        $this->template->load('site/template2', 'site/pages/category', $data); // :blush:
    }

    public function brand(){

        $data = array();
        $data['page_title'] = $this->lang->line('brands_lbl');
        $data['current_page'] = $this->lang->line('brands_lbl');
        $data['brands_list'] = $this->api_model->brand_list();
        $this->template->load('site/template2', 'site/pages/brand', $data); // :blush:
    }

    public function sub_category(){

        $segment = $this->uri->total_segments();

        $where=array('category_slug' => $this->uri->segment($segment));

        $cat_id =  $this->common_model->getIdBySlug($where, 'tbl_category');
        
        $data = array();
        $data['page_title'] = $this->lang->line('subcategory_lbl');
        $data['current_page'] = $this->common_model->selectByidParam($cat_id,'tbl_category','category_name');
        $data['sub_category_list'] = $this->api_model->sub_category_list($cat_id);
        $data['category_slug'] = $this->common_model->selectByidParam($cat_id,'tbl_category','category_slug');

        $data['sharing_img'] = base_url('assets/images/category/'.$this->common_model->selectByidParam($cat_id,'tbl_category','category_image'));

        $this->template->load('site/template2', 'site/pages/sub_category', $data); // :blush:
    }
    
    public function product_details(){

        $data = array();
        $data['page_title'] = 'Product Details';
        $data['current_page'] = 'Product Details';
        $data['category_list'] = $this->api_model->category_list();
        $this->template->load('site/template2', 'site/pages/product_details', $data); // :blush:
    }

    // Get Categories
    public function get_category(){
        return $this->common_model->selectWhere('tbl_category', array('status' => '1'), 'DESC', 'id');
    }


    // Get Sub Categories
    public function get_sub_category($cat_id){
        return $this->Sub_Category_model->get_subcategories($cat_id);
    }

    public function get_submenu_headers($sub_cat_id){
        return $this->Sub_Category_model->get_submenuheaders($sub_cat_id);
    }

    public function get_submenu_items($header_id){
        // echo 'hc';
        return $this->Sub_Category_model->get_submenuitems($header_id);
    }

    // Get Home Sub Categories
    public function get_home_sub_category($cat_id, $limit){
        return $this->Sub_Category_model->get_home_subcategories($cat_id, $limit);
    }

    // get single product
    public function single_product($product_slug){

        $where=array('product_slug' => $product_slug);

        $product_id =  $this->common_model->getIdBySlug($where, 'tbl_product');

        $row_pro=$this->common_model->selectByid($product_id,'tbl_product');

        $data = array();
        $data['page_title'] = $row_pro->product_title;
        $data['current_page'] = $row_pro->product_title;
        $data['product'] = $row_pro;

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        $where= array('user_id' => $user_id, 'product_id' => $product_id);

        $review=$this->common_model->selectByids($where, 'tbl_rating');

        if(!empty($review)){

            $where= array('type' => 'review', 'parent_id' => $review[0]->id);

            $images=$this->common_model->selectByids($where, 'tbl_product_images');

            array_push($review, $images);

            $data['my_review'] = $review;
        }
        else{
            $data['my_review']=array();
        }

        $data['product_rating'] = $this->api_model->get_product_review($product_id);

        $where=array('category_id' => $data['product']->category_id, 'sub_category_id' => $data['product']->sub_category_id, 'id !=' => $data['product']->id);

        $data['related_products'] = $this->common_model->selectByids($where,'tbl_product');

        $data['recent_viewed_products'] = $this->api_model->products_filter('recent_viewed_products','',10,0,'','','','','','',$user_id);

        $data['sharing_img'] = base_url('assets/images/products/'.$data['product']->featured_image);

        $this->Product_model->_set_view($data['product']->id);

        $this->template->load('site/template2', 'site/pages/single_product', $data); // :blush:

        if($user_id!=0){
            $data_recent = $this->common_model->selectByids(array('user_id' => $user_id, 'product_id' => $data['product']->id), 'tbl_recent_viewed');

            if (empty($data_recent)) {
                // insert product in recent

                $data_arr = array(
                    'user_id' => $user_id,
                    'product_id' => $data['product']->id,
                    'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
                );

                $data_recent_update = $this->security->xss_clean($data_arr);

                $data_recent_update = $this->common_model->insert($data_recent_update, 'tbl_recent_viewed');
            }
            else{

                $data_arr = array(
                    'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
                );

                $data_arr = $this->security->xss_clean($data_arr);

                $where = array('product_id ' => $product_id, 'user_id' => $user_id);

                $updated_id = $this->common_model->updateByids($data_arr, $where, 'tbl_recent_viewed');
            }
        }
    }


    // get product list by ids
    public function get_products(){

        $product_ids=explode(',', $this->session->userdata('product_id'));

        return $this->common_model->selectByidsIN($product_ids, 'tbl_product');
    }


    // all kind products list

    // for product search
    public function search(){

        $keyword=addslashes(trim($this->input->get('keyword')));

        $slug=$this->input->get('category') ? $this->input->get('category') : '';

        $where=array('category_slug' => $slug);

        $category_id =  ($slug!='') ? $this->common_model->getIdBySlug($where, 'tbl_category') : 0;

        $data = array();
        $data['page_title'] = $this->lang->line('search_short_lbl');
        $data['current_page'] = $this->lang->line('search_result_lbl').' '.$keyword;

        $base_url=base_url() . 'search-result/';

        $row_all=$this->api_model->products_filter('search','','','','','','','','',$keyword,'',$category_id);

        $id=0;

        $this->get_product_list('search', $row_all, $id, $base_url, $data, $keyword,'',$category_id);
    }


    // todays deals products
    public function todays_deals_list(){

        $data['page_title'] = $this->lang->line('todays_deal_lbl');
        $data['current_page'] = $this->lang->line('todays_deal_lbl');

        $base_url = base_url() . 'todays-deals/';

        $id=0;

        $row_all=$this->api_model->products_filter('today_deal',$id);

        $this->get_product_list('today_deal', $row_all, $id, $base_url, $data);
    }

    // top-rated products
    public function top_rated_products(){

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        $data['page_title'] = $this->lang->line('top_rated_product_lbl');
        $data['current_page'] = $this->lang->line('top_rated_product_lbl');

        $id=0;

        $base_url=base_url() . 'top-rated-products/';

        $row_all=$this->api_model->products_filter('top_rated_products',$id,'','','', '', '','','', '', $user_id);

        $this->get_product_list('top_rated_products', $row_all, $id, $base_url, $data,'',$user_id);
    }

    // latest products
    public function latest_products(){

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        $data['page_title'] = $this->lang->line('latest_product_lbl');
        $data['current_page'] = $this->lang->line('latest_product_lbl');

        $id=0;

        $base_url=base_url() . 'latest-products/';

        $row_all=$this->api_model->products_filter('latest_products',$id,'','','', '', '','','', '', $user_id);

        $this->get_product_list('latest_products', $row_all, $id, $base_url, $data,'',$user_id);
    }


    // recently viewed products
    public function recently_viewed_products(){

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        $data['page_title'] = $this->lang->line('recent_view_lbl');
        $data['current_page'] = $this->lang->line('recent_view_lbl');

        $id=0;

        $base_url=base_url() . 'recently-viewed-products/';

        $row_all=$this->api_model->products_filter('recent_viewed_products',$id,'','','', '', '','','', '', $user_id);

        $this->get_product_list('recent_viewed_products', $row_all, $id, $base_url, $data,'',$user_id);
    }

    // banner wise products
    public function banner_products(){

        $slug =  $this->uri->segment(2);

        $where = array('banner_slug ' => $slug);

        $data['banner_info'] = $this->common_model->selectByids($where, 'tbl_banner');

        if(empty($data['banner_info']))
        {
            show_404();
        }

        $data['page_title'] = $data['banner_info'][0]->banner_title;
        $data['current_page'] = ucwords($data['banner_info'][0]->banner_title);

        $data['sharing_img'] = base_url('assets/images/banner/'.$data['banner_info'][0]->banner_image);

        $id=$data['banner_info'][0]->id;

        $data['type']='banner';
        $data['id']=$id;

        $base_url=base_url() . 'banners/'.$slug;

        $row_all=$this->api_model->products_filter('banner',$id);

        $this->get_product_list('banner', $row_all, $id, $base_url, $data);

    }

    // offer wise products
    public function offer_products(){

        $slug =  $this->uri->segment(2);

        $where = array('offer_slug' => $slug);

        $data['offer_info'] = $this->common_model->selectByids($where, 'tbl_offers');

        if(empty($data['offer_info']))
        {
            $this->template->load('site/template2', 'site/pages/404'); // :blush:
            return;
        }

        $data['page_title'] = $data['offer_info'][0]->offer_title;
        $data['current_page'] = ucwords($data['offer_info'][0]->offer_title);

        $data['sharing_img'] = base_url('assets/images/offers/'.$data['offer_info'][0]->offer_image);

        $id=$data['offer_info'][0]->id;

        $base_url=base_url() . 'offers/'.$slug;

        $row=array();

        $row_all=$this->api_model->products_filter('offer',$id);

        $this->get_product_list('offer', $row_all, $id, $base_url, $data);
    }

    // brand wise products
    // category and sub category products
    public function brand_product($brand_slug){
        
        $data['category_list'] = $this->api_model->category_list();

        $brand_id=$this->common_model->getIdBySlug(array('brand_slug' => $brand_slug),'tbl_brands');

        $brand_row = $this->common_model->selectByid($brand_id, 'tbl_brands');

        // get brand wise products
        $data['page_title'] = $brand_row->brand_name;
        $data['current_page'] = ucwords($brand_row->brand_name);

        $data['sharing_img'] = base_url('assets/images/brands/'.$brand_row->brand_image);

        $base_url=base_url().'brand/'.$brand_slug;

        $row_all=$this->api_model->products_filter('brand',$brand_row->id);

        $this->get_product_list('brand', $row_all, $brand_row->id, $base_url, $data);

    }

    // category and sub category products
    public function cat_sub_product($category_slug, $sub_category_slug=''){
        
        $data['category_list'] = $this->common_model->selectWhere('tbl_category', array('status' => '1'), 'DESC', 'id');


        if($sub_category_slug!=''){

            if(strcmp($category_slug,'products')==0){

                $category_row = $this->common_model->selectByid($sub_category_slug, 'tbl_category');

                // get category wise products
                $data['page_title'] = $category_row->category_name;
                $data['current_page'] = ucwords($category_row->category_name);

                $data['sharing_img'] = base_url('assets/images/category/'.$category_row->category_image);

                $base_url=base_url().'category/products/'.$category_row->id;

                $row_all=$this->api_model->products_filter('productList_cat',$category_row->id);

                $this->get_product_list('productList_cat', $row_all, $category_row->id, $base_url, $data);

            }
            else{
                $where = array('category_slug ' => $category_slug);

                $category_id=$this->common_model->selectByidsParam($where, 'tbl_category', 'id');

                $where = array('sub_category_slug ' => $sub_category_slug);

                $id=$this->common_model->selectByidsParam($where, 'tbl_sub_category', 'id');

                if($category_id!='' && $id!=''){

                    $data['page_title'] = $category_slug.' | '.$sub_category_slug;
                    $data['current_page'] = ucwords($category_slug.' | '.$sub_category_slug);

                    $data['sharing_img'] = base_url('assets/images/sub_category/'.$this->common_model->selectByidsParam(array('id' => $id), 'tbl_sub_category', 'sub_category_image'));

                    $base_url=base_url().'category/'.$category_slug.'/'.$sub_category_slug;

                    $row_all=$this->api_model->products_filter('productList_cat_sub',$id);

                    $this->get_product_list('productList_cat_sub', $row_all, $id, $base_url, $data);

                }
                else{
                    $this->template->load('site/template2', 'site/pages/404'); // :blush:
                    return;
                }
            }
        }
        else{
            $this->template->load('site/template2', 'site/pages/404'); // :blush:
            return;
        }

    }

    public function submenu_item_products($item_slug=''){
        
        $data['category_list'] = $this->common_model->selectWhere('tbl_category', array('status' => '1'), 'DESC', 'id');


        if($item_slug!=''){

            // if(strcmp($item_slug,'products')==0){

                $category_row = $this->db->where(array("submenu_item_name_slug"=>$item_slug))->get("tbl_submenu_items")->row();

                // get category wise products
                $data['page_title'] = $category_row->submenu_item_name;
                $data['current_page'] = ucwords($category_row->submenu_item_name);

                // $data['sharing_img'] = base_url('assets/images/category/'.$category_row->submenu_item_name);

                $base_url=base_url().'item/products/'.$category_row->id;

                $row_all=$this->api_model->products_filter('productList_item',$category_row->id);

                $this->get_product_list('productList_item', $row_all, $category_row->id, $base_url, $data);

            // }
            // else{
            //     $where = array('category_slug ' => $category_slug);

            //     $category_id=$this->common_model->selectByidsParam($where, 'tbl_category', 'id');

            //     $where = array('sub_category_slug ' => $sub_category_slug);

            //     $id=$this->common_model->selectByidsParam($where, 'tbl_sub_category', 'id');

            //     if($category_id!='' && $id!=''){

            //         $data['page_title'] = $category_slug.' | '.$sub_category_slug;
            //         $data['current_page'] = ucwords($category_slug.' | '.$sub_category_slug);

            //         $data['sharing_img'] = base_url('assets/images/sub_category/'.$this->common_model->selectByidsParam(array('id' => $id), 'tbl_sub_category', 'sub_category_image'));

            //         $base_url=base_url().'category/'.$category_slug.'/'.$sub_category_slug;

            //         $row_all=$this->api_model->products_filter('productList_cat_sub',$id);

            //         $this->get_product_list('productList_cat_sub', $row_all, $id, $base_url, $data);

            //     }
            //     else{
            //         $this->template->load('site/template2', 'site/pages/404'); // :blush:
            //         return;
            //     }
            // }
        }
        else{
            $this->template->load('site/template2', 'site/pages/404'); // :blush:
            return;
        }

    }
    
    private function get_product_list($type, $row_all, $id=0, $base_url, $data, $keyword='', $user_id='',$category=''){

        if(empty($row_all)){
            $this->template->load('site/template2', 'site/pages/no_products', $data); // :blush:
            return;
        }

        $data['category_list'] = $this->common_model->selectWhere('tbl_category', array('status' => '1'), 'DESC', 'id');

        $price_arr=array();

        foreach ($row_all as $key => $value) {

            $price=$value->selling_price;
            array_push($price_arr, $price);
        }

        $row=array();

        $this->load->library('pagination');

        $config = array();
        $config["base_url"] = $base_url;
        $config["per_page"] = $this->page_limit;
        $config['use_page_numbers'] = TRUE;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'page';

        $page = ($this->input->get('page')) ? $this->input->get('page') : 1;

        $page=($page-1) * $config["per_page"];

        $page2 = ($this->input->get('page')) ? $this->input->get('page') : 1;

        // for all kind of sorting

        if(!empty($this->input->get('sortByBrand'))){

            $brands_ids=$this->input->get('sortByBrand');

            $row_all=$this->api_model->products_filter($type, $id,'','',$brands_ids,'','','','', $keyword, $user_id,$category);

            $row=$this->api_model->products_filter($type, $id, $config["per_page"], $page, $brands_ids,'','','','', $keyword, $user_id,$category);

            if($this->input->get('price_filter')!=''){

                $price_filter=(explode('-', $this->input->get('price_filter')));

                $min_price=$price_filter[0];
                $max_price=$price_filter[1];

                $row_all=$this->api_model->products_filter($type, $id,'','',$brands_ids, $min_price, $max_price,'','', $keyword, $user_id,$category);

                $row=$this->api_model->products_filter($type, $id, $config["per_page"], $page, $brands_ids, $min_price, $max_price,'','', $keyword, $user_id,$category);

                if($this->input->get('sort')!=''){

                    $row_all=$this->api_model->products_filter($type, $id,'','',$brands_ids, $min_price, $max_price, $this->input->get('sort'),'', $keyword, $user_id,$category);

                    $row=$this->api_model->products_filter($type, $id, $config["per_page"], $page, $brands_ids, $min_price, $max_price, $this->input->get('sort'),'', $keyword, $user_id,$category);

                    if(!empty($this->input->get('sortBySize'))){

                        $sizes=implode(',', $this->input->get('sortBySize'));

                        $row_all=$this->api_model->products_filter($type, $id,'','',$brands_ids, $min_price, $max_price, $this->input->get('sort'),$sizes, $keyword, $user_id,$category);

                        $row=$this->api_model->products_filter($type, $id, $config["per_page"], $page, $brands_ids, $min_price, $max_price, $this->input->get('sort'),$sizes, $keyword, $user_id,$category);
                    }

                }
                else if(!empty($this->input->get('sortBySize'))){

                    $sizes=implode(',', $this->input->get('sortBySize'));

                    $row_all=$this->api_model->products_filter($type, $id,'','',$brands_ids, $min_price, $max_price,'',$sizes, $keyword, $user_id,$category);

                    $row=$this->api_model->products_filter($type, $id, $config["per_page"], $page, $brands_ids, $min_price, $max_price,'',$sizes, $keyword, $user_id,$category);
                }
            }
            else if(!empty($this->input->get('sortBySize'))){

                $sizes=implode(',', $this->input->get('sortBySize'));

                $row_all=$this->api_model->products_filter($type, $id,'','',$brands_ids,'','','',$sizes, $keyword, $user_id,$category);

                $row=$this->api_model->products_filter($type, $id, $config["per_page"], $page, $brands_ids,'','','',$sizes, $keyword, $user_id,$category);

                if($this->input->get('sort')!=''){

                    $row_all=$this->api_model->products_filter($type, $id,'','',$brands_ids, '', '', $this->input->get('sort'),$sizes, $keyword, $user_id,$category);

                    $row=$this->api_model->products_filter($type, $id, $config["per_page"], $page, $brands_ids, '', '', $this->input->get('sort'),$sizes, $keyword, $user_id,$category);
                }
            }
            else if($this->input->get('sort')!=''){

                $row_all=$this->api_model->products_filter($type, $id,'','',$brands_ids, '', '', $this->input->get('sort'),'', $keyword, $user_id,$category);

                $row=$this->api_model->products_filter($type, $id, $config["per_page"], $page,$brands_ids,'','', $this->input->get('sort'),'', $keyword, $user_id,$category);

            }
        }
        else if($this->input->get('price_filter')!=''){
            // for price filter
            $price_filter=(explode('-', $this->input->get('price_filter')));

            $min_price=$price_filter[0];
            $max_price=$price_filter[1];

            $row_all=$this->api_model->products_filter($type, $id,'','','',$min_price,$max_price,'','', $keyword, $user_id,$category);

            $row=$this->api_model->products_filter($type, $id, $config["per_page"], $page,'',$min_price,$max_price,'','', $keyword, $user_id,$category);

            if($this->input->get('sort')!=''){

                $row_all=$this->api_model->products_filter($type, $id,'','','', $min_price, $max_price, $this->input->get('sort'),'', $keyword, $user_id,$category);

                $row=$this->api_model->products_filter($type, $id, $config["per_page"], $page, '', $min_price, $max_price, $this->input->get('sort'),'', $keyword, $user_id,$category);

                if(!empty($this->input->get('sortBySize'))){

                    $sizes=implode(',', $this->input->get('sortBySize'));

                    $row_all=$this->api_model->products_filter($type, $id,'','','', $min_price, $max_price, $this->input->get('sort'),$sizes, $keyword, $user_id,$category);

                    $row=$this->api_model->products_filter($type, $id, $config["per_page"], $page, '', $min_price, $max_price, $this->input->get('sort'),$sizes, $keyword, $user_id,$category);
                }
            }
            else if(!empty($this->input->get('sortBySize'))){

                $sizes=implode(',', $this->input->get('sortBySize'));

                $row_all=$this->api_model->products_filter($type, $id,'','','', $min_price, $max_price,'',$sizes, $keyword, $user_id,$category);

                $row=$this->api_model->products_filter($type, $id, $config["per_page"], $page, '', $min_price, $max_price,'',$sizes, $keyword, $user_id,$category);
            }
        }
        else if(!empty($this->input->get('sortBySize'))){

            $sizes=implode(',', $this->input->get('sortBySize'));

            $row_all=$this->api_model->products_filter($type, $id,'','','','','','',$sizes, $keyword, $user_id,$category);

            $row=$this->api_model->products_filter($type, $id, $config["per_page"], $page,'','','','',$sizes, $keyword, $user_id,$category);

            if($this->input->get('sort')!=''){

                $row_all=$this->api_model->products_filter($type, $id,'','','', '', '', $this->input->get('sort'),$sizes, $keyword, $user_id,$category);

                $row=$this->api_model->products_filter($type, $id, $config["per_page"], $page, '', '', '', $this->input->get('sort'),$sizes, $keyword, $user_id,$category);
            }
        }else if(!empty($this->input->get('sortByColor'))){

            $colors=implode(',', $this->input->get('sortByColor'));
            // echo $colors;

            $row_all=$this->api_model->products_filter($type, $id,'','','','','','','', $keyword, $user_id,$category,$colors);

            $row=$this->api_model->products_filter($type, $id, $config["per_page"], $page,'','','','','', $keyword, $user_id,$category,$colors);
            // die;
            // if($this->input->get('sort')!=''){

            //     $row_all=$this->api_model->products_filter($type, $id,'','','', '', '', $this->input->get('sort'),$sizes, $keyword, $user_id,$category);

            //     $row=$this->api_model->products_filter($type, $id, $config["per_page"], $page, '', '', '', $this->input->get('sort'),$sizes, $keyword, $user_id,$category);
            // }
        }
        else if(!empty($this->input->get('sort')))
        {
            $row_all=$this->api_model->products_filter($type, $id,'','','','','',$this->input->get('sort'),'', $keyword, $user_id,$category);

            $row=$this->api_model->products_filter($type, $id, $config["per_page"], $page,'','','',$this->input->get('sort'),'',$keyword, $user_id,$category);
        }
        else{
            $row=$this->api_model->products_filter($type, $id, $config["per_page"], $page,'','','','','',$keyword, $user_id,$category);
        }


        $brands=array();
        $size=array();
        $colour=array();

        foreach ($row_all as $key => $value) {

            $brands[]=$value->brand_id;

            if($value->product_size!=''){
                $size[]=$value->product_size;                            
            }
            if($value->color!=''){
                $colour[]=$value->color;                            
            }
        }
        $colour = array_unique($colour);
        // print_r($row_all);die;

        $size_arr=array();

        foreach ($size as $key => $value) {
            foreach (explode(',', $value) as $key1 => $value1) {
                $size_arr[]=trim($value1);
            };
        }

        $color_arr=array();
        $color_i=0;
        foreach ($colour as $value) {
            $dt=explode('/', $value);
                $color_arr[$color_i]['text']=$dt[0];
                $color_arr[$color_i]['hex']=$dt[1];
            
            $color_i++;
        }
        // print_r($color_arr);die;

        if($type!='brand' AND !empty($brands)){
            $data['brand_count_items']=array_count_values($brands);
            $data['brand_list']=$this->common_model->selectByidsIN(array_unique($brands), 'tbl_brands');
        }

        $min=min($price_arr);
        $max=max($price_arr);

        $data['price_min']=$min;  
        $data['price_max']=$max;

        asort($size_arr);

        $data['size_list']=array_unique($size_arr);

        $data['color_list']=$color_arr;

        $config["total_rows"] = count($row_all);
        // print_r($data);die;

        // echo count($row_all);

        $config['num_links'] = 2;
        $config['reuse_query_string'] = TRUE;
         
        $config['full_tag_open'] = '<ul class="page-number">';
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

        $data["links"] = $this->pagination->create_links();

        $data['product_list']=$row;

        $start_count=($page2==1) ? 1 : ($this->page_limit*($page2-1)+1);

        $total_count=count($row_all);
        $count=count($row)*$page2;

        $end_count=($count < $this->page_limit) ? $total_count : $count;

        $data["show_result"] = 'Showing '.$start_count.'–'.$end_count.' of '.count($row_all).' results';

        $this->template->load('site/template2', 'site/pages/products', $data); // :blush:
    }

    // end all kind products list

    //  get wishlist

    public function get_wishlist(){

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        $data = array();
        $data['page_title'] = $this->lang->line('wishlist_lbl');
        $data['current_page'] = $this->lang->line('wishlist_lbl');
        $data['wishlist'] = $this->api_model->get_wishlist($user_id);

        $this->template->load('site/template2', 'site/pages/wishlist', $data); // :blush:
    }

    public function wishlist_action(){

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){

            echo 'login_now';
        }
        else{
            

            $product_id=$this->input->post('product_id');

            $user_id=$this->session->userdata('user_id');

            $where = array('user_id' => $user_id , 'product_id' => $product_id);

            $row=$this->common_model->selectByids($where,'tbl_wishlist');

            $response=array();

            if(!empty($row)){

                $this->common_model->deleteByids($where, 'tbl_wishlist');

                $count=count($this->common_model->selectByids($where,'tbl_wishlist'));

                $response=array('icon_lbl' => $this->lang->line('add_wishlist_lbl'),'success' => '1', 'msg' => $this->lang->line('remove_wishlist'), "is_favorite" => false);

            }
            else{
                //perform insertion
                $data_arr = array(
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                    'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
                );

                $data_usr = $this->security->xss_clean($data_arr);

                $last_id = $this->common_model->insert($data_usr, 'tbl_wishlist');

                $count=count($this->common_model->selectByids($where,'tbl_wishlist'));

                $response=array('icon_lbl' => $this->lang->line('remove_wishlist_lbl'),'success' => '1', 'msg' => $this->lang->line('add_wishlist'), "is_favorite" => true);
            }

            echo json_encode($response);
        }
    }

    // product quick preview
    public function quick_view(){

        $product_id=$this->input->post('product_id');

        $row=$this->common_model->selectByid($product_id,'tbl_product');

        $title=$desc=$old_price=$price=$size_view='';

        if(strlen($row->product_title) > 20){
            $title=substr(stripslashes($row->product_title), 0, 20).'...';  
        }else{
            $title=$row->product_title;
        }

        if(strlen($row->product_desc) > 300){
            $desc=substr(stripslashes($row->product_desc), 0, 300);  
        }else{
            $desc=$row->product_desc;
        }

        if($row->product_mrp > $row->selling_price){
          $price='<span class="new-price" style="margin-left:0px">'.CURRENCY_CODE.' '.number_format($row->selling_price, 2).'</span><span class="old-price">'.CURRENCY_CODE.' '.number_format($row->product_mrp).'</span>';
        }
        else{
          $price='<span class="new-price">'.CURRENCY_CODE.' '.number_format($row->selling_price, 2).'</span>';
        }

        $full_img='';

        if($row->status==0){
            $price.='<p style="color: red;font-weight: 500; margin-bottom: 5px">'.$this->lang->line('unavailable_lbl').'</p>';

            $full_img='<div class="unavailable_override"><p>'.$this->lang->line('unavailable_lbl').'</p></div>';
        }

        $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row->featured_image);

        $img_file=$this->_create_thumbnail('assets/images/products/',$thumb_img_nm,$row->featured_image,250,250);

        $img_file_sm=$this->_create_thumbnail('assets/images/products/',$thumb_img_nm,$row->featured_image,100,100);


        $full_img.='<div id="quick_'.$row->id.'" class="tab-pane fade in active">
                          <div class="modal-img img-full"> <img src="'.base_url().$img_file.'" alt=""> </div>
                        </div>';

        $thumb_img='<li class="active img_click"><a data-toggle="tab" href="#quick_'.$row->id.'"><img src="'.base_url().$img_file_sm.'" alt=""></a></li>';


        $img_file2=$this->_create_thumbnail('assets/images/products/',$row->id,$row->featured_image2,250,250);

        $img_file2_sm=$this->_create_thumbnail('assets/images/products/',$row->id,$row->featured_image2,100,100);

        $full_img.='<div id="featured_img" class="tab-pane fade">
                          <div class="modal-img img-full"> <img src="'.base_url().$img_file2.'" alt=""> </div>
                        </div>';

        $thumb_img.='<li class="img_click"><a data-toggle="tab" href="#featured_img"><img src="'.base_url().$img_file2_sm.'" alt=""></a></li>';


        // get gallery data

        $where = array('parent_id' => $product_id,'type' => 'product');

        $row_img=$this->common_model->selectByids($where,'tbl_product_images');

        $i=1;
        foreach ($row_img as $key => $value) {

            $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->image_file);

            $img_big=$this->_create_thumbnail('assets/images/products/gallery/',$thumb_img_nm,$value->image_file,250,250);

            $img_small=$this->_create_thumbnail('assets/images/products/gallery/',$thumb_img_nm,$value->image_file,100,100);

            $full_img.='<div id="quick_gallery_'.$key.'" class="tab-pane fade">
                          <div class="modal-img img-full"> <img src="'.base_url().$img_big.'" alt=""> </div>
                        </div>';

            $thumb_img.='<li class="img_click"><a data-toggle="tab" href="#quick_gallery_'.$key.'"><img src="'.base_url().$img_small.'" alt=""></a></li>';

        }

        $share_url=site_url('product/'.$row->product_slug);

        $response['status']=1;

        $response['html_code']='<div class="modal-details">
                                  <div class="row"> 
                                    <div class="col-md-5 col-sm-5"> 
                                      <div class="tab-content" style="overflow:hidden">
                                        '.$full_img.'
                                      </div>
                                      <div class="modal-product-tab">
                                        <ul class="modal-tab-menu-active">
                                          '.$thumb_img.'
                                        </ul>
                                      </div>
                                    </div>
                                    <div class="col-md-7 col-sm-7">
                                      <div class="product-info">
                                        <h2>'.$title.'</h2>
                                        <div class="product-price">'.$price.'</div>
                                        <div class="add-to-cart quantity">
                                        </div>
                                        <div class="cart-description">
                                            <p>'.$desc.'</p>
                                        </div>
                                        <div class="social-share">
                                          <h3 style="text-transform: initial;"><i class="fa fa-share" aria-hidden="true"></i>&nbsp;&nbsp;'.$this->lang->line('share_lbl').'</h3>
                                          <ul class="socil-icon2">
                                            <li><a href="https://www.facebook.com/sharer/sharer.php?u='.$share_url.'" target="_blank"><i class="fa fa-facebook"></i></a></li>
                                            <li><a href="https://twitter.com/intent/tweet?text='.$title.'&amp;url='.$share_url.'" target="_blank"><i class="fa fa-twitter"></i></a></li>
                                            <li><a href="http://pinterest.com/pin/create/button/?url='.$share_url.'&media='.base_url().$img_file.'&description='.$title.'" target="_blank"><i class="fa fa-pinterest"></i></a></li>
                                            <li><a href="whatsapp://send?text='.$share_url.'" target="_blank" data-action="share/whatsapp/share"><i class="fa fa-whatsapp"></i></a></li>
                                          </ul>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>';

        echo json_encode($response);

    }

    public function cart_action(){

        $response=array();

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            echo 'login_now';
        }
        else{

            $product_id=$this->input->post('product_id');    

            $where = array('id' => $product_id);

            $row=$this->common_model->selectByids($where,'tbl_product');

            if($row){

                $row=$row[0];

                $title=$old_price=$price=$size_view='';

                if(strlen($row->product_title) > 40){
                    $title=substr(stripslashes($row->product_title), 0, 40).'...';  
                }else{
                    $title=$row->product_title;
                }

                if($row->you_save_amt!='0'){
                  $price='<span class="new-price">'.CURRENCY_CODE.' '.$row->selling_price.'</span> 
                        <span class="old-price">'.CURRENCY_CODE.' '.$row->product_mrp.'</span>';
                }
                else{
                  $price='<span class="new-price">'.CURRENCY_CODE.' '.$row->product_mrp.'</span>';
                }

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row->featured_image);

                $img_file=$this->_create_thumbnail('assets/images/products/',$thumb_img_nm,$row->featured_image,250,250);


                if($row->product_size !=''){

                    $selected_size=0;
                    $size='';
                    $i=1;
                    foreach (explode(',', $row->product_size) as $key => $value) {
                        if($i==1){
                            $selected_size=$value;
                            $size.='<div class="radio_btn selected" data-value="'.$value.'">'.$value.'</div>';
                            $i=0;
                        }
                        else{
                            $size.='<div class="radio_btn" data-value="'.$value.'">'.$value.'</div>';
                        }
                    }

                    $size_view.='<br/>
                                  <div class="clearfix"></div>
                                  <p style="font-weight: 600;margin-bottom:0px">'.$this->lang->line('size_lbl').'</p>
                                  <div class="radio-group">
                                    '.$size.'
                                    <br/>
                                    <input type="hidden" id="radio-value" name="product_size" value="'.$selected_size.'" />
                                  </div><br/>';
                }

                $preview_url='';

                if(isset($_SERVER['HTTP_REFERER']))
                { 
                    $preview_url=str_replace(base_url().'site/register','',$_SERVER['HTTP_REFERER']);
                }

                $response['status']=1;
                $response['html_code']='<div class="modal-details">
                                        <div class="row"> 
                                          <div class="col-md-12 col-sm-12">
                                            <div class="product-info">
                                              <div class="col-md-3 col-sm-3 col-xs-12">
                                                <img src="'.base_url().$img_file.'" />
                                              </div>
                                              <div class="col-md-9 col-sm-9 col-xs-12">
                                                <h3>'.$title.'</h3>
                                                <div class="product-price">'.$price.'</div>
                                                <div class="add-to-cart quantity">
                                                    <form class="add-quantity" action="" method="post" id="cartForm">
                                                     <input type="hidden" name="preview_url" value="'.$preview_url.'">
                                                      <input type="hidden" name="product_id" value="'.$product_id.'" />
                                                      <div class="quantity modal-quantity">
                                                        <label>'.$this->lang->line('qty_lbl').'</label>
                                                        <input type="number" min="1" max="'.$row->max_unit_buy.'" value="1" onkeypress="return isNumberKey(event)" name="product_qty">
                                                      </div>
                                                      '.$size_view.'
                                                      <div class="add-to-link btn_add_cart" style="clear:both">
                                                        <button type="submit" class="form-button" data-text="'.$this->lang->line('add_cart_lbl').'">'.$this->lang->line('add_cart_btn').'</button>
                                                      </div>
                                                    </form>
                                                </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>';
            }
            echo json_encode($response);
        }
        
    }

    // cart activities
    public function add_to_cart(){

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            $message=array('success' => '0','msg' => 'Login required!!!');
        }
        else{
            
            if($this->input->post('product_id'))
            {

                $product_status=$this->common_model->selectByidParam($this->input->post('product_id'),'tbl_product','status');

                if($product_status==0){
                    // product is unavailable
                    $message=array('success' => '0','msg' => $this->lang->line('product_unavailable_lbl'));
                    echo json_encode($message);
                    return;
                }

                if (!$this->check_cart($this->input->post('product_id'), $user_id)) {

                    $data_arr = array(
                        'product_id' => $this->input->post('product_id'),
                        'user_id' => $user_id,
                        'product_qty' => $this->input->post('product_qty'),
                        'product_size' => $this->input->post('product_size'),
                        'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
                    );

                    $data_usr = $this->security->xss_clean($data_arr);

                    $cart_id = $this->common_model->insert($data_usr, 'tbl_cart');

                    $message=array('success' => '1','msg' => $this->lang->line('add_cart'),'lbl_title' => $this->lang->line('done_lbl'));

                }
                else{

                    $data_arr = array(
                        'product_qty' => $this->input->post('product_qty'),
                        'product_size' => $this->input->post('product_size'),
                        'last_update' => strtotime(date('d-m-Y h:i:s A',now()))
                    );

                    $data_usr = $this->security->xss_clean($data_arr);

                    $where = array('product_id ' => $this->input->post('product_id'), 'user_id' => $user_id);

                    $updated_id=$this->common_model->updateByids($data_usr, $where,'tbl_cart');

                    $message=array('success' => '1','msg' => $this->lang->line('update_cart'),'lbl_title' => $this->lang->line('done_lbl'));
                }

                $where = array('user_id' => $user_id , 'product_id' => $this->input->post('product_id'));

                $this->common_model->deleteByids($where, 'tbl_wishlist');
            }
            else{
                
            }
        }

        echo json_encode($message);

    }

    public function update_cart(){

        $data_arr = array(
            'product_qty' => $this->input->post('product_qty'),
            'last_update' => strtotime(date('d-m-Y h:i:s A',now()))
        );

        $data_usr = $this->security->xss_clean($data_arr);

        $where = array('id' => $this->input->post('cart_id'));

        $updated_id=$this->common_model->updateByids($data_usr, $where,'tbl_cart');

        $message = array('message' => $this->lang->line('update_cart'),'class' => 'success');
        
        $this->session->set_flashdata('cart_msg', $message);

        redirect('my-cart', 'refresh');
    }

    public function remove_cart($id)
    {

        $where = array('id ' => $id);

        $this->common_model->deleteByids($where, 'tbl_cart');

        $message=array('success' => '1','msg' => $this->lang->line('remove_cart'),'lbl_title' => $this->lang->line('done_lbl'));
                
        echo json_encode($message);
    }

    public function get_cart($limit=0)
    {

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';
        return $this->api_model->get_cart($user_id,'','DESC',$limit);
    }

    public function my_cart(){

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        $data['page_title'] = $this->lang->line('shoppingcart_lbl');
        $data['current_page'] = $this->lang->line('shoppingcart_lbl');
        $data['my_cart'] = $this->api_model->get_cart($user_id);
        $this->template->load('site/template2', 'site/pages/my_cart', $data); // :blush:
    }

    public function buy_now()
    {

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
            redirect('login-register', 'refresh');
        }

        $product_slug =  $this->input->get('product');

        $chkout_ref =  $this->input->get('chkout_ref');

        $size =  (!empty($this->input->get('size'))) ? $this->input->get('size') : '0';
        $qty =  $this->input->get('qty');

        $where=array('product_slug' => $product_slug);

        $product_id =  $this->common_model->getIdBySlug($where, 'tbl_product');

        $cart_exist = $this->common_model->cart_items($product_id, $user_id);

        if ($cart_exist == 0){

            $data_arr = array(
                'product_id' => $product_id,
                'user_id' => $user_id,
                'product_qty' => $qty,
                'product_size' => $size,
                'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
            );

            $data_usr = $this->security->xss_clean($data_arr);

            $this->common_model->insert($data_usr, 'tbl_cart');
        }

        if(empty($this->input->get('order_unique_id')))
        {
            $where = array('user_id' => $user_id, 'product_id' => $product_id, 'cart_unique_id' => $chkout_ref);

            $my_tmp_cart=$this->common_model->selectByids($where, 'tbl_cart_tmp');

            if(empty($my_tmp_cart))
            {
                $data_arr = array(
                    'product_id' => $product_id,
                    'user_id' => $user_id,
                    'product_qty' => $qty,
                    'product_size' => $size,
                    'cart_unique_id' => $chkout_ref,
                    'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
                );

                $data_usr = $this->security->xss_clean($data_arr);

                $cart_id=$this->common_model->insert($data_usr, 'tbl_cart_tmp');
            }
            else
            {
                $data_arr = array(
                    'product_qty' => $qty,
                    'product_size' => $size,
                );

                $data_usr = $this->security->xss_clean($data_arr);

                $this->common_model->updateByids($data_usr, $where,'tbl_cart_tmp');

                $cart_id=$my_tmp_cart[0]->id;
            }

            $data['page_title'] = 'Checkout';
            $data['current_page'] = 'Checkout';
            $data['my_cart'] = $this->api_model->get_cart($user_id, $cart_id);
            $data['addresses'] = $this->common_model->get_addresses($user_id);
            $data['buy_now'] = 'true';

            $where=array('user_id' => $user_id, 'cart_type' => 'temp_cart', 'cart_id' => $cart_id);

            $rowCoupon=$this->common_model->selectByids($where,'tbl_applied_coupon');

            $data['coupon_id'] = (count($rowCoupon)) ? $rowCoupon[0]->coupon_id : 0;

            $this->template->load('site/template2', 'site/pages/checkout', $data);
        }
        else{
            $message = array('message' => $this->lang->line('ord_placed_empty_lbl'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
            redirect('/', 'refresh');
        }
    }

    public function checkout(){

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
            redirect('login-register', 'refresh');
        }

        $data['page_title'] = 'Checkout';
        $data['current_page'] = 'Checkout';
        $data['my_cart'] = $this->api_model->get_cart($user_id,'','','',array('cart_status' => 1));
        $data['addresses'] = $this->common_model->get_addresses($user_id);
        $data['buy_now'] = 'false';

        $where=array('user_id' => $user_id, 'cart_type' => 'main_cart');

        $rowCoupon=$this->common_model->selectByids($where,'tbl_applied_coupon');

        $data['coupon_id'] = (count($rowCoupon)) ? $rowCoupon[0]->coupon_id : 0;

        if(!empty($data['my_cart']) && ($this->session->flashdata('order_unique_id')=='')){
            $this->template->load('site/template2', 'site/pages/checkout', $data); // :blush:
        }
        else{
            $message = array('message' => $this->lang->line('ord_placed_empty_lbl'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
            redirect('/', 'refresh');
        }
    }

    public function get_cat_sub_product($category_id, $sub_category_id=''){
        return $this->api_model->products_filter('productList_cat_sub', $sub_category_id, '10', '0','','','','newest');
    }

    public function product_rating($product_id)
    {
        $res=array();

        $where = array('product_id ' => $product_id);

        if($row_rate = $this->common_model->selectByids($where, 'tbl_rating')){
            foreach ($row_rate as $key => $value) {
                $rate_db[] = $value;
                $sum_rates[] = $value->rating;
            }

            $rate_times = count($rate_db);
            $sum_rates = array_sum($sum_rates);
            $rate_value = $sum_rates/$rate_times;

            $res['rate_times']=strval($rate_times);
            $res['total_rate']=strval($sum_rates);
            $res['rate_avg']=strval(round($rate_value));
        }
        else{
            $res['rate_times']="0";
            $res['total_rate']="0";
            $res['rate_avg']="0";   
        }
        return json_encode($res);
    }
    
    function is_favorite($user_id, $product_id){
        $where = array('user_id ' => $user_id , 'product_id' => $product_id);

        $count=count($this->common_model->selectByids($where,'tbl_wishlist'));

        if($count > 0){
            return true;
        }
        else{
            return false;
        }
    }

    function check_email(){

        $email=$this->input->post('email');  

        $row = $this->common_model->check_email($email);

        //print_r($row);

        if(empty($row)){
           $res=array('success' => '1','msg' => ''); 
        }
        else{
            $res=array('success' => '0','msg' => $this->lang->line('email_exist_error'));
        }

        echo json_encode($res);
        exit;
    }

    function sent_code(){

        $name=$this->input->post('name');
        $email=$this->input->post('email');

        if($this->checkSpam($email)){

            $random_code=rand(1000,5000);

            $where = array('user_email ' => $email);

            $count=count($this->common_model->selectByids($where,'tbl_verify_code'));

            if($count > 0){

                //perform updation
                $data = array(
                    'user_email' => $email,
                    'verify_code' => $random_code,
                    'created_at' => strtotime(date('d-m-Y h:i:s A',now())),
                    'is_verify' => '0',
                );

                $data_usr = $this->security->xss_clean($data);

                $updated_id=$this->common_model->updateByids($data_usr, $where,'tbl_verify_code');
                
            }
            else{
                
                //perform insertion
                $data = array(
                    'user_email' => $email,
                    'verify_code' => $random_code,
                    'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
                );

                $data_usr = $this->security->xss_clean($data);

                $last_id = $this->common_model->insert($data_usr, 'tbl_verify_code');

            }

            $data_arr = array(
                'email' => $email,
                'otp' => $random_code
            );

            $subject = $this->app_name.' - '.$this->lang->line('email_verify_heading_lbl');

            $body = $this->load->view('admin/emails/email_verify.php',$data_arr,TRUE);

            if(send_email($email, $name, $subject, $body)){

                if($this->input->post('is_resend')=='false'){
                    $res=array('success' => '1','msg' => $this->lang->line('verification_code_sent'));     
                }
                else{
                    $res=array('success' => '1','msg' => $this->lang->line('verification_code_resent')); 
                }
            }
            else{
                $res=array('success' => '0','msg' => $this->lang->line('email_not_sent'));
            }
        }
        else{
            $res=array('success' => '0','msg' => $this->lang->line('invalid_email_format'));
        }

        echo json_encode($res);
        exit;
    }

    function checkSpam($email)
    {
        $this->load->library('genuinemail');
        $check = $this->genuinemail->check($email);
        if($check===TRUE) return true;
        return false;
    }

    function verify_code(){

        $email=$this->input->post('email');

        $code=$this->input->post('code');

        $where = array('user_email' => $email, 'verify_code' => $code, 'is_verify' => '0');

        $count=count($this->common_model->selectByids($where,'tbl_verify_code'));

        if($count > 0){

            $data = array(
                'is_verify' => '1',
            );

            $data_usr = $this->security->xss_clean($data);

            $where = array('user_email' => $email);

            $updated_id=$this->common_model->updateByids($data_usr, $where,'tbl_verify_code');

            echo 'true';
        }
        else{
            echo 'false';
        }
    }

    // login and register form view
    public function login_register_form(){

        if($this->session->userdata('user_id')){
            redirect('/', 'refresh');
            $message = array('message' => $this->lang->line('login_success'),'class' => 'success');
            $this->session->set_flashdata('response_msg', $message);
        }

        $data = array();
        $data['page_title'] = $this->lang->line('login_register_lbl');
        $data['current_page'] = $this->lang->line('login_register_lbl');

        $data['google_login_btn'] = $this->google_login_status;

        $data['facebook_login_btn'] = $this->facebook_status;

        $data['email_otp_status'] = $this->email_otp_status;

        $this->template->load('site/template2', 'site/pages/login_register', $data); // :blush:
    }

    // login form
    public function login(){

        $this->form_validation->set_rules('email', $this->lang->line('email_require_lbl'), 'required');  
        $this->form_validation->set_rules('password', $this->lang->line('password_require_lbl'), 'required'); 

        if($this->form_validation->run())  
        {
            if($_POST){

                $row_usr=$this->common_model->selectByids(array('user_type' => 'Normal','user_email' => $this->input->post('email')), 'tbl_users');

                //-- if valid
                if($row_usr){

                    $row_usr=$row_usr[0];

                    if($row_usr->user_password==md5($this->input->post('password'))){

                        if($row_usr->status=='1')
                        {
                            $data = array(
                                'user_id' => $row_usr->id,
                                'user_type' =>$row_usr->user_type,
                                'user_name' => $row_usr->user_name,
                                'user_email' =>$row_usr->user_email,
                                'user_phone' =>$row_usr->user_phone,
                                'is_user_login' => TRUE
                            );
                            $this->session->set_userdata($data);

                            $message = array('message' => $this->lang->line('login_success'),'status' => '1','class' => 'success','preview_url' => $this->input->post('preview_url'));
                            $this->session->set_flashdata('response_msg', $message);
                            
                            echo base64_encode(json_encode($message));
                            exit;
                        }
                        else{
                            $message = array('message' => $this->lang->line('acc_deactived'),'status' => '0');
                            echo base64_encode(json_encode($message));
                            exit;   
                        }
                    }
                    else{

                        $message = array('message' => $this->lang->line('password_invaild'),'status' => '0');
                        echo base64_encode(json_encode($message));
                        exit;
                    }
                }else{
                    $message = array('message' => $this->lang->line('email_not_found'),'status' => '0');
                    echo base64_encode(json_encode($message));
                    exit;
                }
            }
        }
        else  
        {  
            $message = array('message' => $this->lang->line('all_required_field_err'),'status' => '0');
            echo base64_encode(json_encode($message));
        }
    }

    // registration form
    public function register(){

        $this->form_validation->set_rules('user_name', $this->lang->line('name_place_lbl'), 'trim|required');
        $this->form_validation->set_rules('user_email', $this->lang->line('email_place_lbl'), 'trim|required');
        $this->form_validation->set_rules('user_phone', $this->lang->line('phone_no_place_lbl'), 'trim|required');
        $this->form_validation->set_rules('user_password', $this->lang->line('password_place_lbl'), 'trim|required');

        if($this->form_validation->run())  
        {
            if($_POST){

                $row_usr=$this->common_model->selectByids(array('user_type' => 'Normal','user_email' => $this->input->post('user_email')), 'tbl_users');

                //-- if valid
                if(empty($row_usr)){
                    $data = array(
                        'user_name'  => $this->input->post('user_name'),
                        'user_email'  => $this->input->post('user_email'),
                        'user_phone'  => $this->input->post('user_phone'),
                        'user_password'  => md5($this->input->post('user_password')),
                        'created_at'  =>  strtotime(date('d-m-Y h:i:s A'))
                    );

                    $data = $this->security->xss_clean($data);

                    if($this->common_model->insert($data, 'tbl_users')){

                        $data_arr = array(
                            'register_type' => 'Normal',
                            'user_name' => $this->input->post('user_name')
                        );

                        $subject = $this->app_name.' - '.$this->lang->line('register_mail_lbl');

                        $body = $this->load->view('emails/welcome_mail.php',$data_arr,TRUE);

                        send_email($this->input->post('user_email'), $this->input->post('user_name'), $subject, $body);

                        $message = array('message' => $this->lang->line('register_success'),'class' => 'success');
                        $this->session->set_flashdata('response_msg', $message);

                    }
                    else{
                        $message = array('message' => $this->lang->line('register_failed'),'class' => 'error');
                        $this->session->set_flashdata('response_msg', $message);
                    }
                }
                else{
                    $message = array('message' => $this->lang->line('email_exist_error'),'class' => 'error');
                    $this->session->set_flashdata('response_msg', $message);
                }

                redirect('login-register', 'refresh');
            }
        }
        else  
        {  
            $message = array('message' => $this->lang->line('all_required_field_err'),'class' => 'error');
                $this->session->set_flashdata('response_msg', $message);
            redirect('login-register', 'refresh');
        }
    } 

    // address form
    public function addAddress()
    {

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            redirect('login-register', 'refresh');
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'success');
            $this->session->set_flashdata('response_msg', $message);
        }

        $this->form_validation->set_rules('billing_name', $this->lang->line('name_place_lbl'), 'trim|required');
        $this->form_validation->set_rules('billing_mobile_no', $this->lang->line('phone_no_place_lbl'), 'trim|required');
        $this->form_validation->set_rules('building_name', $this->lang->line('address_place_lbl'), 'trim|required');
        $this->form_validation->set_rules('road_area_colony', $this->lang->line('road_area_colony_place_lbl'), 'trim|required');
        $this->form_validation->set_rules('pincode', $this->lang->line('zipcode_place_lbl'), 'trim|required');
        $this->form_validation->set_rules('city', $this->lang->line('city_place_lbl'), 'trim|required');
        $this->form_validation->set_rules('state', $this->lang->line('state_place_lbl'), 'trim|required');
        $this->form_validation->set_rules('country', $this->lang->line('country_place_lbl'), 'trim|required');

        if($this->form_validation->run())  
        {
            if($_POST)
            {

                if($row = $this->common_model->get_addresses($user_id)){
                    $data_arr = array(
                        'is_default' => 'false'
                    );

                    $data_usr = $this->security->xss_clean($data_arr);

                    $where = array('user_id ' => $user_id);

                    $updated_id = $this->common_model->updateByids($data_usr, $where,'tbl_addresses');
                }

                $data_arr = array(
                    'user_id' => $user_id,
                    'pincode' => $this->input->post('pincode'),
                    'building_name' => $this->input->post('building_name'),
                    'road_area_colony' => $this->input->post('road_area_colony'),
                    'city' => $this->input->post('city'),
                    'district' => $this->input->post('district'),
                    'state' => $this->input->post('state'),
                    'country' => $this->input->post('country'),
                    'landmark' => $this->input->post('landmark'),
                    'name' => $this->input->post('billing_name'),
                    'email' => $this->input->post('billing_email'),
                    'mobile_no' => $this->input->post('billing_mobile_no'),
                    'alter_mobile_no' => $this->input->post('alter_mobile_no'),
                    'address_type' => $this->input->post('address_type'),
                    'is_default' => 'true',
                    'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
                );

                $data_usr = $this->security->xss_clean($data_arr);

                $address_id = $this->common_model->insert($data_usr, 'tbl_addresses');

                $message = array('message' => $this->lang->line('add_success'),'class' => 'success');
                $this->session->set_flashdata('response_msg', $message);

                if(isset($_SERVER['HTTP_REFERER']))
                    redirect($_SERVER['HTTP_REFERER']);
                else
                    redirect('/', 'refresh');
            }
        }
        else  
        {  
            $message = array('message' => $this->lang->line('all_required_field_err'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);

            if(isset($_SERVER['HTTP_REFERER']))
                redirect($_SERVER['HTTP_REFERER']);
            else
                redirect('/', 'refresh');
        }
    }

    public function edit_address()
    {
        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            redirect('login-register', 'refresh');
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'success');
            $this->session->set_flashdata('response_msg', $message);
        }

        $this->form_validation->set_rules('billing_name', $this->lang->line('name_place_lbl'), 'trim|required');
        $this->form_validation->set_rules('billing_mobile_no', $this->lang->line('phone_no_place_lbl'), 'trim|required');
        $this->form_validation->set_rules('building_name', $this->lang->line('address_place_lbl'), 'trim|required');
        $this->form_validation->set_rules('road_area_colony', $this->lang->line('road_area_colony_place_lbl'), 'trim|required');
        $this->form_validation->set_rules('pincode', $this->lang->line('zipcode_place_lbl'), 'trim|required');
        $this->form_validation->set_rules('city', $this->lang->line('city_place_lbl'), 'trim|required');
        $this->form_validation->set_rules('state', $this->lang->line('state_place_lbl'), 'trim|required');
        $this->form_validation->set_rules('country', $this->lang->line('country_place_lbl'), 'trim|required');

        if($this->form_validation->run())  
        {
            if($_POST)
            {
                if($row = $this->common_model->get_addresses($user_id)){
                    $data_arr = array(
                        'is_default' => 'false'
                    );

                    $data_usr = $this->security->xss_clean($data_arr);

                    $where = array('user_id ' => $user_id);

                    $updated_id = $this->common_model->updateByids($data_usr, $where,'tbl_addresses');
                }

                $data_arr = array(
                    'pincode' => $this->input->post('pincode'),
                    'building_name' => $this->input->post('building_name'),
                    'road_area_colony' => $this->input->post('road_area_colony'),
                    'city' => $this->input->post('city'),
                    'district' => $this->input->post('district'),
                    'state' => $this->input->post('state'),
                    'country' => $this->input->post('country'),
                    'landmark' => $this->input->post('landmark'),
                    'name' => $this->input->post('billing_name'),
                    'email' => $this->input->post('billing_email'),
                    'mobile_no' => $this->input->post('billing_mobile_no'),
                    'alter_mobile_no' => $this->input->post('alter_mobile_no'),
                    'address_type' => $this->input->post('address_type'),
                    'is_default' => 'true'
                );
                
                $data_usr = $this->security->xss_clean($data_arr);

                $address_id = $this->common_model->update($data_usr, $this->input->post('address_id'),'tbl_addresses');

                $response = array('status' => 1,'msg' => $this->lang->line('update_success'),'title' => $this->lang->line('updated_lbl'),'class' => 'success');
                echo base64_encode(json_encode($response));
                return;
            }
        }
        else  
        {  
            $response = array('status' => 0,'msg' => $this->lang->line('all_required_field_err'));
            echo base64_encode(json_encode($response));
            return;

        }
    } 

    public function delete_address($address_id)
    {
        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            redirect('login-register', 'refresh');
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'success');
            $this->session->set_flashdata('response_msg', $message);
        }

        $row=$this->common_model->selectByids(array('user_id' => $user_id, 'id' => $address_id),'tbl_addresses');

        if(!empty($row))
        {
            $row=$row[0];

            if($row->is_default=='true')
            {
                $data_arr=$this->common_model->selectByids(array('user_id'=>$user_id),'tbl_addresses');

                if(count($data_arr) > 0){

                    $this->common_model->delete($address_id,'tbl_addresses');

                    $data_arr1 = array(
                        'is_default' => 'true'
                    );

                    $data_usr1 = $this->security->xss_clean($data_arr1);

                    $where=array('user_id' => $user_id);

                    $max_id=$this->common_model->getMaxId('tbl_addresses',$where);

                    $updated_id = $this->common_model->update($data_usr1, $max_id, 'tbl_addresses');
                }
            }
            else{
                $this->common_model->delete($address_id,'tbl_addresses');
            }

            $message = array('message' => $this->lang->line('delete_success'),'class' => 'success');
            $this->session->set_flashdata('response_msg', $message);
        }
        else
        {
            $message = array('message' => $this->lang->line('no_address_found'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
        }

        if(isset($_SERVER['HTTP_REFERER']))
            redirect($_SERVER['HTTP_REFERER']);
        else
            redirect('/', 'refresh');
        
    }
    // end address

    function logout(){
        
        $array_items = array('user_id', 'user_type', 'user_name', 'user_email', 'user_phone', 'is_user_login', 'token', 'token', 'success_msg', 'response_msg','cart_msg','order_unique_id','single_pre_url','razorpay_order_id','order_id','data_email');

        $this->session->unset_userdata($array_items);

        if(isset($_SERVER['HTTP_REFERER']))
            redirect($_SERVER['HTTP_REFERER']);
        else
            redirect('/', 'refresh');
    }

    // check cart
    public function check_cart($product_id, $user_id, $size=''){

        if($size==''){
            $where = array('product_id' => $product_id, 'user_id' => $user_id);
        }
        else{
            $where = array('product_id' => $product_id, 'user_id' => $user_id, 'product_size' => $user_id);
        }
        
        if($this->common_model->selectByids($where, 'tbl_cart')){
            return true;
        }
        else{
            return false;
        }

    }

    public function get_coupons()
    {
        return $this->Coupon_model->coupon_list();
    }

    public function apply_coupon(){

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            redirect('login-register', 'refresh');
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'success');
            $this->session->set_flashdata('response_msg', $message);
        }

        $coupon_id=$this->input->post("coupon_id");
        $cart_ids=$this->input->post("cart_ids");
        $cart_type=$this->input->post("cart_type");

        if($cart_type=='main_cart')
        {
            $where=array('user_id' => $user_id, 'cart_type' => $cart_type);
            $rowAppliedCoupon=$this->common_model->selectByids($where,'tbl_applied_coupon');
            $my_cart=$this->api_model->get_cart($user_id);
        }
        else
        {
            $where=array('user_id' => $user_id, 'cart_type' => $cart_type, 'cart_id' => $cart_ids);
            $rowAppliedCoupon=$this->common_model->selectByids($where,'tbl_applied_coupon');
            $my_cart=$this->api_model->get_cart($user_id, $cart_ids);
        }

        $total_amount=$you_save=$delivery_charge=0;

        if(!empty($my_cart))
        {

            $save_msg='';

            if(count($rowAppliedCoupon)==0)
            {

                // no any coupon applied
                foreach ($my_cart as $row_cart) {
                    $total_amount += ($row_cart->selling_price * $row_cart->product_qty);
                    $you_save += ($row_cart->you_save_amt * $row_cart->product_qty);
                    $delivery_charge += $row_cart->delivery_charge;
                }

                $where=array('id' => $coupon_id);

                if($row=$this->common_model->selectByids($where,'tbl_coupon'))
                {
                    $row=$row[0];

                    $where = array('user_id ' => $user_id , 'coupon_id' => $row->id);

                    $count_use=count($this->common_model->selectByids($where,'tbl_order_details'));

                    if($row->coupon_limit_use >= $count_use)
                    {
                        if($row->coupon_per!='0')
                        {
                            // for percentage coupons
                            $payable_amt=$discount=0;

                            // count discount price after coupon apply;
                            $discount=number_format(($row->coupon_per/100) * $total_amount, 2);

                            if($row->cart_status=='true'){

                                if($total_amount >= $row->coupon_cart_min)
                                {
                                    
                                    if($row->max_amt_status=='true')
                                    {
                                        if($discount > $row->coupon_max_amt)
                                        {
                                            $discount=$row->coupon_max_amt;
                                            $payable_amt=number_format(($total_amount - $discount)+$delivery_charge, 2);
                                        }
                                        else{
                                            $payable_amt=number_format(($total_amount - $discount)+$delivery_charge, 2);
                                        }
                                    }
                                    else{
                                        $payable_amt=number_format(($total_amount - $discount)+$delivery_charge, 2);
                                    }

                                    if($discount!=0){
                                        $save_msg=str_replace('###', CURRENCY_CODE.' '.number_format(($discount+$you_save), 2), $this->lang->line('coupon_save_msg_lbl'));
                                    }
                                    else{
                                        $save_msg='';
                                    }

                                    $response=array('success' => '1','msg' => $this->lang->line('applied_coupon'),'coupon_id' => $row->id,'you_save_msg' =>$save_msg, "price" => number_format($total_amount, 2), "payable_amt" => strval($payable_amt));
                                }
                                else{
                                    $response=array('success' => '0','msg' => $this->lang->line('insufficient_cart_amt'));
                                }
                            }
                            else{

                                if($row->max_amt_status=='true')
                                {

                                    if($discount > $row->coupon_max_amt)
                                    {
                                        $discount=$row->coupon_max_amt;
                                        $payable_amt=number_format(($total_amount-$discount) + $delivery_charge, 2);
                                    }
                                    else{
                                        $payable_amt=number_format(($total_amount-$discount) + $delivery_charge, 2);
                                    }
                                }
                                else{
                                    $payable_amt=number_format(($total_amount - $discount)+$delivery_charge, 2);
                                }

                                if($discount!=0){   
                                    $save_msg=str_replace('###', CURRENCY_CODE.' '.number_format(($discount+$you_save), 2), $this->lang->line('coupon_save_msg_lbl'));
                                }
                                else{
                                    $save_msg='';
                                }

                                $response=array('success' => '1','msg' => $this->lang->line('applied_coupon'),'coupon_id' => $row->id,'you_save_msg' =>$save_msg, "price" => number_format($total_amount, 2), "payable_amt" => strval($payable_amt));
                            }
                        }
                        else{

                            // check minimum cart value status
                            if($row->cart_status=='true'){

                                if($total_amount >= $row->coupon_cart_min){

                                    // count discount price after coupon apply;
                                    $discount=number_format($row->coupon_amt, 2);

                                    $payable_amt=number_format(($total_amount - $discount)+$delivery_charge, 2);

                                    if($discount > 0){

                                        $save_msg=str_replace('###', CURRENCY_CODE.' '.number_format(($discount+$you_save), 2), $this->lang->line('coupon_save_msg_lbl'));
                                    }
                                    else{
                                        $save_msg='';
                                    }

                                    $response=array('success' => '1','msg' => $this->lang->line('applied_coupon'),'coupon_id' => $row->id,'you_save_msg' =>$save_msg, "price" => number_format($total_amount, 2), "payable_amt" => strval($payable_amt));
                                }
                                else{
                                    $response=array('success' => '0','msg' => $this->lang->line('insufficient_cart_amt'));
                                }
                            }
                            else{

                                $payable_amt=$discount=0;

                                if($total_amount >= $row->coupon_amt)
                                {

                                    $discount=number_format($row->coupon_amt, 2);

                                    $payable_amt=number_format(($total_amount-$discount) + $delivery_charge, 2);
                                }
                                else{
                                    $discount=0;
                                    $payable_amt=number_format(($total_amount-$discount) + $delivery_charge, 2);
                                }

                                if($discount > 0){
                                    $save_msg=str_replace('###', CURRENCY_CODE.' '.number_format(($discount+$you_save), 2), $this->lang->line('coupon_save_msg_lbl'));
                                }
                                else{
                                    $save_msg='';
                                }

                                $response=array('success' => '1','msg' => $this->lang->line('applied_coupon'),'coupon_id' => $row->id,'you_save_msg' =>$save_msg, "price" => number_format($total_amount, 2), "payable_amt" => strval($payable_amt));
                            }
                        }
                    }
                    else{
                        $response=array('success' => '0','msg' => $this->lang->line('use_limit_over'));
                    }
                }
                else{
                    $response=array('success' => '0','msg' => $this->lang->line('no_coupon'));
                }

                if($response['success']){
                    // insert in applied coupon
                    $data_coupon = array(
                        'user_id' => $user_id,
                        'cart_type' => $cart_type,
                        'cart_id' => $cart_ids,
                        'coupon_id' => $coupon_id,
                        'applied_on' => strtotime(date('d-m-Y h:i:s A',now()))
                    );

                    $data_coupon = $this->security->xss_clean($data_coupon);

                    $this->common_model->insert($data_coupon, 'tbl_applied_coupon');
                }
            }
            else{

                if($rowAppliedCoupon[0]->coupon_id == $coupon_id){
                    
                    foreach ($my_cart as $row_cart) {
                        $total_amount += ($row_cart->selling_price * $row_cart->product_qty);
                        $you_save += ($row_cart->you_save_amt * $row_cart->product_qty);
                        $delivery_charge += $row_cart->delivery_charge;
                    }

                    $where=array('id' => $coupon_id);

                    if($row=$this->common_model->selectByids($where,'tbl_coupon'))
                    {
                        $row=$row[0];

                        $where = array('user_id ' => $user_id , 'coupon_id' => $row->id);

                        $count_use=count($this->common_model->selectByids($where,'tbl_order_details'));

                        if($row->coupon_limit_use >= $count_use)
                        {
                            if($row->coupon_per!='0')
                            {
                                // for percentage coupons

                                $payable_amt=$discount=0;
                                // count discount price after coupon apply;
                                $discount=number_format(($row->coupon_per/100) * $total_amount, 2);

                                if($row->cart_status=='true'){

                                    if($total_amount >= $row->coupon_cart_min)
                                    {
                                        if($row->max_amt_status=='true')
                                        {
                                            if($discount > $row->coupon_max_amt)
                                            {
                                                $discount=$row->coupon_max_amt;
                                                $payable_amt=number_format(($total_amount - $discount)+$delivery_charge, 2);
                                            }
                                            else{
                                                $payable_amt=number_format(($total_amount - $discount)+$delivery_charge, 2);
                                            }
                                        }
                                        else{
                                            $payable_amt=number_format(($total_amount - $discount)+$delivery_charge, 2);
                                        }

                                        if($discount!=0){
                                            $save_msg=str_replace('###', CURRENCY_CODE.' '.number_format(($discount+$you_save), 2), $this->lang->line('coupon_save_msg_lbl'));
                                        }
                                        else{
                                            $save_msg='';
                                        }

                                        $response=array('success' => '1','msg' => $this->lang->line('applied_coupon'),'coupon_id' => $row->id,'you_save_msg' =>$save_msg, "price" => number_format($total_amount, 2), "payable_amt" => strval($payable_amt));
                                    }
                                    else{
                                        $response=array('success' => '0','msg' => $this->lang->line('insufficient_cart_amt'));
                                    }
                                }
                                else{

                                    if($row->max_amt_status=='true')
                                    {
                                        if($discount > $row->coupon_max_amt){
                                            $discount=$row->coupon_max_amt;
                                            $payable_amt=number_format(($total_amount - $discount)+$delivery_charge, 2);
                                        }
                                        else{
                                            $payable_amt=number_format(($total_amount - $discount)+$delivery_charge, 2);
                                        }
                                    }
                                    else{
                                        $payable_amt=number_format(($total_amount - $discount)+$delivery_charge, 2);
                                    }

                                    if($discount!=0){   
                                        $save_msg=str_replace('###', CURRENCY_CODE.' '.number_format(($discount+$you_save), 2), $this->lang->line('coupon_save_msg_lbl'));
                                    }
                                    else{
                                        $save_msg='';
                                    }

                                    $response=array('success' => '1','msg' => $this->lang->line('applied_coupon'),'coupon_id' => $row->id,'you_save_msg' =>$save_msg, "price" => number_format($total_amount,2), "payable_amt" => strval($payable_amt));
                                }
                            }
                            else{

                                // check minimum cart value status
                                if($row->cart_status=='true'){

                                    if($total_amount >= $row->coupon_cart_min)
                                    {
                                        $discount=number_format($row->coupon_amt, 2);

                                        $payable_amt=number_format(($total_amount - $discount)+$delivery_charge, 2);

                                        if($discount > 0){

                                            $save_msg=str_replace('###', CURRENCY_CODE.' '.number_format(($discount+$you_save), 2), $this->lang->line('coupon_save_msg_lbl'));
                                        }
                                        else{
                                            $save_msg='';
                                        }

                                        $response=array('success' => '1','msg' => $this->lang->line('applied_coupon'),'coupon_id' => $row->id,'you_save_msg' =>$save_msg, "price" => number_format($total_amount, 2), "payable_amt" => strval($payable_amt));
                                    }
                                    else{
                                        $response=array('success' => '0','msg' => $this->lang->line('insufficient_cart_amt'));
                                    }
                                }
                                else{

                                    $payable_amt=$discount=0;

                                    if($total_amount >= $row->coupon_amt){

                                        $discount=number_format($row->coupon_amt, 2);

                                        $payable_amt=number_format(($total_amount - $discount)+$delivery_charge, 2);
                                    }
                                    else
                                    {
                                        $discount=0;

                                        $payable_amt=number_format(($total_amount - $discount)+$delivery_charge, 2);
                                    }

                                    if($discount > 0){
                                        $save_msg=str_replace('###', CURRENCY_CODE.' '.strval($discount+$you_save), $this->lang->line('coupon_save_msg_lbl'));

                                    }
                                    else{
                                        $save_msg='';
                                    }

                                    $response=array('success' => '1','msg' => $this->lang->line('applied_coupon'),'coupon_id' => $row->id,'you_save_msg' =>$save_msg, "price" => number_format($total_amount, 2), "payable_amt" => strval($payable_amt));
                                }
                            }
                        }
                        else{
                            $response=array('success' => '0','msg' => $this->lang->line('use_limit_over'));
                        }
                    }
                    else{
                        $response=array('success' => '0','msg' => $this->lang->line('no_coupon'));
                    }

                    if($response['success']==0){
                        $where=array('user_id' => $user_id, 'cart_type' => $cart_type, 'coupon_id' => $coupon_id);
                        $this->common_model->deleteByids($where, 'tbl_applied_coupon');
                    }
                }
                else{
                    // any coupon is applied
                    $response=array('success' => '0','msg' => $this->lang->line('already_applied_coupon'));
                }
            }
        }
        else{
            // cart is empty
            $response=array('success' => '-1','msg' => $this->lang->line('empty_cart_lbl'));
        }

        echo json_encode($response);
    }

    public function remove_coupon($cart_type='main_cart'){

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            redirect('login-register', 'refresh');
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'success');
            $this->session->set_flashdata('response_msg', $message);
        }

        $coupon_id=$this->input->post("coupon_id");
        $cart_id=$this->input->post("cart_ids");

        if($cart_type=='main_cart')
        {
            $my_cart=$this->api_model->get_cart($user_id);
            $where=array('user_id' => $user_id, 'cart_type' => $cart_type);

        }
        else{
            $my_cart=$this->api_model->get_cart($user_id, $cart_id);

            $where=array('user_id' => $user_id, 'cart_type' => $cart_type, 'cart_id' => $cart_id, 'coupon_id' => $coupon_id); 
        }

        $this->common_model->deleteByids($where, 'tbl_applied_coupon');

        if(!empty($my_cart)){

            $total_cart_amt=$delivery_charge=$you_save=0;

            foreach ($my_cart as $key => $value)
            {

                $total_cart_amt+=$value->selling_price*$value->product_qty;
                $delivery_charge+=$value->delivery_charge;
                $you_save+=$value->you_save_amt * $value->product_qty;
            }

            if($you_save!=0){
                $save_msg=str_replace('###', CURRENCY_CODE.' '.number_format($you_save, 2), $this->lang->line('coupon_save_msg_lbl'));    
            }
            else{
                $save_msg='';
            }
            

            $response=array('success' => '1','msg' => $this->lang->line('remove_coupon'), 'you_save_msg' =>$save_msg, "payable_amt" => number_format(($total_cart_amt+$delivery_charge), 2));
        }
        else{

            // cart is empty
            $response=array('success' => '-1','msg' => $this->lang->line('empty_cart_lbl'));
        }
        echo json_encode($response);
    }

    private function user_total_save($user_id)
    {
        $res=array();
        
        $row=$this->api_model->get_cart($user_id);

        $total_amt=$delivery_charge=$you_save=0;

        foreach ($row as $key => $value) {

            $data_ofr=$this->calculate_offer($this->get_single_info(array('id' => $value->product_id),'offer_id','tbl_product'),$value->product_mrp*$value->product_qty);

            $arr_ofr=json_decode($data_ofr);

            $total_amt+=$arr_ofr->selling_price;

            $delivery_charge+=$value->delivery_charge;

            $you_save+=$arr_ofr->you_save;
        }

        $res['total_item']=strval(count($row));
        $res['price']=strval($total_amt);
        $res['delivery_charge']=($delivery_charge!=0)?$delivery_charge:'Free';
        $res['payable_amt']=strval($total_amt+$delivery_charge);

        $res['you_save']=strval($you_save);

        return json_encode($res);
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

    public function _create_thumbnail($path, $thumb_name, $fileName, $width, $height) 
    {
        $source_path = $path.$fileName;

        if($fileName!=''){
            if(file_exists($source_path)){
                
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

                // Do your manipulation
                $this->image_lib->clear();
            }
        }
        else{
            return '';
        }
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
        return json_encode($res);
    }

    public function is_purchased($user_id, $product_id){

        $where = array('user_id' => $user_id, 'product_id' => $product_id, 'pro_order_status' => '4');

        if(count($this->common_model->selectByids($where,'tbl_order_items'))){
            return true;
        }
        else{
            return false;
        }
    }

    public function get_pincode_data(){

        // From URL to get webpage contents. 
        $url = "http://www.postalpincode.in/api/pincode/".$this->input->post('pincode'); 

        // Initialize a CURL session. 
        $ch = curl_init();  

        // Return Page contents. 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        //grab URL and pass it to the variable. 
        curl_setopt($ch, CURLOPT_URL, $url); 

        $response=array();

        if($result = curl_exec($ch)){
            $result1=json_decode($result);

            if($result1->PostOffice!=NULL){

                $response['status']='1';

                foreach ($result1->PostOffice as $key => $value) {

                    $response['city']=$value->Circle;
                    $response['district']=$value->District;
                    $response['state']=$value->State;
                    $response['country']=$value->Country;
                    break;
                }  
            }
            else{
                $response['status']='0';
                $response['massage']='No data found !';
            }
        }
        else{
            $response['status']='0';
            $response['massage']='No data found !'; 
        }

        
        echo json_encode($response);
        return;

    }
    
    // get order unique id

    private function get_order_unique_id()
    {
        $code_feed = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyv0123456789";
        $code_length = 8;  // Set this to be your desired code length
        $final_code = "";
        $feed_length = strlen($code_feed);

        for($i = 0; $i < $code_length; $i ++) {
            $feed_selector = rand(0,$feed_length-1);
            $final_code .= substr($code_feed,$feed_selector,1);
        }
        return $final_code;
    }

    // add product review

    public function product_review(){

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
            redirect('login-register', 'refresh');
        }

        $product_id=$this->input->post("product_id");
        $rate=trim($this->input->post("rating"));
        $review_desc=stripslashes(trim($this->input->post("message")));

        $where= array('user_id' => $user_id, 'product_id' => $product_id);

        $row=$this->common_model->selectByids($where, 'tbl_rating');

        if(empty($row))
        {

            $rowOrd=$this->common_model->selectByids($where, 'tbl_order_items');

            // add new review
            $data_arr = array(
                'product_id' => $product_id,
                'user_id' => $user_id,
                'order_id' => $rowOrd[0]->order_id,
                'rating' => $rate,
                'rating_desc' => $review_desc,
                'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
            );

            $data_usr = $this->security->xss_clean($data_arr);

            $review_id = $this->common_model->insert($data_usr, 'tbl_rating');

            if(!empty($_FILES['product_images'])){
                $files = $_FILES;
                $cpt = count($_FILES['product_images']['name']);
                for($i=0; $i<$cpt; $i++)
                {
                    $_FILES['product_images']['name']= $files['product_images']['name'][$i];
                    $_FILES['product_images']['type']= $files['product_images']['type'][$i];
                    $_FILES['product_images']['tmp_name']= $files['product_images']['tmp_name'][$i];
                    $_FILES['product_images']['error']= $files['product_images']['error'][$i];
                    $_FILES['product_images']['size']= $files['product_images']['size'][$i];  

                    $image = date('dmYhis').'_'.rand(0,99999)."_review.".pathinfo($files['product_images']['name'][$i], PATHINFO_EXTENSION);

                    $config['file_name'] = $image;  

                    // File upload configuration
                    $uploadPath = 'assets/images/review_images/';
                    $config['upload_path'] = $uploadPath;
                    $config['allowed_types'] = 'jpg|jpeg|png|gif';

                    // Load and initialize upload library
                    $this->load->library('upload');
                    $this->upload->initialize($config);   

                    if($this->upload->do_upload('product_images')){

                        $data_img = array(
                            'parent_id' => $review_id,
                            'image_file' => $image,
                            'type' => 'review'
                        );

                        $data_img = $this->security->xss_clean($data_img);
                        $this->common_model->insert($data_img, 'tbl_product_images');
                    }
                }   
            }

            $message = array('success' => '1','message' => $this->lang->line('review_submit'),'class' => 'success');
            $this->session->set_flashdata('response_msg', $message);
            // product review

            $this->Product_model->set_product_review($product_id);
        }
        else
        {
            // update old review
            $data_arr = array(
                'product_id' => $product_id,
                'user_id' => $user_id,
                'order_id' => $row[0]->order_id,
                'rating' => $rate,
                'rating_desc' => $review_desc
            );

            $data_usr = $this->security->xss_clean($data_arr);

            $this->common_model->update($data_usr, $row[0]->id,'tbl_rating');

            $review_id = $row[0]->id;

            if(!empty($_FILES['product_images'])){
                $files = $_FILES;
                $cpt = count($_FILES['product_images']['name']);
                for($i=0; $i<$cpt; $i++)
                {           

                    $_FILES['product_images']['name']= $files['product_images']['name'][$i];
                    $_FILES['product_images']['type']= $files['product_images']['type'][$i];
                    $_FILES['product_images']['tmp_name']= $files['product_images']['tmp_name'][$i];
                    $_FILES['product_images']['error']= $files['product_images']['error'][$i];
                    $_FILES['product_images']['size']= $files['product_images']['size'][$i];  

                    $image = date('dmYhis').'_'.rand(0,99999)."_review.".pathinfo($files['product_images']['name'][$i], PATHINFO_EXTENSION);

                    $config['file_name'] = $image;  

                    // File upload configuration
                    $uploadPath = 'assets/images/review_images/';
                    $config['upload_path'] = $uploadPath;
                    $config['allowed_types'] = 'jpg|jpeg|png|gif';

                    // Load and initialize upload library
                    $this->load->library('upload');
                    $this->upload->initialize($config);   

                    if($this->upload->do_upload('product_images')){

                        $data_img = array(
                            'parent_id' => $review_id,
                            'image_file' => $image,
                            'type' => 'review'
                        );

                        $data_img = $this->security->xss_clean($data_img);
                        $this->common_model->insert($data_img, 'tbl_product_images');
                    }
                }   
            }

            $message = array('success' => '1','message' => $this->lang->line('review_updated'),'class' => 'success');
            $this->session->set_flashdata('response_msg', $message);

            // product review
            $this->Product_model->set_product_review($product_id,'edit');

        }

        echo json_encode($message);

    }

    public function edit_review(){

        $id=$this->input->post("review_id");

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
            redirect('login-register', 'refresh');
        }

        $rate=trim($this->input->post("rating"));
        $review_desc=trim($this->input->post("message"));

        $data_arr = array(
            'rating' => $rate,
            'rating_desc' => $review_desc
        );

        $data_usr = $this->security->xss_clean($data_arr);

        $this->common_model->update($data_usr, $id,'tbl_rating');

        if(!empty($_FILES['product_images'])){
            $files = $_FILES;
            $cpt = count($_FILES['product_images']['name']);
            for($i=0; $i<$cpt; $i++)
            {
                $_FILES['product_images']['name']= $files['product_images']['name'][$i];
                $_FILES['product_images']['type']= $files['product_images']['type'][$i];
                $_FILES['product_images']['tmp_name']= $files['product_images']['tmp_name'][$i];
                $_FILES['product_images']['error']= $files['product_images']['error'][$i];
                $_FILES['product_images']['size']= $files['product_images']['size'][$i];  

                $image = date('dmYhis').'_'.rand(0,99999)."_review.".pathinfo($files['product_images']['name'][$i], PATHINFO_EXTENSION);

                $config['file_name'] = $image;  

                // File upload configuration
                $uploadPath = 'assets/images/review_images/';
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = 'jpg|jpeg|png|gif';

                // Load and initialize upload library
                $this->load->library('upload');
                $this->upload->initialize($config);   

                if($this->upload->do_upload('product_images')){

                    $data_img = array(
                        'parent_id' => $id,
                        'image_file' => $image,
                        'type' => 'review'
                    );

                    $data_img = $this->security->xss_clean($data_img);
                    $this->common_model->insert($data_img, 'tbl_product_images');
                }
            }   
        }

        $message = array('success' => '1','message' => $this->lang->line('review_updated'));

        echo base64_encode(json_encode($message));
    }

    public function remove_review_image(){

        $id=$this->input->post("id");

        $row=$this->common_model->selectByid($id, 'tbl_product_images');
        
        if(file_exists('assets/images/review_images/'.$row->image_file)){
            unlink('assets/images/review_images/'.$row->image_file);
            $mask = $row->id.'*_*';
            array_map('unlink', glob('assets/images/review_images/thumbs/'.$mask));

            $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row->image_file);
            $mask = $thumb_img_nm.'*_*';
            array_map('unlink', glob('assets/images/review_images/thumbs/'.$mask));
        }

        $this->common_model->delete($id,'tbl_product_images');
        
        
        $message = array('success' => '1','message' => $this->lang->line('delete_success'),'class' => 'success');

        echo json_encode($message);
    }

    public function remove_review(){

        $id=$this->input->post("review_id");

        $row_img=$this->common_model->selectByids(array('parent_id' => $id, 'type' => 'review'), 'tbl_product_images');

        foreach ($row_img as $key => $value) {
            if(file_exists('assets/images/review_images/'.$value->image_file))
                unlink('assets/images/review_images/'.$value->image_file);

            $this->common_model->delete($value->id,'tbl_product_images');
        }
        
        $this->common_model->delete($id,'tbl_rating');
        
        $message = array('success' => '1','message' => $this->lang->line('delete_success'));

        echo json_encode($message);

    }

    // COD Place Order Process

    public function place_order(){

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
            redirect('login-register', 'refresh');
        }

        $buy_now=$this->input->post('buy_now');

        $row_address=$this->common_model->selectByid($this->input->post('order_address'), 'tbl_addresses');

        if(!empty($row_address))
        {
            $products_arr=array();
            $data_email=array();

            $is_avail=true;

            $total_cart_amt=$delivery_charge=$you_save=0;

            $order_unique_id='ORD'.$this->get_order_unique_id().rand(0,1000);

            $total_amount=$you_save=$delivery_charge=0;

            if($buy_now=='false'){

                $my_cart=$this->api_model->get_cart($user_id);

                if(!empty($my_cart)){

                    $where=array('user_id' => $user_id, 'cart_type' => 'main_cart');

                    $coupon_id=$this->input->post('coupon_id');

                    if(count($this->common_model->selectByids($where,'tbl_applied_coupon'))==0){
                        $coupon_id=0;
                    }

                    foreach ($my_cart as $value)
                    {
                        if($value->cart_status==0){
                            $is_avail=false;
                        }

                        $total_cart_amt+=$value->selling_price*$value->product_qty;
                        $delivery_charge+=$value->delivery_charge;
                        $you_save+=$value->you_save_amt * $value->product_qty;
                    }

                    if(!$is_avail){
                        $res_json=array('success' => '-2','msg' => $this->lang->line('some_product_unavailable_lbl'));
                        echo json_encode($res_json);
                        exit();
                    }

                    if($coupon_id==0){
                        $discount=0;
                        $discount_amt=0;
                        $payable_amt=number_format(($total_cart_amt+$delivery_charge), 2);
                    }
                    else{

                        $coupon_json=json_decode($this->inner_apply_coupon($coupon_id));
                        $discount=$coupon_json->discount;
                        $discount_amt=$coupon_json->discount_amt;
                        $payable_amt=$coupon_json->payable_amt;
                    }
                    
                    $data_arr = array(
                        'user_id' => $this->session->userdata('user_id'),
                        'coupon_id' => $this->input->post('coupon_id'),
                        'order_unique_id' => $order_unique_id,
                        'order_address' => $this->input->post('order_address'),
                        'total_amt' => $total_cart_amt,
                        'discount' => $discount,
                        'discount_amt' => $discount_amt,
                        'payable_amt' => $payable_amt,
                        'new_payable_amt' => $payable_amt,
                        'delivery_date' => strtotime(date('d-m-Y h:i:s A', strtotime('+7 days'))),
                        'order_date' => strtotime(date('d-m-Y h:i:s A',now())),
                        'delivery_charge' => $delivery_charge,
                        'pincode' => $row_address->pincode,
                        'building_name' => $row_address->building_name,
                        'road_area_colony' => $row_address->road_area_colony,
                        'city' => $row_address->city,
                        'district' => $row_address->district,
                        'state' => $row_address->state,
                        'country' => $row_address->country,
                        'landmark' => $row_address->landmark,
                        'name' => $row_address->name,
                        'email' => $row_address->email,
                        'mobile_no' => $row_address->mobile_no,
                        'alter_mobile_no' => $row_address->alter_mobile_no,
                        'address_type' => $row_address->address_type
                    );

                    $data_ord = $this->security->xss_clean($data_arr);

                    $order_id = $this->common_model->insert($data_ord, 'tbl_order_details');

                    foreach ($my_cart as $value){

                        $cart_id=$value->id;

                        $total_price=($value->product_qty*$value->selling_price);
    
                        $product_mrp=$value->selling_price;

                        $data_order = array(
                            'order_id'  =>  $order_id,
                            'user_id' => $user_id,
                            'product_id'  =>  $value->product_id,
                            'product_title'  =>  $value->product_title,
                            'product_qty'  =>  $value->product_qty,
                            'product_mrp'  =>  $value->product_mrp,
                            'product_price'  =>  $product_mrp,
                            'you_save_amt'  =>  $value->you_save_amt,
                            'product_size'  =>  $value->product_size,
                            'total_price'  =>  $total_price,
                            'delivery_charge'  =>  $value->delivery_charge,
                            'pro_order_status' => '1'
                        );

                        $data_ord_detail = $this->security->xss_clean($data_order);
    
                        $this->common_model->insert($data_ord_detail, 'tbl_order_items');

                        $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $this->common_model->selectByidsParam(array('id' => $value->product_id),'tbl_product','featured_image'));

                        $img_file=$this->_create_thumbnail('assets/images/products/',$thumb_img_nm,$this->common_model->selectByidsParam(array('id' => $value->product_id),'tbl_product','featured_image'),300,300);

                        $p_items['product_url']=base_url('product/'.$value->product_slug);
                        $p_items['product_title']=$value->product_title;
                        $p_items['product_img']=base_url().$img_file;
                        $p_items['product_qty']=$value->product_qty;
                        $p_items['product_price']=$product_mrp;
                        $p_items['delivery_charge']=$delivery_charge;
                        $p_items['product_size']=$value->product_size;
                        
                        $product_color=$this->common_model->selectByidsParam(array('id' => $value->product_id), 'tbl_product', 'color');

                        if ($product_color != '') {
                            $color_arr = explode('/', $product_color);
                            $color_name = $color_arr[0];
                            $product_color=$color_name;
                        }

                        $p_items['product_color'] = $product_color;

                        $p_items['delivery_date']=date('d M, Y').'-'.date('d M, Y', strtotime('+7 days'));

                        array_push($products_arr, $p_items);

                        $this->common_model->delete($cart_id,'tbl_cart');
                    }

                    $data_arr = array(
                        'user_id' => $user_id,
                        'email' => $this->session->userdata('user_email'),
                        'order_id' => $order_id,
                        'order_unique_id' => $order_unique_id,
                        'gateway' => $this->input->post('payment_method'),
                        'payment_amt' => $payable_amt,
                        'payment_id' => '0',
                        'date' => strtotime(date('d-m-Y h:i:s A',now())),
                        'status' => '1'
                    );

                    $data_usr = $this->security->xss_clean($data_arr);

                    $this->common_model->insert($data_usr, 'tbl_transaction');

                    $data_update = array(
                        'order_status'  =>  '1',
                    );

                    $this->common_model->update($data_update, $order_id,'tbl_order_details');

                    $data_arr = array(
                        'order_id' => $order_id,
                        'user_id' => $user_id,
                        'product_id' => '0',
                        'status_title' => '1',
                        'status_desc' => $this->lang->line('0'),
                        'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
                    );

                    $data_usr = $this->security->xss_clean($data_arr);

                    $this->common_model->insert($data_usr, 'tbl_order_status');

                    $where = array('order_id' => $order_id);

                    $row_items=$this->common_model->selectByids($where, 'tbl_order_items');

                    foreach ($row_items as $key2 => $value2) {
                        $data_arr = array(
                            'order_id' => $order_id,
                            'user_id' => $value2->user_id,
                            'product_id' => $value2->product_id,
                            'status_title' => '1',
                            'status_desc' => $this->lang->line('0'),
                            'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
                        );

                        $data_usr = $this->security->xss_clean($data_arr);

                        $this->common_model->insert($data_usr, 'tbl_order_status');
                    }

                    $row_tran = $this->common_model->selectByids(array('order_unique_id ' => $order_unique_id), 'tbl_transaction')[0];

                    $data_email['payment_mode'] = strtoupper($row_tran->gateway);
                    $data_email['payment_id'] = $row_tran->payment_id;

                    $delivery_address=$row_address->building_name.', '.$row_address->road_area_colony.',<br/>'.$row_address->pincode.'<br/>'.$row_address->city.', '.$row_address->state.', '.$row_address->country;

                    $data_email['users_name']=$row_address->name;
                    $data_email['users_email']=$row_address->email;
                    $data_email['users_mobile']=$row_address->mobile_no;

                    $admin_name=$this->common_model->selectByidsParam(array('id' => 1),'tbl_admin','username');

                    $data_email['admin_name']=ucfirst($admin_name);

                    $data_email['order_unique_id']=$order_unique_id;
                    $data_email['order_date']=date('d M, Y');
                    $data_email['delivery_address']=$delivery_address;
                    $data_email['discount_amt'] = $discount_amt;
                    $data_email['total_amt'] = $total_cart_amt;
                    $data_email['delivery_charge'] = $delivery_charge;
                    $data_email['payable_amt'] = $payable_amt;

                    $data_email['products']=$products_arr;

                    $subject = $this->app_name.' - '.$this->lang->line('ord_summary_lbl');

                    $body = $this->load->view('emails/order_summary.php',$data_email,TRUE);

                    if(send_email($row_address->email, $row_address->name, $subject, $body)){

                        if($this->order_email!='')
                        {
                            $subject = $this->app_name.' - '.$this->lang->line('new_ord_lbl');

                            $body = $this->load->view('emails/admin_order_summary.php',$data_email,TRUE);

                            send_email($this->order_email, $admin_name, $subject, $body);
                        } 
                    }
                    else{
                        $res_json=array('success' => '0','msg' => $this->lang->line('email_not_sent'), 'order_unique_id' => $order_unique_id, 'error' => $this->email->print_debugger());
                    }

                    $res_json=array('success' => '1','msg' => $this->lang->line('ord_summary_mail_msg'), 'order_unique_id' => $order_unique_id); 

                    $this->common_model->deleteByids(array('user_id' => $user_id, 'cart_type' => 'main_cart'),'tbl_applied_coupon');
                }
                else{
                    $res_json=array('success' => '-1','msg' => $this->lang->line('ord_placed_empty_lbl'));
                }
            }
            else if($buy_now=='true'){

                $cart_ids=$this->input->post('cart_ids');

                $my_cart=$this->api_model->get_cart($user_id,$cart_ids);

                if(!empty($my_cart)){

                    $where=array('user_id' => $user_id, 'cart_type' => 'temp_cart');

                    $coupon_id=$this->input->post('coupon_id');

                    if(count($this->common_model->selectByids($where,'tbl_applied_coupon'))==0){
                        $coupon_id=0;
                    }

                    foreach ($my_cart as $value)
                    {
                        if($value->cart_status==0){
                            $is_avail=false;
                        }

                        $total_cart_amt+=$value->selling_price*$value->product_qty;
                        $delivery_charge+=$value->delivery_charge;
                        $you_save+=$value->you_save_amt * $value->product_qty;
                    }

                    if(!$is_avail){
                        $res_json=array('success' => '-2','msg' => $this->lang->line('product_unavailable_lbl'));
                        echo json_encode($res_json);
                        exit();
                    }

                    if($coupon_id==0){
                        $discount=0;
                        $discount_amt=0;
                        $payable_amt=$total_cart_amt+$delivery_charge;
                    }
                    else{

                        $coupon_json=json_decode($this->inner_apply_coupon($coupon_id, $cart_ids, 'temp_cart'));
                        $discount=$coupon_json->discount;
                        $discount_amt=$coupon_json->discount_amt;
                        $payable_amt=$coupon_json->payable_amt;
                    }

                    $data_arr = array(
                        'user_id' => $user_id,
                        'coupon_id' => $this->input->post('coupon_id'),
                        'order_unique_id' => $order_unique_id,
                        'order_address' => $this->input->post('order_address'),
                        'total_amt' => $total_cart_amt,
                        'discount' => $discount,
                        'discount_amt' => $discount_amt,
                        'payable_amt' => $payable_amt,
                        'new_payable_amt' => $payable_amt,
                        'delivery_date' => strtotime(date('d-m-Y h:i:s A', strtotime('+7 days'))),
                        'order_date' => strtotime(date('d-m-Y h:i:s A',now())),
                        'delivery_charge' => $delivery_charge,
                        'pincode' => $row_address->pincode,
                        'building_name' => $row_address->building_name,
                        'road_area_colony' => $row_address->road_area_colony,
                        'city' => $row_address->city,
                        'district' => $row_address->district,
                        'state' => $row_address->state,
                        'country' => $row_address->country,
                        'landmark' => $row_address->landmark,
                        'name' => $row_address->name,
                        'email' => $row_address->email,
                        'mobile_no' => $row_address->mobile_no,
                        'alter_mobile_no' => $row_address->alter_mobile_no,
                        'address_type' => $row_address->address_type
                    );

                    $data_ord = $this->security->xss_clean($data_arr);

                    $order_id = $this->common_model->insert($data_ord, 'tbl_order_details');

                    foreach ($my_cart as $value){

                        $cart_id=$value->id;
                        
                        $total_price=($value->product_qty*$value->selling_price);

                        $product_mrp=$value->selling_price;

                        $data_order = array(
                            'order_id'  =>  $order_id,
                            'user_id' => $user_id,
                            'product_id'  =>  $value->product_id,
                            'product_title'  =>  $value->product_title,
                            'product_qty'  =>  $value->product_qty,
                            'product_mrp'  =>  $value->product_mrp,
                            'product_price'  =>  $product_mrp,
                            'you_save_amt'  =>  $value->you_save_amt,
                            'product_size'  =>  $value->product_size,
                            'total_price'  =>  $total_price,
                            'delivery_charge'  =>  $value->delivery_charge,
                            'pro_order_status' => '1'
                        );

                        $data_ord_detail = $this->security->xss_clean($data_order);

                        $this->common_model->insert($data_ord_detail, 'tbl_order_items');

                        $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $this->common_model->selectByidsParam(array('id' => $value->product_id),'tbl_product','featured_image'));

                        $img_file=$this->_create_thumbnail('assets/images/products/',$thumb_img_nm,$this->common_model->selectByidsParam(array('id' => $value->product_id),'tbl_product','featured_image'),300,300);

                        $p_items['product_url']=base_url('product/'.$value->product_slug);
                        $p_items['product_title']=$value->product_title;
                        $p_items['product_img']=base_url().$img_file;
                        $p_items['product_qty']=$value->product_qty;
                        $p_items['product_price']=$product_mrp;
                        $p_items['delivery_charge']=$delivery_charge;
                        $p_items['product_size']=$value->product_size;
                        
                        $product_color=$this->common_model->selectByidsParam(array('id' => $value->product_id), 'tbl_product', 'color');

                        if ($product_color != '') {

                            $color_arr = explode('/', $product_color);
                            $color_name = $color_arr[0];
                            $product_color=$color_name;
                        }

                        $p_items['product_color'] = $product_color;

                        $p_items['delivery_date']=date('d M, Y').'-'.date('d M, Y', strtotime('+7 days'));

                        array_push($products_arr, $p_items);

                        $this->common_model->delete($cart_id,'tbl_cart_tmp');

                        $this->common_model->deleteByids(array('user_id' => $user_id, 'product_id'  =>  $value->product_id),'tbl_cart');
                    }

                    $data_arr = array(
                        'user_id' => $user_id,
                        'email' => $this->session->userdata('user_email'),
                        'order_id' => $order_id,
                        'order_unique_id' => $order_unique_id,
                        'gateway' => $this->input->post('payment_method'),
                        'payment_amt' => $payable_amt,
                        'payment_id' => '0',
                        'date' => strtotime(date('d-m-Y h:i:s A',now())),
                        'status' => '1'
                    );

                    $data_usr = $this->security->xss_clean($data_arr);

                    $this->common_model->insert($data_usr, 'tbl_transaction');

                    $data_update = array(
                        'order_status'  =>  '1',
                    );

                    $this->common_model->update($data_update, $order_id,'tbl_order_details');

                    $data_arr = array(
                        'order_id' => $order_id,
                        'user_id' => $user_id,
                        'product_id' => '0',
                        'status_title' => '1',
                        'status_desc' => $this->lang->line('0'),
                        'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
                    );

                    $data_usr = $this->security->xss_clean($data_arr);

                    $this->common_model->insert($data_usr, 'tbl_order_status');

                    $where = array('order_id' => $order_id);

                    $row_items=$this->common_model->selectByids($where, 'tbl_order_items');

                    foreach ($row_items as $value2) {
                        $data_arr = array(
                            'order_id' => $order_id,
                            'user_id' => $value2->user_id,
                            'product_id' => $value2->product_id,
                            'status_title' => '1',
                            'status_desc' => $this->lang->line('0'),
                            'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
                        );

                        $data_usr = $this->security->xss_clean($data_arr);

                        $this->common_model->insert($data_usr, 'tbl_order_status');
                    }

                    $row_tran = $this->common_model->selectByids(array('order_unique_id ' => $order_unique_id), 'tbl_transaction')[0];

                    $data_email['payment_mode'] = strtoupper($row_tran->gateway);
                    $data_email['payment_id'] = $row_tran->payment_id;

                    $delivery_address=$row_address->building_name.', '.$row_address->road_area_colony.',<br/>'.$row_address->pincode.'<br/>'.$row_address->city.', '.$row_address->state.', '.$row_address->country;

                    $data_email['users_name']=$row_address->name;
                    $data_email['users_email']=$row_address->email;
                    $data_email['users_mobile']=$row_address->mobile_no;

                    $admin_name=$this->common_model->selectByidsParam(array('id' => 1),'tbl_admin','username');

                    $data_email['admin_name']=ucfirst($admin_name);

                    $data_email['order_unique_id']=$order_unique_id;
                    $data_email['order_date']=date('d M, Y');
                    $data_email['delivery_address']=$delivery_address;
                    $data_email['discount_amt'] = $discount_amt;
                    $data_email['total_amt'] = $total_cart_amt;
                    $data_email['delivery_charge'] = $delivery_charge;
                    $data_email['payable_amt'] = $payable_amt;

                    $data_email['products']=$products_arr;

                    $subject = $this->app_name.' - '.$this->lang->line('ord_summary_lbl');

                    $body = $this->load->view('emails/order_summary.php',$data_email,TRUE);

                    if(send_email($row_address->email, $row_address->name, $subject, $body)){

                       if($this->order_email!=''){
                        
                            $subject = $this->app_name.' - '.$this->lang->line('new_ord_lbl');

                            $body = $this->load->view('emails/admin_order_summary.php',$data_email,TRUE);

                            send_email($this->order_email, $admin_name, $subject, $body);
                        } 
                    }
                    else{
                        $res_json=array('success' => '0','msg' => $this->lang->line('email_not_sent'), 'order_unique_id' => $order_unique_id, 'error' => $this->email->print_debugger());
                    }

                    $res_json=array('success' => '1','msg' => $this->lang->line('ord_summary_mail_msg'), 'order_unique_id' => $order_unique_id); 

                    $this->common_model->deleteByids(array('user_id' => $user_id, 'cart_type' => 'temp_cart'),'tbl_applied_coupon');
                }
                else{
                    $res_json=array('success' => '-1','msg' => $this->lang->line('ord_placed_empty_lbl'));
                }
            }
        }
        else{
            // no address found
            $res_json = array('success' => '-1', 'msg' => $this->lang->line('no_address_found'));
        }

        echo json_encode($res_json);
        exit();

    }

    // End COD place order process

    // download order invoice
    public function download_invoice(){

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
            redirect('login-register', 'refresh');
        }

        $data = array();

        $order_no =  $this->uri->segment(2);
        
        $data['page_title'] = 'Orders';
        $data['current_page'] = 'Order Summary';
        $data['order_data'] = $this->Order_model->get_order($order_no);
        $this->load->view('download_invoice', $data); // :blush:
        
        $html = $this->output->get_output();
        
        // Load pdf library
        $this->load->library('pdf');
        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->render();

        $file_name=$this->lang->line('ord_invoice_lbl')." - ".$order_no.".pdf";

        $this->pdf->stream($file_name, array("Attachment"=> 0));

    }

    // download order invoice
    public function app_download_invoice(){

        $data = array();

        $order_no =  $this->uri->segment(2);
        
        $data['order_data'] = $this->Order_model->get_order($order_no);
        $this->load->view('download_invoice', $data); // :blush:
        
        $html = $this->output->get_output();
        
        // Load pdf library
        $this->load->library('pdf');
        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->render();

        $file_name=$this->lang->line('ord_invoice_lbl')." - ".$order_no.".pdf";

        $this->pdf->stream($file_name, array("Attachment"=> 0));

    }

    public function my_order($order_unique_id=NULL){

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
            redirect('login-register', 'refresh');
        }

        $data = array();
        $data['page_title'] = $this->lang->line('myorders_lbl');
        $data['current_page'] = $this->lang->line('myorders_lbl');

        if($order_unique_id!=NULL){
            $data['my_order'] = $this->api_model->get_order($order_unique_id);

            $data['current_page'] = $order_unique_id;

            if(empty($data['my_order'])){
                if(isset($_SERVER['HTTP_REFERER']))
                    redirect($_SERVER['HTTP_REFERER']);
                else
                    redirect('/', 'refresh');
            }

            $data['order_address'] = $this->common_model->selectByid($data['my_order'][0]->order_address, 'tbl_addresses');

            $data['status_titles'] = $this->Order_model->get_titles(true);

            $data['order_status'] = $this->Order_model->get_product_status($data['my_order'][0]->id,0);

            $where = array('order_unique_id ' => $order_unique_id);

            $rowRefund = $this->common_model->selectByids($where, 'tbl_refund');

            $data['refund_data'] = $rowRefund;

            $data['bank_details'] = $this->common_model->selectByids(array('user_id' => $user_id), 'tbl_bank_details','id');

            $this->template->load('site/template2', 'site/pages/order_detail', $data); // :blush:
        }
        else
        {
            $data['my_orders'] = $this->api_model->get_my_orders($user_id);

            $data['bank_details'] = $this->common_model->selectByids(array('user_id' => $user_id), 'tbl_bank_details','is_default');

            $this->template->load('site/template2', 'site/pages/my_orders', $data); // :blush:
        }
    }

    public function is_order_claim($order_id)
    {

        $count_items=count($this->common_model->selectByids(array('order_id' => $order_id), 'tbl_order_items'));
        $count_refund_items=count($this->common_model->selectByids(array('order_id' => $order_id, 'request_status' => '-1'), 'tbl_refund'));

        if($count_items==$count_refund_items){
            return true;
        }
        else{
            return false;
        }

    }

    public function my_account(){

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
            redirect('login-register', 'refresh');
        }

        $data = array();
        $data['page_title'] = $this->lang->line('my_profile_lbl');
        $data['current_page'] = $this->lang->line('my_profile_lbl');

        $data['user_data'] = $this->common_model->selectByid($user_id, 'tbl_users');

        $this->template->load('site/template2', 'site/pages/my_account', $data); // :blush:

    }

    public function change_password_page(){

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
            redirect('login-register', 'refresh');
        }

        if(strcmp($this->session->userdata('user_type'), 'Normal')!=0)
        {
            $this->template->load('site/template2', 'site/pages/404'); // :blush:
            return;
        }

        $data = array();
        $data['page_title'] = $this->lang->line('change_password_lbl');
        $data['current_page'] = $this->lang->line('change_password_lbl');
        
        $this->template->load('site/template2', 'site/pages/change_password', $data); // :blush:
    }

    public function my_addresses(){

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
            redirect('login-register', 'refresh');
        }

        $data = array();
        $data['page_title'] = $this->lang->line('addresses_lbl');
        $data['current_page'] = $this->lang->line('addresses_lbl');

        $data['addresses'] = $this->common_model->get_addresses($user_id);

        $this->template->load('site/template2', 'site/pages/addresses', $data); // :blush:

    }

    public function saved_bank_accounts(){

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
            redirect('login-register', 'refresh');
        }

        $data = array();
        $data['page_title'] = $this->lang->line('saved_bank_lbl');
        $data['current_page'] = $this->lang->line('saved_bank_lbl');

        $data['bank_details'] = $this->common_model->selectByids(array('user_id' => $user_id), 'tbl_bank_details');

        $this->template->load('site/template2', 'site/pages/saved_cards.php', $data); // :blush:

    }

    public function my_reviews(){

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
            redirect('login-register', 'refresh');
        }

        $data = array();
        $data['page_title'] = $this->lang->line('myreviewrating_lbl');
        $data['current_page'] = $this->lang->line('myreviewrating_lbl');

        $where= array('user_id' => $user_id);

        $data['my_review']=$this->common_model->selectByids($where, 'tbl_rating');

        $this->template->load('site/template2', 'site/pages/my_reviews.php', $data); // :blush:

    }

    public function product_reviews(){

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
            redirect('login-register', 'refresh');
        }

        $data = array();
        $data['page_title'] = $this->lang->line('cust_review_lbl');
        $data['current_page'] = $this->lang->line('cust_review_lbl');

        $product_slug =  $this->uri->segment(2);

        $config = array();
        $config["base_url"] = base_url() . 'product-reviews/'.$product_slug;
        $config["per_page"] = $this->page_limit;

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 1;

        $page=($page-1) * $config["per_page"];

        $where=array('product_slug' => $product_slug);

        $product_id =  $this->common_model->getIdBySlug($where, 'tbl_product');

        if($this->input->get('sort')!=''){
            $data['reviews']=$this->api_model->get_product_review($product_id, $this->input->get('sort'));
        }
        else{
            $data['reviews']=$this->api_model->get_product_review($product_id,'',$config["per_page"],$page); 
        }

        $config["total_rows"] = count($this->api_model->get_product_review($product_id));

        $config['num_links'] = 2;
        $config['use_page_numbers'] = TRUE;
        $config['reuse_query_string'] = TRUE;
         
        $config['full_tag_open'] = '<ul class="page-number">';
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

        $data["links"] = $this->pagination->create_links();

        $data['product_row']=$this->common_model->selectByid($product_id, 'tbl_product');

        $this->template->load('site/template2', 'site/pages/product_reviews.php', $data); // :blush:

    }

    public function change_password(){

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
            redirect('login-register', 'refresh');
        }

        $response=array();

        extract($this->input->post());

        if(count($this->common_model->selectByids(array('user_password' => md5($old_password), 'id' => $user_id), 'tbl_users')) > 0){

            $data_update = array(
                'user_password'  =>  md5($new_password)
            );

            $this->common_model->update($data_update, $user_id,'tbl_users');

            $response=array('status' => 1, 'msg' => $this->lang->line('change_password_msg'));
        }
        else{
            $response=array('status' => 0, 'msg' => $this->lang->line('wrong_password_error'), 'class' => 'err_old_password');
        }

        echo base64_encode(json_encode($response));

    }

    public function update_profile(){

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
            redirect('login-register', 'refresh');
        }

        $response=array();

        $row=$this->common_model->selectByid($user_id, 'tbl_users');

        $row_usr=$this->common_model->selectByids(array('user_type' => $row->user_type,'user_email' => $this->input->post('user_email'),'id <> ' => $user_id), 'tbl_users');

        if(empty($row_usr)){

            

            if($_FILES['file_name']['error']!=4){
                
                if($row->user_image!=''){
                    unlink('assets/images/users/'.$row->user_image);
                    $mask = $row->id.'*_*';
                    array_map('unlink', glob('assets/images/users/thumbs/'.$mask));

                    $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row->user_image);
                    $mask = $thumb_img_nm.'*_*';
                    array_map('unlink', glob('assets/images/users/thumbs/'.$mask));
                }

                $config['upload_path'] =  'assets/images/users/';
                $config['allowed_types'] = 'jpg|png|jpeg';

                $image = date('dmYhis').'_'.rand(0,99999).".".pathinfo($_FILES['file_name']['name'], PATHINFO_EXTENSION);

                $config['file_name'] = $image;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('file_name')) {
                    $response = array('status' => 0,'msg' => $this->upload->display_errors());
                    echo base64_encode(json_encode($response));
                    return;
                }
            }
            else{
                $image=$row->user_image;
            }

            $data = array(
                'user_name'  => $this->input->post('user_name'),
                'user_email'  => $this->input->post('user_email'),
                'user_phone'  => $this->input->post('user_phone'),
                'user_image'  => $image
            );

            $data_update = $this->security->xss_clean($data);

            $this->common_model->update($data_update, $user_id,'tbl_users');

            $response=array('status' => 1, 'msg' => $this->lang->line('profile_update_msg'), 'image' => base_url('assets/images/users/').$image);
        }
        else{
            $response=array('status' => 0, 'msg' => $this->lang->line('email_exist_error'));   
        }

        echo base64_encode(json_encode($response));

    }

    public function remove_profile(){

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
            redirect('login-register', 'refresh');
        }

        $response=array();

        $row=$this->common_model->selectByid($user_id, 'tbl_users');

        if($row->user_image!=''){
            unlink('assets/images/users/'.$row->user_image);
            $mask = $row->id.'*_*';
            array_map('unlink', glob('assets/images/users/thumbs/'.$mask));

            $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row->user_image);
            $mask = $thumb_img_nm.'*_*';
            array_map('unlink', glob('assets/images/users/thumbs/'.$mask));
        }

        $data = array(
            'user_image'  => ''
        );

        $data_update = $this->security->xss_clean($data);

        $this->common_model->update($data_update, $user_id,'tbl_users');

        $response=array('status' => 1, 'msg' => $this->lang->line('remove_profile_success'));

        echo base64_encode(json_encode($response));
    }

    // user's forgot password code
    public function forgot_password(){
        
        //-- check duplicate email
        $user_info = $this->common_model->check_email($this->input->post('registered_email'))[0];

        if (!empty($user_info)) {

            $info['new_password']=get_random_password();

            $updateData = array(
                'user_password' => md5($info['new_password'])
            );

            $data_arr = array(
                'email' => $user_info->user_email,
                'password' => $info['new_password']
            );

            if($this->common_model->update($updateData, $user_info->id,'tbl_users')){

                $subject = $this->app_name.' - '.$this->lang->line('forgot_password_lbl');

                $body = $this->load->view('admin/emails/forgot_password.php',$data_arr,TRUE);

                if(send_email($user_info->user_email, $user_info->user_name, $subject, $body))
                {
                    $message = array('success' => '1','message' => $this->lang->line('password_sent'),'class' => 'success');
                    $this->session->set_flashdata('response_msg', $message);
                }
                else{
                    $message = array('success' => '0','message' => $this->lang->line('email_not_sent'),'class' => 'alert alert-danger');
                }
            }
            
        }
        else{
            $message = array('success' => '0','message' => $this->lang->line('email_not_found'),'class' => 'alert alert-danger');
        }

        echo json_encode($message);

    }

    public function order_status($order_id, $product_id=NULL){

        $where=array('order_id' => $order_id);

        return $this->common_model->selectWhere('tbl_order_status',$where,'DESC');

    }

    // cancel product order
    public function cancel_product()
    {
        $order_id=$this->input->post('order_id');
        $product_id=$this->input->post('product_id');

        $reason=$this->input->post('reason');
        $bank_id=$this->input->post('bank_id');

        $products_arr=array();

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
            redirect('login-register', 'refresh');
        }

        $where=array('order_id' => $order_id);

        $row_trn=$this->common_model->selectByids($where, 'tbl_transaction')[0];

        $row_ord=$this->common_model->selectByid($order_id, 'tbl_order_details');

        $actual_pay_amt=($row_ord->payable_amt-$row_ord->delivery_charge);

        $refund_amt=$pro_refund_amt=$product_per=$refund_per=$new_payable_amt=$total_refund_amt=$total_refund_per=0;

        if($product_id!='0')
        {
            // for perticular product order cancel

            $where=array('order_id' => $order_id,'product_id' => $product_id);

            $row_pro=$this->common_model->selectByids($where, 'tbl_order_items');

            foreach ($row_pro as $value) 
            {
                if($row_ord->coupon_id!=0)
                {
                    $product_per=number_format((double)(($value->total_price/$row_ord->total_amt)*100), 2, '.', '');  //44

                    $refund_per=number_format((double)(($product_per/100)*$row_ord->discount_amt), 2, '.', ''); //22

                    $refund_amt=number_format((double)($value->total_price-$refund_per), 2, '.', '');

                    $new_payable_amt=number_format((double)($row_ord->new_payable_amt-$refund_amt), 2, '.', '');
                }
                else{
                    $refund_amt=$value->total_price;
                    $new_payable_amt=($row_ord->new_payable_amt-$refund_amt);
                }

                if($row_trn->gateway=='COD' || $row_trn->gateway=='cod'){
                    $bank_id=0;
                    $status=1;
                }
                else{
                    $status=0;
                }

                $data_arr = array(
                    'bank_id' => $bank_id,
                    'user_id' => $user_id,
                    'order_id' => $order_id,
                    'order_unique_id' => $row_ord->order_unique_id,
                    'product_id' => $product_id,
                    'product_title' => $value->product_title,
                    'product_amt' => $value->total_price,
                    'refund_pay_amt' => $refund_amt,
                    'refund_per' => $refund_per,
                    'gateway' => $row_trn->gateway,
                    'refund_reason' => $reason,
                    'last_updated' => strtotime(date('d-m-Y h:i:s A',now())),
                    'request_status' => $status,
                    'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
                );

                $data_update = $this->security->xss_clean($data_arr);

                $this->common_model->insert($data_update, 'tbl_refund');

                $where=array('order_id' => $order_id, 'pro_order_status <> ' => 5);

                if(count($this->common_model->selectByids($where, 'tbl_order_items')) == 1)
                {

                    $pro_refund_amt=$refund_amt;

                    $refund_amt=$row_ord->refund_amt+$refund_amt;
                    $new_payable_amt=($row_ord->payable_amt-$refund_amt);
                    $refund_per=$row_ord->refund_per+$refund_per;

                    $data_update = array(
                        'order_status' => '5',
                        'new_payable_amt'  =>  '0',
                        'refund_amt'  =>  $refund_amt,
                        'refund_per'  =>  $refund_per
                    );

                    $data = array(
                        'order_id' => $order_id,
                        'user_id' => $user_id,
                        'product_id' => '0',
                        'status_title' => '5',
                        'status_desc' => $this->lang->line('ord_cancel'),
                        'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
                    );

                    $data = $this->security->xss_clean($data);

                    $this->common_model->insert($data, 'tbl_order_status');

                }
                else{

                    $pro_refund_amt=$refund_amt;

                    $refund_amt=$row_ord->refund_amt+$refund_amt;
                    $new_payable_amt=($row_ord->payable_amt-$refund_amt);
                    $refund_per=$row_ord->refund_per+$refund_per;

                    $data_update = array(
                        'new_payable_amt'  =>  $new_payable_amt,
                        'refund_amt'  =>  $refund_amt,
                        'refund_per'  =>  $refund_per
                    );
                }

                $this->common_model->update($data_update, $order_id,'tbl_order_details');

                $data_pro = array(
                    'pro_order_status' => '5'
                ); 

                $data_pro = $this->security->xss_clean($data_pro);

                $this->common_model->updateByids($data_pro, array('order_id' => $order_id, 'product_id' => $product_id),'tbl_order_items');

                $data = array(
                    'order_id' => $order_id,
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                    'status_title' => '5',
                    'status_desc' => $this->lang->line('pro_ord_cancel'),
                    'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
                );

                $data = $this->security->xss_clean($data);

                $this->common_model->insert($data, 'tbl_order_status');

                $this->common_model->updateByids($data_pro, array('order_id' => $order_id, 'product_id' => $value->product_id),'tbl_order_items');

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $this->common_model->selectByidsParam(array('id' => $value->product_id),'tbl_product','featured_image'));

                $img_file=$this->_create_thumbnail('assets/images/products/',$thumb_img_nm,$this->common_model->selectByidsParam(array('id' => $value->product_id),'tbl_product','featured_image'),300,300);

                $p_items['product_title']=$this->common_model->selectByidsParam(array('id' => $value->product_id),'tbl_product','product_title');
                $p_items['product_img']=base_url().$img_file;
                $p_items['product_qty']=$value->product_qty;
                $p_items['product_price']=$value->product_price;
                $p_items['product_size']=$value->product_size;

                $product_color=$this->common_model->selectByidsParam(array('id' => $value->product_id), 'tbl_product', 'color');

                if ($product_color != '') {
                    $color_arr = explode('/', $product_color);
                    $color_name = $color_arr[0];
                    $product_color=$color_name;
                }

                $p_items['product_color'] = $product_color;

                array_push($products_arr, $p_items);
            }

            $response=array('success' => 1, 'msg' => $this->lang->line('product_cancelled_on_lbl'));
        }
        else
        {
            $where=array('order_id' => $order_id, 'pro_order_status <> ' => 5);

            $row_pro=$this->common_model->selectByids($where, 'tbl_order_items');

            foreach ($row_pro as $value) 
            {

                $product_per=$new_payable_amt=0;

                if($row_ord->coupon_id!=0)
                {

                    $product_per=number_format((double)(($value->total_price/$row_ord->total_amt)*100), 2, '.', '');  //44

                    $refund_per=number_format((double)(($product_per/100)*$row_ord->discount_amt), 2, '.', ''); //22

                    $refund_amt=number_format((double)($value->total_price-$refund_per), 2, '.', '');

                }
                else{
                    $refund_amt=$value->total_price;
                    $new_payable_amt=($row_ord->payable_amt-$refund_amt);
                }

                if($row_trn->gateway=='COD' || $row_trn->gateway=='cod'){
                    $bank_id=0;
                    $status=1;
                }
                else{
                    $status=0;
                }

                $total_refund_amt+=$refund_amt;
                $total_refund_per+=$refund_per;

                $data_arr = array(
                    'bank_id' => $bank_id,
                    'user_id' => $user_id,
                    'order_id' => $order_id,
                    'order_unique_id' => $row_ord->order_unique_id,
                    'product_id' => $value->product_id,
                    'product_title' => $value->product_title,
                    'product_amt' => $value->total_price,
                    'refund_pay_amt' => $refund_amt,
                    'refund_per' => $refund_per,
                    'gateway' => $row_trn->gateway,
                    'refund_reason' => $reason,
                    'last_updated' => strtotime(date('d-m-Y h:i:s A',now())),
                    'request_status' => $status,
                    'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
                );

                $data_update = $this->security->xss_clean($data_arr);

                $this->common_model->insert($data_update, 'tbl_refund');

                $data = array(
                    'order_id' => $order_id,
                    'user_id' => $user_id,
                    'product_id' => $value->product_id,
                    'status_title' => '5',
                    'status_desc' => $this->lang->line('pro_ord_cancel'),
                    'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
                );

                $data = $this->security->xss_clean($data);

                $this->common_model->insert($data, 'tbl_order_status');

                $data_pro = array(
                    'pro_order_status' => '5'
                ); 

                $data_pro = $this->security->xss_clean($data_pro);

                $this->common_model->updateByids($data_pro, array('order_id' => $order_id, 'product_id' => $value->product_id),'tbl_order_items');

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $this->common_model->selectByidsParam(array('id' => $value->product_id),'tbl_product','featured_image'));

                $img_file=$this->_create_thumbnail('assets/images/products/',$thumb_img_nm,$this->common_model->selectByidsParam(array('id' => $value->product_id),'tbl_product','featured_image'),300,300);

                $p_items['product_title']=$this->common_model->selectByidsParam(array('id' => $value->product_id),'tbl_product','product_title');
                $p_items['product_img']=base_url().$img_file;
                $p_items['product_qty']=$value->product_qty;
                $p_items['product_price']=$value->product_price;
                $p_items['product_size']=$value->product_size;

                $product_color=$this->common_model->selectByidsParam(array('id' => $value->product_id), 'tbl_product', 'color');

                if ($product_color != '') {
                    $color_arr = explode('/', $product_color);
                    $color_name = $color_arr[0];
                    $product_color=$color_name;
                }

                $p_items['product_color'] = $product_color;

                array_push($products_arr, $p_items);
            }

            $data_update = array(
                'order_status' => '5',
                'new_payable_amt'  =>  '0',
                'refund_amt'  =>  $total_refund_amt,
                'refund_per'  =>  $total_refund_per
            );

            $data_update = $this->security->xss_clean($data_update);
            $this->common_model->update($data_update, $order_id,'tbl_order_details');

            $data = array(
                'order_id' => $order_id,
                'user_id' => $user_id,
                'product_id' => '0',
                'status_title' => '5',
                'status_desc' => $this->lang->line('ord_cancel'),
                'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
            );

            $data = $this->security->xss_clean($data);

            $this->common_model->insert($data, 'tbl_order_status');
            
            $response=array('success' => 1, 'msg' => $this->lang->line('ord_cancelled_lbl'));
        }

        $data_ord=$this->common_model->selectByid($order_id,'tbl_order_details');

        $data_email=array();

        $admin_name=$this->common_model->selectByidsParam(array('id' => 1),'tbl_admin','username');

        $row_tran = $this->common_model->selectByids(array('order_unique_id ' => $data_ord->order_unique_id), 'tbl_transaction')[0];

        $data_email['payment_mode'] = strtoupper($row_tran->gateway);
        $data_email['payment_id'] = $row_tran->payment_id;

        $data_email['users_name']=$data_ord->name;

        $data_email['cancel_heading']=str_replace('###', $data_ord->order_unique_id, $this->lang->line('self_cancelled_lbl'));

        $data_email['admin_cancel_heading']='';
        $data_email['admin_name']='';

        $data_email['order_unique_id']=$data_ord->order_unique_id;
        $data_email['order_date']=date('d M, Y',$data_ord->order_date);

        $data_email['delivery_date']=date('d M, Y',$data_ord->delivery_date);
        $data_email['refund_amt']=($total_refund_amt==0) ? number_format($pro_refund_amt, 2) : number_format($total_refund_amt, 2);

        $data_email['status_desc']=$reason;
        $data_email['order_status']=$data_ord->order_status;

        $data_email['products']=$products_arr;
            
        $subject = $this->app_name.' - '.$this->lang->line('ord_status_update_lbl');

        $body = $this->load->view('emails/order_cancel.php',$data_email,TRUE);

        send_email($data_ord->email, $data_ord->name, $subject, $body);

        if($this->order_email!='')
        {
            $data_email['admin_cancel_heading']=str_replace('###', $data_ord->order_unique_id, $this->lang->line('admin_cancelled_lbl'));
            $data_email['admin_name']=$admin_name;

            $subject = $this->app_name.' - '.$this->lang->line('ord_cancel_detail_lbl');
            $body = $this->load->view('emails/order_cancel.php',$data_email,TRUE);
            send_email($this->order_email, $admin_name, $subject, $body);
        }

        echo json_encode($response);
    }

    // claim refund request
    public function claim_refund()
    {
        $order_id=$this->input->post('order_id');
        $product_id=$this->input->post('product_id');

        $bank_id=$this->input->post('bank_id');

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
            redirect('login-register', 'refresh');
        }

       $data_pro = array(
            'bank_id' => $bank_id,
            'last_updated' => strtotime(date('d-m-Y h:i:s A',now())),
            'request_status' => '0'
        ); 

        $data_pro = $this->security->xss_clean($data_pro);

        if($product_id!=0)
        {
            // claim for particular product of order

            if(count($this->common_model->selectByids(array('order_id' => $order_id, 'product_id' => $product_id, 'user_id' => $user_id), 'tbl_refund')))
            {
                $this->common_model->updateByids($data_pro, array('order_id' => $order_id, 'product_id' => $product_id, 'user_id' => $user_id),'tbl_refund');

                $response = array('success' => 1, 'msg' => $this->lang->line('claim_msg'));
            }
            else{
                $response = array('success' => 0, 'msg' => $this->lang->line('no_data_found_msg'));   
            }
        }
        else
        {
            // claim for whole order

            if(count($this->common_model->selectByids(array('order_id' => $order_id, 'user_id' => $user_id), 'tbl_refund')))
            {
                $this->common_model->updateByids($data_pro, array('order_id' => $order_id, 'user_id' => $user_id),'tbl_refund');

                $response = array('success' => 1, 'msg' => $this->lang->line('claim_msg'));
            }
            else{
                $response = array('success' => 0, 'msg' => $this->lang->line('no_data_found_msg'));   
            }
        }
        
        echo json_encode($response);
    }

    public function add_new_bank()
    {

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
            redirect('login-register', 'refresh');
        }

        extract($this->input->post());

        $where=array('user_id' => $user_id, 'account_no' => $account_no, 'bank_ifsc' => $bank_ifsc);

        $row=$this->common_model->selectByids($where, 'tbl_bank_details');

        if(count($row)==0){
            // add new
            $this->form_validation->set_rules('bank_name', 'Enter bank name', 'trim|required');
            $this->form_validation->set_rules('account_no', 'Enter bank account number', 'trim|required');
            $this->form_validation->set_rules('account_type', 'Select account type', 'trim|required');
            $this->form_validation->set_rules('holder_name', 'Enter bank holder name', 'trim|required');
            $this->form_validation->set_rules('holder_mobile', 'Enter holder mobile number', 'trim|required');

            if($this->form_validation->run() == FALSE)
            {
                $message = array('message' => $this->lang->line('input_required'),'success' => '0');
            }
            else{
                if($this->input->post('is_default')!=''){
                    $is_default=1;
                }
                else{
                    $is_default=0;   
                }

                $where=array('user_id' => $user_id);
                $row_data=$this->common_model->selectByids($where, 'tbl_bank_details');

                if(count($row_data) > 0){
                    if($is_default==1){
                        $data_arr = array(
                            'is_default' => 0
                        ); 

                        $data_arr = $this->security->xss_clean($data_arr);

                        $this->common_model->updateByids($data_arr, array('user_id' => $user_id),'tbl_bank_details');
                    }
                }
                else{
                    $is_default=1;
                }

                $data_arr = array(
                    'user_id' => $user_id,
                    'bank_holder_name' => $holder_name,
                    'bank_holder_phone' => $holder_mobile,
                    'bank_holder_email' => $holder_email,
                    'account_no' => $account_no,
                    'account_type' => $account_type,
                    'bank_ifsc' => $bank_ifsc,
                    'bank_name' => $bank_name,
                    'is_default' => $is_default,
                    'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
                );

                $data_usr = $this->security->xss_clean($data_arr);

                $last_id = $this->common_model->insert($data_usr, 'tbl_bank_details');
                
                $message = array('message' => $this->lang->line('add_msg'),'success' => '1','bank_id' => $last_id);
            }

        }
        else{
            $message = array('message' => $this->lang->line('bank_exist_error'),'success' => '0');
        }

        echo json_encode($message);

    }

    public function edit_bank_account(){

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            $message = array('message' => $this->lang->line('login_required_error'),'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
            redirect('login-register', 'refresh');
        }

        

        extract($this->input->post());

        $bank_id=$this->input->post('bank_id');

        $this->form_validation->set_rules('bank_name', 'Enter bank name', 'trim|required');
        $this->form_validation->set_rules('account_no', 'Enter bank account number', 'trim|required');
        $this->form_validation->set_rules('account_type', 'Select account type', 'trim|required');
        $this->form_validation->set_rules('holder_name', 'Enter bank holder name', 'trim|required');
        $this->form_validation->set_rules('holder_mobile', 'Enter holder mobile number', 'trim|required');

        if($this->form_validation->run() == FALSE)
        {
            $message = array('message' => $this->lang->line('input_required'),'success' => '0');
        }
        else{

            if($this->input->post('is_default')!=''){
                $is_default=1;
            }
            else{
                $is_default=0;
            }

            $where=array('user_id' => $user_id);
            $row_data=$this->common_model->selectByids($where, 'tbl_bank_details');

            if(count($row_data) > 0){
                if($is_default==1){
                    $data_arr = array(
                        'is_default' => 0
                    ); 

                    $data_arr = $this->security->xss_clean($data_arr);

                    $this->common_model->updateByids($data_arr, array('user_id' => $user_id),'tbl_bank_details');
                }
            }
            else{
                $is_default=1;
            }

            $data_arr = array(
                'user_id' => $user_id,
                'bank_holder_name' => $holder_name,
                'bank_holder_phone' => $holder_mobile,
                'bank_holder_email' => $holder_email,
                'account_no' => $account_no,
                'account_type' => $account_type,
                'bank_ifsc' => $bank_ifsc,
                'bank_name' => $bank_name,
                'is_default' => $is_default
            );

            $data_usr = $this->security->xss_clean($data_arr);

            $this->common_model->update($data_usr, $bank_id,'tbl_bank_details');

            if($this->input->post('is_default')==''){
                $where=array('user_id' => $user_id, 'id <>' => $bank_id);
                $max_id=$this->common_model->getMaxId('tbl_bank_details',$where);

                $data_arr = array(
                    'is_default' => 1
                ); 

                $data_arr = $this->security->xss_clean($data_arr);

                $this->common_model->update($data_arr, $max_id,'tbl_bank_details');

            }

            $message = array('message' => $this->lang->line('update_success'),'success' => '1');
        }

        echo base64_encode(json_encode($message));

    }

    public function remove_bank_account(){

        $id=$this->input->post("bank_id");

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

        $message = array('message' => $this->lang->line('bank_remove'),'success' => '1');
        echo json_encode($message);
    }

    public function about_us(){

        $this->load->model('Setting_model');
        $settings_data = $this->Setting_model->get_web_details();
        $data = array();
        $data['page_title'] = 'About Us';
        $data['current_page'] = 'About Us';
        $data['about_title'] = $settings_data->about_page_title;
        $data['settings_row'] = $settings_data->about_content;
        $data['image'] = base_url()."assets/images/".$settings_data->about_image;

        $this->template->load('site/template2', 'site/pages/about_us', $data); // :blush:
    }
    
     public function our_team(){

        $this->load->model('Setting_model');

        $data = array();
        $data['page_title'] = 'Our Team';
        $data['current_page'] = 'Our Team';
        $data['teams'] = $this->common_model->selectByids(array(), 'tbl_teams');

        $this->template->load('site/template2', 'site/pages/our_team', $data); // :blush:
    }

    public function faq(){

        $this->load->model('Setting_model');

        $data = array();
        $data['page_title'] = "FAQ's";
        $data['current_page'] = "FAQ's";
        $data['faq_row'] = $this->common_model->selectByids(array('status' => '1','type' => 'faq'), 'tbl_faq');
        $this->template->load('site/template2', 'site/pages/faq', $data); // :blush:
    }

    public function cms_data($flag='terms'){

        $this->load->model('Setting_model');
        $data = array();

        if($flag == "terms"){

            $data['current_page'] = "Terms and Conditions";
            $data['page_title'] = "Terms and Conditions";
        }
        if($flag == "privacy"){

            $data['current_page'] = "Privacy Policy";
            $data['page_title'] = "Privacy Policy";
        }
        if($flag == "refund"){

            $data['current_page'] = "Refund Policy";
            $data['page_title'] = "Refund Policy";
        }
        if($flag == "cancellation"){

            $data['current_page'] = "Cancellation Policy";
            $data['page_title'] = "Cancellation Policy";
        }
        if($flag == "shipping"){

            $data['current_page'] = "Shipping Delivery";
            $data['page_title'] = "Shipping Delivery";
        }
        if($flag == "career"){

            $data['current_page'] = "Career";
            $data['page_title'] = "Career";
        }

        // $data['page_title'] = "FAQ's";
        // $data['current_page'] = "FAQ's";
        $data['faq_row'] = $this->common_model->selectByids(array('flag' => $flag), 'tbl_cms_contents');
        $this->template->load('site/template2', 'site/pages/faq', $data); // :blush:
    }

    public function payments(){

        $this->load->model('Setting_model');

        $data = array();
        $data['page_title'] = "Payment FAQ's";
        $data['current_page'] = "Payment FAQ's";
        $data['faq_row'] = $this->common_model->selectByids(array('status' => '1','type' => 'payment'), 'tbl_faq');
        $this->template->load('site/template2', 'site/pages/faq', $data); // :blush:
    }

    public function terms_of_use(){

        $this->load->model('Setting_model');

        $data = array();
        $data['page_title'] = "Terms-Of-Use";
        $data['current_page'] = "Terms-Of-Use";
        $data['faq_row'] = $this->common_model->selectByids(array('status' => '1','type' => 'terms'), 'tbl_faq');
        $this->template->load('site/template2', 'site/pages/faq', $data); // :blush:
    }

    public function privacy(){

        $this->load->model('Setting_model');

        $data = array();
        $data['page_title'] = "Privacy";
        $data['current_page'] = "Privacy";
        $data['faq_row'] = $this->common_model->selectByids(array('status' => '1','type' => 'payment'), 'tbl_faq');
        $this->template->load('site/template2', 'site/pages/faq', $data); // :blush:
    }

    public function cancellation(){

        $this->load->model('Setting_model');

        $data = array();
        $data['page_title'] = "Cancellation";
        $data['current_page'] = "Cancellation";
        $data['faq_row'] = $this->common_model->selectByids(array('status' => '1','type' => 'payment'), 'tbl_faq');
        $this->template->load('site/template2', 'site/pages/faq', $data); // :blush:
    }

    public function refund_return_policy(){

        $this->load->model('Setting_model');

        $data = array();
        $data['page_title'] = "Refund & Return Policy";
        $data['current_page'] = "Refund & Return Policy";
        $data['faq_row'] = $this->common_model->selectByids(array('status' => '1','type' => 'payment'), 'tbl_faq');
        $this->template->load('site/template2', 'site/pages/faq', $data); // :blush:
    }

    public function contact_us(){

        $this->load->model('Setting_model');

        $data = array();
        $data['page_title'] = 'Contact Us';
        $data['current_page'] = 'Contact Us';
        $data['contact_subjects'] = $this->common_model->select('tbl_contact_sub','DESC');
        $data['settings_row'] = $this->Setting_model->get_details();
        $this->template->load('site/template2', 'site/pages/contact_us', $data); // :blush:
    }
    
    
    
    public function patner_with_us(){

        // $this->load->model('Setting_model');

        $data = array();
        $data['page_title'] = 'Patner With Us';
        $data['current_page'] = 'Patner With Us';
        // $data['contact_subjects'] = $this->common_model->select('tbl_contact_sub','DESC');
        // $data['settings_row'] = $this->Setting_model->get_details();
        $this->template->load('site/template2', 'site/pages/patner_with_us', $data); // :blush:
    }

    public function contact_form(){
        
        $data_arr = array(
            'contact_name' => $this->input->post('name'),
            'contact_email' => $this->input->post('email'),
            'contact_subject' => addslashes($this->input->post('subject_id')),
            'contact_msg' => addslashes($this->input->post('message')),
            'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
        );

        $data_usr = $this->security->xss_clean($data_arr);

        $last_id = $this->common_model->insert($data_usr, 'tbl_contact_list');

        $data_arr = array_merge($data_arr, array("subject"=>$this->common_model->selectByidParam($this->input->post('subject_id'),'tbl_contact_sub','title')));;

        $admin_name=$this->common_model->selectByidsParam(array('id' => 1),'tbl_admin','username');

        $subject = $this->app_name.'-'.$this->lang->line('contact_form_lbl');

        $body = $this->load->view('admin/emails/contact_form.php',$data_arr,TRUE);
        // 
        if(send_email($this->contact_email, $admin_name, $subject, $body))
        {
           $message=array('success' => '1','msg' => $this->lang->line('contact_msg_success')); 
        }
        else{
            $message=array('success' => '0','msg' => $this->lang->line('error_data_save'));
        }

        echo json_encode($message);
    }

    public function partner_form(){
        
        $data_arr = array(
            'contact_name' => $this->input->post('name'),
            'contact_phone' => $this->input->post('phone'),
            'contact_msg' => addslashes($this->input->post('message')),
            'enquiry_for' => implode(",",$this->input->post('enquiry_for')),
            'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
        );

        $data_usr = $this->security->xss_clean($data_arr);

        $last_id = $this->common_model->insert($data_usr, 'tbl_partner_with_us_list');

        $data_arr = array_merge($data_arr, array("subject"=>$this->common_model->selectByidParam($this->input->post('subject_id'),'tbl_contact_sub','title')));;

        $admin_name=$this->common_model->selectByidsParam(array('id' => 1),'tbl_admin','username');

        $subject = $this->app_name.'-'.$this->lang->line('contact_form_lbl');

        $body = $this->load->view('admin/emails/partner_us.php',$data_arr,TRUE);
        // $this->contact_email
        if(send_email($this->contact_email, $admin_name, $subject, $body))
        {
           $message=array('success' => '1','msg' => $this->lang->line('contact_msg_success')); 
        }
        else{
            $message=array('success' => '0','msg' => $this->lang->line('error_data_save'));
        }

        echo json_encode($message);
    }


    public function convert_currency($to_currency, $from_currency, $amount){
        $req_url = 'https://api.exchangerate-api.com/v4/latest/'.$to_currency;
        $response_json = file_get_contents($req_url);

        $price=number_format($amount,2);

        if(false !== $response_json) {

            try {

            $response_object = json_decode($response_json);

            return $price = number_format(round(($amount * $response_object->rates->$from_currency), 2),2);

            }
            catch(Exception $e) {
                print_r($e);
            }

        }
    }

    private function inner_apply_coupon($coupon_id, $cart_ids = '', $cart_type = 'main_cart')
    {

        $user_id = $this->session->userdata('user_id') ? $this->session->userdata('user_id') : '0';

        if ($user_id == 0) {
            $message = array('message' => $this->lang->line('login_required_error'), 'class' => 'success');
            $this->session->set_flashdata('response_msg', $message);
            redirect('login-register', 'refresh');
        }

        if ($cart_type == 'main_cart') {
            $my_cart = $this->api_model->get_cart($user_id);
        } else {
            $my_cart = $this->api_model->get_cart($user_id, $cart_ids);
        }

        $total_amount=$you_save=$delivery_charge=0;

        if(!empty($my_cart)){
            
            // no any coupon applied
            foreach ($my_cart as $row_cart) {
                $total_amount += ($row_cart->selling_price * $row_cart->product_qty);
                $you_save += ($row_cart->you_save_amt * $row_cart->product_qty);
                $delivery_charge += $row_cart->delivery_charge;
            }

            $where=array('id' => $coupon_id);

            if($row=$this->common_model->selectByids($where,'tbl_coupon')){

                $row=$row[0];

                $where = array('user_id ' => $user_id , 'coupon_id' => $row->id);

                $count_use=count($this->common_model->selectByids($where,'tbl_order_details'));

                if($row->coupon_limit_use >= $count_use)
                {
                    if($row->coupon_per!='0')
                    {
                        // for percentage coupons

                        if($row->cart_status=='true'){

                            if($total_amount >= $row->coupon_cart_min){

                                $payable_amt=$discount=0;

                                // count discount price after coupon apply;
                                $discount = number_format((double)(($row->coupon_per / 100) * $total_amount), 2);

                                if($row->max_amt_status=='true'){

                                    if($discount > $row->coupon_max_amt){
                                        $discount=$row->coupon_max_amt;

                                        $payable_amt=number_format((double)($total_amount - $discount), 2, '.', '')+number_format((double)$delivery_charge, 2, '.', '');
                                    }
                                    else{

                                        $payable_amt=number_format((double)($total_amount - $discount), 2, '.', '')+number_format((double)$delivery_charge, 2, '.', '');
                                    }
                                }
                                else{
                                    $payable_amt=number_format((double)($total_amount - $discount), 2, '.', '')+number_format((double)$delivery_charge, 2, '.', '');
                                }

                                $response=array('success' => '1',"price" => $total_amount, "payable_amt" => strval($payable_amt),"discount" => $row->coupon_per,"discount_amt" => strval($discount));
                            }
                            else{
                                $response=array('success' => '0','msg' => $this->lang->line('insufficient_cart_amt'));
                            }
                        }
                        else{

                            $payable_amt=$discount=0;

                            // count discount price after coupon apply;
                            $discount = number_format((double)(($row->coupon_per / 100) * $total_amount), 2);

                            if($row->max_amt_status=='true')
                            {
                                if($discount > $row->coupon_max_amt){
                                    $discount=$row->coupon_max_amt;

                                    $payable_amt=number_format((double)($total_amount - $discount), 2, '.', '')+number_format((double)$delivery_charge, 2, '.', '');
                                }
                                else{
                                    $payable_amt=number_format((double)($total_amount - $discount), 2, '.', '')+number_format((double)$delivery_charge, 2, '.', '');
                                }
                            }
                            else{
                                $payable_amt=number_format((double)($total_amount - $discount), 2, '.', '')+number_format((double)$delivery_charge, 2, '.', '');
                            }

                            $response=array('success' => '1',"price" => $total_amount, "payable_amt" => strval($payable_amt),"discount" => $row->coupon_per,"discount_amt" => strval($discount));
                        }
                    }
                    else{

                        // check minimum cart value status
                        if($row->cart_status=='true'){

                            if($total_amount >= $row->coupon_cart_min){

                                // count discount price after coupon apply;
                                $discount=$row->coupon_amt;

                                $payable_amt=number_format($total_amount - $discount, 2);

                                $response=array('success' => '1', "price" => $total_amount, "payable_amt" => strval($payable_amt),"discount" => $row->coupon_per,"discount_amt" => strval($discount));
                            }
                            else{
                                $response=array('success' => '0','msg' => $this->lang->line('insufficient_cart_amt'));
                            }
                        }
                        else{

                            $payable_amt=$discount=0;

                            if($total_amount >= $row->coupon_amt)
                            {
                                $discount=number_format($row->coupon_amt, 2);

                                $payable_amt=number_format((double)($total_amount - $row->coupon_amt), 2, '.', '')+number_format((double)$delivery_charge, 2, '.', '');
                            }
                            else
                            {
                                $discount='0';
                                $payable_amt=number_format((double)($total_amount + $delivery_charge), 2);
                            }

                            $response=array('success' => '1', "price" => $total_amount, "payable_amt" => strval($payable_amt),"discount" => $row->coupon_per,"discount_amt" => strval($discount));

                        }
                    }
                }
                else{
                    $response=array('success' => '0','msg' => $this->lang->line('use_limit_over'));
                }
            }
            else{
                $response=array('success' => '0','msg' => $this->lang->line('no_coupon'));
            }
        }
        else{
            // cart is empty
            $response=array('success' => '0','msg' => $this->lang->line('empty_cart_lbl'));
        }

        return json_encode($response);
    }
}
