<?php
  define('APP_CURRENCY', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_currency_code);
  define('CURRENCY_CODE', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_currency_html_code);

  $ci =& get_instance();

?>

<div class="row card_item_block" style="padding-left: 30px;padding-right: 30px">

  <div class="col-lg-12">
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
       <h4 id="oh-snap!-you-got-an-error!"><?=$this->lang->line("note_lbl")?>:<a class="anchorjs-link" href="#oh-snap!-you-got-an-error!"><span class="anchorjs-icon"></span></a></h4>
      <p><?=$this->lang->line('we_recommended_img_lbl')?></p>  
    </div>
  </div>

	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> 
		<a href="<?=site_url('admin/category')?>" title="<?=$cat_cnt?>" class="card card-banner card-green-light">
			<div class="card-body"> <i class="icon fa fa-sitemap fa-4x"></i>
				<div class="content">
					<div class="title"><?=$this->lang->line('category_lbl')?></div>
					<div class="value"><span class="sign"></span><?php echo $ci->number_format_short($cat_cnt);?></div>
				</div>
			</div>
		</a> 
	</div>
	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> 
		<a href="<?=site_url('admin/sub-category')?>" title="<?=$sub_cat_cnt?>" class="card card-banner card-yellow-light">
			<div class="card-body"> <i class="icon fa fa-sitemap fa-4x"></i>
				<div class="content">
					<div class="title"><?=$this->lang->line('sub_category_lbl')?></div>
					<div class="value"><span class="sign"></span><?php echo $ci->number_format_short($sub_cat_cnt);?></div>
				</div>
			</div>
		</a> 
	</div>
	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> 
		<a href="<?=site_url('admin/products')?>" title="<?=$product_cnt?>" class="card card-banner card-pink-light">
			<div class="card-body"> <i class="icon fa fa-product-hunt fa-4x"></i>
				<div class="content">
					<div class="title"><?=$this->lang->line('products_lbl')?></div>
					<div class="value"><span class="sign"></span><?php echo $ci->number_format_short($product_cnt);?></div>
				</div>
			</div>
		</a> 
	</div>
	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> 
		<a href="<?=site_url('admin/users')?>" title="<?=$user_cnt?>" class="card card-banner card-blue-light">
			<div class="card-body"> <i class="icon fa fa-users fa-4x"></i>
				<div class="content">
					<div class="title"><?=$this->lang->line('users_lbl')?></div>
					<div class="value"><span class="sign"></span><?php echo $ci->number_format_short($user_cnt);?></div>
				</div>
			</div>
		</a> 
	</div>
	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> 
		<a href="<?=site_url('admin/orders')?>" title="<?=$order_cnt?>" class="card card-banner card-orange-light">
			<div class="card-body"> <i class="icon fa fa-cart-arrow-down fa-4x"></i>
				<div class="content">
					<div class="title"><?=$this->lang->line('orders_lbl')?></div>
					<div class="value"><span class="sign"></span><?php echo $ci->number_format_short($order_cnt);?></div>
				</div>
			</div>
		</a> 
	</div>

	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> 
		<a href="<?=site_url('admin/transactions')?>" title="<?=$transaction_cnt?>" class="card card-banner card-alicerose-light">
			<div class="card-body"> <i class="icon fa fa-list fa-4x"></i>
				<div class="content">
					<div class="title"><?=$this->lang->line('transactions_lbl')?></div>
					<div class="value"><span class="sign"></span><?php echo $ci->number_format_short($transaction_cnt);?></div>
				</div>
			</div>
		</a> 
	</div>

	<div class="col-lg-4 col-md-6 col-sm-6 col-xs-12"> 
		<a href="<?=site_url('admin/refunds')?>" title="<?=$pending_refund_cnt?>" class="card card-banner card-aliceblue-light">
			<div class="card-body"> <i class="icon fa fa-undo fa-4x"></i>
				<div class="content">
					<div class="title"><?=$this->lang->line('pending_refund_lbl')?></div>
					<div class="value"><span class="sign"></span><?php echo $ci->number_format_short($pending_refund_cnt);?></div>
				</div>
			</div>
		</a> 
	</div>
	
