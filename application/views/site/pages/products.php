<?php 
  
  if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->libraries_load_from=='local')
  {
    add_css(array('assets/site_assets/css/slick.min.css'));

    add_footer_js(array('assets/site_assets/js/slick.min.js'));
  }
  else if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->libraries_load_from=='cdn')
  {
    add_cdn_css(array('https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css'));

    add_footer_cdn_js(array('https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js'));
  }

  add_footer_js(array('assets/site_assets/js/slick.init.js'));
  
  
  $ci =& get_instance();
?>
<?php
    $urls = array();
    $segments = $this->uri->segment_array();

    foreach($segments as $key=>$segment)
    {
        $urls[] = array(site_url(implode( '/',array_slice($segments,0,$key))),$segment);
    }

    if($segments[1]=='product'){

      $ci =& get_instance();  

      $cat_id=$ci->get_single_info(array('product_slug' => $segments[2]),'category_id','tbl_product');
      $sub_cat_id=$ci->get_single_info(array('product_slug' => $segments[2]),'sub_category_id','tbl_product');

      $cat_slug=$ci->get_single_info(array('id' => $cat_id),'category_slug','tbl_category');

      $sub_cat_slug=$ci->get_single_info(array('id' => $sub_cat_id),'sub_category_slug','tbl_sub_category');


      $url='<span class="breadcome-separator">></span><li>'.anchor(base_url('category/'), ucwords(strtolower('category'))).'</li><span class="breadcome-separator">></span><li>'.anchor(base_url('/category'), ucwords(strtolower($cat_slug))).'</li><span class="breadcome-separator">></span><li>'.anchor(base_url('category/'.$cat_slug.'/'.$sub_cat_slug), ucwords(strtolower($sub_cat_slug))).'</li>';

    }
?>

