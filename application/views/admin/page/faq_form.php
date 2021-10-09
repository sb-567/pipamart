<?php 
  $redirect=$_GET['redirect'].(isset($_GET['page']) ? '&page='.$_GET['page'] : '');
?>
<div class="row card_item_block" style="padding-left: 30px;padding-right: 30px">
  <div class="col-md-12">
    <?php 
      if(isset($_GET['redirect'])){
        echo '<a href="'.$redirect.'"><h4 class="pull-left btn_back" style=""><i class="fa fa-arrow-left"></i> Back</h4></a>';
      }
      else{
        echo '<a href="'.base_url('admin/settings').'"><h4 class="pull-left btn_back" style=""><i class="fa fa-arrow-left"></i> Back</h4></a>'; 
      }
    ?>
    <div class="card">
      <div class="page_title_block">
        <div class="col-md-5 col-xs-12">
          <div class="page_title"><?=$current_page?></div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="row mrg-top">
        <div class="col-md-12">
            <?php
                define('IMG_PATH', base_url().'assets/images/category/');

                if($this->session->flashdata('response_msg')) {
                  $message = $this->session->flashdata('response_msg');
                  ?>
                    <div class="<?=$message['class']?> alert-dismissible" role="alert" style="margin-left: 30px;margin-right: 30px">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                      <?=$message['message']?>
                    </div>
                  <?php
                }
            ?>

        </div>
      </div>
      <div class="card-body mrg_bottom"> 
        <form action="<?php if(!isset($faq_row)){ echo site_url('admin/pages/add_faq').'?redirect='.$redirect; }else{  echo site_url('admin/pages/edit_faq/'.$faq_row->id).'?redirect='.$redirect; } ?>" method="post" id="categoryForm" class="form form-horizontal" enctype="multipart/form-data">
          <div class="section">
            <div class="section-body">
              <div class="html_content">
                <div class="content">
                  <div class="content_holder">
                    <div class="form-group">
                      <label class="col-md-3 control-label"><?=$this->lang->line('question_lbl')?>:-</label>
                      <div class="col-md-6">
                        <input type="text" placeholder="<?=$this->lang->line('question_place_lbl')?>" name="faq_question[]" required="" class="form-control" value="<?=(isset($faq_row)) ? $faq_row->faq_question : '';?>">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-3 control-label"><?=$this->lang->line('answer_lbl')?>:-</label>
                      <div class="col-md-6">
                        <textarea name="faq_answer[]" placeholder="<?=$this->lang->line('answer_place_lbl')?>" required="" class="form-control faq_answer" rows="5"><?=(isset($faq_row)) ? $faq_row->faq_answer : '';?></textarea>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-3 control-label"></label>
                      <div class="col-md-6 text-right">
                        <a href="" class="btn_remove" style="color: #F00;display: none;">&times; <?=$this->lang->line('remove_lbl')?></a>
                      </div>
                    </div>
                    <br/>
                  </div>
                </div>
                
              </div>
              <?=(isset($faq_row)) ? '' : '<div class="form-group">
                <div class="col-md-9 col-md-offset-3">                      
                  <button type="button" class="btn btn-success btn-xs btn_more">'.$this->lang->line('add_more_lbl').'</button>
                </div>
              </div>';?>
              
              <br/>
              <div class="form-group">
                <div class="col-md-3 col-md-offset-3">
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

  $(".btn_more").click(function(event){
    var _html=$(".html_content .content").first().html();
    $(".html_content").append(_html);

    $('.btn_remove').each(function(index ){
        if(index!=0){
          $(this).show();
        }

    });

    $(".btn_remove").click(function(e){
      e.preventDefault();

      $(this).parents('.form-group').parents(".content_holder").remove();

    });



  });
</script>
