<?php 
    define('APP_NAME', $this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->site_name);
    define('APP_FAVICON', $this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->web_favicon);
    define('APP_LOGO', $this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->web_logo_2);
    define('APP_LOGO_2', $this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->web_logo_1);
    define('PROFILE_IMG', $this->db->get_where('tbl_admin', array('id' => '1'))->row()->image);

    if(isset($sharing_img) AND $sharing_img!=''){
      $sharing_img=$sharing_img;
      $sharing_wp_img=$sharing_img;
    }
    else{
      $sharing_img=base_url('assets/images/facebook_share_banner.png');
      $sharing_wp_img=base_url('assets/images/wp_share_banner.png');
    }

    $ci =& get_instance();

    if(empty($product)){
      $array_items = array('single_pre_url');
      $this->session->unset_userdata($array_items);
    }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="author" content="">
    <title> <?php if(isset($current_page)){ echo $current_page.' | ';} ?><?php echo APP_NAME;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="<?=base_url('assets/images/').APP_FAVICON?>"/>

    <meta name="description" content="<?=(empty($product) OR $product->seo_meta_description=='') ? $this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->site_description : $product->seo_meta_description ?>">

    <meta name="keywords" content="<?=(empty($product) OR $product->seo_keywords=='') ? $this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->site_keywords : $product->seo_keywords ?>">
    
    <meta property="og:type" content="article" />

    <meta property="og:title" content="<?php if(isset($current_page)){ echo $current_page.' | ';} ?><?php echo APP_NAME;?>" />

    <meta property="og:description" content="<?=(empty($product) OR $product->seo_meta_description=='') ? $this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->site_description : $product->seo_meta_description ?>" />

    <meta property="og:image" itemprop="image" content="<?=$sharing_wp_img?>" />
    <meta property="og:url" content="<?=current_url()?>" />
    <meta property="og:image:width" content="1024" />
    <meta property="og:image:height" content="1024" />
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image" content="<?=$sharing_img?>">
    <link rel="image_src" href="<?=$sharing_wp_img?>">

    <meta name="theme-color" content="#ff5252">

    <link rel="stylesheet" href="<?=base_url('assets/site_assets/css/ionicons.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/site_assets/css/font-awesome.min.css')?>">

    <?php 
      echo put_headers();
      echo put_cdn_headers();
    ?>

    <?php 
      if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->libraries_load_from=='local'){
    ?>
    <link rel="stylesheet" href="<?=base_url('assets/site_assets/css/animate.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/site_assets/css/normalize.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/site_assets/css/jquery-ui.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/site_assets/css/owl.carousel.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/site_assets/css/bootstrap.min.css')?>">

    <script src="<?=base_url('assets/site_assets/js/vendor/jquery-3.4.1.min.js')?>"></script>

    <?php }else if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->libraries_load_from=='cdn'){ ?>
      <!-- Include CDN Files -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/assets/owl.carousel.min.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- End CDN Files -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <?php 
      }
    ?>

    <link rel="stylesheet" href="<?=base_url('assets/site_assets/css/meanmenu.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/site_assets/css/default.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/site_assets/css/style.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/site_assets/css/cust_style.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/site_assets/css/responsive.css')?>">
    <!-- Sweetalert popup -->
    <link rel="stylesheet" type="text/css" href="<?=base_url('assets/sweetalert/sweetalert.css')?>">

    <script src="<?=base_url('assets/site_assets/js/notify.min.js')?>"></script>
	
	  <!-- Google Fonts -->
	  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <style type="text/css">
      .social_img{
        width: 20px !important;
        height: 20px !important;
        position: absolute;
        top: 5px;
        left: 25px;
        z-index: 1;
        margin: 5px;
      }
    </style>


    <?=html_entity_decode($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->header_code)?>

    <script type="text/javascript">
      var Settings = {
        base_url: '<?= base_url() ?>',
        currency_code: '<?= CURRENCY_CODE ?>',
        confirm_msg: '<?=$this->lang->line('are_you_sure_msg')?>',
        ord_cancel_confirm: '<?=$this->lang->line('ord_cancel_confirm_lbl')?>',
        product_cancel_confirm: '<?=$this->lang->line('product_cancel_confirm_lbl')?>',
        err_cart_item_buy: '<?=$this->lang->line('err_cart_item_buy_lbl')?>',
        err_shipping_address: '<?=$this->lang->line('no_shipping_address_err')?>',
        err_something_went_wrong: '<?=$this->lang->line('something_went_wrong_err')?>',
      }
    </script>

  </head>

