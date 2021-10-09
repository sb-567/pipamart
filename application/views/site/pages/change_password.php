<?php 
  	$this->load->view('site/layout/breadcrumb'); 
  	$ci =& get_instance();
?>

<div class="product-list-grid-view-area mt-20">
	  <div class="container">
	    <div class="row"> 
			<div class="col-lg-3 col-md-3 mb_40"> 
		        <?php $this->load->view('site/layout/sidebar_my_account'); ?>
			</div>
			<div class="col-lg-9 col-md-9">
				<?php 
					if(strcmp($this->session->userdata('user_type'), 'Normal')==0){
				?>
				<div class="my_profile_area_detail">
					<div class="checkout-title">
					  <h3><?=$this->lang->line('change_password_lbl')?></h3>
					</div>
					<form action="" id="change_password_form" method="post">
						<div class="row">
							<div class="col-md-4">
								<div class="wizard-form-field">
									<div class="wizard-form-input has-float-label">
									  <input type="password" name="old_password" value="" placeholder="<?=$this->lang->line('old_password_place_lbl')?>"  autocomplete="off">
									  <label><?=$this->lang->line('old_password_place_lbl')?></label>
									  <p class="err err_old_password"><i class="fa fa-exclamation-circle"></i> <span><?=$this->lang->line('old_password_require_lbl')?></span></p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wizard-form-field">
									<div class="wizard-form-input has-float-label">
									  <input type="password" name="new_password" value="" placeholder="<?=$this->lang->line('new_password_place_lbl')?>"  autocomplete="off">
									  <label><?=$this->lang->line('new_password_place_lbl')?></label>
									  <p class="err err_new_password"><i class="fa fa-exclamation-circle"></i> <span><?=$this->lang->line('new_password_require_lbl')?></span></p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="wizard-form-field">
									<div class="wizard-form-input has-float-label">
									  <input type="password" name="confirm_password" value="" placeholder="<?=$this->lang->line('c_new_password_place_lbl')?>"  autocomplete="off">
									  <label><?=$this->lang->line('c_new_password_place_lbl')?></label>
									  <p class="err err_confirm_password"><i class="fa fa-exclamation-circle"></i> <span><?=$this->lang->line('c_new_password_require_lbl')?></span></p>
									</div>
								</div>
							</div>
							<div class="login-submit col-md-12">
							  <button type="submit" class="form-button"><?=$this->lang->line('save_btn')?></button>			  
							</div>
						</div>			
					</form>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

	$("#change_password_form").submit(function(e){

		var inputs = $("#change_password_form :input[type='password']");
		var counts=0;
		e.preventDefault();

		inputs.each(function(){
			if($(this).val()=='')
			{
				$(this).css("border-color","#F00");
				$(this).parents(".wizard-form-input").find("p").fadeIn();
				counts++;
			}
			else{
				$(this).parents(".wizard-form-input").find("p").hide();
			}
		});

		if($("input[name='confirm_password']").val()!=$("input[name='new_password']").val())
		{
			counts++;

			$("input[name='confirm_password']").parents(".wizard-form-input").find("p").find("span").text("<?=$this->lang->line('password_cpass_match_lbl')?>");

			$("input[name='confirm_password']").parents(".wizard-form-input").find("p").fadeIn();
		}
		else
		{
			$(this).parents(".wizard-form-input").find("p").hide();
		}

		if(counts==0)
		{
			var formData = new FormData($(this)[0]);
			var href = '<?=base_url()?>site/change_password';

		    $.ajax({
		        url: href,
		        processData: false,
		        contentType: false,
		        type: 'POST',
		        data: formData,
		        success: function(data){

		          var obj = $.parseJSON(atob(data));
		          
		          if(obj.status==1){
	          		swal({ title: "<?=$this->lang->line('updated_lbl')?>", text: obj.msg, type: "success" }, function(){ location.reload(); });
		          }
		          else{
		          	$("#change_password_form").find("."+obj.class).find("span").text(obj.msg);
		          	$("#change_password_form").find("."+obj.class).fadeIn();
		          }
		        }
		     });

		}

	});

	$("#change_password_form input").blur(function(e)
	{
		if($(this).val()!='')
		{
			if($("input[name='confirm_password']").val()!=''){

				if($("input[name='confirm_password']").val()!=$("input[name='new_password']").val())
				{
					$("input[name='confirm_password']").parents(".wizard-form-input").find("p").find("span").text("<?=$this->lang->line('password_cpass_match_lbl')?>");

					$("input[name='confirm_password']").parents(".wizard-form-input").find("p").fadeIn();
				}
				else{

					$(this).css("border-color","#E5E5E5");
					$(this).parents(".wizard-form-input").find("p").hide();
				}
			}
			else
			{
				$(this).parents(".wizard-form-input").find("p").find("span").text("<?=$this->lang->line('c_new_password_require_lbl')?>");
				$(this).parents(".wizard-form-input").find("p").fadeIn();
			}

			$(this).parents(".wizard-form-input").find("p").hide();

			$(this).css("border-color","#E5E5E5");

		}
		else{
			$(this).parents(".wizard-form-input").find("p").fadeIn();
		}
	});

	$("input[name='confirm_password']").on('keyup blur',function(e){
		if($(this).val()!=''){
			if($(this).val()!=$("input[name='new_password']").val()){
				$(this).css("border-color","#F00");
				$(this).parents(".wizard-form-input").find("p").find("span").text("<?=$this->lang->line('password_cpass_match_lbl')?>");

				$(this).parents(".wizard-form-input").find("p").fadeIn();
			}
			else{
				$(this).parents(".wizard-form-input").find("p").hide();
				$(this).css("border-color","#E5E5E5");
			}
		}
		else
		{
			$(this).css("border-color","#F00");
			$(this).parents(".wizard-form-input").find("p").find("span").text("<?=$this->lang->line('c_new_password_require_lbl')?>");
			$(this).parents(".wizard-form-input").find("p").fadeIn();
		}
	});

</script>