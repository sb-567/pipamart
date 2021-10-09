<?php
  define('IMG_PATH', base_url().'assets/images/offers/');

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
        echo '<a href="'.base_url('admin/offers').'"><h4 class="pull-left btn_back" style=""><i class="fa fa-arrow-left"></i> Back</h4></a>'; 
      }
    ?>
    <div class="card">
      <div class="page_title_block">
        <div class="col-md-5 col-xs-12">
          <div class="page_title"><?=$page_title?></div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="card-body mrg_bottom"> 
        <form action="<?php if(!isset($offer)){ echo site_url('admin/offers/addForm').'?redirect='.$redirect;}else{  echo site_url('admin/offers/editForm/'.$offer->id).'?redirect='.$redirect;} ?>" method="post" class="form form-horizontal" enctype="multipart/form-data">
          <div class="section">
            <div class="section-body">
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('title_lbl')?> :-
                </label>
                <div class="col-md-6">
                  <input type="text" name="offer_title" placeholder="<?=$this->lang->line('title_place_lbl')?>" id="offer_title" value="<?php if(isset($offer)){ echo $offer->offer_title;} ?>" class="form-control"  required>
                </div>
              </div>
              <br/>
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('desc_lbl')?>(<?=$this->lang->line('optional_lbl')?>) :-</label>
                <div class="col-md-6">
                  <textarea name="offer_desc" placeholder="<?=$this->lang->line('desc_lbl')?>" id="offer_desc" class="form-control"><?php if(isset($offer)){ echo $offer->offer_desc;} ?></textarea>
                </div>
              </div>
              
              <hr/>
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('discount_in_pr_lbl')?> :-
                </label>
                <div class="col-md-6">
                  <div class="input-group">
                    <input type="text" name="offer_per" id="offer_per" required="" maxlength="3" min="0" max="100" value="<?php if(isset($offer)){ echo $offer->offer_percentage;} ?>" class="form-control" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                  </div>
                </div>
              </div>
              <hr/>
              <div class="form-group">
                  <label class="col-md-3 control-label"><?=$this->lang->line('select_image_lbl')?> :-
                    <p class="control-label-help hint_lbl">(<?=$this->lang->line('recommended_resolution_lbl')?>: 470X266, 570x223)</p>
                    <p class="control-label-help hint_lbl">(<?=$this->lang->line('accept_img_files_lbl')?>)</p>
                    <p class="control-label-help hint_lbl">(<?=$this->lang->line('recommended_img_lbl')?>)</p>
                  </label>
                  <div class="col-md-6">
                    <div class="fileupload_block">
                      <input type="file" name="file_name" value="fileupload" <?=!isset($offer) ? 'required="required"' : ''?> id="fileupload" accept=".gif, .jpg, .png, jpeg">
                      
                      <div class="fileupload_img"><img type="image" src="<?php 
                        if(!isset($offer)){ echo base_url('assets/images/no-image-1.jpg'); }else{  echo IMG_PATH.$offer->offer_image; } 
                      ?>" alt="coupon image" style="width: 200px !important;height: 120px !important" /></div>
                         
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

  CKEDITOR.replace( 'offer_desc', {
      removePlugins: 'link,about', 
      removeButtons:'Subscript,Superscript,Image',
  } );
</script> 

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