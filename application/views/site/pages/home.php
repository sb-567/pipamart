<?php 
  
  if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->libraries_load_from=='local')
  {
    add_css(array('assets/site_assets/css/nivo-slider.css', 'assets/site_assets/css/slick.min.css'));

    add_footer_js(array('assets/site_assets/js/jquery.nivo.slider.js','assets/site_assets/js/jquery.countdown.min.js','assets/site_assets/js/slick.min.js'));
  }
  else if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->libraries_load_from=='cdn')
  {
    add_cdn_css(array('https://cdnjs.cloudflare.com/ajax/libs/jquery-nivoslider/3.2/nivo-slider.min.css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css'));

    add_footer_cdn_js(array('https://cdnjs.cloudflare.com/ajax/libs/jquery-nivoslider/3.2/jquery.nivo.slider.min.js','https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js','https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js'));
  }

  add_footer_js(array('assets/site_assets/js/nivo.slider.init.js', 'assets/site_assets/js/slick.init.js'));

  $ci =& get_instance();
?>

<style type="text/css">
  .nivo-controlNav{
    z-index: 16 !important; 
  }
  .nivoSlider a.nivo-imageLink{
    z-index: 15 !important; 
  }
</style>

   <?php
  // for hide/show slider 
   if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->home_slider_opt=='true')
   {
    ?>

    <!-- start slider container -->
<section class="pt_5">
  <div class="container-fluid">
    <div class="row">
      <div class="sec-title">
        <div class="col-lg-6 text-left">
          <div class="cat-title">
            <h3>Eco Brand Of Week</h3>
          
          </div>
        </div>
        <div class="col-lg-6 text-right">
          <a href="<?php echo base_url()."brand-of-the-week"; ?>">View all</a>
        </div>
      </div>
    </div>
    
  </div>
  <div class="container-fluid">
    <div class="row">
        <div class="one owl-carousel owl-theme">
         <?php 
        $i=0;
        foreach ($banner_list as $key => $row) 
        {
          $img_file=base_url().$ci->_create_thumbnail('assets/images/banner/',$row->banner_slug,$row->banner_image,1349,700);
      ?>
        <div class="col-md-12 item-col">
          <a href="<?=base_url('banners/'.$row->banner_slug)?>">
              <img src="<?=$img_file?>" class="banner_img" alt="" title="#<?=$row->id?>"/>
            </a>
          </div>
          <?php 
        }
      ?>
        
  </div>
    </div>
  </div>
</section>

<!-- 
    <section class="slider-area mb-50">
      <div class="slider-wrapper theme-default"> 
        <div id="slider" class="nivoSlider"> 
          <?php 
          $i=0;
          foreach ($banner_list as $key => $row) 
          {
            $img_file=base_url('assets/images/banner/'.$row->banner_image);

            /*$thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row->banner_image);

            $img_file=base_url().$ci->_create_thumbnail('assets/images/banner/',$thumb_img_nm,$row->banner_image,1350,422);*/
            ?>
            <a href="<?=base_url('banners/'.$row->banner_slug)?>">
              <img src="<?=$img_file?>" class="banner_img" alt="" title="#<?=$row->id?>"/>
            </a>
            <?php 
          }
          ?>
        </div>
      </div>
    </section> -->
    <!-- end slider container -->

<!--    <section class="disoff mb-10">-->
<!--    <div class="container-fluid">-->
<!--        <div class="row">-->
            
            
<!--                <div class="lbl">-->
<!--                    <marquee>-->
<!--                        <ul>-->
<!--                            <li><a href="#!">Sale- Discount upto 80% Off</a></li>-->
<!--                            <li><a href="#!">Sale- Discount upto 80% Off</a></li>-->
<!--                            <li><a href="#!">Sale- Discount upto 80% Off</a></li>-->
<!--                            <li><a href="#!">Sale- Discount upto 80% Off</a></li>-->
<!--                        </ul>-->
<!--                    </marquee>-->
            
<!--                </div>-->
            
            
<!--        </div>-->
<!--    </div>-->
<!--</section>-->




  <?php }else{ echo '<br/>';} ?>

  <?php
  // for hide/show brands 
  if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->home_brand_opt=='true' AND !empty($brands_list))
  {
    ?>

    <!-- categories container -->
<section class="mt_10 mb-0">
      <div class="container-fluid">
    <div class="row">
      <div class="sec-title">
        <div class="col-lg-6 text-left">
        
        <div class="cat-title">
            <h3>Shop by Category</h3>
          
          </div>
        </div>
        <div class="col-lg-6 text-right">
            
        <!--<a href="'.base_url('/category').'">'.$this->lang->line('view_all_lbl').'</a>-->
          <?php 
          if(count($category_list) > 2){
            
            echo ' <a href="'.base_url('/category').'">View all</a></div>';
          }
        ?>
          
        </div>
      </div>
    </div>
    
  </div>
  <div class="container-fluid">
    
    <div class="row">
       <div class="category-slider owl-carousel owl-theme">
      <?php 
        $i=0;
        
        foreach ($category_list as $key => $row) 
        {
          $img_file=base_url().$ci->_create_thumbnail('assets/images/category/',$row->category_slug,$row->category_image,400,300);

          $counts=$ci->getCount('tbl_sub_category', array('category_id' => $row->id, 'status' => '1'));

          if($counts > 0)
          {
            $url=base_url('category/'.$row->category_slug);  
          }
          else{
            $url=base_url('category/products/'.$row->id);
          }
        ?>
      <div class="col-md-12 item-col">
        <div class="single-offer">
          <div class="all_categori_list img-full"> 
            <a href="<?=$url?>"> 
              <img src="<?=$img_file?>" alt="Category" style="height: auto">  
              <span>
                <?php 
                  if(strlen($row->category_name) > 30){
                    echo substr(stripslashes($row->category_name), 0, 30).'...';  
                  }else{
                    echo $row->category_name;
                  }
                ?>
              </span>
            </a>
          </div>
        </div>
      </div>   
      <?php } ?>  
      </div> 
    </div>
  </div>
</section>
    <!-- end categories container -->

  <?php } ?>

  
  

