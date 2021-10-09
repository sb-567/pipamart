<div class="row card_item_block" style="padding-left: 30px;padding-right: 30px">
	<div class="col-md-12">
        <div class="card">
		    <div class="page_title_block">
	            <div class="col-md-5 col-xs-12">
	              <div class="page_title"><?=$this->lang->line('verify_purchase_lbl')?></div>
	            </div>
	        </div>
          	<div class="clearfix"></div>

	      	<div class="card-body mrg_bottom" style="padding: 0px;">

	      		<ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#website_purchase" aria-controls="website_purchase" role="tab" data-toggle="tab"><i class="fa fa-globe"></i> <?=$this->lang->line('website_purchase_lbl')?></a></li>
					<li role="presentation"><a href="#android_purchase" aria-controls="Verify Purchase" role="tab" data-toggle="tab"><i class="fa fa-android"></i> <?=$this->lang->line('android_app_purchase_lbl')?></a></li>
		        </ul>

	      		<div class="col-md-12">
	      			
			        <div class="tab-content">
			        	<div role="tabpanel" class="tab-pane active" id="website_purchase">
			              	<form action="<?=site_url('admin/pages/save_verify_purchase')?>" method="post" class="form form-horizontal" enctype="multipart/form-data">

              					<input type="hidden" name="action_for" value="website_purchase">
				                <div class="section">
					                <div class="section-body">
					                  <div class="form-group">
					                    <label class="col-md-4 control-label"><?=$this->lang->line('envato_username_lbl')?><span style="color: red">*</span>:-
					                      <p class="control-label-help" style="margin-bottom: 5px"><?=$this->lang->line('envato_username_hint_lbl')?></p>
					                    </label>
					                    <div class="col-md-6">
					                      <input type="text" readonly name="web_envato_buyer_name" id="web_envato_buyer_name" value="<?=$settings_row->web_envato_buyer_name?>" class="form-control" placeholder="viaviwebtech">
					                    </div>
					                  </div>
					                  <div class="form-group">
					                    <label class="col-md-4 control-label"><?=$this->lang->line('envato_purchase_code_lbl')?><span style="color: red">*</span>:-
					                      <p class="control-label-help"><a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code" target="_blank"><?=$this->lang->line('envato_purchase_code_hint_lbl')?></a></p>
					                    </label>
					                    <div class="col-md-6">
					                      <input type="text" name="web_envato_purchase_code" id="web_envato_purchase_code" value="<?=$settings_row->web_envato_purchase_code?>" class="form-control" placeholder="xxxx-xxxx-xxxx-xxxx-xxxx">
					                    </div>
					                  </div>
					                  <div class="form-group">
						                  <div class="col-md-9 col-md-offset-4">
						                    <button type="submit" name="verify_purchase_web_submit" class="btn btn-primary">Save</button>
						                  </div>
					                  </div>
					                </div>
				                </div>
			              	</form>
			              	<br/>
		          		</div>

		          		<!-- for android purchase -->
		          		<div role="tabpanel" class="tab-pane" id="android_purchase">
			              <form action="<?=site_url('admin/pages/save_verify_purchase')?>" method="post" class="form form-horizontal" enctype="multipart/form-data">

              				<input type="hidden" name="action_for" value="android_purchase">
			                <div class="section">
				                <div class="section-body">
				                  <div class="form-group">
				                    <label class="col-md-4 control-label"><?=$this->lang->line('envato_username_lbl')?><span style="color: red">*</span>:-
										<p class="control-label-help" style="margin-bottom: 5px"><?=$this->lang->line('envato_username_hint_lbl')?></p>
									</label>
				                    <div class="col-md-6">
				                      <input type="text" readonly="" name="android_envato_buyer_name" id="android_envato_buyer_name" value="<?=$settings_row->android_envato_buyer_name?>" class="form-control" placeholder="viaviwebtech">
				                    </div>
				                  </div>
				                  <div class="form-group">
				                    <label class="col-md-4 control-label"><?=$this->lang->line('envato_purchase_code_lbl')?><span style="color: red">*</span>:-
				                      <p class="control-label-help"><a href="https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code" target="_blank"><?=$this->lang->line('envato_purchase_code_hint_lbl')?></a></p>
				                    </label>
				                    <div class="col-md-6">
				                    <input type="text" name="android_envato_purchase_code" id="android_envato_purchase_code" value="<?=$settings_row->android_envato_purchase_code?>" class="form-control" placeholder="xxxx-xxxx-xxxx-xxxx-xxxx">
				                    </div>
				                  </div>
				                  <div class="form-group">
				                    <label class="col-md-4 control-label"><?=$this->lang->line('android_package_lbl')?><span style="color: red">*</span> :-
				                      <p class="control-label-help"><?=$this->lang->line('android_package_hint_lbl')?></p>
				                    </label>
				                    <div class="col-md-6">
				                      <input type="text" name="package_name" id="package_name" value="<?=$settings_row->package_name?>" class="form-control" placeholder="com.example.myapp">
				                    </div>
				                  </div>
				                   
				                  <div class="form-group">
				                  <div class="col-md-9 col-md-offset-4">
				                    <button type="submit" name="verify_purchase_android_submit" class="btn btn-primary"><?=$this->lang->line('save_btn')?></button>
				                  </div>
				                  </div>
				                </div>
			                </div>
			              </form>
			              <br/>
			          	</div>
		          		<!-- end -->
			        </div>
	      		</div>

	      		<div class="clearfix"></div>

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
</script>