<?php 
  $this->load->view('site/layout/breadcrumb'); 
?>
<section class="contact-form-area mt-20 mb-30">
  	<div class="container">
    	<div class="row"> 
	      <?php 
	        $i=0;
	        $ci =& get_instance();
	        foreach ($offers_list as $key => $row) 
	        {
	        	$thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row->offer_image);

	          	$img_offer=base_url().$ci->_create_thumbnail('assets/images/offers/',$thumb_img_nm,$row->offer_image,370,210);
    
	      ?>
	      <!--//<?=base_url('offers/'.$row->offer_slug)?>-->
	      <div class="col-md-3 col-sm-3 mb-30">
	        <div class="single-offer">
	          <div class="offer-img img-full"> <img src="<?=$img_offer?>" alt="" style="height: auto"> </div>
	        </div>
	      </div>
	      <?php } ?>
	    </div>
	</div>
</section>
