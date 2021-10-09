<?php 
// print_r($settings_row);
?>
<div class="row card_item_block" style="padding-left:30px;padding-right: 30px">
  <div class="col-sm-12 col-xs-12">
    <div class="card">
      <div class="card-header">
        Page Settings
      </div>
      <div class="clearfix"></div>
      <div class="row mrg-top">
        <div class="col-md-12">
          <?php
          if($this->session->flashdata('response_msg')) {
          $message = $this->session->flashdata('response_msg');
          ?>
          <div class="<?=$message['class']?> alert-dismissible" role="alert" style="margin-left: 30px;margin-right: 30px">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
          <?=$message['message']?>
          </div>
          <?php
          }
          ?>
        </div>
      </div>

      <!-- card body -->

      <div class="card-body mrg_bottom">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#ads_place" aria-controls="ads_place" role="tab" data-toggle="tab"> Ads Places</a></li>
          <li role="presentation"><a href="#about_us" aria-controls="about_us" role="tab" data-toggle="tab"> About Us</a></li>
          <li role="presentation"><a href="#contact_us" aria-controls="contact_us" role="tab" data-toggle="tab"> Contact Us</a></li>
          <li role="presentation"><a href="#faq" aria-controls="faq" role="tab" data-toggle="tab"> FAQ</a></li>
          <li role="presentation"><a href="#terms_of_use" aria-controls="terms_of_use" role="tab" data-toggle="tab"> Terms Of Use</a></li>
          <li role="presentation"><a href="#privacy" aria-controls="privacy" role="tab" data-toggle="tab"> Privacy</a></li>
          <li role="presentation"><a href="#refund_return" aria-controls="refund_return" role="tab" data-toggle="tab"> Refund & Return Policy</a></li>
          <li role="presentation"><a href="#cancellation" aria-controls="cancellation" role="tab" data-toggle="tab"> Cancellation</a></li>
        </ul>

        <div class="tab-content">
          <div role="tabpanel" class="tab-pane active" id="ads_place">
            <form action="<?=site_url('admin/pages/save_setting')?>" method="post" class="form form-horizontal" enctype="multipart/form-data">

              <input type="hidden" name="action_for" value="ads_place">

              <div class="section">
                <div class="section-body">
                  <h4>Home Page Ads (Banner Ads Size is Width:1170, Height:151)</h4>
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="col-md-2 control-label">Banner Ad Status:-</label>
                          <div class="col-md-7">
                              <div class="row toggle_btn">
                                  <input type="checkbox" id="cbx_home_ad" class="cbx hidden" name="home_ad" value="true" <?php echo $settings_row->home_ad=='true' ? 'checked=""' : '' ?>>
                                  <label for="cbx_home_ad" class="lbl" style="float: left"></label>
                              </div>
                          </div>
                        </div>
                        <br/>
                        <div class="form-group">
                          <label class="col-md-2 control-label">Banner Ad Code :-</label>
                          <div class="col-md-7">
                       
                            <textarea name="home_banner_ad" rows="5" class="form-control"><?php echo $settings_row->home_banner_ad;?></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr/>
                  <h4>Product Page Ads (Banner Ads Size is Width:300)</h4>
                  <div class="container-fluid">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label class="col-md-2 control-label">Ad Status:-</label>
                          <div class="col-md-7">
                              <div class="row toggle_btn">
                                  <input type="checkbox" id="cbx_product_ad" class="cbx hidden" name="product_ad" value="true" <?php echo $settings_row->product_ad=='true' ? 'checked=""' : '' ?>>
                                  <label for="cbx_product_ad" class="lbl" style="float: left"></label>
                              </div>
                          </div>
                        </div>
                        <br/>
                        <div class="form-group">
                          <label class="col-md-2 control-label">Ad Code :-</label>
                          <div class="col-md-7">
                       
                            <textarea name="product_banner_ad" rows="5" class="form-control"><?php echo $settings_row->product_banner_ad;?></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="form-group">&nbsp;</div> 
                  <div class="form-group">
                    <div class="col-md-7 col-md-offset-2">
                      <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div role="tabpanel" class="tab-pane" id="about_us">
            <form action="<?=site_url('admin/pages/save_setting')?>" method="post" class="form form-horizontal" enctype="multipart/form-data">

              <input type="hidden" name="action_for" value="about_content">

              <div class="section">
                <div class="section-body">
                  <div class="form-group">
                    <label class="col-md-3 control-label">About Content :-</label>
                    <div class="col-md-7">
                 
                      <textarea name="about_content" id="about_content" class="form-control"><?php echo $settings_row->about_content;?></textarea>
                      <script>CKEDITOR.replace( 'about_content' );</script>
                    </div>
                  </div>
                  <div class="form-group">&nbsp;</div> 
                  <div class="form-group">
                    <div class="col-md-7 col-md-offset-3">
                      <button type="submit" name="submit" class="btn btn-primary">Save</button>
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
                <label class="col-md-3 control-label">Address :-
                </label>
                <div class="col-md-7">
                  <input type="text" name="address" id="address" value="<?php echo $settings_row->address;?>" class="form-control">
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label">Contact Number :-
                </label>
                <div class="col-md-7">
                  <input type="text" name="contact_number" id="contact_number" value="<?php echo $settings_row->contact_number;?>" class="form-control">
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label">Contact Email :-
                </label>
                <div class="col-md-7">
                  <input type="text" name="contact_email" id="contact_email" value="<?php echo $settings_row->contact_email;?>" class="form-control">
                </div>
              </div>

              <hr/>
              <div class="form-group">
                <label class="col-md-3 control-label" style="font-size: 18px">Social Media :-
                </label>
                <div class="col-md-7">
                </div>
              </div>
              <hr/>
              <div class="form-group">
                <label class="col-md-3 control-label">Facebook :-
                </label>
                <div class="col-md-7">
                  <input type="text" name="facebook_url" id="facebook_url" value="<?php echo $settings_row->facebook_url;?>" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Twitter :-
                </label>
                <div class="col-md-7">
                  <input type="text" name="twitter_url" id="twitter_url" value="<?php echo $settings_row->twitter_url;?>" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Youtube :-
                </label>
                <div class="col-md-7">
                  <input type="text" name="youtube_url" id="youtube_url" value="<?php echo $settings_row->youtube_url;?>" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label">Instagram :-
                </label>
                <div class="col-md-7">
                  <input type="text" name="instagram_url" id="instagram_url" value="<?php echo $settings_row->instagram_url;?>" class="form-control">
                </div>
              </div>

              <div class="form-group">&nbsp;</div> 
              <div class="form-group">
                <div class="col-md-7 col-md-offset-3">
                  <button type="submit" name="submit" class="btn btn-primary">Save</button>
                </div>
              </div>


            </form>
          </div>
          
          <div role="tabpanel" class="tab-pane" id="faq">
            <form action="<?=site_url('admin/pages/save_setting')?>" method="post" class="form form-horizontal" enctype="multipart/form-data">

              <input type="hidden" name="action_for" value="faq_content">

              <div class="section">
                <div class="section-body">
                  <div class="form-group">
                    <label class="col-md-3 control-label">FAQ :-</label>
                    <div class="col-md-7">
                 
                      <textarea name="app_faq" id="app_faq" class="form-control"><?php echo $settings_row->app_faq;?></textarea>
                      <script>CKEDITOR.replace('app_faq');</script>
                    </div>
                  </div>
                  <div class="form-group">&nbsp;</div> 
                  <div class="form-group">
                    <div class="col-md-7 col-md-offset-3">
                      <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>

          <div role="tabpanel" class="tab-pane" id="terms_of_use">
            <form action="<?=site_url('admin/pages/save_setting')?>" method="post" class="form form-horizontal" enctype="multipart/form-data">

              <input type="hidden" name="action_for" value="terms_of_use">

              <div class="section">
                <div class="section-body">
                  <div class="form-group">
                    <label class="col-md-3 control-label">Terms Of Use :-</label>
                    <div class="col-md-7">
                 
                      <textarea name="terms_of_use_content" id="terms_of_use_content" class="form-control"><?php echo $settings_row->terms_of_use_content;?></textarea>
                      <script>CKEDITOR.replace('terms_of_use_content');</script>
                    </div>
                  </div>
                  <div class="form-group">&nbsp;</div> 
                  <div class="form-group">
                    <div class="col-md-7 col-md-offset-3">
                      <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>

          <div role="tabpanel" class="tab-pane" id="privacy">
            <form action="<?=site_url('admin/pages/save_setting')?>" method="post" class="form form-horizontal" enctype="multipart/form-data">

              <input type="hidden" name="action_for" value="privacy">

              <div class="section">
                <div class="section-body">
                  <div class="form-group">
                    <label class="col-md-3 control-label">Privacy :-</label>
                    <div class="col-md-7">
                 
                      <textarea name="privacy_content" id="privacy_content" class="form-control"><?php echo $settings_row->privacy_content;?></textarea>
                      <script>CKEDITOR.replace('privacy_content');</script>
                    </div>
                  </div>
                  <div class="form-group">&nbsp;</div> 
                  <div class="form-group">
                    <div class="col-md-7 col-md-offset-3">
                      <button type="submit" name="submit" class="btn btn-primary">Save</button>
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
                    <label class="col-md-3 control-label">Refund & Return Policy :-</label>
                    <div class="col-md-7">
                 
                      <textarea name="refund_return_policy" id="refund_return_policy" class="form-control"><?php echo $settings_row->refund_return_policy;?></textarea>
                      <script>CKEDITOR.replace('refund_return_policy');</script>
                    </div>
                  </div>
                  <div class="form-group">&nbsp;</div> 
                  <div class="form-group">
                    <div class="col-md-7 col-md-offset-3">
                      <button type="submit" name="submit" class="btn btn-primary">Save</button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>


        </div>

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
  });

  var activeTab = localStorage.getItem('activeTab');
  if(activeTab){
    $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
  }

  if($("#cbx_paypal").is(":checked")){
    $(".paypal_details").show();
  }
  else{
    $(".paypal_details").hide();
  }

  if($("#cbx_stripe").is(":checked")){
    $(".stripe_details").show();
  }
  else{
    $(".stripe_details").hide();
  }


  $("#cbx_paypal").on("click",function(e){
    if($(this).is(":checked")){
      $(".paypal_details").show();
    }
    else{
      $(".paypal_details").hide();
    }
  });

  $("#cbx_stripe").on("click",function(e){
    if($(this).is(":checked")){
      $(".stripe_details").show();
    }
    else{
      $(".stripe_details").hide();
    }
  });

</script>