<?php 
  $this->load->view('site/layout/breadcrumb'); 
  $ci =& get_instance();

  // print_r($bank_details);

?>

<div class="product-list-grid-view-area mt-20">
	  <div class="container">
	    <div class="row"> 
			<div class="col-lg-3 col-md-3 mb_40"> 
		        <?php $this->load->view('site/layout/sidebar_my_account'); ?>
			</div>
			<div class="col-lg-9 col-md-9">
				<div class="my_profile_area_detail">
					<div class="checkout-title">
					  <h3><?=$this->lang->line('saved_bank_lbl')?></h3>
					</div>
					<?php 
						if(!empty($bank_details))
						{
						foreach ($bank_details as $key => $value) {
					?>
						<div class="panel panel-danger">
							<div class="panel-heading clearfix" style="padding-top: 5px;padding-bottom: 5px">
							  <h4 class="panel-title pull-left" style="padding-top: 7.5px;"><?=$value->bank_name?> </h4>
							  <div class="btn-group pull-right">
								<a href="" class="btn btn-danger btn_remove_bank" data-id="<?=$value->id?>"><?=$this->lang->line('delete_btn')?></a>
							  </div>
							  <div class="btn-group pull-right">
								<a href="" class="btn btn-success btn_edit_bank" data-stuff='<?php echo htmlentities(json_encode($value)); ?>'><?=$this->lang->line('edit_lbl')?></a>
							  </div>
							</div>
							<div class="panel-body">
								<table class="table table-condensed">
									<tbody>
										<tr>
											<td class="col-md-3"><strong><?=$this->lang->line('bank_acc_no_lbl')?></strong></td>
											<td><?=$value->account_no?></td>
											<td class="col-md-3"><strong><?=$this->lang->line('holder_name_lbl')?></strong></td>
											<td><?=$value->bank_holder_name?></td>
										</tr>
										<tr>
											<td class="col-md-2"><strong><?=$this->lang->line('bank_ifsc_lbl')?></strong></td>
											<td><?=$value->bank_ifsc?></td>
											<td class="col-md-3"><strong><?=$this->lang->line('holder_mobile_lbl')?></strong></td>
											<td><?=$value->bank_holder_phone?></td>
										</tr>
										<tr>
											<td class="col-md-3"><strong><?=$this->lang->line('bank_type_lbl')?></strong></td>
											<td><?=($value->account_type=='saving') ? $this->lang->line('saving_type_lbl') : $this->lang->line('current_type_lbl')?></td>
											<td class="col-md-2"><strong><?=$this->lang->line('holder_email_lbl')?></strong></td>
											<td colspan="3"><?=$value->bank_holder_email?></td>
										</tr>									
									</tbody>
								</table>
							</div>
						</div>
					<?php }
					}
						else{
						echo '<div class="col-md-12 text-center" style="padding: 1em 0px 1em 0px">
								<h3>'.$this->lang->line('no_saved_bank_lbl').'	
							 </div><div class="clearfix"></div>';
						}
					?>
					<div class="address_details_item" style="border-top:1px solid rgba(0, 0, 0, 0.1);">
						<a href="" class="btn_new_account" style="font-size:16px">
						  <div class="address_list" style="padding:15px 5px">
							<i class="fa fa-plus"></i> <?=$this->lang->line('add_new_bank_lbl')?>
						  </div>
						</a>
					</div>
					<form method="post" accept-charset="utf-8" action="<?php echo site_url('site/add_new_bank'); ?>" class="bank_form" id="bank_form_new" style="display:none;margin-top:15px;">
						<div class="row">
							<div class="col-md-6">
								<div class="wizard-form-field">
									<div class="wizard-form-input has-float-label">
									  <input type="text" name="bank_name" value="" required="" placeholder="<?=$this->lang->line('bank_name_place_lbl')?>">
									  <label><?=$this->lang->line('bank_name_place_lbl')?></label>
									</div>
								</div>
							</div>
							<div class="col-md-6">
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
			</div>
		</div>
	</div>
</div>