<div class="product-list-grid-view-area mt-20" id="products_list">
  <div class="container-fluid">
    
    <div class="row"> 

      <div class="col-lg-2 col-md-2"> 
        <div class="sidebar">
            <?php 
      if(isset($_GET['sortByBrand']) || isset($_GET['sortBySize']) || isset($_GET['price_filter']) || isset($_GET['sort']))
      {
    ?>
      <p style="font-size: 16px; border-bottom: 2px solid #995743; padding-bottom: 15px; margin-bottom: 0; color: #000; padding-left: 20px; "><?=$this->lang->line('filters_lbl')?>:
        <br/>
        <?php 
          if(isset($_GET['sortByBrand']))
          {
            foreach ($_GET['sortByBrand'] as $key => $value) {
            ?>
            <span class="tag label label-danger" style="background-color: rgba(255,82,82,1);font-weight: 500;margin: 5px">
              <span><?=$ci->get_single_info(array('id' => $value), 'brand_name', 'tbl_brands')?></span>
              <a href="javascript:void(0)" style="color: #FFF" data-action="brands" data-id="<?=$value?>" class="remove_filter"><i class="fa fa-close"></i></a> 
            </span>
            <?php
            }
          }
        ?>

        <?php 
          if(isset($_GET['sortBySize']))
          {
            foreach ($_GET['sortBySize'] as $key => $value) {
            ?>
            <span class="tag label label-danger" style="background-color: rgba(255,82,82,1);font-weight: 500;margin: 5px">
              <span><?=$this->lang->line('size_lbl')?>: <?=$value?></span>
              <a href="javascript:void(0)" style="color: #FFF" data-action="size" data-id="<?=$value?>" class="remove_filter"><i class="fa fa-close"></i></a> 
            </span>
            <?php
            }
          }
        ?>

        <?php 
          if(isset($_GET['price_filter']))
          {
            ?>
            <span class="tag label label-danger" style="background-color: rgba(255,82,82,1);font-weight: 500;margin: 5px">
              <span><?=$this->lang->line('price_range_lbl')?>:&nbsp;&nbsp;<?=ucwords($_GET['price_filter'])?></span>
              <a href="javascript:void(0)" style="color: #FFF" data-action="price" class="remove_filter"><i class="fa fa-close"></i></a> 
            </span>
            <?php
          }
        ?>

        <?php 
          if(isset($_GET['sort']))
          {
            ?>
            <span class="tag label label-danger" style="background-color: rgba(255,82,82,1);font-weight: 500;margin: 5px">
              <span><?=$this->lang->line('sort_by_lbl')?>:&nbsp;&nbsp;<?=ucwords($_GET['sort'])?></span>
              <a href="javascript:void(0)" style="color: #FFF" data-action="sort" class="remove_filter"><i class="fa fa-close"></i></a> 
            </span>
            <?php
          }
        ?>

        
      </p>
      
      <?php } ?>
             <div id="accordion">
  <div class="card">
    <div class="card-header" id="headingOne">
        <a class="" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Category  <i class="fa fa-angle-down" aria-hidden="true"></i>
        </a>
        
    </div>

    <div id="collapseOne" class="collapse " aria-labelledby="headingOne" data-parent="#accordion">
      <div class="card-body">
        
          
          
            <ul class="product-categories">
              <?php
                
                $n=1;
                foreach ($category_list as $key => $row) 
                {
                  if($n > 5){
                    break;
                  }

                  $n++;
                  $counts=$ci->getCount('tbl_sub_category', array('category_id' => $row->id, 'status' => '1'));

                  if($counts > 0)
                  {
                    $url=base_url('category/'.$row->category_slug);  
                  }
                  else{
                    $url=base_url('category/products/'.$row->id);
                  }

              ?>
              <li>
                <i class="fa fa-angle-right"></i>
                <a href="<?=$url?>">
                  <?php 
                    if(strlen($row->category_name) > 30){
                      echo substr(stripslashes($row->category_name), 0, 30).'...';  
                    }else{
                      echo $row->category_name;
                    }
                  ?>
                </a>
              </li>
              <?php }
                if(count($category_list) > 5)
                {
                ?>
                  <li>
                    <i class="fa fa-angle-right"></i>
                    <a class="rx-default" href="<?=base_url('/category')?>"><?=$this->lang->line('view_all_lbl')?></a>
                  </li>
              <?php } ?>
            </ul>
          
        
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header" id="headingThree">
        <a class=" collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Brands <i class="fa fa-angle-down" aria-hidden="true"></i>
        </a>
        
    </div>
    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
      <div class="card-body">
         <?php
          if(!empty($brand_list))
          {
        ?>
        <div class="widget widget-brand">
          
          <div class="widget-content">
            <form action="" id="brand_sort" method="get">
              <?php

                if(isset($_GET['category'])){
                  echo '<input type="hidden" name="category" value="'.$_GET['category'].'">';
                }

                if(isset($_GET['keyword'])){
                  echo '<input type="hidden" name="keyword" value="'.$_GET['keyword'].'">';
                }

                if(isset($_GET['price_filter'])){
                  echo '<input type="hidden" name="price_filter" value="'.$_GET['price_filter'].'">';
                }

              ?>
              <div class="search_area">
                <input type="text" id="brand_search" placeholder="Search..">
                <button type="button" class="clear_search" style="display: none"><i class="fa fa-close"></i></button>
              </div>
              <ul class="brand-menu" style="max-height: 300px;overflow-y: auto;">
                <?php 
                  $checked='';
                  foreach ($brand_list as $key => $value) {

                    if(!empty($_GET['sortByBrand'])){
                      if(in_array($value->id,$_GET['sortByBrand'])){
                        $checked='checked="checked"';
                      }
                      else{
                        $checked='';
                      }
                    }
                ?>
                <li>
                  <label style="cursor: pointer;">
                      <input type="checkbox" name="sortByBrand[]" class="brand_sort" <?=$checked?> value="<?=$value->id?>">
                      <?=$value->brand_name?> 
                      <span class="pull-right">(<?=$brand_count_items[$value->id]?>)</span>
                  </label>
                </li>
                <?php } ?>
                <li style="display: none" class="no_data_found">No data found !</li>
              </ul>

              <?php

                if(isset($_GET['sortBySize'])){
                  foreach ($_GET['sortBySize'] as $key => $value) {
                    echo '<input type="hidden" name="sortBySize[]" value="'.$value.'">';  
                  }
                }

                if(isset($_GET['sort'])){
                  echo '<input type="hidden" name="sort" value="'.$_GET['sort'].'">'; 
                }

              ?>
              <div class="clearfix"></div>
              <input class="price-button" value="<?=$this->lang->line('filter_btn')?>" type="submit">
            </form>
          </div>
        </div>

        <?php } ?>
      </div>
    </div>
  </div>
