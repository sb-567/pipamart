<?php 
  $this->load->view('site/layout/breadcrumb'); 

  $ci =& get_instance();
?>

<style type="text/css">
	.chosen-container-single .chosen-single div b {
		background: url(<?php echo base_url('assets/site_assets/img/chosen-sprite.png'); ?>) no-repeat 0px 10px;
	}
</style>

<section class="contact-form-area mt-20 mb-30">
	<div class="container">
	  <div class="row"> 
	    <div class="col-md-3"></div>
	    <div class="col-md-6">
	      <div class="contact-form-title">
	        <h2>Patner With Us</h2>
	      </div>
	      <div class="contact-form mb-30">
	          <!--<?php echo site_url('site/contact_form'); ?>-->
	        <form id="partner_form" action="<?php echo site_url('site/partner_form'); ?>" method="post">
				<div class="row">	
				<div class="contact-input wizard-form-field">
					<div class="col-md-6">
						<div class="wizard-form-input has-float-label">
							<input type="text" name="name" required="" placeholder="<?=$this->lang->line('name_place_lbl')?> *">
							<label><?=$this->lang->line('name_place_lbl')?></label>
						</div>	
					</div>
					<div class="col-md-6">
						<div class="wizard-form-input has-float-label">
						  <input type="number" name="phone" required="" placeholder="phone*">
						  <label>Phone</label>
						</div>
					</div>
					<div class="col-md-12">
						<div class="wizard-form-input has-float-label">
							<input type="email" name="email" required="" placeholder="Email*">
							<label>Email Id</label>
						</div>	
					</div>
					
					
					<div class="col-md-12">
						<div class="wizard-form-input has-float-label">
							<textarea name="message" required="" cols="40" rows="80" placeholder="<?=$this->lang->line('message_lbl')?> *"></textarea>
							<label><?=$this->lang->line('message_lbl')?></label>
						</div>	
					</div>
					
					<div class="col-md-6">
					    <div class=" checklabel">
						  <input type="checkbox" name="enquiry_for[]" value="Fashion" >
						  <label>Fashion</label>
						</div>
					</div>
					<div class="col-md-6">
					    <div class="checklabel">
						  <input type="checkbox" name="enquiry_for[]" value="Beauty & health" >
						  <label>Beauty & health</label>
						</div>
					</div>
					
					<div class="col-md-6">
					    <div class=" checklabel">
						  <input type="checkbox" name="enquiry_for[]" value="Grocery" >
						  <label>Grocery</label>
						</div>
					</div>
					<div class="col-md-6">
					    <div class="checklabel">
						  <input type="checkbox" name="enquiry_for[]" value="Home & Kitchen" >
						  <label>Home & Kitchen</label>
						</div>
					</div>
					
					
					<div class="col-md-6">
					    <div class=" checklabel">
						  <input type="checkbox" name="enquiry_for[]" value="Electronics" >
						  <label>Electronics</label>
						</div>
					</div>
					<div class="col-md-6">
					    <div class="checklabel">
						  <input type="checkbox" name="enquiry_for[]" value="Religious & Ceremonial" >
						  <label>Religious & Ceremonial </label>
						</div>
					</div>
					
					<div class="col-md-6">
					    <div class=" checklabel">
						  <input type="checkbox" name="enquiry_for[]" value="Pet Supplies" >
						  <label>Pet Supplies </label>
						</div>
					</div>
					<div class="col-md-6">
					    <div class="checklabel">
						  <input type="checkbox" name="enquiry_for[]" value="Farming & Gardening" >
						  <label>Farming & Gardening  </label>
						</div>
					</div>
					
					
					
					
				  </div>
			    </div>
	          <div class="contact-submit mt_40">
	            <button type="submit" class="form-button btn_send"><?=$this->lang->line('send_msg_btn')?></button>
	          </div>
	        </form>
	        <p class="form-messege"></p>
	      </div>
	    </div>
	    <div class="col-md-3"></div>
	  </div>
	</div>
</section>