<div id="edit_bank_account" class="modal fade" role="dialog" style="z-index: 99999">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="modal-details">
					<div class="ceckout-form" style="background: none;border:none;">
						<form action="" method="post" id="edit_bank_form">
							
						  <input type="hidden" name="bank_id">

						  <div class="billing-fields">

						  	<div class="row">
								<div class="col-md-6">
									<div class="wizard-form-field">
										<div class="wizard-form-input has-float-label">
										  <input type="text" name="bank_name" value="" required="" placeholder="<?=$this->lang->line('bank_name_place_lbl')?>">
										  <label><?=$this->lang->line('bank_name_place_lbl')?></label>
										</div>
									</div>
								</div>
								<div class="col-md-6">
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
									  <input type="checkbox" name="is_default">
									  <span class="checkmark"></span>
									</label>
								</div>
							</div>
							<br/>
							
							<div class="form-fild">
							  <div class="add-to-link">
								<button class="form-button" type="submit" data-text="save"><?=$this->lang->line('save_btn')?></button>
								<button class="form-button" type="button" data-dismiss="modal"><?=$this->lang->line('close_btn')?></button>
							  </div>
							</div>
						  </div>               
						</form>
					  </div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	$(".btn_edit_bank").click(function(e){

		e.preventDefault();
		var data=$(this).data('stuff');

		$('#edit_bank_account').find("input[name='bank_id']").val(data['id']);
		$('#edit_bank_account').find("input[name='bank_name']").val(data['bank_name']);
		$('#edit_bank_account').find("input[name='account_no']").val(data['account_no']);
		$('#edit_bank_account').find("input[name='bank_ifsc']").val(data['bank_ifsc']);
		$('#edit_bank_account').find("input[name='holder_name']").val(data['bank_holder_name']);

		$('#edit_bank_account').find("input[name='holder_mobile']").val(data['bank_holder_phone']);
		$('#edit_bank_account').find("input[name='holder_email']").val(data['bank_holder_email']);
		$('#edit_bank_account').find('#account_type option[value="'+data['state']+'"]').prop('selected', true);
		if(data['is_default']=='1'){
			$('#edit_bank_account').find("input[name=is_default]").prop("checked",true);
		}
		else{
			$('#edit_bank_account').find("input[name=is_default]").prop("checked",false);
		}
		
		$('#edit_bank_account').modal({
	        backdrop: 'static',
	        keyboard: false
	    })
	});

	// update bank account
	$("#edit_bank_form").submit(function(e){
		e.preventDefault();

		$(".process_loader").show();

		var formData = new FormData($(this)[0]);

		var href = '<?=base_url()?>site/edit_bank_account';
		
		$.ajax({
	        url: href,
	        processData: false,
	        contentType: false,
	        type: 'POST',
	        data: formData,
	        success: function(data){
	          var obj = $.parseJSON(atob(data));
	          $(".process_loader").hide();
	          if(obj.success=='1'){
	          	$('#edit_bank_account').modal("hide");
          		swal({ title: "<?=$this->lang->line('updated_lbl')?>", text: obj.message, type: "success" }, function(){ location.reload(); });
	          }
	          else{
	          	swal({
            		title: Settings.err_something_went_wrong,
            		text: obj.message,
            		type: "error"
            	}, function() {
            		location.reload();
            	});
	          }

	        }
	    });

	});
	
	// Submit Bank Form
	$("#bank_form_new").on("submit",function(e){
		e.preventDefault();
		var _form=$(this);
		href=$(this).attr("action");
		$.ajax({
          type:'POST',
          url:href,
          data:$(this).serialize(),
          success:function(res){
            var obj = $.parseJSON(res);
            if(obj.success=='1'){
            	swal({ title: "<?=$this->lang->line('added_lbl')?>", text: obj.message, type: "success" }, function(){ location.reload(); });
            }
            else{
            	swal({
            		title: Settings.err_something_went_wrong,
            		text: obj.message,
            		type: "error"
            	}, function() {
            		location.reload();
            	});
            }
          }
        });
	});


</script>


<?php
  if($this->session->flashdata('response_msg')) {
    $message = $this->session->flashdata('response_msg');
    ?>
      <script type="text/javascript">
        var _msg='<?=$message['message']?>';
        var _class='<?=$message['class']?>';

        $('.notifyjs-corner').empty();
        $.notify(
          _msg, 
          { position:"top right",className: _class }
        ); 
      </script>
    <?php
  }
?>
