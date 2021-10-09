<?php 
  
  $this->load->view('site/layout/breadcrumb'); 

  $ci =& get_instance();

  $total_cart_amt=$delivery_charge=0;

?>
<div class="shopping-cart-area mt-20">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <?php 
          $is_items=false;
          if(!empty($my_cart))
          {
            $is_items=true;
        ?>
        <form class="shop-form cartUpdate" method="post" action="<?=site_url('site/update_cart')?>">

          <input type="hidden" name="cart_id" value="">
          <input type="hidden" name="product_qty" value="">

          <div class="wishlist-table table-responsive">
            <table>
              <thead>
                <tr>
                  <th class="product-remove"></th>
                  <th class="product-cart-img"> <span class="nobr"> <?=$this->lang->line('item_img_lbl')?> </span> </th>
                  <th class="product-name"> <span class="nobr"> <?=$this->lang->line('item_title_lbl')?> </span> </th>
                  <th class="product-quantity"> <span class="nobr"><?=$this->lang->line('item_qty_lbl')?> </span> </th>
                  <th class="product-price"> <span class="nobr"> <?=$this->lang->line('item_price_lbl')?> </span> </th>
                  <th class="product-total-price"> <span class="nobr"> <?=$this->lang->line('total_price_lbl')?> </span> </th>
                </tr>
              </thead>
              <tbody>
                <?php 

                  foreach ($my_cart as $key => $value) {
                    
                    $thumb_img_nm = preg_replace('/\\.[^.\\s]{3,4}$/', '', $value->featured_image);
                    
                    $img_file=$ci->_create_thumbnail('assets/images/products/',$thumb_img_nm,$value->featured_image,50,50);

                    $is_avail=true;

                    if($ci->get_single_info(array('id' => $value->product_id),'status','tbl_product')==0){
                      $is_avail=false;
                    }

                ?>
                <tr>
                  <td class="product-remove"><a href="<?php echo site_url('remove-to-cart/'.$value->id); ?>" class="btn_remove_cart">×</a></td>
                  
                  <td <?=(!$is_avail) ? 'style="opacity: 0.5;"' : ''?> class="product-cart-img">
                    <a href="javascript:void(0)"><img src="<?=base_url().$img_file?>" alt="" style="width: 50px;height: 50px"></a>
                    
                  </td>
                  <td class="product-name">
                    <a href="<?=(!$is_avail) ? 'javascript:void(0)' : site_url('product/'.$ci->get_single_info(array('id' => $value->product_id),'product_slug','tbl_product'));?>" <?=(!$is_avail) ? 'style="opacity: 0.5;"' : ''?>>                      
                      <?php 
                        if(strlen($value->product_title) > 30){
                          echo substr(stripslashes($value->product_title), 0, 30).'...';  
                        }else{
                          echo $value->product_title;
                        }
                      ?>
                    </a>
                    <?php 
                      if(!$is_avail){
                        echo '<p style="color: red;background: #FFF;display: inline-block;box-shadow: 0px 5px 10px #ccc;padding: 5px 10px;line-height: initial">'.$this->lang->line('unavailable_lbl').'</p>';
                      }
                    ?>
                  </td>
                  <td <?=(!$is_avail) ? 'style="opacity: 0.5"' : ''?> class="product-quantity">
                    <input type="hidden" name="crt_id" value="<?=$value->id?>">
                    <select class="product_qty" <?=(!$is_avail) ? 'disabled="disabled"' : ''?>>
                      <?php 
                        for ($i=1; $i <= $value->max_unit_buy; $i++) { 
                      ?>
                      <option value="<?=$i?>" <?php if($i==$value->product_qty){ echo 'selected';} ?>><?=$i?></option>
                      <?php } ?>
                    </select>
                  </td>
                  <td <?=(!$is_avail) ? 'style="opacity: 0.5"' : ''?> class="product-price">
                    <span>

                      <?php 

                        $actual_price='';

                        if($value->you_save_amt!='0'){
                          ?>
                          <ins><?=CURRENCY_CODE.' '.number_format($actual_price=($value->selling_price * $value->product_qty), 2)?></ins>
                          &nbsp;
                          <del><?=CURRENCY_CODE.' '.number_format(($value->product_mrp * $value->product_qty), 2);?></del>
                          <?php
                        }
                        else{
                          ?>
                          <ins><?=CURRENCY_CODE.' '.number_format($actual_price=($value->product_mrp * $value->product_qty), 2);?></ins>
                          <?php
                          
                        }
                      ?>
                    </span>
                  </td>
                  <td <?=(!$is_avail) ? 'style="opacity: 0.5"' : ''?> class="product-total-price"><span><?=CURRENCY_CODE.' '.number_format($actual_price, 2)?></span></td>
                </tr>
                <?php
                    $total_cart_amt+=$actual_price;
                    $delivery_charge+=$value->delivery_charge;
                  }
                  $total_cart_amt+=$delivery_charge;
                ?>
              </tbody>
            </table>
          </div>
        </form>
        <?php 
          }else{
          ?>
          <center style="margin-bottom: 50px;">
            <img src="<?=base_url('assets/img/empty_cart.png')?>">
            <h2 style="font-size: 18px;font-weight: 500;color: #888;"><?=$this->lang->line('empty_cart_lbl')?></h2>
            <br/>
            <a href="<?=base_url('/')?>"><img src="<?=base_url('assets/images/continue-shopping-button.png')?>"></a>
          </center>
          <?php
        } ?>
      </div>
    </div>
  </div>
  <?php 
    if($is_items)
    {
  ?>
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-sm-6">
      </div>
      <div class="col-md-6 col-sm-6">
        <div class="shopping-cart-total">
          <h2><?=$this->lang->line('total_price_lbl')?></h2>
          <div class="shop-table table-responsive">
            <table>
              <tbody>
                <tr class="cart-subtotal">
                  <td data-title="<?=$this->lang->line('price_lbl')?>"><span><?=CURRENCY_CODE.' '.number_format(($total_cart_amt-$delivery_charge), 2)?></span></td>
                </tr>
                <tr class="shipping">
                  <td data-title="<?=$this->lang->line('delivery_charge_lbl')?>"><span><?=($delivery_charge!=0)?'+ '.CURRENCY_CODE.number_format($delivery_charge, 2):$this->lang->line('free_lbl');?></span></td>
                </tr>
                <tr class="order-total">
                  <td data-title="<?=$this->lang->line('payable_amt_lbl')?>"><span><strong><span><?=CURRENCY_CODE.' '.number_format($total_cart_amt, 2)?></strong></span></td>
                </tr>
              </tbody>
            </table>
          </div>
          <h4 class="text-center msg_2" style="font-weight: 500;color: green;margin-bottom: 15px;"></h4>
          <div class="proceed-to-checkout">

            <?php
              echo form_open('checkout', ['id' => 'frmUsers','method' => 'GET']);
              ?>
              <button type="submit" class="checkout-button"><?=$this->lang->line('proceed_checkout_btn')?></button>
              <?php
              echo form_close();
            ?>  
        </div>
      </div>
    </div>
  </div>
  <?php } ?>
</div>

<script type="text/javascript">

  $(".product_qty").change(function(e){
    $("input[name='cart_id']").val($(this).prev("input").val());
    $("input[name='product_qty']").val($(this).val());
    $(this).parents(".cartUpdate").submit();
  });

</script>