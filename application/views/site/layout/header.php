<?php 
    define('APP_NAME', $this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->site_name);
    define('APP_FAVICON', $this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->web_favicon);
    define('APP_LOGO', $this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->web_logo_1);
    define('APP_LOGO_2', $this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->web_logo_1);
    
    $sharing_img=base_url('assets/images/facebook_share_banner.png');
    $sharing_wp_img=base_url('assets/images/wp_share_banner.png');

    $ci =& get_instance();

    $array_items = array('single_pre_url');

    $this->session->unset_userdata($array_items);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="author" content="">
    <title> <?php if(isset($current_page)){ echo $current_page.' | ';} ?><?php echo APP_NAME;?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="<?=base_url('assets/images/').APP_FAVICON?>"/>

    <meta name="description" content="<?=$this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->site_description?>">
    <meta name="keywords" content="<?=$this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->site_keywords?>">

    <meta property="og:type" content="article" />
    <meta property="og:title" content="<?php if(isset($current_page)){ echo $current_page.' | ';} ?><?php echo APP_NAME;?>" />
    <meta property="og:description" content="<?=$this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->site_description?>" />
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

    

	  <!-- Google Fonts -->
	  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

    <script type="text/javascript">
      var Settings = {
        base_url: '<?= base_url() ?>',
        currency_code: '<?= CURRENCY_CODE ?>',
        hour: '<?=$this->lang->line('hour_lbl')?>',
        minute: '<?=$this->lang->line('minute_lbl')?>',
        second: '<?=$this->lang->line('second_lbl')?>',
        confirm_msg: '<?=$this->lang->line('are_you_sure_msg')?>',
        ord_cancel_confirm: '<?=$this->lang->line('ord_cancel_confirm_lbl')?>',
        product_cancel_confirm: '<?=$this->lang->line('product_cancel_confirm_lbl')?>',
        err_cart_item_buy: '<?=$this->lang->line('err_cart_item_buy_lbl')?>',
        err_shipping_address: '<?=$this->lang->line('no_shipping_address_err')?>',
        err_something_went_wrong: '<?=$this->lang->line('something_went_wrong_err')?>',
      }
    </script>

    

  </head>

