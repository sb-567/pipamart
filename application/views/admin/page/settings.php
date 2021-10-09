<?php

  define('APP_CURRENCY', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_currency_code);
  define('CURRENCY_CODE', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_currency_html_code);

  $home_category_ids=array();

  foreach ($home_category as $key => $value)
  {
    $home_category_ids[]=$value->id;
  }
?>

<style type="text/css">
  .select2 {
    width: 100% !important;
  }
  .dataTables_wrapper .top{
    top:auto !important;
    padding: 0px 20px 0px 0px !important;
  }
  .morecontent span {
      display: none;
  }
  .morelink {
      display: block;
  }
</style>
<div class="row card_item_block" style="padding-left:30px;padding-right: 30px">
  <div class="col-sm-12 col-xs-12">
    <div class="card">
      <div class="card-header">
        <?= $page_title ?>
      </div>
      <div class="clearfix"></div>
      <!-- card body -->

      <div class="card-body mrg_bottom" style="padding: 0px">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          
          <li role="presentation" class="active"><a href="#general_settings" aria-controls="general_settings" role="tab" data-toggle="tab"><i class="fa fa-wrench"></i> <?= $this->lang->line('general_setting_lbl') ?></a></li>
          
          <li role="presentation"><a href="#payment_settings" aria-controls="payment_settings" role="tab" data-toggle="tab"><i class="fa fa-credit-card"></i> <?= $this->lang->line('payment_lbl') ?></a></li>
          
          <li role="presentation"><a href="#smtp_settings" aria-controls="smtp_settings" role="tab" data-toggle="tab"><i class="fa fa-envelope"></i> <?= $this->lang->line('smtp_setting_lbl') ?></a></li>

          <li role="presentation"><a href="#scroll" aria-controls="faq" role="tab" data-toggle="tab"><i class="fa fa-question-circle" aria-hidden="true"></i> Bottom Slider </a></li>
          <!--<li role="presentation"><a href="#faq" aria-controls="faq" role="tab" data-toggle="tab"><i class="fa fa-question-circle" aria-hidden="true"></i> <?=$this->lang->line('faq_lbl')?></a></li>-->
          <!--<li role="presentation"><a href="#payments" aria-controls="payments" role="tab" data-toggle="tab"><i class="fa fa-question-circle" aria-hidden="true"></i> <?=$this->lang->line('payments_lbl')?></a></li>-->

          <!--<li role="presentation"><a href="#home_content" aria-controls="home_content" role="tab" data-toggle="tab"><i class="fa fa-home" aria-hidden="true"></i> <?=$this->lang->line('home_content_lbl')?></a></li>-->

        </ul>

        <div class="rows">
          <div class="col-md-12">
            <div class="tab-content">
              <div role="tabpanel" class="tab-pane active" id="general_settings">
                <form action="<?= site_url('admin/pages/save_setting') ?>" method="post" class="form form-horizontal" enctype="multipart/form-data">

                  <input type="hidden" name="action_for" value="general_settings">

                  <div class="section">
                    <div class="section-body">

                      <div class="form-group">
                        <label class="col-md-4 control-label"><?= $this->lang->line('order_email_lbl') ?> :-
                          <p class="control-label-help hint_lbl">(<?= $this->lang->line('order_email_note_lbl') ?>)</p>
                        </label>
                        <div class="col-md-6">
                          <input type="text" name="app_order_email" id="app_order_email" value="<?php echo $settings_row->app_order_email; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group" style="">
                        <label class="col-md-4 control-label"><?= $this->lang->line('contact_email_lbl') ?> <span style="color: red">*</span>:-
                          <p class="control-label-help hint_lbl">(<?= $this->lang->line('contact_email_note_lbl') ?>)</p>
                        </label>
                        <div class="col-md-6">
                          <input type="text" name="app_email" id="app_email" value="<?php echo $settings_row->app_email; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group" style="">
                        <label class="col-md-4 control-label"><?= $this->lang->line('currency_code_lbl') ?> <span style="color: red">*</span>:-</label>
                        <div class="col-md-3">
                          <p><a href="https://html-css-js.com/html/character-codes/currency" title="Click to get others" target="_blank"><?= $this->lang->line('currency_code_lbl') ?> (e.g. India => INR)</a></p>
                          <input type="text" name="app_currency_code" id="app_currency_code" value="<?php echo $settings_row->app_currency_code; ?>" class="form-control">
                        </div>
                        <div class="col-md-3">
                          <p><a href="https://html-css-js.com/html/character-codes/currency" title="Click to get others" target="_blank"><?= $this->lang->line('currency_sign_lbl') ?></a></p>
                          <input type="text" name="app_currency_html_code" id="app_currency_html_code" value="<?php echo $settings_row->app_currency_html_code; ?>" class="form-control">
                        </div>
                      </div>

                      <hr />
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?= $this->lang->line('otp_op_lbl') ?>:-
                          <p class="control-label-help hint_lbl">(<?= $this->lang->line('otp_op_hint_lbl') ?>)</p>
                        </label>
                        <div class="col-md-8">
                          <div class="row toggle_btn">
                            <input type="checkbox" id="cbx_otp_op" class="cbx hidden" name="email_otp_op_status" value="true" <?php echo $settings_row->email_otp_op_status == 'true' ? 'checked=""' : '' ?>>
                            <label for="cbx_otp_op" class="lbl" style="float: left"></label>
                          </div>
                        </div>
                      </div>
                      <hr />

                      <div class="form-group">
                        <label class="col-md-4 control-label"><?= $this->lang->line('admin_title_lbl') ?>:-</label>
                        <div class="col-md-6">
                          <input type="text" name="app_name" id="app_name" value="<?php echo $settings_row->app_name; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?= $this->lang->line('admin_logo_lbl') ?>:-
                          <p class="control-label-help hint_lbl">(<?= $this->lang->line('recommended_resolution_lbl') ?>: 300x300,400x400)</p>
                          <p class="control-label-help hint_lbl">(<?= $this->lang->line('accept_img_files_lbl') ?>)</p>
                        </label>
                        <div class="col-md-6">
                          <div class="fileupload_block">
                            <input type="file" name="app_logo" id="fileupload" accept=".gif, .jpg, .png, jpeg">

                            <?php
                            $img_path = base_url() . 'assets/images/';

                            if ($settings_row->app_logo != "" || file_exists($img_path . $settings_row->app_logo)) {
                              $img_url = $img_path . $settings_row->app_logo;
                            } else {
                              $img_url = $img_path . 'no-image-1.jpg';
                            }

                            ?>
                            <div class="fileupload_img"><img type="image" src="<?php echo $img_url; ?>" alt="image" style="width: 90px;height: 90px;" /></div>

                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?= $this->lang->line('admin_favicon_lbl') ?>:-
                          <p class="control-label-help hint_lbl">(<?= $this->lang->line('recommended_resolution_lbl') ?>: 16x16)</p>
                          <p class="control-label-help hint_lbl">(<?= $this->lang->line('accept_img_files_lbl') ?>)</p>
                        </label>

                        <div class="col-md-6">
                          <div class="fileupload_block">
                            <input type="file" name="web_favicon" id="fileupload" accept=".gif, .jpg, .png, jpeg" style="margin-top: 0px">

                            <?php
                            $img_path = base_url() . 'assets/images/';

                            if ($settings_row->web_favicon != "" || file_exists($img_path . $settings_row->web_favicon)) {
                              $img_url = $img_path . $settings_row->web_favicon;
                            } else {
                              $img_url = $img_path . 'no-image-1.jpg';
                            }

                            ?>
                            <div class="fileupload_img"><img type="image" src="<?php echo $img_url; ?>" alt="image" style="width: 16px !important;height: 16px !important;" /></div>

                          </div>
                        </div>
                      </div>
                      <br />
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?= $this->lang->line('author_lbl') ?>:-</label>
                        <div class="col-md-6">
                          <input type="text" name="app_author" id="app_author" value="<?php echo $settings_row->app_author; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?= $this->lang->line('app_description_lbl') ?>:-</label>
                        <div class="col-md-6">
                          <textarea name="app_description" id="app_description" class="form-control"><?php echo stripslashes($settings_row->app_description);?></textarea>
                            <script>CKEDITOR.replace( 'app_description' );</script>
                        </div>
                      </div>
                      <br/>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?= $this->lang->line('app_version_lbl') ?>:-</label>
                        <div class="col-md-6">
                          <input type="text" name="app_version" id="app_version" value="<?php echo $settings_row->app_version; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?= $this->lang->line('contact_lbl') ?>:-</label>
                        <div class="col-md-6">
                          <input type="text" name="app_contact" id="app_contact" value="<?php echo $settings_row->app_contact; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?= $this->lang->line('website_lbl') ?>:-</label>
                        <div class="col-md-6">
                          <input type="text" name="app_website" id="app_website" value="<?php echo $settings_row->app_website; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?= $this->lang->line('developed_by_lbl') ?>:-</label>
                        <div class="col-md-6">
                          <input type="text" name="app_developed_by" id="app_developed_by" value="<?php echo $settings_row->app_developed_by; ?>" class="form-control">
                        </div>
                      </div>
                      <hr />
                      <div class="form-group">
                        <label class="col-md-3 control-label" style="font-size: 18px"><?= $this->lang->line('social_media_lbl') ?>:-
                        </label>
                        <div class="col-md-6">
                        </div>
                      </div>
                      <hr />
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?= $this->lang->line('facebook_lbl') ?>:-
                        </label>
                        <div class="col-md-6">
                          <input type="text" name="facebook_url" id="facebook_url" value="<?php echo $settings_row->facebook_url; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?= $this->lang->line('twitter_lbl') ?>:-
                        </label>
                        <div class="col-md-6">
                          <input type="text" name="twitter_url" id="twitter_url" value="<?php echo $settings_row->twitter_url; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?= $this->lang->line('youtube_lbl') ?>:-
                        </label>
                        <div class="col-md-6">
                          <input type="text" name="youtube_url" id="youtube_url" value="<?php echo $settings_row->youtube_url; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?= $this->lang->line('instagram_lbl') ?>:-
                        </label>
                        <div class="col-md-6">
                          <input type="text" name="instagram_url" id="instagram_url" value="<?php echo $settings_row->instagram_url; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label">Linkedin:-
                        </label>
                        <div class="col-md-6">
                          <input type="text" name="linkedin_url" id="linkedin_url" value="<?php echo $settings_row->linkedin_url; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label">Whats'app:-
                        </label>
                        <div class="col-md-6">
                          <input type="text" name="whatsapp_url" id="whatsapp_url" value="<?php echo $settings_row->whatsapp_url; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-4 control-label">Blog:-
                        </label>
                        <div class="col-md-6">
                          <input type="text" name="blog_url" id="blog_url" value="<?php echo $settings_row->blog_url; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                          <button type="submit" name="submit" class="btn btn-primary"><?= $this->lang->line('save_btn') ?></button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <div role="tabpanel" class="tab-pane" id="payment_settings">
                <form action="<?= site_url('admin/pages/save_setting') ?>" method="post" class="form form-horizontal" enctype="multipart/form-data">
                  <input type="hidden" name="action_for" value="payment_settings">
                  <div class="form-group">
                    <label class="col-md-3 control-label"><?= $this->lang->line('cod_lbl') ?>:-</label>
                    <div class="col-md-6">
                      <div class="row toggle_btn">
                        <input type="checkbox" id="cbx_cod" class="cbx hidden" name="cod_status" value="true" <?php echo $settings_row->cod_status == 'true' ? 'checked=""' : '' ?>>
                        <label for="cbx_cod" class="lbl" style="float: left"></label>
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="form-group">
                    <label class="col-md-3 control-label"><?= $this->lang->line('paypal_lbl') ?>:-</label>
                    <div class="col-md-6">
                      <div class="row toggle_btn">
                        <input type="checkbox" id="cbx_paypal" class="cbx hidden" name="paypal_status" value="true" <?php echo $settings_row->paypal_status == 'true' ? 'checked=""' : '' ?>>
                        <label for="cbx_paypal" class="lbl" style="float: left"></label>
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="container-fluid paypal_details">
                    <div style="border: 1px solid #ccc;padding:10px">
                      <div class="form-group">
                        <label class="col-md-3 control-label"><?= $this->lang->line('paypal_payment_mode_lbl') ?>:-</label>
                        <div class="col-md-9">
                          <select class="select2" name="paypal_mode">
                            <option value="sandbox" <?= ($settings_row->paypal_mode == 'sandbox') ? 'selected' : ''; ?>><?= $this->lang->line('paypal_sendbox_mode_lbl') ?></option>
                            <option value="live" <?= ($settings_row->paypal_mode == 'live') ? 'selected' : ''; ?>><?= $this->lang->line('paypal_live_mode_lbl') ?></option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label"><?= $this->lang->line('paypal_client_id_lbl') ?>:-
                          <p class="control-label-help hint_lbl">(<?= $this->lang->line('paypal_mode_note_lbl') ?>)</p>
                        </label>
                        <div class="col-md-9">
                          <input type="text" name="paypal_client_id" id="paypal_client_id" value="<?php echo $settings_row->paypal_client_id; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label"><?= $this->lang->line('secret_key_lbl') ?>:-
                          <p class="control-label-help hint_lbl">(<?= $this->lang->line('paypal_mode_note_lbl') ?>)</p>
                        </label>
                        <div class="col-md-9">
                          <input type="text" name="paypal_secret_key" id="paypal_secret_key" value="<?php echo $settings_row->paypal_secret_key; ?>" class="form-control">
                        </div>
                      </div>
                    </div>

                    <br />
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label"><?= $this->lang->line('stripe_lbl') ?>:-</label>
                    <div class="col-md-6">
                      <div class="row toggle_btn">
                        <input type="checkbox" id="cbx_stripe" class="cbx hidden" name="stripe_status" value="true" <?php echo $settings_row->stripe_status == 'true' ? 'checked=""' : '' ?>>
                        <label for="cbx_stripe" class="lbl" style="float: left"></label>
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="container-fluid stripe_details">
                    <div style="border: 1px solid #ccc;padding:10px">
                      <div class="form-group">
                        <label class="col-md-3 control-label"><?= $this->lang->line('publisher_key_lbl') ?>:-</label>
                        <div class="col-md-9">
                          <input type="text" name="stripe_key" id="stripe_key" value="<?php echo $settings_row->stripe_key; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label"><?= $this->lang->line('secret_key_lbl') ?>:-</label>
                        <div class="col-md-9">
                          <input type="text" name="stripe_secret" id="stripe_secret" value="<?php echo $settings_row->stripe_secret; ?>" class="form-control">
                        </div>
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="form-group">

                    <label class="col-md-3 control-label"><?= $this->lang->line('razorpay_lbl') ?>:-</label>
                    <div class="col-md-6">
                      <div class="row toggle_btn">
                        <input type="checkbox" id="cbx_razorpay" data-currency="<?= APP_CURRENCY ?>" class="cbx hidden" name="razorpay_status" value="true" <?php echo ($settings_row->razorpay_status == 'true' and APP_CURRENCY == 'INR') ? 'checked=""' : '' ?>>
                        <label for="cbx_razorpay" class="lbl" style="float: left"></label>
                      </div>
                    </div>
                  </div>
                  <br />
                  <div class="container-fluid razorpay_details">
                    <div style="border: 1px solid #ccc;padding:10px">
                      <span style="color: #F00;font-weight: 500">(<?= $this->lang->line('razorpay_note_lbl') ?>)</span>
                      <bt />
                      <div class="form-group">
                        <label class="col-md-3 control-label"><?= $this->lang->line('key_id_lbl') ?>:-</label>
                        <div class="col-md-9">
                          <input type="text" name="razorpay_key" id="razorpay_key" value="<?php echo $settings_row->razorpay_key; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label"><?= $this->lang->line('key_secret_lbl') ?>:-</label>
                        <div class="col-md-9">
                          <input type="text" name="razorpay_secret" id="razorpay_secret" value="<?php echo $settings_row->razorpay_secret; ?>" class="form-control">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label"><?= $this->lang->line('select_color_lbl') ?> :-</label>
                        <div class="col-md-9">
                          <input type="text" name="razorpay_theme_color" id="razorpay_theme_color" value="<?php echo $settings_row->razorpay_theme_color; ?>" class="form-control jscolor" data-jscolor="{preset:'large', position:'top', borderColor:'#999', insetColor:'#FFF', backgroundColor:'#ddd'}" placeholder="Select razorpay theme color">
                        </div>
                      </div>

                    </div>
                  </div>
                  <br />
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                      <button type="submit" name="payment_submit" class="btn btn-primary"><?= $this->lang->line('save_btn') ?></button>
                    </div>
                  </div>

                </form>
              </div>
              <div role="tabpanel" class="tab-pane" id="smtp_settings">
                <form action="<?= site_url('admin/pages/save_setting') ?>" method="post" class="form form-horizontal" enctype="multipart/form-data">

                  <input type="hidden" name="action_for" value="smtp_settings">
                  <div class="form-group">
                    <label class="col-md-3 control-label"><?= $this->lang->line('smtp_library_lbl') ?> :-</label>
                    <div class="col-md-6">
                      <select name="smtp_library" class="select2" required="required">
                        <option value="ci" <?php if ($smtp->smtp_library == 'ci') { echo 'selected'; } ?>><?= $this->lang->line('smtp_library_ci_lbl') ?></option>
                        <option value="phpmailer" <?php if ($smtp->smtp_library == 'phpmailer') { echo 'selected'; } ?>><?= $this->lang->line('smtp_library_mailer_lbl') ?></option>
                      </select>
                    </div>
                  </div>
                  <hr/>
                  <div class="form-group">
                    <label class="col-md-3 control-label"><?= $this->lang->line('smtp_type_lbl') ?> <span style="color: red">*</span>:-</label>
                    <div class="col-md-6">
                      <div class="radio radio-inline" style="margin-top: 10px">
                        <input type="radio" name="smtp_type" id="gmail" value="gmail" <?php if ($smtp->smtp_type == 'gmail') { echo ' checked="" disabled="disabled"'; } ?>>
                        <label for="gmail">
                        <?= $this->lang->line('gmail_smtp_lbl') ?>
                        </label>
                      </div>
                      <div class="radio radio-inline" style="margin-top: 10px">
                        <input type="radio" name="smtp_type" id="server" value="server" <?php if ($smtp->smtp_type == 'server') { echo ' checked="" disabled="disabled"'; } ?>>
                        <label for="server">
                        <?= $this->lang->line('server_smtp_lbl') ?>
                        </label>
                      </div>
                    </div>
                  </div>
                  <br />

                  <input type="hidden" name="smtpIndex" value="<?= $smtp->smtp_type ?>">

                  <div class="gmailContent" <?php if ($smtp->smtp_type == 'gmail') { echo 'style="display:block"'; } else { echo 'style="display:none"';} ?>>
                    <div class="form-group">
                      <label class="col-md-3 control-label"><?= $this->lang->line('smtp_host_lbl') ?> <span style="color: red">*</span>:-</label>
                      <div class="col-md-6">
                        <input type="text" name="smtp_host[]" class="form-control" value="<?= $smtp->smtp_ghost ?>" placeholder="mail.example.in" <?php if ($smtp->smtp_type == 'gmail') { echo 'required';} ?>>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-3 control-label"><?= $this->lang->line('email_lbl') ?> <span style="color: red">*</span>:-</label>
                      <div class="col-md-6">
                        <input type="text" name="smtp_email[]" class="form-control" value="<?= $smtp->smtp_gemail ?>" placeholder="info@example.com" <?php if ($smtp->smtp_type == 'gmail') { echo 'required'; } ?>>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-3 control-label"><?= $this->lang->line('password_lbl') ?> <span style="color: red">*</span>:-</label>
                      <div class="col-md-6">
                        <input type="password" name="smtp_password[]" class="form-control" value="" placeholder="********">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="col-md-3 control-label"><?= $this->lang->line('smtp_secure_lbl') ?> :-</label>
                      <div class="col-md-3">
                        <select name="smtp_secure[]" class="select2" <?php if ($smtp->smtp_type == 'gmail') { echo 'required';} ?>>
                          <option value="tls" <?php if ($smtp->smtp_gsecure == 'tls') { echo 'selected'; } ?>>TLS</option>
                          <option value="ssl" <?php if ($smtp->smtp_gsecure == 'ssl') { echo 'selected'; } ?>>SSL</option>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <input type="text" name="port_no[]" class="form-control" value="<?= $smtp->gport_no ?>" <?php if ($smtp->smtp_type == 'gmail') { echo 'required'; } ?>>
                      </div>
                    </div>
                  </div>
                  
                  <div class="serverContent" <?php if ($smtp->smtp_type == 'server') { echo 'style="display:block"';} else {echo 'style="display:none"';} ?>>
                  <div class="form-group">
                    <label class="col-md-3 control-label"><?= $this->lang->line('smtp_host_lbl') ?> <span style="color: red">*</span>:-</label>
                    <div class="col-md-6">
                      <input type="text" name="smtp_host[]" id="smtp_host" class="form-control" value="<?= $smtp->smtp_host ?>" placeholder="mail.example.in" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label"><?= $this->lang->line('email_lbl') ?> <span style="color: red">*</span>:-</label>
                    <div class="col-md-6">
                      <input type="text" name="smtp_email[]" id="smtp_email" class="form-control" value="<?= $smtp->smtp_email ?>" placeholder="info@example.com" required>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label"><?= $this->lang->line('password_lbl') ?> <span style="color: red">*</span>:-</label>
                    <div class="col-md-6">
                      <input type="password" name="smtp_password[]" id="smtp_password" class="form-control" value="" placeholder="********">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label"><?= $this->lang->line('smtp_secure_lbl') ?> :-</label>
                    <div class="col-md-3">
                      <select name="smtp_secure[]" class="select2" required>
                        <option value="tls" <?php if ($smtp->smtp_secure == 'tls') { echo 'selected'; } ?>>TLS</option>
                        <option value="ssl" <?php if ($smtp->smtp_secure == 'ssl') { echo 'selected'; } ?>>SSL</option>
                      </select>
                    </div>
                    <div class="col-md-3">
                      <input type="text" name="port_no[]" id="port_no" class="form-control" value="<?= $smtp->port_no ?>" required>
                    </div>
                  </div>
                  </div>
                  <br />
                  <div class="form-group">
                    <div class="col-md-9 col-md-offset-3">
                      <button type="submit" name="submit" class="btn btn-primary"><?= $this->lang->line('save_btn') ?></button>
                    </div>
                  </div>

                </form>

                <br />
                <div class="alert alert-danger alert-dismissible fade in" role="alert">
                  <h4 id="oh-snap!-you-got-an-error!"><?= $this->lang->line('note_lbl') ?>:</h4>
                  <p><i class="fa fa-hand-o-right"></i> <?= $this->lang->line('smtp_note_point1_lbl') ?></p>
                  <p><i class="fa fa-hand-o-right"></i> <?= $this->lang->line('smtp_note_point2_lbl') ?></p>
                </div>

              </div>
              <div role="tabpanel" class="tab-pane search-faq-item" id="scroll">
                  <form action="<?=site_url('admin/pages/save_setting')?>" method="post" class="form form-horizontal" enctype="multipart/form-data">

                      <input type="hidden" name="action_for" value="scroll">
                      <div class="form-group">
                        <label class="col-md-3 control-label">Line 1 :-</label>
                        <div class="col-md-7">
                          <input type="text" name="line_one" id="line_one" value='<?php echo $settings_row->line_one;?>' class="form-control" >
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-md-3 control-label">Line 2 :-
                        </label>
                        <div class="col-md-7">
                          <input type="text" name="line_two" id="line_two" value="<?php echo $settings_row->line_two;?>" class="form-control">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-3 control-label">Line 3 :-
                        </label>
                        <div class="col-md-7">
                          <input type="text" name="line_three" id="line_three" value="<?php echo $settings_row->line_three;?>" class="form-control">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-md-3 control-label">Line 4 :-
                        </label>
                        <div class="col-md-7">
                          <input type="text" name="line_four" id="line_four" value="<?php echo $settings_row->line_four;?>" class="form-control">
                        </div>
                      </div>
                     

                      

                      <div class="form-group">&nbsp;</div> 
                      <div class="form-group">
                        <div class="col-md-7 col-md-offset-3">
                          <button type="submit" name="submit" class="btn btn-primary"><?=$this->lang->line('save_btn')?></button>
                        </div>
                      </div>


                    </form>
              </div>
              <!-- for faq tab -->
              <div role="tabpanel" class="tab-pane search-faq-item" id="faq">
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
              <!-- end faq tab -->

              <!-- for payment faq tab -->

              <div role="tabpanel" class="tab-pane search-faq-item" id="payments">
                <div class="section">
                    <div class="section-body">

                      <div class="add_btn_primary" style="position: absolute;margin-top: 5px"> <a href="<?=site_url('admin/payment-faq/add')?>?redirect=<?=$redirectUrl?>"><?=$this->lang->line('add_new_lbl')?></a> </div>
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
                            foreach ($payment_faq_row as $key => $value) {
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
                              <input type="checkbox" id="enable_disable_payment_check_<?=$i?>" data-id="<?=$value->id?>" class="cbx hidden enable_disable" <?php if($value->status==1){ echo 'checked';} ?>>
                              <label for="enable_disable_payment_check_<?=$i?>" class="lbl"></label>
                            </td>
                            <td nowrap="">
                              <a href="<?php echo site_url("admin/payment-faq/edit/".$value->id);?>?redirect=<?=$redirectUrl?>" class="btn btn-primary btn_edit" data-toggle="tooltip" data-tooltip="<?=$this->lang->line('edit_lbl')?>"><i class="fa fa-edit"></i></a>

                              <a href="" class="btn btn-danger btn_delete" data-toggle="tooltip" data-id="<?=$value->id?>" data-tooltip="<?=$this->lang->line('delete_lbl')?>"><i class="fa fa-trash"></i></a>
                            </td>
                          </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
              </div>
              <!-- end payment faq tab -->

              <!-- for home page tab -->
              <div role="tabpanel" class="tab-pane" id="home_content">
                <form action="<?=site_url('admin/pages/save_setting')?>" method="post" class="form form-horizontal" enctype="multipart/form-data">
                  <input type="hidden" name="action_for" value="home_content">
                  <div class="section">
                    <div class="section-body">
                      <p class="hint_lbl"><?=$this->lang->line('home_setting_note_lbl')?></p>
                      <br/>
                      <div class="form-group">
                        <label class="col-md-4 control-label" style="font-size: 16px;font-weight: 600"><?=$this->lang->line('section_title_lbl')?></label>
                        <label class="col-md-4 control-label" style="font-size: 16px;font-weight: 600"><?=$this->lang->line('for_web_lbl')?></label>
                        <label class="col-md-4 control-label" style="font-size: 16px;font-weight: 600"><?=$this->lang->line('for_app_lbl')?></label>
                      </div>
                      <hr/>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?=$this->lang->line('home_slider_op_lbl')?>:-</label>
                        <div class="col-md-4">
                            <div class="row toggle_btn">
                                <input type="checkbox" id="cbx_home_slider" class="cbx hidden" name="home_slider_opt" value="true" <?php echo $settings_row->home_slider_opt=='true' ? 'checked=""' : '' ?>>
                                <label for="cbx_home_slider" class="lbl" style="float: left"></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row toggle_btn">
                                <input type="checkbox" id="cbx_app_home_slider" class="cbx hidden" name="app_home_slider_opt" value="true" <?php echo $settings_row->app_home_slider_opt=='true' ? 'checked=""' : '' ?>>
                                <label for="cbx_app_home_slider" class="lbl" style="float: left"></label>
                            </div>
                        </div>
                      </div>
                      <hr/>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?=$this->lang->line('home_brand_op_lbl')?>:-</label>
                        <div class="col-md-4">
                            <div class="row toggle_btn">
                                <input type="checkbox" id="cbx_home_brand" class="cbx hidden" name="home_brand_opt" value="true" <?php echo $settings_row->home_brand_opt=='true' ? 'checked=""' : '' ?>>
                                <label for="cbx_home_brand" class="lbl" style="float: left"></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row toggle_btn">
                                <input type="checkbox" id="cbx_app_home_brand" class="cbx hidden" name="app_home_brand_opt" value="true" <?php echo $settings_row->app_home_brand_opt=='true' ? 'checked=""' : '' ?>>
                                <label for="cbx_app_home_brand" class="lbl" style="float: left"></label>
                            </div>
                        </div>
                      </div>
                      <hr/>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?=$this->lang->line('home_category_op_lbl')?>:-</label>
                        <div class="col-md-4">
                            <div class="row toggle_btn">
                                <input type="checkbox" id="cbx_home_category" class="cbx hidden" name="home_category_opt" value="true" <?php echo $settings_row->home_category_opt=='true' ? 'checked=""' : '' ?>>
                                <label for="cbx_home_category" class="lbl" style="float: left"></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row toggle_btn">
                                <input type="checkbox" id="cbx_app_home_category" class="cbx hidden" name="app_home_category_opt" value="true" <?php echo $settings_row->app_home_category_opt=='true' ? 'checked=""' : '' ?>>
                                <label for="cbx_app_home_category" class="lbl" style="float: left"></label>
                            </div>
                        </div>
                      </div>
                      <hr/>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?=$this->lang->line('home_offer_op_lbl')?>:-</label>
                        <div class="col-md-4">
                            <div class="row toggle_btn">
                                <input type="checkbox" id="cbx_home_offer" class="cbx hidden" name="home_offer_opt" value="true" <?php echo $settings_row->home_offer_opt=='true' ? 'checked=""' : '' ?>>
                                <label for="cbx_home_offer" class="lbl" style="float: left"></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row toggle_btn">
                                <input type="checkbox" id="cbx_app_home_offer" class="cbx hidden" name="app_home_offer_opt" value="true" <?php echo $settings_row->app_home_offer_opt=='true' ? 'checked=""' : '' ?>>
                                <label for="cbx_app_home_offer" class="lbl" style="float: left"></label>
                            </div>
                        </div>
                      </div>
                      <hr/>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?=$this->lang->line('home_hot_deal_op_lbl')?>:-</label>
                        <div class="col-md-4">
                            <div class="row toggle_btn">
                                <input type="checkbox" id="cbx_home_flash" class="cbx hidden" name="home_flase_opt" value="true" <?php echo $settings_row->home_flase_opt=='true' ? 'checked=""' : '' ?>>
                                <label for="cbx_home_flash" class="lbl" style="float: left"></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row toggle_btn">
                                <input type="checkbox" id="cbx_app_home_flash" class="cbx hidden" name="app_home_flase_opt" value="true" <?php echo $settings_row->app_home_flase_opt=='true' ? 'checked=""' : '' ?>>
                                <label for="cbx_app_home_flash" class="lbl" style="float: left"></label>
                            </div>
                        </div>
                      </div>
                      <hr/>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?=$this->lang->line('home_latest_op_lbl')?>:-</label>
                        <div class="col-md-4">
                            <div class="row toggle_btn">
                                <input type="checkbox" id="cbx_home_latest" class="cbx hidden" name="home_latest_opt" value="true" <?php echo $settings_row->home_latest_opt=='true' ? 'checked=""' : '' ?>>
                                <label for="cbx_home_latest" class="lbl" style="float: left"></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row toggle_btn">
                                <input type="checkbox" id="cbx_app_home_latest" class="cbx hidden" name="app_home_latest_opt" value="true" <?php echo $settings_row->app_home_latest_opt=='true' ? 'checked=""' : '' ?>>
                                <label for="cbx_app_home_latest" class="lbl" style="float: left"></label>
                            </div>
                        </div>
                      </div>
                      <hr/>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?=$this->lang->line('home_top_rated_op_lbl')?>:-
                          <p class="hint_lbl">(<?=$this->lang->line('home_top_rated_op_hint_lbl')?>)</p>
                        </label>
                        <div class="col-md-4">
                            <div class="row toggle_btn">
                                <input type="checkbox" id="cbx_home_top_rated" class="cbx hidden" name="home_top_rated_opt" value="true" <?php echo $settings_row->home_top_rated_opt=='true' ? 'checked=""' : '' ?>>
                                <label for="cbx_home_top_rated" class="lbl" style="float: left"></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row toggle_btn">
                                <input type="checkbox" id="cbx_app_home_top_rated" class="cbx hidden" name="app_home_top_rated_opt" value="true" <?php echo $settings_row->app_home_top_rated_opt=='true' ? 'checked=""' : '' ?>>
                                <label for="cbx_app_home_top_rated" class="lbl" style="float: left"></label>
                            </div>
                        </div>
                        <div class="col-md-7 col-md-offset-4">
                            <div class="row">
                              <div class="form-group">
                                <label class="col-md-12 control-label"><?=$this->lang->line('min_rate_lbl')?><span class="required_fields">*</span> :-</label>
                                <div class="col-md-12">
                                  <input type="number" name="min_rate" id="min_rate" min="3" value='<?php echo $settings_row->min_rate;?>' class="form-control" required="required">
                                </div>
                              </div>
                            </div>
                        </div>
                      </div>
                      <hr/>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?=$this->lang->line('home_cat_wise_op_lbl')?>:-</label>
                        <div class="col-md-4">
                          <div class="row toggle_btn">
                              <input type="checkbox" id="cbx_home_cat_wise" class="cbx hidden" name="home_cat_wise_opt" value="true" <?php echo $settings_row->home_cat_wise_opt=='true' ? 'checked=""' : '' ?>>
                              <label for="cbx_home_cat_wise" class="lbl" style="float: left"></label>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="row toggle_btn">
                              <input type="checkbox" id="cbx_app_home_cat_wise" class="cbx hidden" name="app_home_cat_wise_opt" value="true" <?php echo $settings_row->app_home_cat_wise_opt=='true' ? 'checked=""' : '' ?>>
                              <label for="cbx_app_home_cat_wise" class="lbl" style="float: left"></label>
                          </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-7 col-md-offset-4">
                            <div class="row" style="margin-top: 20px">
                              <p><?=$this->lang->line('select_cats_lbl')?></p>
                              <select class="select2" name="home_category[]" multiple="">
                                <?php 
                                  foreach ($category_list as $key => $value) {
                                    ?>
                                    <option value="<?=$value->id?>" <?=(in_array($value->id, $home_category_ids)) ? 'selected' : ''?>><?=$value->category_name?></option>
                                    <?php
                                  }
                                ?>
                              </select>
                            </div>
                        </div>
                      </div>
                      <hr/>
                      <div class="form-group">
                        <label class="col-md-4 control-label"><?=$this->lang->line('home_recent_op_lbl')?>:-</label>
                        <div class="col-md-4">
                            <div class="row toggle_btn">
                                <input type="checkbox" id="cbx_home_recent" class="cbx hidden" name="home_recent_opt" value="true" <?php echo $settings_row->home_recent_opt=='true' ? 'checked=""' : '' ?>>
                                <label for="cbx_home_recent" class="lbl" style="float: left"></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row toggle_btn">
                                <input type="checkbox" id="cbx_app_home_recent" class="cbx hidden" name="app_home_recent_opt" value="true" <?php echo $settings_row->app_home_recent_opt=='true' ? 'checked=""' : '' ?>>
                                <label for="cbx_app_home_recent" class="lbl" style="float: left"></label>
                            </div>
                        </div>
                      </div>
                      <br/>
                      <div class="form-group">&nbsp;</div> 
                      <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                          <button type="submit" name="submit" class="btn btn-primary"><?=$this->lang->line('save_btn')?></button>
                        </div>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
              <!-- end home page tab -->

            </div>
          </div>
        </div>

        <div class="clearfix"></div>

      </div>

      <!-- End card -->

    </div>
  </div>
</div>
<br />
<div class="clearfix"></div>

<script src="<?= base_url('assets/js/jscolor.js') ?>"></script>

<script type="text/javascript">
  $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
    document.title = $(this).text() + " | <?= $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_name ?>";
  });

  var activeTab = localStorage.getItem('activeTab');
  if (activeTab) {
    $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
  }

  if ($("#cbx_paypal").is(":checked")) {
    $(".paypal_details").show();
  } else {
    $(".paypal_details").hide();
  }

  if ($("#cbx_stripe").is(":checked")) {
    $(".stripe_details").show();
  } else {
    $(".stripe_details").hide();
  }

  if ($("#cbx_razorpay").is(":checked")) {
    $(".razorpay_details").show();
  } else {
    $(".razorpay_details").hide();
  }


  $("#cbx_paypal").on("click", function(e) {
    if ($(this).is(":checked")) {
      $(".paypal_details").show();
    } else {
      $(".paypal_details").hide();
    }
  });

  $("#cbx_stripe").on("click", function(e) {
    if ($(this).is(":checked")) {
      $(".stripe_details").show();
    } else {
      $(".stripe_details").hide();
    }
  });

  $("#cbx_razorpay").on("click", function(e) {

    if ($(this).data('currency') == 'INR') {
      if ($(this).is(":checked")) {
        $(".razorpay_details").show();
      } else {
        $(".razorpay_details").hide();
      }
    } else {
      $(this).prop("checked", false);
      swal("<?= $this->lang->line('razorpay_note_lbl') ?>");
    }

  });


  $("#cbx_google").on("click", function(e) {
    if ($(this).is(":checked")) {
      $(".google_details").show();
    } else {
      $(".google_details").hide();
    }
  });

  if ($("#cbx_google").is(":checked")) {
    $(".google_details").show();
  } else {
    $(".google_details").hide();
  }

  $("#cbx_facebook").on("click", function(e) {
    if ($(this).is(":checked")) {
      $(".facebook_details").show();
    } else {
      $(".facebook_details").hide();
    }
  });

  if ($("#cbx_facebook").is(":checked")) {
    $(".facebook_details").show();
  } else {
    $(".facebook_details").hide();
  }
