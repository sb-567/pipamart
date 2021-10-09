<?php 
  $this->load->view('site/layout/breadcrumb');
  $ci =& get_instance();

  $dataClaimStuff=array('bank_err' => $this->lang->line('cancel_ord_bank_err'), 'please_wait_lbl' => $this->lang->line('please_wait_lbl'), 'done_lbl' => $this->lang->line('done_lbl'));
?>
<div class="wishlist-table-area mt-20 mb-50">
    <div class="container">
      <div class="row">
      	<?php 
          if(!empty($my_orders)){ 
      	?>
        <div class="col-md-12">
        	<?php 
        		foreach ($my_orders as $key => $value) {

        			$is_order_claim=$ci->is_order_claim($value->id);

        	?>
			<div class="product_oreder_part">
			  <div class="oreder_part_block">
				  <div class="order_detail_track">
					<div class="row">
						<div class="col-md-4 col-sm-4 col-xs-12">
						  <div class="order_track_btn">
							<a href="<?php echo site_url('my-orders/'.$value->order_unique_id); ?>">
								<div class="order_btn" style="text-transform: none;"><?=$value->order_unique_id?></div>
							</a>
						  </div>
						</div>
						<?php

							$status_arr=$ci->order_status($value->id,0);

							if($value->order_status!='4' && $value->order_status!='5'){
								?>
								<div class="col-md-4 col-sm-5 col-xs-12">
									<?=$this->lang->line('expected_delivery_lbl')?> <?=date("M d",$value->delivery_date)?>
									<br><?=$ci->get_single_info(array('order_id' => $value->id,'status_title' => $value->order_status),'status_desc','tbl_order_status')?>
								</div>
								<?php
							}
							else if($value->order_status=='5'){
								?>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<?=$this->lang->line('ord_cancelled_lbl')?>
								</div>
								<?php
							}
							else{
								?>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<?=$this->lang->line('delivery_on_lbl')?> <?=date("M d",$value->delivery_date)?>
									<br><?=$ci->get_single_info(array('order_id' => $value->id,'status_title' => $value->order_status),'status_desc','tbl_order_status')?>
								</div>
								<?php
							}
						?>
						<div class="col-md-4 col-sm-4 col-xs-12 order_track_item">

							<?php 
								if($is_order_claim){
							?>
							<div class="order_cancle_btn_item">
								<a href="javascript:void(0)">
									<div class="cancle_order_btn btn_claim" data-order="<?=$value->id;?>" data-product="0"><?=$this->lang->line('claim_refund_btn')?></div>
								</a>
							</div>
							<?php } ?>
							<div class="order_cancle_btn_item">
								<a href="<?php echo site_url('my-orders/'.$value->order_unique_id); ?>">
									<div class="cancle_order_btn"><i class="fa fa-map-marker"></i> <?=$this->lang->line('track_btn')?></div>
								</a>
							</div>
						</div>
					</div>
				  </div>
				  <div class="track_order_details_part">
				  	<?php 
				  		$where= array('order_id' => $value->id);

                    	$row_items=$this->common_model->selectByids($where, 'tbl_order_items');

                    	foreach ($row_items as $key2 => $value2) 
                    	{

                    		$thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $ci->get_single_info(array('id' => $value2->product_id),'featured_image','tbl_product'));

                    		$img_file=$ci->_create_thumbnail('assets/images/products/',$thumb_img_nm,$ci->get_single_info(array('id' => $value2->product_id),'featured_image','tbl_product'),100,100);
				  	?>
					<div class="col-md-12 details_part_product_img slingle_item_address_part">
					  <div class="row">
						<div class="col-md-1 col-sm-2 col-xs-4">
							<div class="product_img_part">
								<a href="<?php echo site_url('product/'.$ci->get_single_info(array('id' => $value2->product_id),'product_slug','tbl_product')); ?>" target="_blank"><img src="<?=base_url().$img_file?>" alt=""></a>	
							</div>
							
						</div>

						<div class="col-md-4 col-sm-6 col-xs-8">
						  <a href="<?php echo site_url('product/'.$ci->get_single_info(array('id' => $value2->product_id),'product_slug','tbl_product')); ?>" target="_blank" title="<?=$value2->product_title?>">
						  	<?php 
			                    if(strlen($value2->product_title) > 40){
			                      echo substr(stripslashes($value2->product_title), 0, 40).'...';  
			                    }else{
			                      echo $value2->product_title;
			                    }
			                  ?>
						  </a>
						  <div><?=$this->lang->line('price_lbl')?>: <?=CURRENCY_CODE.' '.number_format($value2->product_price, 2)?></div>
						  <div><?=$this->lang->line('qty_lbl')?>: <?=$value2->product_qty?></div>
						  <?php 
						  	if($value2->product_size!='' AND $value2->product_size!='0')
						  	{
						  		echo '<div>'.$this->lang->line('size_lbl').': '.$value2->product_size.'</div>';
						  	}
						  ?>

						</div>

						<?php
							if($value2->pro_order_status!='4' && $value2->pro_order_status!='5'){
								?>
								<div class="col-md-2 col-sm-4 col-xs-12 col-md-offset-5 text-right">				 
									<a href="javascript:void(0)" class="form-button pull-right btn-danger product_cancel pull-right" data-order="<?=$value2->order_id?>" data-product="<?=$value2->product_id?>" data-unique="<?=$value->order_unique_id?>" data-gateway="<?=$ci->get_single_info(array('order_id' => $value2->order_id),'gateway','tbl_transaction')?>"><?=$this->lang->line('cancel_btn')?></a>
								</div>
								<?php
							}
							else if($value2->pro_order_status=='5'){

								$cancelled_on=$ci->get_single_info(array('order_id' => $value2->order_id, 'product_id' => $value2->product_id),'created_at','tbl_refund');

								?>
								<div class="col-md-7 col-sm-4 col-xs-12">
									<span style="color: red;"><?=$this->lang->line('product_cancelled_on_lbl')?> <?=date('d-m-Y h:i A',$cancelled_on)?></span>
									<br>
									<strong><?=$this->lang->line('reason_lbl')?>:</strong>
									<?php echo '<label style="">'.$ci->get_single_info(array('order_id' => $value2->order_id, 'product_id' => $value2->product_id),'refund_reason','tbl_refund').'</label>';?>
									<?php 
										if($ci->get_single_info(array('order_id' => $value2->order_id, 'product_id' => $value2->product_id),'gateway','tbl_refund')!='cod')
										{
											switch ($ci->get_single_info(array('order_id' => $value2->order_id, 'product_id' => $value2->product_id),'request_status','tbl_refund')) {
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

												if($ci->get_single_info(array('order_id' => $value2->order_id, 'product_id' => $value2->product_id),'request_status','tbl_refund')=='-1')
												{
													echo '<a href="javascript:void(0)" class="form-button pull-right btn-danger btn_claim" data-order="'.$value2->order_id.'" data-product="'.$value2->product_id.'">'.$this->lang->line('claim_refund_btn').'</a>';
												}
											}	
										}
									?>
								</div>
								<?php
							}
						?>

					  </div>
					</div>
					<?php } ?>
					<div class="row product_img_part_bottom">
					  <div class="col-md-6 col-sm-6 col-xs-12 product_item_date_item"><span><?=$this->lang->line('ord_on_lbl')?> </span><?=date("D, M jS 'y",$value->order_date)?></div>
					  <div class="col-md-6 col-sm-6 col-xs-12 price_item_right"><span><?=$this->lang->line('ord_total_lbl')?> </span><span class="product_item_price_item"><?=CURRENCY_CODE.' '.number_format($value->payable_amt, 2)?></span></div>
					</div>
				  </div>
				</div>
			</div>	
			<?php } ?>
        </div>
        <?php }else{ ?>
		<center style="margin-bottom: 50px;">
	        <img src="<?=base_url('assets/img/my_order.png')?>">
            <h2 style="font-size: 18px;font-weight: 500;color: #888;"><?=$this->lang->line('my_order_empty')?></h2>
            <br/>
	        <a href="<?=base_url('/')?>"><img src="<?=base_url('assets/images/continue-shopping-button.png')?>"></a>
	     </center>
        <?php } ?>
      </div>
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
      	<div class="msg_holder"></div>
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
        <button class="btn btn-danger" data-dismiss="modal" aria-label="Close"><?=$this->lang->line('close_btn')?></button>
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

