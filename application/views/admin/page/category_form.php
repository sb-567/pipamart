<?php
  define('IMG_PATH', base_url().'assets/images/category/');

  $redirect=$_GET['redirect'].(isset($_GET['page']) ? '&page='.$_GET['page'] : '');
?>
<div class="row card_item_block" style="padding-left: 30px;padding-right: 30px">
  <div class="col-md-12">
    <?php 
      if(isset($_GET['redirect'])){
        echo '<a href="'.$redirect.'"><h4 class="pull-left btn_back" style=""><i class="fa fa-arrow-left"></i> Back</h4></a>';
      }
      else{
        echo '<a href="'.base_url('admin/category').'"><h4 class="pull-left btn_back" style=""><i class="fa fa-arrow-left"></i> Back</h4></a>'; 
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
        <form action="<?php if(!isset($category)){ echo site_url('admin/category/addForm').'?redirect='.$redirect;}else{  echo site_url('admin/category/editForm/'.$category[0]->id).'?redirect='.$redirect;} ?>" method="post" id="categoryForm" class="form form-horizontal" enctype="multipart/form-data">
          <div class="section">
            <div class="section-body">
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('title_lbl')?> :-
                
                </label>
                <div class="col-md-6">
                  <input type="text" placeholder="<?=$this->lang->line('title_place_lbl')?>" id="title" name="title" class="form-control" value="<?php if(isset($category)){ echo $category[0]->category_name;} ?>">
                </div>
              </div>
              <div class="form-group">
                  <label class="col-md-3 control-label"><?=$this->lang->line('select_image_lbl')?> :-
                    <p class="control-label-help hint_lbl">(<?=$this->lang->line('recommended_resolution_lbl')?>: 400x240)</p>
                    <p class="control-label-help hint_lbl">(<?=$this->lang->line('accept_img_files_lbl')?>)</p>
                    <p class="control-label-help hint_lbl">(<?=$this->lang->line('recommended_img_lbl')?>)</p>
                  </label>
                  <div class="col-md-6">
                    <div class="fileupload_block">
                      <input type="file" name="file_name" <?=!isset($category) ? 'required="required"' : ''?> value="fileupload" id="fileupload" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG">
                      
                      <div class="fileupload_img"><img type="image" src="<?php 
                        if(!isset($category)){ echo base_url('assets/images/no-image-1.jpg'); }else{  echo IMG_PATH.$category[0]->category_image; } 
                      ?>" alt="category image" style="width: 150px;height: 90px" /></div>
                         
                    </div>
                  </div>
              </div>
              <hr/>
              <p style="font-weight: 500;font-size: 16px"><?=$this->lang->line('category_wise_product_features_lbl')?>:</p>
              <hr/>
              <?php 
                  if(isset($category)){
                    $db_features=explode(',', $category[0]->product_features);
                  }
              ?>
              <div class="row">
                <div class="col-md-3">
                  <p style="font-weight: 500;font-size: 15px"><?=$this->lang->line('colour_lbl')?> <a href="javascript:void(0)" data-trigger="focus" data-toggle="popover" data-content="<?=$this->lang->line('color_feature_desc_lbl')?>"><i class="fa fa-exclamation-circle"></i></a></p>
                  <input type="checkbox" name="product_features[]" <?php if(isset($category) && in_array('color',$db_features)){ echo 'checked'; } ?> value="color" id="color_cbx" class="cbx hidden">
                  <label for="color_cbx" class="lbl"></label>
                </div>
                <div class="col-md-3">
                  <p style="font-weight: 500;font-size: 15px"><?=$this->lang->line('size_lbl')?> <a href="javascript:void(0)" data-trigger="focus" data-toggle="popover" data-content="<?=$this->lang->line('size_feature_desc_lbl')?>"><i class="fa fa-exclamation-circle"></i></a></p>
                  <input type="checkbox" name="product_features[]" <?php if(isset($category) && in_array('size',$db_features)){ echo 'checked'; } ?> value="size" id="size_cbx" class="cbx hidden">
                  <label for="size_cbx" class="lbl"></label>
                </div>
              </div>
              <hr/>
              <div class="form-group">
                <div class="col-md-12">
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

  $(function () {
    $('[data-toggle="popover"]').popover()
  })

</script> 