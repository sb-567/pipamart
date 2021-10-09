<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Install extends CI_Controller
{
	function __construct()
	{
		error_reporting(0);
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('file');
	}

	function index()
	{
		$this->load->view('install/index');
	}

	/*****INSTALL THE SCRIPT HERE *****/

	function do_install()
	{
		$envato_buyer = verify_envato_purchase_code($this->input->post('envato_purchase_code'));

		$err_arr=array();

		if($envato_buyer->error!='404')
		{

			if(($this->input->post('envato_buyer_name')=='' OR $envato_buyer->buyer!=trim($this->input->post('envato_buyer_name'))))
	        {
	        	array_push($err_arr, 'Invalid buyer name !!!');
				$this->session->set_flashdata('installation_failed', array('status' => 0, 'msg' => $err_arr, 'old_param' => $this->input->post()));
				redirect(base_url('install'));
	        }	
		}
		else{
			array_push($err_arr, 'Invalid purchase code !!!');
			$this->session->set_flashdata('installation_failed', array('status' => 0, 'msg' => $err_arr, 'old_param' => $this->input->post()));
			redirect(base_url('install'));
		}

		if($this->input->post('db_name')!='' && $this->input->post('db_name')!='' && $this->input->post('db_hname')!=''){

			$db_verify=$this->check_db_connection();

			if($db_verify == true)
			{
				
				// Replace the database settings//////////

				$data = read_file('./application/config/database.php');

				$data = str_replace('db_name', trim($this->input->post('db_name')), $data);

				$data = str_replace('db_uname', trim($this->input->post('db_uname')), $data);

				$data = str_replace('db_password', trim($this->input->post('db_password')), $data);

				$data = str_replace('db_hname', trim($this->input->post('db_hname')), $data);

				write_file('./application/config/database.php', $data);

				$old_file='application/config/routes_replace.php';
				$new_file='application/config/routes.php';

				if(!rename($old_file,$new_file)){
				    exit;
				}

				$old_file='application/config/autoload_replace.php';
				$new_file='application/config/autoload.php';

				if(!rename($old_file,$new_file)){
				    exit;
				}


				$this->load->database();

				$lines = file('./database/db.sql');
		        $statement = '';
		        foreach ($lines as $line)
		        {
		            $statement .= $line;
		            if (substr(trim($line), -1) === ';')
		            {
		                $this->db->simple_query($statement);
		                $statement = '';
		            }
		        }

				$data_arr=array(
								'web_envato_buyer_name' => trim($this->input->post('envato_buyer_name')),
								'web_envato_purchase_code' => trim($this->input->post('envato_purchase_code')),
								'web_envato_buyer_email' => trim($this->input->post('envato_buyer_email')),
								'web_url' => trim($this->input->post('web_url')),
								'web_envato_purchased_status' => '1'
							);

				$this->db->trans_start();

			    // $where contains the array for where clause
			    // $data contains the array of user's data which includes the updated value

				$this->db->where(array('id' => 1));
				$this->db->update('tbl_verify', $data_arr);

				$this->db->trans_complete();

				$admin_url=base_url().'admin';

				verify_data_on_server($envato_buyer->item->id,$envato_buyer->buyer,$this->input->post('envato_purchase_code'),1,$admin_url,'',$this->input->post('envato_buyer_email'));
				
				redirect(base_url('admin'),'refresh');
	
			} else {

				array_push($err_arr, 'Error in connecting to database !!!');
				$this->session->set_flashdata('installation_failed', array('status' => 0, 'msg' => $err_arr, 'old_param' => $this->input->post()));
				redirect(base_url('install'));
			}
		}
		else{
			array_push($err_arr, 'Enter all database fields !!!');
			$this->session->set_flashdata('installation_failed', array('status' => 0, 'msg' => $err_arr, 'old_param' => $this->input->post()));
			redirect(base_url('install'));
		}

		

	}
	// -------------------------------------------------------------------------------------------------

	

	/* 

	 * Database validation check from user input settings

	 */

	function check_db_connection()
	{
       	$link = mysqli_connect($this->input->post('db_hname'), $this->input->post('db_uname'), $this->input->post('db_password'),$this->input->post('db_name'));

		if (!$link) {
			mysqli_close($link);
			return false;
		}
		mysqli_close($link);
		return true;
	}

}

