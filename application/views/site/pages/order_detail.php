<?php 
  $this->load->view('site/layout/breadcrumb'); 

  $ci =& get_instance();

  $is_order_claim=$ci->is_order_claim($my_order[0]->id);

  $dataClaimStuff=array('bank_err' => $this->lang->line('cancel_ord_bank_err'), 'please_wait_lbl' => $this->lang->line('please_wait_lbl'), 'done_lbl' => $this->lang->line('done_lbl'));

?>

<style type="text/css">
	.price_details_tbl td{
		padding: 3px 0px;
	}
	.price_details_tbl td:first-child { font-weight: 500 };
</style>

<div class="wishlist-table-area mt-20 mb-50">
	<div class="container">
	  <div class="slingle_product_block row">
		  <div class="col-md-4 col-sm-6 col-xs-12 slingle_item_address_part single_bdr_right bdr_top0">
			<div class="single_address_list">
			  <span class="delivery_address_title"><?=$this->lang->line('ord_details_section_lbl')?> :-</span>
			  <div class="address_detail_product_item">
				<span><?=$this->lang->line('ord_id_lbl')?>: <?=$my_order[0]->order_unique_id?> </span>
				<p><?=$this->lang->line('ord_on_lbl')?>: <?=date("M d, Y",$my_order[0]->order_date)?> </p>
				<?php
                  $_lbl_class='label-primary';
                  $_lbl_title=$ci->get_status_title($my_order[0]->order_status);

                  switch ($my_order[0]->order_status) {
                      case '1':
                          $_lbl_class='label-default';
                          break;
                      case '2':
                          $_lbl_class='label-primary';
                          break;
                      case '3':
                          $_lbl_class='label-warning';
                          break;

                      case '4':
                          $_lbl_class='label-success';
                          break;
                      
                      default:
                          $_lbl_class='label-danger';
                          break;
                  }

                ?>

				<p><?=$this->lang->line('ord_status_lbl')?>: <label class="label <?=$_lbl_class?>"><?=$_lbl_title?></label></p>
				<?php 
					echo $my_order[0]->order_status==4 ? '<p>'.$this->lang->line('delivery_on_lbl').': '.date("M jS, y",$my_order[0]->delivery_date).' </p><button type="button" class="form-button btn_download" data-id="'.$my_order[0]->order_unique_id.'">'.$this->lang->line('download_invoice_btn').'</button>' : '<p>'.$this->lang->line('expected_delivery_lbl').': '.date("M jS, y",$my_order[0]->delivery_date).' </p>';
				?>
				<?php
					if($is_order_claim){
						echo '<a href="javascript:void(0)" class="form-button cancle_order_btn btn_claim" style="margin-top:10px" data-order="'.$my_order[0]->id.'" data-product="0">
							'.$this->lang->line('claim_refund_btn').'
							</a>';
					}
					if($my_order[0]->order_status < 4){
						echo '<a href="javascript:void(0)" class="form-button cancle_order_btn product_cancel" style="margin-top:10px" data-order="'.$my_order[0]->id.'" data-product="0" data-unique="'.$my_order[0]->order_unique_id.'" data-gateway="'.$ci->get_single_info(array('order_id' => $my_order[0]->id),'gateway','tbl_transaction').'">
							'.$this->lang->line('cancel_ord_btn').'
							</a>';
					}
				?>
				
			  </div>
			</div>
		  </div>
		  <div class="col-md-4 col-sm-6 col-xs-12 slingle_item_address_part single_bdr_right bdr_top0">
			<div class="single_address_list" style="width: 100%">
			  <span class="delivery_address_title"><?=$this->lang->line('ord_payment_section_lbl')?> :-</span>
			  <div class="address_detail_product_item">
			  	<table class="price_details_tbl" cellpadding="50" cellspacing="20" width="100%">
			  		<tr>
			  			<td><?=$this->lang->line('total_amt_lbl')?>:</td>
			  			<td class="text-right"><?=CURRENCY_CODE.' '.number_format($my_order[0]->total_amt, 2)?></td>
			  		</tr>
			  		<?php 
			  			if(!empty($refund_data))
			  			{
			  				$cancel_ord_amt=array_sum(array_column($refund_data,'refund_pay_amt'));
			  				?>
			  				<tr>
					  			<td><?=$this->lang->line('cancel_ord_amt_lbl')?>:</td>
					  			<td class="text-right">- <?=CURRENCY_CODE.' '.number_format($cancel_ord_amt, 2)?></td>
					  		</tr>
			  				<?php
			  			}
			  		?>
			  		<tr>
			  			<td><?=$this->lang->line('discount_lbl')?>:</td>
			  			<td class="text-right">- <?=CURRENCY_CODE.' '.number_format($my_order[0]->discount_amt, 2)?></td>
			  		</tr>
			  		<tr>
			  			<td><?=$this->lang->line('delivery_charge_lbl')?>:</td>
			  			<td class="text-right">+ <?=CURRENCY_CODE.' '.number_format($my_order[0]->delivery_charge, 2)?></td>
			  		</tr>
			  		<tr>
			  			<td><?=$this->lang->line('payable_amt_lbl')?>:</td>
			  			<td class="text-right"><?=CURRENCY_CODE.' '.number_format($my_order[0]->new_payable_amt, 2)?></td>
			  		</tr>
			  	</table>
				<p style="font-size: 16px;margin-top: 5px"><?=$this->lang->line('payment_mode_lbl')?>: <strong><?=strtoupper($this->db->get_where('tbl_transaction', array('order_unique_id' => $my_order[0]->order_unique_id))->row()->gateway)?></strong></p>
				<p style="font-size: 16px;margin-top: 5px"><?=$this->lang->line('payment_id_lbl')?>: <?=$this->db->get_where('tbl_transaction', array('order_unique_id' => $my_order[0]->order_unique_id))->row()->payment_id?></p>
				
			  </div>
			</div>
		  </div>
		  <div class="col-md-4 col-sm-6 col-xs-12 slingle_item_address_part bdr_top0">
			<div class="single_address_list">
			  <span class="delivery_address_title"><?=$this->lang->line('ord_address_section_lbl')?> :-</span>
			  <div class="address_detail_product_item">
				<span><?=$my_order[0]->name?> </span>
				<p><?=$my_order[0]->email?></p>
				<div class="product_address">
					<?=$my_order[0]->building_name.', '.$my_order[0]->road_area_colony.', '.$my_order[0]->city.', '.$my_order[0]->district.', '.$my_order[0]->state.' - '.$my_order[0]->pincode;?>
				</div>
				<span class="user_contact"><?=$this->lang->line('phone_no_lbl')?> : <?=$my_order[0]->mobile_no?></span>
			  </div>
			</div>
		  </div>
		  <div class="clearfix"></div>
		  <?php 
		  	foreach ($my_order as $key => $value) {

		  		$thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $ci->get_single_info(array('id' => $value->product_id),'featured_image','tbl_product'));

		  		$img_file=$ci->_create_thumbnail('assets/images/products/',$thumb_img_nm,$ci->get_single_info(array('id' => $value->product_id),'featured_image','tbl_product'),200,200);

		  ?>
		  <div class="col-md-12 details_part_product_img slingle_item_address_part">
			  <div class="row">
				<div class="col-md-1 col-sm-2 col-xs-4">
					<div class="product_img_part">
						<a href="<?php echo site_url('product/'.$ci->get_single_info(array('id' => $value->product_id),'product_slug','tbl_product')); ?>" target="_blank"><img src="<?=base_url().$img_file?>" alt=""></a>	
					</div>					
				</div>

				<div class="col-md-5 col-sm-5 col-xs-8">
				  <a href="<?php echo site_url('product/'.$ci->get_single_info(array('id' => $value->product_id),'product_slug','tbl_product')); ?>" title="<?=$value->product_title?>" target="_blank">
				  	<?php 
					  	if(strlen($value->product_title) > 60){
					  		echo substr(stripslashes($value->product_title), 0, 60).'...';  
					  	}else{
					  		echo $value->product_title;
					  	}
					  	?>
				  </a>				  
				  <div><?=$this->lang->line('price_lbl')?>: <?=CURRENCY_CODE.' '.number_format($value->product_price, 2)?></div>
				  <div><?=$this->lang->line('qty_lbl')?>: <?=$value->product_qty?></div>
				  <?php 
				  	if($value->product_size!='' AND $value->product_size!='0')
				  	{
				  		echo '<div>'.$this->lang->line('size_lbl').': '.$value->product_size.'</div>';
				  	}
				  ?>
				</div>

				<?php
					if($value->pro_order_status!='4' && $value->pro_order_status!='5'){
						?>
						<div class="col-md-5 col-sm-5 col-xs-12 col-md-offset-1 text-right">				 							
							<a href="javascript:void(0)" class="form-button pull-right btn-danger product_cancel" data-order="<?=$value->order_id?>" data-product="<?=$value->product_id?>" data-unique="<?=$value->order_unique_id?>" data-gateway="<?=$ci->get_single_info(array('order_id' => $value->order_id),'gateway','tbl_transaction')?>"><?=$this->lang->line('cancel_btn')?></a>
						</div>
						<?php
					}
					else if($value->pro_order_status=='5'){
						$cancelled_on=$ci->get_single_info(array('order_id' => $value->order_id, 'product_id' => $value->product_id),'created_at','tbl_refund');
						?>
						<div class="col-md-6 col-sm-5 col-xs-12">
							<span style="color: red;"><?=$this->lang->line('product_cancelled_on_lbl')?> <?=date('d-m-Y h:i A',$cancelled_on)?></span>
							<br>
							<strong><?=$this->lang->line('reason_lbl')?>:</strong>
							<?php echo '<label style="">'.$ci->get_single_info(array('order_id' => $value->order_id, 'product_id' => $value->product_id),'refund_reason','tbl_refund').'</label>';?>
							<?php 
								if($ci->get_single_info(array('order_id' => $value->order_id, 'product_id' => $value->product_id),'gateway','tbl_refund')!='cod')
								{
									switch ($ci->get_single_info(array('order_id' => $value->order_id, 'product_id' => $value->product_id),'request_status','tbl_refund')) {
									  case '0':
										  $_lbl_title=$this->lang->line('refund_pending_lbl');
										  $_lbl_class='label-warning';
										  break;
									  case '2':
										  $_lbl_title=$this->lang->line('refund_process_lbl');
										  $_lbl_class='label-primary';
										  break;
									  case '1':
										  $_lbl_title=$this->lang->line('refund_complete_lbl');
										  $_lbl_class='label-success';
										  break;
									  case '-1':
										  $_lbl_title=$this->lang->line('refund_wait_lbl');
										  $_lbl_class='btn-danger';
								  }
								  ?>
									<br/>
									<?=$this->lang->line('refund_status_lbl')?>: <label class="label <?=$_lbl_class?>"><?=$_lbl_title?></label>
									<?php 
										if(!$is_order_claim)
										{
											if($ci->get_single_info(array('order_id' => $value->order_id, 'product_id' => $value->product_id),'request_status','tbl_refund')=='-1')
											{
												echo '<a href="javascript:void(0)" class="form-button pull-right btn-danger btn_claim" data-order="'.$value->order_id.'" data-product="'.$value->product_id.'">'.$this->lang->line('claim_refund_btn').'</a>';
											}
										}
								}
							?>
						</div>
						<?php
					}
				?>

			  </div>
			  <hr style="margin: 10px 0px">
			  <div class="row">
			  	<?php 
					if($value->pro_order_status!='5')
					{
					?>
						<div class="product_timeline_block" style="box-shadow: none;">
							<section class="cd-horizontal-timeline">
							  	<div class="timeline">
							  	  <?php

							  	  	foreach ($status_titles as $key1 => $value1) {
							  	  		if($value1->id=='5')
							  	  			break;
							  	  ?>
								  <div class="dot <?php if($value1->id<=$value->pro_order_status){ echo 'active_dot';}else{ echo 'deactive_dot'; } ?>" id="<?=$value1->id?>" style="<?php if($value->pro_order_status < $value1->id){ echo 'pointer-events: none;cursor: default;';}?>">
								  	<span></span>
									<date style="width: max-content"><?=$value1->title?></date>
								  </div>
								  <?php } ?>
								  <?php 
								  	if($value->pro_order_status=='4'){
								  		?>
								  		<div class="inside" style="width: 100% !important"></div>
								  		<?php
								  	}
								  	else{
								  		?>
								  		<div class="inside" style="width: <?=(20*$value->pro_order_status+2)?>% !important"></div>
								  		<?php
								  	}
								  ?>
								  
								</div>

								<?php 
									$display_first=true;
									foreach ($status_titles as $key1 => $value1) {

										$where=array('order_id' => $my_order[0]->order_id,'status_title' => $value1->id);
								?>
								<?php 
									if($ci->get_single_info($where,'status_desc','tbl_order_status')!='')
									{
										?>
										<article class="modal <?=$value1->id?>" style="<?php if($value1->id==$value->pro_order_status){ echo 'display: block';}?>">
										  <date><?=date("M jS,y",$ci->get_single_info($where,'created_at','tbl_order_status'))?></date>
										  <h2><?=$value1->title?></h2>
										  <p><?=$ci->get_single_info($where,'status_desc','tbl_order_status')?></p>
										</article>
										<?php
									}
									else{
										?>
										<article class="modal <?=$value1->id?>" style="<?php echo $display_first ? 'display: block' : '';  ?>">
											<h2><?=$this->lang->line('no_ord_status_lbl')?></h2>
										</article>
										<?php
									}
								?>
								
								<?php $display_first=false; } ?>
							</section>
						</div>
					<?php 
					}
					else{
						?>
						<div class="product_timeline_block">
							<section class="cd-horizontal-timeline">
							  	<div class="timeline">
							  	  <?php

							  	  	foreach ($status_titles as $key2 => $value2) {

							  	  		if($value2->id!='5' && $value2->id!='1')
							  	  			continue;
							  	  ?>
								  <div class="dot <?php if($value2->id<=$value->pro_order_status){ echo 'active_dot';}else{ echo 'deactive_dot'; } ?>" id="<?=$value2->id?>">
								  	<span></span>
									<date style="width: max-content"><?=$value2->title?></date>
								  </div>
								  <?php } ?>
								  <div class="inside" style="width: <?=(20*($value->pro_order_status-3))+2?>% !important"></div>
								</div>

								<?php 
									$display_first=true;
									foreach ($status_titles as $key2 => $value2) {

										$where=array('order_id' => $my_order[0]->order_id,'status_title' => $value2->id);

								?>
								<?php 
									if($ci->get_single_info($where,'status_desc','tbl_order_status')!='')
									{
										?>
										<article class="modal <?=$value2->id?>" style="<?php if($value2->id==$value->pro_order_status){ echo 'display: block';}?>">
										  <date><?=date("M jS,y",$ci->get_single_info($where,'created_at','tbl_order_status'))?></date>
										  <h2><?=$value2->title?></h2>
										  <p><?=$ci->get_single_info($where,'status_desc','tbl_order_status')?></p>
										</article>
										<?php
									}
									else{
										?>
										<article class="modal <?=$value2->id?>" style="<?php echo $display_first ? 'display: block' : '';  ?>">
											<h2><?=$this->lang->line('no_ord_status_lbl')?></h2>
										</article>
										<?php
									}
								?>
								
								<?php $display_first=false; } ?>
							</section>
						</div>
						<?php
						}
					?>
			  </div>
			</div>
		  <?php } ?>		  
		</div>
		
	</div>

	<div id="orderCancel" class="modal" style="z-index: 9999999;background: rgba(0,0,0,0.5);overflow-y: auto;">
	  <div class="modal-dialog modal-confirm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <img src="<?=base_url('assets/images/shopping-cancel-512.png')?>" style="width: 70px">
	        <h4 class="modal-title cancelTitle"><?=$this->lang->line('product_cancel_confirm_lbl')?></h4>
	        <h5><?=$this->lang->line('ord_id_lbl')?>: <span class="order_unique_id"></span></h5> 
	      </div>
	      <div class="modal-body" style="padding:0px;padding-top:20px;">
	      	<div class="msg_holder">
	      		
	      	</div>
	      	<form id="">
	      		<input type="hidden" name="order_id" value="">
	      		<input type="hidden" name="product_id" value="">
	      		<input type="hidden" name="gateway" value="">

	      		<div class="row">
	      			<div class="col-md-12">
	      				<div class="wizard-form-field">
		                    <div class="wizard-form-input has-float-label">
		                    	<textarea class="form-control" name="reason" rows="4" placeholder="<?=$this->lang->line('reason_place_lbl')?> *"></textarea>
		                    	<label><?=$this->lang->line('reason_place_lbl')?> *</label>
		                    </div>
		                </div>
	      			</div>
	      			<div class="col-md-12 bank_details" style="display: none">
	      				<div class="address_details_block">
	      					<?php 
	      						foreach ($bank_details as $key => $row_bank) {
	      					?>
		                    <div class="address_details_item">
					            <label class="container">
					              <input type="radio" name="bank_acc_id" class="address_radio" value="<?=$row_bank->id?>" <?php if($row_bank->is_default=='1'){ echo 'checked="checked"';} ?>>
					              <span class="checkmark"></span>
					            </label>
		            
					            <div class="address_list">
					              <span style="margin-bottom: 0px"><?=$row_bank->bank_name?> (<?=$this->lang->line('bank_acc_no_lbl')?> :<?=$row_bank->account_no?>)</span>
					              <p style="margin-bottom: 0px"><?=$this->lang->line('bank_type_lbl')?>: <?=ucfirst($row_bank->account_type)?> <br/> <?=$this->lang->line('bank_ifsc_lbl')?>: <?=$row_bank->bank_ifsc?></p>
					              <p style="margin-bottom: 10px"><?=$this->lang->line('holder_name_lbl')?>: <?=$row_bank->bank_holder_name?> <br/> <?=$this->lang->line('holder_mobile_lbl')?>: <?=$row_bank->bank_holder_phone?></p>
					            </div>
				          	</div>
				          	<?php } ?>
		                    <div class="address_details_item">
					            <a href="" class="btn_new_account" style="font-size: 16px">
					              <div class="address_list" style="padding: 15px 5px">
					                <i class="fa fa-plus"></i> <?=$this->lang->line('add_new_bank_lbl')?>
					              </div>
					            </a>
					        </div>
	        			</div>
	      			</div>
	      		</div>
	      	</form>

	      	<form method="post" accept-charset="utf-8" action="<?php echo site_url('site/add_new_bank'); ?>" class="bank_form" style="display: none;">
	      		<div class="row">
	      			<div class="col-md-12">
	      				<div class="wizard-form-field">
							<div class="wizard-form-input has-float-label">
							  <input type="text" name="bank_name" value="" required="" placeholder="<?=$this->lang->line('bank_name_place_lbl')?>">
							  <label><?=$this->lang->line('bank_name_place_lbl')?></label>
							</div>
						</div>
	      			</div>
	      			<div class="col-md-12">
	      				<div class="wizard-form-field">
							<div class="wizard-form-input has-float-label">
							  <input type="text" name="account_no" value="" required="" placeholder="<?=$this->lang->line('bank_acc_no_place_lbl')?>" onkeypress="return isNumberKey(event)">
							  <label><?=$this->lang->line('bank_acc_no_place_lbl')?></label>
							</div>
						</div>
	      			</div>
	      			<div class="col-md-6">
	      				<div class="form-group">
							<select class="form-control" required="required" name="account_type">
								<option value="saving"><?=$this->lang->line('saving_type_lbl')?></option>
								<option value="current"><?=$this->lang->line('current_type_lbl')?></option>
							</select>
						</div>
	      			</div>
	      			<div class="col-md-6">
	      				<div class="wizard-form-field">
							<div class="wizard-form-input has-float-label">
							  <input type="text" name="bank_ifsc" value="" required="" placeholder="<?=$this->lang->line('bank_ifsc_place_lbl')?>">
							  <label><?=$this->lang->line('bank_ifsc_place_lbl')?></label>
							</div>
						</div>
	      			</div>
	      			<div class="col-md-12">
						<div class="wizard-form-field">
							<div class="wizard-form-input has-float-label" style="margin-bottom: 0px">
							  <input type="text" name="holder_name" value="" required="" placeholder="<?=$this->lang->line('holder_name_place_lbl')?>">
							  <label><?=$this->lang->line('holder_name_place_lbl')?></label>
							</div>
							<p class="hint_lbl" style="margin-bottom: 20px">(<?=$this->lang->line('holder_name_note_lbl')?>)</p>
						</div>
					</div>
					<div class="col-md-12">
						<div class="wizard-form-field">
							<div class="wizard-form-input has-float-label" style="margin-bottom: 0px">
							  <input type="text" name="holder_mobile" value="" required="" placeholder="<?=$this->lang->line('holder_mobile_place_lbl')?>" onkeypress="return isNumberKey(event)" maxlength="15">
							  <label><?=$this->lang->line('holder_mobile_place_lbl')?></label>
							</div>
							<p class="hint_lbl" style="margin-bottom: 20px">(<?=$this->lang->line('holder_mobile_note_lbl')?>)</p>
						</div>
					</div>
					<div class="col-md-12">
						<div class="wizard-form-field">
							<div class="wizard-form-input has-float-label" style="margin-bottom: 0px">
							  <input type="text" name="holder_email" value="" required="" placeholder="<?=$this->lang->line('holder_email_place_lbl')?>">
							  <label><?=$this->lang->line('holder_email_place_lbl')?></label>
							</div>
							<p class="hint_lbl" style="margin-bottom: 20px">(<?=$this->lang->line('holder_email_note_lbl')?>)</p>
						</div>
					</div>
	      			<div class="col-md-12">
	      				<label class="container_checkbox"><?=$this->lang->line('default_refund_acc_lbl')?>
						  <input type="checkbox" checked="checked" name="is_default">
						  <span class="checkmark"></span>
						</label>
	      			</div>
	      			<div class="col-md-12">
	      				<br/>
	      				<div class="form-group">
	      					<button type="submit" class="btn btn-success"><?=$this->lang->line('save_btn')?></button>
	      					<button type="button" class="btn btn-warning btn_cancel_form"><?=$this->lang->line('cancel_btn')?></button>
	      				</div>
	      			</div>
	      		</div>
	      	</form>
	      </div>
	      <div class="modal-footer">
	        <button class="btn btn-danger" data-dismiss="modal" aria-label="<?=$this->lang->line('close_btn')?>"><?=$this->lang->line('close_btn')?></button>
	        <?php 

	        	$dataStuff=array('cancel_ord_reason_err' => $this->lang->line('cancel_ord_reason_err'), 'cancel_ord_bank_err' => $this->lang->line('cancel_ord_bank_err'), 'cancel_ord_btn' => $this->lang->line('cancel_ord_btn'), 'please_wait_lbl' => $this->lang->line('please_wait_lbl'), 'cancelled_lbl' => $this->lang->line('cancelled_lbl'));
	        ?>
	        <button class="btn btn-success cancel_order" data-stuff="<?=htmlentities(json_encode($dataStuff))?>"><?=$this->lang->line('cancel_ord_btn')?></button>
	      </div>
	    </div>
	  </div>
	</div>

	<div id="claimRefund" class="modal" style="z-index: 9999999;background: rgba(0,0,0,0.5);overflow-y: auto;">
	  <div class="modal-dialog modal-confirm">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h4 class="modal-title"><?=$this->lang->line('ord_refund_account_lbl')?></h4>
	      </div>
	      <div class="modal-body" style="padding-top: 0px">
	      	<div class="msg_holder">
	      		
	      	</div>
	      	<form id="">
	      		<input type="hidden" name="order_id" value="">
	      		<input type="hidden" name="product_id" value="">
	      		<div class="row">
	      			<div class="col-md-12 bank_details" style="display: none">
	      				<div class="address_details_block">
	      					<?php 
	      						foreach ($bank_details as $key => $row_bank) {
	      					?>
		                    <div class="address_details_item">
					            <label class="container">
					              <input type="radio" name="bank_acc_id" class="address_radio" value="<?=$row_bank->id?>" <?php if($row_bank->is_default=='1'){ echo 'checked="checked"';} ?>>
					              <span class="checkmark"></span>
					            </label>
		            
					            <div class="address_list">
					              <span style="margin-bottom: 0px"><?=$row_bank->bank_name?> (<?=$this->lang->line('bank_acc_no_lbl')?> :<?=$row_bank->account_no?>)</span>
					              <p style="margin-bottom: 0px"><?=$this->lang->line('bank_type_lbl')?>: <?=ucfirst($row_bank->account_type)?> <br/> <?=$this->lang->line('bank_ifsc_lbl')?>: <?=$row_bank->bank_ifsc?></p>
					              <p style="margin-bottom: 10px"><?=$this->lang->line('holder_name_lbl')?>: <?=$row_bank->bank_holder_name?> <br/> <?=$this->lang->line('holder_mobile_lbl')?>: <?=$row_bank->bank_holder_phone?></p>
					            </div>
				          	</div>
				          	<?php } ?>
		                    <div class="address_details_item">
					            <a href="" class="btn_new_account" style="font-size: 16px">
					              <div class="address_list" style="padding: 15px 5px">
					                <i class="fa fa-plus"></i> <?=$this->lang->line('add_new_bank_lbl')?>
					              </div>
					            </a>
					        </div>
	        			</div>
	      			</div>
	      		</div>
	      	</form>

	      	<form method="post" accept-charset="utf-8" action="<?php echo site_url('site/add_new_bank'); ?>" class="bank_form" style="<?=(count($bank_details)!=0) ? 'display: none;' : 'display: block;'?>">
	      		<div class="row">
	      			<div class="col-md-12">
	      				<div class="wizard-form-field">
							<div class="wizard-form-input has-float-label">
							  <input type="text" name="bank_name" value="" required="" placeholder="<?=$this->lang->line('bank_name_place_lbl')?>">
							  <label><?=$this->lang->line('bank_name_place_lbl')?></label>
							</div>
						</div>
	      			</div>
	      			<div class="col-md-12">
	      				<div class="wizard-form-field">
							<div class="wizard-form-input has-float-label">
							  <input type="text" name="account_no" value="" required="" placeholder="<?=$this->lang->line('bank_acc_no_place_lbl')?>" onkeypress="return isNumberKey(event)">
							  <label><?=$this->lang->line('bank_acc_no_place_lbl')?></label>
							</div>
						</div>
	      			</div>
	      			<div class="col-md-6">
	      				<div class="form-group">
							<select class="form-control" required="required" name="account_type">
								<option value="saving"><?=$this->lang->line('saving_type_lbl')?></option>
								<option value="current"><?=$this->lang->line('current_type_lbl')?></option>
							</select>
						</div>
	      			</div>
	      			<div class="col-md-6">
	      				<div class="wizard-form-field">
							<div class="wizard-form-input has-float-label">
							  <input type="text" name="bank_ifsc" value="" required="" placeholder="<?=$this->lang->line('bank_ifsc_place_lbl')?>">
							  <label><?=$this->lang->line('bank_ifsc_place_lbl')?></label>
							</div>
						</div>
	      			</div>
	      			<div class="col-md-12">
						<div class="wizard-form-field">
							<div class="wizard-form-input has-float-label" style="margin-bottom: 0px">
							  <input type="text" name="holder_name" value="" required="" placeholder="<?=$this->lang->line('holder_name_place_lbl')?>">
							  <label><?=$this->lang->line('holder_name_place_lbl')?></label>
							</div>
							<p class="hint_lbl" style="margin-bottom: 20px">(<?=$this->lang->line('holder_name_note_lbl')?>)</p>
						</div>
					</div>
					<div class="col-md-12">
						<div class="wizard-form-field">
							<div class="wizard-form-input has-float-label" style="margin-bottom: 0px">
							  <input type="text" name="holder_mobile" value="" required="" placeholder="<?=$this->lang->line('holder_mobile_place_lbl')?>" onkeypress="return isNumberKey(event)" maxlength="15">
							  <label><?=$this->lang->line('holder_mobile_place_lbl')?></label>
							</div>
							<p class="hint_lbl" style="margin-bottom: 20px">(<?=$this->lang->line('holder_mobile_note_lbl')?>)</p>
						</div>
					</div>
					<div class="col-md-12">
						<div class="wizard-form-field">
							<div class="wizard-form-input has-float-label" style="margin-bottom: 0px">
							  <input type="text" name="holder_email" value="" required="" placeholder="<?=$this->lang->line('holder_email_place_lbl')?>">
							  <label><?=$this->lang->line('holder_email_place_lbl')?></label>
							</div>
							<p class="hint_lbl" style="margin-bottom: 20px">(<?=$this->lang->line('holder_email_note_lbl')?>)</p>
						</div>
					</div>
	      			<div class="col-md-12">
	      				<label class="container_checkbox"><?=$this->lang->line('default_refund_acc_lbl')?>
						  <input type="checkbox" checked="checked" name="is_default">
						  <span class="checkmark"></span>
						</label>
	      			</div>
	      			<div class="col-md-12">
	      				<br/>
	      				<div class="form-group">
	      					<button type="submit" class="btn btn-success"><?=$this->lang->line('save_btn')?></button>
	      					<button type="button" class="btn btn-warning btn_cancel_form"><?=$this->lang->line('cancel_btn')?></button>
	      				</div>
	      			</div>
	      		</div>
	      	</form>
		  </div>
	      <div class="modal-footer">
	        <button class="btn btn-danger" data-dismiss="modal" aria-label="<?=$this->lang->line('close_btn')?>"><?=$this->lang->line('close_btn')?></button>
	        <button class="btn btn-success claim_refund" data-stuff="<?=htmlentities(json_encode($dataClaimStuff))?>"><?=$this->lang->line('claim_refund_btn')?></button>
	      </div>
	    </div>
	  </div>
	</div>