<!-- <body oncontextmenu="return false"> -->
<body>
<div class="wrapper"> 
<!--   <div class="se-pre-con"></div>
  <div class="process_loader"></div> -->
  <section class="topheader">
  <diV class="headertop">
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-2 col-xs-4">
          <a class="logo" href="<?php echo site_url(); ?>"><img src="<?=base_url('assets/images/').APP_LOGO?>" class="img-responsive"></a>
        </div>
        
        <div class="col-md-5 col-xs-8">
            <div class="search-box-area">
                <form accept-charset="utf-8" action="<?=base_url('search-result')?>" id="search_form" method="get">
                 
                  <div class="search-box">
                    <input type="text" name="keyword" id="search" autocomplete="off" placeholder="<?=$this->lang->line('search_lbl')?>" value="<?=$this->input->get('keyword')!='' ? $this->input->get('keyword') : ''?>" required="">
                    <button type="submit"><i class="ion-ios-search-strong"></i></button>
                  </div>
                </form>
              </div>
        </div>

        <div class="col-md-5 col-xs-12">
          <div class="right">
            <ul>
          
            <li><a href="<?php echo site_url('contact-us'); ?>">Contact us</a></li>
            <li><a href="<?php echo site_url('patner_with_us'); ?>">Partner with us</a></li>
        
            <li><a href="<?php echo site_url('my-orders'); ?>">Track Order</a></li>
            <li><a href="<?php echo site_url('my-cart'); ?>">Cart</a></li>
            <?php 
                        if(!check_user_login()){
                      ?>
            <li><a href="<?php echo site_url('login-register'); ?>">LogIn</a></li>
            <?php }else{ ?>
            <li class="dropdown">
                <a href="<?php echo site_url('my-account'); ?>" class="dropdown-toggle" data-toggle="dropdown"><i class="ion-android-person"></i> <?=$this->lang->line('myaccount_lbl')?></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo site_url('my-account'); ?>" ><i class="ion-android-person"></i> <?=$this->lang->line('myaccount_lbl')?></a></li>
                    <li><a href="<?=site_url('site/logout')?>" class="btn_logout"><i class="ion-log-out"></i> <?=$this->lang->line('logout_lbl')?></a></li>
                </ul>
            </li>
            
            <?php } ?>
          
            
            
          </ul>
          </div>
           
        </div>
        </div>

    </div>
  </diV>
</section>
<section class="headermidde">
  <diV class="headertop">
    <div class="container-fluid">
        <div class="row">
          <div class="col-md-6 col-xs-6">
          <!--<ul>-->
          <!--  <li><a href="#!">India</a></li>-->
          <!--  <li><a href="#!">Maharahstra</a></li>-->
          <!--  <li><a href="#!">401203</a></li>-->
          <!--</ul>-->
        </div>

        <div class="col-md-6 col-xs-6">
          <div class="right">
            
          </div>
           
        </div>
        </div>

    </div>
  </diV>
