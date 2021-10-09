<?php 
	if (!defined('BASEPATH')) exit('No direct script access allowed');

	// Include the facebook library
	require_once APPPATH . "libraries/Facebook/autoload.php";


	class Facebook extends CI_Controller{

		private $fb;
	    private $redirectUrl;
	    private $permissions;
	    private $helper;

	    private $app_setting;


		function __construct() {
	        parent::__construct();

        	$this->load->model('Common_model','common_model');
        	$this->load->model('Api_model','api_model');
        	$this->load->model('Users_model');

        	$this->load->helper("date");

        	$this->app_setting = $this->api_model->app_details();

        	$this->app_name=$this->app_setting->app_name;

	        $this->fb = new Facebook\Facebook([
	            'app_id' => $this->app_setting->facebook_app_id, // Replace {app-id} with your app id
	            'app_secret' => $this->app_setting->facebook_app_secret, 
                'default_graph_version' => 'v3.2'
	        ]);

	        $this->redirectUrl = site_url('facebookCallback/');

			$this->permissions = ['email']; // Optional permissions
	        
	        $this->helper = $this->fb->getRedirectLoginHelper();

	    }

	    public function redirect_url(){

			redirect($this->helper->getLoginUrl($this->redirectUrl, $this->permissions));

		}

		public function callback() {

	        if (isset($_REQUEST['code'])) {
	            //$gClient->authenticate();
	            $this->session->set_userdata('token', $this->helper->getAccessToken());
	            redirect($this->redirectUrl);
	        }
	      
	        try {
	            //$accessToken = $this->helper->getAccessToken();
	            $accessToken = $this->session->userdata('token');
	            $response = $this->fb->get('/me?fields=id,name,email', $accessToken);
	            $pic= $this->fb->get('/me/picture?type=large', $accessToken);
	        } catch (Facebook\Exceptions\FacebookResponseException $e) {
	            // When Graph returns an error
	            echo 'Graph returned an error: ' . $e->getMessage();
	            exit;
	        } catch (Facebook\Exceptions\FacebookSDKException $e) {
	            // When validation fails or other local issues
	            echo 'Facebook SDK returned an error: ' . $e->getMessage();
	            exit;
	        }

	        if (!isset($accessToken)) {
	            if ($this->helper->getError()) {
	                header('HTTP/1.0 401 Unauthorized');
	                echo "Error: " . $this->helper->getError() . "\n";
	                echo "Error Code: " . $this->helper->getErrorCode() . "\n";
	                echo "Error Reason: " . $this->helper->getErrorReason() . "\n";
	                echo "Error Description: " . $this->helper->getErrorDescription() . "\n";
	            } else {
	                header('HTTP/1.0 400 Bad Request');
	                echo 'Bad request';
	            }
	            exit;
	        }

	        // The OAuth 2.0 client handler helps us manage access tokens
	        $oAuth2Client = $this->fb->getOAuth2Client();

	        // Get the access token metadata from /debug_token
	        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
	        //echo '<h3>Metadata</h3>';
	        //var_dump($tokenMetadata);

	        // Validation (these will throw FacebookSDKException's when they fail)
	        $tokenMetadata->validateAppId($this->app_setting->facebook_app_id); // Replace {app-id} with your app id
	        // If you know the user ID this access token belongs to, you can validate it here
	        //$tokenMetadata->validateUserId('123');
	        $tokenMetadata->validateExpiration();

	        if (!$accessToken->isLongLived()) {
	            // Exchanges a short-lived access token for a long-lived one
	            try {
	                $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
	            } catch (Facebook\Exceptions\FacebookSDKException $e) {
	                echo "<p>Error getting long-lived access token: " . $this->helper->getMessage() . "</p>\n\n";
	                exit;
	            }

	            echo '<h3>Long-lived</h3>';
	            var_dump($accessToken->getValue());
	        }

	        if ($response) {
	            $userProfile=$response->getDecodedBody();

	            $auth_id=$userProfile['id'];
	            $email=$userProfile['email'];

	            $name=$userProfile['name'];

	           	// check email exist
                $row_user = $this->common_model->check_email($email, 'Facebook', $auth_id);

                if(empty($row_user)){

                	$url='http://graph.facebook.com/'.$auth_id.'/picture';

					if($url!=''){
						$user_name=str_replace(" ","-",$name);

						$image_file = date('dmYhis').'_'.rand(0,99999)."_".$user_name.'.jpg';

						// Image path
						$img = 'assets/images/users/'.$image_file;

						// Save image 
						file_put_contents($img, file_get_contents($url));
					}
					else{
						$image_file='';
					}

                	$data_arr = array(
                        'user_type' => 'Facebook',
                        'user_name' => $name,
                        'user_email' => $email,
                        'user_image' => $image_file,
                        'auth_id' => $auth_id,
                        'created_at' => strtotime(date('d-m-Y h:i:s A',now()))
                    );

                    $data_usr = $this->security->xss_clean($data_arr);

                    $user_id = $this->common_model->insert($data_usr, 'tbl_users');

                    if($email!=''){
                    	$data_register_mail = array(
                            'register_type' => 'Facebook',
                            'user_name' => $name
                        );

                        $subject = $this->app_name.' - '.$this->lang->line('register_mail_lbl');

                        $body = $this->load->view('emails/welcome_mail.php',$data_register_mail,TRUE);

                        send_email($email, $this->input->post('user_name'), $subject, $body);
                    }

                    $data_session = array(
                    	'user_id' => $user_id,
                    	'user_type' => 'Facebook',
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

	        }
	    }
	}
?>