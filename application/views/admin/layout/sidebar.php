<style type="text/css">
  .dropdown-li{
    margin-bottom: 0px !important;
  }
  .cust-dropdown-container{
    background: #E7EDEE;
    display: none;
  }
  .cust-dropdown{
    list-style: none;
    background: #eee;
	padding-left:27px;
  }
  .cust-dropdown li a{
    padding: 8px 0px;
    width: 100%;
    display: block;
    color: #444;
    float: left;
    text-decoration: none;
    transition: all linear 0.2s;
    font-weight: 500;
  }
  .cust-dropdown li a:hover, .cust-dropdown li a.active{
    color: #8bc24b;
  }
</style>

<aside class="app-sidebar" id="sidebar">
  <div class="sidebar-header"> <a class="sidebar-brand" href="<?=site_url('admin/dashboard')?>"><img src="<?=base_url('assets/images/'.APP_LOGO);?>" alt="app logo" /></a>
    <button type="button" class="sidebar-toggle"> <i class="fa fa-times"></i> </button>
  </div>
  <div class="sidebar-menu">
    <ul class="sidebar-nav">
      <li class="<?php if($page_title==$this->lang->line('dashboard_lbl')){ echo 'active';} ?>">
        <a href="<?=site_url('admin/dashboard')?>">
        <div class="icon"> <i class="fa fa-dashboard" aria-hidden="true"></i> </div>
        <div class="title"><?=$this->lang->line('dashboard_lbl')?></div>
        </a> 
      </li>

      <li class="dropdown-li products <?php if(isset($current_page) && $current_page=="products"){ echo 'active'; }?>">
        <a href="javascript:void(0)" class="dropdown-a">
          <div class="icon"> <i class="fa fa-product-hunt" aria-hidden="true"></i> </div>
          <div class="title"><?=$this->lang->line('products_master_lbl')?></div>
          <i class="fa fa-angle-right pull-right" style="padding-top: 8px;color: #fff;"></i>
        </a> 
      </li>

      <li class="cust-dropdown-container">
        <ul class="cust-dropdown"> 
          <li>
            <a href="<?=site_url('admin/category')?>" class="<?php if($page_title==$this->lang->line('category_lbl') OR $page_title==$this->lang->line('add_category_lbl') OR $page_title==$this->lang->line('edit_category_lbl')){ echo 'active';} ?>">
              <div class="title"><i class="fa fa-angle-right"></i> <?=$this->lang->line('category_lbl')?></div>
            </a> 
          </li>
          <li>
            <a href="<?=site_url('admin/sub-category')?>" class="<?php if($page_title==$this->lang->line('sub_category_lbl') OR $page_title==$this->lang->line('add_sub_category_lbl') OR $page_title==$this->lang->line('edit_sub_category_lbl')){ echo 'active';} ?>">
              <div class="title"><i class="fa fa-angle-right"></i> <?=$this->lang->line('sub_category_lbl')?></div>
            </a> 
          </li>
          <li>
            <a href="<?=site_url('admin/submenu-header')?>" class="">
              <div class="title"><i class="fa fa-angle-right"></i> Menu Headers</div>
            </a> 
          </li>
          <li>
            <a href="<?=site_url('admin/submenu-item')?>" class="">
              <div class="title"><i class="fa fa-angle-right"></i> Menu Items</div>
            </a> 
          </li>
          <li>
            <a href="<?=site_url('admin/brand')?>" class="<?php if($page_title==$this->lang->line('brands_lbl') OR $page_title==$this->lang->line('add_brand_lbl') OR $page_title==$this->lang->line('edit_brand_lbl')){ echo 'active';} ?>">
              <div class="title"><i class="fa fa-angle-right"></i> <?=$this->lang->line('brands_lbl')?></div>
            </a> 
          </li>
          <li>
            <a href="<?=site_url('admin/offers')?>" class="<?php if($page_title==$this->lang->line('offers_lbl') OR $page_title==$this->lang->line('add_offer_lbl') OR $page_title==$this->lang->line('edit_offer_lbl')){ echo 'active';} ?>">
              <div class="title"><i class="fa fa-angle-right"></i> <?=$this->lang->line('offers_lbl')?></div>
            </a> 
          </li> 
          <li>
            <a href="<?=site_url('admin/products')?>" class="<?php if($page_title==$this->lang->line('products_lbl') OR $page_title==$this->lang->line('add_product_lbl') OR $page_title==$this->lang->line('edit_product_lbl')){ echo 'active';} ?>">
              <div class="title"><i class="fa fa-angle-right"></i> <?=$this->lang->line('products_lbl')?></div>
            </a> 
          </li>   
        </ul>
      </li>

      <li class="<?php if($page_title==$this->lang->line('banners_lbl')){ echo 'active';} ?>">
        <a href="<?=site_url('admin/banner')?>">
          <div class="icon"> <i class="fa fa-map-o" aria-hidden="true"></i> </div>
          <div class="title"><?=$this->lang->line('banners_lbl')?></div>
          </a>
      </li>
      <li class="<?php if($page_title==$this->lang->line('coupons_lbl')){ echo 'active';} ?>">
        <a href="<?=site_url('admin/coupon')?>">
          <div class="icon"> <i class="fa fa-ticket" aria-hidden="true"></i> </div>
          <div class="title"><?=$this->lang->line('coupons_lbl')?></div>
          </a>
      </li>

      <li class="<?php if($page_title==$this->lang->line('users_lbl')){ echo 'active';} ?>">
        <a href="<?=site_url('admin/users')?>">
        <div class="icon"> <i class="fa fa-users" aria-hidden="true"></i> </div>
        <div class="title"><?=$this->lang->line('users_lbl')?></div>
        </a> 
      </li>

      <li class="<?php if($page_title==$this->lang->line('ord_list_lbl')){ echo 'active';} ?>">
        <a href="<?=site_url('admin/orders')?>">
        <div class="icon"> <i class="fa fa-cart-arrow-down" aria-hidden="true"></i> </div>
        <div class="title"><?=$this->lang->line('ord_list_lbl')?></div>
        </a> 
      </li>

      <li class="<?php if($page_title==$this->lang->line('transactions_lbl')){ echo 'active';} ?>">
        <a href="<?=site_url('admin/transactions')?>">
        <div class="icon"> <i class="fa fa-list" aria-hidden="true"></i> </div>
        <div class="title"><?=$this->lang->line('transactions_lbl')?></div>
        </a> 
      </li>

      <li class="<?php if($page_title==$this->lang->line('refunds_lbl')){ echo 'active';} ?>">
        <a href="<?=site_url('admin/refunds')?>">
        <div class="icon"> <i class="fa fa-undo" aria-hidden="true"></i> </div>
        <div class="title"><?=$this->lang->line('refunds_lbl')?></div>
        </a> 
      </li>

      <li class="<?php if($page_title==$this->lang->line('contact_list_lbl')){ echo 'active';} ?>">
        <a href="<?=site_url('admin/contacts')?>">
        <div class="icon"> <i class="fa fa-envelope" aria-hidden="true"></i> </div>
        <div class="title"><?=$this->lang->line('contact_list_lbl')?></div>
        </a> 
      </li>

      <li class="<?php if($page_title=="Teams"){ echo 'active';} ?>">
        <a href="<?=site_url('admin/cms/teams')?>">
        <div class="icon"> <i class="fa fa-envelope" aria-hidden="true"></i> </div>
        <div class="title">Teams</div>
        </a> 
      </li>

      <li class="dropdown-li cms <?php if(isset($current_page) && $current_page=="CMS"){ echo 'active'; }?>">
        <a href="javascript:void(0)" class="dropdown-a">
          <div class="icon"> <i class="fa fa-product-hunt" aria-hidden="true"></i> </div>
          <div class="title">CMS</div>
          <i class="fa fa-angle-right pull-right" style="padding-top: 8px;color: #fff;"></i>
        </a> 
      </li>

      <li class="cust-dropdown-container">
        <ul class="cust-dropdown"> 
          <li>
            <a href="<?=site_url('admin/cms/data/terms')?>" class="<?php if($page_title=="Terms and Condition" OR $page_title=="Add Terms and Condition"  OR $page_title=="Edit Terms and Condition" ){ echo 'active';} ?>">
              <div class="title"><i class="fa fa-angle-right"></i> Terms and Condition </div>
            </a> 
          </li>
          <li>
            <a href="<?=site_url('admin/cms/data/privacy')?>" class="<?php if($page_title=="Privacy Policy" OR $page_title=="Add Privacy Policy"  OR $page_title=="Edit Privacy Policy" ){ echo 'active';} ?>">
              <div class="title"><i class="fa fa-angle-right"></i> Privacy Policy </div>
            </a> 
          </li>
          <li>
            <a href="<?=site_url('admin/cms/data/refund')?>" class="<?php if($page_title=="Refund Policy" OR $page_title=="Add Refund Policy"  OR $page_title=="Edit Refund Policy" ){ echo 'active';} ?>">
              <div class="title"><i class="fa fa-angle-right"></i> Refund Policy </div>
            </a> 
          </li>
          <li>
            <a href="<?=site_url('admin/cms/data/cancellation')?>" class="<?php if($page_title=="Cancellation Policy" OR $page_title=="Add Cancellation Policy"  OR $page_title=="Edit Cancellation Policy" ){ echo 'active';} ?>">
              <div class="title"><i class="fa fa-angle-right"></i> Cancellation Policy </div>
            </a> 
          </li>
          <li>
            <a href="<?=site_url('admin/cms/data/shipping')?>" class="<?php if($page_title=="Shipping Delivery" OR $page_title=="Add Shipping Delivery"  OR $page_title=="Edit Shipping Delivery" ){ echo 'active';} ?>">
              <div class="title"><i class="fa fa-angle-right"></i> Shipping Delivery </div>
            </a> 
          </li>
          
          <li>
            <a href="<?=site_url('admin/cms/data/career')?>" class="<?php if($page_title=="Career" OR $page_title=="Add Career"  OR $page_title=="Edit Career" ){ echo 'active';} ?>">
              <div class="title"><i class="fa fa-angle-right"></i> Career </div>
            </a> 
          </li>
             
        </ul>
      </li>

      <li class="dropdown-li settings <?php if(isset($current_page) && $current_page=="settings"){ echo 'active'; }?>">
        <a href="javascript:void(0)" class="dropdown-a">
          <div class="icon"> <i class="fa fa-cog" aria-hidden="true"></i> </div>
          <div class="title"><?=$this->lang->line('settings_lbl')?></div>
          <i class="fa fa-angle-right pull-right" style="padding-top: 8px;color: #fff;"></i>
        </a> 
      </li>

      <li class="cust-dropdown-container">
        <ul class="cust-dropdown"> 
          <li>
            <a href="<?=site_url('admin/web-settings')?>" class="<?php if($page_title==$this->lang->line('web_settings_lbl')){ echo 'active';} ?>">
              <div class="title"><i class="fa fa-angle-right"></i> <?=$this->lang->line('web_settings_lbl')?></div>
            </a> 
          </li>
          <li>
            <a href="<?=site_url('admin/settings')?>" class="<?php if($page_title==$this->lang->line('general_settings_lbl')){ echo 'active';} ?>">
              <div class="title"><i class="fa fa-angle-right"></i> <?=$this->lang->line('general_settings_lbl')?></div>
            </a> 
          </li>   
        </ul>
      </li>

      <?php 
        if($this->db->get_where('tbl_verify', array('id' => '1'))->row()->android_envato_purchased_status==1)
        {
      ?>
      <!--<li class="dropdown-li android <?php if(isset($current_page) && $current_page=="android"){ echo 'active'; }?>">-->
      <!--  <a href="javascript:void(0)" class="dropdown-a">-->
      <!--    <div class="icon"> <i class="fa fa-android" aria-hidden="true"></i> </div>-->
      <!--    <div class="title"><?=$this->lang->line('android_app_lbl')?></div>-->
      <!--    <i class="fa fa-angle-right pull-right" style="padding-top: 8px;color: #fff;"></i>-->
      <!--  </a> -->
      <!--</li>-->
      <!--<li class="cust-dropdown-container">-->
      <!--  <ul class="cust-dropdown">-->
      <!--    <li>-->
      <!--      <a href="<?=site_url('admin/android-settings')?>" class="<?php if($page_title==$this->lang->line('android_settings_lbl')){ echo 'active';} ?>">-->
      <!--        <div class="title"><i class="fa fa-angle-right"></i> <?=$this->lang->line('android_settings_lbl')?></div>-->
      <!--      </a> -->
      <!--    </li>-->
      <!--    <li>-->
      <!--      <a href="<?=site_url('admin/notification')?>" class="<?php if($page_title==$this->lang->line('notification_lbl')){ echo 'active';} ?>">-->
      <!--        <div class="title"><i class="fa fa-angle-right" aria-hidden="true"></i> <?=$this->lang->line('notification_lbl')?></div>-->
      <!--      </a> -->
      <!--    </li>  -->
      <!--  </ul>-->
      <!--</li>-->

      <?php } ?>

      <!--<li class="<?php if($page_title==$this->lang->line('verify_purchase_lbl')){ echo 'active';} ?>">-->
      <!--  <a href="<?=site_url('admin/verify-purchase')?>">-->
      <!--  <div class="icon"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div>-->
      <!--  <div class="title"><?=$this->lang->line('verify_purchase_lbl')?></div>-->
      <!--  </a> -->
      <!--</li>-->

      <?php 
        if($this->db->get_where('tbl_verify', array('id' => '1'))->row()->android_envato_purchased_status==1)
        {
      ?>
      <!--<li class="<?php if($page_title==$this->lang->line('api_urls_lbl')){ echo 'active';} ?>">-->
      <!--  <a href="<?=site_url('admin/api-urls')?>">-->
      <!--  <div class="icon"> <i class="fa fa-exchange" aria-hidden="true"></i> </div>-->
      <!--  <div class="title"><?=$this->lang->line('api_urls_lbl')?></div>-->
      <!--  </a> -->
      <!--</li>-->
      <?php } ?>
      
      
    </ul>
  </div>
   
</aside>