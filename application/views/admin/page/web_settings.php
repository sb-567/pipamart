<style type="text/css">
  .select2{
    width: 100% !important;
    height: auto !important;
  }
</style>

<!-- For Bootstrap Tags -->
<link rel="stylesheet" type="text/css" href="<?=base_url('assets/bootstrap-tag/bootstrap-tagsinput.css')?>">
<!-- End -->

<div class="row card_item_block" style="padding-left:30px;padding-right: 30px">
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
          <li role="presentation" class="active"><a href="#web_general_settings" aria-controls="web_general_settings" role="tab" data-toggle="tab"><i class="fa fa-wrench"></i> <?=$this->lang->line('general_setting_lbl')?></a></li>
          <li role="presentation"><a href="#login_settings" aria-controls="login_settings" role="tab" data-toggle="tab"><i class="fa fa-lock"></i> <?=$this->lang->line('login_tab_lbl')?></a></li>
          <li role="presentation"><a href="#page_settings" aria-controls="page_settings" role="tab" data-toggle="tab"><i class="fa fa-newspaper-o"></i> <?=$this->lang->line('page_setting_lbl')?></a></li>
          <!--<li role="presentation"><a href="#ads_place" aria-controls="ads_place" role="tab" data-toggle="tab"><?=$this->lang->line('ads_place_lbl')?></a></li>-->
          <li role="presentation"><a href="#eco_warrior" aria-controls="eco_warrior" role="tab" data-toggle="tab">Eco Warrior of the week</a></li>
        </ul>

        <div class="rows">
          <div class="col-md-12">
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="web_general_settings">
                <form action="<?=site_url('admin/pages/save_setting')?>" method="post" class="form form-horizontal" enctype="multipart/form-data">

                  <input type="hidden" name="action_for" value="web_general_settings">

                  <div class="section">
                    <div class="section-body">
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?=$this->lang->line('site_nm_lbl')?><span class="required_fields">*</span> :-</label>
                        <div class="col-md-6">
                          <input type="text" name="site_name" id="site_name" value="<?php echo $web_settings_row->site_name;?>" class="form-control" required="required">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?=$this->lang->line('site_desc_lbl')?><span class="required_fields">*</span> :-</label>
                        <div class="col-md-6">
                          <textarea rows="6" name="site_description" class="form-control" required=""><?php echo $web_settings_row->site_description;?></textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?=$this->lang->line('site_keyword_lbl')?>:-
                          <p class="control-label-help hint_lbl">(<?=$this->lang->line('seo_keyword_hint_lbl')?>)</p>
                        </label>
                        <div class="col-md-6">
                          <input type="text" name="site_keywords" id="site_keywords" data-role="tagsinput" placeholder="<?=$this->lang->line('site_keyword_place_lbl')?>" value="<?php echo $web_settings_row->site_keywords;?>" class="form-control">
                        </div>
                        <div class="clearfix"></div>
                        <br/>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?=$this->lang->line('site_logo1_lbl')?><span class="required_fields">*</span> :-
                          <p class="control-label-help hint_lbl">(<?=$this->lang->line('recommended_resolution_lbl')?>: 170x36)</p>
                          <p class="control-label-help hint_lbl">(<?=$this->lang->line('accept_img_files_lbl')?>)</p>
                        </label>
                        <div class="col-md-6">
                          <div class="fileupload_block">
                            <input type="file" name="web_logo_1" id="fileupload" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG">

                              <?php 
                                $img_path=base_url().'assets/images/';

                                if($web_settings_row->web_logo_1!="" || file_exists($img_path.$web_settings_row->web_logo_1))
                                {
                                  $img_url=$img_path.$web_settings_row->web_logo_1;
                                }
                                else{
                                  $img_url=$img_path.'no-image-1.jpg';
                                }

                              ?>
                              <div class="fileupload_img"><img type="image" src="<?php echo $img_url;?>" alt="image"  style="width: 200px !important;height: 50px !important;border: 1px solid #ddd;object-fit: contain;" /></div>
                            
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?=$this->lang->line('site_logo2_lbl')?><span class="required_fields">*</span> :-
                          <p class="control-label-help hint_lbl">(<?=$this->lang->line('recommended_resolution_lbl')?>: 170x36)</p>
                          <p class="control-label-help hint_lbl">(<?=$this->lang->line('accept_img_files_lbl')?>)</p>
                          <p class="control-label-help hint_lbl">(<?=$this->lang->line('site_logo2_note_lbl')?>)</p>
                        </label>
                        <div class="col-md-6">
                          <div class="fileupload_block">
                            <input type="file" name="web_logo_2" id="fileupload" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG">

                              <?php 
                                $img_path=base_url().'assets/images/';

                                if($web_settings_row->web_logo_2!="" || file_exists($img_path.$web_settings_row->web_logo_2))
                                {
                                  $img_url=$img_path.$web_settings_row->web_logo_2;
                                }
                                else{
                                  $img_url=$img_path.'no-image-1.jpg';
                                }

                              ?>
                              <div class="fileupload_img"><img type="image" src="<?php echo $img_url;?>" alt="image"  style="width: 200px !important;height: 50px !important;border: 1px solid #ddd;object-fit: contain;" /></div>
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?=$this->lang->line('site_favicon_lbl')?><span class="required_fields">*</span> :-
                          <p class="control-label-help hint_lbl">(<?=$this->lang->line('recommended_resolution_lbl')?>: 16x16)</p>
                        </label>

                        <div class="col-md-6">
                          <div class="fileupload_block">
                            <input type="file" name="web_favicon" id="fileupload" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG" style="margin-top: 0px">

                              <?php 
                                $img_path=base_url().'assets/images/';

                                if($web_settings_row->web_favicon!="" || file_exists($img_path.$web_settings_row->web_favicon))
                                {
                                  $img_url=$img_path.$web_settings_row->web_favicon;
                                }
                                else{
                                  $img_url=$img_path.'no-image-1.jpg';
                                }

                              ?>
                              <div class="fileupload_img"><img type="image" src="<?php echo $img_url;?>" alt="image"  style="width: 16px !important;height: 16px !important;" /></div>
                            
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?=$this->lang->line('copyright_txt_lbl')?><span class="required_fields">*</span> :-</label>
                        <div class="col-md-6">
                          <input type="text" name="copyright_text" id="copyright_text" value='<?php echo $web_settings_row->copyright_text;?>' class="form-control" required="required">
                        </div>
                      </div>
                      <hr/>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?=$this->lang->line('libraries_load_from_lbl')?><span class="required_fields">*</span> :-
                          <p class="control-label-help hint_lbl">(<?=$this->lang->line('local_lbl')?>: <?=$this->lang->line('local_hint_lbl')?>)</p>
                          <p class="control-label-help hint_lbl">(<?=$this->lang->line('cdn_lbl')?>: <?=$this->lang->line('cdn_hint_lbl')?>)</p>
                        </label>
                        <div class="col-md-6">
                          <select class="select2" name="libraries_load_from" required="">
                            <option value="local" <?=($web_settings_row->libraries_load_from=='local') ? 'selected' : ''?>><?=$this->lang->line('local_lbl')?></option>
                            <option value="cdn" <?=($web_settings_row->libraries_load_from=='cdn') ? 'selected' : ''?>><?=$this->lang->line('cdn_recommended_lbl')?></option>
                          </select>
                        </div>
                      </div>
                      <hr/>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?=$this->lang->line('header_code_lbl')?>:-</label>
                        <div class="col-md-6">
                          <textarea rows="3" name="header_code" placeholder="<?=$this->lang->line('header_code_place_lbl')?>" class="form-control"><?php echo html_entity_decode($web_settings_row->header_code);?></textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?=$this->lang->line('footer_code_lbl')?>:-</label>
                        <div class="col-md-6">
                          <textarea rows="3" name="footer_code" placeholder="<?=$this->lang->line('footer_code_place_lbl')?>" class="form-control"><?php echo html_entity_decode($web_settings_row->footer_code);?></textarea>
                        </div>
                      </div>
                      <hr/>
                      <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                          <button type="submit" name="submit" class="btn btn-primary"><?=$this->lang->line('save_btn')?></button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>

              <!-- for login tab -->
              <div role="tabpanel" class="tab-pane" id="login_settings">
                  <form action="<?=site_url('admin/pages/save_setting')?>" method="post" class="form form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="action_for" value="login_settings">
                      <div class="form-group">
                        <label class="col-md-3 control-label"><?=$this->lang->line('google_login_lbl')?>:-</label>
                        <div class="col-md-6">
                            <div class="row toggle_btn">
                                <input type="checkbox" id="cbx_google" class="cbx hidden" name="google_login_status" value="true" <?php echo $settings_row->google_login_status=='true' ? 'checked=""' : '' ?>>
                                <label for="cbx_google" class="lbl" style="float: left"></label>
                            </div>
                        </div>
                      </div>
                      <br/>
                      <div class="container-fluid google_details">
                        <div style="border: 1px solid #ccc;padding:10px">
                          <div class="form-group">
                            <label class="col-md-3 control-label"><?=$this->lang->line('paypal_client_id_lbl')?>:-
                            </label>
                            <div class="col-md-9">
                              <input type="text" name="google_client_id" id="google_client_id" value="<?php echo $settings_row->google_client_id;?>" class="form-control"> 
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-md-3 control-label"><?=$this->lang->line('secret_key_lbl')?>:-
                            </label>
                            <div class="col-md-9">
                              <input type="text" name="google_secret_key" id="google_secret_key" value="<?php echo $settings_row->google_secret_key;?>" class="form-control"> 
                            </div>
                          </div>
                        </div>
                          
                        <br/>
                      </div>
                      <br/>
                      <div class="form-group">
                        <label class="col-md-3 control-label"><?=$this->lang->line('fb_login_lbl')?>:-</label>
                        <div class="col-md-6">
                            <div class="row toggle_btn">
                                <input type="checkbox" id="cbx_facebook" class="cbx hidden" name="facebook_status" value="true" <?php echo $settings_row->facebook_status=='true' ? 'checked=""' : '' ?>>
                                <label for="cbx_facebook" class="lbl" style="float: left"></label>
                            </div>
                        </div>
                      </div>
                      <br/>
                      <div class="container-fluid facebook_details">
                        <div style="border: 1px solid #ccc;padding:10px">
                          <div class="form-group">
                            <label class="col-md-3 control-label"><?=$this->lang->line('fb_app_id_lbl')?>:-
                            </label>
                            <div class="col-md-9">
                              <input type="text" name="facebook_app_id" id="facebook_app_id" value="<?php echo $settings_row->facebook_app_id;?>" class="form-control"> 
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-md-3 control-label"><?=$this->lang->line('fb_app_secret_lbl')?>:-
                            </label>
                            <div class="col-md-9">
                              <input type="text" name="facebook_app_secret" id="facebook_app_secret" value="<?php echo $settings_row->facebook_app_secret;?>" class="form-control"> 
                            </div>
                          </div>
                        </div>
                      </div>

                      <br/>
                      <div class="form-group">
                        <div class="col-md-9 col-md-offset-3">
                          <button type="submit" name="login_submit" class="btn btn-primary"><?=$this->lang->line('save_btn')?></button>
                        </div>
                      </div>
                      
                  </form>
              </div>
              <!-- end login tab -->

              <div role="tabpanel" class="tab-pane" id="page_settings">
                <ul class="nav nav-tabs page_settings_nav" role="tablist">
                  <li role="presentation" class="active"><a href="#about_us" aria-controls="about_us" role="tab" data-toggle="tab"><?=$this->lang->line('about_us_lbl')?></a></li>
                  <li role="presentation"><a href="#contact_us" aria-controls="contact_us" role="tab" data-toggle="tab"><?=$this->lang->line('contact_us_lbl')?></a></li>
                  <!--<li role="presentation"><a href="#terms_of_use" aria-controls="terms_of_use" role="tab" data-toggle="tab"><?=$this->lang->line('term_of_use_lbl')?></a></li>-->
                  <!--<li role="presentation"><a href="#privacy" aria-controls="privacy" role="tab" data-toggle="tab"><?=$this->lang->line('privacy_lbl')?></a></li>-->
                  <!--<li role="presentation"><a href="#refund_return" aria-controls="refund_return" role="tab" data-toggle="tab"><?=$this->lang->line('refund_return_policy_lbl')?></a></li>-->
                  <!--<li role="presentation"><a href="#cancellation" aria-controls="cancellation" role="tab" data-toggle="tab"><?=$this->lang->line('cancellation_lbl')?></a></li>-->
                  
                </ul>

                <div class="tab-content">

                  <div role="tabpanel" class="tab-pane active" id="about_us">
                    <form action="<?=site_url('admin/pages/save_setting')?>" method="post" class="form form-horizontal" enctype="multipart/form-data">
                      <input type="hidden" name="action_for" value="about_content">
                      <div class="section">
                        <div class="section-body">
                          <div class="form-group">
                            <label class="col-md-3 control-label"><?=$this->lang->line('page_title_lbl')?><span class="required_fields">*</span> :-</label>
                            <div class="col-md-7">
                              <input type="text" name="about_page_title" id="about_page_title" value='<?php echo $web_settings_row->about_page_title;?>' class="form-control" required="required">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-md-3 control-label"><?=$this->lang->line('content_lbl')?><span class="required_fields">*</span>:-</label>
                            <div class="col-md-7">
                         
                              <textarea name="about_content" id="about_content" required="" class="form-control"><?php echo $web_settings_row->about_content;?></textarea>
                              <script>CKEDITOR.replace( 'about_content' );</script>
                            </div>
                          </div>
                          <br/>
                          <div class="form-group">
                            <label class="col-md-3 control-label"><?=$this->lang->line('select_image_lbl')?> :-
                                <p class="control-label-help hint_lbl">(<?=$this->lang->line('recommended_resolution_lbl')?>: 1920X600)</p>
                                <p class="control-label-help hint_lbl">(<?=$this->lang->line('accept_img_files_lbl')?>)</p>
                                <p class="control-label-help hint_lbl">(<?=$this->lang->line('recommended_img_lbl')?>)</p>
                            </label>
                            <div class="col-md-6">
                              <div class="fileupload_block">
                                <input type="file" name="about_image" value="fileupload" <?=empty($web_settings_row->about_image) ? 'required="required"' : ''?> id="fileupload" accept=".gif, .jpg, .png, jpeg">
                                
                                <div class="fileupload_img"><img type="image" src="<?php 
                                  if(empty($web_settings_row->about_image)){ echo base_url('assets/images/no-image-1.jpg'); }else{  echo base_url('assets/images/').$web_settings_row->about_image; } 
                                ?>" alt="About image" style="width: 230px !important;height: 120px !important" /></div>
                                   
                              </div>
                            </div>
                          </div>
                          <hr/>

                          <div class="form-group">
                            <label class="col-md-3 control-label"><?=$this->lang->line('page_status_lbl')?>:-</label>
                            <div class="col-md-7">
                                <div class="row toggle_btn">
                                    <input type="checkbox" id="cbx_about_status" class="cbx hidden" name="about_status" value="true" <?php echo $web_settings_row->about_status=='true' ? 'checked=""' : '' ?>>
                                    <label for="cbx_about_status" class="lbl" style="float: left"></label>
                                </div>
                            </div>
                          </div>
                          <br/>
                          <div class="form-group">&nbsp;</div> 
                          <div class="form-group">
                            <div class="col-md-7 col-md-offset-3">
                              <button type="submit" name="submit" class="btn btn-primary"><?=$this->lang->line('save_btn')?></button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div role="tabpanel" class="tab-pane" id="contact_us">
                    <form action="<?=site_url('admin/pages/save_setting')?>" method="post" class="form form-horizontal" enctype="multipart/form-data">

                      <input type="hidden" name="action_for" value="contact_content">
                      <div class="form-group">
                        <label class="col-md-3 control-label"><?=$this->lang->line('page_title_lbl')?><span class="required_fields">*</span> :-</label>
                        <div class="col-md-7">
                          <input type="text" name="contact_page_title" id="contact_page_title" value='<?php echo $web_settings_row->contact_page_title;?>' class="form-control" required="required">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label">Address :-
                        </label>
                        <div class="col-md-7">
                          <input type="text" name="address" id="address" value="<?php echo $web_settings_row->address;?>" class="form-control">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-3 control-label">Contact Number :-
                        </label>
                        <div class="col-md-7">
                          <input type="text" name="contact_number" id="contact_number" value="<?php echo $web_settings_row->contact_number;?>" class="form-control">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-3 control-label">Contact Email :-
                        </label>
                        <div class="col-md-7">
                          <input type="text" name="contact_email" id="contact_email" value="<?php echo $web_settings_row->contact_email;?>" class="form-control">
                        </div>
                      </div>
                      <hr/>
                      <!--<div class="form-group">-->
                      <!--  <label class="col-md-3 control-label">Android App Link :--->
                      <!--  </label>-->
                      <!--  <div class="col-md-7">-->
                      <!--    <input type="text" name="android_app_url" id="android_app_url" value="<?php echo $web_settings_row->android_app_url;?>" class="form-control">-->
                      <!--  </div>-->
                      <!--</div>-->
                      <!--<div class="form-group">-->
                      <!--  <label class="col-md-3 control-label">iOS App Link :--->
                      <!--  </label>-->
                      <!--  <div class="col-md-7">-->
                      <!--    <input type="text" name="ios_app_url" id="ios_app_url" value="<?php echo $web_settings_row->ios_app_url;?>" class="form-control">-->
                      <!--  </div>-->
                      <!--</div>-->

                      

                      <div class="form-group">&nbsp;</div> 
                      <div class="form-group">
                        <div class="col-md-7 col-md-offset-3">
                          <button type="submit" name="submit" class="btn btn-primary"><?=$this->lang->line('save_btn')?></button>
                        </div>
                      </div>


                    </form>
                  </div>
                  <div role="tabpanel" class="tab-pane" id="terms_of_use">
                    <div class="section">
                    <div class="section-body">
                      
                      <div class="add_btn_primary" style="position: absolute;margin-top: 5px"> <a href="<?=site_url('admin/faq/add')?>?redirect=<?=$redirectUrl?>"><?=$this->lang->line('add_new_lbl')?></a> </div>

                      <table class="datatable table table-striped table-bordered table-hover" style="margin-top: 50px !important">
                        <thead>
                          <tr>
                            <th>#</th>             
                            <th><?=$this->lang->line('question_lbl')?></th>
                            <th><?=$this->lang->line('answer_lbl')?></th>
                            <th nowrap=""><?=$this->lang->line('status_lbl')?></th>
                            <th><?=$this->lang->line('action_lbl')?></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php  
                            $i=1;
                            foreach ($faq_row as $key => $value) {
                          ?>
                          <tr class="item_holder">
                            <td><?=$i++?></td>
                            <td>
                              <?=$value->faq_question?>
                            </td>
                            <td class="more">
                                <?=stripslashes($value->faq_answer)?>
                            </td>
                            <td>
                              <input type="checkbox" id="enable_disable_check_<?=$i?>" data-id="<?=$value->id?>" class="cbx hidden enable_disable" <?php if($value->status==1){ echo 'checked';} ?>>
                              <label for="enable_disable_check_<?=$i?>" class="lbl"></label>
                            </td>
                            <td nowrap="">
                              <a href="<?php echo site_url("admin/faq/edit/".$value->id);?>?redirect=<?=$redirectUrl?>" class="btn btn-primary btn_edit" data-toggle="tooltip" data-tooltip="<?=$this->lang->line('edit_lbl')?>"><i class="fa fa-edit"></i></a>

                              <a href="" class="btn btn-danger btn_delete" data-toggle="tooltip" data-id="<?=$value->id?>" data-tooltip="<?=$this->lang->line('delete_lbl')?>"><i class="fa fa-trash"></i></a>
                            </td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  </div>

                  <div role="tabpanel" class="tab-pane" id="privacy">
                    <form action="<?=site_url('admin/pages/save_setting')?>" method="post" class="form form-horizontal" enctype="multipart/form-data">

                      <input type="hidden" name="action_for" value="privacy">

                      <div class="section">
                        <div class="section-body">
                          <div class="form-group">
                            <label class="col-md-3 control-label"><?=$this->lang->line('page_title_lbl')?><span class="required_fields">*</span> :-</label>
                            <div class="col-md-7">
                              <input type="text" name="privacy_page_title" id="privacy_page_title" value='<?php echo $web_settings_row->privacy_page_title;?>' class="form-control" required="required">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-md-3 control-label"><?=$this->lang->line('content_lbl')?><span class="required_fields">*</span> :-</label>
                            <div class="col-md-7">
                         
                              <textarea name="privacy_content" id="privacy_content" class="form-control"><?php echo $web_settings_row->privacy_content;?></textarea>
                              <script>CKEDITOR.replace('privacy_content');</script>
                            </div>
                          </div>
                          <br/>
                          <div class="form-group">
                            <label class="col-md-3 control-label"><?=$this->lang->line('page_status_lbl')?>:-</label>
                            <div class="col-md-7">
                                <div class="row toggle_btn">
                                    <input type="checkbox" id="cbx_privacy" class="cbx hidden" name="privacy_page_status" value="true" <?php echo $web_settings_row->privacy_page_status=='true' ? 'checked=""' : '' ?>>
                                    <label for="cbx_privacy" class="lbl" style="float: left"></label>
                                </div>
                            </div>
                          </div>
                          <br/>
                          <div class="form-group">&nbsp;</div> 
                          <div class="form-group">
                            <div class="col-md-7 col-md-offset-3">
                              <button type="submit" name="submit" class="btn btn-primary"><?=$this->lang->line('save_btn')?></button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>

                  <div role="tabpanel" class="tab-pane" id="refund_return">
                    <form action="<?=site_url('admin/pages/save_setting')?>" method="post" class="form form-horizontal" enctype="multipart/form-data">

                      <input type="hidden" name="action_for" value="refund_return">

                      <div class="section">
                        <div class="section-body">
                          <div class="form-group">
                            <label class="col-md-3 control-label"><?=$this->lang->line('page_title_lbl')?><span class="required_fields">*</span> :-</label>
                            <div class="col-md-7">
                              <input type="text" name="refund_return_policy_page_title" id="refund_return_policy_page_title" value='<?php echo $web_settings_row->refund_return_policy_page_title;?>' class="form-control" required="required">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-md-3 control-label"><?=$this->lang->line('content_lbl')?><span class="required_fields">*</span> :-</label>
                            <div class="col-md-7">
                              <textarea name="refund_return_policy" id="refund_return_policy" class="form-control"><?php echo $web_settings_row->refund_return_policy;?></textarea>
                              <script>CKEDITOR.replace('refund_return_policy');</script>
                            </div>
                          </div>
                          <br/>
                          <div class="form-group">
                            <label class="col-md-3 control-label"><?=$this->lang->line('page_status_lbl')?>:-</label>
                            <div class="col-md-7">
                                <div class="row toggle_btn">
                                    <input type="checkbox" id="cbx_refund_return" class="cbx hidden" name="refund_return_policy_status" value="true" <?php echo $web_settings_row->refund_return_policy_status=='true' ? 'checked=""' : '' ?>>
                                    <label for="cbx_refund_return" class="lbl" style="float: left"></label>
                                </div>
                            </div>
                          </div>
                          <br/>
                          <div class="form-group">&nbsp;</div> 
                          <div class="form-group">
                            <div class="col-md-7 col-md-offset-3">
                              <button type="submit" name="submit" class="btn btn-primary"><?=$this->lang->line('save_btn')?></button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>

                  <div role="tabpanel" class="tab-pane" id="cancellation">
                    <form action="<?=site_url('admin/pages/save_setting')?>" method="post" class="form form-horizontal" enctype="multipart/form-data">
                      <input type="hidden" name="action_for" value="cancellation">
                      <div class="section">
                        <div class="section-body">
                          <div class="form-group">
                            <label class="col-md-3 control-label"><?=$this->lang->line('page_title_lbl')?><span class="required_fields">*</span> :-</label>
                            <div class="col-md-7">
                              <input type="text" name="cancellation_page_title" id="cancellation_page_title" value='<?php echo $web_settings_row->cancellation_page_title;?>' class="form-control" required="required">
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="col-md-3 control-label"><?=$this->lang->line('content_lbl')?><span class="required_fields">*</span> :-</label>
                            <div class="col-md-7">
                         
                              <textarea name="cancellation_content" id="cancellation_content" class="form-control"><?php echo $web_settings_row->cancellation_content;?></textarea>
                              <script>CKEDITOR.replace('cancellation_content');</script>
                            </div>
                          </div>
                          <br/>
                          <div class="form-group">
                            <label class="col-md-3 control-label"><?=$this->lang->line('page_status_lbl')?>:-</label>
                            <div class="col-md-7">
                                <div class="row toggle_btn">
                                    <input type="checkbox" id="cbx_cancellation" class="cbx hidden" name="cancellation_page_status" value="true" <?php echo $web_settings_row->cancellation_page_status=='true' ? 'checked=""' : '' ?>>
                                    <label for="cbx_cancellation" class="lbl" style="float: left"></label>
                                </div>
                            </div>
                          </div>
                          <br/>
                          <div class="form-group">&nbsp;</div> 
                          <div class="form-group">
                            <div class="col-md-7 col-md-offset-3">
                              <button type="submit" name="submit" class="btn btn-primary"><?=$this->lang->line('save_btn')?></button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>

                </div>

              </div>

              <!-- for ads place tab -->
              <div role="tabpanel" class="tab-pane" id="ads_place">
                <form action="<?=site_url('admin/pages/save_setting')?>" method="post" class="form form-horizontal" enctype="multipart/form-data">

                  <input type="hidden" name="action_for" value="ads_place">

                  <div class="section">
                    <div class="section-body">
                      <h4><?=$this->lang->line('home_page_ads_lbl')?></h4>
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="col-md-2 control-label"><?=$this->lang->line('banner_ads_status_lbl')?>:-</label>
                              <div class="col-md-7">
                                  <div class="row toggle_btn">
                                      <input type="checkbox" id="cbx_home_ad" class="cbx hidden" name="home_ad" value="true" <?php echo $web_settings_row->home_ad=='true' ? 'checked=""' : '' ?>>
                                      <label for="cbx_home_ad" class="lbl" style="float: left"></label>
                                  </div>
                              </div>
                            </div>
                            <br/>
                            <div class="form-group">
                              <label class="col-md-2 control-label"><?=$this->lang->line('banner_ads_code_lbl')?>:-</label>
                              <div class="col-md-7">
                                <textarea name="home_banner_ad" rows="5" class="form-control"><?php echo htmlentities($web_settings_row->home_banner_ad);?></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <hr/>
                      <h4><?=$this->lang->line('product_page_ads_lbl')?></h4>
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label class="col-md-2 control-label"><?=$this->lang->line('ads_status_lbl')?>:-</label>
                              <div class="col-md-7">
                                  <div class="row toggle_btn">
                                      <input type="checkbox" id="cbx_product_ad" class="cbx hidden" name="product_ad" value="true" <?php echo $web_settings_row->product_ad=='true' ? 'checked=""' : '' ?>>
                                      <label for="cbx_product_ad" class="lbl" style="float: left"></label>
                                  </div>
                              </div>
                            </div>
                            <br/>
                            <div class="form-group">
                              <label class="col-md-2 control-label"><?=$this->lang->line('ads_code_lbl')?>:-</label>
                              <div class="col-md-7">
                           
                                <textarea name="product_banner_ad" rows="5" class="form-control"><?php echo htmlentities($web_settings_row->product_banner_ad);?></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <div class="form-group">&nbsp;</div> 
                      <div class="form-group">
                        <div class="col-md-7 col-md-offset-2">
                          <button type="submit" name="submit" class="btn btn-primary"><?=$this->lang->line('save_btn')?></button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <!-- end ads place tab -->


              <div role="tabpanel" class="tab-pane" id="eco_warrior">
                <form action="<?=site_url('admin/pages/save_setting')?>" method="post" class="form form-horizontal" enctype="multipart/form-data">

                  <input type="hidden" name="action_for" value="eco_warrior">

                  <div class="section">
                    <div class="section-body">
                      <div class="container-fluid">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <!-- <label class="col-md-2 control-label">Youtube embed code:-</label>
                              <div class="col-md-7">
                                  <div class="row toggle_btn">
                                      <input type="text" id="cbx_home_ad" class="cbx hidden" name="eco_youtube_embed_code" value="<?php echo $web_settings_row->eco_youtube_embed_code; ?>" >
                                      <label for="cbx_home_ad" class="lbl" style="float: left"></label>
                                  </div>
                              </div>
 -->
                              <label class="col-md-3 control-label">Youtube embed code<span class="required_fields">*</span> :-</label>
                              <div class="col-md-7">
                                <input type="text" name="eco_youtube_embed_code" id="eco_youtube_embed_code" value='<?php echo $web_settings_row->eco_youtube_embed_code;?>' class="form-control" required="required">
                              </div>


                            </div>
                            <br/>
                            <div class="form-group">
                              <label class="col-md-3 control-label">Content:-</label>
                              <div class="col-md-7">
                                <textarea name="eco_warrior_content" id="eco_warrior_content" class="form-control"><?php echo $web_settings_row->eco_warrior_content;?></textarea>
                                <script>CKEDITOR.replace('eco_warrior_content');</script>
                              </div>
                            </div>
                            <br/>
                            
                             <div class="form-group">
                              <!-- <label class="col-md-2 control-label">Youtube embed code:-</label>
                              <div class="col-md-7">
                                  <div class="row toggle_btn">
                                      <input type="text" id="cbx_home_ad" class="cbx hidden" name="eco_youtube_embed_code" value="<?php echo $web_settings_row->eco_youtube_embed_code; ?>" >
                                      <label for="cbx_home_ad" class="lbl" style="float: left"></label>
                                  </div>
                              </div>
 -->
                              <label class="col-md-3 control-label">Youtube embed code 2<span class="required_fields">*</span> :-</label>
                              <div class="col-md-7">
                                <input type="text" name="eco_youtube_embed_code1" id="eco_youtube_embed_code1" value='<?php echo $web_settings_row->eco_youtube_embed_code1;?>' class="form-control" required="required">
                              </div>


                            </div>
                            <br/>
                            <div class="form-group">
                              <label class="col-md-3 control-label">Content 2:-</label>
                              <div class="col-md-7">
                                <textarea name="eco_warrior_content1" id="eco_warrior_content1" class="form-control"><?php echo $web_settings_row->eco_warrior_content1;?></textarea>
                                <script>CKEDITOR.replace('eco_warrior_content1');</script>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                   
                      
                      <div class="form-group">&nbsp;</div> 
                      <div class="form-group">
                        <div class="col-md-7 col-md-offset-2">
                          <button type="submit" name="submit" class="btn btn-primary"><?=$this->lang->line('save_btn')?></button>
                        </div>
                      </div>
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

<!-- For Bootstrap Tags -->
<script src="<?=base_url('assets/bootstrap-tag/bootstrap-tagsinput.js')?>"></script>
<!-- End -->  

<script type="text/javascript">

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $("input[name='web_logo_1']").next(".fileupload_img").find("img").attr('src', e.target.result);
      }
      
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("input[name='web_logo_1']").change(function() { 
    readURL(this);
  });


  function readURL2(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $("input[name='web_logo_2']").next(".fileupload_img").find("img").attr('src', e.target.result);
      }
      
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("input[name='web_logo_2']").change(function() { 
    readURL2(this);
  });

  function readURL3(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $("input[name='web_favicon']").next(".fileupload_img").find("img").attr('src', e.target.result);
      }
      
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("input[name='web_favicon']").change(function() { 
    readURL3(this);
  });


  function readURL4(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $("input[name='about_image']").next(".fileupload_img").find("img").attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("input[name='about_image']").change(function() { 
    readURL4(this);
  });



  function urlParam(name){
    var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
    return results ? decodeURIComponent(results[1].replace(/\+/g, '%20')) : null;
  }

  $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
    document.title = $(this).text()+" | <?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_name?>";
  });

  var activeTab = localStorage.getItem('activeTab');
  
  if (window.location.href.indexOf('?page_settings') > 0) {
      localStorage.setItem('activeTab_Parent', '#page_settings');
      var activeTab_Parent = localStorage.getItem('activeTab_Parent');

      if(urlParam('page')!=null){
        activeTab = '#'+urlParam('page');
      }
  }else if (window.location.href.indexOf('?eco_warrior') > 0) {
      localStorage.setItem('activeTab_Parent', '#eco_warrior');
      var activeTab_Parent = localStorage.getItem('activeTab_Parent');

      if(urlParam('page')!=null){
        activeTab = '#'+urlParam('page');
      }
  }
  else{
      localStorage.setItem('activeTab_Parent', '#web_general_settings');
      var activeTab_Parent = localStorage.getItem('activeTab_Parent');
  }

  if(activeTab){
    $('.page_settings_nav a[href="' + activeTab + '"]').tab('show');
  }
  $('.nav-tabs a[href="' + activeTab_Parent + '"]').tab('show');

</script>