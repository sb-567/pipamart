<div class="row card_item_block" style="padding-left:30px;padding-right: 30px">
	<div class="col-md-12">
		<div class="card">
			<div class="page_title_block">
				<div class="col-md-5 col-xs-12">
					<div class="page_title"><?=$page_title?></div>
				</div>
			</div>
			<div class="clearfix"></div>
			<div class="card-body mrg_bottom" style="padding: 0px">
	            <ul class="nav nav-tabs" role="tablist">
	                <li role="presentation" class="active"><a href="#notification_settings" aria-controls="notification_settings" role="tab" data-toggle="tab"><i class="fa fa-wrench"></i> <?=$this->lang->line('notification_settings_lbl')?></a></li>
	                <li role="presentation"><a href="#send_notification" aria-controls="send_notification" role="tab" data-toggle="tab"><i class="fa fa-send"></i> <?=$this->lang->line('send_notification_lbl')?></a></li>
	                
	            </ul>
	            <div class="tab-content">

	            	<!-- Notification Setting -->
	            	<div role="tabpanel" class="tab-pane active" id="notification_settings">
	            		<div class="col-md-12">
	            			<form action="<?=site_url('admin/pages/save_app_setting')?>" name="settings_api" method="post" class="form form-horizontal" enctype="multipart/form-data">

	            			  <input type="hidden" name="action_for" value="notification_settings">

			                  <div class="section">
			                  <div class="section-body">
			                    <div class="form-group">
			                      <label class="col-md-3 control-label"><?=$this->lang->line('one_signal_id_lbl')?> :-</label>
			                      <div class="col-md-9">
			                        <input type="text" name="onesignal_app_id" id="onesignal_app_id" value="<?php echo $settings_row->onesignal_app_id;?>" class="form-control">
			                      </div>
			                    </div>
			                    <div class="form-group">
			                      <label class="col-md-3 control-label"><?=$this->lang->line('one_signal_rest_key_lbl')?> :-</label>
			                      <div class="col-md-9">
			                        <input type="text" name="onesignal_rest_key" id="onesignal_rest_key" value="<?php echo $settings_row->onesignal_rest_key;?>" class="form-control">
			                      </div>
			                    </div>              
			                    <div class="form-group">
			                    <div class="col-md-9 col-md-offset-3">
			                      <button type="submit" name="notification_submit" class="btn btn-primary"><?=$this->lang->line('save_btn')?></button>
			                    </div>
			                    </div>
			                  </div>
			                  </div>
			                </form>
	            		</div>
	            		<div class="clearfix"></div>
	            	</div>
	            	<!-- End Setting -->

	            	<!-- Send Notification -->
              		<div role="tabpanel" class="tab-pane" id="send_notification">
              			<div class="col-md-12">
	              			<form action="<?=site_url('admin/pages/send_notification')?>" method="post" class="form form-horizontal" enctype="multipart/form-data">
	               
			                  <div class="section">
			                    <div class="section-body">

			                      <div class="form-group">
			                        <label class="col-md-3 control-label"><?=$this->lang->line('noti_title_lbl')?> :-</label>
			                        <div class="col-md-9">
			                          <input type="text" name="notification_title" id="notification_title" class="form-control" value="" placeholder="" required>
			                        </div>
			                      </div>
			                      <div class="form-group">
			                        <label class="col-md-3 control-label"><?=$this->lang->line('noti_message_lbl')?> :-</label>
			                        <div class="col-md-9">
			                            <textarea name="notification_msg" id="notification_msg" class="form-control" required></textarea>
			                        </div>
			                      </div>
			                      <div class="form-group">
			                      	<label class="col-md-3 control-label"><?=$this->lang->line('select_image_lbl')?>(<?=$this->lang->line('optional_lbl')?>) :-
					                	<p class="control-label-help hint_lbl">(<?=$this->lang->line('recommended_resolution_lbl')?>: 600x293, 650x317, 700x342, 750x366)</p>
					                    <p class="control-label-help hint_lbl">(<?=$this->lang->line('accept_img_files_lbl')?>)</p>
					                </label>
			                        <div class="col-md-9">
			                          <div class="fileupload_block">
			                             <input type="file" name="big_picture" value="" id="fileupload">
			                             <div class="fileupload_img"><img type="image" src="<?=base_url('assets/images/no-image-1.jpg')?>" alt="image"  style="width: 184px;height: 90px"/></div>    
			                          </div>
			                        </div>
			                      </div>
			                      <div class="col-md-12 mrg_bottom link_block">
			                        <div class="form-group">
			                          <label class="col-md-3 control-label"><?=$this->lang->line('notification_for_lbl')?> :-<br/>(<?=$this->lang->line('optional_lbl')?>)</label>
			                          <div class="col-md-9">
			                            <select name="type" id="type" class="select2">
			                              <option value="" selected="">--<?=$this->lang->line('select_type_lbl')?>--</option>
			                              <option value="category"><?=$this->lang->line('category_lbl')?></option>
			                              <option value="sub_category"><?=$this->lang->line('sub_category_lbl')?></option>
			                              <?php 
			                              	if(!empty($todays_deal)){
			                              		?>
			                              		<option value="todays_deal"><?=$this->lang->line('hot_deal_lbl')?></option>
			                              		<?php
			                              	}
			                              ?>
			                              <option value="brand"><?=$this->lang->line('brand_lbl')?></option>
			                              <option value="offer"><?=$this->lang->line('offer_lbl')?></option>
			                              <option value="banner"><?=$this->lang->line('banner_lbl')?></option>
			                              <option value="product"><?=$this->lang->line('product_lbl')?></option>
			                            </select>
			                          </div>
			                        </div>

			                        <div class="allTypes">
				                        <div class="form-group typeForCategory" style="display: none;">
				                          <label class="col-md-3 control-label"><?=$this->lang->line('category_lbl')?> :-<br/>
				                          <p class="control-label-help"><?=$this->lang->line('noti_category_hint_lbl')?></p></label>
				                          <div class="col-md-9">
				                            <select name="cat_id" class="getData" data-type="category">
				                              <option value="">--<?=$this->lang->line('select_cat_lbl')?>--</option>
				                              <?php 
				                              	foreach ($category_list as $key => $value) {
				                              		echo '<option value="'.$value->id.'">'.$value->category_name.'</option>';
				                              	}
				                              ?>
				                            </select>
				                          </div>
				                      	</div>

				                      	<div class="form-group typeForSubCategory" style="display: none;">
				                          <label class="col-md-3 control-label"><?=$this->lang->line('category_lbl')?> :-</label>
				                          <div class="col-md-9">
				                            <select name="cat_id2" class="getData" data-type="category">
				                              <option value="">--<?=$this->lang->line('select_cat_lbl')?>--</option>
				                              <?php 
				                              	foreach ($category_list as $key => $value) {
				                              		echo '<option value="'.$value->id.'">'.$value->category_name.'</option>';
				                              	}
				                              ?>
				                            </select>
				                          </div>
				                          <hr/>
				                          <label class="col-md-3 control-label"><?=$this->lang->line('sub_category_lbl')?> :-<br/><p class="control-label-help"><?=$this->lang->line('noti_sub_category_hint_lbl')?></p></label>
				                          <div class="col-md-9">
				                            <select name="sub_cat_id" class="select2">
				                              <option value="">--<?=$this->lang->line('select_subcat_lbl')?>--</option>
				                            </select>
				                          </div>
				                      	</div>

				                      	<div class="form-group typeForBrand" style="display: none;">
				                          <label class="col-md-3 control-label"><?=$this->lang->line('brand_lbl')?> :-<br/>
				                          <p class="control-label-help"><?=$this->lang->line('noti_brand_hint_lbl')?></p></label>
				                          <div class="col-md-9">
				                            <select name="brand_id" class="getData" data-type="brand">
				                              <option value="">--<?=$this->lang->line('select_brand_lbl')?>--</option>
				                              <?php 
				                              	foreach ($brand_list as $key => $value) {
				                              		echo '<option value="'.$value->id.'">'.$value->brand_name.'</option>';
				                              	}
				                              ?>
				                            </select>
				                          </div>
				                      	</div>

				                        <div class="form-group typeForOffer" style="display: none;">
				                          <label class="col-md-3 control-label"><?=$this->lang->line('offer_lbl')?> :-<br/>
				                          <p class="control-label-help"><?=$this->lang->line('noti_offer_hint_lbl')?></p></label>
				                          <div class="col-md-9">
				                            <select name="offer_id" class="getData" data-type="offer">
				                              <option value="">--<?=$this->lang->line('select_offer_lbl')?>--</option>
				                              <?php 
				                              	foreach ($offers_list as $key => $value) {
				                              		echo '<option value="'.$value->id.'">'.$value->offer_title.'</option>';
				                              	}
				                              ?>
				                            </select>
				                          </div>
				                      	</div>

				                      	<div class="form-group typeForBanner" style="display: none;">
				                          <label class="col-md-3 control-label"><?=$this->lang->line('banner_lbl')?> :-<br/>
				                          <p class="control-label-help"><?=$this->lang->line('noti_banner_hint_lbl')?></p></label>
				                          <div class="col-md-9">
				                            <select name="banner_id" class="getData" data-type="banner">
				                              <option value="">--<?=$this->lang->line('select_banner_lbl')?>--</option>
				                              <?php 
				                              	foreach ($banner_list as $key => $value) {
				                              		echo '<option value="'.$value->id.'">'.$value->banner_title.'</option>';
				                              	}
				                              ?>
				                            </select>
				                          </div>
				                      	</div> 

					                    <div class="form-group typeForProduct" style="display: none;">
					                        <label class="col-md-3 control-label"><?=$this->lang->line('product_lbl')?> :-<br/>
					                        <p class="control-label-help"><?=$this->lang->line('noti_product_hint_lbl')?></p></label>
					                        <div class="col-md-9">
					                          <select name="product_id" class="getData" data-type="product" id="notification_product">
					                            <option value="" selected="">--<?=$this->lang->line('select_product_lbl')?>--</option>
					                            <?php 
					                              	foreach ($product_list as $key => $value) {
					                              		/*echo '<option data-image="'.base_url("assets/images/products/".$value->featured_image).'" value="'.$value->id.'">'.$value->product_title.'</option>';*/
					                              		echo '<option value="'.$value->id.'">'.$value->product_title.'</option>';

					                              	}
					                              ?>
					                          </select>
					                        </div>
					                    </div>
				                    </div> 
			                      
			                      <div class="or_link_item">
			                      <h2>OR</h2>
			                      </div>
			                      <div class="form-group">
			                        <label class="col-md-3 control-label"><?=$this->lang->line('external_link_lbl')?> :-<br/>(<?=$this->lang->line('optional_lbl')?>)</label>
			                        <div class="col-md-9">
			                          <input type="text" name="external_link" id="external_link" class="form-control" value="" placeholder="http://www.viaviweb.com">
			                        </div>
			                      </div>   
			                    </div>   
			                      <div class="form-group">
			                        <div class="col-md-9 col-md-offset-3">
			                          <button type="submit" name="submit" class="btn btn-primary">Send</button>
			                        </div>
			                      </div>
			                    </div>
			                  </div>
			                </form>
			            </div>
			            <div class="clearfix"></div>
              		</div>
              		<!-- End Code -->
              	</div>
	        </div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
		localStorage.setItem('activeTab', $(e.target).attr('href'));
	});

	var activeTab = localStorage.getItem('activeTab');
	if(activeTab){
		$('.nav-tabs a[href="' + activeTab + '"]').tab('show');
	}

	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();

			reader.onload = function(e) {
				$("input[name='big_picture']").next(".fileupload_img").find("img").attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
	$("input[name='big_picture']").change(function() { 
		readURL(this);
	});


	$("#type").on("change",function(e){
		var _type=$(this).val();

		$("*[class*='typeFor']").each(function(){
			$(this).find("select").attr("required",false);

			/*if($(this).find("#notification_product").html() == undefined){
				$(this).find("select").select2('destroy').val('').select2();
			}*/
		});

		if(_type=='category'){
			$("*[class*='typeFor']").hide();
			$(".typeForCategory").show();
			$("*[class*='typeFor']:not(:hidden)").each(function(){
				$(this).find("select").attr("required",true);
			});
		}
		else if(_type=='sub_category'){
			$("*[class*='typeFor']").hide();
			$(".typeForSubCategory").show();
			$("*[class*='typeFor']:not(:hidden)").each(function(){
				$(this).find("select").attr("required",true);
			});
		}
		else if(_type=='brand'){
			$("*[class*='typeFor']").hide();
			$(".typeForBrand").show();
			$("*[class*='typeFor']:not(:hidden)").each(function(){
				$(this).find("select").attr("required",true);
			});
		}
		else if(_type=='offer'){
			$("*[class*='typeFor']").hide();
			$(".typeForOffer").show();
			$("*[class*='typeFor']:not(:hidden)").each(function(){
				$(this).find("select").attr("required",true);
			});
		}
		else if(_type=='banner'){
			$("*[class*='typeFor']").hide();
			$(".typeForBanner").show();
			$("*[class*='typeFor']:not(:hidden)").each(function(){
				$(this).find("select").attr("required",true);
			});
		}
		else if(_type=='product'){
			$("*[class*='typeFor']").hide();
			$(".typeForProduct").show();
			$("*[class*='typeFor']:not(:hidden)").each(function(){
				$(this).find("select").attr("required",true);
			});
		}
		else{
			$("*[class*='typeFor']").hide();
		}

	});

	$("select[name='cat_id2']").on("change",function(e){

		var _id=$(this).val();

      	// getting sub categories
      	$("select[name='sub_cat_id']").html('<option value="0">--<?=$this->lang->line('select_subcat_lbl')?>--</option>');
      	var href = '<?php echo site_url('admin/product/get_sub_category/')?>'+_id;

      	$.ajax({
      		type:'GET',
      		url:href,
      		success:function(res){
      			$("select[name='sub_cat_id']").append(res);
      		}
      	});
  	});


	$(function(){

		var href = '<?php echo site_url('admin/pages/get_select2_data')?>';

		$(".getData").select2({
			ajax: {
				url: href,
				dataType: 'json',
				delay: 250,
				data: function (params) {
					var query = {
						type: $(this).data("type"),
						search: params.term,
						page: params.page || 1
					}
					return query;
				},
				processResults: function (data, params) {
					params.page = params.page || 1;
					return {
						results: data.items,
						pagination: {
							more: (params.page * 5) < data.total_count
						}
					};
				},
				cache: true
			}
		});
	});

	

</script>