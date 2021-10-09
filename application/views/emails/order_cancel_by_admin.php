<?php 

  define('APP_NAME', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_name);
  define('APP_LOGO', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_logo);

  define('APP_CURRENCY', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_currency_code);
  define('CURRENCY_CODE', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_currency_html_code);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "https://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<style type="text/css">
  body, td, div, p, a, input {
    font-family: arial, sans-serif;
  }
  </style>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <style>
  body, td {
    font-size: 13px;
    padding:0;
    margin:0;
  }
  a:link, a:active {
    color: #1155CC;
    text-decoration: none
  }
  a:hover {
    text-decoration: underline;
    cursor: pointer
  }
  a:visited {
    color: ##6611CC
  }
  img {
    border: 0px
  }
  pre {
    white-space: pre;
    white-space: -moz-pre-wrap;
    white-space: -o-pre-wrap;
    white-space: pre-wrap;
    word-wrap: break-word;
    max-width: 800px;
    overflow: auto;
  }
  .logo {
    left: -7px;
    position: relative;
  }
</style>
<body>
<div class="bodycontainer">
  <div class="maincontent">
    <table width=100% cellpadding=0 cellspacing=0 border=0 class="message">
        <td colspan=2><table width=100% cellpadding=12 cellspacing=0 border=0>
            <tr>
              <td><div style="overflow: hidden;">
                <font size=-1>
                  <img src="<?php echo base_url().'assets/images/'.APP_LOGO?>" width="1" height="1"> <u></u>
                  <div bgcolor="#ececec">
                    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                      <tbody>
                        <tr>
                          <td bgcolor="#ececec"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-family:Arial,Helvetica,sans-serif;max-width:620px">
                              <tbody>
                                <tr>
                                  <td width="100%" bgcolor="#ffffff">
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="max-width:600px">
                                      <tbody>
                                        <tr>
                                          <td>
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                              <tbody>
                                                <tr>
                                                  <td align="center" style="font-size:20px;font-family:Arial,Helvetica,sans-serif;color:#000000;padding:40px 30px 0 30px">
                                                    <div style="color:#8e8e8e;font-size:16px;margin-bottom:12px"> <?=$this->lang->line('hi_lbl')?> <?=$users_name?>, </div>
                                                    <?=$this->lang->line('self_cancelled_lbl')?>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                                <tr>
                                  <td width="100%" bgcolor="#ffffff" style="padding:0 10px"><table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="max-width:600px;margin-bottom:18px">
                                      <tbody>
                                        <tr>
                                          <td bgcolor="#ffffff"><table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                              <tbody>
                                                <tr> </tr>
                                                <tr>
                                                  <td align="center" style="font:13.5px/165% Arial;color:#8e8e8e;padding:20px">
                                                    <?=$status_desc?>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table></td>
                                        </tr>
                                        <tr>
                                          <td bgcolor="#ffffff" style="border-top:1px solid #eaeaea;border-bottom:1px solid #eaeaea;padding:12px 20px;font:12px/150% Arial;color:#676767"><table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                                              <tbody>
                                                <tr>
                                                  <td style="font:12px/1.5 Arial;color:#676767"><span style="color:#707070"><?=$this->lang->line('ord_id_lbl')?>: </span><a href="" style="color:#ff2241;outline:none;text-decoration:none;font-weight:bold" target="_blank"><?=$order_unique_id?></a></td>

                                                  <td style="font:12px/1.5 Arial;color:#676767" align="right"><span style="color:#707070"><?=$this->lang->line('ord_on_lbl')?>: </span><span style="color:#000000;display:inline-block;font-weight:bold"><?=$order_date?></span>
                                                    <br/>

                                                    <?php 
                                                      if($order_status < 4){
                                                        ?>
                                                        <span style="color:#707070"><?=$this->lang->line('estimated_delivery_lbl')?>: </span><span style="color:#000000;display:inline-block;font-weight:bold"><?=$delivery_date?></span>
                                                        <?php
                                                      }
                                                      else if($order_status==4){
                                                        ?>
                                                        <span style="color:#707070"><?=$this->lang->line('delivery_on_lbl')?>: </span><span style="color:#000000;display:inline-block;font-weight:bold"><?=date('d M, Y')?></span>
                                                        <?php
                                                      }
                                                    ?>

                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table></td>
                                        </tr>
                                        <tr>
                                          <td bgcolor="#ffffff" style="font:13.5px/150% Arial;color:#000000;padding:20px 10px"><table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                              <tbody>
                                                <tr>
                                                  <td><table width="100" class="m_-3575512029768076440table2Col" cellpadding="0" cellspacing="0" border="0" align="left" style="width: 100%">
                                                      <tbody>
                                                        <tr>
                                                          <td style="padding:20px 10px"><table width="100%" align="left" cellpadding="0" cellspacing="0" border="0">
                                                              <tbody>
                                                                <tr>
                                                                  <td valign="top" width="40"><img src="<?php echo base_url('assets/images/location_pin.png')?>" width="32" height="32" alt=""></td>
                                                                  <td style="font:13.5px/150% Arial;color:#000000"><span style="color:#909090"><?=$this->lang->line('delivery_address_lbl')?></span>
                                                                    <br>
                                                                    <?=$delivery_address?>
                                                                    </td>
                                                                </tr>
                                                              </tbody>
                                                            </table></td>
                                                        </tr>
                                                      </tbody>
                                                    </table>
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                      <tbody>
                                                        <tr>
                                                          <td style="padding:20px 10px 0px"><table width="100%" align="left" cellpadding="0" cellspacing="0" border="0">
                                                              <tbody>
                                                                <tr>
                                                                  <td valign="top" width="40" style="padding:3px 0 0 0"><img src="<?php echo base_url('assets/images/card-in-use.png')?>" width="32" height="32" alt="" style="margin-left:5px"></td>
                                                                  <td style="font:13.5px/150% Arial;color:#000000" valign="top"><span style="color:#909090"><?=$this->lang->line('payment_summary_lbl')?></span></td>
                                                                </tr>
                                                              </tbody>
                                                            </table>
                                                            <table width="100%" align="left" cellpadding="0" cellspacing="0" border="0">
                                                              <tbody>
                                                                <tr>
                                                                  <td valign="top" width="40" style="padding:4px 0"></td>
                                                                  <td style="padding:4px 0;font:13.5px/150% Arial;color:#000000"><span style="color:#909090"><?=$this->lang->line('total_lbl')?></span></td>
                                                                  <td style="padding:4px 0;font:13.5px/150% Arial;color:#000000" align="right"><span style="color:#000000"><?=CURRENCY_CODE.' '.number_format($total_amt, 2)?></span></td>
                                                                </tr>
                                                                <?php 
                                                                  if($cancel_order_amt!=''){
                                                                    ?>
                                                                    <tr>
                                                                      <td valign="top" width="40" style="padding:4px 0"></td>
                                                                      <td style="padding:4px 0;font:13.5px/150% Arial;color:#000000"><span style="color:#909090"><?=$this->lang->line('cancel_ord_amt_lbl')?></span></td>
                                                                      <td style="padding:4px 0;font:13.5px/150% Arial;color:#000000" align="right"><span style="color:#000000">- <?=CURRENCY_CODE.' '.number_format($cancel_order_amt, 2)?></span></td>
                                                                    </tr>
                                                                    <?php
                                                                  }
                                                                ?>
                                                                <tr>
                                                                  <td valign="top" width="40" style="padding:4px 0"></td>
                                                                  <td style="padding:4px 0;font:13.5px/150% Arial;color:#000000"><span style="color:#909090"><?=$this->lang->line('discount_amt_lbl')?></span></td>
                                                                  <td style="padding:4px 0;font:13.5px/150% Arial;color:#000000" align="right"><span style="color:#000000">- <?=CURRENCY_CODE.' '.number_format($discount_amt, 2)?></span></td>
                                                                </tr>
                                                                <tr>
                                                                  <td valign="top" width="40" style="padding:4px 0"></td>
                                                                  <td style="padding:4px 0;font:13.5px/150% Arial;color:#000000"><span style="color:#909090"><?=$this->lang->line('delivery_charge_lbl')?></span></td>
                                                                  <td style="padding:4px 0;font:13.5px/150% Arial;color:#000000" align="right"><span style="color:#000000"><?=($delivery_charge) ? '+ '.CURRENCY_CODE.' '.number_format($delivery_charge, 2) : $this->lang->line('free_lbl')?></span></td>
                                                                </tr>
                                                                <tr>
                                                                  <td colspan="3" style="border-top:1px solid #eaeaea;padding:17px 0px 0px;font:13.5px/150% Arial;color:#676767"><table width="100%" align="left" cellpadding="0" cellspacing="0" border="0">
                                                                      <tbody>
                                                                        <tr>
                                                                          <td valign="top" width="40" style="padding:3px 0 0 0"></td>
                                                                          <td style="font:13.5px/150% Arial;color:#000000"><span style="color:#909090"><?=$this->lang->line('pay_amt_lbl')?></span></td>
                                                                          <td style="font:13.5px/150% Arial;color:#000000" align="right"><span style="color:#000000;font-weight:bold"><?=CURRENCY_CODE.' '.number_format($payable_amt, 2)?></span></td>
                                                                        </tr>
                                                                      </tbody>
                                                                    </table></td>
                                                                </tr>
                                                              </tbody>
                                                            </table></td>
                                                        </tr>
                                                      </tbody>
                                                    </table>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="max-width:600px;margin-bottom:18px;border-top:5px solid #f0f0f0">
                                      <tbody>
                                        <tr>
                                          <td bgcolor="#ffffff" style="border-radius:2px;padding:20px 10px"><table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                              <tbody>
                                                <?php 
                                                  foreach ($products as $key => $value) {
                                                ?>
                                                <tr>
                                                  <td width="100%" align="center"><table width="280" class="m_-3575512029768076440tableCol" cellpadding="0" cellspacing="0" border="0" align="left">
                                                      <tbody>
                                                        <tr>
                                                          <td align="center" style="padding:20px 10px"><div style="width:150px"> <img src="<?=$value['product_img']?>" width="100%" style="border:none;width: 100%"> </div></td>
                                                        </tr>
                                                      </tbody>
                                                    </table>
                                                    <table width="280" class="m_-3575512029768076440tableCol" cellpadding="0" cellspacing="0" border="0" align="left">
                                                      <tbody>
                                                        <tr>
                                                          <td align="center" style="font:13.2px/165% Arial;color:#000000;padding:15px 10px;font-weight: 600">
                                                            <?=$value['product_title']?>
                                                          </td>
                                                        </tr>
                                                        <tr>
                                                          <td bgcolor="#ffffff" style="padding:10px 10px 0 10px;font:13.5px/150% Arial;color:#909090"><table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                                                              <tbody>
                                                                <tr>
                                                                  <td width="50%" align="left" style="padding:10px 0;border-bottom:1px solid #ebebeb"><?=$this->lang->line('price_lbl')?></td>
                                                                  <td width="50%" align="right" style="color:#000000;padding:10 0px;border-bottom:1px solid #ebebeb"><?=CURRENCY_CODE.' '.number_format($value['product_price'], 2)?></td>
                                                                </tr>
                                                                <?php 
                                                                  if($value['product_size']!='' AND $value['product_size']!='0'){
                                                                ?>
                                                                <tr>
                                                                  <td width="50%" align="left" style="padding:10px 0;border-bottom:1px solid #ebebeb"><?=$this->lang->line('size_lbl')?></td>
                                                                  <td align="right" style="color:#000000;padding:10px 0;border-bottom:1px solid #ebebeb"><?=$value['product_size']?></td>
                                                                </tr>
                                                                <?php } ?>

                                                                <?php 
                                                                  if($value['product_color']!=''){
                                                                ?>
                                                                <tr>
                                                                  <td width="50%" align="left" style="padding:10px 0;border-bottom:1px solid #ebebeb"><?=$this->lang->line('colour_lbl')?></td>
                                                                  <td align="right" style="color:#000000;padding:10px 0;border-bottom:1px solid #ebebeb"><?=$value['product_color']?></td>
                                                                </tr>
                                                                <?php } ?>
                                                                <tr>
                                                                  <td width="50%" align="left" style="padding:10px 0;border-bottom:1px solid #ebebeb"><?=$this->lang->line('qty_lbl')?></td>
                                                                  <td align="right" style="color:#000000;padding:10px 0;border-bottom:1px solid #ebebeb"><?=$value['product_qty']?></td>
                                                                </tr>
                                                                <tr>
                                                                  <td></td>
                                                                </tr>
                                                              </tbody>
                                                            </table></td>
                                                        </tr>
                                                      </tbody>
                                                    </table></td>
                                                </tr>
                                              <?php } ?>
                                              </tbody>
                                            </table></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table></td>
                        </tr>
                        <tr></tr>
                        <tr>
                          <td height="40">
                            <p style="line-height: 40px; padding: 0 0 0 0; margin: 0 0 0 0;">&nbsp;</p>

                            <p>&nbsp;</p>
                          </td>
                        </tr>
                        <!-- Social Media -->
                        <tr>
                          <td align="center" style="padding-bottom:0;padding-right:0;padding-left:0;padding-top:0px;" valign="middle">
                            <!-- For Facecook -->
                            <?php 
                              if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->facebook_url!='')
                              {
                            ?>
                            <span class="sg-image"><a href="<?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->facebook_url?>" target="_blank"><img alt="Facebook" height="18" src="<?php echo base_url().'assets/images/social/facebook.png' ?>" style="border-width: 0px; margin-right: 21px; margin-left: 21px; width: auto; height: auto;" width="8"></a></span>
                            <?php } ?>

                            <!-- For Twitter -->
                            <?php 
                              if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->twitter_url!='')
                              {
                            ?>

                            <!--[if gte mso 9]>&nbsp;&nbsp;&nbsp;<![endif]--><span class="sg-image"><a href="<?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->twitter_url?>" target="_blank"><img alt="Twitter" height="18" src="<?php echo base_url().'assets/images/social/twitter.png' ?>" style="border-width: 0px; margin-right: 16px; margin-left: 16px; width: auto; height: auto;" width="23"></a></span>
                            <?php } ?>

                            <!-- For Instagram -->
                            <?php 
                              if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->instagram_url!='')
                              {
                            ?>
                            <!--[if gte mso 9]>&nbsp;&nbsp;&nbsp;&nbsp;<![endif]--><span class="sg-image"><a href="<?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->instagram_url?>" target="_blank"><img alt="Instagram" height="18" src="<?php echo base_url().'assets/images/social/instagram.png' ?>" style="border-width: 0px; margin-right: 16px; margin-left: 16px; width: auto; height: auto;" width="18"></a></span>
                            <?php } ?>

                            <!-- For YouTube -->
                            <?php 
                              if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->youtube_url!='')
                              {
                            ?>
                            <!--[if gte mso 9]>&nbsp;&nbsp;&nbsp;&nbsp;<![endif]--><span class="sg-image"><a href="<?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->youtube_url?>" target="_blank"><img alt="Youtube" height="18" src="<?php echo base_url().'assets/images/social/youtube.png' ?>" style="border-width: 0px; margin-right: 16px; margin-left: 16px; width: auto; height: auto;" width="18"></a></span>
                            <?php } ?>
                          </td>
                        </tr>
                        <!-- whitespace -->
                        <tr>
                          <td>
                            <p style="line-height: 20px;padding:0 0 0 0;margin:0 0 0 0;">&nbsp;</p>
                          </td>
                        </tr>
                        <!-- Footer -->
                        <tr>
                          <td style="padding-top:0;padding-bottom:0;padding-right:30px;padding-left:30px;text-align:center;margin-right:auto;margin-left:auto;">
                            <center>
                              <p style="margin:0;text-align:center;margin-right:auto;margin-left:auto;padding-top:10px;padding-bottom:0px;font-size:15px;color:#a1a8ad;line-height:23px;">© <?=APP_NAME?></p>
                            </center>
                          </td>
                        </tr>
                        <!-- whitespace -->
                        <tr>
                          <td height="40">
                            <p style="line-height: 40px; padding: 0 0 0 0; margin: 0 0 0 0;">&nbsp;</p>
                            <p>&nbsp;</p>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    </div>
                  </font>
              </div>
          </table>
    </table>    
  </div>
</div>
</body>