</div>

<script src="<?=base_url('assets/site_assets/js/timeline.js')?>"></script>
<script type="text/javascript">
// Submit Bank Form
$(".bank_form").submit(function(e){
	e.preventDefault();

	var _form=$(this);

	href=$(this).attr("action");

	var is_default='';

	if($(_form).find("input[name='is_default']").prop("checked") == true){
		is_default='checked="checked"';
	}

	var parent_element=$(this).prev("form").find(".bank_details");

	bank_name=$(_form).find("input[name='bank_name']").val();
	account_no=$(_form).find("input[name='account_no']").val();
	bank_ifsc=$(_form).find("input[name='bank_ifsc']").val();
	bank_ifsc=$(_form).find("input[name='bank_ifsc']").val();
	account_type=$(_form).find("select[name='account_type']").children("option:selected").text();
	name=$(_form).find("input[name='holder_name']").val();
	mobile_no=$(_form).find("input[name='holder_mobile']").val();

	$.ajax({
	  type:'POST',
	  url:href,
	  data:$(this).serialize(),
	  success:function(res){
		var obj = $.parseJSON(res);

		$('.notifyjs-corner').empty();

		if(obj.success=='1'){

			_form.find("input, textarea").val("");
			
			html_content='<div class="address_details_item"><label class="container"><input type="radio" name="bank_acc_id" class="address_radio" value="'+obj.bank_id+'" '+is_default+'><span class="checkmark"></span></label><div class="address_list"><span style="margin-bottom: 0px">'+bank_name+' <br/>(<?=$this->lang->line('bank_acc_no_lbl')?> :'+account_no+')</span><p style="margin-bottom: 0px"><?=$this->lang->line('bank_type_lbl')?>: '+account_type+' <br/> <?=$this->lang->line('bank_ifsc_lbl')?>: '+bank_ifsc+'</p><p style="margin-bottom: 10px"><?=$this->lang->line('holder_name_lbl')?>: '+name+' <br/> <?=$this->lang->line('holder_mobile_lbl')?>: '+mobile_no+'</p></div></div>';

			$(".bank_form").hide();

			parent_element.find(".address_details_block").prepend(html_content);

			parent_element.show();

			$.notify(
				obj.message, {
					position: "top right",
					className: 'success'
				}
			);
		}
		else{

			$.notify(
				obj.message, {
					position: "top right",
					className: 'error'
				}
			);
		}
		
	  }
	});

});
</script>