<body>
<!-- <div class="se-pre-con"></div>
<div class="process_loader"></div> -->
<div class="wrapper home-3"> 
  <header>
    <div class="header-container">
      <div class="header-middel-area">
        <div class="container">
          <div class="row"> 
            <div class="col-md-2 col-sm-3 col-xs-12">
              <div class="logo"> <a href="<?=base_url('/')?>"><img src="<?=base_url('assets/images/').APP_LOGO?>" alt="<?=APP_NAME?>" style="max-width: auto !important;height: auto;min-width:auto;"></a> </div>
            </div>
            <div class="col-md-8 col-sm-6 col-xs-12">
              <div class="search-box-area">
                <form accept-charset="utf-8" action="<?=base_url('search-result')?>" id="search_form" method="get">
                  <div class="select-area">
                    <select name="category" data-placeholder="Choose Category" class="select" tabindex="1">
                      <option value="">All Categories</option>
                      <?php 
                        foreach ($ci->get_category() as $key => $row) 
                        {
                          echo '<option value="'.$row->category_slug.'">'.$row->category_name.'</option>';
                        }
                      ?>                 
                    </select>
                  </div>
                  <div class="search-box">
                    <input type="text" name="keyword" id="search" autocomplete="off" placeholder="<?=$this->lang->line('search_lbl')?>" value="<?=$this->input->get('keyword')!='' ? $this->input->get('keyword') : ''?>" required="">
                    <button type="submit"><i class="ion-ios-search-strong"></i></button>
                  </div>
                </form>
              </div>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-12">
              <div class="mini-cart-area">
                <ul>
                  <li>
                    <?php 
                      if(!check_user_login()){
                    ?>
                    <a href="javascript:void(0)">
                      <i class="ion-android-person"></i>
                    </a>
                    <?php 
                    }
                    else{

                      $user_img=$this->db->get_where('tbl_users', array('id' => $this->session->userdata('user_id')))->row()->user_image;

                      if($user_img=='' OR !file_exists('assets/images/users/'.$user_img)){
                        $user_img=base_url('assets/images/photo.jpg');
                      }
                      else{

                        $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $user_img);

                        $user_img=base_url().$ci->_create_thumbnail('assets/images/users/',$thumb_img_nm,$user_img,200,200);
                      }
                      
                      ?>
                      <?php 
                        if($this->session->userdata('user_type')=='Google'){
                          echo '<img src="'.base_url('assets/img/google-logo.png').'" class="social_img">';
                        }
                        else if($this->session->userdata('user_type')=='Facebook'){
                          echo '<img src="'.base_url('assets/img/facebook-icon.png').'" class="social_img">';
                        }
                      ?>
                      <a href="javascript:void(0)" style="background-image: url('<?=$user_img?>');background-size: cover;">
                      </a>
                      <?php
                    }
                    ?>
                    <ul class="cart-dropdown user_login">
                      <?php 
                        if(!check_user_login()){
                      ?>
                      <li class="cart-button"> <a href="<?php echo site_url('login-register'); ?>" class="button2"><?=$this->lang->line('login_register_btn')?></a>
                      </li>
                      <?php }else{ ?>
                      <li class="cart-item"><a href="<?php echo site_url('my-account'); ?>"><i class="ion-android-person"></i> <?=$this->lang->line('myaccount_lbl')?></a></li>
                      <li class="cart-item"><a href="<?php echo site_url('my-orders'); ?>"><i class="ion-bag"></i> <?=$this->lang->line('myorders_lbl')?></a></li>
                      <li class="cart-item"><a href="<?php echo site_url('my-cart'); ?>"><i class="ion-ios-cart-outline"></i> <?=$this->lang->line('shoppingcart_lbl')?></a></li>
                      <li class="cart-item"><a href="<?php echo site_url('wishlist'); ?>"><i class="ion-ios-list-outline"></i> <?=$this->lang->line('mywishlist_lbl')?></a></li>
                      <li class="cart-item"><a href="<?=site_url('site/logout')?>" class="btn_logout"><i class="ion-log-out"></i> <?=$this->lang->line('logout_lbl')?></a></li>
                      <?php } ?> 
                    </ul>
                  </li>
                  <li>
                    <a href="<?php echo site_url('my-cart'); ?>">
                      <i class="ion-android-cart"></i>
                      <span class="cart-add"><?=count($ci->get_cart())?></span>
                    </a>
                    <ul class="cart-dropdown">
                      <?php 

                        if(check_user_login()){

                          $row=$ci->get_cart(3);
                          if(!empty($row))
                          {
                          foreach ($row as $key => $value) {

                            $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->featured_image);

                            $img_file=$ci->_create_thumbnail('assets/images/products/',$thumb_img_nm,$value->featured_image,50,50);


                        ?>
                        <li class="cart-item">
                          <div class="cart-img" style="width: auto"> <a href=""><img src="<?=base_url().$img_file?>" alt="" style="width: 68px;height: 68px"></a> </div>
                          <div class="cart-content">
                            <h4>
                              <a href="<?php echo site_url('product/'.$ci->get_single_info(array('id' => $value->product_id),'product_slug','tbl_product')); ?>" title="<?=$ci->get_single_info(array('id' => $value->product_id),'product_title','tbl_product')?>">
                                <?php 
                                  if(strlen($value->product_title) > 20){
                                    echo substr(stripslashes($value->product_title), 0, 20).'...';  
                                  }else{
                                    echo $value->product_title;
                                  }
                                ?>
                              </a>
                            </h4>
                            <p class="cart-quantity"><?=$this->lang->line('qty_lbl')?>: <?=$value->product_qty?></p>
                            <p class="cart-price">
                              <?php 
                                $price=number_format($value->selling_price*$value->product_qty, 2);
                                if(strlen($price) > 20){
                                  echo CURRENCY_CODE.' '.substr(stripslashes($price), 0, 20).'...';  
                                }else{
                                  echo CURRENCY_CODE.' '.$price;
                                }
                              ?>
                            </p>
                          </div>
                          <div class="cart-close"> <a href="<?php echo site_url('remove-to-cart/'.$value->id); ?>" class="btn_remove_cart" title="Remove"><i class="ion-android-close"></i></a> </div>
                        </li>
                        
                        <?php } ?>
                        <?php 
                          if(count($ci->get_cart()) > 3){
                              echo '<li class="cart-item text-center">
                                      <h4 style="font-weight: 500">'.str_replace('###', (count($ci->get_cart())-3), $this->lang->line('remain_cart_items_lbl')).'</h4>
                                    </li>';
                          }
                        ?>
                        
                        <li class="cart-button"> <a href="<?php echo site_url('my-cart'); ?>" class="button2"><?=$this->lang->line('view_cart_btn')?></a> <a href="<?php echo site_url('checkout'); ?>" class="button2"><?=$this->lang->line('checkout_btn')?></a> 
                        </li>
                        <?php 
                        }
                        else{
                          ?>
                          <li class="cart-item text-center" style="padding: 15px">
                            <h4 style="font-weight: 500"><i class="ion-android-cart"></i> <?=$this->lang->line('empty_cart_lbl')?></h4>
                          </li>
                          <?php
                          }
                        }   // end of session check
                        else{
                          ?>
                          <li class="cart-item text-center" style="padding: 15px">
                            <h4 style="font-weight: 500"><?=$this->lang->line('login_status_lbl')?></h4>
                          </li>
                          <?php
                        }
                      ?>

                    </ul>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="mobile-menu-area hidden-sm hidden-md hidden-lg">
        <div class="container">
          <div class="row">
            <div class="col-xs-12">
              <div class="mobile-menu">
                <nav>
                  <ul>
                    <li <?php if(isset($current_page) && $current_page==$this->lang->line('home_lbl')){ echo 'class="active"';} ?>><a href="<?=base_url('/')?>"><?=$this->lang->line('home_lbl')?></a></li>
                    <li <?php if(isset($current_page) && $current_page==$this->lang->line('category_lbl')){ echo 'class="active"';} ?>><a href="<?=base_url('/category')?>"><?=$this->lang->line('category_lbl')?></a>
                      <ul>
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
                        <li>
                          <a href="<?=$url?>">
                            <?php 
                              if(strlen($row->category_name) > 30){
                                echo substr(stripslashes($row->category_name), 0, 30).'...';  
                              }else{
                                echo $row->category_name;
                              }
                            ?>
                            </a>
                            <?php 
                              if($counts > 0)
                              {
                            ?>
                            <ul>
                              <?php 
                                $sub_category_list=$ci->get_sub_category($row->id);
                                $i=1;
                                foreach ($sub_category_list as $key1 => $row1) 
                                {
                              ?>
                              <li>
                                <a href="<?=site_url('category/'.$row->category_slug.'/'.$row1->sub_category_slug)?>">
                                  <?php 
                                    if(strlen($row1->sub_category_name) > 30){
                                      echo substr(stripslashes($row1->sub_category_name), 0, 30).'...';  
                                    }else{
                                      echo $row1->sub_category_name;
                                    }
                                  ?>  
                                </a>
                              </li>
                              <?php } ?>
                            </ul>
                            <?php } ?>
                        </li>
                        <?php } ?>
                      </ul>
                    </li>
                    <li <?php if(isset($current_page) && $current_page==$this->lang->line('offers_lbl')){ echo 'class="active"';} ?>><a href="<?=base_url('/offers')?>"><?=$this->lang->line('offer_lbl')?></a></li>
                    <li <?php if(isset($current_page) && $current_page==$this->lang->line('todays_deal_lbl')){ echo 'class="active"';} ?>><a href="<?=base_url('/todays-deals')?>"><?=$this->lang->line('todays_deal_lbl')?></a></li>
                    <li <?php if(isset($current_page) && $current_page==$this->lang->line('contactus_lbl')){ echo 'class="active"';} ?>><a href="<?php echo site_url('contact-us'); ?>"><?=$this->lang->line('contactus_lbl')?></a></li>                   
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="header-bottom-area header-sticky">
        <div class="container">
          <div class="row"> 
            <div class="col-md-3 col-sm-3">
              <div class="side-menu">
                <div class="category-heading">
                  <h2><i class="ion-android-menu"></i><span><?=$this->lang->line('category_lbl')?></span></h2>
                </div>
                <div id="cate-toggle" class="category-menu-list">
                  <ul>
                    <?php
                       
                      $n=1;
                      foreach ($category_list as $key => $row) 
                      {
                        if($n > 5){
                          break;
                        }

                        $n++;

                        $counts=$ci->getCount('tbl_sub_category', array('category_id' => $row->id, 'status' => '1'));

                        if($counts > 0)
                        {
                          $url=base_url('category/'.$row->category_slug);  
                        }
                        else{
                          $url=base_url('category/products/'.$row->id);
                        }

                    ?>
                    <li <?php if($counts > 0){ echo 'class="right-menu"'; } ?>>
                      <a href="<?=$url?>">
                        <?php 
                          if(strlen($row->category_name) > 30){
                            echo substr(stripslashes($row->category_name), 0, 30).'...';  
                          }else{
                            echo $row->category_name;
                          }
                        ?>
                      </a>
                      <?php 
                        if($counts > 0)
                        {
                      ?>
                      <ul class="cat-dropdown">

                        <?php 
                          $sub_category_list=$ci->get_sub_category($row->id);
                          $i=1;
                          foreach ($sub_category_list as $key1 => $row1) 
                          {

                            if($i > 5){
                              break;
                            }

                            $i++;
                        ?>
                          <li>
                            <a href="<?=site_url('category/'.$row->category_slug.'/'.$row1->sub_category_slug)?>">
                              <?php 
                                if(strlen($row1->sub_category_name) > 30){
                                  echo substr(stripslashes($row1->sub_category_name), 0, 30).'...';  
                                }else{
                                  echo $row1->sub_category_name;
                                }
                              ?>  
                            </a>
                          </li>
                        <?php 
                          }
                          if($counts > 5)
                          {
                        ?>
                        <li class="rx-parent"> <a class="rx-default" href="<?=site_url('category/'.$row->category_slug)?>"><span class="cat-thumb fa fa-ellipsis-h"></span><?=$this->lang->line('view_all_lbl')?></a></li>
                        <?php } ?>
                      </ul>
                      <?php } ?>
                    </li>
                    <?php }
                    if(count($category_list) > 5)
                      {
                    ?>
                    <li class="rx-parent"> <a class="rx-default" href="<?=base_url('/category')?>"><?=$this->lang->line('view_all_lbl')?></a></li>
                    <?php } ?>
                    
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-md-9 col-sm-9"> 
              <div class="logo-sticky"> <a href="<?=base_url('/')?>"><img src="<?=base_url('assets/images/').APP_LOGO?>" alt="" style="max-width: 250px !important;height: auto;min-width: 100%;"></a> </div>
              <div class="main-menu-area">
                <nav>
                  <ul class="main-menu">
                    <li <?php if(isset($current_page) && $current_page==$this->lang->line('home_lbl')){ echo 'class="active"';} ?>><a href="<?=base_url('/')?>"><?=$this->lang->line('home_lbl')?></a></li>
                    <li <?php if(isset($current_page) && $current_page==$this->lang->line('offers_lbl')){ echo 'class="active"';} ?>><a href="<?=base_url('/offers')?>"><?=$this->lang->line('offer_lbl')?></a></li>
                    <li <?php if(isset($current_page) && $current_page==$this->lang->line('todays_deal_lbl')){ echo 'class="active"';} ?>><a href="<?=base_url('/todays-deals')?>"><?=$this->lang->line('todays_deal_lbl')?></a></li>
                    <li <?php if(isset($current_page) && $current_page==$this->lang->line('contactus_lbl')){ echo 'class="active"';} ?>><a href="<?php echo site_url('contact-us'); ?>"><?=$this->lang->line('contactus_lbl')?></a></li>
                  </ul>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </header>
   <!-- <li class="dropdown has-megamenu">-->
              <!--    <a class="nav-link dropdown-toggle" href="products.php" data-toggle="dropdown"> Fashion  </a>-->
              <!--    <div class="dropdown-menu megamenu" role="menu">-->
              <!--      <div class="">-->
              <!--        <ul>-->
                     
              <!--            <li class="dropdown has-megamenu1 ">-->
              <!--              <a class="nav-link dropdown-toggle circle" href="products.php" data-toggle="dropdown"> <i class="icon-ring"></i> <span>Mens</span></a>-->
                            
              <!--               <div class="dropdown-menu megamenu1" role="menu">-->
              <!--                  <div class="row">-->
              <!--                      <div class="col-md-2">-->
              <!--                          <div class="col-megamenu">-->
              <!--                            <h6 class="title">Western-Tops set</h6>-->
              <!--                            <ul class="list-unstyled">-->
              <!--                                <li><a href="#!">Shirt -Formal</a></li>-->
              <!--                                <li><a href="#!">Shirt -Casual</a></li>-->
              <!--                                <li><a href="#!">T-shirt Polo</a></li>-->
              <!--                                <li><a href="#!">T-shirt Round Neck</a></li>-->
              <!--                                <li><a href="#!">Jackets</a></li>-->
              <!--                                <li><a href="#!">Blazer</a></li>-->
              <!--                                <li><a href="#!">Suits</a></li>-->
              <!--                                <li><a href="#!">Sweater</a></li>-->
              <!--                                <li><a href="#!">Sweatshirt</a></li>-->
              <!--                                <li><a href="#!">Suits</a></li>-->
              <!--                            </ul>-->
              <!--                          </div>  <!-- col-megamenu.// -->-->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Ethic-Tops & Sets</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Kurta</a></li>-->
              <!--                                  <li><a href="#!">Kurta Set</a></li>-->
              <!--                                  <li><a href="#!">Sherwani</a></li>-->
              <!--                                  <li><a href="#!">Nehru Jacket</a></li>-->
                                                
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Innerwear</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Briefs & Trunks</a></li>-->
              <!--                                  <li><a href="#!">Boxer</a></li>-->
              <!--                                  <li><a href="#!">Vest</a></li>-->
              <!--                                  <li><a href="#!">Thermal</a></li>-->
                                                
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>    -->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by Ocassion</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
            
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by Style</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
            
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                  </div><!-- end row -->-->
              <!--               </div> <!-- dropdown-mega-menu.// -->-->
                            
              <!--          </li>-->
                        
              <!--           <li class="dropdown has-megamenu1 ">-->
              <!--              <a class="nav-link dropdown-toggle circle" href="products.php" data-toggle="dropdown"> <i class="icon-ring"></i> <span>Womens</span></a>-->
                            
              <!--               <div class="dropdown-menu megamenu1" role="menu">-->
              <!--                  <div class="row">-->
              <!--                      <div class="col-md-2">-->
              <!--                          <div class="col-megamenu">-->
              <!--                            <h6 class="title">Western-Tops set</h6>-->
              <!--                            <ul class="list-unstyled">-->
              <!--                                <li><a href="#!">Shirt -Formal</a></li>-->
              <!--                                <li><a href="#!">Shirt -Casual</a></li>-->
              <!--                                <li><a href="#!">T-shirt Polo</a></li>-->
              <!--                                <li><a href="#!">T-shirt Round Neck</a></li>-->
              <!--                                <li><a href="#!">Jackets</a></li>-->
              <!--                                <li><a href="#!">Blazer</a></li>-->
              <!--                                <li><a href="#!">Suits</a></li>-->
              <!--                                <li><a href="#!">Sweater</a></li>-->
              <!--                                <li><a href="#!">Sweatshirt</a></li>-->
              <!--                                <li><a href="#!">Suits</a></li>-->
              <!--                            </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Ethic-Tops & Sets</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Kurta</a></li>-->
              <!--                                  <li><a href="#!">Kurta Set</a></li>-->
              <!--                                  <li><a href="#!">Sherwani</a></li>-->
              <!--                                  <li><a href="#!">Nehru Jacket</a></li>-->
                                                
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Innerwear</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Briefs & Trunks</a></li>-->
              <!--                                  <li><a href="#!">Boxer</a></li>-->
              <!--                                  <li><a href="#!">Vest</a></li>-->
              <!--                                  <li><a href="#!">Thermal</a></li>-->
                                                
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>    -->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by Ocassion</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
            
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by Style</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
            
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                  </div><!-- end row -->-->
              <!--               </div> <!-- dropdown-mega-menu.// -->-->
                            
              <!--          </li>-->
                        
              <!--          <li class="dropdown has-megamenu1 ">-->
              <!--              <a class="nav-link dropdown-toggle circle" href="products.php" data-toggle="dropdown"> <i class="icon-ring"></i> <span>Kid Boy</span></a>-->
                            
              <!--               <div class="dropdown-menu megamenu1" role="menu">-->
              <!--                  <div class="row">-->
              <!--                      <div class="col-md-2">-->
              <!--                          <div class="col-megamenu">-->
              <!--                            <h6 class="title">Western-Tops set</h6>-->
              <!--                            <ul class="list-unstyled">-->
              <!--                                <li><a href="#!">Shirt -Formal</a></li>-->
              <!--                                <li><a href="#!">Shirt -Casual</a></li>-->
              <!--                                <li><a href="#!">T-shirt Polo</a></li>-->
              <!--                                <li><a href="#!">T-shirt Round Neck</a></li>-->
              <!--                                <li><a href="#!">Jackets</a></li>-->
              <!--                                <li><a href="#!">Blazer</a></li>-->
              <!--                                <li><a href="#!">Suits</a></li>-->
              <!--                                <li><a href="#!">Sweater</a></li>-->
              <!--                                <li><a href="#!">Sweatshirt</a></li>-->
              <!--                                <li><a href="#!">Suits</a></li>-->
              <!--                            </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Ethic-Tops & Sets</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Kurta</a></li>-->
              <!--                                  <li><a href="#!">Kurta Set</a></li>-->
              <!--                                  <li><a href="#!">Sherwani</a></li>-->
              <!--                                  <li><a href="#!">Nehru Jacket</a></li>-->
                                                
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Innerwear</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Briefs & Trunks</a></li>-->
              <!--                                  <li><a href="#!">Boxer</a></li>-->
              <!--                                  <li><a href="#!">Vest</a></li>-->
              <!--                                  <li><a href="#!">Thermal</a></li>-->
                                                
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>    -->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by Ocassion</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
            
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by Style</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
            
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                  </div><!-- end row -->-->
              <!--               </div> <!-- dropdown-mega-menu.// -->-->
                            
              <!--          </li>-->
                        
              <!--          <li class="dropdown has-megamenu1 ">-->
              <!--              <a class="nav-link dropdown-toggle circle" href="products.php" data-toggle="dropdown"> <i class="icon-ring"></i> <span>Kid Girl</span></a>-->
                            
              <!--               <div class="dropdown-menu megamenu1" role="menu">-->
              <!--                  <div class="row">-->
              <!--                      <div class="col-md-2">-->
              <!--                          <div class="col-megamenu">-->
              <!--                            <h6 class="title">Western-Tops set</h6>-->
              <!--                            <ul class="list-unstyled">-->
              <!--                                <li><a href="#!">Shirt -Formal</a></li>-->
              <!--                                <li><a href="#!">Shirt -Casual</a></li>-->
              <!--                                <li><a href="#!">T-shirt Polo</a></li>-->
              <!--                                <li><a href="#!">T-shirt Round Neck</a></li>-->
              <!--                                <li><a href="#!">Jackets</a></li>-->
              <!--                                <li><a href="#!">Blazer</a></li>-->
              <!--                                <li><a href="#!">Suits</a></li>-->
              <!--                                <li><a href="#!">Sweater</a></li>-->
              <!--                                <li><a href="#!">Sweatshirt</a></li>-->
              <!--                                <li><a href="#!">Suits</a></li>-->
              <!--                            </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Ethic-Tops & Sets</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Kurta</a></li>-->
              <!--                                  <li><a href="#!">Kurta Set</a></li>-->
              <!--                                  <li><a href="#!">Sherwani</a></li>-->
              <!--                                  <li><a href="#!">Nehru Jacket</a></li>-->
                                                
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Innerwear</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Briefs & Trunks</a></li>-->
              <!--                                  <li><a href="#!">Boxer</a></li>-->
              <!--                                  <li><a href="#!">Vest</a></li>-->
              <!--                                  <li><a href="#!">Thermal</a></li>-->
                                                
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>    -->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by Ocassion</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
            
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by Style</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
            
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                      <div class="col-md-2">-->
              <!--                        <div class="col-megamenu">-->
              <!--                          <h6 class="title">Shop by motifs</h6>-->
              <!--                              <ul class="list-unstyled">-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                                  <li><a href="#!">Custom Menu</a></li>-->
              <!--                              </ul>-->
              <!--                          </div>  -->
              <!--                      </div>-->
              <!--                  </div>-->
              <!--               </div> -->
                            
              <!--          </li>-->
                        

                      
              <!--        </ul>-->
              <!--      </div>-->
              <!--    </div> <!-- dropdown-mega-menu.// -->-->
              <!--</li>-->

          