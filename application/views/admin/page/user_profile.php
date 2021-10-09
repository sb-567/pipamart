<?php 

	define('IMG_PATH', base_url().'assets/images/users/');

	define('APP_CURRENCY', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_currency_code);
	define('CURRENCY_CODE', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_currency_html_code);

	$ci =& get_instance();

	$user_img='';

	if($user[0]->user_image!='' && file_exists('assets/images/users/'.$user[0]->user_image)){
		$user_img=IMG_PATH.$user[0]->user_image;
	}
	else{
		$user_img=base_url('assets/images/2.png');
	}

?>

<style type="text/css">
	.label-success-cust{
		background: green !important;
	}
</style>

<div class="row card_item_block" style="padding-left:30px;padding-right: 30px">
	<div class="col-lg-12">
		<?php 
	      if(isset($_GET['redirect'])){
	        echo '<a href="'.$_GET['redirect'].'"><h4 class="pull-left btn_back" style=""><i class="fa fa-arrow-left"></i> Back</h4></a>';
	      }
	      else{
	        echo '<a href="'.base_url('admin/users').'"><h4 class="pull-left btn_back" style=""><i class="fa fa-arrow-left"></i> Back</h4></a>'; 
	      }
	    ?>
		<div class="page_title_block user_dashboard_item" style="background-color: #333;border-radius:6px;0 1px 4px 0 rgba(0, 0, 0, 0.14);border-bottom:0">
			<div class="user_dashboard_mr_bottom">
			  <div class="col-md-12 col-xs-12"> <br>
				<span class="badge badge-success badge-icon">
				  <div class="user_profile_img">
				  
				   <?php 
					  if($user[0]->user_type=='Google'){
						echo '<img src="'.base_url('assets/img/google-logo.png').'" style="top: 20px;left: 60px;" class="social_img">';
					  }
					  else if($user[0]->user_type=='Facebook'){
						echo '<img src="'.base_url('assets/img/facebook-icon.png').'" style="top: 20px;left: 60px;" class="social_img">';
					  }
					?>
					<img type="image" src="<?php echo $user_img;?>" alt="image" style=""/>
				  </div>
				  <span style="font-size: 14px;"><?=ucwords($user[0]->user_name)?>				
				  </span>
				</span>  
				<span class="badge badge-success badge-icon">
				<i class="fa fa-envelope fa-2x" aria-hidden="true"></i>
				<span style="font-size: 14px;text-transform: lowercase;"><?php echo $user[0]->user_email;?></span>
				</span> 
				<span class="badge badge-success badge-icon">
				<i class="fa fa-mobile fa-2x" aria-hidden="true"></i>
				<span style="font-size: 14px;text-transform: lowercase;"><?php echo ($user[0]->user_phone!='') ? $user[0]->user_phone : '-';?></span>
				</span> 
				<span class="badge badge-success badge-icon">
				  <strong style="font-size: 14px;"><?=$this->lang->line('register_on_lbl')?>:</strong>
				  <span style="font-size: 14px;"><?php echo date('d-m-Y h:i A',$user[0]->created_at);?></span>
				</span>
				<br><br/>
			  </div>
			</div>
		</div>

	  	<div class="card card-tab">
		    <div class="card-header" style="overflow-x: auto;overflow-y: hidden;">
		      <ul class="nav nav-tabs">
		      	<li role="wishlist_tb" class="active">
		          <a href="#wishlist_tb" aria-controls="wishlist_tb" role="tab" data-toggle="tab"><?=$this->lang->line('wishlist_lbl')?></a>
		        </li>
		        <li role="cart_tb">
		          <a href="#cart_tb" aria-controls="cart_tb" role="tab" data-toggle="tab"><?=$this->lang->line('cart_lbl')?></a>
		        </li>
		        <li role="order_tb">
		          <a href="#order_tb" aria-controls="order_tb" role="tab" data-toggle="tab"><?=$this->lang->line('orders_lbl')?></a>
		        </li>
		        <li role="profile_tb">
		          <a href="#profile_tb" aria-controls="profile_tb" role="tab" data-toggle="tab"><?=$this->lang->line('profile_lbl')?></a>
		        </li>
		        <li role="review_tb">
		          <a href="#review_tb" aria-controls="review_tb" role="tab" data-toggle="tab"><?=$this->lang->line('reviews_lbl')?></a>
		        </li>
		      </ul>
		    </div>
		    <div class="card-body no-padding tab-content">
		      <div role="tabpanel" class="tab-pane active" id="wishlist_tb">
		       	<table class="datatable table table-striped table-bordered table-hover" style="margin-top: 50px !important">
	              <thead>
	                <tr>
	                  	<th><?=$this->lang->line('img_lbl')?></th>
	                  	<th><?=$this->lang->line('product_lbl')?></th>
	        			<th nowrap=""><?=$this->lang->line('price_lbl')?></th>
	        			<th nowrap=""><?=$this->lang->line('created_on_lbl')?></th>
	        			<th><?=$this->lang->line('action_lbl')?></th>
	                </tr>
	              </thead>
	              <tbody>

	              	<?php 
	              		$no=1;
	              		foreach ($wishlist_row as $key => $value)
	              		{

	              			$thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->featured_image);

	              			$img_file=$ci->_create_thumbnail('assets/images/products/',$thumb_img_nm,$value->featured_image,50,50);
	              	?>

	              	<tr>
	              		<td>
	              			<a href="javascript:void(0)">
	              				<img src="<?=base_url().$img_file?>" alt="" style="width: 50px;height: 50px">
	              			</a>
	              		</td>
	              		<td title="<?=$value->product_title?>">
	              			<?php 
	              				if(strlen($value->product_title) > 40){
		                          echo substr(stripslashes($value->product_title), 0, 40).'...';  
		                        }else{
		                          echo $value->product_title;
		                        }
	              			?>
	              		</td>
	              		<td nowrap=""><?=CURRENCY_CODE.' '.number_format($value->selling_price, 2)?></td>
	              		<td><?php echo date('d-m-Y h:i A',$value->created_at);?></td>
	              		<td>
	              			<a href="<?php echo site_url('admin/users/remove_to_wishlist/'.$value->id); ?>" class="btn btn_remove btn-danger btn_delete" data-toggle="tooltip" data-tooltip="<?=$this->lang->line('delete_lbl')?>"><i class="fa fa-trash"></i></a>
	              		</td>

	              	</tr>
	              	<?php } ?>
	              </tbody>
	          	</table>
		      </div>
		      <div role="tabpanel" class="tab-pane" id="cart_tb">
		       	<table class="datatable table table-striped table-bordered table-hover" style="margin-top: 50px !important">
	              <thead>
	                <tr>
	                  	<th><?=$this->lang->line('img_lbl')?></th>						 
	                  	<th><?=$this->lang->line('product_lbl')?></th>
	        			<th><?=$this->lang->line('qty_lbl')?></th>
	        			<th nowrap=""><?=$this->lang->line('price_lbl')?></th>
	        			<th nowrap=""><?=$this->lang->line('total_price_lbl')?></th>
	        			<th nowrap=""><?=$this->lang->line('created_on_lbl')?></th>
	        			<th><?=$this->lang->line('action_lbl')?></th>
	                </tr>
	              </thead>
	              <tbody>

	              	<?php 
	              		$no=1;
	              		foreach ($cart_row as $key => $value) {

	              			$thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->featured_image);

	              			$img_file=$ci->_create_thumbnail('assets/images/products/',$thumb_img_nm,$value->featured_image,50,50);
	              	?>
	              	<tr>
	              		
	              		<td>
	              			<a href="javascript:void(0)">
	              				<img src="<?=base_url().$img_file?>" alt="" style="width: 50px;height: 50px"></a>
	              		</td>
	              		<td title="<?=$value->product_title?>">
	              			<?php 
	              				if(strlen($value->product_title) > 40){
		                          echo substr(stripslashes($value->product_title), 0, 40).'...';  
		                        }else{
		                          echo $value->product_title;
		                        }
	              			?>
	              		</td>
	              		<td><?=$value->product_qty?></td>
	              		<td nowrap=""><?=CURRENCY_CODE.' '.number_format($value->selling_price, 2)?></td>
	              		<td nowrap=""><?=CURRENCY_CODE.' '.number_format($value->selling_price*$value->product_qty, 2)?></td>
	              		<td><?php echo date('d-m-Y h:i A',$value->created_at);?></td>
	              		<td>
	              			<a href="<?php echo site_url('admin/users/remove_to_cart/'.$value->id); ?>" class="btn btn_remove btn-danger btn_delete" data-toggle="tooltip" data-tooltip="<?=$this->lang->line('delete_lbl')?>"><i class="fa fa-trash"></i></a>
	              		</td>

	              	</tr>
	              	<?php } ?>
	              </tbody>
	          	</table>
		      </div>
		      <div role="tabpanel" class="tab-pane" id="order_tb">
		       	<table class="datatable table table-striped table-bordered table-hover" style="margin-top: 50px !important">
	              <thead>
	                <tr>
						<th>#</th>
						<th><?=$this->lang->line('ord_id_lbl')?></th>						 
						<th><?=$this->lang->line('user_nm_lbl')?></th>
						<th><?=$this->lang->line('user_phone_lbl')?></th>
						<th><?=$this->lang->line('payable_amt_lbl')?></th>
						<th nowrap=""><?=$this->lang->line('ord_on_lbl')?></th>
						<th><?=$this->lang->line('status_lbl')?></th>	 
						<th class="cat_action_list"><?=$this->lang->line('action_lbl')?></th>
	                </tr>
	              </thead>
	              <tbody>

	              	<?php 
	              		$no=1;
	              		foreach ($order_row as $key => $row) {
	              	?>

	              	<tr class="item_holder">
	                  	<td><?php echo $no++;?></td>
	                  	<td><a href="<?php echo site_url("admin/orders/".$row->order_unique_id);?>" target="_blank"><?php echo $row->order_unique_id;?></a></td>
			            <td><?php echo $row->name;?></td>
			            <td><?php echo $row->mobile_no;?></td>
			            <td nowrap=""><?=CURRENCY_CODE.' '.$row->new_payable_amt?></td>
			            <td><?php echo date('d-m-Y h:i A',$row->order_date);?></td>
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

		                    <a href="" class="btn btn-warning btn_edit btn_status" <?=($row->order_status > 4) ? 'disabled="disabled"' : ''?> data-toggle="tooltip" data-id="<?=$row->id?>" data-tooltip="<?=$this->lang->line('ord_status_lbl')?>"><i class="fa fa-wrench"></i></a>

		                    <a href="<?php echo site_url("admin/orders/print/".$row->order_unique_id);?>" target="_blank" class="btn btn-primary btn_edit" data-toggle="View" data-tooltip="<?=$this->lang->line('print_lbl')?>"><i class="fa fa-print"></i></a>

		                    <a href="javascript:void(0)" class="btn btn-danger btn_delete btn_delete_ord" data-toggle="tooltip" data-id="<?=$row->id?>" data-tooltip="<?=$this->lang->line('delete_lbl')?>"><i class="fa fa-trash"></i></a>
	                    
	                  	</td>
	                </tr>
	              	<?php } ?>
	              </tbody>
	          	</table>
		      </div>
		      <div role="tabpanel" class="tab-pane" id="profile_tb">
		        <div class="row">
		          <div class="col-md-12 col-sm-12">
		          	<div class="section">
		              <div class="section-title"><i class="icon fa fa-map-marker" aria-hidden="true"></i> <?=$this->lang->line('addresses_lbl')?></div>
		              <div class="section-body __indent"></div>
		              <div class="col-md-12">
		              	
		              </div>
		              <?php 
		              	foreach ($address_data as $key => $value) {
		              ?>
		              <div class="col-md-6">
	              		<div class="container-fluid" style="box-shadow: 0px 5px 5px 0px #ddd;border-radius: 5px;padding: 10px 20px;border:1px solid #ddd">
	              			<h4 style="font-size: 16px;font-weight: 500;"><?=$value->building_name?>,</h4>
				            <h4 style="font-size: 15px;font-weight: normal;"><?=$value->road_area_colony?>,</h4>
				            <h4 style="font-size: 15px;font-weight: normal;"><?=$value->city?>, <?=($value->district!='') ? $value->district.', ' : '' ?><?=$value->state?></h4>
				            <h4 style="font-size: 15px;font-weight: normal;"><?=$value->country?> - <?=$value->pincode?></h4>
				            <h4 style="font-size: 15px;font-weight: normal;"><strong><?=$this->lang->line('name_lbl')?>:</strong> <?=$value->name?></h4>
				            <h4 style="font-size: 15px;font-weight: normal;"><strong><?=$this->lang->line('email_lbl')?>:</strong> <?=$value->email?></h4>
				            <h4 style="font-size: 15px;font-weight: normal;"><strong><?=$this->lang->line('phone_no_lbl')?>:</strong> <?=$value->mobile_no?></h4>
				            <?php 
		              			if($value->is_default=='true'){
		              				echo '<label class="label label-success">'.$this->lang->line('default_lbl').'</label>';		
		              			}
		              		?>

				            <a href="<?php echo site_url('admin/users/remove_address/'.$value->id); ?>" class="btn_remove btn btn-danger btn_cust pull-right"><i class="fa fa-trash"></i> <?=$this->lang->line('delete_lbl')?></a>
	              		</div>
		              </div>
		          	  <?php } ?>
		          	  <div class="clearfix"></div>
		          	</div>
		          	<br/>
		            <div class="section">
		              <div class="section-title"><i class="icon fa fa-book" aria-hidden="true"></i> <?=$this->lang->line('saved_bank_lbl')?></div>
		              <div class="section-body __indent"></div>

		              <?php 
		              	// print_r($bank_details);
		              	foreach ($bank_details as $key => $value) {
		              ?>
		              <div class="panel panel-primary">
					    <div class="panel-heading clearfix" style="padding-top: 5px;padding-bottom: 5px">
					      <h4 class="panel-title pull-left" style="padding-top: 7.5px;"><?=ucwords($value->bank_name)?> <?php if($value->is_default){ echo '['.$this->lang->line('default_refund_acc_lbl').']';} ?></h4>
					      <div class="btn-group pull-right">
					        <a href="<?php echo site_url('admin/users/remove_bank/'.$value->id); ?>" class="btn btn-danger btn_delete btn_remove"><i class="fa fa-trash"></i> <?=$this->lang->line('delete_btn')?></a>
					      </div>
					    </div>
					    <div class="panel-body">
					    	<br/>
						    <table class="table table-condensed">
						        <tbody>
					                <tr>
					                    <td class="col-md-3"><strong><?=$this->lang->line('bank_acc_no_lbl')?></strong></td>
					                    <td><?=$value->account_no?></td>
					                    <td class="col-md-3"><strong><?=$this->lang->line('bank_type_lbl')?></strong></td>
					                    <td><?=ucfirst($value->account_type)?></td>
					                </tr>
					                <tr>
					                    <td class="col-md-2"><strong><?=$this->lang->line('bank_ifsc_lbl')?></strong></td>
					                    <td colspan="3"><?=$value->bank_ifsc?></td>
					                </tr>
					                <tr>
					                    <td class="col-md-3"><strong><?=$this->lang->line('holder_name_lbl')?></strong></td>
					                    <td><?=$value->bank_holder_name?></td>
					                    <td class="col-md-3"><strong><?=$this->lang->line('holder_mobile_lbl')?></strong></td>
					                    <td><?=$value->bank_holder_phone?></td>
					                </tr>
					                <tr>
					                    <td class="col-md-2"><strong><?=$this->lang->line('holder_email_lbl')?></strong></td>
					                    <td colspan="3"><?=$value->bank_holder_email?></td>
					                </tr>
						        </tbody>
						    </table>
					    </div>
					  </div>
					<?php } ?>

		            </div>
		          </div>
		        </div>
		      </div>

		      <div role="tabpanel" class="tab-pane" id="review_tb">
		       	<table class="datatable table table-striped table-bordered table-hover" style="margin-top: 50px !important">
	              <thead>
	                <tr>
	                  	<th><?=$this->lang->line('product_lbl')?></th>
	        			<th nowrap=""><?=$this->lang->line('rating_lbl')?></th>
	        			<th nowrap=""><?=$this->lang->line('reviews_lbl')?></th>
	        			<th nowrap=""><?=$this->lang->line('img_lbl')?></th>
	        			<th nowrap=""><?=$this->lang->line('review_on_lbl')?></th>
	        			<th><?=$this->lang->line('action_lbl')?></th>
	                </tr>
	              </thead>
	              <tbody>

	              	<?php 

	              		$no=1;
	              		foreach ($review_data as $key => $value) {

	              			$product_title=$this->common_model->selectByidParam($value->product_id, 'tbl_product','product_title');
	              	?>

	              	<tr>
	              		<td title="<?=$product_title?>">
	              			<?php 
	              				if(strlen($product_title) > 40){
		                          echo substr(stripslashes($product_title), 0, 40).'...';  
		                        }else{
		                          echo $product_title;
		                        }
	              			?>
	              		</td>
	              		<td nowrap=""><?=$value->rating?></td>
	              		<td><?=stripslashes($value->rating_desc)?></td>
	              		<td>
	              			<button class="btn btn-primary btn_edit btn_view"><?=$this->lang->line('view_lbl')?></button>
	              			<div class="img_holder" style="display: none;">
	              				<div class="row">
		              				<?php 
		              					$row_review_img=$this->common_model->selectByids(array('parent_id' => $value->id, 'type' => 'review'), 'tbl_product_images');

		              					foreach ($row_review_img as $key => $row_img) {
		              				?>
		              				<div class="col-md-2">
		              					<a href="<?=base_url('assets/images/review_images/').$row_img->image_file?>" target="_blank"><img src="<?=base_url('assets/images/review_images/').$row_img->image_file?>" style="width: 100%;border-radius: 10px;border: 5px solid #eee;"></a>
		              				</div>
		              				<?php } ?>
		              			</div>
	              			</div>
	              		</td>
	              		<td><?php echo date('d-m-Y h:i A',$value->created_at);?></td>
	              		<td>
	              			<a href="<?php echo site_url('admin/users/remove_review/'.$value->id); ?>" class="btn btn_remove btn-danger btn_delete" data-toggle="tooltip" data-tooltip="<?=$this->lang->line('delete_lbl')?>"><i class="fa fa-trash"></i></a>
	              		</td>

	              	</tr>
	              	<?php } ?>
	              </tbody>
	          	</table>
		      </div>
		      
		      <div role="tabpanel" class="tab-pane" id="tab4">
		        ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nullaip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nullaip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla
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


