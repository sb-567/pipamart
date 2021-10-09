<?php 
	$row_banner=$banner[0];
	define('IMG_PATH', base_url().'assets/images/product/');
	$CI=&get_instance();

?>
<style type="text/css">
  .top{
    position: relative !important;
    padding: 0px 0px 20px 0px !important;
  }
  .dataTables_wrapper{
    overflow: initial !important;
  }  
</style>
<div class="row card_item_block" style="padding-left:30px;padding-right: 30px">
  <div class="col-xs-12">
  	<?php 
      if(isset($_GET['redirect'])){
        echo '<a href="'.$_GET['redirect'].'"><h4 class="pull-left btn_back" style=""><i class="fa fa-arrow-left"></i> Back</h4></a>';
      }
      else{
        echo '<a href="'.base_url('admin/banner').'"><h4 class="pull-left btn_back" style=""><i class="fa fa-arrow-left"></i> Back</h4></a>'; 
      }
    ?>
    <div class="card mrg_bottom">
      <div class="page_title_block">
        <div class="col-md-5 col-xs-12">
          <div class="page_title" style="font-size: 18px;"><?=$row_banner->banner_title?></div>
        </div>
      </div>
      <div class="clearfix"></div>
      <div class="col-md-12 mrg-top">
      	<table class="datatable table table-striped table-bordered table-hover">
	      <thead>
	        <tr>
	          <th width="30">#</th>
	          <th><?=$this->lang->line('img_lbl')?></th>
	          <th><?=$this->lang->line('products_lbl')?></th>
	          <th><?=$this->lang->line('action_lbl')?></th>
	        </tr>
	      </thead>
	      <tbody>
	      	<?php 
	      		$products=$CI->product_list($row_banner->product_ids);
	      		$no=1;

	      		if(!empty($products))
	      		{
	      		foreach ($products as $key => $value) {
	      	?>
	      	<tr>
	      		<td><?=$no++?></td>
	      		<td>
          			<a href="<?=($value->featured_image!='') ? base_url('assets/images/products/'.$value->featured_image) : 'javascript:void(0)'?>" target="_blank">
          				<img src="<?=base_url('assets/images/products/'.$value->featured_image)?>" alt="" style="width: 50px;height: 50px">
          			</a>
          		</td>
	      		<td title="<?=$value->product_title?>">
	      			<?php 
	      				if(strlen($value->product_title) > 45){
	                      echo substr(stripslashes($value->product_title), 0, 50).'...';  
	                    }else{
	                      echo $value->product_title;
	                    }
	      			?>
	      		</td>
	      		<td>
	                <a href="" data-id="<?=$value->id?>" data-banner="<?=$row_banner->id?>" class="btn btn-danger btn_delete" style="font-size: 12px"> <?=$this->lang->line('remove_lbl')?></a>
	            </td>
	      	</tr>
	      	<?php } } ?>
	      </tbody>
	  	</table>
      </div>
  	</div>
  </div>
</div>

<script type="text/javascript">

    $(".btn_delete").click(function(e) {
        e.preventDefault();
        var _id=$(this).data("id");
        var _banner=$(this).data("banner");

        var href = '<?=base_url()?>admin/banner/remove_product/'+_banner+'/'+_id;

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
                            type: 'GET',
                            url: href
                        })
                        .done(function(res){
                            location.reload();
                        })
                        .fail(function(res) {
                            swal('<?=$this->lang->line('something_went_wrong_err')?>');
                        });

                } else {
                    swal.close();
                }
            });

    });
</script>