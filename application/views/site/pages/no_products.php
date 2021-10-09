<?php 
  $this->load->view('site/layout/breadcrumb'); 
?>

<div class="product-list-grid-view-area mt-20">
  	<div class="container">
    	<div class="row">
    		<center style="margin-bottom: 50px;">
		        <img src="<?=base_url('assets/img/no_data.png')?>">
	            <h2 style="font-size: 18px;font-weight: 500;color: #888;"><?=$this->lang->line('no_data')?></h2>
	            <br/>
		        <a href="<?=base_url('/')?>"><img src="<?=base_url('assets/images/continue-shopping-button.png')?>"></a>
		     </center>
    	</div>
 	</div>
</div>