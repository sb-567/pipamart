<?php 
  $this->load->view('site/layout/breadcrumb'); 
?>

<section class="contact-form-area mt-20 mb-30">
  <div class="container">
    <div class="row"> 
      <?php 
        $i=0;
        $ci =& get_instance();
        foreach ($brands_list as $key => $row) 
        {
          
          if($row->brand_image!=''){
            $img_file=base_url().$ci->_create_thumbnail('assets/images/brand/',$row->brand_slug,$row->brand_image,400,240);
          }
          else{
            $img_file='https://via.placeholder.com/400x240?text=No image';
          }


          $url=base_url('brand/'.$row->brand_slug);



      ?>
      <div class="col-md-2 col-sm-4 col-xs-6">
        <div class="single-offer">
          <div class="all_categori_list img-full"> 
            <a href="<?=$url?>" title="<?=$row->brand_name?>">          
              <img src="<?=$img_file?>" alt="<?=$row->brand_name?>" style="height: 100%"> 
              <span>
                <?php 
                  if(strlen($row->brand_name) > 20){
                    echo substr(stripslashes($row->brand_name), 0, 20).'...';  
                  }else{
                    echo $row->brand_name;
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