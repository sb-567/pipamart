<div class="row card_item_block" style="padding-left: 30px;padding-right: 30px">
  <div class="col-md-12">
    <?php 
      if(isset($_GET['redirect'])){
        echo '<a href="'.$_GET['redirect'].'"><h4 class="pull-left btn_back" style=""><i class="fa fa-arrow-left"></i> Back</h4></a>';
      }
      else{
        echo '<a href="'.base_url('admin/cms').'"><h4 class="pull-left btn_back" style=""><i class="fa fa-arrow-left"></i> Back</h4></a>'; 
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
        <form action="<?php if(!isset($data)){ echo site_url('admin/cms/addFormTeams'); }else{  echo site_url('admin/cms/editFormTeams/'.$data[0]->id).'?redirect='.$_GET['redirect'];} ?>" method="post" id="categoryForm" class="form form-horizontal" enctype="multipart/form-data">
          <div class="section">
            <div class="section-body">
              <div class="input-container">
                <div class="form-group">
                  <label class="col-md-3 control-label">Name :-
                  
                  </label>
                  <div class="col-md-9">
                    <input type="text" placeholder="Name" id="name" value="<?php if(isset($data)){ echo $data[0]->name;} ?>" name="name" class="form-control" required="" >


                    <?php if(isset($data)){ echo '<input type="hidden" name="id" value="'.$data[0]->id.'">'; } ?>
                    
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-3 control-label">Description :-
                  
                  </label>
                  <div class="col-md-9">
                    <textarea type="text" placeholder="Description" id="description" name="description" class="form-control" required="" rows="6"><?php if(isset($data)){ echo $data[0]->content;} ?></textarea>
                    <script>CKEDITOR.replace( 'description' );</script>
                    
                  </div>
                </div>
                <br>
                <div class="form-group">
                            <label class="col-md-3 control-label"><?=$this->lang->line('select_image_lbl')?> :-
                                <p class="control-label-help hint_lbl">(<?=$this->lang->line('recommended_resolution_lbl')?>: 1920X600)</p>
                                <p class="control-label-help hint_lbl">(<?=$this->lang->line('accept_img_files_lbl')?>)</p>
                                <p class="control-label-help hint_lbl">(<?=$this->lang->line('recommended_img_lbl')?>)</p>
                            </label>
                            <div class="col-md-6">
                              <div class="fileupload_block">
                                <input type="file" name="image" value="fileupload" <?=empty($data[0]->image) ? 'required="required"' : ''?> id="fileupload" accept=".gif, .jpg, .png, jpeg">
                                
                                <div class="fileupload_img"><img type="image" src="<?php 
                                  if(empty($data[0]->image)){ echo base_url('assets/images/no-image-1.jpg'); }else{  echo base_url('assets/images/').$data[0]->image; } 
                                ?>" alt="About image" style="width: 230px !important;height: 120px !important" /></div>
                                   
                              </div>
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

  function readURL4(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      
      reader.onload = function(e) {
        $("input[name='image']").next(".fileupload_img").find("img").attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
  $("input[name='image']").change(function() { 
    readURL4(this);
  });

</script>