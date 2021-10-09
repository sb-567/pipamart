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

<section class="contact-form-area mt-20 mb-30">
  <div class="container-fluid">
    <div class="row"> 
      <?php 
        $i=0;
        $ci =& get_instance();
        foreach ($sub_category_list as $key => $row) 
        {
          $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row->sub_category_image);

          $img_file=base_url().$ci->_create_thumbnail('assets/images/sub_category/',$thumb_img_nm,$row->sub_category_image,270,162);

      ?>
      <div class="col-md-3 col-sm-4 col-xs-6">
        <div class="single-offer">
          <div class="all_categori_list img-full"> 
            <a href="<?=site_url('category/'.$category_slug.'/'.$row->sub_category_slug)?>" title="<?=$row->sub_category_name?>">          
              <img src="<?=$img_file?>" alt=""> 
              <span>
                <?php 
                  if(strlen($row->sub_category_name) > 17){
                    echo substr(stripslashes($row->sub_category_name), 0, 17).'...';  
                  }else{
                    echo $row->sub_category_name;
                  }
                ?>
              </span>
            </a>
          </div>
        </div>
      </div> 
      <?php } ?>      
    </div>
    <hr style="margin: 20px 0px" />
    <div class="row">
      <?php 
        foreach ($sub_category_list as $key => $row) 
        {

          if($row->show_on_off==0){
            continue;
          }

          $counts=$ci->getCount('tbl_product', array('sub_category_id' => $row->id, 'status' => '1'));

          if($counts <= 0)
          {
            continue;
          }

      ?>
      <section class="bestseller-product mb-30">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12"> 
              <div class="section-title1-border">
                <div class="section-title1">
                  <h3><?=$row->sub_category_name?></h3>
                  <?php 
                    if($counts > 5){
                      echo '<div class="category_view_all" style="right: 100px"><a href="'.site_url('category/'.$category_slug.'/'.$row->sub_category_slug).'">View All</a></div>';
                    }
                  ?>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
              <div class="bestseller-product3 mb-30 owl-carousel">
                <?php 
                  $products=$ci->get_cat_sub_product($row->category_id, $row->id);

                ?>
                <?php 
                  foreach ($products as $key => $product_row) {

                    $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $product_row->featured_image);

                    $img_file=$ci->_create_thumbnail('assets/images/products/',$thumb_img_nm,$product_row->featured_image,210,210);

                    $img_file2=$ci->_create_thumbnail('assets/images/products/',$product_row->product_id,$product_row->featured_image2,210,210);

                ?>
                  <div class="col-md-12 ">     
                  <div class="single-product3">
                    <div class="product-img"> 
                      <a href="<?php echo site_url('product/'.$product_row->product_slug); ?>" title="<?=$product_row->product_title?>"> <img class="first-img" src="<?=base_url().$img_file?>"> <img class="hover-img" src="<?=base_url().$img_file2?>"> 
                      </a>
                      <ul class="product-action">
                
                        <?php 
                          if(check_user_login() && $ci->is_favorite($this->session->userdata('user_id'), $product_row->product_id)){
                            ?>
                            <li><a href="" class="btn_wishlist" data-id="<?=$product_row->product_id?>" data-toggle="tooltip" title="<?=$this->lang->line('remove_wishlist_lbl')?>" style="background-color: #ff5252"><i class="ion-android-favorite-outline"></i></a></li>
                            <?php
                          }
                          else if($ci->check_cart($product_row->product_id,$this->session->userdata('user_id'))){
                            ?>
                            <li><a href="javascript:void(0)" data-toggle="tooltip" title="Already in Cart"><i class="ion-android-favorite-outline"></i></a></li>
                            <?php
                          } 
                          else{
                            ?>
                            <li><a href="" class="btn_wishlist" data-id="<?=$product_row->product_id?>" data-toggle="tooltip" title="<?=$this->lang->line('add_wishlist_lbl')?>"><i class="ion-android-favorite-outline"></i></a></li>
                            <?php
                          } 
                        ?>

                        <li><a href="" class="btn_quick_view" data-id="<?=$product_row->product_id?>" title="<?=$this->lang->line('quick_view_lbl')?>"><i class="ion-android-expand"></i></a></li>

                      </ul>
                    </div>
                    <div class="product-content">
                      <h2>
                        <a href="<?php echo site_url('product/'.$product_row->product_slug); ?>">
                          <?php 
                            if(strlen($product_row->product_title) > 20){
                              echo substr(stripslashes($product_row->product_title), 0, 20).'...';  
                            }else{
                              echo $product_row->product_title;
                            }
                          ?>
                        </a>
                      </h2>
                      <div class="product-price">
                        <div class="price_holder">  
                        <?php 
                          if($product_row->you_save_amt!='0'){
                            ?>
                            <span class="new-price"><?=CURRENCY_CODE.' '.number_format($product_row->selling_price, 2)?></span> 
                            <span class="old-price"><?=CURRENCY_CODE.' '.number_format($product_row->product_mrp, 2);?></span>
                            <?php
                          }
                          else{
                            ?>
                            <span class="new-price"><?=CURRENCY_CODE.' '.number_format($product_row->product_mrp, 2);?></span>
                            <?php
                            
                          }
                        ?>
                        </div>
                        

                
                      </div>
                    </div>
                  </div>
                  </div>
                <?php } ?>
              </div>
          </div>
        </div>
      </section>
      <?php } ?>
    </div>
  </div>
</section>