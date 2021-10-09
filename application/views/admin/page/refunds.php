<?php 
  define('APP_CURRENCY', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_currency_code);
  define('CURRENCY_CODE', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_currency_html_code);

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
  .morecontent span {
      display: none;
  }
  .morelink {
      display: block;
  }
</style>
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
              <a href="<?=(!empty($refunds)) ? base_url('admin/refunds/export') : 'javascript:void(0)'?>" class="btn btn-success pull-right" data-toggle="tooltip" title="" data-original-title="Export Refunds"><i class="fa fa-file-excel-o"></i> <?=$this->lang->line('export_excel_lbl')?></a>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-12 mrg-top">
        <form id="filterForm" accept="" method="GET">
          <div class="col-md-3 col-xs-12" style="padding: 0px">
            <select class="form-control select2 filter" name="refund_status" style="width: 100%">
              <option value="">---All---</option>
              <option value="pending" <?=(isset($_GET['refund_status']) && $_GET['refund_status']=='pending') ? 'selected="selected"' : ''?>><?=$this->lang->line("refund_pending_lbl")?></option>
              <option value="process" <?=(isset($_GET['refund_status']) && $_GET['refund_status']=='process') ? 'selected="selected"' : ''?>><?=$this->lang->line("refund_process_lbl")?></option>
              <option value="completed" <?=(isset($_GET['refund_status']) && $_GET['refund_status']=='completed') ? 'selected="selected"' : ''?>><?=$this->lang->line("refund_complete_lbl")?></option>
              <option value="wait_to_claim" <?=(isset($_GET['refund_status']) && $_GET['refund_status']=='wait_to_claim') ? 'selected="selected"' : ''?>><?=$this->lang->line("refund_wait_lbl")?></option>
            </select>
          </div>
        </form>
        <div class="clearfix"></div>
        <table class="datatable table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th><?=$this->lang->line('ord_id_lbl')?></th>
              <th><?=$this->lang->line('products_lbl')?></th>
              <th nowrap=""><?=$this->lang->line('refund_amt_lbl')?></th>
              <th><?=$this->lang->line('status_lbl')?></th>
              <th><?=$this->lang->line('last_updated_lbl')?></th>
              <th><?=$this->lang->line('action_lbl')?></th>
            </tr>
          </thead>
          <tbody>
            <?php 
              $i=1;
              foreach ($refunds as $key => $value) {
                ?>
                <tr class="item_holder">
                  <td><?=$i++?></td>
                  <td>
                    <?php 
                      echo (!$value->cancel_by) ? '<label class="label label-info">'.$this->lang->line('cancel_by_admin_lbl').'</label>': '';
                      echo '<hr style="margin: 10px;margin-bottom: 5px;"/>';
                    ?>
                    <a href="<?php echo site_url("admin/orders/".$value->order_unique_id);?>" target="_blank"><?php echo $value->order_unique_id;?></a>
                  </td>
                  <td><?=$value->product_title?></td>
                  <td><?=CURRENCY_CODE.' '.number_format($value->refund_pay_amt, 2)?></td>
                  <td>
                    <?php 
                      
                      $_bnt_class='label-primary';

                      switch ($value->request_status) {
                          case '0':
                              $_btn_title=$this->lang->line('refund_pending_lbl');
                              $_bnt_class='btn-warning';
                              break;
                          case '2':
                              $_btn_title=$this->lang->line('refund_process_lbl');
                              $_bnt_class='btn-primary';
                              break;
                          case '1':
                              $_btn_title=$this->lang->line('refund_complete_lbl');
                              $_bnt_class='btn-success';
                              break;
                          case '-1':
                              $_btn_title=$this->lang->line('refund_wait_lbl');
                              $_bnt_class='btn-danger';
                              break;

                          default:
                              $_bnt_class='btn-danger';
                              break;
                      }

                    ?>
                    <div class="dropdown" style="float:right">
                      <button class="btn <?=$_bnt_class?> dropdown-toggle btn_cust" <?=($value->request_status=='-1') ? 'disabled' : ''; ?> type="button" data-toggle="dropdown"><?php echo $_btn_title ?>
                      <span class="caret"></span></button>
                      <ul class="dropdown-menu" style="right:0;left:auto;">
                        <li><a href="" class="action_status" data-id="<?=$value->id?>" data-action="pending"><?=$this->lang->line('refund_pending_lbl')?></a></li>
                        <li><a href="" class="action_status" data-id="<?=$value->id?>" data-action="process"><?=$this->lang->line('refund_process_lbl')?></a></li>
                        <li><a href="" class="action_status" data-id="<?=$value->id?>" data-action="completed"><?=$this->lang->line('refund_complete_lbl')?></a></li>
                      </ul>
                    </div>

                  </td>
                  <td nowrap=""><?php echo date('d-m-Y h:i A',$value->last_updated);?></td>
                  <td nowrap="">
                    <a href="javascript:void(0)" class="btn btn-warning btn_edit <?=($value->request_status=='-1') ? '' : 'btn_more'; ?>"<?=($value->request_status=='-1') ? 'disabled' : ''; ?> data-toggle="tooltip" data-id="<?=$value->id?>" data-tooltip="View Details"><i class="fa fa-eye"></i></a>

                    <div class="row modal_details" style="display: none;">
                      <table style="width: 100%">
                        <tr>
                          <td colspan="2">
                            <h4><?=$this->lang->line('ord_unique_id_lbl')?>: <span style="font-weight: 400"><?php echo $value->order_unique_id;?></span></h4>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <h4><?=$this->lang->line('user_nm_lbl')?>: <span style="font-weight: 400"><?=$value->user_name?></span></h4>
                          </td>
                          <td>
                            <h4><?=$this->lang->line('user_email_lbl')?>: <span style="font-weight: 400"><?=$value->user_email?></span></h4>
                          </td>
                        </tr>

                        <tr>
                          <td colspan="2">
                            <h4><?=$this->lang->line('reason_lbl')?></h4>
                            <p><?=$value->refund_reason?></p>
                          </td>
                        </tr>
                        
                        <tr>
                          <td colspan="2">
                            <h4><?=$this->lang->line('bank_details_lbl')?>:</h4>
                          </td>
                        </tr>
                        <tr>
                          <td colspan="2">
                            <table class="table">
                              <tbody>
                                <tr>
                                  <td><strong><?=$this->lang->line('bank_name_lbl')?>:</strong></td>
                                  <td colspan="3"><?=$value->bank_name?></td>
                                </tr>
                                <tr>
                                  <td><strong><?=$this->lang->line('bank_acc_no_lbl')?>:</strong></td>
                                  <td><?=$value->account_no?></td>
                                  <td><strong><?=$this->lang->line('holder_name_lbl')?>:</strong></td>
                                  <td><?=$value->bank_holder_name?></td>
                                  
                                  
                                </tr>
                                <tr>
                                  <td><strong><?=$this->lang->line('bank_ifsc_lbl')?>:</strong></td>
                                  <td><?=$value->bank_ifsc?></td>
                                  <td><strong><?=$this->lang->line('holder_mobile_lbl')?>:</strong></td>
                                  <td><?=$value->bank_holder_phone?></td>
                                  
                                  
                                </tr>
                                <tr>
                                  <td><strong><?=$this->lang->line('bank_type_lbl')?>:</strong></td>
                                  <td><?=ucfirst($value->account_type)?></td>
                                  <td><strong><?=$this->lang->line('holder_email_lbl')?>:</strong></td>
                                  <td colspan="3"><?=$value->bank_holder_email?></td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </table>
                    </div>
                  </td>
                </tr>
                <?php
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div id="refundModal" class="modal fade" role="dialog" style="">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?=$this->lang->line('refund_details_lbl')?></h4>
        </div>
        <div class="modal-body" style="padding-top: 0px"></div>
    </div>
  </div>
</div>

<div id="product_modal" class="modal fade" role="dialog" style="">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?=$this->lang->line('products_lbl')?></h4>
        </div>
        <div class="modal-body" style="padding-top: 0px"></div>
    </div>
  </div>
</div>

<script type="text/javascript">

  $(".filter").on("change",function(e){
    $("#filterForm *").filter(":input").each(function(){
      if ($(this).val() == '')
        $(this).prop("disabled", true);
    });
    $("#filterForm").submit();
  });

  $(".datatable").on("click",".action_status",function(e){
    e.preventDefault();

    var href='<?=base_url()?>admin/pages/refund_status';

    var _id = $(this).data("id");
    var _action=$(this).data("action");

    if(_id!='')
    {
      swal({
        title: "Are you sure to change status?",
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
              data:{id:_id,for_action:_action},
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
          { position:"top center",className: 'danger' }
        );
    }

  });

  $(".datatable").on("click",".btn_more",function(e){
    e.preventDefault();

    var html=$(this).parents("tr").find(".modal_details").html();

    $("#refundModal .modal-body").html(html);
    $("#refundModal").modal("show");
  });

  $(".datatable").on("click",".btn_products",function(e){
    e.preventDefault();

    var html=$(this).parents("tr").find(".modal_details").html();

    $("#product_modal .modal-body").html(html);
    $("#product_modal").modal("show");
  });

  

  $(document).ready(function() {
      // Configure/customize these variables.
      var showChar = 50;  // How many characters are shown by default
      var ellipsestext = "...";
      var moretext = "<?=$this->lang->line('show_more_lbl')?>";
      var lesstext = "<?=$this->lang->line('show_less_lbl')?>";
      

      $('.more').each(function() {
          var content = $.trim($(this).text());
    
          

          if(content.length > showChar) {
    
              var c = content.substr(0, showChar);
              var h = content.substr(showChar, content.length - showChar);
    
              var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span><a href="" class="morelink">' + moretext + '</a></span>';
   
              $(this).html(html);
          }
   
      });
   
      $(".morelink").click(function(){
          if($(this).hasClass("less")) {
              $(this).removeClass("less");
              $(this).html(moretext);
          } else {
              $(this).addClass("less");
              $(this).html(lesstext);
          }
          $(this).parent().prev().toggle();
          $(this).prev().toggle();
          return false;
      });
  });

</script>