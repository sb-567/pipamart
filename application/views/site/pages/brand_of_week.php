<?php 
  
  if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->libraries_load_from=='local')
  {
    add_css(array('assets/site_assets/css/nivo-slider.css', 'assets/site_assets/css/slick.min.css'));

    add_footer_js(array('assets/site_assets/js/jquery.nivo.slider.js','assets/site_assets/js/jquery.countdown.min.js','assets/site_assets/js/slick.min.js'));
  }
  else if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->libraries_load_from=='cdn')
  {
    add_cdn_css(array('https://cdnjs.cloudflare.com/ajax/libs/jquery-nivoslider/3.2/nivo-slider.min.css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css'));

    add_footer_cdn_js(array('https://cdnjs.cloudflare.com/ajax/libs/jquery-nivoslider/3.2/jquery.nivo.slider.min.js','https://cdnjs.cloudflare.com/ajax/libs/jquery.countdown/2.2.0/jquery.countdown.min.js','https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js'));
  }

  add_footer_js(array('assets/site_assets/js/nivo.slider.init.js', 'assets/site_assets/js/slick.init.js'));

  $ci =& get_instance();
?>

<style type="text/css">
  .nivo-controlNav{
    z-index: 16 !important; 
  }
  .nivoSlider a.nivo-imageLink{
    z-index: 15 !important; 
  }
</style>



    <!-- start slider container -->
<section class="pt_5">
  <div class="container-fluid">
    <div class="row">
      <div class="sec-title">
        <div class="col-lg-6 text-left">
          <div class="cat-title">
            <h3>Eco Brand Of Week</h3>
          
          </div>
        </div>
        <div class="col-lg-6 text-right">
          <!-- <a href="#">View all</a> -->
        </div>
      </div>
    </div>
    
  </div>
  <div class="container-fluid">
    <div class="row">
         <?php 
        $i=0;
        foreach ($banner_list as $key => $row) 
        {
          $img_file=base_url().$ci->_create_thumbnail('assets/images/banner/',$row->banner_slug,$row->banner_image,1349,700);
      ?>
        <div class="col-md-4 col-sm-6 col-lg-4">
          <div class="item">
            <a href="<?=base_url('banners/'.$row->banner_slug)?>">
              <img src="<?=$img_file?>" class="banner_img" alt="" title="#<?=$row->id?>"/>
            </a>
          </div>
        </div>
          <?php 
        }
      ?>
        
  </div>
</section>
