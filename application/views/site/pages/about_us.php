<?php 
  $this->load->view('site/layout/breadcrumb'); 
  // print_r($contact_subjects);

  // print_r($settings_row);

  $ci =& get_instance();
?>
<section class="about-us-area"> 
  <div class="container-fluid">
    <div class="row"> 
    <div class="col-md-5">
        <img src="<?= $image; ?>" class="img-responsive" >
    </div>
      <div class="col-md-7">
          <h2><?=$about_title?></h2>
        <?=$settings_row?>
      </div>
    </div>
  </div>
</section>
    