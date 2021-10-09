<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'libraries/razorpay-php/Razorpay.php'); // require razorpay files

use Razorpay\Api\Api;

use Razorpay\Api\Errors\SignatureVerificationError;

class Razorpay extends CI_Controller {

    private $key_id;

    private $secret_key;

    private $app_name;

    private $order_email;

    private $app_setting;

    private $order_unique_id=null;

    private $order_id=null;

    public function __construct() {
        parent::__construct();

        ini_set('MAX_EXECUTION_TIME', '-1');

        $this->load->library("session");
        $this->load->helper('url');

        $this->load->model('Common_model','common_model');
        $this->load->model('Api_model','api_model');
        $this->load->model('Coupon_model');
        $this->load->model('Offers_model');

        $this->app_setting = $this->api_model->app_details();
        $this->web_setting = $this->api_model->web_details();

        define('APP_CURRENCY', $this->app_setting->app_currency_code);
        define('CURRENCY_CODE', $this->app_setting->app_currency_html_code);

        $this->load->library("CompressImage");

        $this->key_id=$this->app_setting->razorpay_key;
        $this->secret_key=$this->app_setting->razorpay_secret;

        $this->app_name=$this->app_setting->app_name;
        $this->order_email=$this->app_setting->app_order_email;
    }

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

    public function generate_ord()
    {

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            redirect('login-register', 'refresh');
        }

        $cart_type=($this->input->post('buy_now')=='true') ? 'temp_cart' : 'main_cart';

        $this->session->set_userdata("buy_now", $this->input->post('buy_now'));
        $this->session->set_userdata("cart_type", $cart_type);
        $this->session->set_userdata("order_address", $this->input->post('order_address'));

        $this->session->set_userdata("current_page", $this->input->post('current_page'));
        
        $cart_ids=$this->input->post('cart_ids');

        if($cart_type=='main_cart'){
            $my_cart=$this->api_model->get_cart($user_id);
        }
        else{
            $my_cart=$this->api_model->get_cart($user_id,$cart_ids);
        }

        $total_cart_amt=$delivery_charge=$you_save=0;

        if(!empty($my_cart))
        {
            $is_avail=true;

            foreach ($my_cart as $key => $value)
            {
                if($value->cart_status==0){
                    $is_avail=false;
                }

                $total_cart_amt+=$value->selling_price*$value->product_qty;
                $delivery_charge+=$value->delivery_charge;
                $you_save+=$value->you_save_amt * $value->product_qty;
            }

            if(!$is_avail){
                $res_json=array('success' => '-2','message' => $this->lang->line('some_product_unavailable_lbl'));
                echo json_encode($res_json);
                exit();
            }

            $where=array('user_id' => $user_id, 'cart_type' => $cart_type);

            $coupon_id=$this->input->post('coupon_id');

            if(count($this->common_model->selectByids($where,'tbl_applied_coupon'))==0){
                $coupon_id=0;
            }

            if($coupon_id==0)
            {
                $discount=0;
                $discount_amt=0;
                $payable_amt=$total_cart_amt+$delivery_charge;
            }
            else
            {
                $coupon_json=json_decode($this->inner_apply_coupon($coupon_id,$this->input->post('cart_ids'),$cart_type));
                $discount=$coupon_json->discount;
                $discount_amt=$coupon_json->discount_amt;
                $payable_amt=$coupon_json->payable_amt;
            }

            $this->session->set_userdata("coupon_id", $coupon_id);
            $this->session->set_userdata("total_amt", $total_cart_amt);
            $this->session->set_userdata("discount", $discount);
            $this->session->set_userdata("discount_amt", $discount_amt);
            $this->session->set_userdata("payable_amt", $payable_amt);
            $this->session->set_userdata("cart_ids", $this->input->post('cart_ids'));
            $this->session->set_userdata("delivery_charge", $delivery_charge);

            $api = new Api($this->key_id, $this->secret_key);

            $payable_amt=$payable_amt*100;

            if(APP_CURRENCY == 'INR')
            {
                if($this->session->userdata('razorpay_order_id'))
                {

                    $order = $api->order->fetch($this->session->userdata('razorpay_order_id'));

                    if(($order['amount'] != $payable_amt))
                    {

                        $this->session->unset_userdata(array('razorpay_order_id'));

                        $order  = $api->order->create(array('receipt' => 'user_rcptid_'.$user_id, 'amount' => $payable_amt, 'currency' => APP_CURRENCY,'payment_capture' =>  '1')); // Creates order

                        $orderId = $order['id']; 

                        $this->session->set_userdata("razorpay_order_id", $orderId);
                    }
                    else
                    {
                        $orderId = $this->session->userdata('razorpay_order_id');
                    }
                }
                else
                {
                    $order  = $api->order->create(array('receipt' => 'user_rcptid_'.$user_id, 'amount' => $payable_amt, 'currency' => APP_CURRENCY,'payment_capture' =>  '1')); // Creates order

                    $orderId = $order['id']; 

                    $this->session->set_userdata("razorpay_order_id", $orderId);

                }
                $res_json=array('success' => '1','razorpay_order_id' => $orderId,'key' => $this->key_id, 'amount' => $payable_amt, 'site_name' => $this->web_setting->site_name, 'description' => $this->lang->line('pay_with_razorpay_lbl'),'theme_color' => '#'.$this->app_setting->razorpay_theme_color,'user_name' => $this->common_model->selectByidParam($user_id,'tbl_users','user_name'),'user_email' => $this->common_model->selectByidParam($user_id,'tbl_users','user_email'),'user_phone' => $this->common_model->selectByidParam($user_id,'tbl_users','user_phone'),'logo' => base_url('assets/images/'.$this->web_setting->web_logo_1));
            }
            else{
                $res_json=array('success' => '0','message' => $this->lang->line('razorpay_currency_err'));
            }
        }
        else{
            // cart is empty
            $res_json=array('success' => '0','message' => $this->lang->line('ord_placed_empty_lbl'));
        }

