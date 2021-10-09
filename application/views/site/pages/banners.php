<?php 
  $this->load->view('site/layout/breadcrumb'); 
?>
<section class="contact-form-area mt-20 mb-30">
  <div class="container">
    <div class="row"> 
      <?php 
        $i=0;
        $ci =& get_instance();
        foreach ($banner_list as $key => $row) 
        {
          $img_file=base_url().$ci->_create_thumbnail('assets/images/banner/',$row->banner_slug,$row->banner_image,400,125);

          $url=base_url('banners/'.$row->banner_slug);

      ?>
      <div class="col-md-4 col-sm-4 col-xs-6">
        <div class="single-offer">
          <div class="all_categori_list img-full"> 
            <a href="<?=$url?>">          
              <img src="<?=$img_file?>" alt=""> 
              <span>
                <?php 
                  if(strlen($row->banner_title) > 30){
                    echo strtr(stripslashes($row->banner_title), 0, 30).'...';  
                  }else{
                    echo $row->banner_title;
                  }
                ?>
              </span>
            </a>
          </div>
        </div>
      </div> 
      <?php } ?>      
    </div>
  </div>
</section>