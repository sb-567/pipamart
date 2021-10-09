<?php
  define('IMG_PATH', base_url().'assets/images/banner/');
  $redirect=$_GET['redirect'].(isset($_GET['page']) ? '&page='.$_GET['page'] : '');
?>
<style type="text/css">
  .select2{
    padding: 0px;
    height: auto !important;
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
        echo '<a href="'.base_url('admin/banner').'"><h4 class="pull-left btn_back" style=""><i class="fa fa-arrow-left"></i> Back</h4></a>'; 
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
        <form action="<?php if(!isset($banner)){ echo site_url('admin/banner/addForm').'?redirect='.$redirect;}else{  echo site_url('admin/banner/editForm/'.$banner[0]->id).'?redirect='.$redirect;} ?>" method="post" id="categoryForm" class="form form-horizontal" enctype="multipart/form-data">
          <div class="section">
            <div class="section-body">
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('title_lbl')?> :-
                
                </label>
                <div class="col-md-6">
                  <input type="text" placeholder="<?=$this->lang->line('title_place_lbl')?>" id="title" name="title" class="form-control" value="<?php if(isset($banner)){ echo $banner[0]->banner_title;} ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('desc_lbl')?>(<?=$this->lang->line('optional_lbl')?>) :-</label>
                <div class="col-md-6">
                  <textarea name="banner_desc" id="banner_desc" class="form-control"><?php if(isset($banner)){ echo $banner[0]->banner_desc; } ?></textarea>
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
                    <input type="file" name="file_name" value="fileupload" <?=!isset($banner) ? 'required="required"' : ''?> id="fileupload" accept=".gif, .jpg, .png, jpeg">
                    
                    <div class="fileupload_img"><img type="image" src="<?php 
                      if(!isset($banner)){ echo base_url('assets/images/no-image-1.jpg'); }else{  echo IMG_PATH.$banner[0]->banner_image; } 
                    ?>" alt="banner image" style="width: 230px !important;height: 100px !important" /></div>
                       
                  </div>
                </div>
              </div>
              <hr/>
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('offer_lbl')?> :-
                  <p class="control-label-help hint_lbl">(<?=$this->lang->line('offer_in_banner_hint_lbl')?>)</p>
                </label>
                <div class="col-md-6">
                  <select name="offer_id" id="offer_id" class="select2 form-control">
                    <option value="0">---<?=$this->lang->line('select_offer_lbl')?>---</option>
                    <?php 
                      foreach ($offers AS $key => $value) {
                        ?>
                        <?php if(isset($banner)){?>

                        <option value="<?php echo $value->id;?>" <?php if($value->id==$banner[0]->offer_id){ echo 'selected';}?>><?php echo stripslashes($value->offer_title);?>
                        </option>   

                      <?php }else{?>  

                        <option value="<?php echo $value->id;?>"><?php echo stripslashes($value->offer_title);?></option>
                          
                      <?php }?> 
                        <?php
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="or_link_item">
              <h2>OR</h2>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('products_lbl')?> :-</label>
                <div class="col-md-6">
                  <select name="product_ids[]" id="product_ids" class="select2 form-control" multiple="multiple">
                    <?php 
                      foreach ($products AS $key => $value) {
                        ?>
                        <?php if(isset($banner)){?>

                        <option value="<?php echo $value->id;?>" <?php $product_list=explode(",", $banner[0]->product_ids);
                            foreach($product_list AS $product_id)
                            {
                              if($value->id==$product_id){ 
                                echo 'selected';
                              }
                            }
                            ?>><?php echo stripslashes($value->product_title);?>
                        </option>   

                      <?php }else{?>  

                        <option value="<?php echo $value->id;?>"><?php echo stripslashes($value->product_title);?></option>
                          
                      <?php }?> 
                        <?php
                      }
                    ?>
                  </select>
                </div>
              </div>
              <div class="clearfix"></div>
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

  $(".select2").select2();

  CKEDITOR.replace( 'banner_desc', {
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