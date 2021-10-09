<?php 
    define('APP_NAME', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_name);
    define('APP_LOGO', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_logo);
    define('APP_FAVICON', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->web_favicon);
?>
<!DOCTYPE html>
<html>
<head>
<meta name="author" content="">
<meta name="description" content="">
<meta http-equiv="Content-Type"content="text/html;charset=UTF-8"/>
<meta name="viewport"content="width=device-width, initial-scale=1.0">
<title><?php echo APP_NAME;?> | Login</title>
<link rel="shortcut icon" type="image/png" href="<?=base_url('assets/images/').APP_FAVICON?>"/>
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/vendor.css')?>">
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/flat-admin.css')?>">

</head>
<body>
<div class="app app-default">
  <div class="app-container app-login">
    <div class="flex-center">
      <div class="app-body">
        <div class="app-block">
          <div class="app-form login-form">
            <div class="form-header">
              <div class="app-brand"><?php echo APP_NAME;?></div>
            </div>
			<div class="login_title_lineitem">
				<div class="line_1"></div>
				  <div class="flipInX-1 blind icon">
					 <span class="icon">
						 <i class="fa fa-gg"></i>&nbsp;
						 <i class="fa fa-gg"></i>&nbsp;
						 <i class="fa fa-gg"></i>
				   </span>
				   </div>
				<div class="line_2"></div>
			</div>
			<div class="clearfix"></div>
             <form action="<?php echo site_url('admin/login'); ?>" method="post">
				<div class="input-group" style="border:0px;">
					<!-- Error Goes Here -->
					<?php
					    if($this->session->flashdata('response_msg')) {
					      $message = $this->session->flashdata('response_msg');
					      ?>
					        <div class="alert <?=$message['class']?> alert-dismissible" role="alert"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <?=$message['message']?></div>
					      <?php
					    }
					  ?>
					  <?php print_r(validation_errors()) ?>
				</div>
				<div class="input-group"> <span class="input-group-addon" id="basic-addon1"> <i class="fa fa-user" aria-hidden="true"></i></span>
					<input type="text" name="username" id="username" class="form-control" placeholder="Username" aria-describedby="basic-addon1" value="<?php echo set_value('username'); ?>">
				</div>
				<div class="input-group"> <span class="input-group-addon" id="basic-addon2"> <i class="fa fa-key" aria-hidden="true"></i></span>
					<input type="password" name="password" id="password" class="form-control" placeholder="Password" aria-describedby="basic-addon2" value="<?php echo set_value('password'); ?>">
				</div>
				<div class="text-center">
					<input type="submit" class="btn btn-success btn-submit" value="<?=$this->lang->line('login_btn')?>">
				</div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>