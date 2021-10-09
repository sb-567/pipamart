
  <footer>
     <div class="innovatoryFooter-top">
   <div class="container-fluid">
      <div class="block_newsletter">
         <div class="row">
        
          <div class="col-md-5  col-xs-12 col-sm-12 newsletter-form">
         
           <form accept-charset="utf-8" action="" class="mt-20 mb-10" method="get">
         	<div class="input-group">
                <input type="email" class="form-control" placeholder="Enter your email" required>
                 <span class="input-group-btn">
                <button class="btn btn-theme" type="submit">Subscribe</button>
               </span>
            </div>
            
            </form>
            </div>
            <div class="col-md-7  col-xs-12 col-sm-12 newsletter-form">
                 <div class="title-text mt-30 text-right mr-10">
                  <p class="h3">"Lets be the reason for someone else's Happiness"</p>
                 
               </div>
            </div>
            <div class="clearfix"></div>
         </div>
      </div>
   </div>
</div>
    <div class="footer-container white-bg"> 
    <div class="footer-top-area ptb-20 pb-90">
        <div class="container-fluid">
          <div class="row"> 
            <div class="col-md-3 col-sm-6">
              <div class="single-footer"> 
                <!--<div class="footer-logo"> <a href="<?=base_url('/')?>"><img src="<?=base_url('assets/images/').APP_LOGO_2?>" alt=""></a> -->
                <!--</div>-->
                <div class="footer-content">
                  <p>
                    <?php

                      $about_content=strip_tags($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->about_content);
                      if(strlen($about_content) > 150){
                        echo substr($about_content,0,150).'...';
                      }
                      else{
                        echo $about_content;
                      }
                    ?>
                  </p>
                  
                    <!--<ul class="socil-icon mb-40">
                  <?php 
                    if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->facebook_url!='')
                    {
                  ?>
                    <li><a href="<?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->facebook_url?>" data-toggle="tooltip" title="Facebook" target="_blank"><i class="ion-social-facebook"></i></a></li>
                  <?php } ?>
                  <?php 
                    if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->twitter_url!='')
                    {
                  ?>
                    <li><a href="<?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->twitter_url?>" data-toggle="tooltip" title="Twitter" target="_blank"><i class="ion-social-twitter"></i></a></li>
                  <?php } ?>

                  <?php 
                    if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->instagram_url!='')
                    {
                  ?>
                    <li><a href="<?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->instagram_url?>" data-toggle="tooltip" title="Instagram" target="_blank"><i class="ion-social-instagram"></i></a></li>
                  <?php } ?>

                  <?php 
                    if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->youtube_url!='')
                    {
                  ?>
                    <li><a href="<?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->youtube_url?>" data-toggle="tooltip" title="Youtube" target="_blank"><i class="ion-social-youtube"></i></a></li>
                  <?php } ?>
                </ul>-->
                  
                  
         
                </div>
              </div>
            </div>
            <div class="col-md-2 col-sm-6">
              <div class="single-footer brd1 mt-10">
                <div class="footer-title">
                  <h3><?=$this->lang->line('about_section_lbl')?></h3>
                </div>
                <ul class="footer-info">
                  <?php 
                    if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->about_status=='true')
                    {
                  ?>
                  <li><i class="fa fa-angle-double-right"></i><a href="<?php echo site_url('about-us'); ?>"><?=$this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->about_page_title?></a></li>
                  <?php } ?>
                  <li><i class="fa fa-angle-double-right"></i><a href="<?php echo site_url('our-team'); ?>">Our Team</a></li>
                  
                   
                  <!--<li><i class="fa fa-angle-double-right"></i><a href="<?php echo site_url('privacy-policy'); ?>">Privacy Policy</a></li>-->
                  <li><i class="fa fa-angle-double-right"></i><a href="<?php echo site_url('career'); ?>">Career </a></li>
                 
                  
                  <li><i class="fa fa-angle-double-right"></i><a href="<?php echo site_url('contact-us'); ?>">Contact Us</a></li>
                </ul>
              </div>
            </div>
            
            <div class="col-md-2 col-sm-6">
              <div class="single-footer brd1 mt-10">
                <div class="footer-title">
                  <h3><?=$this->lang->line('info_section_lbl')?></h3>
                </div>
                <ul class="footer-info">
                   <li><i class="fa fa-angle-double-right"></i><a href="<?php echo site_url('terms-and-conditions'); ?>">Terms & Condition</a></li>
                   
                   <?php 
                    if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->privacy_page_status=='true')
                    {
                  ?>
                  <li><i class="fa fa-angle-double-right"></i><a href="<?php echo site_url('privacy-policy'); ?>">Privacy Policy</a></li>
                  <?php } ?>
                 
                  <?php 
                    if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->refund_return_policy_status=='true')
                    {
                  ?>
                  <li><i class="fa fa-angle-double-right"></i><a href="<?php echo site_url('refund-policy'); ?>">Refund Policy</a></li>
                  <?php } ?>
                  <?php 
                    if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->cancellation_page_status=='true')
                    {
                  ?>
                    <li><i class="fa fa-angle-double-right"></i><a href="<?php echo site_url('cancellation-policy'); ?>">Cancellation Policy</a></li>
                  <?php } ?>

                  <li><i class="fa fa-angle-double-right"></i><a href="<?php echo site_url('shipping-delivery'); ?>">Shipping Delivery</a></li>
                  
                </ul>
              </div>
            </div>
            
            <div class="col-md-2 col-sm-6">
              <div class="single-footer brd1 mt-10">
                <div class="footer-title">
                  <h3><?=$this->lang->line('social_section_lbl')?></h3>
                </div>
                <ul class="footer-info">
                  <li><i class="fa fa-angle-double-right"></i><a href="<?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->facebook_url?>" target="_blank"> Facebook</a></li>
                  <li><i class="fa fa-angle-double-right"></i><a href="<?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->youtube_url?>" target="_blank"> <?=$this->lang->line('youtube_lbl')?></a></li>
                  <li><i class="fa fa-angle-double-right"></i><a href="<?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->instagram_url?>"  target="_blank">Instagram</a></li>
                  <li><i class="fa fa-angle-double-right"></i><a href="<?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->twitter_url?>"  target="_blank">Twitter</a></li>
                  <li><i class="fa fa-angle-double-right"></i><a href="<?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->linkedin_url?>"  target="_blank">Linkedin</a></li>
                  <li><i class="fa fa-angle-double-right"></i><a href="<?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->blog_url?>"  target="_blank">Blog</a></li>
                  
                </ul>
              </div>
            </div>
            
            
            <div class="col-md-3 col-sm-6">
              <div class="single-footer mt-10 brd1">
                <?php 
                  if($this->db->get_where('tbl_settings', array('id' => '1'))->row()->facebook_url!='' || $this->db->get_where('tbl_settings', array('id' => '1'))->row()->twitter_url!='' || $this->db->get_where('tbl_settings', array('id' => '1'))->row()->instagram_url!='' || $this->db->get_where('tbl_settings', array('id' => '1'))->row()->youtube_url!='')
                  {
                ?>
                <div class="footer-title">
                  <h3>Contact Us</h3>
                </div>
    
           <div class="contact-address  mb-30">
               <p>Pipa Mart<br>Pipa Farms LLP,</p>
	          <ul>
	            
	            <li><i class="fa fa-map"></i> <?=$this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->address?></li>
	            <li><i class="fa fa-phone"></i> <?=$this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->contact_number?></li>
	            <li><i class="fa fa-envelope-o"></i> <?=$this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->contact_email?></li>
	          </ul>
	        </div>  
                    <?php } ?>
               </div>
            </div>
            
             <!-- <div class="col-md-2 col-sm-6">
              <div class="single-footer">
             
                   <p><img src="<?php echo base_url();?>assets/images/fssat.png" style="width:100px"><br/><b>21940050000082</b></p>
            
               </div>
            </div>-->
            
            
          </div>
        </div>
      </div>
      
      
      
    </div>
    
    
  <section class="disoff">
    <div class="container-fluid">
        <div class="row">
                <div class="col-md-12">
                    <div class="lbl footer-bottom-area">
                    <marquee>
                        <ul>
                            <li><?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->line_one?></li>
                            <li><?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->line_two?></li>
                            <li><?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->line_three?></li>
                            <li><?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->line_four?></li>
                           
                            <!--<li>Check our Blog and Social Media Pages directly from our website</li>-->
                            
                        </ul>
                    </marquee>
            
                </div>
                </div>
               
            
                
            
            
        </div>
    </div>
