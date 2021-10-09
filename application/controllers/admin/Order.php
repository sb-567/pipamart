<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller {

    private $app_logo;

    private $app_name;

    public function __construct(){
        parent::__construct();

        ini_set('MAX_EXECUTION_TIME', '-1');

        check_login_user();
        $this->load->helper('image'); 
        $this->load->model('common_model');
        $this->load->model('Order_model');
        $this->load->model('Product_model');
        $this->load->model('Api_model','api_model');

        $this->load->library("CompressImage");

        $this->load->helper("date");

        $app_setting = $this->api_model->app_details();

        $this->app_name=$app_setting->app_name;
    }

    public function get_status_title($id){
        return $this->common_model->selectByidParam($id,'tbl_status_title','title');
    }

    function index()
    {
        $data = array();
        $data['page_title'] = $this->lang->line('ord_list_lbl');
        $data['current_page'] = $this->lang->line('ord_list_lbl');

        if($this->input->get('ord_status')){

            $ord_status=trim($this->input->get('ord_status'));

            $data['order_list'] = $this->common_model->selectWhere('tbl_order_details',array('order_status' => $ord_status),'DESC');
        }
        else{
            $data['order_list'] = $this->Order_model->order_list();
        }

        $data['status_titles'] = $this->Order_model->get_titles(true);

        $this->template->load('admin/template', 'admin/page/orders', $data); // :blush:
    } 

    public function order_summary()
    {
        $data = array();

        $order_no =  $this->uri->segment(3);

        if(!empty($this->Order_model->get_order($order_no))){
            $data['page_title'] = $this->lang->line('ord_list_lbl');
            $data['current_page'] = $this->lang->line('ord_summary_lbl');

            $data['order_data'] = $this->Order_model->get_order($order_no);

            $where = array('order_unique_id ' => $order_no);

            $rowRefund = $this->common_model->selectByids($where, 'tbl_refund');

            $data['refund_data'] = $rowRefund;

            $data_update=array('is_seen' => 1);

            $this->common_model->updateByids($data_update, array('order_unique_id' => $order_no),'tbl_order_details');

            $this->template->load('admin/template', 'admin/page/view_order', $data); // :blush:
        }
        else{
            redirect('admin/orders', 'refresh');
        }
    }

    public function print_order()
    {
        $data = array();

        $order_no =  $this->uri->segment(4);

        $where = array('order_unique_id ' => $order_no);

        $rowRefund = $this->common_model->selectByids($where, 'tbl_refund');

        $data['refund_data'] = $rowRefund;

        $data['order_data'] = $this->Order_model->get_order($order_no);
        $this->load->view('admin/page/print_order', $data); // :blush:
    }

    public function download_invoice(){

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

        $this->pdf->stream($file_name, array("Attachment"=> 1));

    }

    public function order_status_form($order_id,$product_id=0) 
    {  
        if($product_id==0){
            $data['status_titles'] = $this->Order_model->get_titles(true);
        }
        else{
            $data['status_titles'] = $this->Order_model->get_cancel_titles();
        }
        $data['product_id'] = $product_id;
        $data['order_data'] = $this->Order_model->get_product_status($order_id,$product_id);
        $data['delivery_date'] = $this->common_model->selectByidParam($order_id,'tbl_order_details','delivery_date');
        $this->load->view('admin/page/order_status_update', $data); // :blush:
    }

    public function update_product_status() 
    {

        $status=$this->input->post('order_status');

        $status_desc=trim($this->input->post('status_desc'));

        $products_arr=array();

        $where=array('order_id' => $this->input->post('order_id'));

        $row_trn=$this->common_model->selectByids($where, 'tbl_transaction')[0];

        $refund_amt=$pro_refund_amt=$product_per=$refund_per=$new_payable_amt=$total_refund_amt=$total_refund_per=0;

        if($this->input->post('product_id')==0){

            // for full order

            $data_arr = array(
                'order_id' => $this->input->post('order_id'),
                'user_id' => $this->input->post('user_id'),
                'product_id' => '0',
                'status_title' => $status,
                'status_desc' => $status_desc,
                'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
            );

            $data_usr = $this->security->xss_clean($data_arr);

            $this->common_model->insert($data_usr, 'tbl_order_status');

            $data_arr=$this->common_model->selectByids(array('order_id' => $this->input->post('order_id'), 'pro_order_status <>' => 5),'tbl_order_items');

            $row_ord=$this->common_model->selectByid($this->input->post('order_id'), 'tbl_order_details');
            $actual_pay_amt=($row_ord->payable_amt-$row_ord->delivery_charge);

            foreach ($data_arr as $key => $value) 
            {
                $data = array(
                    'order_id' => $value->order_id,
                    'user_id' => $value->user_id,
                    'product_id' => $value->product_id,
                    'status_title' => $status,
                    'status_desc' => $status_desc,
                    'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
                );

                $data = $this->security->xss_clean($data);

                $this->common_model->insert($data, 'tbl_order_status');

                $data_pro = array(
                    'pro_order_status' => $status
                ); 

                $data_pro = $this->security->xss_clean($data_pro);

                $this->common_model->updateByids($data_pro, array('order_id' => $this->input->post('order_id'), 'product_id' => $value->product_id, 'user_id' => $value->user_id),'tbl_order_items');

                $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $this->common_model->selectByidsParam(array('id' => $value->product_id),'tbl_product','featured_image'));

                $img_file=$this->_create_thumbnail('assets/images/products/',$thumb_img_nm,$this->common_model->selectByidsParam(array('id' => $value->product_id),'tbl_product','featured_image'),300,300);

                $p_items['product_url']=base_url('product/'.$this->common_model->selectByidsParam(array('id' => $value->product_id),'tbl_product','product_slug'));
                
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

                if($status=='4'){
                    $this->Product_model->updateTotalSale($value->product_id);
                }

                if($status==5){

                    if($row_trn->gateway!='COD' || $row_trn->gateway!='cod')
                    {

                        $where=array('order_id' => $this->input->post('order_id'),'product_id' => $value->product_id);

                        $row_pro=$this->common_model->selectByids($where, 'tbl_order_items');

                        foreach ($row_pro as $value_pro) 
                        {
                            $product_per=$new_payable_amt=0;

                            if($row_ord->coupon_id!=0)
                            {
                                $product_per=number_format((double)(($value_pro->total_price/$row_ord->total_amt)*100), 2, '.', '');  //44

                                $refund_per=number_format((double)(($product_per/100)*$row_ord->discount_amt), 2, '.', ''); //22

                                $refund_amt=number_format((double)($value_pro->total_price-$refund_per), 2, '.', '');
                            }
                            else{
                                $refund_amt=$value_pro->total_price;
                            }

                            $total_refund_amt+=$refund_amt;
                            $total_refund_per+=$refund_per;

                            $data_arr = array(
                                'bank_id' => '0',
                                'user_id' => $this->input->post('user_id'),
                                'order_id' => $this->input->post('order_id'),
                                'order_unique_id' => $row_ord->order_unique_id,
                                'product_id' => $value->product_id,
                                'product_title' => $value_pro->product_title,
                                'product_amt' => $value_pro->total_price,
                                'refund_pay_amt' => $refund_amt,
                                'refund_per' => $refund_per,
                                'gateway' => $row_trn->gateway,
                                'refund_reason' => $status_desc,
                                'last_updated' => strtotime(date('d-m-Y h:i:s A',now())),
                                'request_status' => '-1',
                                'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
                            );

                            $data_update = $this->security->xss_clean($data_arr);

                            $this->common_model->insert($data_update, 'tbl_refund');
                        }
                    }
                }
            }

            $data_ord = array(
                'order_status' => $status
            ); 

            $data_ord = $this->security->xss_clean($data_ord);
            $this->common_model->update($data_ord, $this->input->post('order_id'),'tbl_order_details');    

            if($status==5){

                $data_update = array(
                    'order_status' => '5',
                    'new_payable_amt'  =>  '0',
                    'refund_amt'  =>  $total_refund_amt,
                    'refund_per'  =>  $total_refund_per
                );

                $data = array(
                    'order_id' => $this->input->post('order_id'),
                    'user_id' => $this->input->post('user_id'),
                    'product_id' => '0',
                    'status_title' => '5',
                    'status_desc' => $status_desc,
                    'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
                );

                $data = $this->security->xss_clean($data);

                $this->common_model->insert($data, 'tbl_order_status');

                $this->common_model->update($data_update, $this->input->post('order_id'),'tbl_order_details');
            }
        }
        else{

            $data_arr1=$this->common_model->selectByids(array('order_id' => $this->input->post('order_id'), 'pro_order_status <>' => 5),'tbl_order_items');

            $total_items=count($data_arr1);

            if($status==5){

                if($row_trn->gateway!='COD' || $row_trn->gateway!='cod'){

                    $row_ord=$this->common_model->selectByid($this->input->post('order_id'), 'tbl_order_details');

                    $where=array('order_id' => $this->input->post('order_id'),'product_id' => $this->input->post('product_id'));

                    $actual_pay_amt=($row_ord->payable_amt-$row_ord->delivery_charge);

                    $product_per=$refund_amt=$new_payable_amt=0;

                    $row_pro=$this->common_model->selectByids($where, 'tbl_order_items');

                    foreach ($row_pro as $value)
                    {
                        if($row_ord->coupon_id!=0)
                        {
                            $product_per=number_format((double)(($value->total_price/$row_ord->total_amt)*100), 2, '.', '');  //44

                            $refund_per=number_format((double)(($product_per/100)*$row_ord->discount_amt), 2, '.', ''); //22

                            $refund_amt=number_format((double)($value->total_price-$refund_per), 2, '.', '');

                            $new_payable_amt=number_format((double)($row_ord->payable_amt-$refund_amt), 2, '.', '');
                        }
                        else{
                            $refund_amt=$value->total_price;
                            $new_payable_amt=($row_ord->payable_amt-$refund_amt);
                        }

                        $data_arr = array(
                            'bank_id' => '0',
                            'user_id' => $this->input->post('user_id'),
                            'order_id' => $this->input->post('order_id'),
                            'order_unique_id' => $row_ord->order_unique_id,
                            'product_id' => $this->input->post('product_id'),
                            'product_title' => $value->product_title,
                            'product_amt' => $value->total_price,
                            'refund_pay_amt' => $refund_amt,
                            'refund_per' => $refund_per,
                            'gateway' => $row_trn->gateway,
                            'refund_reason' => $status_desc,
                            'last_updated' => strtotime(date('d-m-Y h:i:s A',now())),
                            'request_status' => '-1',
                            'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
                        );

                        $data_update = $this->security->xss_clean($data_arr);
                        $this->common_model->insert($data_update, 'tbl_refund');

                        $pro_refund_amt=$refund_amt;

                        $refund_amt=$row_ord->refund_amt+$refund_amt;
                        $new_payable_amt=($row_ord->payable_amt-$refund_amt);
                        $refund_per=$row_ord->refund_per+$refund_per;

                        $data_update = array(
                            'new_payable_amt'  =>  $new_payable_amt,
                            'refund_amt'  =>  $refund_amt,
                            'refund_per'  =>  $refund_per
                        );

                        $this->common_model->update($data_update, $this->input->post('order_id'),'tbl_order_details');

                        $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $this->common_model->selectByidsParam(array('id' => $value->product_id),'tbl_product','featured_image'));

                        $img_file=$this->_create_thumbnail('assets/images/products/',$thumb_img_nm,$this->common_model->selectByidsParam(array('id' => $value->product_id),'tbl_product','featured_image'),300,300);

                        $p_items['product_url']=base_url('product/'.$this->common_model->selectByidsParam(array('id' => $value->product_id),'tbl_product','product_slug'));
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
            }

            $data = array(
                'order_id' => $this->input->post('order_id'),
                'user_id' => $this->input->post('user_id'),
                'product_id' => $this->input->post('product_id'),
                'status_title' => $status,
                'status_desc' => $status_desc,
                'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
            );

            $data = $this->security->xss_clean($data);

            $this->common_model->insert($data, 'tbl_order_status');

            $data_pro = array(
                'pro_order_status' => $status
            ); 

            $data_pro = $this->security->xss_clean($data_pro);

            $this->common_model->updateByids($data_pro, array('order_id' => $this->input->post('order_id'), 'product_id' => $this->input->post('product_id'), 'user_id' => $this->input->post('user_id')),'tbl_order_items');

            if($status=='4'){
                $this->Product_model->updateTotalSale($value->product_id);
            }

            if($total_items==1){

                $data = array(
                    'order_id' => $this->input->post('order_id'),
                    'user_id' => $this->input->post('user_id'),
                    'product_id' => '0',
                    'status_title' => $status,
                    'status_desc' => $status_desc,
                    'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
                );

                $data = $this->security->xss_clean($data);

                $this->common_model->insert($data, 'tbl_order_status');

                $data_ord = array(
                    'order_status' => $status
                );

                $data_ord = $this->security->xss_clean($data_ord);
                $this->common_model->update($data_ord, $this->input->post('order_id'),'tbl_order_details');
            }
            else{
                if($status!=5){

                }
            }
        }

        $data_ord=$this->common_model->selectByid($this->input->post('order_id'),'tbl_order_details');

        $data_email=array();

        $delivery_address=$data_ord->building_name.', '.$data_ord->road_area_colony.',<br/>'.$data_ord->pincode.'<br/>'.$data_ord->city.', '.$data_ord->state.', '.$data_ord->country;

        $data_email['users_name']=$data_ord->name;

        $admin_name=$this->common_model->selectByidsParam(array('id' => 1),'tbl_admin','username');

        $row_tran = $this->common_model->selectByids(array('order_unique_id ' => $data_ord->order_unique_id), 'tbl_transaction')[0];

        $data_email['payment_mode'] = strtoupper($row_tran->gateway);
        $data_email['payment_id'] = $row_tran->payment_id;

        $data_email['order_unique_id']=$data_ord->order_unique_id;
        $data_email['order_date']=date('d M, Y',$data_ord->order_date);

        $data_email['delivery_date']=date('d M, Y',$data_ord->delivery_date);

        $where = array('order_id ' => $this->input->post('order_id'));

        $row_refund = $this->common_model->selectByids($where, 'tbl_refund');

        if(!empty($row_refund))
        {
            $cancel_ord_amt=array_sum(array_column($row_refund,'refund_pay_amt'));

            $cancel_order_amt = strval($cancel_ord_amt);
        }
        else{
            $cancel_order_amt = '';
        }

        $data_email['delivery_address']=$delivery_address;
        $data_email['discount_amt']=$data_ord->discount_amt;
        $data_email['total_amt']=$data_ord->total_amt;
        $data_email['cancel_order_amt']=$cancel_order_amt;
        $data_email['delivery_charge']=$data_ord->delivery_charge;
        $data_email['payable_amt']=$data_ord->new_payable_amt;

        $data_email['status_desc']=$status_desc;
        $data_email['order_status']=$status;
        $data_email['status_title']=$this->get_status_title($status);

        $data_email['refund_amt']=($total_refund_amt==0) ? number_format($pro_refund_amt, 2) : number_format($total_refund_amt, 2);

        $data_email['products']=$products_arr;
            
        //  send email

        if($status==5)
        {
            $subject = $this->app_name.' - '.$this->lang->line('ord_status_update_lbl');
            $body = $this->load->view('emails/admin_order_cancel.php',$data_email,TRUE);
        }
        else{
            $subject = $this->app_name.' - '.$this->lang->line('ord_status_update_lbl');
            $body = $this->load->view('emails/order_status.php',$data_email,TRUE);
        }

        send_email($data_ord->email, $data_ord->name, $subject, $body);

        echo "true";
    }

    // update order delivery date
    public function update_delivery_date() 
    {
        $delivery_date=$this->input->post('delivery_date');
        $order_id=$this->input->post('order_id');

        $data = array(
            'delivery_date'  =>  strtotime($delivery_date)
        );

        $data = $this->security->xss_clean($data);
        $this->common_model->update($data, $order_id,'tbl_order_details');
        echo 'success';

    }
    
    //-- delete order
    public function delete($id)
    {
        echo $this->Order_model->delete($id);
    }

    //-- delete order
    public function delete_transaction($id)
    {
        echo $this->Order_model->delete_transaction($id);
    }

    //-- delete order
    public function delete_ord_status()
    {
        if(!empty($this->input->post())){
            echo $this->Order_model->delete_ord_status($this->input->post('order_id'),$this->input->post('status_id'));    
        }
        else{
            echo 'Invalid Request';
        }
    }

    function convertpdf()
    {

        $this->load->helper('pdf_helper');
        $this->load->view('admin/page/pdfreport', $data);
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
                    $config['quality'] = '60%';
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

    public function order_notify()
    {
        $row=$this->api_model->get_unseen_orders(3);

        $html='';

        foreach ($row as $key => $value) {

            $old_title='New order is placed by '.$value->user_name;

            if(strlen($old_title) > 30){
              $title=substr(stripslashes($old_title), 0, 30).'...';  
            }else{
              $title=$old_title;
            }

            $html.='<li><a title="'.$old_title.'" href="'.site_url("admin/orders/".$value->order_unique_id).'"><div class="message"><div class="content"><div class="title">'.$title.'</div><div class="description"><span>ORDER ID:</span> '.$value->order_unique_id.'</div><div class="description"><span>Date:</span> '.date('d M, Y', $value->order_date).'</div></div></div></a></li>';
        }

        $response=array('count' => count($row), 'content' => $html);

        echo base64_encode(json_encode($response));
    }
}