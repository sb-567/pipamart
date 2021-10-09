<?php 

	define('APP_FAVICON', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->web_favicon);
	define('APP_LOGO', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_logo);

	define('APP_CURRENCY', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_currency_code);
	define('CURRENCY_CODE', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_currency_html_code);

	$address_arr=$this->common_model->get_addresses($order_data[0]->user_id,true);

	$ci =& get_instance();

?>

<!DOCTYPE html>
<html>
<head>
	<title><?=$this->lang->line('ord_invoice_lbl')?> - <?=$order_data[0]->order_unique_id?></title>
	<link rel="shortcut icon" type="image/png" href="<?=base_url('assets/images/').APP_FAVICON?>"/>

	<link rel="stylesheet" href="<?=base_url('assets/site_assets/css/bootstrap.min.css')?>">
	<link rel="stylesheet" href="<?=base_url('assets/site_assets/css/font-awesome.min.css')?>">

	<style type="text/css">
		.invoice-title h2{
			float:right;
			text-align:right
		}
		.table>tbody>tr>td, .table>tfoot>tr>td{
			border-top: none !important;
			background: #f5f4f4;
		}
		.container {
		    width: 1020px;
		}
		.invoice-title h2, .invoice-title h3 {
		    display: inline-block;
		}
		.table strong {
		    font-weight: 500;
		}
		.table > tbody > tr > .no-line {
		    border-top: none;
		}

		.table > thead > tr > .no-line {
		    border-bottom: none;
		}

		.table > tbody > tr > .thick-line {
		    border-top: 1px solid #ddd;
		}
		.table > tbody > tr > td{
			border-right:0px solid;
		}
		.rank_item{
			width:30px !important
		}
		.user_billing_item{
			padding:20px 20px 10px 20px;	
		}
		.table-condensed > thead > tr > td{
			padding:8px;
		}
		.table-condensed > tbody > tr > td{
			padding:8px;
		}
		tr.top_bdr{
			border-top:0px solid;
		}
		td.bdr_left{
			border-left:0px solid;
		}
		td.bdr_right{
			border-right:0px solid;
		}
		td.bdr_bottom{
			border-bottom:0px solid;
		}
		td.no_bdr{
			border-right:0px !important;
		}
		div{
			font-size:16px;
			margin-bottom:8px;
		}
	</style>

