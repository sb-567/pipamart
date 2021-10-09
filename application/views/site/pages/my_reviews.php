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
				<div class="my_profile_area_detail">
					<div class="checkout-title">
					  <h3><?=$this->lang->line('myreviewrating_lbl')?></h3>
					</div>
					<?php 
						if(!empty($my_review))
						{
					?>
					<div class="row">
						<?php 
							foreach ($my_review as $key => $value) {

								$thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $ci->get_single_info(array('id' => $value->product_id),'featured_image','tbl_product'));

								$img_file=$ci->_create_thumbnail('assets/images/products/',$thumb_img_nm,$ci->get_single_info(array('id' => $value->product_id),'featured_image','tbl_product'),200,200);

						?>
						<div class="col-md-12 details_part_product_img my_review_area">
						  <div class="row">
							<div class="col-md-2 col-sm-2 col-xs-4">
							  <div class="product_img_part"> <a href="<?php echo site_url('product/'.$ci->get_single_info(array('id' => $value->product_id),'product_slug','tbl_product')); ?>" target="_blank"><img src="<?=base_url().$img_file?>" alt="" style="border: 2px solid #ddd;border-radius: 6px;"></a> </div>
							</div>
							<div class="col-md-8 col-sm-8 col-xs-8"> <a href="<?php echo site_url('product/'.$ci->get_single_info(array('id' => $value->product_id),'product_slug','tbl_product')); ?>" target="_blank" style="font-weight:500"><?php echo $ci->get_single_info(array('id' => $value->product_id),'product_title','tbl_product'); ?></a>
							  <div><?=nl2br(stripslashes($value->rating_desc))?></div>
							  <div class="product-rating">
							  	<?php 
	                              for ($x = 0; $x < 5; $x++) { 
	                                if($x < $value->rating){
	                                  ?>
	                                  <i class="fa fa-star"></i>
	                                  <?php  
	                                }
	                                else{
	                                  ?>
	                                  <i class="fa fa-star on-color"></i>
	                                  <?php
	                                }
	                              }
	                            ?>
	                            <input type="hidden" class="review_content" value="<?php echo $value->rating_desc; ?>">
	                            <?php

	                            	$row_review_img=$this->common_model->selectByids(array('parent_id' => $value->id, 'type' => 'review'), 'tbl_product_images');

	                            	foreach ($row_review_img as $valueReview) {
	                            		echo '<input type="hidden" name="review_images[]" data-id="'.$valueReview->id.'" value="'.base_url('assets/images/review_images/').$valueReview->image_file.'">';
	                            	}
	                            ?>
	                            
							  	<a class="review-link edit_review" href="" data-rating='<?php echo $value->rating; ?>' data-id='<?php echo $value->id; ?>'>(<?=$this->lang->line('edit_review_lbl')?>)</a> 
							  </div>
							</div>
							<div class="col-md-2 col-sm-2 col-xs-12 text-right"> <a href="javascript:void(0)" class="form-button pull-right btn-danger btn_remove_review" data-id="<?=$value->id?>"><?=$this->lang->line('delete_btn')?></a> </div>
						  </div>
						</div>
						<?php } ?>
					</div>
					<?php }else{
						?>
						<div class="col-md-12 text-center" style="padding: 1em 0px 1em 0px">
							<h3><?=$this->lang->line('no_review_lbl')?></h3>	
						</div>
						<?php
					} ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="edit_review" class="modal fade" role="dialog" style="z-index: 99999">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="modal-details">
					<h3 style="font-weight: 500"><?=$this->lang->line('edit_review_lbl')?></h3>
                  	<br/>
					<div class="ceckout-form" style="background: none;border:none;">
						<form action="" method="post" id="edit_review_form">
							<input type="hidden" name="review_id" value="">
							<input type="hidden" class="inp_rating" name="rating" value="">
							<label><?=$this->lang->line('your_rating_lbl')?></label>
							<div class="rating"> 
								<div class='rating-stars'>
								    <ul id='stars'>
								      <li class='star selected' title='<?=$this->lang->line('rate_poor_lbl')?>' data-value='1'>
								        <i class='fa fa-star fa-fw'></i>
								      </li>
								      <li class='star' title='<?=$this->lang->line('rate_fair_lbl')?>' data-value='2'>
								        <i class='fa fa-star fa-fw'></i>
								      </li>
								      <li class='star' title='<?=$this->lang->line('rate_good_lbl')?>' data-value='3'>
								        <i class='fa fa-star fa-fw'></i>
								      </li>
								      <li class='star' title='<?=$this->lang->line('rate_excellent_lbl')?>' data-value='4'>
								        <i class='fa fa-star fa-fw'></i>
								      </li>
								      <li class='star' title='<?=$this->lang->line('rate_wow_lbl')?>' data-value='5'>
								        <i class='fa fa-star fa-fw'></i>
								      </li>
								    </ul>
								  </div> 
							</div>
							<br/>
							<div class="form-fild">
								<div class="wizard-form-field">
									<div class="wizard-form-input has-float-label" style="margin-bottom: 0px">
									  <textarea placeholder="<?=$this->lang->line('reviews_place_lbl')?>" name="message" cols="40" rows="8"></textarea>
									  <label><?=$this->lang->line('reviews_place_lbl')?></label>
									</div>
								</div>
							</div>

							<div class="form-fild">
								<label><?=$this->lang->line('product_review_img_lbl')?></label>
								<input type="file" name="product_images[]" multiple="" style="outline: none !important;padding-top: 10px">
							</div>

							<div class="form-fild img_container">

							</div>
							
							<div class="add-to-link" style="margin-top: 15px">
								<button class="form-button" type="submit" data-text="save"><?=$this->lang->line('save_btn')?></button>
								<button class="form-button" type="button" data-dismiss="modal"><?=$this->lang->line('close_btn')?></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">

	$(".edit_review").on("click",function(e){
		e.preventDefault();

		var onStar = parseInt($(this).data('rating'), 10); // The star currently selected
		var stars = $('#stars li').parent().children('li.star');

		for (i = 0; i < stars.length; i++) {
			$(stars[i]).removeClass('selected');
		}

		for (i = 0; i < onStar; i++) {
			$(stars[i]).addClass('selected');
		}

		$('#edit_review').find(".inp_rating").val(parseInt($(this).data('rating'), 10));
		$('#edit_review').find("input[name='review_id']").val($(this).data('id'));
		$('#edit_review').find("textarea[name='message']").val($(this).parents(".product-rating").find("input.review_content").val());


		var arrIds = $(this).parents(".product-rating").find('input[name="review_images[]"]').map(function () {
		    return $(this).data("id");
		}).get();

		var arrImage = $(this).parents(".product-rating").find('input[name="review_images[]"]').map(function () {
		    return $(this).val();
		}).get();

		var joinArr = arrIds.map((el, i) => {
		  return [arrIds[i], arrImage[i]];
		});

		var mainArr = Object.fromEntries(joinArr);

		var html='<div class="row upload_img_part">';

		var elem='';

		$("#edit_review").find(".img_container").html('');

		$.each(mainArr,function(index, value) 
		{
			html+='<div class="review_img_holder"><img src="'+value+'" /><br/><a href="javascript:void(0)" class="btn_remove_img" data-id="'+index+'" style="color: #F00">&times;</a></div>';
		});

		html+='</div>';

		$("#edit_review").find(".img_container").html(html);

		$(".btn_remove_img").click(function(event){
			event.preventDefault();

			var _ele=$(this).parent(".review_img_holder");

			var href = '<?=base_url()?>site/remove_review_image';

			var id=$(this).data("id");

			swal({
				title: "<?=$this->lang->line('are_you_sure_msg')?>",
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
				if (isConfirm) {

					$.ajax({
						url:href,
						data: {"id": id},
						type:'post',
						success:function(res){
							var obj = $.parseJSON(res); 
							swal.close();
							if(obj.success==1){
								_ele.remove();
								$('.notifyjs-corner').empty();
								$.notify(
									obj.message, 
									{ position:"top right",className: obj.class }
								);
							}
							else{
								swal("<?=$this->lang->line('something_went_wrong_err')?>");
							}
						}
					});

				}else{
					swal.close();
				}
			});
		});

		$('#edit_review').modal({
	        backdrop: 'static',
	        keyboard: false
	    })
	});


	$("#edit_review_form").on("submit",function(e){
		e.preventDefault();
		$(".process_loader").show();

		var formData = new FormData($(this)[0]);

		var href = '<?=base_url()?>site/edit_review';

		$.ajax({
	        url: href,
	        processData: false,
	        contentType: false,
	        type: 'POST',
	        data: formData,
	        success: function(data){

	          var obj = $.parseJSON(atob(data));
	          $(".process_loader").hide();
	          $('#edit_review').modal("hide");

	          if(obj.success=='1'){
          		swal({ title: "<?=$this->lang->line('updated_lbl')?>", text: obj.message, type: "success" }, function(){ location.reload(); });
	          }
	          else{
	          	swal("<?=$this->lang->line('something_went_wrong_err')?>", obj.message);
	          }

	        }
	    });
	});
</script>