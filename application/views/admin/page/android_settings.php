<style type="text/css">
  .select2{
    width: 100% !important;
  }
  .field_lable {
    margin-bottom: 10px;
    margin-top: 10px;
    color: #666;
    padding-left: 15px;
    font-size: 14px;
    line-height: 24px;
  }
  .banner_ads_block .toggle_btn, .interstital_ad_item .toggle_btn{
    margin-top: 6px;
  }
</style>
<div class="row" style="padding-left:30px;padding-right: 30px">
  <div class="col-sm-12 col-xs-12">
    <div class="card">
      <div class="card-header">
        <?=$page_title?>
      </div>
      <div class="clearfix"></div>

      <!-- card body -->

      <div class="card-body mrg_bottom" style="padding: 0px">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#admob_settings" aria-controls="admob_settings" role="tab" data-toggle="tab"><i class="fa fa-audio-description"></i> Ads Settings</a></li>
          <li role="presentation"><a href="#api_settings" aria-controls="api_settings" role="tab" data-toggle="tab"><i class="fa fa-exchange"></i> API Settings</a></li>
          <li role="presentation"><a href="#app_update_popup" aria-controls="app_update_popup" role="tab" data-toggle="tab"><i class="fa fa-android"></i> App Update Popup</a></li>
        </ul>

        <div class="rows">
          <div class="col-md-12">
              <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="admob_settings">
                  <form action="<?=site_url('admin/pages/save_app_setting')?>" method="post" class="form form-horizontal" enctype="multipart/form-data">

                    <input type="hidden" name="action_for" value="admob_settings">
                    <div class="section">
                      <div class="section-body">
                        <div class="row">
                          <div class="form-group">
                            <div class="col-md-12">                
                            <div class="col-md-12">
                              <div class="admob_title">Android</div>

                              <div class="form-group">
                                <label class="col-md-3 control-label">Publisher ID :-
                                  <p class="control-label-help hint_lbl">(Note: Publisher ID is not required for facebook ads)</p>
                                </label>
                                <div class="col-md-9">
                                  <input type="text" name="publisher_id" id="publisher_id" value="<?php echo $settings_android_row->publisher_id;?>" class="form-control">
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="banner_ads_block" style="min-height: auto;">
                                <div class="banner_ad_item">
                                  <label class="control-label">Banner Ads:-</label>
                                  <div class="row toggle_btn">
                                    <input type="checkbox" id="checked1" name="banner_ad" value="true" class="cbx hidden" <?php if($settings_android_row->banner_ad=='true'){?>checked <?php }?> />
                                    <label for="checked1" class="lbl"></label>
                                  </div>
                                </div>
                                <div class="col-md-12">             
                                  <div class="form-group" id="#admob_banner_id">                              
                                      <p class="field_lable">Banner Ad Type :-</p>
                                      <div class="col-md-12"> 
                                        <select name="banner_ad_type" id="banner_ad_type" class="select2">
                                          <option value="admob" <?php if($settings_android_row->banner_ad_type=='admob'){ echo 'selected'; }?>>Admob</option>
                                          <option value="facebook" <?php if($settings_android_row->banner_ad_type=='facebook'){ echo 'selected'; }?>>Facebook</option>
                                        </select>                                 
                                      </div>
                                      
                                      <p class="field_lable">Banner Ad ID :-</p>
                                    <div class="col-md-12 banner_ad_id" style="display: none">
                                      <input type="text" name="banner_ad_id" id="banner_ad_id" value="<?php echo $settings_android_row->banner_ad_id;?>" class="form-control">
                                    </div>
                                    <div class="col-md-12 banner_facebook_id" style="display: none">
                                      <input type="text" name="banner_facebook_id" id="banner_facebook_id" value="<?php echo $settings_android_row->banner_facebook_id;?>" class="form-control">
                                    </div>
                                  </div>
                                </div>
                              </div>  
                            </div>
                            <div class="col-md-6">
                              <div class="interstital_ads_block">
                                <div class="interstital_ad_item">
                                  <label class="control-label">Interstitial Ads:-</label>
                                  <div class="row toggle_btn">
                                    <input type="checkbox" id="checked2" name="interstital_ad" value="true" class="cbx hidden" <?php if($settings_android_row->interstital_ad=='true'){?>checked <?php }?>/>
                                    <label for="checked2" class="lbl"></label>
                                  </div>
                                </div>
                                <div class="col-md-12">             
                                  <div class="form-group" id="interstital_ad_id">                              
                                      
                                      <p class="field_lable">Interstitial Ad Type :-</p>
                                      <div class="col-md-12"> 
                                        <select name="interstital_ad_type" id="interstital_ad_type" class="select2">
                                          <option value="admob" <?php if($settings_android_row->interstital_ad_type=='admob'){ echo 'selected'; }?>>Admob</option>
                                          <option value="facebook" <?php if($settings_android_row->interstital_ad_type=='facebook'){ echo 'selected'; }?>>Facebook</option>
                                        </select>                                 
                                      </div>
                                      
                                      <p class="field_lable">Interstitial Ad ID :-</p>

                                      <div class="col-md-12 interstital_ad_id" style="display: none">
                                        <input type="text" name="interstital_ad_id" id="interstital_ad_id" value="<?php echo $settings_android_row->interstital_ad_id;?>" class="form-control">
                                      </div>

                                      <div class="col-md-12 interstital_facebook_id" style="display: none">
                                        <input type="text" name="interstital_facebook_id" id="interstital_facebook_id" value="<?php echo $settings_android_row->interstital_facebook_id;?>" class="form-control">
                                      </div>
                                      <p class="field_lable">Interstitial Ad Clicks :-</p>
                                      <div class="col-md-12"> 
                                          <input type="text" name="interstital_ad_click" id="interstital_ad_click" value="<?php echo $settings_android_row->interstital_ad_click;?>" class="form-control ads_click">                                 
                                      </div>
                                  </div>
                                    
                                </div>
                              </div>  
                            </div>
                            </div>
                          </div>
                          </div>
                          <div class="form-group">
                            <div class="col-md-9">
                            <button type="submit" name="admob_submit" class="btn btn-primary">Save</button>
                            </div>
                          </div>
                      </div>
                    </div>
                  </form>
                </div>
                <div role="tabpanel" class="tab-pane" id="api_settings">
                  <form action="<?=site_url('admin/pages/save_app_setting')?>" method="post" class="form form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="action_for" value="api_settings">
                    <div class="section">
                      <div class="section-body">
                        <div class="form-group">
                          <label class="col-md-3 control-label">Home Limit:-</label>
                          <div class="col-md-6">
                            <input type="number" name="api_home_limit" id="api_home_limit" value="<?php echo $settings_android_row->api_home_limit;?>" class="form-control"> 
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label">Page Limit:-</label>
                          <div class="col-md-6">
                            <input type="number" name="api_page_limit" id="api_page_limit" value="<?php echo $settings_android_row->api_page_limit;?>" class="form-control"> 
                          </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group">
                          <label class="col-md-3 control-label">Category List Order By:-</label>
                          <div class="col-md-6">
                              <select name="api_cat_order_by" id="api_cat_order_by" class="select2">
                                <option value="id" <?php if($settings_android_row->api_cat_order_by=='id'){ echo 'selected'; }?>>ID</option>
                                <option value="category_name" <?php if($settings_android_row->api_cat_order_by=='category_name'){ echo 'selected'; }?>>Name</option>
                              </select>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label">Category Products Order:-</label>
                          <div class="col-md-6">
                              <select name="api_cat_post_order_by" id="api_cat_post_order_by" class="select2">
                                <option value="ASC" <?php if($settings_android_row->api_cat_post_order_by=='ASC'){ echo 'selected'; }?>>ASC</option>
                                <option value="DESC" <?php if($settings_android_row->api_cat_post_order_by=='DESC'){ echo 'selected'; }?>>DESC</option>
                    
                              </select>
                          </div>
                         
                        </div>
                        <div class="form-group">
                          <label class="col-md-3 control-label">All Products Order:-</label>
                          <div class="col-md-6">
                              <select name="api_all_order_by" id="api_all_order_by" class="select2">
                                <option value="ASC" <?php if($settings_android_row->api_all_order_by=='ASC'){ echo 'selected'; }?>>ASC</option>
                                <option value="DESC" <?php if($settings_android_row->api_all_order_by=='DESC'){ echo 'selected'; }?>>DESC</option>
                              </select>
                          </div>
                        </div>
                        
                        <div class="form-group">
                          <div class="col-md-9 col-md-offset-3">
                            <button type="submit" name="api_submit" class="btn btn-primary">Save</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>

                <div role="tabpanel" class="tab-pane" id="app_update_popup">
                  <form action="<?=site_url('admin/pages/save_app_setting')?>" method="post" class="form form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="action_for" value="app_update_popup">
                      <div class="form-group">
                        <label class="col-md-3 control-label">App Update Popup Show/Hide:-
                          <p class="control-label-help" style="color:#F00">You can show/hide update popup from this option</p>
                        </label>
                        <div class="col-md-6">
                          <div class="row" style="margin-top: 15px">
                              <input type="checkbox" id="chk_update" name="app_update_status" value="true" class="cbx hidden" <?php if($settings_android_row->app_update_status=='true'){ echo 'checked'; }?>/>
                              <label for="chk_update" class="lbl" style="left: 15px;"></label>
                          </div>
                        </div>                   
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label">New App Version Code:-</label>
                        <div class="col-md-6">
                          <input type="number" min="1" name="app_new_version" id="app_new_version" required="" value="<?php echo $settings_android_row->app_new_version;?>" class="form-control">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-3 control-label">Description :-</label>
                        <div class="col-md-6">
                          <textarea name="app_update_desc" class="form-control"><?php echo $settings_android_row->app_update_desc;?></textarea>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-3 control-label">App Link :-
                          <p class="control-label-help">You will be redirect on this link after click on update</p>
                        </label>
                        <div class="col-md-6">
                          <input type="text" name="app_redirect_url" id="app_redirect_url" required="" value="<?php echo $settings_android_row->app_redirect_url;?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label">Cancel Option :-
                          <p class="control-label-help" style="color:#F00">Cancel button option will show in app update popup</p>
                        </label>
                        <div class="col-md-6">
                          <div class="row" style="margin-top: 15px">
                              <input type="checkbox" id="chk_cancel_update" name="cancel_update_status" value="true" class="cbx hidden" <?php if($settings_android_row->cancel_update_status=='true'){ echo 'checked'; }?>/>
                              <label for="chk_cancel_update" class="lbl" style="left: 15px"></label>
                          </div>
                        </div>
                      </div> 

                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                        <button type="submit" name="app_update_popup" class="btn btn-primary">Save</button>
                        </div>
                      </div>

                  </form>
                </div>
                
              </div>
          </div>
        </div>

        <div class="clearfix"></div>

      </div>

      <!-- End card -->

    </div>
  </div>
