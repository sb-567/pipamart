<?php
    define('IMG_PATH', base_url().'assets/images/coupons/');
    define('CURRENCY_CODE', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_currency_html_code);

    $redirect=$_GET['redirect'].(isset($_GET['page']) ? '&page='.$_GET['page'] : '');

?>
<style type="text/css">
  .select2{
    padding: 0px;
  }
  .select2-selection{
    min-height: auto !important;
  }
</style>

<div class="row card_item_block" style="padding-left: 30px;padding-right: 30px">
  <div class="col-md-12">
    <?php 
      if(isset($_GET['redirect'])){
        echo '<a href="'.$redirect.'"><h4 class="pull-left btn_back" style=""><i class="fa fa-arrow-left"></i> Back</h4></a>';
      }
      else{
        echo '<a href="'.base_url('admin/coupon').'"><h4 class="pull-left btn_back" style=""><i class="fa fa-arrow-left"></i> Back</h4></a>'; 
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
        <form action="<?php if(!isset($coupon)){ echo site_url('admin/coupon/addForm').'?redirect='.$redirect; }else{  echo site_url('admin/coupon/editForm/'.$coupon[0]->id).'?redirect='.$_GET['redirect'];} ?>" method="post" class="form form-horizontal" enctype="multipart/form-data">
          <div class="section">
            <div class="section-body">
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('desc_lbl')?> :-</label>
                <div class="col-md-6">
                  <textarea name="coupon_desc" id="coupon_desc" class="form-control"><?php if(isset($coupon)){ echo $coupon[0]->coupon_desc;} ?></textarea>
                </div>
              </div>
              <br/>
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('coupon_code_lbl')?> :-
                </label>
                <div class="col-md-6">
                  <input type="text" name="coupon_code" id="coupon_code" value="<?php if(isset($coupon)){ echo $coupon[0]->coupon_code;} ?>" class="form-control"  required>
                </div>
              </div>
              <hr/>
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('discount_in_pr_lbl')?> :-
                  <p class="control-label-help">(<?=$this->lang->line('discount_in_pr_note_lbl')?>)</p>
                </label>
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon" id="coupon_per">
                        <i class="fa fa-percent" aria-hidden="true"></i></span>
                        <input type="text" name="coupon_per" class="form-control" aria-describedby="coupon_per" maxlength="3" min="0" max="100" <?=(!isset($coupon)) ? 'required="required"' : ''?> onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" value="<?php if(isset($coupon)){ echo $coupon[0]->coupon_per;} ?>">
                    </div>
                </div>
              </div>
              <div class="or_link_item">
              <h2><?=$this->lang->line('or_lbl')?></h2>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('discount_in_amt_lbl')?> :-
                </label>
                <div class="col-md-6">
                  <div class="input-group">
                      <span class="input-group-addon" id="coupon_amt" style="font-weight: 600">
                        <?=CURRENCY_CODE?>
                      </span>
                      <input type="text" name="coupon_amt" aria-describedby="coupon_amt" min="0" max="100" <?=(!isset($coupon)) ? 'required="required"' : ''?> value="<?php if(isset($coupon)){ echo $coupon[0]->coupon_amt;} ?>" class="form-control" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                  </div>

                </div>
              </div>
              <hr/>
              <?php if(!isset($coupon) || $coupon[0]->coupon_amt==0){?>
              <div class="form-group max_discount">
                <label class="col-md-3 control-label"><?=$this->lang->line('max_discount_status_lbl')?>:-
                </label>
                <div class="col-md-6">
                  <select class="select2" name="max_amt_status" required="">
                    <option value="true" <?php if(isset($coupon) && $coupon[0]->max_amt_status=='true'){ echo 'selected';} ?>><?=$this->lang->line('true_lbl')?></option>
                    <option value="false" <?php if(isset($coupon) && $coupon[0]->max_amt_status=='false'){ echo 'selected';} ?>><?=$this->lang->line('false_lbl')?></option>
                  </select>
                </div>
              </div>
              <div class="form-group max_discount">
                <label class="col-md-3 control-label"><?=$this->lang->line('max_discount_amt_lbl')?> :-
                </label>
                <div class="col-md-6">
                  <input type="text" name="coupon_max_amt" id="coupon_max_amt" min="0" max="100" value="<?php if(isset($coupon)){ echo $coupon[0]->coupon_max_amt;} ?>" class="form-control" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" >
                </div>
              </div>
              <?php } ?>
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('min_amt_in_cart_status_lbl')?>:-
                </label>
                <div class="col-md-6">
                  <select class="select2" name="cart_status" required="">
                    <option value="true" <?php if(isset($coupon) && $coupon[0]->cart_status=='true'){ echo 'selected';} ?>><?=$this->lang->line('true_lbl')?></option>
                    <option value="false" <?php if(isset($coupon) && $coupon[0]->cart_status=='false'){ echo 'selected';} ?>><?=$this->lang->line('false_lbl')?></option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('min_amt_in_cart_lbl')?>:-
                </label>
                <div class="col-md-6">
                  <input type="text" name="coupon_cart_min" id="coupon_cart_min" min="0" value="<?php if(isset($coupon)){ echo $coupon[0]->coupon_cart_min;} ?>" class="form-control" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" >
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('max_coupon_per_user_lbl')?>:-
                </label>
                <div class="col-md-6">
                  <input type="text" name="coupon_limit_use" id="coupon_limit_use" min="1" value="<?php if(isset($coupon)){ echo $coupon[0]->coupon_limit_use;}else{ echo '1';} ?>" class="form-control" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" >
                </div>
              </div>
              <hr/>
              <div class="form-group">
                  <label class="col-md-3 control-label"><?=$this->lang->line('select_image_lbl')?> :-
                    <p class="control-label-help hint_lbl">(<?=$this->lang->line('recommended_resolution_lbl')?>: 300X130,400X173)</p>
                    <p class="control-label-help hint_lbl">(<?=$this->lang->line('accept_img_files_lbl')?>)</p>
                    <p class="control-label-help hint_lbl">(<?=$this->lang->line('recommended_img_lbl')?>)</p>
                  </label>
                  <div class="col-md-6">
                    <div class="fileupload_block">
                      <input type="file" name="file_name" value="fileupload" <?=!isset($coupon) ? 'required="required"' : ''?> accept=".jpg, .png, jpeg" id="fileupload">
                      
                      <div class="fileupload_img"><img type="image" src="<?php 
                        if(!isset($coupon)){ echo base_url('assets/images/no-image-1.jpg'); }else{  echo IMG_PATH.$coupon[0]->coupon_image; } 
                      ?>" alt="coupon image" style="width: 150px;height: 90px" /></div>
                         
                    </div>
                  </div>
              </div>

              <br/>
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

  CKEDITOR.replace( 'coupon_desc', {
      removePlugins: 'link,about', 
      removeButtons:'Subscript,Superscript,Image',
  } );
</script> 

<script type="text/javascript">

  $(".select2").each(function(index){
    var _ele=$(this).val();
    if(_ele=='true'){
      $(this).parents(".form-group").next(".form-group").fadeIn(100);
    }
    else{
      $(this).parents(".form-group").next(".form-group").fadeOut(100);
    }
  });

  $(".select2").on("change",function(e){
    var _ele=$(this).val();
    if(_ele=='true'){
      $(this).parents(".form-group").next(".form-group").fadeIn(100);
    }
    else{
      $(this).parents(".form-group").next(".form-group").fadeOut(100);
    }
  });

  //perform operations

  $("#coupon_per").keyup(function(e){
    var _per=$(this).val();
    if(_per!=''){
      $("#coupon_amt").val('');
      $(".max_discount").show();
    }
  });

  $("#coupon_amt").keyup(function(e){
    var _amt=$(this).val();
    if(_amt!=''){
      $("#coupon_per").val('');
      $(".max_discount").hide();
    }
  });

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


  $("input[name='coupon_per']").on("keyup",function(e){
    if($(this).val()!=''){
      $("input[name='coupon_amt']").attr("required",false);
    }
    else{
      $("input[name='coupon_amt']").attr("required",true);
    }
  });

  $("input[name='coupon_amt']").on("keyup",function(e){
    if($(this).val()!=''){
      $("input[name='coupon_per']").attr("required",false);
    }
    else{
      $("input[name='coupon_per']").attr("required",true);
    }
  });

  if($("select[name='max_amt_status']").val()=='true')
  {
    $("input[name='coupon_max_amt']").attr("required",true);
  }
  else{
    $("input[name='coupon_max_amt']").attr("required",false); 
  }

  $("select[name='max_amt_status']").on("change",function(e){
      if($(this).val()=='true')
      {
        $("input[name='coupon_max_amt']").attr("required",true);
      }
      else
      {
        $("input[name='coupon_max_amt']").attr("required",false); 
      }
  });


  if($("select[name='cart_status']").val()=='true'){
    $("input[name='coupon_cart_min']").attr("required",true);
  }
  else{
    $("input[name='coupon_cart_min']").attr("required",false); 
  }

  $("select[name='cart_status']").on("change",function(e){
      if($(this).val()=='true')
      {
        $("input[name='coupon_cart_min']").attr("required",true);
      }
      else{
        $("input[name='coupon_cart_min']").attr("required",false); 
      }
  });

</script> 