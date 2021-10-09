<?php
  define('IMG_PATH', base_url().'assets/images/sub_category/');

  $redirect=$_GET['redirect'].(isset($_GET['page']) ? '&page='.$_GET['page'] : '');
?>
<div class="row card_item_block" style="padding-left: 30px;padding-right: 30px">
  <div class="col-md-12">
    <?php 
      if(isset($_GET['redirect'])){
        echo '<a href="'.$redirect.'"><h4 class="pull-left btn_back" style=""><i class="fa fa-arrow-left"></i> Back</h4></a>';
      }
      else{
        echo '<a href="'.base_url('admin/sub-category').'"><h4 class="pull-left btn_back" style=""><i class="fa fa-arrow-left"></i> Back</h4></a>'; 
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
        <form action="<?php if(!isset($sub_category)){ echo site_url('admin/SubMenu/addForm_item').'?redirect='.$redirect; }else{  echo site_url('admin/SubMenu/editForm_item/'.$sub_category[0]->id).'?redirect='.$redirect;} ?>" method="post" id="categoryForm" class="form form-horizontal" enctype="multipart/form-data">
          <div class="section">
            <div class="section-body">

              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('title_lbl')?> :-</label>
                <div class="col-md-6">
                  <input type="text" placeholder="<?=$this->lang->line('title_place_lbl')?>" id="title" name="title" class="form-control" value="<?php if(isset($sub_category)){ echo $sub_category[0]->submenu_item_name;} ?>">
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('select_cat_lbl')?> :-</label>
                <div class="col-md-6">
                  <?php 
              if(isset($sub_category))
              {
                echo '<input type="hidden" class="item_id" value="'.$sub_category[0]->id.'">';  
              } 
              ?>
                  <?php 
                          if(isset($sub_category))
                          {
                            echo '<input type="hidden" class="old_cat_id" value="'.$sub_category[0]->category_id.'">';  
                          } 
                          ?>
                  <select name="category_id" class="select2">
                      <option value="" selected>--<?=$this->lang->line('select_cat_lbl')?>--</option>
                      <?php 
                          foreach ($category_list as $key => $value)
                          {
                            ?>
                            <option value="<?=$value->id?>" <?php if(isset($sub_category) && $sub_category[0]->category_id==$value->id){ echo 'selected';} ?>><?=$value->category_name?></option>
                            <?php
                          }
                      ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('select_subcat_lbl')?> :-</label>
                <div class="col-md-6">
                  <?php
                   if(isset($sub_category))
                          {
                            echo '<input type="hidden" class="old_sub_cat_id" value="'.$sub_category[0]->sub_category_id.'">';  
                          } 
                          ?>
                  <select name="sub_cat_id" class="select2" id="sub_cat_id">
                      <option value="" selected>--<?=$this->lang->line('select_cat_lbl')?>--</option>
                      
                  </select>
                </div>
              </div>

               <div class="form-group">
                <label class="col-md-3 control-label">Select SubMenu Header:-</label>
                <div class="col-md-6">
                  <?php
                   if(isset($sub_category))
                          {
                            echo '<input type="hidden" class="old_header_id" value="'.$sub_category[0]->submenu_header_id.'">';  
                          } 
                          ?>
                  <select name="submenu_header_id" class="select2" id="header_id">
                      <option value="" selected>--Select Submenu Header--</option>
                      
                  </select>
                </div>
              </div>
              
             <!--  <div class="form-group">
               
                <div class="col-md-6">
                  <div class="fileupload_block">
                    <input type="file" name="file_name" value="fileupload" <?=!isset($sub_category) ? 'required="required"' : ''?> id="fileupload" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG">
                    
                    <div class="fileupload_img"><img type="image" src="<?php 
                      if(!isset($sub_category)){ echo base_url('assets/images/no-image-1.jpg'); }else{  echo IMG_PATH.$sub_category[0]->sub_category_image; } 
                    ?>" alt="sub_category image" style="width: 150px;height: 90px" /></div>
                       
                  </div>
                </div>
              </div> -->

              <!-- <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('sub_category_web_note_lbl')?> <a href="<?=base_url('assets/images/product_list_hint.jpg')?>" class="btn_hint"><i class="fa fa-exclamation-circle"></i></a>:-
                </label>
                <div class="col-md-6" style="margin-top: 15px">
                  <input type="checkbox" name="show_on_off" <?php if(isset($sub_category) && $sub_category[0]->show_on_off=='1'){ echo 'checked'; } ?> value="1" id="color_cbx" class="cbx hidden">
                  <label for="color_cbx" class="lbl"></label>
                </div>
              </div> -->
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

<!-- Hint Modal -->
<div class="modal fade" id="hindModal" tabindex="-1" role="dialog" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-body">
        <img src="" style="width: 100%;height: auto;">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">


  var product_id=$(".item_id").val();

  if(product_id!=''){
    var _id=$("select[name='category_id']").val();

    // for sub category
    var _old_id_sub=$(".old_sub_cat_id").val();

    $("select[name='sub_cat_id']").html('<option value="0">--<?=$this->lang->line('select_subcat_lbl')?>--</option>');

    var href = '<?php echo site_url('admin/product/get_sub_category/')?>'+_id;

    $.ajax({
      type:'GET',
      url:href,
      success:function(res){
        $("select[name='sub_cat_id']").append(res);
        $('#sub_cat_id option[value="'+_old_id_sub+'"]').prop('selected', true);
      }
    });


     var _old_id_header=$(".old_header_id").val();

    $("select[name='submenu_header_id']").html('<option value="0">--<?=$this->lang->line('select_subcat_lbl')?>--</option>');

    var href = '<?php echo site_url('admin/product/get_submenu_header/')?>'+_id;

    $.ajax({
      type:'GET',
      url:href,
      success:function(res){
        $("select[name='submenu_header_id']").append(res);
        $('#header_id option[value="'+_old_id_header+'"]').prop('selected', true);
      }
    });

  }

  $(".btn_hint").click(function(e){
    e.preventDefault();
    $("#hindModal").find("img").attr("src",$(this).attr("href"));
    $("#hindModal").modal("show");  
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

  $("select[name='category_id']").on("change",function(e){

      var _id=$(this).val();

      // getting sub categories
      $("select[name='sub_cat_id']").html('<option value="0">--<?=$this->lang->line('select_subcat_lbl')?>--</option>');
      var href = '<?php echo site_url('admin/product/get_sub_category/')?>'+_id;

      $.ajax({
        type:'GET',
        url:href,
        success:function(res){
          $("select[name='sub_cat_id']").append(res);
        }
      });
    });

    $("select[name='sub_cat_id']").on("change",function(e){

      var _id=$(this).val();

      // getting sub categories
      $("select[name='submenu_header_id']").html('<option value="0">--Select Submenu Header--</option>');
      var href = '<?php echo site_url('admin/product/get_submenu_header/')?>'+_id;

      $.ajax({
        type:'GET',
        url:href,
        success:function(res){
          $("select[name='submenu_header_id']").append(res);
        }
      });
    });

</script> 