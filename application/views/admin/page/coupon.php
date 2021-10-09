<?php 
define('CURRENCY_CODE', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_currency_html_code);
?>
<div class="row card_item_block" style="padding-left:30px;padding-right: 30px">
  <div class="col-xs-12">
    <div class="card mrg_bottom">
      <div class="page_title_block">
        <div class="col-md-5 col-xs-12">
          <div class="page_title"><?=$page_title?></div>
        </div>
        <div class="col-md-6 col-md-offset-1 col-xs-12">
          <div class="col-sm-12">
            <div class="search_list">
              <div class="search_block">
                <form method="GET" action="">
                <input class="form-control input-sm" placeholder="<?=$this->lang->line('search_lbl')?>" aria-controls="DataTables_Table_0" type="search" name="search_value" required value="<?php if(isset($_GET['search_value'])){ echo $_GET['search_value']; }?>">
                      <button type="submit" class="btn-search"><i class="fa fa-search"></i></button>
                </form>  
              </div>
              <div class="add_btn_primary"> <a href="<?php echo site_url("admin/coupon/add");?>?redirect=<?=$redirectUrl?>"><?=$this->lang->line('add_new_lbl')?></a> </div>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-12 mrg-top">
        <?php 
          if(!empty($coupon_list)){ 
        ?>
        <div class="row">
          <?php 
            define('IMG_PATH', base_url().'assets/images/coupons/');
            $i=0;
            $CI=&get_instance();
            foreach ($coupon_list as $key => $row) 
            {
          ?>
          <div class="col-lg-4 col-sm-6 col-xs-12 item_holder">
            <div class="block_wallpaper add_wall_category" style="box-shadow:0px 3px 8px rgba(0, 0, 0, 0.3)">           
              <div class="wall_image_title">
                <?php 
                  if($row->coupon_amt==0){
                    ?>
                    <h2><a href="<?php echo site_url("admin/coupon/edit/".$row->id);?>?redirect=<?=$redirectUrl?>" style="text-shadow: 1px 1px 1px #000;font-size: 16px"><?=$this->lang->line('discount_lbl')?>: <?=$row->coupon_per?>%</a></h2>
                    <?php
                  }
                  else{
                    ?>
                    <h2><a href="<?php echo site_url("admin/coupon/edit/".$row->id);?>?redirect=<?=$redirectUrl?>" style="text-shadow: 1px 1px 1px #000;font-size: 16px"><?=$this->lang->line('discount_lbl')?>: <?=CURRENCY_CODE?> <?=$row->coupon_amt?></a></h2>
                    <?php
                  }
                ?>

                <ul>

                  <li><a href="" data-toggle="tooltip" data-tooltip="<?=$this->lang->line('view_lbl')?>" class="coupons_detail"><i class="fa fa-eye"></i></a> 

                    <div class="detailsHolder" style="display: none;">
                        <div class="modal-body">
                          <div class="row">
                            <div style="text-align: justify;">
                              <h4><?=$this->lang->line('desc_lbl')?></h4>
                              <hr/>
                              <?=$row->coupon_desc?>
                            </div>
                          </div>
                          <hr/>
                          <div class="row">
                            <div class="col-md-4">
                               <?php 
                                  if($row->coupon_amt==0){
                                    ?>
                                    <p style="font-weight: normal !important;"><strong><?=$this->lang->line('discount_lbl')?>: </strong><?=$row->coupon_per?>%</p>
                                    <?php
                                  }
                                  else{
                                    ?>
                                    <p style="font-weight: normal !important;"><strong><?=$this->lang->line('discount_lbl')?>: </strong> <?=CURRENCY_CODE?> <?=$row->coupon_amt?></p>
                                    <?php
                                  }
                                ?>
                            </div>
                            <div class="col-md-8">
                               <p style="font-weight: normal !important;"><strong><?=$this->lang->line('max_discount_amt_lbl')?>: </strong><?=$row->coupon_max_amt?></p>
                            </div>
                            
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger btn_delete" data-dismiss="modal">&times; <?=$this->lang->line('close_btn')?></button>
                        </div>
                    </div>
                  </li>
                  <li><a href="<?php echo site_url("admin/coupon/edit/".$row->id);?>?redirect=<?=$redirectUrl?>" data-toggle="tooltip" data-tooltip="<?=$this->lang->line('edit_lbl')?>"><i class="fa fa-edit"></i></a></li>               
                  <li><a href="" data-toggle="tooltip" class="btn_delete_a" data-id="<?=$row->id?>" data-tooltip="<?=$this->lang->line('delete_lbl')?>"><i class="fa fa-trash"></i></a></li>
                  <li>
                    <div class="row toggle_btn">
                      <input type="checkbox" id="enable_disable_check_<?=$i?>" data-id="<?=$row->id?>" class="cbx hidden enable_disable" <?php if($row->status==1){ echo 'checked';} ?>>
                      <label for="enable_disable_check_<?=$i?>" class="lbl"></label>
                    </div>
                  </li>
                </ul>
              </div>
              <span>
                <?php 
                  if(file_exists(IMG_PATH.$row->coupon_image) || $row->coupon_image==''){
                    ?>
                    <img src="https://via.placeholder.com/300x300?text=No image" style="height: 150px !important">
                    <?php
                  }else{
                    ?>
                    <img src="<?=IMG_PATH.$row->coupon_image?>" style="height: 150px !important"/>
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
            <h3 class="text-muted" style="font-weight: 400"><?=$this->lang->line('no_data')?></h3>
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

<div id="coupons_detail" class="modal fade" role="dialog" style="">
  <div class="modal-dialog">
    <div class="modal-content">
      
    </div>

  </div>
</div>

<script type="text/javascript">

  $(".coupons_detail").click(function(e){

    e.preventDefault();
    $("#coupons_detail").modal("show");
    $("#coupons_detail .modal-content").html($(this).next(".detailsHolder").html());
  });


  $(".btn_delete_a").click(function(e){
      e.preventDefault();
      var _id=$(this).data("id");

      e.preventDefault(); 
      var href = '<?=base_url()?>admin/coupon/delete/'+_id;
      var btn = this;

      swal({
        title: "<?=$this->lang->line('are_you_sure_msg')?>",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: "btn-danger btn_edit",
        cancelButtonClass: "btn-warning btn_edit",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: false,
        showLoaderOnConfirm: true
      },
      function(isConfirm) {
        if (isConfirm) {

          $.ajax({
            type:'GET',
            url:href,
            success:function(res){
                if($.trim(res)=='success'){
                  swal({
                      title: "<?=$this->lang->line('deleted_lbl')?>", 
                      text: "<?=$this->lang->line('deleted_data_lbl')?>",
                      type: "success"
                  },function() {
                      $(btn).closest('.item_holder').fadeOut("200");
                  });
                }
                else
                {
                  swal.close();
                  $('.notifyjs-corner').empty();
                  $.notify(
                    $.trim(res),
                    { position:"top center",className: 'warn'}
                  );
                }

              }
          });
          
        }else{
          swal.close();
        }
      });
  });


  $(".enable_disable").on("click",function(e){

    var href;
    var btn = this;
    var _id=$(this).data("id");

    var _for=$(this).prop("checked");
    if(_for==false){
      href = '<?=base_url()?>admin/coupon/deactive/'+_id;
    }else{
      href = '<?=base_url()?>admin/coupon/active/'+_id;
    }

    $.ajax({
      type:'GET',
      url:href,
      success:function(res){
          $('.notifyjs-corner').empty();
          var obj = $.parseJSON(res);
          $.notify($.trim(obj.message), { position:"top center",className: obj.class});
        }
    });

  });

</script>