        echo json_encode($res_json);
    }

    public function pay()
    {

        $success = true;

        $error = "";

        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

        if($user_id==0){
            redirect('login-register', 'refresh');
        }

        $this->order_unique_id='ORD'.$this->get_order_unique_id().rand(0,1000);

        if (empty($this->input->post('razorpay_payment_id')) === false)
        {
            $api = new Api($this->key_id, $this->secret_key);

            try
            {
                // perform action in database

                $payment_id=$this->input->post('razorpay_payment_id');
                $razorpay_order_id=$this->session->userdata("razorpay_order_id");

                $this->load->helper("date");

                $cart_ids=explode(',', $this->session->userdata('cart_ids'));

                $row_address=$this->common_model->selectByid($this->session->userdata('order_address'), 'tbl_addresses');

                $products_arr=array();
                $data_email=array();

                if(!empty($row_address)){

                    $is_avail=true;

                    if($this->session->userdata('buy_now')=='false')
                    {
                        $my_cart=$this->api_model->get_cart($user_id);

                        if(!empty($my_cart)){

                            foreach ($my_cart as $key => $value)
                            {
                                if($value->cart_status==0){
                                    $is_avail=false;
                                }
                            }

                            if(!$is_avail){
                                $message = array('message' => $this->lang->line('some_product_unavailable_lbl'),'class' => 'error');
                                $this->session->set_flashdata('response_msg', $message);
                                redirect(base_url() . 'checkout', 'refresh');
                            }

                            $data_arr = array(
                                'user_id' => $user_id,
                                'coupon_id' => $this->session->userdata('coupon_id'),
                                'order_unique_id' => $this->order_unique_id,
                                'order_address' => $this->session->userdata('order_address'),
                                'total_amt' => $this->session->userdata('total_amt'),
                                'discount' => $this->session->userdata('discount'),
                                'discount_amt' => $this->session->userdata('discount_amt'),
                                'payable_amt' => $this->session->userdata('payable_amt'),
                                'new_payable_amt' => $this->session->userdata('payable_amt'),
                                'delivery_date' => strtotime(date('d-m-Y h:i:s A', strtotime('+7 days'))),
                                'order_date' => strtotime(date('d-m-Y h:i:s A',now())),
                                'delivery_charge' => $this->session->userdata('delivery_charge'),
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

                            foreach ($my_cart as $key => $value){

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
                                $p_items['delivery_charge']=$this->session->userdata('delivery_charge');
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
                            }

                            $data_arr = array(
                                'user_id' => $this->session->userdata('user_id'),
                                'email' => $this->session->userdata('user_email'),
                                'order_id' => $order_id,
                                'order_unique_id' => $this->order_unique_id,
                                'gateway' => 'razorpay',
                                'payment_amt' => $this->session->userdata('payable_amt'),
                                'payment_id' => $payment_id,
                                'razorpay_order_id' => $razorpay_order_id,
                                'date' => strtotime(date('d-m-Y h:i:s A',now())),
                                'status' => '1',
                            );

                            $data_usr = $this->security->xss_clean($data_arr);

                            $this->common_model->insert($data_usr, 'tbl_transaction');

                            $data_update = array(
                                'order_status'  =>  '1',
                            );

                            $this->common_model->update($data_update, $order_id,'tbl_order_details');

                            $data_arr = array(
                                'order_id' => $order_id,
                                'user_id' => $this->session->userdata('user_id'),
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

                            $data_email['order_unique_id']=$this->order_unique_id;
                            $data_email['order_date']=date('d M, Y');
                            $data_email['delivery_address']=$delivery_address;
                            $data_email['discount_amt']=$this->session->userdata('discount_amt');
                            $data_email['total_amt']=$this->session->userdata('total_amt');
                            $data_email['delivery_charge']=$this->session->userdata('delivery_charge');
                            $data_email['payable_amt']=$this->session->userdata('payable_amt');

                            $data_email['products']=$products_arr;

                            $this->session->set_flashdata('data_email', $data_email);
                        }
                        else{
                            // cart is empty
                            $message = array('message' => $this->lang->line('ord_placed_empty_lbl'),'class' => 'error');
                            $this->session->set_flashdata('response_msg', $message);
                            redirect(base_url() . 'checkout', 'refresh');
                        }

                    }
                    else if($this->session->userdata('buy_now')=='true')
                    {
                        // logic for buy now

                        $my_cart=$this->api_model->get_cart($user_id,$cart_ids);

                        if(!empty($my_cart)){

                            foreach ($my_cart as $key => $value)
                            {
                                if($value->cart_status==0){
                                    $is_avail=false;
                                }
                            }

                            if(!$is_avail){
                                $message = array('message' => $this->lang->line('product_unavailable_lbl'),'class' => 'error');
                                $this->session->set_flashdata('response_msg', $message);
                                redirect($this->session->userdata('current_page'));
                            }

                            $data_arr = array(
                                'user_id' => $user_id,
                                'coupon_id' => $this->session->userdata('coupon_id'),
                                'order_unique_id' => $this->order_unique_id,
                                'order_address' => $this->session->userdata('order_address'),
                                'total_amt' => $this->session->userdata('total_amt'),
                                'discount' => $this->session->userdata('discount'),
                                'discount_amt' => $this->session->userdata('discount_amt'),
                                'payable_amt' => $this->session->userdata('payable_amt'),
                                'new_payable_amt' => $this->session->userdata('payable_amt'),
                                'delivery_date' => strtotime(date('d-m-Y h:i:s A', strtotime('+7 days'))),
                                'order_date' => strtotime(date('d-m-Y h:i:s A',now())),
                                'delivery_charge' => $this->session->userdata('delivery_charge'),
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

                            $this->order_id=$order_id;

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

                                $this->session->set_userdata("product_id", $value->product_id);

                                $data_ord_detail = $this->security->xss_clean($data_order);

                                $this->common_model->insert($data_ord_detail, 'tbl_order_items');

                                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $this->common_model->selectByidsParam(array('id' => $value->product_id),'tbl_product','featured_image'));

                                $img_file=$this->_create_thumbnail('assets/images/products/',$thumb_img_nm,$this->common_model->selectByidsParam(array('id' => $value->product_id),'tbl_product','featured_image'),300,300);

                                $p_items['product_url']=base_url('product/'.$value->product_slug);
                                $p_items['product_title']=$value->product_title;

                                $p_items['product_img']=base_url().$img_file;

                                $p_items['product_qty']=$value->product_qty;
                                $p_items['product_price']=$product_mrp;
                                $p_items['delivery_charge']=$this->session->userdata('delivery_charge');
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
                            }

                            $data_arr = array(
                                'user_id' => $this->session->userdata('user_id'),
                                'email' => $this->session->userdata('user_email'),
                                'order_id' => $order_id,
                                'order_unique_id' => $this->order_unique_id,
                                'gateway' => 'razorpay',
                                'payment_amt' => $this->session->userdata('payable_amt'),
                                'payment_id' => $payment_id,
                                'razorpay_order_id' => $razorpay_order_id,
                                'date' => strtotime(date('d-m-Y h:i:s A',now())),
                                'status' => '1',
                            );

                            $data_usr = $this->security->xss_clean($data_arr);

                            $this->common_model->insert($data_usr, 'tbl_transaction');

                            $data_update = array(
                                'order_status'  =>  '1',
                            );

                            $this->common_model->update($data_update, $order_id,'tbl_order_details');

                            $data_arr = array(
                                'order_id' => $order_id,
                                'user_id' => $this->session->userdata('user_id'),
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

                            $data_email['order_unique_id']=$this->order_unique_id;
                            $data_email['order_date']=date('d M, Y');
                            $data_email['delivery_address']=$delivery_address;
                            $data_email['discount_amt']=$this->session->userdata('discount_amt');
                            $data_email['total_amt']=$this->session->userdata('total_amt');
                            $data_email['delivery_charge']=$this->session->userdata('delivery_charge');
                            $data_email['payable_amt']=$this->session->userdata('payable_amt');

                            $data_email['products']=$products_arr;

                            $this->session->set_flashdata('data_email', $data_email);
                        }
                        else{
                            // cart is empty
                            $message = array('message' => $this->lang->line('ord_placed_empty_lbl'),'class' => 'error');
                            $this->session->set_flashdata('response_msg', $message);
                            redirect($this->session->userdata('current_page'));
                        }

                    }
                }
                else{
                    // no address found
                    $message = array('message' => $this->lang->line('no_address_found'),'class' => 'error');
                    $this->session->set_flashdata('response_msg', $message);
                    redirect($this->session->userdata('current_page'));
                }

                
            }
            catch(SignatureVerificationError $e)
            {
                $success = false;
                $error = 'Razorpay Error : ' . $e->getMessage();
            }
        }

        if ($success === true)
        {
            if($this->session->userdata('buy_now')=='false'){
                // remove cart table data
                $this->common_model->deleteByids(array('user_id' => $this->session->userdata('user_id')),'tbl_cart');
                $this->common_model->deleteByids(array('user_id' => $this->session->userdata('user_id'), 'cart_type' => 'main_cart'),'tbl_applied_coupon');
            }
            else{
                // remove temp cart table
                $this->common_model->delete($this->session->userdata('cart_ids'),'tbl_cart_tmp');
                $this->common_model->deleteByids(array('user_id' => $this->session->userdata('user_id'), 'product_id' => $this->session->userdata('product_id')),'tbl_cart');
                $this->common_model->deleteByids(array('user_id' => $this->session->userdata('user_id'), 'cart_type' => 'temp_cart'),'tbl_applied_coupon');
            }

            $data_email=$this->session->flashdata('data_email');

            $subject = $this->app_name.' - '.$this->lang->line('ord_summary_lbl');

            $body = $this->load->view('emails/order_summary.php',$data_email,TRUE);

            if(send_email($data_email['users_email'], $data_email['users_name'], $subject, $body)){

                 if($this->order_email!=''){

                    $subject = $this->app_name.' - '.$this->lang->line('new_ord_lbl');

                    $body = $this->load->view('emails/admin_order_summary.php',$data_email,TRUE);

                    send_email($this->order_email, $data_email['admin_name'], $subject, $body);
                } 
            }
            else {
                $res_json = array('success' => '0', 'msg' => $this->lang->line('email_not_sent'), 'order_unique_id' => $this->order_unique_id, 'error' => $this->email->print_debugger());
            }

            $res_json = array('success' => '1', 'msg' => $this->lang->line('ord_summary_mail_msg'), 'order_unique_id' => $this->order_unique_id);

            $this->session->set_flashdata('payment_msg', $res_json);
        }
        else
        {
            // delete order details page
            $this->common_model->deleteByids(array('id' => $this->order_id, 'user_id' => $this->session->userdata('user_id')), 'tbl_order_details');

            $this->common_model->deleteByids(array('order_id' => $this->order_id, 'user_id' => $this->session->userdata('user_id')), 'tbl_order_items');

            $this->common_model->deleteByids(array('order_id' => $this->order_id, 'user_id' => $this->session->userdata('user_id')), 'tbl_order_status');

            $this->common_model->deleteByids(array('order_id' => $this->order_id, 'user_id' => $this->session->userdata('user_id')), 'tbl_transaction');

            $message = array('success' => '0','message' => $error);
            $this->session->set_flashdata('payment_msg', $message);
        }

        $array_items = array('coupon_id', 'order_address', 'total_amt', 'discount', 'discount_amt', 'payable_amt', 'cart_ids', 'delivery_charge', 'razorpay_order_id','product_id');

        $this->session->unset_userdata($array_items);
        redirect('my-orders');
    }

    private function _create_thumbnail($path, $thumb_name, $fileName, $width, $height) 
    {
        $source_path = $path.$fileName;

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