<section class="dealday">
	<div class="container-fluid">
		<div class="row">
			<div class="sec-title">
				<div class="col-lg-6 text-left">
				<h2>Deal Of the Day / Flash Sales</h2>
				</div>
				<div class="col-lg-6 text-right">
					<a href="#">View all</a>
				</div>
			</div>
		</div>
		
	</div>
	<div class="deal">
		<div class="container-fluid">
		  <div class="three owl-carousel owl-theme">
		      
        <?php 
        
        foreach($todays_deal as $today){
          $img_file = "";
          $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $today->featured_image);
          $img_file=$ci->_create_thumbnail('assets/images/products/',$thumb_img_nm,$today->featured_image,300,300);
         ?>
         <a href="<?php echo base_url().'product/'.$today->product_slug; ?>">
      		  <div class="item">
      			<h3><?php echo $today->category_name; ?></h3>
      			<span><?php
             if(strlen($today->product_title) > 25){
                                  echo substr(stripslashes($today->product_title), 0, 22).'...';  
                                }else{
                                  echo $today->product_title;
                                }
                                 // echo $today->product_title; 
            ?></span>
      			<img src="<?php echo base_url().$img_file; ?>" class="img-responsive" >
      			<h5>Rs <?php echo $today->selling_price; ?> (Mrp- Rs <?php echo $today->product_mrp; ?> / <?php echo $today->you_save_per; ?>% Off)*</h5>
      			<h6>Time Left < <?php
            // $date1 = new DateTime(date('Y-m-d H:i:s'));
            // $midnight = date("Y-m-d 23:59:59");
            // $date2 = new DateTime(date('Y-m-d H:i:s', strtotime($midnight)));
            //  echo $date1->diff($date2)->hours.":".$date1->diff($date2)->minutes.":".$date1->diff($date2)->seconds; 
            
            $timenow = date('Y-m-d H:i:s');
            $midnight = date('Y-m-d 47:59:59');
            $diff = strtotime($midnight)-strtotime($timenow);
            echo gmdate("H:i:s", $diff);
             ?></h6>
      	    </div>
          </a>
          <?php } ?>

    	    <!-- <div class="item">
    			<h3>Ecotattva</h3>
    			<span>Khadi Saree</span>
    			<img src="<?php base_url() ?>assets/images/c1.jpg" class="img-responsive" >
    			<h5>Rs 500 (Mrp- Rs 2500 / 80% Off)*</h5>
    			<h6>Time Left > 01:50:20</h6>
    	    </div>
    	    <div class="item">
    			<h3>Ecotattva</h3>
    			<span>Khadi Saree</span>
    			<img src="<?php base_url() ?>assets/images/c1.jpg" class="img-responsive" >
    			<h5>Rs 500 (Mrp- Rs 2500 / 80% Off)*</h5>
    			<h6>Time Left > 01:50:20</h6>
    	    </div>

    	    <div class="item">
    			<h3>Ecotattva</h3>
    			<span>Khadi Saree</span>
    			<img src="<?php base_url() ?>assets/images/c1.jpg" class="img-responsive" >
    			<h5>Rs 500 (Mrp- Rs 2500 / 80% Off)*</h5>
    			<h6>Time Left > 01:50:20</h6>
    	    </div> -->

  	 </div>
  	</div>
  </div>
