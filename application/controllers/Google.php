<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	// Include the google api php libraries
	include_once APPPATH . "libraries/google-api-php-client/Google_Client.php";
    include_once APPPATH . "libraries/google-api-php-client/contrib/Google_Oauth2Service.php";

	class Google extends CI_Controller{

	    private $client;

	    private $google_oauthV2;

	    private $app_name;

		function __construct() {
	        parent::__construct();

        	$this->load->model('Common_model','common_model');
        	$this->load->model('Api_model','api_model');
        	$this->load->model('Users_model');

        	$this->load->helper("date");

        	$app_setting = $this->api_model->app_details();

	        $this->client = new Google_Client();

	        $this->app_name=$app_setting->app_name;

	        $this->client->setClientId($app_setting->google_client_id);
		    $this->client->setClientSecret($app_setting->google_secret_key);
		    $this->client->setRedirectUri(site_url('googleCallback'));

	        $this->google_oauthV2 = new Google_Oauth2Service($this->client);

	    }

	    public function redirect_url(){

			redirect($this->client->createAuthUrl());

		}

		public function callback() {

			try {

				if(isset($_REQUEST['code'])) {
		            $this->client->authenticate();
		            $this->session->set_userdata('token', $this->client->getAccessToken());
		            redirect(site_url('googleCallback'));
		        }

		        $token = $this->session->userdata('token');
		        if (!empty($token)) {
		            $this->client->setAccessToken($token);
		        }

		        if ($this->client->getAccessToken()) {
		            $userProfile = $this->google_oauthV2->userinfo->get();

		            $auth_id=$userProfile['id'];
		            $email=$userProfile['email'];

		            $name=$userProfile['name'];

		           	// check email exist
	                $row_user = $this->common_model->check_email($email, 'Google', $auth_id);

	                if(empty($row_user)){

	                	// Remote image URL
						$url = $userProfile['picture'];

						$image_file = date('dmYhis').'_'.rand(0,99999)."_".$userProfile['given_name'].'.jpg';

						// Image path
						$img = 'assets/images/users/'.$image_file;

						// Save image 
						file_put_contents($img, file_get_contents($url));

	                	$data_arr = array(
	                        'user_type' => 'Google',
	                        'user_name' => $name,
	                        'user_email' => $email,
	                        'user_image' => $image_file,
	                        'auth_id' => $auth_id,
	                        'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
	                    );

	                    $data_usr = $this->security->xss_clean($data_arr);

	                    $user_id = $this->common_model->insert($data_usr, 'tbl_users');

	                    $data_register_mail = array(
                            'register_type' => 'Google',
                            'user_name' => $name
                        );

                        $subject = $this->app_name.' - '.$this->lang->line('register_mail_lbl');

                        $body = $this->load->view('emails/welcome_mail.php',$data_register_mail,TRUE);

                        send_email($email, $this->input->post('user_name'), $subject, $body);

	                    $data_session = array(
		                    'user_id' => $user_id,
		                    'user_type' => 'Google',
		                    'user_name' => $name,
		                    'user_email' =>$email,
		                    'user_phone' =>'',
		                    'is_user_login' => TRUE
		                );

	                }
	                else{

	                	$updateData = array(
	                        'auth_id'  =>  $auth_id,
	                    );

	                    $this->common_model->update($updateData, $row_user[0]->id,'tbl_users');

	                    $data_session = array(
		                    'user_id' => $row_user[0]->id,
		                    'user_type' => $row_user[0]->user_type,
		                    'user_name' => $row_user[0]->user_name,
		                    'user_email' =>$row_user[0]->user_email,
		                    'user_phone' =>$row_user[0]->user_phone,
		                    'is_user_login' => TRUE
		                );
	                }

	                $this->session->set_userdata($data_session);

		            $message = array('message' => $this->lang->line('login_success'),'class' => 'success');
		            $this->session->set_flashdata('response_msg', $message);

		            redirect('/', 'refresh');


		        } else {
		            redirect($this->client->createAuthUrl());
		        }

				
			} catch (Exception $e) {
				die('Something went to wrong -> '.$e);
			}

	        
	    }
	}
?>