</div>

<div class="row card_item_block" style="padding-left: 30px;padding-right: 30px">
  <div class="col-lg-12">
    <div class="container-fluid" style="background: #FFF;box-shadow: 0px 5px 10px 0px #CCC;border-radius: 2px;">
      <div class="col-lg-10">
        <h3><?=$this->lang->line('ord_analysis_lbl')?></h3>
      </div>
      <div class="col-lg-2" style="padding-top: 20px">
        <form method="get" id="graphFilter2">
          <select class="form-control" name="order_filter" style="box-shadow: none;height: auto;border-radius: 0px;font-size: 16px;">
            <?php 
              $currentYear=date('Y');
              $minYear=2019;

              for ($i=$currentYear; $i >= $minYear ; $i--) { 
                ?>
                <option value="<?=$i?>" <?=(isset($_GET['order_filter']) && $_GET['order_filter']==$i) ? 'selected' : ''?>><?=$i?></option>
                <?php
              }
            ?>
          </select>
        </form>
      </div>
      <div class="col-lg-12">
        <?php 
          if($order_no_data_status){
            ?>
            <h3 class="text-muted text-center" style="padding-bottom: 2em"><?=$this->lang->line('no_data')?></h3>
            <?php
          }
          else{
            ?>
            <div id="ordersChart">
            <p style="text-align: center;"><i class="fa fa-spinner fa-spin" style="font-size:3em;color:#aaa;margin-bottom:50px" aria-hidden="true"></i></p>
            </div>
            <?php    
          }
        ?>
      </div>
    </div>
  </div>
</div>
<br/>
<div class="row card_item_block" style="padding-left: 30px;padding-right: 30px">
  <div class="col-lg-12">
    <div class="container-fluid" style="background: #FFF;box-shadow: 0px 5px 10px 0px #CCC;border-radius: 2px;">
      <div class="col-lg-10">
        <h3><?=$this->lang->line('tran_analysis_lbl')?></h3>
      </div>
      <div class="col-lg-2" style="padding-top: 20px">
        <form method="get" id="graphFilter">
          <select class="form-control" name="transaction_filter" style="box-shadow: none;height: auto;border-radius: 0px;font-size: 16px;">
            <?php 
              $currentYear=date('Y');
              $minYear=2019;

              for ($i=$currentYear; $i >= $minYear ; $i--) { 
                ?>
                <option value="<?=$i?>" <?=(isset($_GET['transaction_filter']) && $_GET['transaction_filter']==$i) ? 'selected' : ''?>><?=$i?></option>
                <?php
              }
            ?>
          </select>
        </form>
      </div>
      <div class="col-lg-12">
        <?php 
          if($no_data_status){
            ?>
            <h3 class="text-muted text-center" style="padding-bottom: 2em"><?=$this->lang->line('no_data')?></h3>
            <?php
          }
          else{
            ?>
            <div id="transactionChart">
              <p style="text-align: center;"><i class="fa fa-spinner fa-spin" style="font-size:3em;color:#aaa;margin-bottom:50px" aria-hidden="true"></i></p>
            </div>
            <?php    
          }
        ?>
      </div>
    </div>
  </div>
</div>

