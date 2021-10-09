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
        <form action="<?php if(!isset($data)){ echo site_url('admin/cms/addForm'); }else{  echo site_url('admin/cms/editForm/'.$data[0]->id).'?redirect='.$_GET['redirect'];} ?>" method="post" id="categoryForm" class="form form-horizontal" enctype="multipart/form-data">
          <div class="section">
            <div class="section-body">
              <div class="input-container">
                <div class="form-group">
                  <label class="col-md-3 control-label"><?=$this->lang->line('title_lbl')?> :-
                  
                  </label>
                  <div class="col-md-9">
                    <textarea type="text" placeholder="<?=$this->lang->line('title_place_lbl')?>" id="title" name="title" class="form-control" required="" ><?php if(isset($data)){ echo $data[0]->title;} ?></textarea>

                    <input type="hidden"  id="flag" name="flag"  value="<?php if(isset($flag)){ echo $flag;} ?>">

                    <?php if(isset($data)){ echo '<input type="hidden" name="id" value="'.$data[0]->id.'">'; } ?>
                    
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-md-3 control-label">Description :-
                  
                  </label>
                  <div class="col-md-9">
                    <textarea type="text" placeholder="Description" id="description" name="description" class="form-control" required="" rows="6"><?php if(isset($data)){ echo $data[0]->description;} ?></textarea>

                    
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

  $(".btn_remove:eq(0)").hide();

  $(".add_more").click(function(e){

    var _html=$(".input-container").html();
      
    $("#dynamicInput").append(_html);

    $(".btn_remove:not(:eq(0))").css("opacity","1").show();

    $(".btn_remove").click(function(e){
      e.preventDefault();
      $(this).parents(".form-group").remove();
    });
  });

  $(".btn_remove").click(function(e){
    e.preventDefault();
    $(this).parents(".form-group").remove();
  });
</script>