</script>

<script type="text/javascript">
  $("input[name='smtp_type']").on("click", function(e) {

    var checkbox = $(this);

    $("input[name='smtp_password[]']").attr("required", false);

    e.preventDefault();
    e.stopPropagation();

    var _val = $(this).val();
    if (_val == 'gmail') {

      swal({
          title: "Are you sure?",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger btn_edit",
          cancelButtonClass: "btn-warning btn_edit",
          confirmButtonText: "Yes",
          cancelButtonText: "No",
          closeOnConfirm: false,
          closeOnCancel: false,
          showLoaderOnConfirm: false
        },
        function(isConfirm) {
          if (isConfirm) {

            checkbox.attr("disabled", true);
            checkbox.prop("checked", true);
            $("#server").attr("disabled", false);
            $("#server").prop("checked", false);

            $(".serverContent").hide();
            $(".gmailContent").show();

            $(".serverContent").find("input").attr("required", false);
            $(".gmailContent").find("input").attr("required", true);

            $("input[name='smtpIndex']").val('gmail');

            $("input[name='smtp_password[]']").attr("required",false);

            swal.close();

          } else {
            swal.close();
          }

        });
    } else {

      swal({
          title: "Are you sure?",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger btn_edit",
          cancelButtonClass: "btn-warning btn_edit",
          confirmButtonText: "Yes",
          cancelButtonText: "No",
          closeOnConfirm: false,
          closeOnCancel: false,
          showLoaderOnConfirm: false
        },
        function(isConfirm) {
          if (isConfirm) {

            checkbox.attr("disabled", true);
            checkbox.prop("checked", true);
            $("#gmail").attr("disabled", false);
            $("#gmail").prop("checked", false);

            $(".gmailContent").hide();
            $(".serverContent").show();

            $("input[name='smtpIndex']").val('server');

            $(".serverContent").find("input").attr("required", true);
            $(".gmailContent").find("input").attr("required", false);

            $("input[name='smtp_password[]']").attr("required",false);

            swal.close();

          } else {
            swal.close();
          }

        });

    }

  });
