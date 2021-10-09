<?php
    $urls = array();
    $segments = $this->uri->segment_array();

    foreach($segments as $key=>$segment)
    {
        $urls[] = array(site_url(implode( '/',array_slice($segments,0,$key))),$segment);
    }

    // print_r($urls);die;

    if($segments[1]=='product'){

      $ci =& get_instance();  

      $cat_id=$ci->get_single_info(array('product_slug' => $segments[2]),'category_id','tbl_product');
      $sub_cat_id=$ci->get_single_info(array('product_slug' => $segments[2]),'sub_category_id','tbl_product');

      $cat_slug=$ci->get_single_info(array('id' => $cat_id),'category_slug','tbl_category');

      $sub_cat_slug=$ci->get_single_info(array('id' => $sub_cat_id),'sub_category_slug','tbl_sub_category');


      $url='<span class="breadcome-separator">></span><li>'.anchor(base_url('category/'), ucwords(strtolower('category'))).'</li><span class="breadcome-separator">></span><li>'.anchor(base_url('/category'), ucwords(strtolower($cat_slug))).'</li><span class="breadcome-separator">></span><li>'.anchor(base_url('category/'.$cat_slug.'/'.$sub_cat_slug), ucwords(strtolower($sub_cat_slug))).'</li>';

    }
?>
<div class="heading-banner-area ">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="heading-banner">
          <div class="breadcrumbs">
            <ul>
              <li><a href="<?php echo site_url('/');?>"><?=$this->lang->line('home_lbl')?></a></li>
                <?php 
                    foreach($urls as $key => $value)
                    {
                      if(!is_numeric($value[1])){
                        if($value[1]=='product-reviews'){
                          continue;
                        }
                        else if($value[1]=='product'){
                          continue;
                        }
                        else{

                          $title='';

                          if(strlen($value[1]) > 45){
                            $title=substr(stripslashes($value[1]), 0, 45).'...';  
                          }else{
                            $title=$value[1];
                          }

                          if(strcmp(current_url(), $value[0])){
                            echo '<span class="breadcome-separator">></span><li>';
                            echo anchor($value[0], ucwords(strtolower($title)));
                            echo '</li>';
                          }
                          else{

                            if(strlen($current_page) > 45){
                              $title=substr(stripslashes($current_page), 0, 45).'...';  
                            }else{
                              $title=$current_page;
                            }

                            echo '<span class="breadcome-separator">></span><li>';
                            echo ucwords(strtolower($title));
                            echo '</li>'; 
                          }
                        }
                      }
                      else{
                        continue;  
                      }
                    }
                ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