</section>
<section>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="row">
          <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand mobiles" href="<?php echo site_url(); ?>"><img src="<?=base_url('assets/images/').APP_LOGO?>" class="img-responsive "></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          
          <ul class="nav navbar-nav ">
                <?php
                  $n=1;
                  foreach ($ci->get_category() as $key => $row) 
                  {
                    $counts=$ci->getCount('tbl_sub_category', array('category_id' => $row->id, 'status' => '1'));

                    if($counts > 0)
                    {
                      $url=base_url('category/'.$row->category_slug);  
                    }
                    else{
                      $url=base_url('category/products/'.$row->id);
                    }
                   ?>
                    <li class="dropdown has-megamenu">
                      <a href="<?php echo $url; ?>"   >
                        <?php 
                          if(strlen($row->category_name) > 25){
                            echo substr(stripslashes($row->category_name), 0, 25).'...';  
                          }else{
                            echo $row->category_name;
                          }
                        ?>
                      </a>
                    <?php if($counts > 0){ ?>
                      <div class="dropdown-toggle dicon"  data-toggle="dropdown"  role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-caret-down"></i></div>
                    <?php } ?>
                        <?php 
                          if($counts > 0)
                          { ?>
                            <div class="dropdown-menu megamenu" role="menu">
                              <div class="">
                                <ul>
                                <?php 
                                    $sub_category_list=$ci->get_sub_category($row->id);
                                    $i=1;
                                    foreach ($sub_category_list as $key1 => $row1) 
                                    {

                                      $submenucounts=$ci->getCount('tbl_submenu_headers', array('sub_category_id' => $row1->id));
                                  ?>
                                  <li class="dropdown has-megamenu1 ">
                                    <a href="<?=site_url('category/'.$row->category_slug.'/'.$row1->sub_category_slug)?>" >  <span>
                                      <?php 
                                    if(strlen($row1->sub_category_name) > 30){
                                      echo substr(stripslashes($row1->sub_category_name), 0, 30).'...';  
                                    }else{
                                      echo $row1->sub_category_name;
                                    }
                                  ?> 
                                    </span></a>
                                    
                                    <?php if($submenucounts > 0){ ?> 
                      <div class="dropdown-toggle dicon"  data-toggle="dropdown"  role="button" aria-haspopup="true" aria-expanded="false"></div>
                    <?php } ?>
                                    
                                    

                                    <?php 
                                    if($submenucounts > 0){


                                     ?>
                                      <div class="dropdown-menu megamenu1" role="menu">
                                        <div class="row">
                                          <?php
                                          $submenu_headers=$ci->get_submenu_headers($row1->id);
                                    // $i=1;
                                    foreach ($submenu_headers as $key2 => $row2) 
                                    {
                                          ?>
                                          <div class="col-md-2">
                                            <div class="col-megamenu">
                                              <h6 class="title"><?php echo $row2->submenu_header; ?></h6>
                                              <ul class="list-unstyled">
                                                  <?php
                                                  // echo 'tets';
                                                        $submenu_items=$ci->get_submenu_items($row2->id);
                                                        // print_r($submenu_items);
                                                  // $i=1;
                                                  foreach ($submenu_items as $key3 => $row3) 
                                                  {
                                                        ?>
                                                  <li><a href="<?php echo base_url()."item/product/".$row3->submenu_item_name_slug; ?>"><?php echo $row3->submenu_item_name; ?></a></li>
                                                <?php } ?>
                                                  <!-- <li><a href="#!">Shirt -Casual</a></li>
                                                  <li><a href="#!">T-shirt Polo</a></li>
                                                  <li><a href="#!">T-shirt Round Neck</a></li>
                                                  <li><a href="#!">Jackets</a></li>
                                                  <li><a href="#!">Blazer</a></li>
                                                  <li><a href="#!">Suits</a></li>
                                                  <li><a href="#!">Sweater</a></li>
                                                  <li><a href="#!">Sweatshirt</a></li>
                                                  <li><a href="#!">Suits</a></li> -->
                                              </ul>
                                            </div>
                                          </div> 
                                        <?php } ?>

                                        </div>
                                      </div>
                                    <?php } ?> 

                                  </li>
                                <?php } ?>
                                </ul>
                              </div>
                            </div>
                           
                        <?php }
                       ?>
                    </li>

                <?php } ?>
                <li><a href="<?php echo site_url('deal-of-the-day'); ?>">Deals of the day</a></li>
             
      
             <!--deal-of-the-day url added-->



              
            </ul>
          
          
        </div>
        </div>
      </div>
    </nav>
</section>

