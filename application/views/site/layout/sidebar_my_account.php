<div class="widget widget-shop-categories">
  <h3 class="widget-shop-title"><?=$this->lang->line('myaccount_lbl')?></h3>
  	<div class="widget-content">
        <ul class="product-categories my_profile_detail_widget">
        	<li>
                <i class="fa fa-angle-right"></i>
            	<a class="rx-default <?php if(isset($current_page) && strcmp($current_page,$this->lang->line('my_profile_lbl'))==0){ echo 'active';} ?>" href="<?=base_url('/my-account')?>"><?=$this->lang->line('my_profile_lbl')?></a>
            </li>
            <?php 
                if(strcmp($this->session->userdata('user_type'), 'Normal')==0)
                {
            ?>
            <li>
                <i class="fa fa-angle-right"></i>
                <a class="rx-default <?php if(isset($current_page) && strcmp($current_page,$this->lang->line('change_password_lbl'))==0){ echo 'active';} ?>" href="<?=base_url('/change-password')?>"><?=$this->lang->line('change_password_lbl')?></a>
            </li>
            <?php } ?>
            <li>
                <i class="fa fa-angle-right"></i>
            	<a class="rx-default <?php if(isset($current_page) && strcmp($current_page,$this->lang->line('addresses_lbl'))==0){ echo 'active';} ?>" href="<?=base_url('/my-addresses')?>"><?=$this->lang->line('addresses_lbl')?></a>
            </li>
            <li>
                <i class="fa fa-angle-right"></i>
            	<a class="rx-default <?php if(isset($current_page) && strcmp($current_page,$this->lang->line('saved_bank_lbl'))==0){ echo 'active';} ?>" href="<?=base_url('/saved-bank-accounts')?>"><?=$this->lang->line('saved_bank_lbl')?></a>
            </li>
            <li>
                <i class="fa fa-angle-right"></i>
            	<a class="rx-default <?php if(isset($current_page) && strcmp($current_page,$this->lang->line('myreviewrating_lbl'))==0){ echo 'active';} ?>" href="<?=base_url('/my-reviews')?>"><?=$this->lang->line('myreviewrating_lbl')?></a>
            </li>
            <li>
                <i class="fa fa-angle-right"></i>
                <a class="rx-default" href="<?=base_url('/my-orders')?>"><?=$this->lang->line('myorders_lbl')?></a>
            </li>
        </ul>
	</div>
</div>