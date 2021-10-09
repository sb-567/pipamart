<?php 

define('APP_CURRENCY', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_currency_code);
define('CURRENCY_CODE', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_currency_html_code);

define('IMG_PATH', base_url().'assets/images/products/');
define('IMG_PATH_GALLERY', base_url().'assets/images/products/gallery/');

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
        echo '<a href="'.$_GET['redirect'].'"><h4 class="pull-left btn_back" style=""><i class="fa fa-arrow-left"></i> Back</h4></a>';
      }
      else{
        echo '<a href="'.base_url('admin/products').'"><h4 class="pull-left btn_back" style=""><i class="fa fa-arrow-left"></i> Back</h4></a>'; 
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
        <form action="<?php echo site_url('admin/product/addForm').'?redirect='.$_GET['redirect']; ?>" method="post" id="categoryForm" class="form form-horizontal" enctype="multipart/form-data">
          <div class="section">
            <div class="section-body">

              <?php 
                  if(isset($product))
                  {
                    echo '<input type="hidden" class="product_id" value="'.$product[0]->id.'">';  
                  } 
                ?>
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('select_cat_lbl')?> :-</label>
                <div class="col-md-6">
                  <select name="category_id" class="select2" required="">
                      <option value="0" selected>--<?=$this->lang->line('select_cat_lbl')?>--</option>
                      <?php 
                          foreach ($category_list as $key => $value)
                          {
                            ?>
                            <option value="<?=$value->id?>" <?php if(isset($product) && $product[0]->category_id==$value->id){ echo 'selected';} ?>><?=$value->category_name?></option>
                            <?php
                          }
                      ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <?php 
                  if(isset($product))
                  {
                    echo '<input type="hidden" class="old_sub_cat_id" value="'.$product[0]->sub_category_id.'">';  
                  } 
                ?>
                <label class="col-md-3 control-label"><?=$this->lang->line('select_subcat_lbl')?> :-</label>
                <div class="col-md-6">
                  <select name="sub_cat_id" class="select2" id="sub_category_id" required="">
                      <option value="0" selected>--<?=$this->lang->line('select_subcat_lbl')?>--</option>
                  </select>
                </div>
              </div>
              <?php 
                if(isset($product))
                {
                  echo '<input type="hidden" class="old_brand_id" value="'.$product[0]->brand_id.'">';  
                } 
              ?>

              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('select_brand_lbl')?> :-</label>
                <div class="col-md-6">
                  <select name="brand_id" class="select2" id="brand_id">
                      <option value="0" selected>--<?=$this->lang->line('select_brand_lbl')?>--</option>
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('title_lbl')?> :-
                </label>
                <div class="col-md-6">
                  <input type="text" name="title" id="product_title" value="<?php if(isset($product)){ echo $product[0]->product_title.'-1';} ?>" class="form-control" placeholder="<?=$this->lang->line('title_place_lbl')?>" required>
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('sort_desc_lbl')?> :-</label>
                <div class="col-md-6">
                  <textarea name="product_desc" id="product_desc" class="form-control" rows="5"><?php if(isset($product)){ echo $product[0]->product_desc;} ?></textarea>
                </div>
              </div>
              <br/>
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('product_features_lbl')?> :-</label>
                <div class="col-md-6">
                  <textarea name="product_features_desc" id="product_features_desc" required="" class="form-control"><?php if(isset($product)){ echo $product[0]->product_features;} ?></textarea>
                </div>
              </div>
              <br/>
              
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('product_mrp_lbl')?> :-</label>
                <div class="col-md-6">
                  <input type="text" name="product_mrp" id="product_mrp" value="<?php if(isset($product)){ echo $product[0]->product_mrp;} ?>" class="form-control" placeholder="" onkeypress="return (event.charCode == 8 || event.charCode == 0 || event.charCode == 13) ? null : event.charCode >= 48 && event.charCode <= 57" required>
                </div>
              </div>
              <div class="form-group">
                <?php 
                  if(isset($product))
                  {
                    echo '<input type="hidden" class="old_offer_id" value="'.$product[0]->offer_id.'">';  
                  } 
                ?>
                <label class="col-md-3 control-label"><?=$this->lang->line('select_offer_lbl')?> :-</label>
                <div class="col-md-6">
                  <select name="offer_id" id="offer_id" class="select2">
                      <option value="0" selected>--<?=$this->lang->line('select_offer_lbl')?>--</option>
                      <?php 
                          foreach ($offer_list as $key => $value)
                          {
                            ?>
                            <option value="<?=$value->id?>" <?php if(isset($product) && $product[0]->offer_id==$value->id){ echo 'selected';} ?>><?=$value->offer_title?></option>
                            <?php
                          }
                      ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('product_sale_price_lbl')?> :-
                </label>
                <div class="col-md-6">
                  <input type="text" name="selling_price" id="selling_price" readonly="" value="" class="form-control" placeholder="">
                </div>
              </div>
              <div class="form-group saving_info" style="display: none;">
                <label class="col-md-9 col-md-offset-3 control-label" style="padding-top: 0px">
                  <strong style="color: green"><?=$this->lang->line('offer_apply_success_lbl')?></strong>
                </label>
                <label class="col-md-3 control-label"><?=$this->lang->line('you_save_lbl')?> :-
                </label>
                <div class="col-md-3">
                  <div class="input-group">
                    <input type="text" name="you_save" id="you_save_price" readonly="readonly" value="" class="form-control" placeholder="Saving in <?=APP_CURRENCY?>">
                    <span class="input-group-addon"><?=CURRENCY_CODE?></span>
                  </div>
                </div>
                
                <div class="col-md-3">
                  <div class="input-group">
                    <input type="text" name="you_save_per" id="you_save_per" readonly="readonly" value="" class="form-control" placeholder="Saving in Percentage">
                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                  </div>
                </div>
              </div>
              <input type="hidden" name="product_quantity" value="0">
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('max_unit_buy_lbl')?> :-
                </label>
                <div class="col-md-6">
                  <input type="text" name="max_unit_buy" id="max_unit_buy" value="<?php if(isset($product)){ echo $product[0]->max_unit_buy;} ?>" class="form-control" placeholder="1">
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('feature_img1_lbl')?> :-
                  <p class="control-label-help hint_lbl">(<?=$this->lang->line('recommended_resolution_lbl')?>: 600x600, 800x800)</p>
                  <p class="control-label-help hint_lbl">(<?=$this->lang->line('accept_img_files_lbl')?>)</p>
                </label>
                <div class="col-md-6">
                  <div class="fileupload_block">
                    <input type="file" <?php if(!isset($product)){ echo 'required';} ?> name="file_name" value="fileupload" id="fileupload" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG">
                    
                    <div class="fileupload_img"><img type="image" src="<?php echo base_url('assets/images/no-image-1.jpg');?>" alt="product image" style="width: 90px;height: 90px" /></div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('feature_img2_lbl')?> :-
                  <p class="control-label-help hint_lbl">(<?=$this->lang->line('recommended_resolution_lbl')?>: 600x600, 800x800)</p>
                  <p class="control-label-help hint_lbl">(<?=$this->lang->line('accept_img_files_lbl')?>)</p>
                </label>
                <div class="col-md-6">
                  <div class="fileupload_block">
                    <input type="file" <?php if(!isset($product)){ echo 'required';} ?> name="file_name2" value="fileupload" id="fileupload" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG">
                    
                    <div class="fileupload_img"><img type="image" src="<?php echo base_url('assets/images/no-image-1.jpg');?>" alt="product image" style="width: 90px;height: 90px" /></div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-md-3 control-label"><?=$this->lang->line('product_img_gallery_lbl')?> :-
                  <p class="control-label-help hint_lbl">(<?=$this->lang->line('recommended_resolution_lbl')?>: 600x600, 800x800)</p>
                  <p class="control-label-help hint_lbl">(<?=$this->lang->line('accept_img_files_lbl')?>)</p>
                </label>
                <div class="col-md-6">
                  <input type="file" name="product_images[]" value="" id="fileupload" class="form-control" multiple="">
                </div>
              </div>
              <hr/>

              <?php 
                $color_name=$color_code='';
                if(isset($product))
                {
                    $color_arr=explode('/', $product[0]->color);
                    $color_name=$color_arr[0];
                    $color_code=$color_arr[1];
                } 
              ?>


              <?php 
                if(isset($product))
                {
                  echo '<input type="hidden" class="old_color_id" value="'.$product[0]->other_color_product.'">';  
                } 
              ?>

              <div class="product_features">
                <div class="form-group other_color_product" style="display: none;">
                  <label class="col-md-3 control-label"><?=$this->lang->line('other_product_color_lbl')?> :-</label>
                  <div class="col-md-6">
                    <select name="other_color_product[]" id="other_color_product" class="select2" multiple="">
                    </select>
                  </div>
                </div>
                <div class="color" style="display: none;">
                  <div class="form-group">
                    <label class="col-md-3 control-label"><?=$this->lang->line('product_color_lbl')?> :-</label>
                    <div class="col-md-6">
                      <input type="text" name="product_color" id="product_color" value="<?php if(isset($product)){ echo $color_name;} ?>" class="form-control" placeholder="Enter product color">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label"><?=$this->lang->line('select_color_lbl')?> :-</label>
                    <div class="col-md-6">
                      <input type="text" name="color_code" id="color_code" value="<?php if(isset($product)){ echo $color_code;} ?>" class="form-control jscolor"  data-jscolor="{preset:'large', position:'top', borderColor:'#999', insetColor:'#FFF', backgroundColor:'#ddd'}"placeholder="Enter product color">
                    </div>
                  </div> 
                </div>
                <div class="size" style="display: none;">
                  <div class="form-group">
                    <label class="col-md-3 control-label"><?=$this->lang->line('product_size_lbl')?> :-
                      <p class="control-label-help">(<?=$this->lang->line('product_size_note_lbl')?>)</p>
                    </label>
                    <div class="col-md-6">
                      <input type="text" name="product_size" id="product_size" value="<?php if(isset($product)){ echo $product[0]->product_size;} ?>" class="form-control" placeholder="Enter product sizes">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-md-3 control-label"><?=$this->lang->line('product_size_chart_lbl')?>:-
                      <p class="control-label-help hint_lbl">(<?=$this->lang->line('accept_img_files_lbl')?>)</p>
                    </label>
                    <div class="col-md-6">
                      <div class="fileupload_block">
                        <input type="file" <?php if(!isset($product)){ echo 'required';} ?> name="size_chart" value="fileupload" id="fileupload" accept=".jpg, .png, jpeg, .PNG, .JPG, .JPEG">
                        
                        <div class="fileupload_img"><img type="image" src="<?php echo base_url('assets/images/no-image-1.jpg');?>" alt="product image" style="width: auto;height: 90px" /></div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-md-3 control-label"><?=$this->lang->line('delivery_charge_lbl')?> :-
                  </label>
                  <div class="col-md-6">
                    <input type="text" name="delivery_charge" id="delivery_charge" value="<?php if(isset($product)){ echo $product[0]->delivery_charge;}else{ echo '0';} ?>" class="form-control" placeholder="<?=$this->lang->line('delivery_charge_lbl')?>" required>
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

<div class="clearfix"></div>

<script src="<?=base_url('assets/js/jscolor.js')?>"></script>

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

  function readURL2(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $("input[name='file_name2']").next(".fileupload_img").find("img").attr('src', e.target.result);
      }
      
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("input[name='file_name2']").change(function() { 
    readURL2(this);
  });

  function readURL3(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $("input[name='size_chart']").next(".fileupload_img").find("img").attr('src', e.target.result);
      }
      
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("input[name='size_chart']").change(function() { 
    readURL3(this);
  });

</script> 

<script type="text/javascript">
  CKEDITOR.replace( 'product_features_desc', {
      removePlugins: 'link,about', 
      removeButtons:'Subscript,Superscript,Image',
  });
</script>

<script type="text/javascript">

  // edit product 
  var product_id=$(".product_id").val();

  var _id=$("select[name='category_id']").val();
  

  // for sub category
  var _old_id_sub=$(".old_sub_cat_id").val();

  $("select[name='sub_cat_id']").html("<option value='0'>--<?=$this->lang->line('select_subcat_lbl')?>--</option>");

  var href = '<?php echo site_url('admin/product/get_sub_category/')?>'+_id;

  $.ajax({
  type:'GET',
  url:href,
  success:function(res){
      $("select[name='sub_cat_id']").append(res);
      $('#sub_category_id option[value="'+_old_id_sub+'"]').prop('selected', true);
    }
  });

  // for brands
  var _old_id_brand=$(".old_brand_id").val();

  $("select[name='brand_id']").html("<option value='0'>--<?=$this->lang->line('select_brand_lbl')?>--</option>");
  var href = '<?php echo site_url('admin/product/get_brands/')?>'+_id;

  $.ajax({
    type:'GET',
    url:href,
    success:function(res){
      $("select[name='brand_id']").append(res);
      $('#brand_id option[value="'+_old_id_brand+'"]').prop('selected', true);
    }
  });

  var href = '<?php echo site_url('admin/product/get_featured/')?>'+_id;

  $.ajax({
    type:'GET',
    url:href,
    success:function(res){
      res=$.trim(res);
      if(res!=''){
        var res_arr = res.split(",");  
        $.each(res_arr, function( index, value ) {
          $(".product_features").find("."+value).show();
        });
      }
    }
  });

  var _old_id_ofr=$(".old_offer_id").val();

  var _mrp=parseFloat($("input[name='product_mrp']").val());

  if(_old_id_ofr!=0){
    var href = '<?php echo site_url('admin/product/calculate_offer/')?>'+_old_id_ofr+'/'+_mrp;

    $.ajax({
      type:'GET',
      url:href,
      success:function(res){
          $('#offer_id option[value="'+_old_id_ofr+'"]').prop('selected', true);
          $obj=$.parseJSON(res);
          $("input[name='selling_price']").val($obj.selling_price);

          if(_old_id_ofr!=0){
            $("input[name='selling_price']").css("borderColor","green");
            $(".saving_info").show();
          }
          else{
            $("input[name='selling_price']").css("borderColor","#999");
            $(".saving_info").hide();
          }
          $("input[name='you_save']").val($obj.you_save);
          $("input[name='you_save_per']").val($obj.you_save_per);
        }
    });

  }
  else{
    $("input[name='selling_price']").val(_mrp);
  }

  var old_color_id=$(".old_color_id").val();

  var href = '<?php echo site_url('admin/product/get_color_products')?>';

  $.ajax({
    type:'POST',
    url:href,
    data: {brand_id: _old_id_brand, cat_id:_id, curr_id:product_id},
    success:function(res){
      $obj=$.parseJSON(res);
      if($obj.status){
          $(".other_color_product").show();
          $("#other_color_product").append($obj.data);
          if(old_color_id!=''){
            var res_arr = old_color_id.split(",");
            $.each(res_arr, function( index, value ) {
              $('#other_color_product option[value="'+value+'"]').prop('selected', true);
            });
          }
      }
    }
  });

  $(document).ready(function(e){

    $("input[name='product_mrp']").keyup(function(e){
      if($(this).val()!=''){
        var _mrp=parseInt($(this).val());
        $("input[name='selling_price']").val($(this).val());
      }
    });


    // apply offser
    $("select[name='offer_id']").on("change",function(e){

      var _mrp=parseInt($("input[name='product_mrp']").val());
      var _id=$(this).val();

      var href = '<?php echo site_url('admin/product/calculate_offer/')?>'+_id+'/'+_mrp;

      $.ajax({
        type:'GET',
        url:href,
        success:function(res){
          $obj=$.parseJSON(res);
          $("input[name='selling_price']").val($obj.selling_price);

          if(_id!=0){
            $("input[name='selling_price']").css("borderColor","green");
            $(".saving_info").show();
          }
          else{
            $("input[name='selling_price']").css("borderColor","#999");
            $(".saving_info").hide();
          }
          $("input[name='you_save']").val($obj.you_save);
          $("input[name='you_save_per']").val($obj.you_save_per);
        }
      });

    });


    $("select[name='category_id']").change(function(e){

      var _id=$(this).val();

      // getting sub categories
      $("select[name='sub_cat_id']").html("<option value='0'>--<?=$this->lang->line('select_subcat_lbl')?>--</option>");
      var href = '<?php echo site_url('admin/product/get_sub_category/')?>'+_id;

      $.ajax({
        type:'GET',
        url:href,
        success:function(res){
            $("select[name='sub_cat_id']").append(res);
          }
      });

      $("select[name='brand_id']").html("<option value='0'>--<?=$this->lang->line('select_brand_lbl')?>--</option>");
      var href = '<?php echo site_url('admin/product/get_brands/')?>'+_id;

      $.ajax({
        type:'GET',
        url:href,
        success:function(res){
          $("select[name='brand_id']").append(res);
        }
      });

      var href = '<?php echo site_url('admin/product/get_featured/')?>'+_id;

      $.ajax({
        type:'GET',
        url:href,
        success:function(res){
          res=$.trim(res);
          var res_arr = res.split(",");
          $.each(res_arr, function( index, value ) {
            $(".product_features").find("."+value).show();
          });
        }
      });

    });

    $(".remove_img").click(function(e){

      e.preventDefault();

      var _id=$(this).data("id");

      var href = '<?php echo site_url('admin/product/remove/')?>'+_id;

      var btn = this;

      swal({
          title: "Are you sure ?",
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
                    if(res=='success'){
                      swal.close();
                      $(btn).closest('div').fadeOut("200");
                    }
                    else
                    {
                      alert("Error");
                    }
                  }
              });
          }
          else{
            swal.close();
          }
      });

    });

    // other product colors

    $("select[name='brand_id']").change(function(e){

        var brand_id=$(this).val();
        var cat_id=$("select[name='category_id']").val();
        var curr_id=0;

        if(product_id!=''){
          curr_id=product_id;
        }

        var href = '<?php echo site_url('admin/product/get_color_products')?>';

        if(cat_id!=''){
          $.ajax({
            type:'POST',
            url:href,
            data: {brand_id: brand_id, cat_id:cat_id, curr_id:curr_id},
            success:function(res){
              $obj=$.parseJSON(res);
              if($obj.status){
                  $(".other_color_product").show();
                  $("#other_color_product").append($obj.data);
              }
            }
          });
        }
    });

  });
</script>