<div id="orderConfirm" class="modal" style="z-index: 9999999;background: rgba(0,0,0,0.8);text-align:center;">
  <div class="modal-dialog modal-confirm" style="width: fit-content">
    <div class="modal-content">
      <div class="modal-header">
        <img src="<?=base_url('assets/images/success-icon.png')?>" style="width: 70px">
        <h4 class="modal-title"><?=$this->lang->line('ord_placed_lbl')?></h4> 
      </div>
      <div class="modal-body" style="padding-top: 0px">
        <p class="text-center" style="font-size: 18px;color: green;font-weight: 600;margin-bottom: 5px"><?=$this->lang->line('thank_you_ord_lbl')?></p>
        <p style="margin-bottom: 5px;text-align: center;"><?=$this->lang->line('ord_confirm_lbl')?></p>
        <p style="color: #000;margin-bottom: 5px;font-size: 16px;text-align: center;"><strong><?=$this->lang->line('ord_no_lbl')?>:</strong> <span class="ord_no_lbl"></span></p>
      </div>
      <div class="modal-footer" style="text-align: center">
        <button class="btn btn-danger btn_track"><?=$this->lang->line('track_ord_btn')?></button>
        <button class="btn btn-success btn_orders" onclick="location.href='<?=base_url('my-orders')?>'"><?=$this->lang->line('my_ord_btn')?></button>
      </div>
    </div>
  </div>
</div>


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
				
				html_content='<div class="address_details_item"><label class="container"><input type="radio" name="bank_acc_id" class="address_radio" value="'+obj.bank_id+'" '+is_default+'><span class="checkmark"></span></label><div class="address_list"><span style="margin-bottom: 0px">'+bank_name+' (<?=$this->lang->line('bank_acc_no_lbl')?> :'+account_no+')</span><p style="margin-bottom: 0px"><?=$this->lang->line('bank_type_lbl')?>: '+account_type+' <br/> <?=$this->lang->line('bank_ifsc_lbl')?>: '+bank_ifsc+'</p><p style="margin-bottom: 10px"><?=$this->lang->line('holder_name_lbl')?>: '+name+' <br/> <?=$this->lang->line('holder_mobile_lbl')?>: '+mobile_no+'</p></div></div>';

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


	$('#orderCancel, #claimRefund').on('hidden.bs.modal', function () {
	  $("body").css("overflow-y","auto");
	  $(".bank_form").hide();
	  $(".bank_details").hide();
	  $(".msg_holder").html('');
	  $("textarea[name='reason']").css("border-color","#ccc");
	  $("textarea").val('');
	});

</script>

<?php
  if($this->session->flashdata('payment_msg')) {
    $data = $this->session->flashdata('payment_msg');
    ?>
	<script type="text/javascript">
      $("#orderConfirm .ord_no_lbl").text('<?=$data['order_unique_id']?>');

      $("#orderConfirm .btn_track").on("click",function(e){
        window.location.href='<?=base_url().'my-orders/'.$data['order_unique_id']?>';
      });

      $("#orderConfirm").fadeIn();
    </script>
    <?php
  } 
?>