</section>


    <!-- Product Quick Preview -->
    <div id="productQuickView" class="modal fade" role="dialog" style="z-index: 9999999">
      <div class="modal-dialog"> 
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body">
          </div>
        </div>
      </div>
    </div>

  </footer>
    
    <style type="text/css">
      .radio-group{
          position: relative;
      }
      .radio_btn{
          display: inline-block;
          width: auto;
          height: auto;
          background-color: #eee;
          border: 2px solid #ddd;
          cursor: pointer;
          margin: 2px 1px;
          text-align: center;
          padding: 5px 15px;
      }
      .radio_btn.selected{
          border-color: #ff5252;
      }
    </style>
    
    <div class="flt"><a href="https://api.whatsapp.com/send?phone=<?=$this->db->get_where('tbl_settings', array('id' => '1'))->row()->whatsapp_url?>&text=Hello%20Pipamart" target="_blank"><i class="fa fa-whatsapp"></i></a> </div>

    <div id="cartModal" class="modal fade" role="dialog" style="z-index: 9999999">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
              
            </div>
        </div>
      </div>
    </div>
  <?php
    if($this->session->flashdata('cart_msg')) {
      $message = $this->session->flashdata('cart_msg');
      ?>
        <script type="text/javascript">
          var _msg='<?=$message['message']?>';
          var _class='<?=$message['class']?>';

          $('.notifyjs-corner').empty();
          $.notify(
            _msg, 
            { position:"top right",className: _class }
          ); 
        </script>
      <?php
    }
  ?>

   <?php 
      if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->libraries_load_from=='local'){
        ?>

        <script src="<?=base_url('assets/site_assets/js/bootstrap.min.js')?>"></script>
        
        <script type="text/javascript" src="<?=base_url('assets/site_assets/js/jquery.scrollUp.min.js')?>"></script>
        
        <script type="text/javascript" src="<?=base_url('assets/site_assets/js/jquery.meanmenu.min.js')?>"></script>
        
        <script type="text/javascript" src="<?=base_url('assets/site_assets/js/owl.carousel.min.js')?>"></script>

      <?php }else if($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->libraries_load_from=='cdn'){ ?>
        <!-- Include CDN Files -->

        <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/scrollup/2.4.1/jquery.scrollUp.min.js"></script>
        
        <script type="text/javascript" src="<?=base_url('assets/site_assets/js/jquery.meanmenu.min.js')?>"></script>
        
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.2.1/owl.carousel.min.js"></script>
      <?php } ?>

      <?php 
    // for dynamic js files
      echo put_cdn_footers();
      echo put_footers();
      ?>

      <script type="text/javascript" src="<?=base_url('assets/site_assets/js/jquery-ui.min.js')?>"></script>

      <script type="text/javascript" src="<?=base_url('assets/sweetalert/sweetalert.min.js')?>"></script>

      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

      <script type="text/javascript" src="<?=base_url('assets/site_assets/js/plugins.js')?>"></script>

      <script type="text/javascript" src="<?=base_url('assets/site_assets/js/custom_jquery.js')?>"></script>

      <script src="<?=base_url('assets/site_assets/js/cust_javascript.js')?>"></script>
      
      <script>
          $('li.dropdown').on('click', function() {
    var $el = $(this);
    if ($el.hasClass('open')) {
        var $a = $el.children('a.dropdown-toggle');
        if ($a.length && $a.attr('href')) {
            location.href = $a.attr('href');
        }
    }
});
      </script>

      <?=html_entity_decode($this->db->get_where('tbl_web_settings', array('id' => '1'))->row()->footer_code)?>
</body>
</html>