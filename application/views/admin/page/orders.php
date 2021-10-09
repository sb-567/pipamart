<?php 
  $ci =& get_instance();
?>
<style type="text/css">
  .dataTables_wrapper{
    overflow: auto !important;
    clear: both !important;
  }
  .btn-success{
    background-color: #398439 !important;
    border-color: #398439 !important;
  }
  .label-success-cust{
    background: green !important;
  }
</style>
<div class="row card_item_block" style="padding-left:30px;padding-right: 30px">
  <div class="col-xs-12">
    <div class="card mrg_bottom">
      <div class="col-md-12 mrg-top">
          <div style="float: left;font-size:1.2em;padding-top: 20px;color:#666666;"><?=$page_title?></div>

            <div class="clearfix"></div>
            <div class="col-md-12" style="margin-top: 2em;padding: 0px">
              <hr/>
              <div class="col-md-3" style="padding: 0px">
                <form id="filterForm" accept="" method="GET">
                    <select class="form-control select2 filter" name="ord_status" style="width: 100%">
                      <option value="">---All---</option>
                      <?php 
                        foreach ($status_titles as $key => $value) {
                      ?>
                      <option value="<?=$value->id?>" <?=(isset($_GET['ord_status']) && $_GET['ord_status']==$value->id) ? 'selected="selected"' : ''?>><?=$value->title?></option>
                      <?php } ?>
                    </select>
                </form>
              </div>

              <div class="col-md-3 col-xs-12 text-right" style="float: right;margin-bottom:20px;padding-right:0">
        				<div class="checkbox" style="width: 100px;margin-top: 5px;margin-left: 10px;float: left;right: 95px;position: absolute;">
        				  <input type="checkbox" id="checkall">
        				  <label for="checkall">
        					  <?=$this->lang->line('select_all_lbl')?>
        				  </label>
        				</div>
        				<div class="dropdown" style="float:right">
        				  <button class="btn btn-primary dropdown-toggle btn_cust" type="button" data-toggle="dropdown"><?=$this->lang->line('action_lbl')?>
        				  <span class="caret"></span></button>
        				  <ul class="dropdown-menu" style="right:0;left:auto;">
        					<li><a href="" class="actions" data-action="delete"><?=$this->lang->line('delete_lbl')?></a></li>
        				  </ul>
        				</div>
              </div>
            </div>

            <table class="datatable table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <th></th>
                  <th><?=$this->lang->line('ord_id_lbl')?></th>						 
                  <th><?=$this->lang->line('user_nm_lbl')?></th>
        				  <th><?=$this->lang->line('user_phone_lbl')?></th>
        				  <th nowrap=""><?=$this->lang->line('ord_on_lbl')?></th>
        				  <th><?=$this->lang->line('status_lbl')?></th>	 
                  <th class="cat_action_list"><?=$this->lang->line('action_lbl')?></th>
                </tr>
              </thead>
              <tbody>
              	<?php 
  		            $i=1;
                  
  		            foreach ($order_list as $key => $row) 
  		            {
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
                  <td><a href="<?php echo site_url("admin/orders/".$row->order_unique_id);?>"><?php echo $row->order_unique_id;?></a></td>
		              <td style="word-wrap: break-word;"><?php echo $row->name;?></td>
                  <td><?php echo $row->mobile_no;?></td>
                  <td><?php echo date('d-m-Y',$row->order_date).'<br/>'.date('h:i A',$row->order_date);?></td>
		              <td>
                    <?php 
                      
                      $_bnt_class='label-primary';
                      $_btn_title=$ci->get_status_title($row->order_status);

                      switch ($row->order_status) {
                          case '1':
                              $_bnt_class='label-default';
                              break;
                          case '2':
                              $_bnt_class='label-warning';
                              break;
                          case '3':
                              $_bnt_class='label-success';
                              break;

                          case '4':
                              $_bnt_class='label-success-cust';
                              break;
                          
                          default:
                              $_bnt_class='label-danger';
                              break;
                      }

                    ?>

                    <span class="label <?=$_bnt_class?>"><?=$_btn_title?></span>

              		</td>
                  <td nowrap="">

                    <a href="" class="btn btn-warning btn_edit btn_status" data-toggle="tooltip" data-id="<?=$row->id?>" data-tooltip="<?=$this->lang->line('ord_status_lbl')?>"><i class="fa fa-wrench"></i></a>

                    <a class="btn btn-info btn_cust" <?=($row->order_status != 4) ? 'disabled="disabled"' : ''?> href="<?php echo site_url("admin/orders/print/".$row->order_unique_id);?>" target="_blank" data-tooltip="<?=$this->lang->line('print_lbl')?>"><i class="fa fa-print"></i></a>

                    <a href="" class="btn btn-danger btn_delete" data-toggle="tooltip" data-id="<?=$row->id?>" data-tooltip="<?=$this->lang->line('delete_lbl')?>"><i class="fa fa-trash"></i></a>
                    
                  </td>
                </tr>
               <?php		
      					 $i++;
      			 	   }
      			   ?>
              </tbody>
            </table>
          </div>
      <div class="clearfix"></div>
    </div>
  </div>
</div>

<div id="orderStatus" class="modal fade" role="dialog" style="">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?=$this->lang->line('update_ord_status_lbl')?></h4>
        </div>
        <div class="modal-body" style="padding-top: 0px">
          
        </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  $(".btn_status").click(function(e){  

        e.preventDefault();

      $("#orderStatus").modal("show");

      var _id=$(this).data("id");

      var href='<?=base_url()?>admin/order/order_status_form/'+_id;

      $("#orderStatus .modal-body").load(href);

  });
</script>

<script type="text/javascript">

  $(".filter").on("change",function(e){
    $("#filterForm *").filter(":input").each(function(){
      if ($(this).val() == '')
        $(this).prop("disabled", true);
    });
    $("#filterForm").submit();
  });

  // for multiple action

  $(".actions").click(function(e){
    e.preventDefault();

    var _table='tbl_order_details';

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
                  if(res.status=='1'){
                    swal({
                        title: "<?=$this->lang->line('successfully_lbl')?>", 
                        text: "<?=$this->lang->line('action_done_msg')?>", 
                        type: "success"
                    },function() {
                        location.reload();
                    });
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

  // for delete order
  $(".btn_delete").click(function(e){
      e.preventDefault();
      var _id=$(this).data("id");

      e.preventDefault(); 

      var href='<?=base_url()?>admin/order/delete/'+_id;

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
                  alert("<?=$this->lang->line('something_went_wrong_err')?>");
                }

              }
          });
          
        }else{
          swal.close();
        }
      });
  });


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

</script>