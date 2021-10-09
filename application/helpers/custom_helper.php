<?php 

	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	//-- check logged user
	if (!function_exists('check_login_user')) {
		function check_login_user() {
			$ci = get_instance();
			if ($ci->session->userdata('is_login') != TRUE) {

				$array_items = array('id', 'username', 'email', 'is_login');

				$ci->session->unset_userdata($array_items);

				redirect(base_url('admin/login'));
			}
		}
	}

	if (!function_exists('check_user_login')) {
		function check_user_login() {
			$ci = get_instance();

			if ($ci->session->userdata('is_user_login') != TRUE) 
			{
				$array_items = array('user_id', 'user_name', 'user_email', 'is_user_login','token');
				$ci->session->unset_userdata($array_items);
				return false;
			}
			else{

				$ci->db->select('*');
				$ci->db->from('tbl_users');
				$ci->db->where('id', $ci->session->userdata('user_id')); 
				$row=$ci->db->get()->result();

				if(!empty($row)){

					$row=$row[0];

					if($row->status=='0')
					{
						$array_items = array('user_id', 'user_name', 'user_email', 'is_user_login');

						$ci->session->unset_userdata($array_items);

						return false;   	
					}
				}
				else{
					$array_items = array('user_id', 'user_name', 'user_email', 'is_user_login');

					$ci->session->unset_userdata($array_items);

					return false;
				}



				return true;
			}
		}
	}


	//Dynamically add Javascript files to header page
	if(!function_exists('add_js')){
		function add_js($file='')
		{
			$str = '';
			$ci = &get_instance();
			$header_js  = $ci->config->item('header_js');

			if(empty($file)){
				return;
			}

			if(is_array($file)){
				if(!is_array($file) && count($file) <= 0){
					return;
				}
				foreach($file AS $item){
					$header_js[] = $item;
				}
				$ci->config->set_item('header_js',$header_js);
			}else{
				$str = $file;
				$header_js[] = $str;
				$ci->config->set_item('header_js',$header_js);
			}
		}
	}


	if(!function_exists('add_footer_js')){
		function add_footer_js($file='')
		{
			$str = '';
			$ci = &get_instance();
			$footer_js  = $ci->config->item('footer_js');

			if(empty($file)){
				return;
			}

			if(is_array($file)){
				if(!is_array($file) && count($file) <= 0){
					return;
				}
				foreach($file AS $item){
					$footer_js[] = $item;
				}
				$ci->config->set_item('footer_js',$footer_js);
			}else{
				$str = $file;
				$footer_js[] = $str;
				$ci->config->set_item('footer_js',$header_js);
			}
		}
	}


	//Dynamically add CSS files to header page
	if(!function_exists('add_css')){
		function add_css($file='')
		{
			$str = '';
			$ci = &get_instance();
			$header_css = $ci->config->item('header_css');

			if(empty($file)){
				return;
			}

			if(is_array($file)){
				if(!is_array($file) && count($file) <= 0){
					return;
				}
				foreach($file AS $item){   
					$header_css[] = $item;
				}
				$ci->config->set_item('header_css',$header_css);
			}else{
				$str = $file;
				$header_css[] = $str;
				$ci->config->set_item('header_css',$header_css);
			}
		}
	}

	if(!function_exists('put_headers')){
		function put_headers()
		{
			$str = '';
			$ci = &get_instance();
			$header_css = $ci->config->item('header_css');

			$header_js  = $ci->config->item('header_js');

			if(!empty($header_css)){
				foreach($header_css AS $item){
					$str .= '<link rel="stylesheet" href="'.base_url().$item.'" type="text/css" />'."\n";
				}
			}

			if(!empty($header_js)){
				foreach($header_js AS $item){
					$str .= '<script type="text/javascript" src="'.base_url().$item.'"></script>'."\n";
				}
			}

			return $str;
		}
	}

	if(!function_exists('put_footers')){
		function put_footers()
		{
			$str = '';
			$ci = &get_instance();
			$footer_js  = $ci->config->item('footer_js');

			if(!empty($footer_js)){
				foreach($footer_js AS $item){
					$str .= '<script type="text/javascript" src="'.base_url().$item.'"></script>'."\n";
				}
			}

			return $str;
		}
	}


	if(!function_exists('add_cdn_css')){
		function add_cdn_css($file='')
		{
			$str = '';
			$ci = &get_instance();
			$header_cdn_css = $ci->config->item('header_cdn_css');

			if(empty($file)){
				return;
			}

			if(is_array($file)){
				if(!is_array($file) && count($file) <= 0){
					return;
				}
				foreach($file AS $item){   
					$header_cdn_css[] = $item;
				}
				$ci->config->set_item('header_cdn_css',$header_cdn_css);
			}else{
				$str = $file;
				$header_cdn_css[] = $str;
				$ci->config->set_item('header_cdn_css',$header_cdn_css);
			}
		}
	}

	if(!function_exists('add_footer_cdn_js')){
		function add_footer_cdn_js($file='')
		{
			$str = '';
			$ci = &get_instance();
			$footer_cdn_js  = $ci->config->item('footer_cdn_js');

			if(empty($file)){
				return;
			}

			if(is_array($file)){
				if(!is_array($file) && count($file) <= 0){
					return;
				}
				foreach($file AS $item){
					$footer_cdn_js[] = $item;
				}
				$ci->config->set_item('footer_cdn_js',$footer_cdn_js);
			}else{
				$str = $file;
				$footer_cdn_js[] = $str;
				$ci->config->set_item('footer_cdn_js',$header_js);
			}
		}
	}

	if(!function_exists('put_cdn_headers')){
		function put_cdn_headers()
		{
			$str = '';
			$ci = &get_instance();
			$header_cdn_css = $ci->config->item('header_cdn_css');

			if(!empty($header_cdn_css)){
				foreach($header_cdn_css AS $item){
					$str .= '<link rel="stylesheet" href="'.$item.'" type="text/css" />'."\n";
				}
			}

			return $str;
		}
	}

	if(!function_exists('put_cdn_footers')){
		function put_cdn_footers()
		{
			$str = '';
			$ci = &get_instance();
			$footer_cdn_js  = $ci->config->item('footer_cdn_js');

			if(!empty($footer_cdn_js)){
				foreach($footer_cdn_js AS $item){
					$str .= '<script type="text/javascript" src="'.$item.'"></script>'."\n";
				}
			}

			return $str;
		}
	}

	if (!function_exists('send_email')) {

		function send_email($recipient_email, $recipient_name, $subject, $body, $reply_to=false) {

			$ci =& get_instance();

			$ci->db->select('*');
			$ci->db->from('tbl_smtp_settings');
			$ci->db->where('id', '1'); 
			$row=$ci->db->get()->result()[0];

			$ci->db->select('tbl_settings.*');
			$ci->db->from('tbl_settings');
			$ci->db->where('tbl_settings.id', '1'); 
			$row_settings=$ci->db->get()->result()[0];

			if($row->smtp_library=='ci'){
				// load ci email library

				$ci->load->library('email');
				$config['useragent'] = "CodeIgniter";
				$config['protocol']='smtp';

				$fromEmail='';

				if($row->smtp_library=='gmail'){

					$fromEmail=$row->smtp_gemail;

					$config['smtp_host']=$row->smtp_ghost;
					$config['smtp_user']=$row->smtp_gemail;
					$config['smtp_pass']=$row->smtp_gpassword;
					$config['smtp_crypto'] = $row->smtp_gsecure;
					$config['smtp_port']=$row->gport_no;
				}
				else{
					$fromEmail=$row->smtp_email;

					$config['smtp_host']=$row->smtp_host;
					$config['smtp_user']=$row->smtp_email;
					$config['smtp_pass']=$row->smtp_password;
					$config['smtp_crypto'] = $row->smtp_secure;
					$config['smtp_port']=$row->port_no;
				}
				
				$config['smtp_timeout']='100';
				$config['mailtype']     = "html";
				$config['charset']      = "utf-8";
				$config['wordwrap'] = TRUE;
				$config['send_multipart'] = FALSE;

				$ci->email->initialize($config);
				$ci->email->set_newline("\r\n");

				$ci->email->clear(TRUE);  
				$ci->email->from($fromEmail, $row_settings->app_name);

				if($reply_to){
					$ci->email->reply_to($fromEmail, $row_settings->app_name);
				}

	            $ci->email->to($recipient_email, $recipient_name); // replace it with receiver mail id

	            $ci->email->subject($subject); // replace it with relevant subject

	            $ci->email->message($body);

        		if($ci->email->send()){
        			return true;
        		}
        		else{
        			return false;
        		}
			}
			else{
				// load php mailer library
				$ci->load->library("phpmailer_library");
				$mail = $ci->phpmailer_library->load();

				// SMTP configuration
		        $mail->isSMTP();

		        $mail->SMTPDebug  = 0;

		        $fromEmail='';

		        if($row->smtp_library=='gmail'){

		        	$fromEmail=$row->smtp_gemail;

		        	$mail->Host     = $row->smtp_ghost;
			        $mail->SMTPAuth = true;
			        $mail->Username = $row->smtp_gemail;
			        $mail->Password = $row->smtp_gpassword;
			        $mail->SMTPSecure = $row->smtp_gsecure;
			        $mail->Port     = $row->gport_no;
		        }
				else{

					$fromEmail=$row->smtp_email;

					$mail->Host     = $row->smtp_host;
			        $mail->SMTPAuth = true;
			        $mail->Username = $row->smtp_email;
			        $mail->Password = $row->smtp_password;
			        $mail->SMTPSecure = $row->smtp_secure;
			        $mail->Port     = $row->port_no;
				}

		        $mail->setFrom($fromEmail, $row_settings->app_name);
		        if($reply_to){
		        	$mail->addReplyTo($row_settings->app_email, $row_settings->app_name);
		        }

		        // Add a recipient
		        $mail->addAddress($recipient_email, $recipient_name);

		        // Email subject
		        $mail->Subject = $subject;

		        // Set email format to HTML
		        $mail->isHTML(true);

		        // Email body content
		        $mail->Body = $body;

		        // Send email
		        if(!$mail->send()){
		            return false;
		        }else{
		            return true;
		        }
			}
		}
	}

	// check sign salt for API
	if (!function_exists('checkSignSalt')) {
		function checkSignSalt($data) {

			$ci = get_instance();

			$ci->db->select('*');
			$ci->db->from('tbl_verify');
			$ci->db->where('tbl_verify.id', '1'); 
			$row=$ci->db->get()->result();

			$key="viaviweb";

			$data_json = $data;

			$data_arr = json_decode(base64_decode($data_json),true);

			if($row[0]->android_envato_buyer_name!='' && $row[0]->android_envato_purchase_code!='' && $row[0]->android_envato_purchased_status==1)
			{

				if(!empty($data_arr))
				{
					if($data_arr['package_name']==$row[0]->package_name){
						if($data_arr['sign'] == '' && $data_arr['salt'] == '' ){

							$set['status'] = -1;
							$set['message'] = "Sign salt is required!";

							header( 'Content-Type: application/json; charset=utf-8' );
							echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
							exit(); 
						}else{

							$data_arr['salt'];    

							$md5_salt=md5($key.$data_arr['salt']);

							if($data_arr['sign']!=$md5_salt){

								$set['status'] = -1;
								$set['message'] = "Invalid sign salt!";

								header( 'Content-Type: application/json; charset=utf-8' );
								echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
								exit(); 

							}

							if(isset($data_arr['user_id']) AND  $data_arr['user_id']!=0){

								$user_id=$data_arr['user_id'];

								$ci->db->select('*');
								$ci->db->from('tbl_users');
								$ci->db->where('id', $user_id); 
								$row_user=$ci->db->get()->result();

								if(!empty($row_user))
								{
									$row_user=$row_user[0];

									if($row_user->status=='0')
									{
										$set['status'] = 2;
										$set['message'] = "Your account is deactivated!";

										header( 'Content-Type: application/json; charset=utf-8' );
										echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
										exit();
									}

								}
								else{
									$set['status'] = 2;
									$set['message'] = "User ID not found!";

									header( 'Content-Type: application/json; charset=utf-8' );
									echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
									exit();
								}
							}
						}
					}
					else{

						$set['status'] = -1;
						$set['message'] = "Package name is invalid!";
						header( 'Content-Type: application/json; charset=utf-8' );
						echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
						exit();
					}
				}
				else{

					$set['status'] = -1;
					$set['message'] = "Sorry request is invalid!";
					header( 'Content-Type: application/json; charset=utf-8' );
					echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
					exit();
				}
			}
			else{
				$set['status'] = -1;
				$set['message'] = "Envato purchase code verification failed!";
				header( 'Content-Type: application/json; charset=utf-8' );
				echo $val= str_replace('\\/', '/', json_encode($set,JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
				exit();
			}

			return $data_arr;
		}
	}

	if (!function_exists('get_random_password'))
	{

		function get_random_password($chars_min=6, $chars_max=8, $use_upper_case=false, $include_numbers=false, $include_special_chars=false)
		{
			$length = rand($chars_min, $chars_max);
			$selection = 'aeuoyibcdfghjklmnpqrstvwxz';
			if($include_numbers) {
				$selection .= "1234567890";
			}
			if($include_special_chars) {
				$selection .= "!@\"#$%&[]{}?|";
			}

			$password = "";
			for($i=0; $i<$length; $i++) {
				$current_letter = $use_upper_case ? (rand(0,1) ? strtoupper($selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))]) : $selection[(rand() % strlen($selection))];            
				$password .=  $current_letter;
			}                

			return $password;
		}

	}

	// convert currency
	if (!function_exists('convert_currency')) {
		function convert_currency($to_currency, $from_currency, $amount) {
			$req_url = 'https://api.exchangerate-api.com/v4/latest/'.$to_currency;
			$response_json = file_get_contents($req_url);

			$price=number_format($amount,2);

			if(false !== $response_json) {

				try{
					$response_object = json_decode($response_json);
					return $price = number_format(round(($amount * $response_object->rates->$from_currency), 2),2);
				}
				catch(Exception $e) {
					print_r($e);
				}

			}
		}
	}

	// verify envato purchase code
	if (!function_exists('verify_envato_purchase_code')) {
	    function verify_envato_purchase_code($product_code) {

	        $url = "https://api.envato.com/v3/market/author/sale?code=".$product_code;
			$curl = curl_init($url);

			$personal_token = "M8tF6z8lzZBBkmZt4xm3dU4lw7Rlbrwp";
			$header = array();
			$header[] = 'Authorization: Bearer '.$personal_token;
			$header[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:41.0) Gecko/20100101 Firefox/41.0';
			$header[] = 'timeout: 20';
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_HTTPHEADER,$header);

			$envatoRes = curl_exec($curl);
			curl_close($curl);
			$envatoRes = json_decode($envatoRes);

			return $envatoRes;
	    }
	}

	// verify on our server
	if (!function_exists('verify_data_on_server')) {
	    function verify_data_on_server($product_id,$buyer_name,$purchase_code,$purchased_status,$admin_url,$package_name='',$envato_buyer_email='')
	    {

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"http://www.secureapp.viaviweb.in/verified_user.php");
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query(array('envato_product_id' => $product_id,'envato_buyer_name' => $buyer_name,'envato_purchase_code' => $purchase_code,'envato_purchased_status' => $purchased_status,'buyer_admin_url' => $admin_url,'package_name' => $package_name,'envato_buyer_email' => $envato_buyer_email)));

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			curl_close ($ch);
	    }
	}

