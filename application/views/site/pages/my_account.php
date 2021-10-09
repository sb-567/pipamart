<?php 
  	$this->load->view('site/layout/breadcrumb'); 
  	$ci =& get_instance();

  	define('IMG_PATH', base_url().'assets/images/users/');

  	if($user_data->user_image!='' && file_exists('assets/images/users/'.$user_data->user_image)){
		$user_img=IMG_PATH.$user_data->user_image;
	}
	else{
		$user_img=base_url('assets/images/photo.jpg');
	}

?>

<style type="text/css">
	.file {
		position: relative;
		display: inline-block;
		cursor: pointer;
		height: 50px;
		float: left;    
		margin-right: 10px;
	}
	.file input {
		min-width: 14rem;
		margin: 0;
		filter: alpha(opacity=0);
		opacity: 0;
	}
	.file-custom {
		position: absolute;
		top: 0;
		right: 0;
		left: 0;
		z-index: 5;
		height: 50px;
		padding: .5rem 1rem;
		line-height: 36px;
		color: #555;
		background-color: #fff;
		border: 2px solid #ebebeb;
		border-radius: .25rem;
		-webkit-user-select: none;
		-moz-user-select: none;
		-ms-user-select: none;
		user-select: none;
	}
	.file-custom:after {
		content: "<?=$this->lang->line('choose_file_place_lbl')?>";
		padding-left: 10px;
	}
	.file-custom:before {
		position: absolute;
		top: 0px;
		right: 0px;
		bottom: 0;
		z-index: 6;
		display: block;
		content: "<?=$this->lang->line('browse_file_place_lbl')?>";
		height: 46px;
		padding: .5rem 1rem;
		line-height: 36px;
		color: #555;
		background-color: #eee;
		border: 0;
		border-radius: 0;
	}
	.file input:focus ~ .file-custom {
		border:2px solid #ff5252;
	}
	@media (max-width:489px) {
		.file {
			width: 170px;
			margin-bottom: 15px;
			margin-right: 20px;
		}
	}
</style>

<div class="product-list-grid-view-area mt-20">
	  <div class="container">
	    <div class="row"> 
			<div class="col-lg-3 col-md-3 mb_40"> 
		        <?php $this->load->view('site/layout/sidebar_my_account'); ?>
			</div>
			<div class="col-lg-9 col-md-9">
				<div class="my_profile_area_detail">
					<div class="checkout-title">
					  <h3><?=$this->lang->line('my_profile_lbl')?></h3>
					</div>
					<form action="" id="profile_form">
						<div class="row">
							<div class="col-md-6">
								<div class="wizard-form-field">
									<div class="wizard-form-input has-float-label">
									  <input type="text" name="user_name" value="<?=$user_data->user_name?>" required="" <?=($user_data->user_type!='Normal') ? 'readonly=""' : ''?> placeholder="<?=$this->lang->line('name_place_lbl')?>">
									  <label><?=$this->lang->line('name_place_lbl')?></label>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="wizard-form-field">
									<div class="wizard-form-input has-float-label">
									  <input type="text" name="user_email" value="<?=$user_data->user_email?>" <?=($user_data->user_type=='Normal') ? 'required=""' : ''?> <?=($user_data->user_email!='') ? 'readonly=""' : ''?> placeholder="<?=$this->lang->line('email_place_lbl')?>">
									  <label><?=$this->lang->line('email_place_lbl')?></label>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="wizard-form-field">
									<div class="wizard-form-input has-float-label">
									  <input type="text" name="user_phone" value="<?=$user_data->user_phone?>" required="" placeholder="<?=$this->lang->line('phone_no_place_lbl')?>" onkeypress="return isNumberKey(event)" maxlength="15">
									  <label><?=$this->lang->line('phone_no_place_lbl')?></label>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<label class="file">
								  <input type="file" id="file" name="file_name" aria-label="Profile picture browse" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG">
								  <span class="file-custom"></span>
								</label>
							</div>
							<div class="col-md-2">
								<img class="fileupload_img" src="<?=$user_img?>" style="width:50px;height:50px;margin-top:0px;border:2px solid #e5e5e5;border-radius:4px;">
								<a href="javascript:void(0)"class="_tooltip remove_profile" data-toggle="tooltip" title="<?=$this->lang->line('remove_profile_lbl')?>" data-original-title="<?=$this->lang->line('remove_profile_lbl')?>"><i class="fa fa-close"></i></a>
							</div>
							<div class="clearfix"></div>
							<div class="login-submit col-md-12">
							  <button type="submit" class="form-button"><?=$this->lang->line('save_btn')?></button>  
							</div>
						</div>			
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				$(".fileupload_img").attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}

	$("input[name='file_name']").change(function() { 
		readURL(this);
	});

	$("#profile_form").submit(function(e)
	{
		var inputs = $("#profile_form :input[type='text']");
		var counts=0;
		e.preventDefault();

		inputs.each(function(){
			if($(this).val()==''){
				$(this).css("border-color","#F00");
				counts++;
			}
			else{
				$(this).css("border-color","#E5E5E5");
			}
		});

		if(counts==0){
			
			$(".process_loader").show();

			var formData = new FormData($(this)[0]);

			var href = '<?=base_url()?>site/update_profile';

		    $.ajax({
		        url: href,
		        processData: false,
		        contentType: false,
		        type: 'POST',
		        data: formData,
		        success: function(data){

		          var obj = $.parseJSON(atob(data));
		          
		          $(".process_loader").hide();

		          if(obj.status==1){
	          		swal({ title: "<?=$this->lang->line('updated_lbl')?>", text: obj.msg, type: "success"});
	          		$(".profile_img").css("background-image", "url('"+obj.image+"')");
		          }
		          else{
		          	swal({
		          		title: Settings.err_something_went_wrong,
		          		text: obj.msg,
		          		type: "error"
		          	}, function() {
		          		location.reload();
		          	});
		          }
		        }
		     });
		}
	});

	$("#profile_form :input[type='text']").blur(function(e){
		if($(this).val()!=''){
			$(this).css("border-color","#E5E5E5");
		}
		else{
			$(this).css("border-color","#F00");
		}
	});

	$(".remove_profile").on("click",function(e){
		e.preventDefault();

		swal({
            title: Settings.confirm_msg,
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: "btn-danger btn_edit",
            cancelButtonClass: "btn-warning btn_edit",
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: false,
            closeOnCancel: false,
            showLoaderOnConfirm: true
        },
        function(isConfirm) {
            if(isConfirm){

				$(".process_loader").show();

				var href = '<?=base_url()?>site/remove_profile';
				$.ajax({
			        url: href,
			        type: 'POST',
			        success: function(data){
			        	var obj = $.parseJSON(atob(data));
						$(".process_loader").hide();

						if(obj.status==1){
							swal({ title: "<?=$this->lang->line('removed_lbl')?>", text: obj.msg, type: "success"});
							$(".fileupload_img").attr('src',"<?=base_url('assets/images/photo.jpg')?>");
							$(".profile_img").css("background-image", "url('<?=base_url('assets/images/photo.jpg')?>')");
						}
						else{
							swal({
								title: Settings.err_something_went_wrong,
								text: obj.msg,
								type: "error"
							}, function() {
								location.reload();
							});
						}
			        }
			    });
			} 
			else {
                swal.close();
            }
        });
	});

</script>