</div>
<br/>
<div class="clearfix"></div>   

<script type="text/javascript">
  $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
    document.title = $(this).text()+" | <?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_name?>";
  });

  var activeTab = localStorage.getItem('activeTab');
  if(activeTab){
    $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
  }

  if($("select[name='banner_ad_type']").val()==='facebook'){
    $(".banner_ad_id").hide();
    $(".banner_facebook_id").show();
  }
  else{
    $(".banner_facebook_id").hide();
    $(".banner_ad_id").show(); 
  }

  $("select[name='banner_ad_type']").change(function(e){
    if($(this).val()==='facebook'){
      $(".banner_ad_id").hide();
      $(".banner_facebook_id").show();
    }
    else{
      $(".banner_facebook_id").hide();
      $(".banner_ad_id").show(); 
    }
  });

  if($("select[name='interstital_ad_type']").val()==='facebook'){
    $(".interstital_ad_id").hide();
    $(".interstital_facebook_id").show();
  }
  else{
    $(".interstital_facebook_id").hide();
    $(".interstital_ad_id").show(); 
  }

  $("select[name='interstital_ad_type']").change(function(e){

    if($(this).val()==='facebook'){
      $(".interstital_ad_id").hide();
      $(".interstital_facebook_id").show();
    }
    else{
      $(".interstital_facebook_id").hide();
      $(".interstital_ad_id").show(); 
    }
  });

</script>