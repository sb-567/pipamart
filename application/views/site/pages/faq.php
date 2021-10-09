<?php 
  $this->load->view('site/layout/breadcrumb');
  $ci =& get_instance();
?>
<section class="frequently-question mt-20">
  <div class="container">
    <div class="row"> 
      <div class="col-md-12">
        <div class="goroup-accrodion mb-60">
          <div class="panel-group" id="accordion" role="tablist">
            <?php 
              $is_active=true;
              foreach ($faq_row as $key => $value) {
            ?>
            <div class="panel panel-default<?=($is_active) ? ' active' : ''?>">
              <div class="panel-heading">
                <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#<?=$value->id?>"> <?=$value->title?></a> </h4>
              </div>
              <div id="<?=$value->id?>" class="panel-collapse collapse<?=($is_active) ? ' in' : ''?>">
                <div class="panel-body" style="text-align: justify;">
                  <?=nl2br(stripslashes($value->description))?>
                </div>
              </div>
            </div>
            <?php $is_active=false; } ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
    