<?php

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'third_party/REST_Controller.php';
require APPPATH . 'third_party/Format.php';

require_once(APPPATH . 'libraries/razorpay-php/Razorpay.php'); // require razorpay files

use Razorpay\Api\Api;

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Apis extends REST_Controller
{

    private $get_param = null;

    private $app_setting=null;

    private $stripe_secret;

    private $app_logo;

    private $app_name;

    private $contact_email;

    private $order_email;

    private $api_home_limit;

    private $api_page_limit;

    public function __construct()
    {
        parent::__construct();

        $this->get_param = checkSignSalt($this->input->post('data'));

        $this->load->model('Api_model', 'api_model');
        $this->load->model('common_model');
        $this->load->model('Category_model');
        $this->load->model('Sub_Category_model');
        $this->load->model('Offers_model');
        $this->load->model('Order_model');

        $this->load->library("CompressImage");

        // load language for api
        $this->lang->load('api_messages', 'api');

        // loading required helpers
        $this->load->helper('image');
        $this->load->helper("date");

        $this->app_setting = $this->api_model->app_details();

        $android_settings = $this->api_model->android_details();

        $this->api_home_limit = $android_settings->api_home_limit;
        $this->api_page_limit = $android_settings->api_page_limit;

        $smtp_setting = $this->api_model->smtp_settings();

        $this->app_name = $this->app_setting->app_name;
        $this->contact_email = $this->app_setting->app_email;
        $this->order_email = $this->app_setting->app_order_email;

        define('APP_CURRENCY', $this->app_setting->app_currency_code);
        define('CURRENCY_CODE', $this->app_setting->app_currency_html_code);

        $this->stripe_secret = $this->app_setting->stripe_secret;
    }

    private function get_order_unique_id()
    {
        $code_feed = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyv0123456789";
        $code_length = 8;  // Set this to be your desired code length
        $final_code = "";
        $feed_length = strlen($code_feed);

        for ($i = 0; $i < $code_length; $i++) {
            $feed_selector = rand(0, $feed_length - 1);
            $final_code .= substr($code_feed, $feed_selector, 1);
        }
        return $final_code;
    }

    private function number_format_short($n, $precision = 1)
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

    public function product_rating($product_id)
    {

        $res = array();

        $where = array('product_id ' => $product_id);

        if ($row_rate = $this->common_model->selectByids($where, 'tbl_rating')) {
            foreach ($row_rate as $key => $value) {
                $rate_db[] = $value;
                $sum_rates[] = $value->rating;
            }

            $rate_times = count($rate_db);
            $sum_rates = array_sum($sum_rates);
            $rate_value = $sum_rates / $rate_times;

            $res['rate_times'] = $this->number_format_short($rate_times);
            $res['total_rate'] = strval($sum_rates);
            $res['rate_avg'] = strval(round($rate_value));
        } else {
            $res['rate_times'] = "0";
            $res['total_rate'] = "0";
            $res['rate_avg'] = "0";
        }
        return json_encode($res);
    }

    private function calculate_offer($offer_id, $mrp)
    {
        $res = array();

        if ($offer_id != 0) {
            $offer = $this->Offers_model->single_offer($offer_id);
            $res['selling_price'] = round($mrp - (($offer->offer_percentage / 100) * $mrp), 2);

            $res['you_save'] = round($mrp - $res['selling_price'], 2);
            $res['you_save_per'] = $offer->offer_percentage;
        } else {
            $res['selling_price'] = $mrp;
            $res['you_save'] = 0;
            $res['you_save_per'] = 0;
        }
        
        return json_encode($res);
    }

    private function user_total_save($user_id)
    {
        $res = array();

        $row = $this->api_model->get_cart($user_id);

        $total_amt = $delivery_charge = $you_save = 0;

        foreach ($row as $key => $value) {

            $data_ofr = $this->calculate_offer($this->get_product_info($value->product_id, 'offer_id'), $value->product_mrp * $value->product_qty);

            $arr_ofr = json_decode($data_ofr);

            $total_amt += $arr_ofr->selling_price;

            $delivery_charge += $value->delivery_charge;

            $you_save += $arr_ofr->you_save;
        }

        $res['total_item'] = strval(count($row));
        $res['price'] = strval($total_amt);
        $res['delivery_charge'] = ($delivery_charge != 0) ? $delivery_charge : $this->lang->line('free_lbl');
        $res['payable_amt'] = strval($total_amt + $delivery_charge);

        $res['you_save'] = strval($you_save);

        return json_encode($res);
    }

    private function get_banner_info($id, $param)
    {
        $this->load->model('Banner_model');
        $data = $this->Banner_model->single_banner($id);
        if (!empty($data)) {
            return $data[0]->$param;
        } else {
            return '';
        }
    }

    private function get_product_info($id, $param)
    {
        $this->load->model('Product_model');
        $data = $this->Product_model->single_product($id);
        if (!empty($data)) {
            return $data[0]->$param;
        } else {
            return '';
        }
    }

    public function get_category_info($id, $param)
    {
        $data = $this->Category_model->single_category($id);
        if (!empty($data)) {
            return $data[0]->$param;
        } else {
            return '';
        }
    }

    public function get_sub_category_info($id, $param)
    {
        $data = $this->Sub_Category_model->single($id);
        if (!empty($data)) {
            return $data[0]->$param;
        } else {
            return '';
        }
    }

    public function get_brand_info($id, $param)
    {
        $data = $this->Brand_model->single_brand($id);
        if (!empty($data)) {
            return $data[0]->$param;
        } else {
            return '';
        }
    }

    public function home_post()
    {
        if(isset($this->get_param['user_id'])){
            $user_id = $this->get_param['user_id'];   // default 0
        }
        else{
            $user_id = 0;
        }

        $response = array();
        $data_arr = array();

        if($this->app_setting->app_home_slider_opt=='true')
        {

            $row = $this->api_model->banner_list($this->api_home_limit, 0);

            foreach ($row as $key => $value) {

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->banner_image);

                $data_arr['id'] = $value->id;
                $data_arr['banner_title'] = $value->banner_title;
                $data_arr['banner_image'] = base_url() . $this->_create_thumbnail('assets/images/banner/',$thumb_img_nm,$value->banner_image,600,250);
                array_push($response, $data_arr);
            }
        }

        $row_info['banners'] = $response;

        $response = array();
        $data_arr = array();

        $row_ord = $this->api_model->get_my_orders($user_id, '', '', true);

        $show_orders=3;
        $nos=1;

        if (count($row_ord) > 0) {

            foreach ($row_ord as $key => $value) {

                $where = array('order_id' => $value->id);

                $row_items = $this->common_model->selectByids($where, 'tbl_order_items');

                if (count($row_items) > 0) {
                    foreach ($row_items as $key2 => $value2) {

                        if($nos > $show_orders){
                            break;
                        }

                        if($value2->pro_order_status == 5){
                            continue;
                        }

                        $nos++;

                        $data_arr['order_id'] = $value->id;
                        $data_arr['order_unique_id'] = $value->order_unique_id;

                        $data_arr['product_id'] = $value2->product_id;
                        $data_arr['product_title'] = $value2->product_title;

                        $data_arr['product_image'] = base_url() . 'assets/images/products/' . $this->get_product_info($value2->product_id, 'featured_image');

                        $data_arr['order_status'] = $this->common_model->selectByidParam($value2->pro_order_status, 'tbl_status_title', 'title');

                        $data_arr['current_order_status'] = ($value2->pro_order_status < 5) ? 'true' : 'false';

                        array_push($response, $data_arr);
                    }
                }
            }
        }

        $row_info['my_order'] = $response;

        $response = array();
        $data_arr = array();

        if($this->app_setting->app_home_brand_opt=='true')
        {

            $row = $this->api_model->brand_list($this->api_home_limit, 0);

            foreach ($row as $key => $value) {

                $data_arr['id'] = $value->id;
                $data_arr['brand_name'] = $value->brand_name;

                if ($value->brand_image != '') {
                    $data_arr['brand_image'] = base_url() . 'assets/images/brand/' . $value->brand_image;

                    $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->brand_image);

                    $data_arr['brand_image_thumb'] = base_url() . $this->_create_thumbnail('assets/images/brand/', $thumb_img_nm, $value->brand_image, 140, 80);
                } else {
                    $data_arr['brand_image'] = '';

                    $data_arr['brand_image_thumb'] = '';
                }


                array_push($response, $data_arr);
            }
        }

        $row_info['brands'] = $response;

        $response = array();
        $data_arr = array();

        if($this->app_setting->app_home_category_opt=='true')
        {
            $row = $this->api_model->category_list($this->api_home_limit, 0);

            $no = 1;

            foreach ($row as $key => $value) {

                $data_arr['id'] = $value->id;
                $data_arr['category_name'] = $value->category_name;

                $data_arr['category_image'] = base_url() . 'assets/images/category/' . $value->category_image;

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->category_image);

                $data_arr['category_image_thumb'] = base_url() . $this->_create_thumbnail('assets/images/category/', $thumb_img_nm, $value->category_image, 140, 80);

                $count_sub = count($this->Sub_Category_model->get_subcategories($value->id));

                if ($count_sub > 0) {
                    $data_arr['sub_cat_status'] = 'true';
                } else {
                    $data_arr['sub_cat_status'] = 'false';
                }

                array_push($response, $data_arr);
            }
        }

        $row_info['categories'] = $response;

        $response = array();
        $data_arr = array();

        if($this->app_setting->app_home_flase_opt=='true')
        {

            $row = $this->api_model->products_filter('today_deal','',$this->api_home_limit, 0);

            // for today deals
            foreach ($row as $key => $value) {

                $data_rate = $this->product_rating($value->product_id);

                $arr_rate = json_decode($data_rate);

                $data_arr['id'] = $value->product_id;

                $data_arr['category_id'] = $value->category_id;
                $data_arr['sub_category_id'] = $value->sub_category_id;
                $data_arr['brand_id'] = $value->brand_id;
                $data_arr['offer_id'] = $value->offer_id;

                $data_arr['product_title'] = $value->product_title;
                $data_arr['product_desc'] = stripslashes($value->product_desc);

                $data_arr['product_image'] = base_url() . 'assets/images/products/' . $value->featured_image;

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->featured_image);

                $data_arr['product_image_portrait'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 300);

                $data_arr['product_mrp'] = number_format($value->product_mrp,2);
                $data_arr['product_sell_price'] = number_format($value->selling_price,2);
                $data_arr['you_save'] = number_format($value->you_save_amt,2);
                $data_arr['you_save_per'] = $value->you_save_per . ' ' . $this->lang->line('per_off_lbl');

                $data_arr['product_status'] = $value->status;
                $data_arr['product_status_lbl'] = $this->lang->line('unavailable_lbl');

                $data_arr['total_views'] = $value->total_views;
                $data_arr['total_rate'] = $arr_rate->rate_times;
                $data_arr['rate_avg'] = $arr_rate->rate_avg;

                $data_arr['category_name'] = $value->category_name;
                $data_arr['sub_category_name'] = $this->get_sub_category_info($value->sub_category_id, 'sub_category_name');

                array_push($response, $data_arr);
            }
        }

        $row_info['todays_deals'] = $response;

        $response = array();
        $data_arr = array();

        if($this->app_setting->app_home_offer_opt=='true')
        {

            $row = $this->api_model->offers_list($this->api_home_limit, 0);

            foreach ($row as $key => $value) {

                $data_arr['id'] = $value->id;
                $data_arr['offer_title'] = $value->offer_title;
                $data_arr['offer_image'] = base_url() . 'assets/images/offers/' . $value->offer_image;

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->offer_image);

                $data_arr['offer_image_thumb'] = base_url() . $this->_create_thumbnail('assets/images/offers/', $thumb_img_nm, $value->offer_image, 370, 210);
                array_push($response, $data_arr);
            }
        }

        $row_info['offers'] = $response;

        $response = array();
        $data_arr = array();

        if($this->app_setting->app_home_latest_opt=='true')
        {
            $row = $this->api_model->products_filter('latest_products','',$this->api_home_limit, 0,'','','','','','',$user_id);

            // for latest products
            foreach ($row as $key => $value) {

                $data_rate = $this->product_rating($value->product_id);

                $arr_rate = json_decode($data_rate);

                $data_arr['id'] = $value->product_id;

                $data_arr['category_id'] = $value->category_id;
                $data_arr['sub_category_id'] = $value->sub_category_id;
                $data_arr['brand_id'] = $value->brand_id;
                $data_arr['offer_id'] = $value->offer_id;

                $data_arr['product_title'] = $value->product_title;
                $data_arr['product_desc'] = stripslashes($value->product_desc);

                $data_arr['product_image'] = base_url() . 'assets/images/products/' . $value->featured_image;

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->featured_image);

                $data_arr['product_image_portrait'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 300);

                $data_arr['product_mrp'] = number_format($value->product_mrp,2);
                $data_arr['product_sell_price'] = number_format($value->selling_price,2);
                $data_arr['you_save'] = number_format($value->you_save_amt,2);
                $data_arr['you_save_per'] = $value->you_save_per . ' ' . $this->lang->line('per_off_lbl');

                $data_arr['product_status'] = $value->status;
                $data_arr['product_status_lbl'] = $this->lang->line('unavailable_lbl');

                $data_arr['total_views'] = $value->total_views;
                $data_arr['total_rate'] = $arr_rate->rate_times;
                $data_arr['rate_avg'] = $arr_rate->rate_avg;

                $data_arr['category_name'] = $this->common_model->selectByidParam($value->category_id, 'tbl_category', 'category_name');
                $data_arr['sub_category_name'] = $this->get_sub_category_info($value->sub_category_id, 'sub_category_name');

                array_push($response, $data_arr);
            }
        }

        $row_info['latest_products'] = $response;

        $response = array();
        $data_arr = array();

        if($this->app_setting->app_home_top_rated_opt=='true')
        {
            $row = $this->api_model->products_filter('top_rated_products','',$this->api_home_limit, 0,'','','','','','',$user_id);

            // for top rated products
            foreach ($row as $key => $value) {

                $data_rate = $this->product_rating($value->product_id);

                $arr_rate = json_decode($data_rate);

                $data_arr['id'] = $value->product_id;

                $data_arr['category_id'] = $value->category_id;
                $data_arr['sub_category_id'] = $value->sub_category_id;
                $data_arr['brand_id'] = $value->brand_id;
                $data_arr['offer_id'] = $value->offer_id;

                $data_arr['product_title'] = $value->product_title;
                $data_arr['product_desc'] = stripslashes($value->product_desc);

                $data_arr['product_image'] = base_url() . 'assets/images/products/' . $value->featured_image;

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->featured_image);

                $data_arr['product_image_portrait'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 300);

                $data_arr['product_mrp'] = number_format($value->product_mrp,2);
                $data_arr['product_sell_price'] = number_format($value->selling_price,2);
                $data_arr['you_save'] = number_format($value->you_save_amt,2);
                $data_arr['you_save_per'] = $value->you_save_per . ' ' . $this->lang->line('per_off_lbl');

                $data_arr['product_status'] = $value->status;
                $data_arr['product_status_lbl'] = $this->lang->line('unavailable_lbl');

                $data_arr['total_views'] = $value->total_views;
                $data_arr['total_rate'] = $arr_rate->rate_times;
                $data_arr['rate_avg'] = $arr_rate->rate_avg;

                $data_arr['category_name'] = $this->common_model->selectByidParam($value->category_id, 'tbl_category', 'category_name');
                $data_arr['sub_category_name'] = $this->get_sub_category_info($value->sub_category_id, 'sub_category_name');

                array_push($response, $data_arr);
            }
        }

        $row_info['top_rated_products'] = $response;

        $response = array();
        $data_arr = array();

        if($this->app_setting->app_home_recent_opt=='true')
        {

            $row = $this->api_model->products_filter('recent_viewed_products','',$this->api_home_limit, 0,'','','','','','',$user_id);

            // for recent viewed
            foreach ($row as $key => $value) {

                $data_rate = $this->product_rating($value->product_id);

                $arr_rate = json_decode($data_rate);

                $data_arr['id'] = $value->product_id;

                $data_arr['category_id'] = $value->category_id;
                $data_arr['sub_category_id'] = $value->sub_category_id;
                $data_arr['brand_id'] = $value->brand_id;
                $data_arr['offer_id'] = $value->offer_id;

                $data_arr['product_title'] = $value->product_title;
                $data_arr['product_desc'] = stripslashes($value->product_desc);

                $data_arr['product_image'] = base_url() . 'assets/images/products/' . $value->featured_image;

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->featured_image);

                $data_arr['product_image_portrait'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 300);

                $data_arr['product_mrp'] = number_format($value->product_mrp,2);
                $data_arr['product_sell_price'] = number_format($value->selling_price,2);
                $data_arr['you_save'] = number_format($value->you_save_amt,2);
                $data_arr['you_save_per'] = $value->you_save_per . ' ' . $this->lang->line('per_off_lbl');

                $data_arr['product_status'] = $value->status;
                $data_arr['product_status_lbl'] = $this->lang->line('unavailable_lbl');

                $data_arr['total_views'] = $value->total_views;
                $data_arr['total_rate'] = $arr_rate->rate_times;
                $data_arr['rate_avg'] = $arr_rate->rate_avg;

                $data_arr['category_name'] = $this->common_model->selectByidParam($value->category_id, 'tbl_category', 'category_name');
                $data_arr['sub_category_name'] = $this->get_sub_category_info($value->sub_category_id, 'sub_category_name');

                array_push($response, $data_arr);
            }
        }

        $row_info['recent_view'] = $response;

        $response = array();
        $data_arr = array();

        if($this->app_setting->app_home_cat_wise_opt=='true')
        {

            $row = $this->common_model->selectByids(array('set_on_home' => '1','status' => '1'),'tbl_category','category_name','ASC');

            $home_category=array();

            $response=array();

            foreach ($row as $key => $value) {

                $home_category['id']=$value->id;
                $home_category['title']=$value->category_name;

                $row_products = $this->api_model->products_filter('productList_cat', $value->id, $this->api_home_limit, 0);

                $home_category['products']=array();

                foreach ($row_products as $key2 => $value2) {

                    // $home_category['products']=array();

                    $data_rate = $this->product_rating($value2->product_id);

                    $arr_rate = json_decode($data_rate);

                    $data_arr['id'] = $value2->product_id;

                    $data_arr['category_id'] = $value2->category_id;
                    $data_arr['sub_category_id'] = $value2->sub_category_id;
                    $data_arr['brand_id'] = $value2->brand_id;
                    $data_arr['offer_id'] = $value2->offer_id;

                    $data_arr['product_title'] = $value2->product_title;
                    $data_arr['product_desc'] = stripslashes($value2->product_desc);

                    $data_arr['product_image'] = base_url() . 'assets/images/products/' . $value2->featured_image;

                    $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value2->featured_image);

                    $data_arr['product_image_portrait'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value2->featured_image, 250, 300);

                    $data_arr['product_mrp'] = number_format($value2->product_mrp,2);
                    $data_arr['product_sell_price'] = number_format($value2->selling_price,2);
                    $data_arr['you_save'] = number_format($value2->you_save_amt,2);
                    $data_arr['you_save_per'] = $value2->you_save_per . ' ' . $this->lang->line('per_off_lbl');

                    $data_arr['product_status'] = $value2->status;
                    $data_arr['product_status_lbl'] = $this->lang->line('unavailable_lbl');

                    $data_arr['total_views'] = $value2->total_views;
                    $data_arr['total_rate'] = $arr_rate->rate_times;
                    $data_arr['rate_avg'] = $arr_rate->rate_avg;

                    $data_arr['category_name'] = $this->common_model->selectByidParam($value2->category_id, 'tbl_category', 'category_name');
                    $data_arr['sub_category_name'] = $this->get_sub_category_info($value2->sub_category_id, 'sub_category_name');

                    $home_category['products'][]=$data_arr;
                }

                array_push($response, $home_category);
            }
        }

        $row_info['home_category'] = $response;

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // for category list
    public function categories_post()
    {

        $response = array();

        if(isset($this->get_param['page'])) {
            $start = ($this->get_param['page'] - 1) * $this->api_page_limit;
        } else {
            $start = 0;
        }

        $row = $this->api_model->category_list($this->api_page_limit, $start);

        foreach ($row as $key => $value) {

            $data_arr['id'] = $value->id;
            $data_arr['category_name'] = $value->category_name;
            $data_arr['category_image'] = base_url() . 'assets/images/category/' . $value->category_image;

            $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->category_image);

            $data_arr['category_image_thumb'] = base_url() . $this->_create_thumbnail('assets/images/category/', $thumb_img_nm, $value->category_image, 200, 120);

            $count_sub = count($this->Sub_Category_model->get_subcategories($value->id));

            if ($count_sub > 0) {
                $data_arr['sub_cat_status'] = 'true';
            } else {
                $data_arr['sub_cat_status'] = 'false';
            }

            array_push($response, $data_arr);
        }
        $row_info['ECOMMERCE_APP'] = $response;

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // for sub category list
    public function sub_categories_post()
    {
        $response = array();

        $cat_id = $this->get_param['cat_id'];

        if(isset($this->get_param['page'])) {
            $start = ($this->get_param['page'] - 1) * $this->api_page_limit;
        } else {
            $start = 0;
        }

        $row = $this->api_model->sub_category_list($cat_id, $this->api_page_limit, $start);

        foreach ($row as $key => $value) {
            $data_arr['id'] = $value->id;

            $data_arr['sub_category_name'] = $value->sub_category_name;
            $data_arr['sub_category_image'] = base_url() . 'assets/images/sub_category/' . $value->sub_category_image;

            $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->sub_category_image);

            $data_arr['sub_category_image_thumb'] = base_url() . $this->_create_thumbnail('assets/images/sub_category/', $thumb_img_nm, $value->sub_category_image, 200, 120);

            $data_arr['category_id'] = $value->category_id;
            $data_arr['category_name'] = $value->category_name;

            array_push($response, $data_arr);
        }

        $row_info['ECOMMERCE_APP'] = $response;

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // for product list by category and sub category
    public function productList_cat_sub_post()
    {

        $response = array();

        if(isset($this->get_param['page'])) {
            $start = ($this->get_param['page'] - 1) * $this->api_page_limit;
        } else {
            $start = 0;
        }

        if($this->get_param['sub_cat_id']!=0){
            $sub_cat_id = $this->get_param['sub_cat_id'];

            $row_info['total_products'] = count($this->api_model->products_filter('productList_cat_sub', $sub_cat_id));

            $row = $this->api_model->products_filter('productList_cat_sub', $sub_cat_id, $this->api_page_limit, $start);

            foreach ($row as $key => $value) {

                // for rating
                $data_rate = $this->product_rating($value->product_id);

                $arr_rate = json_decode($data_rate);

                $data_arr['id'] = $value->product_id;

                $data_arr['category_id'] = $value->category_id;
                $data_arr['sub_category_id'] = $value->sub_category_id;
                $data_arr['brand_id'] = $value->brand_id;
                $data_arr['offer_id'] = $value->offer_id;

                $data_arr['product_title'] = $value->product_title;
                $data_arr['product_desc'] = stripslashes($value->product_desc);

                $data_arr['product_image'] = base_url() . 'assets/images/products/' . $value->featured_image;

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->featured_image);

                $data_arr['product_image_square'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 250);

                $data_arr['product_image_portrait'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 300);

                $data_arr['product_mrp'] = number_format($value->product_mrp,2);
                $data_arr['product_sell_price'] = number_format($value->selling_price,2);
                $data_arr['you_save'] = number_format($value->you_save_amt,2);
                $data_arr['you_save_per'] = $value->you_save_per . ' ' . $this->lang->line('per_off_lbl');

                $data_arr['product_status'] = $value->status;
                $data_arr['product_status_lbl'] = $this->lang->line('unavailable_lbl');

                $data_arr['total_views'] = $value->total_views;
                $data_arr['total_rate'] = $arr_rate->rate_times;
                $data_arr['rate_avg'] = $arr_rate->rate_avg;

                $data_arr['category_name'] = $value->category_name;
                $data_arr['sub_category_name'] = $this->get_sub_category_info($value->sub_category_id, 'sub_category_name');

                array_push($response, $data_arr);
            }
        }
        else{

            // only category wise products

            $cat_id = $this->get_param['cat_id'];

            $row_info['total_products'] = count($this->api_model->products_filter('productList_cat', $cat_id));

            $row = $this->api_model->products_filter('productList_cat', $cat_id, $this->api_page_limit, $start);

            foreach ($row as $key => $value) {

                // for rating
                $data_rate = $this->product_rating($value->product_id);

                $arr_rate = json_decode($data_rate);

                $data_arr['id'] = $value->product_id;

                $data_arr['category_id'] = $value->category_id;
                $data_arr['sub_category_id'] = $value->sub_category_id;
                $data_arr['brand_id'] = $value->brand_id;
                $data_arr['offer_id'] = $value->offer_id;

                $data_arr['product_title'] = $value->product_title;
                $data_arr['product_desc'] = stripslashes($value->product_desc);

                $data_arr['product_image'] = base_url() . 'assets/images/products/' . $value->featured_image;

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->featured_image);

                $data_arr['product_image_square'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 250);

                $data_arr['product_image_portrait'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 300);

                $data_arr['product_mrp'] = number_format($value->product_mrp,2);
                $data_arr['product_sell_price'] = number_format($value->selling_price,2);
                $data_arr['you_save'] = number_format($value->you_save_amt,2);
                $data_arr['you_save_per'] = $value->you_save_per . ' ' . $this->lang->line('per_off_lbl');

                $data_arr['product_status'] = $value->status;
                $data_arr['product_status_lbl'] = $this->lang->line('unavailable_lbl');

                $data_arr['total_views'] = $value->total_views;
                $data_arr['total_rate'] = $arr_rate->rate_times;
                $data_arr['rate_avg'] = $arr_rate->rate_avg;

                $data_arr['category_name'] = $value->category_name;
                $data_arr['sub_category_name'] = $this->get_sub_category_info($value->sub_category_id, 'sub_category_name');

                array_push($response, $data_arr);
            }

        }
        
        $row_info['ECOMMERCE_APP'] = $response;

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // banner wise products
    public function products_by_banner_post()
    {
        $response = array();

        if(isset($this->get_param['banner_id']) AND $this->get_param['banner_id']!=''){

            if(isset($this->get_param['page'])) {
                $start = ($this->get_param['page'] - 1) * $this->api_page_limit;
            } else {
                $start = 0;
            }

            $banner_id = $this->get_param['banner_id'];

            $row_info['total_products'] = count($this->api_model->products_filter('banner', $banner_id));

            $row = $this->api_model->products_filter('banner', $banner_id, $this->api_page_limit, $start);

            foreach ($row as $key => $value) {

                // for rating
                $data_rate = $this->product_rating($value->product_id);

                $arr_rate = json_decode($data_rate);

                $data_arr['id'] = $value->product_id;
                $data_arr['category_id'] = $value->category_id;
                $data_arr['sub_category_id'] = $value->sub_category_id;
                $data_arr['brand_id'] = $value->brand_id;
                $data_arr['offer_id'] = $value->offer_id;

                $data_arr['product_title'] = $value->product_title;
                $data_arr['product_desc'] = stripslashes($value->product_desc);

                $data_arr['product_image'] = base_url() . 'assets/images/products/' . $value->featured_image;

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->featured_image);

                $data_arr['product_image_square'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 250);

                $data_arr['product_image_portrait'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 300);

                $data_arr['product_mrp'] = number_format($value->product_mrp,2);
                $data_arr['product_sell_price'] = number_format($value->selling_price,2);
                $data_arr['you_save'] = number_format($value->you_save_amt,2);
                $data_arr['you_save_per'] = $value->you_save_per . ' ' . $this->lang->line('per_off_lbl');

                $data_arr['product_status'] = $value->status;
                $data_arr['product_status_lbl'] = $this->lang->line('unavailable_lbl');

                $data_arr['total_views'] = $value->total_views;
                $data_arr['total_rate'] = $arr_rate->total_rate;
                $data_arr['nos_user_rate'] = $arr_rate->rate_times;
                $data_arr['rate_avg'] = $arr_rate->rate_avg;

                $data_arr['banner_title'] = $this->get_banner_info($banner_id, "banner_title");

                array_push($response, $data_arr);
            }
            $row_info['ECOMMERCE_APP'] = $response;
        }
        else{
            $row_info['total_products']=0;
            $row_info['ECOMMERCE_APP'] = $response;
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // brand wise products
    public function products_by_brand_post()
    {
        $response = array();

        if(isset($this->get_param['brand_id']) AND $this->get_param['brand_id']!=''){
            $brand_id = $this->get_param['brand_id'];

            if(isset($this->get_param['page'])) {
                $start = ($this->get_param['page'] - 1) * $this->api_page_limit;
            } else {
                $start = 0;
            }

            $row_info['total_products'] = count($this->api_model->products_filter('brand', $brand_id));

            $row = $this->api_model->products_filter('brand', $brand_id, $this->api_page_limit, $start);

            foreach ($row as $key => $value){

                // for rating
                $data_rate = $this->product_rating($value->product_id);

                $arr_rate = json_decode($data_rate);

                $data_arr['id'] = $value->product_id;
                $data_arr['category_id'] = $value->category_id;
                $data_arr['sub_category_id'] = $value->sub_category_id;
                $data_arr['brand_id'] = $value->brand_id;
                $data_arr['offer_id'] = $value->offer_id;

                $data_arr['product_title'] = $value->product_title;
                $data_arr['product_desc'] = stripslashes($value->product_desc);

                $data_arr['product_image'] = base_url() . 'assets/images/products/' . $value->featured_image;

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->featured_image);

                $data_arr['product_image_square'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 250);

                $data_arr['product_image_portrait'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 300);

                $data_arr['product_mrp'] = number_format($value->product_mrp,2);
                $data_arr['product_sell_price'] = number_format($value->selling_price,2);
                $data_arr['you_save'] = number_format($value->you_save_amt,2);
                $data_arr['you_save_per'] = $value->you_save_per . ' ' . $this->lang->line('per_off_lbl');

                $data_arr['product_status'] = $value->status;
                $data_arr['product_status_lbl'] = $this->lang->line('unavailable_lbl');

                $data_arr['total_views'] = $value->total_views;
                $data_arr['total_rate'] = $arr_rate->total_rate;
                $data_arr['nos_user_rate'] = $arr_rate->rate_times;
                $data_arr['rate_avg'] = $arr_rate->rate_avg;

                $data_arr['brand_name'] = $value->brand_name;

                array_push($response, $data_arr);
            }
            $row_info['ECOMMERCE_APP'] = $response;
        }
        else{
            $row_info['total_products']=0;
            $row_info['ECOMMERCE_APP'] = $response;
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // offer wise products
    public function products_by_offer_post()
    {

        $response = array();

        if(isset($this->get_param['offer_id']) && $this->get_param['offer_id']!=''){

            $offer_id = $this->get_param['offer_id'];

            if(isset($this->get_param['page'])) {
                $start = ($this->get_param['page'] - 1) * $this->api_page_limit;
            } else {
                $start = 0;
            }

            $row_info['total_products'] = count($this->api_model->products_filter('offer',$offer_id));

            $row = $this->api_model->products_filter('offer',$offer_id, $this->api_page_limit, $start);

            foreach ($row as $key => $value) {

                // for rating
                $data_rate = $this->product_rating($value->product_id);

                $arr_rate = json_decode($data_rate);

                $data_arr['id'] = $value->product_id;
                $data_arr['category_id'] = $value->category_id;
                $data_arr['sub_category_id'] = $value->sub_category_id;
                $data_arr['brand_id'] = $value->brand_id;
                $data_arr['offer_id'] = $value->offer_id;

                $data_arr['product_title'] = $value->product_title;
                $data_arr['product_desc'] = stripslashes($value->product_desc);

                $data_arr['product_image'] = base_url() . 'assets/images/products/' . $value->featured_image;

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->featured_image);

                $data_arr['product_image_square'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 250);

                $data_arr['product_image_portrait'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 300);

                $data_arr['product_mrp'] = number_format($value->product_mrp,2);
                $data_arr['product_sell_price'] = number_format($value->selling_price,2);
                $data_arr['you_save'] = number_format($value->you_save_amt,2);
                $data_arr['you_save_per'] = $value->you_save_per . ' ' . $this->lang->line('per_off_lbl');

                $data_arr['product_status'] = $value->status;
                $data_arr['product_status_lbl'] = $this->lang->line('unavailable_lbl');

                $data_arr['total_views'] = $value->total_views;
                $data_arr['total_rate'] = $arr_rate->total_rate;
                $data_arr['nos_user_rate'] = $arr_rate->rate_times;
                $data_arr['rate_avg'] = $arr_rate->rate_avg;

                $data_arr['offer_title'] = $this->common_model->selectByidParam($value->offer_id, 'tbl_offers', 'offer_title');

                array_push($response, $data_arr);
            }
            $row_info['ECOMMERCE_APP'] = $response;
        }
        else{
            $row_info['total_products'] = 0;
            $row_info['ECOMMERCE_APP'] = $response;
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    public function single_product_post()
    {

        $this->load->model('product_model');

        $response = array();

        $id = $this->get_param['id'];

        $data_rate = $this->product_rating($id);

        $arr_rate = json_decode($data_rate);

        if ($row = $this->product_model->single_product($id)) {

            $row_info['success'] = '1';
            $row_info['msg'] = '';

            foreach ($row as $key => $value) {

                $row_info['share_link'] = base_url() . 'product/' . $value->product_slug;

                $row_info['id'] = $value->id;

                $row_info['category_id'] = $value->category_id;
                $row_info['sub_category_id'] = $value->sub_category_id;
                $row_info['brand_id'] = $value->brand_id;
                $row_info['offer_id'] = $value->offer_id;

                $row_info['product_title'] = $value->product_title;
                $row_info['product_desc'] = stripslashes($value->product_desc);
                $row_info['product_features'] = stripslashes($value->product_features);

                $row_info['product_image'] = base_url() . 'assets/images/products/' . $value->featured_image;

                if($value->size_chart!='')
                {
                    $row_info['size_chart'] = base_url() . 'assets/images/products/' . $value->size_chart;
                }
                else{
                    $row_info['size_chart'] = '';
                }

                $row_info['product_mrp'] = number_format($value->product_mrp,2);
                $row_info['product_sell_price'] = number_format($value->selling_price,2);
                $row_info['you_save'] = number_format($value->you_save_amt,2);
                $row_info['you_save_per'] = $value->you_save_per . ' ' . $this->lang->line('per_off_lbl');

                $row_info['product_status'] = $value->status;
                $row_info['product_status_lbl'] = $this->lang->line('unavailable_lbl');

                if ($value->color != '') {

                    $color_arr = explode('/', $value->color);
                    $color_name = $color_arr[0];
                    $color_code = $color_arr[1];

                    $row_info['is_color'] = true;
                    $row_info['color_id'] = $value->id;
                    $row_info['color_code'] = '#' . $color_code;

                    $data_arr1['color_id'] = $value->id;
                    $data_arr1['color_code'] = '#' . $color_code;

                    if ($value->other_color_product != '') {
                        $arr_color = explode(',', $value->other_color_product);


                        $row_info['color_arr'][] = $data_arr1;

                        foreach ($arr_color as $key => $val) {
                            $data_arr1['color_id'] = $val;
                            $clr_arr = explode('/', $this->get_product_info($val, 'color'));
                            $clr_name = $clr_arr[0];
                            $clr_code = $clr_arr[1];

                            $data_arr1['color_code'] = '#' . $clr_code;

                            $row_info['color_arr'][] = $data_arr1;
                        }
                    } else {
                        $row_info['color_arr'][] = $data_arr1;
                    }
                } else {
                    $row_info['is_color'] = false;
                    $row_info['id'] = '';
                    $row_info['color_code'] = '';
                    $row_info['color_arr'] = array();
                }

                if ($value->product_size != '') {
                    $row_info['is_size'] = true;

                    if ($value->product_size != '') {
                        $arr_size = explode(',', $value->product_size);
                        foreach ($arr_size as $key => $val) {
                            $data_arr2['product_size'] = trim($val);

                            $row_info['product_sizes'][] = $data_arr2;
                        }
                    } else {
                        $row_info['product_sizes'] = array();
                    }
                } else {
                    $row_info['is_size'] = false;
                    $row_info['product_size'] = "";
                    $row_info['product_sizes'] = array();
                }

                $row_info['total_views'] = $value->total_views;
                $row_info['total_rate'] = $arr_rate->rate_times;
                $row_info['rate_avg'] = $arr_rate->rate_avg;

                $row_info['category_name'] = $value->category_name;
                $row_info['sub_category_name'] = $this->get_sub_category_info($value->sub_category_id, 'sub_category_name');

                if ($row_img = $this->product_model->get_gallery($id)) {

                    $row_info['product_images'][] = array('id' => '0', 'product_image' => base_url() . 'assets/images/products/' . $value->featured_image, 'product_image_thumb' => base_url() . 'assets/images/products/' . $value->featured_image);

                    foreach ($row_img as $key_img => $value_img) {

                        $data_arr_img['id'] = $value_img->id;
                        $data_arr_img['product_image'] = base_url() . 'assets/images/products/gallery/' . $value_img->image_file;
                        $data_arr_img['product_image_thumb'] = base_url() . 'assets/images/products/gallery/' . $value_img->image_file;

                        $row_info['product_images'][] = $data_arr_img;
                    }
                } else {
                    $row_info['product_images'] = array();
                }

                $response2 = array();

                $where = array('product_id ' => $value->id);

                $row_rate = $this->common_model->selectByids($where, 'tbl_rating');

                $rate_list_limit = 2;
                $no = 0;

                foreach ($row_rate as $key => $value2) {

                    if ($no != $rate_list_limit) {
                        $data_arr3['id'] = $value2->id;
                        $data_arr3['user_name'] = $this->common_model->selectByidParam($value2->user_id, 'tbl_users', 'user_name');

                        $user_img = $this->common_model->selectByidParam($value2->user_id, 'tbl_users', 'user_image');

                        if ($user_img == '' or !file_exists('assets/images/users/' . $user_img)) {
                            $user_img = base_url('assets/images/photo.jpg');
                        } else {

                            $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $user_img);

                            $user_img = base_url() . $this->_create_thumbnail('assets/images/users/', $thumb_img_nm, $user_img, 200, 200);
                        }
                        
                        $data_arr3['user_image'] = $user_img;

                        $data_arr3['user_rate'] = $value2->rating;
                        $data_arr3['rate_desc'] = $value2->rating_desc;
                        $data_arr3['rate_date'] = date('M jS, Y', $value2->created_at);

                        $where = array('parent_id' => $value2->id, 'type' => 'review');

                        $img_arr = array();

                        if ($row_img = $this->common_model->selectByids($where, 'tbl_product_images')) {
                            foreach ($row_img as $key2 => $value3) {

                                $data_arr4['id'] = $value3->id;
                                $data_arr4['image'] = base_url() . 'assets/images/review_images/' . $value3->image_file;;

                                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value3->image_file);

                                $review_img_file = $this->_create_thumbnail('assets/images/review_images/', $thumb_img_nm, $value3->image_file, 200, 200);

                                $data_arr4['image_path_thumb'] = base_url() . $review_img_file;

                                array_push($img_arr, $data_arr4);
                            }
                        }

                        $data_arr3['reviews_images'] = $img_arr;

                        array_push($response2, $data_arr3);

                        $no++;
                    } else {
                        break;
                    }
                }

                $row_info['reviews'] = $response2;

                $response3=array();
                $data_arr=array();

                $where = array('product_id <>' => $value->id);

                $where=array('category_id' => $value->category_id, 'sub_category_id' => $value->sub_category_id, 'id !=' => $value->id);

                $related_products = $this->common_model->selectByids($where, 'tbl_product');

                foreach ($related_products as $key => $value3) {

                    $data_rate = $this->product_rating($value3->id);

                    $arr_rate = json_decode($data_rate);

                    $data_arr['id'] = $value3->id;

                    $data_arr['category_id'] = $value3->category_id;
                    $data_arr['sub_category_id'] = $value3->sub_category_id;
                    $data_arr['brand_id'] = $value3->brand_id;
                    $data_arr['offer_id'] = $value3->offer_id;

                    $data_arr['product_title'] = $value3->product_title;
                    $data_arr['product_desc'] = stripslashes($value3->product_desc);

                    $data_arr['product_image'] = base_url() . 'assets/images/products/' . $value3->featured_image;

                    $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value3->featured_image);

                    $data_arr['product_image_square'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value3->featured_image, 250, 250);

                    $data_arr['product_image_portrait'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value3->featured_image, 250, 300);

                    $data_arr['product_mrp'] = number_format($value3->product_mrp,2);
                    $data_arr['product_sell_price'] = number_format($value3->selling_price,2);
                    $data_arr['you_save'] = number_format($value3->you_save_amt,2);
                    $data_arr['you_save_per'] = $value3->you_save_per . ' ' . $this->lang->line('per_off_lbl');

                    $data_arr['product_status'] = $value3->status;
                    $data_arr['product_status_lbl'] = $this->lang->line('unavailable_lbl');

                    $data_arr['total_views'] = $value3->total_views;
                    $data_arr['total_rate'] = $arr_rate->rate_times;
                    $data_arr['rate_avg'] = $arr_rate->rate_avg;

                    $data_arr['category_name'] = $this->get_category_info($value3->category_id, 'category_name');
                    $data_arr['sub_category_name'] = $this->get_sub_category_info($value3->sub_category_id, 'sub_category_name');

                    array_push($response3, $data_arr);
                }

                $row_info['related_products'] = $response3;
            }

            if($this->get_param['user_id']!=0)
            {
                $this->product_model->_set_view($id);

                $data_recent = $this->common_model->selectByids(array('user_id' => $this->get_param['user_id'], 'product_id' => $id), 'tbl_recent_viewed');

                if (empty($data_recent)) {
                    // insert product in recent

                    $data_arr = array(
                        'user_id' => $this->get_param['user_id'],
                        'product_id' => $id,
                        'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
                    );

                    $data_ord = $this->security->xss_clean($data_arr);

                    $order_id = $this->common_model->insert($data_ord, 'tbl_recent_viewed');
                }
                else{

                    $data_arr = array(
                        'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
                    );

                    $data_arr = $this->security->xss_clean($data_arr);

                    $where = array('product_id ' => $id, 'user_id' => $this->get_param['user_id']);

                    $updated_id = $this->common_model->updateByids($data_arr, $where, 'tbl_recent_viewed');
                }
            }
        } else {

            $row_info['success'] = '0';
            $row_info['msg'] = $this->lang->line('no_data');

            $res_info = array();
        }

        if (!empty($row)) {
            if ($this->get_param['user_id'] != 0) {
                $row_info['address_count'] = strval(count($this->common_model->get_addresses($this->get_param['user_id'])));
            } else {
                $row_info['address_count'] = "0";
            }

            $where = array('user_id' => $this->get_param['user_id'], 'product_id' => $this->get_param['id']);

            if (count($this->common_model->selectByids($where, 'tbl_wishlist')) > 0) {
                $row_info['is_favorite'] = "true";
            } else {
                $row_info['is_favorite'] = "false";
            }
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    public function get_id_by_slug_post()
    {
        $response = array();
        if(isset($this->get_param['product_slug']) && $this->get_param['product_slug']!='') {

            $product_slug=$this->get_param['product_slug'];
            
            $id=$this->common_model->selectByidsParam(array('product_slug' => $product_slug), 'tbl_product', 'id');

            $title=$this->common_model->selectByidsParam(array('product_slug' => $product_slug), 'tbl_product', 'product_title');

            if(!empty($id)){
                $row_info['id'] = $id;
                $row_info['title'] = $title;
            }
            else{
                $row_info['success'] = '0';
                $row_info['msg'] = $this->lang->line('no_data_found_msg');
            }

        } else {
            $row_info['success'] = '0';
            $row_info['msg'] = $this->lang->line('no_data_found_msg');   
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    public function brands_post()
    {
        $response = array();

        if(isset($this->get_param['page'])) {
            $start = ($this->get_param['page'] - 1) * $this->api_page_limit;
        } else {
            $start = 0;
        }

        $row = $this->api_model->brand_list($this->api_page_limit, $start);

        foreach ($row as $key => $value) {
            $data_arr['id'] = $value->id;
            $data_arr['brand_name'] = $value->brand_name;
            if ($value->brand_image != '') {
                $data_arr['brand_image'] = base_url() . 'assets/images/brand/' . $value->brand_image;

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->brand_image);

                $data_arr['brand_image_thumb'] = base_url() . $this->_create_thumbnail('assets/images/brand/', $thumb_img_nm, $value->brand_image, 200, 120);
            } else {
                $data_arr['brand_image'] = '';

                $data_arr['brand_image_thumb'] = '';
            }
            array_push($response, $data_arr);
        }
        $row_info['ECOMMERCE_APP'] = $response;

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    public function coupons_post()
    {
        $response = array();

        $user_id=$this->get_param['user_id'];
        $cart_ids=$this->get_param['cart_ids'];
        $cart_type=$this->get_param['cart_type'];   // main_cart/temp_cart

        if(isset($this->get_param['page'])) {
            $start = ($this->get_param['page'] - 1) * $this->api_page_limit;
        } else {
            $start = 0;
        }

        $row_coupon = $this->api_model->coupon_list($this->api_page_limit, $start);

        if($cart_type=='main_cart'){
            $my_cart=$this->api_model->get_cart($user_id);
        }
        else{
            $my_cart=$this->api_model->get_cart($user_id, $cart_ids);
        }

        $total_amount=$delivery_charge=$you_save=0;

        // no any coupon applied
        foreach ($my_cart as $row_cart) {
            $total_amount += ($row_cart->selling_price * $row_cart->product_qty);
            $you_save += ($row_cart->you_save_amt * $row_cart->product_qty);
            $delivery_charge += $row_cart->delivery_charge;
        }

        foreach ($row_coupon as $value) {

            if($value->cart_status=='true'){
              if($value->coupon_cart_min > $total_amount){
                continue;
              }
            }

            if($value->coupon_per==0 && ($total_amount < $value->coupon_amt)){
              continue;
            }

            $data_arr['id'] = $value->id;
            $data_arr['coupon_code'] = $value->coupon_code;
            $data_arr['coupon_image'] = base_url() . 'assets/images/coupons/' . $value->coupon_image;

            $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->coupon_image);

            $data_arr['coupon_image_thumb'] = base_url() . $this->_create_thumbnail('assets/images/coupons/', $thumb_img_nm, $value->coupon_image, 300, 150);

            array_push($response, $data_arr);
        }

        $row_info['ECOMMERCE_APP'] = $response;

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    public function offers_post()
    {

        $response = array();

        if(isset($this->get_param['page'])) {
            $start = ($this->get_param['page'] - 1) * $this->api_page_limit;
        } else {
            $start = 0;
        }

        $row = $this->api_model->offers_list($this->api_page_limit, $start);

        foreach ($row as $key => $value) {
            $data_arr['id'] = $value->id;
            $data_arr['offer_title'] = $value->offer_title;
            $data_arr['offer_image'] = base_url() . 'assets/images/offers/' . $value->offer_image;

            $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->offer_image);

            $data_arr['offer_image_thumb'] = base_url() . $this->_create_thumbnail('assets/images/offers/', $thumb_img_nm, $value->offer_image, 370, 210);

            array_push($response, $data_arr);
        }
        $row_info['ECOMMERCE_APP'] = $response;

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // todays deal products
    public function today_deal_post()
    {

        $response = array();

        if(isset($this->get_param['page'])) {
            $start = ($this->get_param['page'] - 1) * $this->api_page_limit;
        } else {
            $start = 0;
        }

        $row_info['total_products'] = count($this->api_model->products_filter('today_deal',''));

        $row = $this->api_model->products_filter('today_deal','',$this->api_page_limit, $start);
        
        foreach ($row as $key => $value) {

            $data_rate = $this->product_rating($value->product_id);

            $arr_rate = json_decode($data_rate);

            $data_arr['id'] = $value->product_id;

            $data_arr['category_id'] = $value->category_id;
            $data_arr['sub_category_id'] = $value->sub_category_id;
            $data_arr['brand_id'] = $value->brand_id;
            $data_arr['offer_id'] = $value->offer_id;

            $data_arr['product_title'] = $value->product_title;
            $data_arr['product_desc'] = stripslashes($value->product_desc);

            $data_arr['product_image'] = base_url() . 'assets/images/products/' . $value->featured_image;

            $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->featured_image);

            $data_arr['product_image_square'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 250);

            $data_arr['product_image_portrait'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 300);

            $data_arr['product_mrp'] = number_format($value->product_mrp,2);
            $data_arr['product_sell_price'] = number_format($value->selling_price,2);
            $data_arr['you_save'] = number_format($value->you_save_amt,2);
            $data_arr['you_save_per'] = $value->you_save_per . ' ' . $this->lang->line('per_off_lbl');

            $data_arr['product_status'] = $value->status;
            $data_arr['product_status_lbl'] = $this->lang->line('unavailable_lbl');

            $data_arr['total_views'] = $value->total_views;
            $data_arr['total_rate'] = $arr_rate->rate_times;
            $data_arr['rate_avg'] = $arr_rate->rate_avg;

            $data_arr['category_name'] = $value->category_name;
            $data_arr['sub_category_name'] = $this->get_sub_category_info($value->sub_category_id, 'sub_category_name');

            array_push($response, $data_arr);
        }
        $row_info['ECOMMERCE_APP'] = $response;

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // search products
    public function search_post()
    {
        $response = array();

        if(isset($this->get_param['page'])) {
            $start = ($this->get_param['page'] - 1) * $this->api_page_limit;
        } else {
            $start = 0;
        }

        if(isset($this->get_param['keyword']) && $this->get_param['keyword']!=''){
            $keyword=trim($this->get_param['keyword']);

            $row_info['total_products'] = count($this->api_model->products_filter('search','','','','','','','','',$keyword));

            $row=$this->api_model->products_filter('search','', $this->api_page_limit, $start,'','','','','',$keyword);

            foreach ($row as $key => $value) {

                $data_rate = $this->product_rating($value->product_id);

                $arr_rate = json_decode($data_rate);

                $data_arr['id'] = $value->product_id;

                $data_arr['category_id'] = $value->category_id;
                $data_arr['sub_category_id'] = $value->sub_category_id;
                $data_arr['brand_id'] = $value->brand_id;
                $data_arr['offer_id'] = $value->offer_id;

                $data_arr['product_title'] = $value->product_title;
                $data_arr['product_desc'] = stripslashes($value->product_desc);

                $data_arr['product_image'] = base_url() . 'assets/images/products/' . $value->featured_image;

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->featured_image);

                $data_arr['product_image_square'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 250);

                $data_arr['product_image_portrait'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 300);

                $data_arr['product_mrp'] = number_format($value->product_mrp,2);
				$data_arr['product_sell_price'] = number_format($value->selling_price,2);
				$data_arr['you_save'] = number_format($value->you_save_amt,2);
                $data_arr['you_save_per'] = $value->you_save_per . ' ' . $this->lang->line('per_off_lbl');

                $data_arr['product_status'] = $value->status;
                $data_arr['product_status_lbl'] = $this->lang->line('unavailable_lbl');

                $data_arr['total_views'] = $value->total_views;
                $data_arr['total_rate'] = $arr_rate->total_rate;
                $data_arr['nos_user_rate'] = $arr_rate->rate_times;
                $data_arr['rate_avg'] = $arr_rate->rate_avg;

                $data_arr['category_name'] = $value->category_name;
                $data_arr['sub_category_name'] = $this->get_sub_category_info($value->sub_category_id, 'sub_category_name');

                array_push($response, $data_arr);
            }

            $row_info['ECOMMERCE_APP'] = $response;
        }
        else{
            $row_info['total_products'] = 0;
            $row_info['ECOMMERCE_APP'] = $response;
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    public function single_coupon_post()
    {

        $response = array();

        $row = $this->common_model->selectByid($this->get_param['id'], 'tbl_coupon');

        $row_info['id'] = $row->id;
        $row_info['coupon_code'] = $row->coupon_code;
        $row_info['coupon_desc'] = stripslashes($row->coupon_desc);
        $row_info['coupon_image'] = base_url() . 'assets/images/coupons/' . $row->coupon_image;

        $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row->coupon_image);

        $row_info['coupon_image_thumb'] = base_url() . $this->_create_thumbnail('assets/images/coupons/', $thumb_img_nm, $row->coupon_image, 300, 150);

        $row_info['coupon_amt'] = ($row->coupon_per!=0) ? $row->coupon_per.'%' : CURRENCY_CODE.' '.$row->coupon_amt;
        
        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // add and update cart
    public function cart_add_update_post()
    {
        $response = array();

        $product_id = trim($this->get_param['product_id']);
        $user_id = trim($this->get_param['user_id']);

        $buy_now = trim($this->get_param['buy_now']);

        if($this->get_product_info($this->get_param['product_id'], 'max_unit_buy') >= $this->get_param['product_qty'])
        {
            if($buy_now=='true')
            {
                // action on table temp cart

                // update cart

                $device_id = trim($this->get_param['device_id']);

                $data_arr = array(
                    'product_qty' => $this->get_param['product_qty'],
                    'product_size' => $this->get_param['product_size']
                );

                $data_usr = $this->security->xss_clean($data_arr);

                $where = array('product_id ' => $product_id, 'user_id' => $user_id, 'cart_unique_id' => $device_id);

                $updated_id = $this->common_model->updateByids($data_usr, $where, 'tbl_cart_tmp');

                $cart_id=$this->common_model->selectByidsParam($where, 'tbl_cart_tmp', 'id');

                $row_info['success'] = '1';
                $row_info['msg'] = $this->lang->line('update_cart');
                $row_info['cart_empty_msg'] = '';

                $row_cart=$this->api_model->get_cart($user_id, $cart_id);

                $row_info['total_item'] = strval(count($row_cart));

                $qty = $this->get_param['product_qty'];

                $total_mrp = ($this->get_product_info($this->get_param['product_id'], 'selling_price') * $qty);

                $data_ofr = $this->calculate_offer($this->get_product_info($this->get_param['product_id'], 'offer_id'), $total_mrp);

                $arr_ofr = json_decode($data_ofr);

                $row_info['product_size'] = $this->get_param['product_size'];

                $row_info['product_mrp'] = number_format($this->get_product_info($product_id, 'product_mrp') * $qty,2);

                $row_info['product_sell_price'] = number_format($this->get_product_info($product_id, 'selling_price') * $qty,2);

                $total_amt = $delivery_charge = $you_save = 0;

                foreach ($row_cart as $key => $value) {

                    $total_amt += $this->get_product_info($value->product_id, 'selling_price') * $value->product_qty;

                    $delivery_charge += $this->get_product_info($value->product_id, 'delivery_charge');

                    $you_save += $this->get_product_info($value->product_id, 'you_save_amt') * $value->product_qty;
                }

                $row_info['price'] = number_format($total_amt,2);
                $row_info['delivery_charge'] = ($delivery_charge != 0) ? CURRENCY_CODE . ' ' . number_format($delivery_charge,2) : $this->lang->line('free_lbl');
                $row_info['payable_amt'] = number_format($total_amt + $delivery_charge,2);

                $row_info['you_save'] = number_format($you_save,2);
                $row_info['you_save_per'] = $arr_ofr->you_save_per . ' ' . $this->lang->line('per_off_lbl');

                if ($you_save != 0) {

                    $row_info['you_save_msg'] = str_replace('###', CURRENCY_CODE . ' ' . number_format($you_save,2), $this->lang->line('coupon_save_msg_lbl'));
                } else {
                    $row_info['you_save_msg'] = '';
                }

            }
            else
            {
                // action on table main cart

                $cart_exist = $this->common_model->cart_items($product_id, $user_id);

                if($cart_exist == 0)
                {
                    //  add in cart
                    $data_arr = array(
                        'product_id' => $this->get_param['product_id'],
                        'user_id' => $this->get_param['user_id'],
                        'product_qty' => $this->get_param['product_qty'],
                        'product_size' => $this->get_param['product_size'],
                        'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
                    );

                    $data_usr = $this->security->xss_clean($data_arr);

                    $cart_id = $this->common_model->insert($data_usr, 'tbl_cart');

                    $cart_items = count($this->api_model->get_cart($this->get_param['user_id']));

                    $row_info = array('total_item' => strval($cart_items), 'success' => '1', 'msg' => $this->lang->line('add_cart'));
                    
                }
                else 
                {
                    // update cart

                    $data_arr = array(
                        'product_qty' => $this->get_param['product_qty'],
                        'product_size' => $this->get_param['product_size'],
                        'last_update' => strtotime(date('d-m-Y h:i:s A', now()))
                    );

                    $data_usr = $this->security->xss_clean($data_arr);

                    $where = array('product_id ' => $product_id, 'user_id' => $user_id);

                    $updated_id = $this->common_model->updateByids($data_usr, $where, 'tbl_cart');

                    $row_info['success'] = '1';
                    $row_info['msg'] = $this->lang->line('update_cart');
                    $row_info['cart_empty_msg'] = '';

                    $row_cart=$this->api_model->get_cart($user_id);

                    $row_info['total_item'] = strval(count($row_cart));

                    $qty = $this->get_param['product_qty'];

                    $total_mrp = ($this->get_product_info($this->get_param['product_id'], 'selling_price') * $qty);

                    $data_ofr = $this->calculate_offer($this->get_product_info($this->get_param['product_id'], 'offer_id'), $total_mrp);

                    $arr_ofr = json_decode($data_ofr);

                    $row_info['product_size'] = $this->get_param['product_size'];

                    $row_info['product_mrp'] = number_format($this->get_product_info($this->get_param['product_id'], 'product_mrp') * $qty,2);

                    $row_info['product_sell_price'] = number_format($this->get_product_info($this->get_param['product_id'], 'selling_price') * $qty,2);

                    // for returns updated values

                    $total_amt = $delivery_charge = $you_save = 0;

                    foreach ($row_cart as $key => $value) {

                        $total_amt += $this->get_product_info($value->product_id, 'selling_price') * $value->product_qty;

                        $delivery_charge += $this->get_product_info($value->product_id, 'delivery_charge');

                        $you_save += $this->get_product_info($value->product_id, 'you_save_amt') * $value->product_qty;
                    }

                    $row_info['price'] = number_format($total_amt,2);
                    $row_info['delivery_charge'] = ($delivery_charge != 0) ? CURRENCY_CODE . ' ' . number_format($delivery_charge,2) : $this->lang->line('free_lbl');
                    $row_info['payable_amt'] = number_format($total_amt + $delivery_charge,2);

                    $row_info['you_save'] = number_format($you_save,2);
                    $row_info['you_save_per'] = $arr_ofr->you_save_per . ' ' . $this->lang->line('per_off_lbl');

                    if ($you_save != 0) {

                        $row_info['you_save_msg'] = str_replace('###', CURRENCY_CODE . ' ' . number_format($you_save,2), $this->lang->line('coupon_save_msg_lbl'));
                    } else {
                        $row_info['you_save_msg'] = '';
                    }
                }
            }

        }
        else{
            $row_info = array('success' => '0', 'msg' => str_replace('###', $this->get_product_info($this->get_param['product_id'], 'max_unit_buy'), $this->lang->line('err_cart_item_buy_lbl')), 'cart_empty_msg' => '0');
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // delete cart item
    public function cart_item_delete_post()
    {
        $response = array();

        if ($this->common_model->delete($this->get_param['cart_id'], 'tbl_cart')) {

            $row_info['success'] = '1';
            $row_info['msg'] = $this->lang->line('remove_cart');

            $total_amt = $delivery_charge = $you_save = 0;

            $row = $this->api_model->get_cart($this->get_param['user_id']);

            if(empty(!$row))
            {

                foreach ($row as $key => $value) {

                    $total_amt += $this->get_product_info($value->product_id, 'selling_price') * $value->product_qty;

                    $delivery_charge += $value->delivery_charge;

                    $you_save += $this->get_product_info($value->product_id, 'you_save_amt') * $value->product_qty;
                }

                $row_info['total_item'] = count($row);
                $row_info['price'] = number_format($total_amt,2);
                $row_info['delivery_charge'] = ($delivery_charge != 0) ? CURRENCY_CODE . ' ' . $delivery_charge : $this->lang->line('free_lbl');
                $row_info['payable_amt'] = number_format($total_amt + $delivery_charge,2);

                if ($you_save != 0) {

                    $row_info['you_save_msg'] = str_replace('###', CURRENCY_CODE . ' ' . number_format($you_save,2), $this->lang->line('coupon_save_msg_lbl'));
                } else {
                    $row_info['you_save_msg'] = '';
                }

                $row_info['cart_empty_msg'] = '';
            }
            else{
                // no more data in cart

                $row_info['total_item'] = '0';
                $row_info['cart_empty_msg'] = $this->lang->line('cart_empty_msg');
            }
        } else {
            $row_info['success'] = '0';
            $row_info['msg'] = $this->lang->line('no_data');
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // get cart items by users
    public function my_cart_post()
    {

        $response = array();

        $total_amt = $delivery_charge = $you_save = 0;

        if ($row = $this->api_model->get_cart($this->get_param['user_id'])){

            $row_info['success']=1;
            $row_info['msg']='';

            foreach ($row as $key => $value)
            {

                $data_arr['id'] = $value->id;

                $data_arr['product_id'] = $value->product_id;
                $data_arr['user_id'] = $value->user_id;

                $data_arr['product_qty'] = $value->product_qty;

                $data_arr['product_size'] = ($value->product_size!='0') ? $value->product_size : '';

                $data_arr['max_unit_buy'] = $value->max_unit_buy;

                $data_arr['product_title'] = $value->product_title;

                $data_arr['product_image'] = base_url() . 'assets/images/products/' . $value->featured_image;

                $total_mrp = ($this->get_product_info($value->product_id, 'selling_price') * $value->product_qty);

                $data_ofr = $this->calculate_offer($this->get_product_info($value->product_id, 'offer_id'), $total_mrp);

                $arr_ofr = json_decode($data_ofr);

                $data_arr['product_mrp'] = number_format($value->product_mrp * $value->product_qty,2);
                $data_arr['product_sell_price'] = number_format($value->selling_price * $value->product_qty,2);
                $data_arr['you_save'] = number_format($value->you_save_amt * $value->product_qty,2);

                $data_arr['you_save_per'] = $arr_ofr->you_save_per . ' ' . $this->lang->line('per_off_lbl');

                $data_arr['delivery_charge'] = ($value->delivery_charge != 0) ? CURRENCY_CODE . ' ' . number_format($value->delivery_charge,2) : $this->lang->line('free_lbl');

                $data_arr['product_status'] = $this->get_product_info($value->product_id, 'status');
                $data_arr['product_status_lbl'] = $this->lang->line('unavailable_lbl');                

                array_push($response, $data_arr);

                $total_amt += ($value->selling_price * $value->product_qty);

                $delivery_charge += $value->delivery_charge;

                $you_save += ($value->you_save_amt * $value->product_qty);
            }

            $row_info['ECOMMERCE_APP'] = $response;
        } else {

            $row_info['success']=0;
            $row_info['msg']=$this->lang->line('cart_empty_msg');

            $row_info['ECOMMERCE_APP'] = $response;
        }

        $row_info['total_item'] = strval(count($row));
        $row_info['price'] = number_format($total_amt,2);
        $row_info['delivery_charge'] = ($delivery_charge != 0) ? CURRENCY_CODE . ' ' . number_format($delivery_charge,2) : $this->lang->line('free_lbl');
        $row_info['payable_amt'] = number_format($total_amt + $delivery_charge,2);

        if ($you_save != 0)
        {
            $row_info['you_save_msg'] = str_replace('###', CURRENCY_CODE . ' ' . number_format($you_save,2), $this->lang->line('coupon_save_msg_lbl'));
        } else {
            $row_info['you_save_msg'] = '';
        }

        $row_info['address_count'] = strval(count($this->common_model->get_addresses($this->get_param['user_id'])));

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // all address api

    public function get_countries_post()
    {

        $user_id=$this->get_param['user_id'];

        $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");


        $response = array();

        foreach ($countries as $key => $value) {
            $data_arr['country_name'] = $value;
            array_push($response, $data_arr);
        }

        $row_info['home_address_lbl'] = $this->lang->line('home_address_lbl');
        $row_info['office_address_lbl'] = $this->lang->line('office_address_lbl');

        if($user_id!=0)
        {
            $row_user = $this->common_model->selectByid($user_id, 'tbl_users');
            $row_info['user_name'] = $row_user->user_name;
            $row_info['user_email'] = $row_user->user_email;
            $row_info['user_phone'] = $row_user->user_phone;
        }
        else
        {
            $row_info['user_name'] = '';
            $row_info['user_email'] = '';
            $row_info['user_phone'] = '';
        }

        $row_info['ECOMMERCE_APP'] = $response;

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    public function addedit_address_post()
    {

        $response = array();

        $user_id = $this->get_param['user_id'];

        $type = $this->get_param['type']; // add/edit

        if ($type == 'add') 
        {
            if ($row = $this->common_model->get_addresses($user_id)) {

                $data_arr = array(
                    'is_default' => 'false'
                );

                $data_usr = $this->security->xss_clean($data_arr);

                $where = array('user_id ' => $user_id);

                $updated_id = $this->common_model->updateByids($data_usr, $where, 'tbl_addresses');
            }

            $data_arr = array(
                'user_id' => $user_id,
                'pincode' => trim($this->get_param['pincode']),
                'building_name' => trim($this->get_param['building_name']),
                'road_area_colony' => trim($this->get_param['road_area_colony']),
                'city' => trim($this->get_param['city']),
                'district' => trim($this->get_param['district']),
                'state' => trim($this->get_param['state']),
                'country' => trim($this->get_param['country']),
                'landmark' => trim($this->get_param['landmark']),
                'name' => trim($this->get_param['name']),
                'email' => trim($this->get_param['email']),
                'mobile_no' => trim($this->get_param['mobile_no']),
                'alter_mobile_no' => trim($this->get_param['alter_mobile_no']),
                'address_type' => trim($this->get_param['address_type']),
                'is_default' => 'true',
                'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
            );

            $data_usr = $this->security->xss_clean($data_arr);

            $address_id = $this->common_model->insert($data_usr, 'tbl_addresses');

            $row_info = array('success' => '1', 'msg' => $this->lang->line('add_success'));

            $row_info['address_id'] = $address_id;
            $row_info['address'] = $this->get_param['building_name'] . ', ' . $this->get_param['road_area_colony'] . ', ' . $this->get_param['city'] . ', ' . $this->get_param['district'] . ', ' . $this->get_param['state'] . ', ' . $this->get_param['country'] . ' - ' . $this->get_param['pincode'];

            $row_info['name'] = $this->get_param['name'];
            $row_info['mobile_no'] = $this->get_param['mobile_no'];
            $row_info['address_type'] = ($this->get_param['address_type']=='1') ? $this->lang->line('home_address_val_lbl') : $this->lang->line('office_address_val_lbl');
        } 
        else if($type == 'edit') 
        {

            $address_id = $this->get_param['id'];

            $data_arr = array(
                'is_default' => 'false'
            );

            $data_usr = $this->security->xss_clean($data_arr);

            $where = array('user_id ' => $user_id);

            $updated_id = $this->common_model->updateByids($data_usr, $where, 'tbl_addresses');

            $data_arr = array(
                'pincode' => $this->get_param['pincode'],
                'building_name' => $this->get_param['building_name'],
                'road_area_colony' => $this->get_param['road_area_colony'],
                'city' => $this->get_param['city'],
                'district' => $this->get_param['district'],
                'state' => $this->get_param['state'],
                'country' => trim($this->get_param['country']),
                'landmark' => $this->get_param['landmark'],
                'name' => $this->get_param['name'],
                'email' => $this->get_param['email'],
                'mobile_no' => $this->get_param['mobile_no'],
                'alter_mobile_no' => $this->get_param['alter_mobile_no'],
                'is_default' => 'true',
                'address_type' => $this->get_param['address_type']
            );

            $data_usr = $this->security->xss_clean($data_arr);

            $user_id = $this->common_model->update($data_usr, $address_id, 'tbl_addresses');

            $row_info = array('success' => '1', 'msg' => $this->lang->line('update_success'));

            $row_info['address_id'] = $address_id;
            $row_info['address'] = $this->get_param['building_name'] . ', ' . $this->get_param['road_area_colony'] . ', ' . $this->get_param['city'] . ', ' . $this->get_param['district'] . ', ' . $this->get_param['state'] . ', ' . $this->get_param['country'] . ' - ' . $this->get_param['pincode'];

            $row_info['name'] = $this->get_param['name'];
            $row_info['mobile_no'] = $this->get_param['mobile_no'];
            $row_info['address_type'] = ($this->get_param['address_type']==1) ? $this->lang->line('home_address_val_lbl') : $this->lang->line('office_address_val_lbl');
        } 
        else {
            $row_info = array('success' => '0', 'msg' => $this->lang->line('type_invalid'));
        }

        $row_info['address_count'] = strval(count($this->common_model->get_addresses($user_id)));

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    public function single_address_post()
    {

        $address_id = $this->get_param['address_id'];

        if ($row = $this->common_model->selectByid($address_id, 'tbl_addresses')) 
        {
            $row_info['pincode'] = $row->pincode;
            $row_info['building_name'] = $row->building_name;
            $row_info['road_area_colony'] = $row->road_area_colony;
            $row_info['city'] = $row->city;
            $row_info['district'] = $row->district;
            $row_info['state'] = $row->state;
            $row_info['country'] = $row->country;
            $row_info['landmark'] = $row->landmark;
            $row_info['name'] = $row->name;
            $row_info['email'] = $row->email;
            $row_info['mobile_no'] = $row->mobile_no;
            $row_info['alter_mobile_no'] = $row->alter_mobile_no;
            $row_info['address_type'] = $row->address_type;
        }
        else {
            $row_info['pincode'] = '';
            $row_info['building_name'] = '';
            $row_info['road_area_colony'] = '';
            $row_info['city'] = '';
            $row_info['district'] = '';
            $row_info['state'] = '';
            $row_info['country'] = '';
            $row_info['landmark'] = '';
            $row_info['name'] = '';
            $row_info['email'] = '';
            $row_info['mobile_no'] = '';
            $row_info['alter_mobile_no'] = '';
            $row_info['address_type'] = '';
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    public function change_address_post()
    {

        $response = array();

        $address_id = $this->get_param['address_id'];
        $user_id = $this->get_param['user_id'];

        $data_arr = array(
            'is_default' => 'false'
        );

        $data_usr = $this->security->xss_clean($data_arr);

        $where = array('user_id ' => $user_id);

        $updated_id = $this->common_model->updateByids($data_usr, $where, 'tbl_addresses');

        $data_arr1 = array(
            'is_default' => 'true'
        );

        $data_usr1 = $this->security->xss_clean($data_arr1);

        $updated_id = $this->common_model->update($data_usr1, $address_id, 'tbl_addresses');

        // to get default address of user
        $address_arr = $this->common_model->get_addresses($user_id, true);

        $address_arr = $address_arr[0];

        $row_info['success'] = '1';
        $row_info['msg'] = $this->lang->line('update_success');

        $row_info['address_id'] = $address_arr->id;
        $row_info['address'] = $address_arr->building_name . ', ' . $address_arr->road_area_colony . ', ' . $address_arr->city . ', ' . $address_arr->district . ', ' . $address_arr->state . ', ' . $address_arr->country . ' - ' . $address_arr->pincode;

        $row_info['name'] = $address_arr->name;
        $row_info['mobile_no'] = $address_arr->mobile_no;
        $row_info['address_type'] = ($address_arr->address_type==1) ? $this->lang->line('home_address_val_lbl') : $this->lang->line('office_address_val_lbl');

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // get addresses by users
    public function get_addresses_post()
    {

        $response = array();

        $row_info['address_count'] = count($this->common_model->get_addresses($this->get_param['user_id']));

        if ($row = $this->common_model->get_addresses($this->get_param['user_id'])) {
            foreach ($row as $key => $value) {

                $data_arr['id'] = $value->id;
                $data_arr['name'] = $value->name;
                $data_arr['mobile_no'] = $value->mobile_no;
                $data_arr['address'] = $value->building_name . ', ' . $value->road_area_colony . ', ' . $value->city . ', ' . $value->district . ', ' . $value->state . ', ' . $value->country . ' - ' . $value->pincode;
                $data_arr['address_type'] = ($value->address_type==1) ? $this->lang->line('home_address_val_lbl') : $this->lang->line('office_address_val_lbl');
                $data_arr['is_default'] = $value->is_default;

                array_push($response, $data_arr);
            }
            $row_info['ECOMMERCE_APP'] = $response;
        } else {
            $row_info['ECOMMERCE_APP'] = $response;
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // check address is available by users
    public function is_address_avail_post()
    {

        $response = array();

        if ($row = $this->common_model->get_addresses($this->get_param['user_id'])) {
            $row_info = array('is_address_avail' => true);
        } else {
            $row_info = array('is_address_avail' => false);
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // delete address by users
    public function delete_address_post()
    {
        $response = array();

        $id = $this->get_param['id'];
        $user_id = $this->get_param['user_id'];

        $row = $this->common_model->selectByids(array('user_id' => $user_id, 'id' => $id), 'tbl_addresses');

        if (!empty($row))
        {
            $row = $row[0];

            if ($row->is_default == 'true') {

                $data_arr = $this->common_model->selectByids(array('user_id' => $user_id), 'tbl_addresses');

                if (!empty($row)) {

                    $this->common_model->delete($id, 'tbl_addresses');

                    $data_arr1 = array(
                        'is_default' => 'true'
                    );

                    $data_usr1 = $this->security->xss_clean($data_arr1);

                    $where = array('user_id' => $user_id);

                    $max_id = $this->common_model->getMaxId('tbl_addresses', $where);

                    $updated_id = $this->common_model->update($data_usr1, $max_id, 'tbl_addresses');
                }
            } else {
                $this->common_model->delete($id, 'tbl_addresses');
            }

            $row_info['success'] = '1';
            $row_info['msg'] = $this->lang->line('delete_success');
        } else {
            $row_info['success'] = '1';
            $row_info['msg'] = $this->lang->line('no_data_found_msg');
        }

        $row_info['address_count'] = strval(count($this->common_model->get_addresses($user_id)));

        // to get default address of user
        $address_arr = $this->common_model->get_addresses($user_id, true);

        if (!empty($address_arr)) 
        {
            $address_arr = $address_arr[0];

            $row_info['address'] = $address_arr->building_name . ', ' . $address_arr->road_area_colony . ', ' . $address_arr->city . ', ' . $address_arr->district . ', ' . $address_arr->state . ' - ' . $address_arr->pincode;
        } else {
            $row_info['address'] = "";
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }
    //end address api

    // wishlist

    public function wishlist_post()
    {

        $user_id = $this->get_param['user_id'];
        $product_id = $this->get_param['product_id'];

        $where = array('user_id ' => $user_id, 'product_id' => $product_id);

        $count = count($this->common_model->selectByids($where, 'tbl_wishlist'));

        if ($count > 0) {

            $this->common_model->deleteByids($where, 'tbl_wishlist');

            $count = count($this->common_model->selectByids($where, 'tbl_wishlist'));

            $row_info = array('total_items' => strval($count), 'success' => '1', 'msg' => $this->lang->line('remove_wishlist'), "is_favorite" => "false");
        } else {
            //perform insertion
            $data_arr = array(
                'user_id' => $this->get_param['user_id'],
                'product_id' => $this->get_param['product_id'],
                'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
            );

            $data_usr = $this->security->xss_clean($data_arr);

            $last_id = $this->common_model->insert($data_usr, 'tbl_wishlist');

            $count = count($this->common_model->selectByids($where, 'tbl_wishlist'));

            $row_info = array('total_items' => strval($count), 'success' => '1', 'msg' => $this->lang->line('add_wishlist'), "is_favorite" => "true");
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    public function my_wishlist_post()
    {

        $response = array();

        $user_id = isset($this->get_param['user_id']) ? $this->get_param['user_id'] : '';

        if(isset($this->get_param['page'])) {
            $start = ($this->get_param['page'] - 1) * $this->api_page_limit;
        } else {
            $start = 0;
        }

        $row_info['total_products'] = count($this->api_model->get_wishlist($user_id));

        $row = $this->api_model->get_wishlist($user_id, $this->api_page_limit, $start);

        foreach ($row as $key => $value) {

            // for rating
            $data_rate = $this->product_rating($value->product_id);

            $arr_rate = json_decode($data_rate);

            $data_arr['id'] = $value->product_id;

            $data_arr['category_id'] = $value->category_id;
            $data_arr['sub_category_id'] = $value->sub_category_id;
            $data_arr['brand_id'] = $value->brand_id;
            $data_arr['offer_id'] = $value->offer_id;

            $data_arr['product_title'] = $value->product_title;
            $data_arr['product_desc'] = stripslashes($value->product_desc);

            $data_arr['product_image'] = base_url() . 'assets/images/products/' . $value->featured_image;

            $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->featured_image);

            $data_arr['product_image_square'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 250);

            $data_arr['product_image_portrait'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 300);

            $data_arr['product_mrp'] = number_format($value->product_mrp,2);
            $data_arr['product_sell_price'] = number_format($value->selling_price,2);
            $data_arr['you_save'] = number_format($value->you_save_amt,2);
            $data_arr['you_save_per'] = $value->you_save_per . ' ' . $this->lang->line('per_off_lbl');

            $data_arr['product_status'] = $value->status;
            $data_arr['product_status_lbl'] = $this->lang->line('unavailable_lbl');

            $data_arr['total_views'] = $value->total_views;
            $data_arr['total_rate'] = $arr_rate->rate_times;
            $data_arr['rate_avg'] = $arr_rate->rate_avg;

            $data_arr['category_name'] = $this->get_category_info($value->category_id, 'category_name');
            $data_arr['sub_category_name'] = $this->get_sub_category_info($value->sub_category_id, 'sub_category_name');

            array_push($response, $data_arr);
        }

        $row_info['ECOMMERCE_APP'] = $response;

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    public function empty_wishlist_post()
    {

        $user_id = $this->get_param['user_id'];

        $where = array('user_id ' => $user_id);

        $this->common_model->deleteByids($where, 'tbl_wishlist');

        $row_info = array('success' => '1', 'msg' => $this->lang->line('empty_wishlist'));

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // end wishlist

    // get bank data

    public function get_bank_list_post()
    {

        $response = array();

        $user_id = $this->get_param['user_id'];

        $row = $this->common_model->selectByids(array('user_id' => $user_id), 'tbl_bank_details', 'is_default');

        $row_info['bank_count'] = count($row);

        if (!empty($row)) {

            $row_info['success'] = '1';
            $row_info['msg'] = str_replace('###', count($row), $this->lang->line('nos_records_msg'));

            foreach ($row as $key => $value) {

                $data_arr['id'] = $value->id;
                $data_arr['bank_holder_name'] = $value->bank_holder_name;
                $data_arr['bank_holder_phone'] = $value->bank_holder_phone;
                $data_arr['bank_holder_email'] = $value->bank_holder_email;

                $data_arr['account_no'] = $value->account_no;
                $data_arr['account_type'] = ucfirst($value->account_type);
                $data_arr['bank_ifsc'] = $value->bank_ifsc;
                $data_arr['bank_name'] = $value->bank_name;
                $data_arr['is_default'] = ($value->is_default) ? true : false;

                array_push($response, $data_arr);
            }
            $row_info['ECOMMERCE_APP'] = $response;
        } else {

            $row_info['success'] = '0';
            $row_info['msg'] = $this->lang->line('no_saved_bank_lbl');
            $row_info['ECOMMERCE_APP'] = $response;
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // get single bank data

    public function get_bank_details_post()
    {
        $response = array();

        $bank_id = $this->get_param['bank_id'];
        $user_id = $this->get_param['user_id'];

        if ($row = $this->common_model->selectByids(array('id' => $bank_id, 'user_id' => $user_id), 'tbl_bank_details')) {

            $row = $row[0];

            $row_info['bank_holder_name'] = $row->bank_holder_name;
            $row_info['bank_holder_phone'] = $row->bank_holder_phone;
            $row_info['bank_holder_email'] = $row->bank_holder_email;
            $row_info['account_no'] = $row->account_no;
            $row_info['account_type'] = $row->account_type;
            $row_info['bank_ifsc'] = $row->bank_ifsc;
            $row_info['bank_name'] = $row->bank_name;
            $row_info['is_default'] = ($row->is_default) ? true : false;
        } else {
            $row_info['bank_holder_name'] = '';
            $row_info['bank_holder_phone'] = '';
            $row_info['bank_holder_email'] = '';
            $row_info['account_no'] = '';
            $row_info['account_type'] = '';
            $row_info['bank_ifsc'] = '';
            $row_info['bank_name'] = '';
            $row_info['is_default'] = false;
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // add/edit new bank account

    public function addedit_bank_account_post()
    {

        $response = array();

        $user_id = $this->get_param['user_id'];
        $bank_name = addslashes(trim($this->get_param['bank_name']));
        $account_no = addslashes(trim($this->get_param['account_no']));
        $bank_ifsc = addslashes(trim($this->get_param['bank_ifsc']));

        $account_type = addslashes(trim($this->get_param['account_type']));   //saving, current

        $name = addslashes(trim($this->get_param['name']));
        $phone = addslashes(trim($this->get_param['phone']));
        $email = addslashes(trim($this->get_param['email']));

        $is_default = addslashes(trim($this->get_param['is_default']));

        $type = $this->get_param['type'];     // add/edit

        if ($type == 'add') {

            $where = array('user_id' => $user_id, 'account_no' => $account_no, 'bank_ifsc' => $bank_ifsc);

            $row = $this->common_model->selectByids($where, 'tbl_bank_details');

            if (count($row) == 0) {

                $where = array('user_id' => $user_id);
                $row_data = $this->common_model->selectByids($where, 'tbl_bank_details');

                if (count($row_data) > 0) {
                    if ($is_default) {
                        $data_arr = array(
                            'is_default' => 0
                        );

                        $data_arr = $this->security->xss_clean($data_arr);

                        $this->common_model->updateByids($data_arr, array('user_id' => $user_id), 'tbl_bank_details');
                    }
                } else {
                    $is_default = 1;
                }

                $data_arr = array(
                    'user_id' => $user_id,
                    'bank_holder_name' => $name,
                    'bank_holder_phone' => $phone,
                    'bank_holder_email' => $email,
                    'account_no' => $account_no,
                    'account_type' => $account_type,
                    'bank_ifsc' => $bank_ifsc,
                    'bank_name' => $bank_name,
                    'is_default' => $is_default,
                    'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
                );

                $data_usr = $this->security->xss_clean($data_arr);

                $last_id = $this->common_model->insert($data_usr, 'tbl_bank_details');

                $row_info['success'] = '1';
                $row_info['msg'] = $this->lang->line('add_msg');
            } else {

                $row_info['success'] = '0';
                $row_info['msg'] = $this->lang->line('bank_exist_error');
            }
        } else if ($type == 'edit') {

            $bank_id = $this->get_param['bank_id'];

            $row_bank = $this->common_model->selectByid($bank_id, 'tbl_bank_details');

            if (!empty($row_bank)) {
                $where = array('user_id' => $user_id);
                $row_data = $this->common_model->selectByids($where, 'tbl_bank_details');

                if (count($row_data) > 0) {
                    if ($is_default) {
                        $data_arr = array(
                            'is_default' => 0
                        );

                        $data_arr = $this->security->xss_clean($data_arr);

                        $this->common_model->updateByids($data_arr, array('user_id' => $user_id), 'tbl_bank_details');
                    }
                } else {
                    $is_default = 1;
                }

                $data_arr = array(
                    'user_id' => $user_id,
                    'bank_holder_name' => $name,
                    'bank_holder_phone' => $phone,
                    'bank_holder_email' => $email,
                    'account_no' => $account_no,
                    'account_type' => $account_type,
                    'bank_ifsc' => $bank_ifsc,
                    'bank_name' => $bank_name,
                    'is_default' => $is_default
                );

                $data_usr = $this->security->xss_clean($data_arr);

                $this->common_model->update($data_usr, $bank_id, 'tbl_bank_details');

                if (!$is_default) {
                    $where = array('user_id' => $user_id, 'id <>' => $bank_id);
                    $max_id = $this->common_model->getMaxId('tbl_bank_details', $where);

                    $data_arr = array(
                        'is_default' => 1
                    );

                    $data_arr = $this->security->xss_clean($data_arr);

                    $this->common_model->update($data_arr, $max_id, 'tbl_bank_details');
                }

                $row_info['success'] = '1';
                $row_info['msg'] = $this->lang->line('update_success');
            } 
            else 
            {
                $row_info['success'] = '1';
                $row_info['msg'] = $this->lang->line('no_data_found_msg');
            }
        } else {
            $row_info['success'] = '0';
            $row_info['msg'] = $this->lang->line('type_invalid');
        }

        $row_bank = $this->common_model->selectByids(array('user_id' => $user_id), 'tbl_bank_details', 'is_default');

        $row_info['bank_count'] = strval(count($row_bank));

        if (!empty($row_bank)) {

            $row_bank = $row_bank[0];

            $row_info['bank_details'] = $row_bank->bank_name . '(Acc. ' . $row_bank->account_no . '), ' . $row_bank->bank_holder_name . ', ' . $row_bank->bank_holder_phone . ', ' . $row_bank->bank_holder_email;
        } else {

            $row_info['bank_details'] = "";
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    public function delete_bank_account_post()
    {

        $response = array();

        $bank_id = $this->get_param['bank_id'];
        $user_id = $this->get_param['user_id'];

        $where = array('id' => $bank_id, 'user_id' => $user_id);
        $row_data = $this->common_model->selectByids($where, 'tbl_bank_details');

        if (!empty($row_data)) {

            $row_data = $row_data[0];
            if ($row_data->is_default == '1') {

                $data_arr = $this->common_model->selectByids(array('user_id' => $user_id), 'tbl_bank_details');

                if (count($data_arr) > 0) {

                    $this->common_model->delete($bank_id, 'tbl_bank_details');

                    $data_arr1 = array(
                        'is_default' => '1'
                    );

                    $data_usr1 = $this->security->xss_clean($data_arr1);

                    $where = array('user_id' => $user_id);

                    $max_id = $this->common_model->getMaxId('tbl_bank_details', $where);

                    $updated_id = $this->common_model->update($data_usr1, $max_id, 'tbl_bank_details');
                }
            } else {
                $this->common_model->delete($bank_id, 'tbl_bank_details');
            }

            $row_info['success'] = '1';
            $row_info['msg'] = $this->lang->line('bank_remove');
        } else {
            $row_info['success'] = '1';
            $row_info['msg'] = $this->lang->line('no_data_found_msg');
        }

        $row_bank = $this->common_model->selectByids(array('user_id' => $user_id), 'tbl_bank_details', 'is_default');

        $row_info['bank_count'] = strval(count($row_bank));

        if (!empty($row_bank)) {

            $row_bank = $row_bank[0];

            $row_info['bank_details'] = $row_bank->bank_name . '(Acc. ' . $row_bank->account_no . '), ' . $row_bank->bank_holder_name . ', ' . $row_bank->bank_holder_phone . ', ' . $row_bank->bank_holder_email;
        } else {

            $row_info['bank_details'] = "";
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }


    // apply coupon

    public function apply_coupon_post()
    {

        $response = array();

        $user_id = $this->get_param['user_id'];
        $coupon_id = $this->get_param['coupon_id'];
        $cart_ids = $this->get_param['cart_ids'];
        $cart_type=$this->get_param['cart_type'];   // main_cart, temp_cart

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

        $total_amount=$delivery_charge=$you_save=0;
        $save_msg='';

        $is_avail=true;

        if(!empty($my_cart)){

            foreach ($my_cart as $value) 
            {
                if($value->cart_status==0){
                    $is_avail=false;
                }
            }

            if(!$is_avail){
                $row_info = array('success' => '2', 'msg' => $this->lang->line('some_product_unavailable_lbl'));
                $this->set_response($row_info, REST_Controller::HTTP_OK);
                return;
            }

            if(count($rowAppliedCoupon)==0){

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

                                    if($discount > 0){
                                        $save_msg=str_replace('###', CURRENCY_CODE.' '.number_format(($discount+$you_save),2), $this->lang->line('coupon_save_msg_lbl'));
                                    }

                                    $response=array('success' => '1','msg' => $this->lang->line('applied_coupon'),'coupon_id' => $row->id,'you_save_msg' =>$save_msg, "price" => number_format($total_amount,2), "payable_amt" => strval($payable_amt));
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

                                if($discount > 0)
                                {   
                                    $save_msg=str_replace('###', CURRENCY_CODE.' '.number_format(($discount+$you_save),2), $this->lang->line('coupon_save_msg_lbl'));
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

                        if($response['success'])
                        {
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
                        $response=array('success' => '0','msg' => $this->lang->line('use_limit_over'));
                    }
                }
                else{
                    $response=array('success' => '0','msg' => $this->lang->line('no_coupon'));
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
            $response=array('success' => '2','msg' => $this->lang->line('cart_empty_msg'));
        }

        $this->set_response($response, REST_Controller::HTTP_OK);
    }


    public function remove_coupon_post()
    {
        $response = array();

        $coupon_id = $this->get_param['coupon_id'];
        $cart_type = $this->get_param['cart_type']; // main_cart/temp_cart
        $user_id = $this->get_param['user_id'];

        $where=array('user_id' => $user_id, 'cart_type' => $cart_type);

        $data_coupon=$this->common_model->selectByids($where,'tbl_applied_coupon');

        if(!empty($data_coupon)){

            // coupon data found

            $data_coupon=$data_coupon[0];

            if($cart_type=='temp_cart'){
                $my_cart = $this->api_model->get_cart($user_id, $data_coupon->cart_id);
            }
            else{
                $my_cart = $this->api_model->get_cart($user_id);   
            }

            if(!empty($my_cart)){
                $total_amt=$delivery_charge=$you_save=0;

                foreach ($my_cart as $value) {

                    $total_amt += $value->selling_price * $value->product_qty;

                    $delivery_charge += $value->delivery_charge;

                    $you_save += $value->you_save_amt * $value->product_qty;
                }

                $total_amt=number_format((float)$total_amt, 2, '.', '');

                $row_info['success'] = '1';
                $row_info['msg'] = $this->lang->line('remove_coupon_msg');

                $row_info['price'] = $total_amt;
                $row_info['payable_amt'] = number_format((float)($total_amt), 2, '.', '') + number_format((float)$delivery_charge, 2, '.', '');

                if ($you_save != 0) {
                    $row_info['you_save_msg'] = str_replace('###', CURRENCY_CODE . ' ' . strval($you_save), $this->lang->line('coupon_save_msg_lbl'));
                } else {
                    $row_info['you_save_msg'] = '';
                }

                $where=array('user_id' => $user_id, 'cart_type' => $cart_type, 'coupon_id' => $coupon_id);

                $this->common_model->deleteByids($where, 'tbl_applied_coupon');
            }
            else{
                // cart id empty
                $row_info['success'] = '2';
                $row_info['msg'] = $this->lang->line('ord_placed_empty_lbl');
            }
        }
        else{
            // coupon data not found
            $row_info['success'] = '0';
            $row_info['msg'] = $this->lang->line('no_data_found_msg');
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // my orders
    public function my_order_post()
    {
        $user_id = $this->get_param['user_id'];

        if(isset($this->get_param['page'])) {
            $start = ($this->get_param['page'] - 1) * $this->api_page_limit;
        } else {
            $start = 0;
        }

        $response = array();
        $row_info = array();

        $row_ord = $this->api_model->get_my_orders($user_id, $this->api_page_limit, $start);

        if (count($row_ord) > 0) {
            foreach ($row_ord as $key => $value) {

                $where = array('order_id' => $value->id);

                $row_items = $this->common_model->selectByids($where, 'tbl_order_items');

                if (count($row_items) > 0) {
                    foreach ($row_items as $key2 => $value2) {

                        $data_arr['order_id'] = $value->id;
                        $data_arr['order_unique_id'] = $value->order_unique_id;

                        $data_arr['product_id'] = $value2->product_id;
                        $data_arr['product_title'] = $value2->product_title;

                        $data_arr['product_image'] = base_url() . 'assets/images/products/' . $this->get_product_info($value2->product_id, 'featured_image');

                        $data_arr['order_status'] = $this->common_model->selectByidParam($value2->pro_order_status, 'tbl_status_title', 'title');

                        $data_arr['current_order_status'] = ($value2->pro_order_status < 5) ? 'true' : 'false';

                        array_push($response, $data_arr);
                    }
                }
            }
        }

        $row_info['ECOMMERCE_APP'] = $response;

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // user's order details
    public function order_detail_post()
    {

        $order_unique_id = $this->get_param['order_unique_id'];
        $product_id = $this->get_param['product_id'];

        $response = array();
        $row_info = array();

        $row_ord = $this->api_model->get_order($order_unique_id, $product_id);

        if(!empty($row_ord)){

            $row_info['success'] = 1;
            $row_info['msg'] = '';

            $total_amt=0;

            foreach ($row_ord as $key => $value) {

                $row_info['order_id'] = $value->id;
                $row_info['order_unique_id'] = $value->order_unique_id;
                $row_info['order_date'] = date('d-m-Y', $value->order_date);

                $my_rating=$this->common_model->selectByidsParam(array('user_id' => $value->user_id, 'product_id' => $value->product_id), 'tbl_rating', 'rating');

                $row_info['my_rating'] = ($my_rating!='') ? $my_rating : '0';

                $row_info['product_id'] = $value->product_id;
                $row_info['product_title'] = $value->product_title;

                $row_info['address'] = $value->building_name . ', ' . $value->road_area_colony . ', ' . $value->city . ', ' . $value->district . ', ' . $value->state . ', ' . $value->country . ' - ' . $value->pincode;

                $row_info['name'] = $value->name;
                $row_info['mobile_no'] = $value->mobile_no;
                $row_info['email'] = $value->email;

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $this->get_product_info($value->product_id, 'featured_image'));

                $row_info['product_image'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $this->get_product_info($value->product_id, 'featured_image'), 250, 250);

                $row_info['product_qty'] = $value->product_qty;
                $row_info['product_size'] = ($value->product_size!='0') ? $value->product_size : '';

                $product_color=$this->get_product_info($value->product_id, 'color');

                if ($product_color != '') {

                    $color_arr = explode('/', $product_color);
                    $color_name = $color_arr[0];
                    $color_code = $color_arr[1];

                    $product_color=$color_name;
                }

                $row_info['product_color'] = $product_color;

                $row_info['product_price'] = number_format($value->product_mrp,2);

                $row_info['selling_price'] = number_format($value->product_price, 2);
                $row_info['discount_amt'] = number_format($value->you_save_amt,2);

                $row_info['delivery_charge'] = ($value->delivery_charge != 0) ? number_format($value->delivery_charge) : $this->lang->line('free_lbl');

                $payable_amt=($value->product_price * $value->product_qty);

                $row_info['payable_amt'] = number_format(($payable_amt + $value->delivery_charge),2);

                /*  for order price details  */

                $where_ord = array('order_unique_id' => $order_unique_id);
                $row_full_ord = $this->common_model->selectByids($where_ord, 'tbl_order_details')[0];

                $row_info['opd_price'] = number_format($row_full_ord->total_amt, 2);
                $row_info['opd_discount'] = number_format($row_full_ord->discount_amt, 2);

                $row_info['opd_delivery'] = ($row_full_ord->delivery_charge != 0) ? number_format($row_full_ord->delivery_charge) : $this->lang->line('free_lbl');
                $row_info['opd_amountPayable'] = number_format($row_full_ord->new_payable_amt, 2);

                /*  end order price details  */

                $row_info['current_order_status'] = ($value->order_status == 4) ? 'true' : 'false';

                $row_info['cancel_product'] = ($value->pro_order_status < 4) ? 'true' : 'false';

                $where = array('order_unique_id ' => $order_unique_id);

                $row_refund = $this->common_model->selectByids($where, 'tbl_refund');

                if(!empty($row_refund))
                {
                    $cancel_ord_amt=array_sum(array_column($row_refund,'refund_pay_amt'));

                    $row_info['cancel_order_amt'] = strval($cancel_ord_amt);
                }
                else{
                    $row_info['cancel_order_amt'] = '';
                }

                $row_tran = $this->common_model->selectByids($where, 'tbl_transaction')[0];

                $row_info['payment_mode'] = strtoupper($row_tran->gateway);
                $row_info['payment_id'] = $row_tran->payment_id;

                $row_other_ord = $this->api_model->get_order_other_product($order_unique_id, $product_id);

                $response = array();

                if (!empty($row_other_ord)) {

                    $countCancel=$countDelivery=0;

                    foreach ($row_other_ord as $key2 => $value2) 
                    {

                        $data_arr['order_id'] = $value2->id;
                        $data_arr['order_unique_id'] = $value2->order_unique_id;

                        $data_arr['product_id'] = $value2->product_id;
                        $data_arr['product_title'] = $value2->product_title;

                        $data_arr['product_image'] = base_url() . 'assets/images/products/' . $this->get_product_info($value2->product_id, 'featured_image');

                        $data_arr['order_status'] = $this->common_model->selectByidParam($value2->pro_order_status, 'tbl_status_title', 'title');

                        $data_arr['current_order_status'] = ($value2->pro_order_status < 5) ? 'true' : 'false';

                        if($value2->pro_order_status == 5){
                            $countCancel++;
                        }

                        if($value2->pro_order_status == 4){
                            $countDelivery++;
                        }

                        array_push($response, $data_arr);
                    }

                    if($countCancel==count($row_other_ord) OR $countDelivery==count($row_other_ord))
                    {
                        $row_info['order_other_items_status'] = false;
                    }
                    else{
                        $row_info['order_other_items_status'] = true;
                    }

                    $row_info['order_other_items'] = $response;
                } 
                else {

                    $row_info['order_other_items_status'] = false;

                    $row_info['order_other_items'] = array();
                }

                $response = array();
                $data_arr = array();

                $row = $this->Order_model->get_product_status($value->id, $product_id, $value->user_id);

                if (!empty($row)) 
                {

                    $max_key = max(array_keys($row));

                    $min_key = min(array_keys($row));

                    foreach ($row as $key1 => $value1) {

                        if ($max_key > $min_key) {
                            if ($key1 == $min_key) 
                            {
                                $data_arr['id'] = $value1->id;
                                $data_arr['status_title'] = $this->common_model->selectByidParam($value1->status_title, 'tbl_status_title', 'title');
                                $data_arr['status_desc'] = $value1->status_desc;
                                $data_arr['datetime'] = date('d-m-Y h:i A', $value1->created_at);

                                $data_arr['is_status'] = ($value1->status_title==5) ? 'true' : 'false';

                                array_push($response, $data_arr);
                            }

                            if ($key1 == $max_key) {
                                $data_arr['id'] = $value1->id;
                                $data_arr['status_title'] = $this->common_model->selectByidParam($value1->status_title, 'tbl_status_title', 'title');
                                $data_arr['status_desc'] = $value1->status_desc;
                                $data_arr['datetime'] = date('d-m-Y h:i A', $value1->created_at);

                                $data_arr['is_status'] = ($value1->status_title==5) ? 'true' : 'false';

                                array_push($response, $data_arr);
                            }
                        } else {
                            $data_arr['id'] = $value1->id;
                            $data_arr['status_title'] = $this->common_model->selectByidParam($value1->status_title, 'tbl_status_title', 'title');
                            $data_arr['status_desc'] = $value1->status_desc;
                            $data_arr['datetime'] = date('d-m-Y h:i A', $value1->created_at);

                            $data_arr['is_status'] = 'false';

                            array_push($response, $data_arr);
                        }
                    }

                    if (count($row) == 1) {
                        $data_arr['id'] = '0';
                        $data_arr['status_title'] = $this->lang->line('expected_delivery_lbl');
                        $data_arr['status_desc'] = '';
                        $data_arr['datetime'] = date('d-m-Y', $value->delivery_date);
                        $data_arr['is_status'] = ($value1->status_title==5) ? 'true' : 'false';

                        array_push($response, $data_arr);
                    }

                    $row_info['order_status'] = $response;
                } 
                else {
                    $row_info['order_status'] = array();
                }

                // check refund availability

                $where = array('order_unique_id ' => $order_unique_id, 'product_id ' => $product_id);

                $rowRefund = $this->common_model->selectByids($where, 'tbl_refund');

                if(!empty($rowRefund)){

                    $rowRefund=$rowRefund[0];

                    if($value->pro_order_status==5 AND $row_tran->gateway!='cod'){

                        switch ($rowRefund->request_status) 
                        {
                            case '0':
                              $refund_status=$this->lang->line('refund_pending_lbl');
                              break;
                            case '2':
                              $refund_status=$this->lang->line('refund_process_lbl');
                              break;
                            case '1':
                              $refund_status=$this->lang->line('refund_complete_lbl');
                              break;
                            case '-1':
                              $refund_status=$this->lang->line('refund_wait_lbl');
                        }

                        $row_info['reason'] = $rowRefund->refund_reason;
                        $row_info['refund_status'] = $refund_status;

                        $row_info['is_claim']=($rowRefund->request_status=='-1') ? true : false;

                        $row_info['last_updated'] = date('d-m-Y h:i:s A', $rowRefund->last_updated);
                    }
                    else{
                        $row_info['reason'] = $rowRefund->refund_reason;
                        $row_info['refund_status'] = '';
                        $row_info['is_claim'] = false;
                        $row_info['last_updated'] = '';
                    }
                }
                else{
                    $row_info['reason'] = '';
                    $row_info['refund_status'] = '';
                    $row_info['is_claim'] = false;
                    $row_info['last_updated'] = '';
                }

                $count_items=count($this->common_model->selectByids(array('order_id' => $value->id), 'tbl_order_items'));
                $count_refund_items=count($this->common_model->selectByids(array('order_id' => $value->id, 'request_status' => '-1'), 'tbl_refund'));

                if($count_items==$count_refund_items AND $count_items!=1)
                {
                    $row_info['is_claim'] = false;
                    $row_info['is_order_claim']=true;
                }
                else{
                    $row_info['is_order_claim']=false;
                }

                $row_info['download_invoice'] = base_url('app-download-invoice/' . $order_unique_id);
            }  
        }
        else{
            $row_info['success'] = '0';
            $row_info['msg'] = $this->lang->line('no_data_found_msg');
        }
        

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // for order status 

    public function order_status_post()
    {

        $response = array();

        $order_id = $this->get_param['order_id'];
        $user_id = $this->get_param['user_id'];
        $product_id = $this->get_param['product_id'];

        $row = $this->Order_model->get_product_status($order_id, $product_id, $user_id);

        if (!empty($row)) {
            foreach ($row as $key => $value) {
                $data_arr['id'] = $value->id;
                $data_arr['status_title'] = $this->common_model->selectByidParam($value->status_title, 'tbl_status_title', 'title');
                $data_arr['status_desc'] = $value->status_desc;
                $data_arr['datetime'] = date('d-m-Y h:i A', $value->created_at);

                $data_arr['is_status'] = ($value->status_title==5) ? 'true' : 'false';

                $data_arr['is_delivered'] = ($value->status_title==4) ? 'true' : 'false';
                

                array_push($response, $data_arr);
            }

            $row_info['ECOMMERCE_APP'] = $response;
        } else {
            $row_info['ECOMMERCE_APP'] = array();
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    public function order_or_product_cancel_post()
    {

        $order_id = $this->get_param['order_id'];
        $user_id = $this->get_param['user_id'];
        $product_id = $this->get_param['product_id'];

        $reason = addslashes(trim($this->get_param['reason']));

        $bank_id = $this->get_param['bank_id'];   // default 0

        $this->load->helper("date");

        $where = array('order_id' => $order_id, 'user_id' => $user_id);

        $row_trn = $this->common_model->selectByids($where, 'tbl_transaction')[0];

        $where = array('id' => $order_id, 'user_id' => $user_id);

        $row_ord = $this->common_model->selectByids($where, 'tbl_order_details')[0];

        $actual_pay_amt = ($row_ord->payable_amt - $row_ord->delivery_charge);

        $products_arr=array();

        $refund_amt=$pro_refund_amt=$product_per=$refund_per=$new_payable_amt=$total_refund_amt=$total_refund_per=0;

        if($product_id != '0')
        {
            // for particular product cancel of order

            $where = array('order_id' => $order_id, 'product_id' => $product_id);

            $row_pro = $this->common_model->selectByids($where, 'tbl_order_items');

            foreach ($row_pro as $value) 
            {
                if ($value->pro_order_status != 5) 
                {
                    $product_per = $refund_amt = $refund_per = $new_payable_amt = 0;

                    if ($row_ord->coupon_id != 0) 
                    {
                        $product_per=number_format((double)(($value->total_price/$row_ord->total_amt)*100), 2, '.', '');  //44

                        $refund_per=number_format((double)(($product_per/100)*$row_ord->discount_amt), 2, '.', ''); //22

                        $refund_amt=number_format((double)($value->total_price-$refund_per), 2, '.', '');

                        $new_payable_amt=number_format((double)($row_ord->new_payable_amt-$refund_amt), 2, '.', '');
                    } 
                    else {
                        $refund_amt = $value->total_price;
                        $new_payable_amt = ($row_ord->new_payable_amt - $refund_amt);
                    }

                    if ($row_trn->gateway == 'COD' || $row_trn->gateway == 'cod') {
                        $bank_id = 0;
                        $status = 1;
                    } else {
                        $status = 0;
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
                        'last_updated' => strtotime(date('d-m-Y h:i:s A', now())),
                        'request_status' => $status,
                        'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
                    );

                    $data_update = $this->security->xss_clean($data_arr);

                    $this->common_model->insert($data_update, 'tbl_refund');

                    $where = array('order_id' => $order_id, 'pro_order_status <> ' => 5);

                    if (count($this->common_model->selectByids($where, 'tbl_order_items')) == 1) 
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
                            'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
                        );

                        $data = $this->security->xss_clean($data);

                        $this->common_model->insert($data, 'tbl_order_status');
                    } 
                    else 
                    {

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

                    $this->common_model->update($data_update, $order_id, 'tbl_order_details');

                    $data_pro = array(
                        'pro_order_status' => '5'
                    );

                    $data_pro = $this->security->xss_clean($data_pro);

                    $this->common_model->updateByids($data_pro, array('order_id' => $order_id, 'product_id' => $product_id), 'tbl_order_items');

                    $data = array(
                        'order_id' => $order_id,
                        'user_id' => $user_id,
                        'product_id' => $product_id,
                        'status_title' => '5',
                        'status_desc' => $this->lang->line('pro_ord_cancel'),
                        'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
                    );

                    $data = $this->security->xss_clean($data);

                    $this->common_model->insert($data, 'tbl_order_status');

                    $data_return['order_id'] = $order_id;
                    $data_return['product_id'] = $value->product_id;

                    $data_return['order_status'] = $this->common_model->selectByidParam(5, 'tbl_status_title', 'title');

                    $data_return['current_order_status'] = 'false';

                    $row_info = array('success' => 1, 'msg' => $this->lang->line('pro_ord_cancel'));

                    $row_info['ECOMMERCE_APP'][]=$data_return;

                } else {
                    $row_info = array('success' => 0, 'msg' => $this->lang->line('pro_already_cancelled'));
                }

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
        } 
        else 
        {

            $where = array('order_id' => $order_id, 'pro_order_status <> ' => 5);

            $row_pro = $this->common_model->selectByids($where, 'tbl_order_items');

            $response=array();

            foreach ($row_pro as $value) 
            {   
                $product_per = $new_payable_amt = 0;

                if ($row_ord->coupon_id != 0) 
                {
                    $product_per=number_format((double)(($value->total_price/$row_ord->total_amt)*100), 2, '.', '');  //44

                    $refund_per=number_format((double)(($product_per/100)*$row_ord->discount_amt), 2, '.', ''); //22

                    $refund_amt=number_format((double)($value->total_price-$refund_per), 2, '.', '');

                    $new_payable_amt=number_format((double)($row_ord->new_payable_amt-$refund_amt), 2, '.', '');
                } 
                else {
                    $refund_amt = $value->total_price;
                    $new_payable_amt = ($row_ord->payable_amt - $refund_amt);
                }

                if ($row_trn->gateway == 'COD' || $row_trn->gateway == 'cod') {
                    $bank_id = 0;
                    $status = 1;
                } else {
                    $status = 0;
                }

                $total_refund_amt += $refund_amt;
                $total_refund_per += $refund_per;

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
                    'last_updated' => strtotime(date('d-m-Y h:i:s A', now())),
                    'request_status' => $status,
                    'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
                );

                $data_update = $this->security->xss_clean($data_arr);

                $this->common_model->insert($data_update, 'tbl_refund');

                $data = array(
                    'order_id' => $order_id,
                    'user_id' => $user_id,
                    'product_id' => $value->product_id,
                    'status_title' => '5',
                    'status_desc' => $this->lang->line('pro_ord_cancel'),
                    'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
                );

                $data = $this->security->xss_clean($data);

                $this->common_model->insert($data, 'tbl_order_status');

                $data_pro = array(
                    'pro_order_status' => '5'
                );

                $data_pro = $this->security->xss_clean($data_pro);

                $this->common_model->updateByids($data_pro, array('order_id' => $order_id, 'product_id' => $value->product_id), 'tbl_order_items');

                $data_return['order_id'] = $order_id;

                $data_return['product_id'] = $value->product_id;

                $data_return['order_status'] = $this->common_model->selectByidParam(5, 'tbl_status_title', 'title');

                $data_return['current_order_status'] = 'false';

                array_push($response, $data_return);

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
            $this->common_model->update($data_update, $order_id, 'tbl_order_details');

            $data = array(
                'order_id' => $order_id,
                'user_id' => $user_id,
                'product_id' => '0',
                'status_title' => '5',
                'status_desc' => $this->lang->line('ord_cancel'),
                'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
            );

            $data = $this->security->xss_clean($data);

            $this->common_model->insert($data, 'tbl_order_status');

            $row_info = array('success' => 1, 'msg' => $this->lang->line('ord_cancel'));

            $row_info['ECOMMERCE_APP']=$response;
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
        
        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // claim refund request
    public function claim_refund_post()
    {
        $order_id = $this->get_param['order_id'];
        $user_id = $this->get_param['user_id'];
        $product_id = $this->get_param['product_id'];

        $bank_id = $this->get_param['bank_id'];   // default 0

        $this->load->helper("date");

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

                $row_info = array('success' => 1, 'msg' => $this->lang->line('claim_msg'));
            }
            else{
                $row_info = array('success' => 0, 'msg' => $this->lang->line('no_data_found_msg'));   
            }
        }
        else
        {
            // claim for whole order

            if(count($this->common_model->selectByids(array('order_id' => $order_id, 'user_id' => $user_id), 'tbl_refund')))
            {
                $this->common_model->updateByids($data_pro, array('order_id' => $order_id, 'user_id' => $user_id),'tbl_refund');

                $row_info = array('success' => 1, 'msg' => $this->lang->line('claim_msg'));
            }
            else{
                $row_info = array('success' => 0, 'msg' => $this->lang->line('no_data_found_msg'));   
            }
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // get contact subject list
    public function contact_subjects_post()
    {

        $response = array();

        $row = $this->common_model->select('tbl_contact_sub', 'DESC');

        foreach ($row as $key => $value) {

            $data_arr['id'] = $value->id;
            $data_arr['subject'] = $value->title;

            array_push($response, $data_arr);
        }

        $row_info = array('ECOMMERCE_APP' => $response);

        if(isset($this->get_param['user_id']) && $this->get_param['user_id']!=0){
            $row_info['name']=$this->common_model->selectByidParam($this->get_param['user_id'], 'tbl_users', 'user_name');
            $row_info['email']=$this->common_model->selectByidParam($this->get_param['user_id'], 'tbl_users', 'user_email');
        }
        else{
            $row_info['name']='';
            $row_info['email']='';
        }
        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    //submit contact form
    public function contact_form_post()
    {

        $data_arr = array(
            'contact_name' => $this->get_param['contact_name'],
            'contact_email' => $this->get_param['contact_email'],
            'contact_subject' => addslashes($this->get_param['contact_subject']),
            'contact_msg' => addslashes($this->get_param['contact_msg']),
            'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
        );

        $data_usr = $this->security->xss_clean($data_arr);

        $last_id = $this->common_model->insert($data_usr, 'tbl_contact_list');

        $data_arr = array_merge($data_arr, array("subject" => $this->common_model->selectByidParam($this->get_param['contact_subject'], 'tbl_contact_sub', 'title')));;

        $admin_name=$this->common_model->selectByidsParam(array('id' => 1),'tbl_admin','username');

        $subject = $this->app_name.'-'.$this->lang->line('contact_form_lbl');

        $body = $this->load->view('admin/emails/contact_form.php',$data_arr,TRUE);

        if(send_email($this->contact_email, $admin_name, $subject, $body))
        {
            $row_info = array('success' => '1', 'msg' => $this->lang->line('contact_msg_success'));
        }
        else {
            $row_info = array('success' => '0', 'msg' => $this->lang->line('error_data_save'));
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }


    //product review and ratings

    public function users_review_post()
    {

        $response = array();
        $row_info = array();

        $product_id=$this->get_param['product_id'];

        if (isset($this->get_param['page'])) {
            $start = ($this->get_param['page'] - 1) * $this->api_page_limit;
        } else {
            $start = 0;
        }

        $where = array('product_id ' => $product_id);

        $filter_type=(isset($this->get_param['filter_type'])) ? $this->get_param['filter_type'] : 'newest';

        $row=$this->api_model->get_product_review($product_id, $filter_type, $this->api_page_limit, $start);

        foreach ($row as $key => $value) {
            $data_arr['id'] = $value->id;

            $data_arr['user_name'] = $this->common_model->selectByidParam($value->user_id, 'tbl_users', 'user_name');

            $user_img = $this->common_model->selectByidParam($value->user_id, 'tbl_users', 'user_image');

            if ($user_img == '' or !file_exists('assets/images/users/' . $user_img)) {
                $user_img = base_url('assets/images/photo.jpg');
            } else {

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $user_img);

                $user_img = base_url() . $this->_create_thumbnail('assets/images/users/', $thumb_img_nm, $user_img, 200, 200);
            }

            $data_arr['user_image'] = $user_img;

            $data_arr['user_rate'] = $value->rating;
            $data_arr['rate_desc'] = $value->rating_desc;
            $data_arr['rate_date'] = date('d-m-Y', $value->created_at);

            $where = array('parent_id' => $value->id, 'type' => 'review');

            $img_arr = array();

            if ($row_img = $this->common_model->selectByids($where, 'tbl_product_images')) {
                foreach ($row_img as $key2 => $value2) {
                    $data_arr2['id'] = $value2->id;
                    $data_arr2['image'] = base_url() . 'assets/images/review_images/' . $value2->image_file;;

                    $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value2->image_file);

                    $img_file = $this->_create_thumbnail('assets/images/review_images/', $thumb_img_nm, $value2->image_file, 200, 200);

                    $data_arr2['image_path_thumb'] = base_url() . $img_file;

                    array_push($img_arr, $data_arr2);
                }
            }

            $data_arr['reviews_images'] = $img_arr;

            array_push($response, $data_arr);
        }

        $row_info['reviews'] = $response;

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }


    public function my_review_post()
    {
        $user_id = $this->get_param['user_id'];

        $product_id = $this->get_param['product_id'];

        $response = array();
        $row_info = array();

        $response['success'] = '1';
        $response['msg'] = '';

        $response['product_title'] = $this->get_product_info($product_id, 'product_title');
        $response['product_image'] = base_url() . 'assets/images/products/' . $this->get_product_info($product_id, 'featured_image');

        $where = array('user_id' => $user_id, 'product_id' => $product_id);

        if($row = $this->common_model->selectByids($where, 'tbl_rating')) {
            $response['review_id'] = $row[0]->id;
            $response['rate'] = $row[0]->rating;
            $response['rating_desc'] = $row[0]->rating_desc;
            $response['rating_date'] = date('d-m-Y', $row[0]->created_at);

            $where_1 = array('parent_id' => $row[0]->id, 'type' => 'review');

            if ($row_img = $this->common_model->selectByids($where_1, 'tbl_product_images')) {
                foreach ($row_img as $key => $value) {
                    $data_img['id'] = $value->id;
                    $data_img['image'] = base_url() . 'assets/images/review_images/' . $value->image_file;

                    $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->image_file);

                    $img_file = $this->_create_thumbnail('assets/images/review_images/', $thumb_img_nm, $value->image_file, 200, 200);
                    $data_img['image_path_thumb'] = base_url() . $img_file;

                    array_push($row_info, $data_img);
                }
                $response['ECOMMERCE_APP'] = $row_info;
            } else {
                $response['ECOMMERCE_APP'] = $row_info;
            }
        } else {

            $response['success'] = '0';
            $response['msg'] = $this->lang->line('no_data_found_msg');

            $response['review_id'] = '';
            $response['rate'] = '0';
            $response['rating_desc'] = '';
            $response['rating_date'] = '';
            $response['ECOMMERCE_APP'] = $row_info;
        }

        $this->set_response($response, REST_Controller::HTTP_OK);
    }

    public function product_review_post()
    {

        $user_id = $this->get_param['user_id'];
        $product_id = $this->get_param['product_id'];

        $review_desc = $this->get_param['review_desc'];
        $rate = $this->get_param['rate'];

        $where = array('user_id' => $user_id, 'product_id' => $product_id, 'pro_order_status' => '4');

        $row_ord = $this->common_model->selectByids($where, 'tbl_order_items');

        if (!empty($row_ord)) {

            $where = array('user_id' => $user_id, 'product_id' => $product_id);

            $row = $this->common_model->selectByids($where, 'tbl_rating');

            if (empty($row)) {

                $data_arr = array(
                    'product_id' => $product_id,
                    'user_id' => $user_id,
                    'order_id' => $row_ord[0]->order_id,
                    'rating' => $rate,
                    'rating_desc' => addslashes(trim($review_desc)),
                    'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
                );

                $data_usr = $this->security->xss_clean($data_arr);

                $review_id = $this->common_model->insert($data_usr, 'tbl_rating');

                if (!empty($_FILES['product_images'])) {
                    $files = $_FILES;
                    $cpt = count($_FILES['product_images']['name']);
                    for ($i = 0; $i < $cpt; $i++) {
                        $_FILES['product_images']['name'] = $files['product_images']['name'][$i];
                        $_FILES['product_images']['type'] = $files['product_images']['type'][$i];
                        $_FILES['product_images']['tmp_name'] = $files['product_images']['tmp_name'][$i];
                        $_FILES['product_images']['error'] = $files['product_images']['error'][$i];
                        $_FILES['product_images']['size'] = $files['product_images']['size'][$i];

                        $image = date('dmYhis') . '_' . rand(0, 99999) . "." . pathinfo($files['product_images']['name'][$i], PATHINFO_EXTENSION);

                        $config['file_name'] = $image;

                        // File upload configuration
                        $uploadPath = 'assets/images/review_images/';
                        $config['upload_path'] = $uploadPath;
                        $config['allowed_types'] = 'jpg|jpeg|png|gif';

                        // Load and initialize upload library
                        $this->load->library('upload');
                        $this->upload->initialize($config);

                        if ($this->upload->do_upload('product_images')) {

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

                $row_info = array('success' => '1', 'msg' => $this->lang->line('review_submit'), 'rate' => $rate);
            } else {

                $data_arr = array(
                    'product_id' => $product_id,
                    'user_id' => $user_id,
                    'order_id' => $row_ord[0]->order_id,
                    'rating' => $rate,
                    'rating_desc' => addslashes($review_desc)
                );

                $data_usr = $this->security->xss_clean($data_arr);

                $this->common_model->update($data_usr, $row[0]->id, 'tbl_rating');

                $review_id = $row[0]->id;

                if (!empty($_FILES['product_images'])) {
                    $files = $_FILES;
                    $cpt = count($_FILES['product_images']['name']);
                    for ($i = 0; $i < $cpt; $i++) {

                        $_FILES['product_images']['name'] = $files['product_images']['name'][$i];
                        $_FILES['product_images']['type'] = $files['product_images']['type'][$i];
                        $_FILES['product_images']['tmp_name'] = $files['product_images']['tmp_name'][$i];
                        $_FILES['product_images']['error'] = $files['product_images']['error'][$i];
                        $_FILES['product_images']['size'] = $files['product_images']['size'][$i];

                        $image = date('dmYhis') . '_' . rand(0, 99999) . "." . pathinfo($files['product_images']['name'][$i], PATHINFO_EXTENSION);

                        $config['file_name'] = $image;

                        // File upload configuration
                        $uploadPath = 'assets/images/review_images/';
                        $config['upload_path'] = $uploadPath;
                        $config['allowed_types'] = 'jpg|jpeg|png|gif';

                        // Load and initialize upload library
                        $this->load->library('upload');
                        $this->upload->initialize($config);

                        if ($this->upload->do_upload('product_images')) {

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

                $row_info = array('success' => '1', 'msg' => $this->lang->line('review_updated'), 'rate' => $rate);
            }
        } else {
            $row_info = array('success' => '0', 'msg' => $this->lang->line('not_buy_product'));
        }


        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    public function remove_review_image_post()
    {

        $image_id = $this->get_param['image_id'];

        $where_1 = array('id' => $image_id, 'type' => 'review');

        $row = $this->common_model->selectByids($where_1, 'tbl_product_images');

        if (file_exists('assets/images/review_images/' . $row[0]->image_file)) {
            unlink('assets/images/review_images/' . $row[0]->image_file);
            $mask = $row[0]->id . '*_*';
            array_map('unlink', glob('assets/images/review_images/thumbs/' . $mask));

            $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row[0]->image_file);
            $mask = $thumb_img_nm.'*_*';
            array_map('unlink', glob('assets/images/review_images/thumbs/'.$mask));
        }

        $this->common_model->delete($image_id, 'tbl_product_images');

        $row_info = array('success' => '1', 'msg' => $this->lang->line('delete_success'));

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // order placed process

    public function order_summary_post()
    {

        $response = array();

        $user_id=$this->get_param['user_id'];

        $total_amt = $delivery_charge = $you_save = 0;
        $cart_ids = $cart_id = '';

        $row_info['success'] = '1';
        $row_info['msg'] = '';

        $cart_type='';

        if($this->get_param['buy_now']=='true')
        {
            $cart_type='temp_cart';

            $product_id=addslashes(trim($this->get_param['product_id']));
            $qty=1;
            $size=addslashes(trim($this->get_param['product_size']));
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

            $device_id=$this->get_param['device_id'];

            $where = array('user_id' => $user_id, 'product_id' => $product_id, 'cart_unique_id' => $device_id);

            $this->common_model->deleteByids($where, 'tbl_cart_tmp');

            $data_arr = array(
                'product_id' => $product_id,
                'user_id' => $user_id,
                'product_qty' => $qty,
                'product_size' => $size,
                'cart_unique_id' => $device_id,
                'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
            );

            $data_usr = $this->security->xss_clean($data_arr);

            $cart_id=$this->common_model->insert($data_usr, 'tbl_cart_tmp');
        }
        else{

            $cart_type='main_cart';

            $cart_exist = $this->api_model->get_cart($user_id);

            if (empty($cart_exist)){
                // no cart items found
                $row_info = array('success' => '0', 'msg' => $this->lang->line('ord_placed_empty_lbl'));
                $this->set_response($row_info, REST_Controller::HTTP_OK);
            }
        }

        // to get default address of user
        if($address_arr = $this->common_model->get_addresses($user_id, true)) {

            $address_arr = $address_arr[0];

            $row_info['address_id'] = $address_arr->id;
            $row_info['address'] = $address_arr->building_name . ', ' . $address_arr->road_area_colony . ', ' . $address_arr->city . ', ' . $address_arr->state . ', ' . $address_arr->country . ' - ' . $address_arr->pincode;

            $row_info['name'] = $address_arr->name;
            $row_info['mobile_no'] = $address_arr->mobile_no;
            $row_info['address_type'] = ($address_arr->address_type==1) ? $this->lang->line('home_address_val_lbl') : $this->lang->line('office_address_val_lbl');
        } 
        else 
        {
            $row_info['address_id'] = '';
            $row_info['address'] = '';
            $row_info['name'] = '';
            $row_info['mobile_no'] = '';
            $row_info['address_type'] = '';
        }

        if($this->get_param['buy_now']=='true'){
            // for user's perticular item
            $row_cart = $this->api_model->get_cart($user_id, $cart_id,'DESC','0',array('cart_status' => 1));
        }
        else{
            // for user's all items
            $row_cart = $this->api_model->get_cart($user_id,'','DESC','0',array('cart_status' => 1));
        }

        if(!empty($row_cart))
        {

            foreach($row_cart as $value) {

                $data_arr['id'] = $value->id;

                $data_arr['product_id'] = $value->product_id;
                $data_arr['user_id'] = $value->user_id;

                $data_arr['product_qty'] = $value->product_qty;
                $data_arr['max_unit_buy'] = $value->max_unit_buy;

                $data_arr['product_title'] = $value->product_title;

                $data_arr['product_image'] = base_url() . 'assets/images/products/' . $value->featured_image;

                $data_arr['product_size'] = ($value->product_size!='0') ? $value->product_size : '';

                $total_mrp = ($this->get_product_info($value->product_id, 'selling_price') * $value->product_qty);

                $data_ofr = $this->calculate_offer($this->get_product_info($value->product_id, 'offer_id'), $total_mrp);

                $arr_ofr = json_decode($data_ofr);

                $data_arr['product_mrp'] = number_format($value->product_mrp * $value->product_qty,2);

                $data_arr['product_sell_price'] = number_format($value->selling_price * $value->product_qty,2);

                $data_arr['you_save'] = number_format($value->you_save_amt * $value->product_qty,2);
                
                $data_arr['you_save_per'] = $arr_ofr->you_save_per . ' ' . $this->lang->line('per_off_lbl');

                $data_arr['delivery_charge'] = ($value->delivery_charge != 0) ? CURRENCY_CODE . ' ' . number_format($value->delivery_charge,2) : $this->lang->line('free_lbl');

                array_push($response, $data_arr);

                $total_amt += ($value->selling_price * $value->product_qty);

                $delivery_charge += $value->delivery_charge;

                $you_save += ($value->you_save_amt * $value->product_qty);

                $cart_ids .= $value->id . ',';
            }

            $row_info['order_summary'] = $response;

        }
        else {
            $row_info['order_summary'] = $response;
        }

        $where=array('user_id' => $user_id, 'cart_type' => $cart_type, 'cart_id' => $cart_ids);

        $row_coupon=$this->common_model->selectByids($where,'tbl_applied_coupon');

        if(count($row_coupon)==0){
            $coupon_id=0;
        }
        else{
            $coupon_id=$row_coupon[0]->coupon_id;
        }

        if($coupon_id==0){
            $discount=0;
            $discount_amt=0;
            $payable_amt=number_format((float)($total_amt), 2, '.', '') + number_format((float)$delivery_charge, 2, '.', '');
        }
        else{

            $coupon_json=json_decode($this->inner_apply_coupon($user_id, $coupon_id));
            $discount=$coupon_json->discount;
            $discount_amt=$coupon_json->discount_amt;
            $payable_amt=$coupon_json->payable_amt;
        }

        $you_save=$you_save+$discount_amt;

        $row_info['cart_ids'] = strval(rtrim($cart_ids, ','));
        $row_info['total_item'] = strval(count($row_cart));
        $row_info['cart_items'] = strval(count($this->api_model->get_cart($this->get_param['user_id'])));
        $row_info['price'] = number_format($total_amt, 2);
        $row_info['delivery_charge'] = ($delivery_charge != 0) ? number_format($delivery_charge, 2) : $this->lang->line('free_lbl');

        $row_info['payable_amt'] = number_format($payable_amt, 2);

        $row_info['you_save'] = number_format($you_save, 2);

        if ($you_save != 0) {
            $row_info['you_save_msg'] = str_replace('###', CURRENCY_CODE . ' ' . number_format($you_save, 2), $this->lang->line('coupon_save_msg_lbl'));
        } else {
            $row_info['you_save_msg'] = '';
        }

        $row_info['coupon_id'] = strval($coupon_id);

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    public function remove_temp_cart_post()
    {

        $user_id=$this->get_param['user_id'];
        $device_id=$this->get_param['device_id'];

        if($user_id!=0)
        {
            $where = array('user_id' => $user_id, 'cart_unique_id' => $device_id);
            $cart_id=$this->common_model->selectByidsParam($where, 'tbl_cart_tmp', 'id');

            $this->common_model->deleteByids($where, 'tbl_cart_tmp');

            $where = array('user_id' => $user_id, 'cart_id' => $cart_id);
            $this->common_model->deleteByids($where, 'tbl_applied_coupon');
        }

        $row_info = array('success' => '1', 'msg' => $this->lang->line('cart_empty_msg'));

        $this->set_response($data_info, REST_Controller::HTTP_OK);
    }

    //payment success
    public function payment_post()
    {
        $response = array();

        $cart_type = trim($this->get_param['cart_type']);   // main_cart/temp_cart
        $user_id = trim($this->get_param['user_id']);
        $cart_ids=$this->get_param['cart_ids'];
        $coupon_id = trim($this->get_param['coupon_id']);
        $order_address = trim($this->get_param['address_id']);

        $payment_method = trim($this->get_param['gateway']);
        $payment_id = trim($this->get_param['payment_id']);
        $razorpay_order_id = trim($this->get_param['razorpay_order_id']);

        $row_address=$this->common_model->selectByid($order_address, 'tbl_addresses');

        if(!empty($row_address))
        {
            $products_arr=array();
            $data_email=array();

            $total_cart_amt=$delivery_charge=$you_save=0;

            $order_unique_id = 'ORD' . $this->get_order_unique_id() . rand(0, 1000);

            $is_avail=true;

            if($cart_type=='main_cart')
            {
                // from main cart table

                $my_cart=$this->api_model->get_cart($user_id);

                if(!empty($my_cart))
                {
                    try {

                        $where=array('user_id' => $user_id, 'cart_type' => $cart_type);

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

                        if(!$is_avail && $payment_method=='cod'){
                            $row_info = array('success' => '2', 'msg' => $this->lang->line('some_product_unavailable_lbl'));
                            $this->set_response($row_info, REST_Controller::HTTP_OK);
                            return;
                        }

                        if($coupon_id==0){
                            $discount=0;
                            $discount_amt=0;
                            $payable_amt=($total_cart_amt+$delivery_charge);
                        }
                        else{

                            $coupon_json=json_decode($this->inner_apply_coupon($user_id, $coupon_id));
                            $discount=$coupon_json->discount;
                            $discount_amt=$coupon_json->discount_amt;
                            $payable_amt=$coupon_json->payable_amt;
                        }

                        $data_arr = array(
                            'user_id' => $user_id,
                            'coupon_id' => $coupon_id,
                            'order_unique_id' => $order_unique_id,
                            'order_address' => $order_address,
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
                            'email' => $this->common_model->selectByidsParam(array('id' => $user_id), 'tbl_users', 'user_email'),
                            'order_id' => $order_id,
                            'order_unique_id' => $order_unique_id,
                            'gateway' => $payment_method,
                            'payment_amt' => $payable_amt,
                            'payment_id' => $payment_id,
                            'razorpay_order_id' => $razorpay_order_id,
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

                        if(send_email($row_address->email, $row_address->name, $subject, $body))
                        {

                           if($this->order_email!='')
                           {
                                $subject = $this->app_name.' - '.$this->lang->line('new_ord_lbl');

                                $body = $this->load->view('emails/admin_order_summary.php',$data_email,TRUE);

                                send_email($this->order_email, $admin_name, $subject, $body);
                            } 
                        }
                        else
                        {
                            $row_info=array('success' => '0','msg' => $this->lang->line('email_not_sent'), 'order_unique_id' => $order_unique_id, 'error' => $this->email->print_debugger());
                        }


                        $row_info = array('success' => '1', 'msg' => $this->lang->line('payment_success'), 'title' => $this->lang->line('ord_placed_lbl'), 'thank_you_msg' => $this->lang->line('thank_you_ord_lbl'), 'ord_confirm_msg' => $this->lang->line('ord_confirm_lbl'), 'order_unique_id' => $order_unique_id);

                        $this->common_model->deleteByids(array('user_id' => $user_id, 'cart_type' => 'main_cart'),'tbl_applied_coupon');
                        
                    } 
                    catch (Exception $e) 
                    {
                        // something went to wrong
                        $row_info = array('success' => '0', 'msg' => $this->lang->line('something_went_wrong_err'));
                    }
                }
                else{
                    // no cart items found
                    $row_info = array('success' => '2', 'msg' => $this->lang->line('ord_placed_empty_lbl'));
                }
            }
            else if($cart_type=='temp_cart'){
                // from temp cart table

                $my_cart=$this->api_model->get_cart($user_id, $cart_ids);

                if(!empty($my_cart))
                {

                    try {

                        $where=array('user_id' => $user_id, 'cart_type' => $cart_type, 'cart_id' => $cart_ids);

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

                        if(!$is_avail && $payment_method=='cod')
                        {
                            $row_info = array('success' => '2', 'msg' => $this->lang->line('product_unavailable_lbl'));
                            $this->set_response($row_info, REST_Controller::HTTP_OK);
                            return;
                        }

                        if($coupon_id==0){
                            $discount=0;
                            $discount_amt=0;
                            $payable_amt=($total_cart_amt+$delivery_charge);
                        }
                        else{

                            $coupon_json=json_decode($this->inner_apply_coupon($user_id, $coupon_id, $cart_ids, 'temp_cart'));
                            $discount=$coupon_json->discount;
                            $discount_amt=$coupon_json->discount_amt;
                            $payable_amt=$coupon_json->payable_amt;
                        }

                        $data_arr = array(
                            'user_id' => $user_id,
                            'coupon_id' => $coupon_id,
                            'order_unique_id' => $order_unique_id,
                            'order_address' => $order_address,
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
                            $p_items['product_price']=number_format($product_mrp,2);
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
                            'email' => $this->common_model->selectByidsParam(array('id' => $user_id), 'tbl_users', 'user_email'),
                            'order_id' => $order_id,
                            'order_unique_id' => $order_unique_id,
                            'gateway' => $payment_method,
                            'payment_amt' => $payable_amt,
                            'payment_id' => $payment_id,
                            'razorpay_order_id' => $razorpay_order_id,
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
                            $row_info=array('success' => '0','msg' => $this->lang->line('email_not_sent'), 'order_unique_id' => $order_unique_id, 'error' => $this->email->print_debugger());
                        }


                        $row_info = array('success' => '1', 'msg' => $this->lang->line('payment_success'), 'title' => $this->lang->line('ord_placed_lbl'), 'thank_you_msg' => $this->lang->line('thank_you_ord_lbl'), 'ord_confirm_msg' => $this->lang->line('ord_confirm_lbl'), 'order_unique_id' => $order_unique_id);


                        $this->common_model->deleteByids(array('user_id' => $user_id, 'cart_type' => 'temp_cart'),'tbl_applied_coupon');
                        
                    } catch (Exception $e) {
                        // something went to wrong
                        $row_info = array('success' => '0', 'msg' => $this->lang->line('something_went_wrong_err'));
                    }
                }
                else{
                    // no cart items found
                    $row_info = array('success' => '2', 'msg' => $this->lang->line('ord_placed_empty_lbl'));
                }
            }

            $this->common_model->deleteByids(array('user_id' => $user_id, 'cart_type' => $cart_type),'tbl_applied_coupon');
        }
        else{
            // no address found
            $row_info = array('success' => '0', 'msg' => $this->lang->line('no_address_found'));
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    public function email_verify_post()
    {

        $response = array();

        $user_name=addslashes(trim($this->get_param['name']));
        $user_email=addslashes(trim($this->get_param['email']));

        if($this->checkSpam($user_email)){
            $email = $this->common_model->check_email($user_email);

            if (empty($email)) {

                $data_arr = array(
                    'name' => $user_name,
                    'email' => $user_email,
                    'otp' => trim($this->get_param['otp'])
                );

                $subject = $this->app_name.' - '.$this->lang->line('email_verify_heading_lbl');

                $body = $this->load->view('admin/emails/email_verify.php',$data_arr,TRUE);

                if(send_email($user_email, $user_name, $subject, $body))
                {
                    $row_info = array('success' => '1', 'msg' => $this->lang->line('verification_code_sent'));
                }
                else
                {
                    $row_info = array('success' => '0', 'msg' => $this->lang->line('email_not_sent'));
                }
            } 
            else {
                $row_info = array('success' => '0', 'msg' => $this->lang->line('email_exist'));
            }
        }
        else{
            $row_info=array('success' => '0','msg' => $this->lang->line('invalid_email_format'));
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    public function register_post()
    {

        $response = array();

        $user_type = ucfirst($this->get_param['type']);

        $user_name = addslashes(trim($this->get_param['name']));
        $user_email = addslashes(trim($this->get_param['email']));

        $register_platform = addslashes(trim($this->get_param['register_platform']));   // web/android

        switch ($user_type) {
            case ($user_type == 'Normal'): {
                    // register in normal way

                    $user_phone = addslashes(trim($this->get_param['phone']));

                    // check email exist
                    $row_user = $this->common_model->check_email($user_email, $user_type);

                    if (empty($row_user)) {

                        $data_arr = array(
                            'user_type' => $user_type,
                            'user_name' => $user_name,
                            'user_email' => $user_email,
                            'user_phone' => $user_phone,
                            'user_password' => md5(trim($this->get_param['password'])),
                            'device_id' => trim($this->get_param['device_id']),
                            'register_platform' => $register_platform,
                            'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
                        );

                        $data_usr = $this->security->xss_clean($data_arr);

                        $user_id = $this->common_model->insert($data_usr, 'tbl_users');

                        $data_register_mail = array(
                            'register_type' => 'Normal',
                            'user_name' => $user_name
                        );

                        $subject = $this->app_name.' - '.$this->lang->line('register_mail_lbl');

                        $body = $this->load->view('emails/welcome_mail.php',$data_register_mail,TRUE);

                        send_email($user_email, $user_name, $subject, $body);

                        $row_info = array('success' => '1', 'msg' => $this->lang->line('register_success'));
                    } 
                    else 
                    {
                        $row_info = array('success' => '0', 'msg' => $this->lang->line('email_exist'));
                    }
                }
                break;

            case ($user_type == 'Google'): {
                    // register with google

                    $auth_id = addslashes(trim($this->get_param['auth_id']));

                    // check email exist
                    $row_user = $this->common_model->check_email($user_email, $user_type, $auth_id);

                    if (empty($row_user)) {
                        $data_arr = array(
                            'user_type' => $user_type,
                            'user_name' => $user_name,
                            'user_email' => $user_email,
                            'device_id' => trim($this->get_param['device_id']),
                            'auth_id' => $auth_id,
                            'register_platform' => $register_platform,
                            'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
                        );

                        $data_usr = $this->security->xss_clean($data_arr);

                        $user_id = $this->common_model->insert($data_usr, 'tbl_users');

                        $data_register_mail = array(
                            'register_type' => 'Google',
                            'user_name' => $user_name
                        );

                        $subject = $this->app_name.' - '.$this->lang->line('register_mail_lbl');

                        $body = $this->load->view('emails/welcome_mail.php',$data_register_mail,TRUE);

                        send_email($user_email, $user_name, $subject, $body);

                        $row_info['success'] = 1;
                        $row_info['msg'] = $this->lang->line('login_success');

                        $row_info['user_id'] = $user_id;
                        $row_info['name'] = $user_name;
                        $row_info['email'] = $user_email;
                        $row_info['auth_id'] = $auth_id;
                        $row_info['user_image'] = '';
                    } 
                    else {

                        $updateData = array(
                            'auth_id'  =>  $auth_id,
                        );

                        $this->common_model->update($updateData, $row_user[0]->id, 'tbl_users');

                        $row_info['success'] = 1;
                        $row_info['msg'] = $this->lang->line('login_success');

                        $row_info['user_id'] = $row_user[0]->id;
                        $row_info['name'] = $row_user[0]->user_name;
                        $row_info['email'] = $row_user[0]->user_email;
                        $row_info['auth_id'] = $row_user[0]->auth_id;

                        $user_img = $row_user[0]->user_image;

                        if ($user_img == '' or !file_exists('assets/images/users/' . $user_img)) {
                            $user_img = base_url('assets/images/photo.jpg');
                        } else {

                            $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $user_img);
                            $user_img = base_url() . $this->_create_thumbnail('assets/images/users/', $thumb_img_nm, $user_img, 200, 200);
                        }

                        $curr_date=date('d-m-Y');

                        $this->common_model->deleteByids(array('user_id' => $row_user[0]->id, "DATE_FORMAT(FROM_UNIXTIME(`created_at`), '%e-%l-%Y') <" => $curr_date), 'tbl_cart_tmp');

                        $row_info['user_image'] = $user_img;
                    }
                }
                break;

            case ($user_type == 'Facebook'): {
                    // register with facebook

                    $auth_id = addslashes(trim($this->get_param['auth_id']));

                    // check email exist
                    $row_user = $this->common_model->check_email($user_email, $user_type, $auth_id);

                    if (empty($row_user)) {
                        $data_arr = array(
                            'user_type' => $user_type,
                            'user_name' => $user_name,
                            'user_email' => $user_email,
                            'device_id' => trim($this->get_param['device_id']),
                            'auth_id' => $auth_id,
                            'register_platform' => $register_platform,
                            'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
                        );

                        $data_usr = $this->security->xss_clean($data_arr);

                        $user_id = $this->common_model->insert($data_usr, 'tbl_users');

                        if($user_email!=''){
                            $data_register_mail = array(
                                'register_type' => 'Facebook',
                                'user_name' => $user_name
                            );

                            $subject = $this->app_name.' - '.$this->lang->line('register_mail_lbl');

                            $body = $this->load->view('emails/welcome_mail.php',$data_register_mail,TRUE);

                            send_email($user_email, $user_name, $subject, $body);
                        }

                        $row_info['success'] = 1;
                        $row_info['msg'] = $this->lang->line('login_success');

                        $row_info['user_id'] = $user_id;
                        $row_info['name'] = $user_name;
                        $row_info['email'] = $user_email;
                        $row_info['auth_id'] = $auth_id;
                        $row_info['user_image'] = '';
                    }
                    else 
                    {

                        $updateData = array(
                            'auth_id'  =>  $auth_id,
                        );

                        $this->common_model->update($updateData, $row_user[0]->id, 'tbl_users');

                        $row_info['success'] = 1;
                        $row_info['msg'] = $this->lang->line('login_success');

                        $row_info['user_id'] = $row_user[0]->id;
                        $row_info['name'] = $row_user[0]->user_name;
                        $row_info['email'] = $row_user[0]->user_email;
                        $row_info['auth_id'] = $row_user[0]->auth_id;
                        
                        $user_img = $row_user[0]->user_image;

                        if ($user_img == '' or !file_exists('assets/images/users/' . $user_img)) {
                            $user_img = base_url('assets/images/photo.jpg');
                        } else {

                            $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $user_img);
                            $user_img = base_url() . $this->_create_thumbnail('assets/images/users/', $thumb_img_nm, $user_img, 200, 200);
                        }

                        $curr_date=date('d-m-Y');

                        $this->common_model->deleteByids(array('user_id' => $row_user[0]->id, "DATE_FORMAT(FROM_UNIXTIME(`created_at`), '%e-%l-%Y') <" => $curr_date), 'tbl_cart_tmp');

                        $row_info['user_image'] = $user_img;
                    }
                }
                break;

            default:
                $row_info = array('success' => '0', 'msg' => $this->lang->line('type_invalid'));
                break;
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // user's login code
    public function login_post()
    {

        $response = array();

        if(isset($this->get_param['user_id'])){

            $user_id=$this->get_param['user_id'];

            $row_user=$this->common_model->selectByid($user_id, 'tbl_users');

            if($row_user->status!=1){
                $row_info = array('status' => 1,'success' => 0, 'msg' => $this->lang->line('account_deactive'));
            }
            else
            {
                $curr_date=date('d-m-Y');

                $this->common_model->deleteByids(array('user_id' => $row_user->id, "DATE_FORMAT(FROM_UNIXTIME(`created_at`), '%e-%l-%Y') <" => $curr_date), 'tbl_cart_tmp');

                $row_info = array('success' => 1, 'msg' => $this->lang->line('login_success'));
            }
            $this->set_response($row_info, REST_Controller::HTTP_OK);
            return;
        }

        $user_type = 'Normal';

        $user_email = addslashes(trim($this->get_param['email']));

        // check email exist
        $user_info = $this->common_model->check_email($user_email, $user_type);

        if(!empty($user_info)) {

            if ($user_info[0]->status == 1) {
                $password = md5($this->get_param['password']);

                if ($user_info[0]->user_password == $password) {

                    $curr_date=date('d-m-Y');

                    $this->common_model->deleteByids(array('user_id' => $user_info[0]->id, "DATE_FORMAT(FROM_UNIXTIME(`created_at`), '%e-%l-%Y') <" => $curr_date), 'tbl_cart_tmp');

                    $row_info['success'] = 1;
                    $row_info['msg'] = $this->lang->line('login_success');

                    $row_info['user_id'] = $user_info[0]->id;
                    $row_info['name'] = $user_info[0]->user_name;
                    $row_info['email'] = $user_info[0]->user_email;
                    $row_info['phone'] = $user_info[0]->user_phone;
                    
                    $user_img = $user_info[0]->user_image;

                    if ($user_img == '' or !file_exists('assets/images/users/' . $user_img)) {
                        $user_img = base_url('assets/images/photo.jpg');
                    } else {

                        $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $user_img);
                        $user_img = base_url() . $this->_create_thumbnail('assets/images/users/', $thumb_img_nm, $user_img, 200, 200);
                    }

                    $row_info['user_image'] = $user_img;
                } 
                else {
                    $row_info = array('success' => '0', 'msg' => $this->lang->line('invalid_password'));
                }
            } else {

                $row_info = array('success' => '0', 'msg' => $this->lang->line('account_deactive'));
            }
        }
        else {
            $row_info = array('success' => '0', 'msg' => $this->lang->line('email_not_found'));
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // user's forgot password code
    public function forgot_password_post()
    {

        $response = array();

        $user_info = $this->common_model->check_email($this->get_param['email'])[0];

        if (!empty($user_info)) 
        {

            $this->load->helper("rendomPassword");

            $info['new_password'] = get_random_password();

            $updateData = array(
                'user_password' => md5($info['new_password'])
            );

            $data_arr = array(
                'email' => $user_info->user_email,
                'password' => $info['new_password']
            );

            if ($this->common_model->update($updateData, $user_info->id, 'tbl_users')) {

                $subject = $this->app_name . ' - ' . $this->lang->line('forgot_password_lbl');

                $body = $this->load->view('admin/emails/forgot_password.php', $data_arr, TRUE);

                if (send_email($user_info->user_email, $user_info->user_name, $subject, $body)) 
                {
                    $row_info = array('success' => '1', 'msg' => $this->lang->line('password_sent_mail'));
                } 
                else 
                {
                    $row_info = array('success' => '0', $this->lang->line('email_not_sent'));
                }
            }
        }
        else 
        {
            $row_info = array('success' => '0', 'msg' => $this->lang->line('email_not_found'));
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // user's profile
    public function profile_post()
    {

        $response = array();

        $user_id = $this->get_param['user_id'];

        $row = $this->common_model->selectByid($user_id, 'tbl_users');

        if ($row) {
            $row_info['success'] = '1';
            $row_info['id'] = $row->id;
            $row_info['user_name'] = $row->user_name;
            $row_info['user_email'] = $row->user_email;
            $row_info['user_phone'] = $row->user_phone;

            $user_img = $row->user_image;

            if ($user_img == '' or !file_exists('assets/images/users/' . $user_img)) {
                $user_img = base_url('assets/images/photo.jpg');
            } else {

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $user_img);
                $user_img = base_url() . $this->_create_thumbnail('assets/images/users/', $thumb_img_nm, $user_img, 200, 200);
            }

            $row_info['user_image'] = $user_img;

            $row_info['address_count'] = strval(count($this->common_model->get_addresses($user_id)));

            // to get default address of user
            $address_arr = $this->common_model->get_addresses($user_id, true);

            if (!empty($address_arr)) {
                $address_arr = $address_arr[0];

                $row_info['address'] = $address_arr->building_name . ', ' . $address_arr->road_area_colony . ', ' . $address_arr->city . ', ' . $address_arr->district . ', ' . $address_arr->state . ' - ' . $address_arr->pincode;
            } else {
                $row_info['address'] = "";
            }

            $row_bank = $this->common_model->selectByids(array('user_id' => $user_id), 'tbl_bank_details', 'is_default');

            $row_info['bank_count'] = strval(count($row_bank));

            if (!empty($row_bank)) {

                $row_bank = $row_bank[0];

                $row_info['bank_details'] = $row_bank->bank_name . '(Acc. ' . $row_bank->account_no . '), ' . $row_bank->bank_holder_name . ', ' . $row_bank->bank_holder_phone . ', ' . $row_bank->bank_holder_email;
            } else {

                $row_info['bank_details'] = "";
            }

            $response = array();
            $data_arr = array();

            $row_ord = $this->api_model->get_my_orders($user_id, '', '', true);

            $show_orders=3;
            $nos=1;

            if (count($row_ord) > 0) {

                foreach ($row_ord as $key => $value) {

                    $where = array('order_id' => $value->id);

                    $row_items = $this->common_model->selectByids($where, 'tbl_order_items');

                    if (count($row_items) > 0) {
                        foreach ($row_items as $key2 => $value2) {

                            if($nos > $show_orders){
                                break;
                            }

                            if($value2->pro_order_status == 5){
                                continue;
                            }

                            $nos++;

                            $data_arr['order_id'] = $value->id;
                            $data_arr['order_unique_id'] = $value->order_unique_id;

                            $data_arr['product_id'] = $value2->product_id;
                            $data_arr['product_title'] = $value2->product_title;

                            $data_arr['product_image'] = base_url() . 'assets/images/products/' . $this->get_product_info($value2->product_id, 'featured_image');

                            $data_arr['order_status'] = $this->common_model->selectByidParam($value2->pro_order_status, 'tbl_status_title', 'title');

                            $data_arr['current_order_status'] = ($value2->pro_order_status < 5) ? 'true' : 'false';

                            array_push($response, $data_arr);
                        }
                    }
                }
            }
            $row_info['ECOMMERCE_APP'] = $response;

        } else {
            $row_info = array('success' => '0', 'msg' => $this->lang->line('no_data'));
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // user's profile update
    public function edit_profile_post()
    {
        $row = $this->common_model->selectByid($this->get_param['id'], 'tbl_users');

        if (isset($_FILES['user_image'])) {
            if($_FILES['user_image']['error'] != 4) {

                if($row->user_image!=''){
                    if (file_exists('assets/images/users/' . $row->user_image)) {
                        unlink('assets/images/users/'.$row->user_image);
                        $mask = $row->id.'*_*';
                        array_map('unlink', glob('assets/images/users/thumbs/'.$mask));

                        $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row->user_image);
                        $mask = $thumb_img_nm.'*_*';
                        array_map('unlink', glob('assets/images/users/thumbs/'.$mask));
                    }
                }

                $config['upload_path'] =  'assets/images/users/';
                $config['allowed_types'] = '*';

                $image = date('dmYhis') . '_' . rand(0, 99999) . "." . pathinfo($_FILES['user_image']['name'], PATHINFO_EXTENSION);

                $config['file_name'] = $image;

                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('user_image')) {

                    $row_info = array('success' => '0', 'msg' => strip_tags($this->upload->display_errors()));

                    $this->set_response($row_info, REST_Controller::HTTP_OK);
                    return;
                }

            } else {
                $image = $row->user_image;
            }
        } else {
            $image = $row->user_image;
        }

        if(isset($this->get_param['is_remove']) && $this->get_param['is_remove']){

            if($row->user_image!=''){
                if (file_exists('assets/images/users/' . $row->user_image)) {
                    unlink('assets/images/users/'.$row->user_image);
                    $mask = $row->id.'*_*';
                    array_map('unlink', glob('assets/images/users/thumbs/'.$mask));

                    $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row->user_image);
                    $mask = $thumb_img_nm.'*_*';
                    array_map('unlink', glob('assets/images/users/thumbs/'.$mask));
                }
            }

            $image = '';
        }

        $data_arr = array(
            'user_name' => $this->get_param['user_name'],
            'user_phone' => $this->get_param['user_phone'],
            'user_image'  => $image
        );

        $data_usr = $this->security->xss_clean($data_arr);

        $user_id = $this->common_model->update($data_usr, $this->get_param['id'], 'tbl_users');

        if($image!='')
        {
            $user_img = $image;

            if ($user_img == '' or !file_exists('assets/images/users/' . $user_img)) {
                $user_img = base_url('assets/images/photo.jpg');
            } else {

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $user_img);
                $user_img = base_url() . $this->_create_thumbnail('assets/images/users/', $thumb_img_nm, $user_img, 200, 200);
            }
        }
        else{
            $user_img = base_url('assets/images/photo.jpg');
        }

        $row_info = array('success' => '1', 'msg' => $this->lang->line('update_success'), 'user_name' => $this->get_param['user_name'], 'user_email' => $row->user_email, 'user_image' => $user_img);

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // change password
    public function change_password_post()
    {
        $user_id=$this->get_param['user_id'];
        $old_password=trim($this->get_param['old_password']);
        $new_password=trim($this->get_param['new_password']);

        $row_user = $this->common_model->selectByid($user_id, 'tbl_users');

        if(!empty($row_user))
        {
            if($row_user->status==1){

                if ($row_user->user_password == md5($old_password)) {

                    $data_update = array(
                        'user_password'  =>  md5($new_password)
                    );

                    $data_update = $this->security->xss_clean($data_update);

                    $this->common_model->update($data_update, $user_id,'tbl_users');
                    $row_info=array('success' => 1, 'msg' => $this->lang->line('change_password_msg'));
                }
                else{
                    // password is wrong
                    $row_info = array('success' => '0', 'msg' => $this->lang->line('wrong_password_error'));
                }
            }
            else{
                // account is deactived
                $row_info = array('success' => '0', 'msg' => $this->lang->line('account_deactive'));
            }
            
        }
        else{
            $row_info = array('success' => '0', 'msg' => $this->lang->line('no_data_found_msg'));
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // get all latest products list
    public function get_latest_products_post()
    {
        $response = array();

        if (isset($this->get_param['page'])) {
            $start = ($this->get_param['page'] - 1) * $this->api_page_limit;
        } else {
            $start = 0;
        }

        $row_info['total_products'] = count($this->api_model->products_filter('latest_products'));

        $row = $this->api_model->products_filter('latest_products','', $this->api_page_limit, $start);

        if (!empty($row)) {

            foreach ($row as $key => $value) {

                $data_rate = $this->product_rating($value->product_id);

                $arr_rate = json_decode($data_rate);

                $data_arr['id'] = $value->product_id;

                $data_arr['category_id'] = $value->category_id;
                $data_arr['sub_category_id'] = $value->sub_category_id;
                $data_arr['brand_id'] = $value->brand_id;
                $data_arr['offer_id'] = $value->offer_id;

                $data_arr['product_title'] = $value->product_title;
                $data_arr['product_desc'] = stripslashes($value->product_desc);

                $data_arr['product_image'] = base_url() . 'assets/images/products/' . $value->featured_image;

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->featured_image);

                $data_arr['product_image_square'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 250);

                $data_arr['product_image_portrait'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 300);

                $data_arr['product_mrp'] = number_format($value->product_mrp,2);
                $data_arr['product_sell_price'] = number_format($value->selling_price,2);
                $data_arr['you_save'] = number_format($value->you_save_amt,2);

                $data_arr['you_save_per'] = $value->you_save_per . ' ' . $this->lang->line('per_off_lbl');

                $data_arr['total_views'] = $value->total_views;
                $data_arr['total_rate'] = $arr_rate->total_rate;
                $data_arr['nos_user_rate'] = $arr_rate->rate_times;
                $data_arr['rate_avg'] = $arr_rate->rate_avg;

                $data_arr['product_status'] = $value->status;
                $data_arr['product_status_lbl'] = $this->lang->line('unavailable_lbl');

                $data_arr['category_name'] = $this->common_model->selectByidParam($value->category_id, 'tbl_category', 'category_name');
                $data_arr['sub_category_name'] = $this->get_sub_category_info($value->sub_category_id, 'sub_category_name');

                array_push($response, $data_arr);
            }
        }

        $row_info['ECOMMERCE_APP'] = $response;

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // get all latest products list
    public function get_top_rated_products_post()
    {
        $response = array();

        if (isset($this->get_param['page'])) {
            $start = ($this->get_param['page'] - 1) * $this->api_page_limit;
        } else {
            $start = 0;
        }

        $row_info['total_products'] = count($this->api_model->products_filter('top_rated_products'));

        $row = $this->api_model->products_filter('top_rated_products','', $this->api_page_limit, $start);

        if (!empty($row)) {

            foreach ($row as $key => $value) {

                $data_rate = $this->product_rating($value->product_id);

                $arr_rate = json_decode($data_rate);

                $data_arr['id'] = $value->product_id;

                $data_arr['category_id'] = $value->category_id;
                $data_arr['sub_category_id'] = $value->sub_category_id;
                $data_arr['brand_id'] = $value->brand_id;
                $data_arr['offer_id'] = $value->offer_id;

                $data_arr['product_title'] = $value->product_title;
                $data_arr['product_desc'] = stripslashes($value->product_desc);

                $data_arr['product_image'] = base_url() . 'assets/images/products/' . $value->featured_image;

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->featured_image);

                $data_arr['product_image_square'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 250);

                $data_arr['product_image_portrait'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 300);

                $data_arr['product_mrp'] = number_format($value->product_mrp,2);
                $data_arr['product_sell_price'] = number_format($value->selling_price,2);
                $data_arr['you_save'] = number_format($value->you_save_amt,2);

                $data_arr['you_save_per'] = $value->you_save_per . ' ' . $this->lang->line('per_off_lbl');

                $data_arr['total_views'] = $value->total_views;
                $data_arr['total_rate'] = $arr_rate->total_rate;
                $data_arr['nos_user_rate'] = $arr_rate->rate_times;
                $data_arr['rate_avg'] = $arr_rate->rate_avg;

                $data_arr['product_status'] = $value->status;
                $data_arr['product_status_lbl'] = $this->lang->line('unavailable_lbl');

                $data_arr['category_name'] = $this->common_model->selectByidParam($value->category_id, 'tbl_category', 'category_name');
                $data_arr['sub_category_name'] = $this->get_sub_category_info($value->sub_category_id, 'sub_category_name');

                array_push($response, $data_arr);
            }
        }

        $row_info['ECOMMERCE_APP'] = $response;

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // get all recently viewed products list
    public function get_recent_viewed_products_post()
    {
        $response = array();

        $user_id = trim($this->get_param['user_id']);

        if (isset($this->get_param['page'])) {
            $start = ($this->get_param['page'] - 1) * $this->api_page_limit;
        } else {
            $start = 0;
        }

        $row_info['total_products'] = count($this->api_model->products_filter('recent_viewed_products','','','','','','','','','',$user_id));

        $row = $this->api_model->products_filter('recent_viewed_products','', $this->api_page_limit, $start,'','','','','','',$user_id);

        if (!empty($row)) {

            foreach ($row as $key => $value) {

                $data_rate = $this->product_rating($value->product_id);

                $arr_rate = json_decode($data_rate);

                $data_arr['id'] = $value->product_id;

                $data_arr['category_id'] = $value->category_id;
                $data_arr['sub_category_id'] = $value->sub_category_id;
                $data_arr['brand_id'] = $value->brand_id;
                $data_arr['offer_id'] = $value->offer_id;

                $data_arr['product_title'] = $value->product_title;
                $data_arr['product_desc'] = stripslashes($value->product_desc);

                $data_arr['product_image'] = base_url() . 'assets/images/products/' . $value->featured_image;

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->featured_image);

                $data_arr['product_image_square'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 250);

                $data_arr['product_image_portrait'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 300);

                $data_arr['product_mrp'] = number_format($value->product_mrp,2);
                $data_arr['product_sell_price'] = number_format($value->selling_price,2);
                $data_arr['you_save'] = number_format($value->you_save_amt,2);

                $data_arr['you_save_per'] = $value->you_save_per . ' ' . $this->lang->line('per_off_lbl');

                $data_arr['total_views'] = $value->total_views;
                $data_arr['total_rate'] = $arr_rate->total_rate;
                $data_arr['nos_user_rate'] = $arr_rate->rate_times;
                $data_arr['rate_avg'] = $arr_rate->rate_avg;

                $data_arr['product_status'] = $value->status;
                $data_arr['product_status_lbl'] = $this->lang->line('unavailable_lbl');

                $data_arr['category_name'] = $this->common_model->selectByidParam($value->category_id, 'tbl_category', 'category_name');
                $data_arr['sub_category_name'] = $this->get_sub_category_info($value->sub_category_id, 'sub_category_name');

                array_push($response, $data_arr);
            }
        }

        $row_info['ECOMMERCE_APP'] = $response;

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // application details
    public function app_details_post()
    {

        $user_id=$this->get_param['user_id'];

        $row = $this->api_model->app_details();

        $row_app = $this->api_model->android_details();

        $data_info['app_developed_by'] = $row->app_developed_by;

        $data_info['publisher_id'] = $row_app->publisher_id;

        $data_info['interstitial_ad'] = $row_app->interstital_ad;

        $data_info['interstitial_ad_type'] = $row_app->interstital_ad_type;

        $data_info['interstitial_ad_id'] = ($row_app->interstital_ad_type=='facebook') ? $row_app->interstital_facebook_id : $row_app->interstital_ad_id;

        $data_info['interstitial_ad_click'] = $row_app->interstital_ad_click;

        // Add banner ads data
        $data_info['banner_ad'] = $row_app->banner_ad;

        $data_info['banner_ad_type'] = $row_app->banner_ad_type;

        $data_info['banner_ad_id'] = ($row_app->banner_ad_type=='facebook') ? $row_app->banner_facebook_id : $row_app->banner_ad_id;

        // end banner ads data

        $data_info['app_update_status'] = $row_app->app_update_status;
        $data_info['app_new_version'] = intval($row_app->app_new_version);
        $data_info['app_update_desc'] = $row_app->app_update_desc;
        $data_info['app_redirect_url'] = $row_app->app_redirect_url;
        $data_info['cancel_update_status'] = $row_app->cancel_update_status;

        $data_info['app_currency_code'] = $row->app_currency_html_code;

        $data_info['privacy_policy'] = base_url('privacy');

        $data_info['cart_items'] = strval(count($this->api_model->get_cart($user_id)));

        $row_user = $this->common_model->selectByid($user_id, 'tbl_users');

        if (!empty($row_user)) {

            $user_img = $row_user->user_image;

            if ($user_img == '' or !file_exists('assets/images/users/' . $user_img)) {
                $user_img = base_url('assets/images/photo.jpg');
            } else {

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $user_img);

                $user_img = base_url() . $this->_create_thumbnail('assets/images/users/', $thumb_img_nm, $user_img, 200, 200);
            }

            $data_info['user_name'] = $row_user->user_name;
            $data_info['user_email'] = $row_user->user_email;
            $data_info['user_image'] = $user_img;
        } else {
            $data_info['user_name'] = '';
            $data_info['user_email'] = '';
            $data_info['user_image'] = '';
        }

        if($user_id!=0)
        {
            $device_id=$this->get_param['device_id'];

            $where = array('user_id' => $user_id, 'cart_unique_id' => $device_id);

            $this->common_model->deleteByids($where, 'tbl_cart_tmp');
        }

        $this->set_response($data_info, REST_Controller::HTTP_OK);
    }

    // check email otp status
    public function check_otp_status_post()
    {

        $row = $this->api_model->app_details();

        $row_app = $this->api_model->android_details();

        $data_info['email_otp_status'] = $row->email_otp_op_status;

        $this->set_response($data_info, REST_Controller::HTTP_OK);
    }

    // application about us
    public function about_us_post()
    {

        $row = $this->api_model->app_details();

        $data_info['app_name'] = $row->app_name;
        $data_info['app_logo'] = base_url() . 'assets/images/' . $row->app_logo;

        $data_info['app_version'] = $row->app_version;
        $data_info['app_author'] = $row->app_author;
        $data_info['app_contact'] = $row->app_contact;
        $data_info['app_email'] = $row->app_email;
        $data_info['app_website'] = $row->app_website;
        $data_info['app_description'] = $row->app_description;
        $data_info['app_developed_by'] = $row->app_developed_by;

        $this->set_response($data_info, REST_Controller::HTTP_OK);
    }

    // application privacy policy
    public function privacy_policy_post()
    {
        $row = $this->api_model->app_details();

        $data['privcy_policy'] = stripslashes($row->app_privacy_policy);

        $this->set_response($data, REST_Controller::HTTP_OK);
    }


    public function get_data_post()
    {
        $type = trim($this->get_param['type']); // term_of_use, refund_policy, cancel_policy

        $row = $this->api_model->web_details();

        switch ($type) {
            case 'term_of_use':
                {
                    $row_info['content']=$row->terms_of_use_content;
                }
                break;

            case 'refund_policy':
                {
                    $row_info['content']=$row->refund_return_policy;
                }
                break;

            case 'cancel_policy':
                {
                    $row_info['content']=$row->cancellation_content;
                }
                break;
            
            default:
                {
                    $row_info['content']='';
                }
                break;
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);

    }

    // application payment faq and simple faq
    public function review_filter_list_post()
    {
        $product_id = $this->get_param['product_id'];

        $data_rate = $this->product_rating($product_id);

        $arr_rate = json_decode($data_rate);

        $row_info['total_rate'] = $arr_rate->rate_times;
        $row_info['rate_avg'] = $arr_rate->rate_avg;

        $filter_list=array('newest' => $this->lang->line('review_newest_first_lbl'),'oldest' => $this->lang->line('review_oldest_first_lbl'),'negative' => $this->lang->line('review_negative_lbl'),'positive' => $this->lang->line('review_positive_lbl'));

        foreach ($filter_list as $key => $value) {
            $data['value'] = $key;
            $data['title'] = $value;

            $row_info['filter_list'][]=$data;
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }    

    // application payment faq and simple faq
    public function faq_post()
    {

        if(!isset($this->get_param['type']) || $this->get_param['type']==''){
            $type='faq';
        }
        else{
            $type = trim($this->get_param['type']);    
        }
        

        $row = $this->common_model->selectByids(array('type' => $type, 'status' => '1'), 'tbl_faq');

        $response=array();

        foreach ($row as $key => $value) {
            $data_arr['id']=$value->id;
            $data_arr['question']=stripslashes($value->faq_question);
            $data_arr['answer']=stripslashes($value->faq_answer);

            array_push($response, $data_arr);
        }

        $row_info['ECOMMERCE_APP']=$response;

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // payment details
    public function payment_details_post()
    {

        $row = $this->api_model->app_details();

        if($row->cod_status=='true' && $row->paypal_status=='true' && $row->stripe_status=='true' && $row->razorpay_status=='true'){

            $row_info['success'] = '1';
            $row_info['msg'] = '';
            $row_info['cod_status'] = $row->cod_status;
            $row_info['paypal_status'] = $row->paypal_status;
            $row_info['stripe_status'] = $row->stripe_status;
            if (APP_CURRENCY == 'INR' || APP_CURRENCY == 'inr') {
                $row_info['razorpay_status'] = $row->razorpay_status;    
            }
            else{
                $row_info['razorpay_status'] = 'false';
            }
        }
        else{
            $row_info['success'] = '0';
            $row_info['msg'] = $this->lang->line('no_payment_option');
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // validate checkout amount
    public function stripe_validate_checkout_amt_post()
    {
        $user_id = $this->get_param['user_id'];
        $cart_ids = $this->get_param['cart_ids'];
        $cart_type = $this->get_param['cart_type']; // main_cart/temp_cart

        if($cart_type=='main_cart'){
            $my_cart = $this->api_model->get_cart($user_id);
        }
        else{
            $my_cart = $this->api_model->get_cart($user_id, $cart_ids);
        }

        $is_avail=true;

        if(!empty($my_cart)){

            $total_cart_amt=$delivery_charge=$you_save=0;

            $where = array('user_id' => $user_id, 'cart_type' => $cart_type);

            $row_coupon=$this->common_model->selectByids($where,'tbl_applied_coupon');

            if(count($row_coupon)==0){
                $coupon_id=0;
            }
            else{
                $coupon_id=$row_coupon[0]->coupon_id;
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
                $row_info = array('success' => '2', 'msg' => $this->lang->line('some_product_unavailable_lbl'));
                $this->set_response($row_info, REST_Controller::HTTP_OK);
                return;
            }

            if($coupon_id==0){
                $discount=0;
                $discount_amt=0;
                $payable_amt=number_format((float)($total_cart_amt), 2, '.', '') + number_format((float)$delivery_charge, 2, '.', '');
            }
            else{

                $coupon_json=json_decode($this->inner_apply_coupon($user_id, $coupon_id));
                $discount=$coupon_json->discount;
                $discount_amt=$coupon_json->discount_amt;
                $payable_amt=$coupon_json->payable_amt;
            }

            if (APP_CURRENCY != 'USD' || APP_CURRENCY != 'usd') {

                $from_currency = urlencode('USD');
                $to_currency = strtoupper(APP_CURRENCY);

                if (convert_currency($to_currency, $from_currency, $payable_amt) < 1) {
                    $row_info['success'] = '0';
                    $row_info['msg'] = $this->lang->line('checkout_amt_error');
                    $this->set_response($row_info, REST_Controller::HTTP_OK);
                    return;
                }
            }

            $row_info['success'] = '1';
            $row_info['msg'] = '';
        }
        else{
            $row_info['success'] = '2';
            $row_info['msg'] = $this->lang->line('ord_placed_empty_lbl');
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // generate paypal amount
    public function generate_paypal_amount_post()
    {

        $row_app = $this->api_model->app_details();

        $user_id = $this->get_param['user_id'];
        $cart_ids = $this->get_param['cart_ids'];
        $cart_type = $this->get_param['cart_type']; // main_cart/temp_cart

        if($cart_type=='main_cart')
        {
            $where = array('user_id' => $user_id, 'cart_type' => $cart_type);
            $row_coupon=$this->common_model->selectByids($where,'tbl_applied_coupon');

            $my_cart = $this->api_model->get_cart($user_id);
        }
        else
        {
            $where = array('user_id' => $user_id, 'cart_type' => $cart_type, 'cart_id' => $cart_ids);
            $row_coupon=$this->common_model->selectByids($where,'tbl_applied_coupon');
            $my_cart = $this->api_model->get_cart($user_id, $cart_ids);
        }

        $is_avail=true;

        if(!empty($my_cart)){

            $total_cart_amt=$delivery_charge=$you_save=0;

            if(count($row_coupon)==0){
                $coupon_id=0;
            }
            else{
                $coupon_id=$row_coupon[0]->coupon_id;
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
                $row_info = array('success' => '2', 'msg' => $this->lang->line('some_product_unavailable_lbl'));
                $this->set_response($row_info, REST_Controller::HTTP_OK);
                return;
            }

            if($coupon_id==0){
                $discount=0;
                $discount_amt=0;
                $payable_amt=number_format((float)($total_cart_amt), 2, '.', '') + number_format((float)$delivery_charge, 2, '.', '');
            }
            else
            {

                if($cart_type=='main_cart')
                {
                    $coupon_json=json_decode($this->inner_apply_coupon($user_id, $coupon_id));    
                }
                else{
                    $coupon_json=json_decode($this->inner_apply_coupon($user_id, $coupon_id, $cart_ids,'temp_cart'));
                }
                $discount=$coupon_json->discount;
                $discount_amt=$coupon_json->discount_amt;
                $payable_amt=$coupon_json->payable_amt;
            }

            $row_info['paypal_mode'] = $row_app->paypal_mode;
            $row_info['paypal_client_id'] = $row_app->paypal_client_id;
            $row_info['paypal_currency_code'] = $row_app->app_currency_code;

            $row_info['success'] = '1';
            $row_info['msg'] = '';
            $row_info['payable_amt'] = $payable_amt;
        }
        else{
            $row_info['success'] = '2';
            $row_info['msg'] = $this->lang->line('ord_placed_empty_lbl');
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // get stripe payment id...
    public function stripe_token_post()
    {

        $user_id = $this->get_param['user_id'];
        $cart_ids = $this->get_param['cart_ids'];
        $cart_type = $this->get_param['cart_type']; // main_cart/temp_cart

        if($cart_type=='main_cart')
        {
            $where = array('user_id' => $user_id, 'cart_type' => $cart_type);
            $row_coupon=$this->common_model->selectByids($where,'tbl_applied_coupon');
            $my_cart = $this->api_model->get_cart($user_id);
        }
        else
        {
            $where = array('user_id' => $user_id, 'cart_type' => $cart_type, 'cart_id' => $cart_ids);
            $row_coupon=$this->common_model->selectByids($where,'tbl_applied_coupon');
            $my_cart = $this->api_model->get_cart($user_id, $cart_ids);
        }

        $is_avail=true;

        if(!empty($my_cart)){

            $total_cart_amt=$delivery_charge=$you_save=0;

            if(count($row_coupon)==0){
                $coupon_id=0;
            }
            else{
                $coupon_id=$row_coupon[0]->coupon_id;
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
                $row_info = array('success' => '2', 'msg' => $this->lang->line('some_product_unavailable_lbl'));
                $this->set_response($row_info, REST_Controller::HTTP_OK);
                return;
            }

            if($coupon_id==0){
                $discount=0;
                $discount_amt=0;
                $payable_amt=number_format((float)($total_cart_amt), 2, '.', '') + number_format((float)$delivery_charge, 2, '.', '');
            }
            else{

                if($cart_type=='main_cart')
                {
                    $coupon_json=json_decode($this->inner_apply_coupon($user_id, $coupon_id));    
                }
                else{
                    $coupon_json=json_decode($this->inner_apply_coupon($user_id, $coupon_id, $cart_ids,'temp_cart'));
                }

                $discount=$coupon_json->discount;
                $discount_amt=$coupon_json->discount_amt;
                $payable_amt=$coupon_json->payable_amt;
            }

            if (APP_CURRENCY != 'USD' || APP_CURRENCY != 'usd') {

                $from_currency = urlencode('USD');
                $to_currency = strtoupper(APP_CURRENCY);

                if (convert_currency($to_currency, $from_currency, $payable_amt) < 1) {
                    $row_info['success'] = '0';
                    $row_info['msg'] = $this->lang->line('checkout_amt_error');
                    $this->set_response($row_info, REST_Controller::HTTP_OK);
                    return;
                }
            } 

            require_once('application/libraries/stripe-php/init.php');

            \Stripe\Stripe::setApiKey($this->stripe_secret);

            $intent = \Stripe\PaymentIntent::create([
                'amount' => $payable_amt * 100,
                'currency' => APP_CURRENCY,
            ]);

            $row = $this->api_model->app_details();

            $row_info['stripe_key'] = $row->stripe_key;

            if ($intent->client_secret != '') {
                $client_secret = $intent->client_secret;

                $row_info['success'] = '1';
                $row_info['msg'] = $this->lang->line('stripe_token_success');
                $row_info['stripe_payment_token'] = $client_secret;
            }
            else {
                $row_info['success'] = '0';
                $row_info['msg'] = $this->lang->line('stripe_token_issue');
            }
        }
        else{
            $row_info['success'] = '2';
            $row_info['msg'] = $this->lang->line('ord_placed_empty_lbl');
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // get razorpay order id
    public function razorpay_order_id_post()
    {
        $row = $this->api_model->app_details();

        $user_id = $this->get_param['user_id'];
        $cart_ids = $this->get_param['cart_ids'];
        $cart_type = $this->get_param['cart_type']; // main_cart/temp_cart

        if($cart_type=='main_cart')
        {
            $where = array('user_id' => $user_id, 'cart_type' => $cart_type);
            $row_coupon=$this->common_model->selectByids($where,'tbl_applied_coupon');
            $my_cart = $this->api_model->get_cart($user_id);
        }
        else
        {
            $where = array('user_id' => $user_id, 'cart_type' => $cart_type, 'cart_id' => $cart_ids);
            $row_coupon=$this->common_model->selectByids($where,'tbl_applied_coupon');
            $my_cart = $this->api_model->get_cart($user_id, $cart_ids);
        }

        $is_avail=true;

        if(!empty($my_cart))
        {
            try {

                if(APP_CURRENCY=='INR')
                {
                    $total_cart_amt=$delivery_charge=$you_save=0;

                    if(count($row_coupon)==0){
                        $coupon_id=0;
                    }
                    else{
                        $coupon_id=$row_coupon[0]->coupon_id;
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
                        $row_info = array('success' => '2', 'msg' => $this->lang->line('some_product_unavailable_lbl'));
                        $this->set_response($row_info, REST_Controller::HTTP_OK);
                        return;
                    }

                    if($coupon_id==0){
                        $discount=0;
                        $discount_amt=0;
                        $payable_amt=($total_cart_amt + $delivery_charge);
                    }
                    else{

                        if($cart_type=='main_cart')
                        {
                            $coupon_json=json_decode($this->inner_apply_coupon($user_id, $coupon_id));    
                        }
                        else{
                            $coupon_json=json_decode($this->inner_apply_coupon($user_id, $coupon_id, $cart_ids,'temp_cart'));
                        }

                        $discount=$coupon_json->discount;
                        $discount_amt=$coupon_json->discount_amt;
                        $payable_amt=$coupon_json->payable_amt;
                    }

                    $payable_amt=$payable_amt*100;

                    $razorpay_api = new Api($row->razorpay_key, $row->razorpay_secret);

                    $order = $razorpay_api->order->create(array('receipt' => 'user_rcptid_' . $user_id, 'amount' => $payable_amt, 'currency' => APP_CURRENCY, 'payment_capture' =>  '1'));

                    $orderId = $order['id'];

                    $row_info['success'] = '1';
                    $row_info['msg'] = '';
                    $row_info['order_id'] = $orderId;

                    $row_info['razorpay_key_id'] = $row->razorpay_key;
                    $row_info['razorpay_secret'] = $row->razorpay_secret;

                    $row_info['theme_color'] = '#' . $row->razorpay_theme_color;

                    $row_info['name'] = $row->app_name;

                    $row_info['image'] = base_url() . $this->_create_thumbnail('assets/images/', 'app_logo', $row->app_logo, 96, 96);

                    /*$row_info['image'] = 'https://shopping.viavilab.com/assets/images/28092020025412_64200.png';*/
                    
                    $row_info['description'] = $this->lang->line('pay_with_razorpay_lbl');

                    $row_info['currency'] = APP_CURRENCY;

                    $row_info['payable_amt'] = $payable_amt;

                    $row_info['email'] = $this->common_model->selectByidParam($user_id,'tbl_users','user_email');

                    $row_info['contact'] = $this->common_model->selectByidParam($user_id,'tbl_users','user_phone');
                }
                else{
                    $row_info['success'] = '0';
                    $row_info['msg'] = $this->lang->line('razorpay_currency_err');
                }
            }
            catch (Exception $e)
            {
                $row_info['success'] = '0';
                $row_info['msg'] = $this->lang->line('something_went_wrong_err');
            }
        }
        else{
            $row_info['success'] = '2';
            $row_info['msg'] = $this->lang->line('ord_placed_empty_lbl');
        }

        $this->set_response($row_info, REST_Controller::HTTP_OK);
    }

    // all filter api goes here
    public function filter_list_post(){

        // type, sort, id, keyword, user_id

        $data_info = array();

        if(isset($this->get_param['type']) OR $this->get_param['type']!='')
        {
            $type = $this->get_param['type'];
            $sort = $this->get_param['sort'];

            $sorting_arr=array('newest' => 'Newest First','low-high' => 'Low to High Price','high-low' => 'High to Low Price','top' => 'Top Selling');

            $response=array();

            foreach ($sorting_arr as $key => $value) {
                $data_arr['title']=$value;
                $data_arr['sort']=$key;

                if(strcmp($key, $sort) == 0){
                    $data_arr['selected'] = 'true';
                }
                else{
                    $data_arr['selected'] = 'false';
                }

                array_push($response, $data_arr);
            }

            $data_info['sort_by'] = $response;

            if(isset($this->get_param['id'])) {
                $id = $this->get_param['id'];
            } else {
                $id = 0;
            }

            if($type=='search'){

                $keyword = trim($this->get_param['keyword']);

                $row = $this->api_model->products_filter($type, $id,'','','','','','','',$keyword);
            }
            else if($type=='recent_viewed_products'){

                $user_id = trim($this->get_param['user_id']);

                $row = $this->api_model->products_filter($type, $id,'','','','','','','','',$user_id);
            }
            else{
                $row = $this->api_model->products_filter($type, $id);
            }


            $brands = array();
            $size=array();

            foreach ($row as $key => $value) {

                if($value->brand_id!=0){
                    $brands[] = $value->brand_id;
                }

                if($value->product_size!=''){
                    $size[]=$value->product_size;
                }

            }

            $size_arr=array();

            foreach ($size as $key => $value) {
                foreach (explode(',', $value) as $key1 => $value1) {
                    $size_arr[]=trim($value1);
                };
            }

            asort($size_arr);

            $size_arr=array_unique($size_arr);

            if(!empty($size_arr)){
                $data_info['size_status'] = 'true';
            }
            else{
                $data_info['size_status'] = 'false';
            }

            if(!empty($brands) AND $type!='brand'){
                $data_info['brand_filter'] = "true";
            }
            else{
                $data_info['brand_filter'] = "false";
            }

        }
        else
        {
            $data_info['success'] = '0';
            $data_info['msg'] = 'Type is not available !!!';
        }

        $this->set_response($data_info, REST_Controller::HTTP_OK);

    }
    public function price_filter_post(){
        // type, sort, id, keyword, user_id

        $data_info = array();

        if(isset($this->get_param['type']) OR $this->get_param['type']!='')
        {
            $type = $this->get_param['type'];

            if(isset($this->get_param['id'])) {
                $id = $this->get_param['id'];
            } else {
                $id = 0;
            }

            if($type=='search'){

                $keyword = trim($this->get_param['keyword']);

                $row = $this->api_model->products_filter($type, $id,'','','','','','','',$keyword);
            }
            else if($type=='recent_viewed_products'){

                $user_id = trim($this->get_param['user_id']);

                $row = $this->api_model->products_filter($type, $id,'','','','','','','','',$user_id);
            }
            else{
                $row = $this->api_model->products_filter($type, $id);
            }


            $price_arr = array();

            foreach ($row as $key => $value) {
                $price_arr[] = $value->selling_price;
            }

            $min = min($price_arr);
            $max = max($price_arr);

            $data_info['price_min'] = strval(floor($min));
            $data_info['price_max'] = strval(ceil($max));

            if (isset($this->get_param['pre_min']) && isset($this->get_param['pre_max'])) {
                $data_info['pre_price_min'] = ($this->get_param['pre_min']) ? $this->get_param['pre_min'] : strval(floor($min));
                $data_info['pre_price_max'] = ($this->get_param['pre_max']) ? $this->get_param['pre_max'] : strval(ceil($max));
            } else {
                $data_info['pre_price_min'] = strval(floor($min));
                $data_info['pre_price_max'] = strval(ceil($max));
            }

        }
        else
        {
            $data_info['success'] = '0';
            $data_info['msg'] = 'Type is not available !!!';
        }

        $this->set_response($data_info, REST_Controller::HTTP_OK);
    }
    public function brand_filter_post(){

        // type, sort, id, keyword, user_id, brand_ids

        $data_info = array();

        if(isset($this->get_param['type']) OR $this->get_param['type']!='')
        {
            $type = $this->get_param['type'];

            if(isset($this->get_param['id'])) {
                $id = $this->get_param['id'];
            } else {
                $id = 0;
            }

            $brand_ids = $this->get_param['brand_ids'];

            if($type=='search'){

                $keyword = trim($this->get_param['keyword']);

                $row = $this->api_model->products_filter($type, $id,'','','','','','','',$keyword);
            }
            else if($type=='recent_viewed_products'){

                $user_id = trim($this->get_param['user_id']);

                $row = $this->api_model->products_filter($type, $id,'','','','','','','','',$user_id);
            }
            else{
                $row = $this->api_model->products_filter($type, $id);
            }


            $brands = array();

            foreach ($row as $key => $value) {
                $brands[] = $value->brand_id;
            }

            $brand_count_items = array_count_values($brands);

            $rowBrands = $this->common_model->selectByidsIN(array_unique($brands), 'tbl_brands');

            $response = array();

            if ($brand_ids != '') {

                $brand_ids_arr = explode(",", $brand_ids);

                foreach ($rowBrands as $key => $value) {

                    $data_arr['id'] = $value->id;
                    $data_arr['brand_name'] = $value->brand_name;

                    $data_arr['total_cnt'] = strval($brand_count_items[$value->id]);

                    if(in_array($value->id, $brand_ids_arr)){
                        $data_arr['selected'] = 'true';
                    }
                    else{
                        $data_arr['selected'] = 'false';
                    }

                    array_push($response, $data_arr);
                }
            } else {
                foreach ($rowBrands as $key => $value) {

                    $data_arr['id'] = $value->id;
                    $data_arr['brand_name'] = $value->brand_name;
                    $data_arr['total_cnt'] = strval($brand_count_items[$value->id]);
                    $data_arr['selected'] = 'false';

                    array_push($response, $data_arr);
                }
            }

            if($type!='brand'){
                $data_info['brand_list'] = $response;
            }
            else{
                $data_info['brand_list'] = array();
            }

        }
        else
        {
            $data_info['success'] = '0';
            $data_info['msg'] = 'Type is not available !!!';
        }

        $this->set_response($data_info, REST_Controller::HTTP_OK);
    }

    public function size_filter_post(){

        // type, sort, id, keyword, user_id, sizes

        $data_info = array();

        if(isset($this->get_param['type']) OR $this->get_param['type']!='')
        {
            $type = $this->get_param['type'];

            if(isset($this->get_param['id'])) {
                $id = $this->get_param['id'];
            } else {
                $id = 0;
            }

            $sizes = $this->get_param['sizes'];

            if (isset($this->get_param['brand_ids']) && $this->get_param['brand_ids'] != ''){
                $brand_ids = rtrim($this->get_param['brand_ids'], ',');

                $brand_ids=explode(',', $brand_ids);

            }
            else{
                $brand_ids = '';
            }

            if($type=='search'){

                $keyword = trim($this->get_param['keyword']);

                $row = $this->api_model->products_filter($type, $id,'','',$brand_ids,'','','','',$keyword);
            }
            else if($type=='recent_viewed_products'){

                $user_id = trim($this->get_param['user_id']);

                $row = $this->api_model->products_filter($type, $id,'','',$brand_ids,'','','','','',$user_id);
            }
            else{
                $row = $this->api_model->products_filter($type, $id,'','',$brand_ids);
            }

            $size=array();

            foreach ($row as $key => $value) {
                if($value->product_size!=''){
                    $size[]=$value->product_size;
                }
            }

            $size_arr=array();

            foreach ($size as $key => $value) {
                foreach (explode(',', $value) as $key1 => $value1) {
                    $size_arr[]=trim($value1);
                };
            }

            asort($size_arr);

            $size_arr=array_unique($size_arr);

            $response = array();
            $data_arr=array();

            if(!empty($size_arr)){

                if($sizes!=''){

                    $fitered_size = explode(",", $sizes);

                    foreach ($size_arr as $key => $value) {

                        $data_arr['size'] = $value;

                        if (in_array($value, $fitered_size)){
                            $data_arr['selected'] = 'true';
                        }
                        else{
                            $data_arr['selected'] = 'false';
                        }

                        array_push($response, $data_arr);
                    }
                }
                else{

                    foreach ($size_arr as $key => $value) {

                        $data_arr['size'] = $value;
                        $data_arr['selected'] = 'false';

                        array_push($response, $data_arr);
                    }

                }
                $data_info['sizes'] = $response;
            }
            else{
                $data_info['sizes'] = array();
            }
        }
        else
        {
            $data_info['success'] = '0';
            $data_info['msg'] = 'Type is not available !!!';
        }

        $this->set_response($data_info, REST_Controller::HTTP_OK);
    }

    public function apply_filter_post()
    {

        $data_info = array();

        if (isset($this->get_param['type'])) {

            if(isset($this->get_param['page'])) {
                $start = ($this->get_param['page'] - 1) * $this->api_page_limit;
            } else {
                $start = 0;
            }

            $type = $this->get_param['type'];

            $min_price = $this->get_param['min_price'];
            $max_price = $this->get_param['max_price'];

            if ($type == '') {
                $data_info['success'] = '0';
                $data_info['msg'] = 'Please enter type !!!';
            } else {

                if (isset($this->get_param['brand_ids']) && $this->get_param['brand_ids'] != ''){
                    $brand_ids = rtrim($this->get_param['brand_ids'], ',');
                    $brand_ids=explode(',', $brand_ids);
                }
                else{
                    $brand_ids = '';
                }

                if (isset($this->get_param['sizes']) && $this->get_param['sizes'] != ''){
                    $sizes = rtrim($this->get_param['sizes'], ',');
                }
                else{
                    $sizes = '';
                }

                if (isset($this->get_param['id'])) {
                    $_id = $this->get_param['id'];
                } else {
                    $_id = 0;
                }

                if(isset($this->get_param['sort'])) {
                    $sort_by = $this->get_param['sort'];
                } else {
                    $sort_by = 'newest';
                }

                $data_info['sort'] = $sort_by;

                if($type=='search'){

                    $keyword = trim($this->get_param['keyword']);

                    $row_all = $this->api_model->products_filter($type, $_id, '', '', $brand_ids, $min_price, $max_price, $sort_by, $sizes, $keyword);

                    $row = $this->api_model->products_filter($type, $_id, $this->api_page_limit, $start, $brand_ids, $min_price, $max_price, $sort_by, $sizes, $keyword);
                }
                else if($type=='recent_viewed_products'){

                    $user_id = trim($this->get_param['user_id']);

                    $row_all = $this->api_model->products_filter($type, $_id, '', '', $brand_ids, $min_price, $max_price, $sort_by, $sizes,'',$user_id);

                    $row = $this->api_model->products_filter($type, $_id, $this->api_page_limit, $start, $brand_ids, $min_price, $max_price, $sort_by, $sizes,'',$user_id);

                }
                else{
                    $row_all = $this->api_model->products_filter($type, $_id,'','', $brand_ids, $min_price, $max_price, $sort_by, $sizes);

                    $row = $this->api_model->products_filter($type, $_id, $this->api_page_limit, $start, $brand_ids, $min_price, $max_price, $sort_by, $sizes);
                }

                $data_info['total_products'] = count($row_all);

                $response=array();

                if($row)
                {
                    foreach ($row as $key => $value) {

                        $data_rate = $this->product_rating($value->product_id);

                        $arr_rate = json_decode($data_rate);

                        $data_arr['id'] = $value->product_id;
                        $data_arr['category_id'] = $value->category_id;
                        $data_arr['sub_category_id'] = $value->sub_category_id;
                        $data_arr['brand_id'] = $value->brand_id;
                        $data_arr['offer_id'] = $value->offer_id;

                        $data_arr['product_title'] = $value->product_title;
                        $data_arr['product_desc'] = stripslashes($value->product_desc);

                        $data_arr['product_image'] = base_url() . 'assets/images/products/' . $value->featured_image;

                        $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->featured_image);

                        $data_arr['product_image_square'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 250);

                        $data_arr['product_image_portrait'] = base_url() . $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $value->featured_image, 250, 300);

                        $data_arr['product_mrp'] = number_format($value->product_mrp,2);
                        $data_arr['product_sell_price'] = number_format($value->selling_price,2);
                        $data_arr['you_save'] = number_format($value->you_save_amt,2);

                        $data_arr['product_status'] = $value->status;
                        $data_arr['product_status_lbl'] = $this->lang->line('unavailable_lbl');

                        $data_arr['you_save_per'] = $value->you_save_per . ' ' . $this->lang->line('per_off_lbl');

                        $data_arr['total_views'] = $value->total_views;
                        $data_arr['total_rate'] = $arr_rate->total_rate;
                        $data_arr['nos_user_rate'] = $arr_rate->rate_times;
                        $data_arr['rate_avg'] = $arr_rate->rate_avg;

                        array_push($response, $data_arr);
                    }
                    $data_info['ECOMMERCE_APP'] = $response;
                } else {
                    $data_info['ECOMMERCE_APP'] = $response;
                }
            }
        } else {
            $data_info['success'] = '0';
            $data_info['msg'] = 'Type is not available !!!';
        }

        $this->set_response($data_info, REST_Controller::HTTP_OK);
    }

    // end filter api

    private function _create_thumbnail($path, $thumb_name, $fileName, $width, $height)
    {
        $source_path = $path . $fileName;

        if (file_exists($source_path)) {
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);

            if ($thumb_name == 'app_logo') {

                $thumb_name = $thumb_name . '_' . $width . 'x' . $height . '.' . $ext;
                $thumb_path = $path . $thumb_name;
            } else {
                $thumb_name = $thumb_name . '_' . $width . 'x' . $height . '.' . $ext;
                $thumb_path = $path . 'thumbs/' . $thumb_name;
            }

            if (!file_exists($thumb_path)) {
                $this->load->library('image_lib');
                $config['image_library']  = 'gd2';
                $config['source_image']   = $source_path;
                $config['new_image']      = $thumb_path;
                $config['create_thumb']   = FALSE;
                $config['maintain_ratio'] = FALSE;
                $config['width']          = $width;
                $config['height']         = $height;
                $this->image_lib->initialize($config);
                if (!$this->image_lib->resize()) {
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

    private function inner_apply_coupon($user_id, $coupon_id, $cart_ids='', $cart_type='main_cart')
    {
        if($cart_type=='main_cart')
        {
            $my_cart=$this->api_model->get_cart($user_id);
        }
        else{
            $my_cart=$this->api_model->get_cart($user_id, $cart_ids);
        }

        $total_amount=$delivery_charge=$you_save=0;

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

                                        $payable_amt=number_format((float)($total_amount - $discount), 2, '.', '')+number_format((float)$delivery_charge, 2, '.', '');
                                    }
                                    else{

                                        $payable_amt=number_format((float)($total_amount - $discount), 2, '.', '')+number_format((float)$delivery_charge, 2, '.', '');
                                    }
                                }
                                else{
                                    $payable_amt=number_format((float)($total_amount - $discount), 2, '.', '')+number_format((float)$delivery_charge, 2, '.', '');
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

                                    $payable_amt=number_format((float)($total_amount - $discount), 2, '.', '')+number_format((float)$delivery_charge, 2, '.', '');
                                }
                                else{
                                    $payable_amt=number_format((float)($total_amount - $discount), 2, '.', '')+number_format((float)$delivery_charge, 2, '.', '');
                                }
                            }
                            else{
                                $payable_amt=number_format((float)($total_amount - $discount), 2, '.', '')+number_format((float)$delivery_charge, 2, '.', '');
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

                                $payable_amt=number_format((float)($total_amount - $row->coupon_amt), 2, '.', '')+number_format((float)$delivery_charge, 2, '.', '');
                            }
                            else
                            {
                                $discount='0';
                                $payable_amt=number_format((float)($total_amount + $delivery_charge), 2);
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

    function checkSpam($email)
    {
        $this->load->library('genuinemail');
        $check = $this->genuinemail->check($email);
        if($check===TRUE) return true;
        return false;
    }
}
