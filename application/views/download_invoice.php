<?php 

error_reporting(0);

define('APP_FAVICON', 'app_favicon.png');
define('APP_LOGO', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_logo);

define('APP_CURRENCY', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_currency_code);
define('CURRENCY_CODE', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_currency_html_code);
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?=$this->lang->line('ord_invoice_lbl')?> - <?=$order_data[0]->order_unique_id?></title>
	<link rel="shortcut icon" type="image/png" href="<?=base_url('assets/images/').APP_FAVICON?>"/>

	<link href="http://netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<style type="text/css">
		.invoice-title h2{
			float:right;
			text-align:right
		}
		.container {
		    width: 100%;
		}
		.table>tbody>tr>td, .table>tfoot>tr>td{
			border-top: none !important;
			background: #f5f4f4;
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

		thead:before, thead:after { display: none !important; }
		tbody:before, tbody:after { display: none !important; }

		table {
	        border-collapse: collapse;
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
					<div style="font-size: 13px;font-weight: 600">
					  <?=$this->lang->line('billing_shipping_section_lbl')?>:
					</div>
					<div style="font-size: 12px;">
					  	<?php echo $this->common_model->selectByidParam($order_data[0]->user_id, 'tbl_users','user_name');?><br>
					  	<?php 
                            echo $order_data[0]->building_name.', '.$order_data[0]->road_area_colony.',<br/>'.$order_data[0]->city.', '.$order_data[0]->state.', '.$order_data[0]->country.'<br/>'.$order_data[0]->pincode;
                        ?>
                        <br/>
                        <strong><?=$this->lang->line('phone_no_lbl')?>.</strong> <?php echo $order_data[0]->mobile_no;?><br>
                        <strong><?=$this->lang->line('email_lbl')?>.</strong> <?php echo $order_data[0]->email?>
					</div>				
				  </div>
				  <div class="col-xs-5">
					<div class="invoice-title">
					  <h2 style="margin-top: 0px"><img src="<?='assets/images/'.APP_LOGO;?>" style="width: 80px;height: 80px" alt="" /></h2>
					</div>
				  </div>
				  
				</div>
				<div class="row">
				  <div class="col-xs-7">
				  </div>
				  <div class="col-xs-5 topTbl" style="float: right;">	
					<table class="table" style="border-collapse: collapse;">
					  <tbody>
						<tr style="font-size: 13px;">
						  <td style="padding: 5px 8px"><strong style="font-weight: 600"><?=$this->lang->line('ord_id_lbl')?>:</strong></td>
						  <td style="text-align:right;padding: 5px 8px"><?=$order_data[0]->order_unique_id?></td>
						</tr>
						<tr style="font-size: 13px;">
						  <td style="padding: 5px 8px"><strong style="font-weight: 600"><?=$this->lang->line('ord_on_lbl')?>:</strong></td>
						  <td style="text-align:right;padding: 5px 8px"><?php echo date('M d, Y',$order_data[0]->order_date);?></td>
						</tr>
						<tr style="background:#d7dcdc;font-size: 13px">
						  <td style="padding: 5px 8px" nowrap=""><strong style="font-weight: 600"><?=$this->lang->line('total_amt_lbl')?>:</strong></td>
						  <td style="text-align:right;padding: 5px 8px"><strong><?php echo CURRENCY_CODE.' '.$order_data[0]->new_payable_amt;?></strong></td>
						</tr>
					  </tbody>
					</table>
				  </div>
				</div>
			  </div>	
	          <div class="panel-body" style="margin-bottom:0;padding-top: 0px">
	            <div class="table-responsive" style="margin-bottom:0;overflow:hidden !important">
	              <table class="table table-condensed">
	                <thead>
	                    <tr class="top_bdr" style="background:#d7dcdc;font-size: 13px">
						  <td class="rank_item text-left bdr_left bdr_right"><strong style="font-weight: 600"><?=$this->lang->line('product_lbl')?></strong></td>	
	                      <td class="text-center bdr_right"><strong style="font-weight: 600"><?=$this->lang->line('price_lbl')?></strong></td>	
	                      <td class="text-center bdr_right"><strong style="font-weight: 600"><?=$this->lang->line('saving_lbl')?></strong></td>	
	                      <td class="text-center bdr_right"><strong style="font-weight: 600"><?=$this->lang->line('qty_lbl')?></strong></td>
						  <td class="text-center bdr_right"><strong style="font-weight: 600"><?=$this->lang->line('total_price_lbl')?></strong></td>					  
	                    </tr>
	                </thead>
	                <tbody>
					<?php

						$items_arr=$this->common_model->selectByids(array('order_id' => $order_data[0]->id, 'pro_order_status <> ' => '5'), 'tbl_order_items');

						$_total_price=$_total_price=$_total_qty=0;

                        foreach ($items_arr as $key => $val) {

                            $_total_price+=$val->total_price;

					?>  
	                  <tr style="font-size: 12px;font-weight: 500">
						<td class="rank_item text-left thick-line bdr_left"><?=wordwrap($val->product_title,35,"<br>\n")?></td>
	                    
	                    <td class="text-center thick-line"><?php echo CURRENCY_CODE.' '.$this->common_model->selectByidParam($val->product_id, 'tbl_product','product_mrp');?></td>
	                    <td class="text-center thick-line"><?=$this->common_model->selectByidParam($val->product_id, 'tbl_product','product_mrp')-$val->product_price?></td>
	                    <td class="text-center thick-line"><?=$val->product_qty?></td>
						<td class="text-center thick-line"><?=CURRENCY_CODE.' '.$val->total_price?></td>					
	                  </tr>
	              	<?php } ?>
	                  <tr>
					    <td class="thick-line bdr_left"></td>
					    <td class="thick-line bdr_left"></td>
	                    <td class="text-center thick-line"></td>
						<td class="text-center thick-line"></td>
	                    <td class="text-center thick-line"></td>
	                  </tr>				  				  			                    				  
	                </tbody>
	              </table>
	            </div>
				<div class="row" style="margin-top: 10px">
				  <div class="col-xs-7">
				  </div>
				  <div class="col-xs-4" style="float: right;">	
					<table class="table" style="font-size: 13px;">
					  <tbody>
						<tr>
						  <td style="padding: 5px 8px"><strong style="font-weight: 600"><?=$this->lang->line('sub_total_lbl')?></strong></td>
						  <td style="text-align:right;padding: 5px 8px"><?=CURRENCY_CODE.' '.$_total_price?></td>
						</tr>
						<tr>
						  <td style="padding: 5px 8px"><strong style="font-weight: 600"><?=$this->lang->line('delivery_charge_lbl')?></strong></td>
						  <td style="text-align:right;padding: 5px 8px"><?=$order_data[0]->delivery_charge ? '+ '.$order_data[0]->delivery_charge : $this->lang->line('free_lbl')?></td>
						</tr>
						<tr>
						  <td style="padding: 5px 8px"><strong style="font-weight: 600"><?=$this->lang->line('discount_lbl')?></strong></td>
						  <td style="text-align:right;padding: 5px 8px">- <?=CURRENCY_CODE.' '.($order_data[0]->discount_amt)?></td>
						</tr>
						<tr>
						  <td style="padding: 5px 8px"><strong style="font-weight: 600"><?=$this->lang->line('payable_amt_lbl')?></strong></td>
						  <td style="text-align:right;padding: 5px 8px"><?=CURRENCY_CODE.' '.$order_data[0]->new_payable_amt?></td>
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
</body>
</html>