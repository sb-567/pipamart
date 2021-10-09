<?php 
  define('APP_NAME', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_name);
  define('APP_FAVICON', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->web_favicon);
  define('APP_LOGO', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_logo);
  define('PROFILE_IMG', $this->db->get_where('tbl_admin', array('id' => '1'))->row()->image);

?>
<!DOCTYPE html>
<html>
<head>
  <meta name="author" content="">
  <meta name="description" content="">
  <meta http-equiv="Content-Type"content="text/html;charset=UTF-8"/>
  <meta name="viewport"content="width=device-width, initial-scale=1.0">
  <title><?php if(isset($page_title)){ echo $page_title.' | ';} ?><?php echo APP_NAME;?></title>
  <link rel="shortcut icon" type="image/png" href="<?=base_url('assets/images/').APP_FAVICON?>"/>
  <link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/vendor.css')?>">
  <link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/flat-admin.css')?>">

  <link rel="stylesheet" type="text/css" href="<?=base_url('assets/sweetalert/sweetalert.css')?>">

  <script src="<?=base_url('assets/ckeditor/ckeditor.js')?>"></script>

  <script type="text/javascript" src="<?=base_url('assets/sweetalert/sweetalert.min.js')?>"></script>

  <script type="text/javascript" src="<?=base_url('assets/js/vendor.js')?>"></script>

  <script src="<?=base_url('assets/js/notify.min.js')?>"></script>

  
  <style type="text/css">

    .required_fields{
      color: red;
    }
    .btn_edit, .btn_delete, .btn_cust{
      padding: 5px 10px !important;
    }
    .sweet-alert h2{
      font-size: 20px !important;
    }
    .sweet-alert .btn{
      font-size: 14px;
      min-width: 70px !important;
      padding: 8px 12px !important;
      border: 0 !important;
      height: auto !important;
      margin: 0px 3px !important;
      box-shadow: none !important;
    }
    .sweet-alert .sa-icon {
      margin: 0 auto 15px auto !important;
    }
    .select2{
      height: auto !important;
      min-height: 48px !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__rendered{
      padding: 4px 5px !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
      padding: 3px 3px !important;
    }
    .hint_lbl{
      color: red !important;
      margin-bottom: 2px;
    }

    .btn_back{
      font-size: 20px;color: #e91e63
    }
    
    a[disabled="disabled"] {
      pointer-events: none;
    }

    .notifyjs-corner{
      left: 50% !important;
      transform: translateX(-50%) !important;
    }

    .notifyjs-bootstrap-base{
      background-position: 3px 8px !important;
      border-radius: 0px;
      box-shadow: 0px 1px 14px 0px #0006;
    }

    .social_img{
      width: 20px !important;
      height: 20px !important;
      position: absolute;
      top: -11px;
      z-index: 1;
      left: 40px;
      margin:5px;
    }

    @media (min-width:200px) and (max-width:991px){
      .dataTables_wrapper .top {
        position: relative;
        padding: 10px 0px;
      }
    }
  </style>

  <script type="text/javascript">
    var Settings = {
      search_lbl: '<?=$this->lang->line('search_lbl')?>',
    }
  </script>

</head>
<body>

  <div class="loader"></div>
  <div class="app app-default">

    <?php $this->load->view('admin/layout/sidebar'); ?>

    <div class="app-container">
      <nav class="navbar navbar-default" id="navbar">
        <div class="container-fluid">
          <div class="navbar-collapse collapse in">
            <ul class="nav navbar-nav navbar-mobile">
              <li>
                <button type="button" class="sidebar-toggle"> <i class="fa fa-bars"></i> </button>
              </li>
              <li class="logo"> <a class="navbar-brand" href="#"><?php echo APP_NAME;?></a> </li>
              <li>
                <button type="button" class="navbar-toggle">
                  <?php if(PROFILE_IMG){?>               
                    <img class="profile-img" src="<?=base_url('assets/images/').PROFILE_IMG?>">
                  <?php }else{?>
                    <img class="profile-img" src="<?=base_url('assets/images/profile.png')?>">
                  <?php }?>
                  
                </button>
              </li>
            </ul>
            <ul class="nav navbar-nav navbar-left">
              <li class="navbar-title"><?php echo APP_NAME;?></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
              <a href="<?=base_url('/')?>" target="_blank" style="font-size:14px;color:#FFF;border:1px solid rgba(255, 255, 255, 0.7);padding: 8px 12px;border-radius:2px;margin-right:20px;"><i class="fa fa-desktop" style="padding-right:6px;"></i> <?=$this->lang->line('visit_web_lbl')?></a>

              <li class="dropdown notification">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <div class="icon"><i class="fa fa-shopping-basket" aria-hidden="true"></i></div>
                  <div class="title"><?=$this->lang->line('new_ord_lbl')?></div>
                  <div class="count notify_count">0</div>
                </a>
                <div class="dropdown-menu">
                  <ul class="ordering_ul">
                    <li class="dropdown-header ordering_heading"><?=$this->lang->line('ordering_lbl')?></li>
                    <li class="dropdown-empty"><?=$this->lang->line('no_new_ord_lbl')?></li>
                  </ul>
                </div>
              </li>

              <li class="dropdown profile"> <a href="profile.php" class="dropdown-toggle" data-toggle="dropdown"> <?php if(PROFILE_IMG){?>               
                <img class="profile-img" src="<?=base_url('assets/images/').PROFILE_IMG?>">
              <?php }else{?>
                <img class="profile-img" src="<?=base_url('assets/images/profile.png')?>">
              <?php }?>
              <div class="title"><?=$this->lang->line('profile_lbl')?></div>
            </a>
            <div class="dropdown-menu">
              <div class="profile-info">
                <h4 class="username"><?=$this->lang->line('admin_lbl')?></h4>
              </div>
              <ul class="action">
                <li><a href="<?=site_url('admin/profile')?>"><?=$this->lang->line('profile_lbl')?></a></li>                  
                <li><a href="<?=site_url('admin/backup')?>" class="btn_backup btn_top_action"><?=$this->lang->line('backup_db_lbl')?></a></li>
                <li><a href="<?=site_url('admin/logout')?>" class="btn_logout btn_top_action">Logout</a></li>
              </ul>
            </div>
          </li>
        </ul>
        
      </div>
    </div>
  </nav>
