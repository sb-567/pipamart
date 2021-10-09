<?php 
  $this->load->view('site/layout/breadcrumb'); 
  $ci =& get_instance();

  $product_image=$ci->_create_thumbnail('assets/images/products/',$product_row->product_slug,$product_row->featured_image,250,250);

?>

<link rel="stylesheet" type="text/css" href="<?=base_url('assets/site_assets/js/baguettebox/baguetteBox.min.css')?>">

<style type="text/css">
	#baguetteBox-overlay{
		background:rgba(0, 0, 0, 0.9) !important;
	}
</style>

<div class="product-list-grid-view-area product_review mt-20">
	  <div class="container">
	    <div class="row"> 
			<div class="col-lg-3 col-md-3 mb_40"> 
		       <div class="widget widget-shop-categories">
				  	<div class="single-product">
					  <div class="product-img"> 
					  	<a href="<?php echo site_url('product/'.$product_row->product_slug); ?>"> <img class="first-img" src="<?=base_url().$product_image?>" alt=""></a>
					  </div>
					  <div class="product-content">
						<h2><a href="<?php echo site_url('product/'.$product_row->product_slug); ?>" style="line-height: 21px"><?=$product_row->product_title?></a></h2>
						
						<div class="product-price"> 
						<?php 
							if($product_row->you_save_amt!='0'){
								?>
								<span class="new-price"><?=CURRENCY_CODE.' '.$product_row->selling_price?></span> 
								<span class="old-price"><?=CURRENCY_CODE.' '.$product_row->product_mrp;?></span>
								<?php
							}
							else{
								?>
								<span class="new-price"><?=CURRENCY_CODE.' '.$product_row->product_mrp;?></span>
								<?php
							}
						?>
						</div>
						<div class="rating">
							<?php 
                              for ($x = 0; $x < 5; $x++) { 
                                if($x < $product_row->rate_avg){
                                  ?>
                                  <i class="fa fa-star" style="color: #F9BA48"></i>
                                  <?php  
                                }
                                else{
                                  ?>
                                  <i class="fa fa-star"></i>
                                  <?php
                                }
                              }
                            ?>
						</div>
					  </div>
					</div>
				</div>
			</div>
			<div class="col-lg-9 col-md-9">
				<div class="my_profile_area_detail">
					<div class="checkout-title">
						<h3>All Reviews
							<div class="toolbar-form">
								<form action="" method="get">
								  <div class="toolbar-select">
									<select data-placeholder="Sort by..." class="order-by reviews_order" name="sort" tabindex="1">
									  <option value="newest" <?php echo (isset($_GET['sort']) && strcmp($_GET['sort'], 'newest')==0) ? 'selected' : '' ?>><?=$this->lang->line('review_newest_first_lbl')?></option>
									  <option value="oldest" <?php echo (isset($_GET['sort']) && strcmp($_GET['sort'], 'oldest')==0) ? 'selected' : '' ?>><?=$this->lang->line('review_oldest_first_lbl')?></option>
									  <option value="negative" <?php echo (isset($_GET['sort']) && strcmp($_GET['sort'], 'negative')==0) ? 'selected' : '' ?>><?=$this->lang->line('review_negative_lbl')?></option>
									  <option value="positive" <?php echo (isset($_GET['sort']) && strcmp($_GET['sort'], 'positive')==0) ? 'selected' : '' ?>><?=$this->lang->line('review_positive_lbl')?></option>
									</select>
								  </div>
								</form>
							</div>							
						</h3>
					</div>

					<div class="row">
						<?php 
							define('IMG_PATH', base_url().'assets/images/users/');

							foreach ($reviews as $key => $value) {

								if($this->common_model->selectByidParam($value->user_id, 'tbl_users','user_image')!='' && file_exists('assets/images/users/'.$this->common_model->selectByidParam($value->user_id, 'tbl_users','user_image')))
								{
									$user_img=IMG_PATH.$this->common_model->selectByidParam($value->user_id, 'tbl_users','user_image');
								}
								else{
									$user_img=base_url('assets/images/2.png');
								}

								$row_review_img=$this->common_model->selectByids(array('parent_id' => $value->id, 'type' => 'review'), 'tbl_product_images');

						?>
						<div class="col-md-12 details_part_product_img my_review_area">
						  <div class="row">
							<div class="col-md-1" style="padding-right: 0px">
							  <div class="product_img_part"> <a href="" target="_blank"><img src="<?=$user_img?>" alt="" style="border: 2px solid #ddd;border-radius: 6px;width: 50px;height: 50px"></a> </div>
							</div>
							<div class="col-md-8"> <a href="javascript:void(0)" style="font-weight:500;margin-bottom: 0px"><?=($value->user_id==$this->session->userdata('user_id')) ? 'You' : $value->user_name; ?></a>
							  <div style="margin-bottom: 10px"><?=nl2br(stripslashes($value->rating_desc))?></div>

								<div class="tz-gallery">
									<div class="row upload_img_part">
										<?php 
											foreach ($row_review_img as $key => $review_img) {
										?>
										<div class="user_upload_preview">
							                <a class="lightbox" href="<?=base_url('assets/images/review_images/').$review_img->image_file?>">
							                    <img src="<?=base_url('assets/images/review_images/').$review_img->image_file?>" alt="Review image">
							                </a>
							            </div>
							        	<?php } ?>
									</div>
								</div>
								
							</div>
							<div class="col-md-3 text-right">
								<div class="product-rating">
								  	<?php 
		                              for ($x = 0; $x < 5; $x++) { 
		                                if($x < $value->rating){
		                                  ?>
		                                  <i class="fa fa-star"></i>
		                                  <?php  
		                                }
		                                else{
		                                  ?>
		                                  <i class="fa fa-star on-color"></i>
		                                  <?php
		                                }
		                              }
		                            ?>
								  </div>
								<i class="fa fa-clock-o"></i> <?=date('M jS, Y',$value->created_at)?>
							</div>
						  </div>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php 
		          if(!empty($links)){
		        ?>
		        <div class="pagination pb-10">
		          <?php 
		              echo $links;  
		          ?>
		        </div>
		        <?php } ?>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?=base_url('assets/site_assets/js/baguettebox/baguetteBox.min.js')?>"></script>

<script type="text/javascript">
	baguetteBox.run('.tz-gallery');
</script>

<script type="text/javascript">
	$(".reviews_order").change(function (e) {
		$(this).parents("form").submit();
	});
</script>