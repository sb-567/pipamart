<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'libraries/paypal-php-sdk/sample/bootstrap.php'); // require paypal files

/** All Paypal Details class **/

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;

use PayPal\Api\PayerInfo;

class Paypal extends CI_Controller
{
    public $_api_context;

    private $app_name;

    private $app_email;

    private $order_email;

    private $buy_now=null;

    function  __construct()
    {
        parent::__construct();

        ini_set('MAX_EXECUTION_TIME', '-1');

        $this->load->model('paypal_model', 'paypal');
        $this->load->model('Offers_model');
        $this->load->model('Api_model', 'api_model');

        $app_setting = $this->api_model->app_details();

        $smtp_setting = $this->api_model->smtp_settings();

        $this->app_name = $app_setting->app_name;
        $this->app_email = $smtp_setting->smtp_email;
        $this->order_email = $app_setting->app_order_email;

        define('APP_CURRENCY', $app_setting->app_currency_code);
        define('CURRENCY_CODE', $app_setting->app_currency_html_code);

        $this->load->library("CompressImage");

        $this->load->model('common_model');

        // paypal credentials
        $this->config->load('paypal');

        $this->_api_context = new \PayPal\Rest\ApiContext(
            new \PayPal\Auth\OAuthTokenCredential(
                $app_setting->paypal_client_id,
                $app_setting->paypal_secret_key
            )
        );
    }