</head>
<body>
	<div class="container">
	    <div class="row">
	      <div class="col-md-12">
	        <div class="panel panel-default"> 
			  <div class="user_billing_item">
				<div class="row" style="border-bottom:1px solid rgba(0, 0, 0, 0.1);margin-bottom:30px;padding-bottom:10px;">
				  <div class="col-xs-6">            
					<div>
					  <strong><?=$this->lang->line('billing_shipping_section_lbl')?>:</strong>
					</div>
					<div>
					  	<?php echo $this->common_model->selectByidParam($order_data[0]->user_id, 'tbl_users','user_name');?><br>
					  	<?php 
                            echo $order_data[0]->building_name.', '.$order_data[0]->road_area_colony.',<br/>'.$order_data[0]->city.',<br/>'.$order_data[0]->state.' - '.$order_data[0]->country.'<br/>'.$order_data[0]->pincode;
                        ?>
                        <br/>
                        <strong><?=$this->lang->line('phone_no_lbl')?>.</strong> <?php echo $this->common_model->selectByidParam($order_data[0]->user_id, 'tbl_users','user_phone');?><br>
                        <strong><?=$this->lang->line('email_lbl')?>.</strong> <?php echo $this->common_model->selectByidParam($order_data[0]->user_id, 'tbl_users','user_email');?>
					</div>				
				  </div>
				  <div class="col-xs-6">
					<div class="invoice-title">
					  <h2 style="margin-top: 0px"><img src="<?=base_url('assets/images/'.APP_LOGO);?>" style="width: 100px;height: 100px" alt="" /></h2>
					</div>
				  </div>
				</div>
				<div class="row">
				  <div class="col-xs-7">
				  </div>
				  <div class="col-xs-5">	
					<table class="table">
					  <tbody>
						<tr>
						  <td><strong><?=$this->lang->line('ord_id_lbl')?> #</strong></td>
						  <td style="text-align:right"><?=$order_data[0]->order_unique_id?></td>
						</tr>
						<tr>
						  <td><strong><?=$this->lang->line('ord_on_lbl')?>:</strong></td>
						  <td style="text-align:right"><?php echo date('F d, Y',$order_data[0]->order_date);?></td>
						</tr>
						<tr style="background:#d7dcdc">
						  <td><strong><?=$this->lang->line('total_amt_lbl')?></strong></td>
						  <td style="text-align:right"><strong><?php echo CURRENCY_CODE.' '.$order_data[0]->payable_amt;?></strong></td>
						</tr>
					  </tbody>
					</table>
				  </div>
				</div>
			  </div>	
	          <div class="panel-body" style="margin-bottom:0;">
	            <div class="table-responsive" style="margin-bottom:0;overflow:hidden !important">
	              <table class="table table-condensed">
	                <thead>
	                    <tr class="top_bdr" style="background:#d7dcdc">
						  <td class="rank_item text-left bdr_left bdr_right"><strong style="font-weight: 600"><?=$this->lang->line('product_lbl')?></strong></td>	
	                      <td class="text-right bdr_right"><strong style="font-weight: 600"><?=$this->lang->line('price_lbl')?></strong></td>	
	                      <td class="text-right bdr_right"><strong style="font-weight: 600"><?=$this->lang->line('saving_lbl')?></strong></td>	
	                      <td class="text-right bdr_right"><strong style="font-weight: 600"><?=$this->lang->line('qty_lbl')?></strong></td>
						  <td class="text-right bdr_right"><strong style="font-weight: 600"><?=$this->lang->line('total_price_lbl')?></strong></td>					  
	                    </tr>
	                </thead>
	                <tbody>
					<?php

						$items_arr=$this->common_model->selectByids(array('order_id' => $order_data[0]->id), 'tbl_order_items');

                        foreach ($items_arr as $key => $val) 
                        {
					?>  
	                  <tr>
						<td class="rank_item text-left thick-line bdr_left" style="min-width: 450px !important"><?=$val->product_title?></td>
	                    
	                    <td class="text-right thick-line"><?=CURRENCY_CODE.' '.$val->product_price?></td>
	                    <td class="text-right thick-line"><?php echo CURRENCY_CODE.' '.($this->common_model->selectByidParam($val->product_id, 'tbl_product','product_mrp')-$val->product_price)?></td>
	                    <td class="text-right thick-line"><?=$val->product_qty?></td>
						<td class="text-right thick-line"><?=CURRENCY_CODE.' '.$val->total_price?></td>					
	                  </tr>
	              	<?php } ?>
	                  <tr>
					    <td class="thick-line bdr_left"></td>
					    <td class="thick-line bdr_left"></td>
	                    <td class="text-right thick-line"></td>
						<td class="text-right thick-line"></td>
	                    <td class="text-right thick-line"></td>
	                  </tr>				  				  			                    				  
	                </tbody>
	              </table>
	            </div>
				<div class="row" style="margin-top: 10px">
				  <div class="col-xs-7">
				  </div>
				  <div class="col-xs-5">	
					<table class="table">
					  <tbody>
						<tr>
						  <td><strong style="font-weight: 600"><?=$this->lang->line('total_lbl')?></strong></td>
						  <td style="text-align:right"><?=CURRENCY_CODE.' '.number_format($order_data[0]->total_amt, 2)?></td>
						</tr>
						<?php 
                        	if(!empty($refund_data))
                        	{
                            	$cancel_ord_amt=array_sum(array_column($refund_data,'refund_pay_amt'));
                        ?>
						<tr>
						  <td><strong style="font-weight: 600"><?=$this->lang->line('cancel_ord_amt_lbl')?></strong></td>
						  <td style="text-align:right">- <?=CURRENCY_CODE.' '.number_format($cancel_ord_amt, 2)?></td>
						</tr>                        
                    	<?php } ?>

						<tr>
						  <td><strong style="font-weight: 600"><?=$this->lang->line('discount_lbl')?></strong></td>
						  <td style="text-align:right">- <?=CURRENCY_CODE.' '.($order_data[0]->discount_amt)?></td>
						</tr>
						<tr>
						  <td><strong style="font-weight: 600"><?=$this->lang->line('delivery_charge_lbl')?></strong></td>
						  <td style="text-align:right"><?=($order_data[0]->delivery_charge) ? '+ '.CURRENCY_CODE.' '.number_format($order_data[0]->delivery_charge, 2) : $this->lang->line('free_lbl')?></td>
						</tr>
						<tr>
						  <td><strong style="font-weight: 600"><?=$this->lang->line('payable_amt_lbl')?></strong></td>
						  <td style="text-align:right"><?=CURRENCY_CODE.' '.number_format($order_data[0]->new_payable_amt)?></td>
						</tr>
					  </tbody>
					</table>
				  </div>
				  
				</div>
	          </div>
	        </div>
			<center>
				<button class="btn btn-success btn_download" data-id="<?=$order_data[0]->order_unique_id?>"><i class="fa fa-download"></i> <?=$this->lang->line('download_invoice_btn')?></button>
				<button class="btn btn-danger btn_close"><i class="fa fa-close"></i> <?=$this->lang->line('close_btn')?></button>
			</center>
	      </div>

	    </div>

	</div>

	<script src="<?=base_url('assets/site_assets/js/vendor/jquery-1.12.4.min.js')?>"></script>

	<script type="text/javascript">
		$(document).ready(function(e){
			$(".btn_download").click(function(e){
				e.preventDefault();
				var _id=$(this).data("id");

				href = '<?=base_url()?>product-invoice/'+_id;

				window.location.href=href;
			});

			$(".btn_close").click(function(e){
				window.opener.focus(); window.close();
			});
		});
	</script>

</body>
</html>