<div id="productImages" class="modal fade" role="dialog" style="">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?=$this->lang->line('review_images_lbl')?></h4>
        </div>
        <div class="modal-body">
          	
        </div>
    </div>
  </div>
</div>

<script type="text/javascript">

	$(".btn_view").click(function(e){

		$("#productImages .modal-body").html($(this).next('.img_holder').html());

		$("#productImages").modal("show");
	});

  	$(".btn_status").click(function(e){  

        e.preventDefault();
      	$("#orderStatus").modal("show");
      	var _id=$(this).data("id");
      	var href='<?=base_url()?>admin/order/order_status_form/'+_id;

      	$("#orderStatus .modal-body").load(href);
  	});
</script>

<script type="text/javascript">

	$(".btn_remove").on("click",function(e){
		e.preventDefault();

		var href=$(this).attr("href");

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
	        	window.location.href=href;
	        }
	        else{
	        	swal.close();
	        }
	    });
    });

    $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
	    localStorage.setItem('activeTab', $(e.target).attr('href'));

	});

	$('a[data-toggle="tab"]').click(function(e){
	  	/*location.reload();*/
	});

	var activeTab = localStorage.getItem('activeTab');
	if(activeTab){
		$('.nav-tabs a[href="' + activeTab + '"]').tab('show');
	}

</script>


<script type="text/javascript">
	// for delete order
  $(".btn_delete_ord").on("click",function(e){
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