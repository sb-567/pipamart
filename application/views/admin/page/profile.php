<div class="row card_item_block" style="padding-left: 30px;padding-right: 30px">
  <div class="col-md-12">
    <div class="card">
      <div class="page_title_block">
        <div class="col-md-5 col-xs-12">
          <div class="page_title"><?=$current_page?></div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="row mrg-top">
        <div class="col-md-12">
          <?php

            define('IMG_PATH', base_url().'assets/images/');

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
      <div class="card-body mrg_bottom"> 
        <form action="<?=site_url('admin/pages/save_profile')?>" name="editprofile" method="post" class="form form-horizontal" enctype="multipart/form-data">
            <div class="section">
              <div class="section-body">
                <div class="form-group">
                    <label class="col-md-3 control-label">Profile Image :-
                      <p class="control-label-help hint_lbl">(Recommended resolution: 300x300,400x400 or Square Image)</p>
                      <p class="control-label-help hint_lbl">(Accept only png, jpg, jpeg, gif image files)</p>
                    </label>
                    <div class="col-md-6">
                      <div class="fileupload_block">
                        <input type="file" name="file_name" value="fileupload" id="fileupload" accept=".gif, .jpg, .png, jpeg">
                        
                        <div class="fileupload_img"><img type="image" src="<?php 
                          if(!isset($row)){ echo base_url('assets/images/no-image-1.jpg'); }else{  echo IMG_PATH.$row->image; } 
                        ?>" alt="profile image" style="width: 90px;height: 90px" /></div>
                           
                      </div>
                    </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label">Username :-</label>
                  <div class="col-md-6">
                    <input type="text" name="username" id="username" value="<?=$row->username?>" class="form-control" required autocomplete="off">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label">Password :-</label>
                  <div class="col-md-6">
                    <input type="password" name="password" id="password" value="" class="form-control" autocomplete="off">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label">Email :-</label>
                  <div class="col-md-6">
                    <input type="text" name="email" id="email" value="<?=$row->email?>" class="form-control" required autocomplete="off">
                  </div>
                </div>                 
                 
                <div class="form-group">
                  <div class="col-md-9 col-md-offset-3">
                    <button type="submit" name="submit" class="btn btn-primary">Save</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $("input[name='file_name']").next(".fileupload_img").find("img").attr('src', e.target.result);
      }
      
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("input[name='file_name']").change(function() { 
    readURL(this);
  });

</script> 