    function create_payment_with_paypal()
    {
        $user_id = $this->session->userdata('user_id') ? $this->session->userdata('user_id') : '0';

        if ($user_id == 0) {
            redirect('login-register', 'refresh');
        }

        $row_address = $this->common_model->selectByid($this->input->post('order_address'), 'tbl_addresses');

        $products_arr = array();
        $data_email = array();

        if (!empty($row_address)) {

            $order_unique_id = 'ORD' . $this->get_order_unique_id() . rand(0, 1000);
            $this->session->set_userdata('order_unique_id', $order_unique_id);

            $this->load->helper("date");

            $cart_ids = $this->input->post('cart_ids');

            // Setup PayPal api context
            $this->_api_context->setConfig($this->config->item('settings'));

            $itemList = new ItemList();

            $items = array();

            $total_cart_amt = $delivery_charge = $you_save = 0;

            $this->buy_now=$this->input->post('buy_now');

            $is_avail=true;

            if ($this->input->post('buy_now') == 'false') {
                
                $where=array('user_id' => $user_id, 'cart_type' => 'main_cart');

                $my_cart = $this->api_model->get_cart($user_id);

                if (!empty($my_cart)) {

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
                        $message = array('message' => $this->lang->line('some_product_unavailable_lbl'), 'class' => 'error');
                        $this->session->set_flashdata('response_msg', $message);
                        redirect($this->input->post('current_page'));
                    }

                    if ($coupon_id == 0) {
                        $discount = 0;
                        $discount_amt = 0;
                        $payable_amt = $total_cart_amt + $delivery_charge;
                    } else {

                        $coupon_json = json_decode($this->inner_apply_coupon($coupon_id));
                        $discount = $coupon_json->discount;
                        $discount_amt = $coupon_json->discount_amt;
                        $payable_amt = $coupon_json->payable_amt;
                    }

                    foreach ($my_cart as $value) {

                        $cart_id = $value->id;

                        $total_price = ($value->product_qty * $value->selling_price);

                        $product_mrp = $value->selling_price;

                        $delivery_charge = $value->delivery_charge;

                        $item["name"] = $value->product_title;
                        $item["sku"] = $value->product_id;  // Similar to `item_number` in Classic API

                        $description = '';

                        if (strlen($this->common_model->selectByidsParam(array('id' => $value->product_id), 'tbl_product', 'product_desc')) > 30) {
                            $description = substr(stripslashes($this->common_model->selectByidsParam(array('id' => $value->product_id), 'tbl_product', 'product_desc')), 0, 30) . '...';
                        } else {
                            $description = $this->common_model->selectByidsParam(array('id' => $value->product_id), 'tbl_product', 'product_desc');
                        }

                        $item["description"] = strip_tags($description);
                        $item["currency"] = APP_CURRENCY;
                        $item["quantity"] = $value->product_qty;

                        $product_actual_amt = 0;

                        if ($coupon_id != 0) {

                            $product_per = number_format((float)(($product_mrp / $total_cart_amt) * 100), 2, '.', '');  //44
                            $product_amt_per = number_format((float)(($product_per / 100) * $discount_amt), 2, '.', ''); //22
                            $product_actual_amt = $product_mrp - $product_amt_per; //38 
                        } else {
                            $product_actual_amt = number_format((float)$product_mrp, 2, '.', '');
                        }

                        $product_actual_amt += number_format((float)$delivery_charge, 2, '.', '');

                        $item["price"] = number_format((float)$product_actual_amt, 2, '.', '');

                        array_push($items, $item);
                    }

                    $itemList->setItems($items);

                    $payer['payment_method'] = 'paypal';

                    $details['tax'] = '';
                    $details['subtotal'] = number_format((float)$payable_amt, 2, '.', '');

                    $amount['currency'] = APP_CURRENCY;
                    $amount['total'] = number_format((float)$payable_amt, 2, '.', '');

                    $transaction['description'] = 'Order Payment description';
                    $transaction['amount'] = $amount;
                    $transaction['invoice_number'] = uniqid();
                    $transaction['item_list'] = $itemList;

                    $baseUrl = base_url();
                    $redirectUrls = new RedirectUrls();
                    $redirectUrls->setReturnUrl($baseUrl . "paypal/getPaymentStatus")
                        ->setCancelUrl($baseUrl . "paypal/getPaymentStatus");


                    $payment = new Payment();
                    $payment->setIntent("sale")
                        ->setPayer($payer)
                        ->setRedirectUrls($redirectUrls)
                        ->setTransactions(array($transaction));

                    try {
                        $payment->create($this->_api_context);

                        $row_address = $this->common_model->selectByid($this->input->post('order_address'), 'tbl_addresses');

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
                            'order_date' => strtotime(date('d-m-Y h:i:s A', now())),
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

                        $this->session->set_userdata("order_id", $order_id);

                        $products_arr = array();

                        foreach ($my_cart as $value) {

                            $cart_id = $value->id;

                            $total_price = ($value->product_qty * $value->selling_price);

                            $product_mrp = $value->selling_price;

                            $data_order_item = array(
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
                                'delivery_charge'  =>  $value->delivery_charge
                            );

                            $data_ord_items = $this->security->xss_clean($data_order_item);

                            $this->common_model->insert($data_ord_items, 'tbl_order_items');

                            $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $this->common_model->selectByidsParam(array('id' => $value->product_id), 'tbl_product', 'featured_image'));

                            $img_file = $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $this->common_model->selectByidsParam(array('id' => $value->product_id), 'tbl_product', 'featured_image'), 300, 300);

                            $p_items['product_url']=base_url('product/'.$value->product_slug);

                            $p_items['product_title'] = $value->product_title;
                            $p_items['product_img'] = base_url() . $img_file;
                            $p_items['product_qty'] = $value->product_qty;
                            $p_items['product_price'] = $product_mrp;
                            $p_items['delivery_charge'] = $delivery_charge;
                            $p_items['product_size'] = $value->product_size;

                            $product_color = $this->common_model->selectByidsParam(array('id' => $value->product_id), 'tbl_product', 'color');

                            if ($product_color != '') {

                                $color_arr = explode('/', $product_color);
                                $color_name = $color_arr[0];
                                $color_code = $color_arr[1];

                                $product_color = $color_name;
                            }

                            $p_items['product_color'] = $product_color;

                            $p_items['delivery_date'] = date('d M, Y') . '-' . date('d M, Y', strtotime('+7 days'));

                            array_push($products_arr, $p_items);

                            $this->common_model->delete($cart_id,'tbl_cart');
                        }

                        $data_arr = array(
                            'user_id' => $user_id,
                            'email' => $this->session->userdata('user_email'),
                            'order_id' => $order_id,
                            'order_unique_id' => $order_unique_id,
                            'gateway' => $this->input->post('payment_method'),
                            'date' => strtotime(date('d-m-Y h:i:s A', now())),
                        );

                        $data_usr = $this->security->xss_clean($data_arr);

                        $this->common_model->insert($data_usr, 'tbl_transaction');

                        $data_arr = array(
                            'order_id' => $order_id,
                            'user_id' => $user_id,
                            'product_id' => '0',
                            'status_title' => '1',
                            'status_desc' => $this->lang->line('0'),
                            'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
                        );

                        $data_usr = $this->security->xss_clean($data_arr);

                        $this->common_model->insert($data_usr, 'tbl_order_status');

                        $where = array('order_id' => $order_id);

                        $row_items = $this->common_model->selectByids($where, 'tbl_order_items');

                        foreach ($row_items as $key2 => $value2) 
                        {
                            $data_arr = array(
                                'order_id' => $order_id,
                                'user_id' => $value2->user_id,
                                'product_id' => $value2->product_id,
                                'status_title' => '1',
                                'status_desc' => $this->lang->line('0'),
                                'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
                            );

                            $data_usr = $this->security->xss_clean($data_arr);

                            $this->common_model->insert($data_usr, 'tbl_order_status');

                            $data_pro = array(
                                'pro_order_status' => '1'
                            );

                            $data_pro = $this->security->xss_clean($data_pro);

                            $this->common_model->updateByids($data_pro, array('order_id' => $order_id, 'product_id' => $value2->product_id), 'tbl_order_items');
                        }

                        $row_tran = $this->common_model->selectByids(array('order_unique_id ' => $order_unique_id), 'tbl_transaction')[0];

                        $data_email['payment_mode'] = strtoupper($row_tran->gateway);

                        $delivery_address = $row_address->building_name . ', ' . $row_address->road_area_colony . ',<br/>' . $row_address->pincode . '<br/>' . $row_address->city . ', ' . $row_address->state . ', ' . $row_address->country;

                        $data_email['users_name'] = $row_address->name;
                        $data_email['users_email'] = $row_address->email;
                        $data_email['users_mobile'] = $row_address->mobile_no;

                        $admin_name = $this->common_model->selectByidsParam(array('id' => 1), 'tbl_admin', 'username');

                        $data_email['admin_name'] = ucfirst($admin_name);

                        $data_email['order_unique_id'] = $order_unique_id;
                        $data_email['order_date'] = date('d M, Y');
                        $data_email['delivery_address'] = $delivery_address;
                        $data_email['discount_amt'] = $discount_amt;
                        $data_email['total_amt'] = $total_cart_amt;
                        $data_email['delivery_charge'] = $delivery_charge;
                        $data_email['payable_amt'] = $payable_amt;

                        $data_email['products'] = $products_arr;

                        $this->session->set_userdata("data_email", $data_email);
                        
                    } catch (Exception $ex) {
                        ResultPrinter::printError("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", null, $ex);
                        exit(1);
                    }

                    foreach ($payment->getLinks() as $link) {
                        if ($link->getRel() == 'approval_url') {
                            $redirect_url = $link->getHref();
                            break;
                        }
                    }

                    if (isset($redirect_url)) {
                        redirect($redirect_url);
                    }

                    $message = array('message' => 'Unknown error occurred', 'class' => 'error');
                    $this->session->set_flashdata('response_msg', $message);
                    redirect('checkout');
                } else {
                    // cart is empty
                    $message = array('message' => $this->lang->line('ord_placed_empty_lbl'), 'class' => 'error');
                    $this->session->set_flashdata('response_msg', $message);
                    redirect($this->input->post('current_page'));
                }

            } 
            else if ($this->input->post('buy_now') == 'true') {

                $where=array('user_id' => $user_id, 'cart_type' => 'temp_cart');

                $my_cart = $this->api_model->get_cart($user_id, $cart_ids);

                if (!empty($my_cart))
                {

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
                        $message = array('message' => $this->lang->line('some_product_unavailable_lbl'), 'class' => 'error');
                        $this->session->set_flashdata('response_msg', $message);
                        redirect($this->input->post('current_page'));
                    }

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
                        $message = array('message' => $this->lang->line('some_product_unavailable_lbl'), 'class' => 'error');
                        $this->session->set_flashdata('response_msg', $message);
                        redirect($this->input->post('current_page'));
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

                    foreach ($my_cart as $value) {

                        $cart_id = $value->id;

                        $total_price = ($value->product_qty * $value->selling_price);

                        $product_mrp = $value->selling_price;

                        $delivery_charge = $value->delivery_charge;

                        $item["name"] = $value->product_title;
                        $item["sku"] = $value->product_id;  // Similar to `item_number` in Classic API

                        $description = '';

                        if (strlen($this->common_model->selectByidsParam(array('id' => $value->product_id), 'tbl_product', 'product_desc')) > 30) {
                            $description = substr(stripslashes($this->common_model->selectByidsParam(array('id' => $value->product_id), 'tbl_product', 'product_desc')), 0, 30) . '...';
                        } else {
                            $description = $this->common_model->selectByidsParam(array('id' => $value->product_id), 'tbl_product', 'product_desc');
                        }

                        $item["description"] = strip_tags($description);
                        $item["currency"] = APP_CURRENCY;
                        $item["quantity"] = $value->product_qty;

                        $product_actual_amt = 0;

                        if ($coupon_id != 0) {

                            $product_per = number_format((float)(($product_mrp / $total_cart_amt) * 100), 2, '.', '');  //44
                            $product_amt_per = number_format((float)(($product_per / 100) * $discount_amt), 2, '.', ''); //22
                            $product_actual_amt = $product_mrp - $product_amt_per; //38 
                        } else {
                            $product_actual_amt = number_format((float)$product_mrp, 2, '.', '');
                        }

                        $product_actual_amt += number_format((float)$delivery_charge, 2, '.', '');

                        $item["price"] = number_format((float)$product_actual_amt, 2, '.', '');

                        array_push($items, $item);
                    }

                    $itemList->setItems($items);

                    $payer['payment_method'] = 'paypal';

                    $details['tax'] = '';
                    $details['subtotal'] = number_format((float)$payable_amt, 2, '.', '');

                    $amount['currency'] = APP_CURRENCY;
                    $amount['total'] = number_format((float)$payable_amt, 2, '.', '');

                    $transaction['description'] = 'Order Payment description';
                    $transaction['amount'] = $amount;
                    $transaction['invoice_number'] = uniqid();
                    $transaction['item_list'] = $itemList;

                    $baseUrl = base_url();
                    $redirectUrls = new RedirectUrls();
                    $redirectUrls->setReturnUrl($baseUrl . "paypal/getPaymentStatus")
                        ->setCancelUrl($baseUrl . "paypal/getPaymentStatus");


                    $payment = new Payment();
                    $payment->setIntent("sale")
                        ->setPayer($payer)
                        ->setRedirectUrls($redirectUrls)
                        ->setTransactions(array($transaction));

                    try {
                        $payment->create($this->_api_context);

                        $row_address = $this->common_model->selectByid($this->input->post('order_address'), 'tbl_addresses');

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
                            'order_date' => strtotime(date('d-m-Y h:i:s A', now())),
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

                        $order_id=$this->common_model->insert($data_ord, 'tbl_order_details');

                        $this->session->set_userdata("order_id", $order_id);

                        $products_arr = array();

                        foreach ($my_cart as $value) {

                            $cart_id = $value->id;

                            $total_price = ($value->product_qty * $value->selling_price);

                            $product_mrp = $value->selling_price;

                            $data_order_item = array(
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
                                'delivery_charge'  =>  $value->delivery_charge
                            );

                            $data_ord_items = $this->security->xss_clean($data_order_item);

                            $this->common_model->insert($data_ord_items, 'tbl_order_items');

                            $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $this->common_model->selectByidsParam(array('id' => $value->product_id), 'tbl_product', 'featured_image'));

                            $img_file = $this->_create_thumbnail('assets/images/products/', $thumb_img_nm, $this->common_model->selectByidsParam(array('id' => $value->product_id), 'tbl_product', 'featured_image'), 300, 300);

                            $p_items['product_url']=base_url('product/'.$value->product_slug);
                            $p_items['product_title'] = $value->product_title;
                            $p_items['product_img'] = base_url() . $img_file;
                            $p_items['product_qty'] = $value->product_qty;
                            $p_items['product_price'] = $product_mrp;
                            $p_items['delivery_charge'] = $delivery_charge;
                            $p_items['product_size'] = $value->product_size;

                            $product_color = $this->common_model->selectByidsParam(array('id' => $value->product_id), 'tbl_product', 'color');

                            if ($product_color != '') {

                                $color_arr = explode('/', $product_color);
                                $color_name = $color_arr[0];
                                $color_code = $color_arr[1];

                                $product_color = $color_name;
                            }

                            $p_items['product_color'] = $product_color;

                            $p_items['delivery_date'] = date('d M, Y') . '-' . date('d M, Y', strtotime('+7 days'));

                            $this->common_model->delete($cart_id,'tbl_cart_tmp');

                            $this->common_model->deleteByids(array('user_id' => $user_id, 'product_id'  =>  $value->product_id),'tbl_cart');

                            array_push($products_arr, $p_items);
                        }

                        $data_arr = array(
                            'user_id' => $user_id,
                            'email' => $this->session->userdata('user_email'),
                            'order_id' => $order_id,
                            'order_unique_id' => $order_unique_id,
                            'gateway' => $this->input->post('payment_method'),
                            'date' => strtotime(date('d-m-Y h:i:s A', now())),
                        );

                        $data_usr = $this->security->xss_clean($data_arr);

                        $this->common_model->insert($data_usr, 'tbl_transaction');

                        $data_arr = array(
                            'order_id' => $order_id,
                            'user_id' => $user_id,
                            'product_id' => '0',
                            'status_title' => '1',
                            'status_desc' => $this->lang->line('0'),
                            'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
                        );

                        $data_usr = $this->security->xss_clean($data_arr);

                        $this->common_model->insert($data_usr, 'tbl_order_status');

                        $where = array('order_id' => $order_id);

                        $row_items = $this->common_model->selectByids($where, 'tbl_order_items');

                        foreach ($row_items as $key2 => $value2) {
                            $data_arr = array(
                                'order_id' => $order_id,
                                'user_id' => $value2->user_id,
                                'product_id' => $value2->product_id,
                                'status_title' => '1',
                                'status_desc' => $this->lang->line('0'),
                                'created_at' => strtotime(date('d-m-Y h:i:s A', now()))
                            );

                            $data_usr = $this->security->xss_clean($data_arr);

                            $this->common_model->insert($data_usr, 'tbl_order_status');

                            $data_pro = array(
                                'pro_order_status' => '1'
                            );

                            $data_pro = $this->security->xss_clean($data_pro);

                            $this->common_model->updateByids($data_pro, array('order_id' => $order_id, 'product_id' => $value2->product_id), 'tbl_order_items');
                        }

                        $row_tran = $this->common_model->selectByids(array('order_unique_id ' => $order_unique_id), 'tbl_transaction')[0];

                        $data_email['payment_mode'] = strtoupper($row_tran->gateway);

                        $delivery_address = $row_address->building_name . ', ' . $row_address->road_area_colony . ',<br/>' . $row_address->pincode . '<br/>' . $row_address->city . ', ' . $row_address->state . ', ' . $row_address->country;

                        $data_email['users_name'] = $row_address->name;
                        $data_email['users_email'] = $row_address->email;
                        $data_email['users_mobile'] = $row_address->mobile_no;

                        $admin_name = $this->common_model->selectByidsParam(array('id' => 1), 'tbl_admin', 'username');

                        $data_email['admin_name'] = ucfirst($admin_name);

                        $data_email['order_unique_id'] = $order_unique_id;
                        $data_email['order_date'] = date('d M, Y');
                        $data_email['delivery_address'] = $delivery_address;
                        $data_email['discount_amt'] = $discount_amt;
                        $data_email['total_amt'] = $total_cart_amt;
                        $data_email['delivery_charge'] = $delivery_charge;
                        $data_email['payable_amt'] = $payable_amt;

                        $data_email['products'] = $products_arr;

                        $this->session->set_userdata("data_email", $data_email);
                        
                    } catch (Exception $ex) {
                        ResultPrinter::printError("Created Payment Using PayPal. Please visit the URL to Approve.", "Payment", null, $ex);
                        exit(1);
                    }

                    foreach ($payment->getLinks() as $link) {
                        if ($link->getRel() == 'approval_url') {
                            $redirect_url = $link->getHref();
                            break;
                        }
                    }

                    if (isset($redirect_url)) {
                        redirect($redirect_url);
                    }

                    $message = array('message' => 'Unknown error occurred', 'class' => 'error');
                    $this->session->set_flashdata('response_msg', $message);
                    redirect('checkout');
                } else {
                    // cart is empty
                    $message = array('message' => $this->lang->line('ord_placed_empty_lbl'), 'class' => 'error');
                    $this->session->set_flashdata('response_msg', $message);
                    redirect($this->input->post('current_page'));
                }
            }
        } else {
            // no address found
            $message = array('message' => $this->lang->line('no_address_found'), 'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
            redirect($this->input->post('current_page'));
        }
    }


    function getPaymentStatus()
    {
        // paypal credentials
        $order_id = $this->session->userdata('order_id');
        $order_unique_id = $this->session->userdata('order_unique_id');

        $data_email = $this->session->userdata('data_email');

        /** Get the payment ID before session clear **/
        $payment_id = $this->input->get("paymentId");
        $PayerID = $this->input->get("PayerID");
        $token = $this->input->get("token");
        /** clear the session payment ID **/

        if (empty($PayerID) || empty($token)) {

            // delete order details page
            $this->common_model->deleteByids(array('id' => $order_id, 'user_id' => $this->session->userdata('user_id')), 'tbl_order_details');

            $this->common_model->deleteByids(array('order_id' => $order_id, 'user_id' => $this->session->userdata('user_id')), 'tbl_order_items');

            $this->common_model->deleteByids(array('order_id' => $order_id, 'user_id' => $this->session->userdata('user_id')), 'tbl_order_status');

            $this->common_model->deleteByids(array('order_id' => $order_id, 'user_id' => $this->session->userdata('user_id')), 'tbl_transaction');

            $array_items = array('order_id', 'order_unique_id', 'data_email');

            $this->session->unset_userdata($array_items);

            $message = array('message' => 'Error in Payment !!!', 'class' => 'error');
            $this->session->set_flashdata('response_msg', $message);
            redirect('checkout');
        }

        $payment = Payment::get($payment_id, $this->_api_context);

        $execution = new PaymentExecution();
        $execution->setPayerId($this->input->get('PayerID'));

        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);

        //  DEBUG RESULT, remove it later **/
        if ($result->getState() == 'approved') {
            $trans = $result->getTransactions();

            $relatedResources = $trans[0]->getRelatedResources();
            $sale = $relatedResources[0]->getSale();
            // sale info //
            $saleId = $sale->getId();
            $CreateTime = $sale->getCreateTime();
            $UpdateTime = $sale->getUpdateTime();
            $State = $sale->getState();
            $Total = $sale->getAmount()->getTotal();

            $data_arr = array(
                'payment_amt' => $Total,
                'payment_id' => $payment_id,
                'status' => '1'
            );

            $data_usr = $this->security->xss_clean($data_arr);

            $where = array('order_id' => $order_id);

            $this->common_model->updateByids($data_usr, $where, 'tbl_transaction');

            $data_update = array(
                'order_status'  =>  '1',
            );

            $this->common_model->update($data_update, $order_id, 'tbl_order_details');

            $subject = $this->app_name.' - '.$this->lang->line('ord_summary_lbl');

            array_push($data_email, array('payment_id' => $payment_id));

            $body = $this->load->view('emails/order_summary.php',$data_email,TRUE);

            if(send_email($data_email['users_email'], $data_email['users_name'], $subject, $body)){

                 if($this->order_email!=''){

                    $subject = $this->app_name.' - '.$this->lang->line('new_ord_lbl');

                    $body = $this->load->view('emails/admin_order_summary.php',$data_email,TRUE);

                    send_email($this->order_email, $data_email['admin_name'], $subject, $body);
                } 
            }
            else {
                $res_json = array('success' => '0', 'msg' => $this->lang->line('email_not_sent'), 'order_unique_id' => $order_unique_id, 'error' => $this->email->print_debugger());
            }

            $res_json = array('success' => '1', 'msg' => $this->lang->line('ord_summary_mail_msg'), 'order_unique_id' => $order_unique_id);

            if($this->buy_now=='false'){
                // remove from tbl_cart

                $this->common_model->deleteByids(array('user_id' => $this->session->userdata('user_id'), 'cart_type' => 'main_cart'),'tbl_applied_coupon');
            }
            else{
                // remove from tbl_tmp_cart

                $this->common_model->deleteByids(array('user_id' => $this->session->userdata('user_id'), 'cart_type' => 'temp_cart'),'tbl_applied_coupon');
            }

            $array_items = array('order_id', 'order_unique_id', 'data_email');

            $this->session->unset_userdata($array_items);
            
            $this->session->set_flashdata('payment_msg', $res_json);
            redirect('my-orders');
        }

        // delete order details page
        $this->common_model->deleteByids(array('id' => $order_id, 'user_id' => $this->session->userdata('user_id')), 'tbl_order_details');

        $this->common_model->deleteByids(array('order_id' => $order_id, 'user_id' => $this->session->userdata('user_id')), 'tbl_order_items');

        $this->common_model->deleteByids(array('order_id' => $order_id, 'user_id' => $this->session->userdata('user_id')), 'tbl_order_status');

        $this->common_model->deleteByids(array('order_id' => $order_id, 'user_id' => $this->session->userdata('user_id')), 'tbl_transaction');

        redirect('paypal/cancel');
    }
    function cancel()
    {
        $order_id = $this->session->userdata('order_id');

        // delete order details page
        $this->common_model->deleteByids(array('id' => $order_id, 'user_id' => $this->session->userdata('user_id')), 'tbl_order_details');

        $this->common_model->deleteByids(array('order_id' => $order_id, 'user_id' => $this->session->userdata('user_id')), 'tbl_order_items');

        $this->common_model->deleteByids(array('order_id' => $order_id, 'user_id' => $this->session->userdata('user_id')), 'tbl_order_status');

        $this->common_model->deleteByids(array('order_id' => $order_id, 'user_id' => $this->session->userdata('user_id')), 'tbl_transaction');

        $array_items = array('order_id', 'order_unique_id', 'data_email');

        $this->session->unset_userdata($array_items);

        $message = array('message' => 'Payment failed', 'class' => 'error');
        $this->session->set_flashdata('response_msg', $message);
        redirect('checkout');
    }

    // get order unique id
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
