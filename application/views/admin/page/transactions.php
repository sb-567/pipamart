<?php 

define('APP_CURRENCY', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_currency_code);
define('CURRENCY_CODE', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_currency_html_code);

//print_r($transactions);

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
              <a href="<?=(!empty($transactions)) ? base_url('admin/transactions/export') : 'javascript:void(0)'?>" class="btn btn-success pull-right" data-toggle="tooltip" title="" data-original-title="Export Transactions"><i class="fa fa-file-excel-o"></i> <?=$this->lang->line('export_excel_lbl')?></a>
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-12 mrg-top">
        <form id="filterForm" accept="" method="GET">
          <div class="col-md-3 col-xs-12" style="padding: 0px">
            <select class="form-control select2 filter" name="payment_mode" style="width: 100%">
              <option value="">---All---</option>
              <option value="cod" <?=(isset($_GET['payment_mode']) && $_GET['payment_mode']=='cod') ? 'selected="selected"' : ''?>><?=$this->lang->line("cod_short_lbl")?></option>
              <option value="paypal" <?=(isset($_GET['payment_mode']) && $_GET['payment_mode']=='paypal') ? 'selected="selected"' : ''?>><?=$this->lang->line("paypal_lbl")?></option>
              <option value="stripe" <?=(isset($_GET['payment_mode']) && $_GET['payment_mode']=='stripe') ? 'selected="selected"' : ''?>><?=$this->lang->line("stripe_lbl")?></option>
              <option value="razorpay" <?=(isset($_GET['payment_mode']) && $_GET['payment_mode']=='razorpay') ? 'selected="selected"' : ''?>><?=$this->lang->line("razorpay_lbl")?></option>
            </select>
          </div>
        </form>
        <div class="clearfix"></div>
        <table class="datatable table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th><?=$this->lang->line('ord_id_lbl')?></th>
              <th><?=$this->lang->line('email_lbl')?></th>
              <th><?=$this->lang->line('amount_lbl')?></th>
              <th><?=$this->lang->line('mode_lbl')?></th>
              <th><?=$this->lang->line('payment_id_lbl')?></th>
              <th><?=$this->lang->line('date_lbl')?></th>
              <th width="50"><?=$this->lang->line('action_lbl')?></th>

            </tr>
          </thead>
          <tbody>
            <?php
              $i=1;
              foreach ($transactions as $key => $value) {
            ?>
            <tr class="item_holder">
              <td><?=$i++?></td>
              <td><a href="<?php echo site_url("admin/orders/".$value->order_unique_id);?>"><?php echo $value->order_unique_id;?></a></td>
              <td style="word-wrap: break-word;"><?=$value->email?></td>
              <td ><?=CURRENCY_CODE.' '.$value->payment_amt?></td>
              <td><?=strtoupper($value->gateway)?></td>
              <td><?php echo $value->payment_id;?>
              </td>
              <td><?php echo date('d-m-Y',$value->date).'<br/>'.date('h:i A',$value->date);?></td>
              <td width="50">
                <a href="" class="btn btn-danger btn_delete" data-toggle="tooltip" data-id="<?=$value->id?>" data-tooltip="<?=$this->lang->line('delete_lbl')?>"><i class="fa fa-trash"></i></a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
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


  // for delete transaction
  $(".btn_delete").click(function(e){
      e.preventDefault();
      var _id=$(this).data("id");

      e.preventDefault(); 

      var href='<?=base_url()?>admin/order/delete_transaction/'+_id;

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
                  swal("<?=$this->lang->line('something_went_wrong_err')?>");
                }

              }
          });
          
        }else{
          swal.close();
        }
      });
  });
</script>