<?php 

define('APP_CURRENCY', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_currency_code);
define('CURRENCY_CODE', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_currency_html_code);

$ci =& get_instance();
?>

<div class="row card_item_block" style="padding-left:30px;padding-right: 30px">
  <div class="col-xs-12 mr_bottom20">
    <div class="card mr_bottom20 mr_top10">
      <div class="page_title_white user_dashboard_item" style="background-color:#FFFFFF;">
        <div class="col-md-10 col-xs-12">
          <div class="page_title"><?=$current_page?></div>
        </div>

        <div class="col-md-2 col-xs-12">              
          <div class="search_list">                     

            <div class="add_btn_primary"><a href="<?=site_url("admin/orders")?>" class="btn btn-primary"><i class="fa fa-angle-double-left"></i> <?=$this->lang->line('back_btn')?></a>
            </div>
            &nbsp;&nbsp;
            <div class="add_btn_primary"><a href="<?php echo site_url("admin/orders/print/".$order_data[0]->order_unique_id);?>" target="_blank" class="btn btn-success"><i class="fa fa-print"></i> <?=$this->lang->line('print_lbl')?></a>
            </div>
          </div>                  
        </div>

      </div>
      <hr>

      <div class="form-group m-form__group row align-items-center" style="padding-left:30px;padding-right: 30px">
          <div class="rows">
            <div class="address_item_header">
                <div class="col-md-5 col-xs-12">
                    <h4 style="margin-top:0px;font-weight: 600;margin-bottom: 15px"><?=$this->lang->line('ord_details_section_lbl')?></h4>
                    <div style="font-size: 14px;font-weight: 400;color: #6d6d6d;">
                        <strong style="font-weight: 500;color: #575757"><?=$this->lang->line('ord_id_lbl')?></strong>:&nbsp;&nbsp;<?=$order_data[0]->order_unique_id?>
                    </div>
                    <div style="font-size: 14px;margin-top: 8px;font-weight: 400;color: #6d6d6d;">
                        <strong style="font-weight: 500;color: #575757"><?=$this->lang->line('ord_on_lbl')?>:</strong>&nbsp;&nbsp;<?php echo date('d-m-Y h:i A',$order_data[0]->order_date);?>
                    </div>
                    <div style="font-size: 14px;margin-top: 8px;font-weight: 400;color: #6d6d6d;">
                        <strong style="font-weight: 500;color: #575757"><?=$this->lang->line('payment_mode_lbl')?>:</strong>&nbsp;&nbsp;<?=strtoupper($this->db->get_where('tbl_transaction', array('order_unique_id' => $order_data[0]->order_unique_id))->row()->gateway)?>
                    </div>
                    <div style="font-size: 14px;margin-top: 8px;font-weight: 400;color: #6d6d6d;">
                        <strong style="font-weight: 500;color: #575757"><?=$this->lang->line('payment_id_lbl')?>:</strong>&nbsp;&nbsp;<?=$this->db->get_where('tbl_transaction', array('order_unique_id' => $order_data[0]->order_unique_id))->row()->payment_id?>
                    </div>
                    <div style="font-size: 14px;margin-top: 8px;font-weight: 400;color: #6d6d6d;">
                        <strong style="font-weight: 500;color: #575757"><?=$this->lang->line('ord_status_lbl')?>:</strong>&nbsp;&nbsp; 
                        <?php 
                            switch ($order_data[0]->order_status) {
                                case '1':
                                    echo '<span style="color:orange;font-size:14px">'.$ci->get_status_title($order_data[0]->order_status).'</span>';
                                    break;
                                case '2':
                                    echo '<span style="color:orange;font-size:14px">'.$ci->get_status_title($order_data[0]->order_status).'</span>';
                                    break;
                                case '3':
                                    echo '<span style="color:orange;font-size:14px">'.$ci->get_status_title($order_data[0]->order_status).'</span>';
                                    break;
                                case '4':
                                    echo '<span style="color:green;font-size:14px">'.$ci->get_status_title($order_data[0]->order_status).'</span>';
                                    break;
                                
                                default:
                                    echo '<span style="color:red;font-size:14px">'.$ci->get_status_title($order_data[0]->order_status).'</span>';
                                    break;
                            }
                        ?>
                    </div>
                    
                </div>
                <div class="col-md-7 col-xs-12">
                    <h4 style="margin-top:0px;font-weight: 600;margin-bottom: 15px"><?=$this->lang->line('billing_shipping_section_lbl')?></h4>
                    <div style="font-size: 14px;font-weight: 400;color: #6d6d6d;">
                        <strong style="font-weight: 500;color: #575757"><?=$this->lang->line('name_lbl')?>:</strong> <?php echo $order_data[0]->name;?>        
                    </div>
                    <div style="font-size: 14px;margin-top: 8px;font-weight: 400;color: #6d6d6d;">
                        <strong style="font-weight: 500;color: #575757"><?=$this->lang->line('phone_no_lbl')?>:</strong> <?php echo $order_data[0]->mobile_no?>         
                    </div>
                    <div style="font-size: 14px;margin-top: 8px;line-height: 1.7;font-weight: 400;color: #6d6d6d;">
                        <strong style="font-weight: 500;color: #575757"><?=$this->lang->line('address_sort_lbl')?>:</strong>
                        <?php 
                            echo $order_data[0]->building_name.', '.$order_data[0]->road_area_colony.', '.$order_data[0]->city.', '.$order_data[0]->state.', '.$order_data[0]->country.' - '.$order_data[0]->pincode;
                        ?>
                    </div>
                </div>                               
            </div>
			<div class="clearfix"></div>
            <br/>
            <div class="card-body no-padding">
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-condensed">
                                        <thead>
                                            <tr class="top_bdr">
                                                <td class="rank_item text-center bdr_left bdr_right"></td> 
                                                <td class="bdr_right" width="300px"><strong><?=$this->lang->line('product_lbl')?></strong></td>
                                                <td class="text-right bdr_right"><strong><?=$this->lang->line('price_lbl')?></strong></td>
                                                <td class="text-right bdr_right"><strong style="font-weight: 600"><?=$this->lang->line('saving_lbl')?></strong></td>
                                                <td class="text-right bdr_right"><strong><?=$this->lang->line('qty_lbl')?></strong></td> 
                                                <td class="text-right bdr_right"><strong><?=$this->lang->line('total_price_lbl')?></strong></td>
                                                <td class="text-center bdr_right" width="100px"><strong><?=$this->lang->line('status_lbl')?></strong></td>
                                                <td class="text-center bdr_right"><strong><?=$this->lang->line('update_lbl')?></strong></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                            define('IMG_PATH', base_url().'assets/images/products/');

                                            $items_arr=$this->common_model->selectByids(array('order_id' => $order_data[0]->id), 'tbl_order_items');

                                            $_total_price=$_total_amt=$_total_qty=0;

                                            foreach ($items_arr as $key => $val) {

                                                $_total_amt+=$val->total_price;

                                        ?>  
                                            <tr>
                                                <td class="thick-line bdr_left">
                                                    <img src="<?=IMG_PATH.$this->common_model->selectByidParam($val->product_id, 'tbl_product','featured_image')?>" style="height: 60px;width: 60px;border: 2px solid #ddd;border-radius:4px"/> 
                                                </td>
                                                <td class="thick-line bdr_left"><?=$val->product_title?></td>
                                                <td nowrap="" class="text-right thick-line"><?=CURRENCY_CODE.' '.number_format($val->product_price, 2)?></td>
                                                <td nowrap="" class="text-right thick-line"><?=CURRENCY_CODE.' '.number_format($val->you_save_amt, 2)?></td>
                                                <td class="thick-line text-right bdr_left"><?=$val->product_qty?></td>
                                                <td nowrap="" class="text-right thick-line"><?=CURRENCY_CODE.' '.number_format($val->total_price, 2)?></td>
                                                <td class="text-center thick-line">
                                                    <?php 
                                                        switch ($val->pro_order_status) {
                                                            case '1':
                                                                echo '<span style="color:orange;font-size:14px">'.$ci->get_status_title($val->pro_order_status).'</span>';
                                                                break;
                                                            case '2':
                                                                echo '<span style="color:orange;font-size:14px">'.$ci->get_status_title($val->pro_order_status).'</span>';
                                                                break;
                                                            case '3':
                                                                echo '<span style="color:orange;font-size:14px">'.$ci->get_status_title($val->pro_order_status).'</span>';
                                                                break;
                                                            case '4':
                                                                echo '<span style="color:green;font-size:14px">'.$ci->get_status_title($val->pro_order_status).'</span>';
                                                                break;
                                                            
                                                            default:
                                                                echo '<span style="color:red;font-size:14px">'.$ci->get_status_title($val->pro_order_status).'</span>';
                                                                break;
                                                        }
                                                    ?>
                                                    
                                                </td>
                                                <td class="text-center thick-line">
                                                    <a href="" <?=($val->pro_order_status > 4) ? 'disabled="disabled"' : ''?> class="btn btn-primary btn_edit btn_status" data-toggle="tooltip" data-order="<?=$val->order_id?>" data-product="<?=$val->product_id?>" data-tooltip="<?=$this->lang->line('update_status_lbl')?>"><i class="fa fa-wrench"></i></a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                            <tr>
                                                <td colspan="8" class="thick-line bdr_left"></td>
                                            </tr>
                                            <tr>
                                                <td class="thick-line bdr_left"></td>
                                                <td class="thick-line bdr_left"></td>
                                                <td class="thick-line bdr_left"></td>
                                                <td colspan="2" class="thick-line text-right bdr_left"><strong><?=$this->lang->line('total_lbl')?></strong></td>
                                                <td nowrap="" class="text-right thick-line" style="font-weight: 600"><?=CURRENCY_CODE.' '.number_format($order_data[0]->total_amt, 2)?></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <?php 
                                            if(!empty($refund_data))
                                            {
                                                $cancel_ord_amt=array_sum(array_column($refund_data,'refund_pay_amt'));
                                                ?>
                                                <tr>
                                                    <td class="thick-line bdr_left"></td>
                                                    <td class="thick-line bdr_left"></td>
                                                    <td class="thick-line bdr_left"></td>
                                                    <td colspan="2" class="thick-line text-right bdr_left"><strong><?=$this->lang->line('cancel_ord_amt_lbl')?></strong></td>
                                                    <td nowrap="" class="text-right thick-line" style="font-weight: 600">- <?=CURRENCY_CODE.' '.number_format($cancel_ord_amt, 2)?></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>   
                                                <?php
                                            }
                                            ?>
                                            <tr>
                                                <td class="thick-line bdr_left"></td>
                                                <td class="thick-line bdr_left"></td>
                                                <td class="thick-line bdr_left"></td>
                                                <td colspan="2" class="thick-line text-right bdr_left"><strong><?=$this->lang->line('discount_amt_lbl')?></strong></td>
                                                <td nowrap="" class="text-right thick-line" style="font-weight: 600">- <?=CURRENCY_CODE.' '.number_format($order_data[0]->discount_amt, 2)?></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            
                                            <tr>
                                                <td class="thick-line bdr_left"></td>
                                                <td class="thick-line bdr_left"></td>
                                                <td class="thick-line bdr_left"></td>
                                                <td colspan="2" class="thick-line text-right bdr_left"><strong><?=$this->lang->line('delivery_charge_lbl')?></strong></td>
                                                <td nowrap="" class="text-right thick-line" style="font-weight: 600"><?=($order_data[0]->delivery_charge) ? '+ '.CURRENCY_CODE.number_format($order_data[0]->delivery_charge, 2) : $this->lang->line('free_lbl')?></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td class="thick-line bdr_left"></td>
                                                <td class="thick-line bdr_left"></td>
                                                <td class="thick-line bdr_left"></td>
                                                <td colspan="2" class="thick-line text-right bdr_left"><strong><?=$this->lang->line('payable_amt_lbl')?></strong></td>
                                                <td nowrap="" class="text-right thick-line" style="font-weight: 600"><?=CURRENCY_CODE.' '.number_format($order_data[0]->new_payable_amt, 2)?></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>


<div id="orderStatus" class="modal fade" role="dialog" style="">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Update Order Status</h4>
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

      var _id=$(this).data("order");

      var _product_id=$(this).data("product");

      var href='<?=base_url()?>admin/order/order_status_form/'+_id+'/'+_product_id;

      $("#orderStatus .modal-body").load(href);

  });
</script>