</section>

  

 <!-- offer container -->
<div class="offer-area mt_10">
    <div class="container-fluid">
		<div class="row">
			<div class="sec-title">
				<div class="col-lg-6 text-left">
				
				<div class="cat-title">
            <h3><?=$this->lang->line('offer_lbl')?></h3>
          
          </div>
				</div>
				<div class="col-lg-6 text-right">
					<a href="#">View all</a>
				</div>
			</div>
		</div>
		
	</div>
  <div class="container-fluid">
    
    <div class="row">
        <div class="product-offers  owl-carousel">
        <?php 
          $i=0;
          foreach ($offers_list as $key => $row) 
          {
            $img_offer=base_url().$ci->_create_thumbnail('assets/images/offers/',$row->offer_slug,$row->offer_image,370,210);
        ?>
       <div class="col-md-12 item-col">
          <div class="single-offer  h-prod">
              <!--<?=base_url('offers/'.$row->offer_slug)?>-->
            <div class="offer-img img-full"> <img src="<?=$img_offer?>" alt="product-offers" style="height: auto"> </div>
          </div>
        </div>
      
        <?php } ?>
        </div>
    </div>
  </div>
</div>



  <?php 
  if(!empty($weekly_offer))
  {
?>
<!-- categories container -->
<section class="mb-0">
  <div class="container">
    <div class="row">
      <div class="col-md-12"> 
        <div class="section-title1-border">
          <div class="section-title1">
            <h3>Weekly Offers</h3>
          </div>     
        </div>
      </div>
    </div>
    <div class="row">
      
                    <?php

                    $ci =& get_instance();
                    foreach ($weekly_offer as $key => $row) {

                      $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

                      // $img_file='assets/images/products/'.$row->featured_image;

                      $img_file=$ci->_create_thumbnail('assets/images/products/',$row->product_slug,$row->featured_image,300,200);

                     if(file_exists('assets/images/products/'.$row->featured_image2)){
                      $img_file2=$ci->_create_thumbnail('assets/images/products/',$row->id,$row->featured_image2,300,200);
                     }
                     else{
                         $img_file2='';
                     } 
                      
                      
                  ?>
                  <div class="col-md-3 col-sm-3 col-xs-12">
                    <div class="single-product h-prod">
                      <div class="product-img"><div class="on-sale">offer </div> <a href="<?php echo site_url('product/'.$row->product_slug); ?>" title="<?=$row->product_title?>" target="_blank">
                        <img class="first-img" src="<?=base_url().$img_file?>" alt=""> 
                        <?php if($img_file2!=''){?>  <img class="hover-img" src="<?=base_url().$img_file2?>"> <?php } ?> </a>
                        <ul class="product-action">
                          <?php 
                            if(check_user_login() && $ci->is_favorite($this->session->userdata('user_id'), $row->id)){
                              ?>
                              <li><a href="" class="btn_wishlist" data-id="<?=$row->id?>" data-toggle="tooltip" title="<?=$this->lang->line('remove_wishlist_lbl')?>" style="background-color: #ff5252"><i class="ion-android-favorite-outline"></i></a></li>
                              <?php
                            }
                            else if($ci->check_cart($row->id,$user_id)){
                              ?>
                              <li><a href="javascript:void(0)" data-toggle="tooltip" title="<?=$this->lang->line('already_cart_lbl')?>"><i class="ion-android-favorite-outline"></i></a></li>
                              <?php
                            } 
                            else{
                              ?>
                              <li><a href="" class="btn_wishlist" data-id="<?=$row->id?>" data-toggle="tooltip" title="<?=$this->lang->line('add_wishlist_lbl')?>"><i class="ion-android-favorite-outline"></i></a></li>
                              <?php
                            } 
                          ?>

                          <li><a href="" class="btn_quick_view" data-id="<?=$row->id?>" title="<?=$this->lang->line('quick_view_lbl')?>"><i class="ion-android-expand"></i></a></li>
                        </ul>
                      </div>
                      <div class="product-content">
                        <h2>
                          <a href="<?php echo site_url('product/'.$row->product_slug); ?>" title="<?=$row->product_title?>" target="_blank">
                             <?php 
                                if(strlen($row->product_title) > 16){
                                  echo substr(stripslashes($row->product_title), 0, 16).'...';  
                                }else{
                                  echo $row->product_title;
                                }
                              ?>
                          </a>
                        </h2>
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
                        <div class="product-price"> 
                          <?php 
                            if($row->you_save_amt!='0'){
                              ?>
                              <span class="new-price"><?=CURRENCY_CODE.' '.$row->selling_price?>/<?php echo $row->unit_type;?></span> 
                              <span class="old-price"><?=CURRENCY_CODE.' '.$row->product_mrp;?></span>
                              
                              <?php
                            }
                            else{
                              ?>
                              <span class="new-price"><?=CURRENCY_CODE.' '.$row->product_mrp;?>/<?php echo $row->unit_type;?></span>
                              <?php
                              
                            }
                          ?>

                          <?php 
                            if(!$ci->check_cart($row->id,$user_id)){
                              ?> 
                              <div>
                                  <div class="qty-cart">
                    <div class="quantity buttons_added">
                      <input type="button" value="-" class="minus minus-btn">
                      <input id="quantity_change_<?=$row->id;?>" type="number" step="1" name="quantity" value="1"  min="1" max="<?=$row->max_unit_buy ? $row->max_unit_buy: '1'?>" onkeypress="return isNumberKey(event)"class="input-text qty text">
                      <input type="button" value="+" class="plus plus-btn">
                    </div>
                  </div>
                                  <button class="button quantity-button btn-add-cartx mt-5" data-product_id="<?=$row->id?>" data-product_qty="1"><?php if($ci->check_cart($row->id,$this->session->userdata('user_id'))){ echo $this->lang->line('update_cart_btn'); }else{ echo $this->lang->line('add_cart_btn'); } ?></button>
                          
                            </div>
                           
                            <?php
                            }
                            else{
                              $cart_id=$ci->get_single_info(array('product_id' => $row->id, 'user_id' => $user_id),'id','tbl_cart');
                              ?>
                              <a class="button quantity-button btn_remove_cart btn-rx mt-5" style="" href="<?php echo site_url('remove-to-cart/'.$cart_id); ?>" data-toggle="tooltip" title="<?=$this->lang->line('remove_cart_lbl')?>"><?=$this->lang->line('remove_cart_btn')?></a>
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
       </section>
      
      

 <?php } ?>
 
 
 <?php if(isset($web_settings) && !empty($web_settings->eco_youtube_embed_code)){ ?>
 <section class="ecoear pt_5 mt_20">
	<div class="container-fluid">
		<div class="row">
			<div class="sec-title">
				<div class="col-lg-6 text-left">
				<h2>Eco Warrior Of The Week</h2>
				</div>
				<div class="col-lg-6 text-right">
					<!-- <a href="#">View all</a> -->
				</div>
			</div>
		</div>
		
	</div>
	<div class="eco">
		<div class="container-fluid">
		<div class="five owl-carousel owl-theme">
    		<div class="item">
    			<div class="col-md-5">
    				<iframe width="100%" height="315" src="https://www.youtube.com/embed/<?php echo $web_settings->eco_youtube_embed_code; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    			</div>
    			<div class="col-md-7">
    				<div class="con">
              <?php echo $web_settings->eco_warrior_content; ?>
    					
    				</div>

    			</div>
    	    </div>
    	    
    	    <div class="item">
    			<div class="col-md-5">
    				<iframe width="100%" height="315" src="https://www.youtube.com/embed/<?php echo $web_settings->eco_youtube_embed_code1; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    			</div>
    			<div class="col-md-7">
    				<div class="con">
              <?php echo $web_settings->eco_warrior_content1; ?>
    					
    				</div>

    			</div>
    	    </div>

    	   
    	    

	</div>
	</div>
</section>
<?php } ?>
