<?php 
  if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->libraries_load_from=='local')
  {
    add_css(array('assets/site_assets/css/slick.min.css'));

    add_footer_js(array('assets/site_assets/js/slick.min.js'));
  }
  else if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->libraries_load_from=='cdn')
  {
    add_cdn_css(array('https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css'));

    add_footer_cdn_js(array('https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js'));
  }

  add_footer_js(array('assets/site_assets/js/slick.init.js'));
  
  $this->load->view('site/layout/breadcrumb'); 
?>
<div class="product-list-grid-view-area mt-20" id="products_list">
  <div class="container">
    <div class="row"> 
      <?php 
        if(!empty($product_list)){
      ?>
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="shop-tab-menu">
          <div class="row"> 
            <div class="col-md-5 col-sm-5 col-lg-6 col-xs-12">
              <div class="shop-tab">
                <ul>
                  <li class="active"><a data-toggle="tab" href="#grid-view"><i class="ion-android-apps"></i></a></li>
                  <li><a data-toggle="tab" href="#list-view"><i class="ion-navicon-round"></i></a></li>
                </ul>
              </div>
            </div>
            <div class="col-md-7 col-sm-7 col-lg-6 hidden-xs text-right">
              <div class="toolbar-form">
                <form action="" method="get" id="sort_filter_form">
                  <input type="hidden" name="keyword" value="<?php if(isset($_GET['keyword'])){ echo trim($_GET['keyword']); }?>">
                  <div class="toolbar-select"> <span><?=$this->lang->line('sort_by_lbl')?>:</span>
                    <select data-placeholder="<?=$this->lang->line('sort_by_lbl')?>..." class="order-by list_order" name="sort" tabindex="1">
                      <option value="newest" <?php echo (isset($_GET['sort']) && strcmp($_GET['sort'], 'newest')==0) ? 'selected' : '' ?>><?=$this->lang->line('newest_first_lbl')?></option>
                      <option value="low-high" <?php echo (isset($_GET['sort']) && strcmp($_GET['sort'], 'low-high')==0) ? 'selected' : '' ?>><?=$this->lang->line('low_to_high_lbl')?></option>
                      <option value="high-low" <?php echo (isset($_GET['sort']) && strcmp($_GET['sort'], 'high-low')==0) ? 'selected' : '' ?>><?=$this->lang->line('high_to_low_lbl')?></option>
                      <option value="top" <?php echo (isset($_GET['sort']) && strcmp($_GET['sort'], 'top')==0) ? 'selected' : '' ?>><?=$this->lang->line('top_selling_lbl')?></option>
                    </select>
                  </div>
                </form>
              </div>
              <div class="show-result">
                <p><?=$show_result;?></p>
              </div>
            </div>
          </div>
        </div>
        <div class="shop-product-area">
          <div class="tab-content"> 

            <!-- For Grid View -->
            <div id="grid-view" class="tab-pane fade in active">
              <div class="row">
                <div class="product-container"> 
                  <?php

                    $ci =& get_instance();
                    foreach ($product_list as $key => $row) {

                      $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

                      // $img_file='assets/images/products/'.$row->featured_image;

                      $img_file=$ci->_create_thumbnail('assets/images/products/',$row->product_slug,$row->featured_image,360,360);

                      $img_file2=$ci->_create_thumbnail('assets/images/products/',$row->id,$row->featured_image2,360,360);

                  ?>
                  <div class="col-md-3 col-sm-3 col-xs-6 item-col2">
                    <div class="single-product">
                      <div class="product-img"> <a href="<?php echo site_url('product/'.$row->product_slug); ?>" title="<?=$row->product_title?>"> <img class="first-img" src="<?=base_url().$img_file?>" alt=""> <img class="hover-img" src="<?=base_url().$img_file2?>" alt=""> </a>
                        <?php 
                          if($row->you_save_per!='0'){
                            echo '<span class="sicker">'.$row->you_save_per.$this->lang->line('per_off_lbl').'</span>';
                          }
                        ?>
                        <ul class="product-action">
                          <?php 
                            if(check_user_login() && $ci->is_favorite($this->session->userdata('user_id'), $row->id)){
                              ?>
                              <li><a href="" class="btn_wishlist" data-id="<?=$row->id?>" data-toggle="tooltip" title="Remove to Wishlist" style="background-color: #ff5252"><i class="ion-android-favorite-outline"></i></a></li>
                              <?php
                            }
                            else if($ci->check_cart($row->id,$user_id)){
                              ?>
                              <li><a href="javascript:void(0)" data-toggle="tooltip" title="Already in Cart"><i class="ion-android-favorite-outline"></i></a></li>
                              <?php
                            } 
                            else{
                              ?>
                              <li><a href="" class="btn_wishlist" data-id="<?=$row->id?>" data-toggle="tooltip" title="Add to Wishlist"><i class="ion-android-favorite-outline"></i></a></li>
                              <?php
                            } 
                          ?>

                          <li><a href="" class="btn_quick_view" data-id="<?=$row->id?>" title="Quick View"><i class="ion-android-expand"></i></a></li>
                        </ul>
                      </div>
                      <div class="product-content">
                        <h2>
                          <a href="<?php echo site_url('product/'.$row->product_slug); ?>" title="<?=$row->product_title?>">
                             <?php 
                                if(strlen($row->product_title) > 18){
                                  echo substr(stripslashes($row->product_title), 0, 18).'...';  
                                }else{
                                  echo $row->product_title;
                                }
                              ?>
                          </a>
                        </h2>
                        
                        <div class="product-price"> 
                           <?php 
                            if($row->you_save_amt!='0'){
                              ?>
                              <span class="new-price"><?=CURRENCY_CODE.' '.$row->selling_price?></span> 
                              <span class="old-price"><?=CURRENCY_CODE.' '.$row->product_mrp;?></span>
                              
                              <?php
                            }
                            else{
                              ?>
                              <span class="new-price"><?=CURRENCY_CODE.' '.$row->product_mrp;?></span>
                              <?php
                              
                            }
                          ?>

                          <div class="rating">
                            <?php 
                              for ($x = 0; $x < 5; $x++) { 
                                if($x < $row->rate_avg){
                                  ?>
                                  <i class="fa fa-star" style="color: #F9BA48"></i>
                                  <?php  
                                }
                                else{
                                  ?>
                                  <i class="fa fa-star"></i>
                                  <?php
                                }
                                
                              }
                            ?>
                          </div>

                          <?php 
                            if(!$ci->check_cart($row->id,$user_id)){
                              ?>
                              <a class="button add-btn btn_cart" data-id="<?=$row->id?>" data-maxunit="<?=$row->max_unit_buy?>" style="" href="javascript:void(0)" data-toggle="tooltip" title="Add to Cart">add to cart</a>
                              <?php
                            }
                            else{

                              $cart_id=$ci->get_single_info(array('product_id' => $row->id, 'user_id' => $user_id),'id','tbl_cart');

                              ?>
                              <a class="button add-btn btn_remove_cart" style="" href="<?php echo site_url('remove-to-cart/'.$cart_id); ?>" data-toggle="tooltip" title="Remove to Cart">remove to cart</a>
                              <?php
                            }
                          ?>
                           </div>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                </div>
              </div>
            </div>
		        
            <!-- For List View -->
            <div id="list-view" class="tab-pane fade">
              <div class="row">
                <div class="all-prodict-item-list pt-10"> 
                  <div class="row">
                    <?php

                      $ci =& get_instance();
                      foreach ($product_list as $key => $row) {

                        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

                        // $img_file='assets/images/products/'.$row->featured_image;

                        $img_file=$ci->_create_thumbnail('assets/images/products/',$row->product_slug,$row->featured_image,360,360);

                        $img_file2=$ci->_create_thumbnail('assets/images/products/',$row->id,$row->featured_image2,360,360);

                    ?>
                    <div class="col-md-12">
                      <div class="single-item">
                      <div class="product-img img-full">
                        <div class="col-md-4 col-sm-4"> <a href="<?php echo site_url('product/'.$row->product_slug); ?>" title="<?=$row->product_title?>"> <img class="first-img" src="<?=base_url().$img_file?>" alt=""> <img class="hover-img" src="<?=base_url().$img_file2?>" alt=""> </a>

                          <?php 
                            if($row->you_save_per!='0'){
                              echo '<span class="sicker">'.$row->you_save_per.$this->lang->line('per_off_lbl').'</span>';
                            }
                          ?>

                        </div>
                        <div class="col-md-8 col-sm-8">
                        <div class="product-content-2">
                          <h2>
                            <a href="<?php echo site_url('product/'.$row->product_slug); ?>" title="<?=$row->product_title?>">
                               <?php 
                                  if(strlen($row->product_title) > 70){
                                    echo substr(stripslashes($row->product_title), 0, 70).'...';  
                                  }else{
                                    echo $row->product_title;
                                  }
                                ?>
                            </a>
                          </h2>
                          <div class="product-price">
                            <?php 
                            if($row->you_save_amt!='0'){
                              ?>
                              <span class="new-price"><?=CURRENCY_CODE.' '.$row->selling_price?></span> 
                              <span class="old-price"><?=CURRENCY_CODE.' '.$row->product_mrp;?></span>
                              
                              <?php
                            }
                            else{
                              ?>
                              <span class="new-price"><?=CURRENCY_CODE.' '.$row->product_mrp;?></span>
                              <?php
                              
                            }
                          ?>
                          </div>
                          <div class="rating mb-15"> 

                            <?php 
                              for ($x = 0; $x < 5; $x++) { 
                                if($x < $row->rate_avg){
                                  ?>
                                  <i class="fa fa-star" style="color: #F9BA48"></i>
                                  <?php  
                                }
                                else{
                                  ?>
                                  <i class="fa fa-star"></i>
                                  <?php
                                }
                              }
                            ?>
                          </div>
                          <div class="product-discription">
                            <?php 
                              if(strlen($row->product_desc) > 200){
                                  echo substr(stripslashes($row->product_desc), 0, 200);  
                              }else{
                                  echo $row->product_desc;
                              }
                            ?>
                          </div>
                          <div class="pro-action-2 mt-10">
                          <ul class="product-cart-area-list">
                            <li>
                              <?php 
                                if(!$ci->check_cart($row->id,$user_id)){
                                  ?>
                                  <a class="action-btn big btn_cart" data-id="<?=$row->id?>" data-maxunit="<?=$row->max_unit_buy?>" style="" href="javascript:void(0)" data-toggle="tooltip" title="Add to Cart">add to cart</a>
                                  <?php
                                }
                                else{

                                  $cart_id=$ci->get_single_info(array('product_id' => $row->id, 'user_id' => $user_id),'id','tbl_cart');

                                  ?>
                                  <a class="action-btn big btn_remove_cart" style="" href="<?php echo site_url('remove-to-cart/'.$cart_id); ?>" data-toggle="tooltip" title="Remove to Cart">remove to cart</a>
                                  <?php
                                }
                              ?>

                            </li>

                            <li>
                              <?php 
                                if(check_user_login() && $ci->is_favorite($this->session->userdata('user_id'), $row->id)){
                                  ?>
                                  <a class="action-btn small" href="" class="btn_wishlist" data-id="<?=$row->id?>" data-toggle="tooltip" title="Remove to Wishlist"><i class="ion-android-favorite-outline"></i></a>

                                  <?php
                                }
                                else if($ci->check_cart($row->id,$user_id)){
                                  ?>

                                  <a class="action-btn small" href="javascript:void(0)" data-toggle="tooltip" title="Already in Cart"><i class="ion-android-favorite-outline"></i></a>

                                  <?php
                                } 
                                else{
                                  ?>

                                  <a class="action-btn small" href="" class="btn_wishlist" data-id="<?=$row->id?>" data-toggle="tooltip" title="Add to Wishlist"><i class="ion-android-favorite-outline"></i></a>

                                  <?php
                                } 
                              ?>

                              
                            </li>
                            <li>
                              <a class="action-btn small btn_quick_view" data-id="<?=$row->id?>" title="Quick View"><i class="ion-android-expand"></i></a>
                            </li>
                          </ul>
                          </div>
                        </div>
                        </div>
                      </div>
                      </div>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php 
          if(!empty($links)){
        ?>
        <div class="pagination pb-10">
          <?php 
              echo $links;  
          ?>
        </div>
        <?php } ?>
      </div>
      <?php }
      else{ ?>
      <div class="col-md-12 col-sm-12 col-xs-12 text-center">
        <p style="font-size: 2em"><strong>Sorry!</strong> no product found</p>
        <br/>
      </div>
      <?php } ?>
    </div>
  </div>
</div>