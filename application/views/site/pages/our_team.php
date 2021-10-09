<?php 
  $this->load->view('site/layout/breadcrumb'); 
  // print_r($contact_subjects);

  // print_r($settings_row);

  $ci =& get_instance();
?>
<section class="about-us-area"> 
  <div class="container-fluid">

    <?php $i=1; foreach ($teams as $key => $value) { ?>
      <?php if($i%2 == 0){ ?>
          <div class="row">
            <div class="mt_40"> 
              <div class="col-md-7">
                <h2><?php echo $value->name; ?></h2>
                <?php echo $value->content; ?>
              </div>
              <div class="col-md-5">
                  <img src="<?=base_url('assets/images/'.$value->image);?>" class="img-responsive" >
              </div>
            </div>
          </div>
      <?php }else{ ?>
          <div class="row"> 
            <div class="mt_40">
              <div class="col-md-5">
                  <img src="<?=base_url('assets/images/'.$value->image);?>" class="img-responsive" >
              </div>
              <div class="col-md-7">
                  <h2><?php echo $value->name; ?></h2>
                <?php echo $value->content; ?>
              </div>
            </div>
          </div>
      <?php } ?>

  <?php $i++; } ?>

  </div>
</section>
    