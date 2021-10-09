<?php
    define('IMG_PATH', base_url().'assets/images/users/');
    $redirect=$_GET['redirect'].(isset($_GET['page']) ? '&page='.$_GET['page'] : '');

?>
<div class="row card_item_block" style="padding-left: 30px;padding-right: 30px">
  <div class="col-md-12">
    <?php 
      if(isset($_GET['redirect'])){
        echo '<a href="'.$redirect.'"><h4 class="pull-left btn_back" style=""><i class="fa fa-arrow-left"></i> Back</h4></a>';
      }
      else{
        echo '<a href="'.base_url('admin/users').'"><h4 class="pull-left btn_back" style=""><i class="fa fa-arrow-left"></i> Back</h4></a>'; 
      }
    ?>
    <div class="card">
      <div class="page_title_block">
        <div class="col-md-5 col-xs-12">
          <div class="page_title"><?=$current_page?></div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="card-body mrg_bottom"> 
        <form action="<?php if(!isset($users)){ echo site_url('admin/users/addForm').'?redirect='.$redirect; }else{  echo site_url('admin/users/editForm/'.$users[0]->id).'?redirect='.$_GET['redirect'];} ?>" method="post" id="categoryForm" class="form form-horizontal" enctype="multipart/form-data">
          <div class="section">
            <div class="section-body">
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('name_lbl')?>:-
                </label>
                <div class="col-md-6">
                  <input type="text" required="" placeholder="<?=$this->lang->line('name_place_lbl')?>" id="user_name" name="user_name" class="form-control" value="<?php if(isset($users)){ echo $users[0]->user_name;} ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('email_lbl')?> :-
                
                </label>
                <div class="col-md-6">
                  <input type="text" required="" placeholder="<?=$this->lang->line('email_place_lbl')?>" id="user_email" name="user_email" class="form-control" <?php if(isset($users) && (strcmp($users[0]->user_type, 'Normal')!=0)){ echo 'readonly="readonly"';} ?> value="<?php if(isset($users)){ echo $users[0]->user_email;} ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('phone_no_lbl')?> :-
                
                </label>
                <div class="col-md-6">
                  <input type="text" onkeypress="return isNumberKey(event)" maxlength="15" placeholder="<?=$this->lang->line('phone_no_place_lbl')?>" id="user_phone" name="user_phone" class="form-control" value="<?php if(isset($users)){ echo $users[0]->user_phone;} ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('password_lbl')?> :-</label>
                <div class="col-md-6">
                  <input type="password" placeholder="*******" <?php if(isset($users) && (strcmp($users[0]->user_type, 'Normal')!=0)){ echo 'disabled=""';} ?> id="user_password" name="user_password" class="form-control" value=""<?php echo (!isset($users)) ? 'required="required"' : '' ;?>>
                </div>
              </div>

              <div class="form-group">
                  <label class="col-md-3 control-label"><?=$this->lang->line('select_image_lbl')?> :-
                    <p class="control-label-help hint_lbl">(<?=$this->lang->line('recommended_resolution_lbl')?>: 300x300, 400x400)</p>
                    <p class="control-label-help hint_lbl">(<?=$this->lang->line('accept_img_files_lbl')?>)</p>
                  </label>
                  <div class="col-md-6">
                    <div class="fileupload_block">
                      <input type="file" name="file_name" value="fileupload" id="fileupload" accept=".gif, .jpg, .png, jpeg" <?php echo (!isset($users)) ? 'required="required"' : '' ;?>>
                      <div class="fileupload_img"><img type="image" src="<?php 
                        if(!isset($users)){ echo base_url('assets/images/2.png'); }else{  echo IMG_PATH.$users[0]->user_image; } 
                      ?>" alt="<?=$this->lang->line('select_image_lbl')?>" style="width: 90px;height: 90px" /></div>  
                    </div>
                  </div>
                </div>
              <div class="form-group">
                <div class="col-md-9 col-md-offset-3">
                  <button type="submit" name="btn_submit" class="btn btn-primary"><?=$this->lang->line('save_btn')?></button>
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