<div class="card">
    <div class="card-header" id="headingTwo">
        <a class=" collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Price <i class="fa fa-angle-down" aria-hidden="true"></i>
        </a>
        
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
      <div class="card-body">
        <?php
          if($price_min!=$price_max){
        ?>
        <div class="widget widget-price-slider">
          
          <div class="widget-content">
            <div class="price-filter">
              <?php 
                if(isset($_GET['price_filter'])){

                  $price_filter=(explode('-', $_GET['price_filter']));

                  $min_price=$price_filter[0];
                  $max_price=$price_filter[1];

                }
                else{
                  $min_price=$price_min;
                  $max_price=$price_max;
                }
              ?>
              <form action="" method="get" id="price_filter_form">
                <?php

                  if(isset($_GET['category'])){
                    echo '<input type="hidden" name="category" value="'.$_GET['category'].'">';
                  }

                  if(isset($_GET['keyword'])){
                    echo '<input type="hidden" name="keyword" value="'.$_GET['keyword'].'">';
                  }

                ?>
                <div id="slider-range"></div>
                <span><?=$this->lang->line('price_range_lbl')?>:
                <input id="amount" class="amount" type="text" readonly="" data-currency="<?=CURRENCY_CODE?>" data-min="<?=floor($price_min)?>" data-max="<?=ceil($price_max)?>" data-min2="<?=floor($min_price)?>" data-max2="<?=ceil($max_price)?>">
                <input type="hidden" name="price_filter" id="price_filter" value="">
                </span>

                <?php
                  if(isset($_GET['sortByBrand'])){
                    foreach ($_GET['sortByBrand'] as $key => $value) {
                      echo '<input type="hidden" name="sortByBrand[]" value="'.$value.'">';
                    }
                  }
                  
                  if(isset($_GET['sortBySize'])){
                    foreach ($_GET['sortBySize'] as $key => $value) {
                      echo '<input type="hidden" name="sortBySize[]" value="'.$value.'">';
                    }
                  }

                  if(isset($_GET['sort'])){
                    echo '<input type="hidden" name="sort" value="'.$_GET['sort'].'">';
                  }
                ?>

                <input class="price-button" value="<?=$this->lang->line('filter_btn')?>" type="submit">
              </form>
            </div>
          </div>
        </div>
        <?php 
          }
          
          ?>
      </div>
    </div>
  </div>
   <div class="card">
    <div class="card-header" id="headingfour">
        <a class=" collapsed" data-toggle="collapse" data-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
          Sizes <i class="fa fa-angle-down" aria-hidden="true"></i>
        </a>
        
    </div>
    <div id="collapsefour" class="collapse" aria-labelledby="headingfour" data-parent="#accordion">
      <div class="card-body">
         <?php 
          if(!empty($size_list))
          {
        ?>
        <div class="widget widget-brand">

          <div class="widget-content">
            <form action="" id="size_sort" method="get">
              <?php

                if(isset($_GET['category'])){
                  echo '<input type="hidden" name="category" value="'.$_GET['category'].'">';
                }

                if(isset($_GET['keyword'])){
                  echo '<input type="hidden" name="keyword" value="'.$_GET['keyword'].'">';
                }

                if(isset($_GET['price_filter'])){
                  echo '<input type="hidden" name="price_filter" value="'.$_GET['price_filter'].'">';
                }

                if(isset($_GET['sortByBrand'])){
                  foreach ($_GET['sortByBrand'] as $key => $value) {
                    echo '<input type="hidden" name="sortByBrand[]" value="'.$value.'">';  
                  }
                }

              ?>
              <ul class="brand-menu size-brand-list">
                <?php 
                  $checked='';
                  foreach ($size_list as $key => $value) {

                    if(!empty($_GET['sortBySize'])){
                      if(in_array($value,$_GET['sortBySize'])){
                        $checked='checked="checked"';
                      }
                      else{
                        $checked='';
                      }
                    }
                ?>
                <li>
                  <label style="cursor: pointer;">
                      <input type="checkbox" name="sortBySize[]" class="size_sort" <?=$checked?> value="<?=$value?>">
                      <?=$value?> 
                  </label>
                </li>
                <?php } ?>
              </ul>

              <?php

                if(isset($_GET['sort'])){
                  echo '<input type="hidden" name="sort" value="'.$_GET['sort'].'">'; 
                }
              ?>
              <div class="clearfix"></div>
              <input class="price-button" value="<?=$this->lang->line('filter_btn')?>" type="submit">
            </form>
          </div>
        </div>

        <?php } ?>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingseven">
        <a class=" collapsed" data-toggle="collapse" data-target="#collapseseven" aria-expanded="false" aria-controls="collapseseven">
          Colour <i class="fa fa-angle-down" aria-hidden="true"></i>
        </a>
        
    </div>
    <div id="collapseseven" class="collapse" aria-labelledby="headingseven" data-parent="#accordion">
      <div class="card-body">
         <?php 
          if(!empty($color_list))
          {
        ?>
        <div class="widget widget-brand">

          <div class="widget-content">
            <form action="" id="size_sort" method="get">
              <?php

                if(isset($_GET['category'])){
                  echo '<input type="hidden" name="category" value="'.$_GET['category'].'">';
                }

                if(isset($_GET['keyword'])){
                  echo '<input type="hidden" name="keyword" value="'.$_GET['keyword'].'">';
                }

                if(isset($_GET['price_filter'])){
                  echo '<input type="hidden" name="price_filter" value="'.$_GET['price_filter'].'">';
                }

                if(isset($_GET['sortByBrand'])){
                  foreach ($_GET['sortByBrand'] as $key => $value) {
                    echo '<input type="hidden" name="sortByBrand[]" value="'.$value.'">';  
                  }
                }

                if(isset($_GET['sortByColor'])){
                  foreach ($_GET['sortByColor'] as $key => $value) {
                    echo '<input type="hidden" name="sortByColor[]" value="'.$value.'">';  
                  }
                }

              ?>
              <ul class="brand-menu size-brand-list">
                <?php 
                  $checked='';
                  foreach ($color_list as $val) {

                    if(!empty($_GET['sortByColor'])){
                      if(in_array($val['hex'],$_GET['sortByColor'])){
                        $checked='checked="checked"';
                      }
                      else{
                        $checked='';
                      }
                    }
                ?>
                <li>
                  <label style="cursor: pointer;">
                      <input type="checkbox" name="sortByColor[]" class="size_sort" <?=$checked?> value="<?=$val['hex']?>">
                      <?=$val['text']?> 
                  </label>
                </li>
                <?php } ?>
              </ul>

              <?php

                if(isset($_GET['sort'])){
                  echo '<input type="hidden" name="sort" value="'.$_GET['sort'].'">'; 
                }
              ?>
              <div class="clearfix"></div>
              <input class="price-button" value="<?=$this->lang->line('filter_btn')?>" type="submit">
            </form>
          </div>
        </div>

        <?php } ?>
      </div>
    </div>
  </div>
   <div class="card">
    <div class="card-header" id="headingfive">
        <a class=" collapsed" data-toggle="collapse" data-target="#collapsefive" aria-expanded="false" aria-controls="collapsefive">
          Discount Range <i class="fa fa-angle-down" aria-hidden="true"></i>
        </a>
        
    </div>
    <div id="collapsefive" class="collapse" aria-labelledby="headingfive" data-parent="#accordion">
      <div class="card-body">
         <?php 
          if(!empty($size_list))
          {
        ?>
        <div class="widget widget-brand">

          <div class="widget-content">
            <form action="" id="size_sort" method="get">
              <?php

                if(isset($_GET['category'])){
                  echo '<input type="hidden" name="category" value="'.$_GET['category'].'">';
                }

                if(isset($_GET['keyword'])){
                  echo '<input type="hidden" name="keyword" value="'.$_GET['keyword'].'">';
                }

                if(isset($_GET['price_filter'])){
                  echo '<input type="hidden" name="price_filter" value="'.$_GET['price_filter'].'">';
                }

                if(isset($_GET['sortByBrand'])){
                  foreach ($_GET['sortByBrand'] as $key => $value) {
                    echo '<input type="hidden" name="sortByBrand[]" value="'.$value.'">';  
                  }
                }

              ?>
              <ul class="brand-menu size-brand-list">
                <?php 
                  $checked='';
                  foreach ($size_list as $key => $value) {

                    if(!empty($_GET['sortBySize'])){
                      if(in_array($value,$_GET['sortBySize'])){
                        $checked='checked="checked"';
                      }
                      else{
                        $checked='';
                      }
                    }
                ?>
                <li>
                  <label style="cursor: pointer;">
                      <input type="checkbox" name="sortBySize[]" class="size_sort" <?=$checked?> value="<?=$value?>">
                      10%
                  </label>
                </li>
                <?php } ?>
              </ul>

              <?php

                if(isset($_GET['sort'])){
                  echo '<input type="hidden" name="sort" value="'.$_GET['sort'].'">'; 
                }
              ?>
              <div class="clearfix"></div>
              <input class="price-button" value="<?=$this->lang->line('filter_btn')?>" type="submit">
            </form>
          </div>
        </div>

        <?php } ?>
      </div>
    </div>
  </div>
   <div class="card">
    <div class="card-header" id="headingsix">
        <a class=" collapsed" data-toggle="collapse" data-target="#collapsesix" aria-expanded="false" aria-controls="collapsesix">
          Customer Rating <i class="fa fa-angle-down" aria-hidden="true"></i>
        </a>
        
    </div>
    <div id="collapsesix" class="collapse" aria-labelledby="headingsix" data-parent="#accordion">
      <div class="card-body">
         <?php 
          if(!empty($size_list))
          {
        ?>
        <div class="widget widget-brand">

          <div class="widget-content">
            <form action="" id="size_sort" method="get">
              <?php

                if(isset($_GET['category'])){
                  echo '<input type="hidden" name="category" value="'.$_GET['category'].'">';
                }

                if(isset($_GET['keyword'])){
                  echo '<input type="hidden" name="keyword" value="'.$_GET['keyword'].'">';
                }

                if(isset($_GET['price_filter'])){
                  echo '<input type="hidden" name="price_filter" value="'.$_GET['price_filter'].'">';
                }

                if(isset($_GET['sortByBrand'])){
                  foreach ($_GET['sortByBrand'] as $key => $value) {
                    echo '<input type="hidden" name="sortByBrand[]" value="'.$value.'">';  
                  }
                }

              ?>
               <div class="rate">
    <input type="radio" id="star5" name="rate" value="5" />
    <label for="star5" title="text">5 stars</label>
    <input type="radio" id="star4" name="rate" value="4" />
    <label for="star4" title="text">4 stars</label>
    <input type="radio" id="star3" name="rate" value="3" />
    <label for="star3" title="text">3 stars</label>
    <input type="radio" id="star2" name="rate" value="2" />
    <label for="star2" title="text">2 stars</label>
    <input type="radio" id="star1" name="rate" value="1" />
    <label for="star1" title="text">1 star</label>
  </div>

              <?php

                if(isset($_GET['sort'])){
                  echo '<input type="hidden" name="sort" value="'.$_GET['sort'].'">'; 
                }
              ?>
              <div class="clearfix"></div>
              <input class="price-button" value="<?=$this->lang->line('filter_btn')?>" type="submit">
            </form>
          </div>
        </div>

        <?php } ?>
      </div>
    </div>
  </div>