</script>

<script type="text/javascript">
  // for faq enable disable
  $(".enable_disable").on("click",function(e){

    var href;
    var btn = this;
    var _id=$(this).data("id");

    var _for=$(this).prop("checked");
    if(_for==false){
      href='<?=base_url()?>admin/pages/faq_deactive/'+_id
    }else{
      href='<?=base_url()?>admin/pages/faq_active/'+_id
    }

    $.ajax({
      type:'GET',
      url:href,
      success:function(res){
          $('.notifyjs-corner').empty();
          var obj = $.parseJSON(res);
          $.notify($.trim(obj.message), { position:"top center",className: obj.class});
        }
    });

  });


  $(document).ready(function() {
      // Configure/customize these variables.
      var showChar = 100;  // How many characters are shown by default
      var ellipsestext = "...";
      var moretext = "<?=$this->lang->line('show_more_lbl')?>";
      var lesstext = "<?=$this->lang->line('show_less_lbl')?>";
      

      $('.more').each(function() {
          var content = $.trim($(this).text());

          if(content.length > showChar) {

              var c = content.substr(0, showChar);
              var h = content.substr(showChar, content.length - showChar);

              var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span><a href="" class="morelink">' + moretext + '</a></span>';
   
              $(this).html(html);
          }
   
      });
   
      $(".morelink").click(function(){
          if($(this).hasClass("less")) {
              $(this).removeClass("less");
              $(this).html(moretext);
          } else {
              $(this).addClass("less");
              $(this).html(lesstext);
          }
          $(this).parent().prev().toggle();
          $(this).prev().toggle();
          return false;
      });
  });

  // for delete data
  $(".btn_delete").click(function(e){
      e.preventDefault();
      var _id=$(this).data("id");

      e.preventDefault(); 
      var href='<?=base_url()?>admin/pages/faq_payment_delete/'+_id;

      var btn = this;

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
            type:'GET',
            url:href,
            success:function(res){
                if($.trim(res)=='success'){
                  swal({
                      title: "<?=$this->lang->line('deleted_lbl')?>", 
                      text: "<?=$this->lang->line('deleted_data_lbl')?>",
                      type: "success"
                  },function() {
                      $(btn).closest('.item_holder').fadeOut("200");
                  });
                }
                else
                {
                  swal("Error");
                }

              }
          });
          
        }else{
          swal.close();
        }
      });
  });
</script>