<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Stripe extends CI_Controller
{
    private $stripe_secret;

    public $order_id;

    private $app_name;

    private $order_email;

    public function __construct()
    {
        parent::__construct();

        ini_set('MAX_EXECUTION_TIME', '-1');

        $this->load->library("session");
        $this->load->helper('url');
        $this->load->helper("date");

        $this->load->model('Common_model', 'common_model');
        $this->load->model('Api_model', 'api_model');

        $this->load->library("CompressImage");

        $app_setting = $this->api_model->app_details();

        define('APP_CURRENCY', $app_setting->app_currency_code);
        define('CURRENCY_CODE', $app_setting->app_currency_html_code);

        $this->stripe_secret = $app_setting->stripe_secret;

        $this->app_name = $app_setting->app_name;
        $this->app_name = $app_setting->app_name;
        $this->order_email = $app_setting->app_order_email;
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

    public function stripePost()
    {
        $user_id = $this->session->userdata('user_id') ? $this->session->userdata('user_id') : '0';

        if ($user_id == 0) {
            $message = array('message' => $this->lang->line('login_required_error'), 'class' => 'success');
            $this->session->set_flashdata('response_msg', $message);
            redirect('login-register', 'refresh');
        }

        $from_currency = urlencode('USD');
        $to_currency = strtoupper(APP_CURRENCY);

        $buy_now = $this->input->post('buy_now');

        $row_address = $this->common_model->selectByid($this->input->post('order_address'), 'tbl_addresses');

        if (!empty($row_address)) {
            $products_arr = array();
            $data_email = array();
            $cart_ids = $this->input->post('cart_ids');

            $total_cart_amt = $delivery_charge = $you_save = 0;

            $is_avail=true;

            $order_unique_id = 'ORD' . $this->get_order_unique_id() . rand(0, 1000);

            if ($buy_now == 'false') {
                // for cart checkout

                $my_cart = $this->api_model->get_cart($user_id);

                if (!empty($my_cart)) {

                    $where = array('user_id' => $user_id, 'cart_type' => 'main_cart');

                    $coupon_id = $this->input->post('coupon_id');

                    if (count($this->common_model->selectByids($where, 'tbl_applied_coupon')) == 0) {
                        $coupon_id = 0;
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

                    if ($coupon_id == 0) {
                        $discount = 0;
                        $discount_amt = 0;
                        $payable_amt = $total_cart_amt + $delivery_charge;
                    } else {

                        $coupon_json = json_decode($this->inner_apply_coupon($coupon_id, $cart_ids, 'main_cart'));
                        $discount = $coupon_json->discount;
                        $discount_amt = $coupon_json->discount_amt;
                        $payable_amt = $coupon_json->payable_amt;
                    }

                    if ($from_currency != $to_currency) {
                        if (convert_currency($to_currency, $from_currency, $payable_amt) < 1) {
                            $res_json = array('success' => '0', 'msg' => $this->lang->line('checkout_amt_error'));
                            echo json_encode($res_json);
                            return;
                        }
                    }

                    require_once('application/libraries/stripe-php/init.php');

                    \Stripe\Stripe::setApiKey($this->stripe_secret);

                    $intent = \Stripe\PaymentIntent::create([
                        'amount' => $payable_amt * 100,
                        'currency' => strtolower(APP_CURRENCY),
                    ]);

                    $token = \Stripe\Token::create([
                        'card' => [
                            'number' => $this->input->post('card_no'),
                            'exp_month' => $this->input->post('ccExpiryMonth'),
                            'exp_year' => $this->input->post('ccExpiryYear'),
                            'cvc' => $this->input->post('cvvNumber'),
                        ],
                    ]);

                    if (!isset($token['id'])) {
                        $res_json = array('success' => '0', 'msg' => $this->lang->line('stripe_token_issue'));
                        echo json_encode($res_json);
                        return;
                    }
            
                    $charge = \Stripe\Charge::create([
                        "amount" => $payable_amt * 100,
                        "currency" => APP_CURRENCY,
                        "source" => $token['id'],
                        "description" => $this->lang->line('stripe_ord_prefix')." ".$order_unique_id
                    ]);

                    // check payment status
                    if ($charge['status'] == 'succeeded') {

                        $stripe_payment_id = $charge['id'];

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
    
                            $this->common_model->delete($cart_id,'tbl_cart');
                        }

                        $data_arr = array(
                            'user_id' => $user_id,
                            'email' => $this->session->userdata('user_email'),
                            'order_id' => $order_id,
                            'order_unique_id' => $order_unique_id,
                            'gateway' => $this->input->post('payment_method'),
                            'payment_amt' => $payable_amt,
                            'payment_id' => $stripe_payment_id,
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
                            $res_json=array('success' => '0','msg' => $this->lang->line('email_not_sent'), 'order_unique_id' => $order_unique_id);
                        }

                        $res_json=array('success' => '1','msg' => $this->lang->line('ord_summary_mail_msg'), 'order_unique_id' => $order_unique_id); 

                        $this->session->set_flashdata('payment_msg', $res_json);
    
                        $this->common_model->deleteByids(array('user_id' => $user_id, 'cart_type' => 'main_cart'),'tbl_applied_coupon');
                    }
                    else{
                        $res_json = array('success' => '0', 'msg' => $this->lang->line('stripe_failed_err'));
                    }
                } else {
                    $res_json = array('success' => '-1', 'msg' => $this->lang->line('ord_placed_empty_lbl'));    
                }
                echo json_encode($res_json);
                return;

            } else {
                // for buy now

                $my_cart = $this->api_model->get_cart($user_id, $cart_ids);

                if (!empty($my_cart)) {

                    $where = array('user_id' => $user_id, 'cart_type' => 'temp_cart');

                    $coupon_id = $this->input->post('coupon_id');

                    if (count($this->common_model->selectByids($where, 'tbl_applied_coupon')) == 0) {
                        $coupon_id = 0;
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

                    if ($coupon_id == 0) {
                        $discount = 0;
                        $discount_amt = 0;
                        $payable_amt = $total_cart_amt + $delivery_charge;
                    } else {

                        $coupon_json = json_decode($this->inner_apply_coupon($coupon_id, $cart_ids, 'temp_cart'));
                        $discount = $coupon_json->discount;
                        $discount_amt = $coupon_json->discount_amt;
                        $payable_amt = $coupon_json->payable_amt;
                    }

                    if ($from_currency != $to_currency) {
                        if (convert_currency($to_currency, $from_currency, $payable_amt) < 1) {
                            $res_json = array('success' => '0', 'msg' => $this->lang->line('checkout_amt_error'));
                            echo json_encode($res_json);
                            return;
                        }
                    }

                    require_once('application/libraries/stripe-php/init.php');

                    \Stripe\Stripe::setApiKey($this->stripe_secret);

                    $intent = \Stripe\PaymentIntent::create([
                        'amount' => $payable_amt * 100,
                        'currency' => strtolower(APP_CURRENCY),
                    ]);

                    $token = \Stripe\Token::create([
                        'card' => [
                            'number' => $this->input->post('card_no'),
                            'exp_month' => $this->input->post('ccExpiryMonth'),
                            'exp_year' => $this->input->post('ccExpiryYear'),
                            'cvc' => $this->input->post('cvvNumber'),
                        ],
                    ]);

                    if (!isset($token['id'])) {
                        $res_json = array('success' => '0', 'msg' => $this->lang->line('stripe_token_issue'));
                        echo json_encode($res_json);
                        return;
                    }
            
                    $charge = \Stripe\Charge::create([
                        "amount" => $payable_amt * 100,
                        "currency" => APP_CURRENCY,
                        "source" => $token['id'],
                        "description" => $this->lang->line('stripe_ord_prefix')." ".$order_unique_id
                    ]);

                    // check payment status
                    if ($charge['status'] == 'succeeded') {

                        $stripe_payment_id = $charge['id'];

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

                            $this->common_model->deleteByids(array('user_id' => $user_id, 'product_id'  =>  $value->product_id),'tbl_cart');
    
                            $this->common_model->delete($cart_id,'tbl_cart_tmp');
                        }

                        $data_arr = array(
                            'user_id' => $user_id,
                            'email' => $this->session->userdata('user_email'),
                            'order_id' => $order_id,
                            'order_unique_id' => $order_unique_id,
                            'gateway' => $this->input->post('payment_method'),
                            'payment_amt' => $payable_amt,
                            'payment_id' => $stripe_payment_id,
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
                            $res_json=array('success' => '0','msg' => $this->lang->line('email_not_sent'), 'order_unique_id' => $order_unique_id);
                        }
                        
                        $res_json=array('success' => '1','msg' => $this->lang->line('ord_summary_mail_msg'), 'order_unique_id' => $order_unique_id); 

                        $this->session->set_flashdata('payment_msg', $res_json);
    
                        $this->common_model->deleteByids(array('user_id' => $user_id, 'cart_type' => 'temp_cart'),'tbl_applied_coupon');
                    }
                    else{
                        $res_json = array('success' => '0', 'msg' => $this->lang->line('stripe_failed_err'));
                    }
                }
                else {
                    $res_json = array('success' => '-1', 'msg' => $this->lang->line('ord_placed_empty_lbl'));
                }
                echo json_encode($res_json);
                return;
            }
        }
        else {
            // no address found
            $res_json = array('success' => '0', 'msg' => $this->lang->line('no_address_found'));
            echo json_encode($res_json);
            return;
        }
    }

    private function convert_currency($to_currency, $from_currency, $amount)
    {
        $req_url = 'https://api.exchangerate-api.com/v4/latest/' . $to_currency;
        $response_json = file_get_contents($req_url);

        $price = number_format($amount, 2);

        if (false !== $response_json) {

            try {

                $response_object = json_decode($response_json);

                return $price = number_format(round(($amount * $response_object->rates->$from_currency), 2), 2);
            } catch (Exception $e) {
                print_r($e);
            }
        }
    }

    private function _create_thumbnail($path, $thumb_name, $fileName, $width, $height)
    {
        $source_path = $path . $fileName;

        if (file_exists($source_path)) {
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);

            $thumb_name = $thumb_name . '_' . $width . 'x' . $height . '.' . $ext;

            $thumb_path = $path . 'thumbs/' . $thumb_name;

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
