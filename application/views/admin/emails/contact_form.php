<?php 

define('APP_NAME', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_name);
define('APP_LOGO', $this->db->get_where('tbl_settings', array('id' => '1'))->row()->app_logo);

?>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <!--[if !mso]><!-->
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!--<![endif]-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title></title>
  <!--[if !mso]><!-->
  <style type="text/css">
    body, html{
      font-family: 'Verdana' !important;
    }
  </style>
  <!--<![endif]-->
  <!--[if (gte mso 9)|(IE)]>
    <style type="text/css">
        .address-description a {color: #000000 ; text-decoration: none;}
        table {border-collapse: collapse ;}
    </style>
    <![endif]-->
</head>

<body bgcolor="#e1e5e8" style="margin-top:0 ;margin-bottom:0 ;margin-right:0 ;margin-left:0 ;padding-top:0px;padding-bottom:0px;padding-right:0px;padding-left:0px;background-color:#e1e5e8;">
  <!--[if gte mso 9]>
<center>
<table width="600" cellpadding="0" cellspacing="0"><tr><td valign="top">
<![endif]-->
  <center style="width:100%;table-layout:fixed;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#e1e5e8;">
    <div style="max-width:600px;margin-top:0;margin-bottom:0;margin-right:auto;margin-left:auto;">
      <table align="center" cellpadding="0" style="border-spacing:0;color:#333333;margin:0 auto;width:100%;max-width:600px;">
        <tbody>
          <tr>
            <td align="center" class="vervelogoplaceholder" height="143" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;height:143px;vertical-align:middle;" valign="middle"><span class="sg-image"><img alt="App Logo" height="100" src="<?php echo base_url().'assets/images/'.APP_LOGO?>" style="border-width: 0px; width: 100px; height: 100px;" width="100"></a></span></td>
          </tr>
          <!-- Start of Email Body-->
          <tr>
            <td class="one-column" style="padding-top:0;padding-bottom:0;padding-right:0;padding-left:0;background-color:#ffffff;">
              <!--[if gte mso 9]>
                    <center>
                    <table width="80%" cellpadding="20" cellspacing="30"><tr><td valign="top">
                    <![endif]-->
              <table style="border-spacing:0;" width="100%">
                <tbody>
                  <tr>
                    <td class="inner contents center" style="padding-top:15px;padding-bottom:15px;padding-right:30px;padding-left:30px;text-align:left;">
                        
                        <p class="description" style="font-family:'Verdana';margin:0;text-align:left;max-width:100%;color:#a1a8ad;line-height:24px;font-size:15px;margin-bottom:10px;margin-left: auto; margin-right: auto;"><span style="color: rgb(161, 168, 173); font-size: 15px; text-align: center; background-color: rgb(255, 255, 255);"><?=$this->lang->line('about_contact_email_lbl')?>:</span></p>
                        <p class="description" style="font-family:'Verdana';margin:0;text-align:left;max-width:100%;line-height:24px;font-size:15px;margin-bottom:10px;margin-left: auto; margin-right: auto;"><strong><?=$this->lang->line('name_lbl')?>:</strong> <?=$contact_name?></p>
                        <p class="description" style="font-family:'Verdana';margin:0;text-align:left;max-width:100%;line-height:24px;font-size:15px;margin-bottom:10px;margin-left: auto; margin-right: auto;"><strong><?=$this->lang->line('email_lbl')?>:</strong> <?=$contact_email?></p>
                        <p class="description" style="font-family:'Verdana';margin:0;text-align:left;max-width:100%;line-height:24px;font-size:15px;margin-bottom:10px;margin-left: auto; margin-right: auto;"><strong><?=$this->lang->line('subject_title_lbl')?>:</strong> <?=$subject?></p>
                        <p class="description" style="font-family:'Verdana';margin:0;text-align:left;max-width:100%;line-height:24px;font-size:15px;margin-bottom:5px;margin-left: auto; margin-right: auto;"><strong><?=$this->lang->line('message_lbl')?>:</strong> <div><?=$contact_msg?></div></p>
                    </td>
                  </tr>
                </tbody>
              </table>
              <!--[if (gte mso 9)|(IE)]>
                    </td></tr></table>
                    </center>
                    <![endif]-->
            </td>
          </tr>
          <!-- End of Email Body-->
          <!-- whitespace -->
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
  </center>
  <!--[if gte mso 9]>
</td></tr></table>
</center>
<![endif]-->


</body>