</div>
        

       

        
        
          <?php 
            if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->product_ad=='true')
            {
          ?>
          <div>
            <div class="widget widget-brand">
              <?php 
                echo $this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->product_banner_ad;
              ?>
            </div>
          </div>
          <?php } ?>
          <div class="clearfix"></div>
        </div>
      </div>
      <div class="col-lg-10 col-md-10">
        <div class="shop-tab-menu">
          <div class="row"> 
            <div class="col-md-6 col-sm-3 col-lg-8 col-xs-12">
             <div class="heading-banner-area ">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="heading-banner">
          <div class="breadcrumbss">
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
            </div>
            <div class="col-md-6 col-sm-9 col-lg-4 hidden-xs text-right">
              <div class="toolbar-form">
                <form action="" method="get" id="sort_filter_form">

                  <?php

                    if(isset($_GET['category'])){
                      echo '<input type="hidden" name="category" value="'.$_GET['category'].'">';
                    }

                    if(isset($_GET['keyword'])){
                      echo '<input type="hidden" name="keyword" value="'.$_GET['keyword'].'">';
                    }

                    if(isset($_GET['price_filter'])){
                      echo '<input type="hidden" name="price_filter" value="'.$_GET['price_filter'].'">';
                    }

                    if(isset($_GET['sortByBrand'])){
                      foreach ($_GET['sortByBrand'] as $key => $value) {
                        echo '<input type="hidden" name="sortByBrand[]" value="'.$value.'">';  
                      }
                    }

                    if(isset($_GET['sortBySize'])){
                      foreach ($_GET['sortBySize'] as $key => $value) {
                        echo '<input type="hidden" name="sortBySize[]" value="'.$value.'">';
                      }
                    }
                  ?>

                  <div class="toolbar-select"> <span><?=$this->lang->line('sort_by_lbl')?>:</span>
                    <select data-placeholder="<?=$this->lang->line('sort_by_lbl')?>..." class="order-by list_order" name="sort" tabindex="1">
                      <option value="newest" <?php echo (isset($_GET['sort']) && strcmp($_GET['sort'], 'newest')==0) ? 'selected' : '' ?>><?=$this->lang->line('newest_first_lbl')?></option>
                      <option value="low-high" <?php echo (isset($_GET['sort']) && strcmp($_GET['sort'], 'low-high')==0) ? 'selected' : '' ?>><?=$this->lang->line('low_to_high_lbl')?></option>
                      <option value="high-low" <?php echo (isset($_GET['sort']) && strcmp($_GET['sort'], 'high-low')==0) ? 'selected' : '' ?>><?=$this->lang->line('high_to_low_lbl')?></option>
                      <option value="top" <?php echo (isset($_GET['sort']) && strcmp($_GET['sort'], 'top')==0) ? 'selected' : '' ?>><?=$this->lang->line('top_selling_lbl')?></option>
                    </select>
                  </div>
                </form>
              </div>
              <!--<div class="show-result">-->
              <!--  <p><?=$show_result;?></p>-->
              <!--</div>-->
            </div>
          </div>
        </div>
        <div class="shop-product-area">
          <div class="tab-content"> 
            <div id="grid-view" class="tab-pane fade in active">
              <div class="row">
                <div class="product-container"> 
                  <?php

                    $ci =& get_instance();
                    
                    foreach ($product_list as $key => $row)
                    {
            
                      $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

                      $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row->featured_image);

                      $img_file=$ci->_create_thumbnail('assets/images/products/',$thumb_img_nm,$row->featured_image,300,300);

                      $img_file2=$ci->_create_thumbnail('assets/images/products/',$row->product_id,$row->featured_image2,300,300);

                      $is_avail=true;

                      if($row->status==0)
                      {
                        $is_avail=false;
                      }

                  ?>
                  <div class="col-md-3 col-sm-3 col-xs-12 " id="">
                    <div class="single-product">
                      <?php 
                        if(!$is_avail)
                        {
                      ?>
                      <div class="unavailable_override">
                        <p><?=$this->lang->line('unavailable_lbl')?></p>
                      </div> 
                      <?php } ?>
                      <div class="product-img"> <a href="<?php echo site_url('product/'.$row->product_slug); ?>" title="<?=$row->product_title?>"> <img class="first-img" src="<?=base_url().$img_file?>" alt=""> <img class="hover-img" src="<?=base_url().$img_file2?>" alt=""> </a>
                        <?php 
                          if($row->you_save_per!='0'){
                            echo '<span class="sicker">'.$row->you_save_per.$this->lang->line('per_off_lbl').'</span>';
                          }
                        ?>
                        <ul class="product-action">
                          <?php 
                            if(check_user_login() && $ci->is_favorite($this->session->userdata('user_id'), $row->product_id)){
                              ?>
                              <li><a href="javascript:void(0)" class="btn_wishlist" data-id="<?=$row->product_id?>" data-toggle="tooltip" title="<?=$this->lang->line('remove_wishlist_lbl')?>" style="background-color: #ff5252"><i class="ion-android-favorite-outline"></i></a></li>
                              <?php
                            }
                            else if($ci->check_cart($row->product_id,$user_id)){
                              ?>
                              <li><a href="javascript:void(0)" data-toggle="tooltip" title="<?=$this->lang->line('already_cart_lbl')?>"><i class="ion-android-favorite-outline"></i></a></li>
                              <?php
                            } 
                            else{
                              ?>
                              <li><a href="javascript:void(0)" class="btn_wishlist" data-id="<?=$row->product_id?>" data-toggle="tooltip" title="<?=$this->lang->line('add_wishlist_lbl')?>"><i class="ion-android-favorite-outline"></i></a></li>
                              <?php
                            } 
                          ?>
                          <li><a href="javascript:void(0)" class="btn_quick_view" data-id="<?=$row->product_id?>" title="<?=$this->lang->line('quick_view_lbl')?>"><i class="ion-android-expand"></i></a></li>
                        </ul>
                      </div>
                      <div class="product-content">
                        <h2>
                          <a href="<?php echo site_url('product/'.$row->product_slug); ?>" title="<?=$row->product_title?>">
                             <?php 
                                if(strlen($row->product_title) > 25){
                                  echo substr(stripslashes($row->product_title), 0, 25).'...';  
                                }else{
                                  echo $row->product_title;
                                }
                              ?>
                          </a>
                          
                        
                        </h2>
                        <p>
                         
                             <?php 
                                if(strlen($row->product_desc) > 20){
                                  echo substr(stripslashes($row->product_desc), 0, 20).'...';  
                                }else{
                                  echo $row->product_desc;
                                }
                              ?>
                         
                          
                         
                        </p>
                        
                        <div class="product-price">
                          <div class="price_holder"> 
                            <?php 
                              if($row->you_save_amt!='0'){
                                ?>
                                <span class="new-price"><?=CURRENCY_CODE.' '.number_format($row->selling_price, 2)?></span> 
                                <span class="old-price"><?=CURRENCY_CODE.' '.number_format($row->product_mrp, 2);?></span>
                                
                                <?php
                              }
                              else{
                                ?>
                                <span class="new-price"><?=CURRENCY_CODE.' '.number_format($row->product_mrp, 2);?></span>
                                <?php
                                
                              }
                            ?>
                          </div>
                       
                           </div>
                      </div>
                    </div>
                  </div>
                  <?php } ?>
                </div>
              </div>
            </div>
            <div id="list-view" class="tab-pane fade">
              <div class="row">
                <div class="all-prodict-item-list pt-10"> 
                  <div class="row">
                    <?php

                      $ci =& get_instance();
                      
                      foreach ($product_list as $key => $row)
                      {
                        
                        $user_id=$this->session->userdata('user_id') ? $this->session->userdata('user_id'):'0';

                        $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row->featured_image);

                        $img_file=$ci->_create_thumbnail('assets/images/products/',$thumb_img_nm,$row->featured_image,300,300);

                        $img_file2=$ci->_create_thumbnail('assets/images/products/',$row->product_id,$row->featured_image2,300,300);

                        $is_avail=true;

                        if($row->status==0)
                        {
                          $is_avail=false;
                        }

                    ?>
                    <div class="col-md-12">
                      <div class="single-item">
                      <div class="product-img img-full">
                        <div class="col-md-4 col-sm-5"> 
                          <?php 
                            if(!$is_avail)
                            {
                          ?>
                          <div class="unavailable_override">
                            <p><?=$this->lang->line('unavailable_lbl')?></p>
                          </div> 
                          <?php } ?>
                          <a href="<?php echo site_url('product/'.$row->product_slug); ?>" title="<?=$row->product_title?>"> <img class="first-img" src="<?=base_url().$img_file?>" alt="" style="height: 280px;width: 280px"> <img class="hover-img" src="<?=base_url().$img_file2?>" alt="" style="height: 280px;width: 280px"> </a>
                          <?php 
                            if($row->you_save_per!='0'){
                              echo '<span class="sicker">'.$row->you_save_per.$this->lang->line('per_off_lbl').'</span>';
                            }
                          ?>
                        </div>
                        <div class="col-md-8 col-sm-7">
                        <div class="product-content-2">
                          <h2>
                            <a href="<?php echo site_url('product/'.$row->product_slug); ?>" title="<?=$row->product_title?>">
                               <?php 
                                  if(strlen($row->product_title) > 50){
                                    echo substr(stripslashes($row->product_title), 0, 50).'...';  
                                  }else{
                                    echo $row->product_title;
                                  }
                                ?>
                            </a>
                          </h2>
                          
                          <p><?php $row->product_desc ?></p>
                          
                          <div class="product-price">
                            <?php 
                              if($row->you_save_amt!='0'){
                                ?>
                                <span class="new-price"><?=CURRENCY_CODE.' '.number_format($row->selling_price, 2)?></span> 
                                <span class="old-price"><?=CURRENCY_CODE.' '.number_format($row->product_mrp, 2);?></span>
                                <?php
                              }
                              else{
                                ?>
                                <span class="new-price"><?=CURRENCY_CODE.' '.number_format($row->product_mrp, 2);?></span>
                                <?php
                                
                              }
                            ?>
                          </div>
                          <div class="rating mb-15"> 

                            <?php 
                              for ($x = 0; $x < 5; $x++) { 
                                if($x < $row->rate_avg){
                                  ?>
                                  <i class="fa fa-star" style="color: #F9BA48"></i>
                                  <?php  
                                }
                                else{
                                  ?>
                                  <i class="fa fa-star"></i>
                                  <?php
                                }
                              }
                            ?>
                          </div>
                          <div class="product-discription">
                            <?php 
                              if(strlen($row->product_desc) > 220){
                                  echo substr(stripslashes($row->product_desc), 0, 220).'...'; 
                              }else{
                                  echo $row->product_desc;
                              }
                            ?>
                          </div>
                          <div class="pro-action-2 mt-10">
                          <ul class="product-cart-area-list">
                            <li>
                              <?php 
                                if(!$ci->check_cart($row->product_id,$user_id)){
                                  ?>
                                  <a href="javascript:void(0)" class="action-btn big btn_cart <?=(!$is_avail) ? 'disabled' : ''?>" data-id="<?=$row->product_id?>" data-maxunit="<?=$row->max_unit_buy?>" data-toggle="tooltip" title="<?=$this->lang->line('add_cart_lbl')?>"><?=$this->lang->line('add_cart_btn')?></a>
                                  <?php
                                }
                                else{

                                  $cart_id=$ci->get_single_info(array('product_id' => $row->product_id, 'user_id' => $user_id),'id','tbl_cart');

                                  ?>
                                  <a class="action-btn big btn_remove_cart" href="<?php echo site_url('remove-to-cart/'.$cart_id); ?>" data-toggle="tooltip" title="<?=$this->lang->line('remove_cart_lbl')?>"><?=$this->lang->line('remove_cart_btn')?></a>
                                  <?php
                                }
                              ?>
                            </li>



                            <li>
                              <?php 
                                if(check_user_login() && $ci->is_favorite($this->session->userdata('user_id'), $row->product_id)){
                                  ?>
                                  <a class="action-btn small btn_wishlist" href="javascript:void(0)" class="btn_wishlist" data-id="<?=$row->product_id?>" data-toggle="tooltip" title="<?=$this->lang->line('remove_wishlist_lbl')?>" style="background-color: #ff5252"><i class="ion-android-favorite-outline"></i></a>

                                  <?php
                                }
                                else if($ci->check_cart($row->product_id,$user_id)){
                                  ?>

                                  <a class="action-btn small" href="javascript:void(0)" data-toggle="tooltip" title="<?=$this->lang->line('already_cart_lbl')?>"><i class="ion-android-favorite-outline"></i></a>

                                  <?php
                                } 
                                else{
                                  ?>

                                  <a class="action-btn small btn_wishlist" href="javascript:void(0)" class="btn_wishlist" data-id="<?=$row->product_id?>" data-toggle="tooltip" title="<?=$this->lang->line('add_wishlist_lbl')?>"><i class="ion-android-favorite-outline"></i></a>

                                  <?php
                                } 
                              ?>
                            </li>
                            <li>
                              <a class="action-btn small btn_quick_view" data-id="<?=$row->product_id?>" title="<?=$this->lang->line('quick_view_lbl')?>"><i class="ion-android-expand"></i></a>
                            </li>
                          </ul>
                          </div>
                        </div>
                        </div>
                      </div>
                      </div>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php 
          if(!empty($links)){
        ?>
        <div class="pagination pb-10">
          <?php 
              echo $links;  
          ?>
        </div>
        <?php } ?>
      </div>
      
    </div>
  </div>
</div>


<script type="text/javascript">

  $("#brand_search").val('');

  $("#brand_search").on("keyup",function(e){
    var input, filter, ul, li, a, i, txtValue;
    input = $(this).val();

    if(input!=''){
      $(".clear_search").show();
    }
    else{
      $(".clear_search").hide(); 
    }

    filter = input.toUpperCase();
    ul = $(this).parents("div").next("ul");
    li = ul.find('li');
    label = ul.find('li label');

    // Loop through all list items, and hide those who don't match the search query
    var _empty=0;
    for (i = 0; i < label.length; i++) {
      a = label[i];
      txtValue = a.textContent || a.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        label[i].style.display = "";
        li[i].style.display = "";
      } else {
        label[i].style.display = "none";
        li[i].style.display = "none";
        _empty++;
      }
    }

    if(_empty==label.length){
      ul.find(".no_data_found").show();
    }
    else{
      ul.find(".no_data_found").hide(); 
    }

  })


  $(".clear_search").click(function(e){
    e.preventDefault();

    $("#brand_search").val('');
    $("#brand_search").trigger('keyup');
    $(this).hide();
  });
</script>