<div class="row card_item_block" style="padding-left: 30px;padding-right: 30px">
  <div class="col-md-12">
    <?php 
      if(isset($_GET['redirect'])){
        echo '<a href="'.$_GET['redirect'].'"><h4 class="pull-left btn_back" style=""><i class="fa fa-arrow-left"></i> Back</h4></a>';
      }
      else{
        echo '<a href="'.base_url('admin/contacts').'"><h4 class="pull-left btn_back" style=""><i class="fa fa-arrow-left"></i> Back</h4></a>'; 
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
        <form action="<?php if(!isset($subjects)){ echo site_url('admin/contacts/addForm'); }else{  echo site_url('admin/contacts/editForm/'.$subjects[0]->id).'?redirect='.$_GET['redirect'];} ?>" method="post" id="categoryForm" class="form form-horizontal" enctype="multipart/form-data">
          <div class="section">
            <div class="section-body">
              <div class="input-container">
                <div class="form-group">
                  <label class="col-md-3 control-label"><?=$this->lang->line('title_lbl')?> :-
                  
                  </label>
                  <div class="col-md-6">
                    <input type="text" placeholder="<?=$this->lang->line('title_place_lbl')?>" id="subject_title" name="subject_title[]" class="form-control" required="" value="<?php if(isset($subjects)){ echo $subjects[0]->title;} ?>">
                    <a href="" class="btn_remove" style="float: right;color: red;font-weight: 600;opacity: 0">&times; <?=$this->lang->line('remove_lbl')?></a>
                  </div>
                </div>
              </div>
              <?php 
                if(!isset($subjects)){
              ?>
              <div id="dynamicInput"></div>
              <div class="form-group">
                  <div class="col-md-9 col-md-offset-3">                      
                    <button type="button" class="btn btn-success btn-xs add_more"><?=$this->lang->line('add_more_subject_lbl')?></button>
                  </div>
                </div>
              <br/>
              <?php } ?>
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