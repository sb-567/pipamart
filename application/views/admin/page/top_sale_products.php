<div class="row card_item_block" style="padding-left:30px;padding-right: 30px">
  <div class="col-xs-12">
    <div class="card mrg_bottom">
      <div class="page_title_block">
        <div class="col-md-5 col-xs-12">
          <div class="page_title"><?=$current_page?></div>
        </div>
        <div class="col-md-6 col-md-offset-1 col-xs-12">
          <div class="col-sm-12">
            <div class="search_list">
              <div class="search_block">
                <form  method="post" action="">
                <input class="form-control input-sm" placeholder="<?=$this->lang->line('search_lbl')?>" aria-controls="DataTables_Table_0" type="search" name="search_value" required value="<?php if(isset($_POST['search_value'])){ echo $_POST['search_value']; }?>">
                      <button type="submit" name="data_search" class="btn-search"><i class="fa fa-search"></i></button>
                </form>  
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-12 mrg-top">
        <?php 
          if($this->session->flashdata('response_msg')) {
            $message = $this->session->flashdata('response_msg');
            ?>
              <div class="<?=$message['class']?> alert-dismissible" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                <?=$message['message']?>
              </div>
            <?php
          }
        ?>
        <?php 
          if(!empty($products)){ 
        ?>
        <div class="row">
          <?php 
            $i=0;
            define('IMG_PATH', base_url().'assets/images/products/');

            $CI=&get_instance();

            // print_r($products);

            foreach ($products as $key => $row) 
            {

          ?>
          <div class="col-lg-4 col-sm-6 col-xs-12 item_holder">
            <div class="block_wallpaper add_wall_category" style="box-shadow:0px 3px 8px rgba(0, 0, 0, 0.3)">  
              <div class="wall_category_block">
                <h2 style="font-size: 16px">
                  <?php 
                    if(strlen($row->category_name) > 23){
                      echo substr(stripslashes($row->category_name), 0, 23).'...';  
                    }else{
                      echo $row->category_name;
                    }
                  ?>
                </h2>
              </div>        
              <div class="wall_image_title">
                <h2>
                  <a href="javascript:void(0)" style="text-shadow: 1px 1px 1px #000;font-size: 16px" title="<?=$row->product_title?>">
                  <?php 
                    if(strlen($row->product_title) > 33){
                      echo substr(stripslashes($row->product_title), 0, 33).'...';  
                    }else{
                      echo $row->product_title;
                    }
                  ?>
                  </a>
                </h2>
                <ul>                
                  <li><a href="javascript:void(0)" data-toggle="tooltip" data-tooltip="<?=$row->total_views?> Views"><i class="fa fa-eye"></i></a></li>
                  <li>
                    <div class="container-fluid">
                      <span class="label label-danger">Total Sales: <?=$row->total_sale?></span>
                    </div>
                  </li>
                </ul>
              </div>
              <span>
                <?php 
                  if(file_exists(IMG_PATH.$row->featured_image) || $row->featured_image==''){
                    ?>
                    <img src="https://via.placeholder.com/300x300?text=No image" style="height: 300px !important">
                    <?php
                  }else{
                    ?>
                    <img src="<?=IMG_PATH.$row->featured_image?>" style="height: 300px !important"/>
                    <?php
                  }
                ?>
              </span>
            </div>
          </div>  
        <?php 
            $i++;
          }
        ?>
        </div>
        <?php }else{ ?>
          <div class="col-lg-12 col-sm-12 col-xs-12" style="">
            <h3 class="text-muted" style="font-weight: 400">Sorry! no records found...</h3>
          </div>
        <?php } ?>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-12 col-xs-12">
          <div class="pagination_item_block">
            <nav>
              <?php 
                  if(!empty($links)){
                    echo $links;  
                  } 
              ?>
            </nav>
          </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

</script>