<div class="row card_item_block" style="padding-left: 30px;padding-right: 30px">
  <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
    <div class="card card-mini">
      <div class="card-header">
        <div class="card-title"><?=$this->lang->line('top_sales_products_lbl')?> <a href="<?php if(!empty($top_selling_products)){ echo site_url('admin/top-sale-products'); }else{ echo 'javascript:void(0)';}?>">[<?=$this->lang->line('view_all_lbl')?>]</a></div>
        <ul class="card-action">
          <li>
            <a href="" class="refresh_btn">
              <i class="fa fa-refresh"></i>
            </a>
          </li>
        </ul>
      </div>
      <div class="card-body no-padding table-responsive">
        <table class="table card-table">
          <thead>
            <tr>
              <th><?=$this->lang->line('product_lbl')?></th>
              <th class="right" style="text-align: center;"><?=$this->lang->line('sales_lbl')?></th>
            </tr>
          </thead>
          <tbody>
          	<?php 

          		if(!empty($top_selling_products))
          		{
          			foreach ($top_selling_products as $key => $value) {
          	?>
	            <tr>
	              <td><?=$value->product_title?></td>
	              <td class="right" align="center"><?=$value->total_sale?></td>
	            </tr>
        	     <?php } }else{ ?>
            <tr>
              <td colspan="2" align="center"><?=$this->lang->line('no_data')?></td>
            </tr>
        	<?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
    <div class="card card-mini">
      <div class="card-header">
        <div class="card-title"><?=$this->lang->line('todays_ord_lbl')?> <a href="<?php if(!empty($todays_orders)){ echo site_url('admin/orders'); }else{ echo 'javascript:void(0)';}?>">[<?=$this->lang->line('view_all_lbl')?>]</a></div>
        <ul class="card-action">
          <li>
            <a href="" class="refresh_btn">
              <i class="fa fa-refresh"></i>
            </a>
          </li>
        </ul>
      </div>
      <div class="card-body no-padding table-responsive">
        <table class="table card-table">
          <thead>
            <tr>
              <th><?=$this->lang->line('ord_id_lbl')?></th>
              <th><?=$this->lang->line('user_lbl')?></th>
              <th class="right"><?=$this->lang->line('amount_lbl')?></th>
              <th><?=$this->lang->line('status_lbl')?></th>
            </tr>
          </thead>
          <tbody>
            <?php
          		if(!empty($todays_orders))
          		{
          			$ci =& get_instance();
          			foreach ($todays_orders as $key => $value) {
                      
                      $_bnt_class='badge-primary';
                      $_btn_icon='fa fa-clock-o';
                      $_btn_title=$ci->get_status_title($value->order_status);

                      switch ($value->order_status) {
                          case '1':
                              $_bnt_class='badge-default';
                              $_btn_icon='fa fa-clock-o';
                              break;
                          case '2':
                              $_bnt_class='badge-primary';
                              $_btn_icon='fa fa-clock-o';
                              break;
                          case '3':
                              $_bnt_class='badge-warning';
                              $_btn_icon='fa fa-truck';
                              break;

                          case '4':
                              $_bnt_class='badge-success';
                              $_btn_icon='fa fa-check';
                              break;
                          
                          default:
                              $_bnt_class='badge-danger';
                              $_btn_icon='fa fa-times';
                              break;
                      }

          	?>
	            <tr>
	              <td><a href="<?php echo site_url("admin/orders/".$value->order_unique_id);?>" target="_blank"><?=$value->order_unique_id?></a></td>
	              <td class="right"><?=$value->name?></td>
	              <td class="right"><?=CURRENCY_CODE.' '.$value->payable_amt?></td>
	              <td><span class="badge <?=$_bnt_class?> badge-icon"><i class="<?=$_btn_icon?>" aria-hidden="true"></i><span><?=$_btn_title?></span></span></td>
	            </tr>
        	<?php } }else{ ?>
            <tr>
              <td colspan="4" align="center"><?=$this->lang->line('no_data')?></td>
            </tr>
        	<?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

 <script type="text/javascript">
 	$(".refresh_btn").click(function(e){
 		e.preventDefault();
 		location.reload();
 	});
 </script>


 <?php

  if(!$order_no_data_status){
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
      google.charts.load('current', {packages: ['corechart', 'line']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'MONTHS');
        data.addColumn('number', '<?=$this->lang->line('total_ords_lbl')?>');
        data.addColumn('number', '<?=$this->lang->line('process_ord_lbl')?>');
        data.addColumn('number', '<?=$this->lang->line('delivered_ord_lbl')?>');
        data.addColumn('number', '<?=$this->lang->line('cancellled_ord_lbl')?>');

        data.addRows([<?=$countStrOrd?>]);

        var options = {
          curveType: 'function',
          fontSize: 15,
          hAxis: {
            title: "<?=$this->lang->line('months_of_lbl')?> <?=(isset($_GET['order_filter'])) ? $_GET['order_filter'] : date('Y')?>",
            titleTextStyle: {
              color: '#000',
              bold:'true',
              italic: false
            },
          },
          vAxis: {
            title: "<?=$this->lang->line('total_ords_lbl')?>",
            titleTextStyle: {
              color: '#000',
              bold:'true',
              italic: false,
            },
            gridlines: { count: -1},
            format: 'short',
            viewWindowMode: "explicit", viewWindow: {min: 0, max: 'auto'},
          },
          height: 400,
          chartArea:{
            left:50,top:20,width:'100%',height:'auto'
          },
          legend: {
              position: 'bottom'
          },
          colors: ['#000080','#ff6600', '#009900','#cc0000'],
          lineWidth:4,
          animation: {
            startup: true,
            duration: 1200,
            easing: 'out',
          },
          pointSize: 5,
          pointShape: "circle",

        };
        var chart = new google.visualization.LineChart(document.getElementById('ordersChart'));

        chart.draw(data, options);
      }

      $(document).ready(function () {
          $(window).resize(function(){
              drawChart();
          });
      });
    </script>
    <?php
  }
?>

 <?php 
  if(!$no_data_status){
    ?>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript">
      google.charts.load('current', {packages: ['corechart', 'line']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'MONTHS');
        data.addColumn('number', '<?=$this->lang->line('total_payment_lbl')?>');
        data.addColumn('number', '<?=strtoupper($this->lang->line('cod_short_lbl'))?>');
        data.addColumn('number', '<?=strtoupper($this->lang->line('paypal_lbl'))?>');
        data.addColumn('number', '<?=strtoupper($this->lang->line('stripe_lbl'))?>');
        data.addColumn('number', '<?=strtoupper($this->lang->line('razorpay_lbl'))?>');

        data.addRows([<?=$countStr?>]);

        var options = {
          curveType: 'function',
          fontSize: 15,
          hAxis: {
            title: "<?=$this->lang->line('months_of_lbl')?><?=(isset($_GET['transaction_filter'])) ? $_GET['transaction_filter'] : date('Y')?>",
            titleTextStyle: {
              color: '#000',
              bold:'true',
              italic: false
            },
          },
          vAxis: {
            title: "<?=$this->lang->line('total_payment_lbl')?>",
            titleTextStyle: {
              color: '#000',
              bold:'true',
              italic: false,
            },
            gridlines: { count: -1},
            format: 'short',
            viewWindowMode: "explicit", viewWindow: {min: 0, max: 'auto'},
          },
          height: 400,
          chartArea:{
            left:50,top:20,width:'100%',height:'auto'
          },
          legend: {
              position: 'bottom'
          },
          colors: ['#008000', '#808000','#00FFFF','#008080','#000080','#800080'],
          lineWidth:4,
          animation: {
            startup: true,
            duration: 1200,
            easing: 'out',
          },
          pointSize: 5,
          pointShape: "circle",

        };
        var chart = new google.visualization.LineChart(document.getElementById('transactionChart'));

        chart.draw(data, options);
      }


      $(document).ready(function () {
          $(window).resize(function(){
              drawChart();
          });
      });
    </script>
    <?php
  }
?>

<script type="text/javascript">
    
    // filter of graph
    $("select[name='transaction_filter']").on("change",function(e){
      $("#graphFilter").submit();
    });

    $("select[name='order_filter']").on("change",function(e){
      $("#graphFilter2").submit();
    });

</script> 