<?php 
  $this->load->view('site/layout/breadcrumb'); 
?>

<section class="contact-form-area mt-20 mb-30">
  <div class="container">
    <div class="row"> 
      <?php 
        $i=0;
        $ci =& get_instance();
        foreach ($category_list as $key => $row) 
        {
          $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row->category_image);

          $img_file=base_url().$ci->_create_thumbnail('assets/images/category/',$thumb_img_nm,$row->category_image,270,162);

          $counts=$ci->getCount('tbl_sub_category', array('category_id' => $row->id, 'status' => '1'));

          if($counts > 0)
          {
            $url=base_url('category/'.$row->category_slug);  
          }
          else{
            $url=base_url('category/products/'.$row->id);
          }

      ?>
      <div class="col-md-3 col-sm-4 col-xs-6">
        <div class="single-offer">
          <div class="all_categori_list img-full"> 
            <a href="<?=$url?>" title="<?=$row->category_name?>">          
              <img src="<?=$img_file?>" alt=""> 
              <span>
                <?php 
                  if(strlen($row->category_name) > 30){
                    echo strstr(stripslashes($row->category_name), 0, 30).'...';  
                  }else{
                    echo $row->category_name;
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