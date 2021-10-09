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
              <div class="add_btn_primary"> <a href="<?php echo site_url("admin/users/add");?>?redirect=<?=$redirectUrl?>"><?=$this->lang->line('add_new_lbl')?></a> </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="col-md-3 col-xs-12 text-right" style="float: right;">
            <form method="post" action="">
                <div class="checkbox" style="width: 100px;margin-top: 5px;margin-left: 10px;float: left;right: 110px;position: absolute;">
                  <input type="checkbox" id="checkall">
                  <label for="checkall">
                      <?=$this->lang->line('select_all_lbl')?>
                  </label>
                </div>
                <div class="dropdown" style="float:right">
                  <button class="btn btn-primary dropdown-toggle btn_cust" type="button" data-toggle="dropdown"><?=$this->lang->line('action_lbl')?>
                  <span class="caret"></span></button>
                  <ul class="dropdown-menu" style="right:0;left:auto;">
                    <li><a href="" class="actions" data-action="enable"><?=$this->lang->line('enable_lbl')?></a></li>
                    <li><a href="" class="actions" data-action="disable"><?=$this->lang->line('disable_lbl')?></a></li>
                    <li><a href="" class="actions" data-action="delete"><?=$this->lang->line('delete_lbl')?></a></li>
                  </ul>
                </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
        <?php 
          if(!empty($user_list)){ 
        ?>
        <div class="col-md-12 mrg-top">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th style="width:40px"></th>
                <th><?=$this->lang->line('register_platform_lbl')?></th>
                <th><?=$this->lang->line('name_lbl')?></th>
      				  <th><?=$this->lang->line('email_lbl')?></th>
      				  <th nowrap=""><?=$this->lang->line('register_on_lbl')?></th>
      				  <th><?=$this->lang->line('status_lbl')?></th>	 
                <th class="cat_action_list"><?=$this->lang->line('action_lbl')?></th>
              </tr>
            </thead>
            <tbody>
            	<?php 
	              define('IMG_PATH', base_url().'assets/images/users/');
		            $i=0;
		            foreach ($user_list as $key => $row) 
		            {
                  $user_img='';

                  if($row->user_image!='' && file_exists('assets/images/users/'.$row->user_image)){
                    $user_img=IMG_PATH.$row->user_image;
                  }
                  else{
                    $user_img=base_url('assets/images/2.png');
                  }
		          ?>
              <tr class="item_holder">
                <td>  
                  <div>
                      <div class="checkbox">
                        <input type="checkbox" name="post_ids[]" id="checkbox<?php echo $i;?>" value="<?php echo $row->id; ?>" class="post_ids">
                        <label for="checkbox<?php echo $i;?>">
                        </label>
                      </div>
                  </div>
                </td>
                <td><?=ucfirst($row->register_platform)?></td>
                <td nowrap="">
                  <a href="<?php echo site_url("admin/users/profile/".$row->id);?>?redirect=<?=$redirectUrl?>">
                    <div class="row" style="vertical-align: middle;">
                      <div class="col-md-3 col-xs-12">
                        <?php 
                          if($row->user_type=='Google'){
                            echo '<img src="'.base_url('assets/img/google-logo.png').'" class="social_img" style="">';
                          }
                          else if($row->user_type=='Facebook'){
                            echo '<img src="'.base_url('assets/img/facebook-icon.png').'" class="social_img" style="">';
                          }
                        ?>
                        <img src="<?=$user_img?>" style="width: 40px;height: 40px;border-radius: 4px">
                      </div>
                      <div class="col-md-9 col-xs-12" style="padding: 8px 15px">
                        <?php echo $row->user_name;?>
                      </div>
                    </div>
                  </a>
                </td>
                <td><?php echo ($row->user_email) ? $row->user_email : '-'?></td>
	              <td><?php echo date('d-m-Y',$row->created_at);?></td>

	              <td>
	           	    <input type="checkbox" id="enable_disable_check_<?=$i?>" data-id="<?=$row->id?>" class="cbx hidden enable_disable" <?php if($row->status==1){ echo 'checked';} ?>>
                  <label for="enable_disable_check_<?=$i?>" class="lbl"></label>
            		</td>
                <td nowrap="">

                  <a href="<?php echo site_url("admin/users/profile/".$row->id);?>?redirect=<?=$redirectUrl?>" class="btn btn-success btn_cust" data-toggle="tooltip" data-tooltip="<?=$this->lang->line('profile_lbl')?>"><i class="fa fa-eye"></i></a>

                 	<a href="<?php echo site_url("admin/users/edit/".$row->id);?>?redirect=<?=$redirectUrl?>" class="btn btn-primary btn_cust" data-toggle="tooltip" data-tooltip="<?=$this->lang->line('edit_lbl')?>"><i class="fa fa-edit"></i></a>

                  <a href="" class="btn btn-danger btn_delete" data-toggle="tooltip" data-id="<?=$row->id?>" data-tooltip="<?=$this->lang->line('delete_lbl')?>"><i class="fa fa-trash"></i></a>
                </td>
              </tr>
             <?php		
    					 $i++;
    			 	   }
    			   ?>
            </tbody>
          </table>
        <?php }else{ ?>
          <div class="col-lg-12 col-sm-12 col-xs-12" style="text-align: center;">
            <h4 class="text-muted" style="font-weight: 400">Sorry! no records found...</h4>
            <br/>
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

  // for multiple action

  $(".actions").click(function(e){
    e.preventDefault();

    var _table='tbl_users';

    var href='<?=base_url()?>admin/pages/perform_multipe';

    var _ids = $.map($('.post_ids:checked'), function(c){return c.value; });
    var _action=$(this).data("action");

    if(_ids!='')
    {
      swal({
        title: "<?=$this->lang->line('action_lbl')?>: "+$(this).text(),
        text: "<?=$this->lang->line('action_confirm_msg')?>",
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
              type:'post',
              url:href,
              dataType:'json',
              data:{ids:_ids,for_action:_action,table:_table},
              success:function(res){
                  console.log(res);
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
    }
    else{
        $('.notifyjs-corner').empty();
        $.notify(
          '<?=$this->lang->line('no_record_select_msg')?>',  
          { position:"top center",className: 'error' }
        );
    }

  });

	$(".enable_disable").on("click",function(e){

    var href;
    var btn = this;
    var _id=$(this).data("id");

    var _for=$(this).prop("checked");
    if(_for==false){
      href='<?=base_url()?>admin/users/deactive/'+_id
    }else{
      href='<?=base_url()?>admin/users/active/'+_id
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

  var totalItems=0;

  $("#checkall").click(function () {

    totalItems=0;

    $("input[name='post_ids[]']").not(this).prop('checked', this.checked);

    $.each($("input[name='post_ids[]']:checked"), function(){
      totalItems=totalItems+1;
    });

    if($("input[name='post_ids[]']").prop("checked") == true){
      $('.notifyjs-corner').empty();
      $.notify(
        'Total '+totalItems+' item checked',
        { position:"top center",className: 'success',clickToHide : false,autoHide : false}
      );
    }
    else if($("input[name='post_ids[]']"). prop("checked") == false){
      totalItems=0;
      $('.notifyjs-corner').empty();
    }
  });

  $(".post_ids").click(function(e){

      if($(this).prop("checked") == true){
        totalItems=totalItems+1;
      }
      else if($(this). prop("checked") == false){
        totalItems = totalItems-1;
      }

      if(totalItems==0){
        $('.notifyjs-corner').empty();
        exit();
      }

      $('.notifyjs-corner').empty();

      $.notify(
        'Total '+totalItems+' item checked',
        { position:"top center",className: 'success',clickToHide : false,autoHide : false}
      );
  });

  // for delete users
  $(".btn_delete").click(function(e){
      e.preventDefault();
      var _id=$(this).data("id");

      e.preventDefault(); 
      var href='<?=base_url()?>admin/users/delete/'+_id;

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
                      title: "Deleted", 
                      text: "Your user has been deleted", 
                      type: "success"
                  },function() {
                      $(btn).closest('.item_holder').fadeOut("200");
                  });
                }
                else
                {
                  //alert("Error");
                }

              }
          });
          
        }else{
          swal.close();
        }
      });
  });
</script>