<?php  
  $this->load->view('site/layout/breadcrumb'); 
?>
<div class="wishlist-table-area mt-20 mb-50">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <?php 
            if(!empty($wishlist))
            {
          ?>
          <div class="wishlist-table table-responsive">

            <table>
              <thead>
                <tr>
                  <th class="product-remove"></th>
                  <th class="product-cart-img"> <span class="nobr">Product Image</span> </th>
                  <th class="product-name"> <span class="nobr">Product Name</span> </th>
                  <th class="product-price"> <span class="nobr"> Price </span> </th>
                  <th class="product-add-to-cart">Add To Cart</th>
                </tr>
              </thead>
              <tbody>
              	<?php 
                  $ci =& get_instance();
                  foreach ($wishlist as $key => $row)
                  {
                    $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $row->featured_image);
                    
                    $img_file=$ci->_create_thumbnail('assets/images/products/',$thumb_img_nm,$row->featured_image,50,50);

                    $is_avail=true;

                    if($ci->get_single_info(array('id' => $row->product_id),'status','tbl_product')==0){
                      $is_avail=false;
                    }

                ?>
                <tr>
                  <td class="product-remove"><a href="javascript:void(0)" class="btn_remove_wishlist" data-id="<?=$row->product_id?>">×</a></td>
                  <td <?=(!$is_avail) ? 'style="opacity: 0.5;"' : ''?> class="product-cart-img"><a href="javascript:void(0)"><img src="<?=base_url().$img_file?>" alt="<?=$row->product_slug?>" style="width: 50px;height: 50px"></a></td>
                  <td class="product-name">
                    <a href="<?php echo site_url('product/'.$row->product_slug); ?>" <?=(!$is_avail) ? 'style="opacity: 0.5;"' : ''?>>
                      <?php
                        if(strlen($row->product_title) > 30){
                          echo strtr(stripslashes($row->product_title), 0, 30).'...';  
                        }else{
                          echo $row->product_title;
                        }
                      ?>
                    </a>
                    <?php 
                      if(!$is_avail){
                        echo '<p style="color: red;background: #FFF;display: inline-block;box-shadow: 0px 5px 10px #ccc;padding: 5px 10px;line-height: initial">'.$this->lang->line('unavailable_lbl').'</p>';
                      }
                    ?>
                  </td>
                  <td <?=(!$is_avail) ? 'style="opacity: 0.5"' : ''?> class="product-price" nowrap="">
                    <span>
                      <?php 
                        if($row->you_save_amt!='0'){
                          ?>
                          <ins><?=CURRENCY_CODE.' '.number_format($row->selling_price, 2)?></ins> 
                          <del><?=CURRENCY_CODE.' '.number_format($row->product_mrp, 2);?></del>
                          <?php
                        }
                        else{
                          ?>
                          <ins><?=CURRENCY_CODE.' '.number_format($row->product_mrp, 2);?></ins>
                          <?php
                          
                        }
                      ?>
                    </span>
                  </td>
                  <td <?=(!$is_avail) ? 'style="opacity: 0.5"' : ''?> class="product-add-to-cart">
                    <a href="javascript:void(0)" class="wishlist-btn btn_cart <?=(!$is_avail) ? 'disabled"' : ''?>" data-id="<?=$row->product_id?>" data-maxunit="<?=$row->max_unit_buy?>"><?=$this->lang->line("add_cart_lbl")?></a>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <?php 
            }else{
            ?>
            <center>
              <img src="<?=base_url('assets/img/empty_wishlist.png')?>">
              <h2 style="font-size: 18px;font-weight: 500;color: #888;"><?=$this->lang->line('empty_wishlist_lbl')?></h2>
              <br/>
              <a href="<?=base_url('/')?>"><img src="<?=base_url('assets/images/continue-shopping-button.png')?>"></a>
            </center>
            <?php
          } ?>
        </div>
      </div>
    </div>
</div>

<script type="text/javascript">
  $(".btn_cart").click(function(e) {
    e.preventDefault();
    var btn = $(this);
    var _id=$(this).data("id");
    var _maxunit=$(this).data("maxunit");

    href = '<?=base_url()?>site/cart_action';

    $.ajax({
      url:href,
      data: {"product_id": _id},
      type:'post',
      success:function(res){
          if(res=='login_now'){
            window.location.href = "<?php echo site_url('login-register'); ?>";
          }
          else{

            var obj = $.parseJSON(res); 

            $("#cartModel .modal-body").html(obj.html_code);
            $("#cartModel").modal("show");

            $('.radio-group .radio_btn').click(function(){
                $(this).parent().find('.radio_btn').removeClass('selected');
                $(this).addClass('selected');
                var val = $(this).attr('data-value');
                $(this).parent().find('input').val(val);
            });

            $("input[name='product_qty']").blur(function(){
              if($(this).val() <= 0){
                $(this).val(1);
              }
              else if($(this).val() > _maxunit){
                alert("You cannot buy more than "+_maxunit+" items in single order !!!");
                $(this).val(_maxunit);
              }
            });
          }
        },
        error : function(res) {
            alert("error");
        }

    });
  });

</script>
