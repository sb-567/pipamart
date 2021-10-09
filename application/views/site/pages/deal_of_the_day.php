<?php 
  $this->load->view('site/layout/breadcrumb'); 
  // print_r($contact_subjects);

  // print_r($settings_row);

  $ci =& get_instance();
?>
<section class="deal_of_the_day mt_40"> 
  <div class="container-fluid">
    <div class="row"> 
        
            <?php foreach($todays_deal as $today){
          $img_file = "";
          $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $today->featured_image);
          $img_file=$ci->_create_thumbnail('assets/images/products/',$thumb_img_nm,$today->featured_image,300,300);
         ?>
         <a href="<?php echo base_url().'product/'.$today->product_slug; ?>">
      		  <div class="col-md-3">
      		    <div class="content">
      		      
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
      		
             
             </div>
      	    </div>
          </a>
          <?php } ?>
        
    </div>
  </div>
</section>
    