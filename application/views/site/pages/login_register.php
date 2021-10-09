<?php 
  	$this->load->view('site/layout/breadcrumb');

    if($this->session->flashdata('response_msg')) {
      $message = $this->session->flashdata('response_msg');
    }
    else{
      $message='';
    }
?>

<style type="text/css">
  .social_login{
  	text-align: center;
  	display: inline-block;
  	margin-bottom: 40px;
  	width: 100%;
  }
  .social_login img{
  	width: 220px;
  	height: auto;
  	margin:10px 0;
  }
  .social_login .btn_social{
  	filter: grayscale(0%);   
  	transition: all linear 0.3s;
  }
  .social_login .btn_social:hover{
  	filter: grayscale(50%);
  	transition: all linear 0.3s;
  }
</style>

<section class="my-account-area mt-20 mb-20">
<div class="container">
  <div class="row">
    <div class="col-md-6 col-sm-6">
      <div class="customer-login-register">
        <div class="form-login-title">
          <h2><?=$this->lang->line('login_lbl')?></h2>
        </div>
        <div class="login-form">
          <form action="<?php echo site_url('site/login'); ?>" id="login_form" method="post">
          	<input type="hidden" name="preview_url" value="<?php if(isset($_SERVER['HTTP_REFERER']) && $this->session->userdata('single_pre_url')==''){ echo str_replace(base_url().'site/register','',$_SERVER['HTTP_REFERER']);}else { echo $this->session->userdata('single_pre_url'); $this->session->unset_userdata('single_pre_url'); }?>">

            <div class="wizard-form-field">
              <div class="wizard-form-input has-float-label">
                <input type="email" name="email" value="" autocomplete="off" placeholder="<?=$this->lang->line('email_place_lbl')?>">
                <label><?=$this->lang->line('email_place_lbl')?></label>
                <p class="err"><i class="fa fa-exclamation-circle"></i> <span><?=$this->lang->line('email_require_lbl')?></span></p>
              </div>

              <div class="wizard-form-input has-float-label">
                <input type="password" name="password" value="" autocomplete="off" placeholder="<?=$this->lang->line('password_lbl')?>">
                <label><?=$this->lang->line('password_lbl')?></label>
                <p class="err"><i class="fa fa-exclamation-circle"></i> <span><?=$this->lang->line('password_require_lbl')?></span></p>
              </div>
            </div>
            <div class="login-submit">
              <div class="clearfix"></div>
              <button type="submit" class="form-button"><?=$this->lang->line('login_btn')?></button>
            </div>
            <div class="lost-password"> <a href="" class="lost_password" data-toggle="modal" data-target="#lostPassword" data-backdrop="static" data-keyboard="false"><?=$this->lang->line('lost_password_lbl')?></a> </div>
          </form>
        </div>

        <?php 

          if($google_login_btn=='true' OR $facebook_login_btn=='true'){
        ?>

        <div class="social_login">
          <h2 style="font-weight: 600">OR</h2>
          <?php 
            if($google_login_btn=='true'){
          ?>
    		  <div class="col-md-6 col-sm-6 col-xs-12">		  
    			 <a href="<?=site_url('redirectGoogle')?>" class="btn_social"><img src="<?=base_url('assets/img/google_login_btn.png')?>"/></a>
    		  </div>
          <?php }
            if($facebook_login_btn=='true'){
          ?>
    		  <div class="col-md-6 col-sm-6 col-xs-12">		  
    			 <a href="<?=site_url('redirectFacebook')?>" class="btn_social"><img src="<?=base_url('assets/img/fb_login_btn.png')?>"/></a>
    		  </div>
          <?php } ?>
        </div>

        <?php } ?>

      </div>
    </div>

    <div class="col-md-6 col-sm-6">

      <div class="customer-login-register register-pt-0">
        <div class="form-register-title">
          <h2><?=$this->lang->line('register_lbl')?></h2>
        </div>
        <div class="register-form">

          <form action="<?php echo site_url('site/register'); ?>" id="registerForm" method="post">
            <input type="hidden" name="preview_url" value="<?php if(isset($_SERVER['HTTP_REFERER'])){ echo $_SERVER['HTTP_REFERER']; }?>">
            <div class="step_1">

              <div class="wizard-form-field">
                <div class="wizard-form-input has-float-label">
                  <input type="text" name="user_name" value="" autocomplete="off" placeholder="<?=$this->lang->line('name_place_lbl')?>">
                  <label><?=$this->lang->line('name_place_lbl')?></label>
                  <p class="err"><i class="fa fa-exclamation-circle"></i> <span><?=$this->lang->line('name_require_lbl')?></span></p>
                </div>
              </div>

              <div class="wizard-form-field">
                <div class="wizard-form-input has-float-label">
                  <input type="text" name="user_email" value="" autocomplete="off" placeholder="<?=$this->lang->line('email_place_lbl')?>">
                  <label><?=$this->lang->line('email_place_lbl')?></label>
                  <p class="err"><i class="fa fa-exclamation-circle"></i> <span><?=$this->lang->line('email_require_lbl')?></span></p>
                </div>
              </div>

              <div class="wizard-form-field">
                <div class="wizard-form-input has-float-label">
                  <input type="password" name="user_password" value="" autocomplete="off" placeholder="<?=$this->lang->line('password_lbl')?>">
                  <label><?=$this->lang->line('password_lbl')?></label>
                  <p class="err"><i class="fa fa-exclamation-circle"></i> <span><?=$this->lang->line('password_require_lbl')?></span></p>
                </div>
              </div>

              <div class="wizard-form-field">
                <div class="wizard-form-input has-float-label">
                  <input type="password" name="c_password" value="" autocomplete="off" placeholder="<?=$this->lang->line('cpassword_lbl')?>">
                  <label><?=$this->lang->line('cpassword_lbl')?></label>
                  <p class="err"><i class="fa fa-exclamation-circle"></i> <span><?=$this->lang->line('cpassword_require_lbl')?></span></p>
                </div>
              </div>

              <div class="wizard-form-field">
                <div class="wizard-form-input has-float-label">
                  <input type="text" name="user_phone" value="" autocomplete="off" placeholder="<?=$this->lang->line('phone_no_lbl')?>" onkeypress="return isNumberKey(event)" maxlength="15">
                  <label><?=$this->lang->line('phone_no_lbl')?></label>
                  <p class="err"><i class="fa fa-exclamation-circle"></i> <span><?=$this->lang->line('phone_no_require_lbl')?></span></p>
                </div>
              </div>

              <div class="register-submit">
                <?php 
                    if($email_otp_status=='true'){
                      ?>
                      <button type="button" class="form-button step_1_btn"><?=$this->lang->line('submit_btn')?></button>
                      <?php
                    }
                    else{
                      ?>
                      <button type="submit" class="form-button btn_register" name="btn_register"><?=$this->lang->line('register_btn')?></button>
                      <?php
                    }
                ?>
                
              </div>
            </div>
            <div class="step_2" style="display: none;">

              <p class="text-center" style="color: red;font-size: 16px;font-weight: 400"><?=$this->lang->line('sent_otp_lbl')?> </p>

              <div class="wizard-form-field">
                <div class="wizard-form-input has-float-label">
                  <input type="text" name="email_sent_code" value="" autocomplete="off" placeholder="<?=$this->lang->line('enter_code_lbl')?>">
                  <label><?=$this->lang->line('enter_code_lbl')?></label>
                  <p class="err"><i class="fa fa-exclamation-circle"></i> <span><?=$this->lang->line('invalid_code_lbl')?></span></p>
                </div>
              </div>

              <div class="register-submit">

                <button type="button" class="form-button btn_resend" disabled="true" style="background-color: #bbb"><?=$this->lang->line('resend_btn')?></button><span>&nbsp;&nbsp;&nbsp;&nbsp;Wait <span id="countdown">60</span> Seconds</span>
                <div class="clearfix"></div>
                <br/>
                <button type="button" class="form-button btn_back"><?=$this->lang->line('back_btn')?></button>
                
                <button type="submit" class="form-button step_2_btn" name="btn_register"><?=$this->lang->line('register_btn')?></button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</section>

<div id="lostPassword" class="modal fade" role="dialog" style="z-index: 9999999">
  <div class="modal-dialog modal-sm"> 
    <div class="modal-content">
      <div class="modal-header" style="padding: 15px 20px">
        <h3><?=$this->lang->line('forgot_password_lbl')?></h3>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" style="padding-top: 10px">
        <div class="modal-details">
          <form action="<?=base_url('site/forgot_password')?>" method="post" id="lost_password_form">
            <!-- <p class="err_password" style="color: red;display: none"></p> -->
            <div class="wizard-form-field">
              <div class="wizard-form-input has-float-label">
                <input type="email" name="registered_email" value="" placeholder="<?=$this->lang->line('registered_email_lbl')?>">
                <label><?=$this->lang->line('registered_email_lbl')?></label>
                <p class="err err_password"><i class="fa fa-exclamation-circle"></i> <span><?=$this->lang->line('email_require_lbl')?></span></p>
              </div>
            </div>
            <div class="login-submit">
              <button type="submit" class="form-button"><?=$this->lang->line('reset_btn')?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  $('#lostPassword').on('hidden.bs.modal', function () {
    $("input[name='registered_email']").val('');
    $("input").next("p").fadeOut();
    $(".err_password").hide();
  })

	$("#login_form").submit(function (e) {

    e.preventDefault();

		var $inputs = $("#login_form :input[name='email'], #login_form :input[name='password']");

		var counts=0;

		$inputs.each(function(){

			if($(this).val() != '') {
        $(this).parents(".wizard-form-input").find("p").fadeOut();  
      } else {
        counts++;
        $(this).parents(".wizard-form-input").find("p").fadeIn();
      }
		});

		if(counts==0){

      $(".process_loader").show();

      $.ajax({
        url:$(this).attr("action"),
        data: $(this).serialize(),
        type:'post',
        success:function(data){

          $(".process_loader").hide();

          var obj = $.parseJSON(atob(data));
          if(obj.status=='1'){
            window.location.href=obj.preview_url;
          }
          else{
            swal(obj.message);
          }
          
        },
        error : function(data) {
          alert("error");
        }
      });
    }
	});

  function IsEmail(email) {
    var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if(!regex.test(email)) {
      return false;
    }else{
      return true;
    }
  }

  function resendOTP() {
      var count = document.getElementById('countdown');
      timeoutfn = function(){

        if(parseInt(count.innerHTML) <= 0){
          clearInterval(this);

          $('.btn_resend').removeAttr("style");
          $('.btn_resend').attr("disabled", false);
          $("#countdown").parent("span").hide();

        }
        else{
          count.innerHTML = parseInt(count.innerHTML) - 1;
          setTimeout(timeoutfn, 1000);
        }
      };

      setTimeout(timeoutfn, 1000);
  }

  $(".btn_resend").on("click",function(e){
    e.preventDefault();

    $(this).attr("disabled", true);
    $(this).css("background-color", "#bbb");

    var name=$("input[name='user_name']").val();
    var email=$("input[name='user_email']").val();

    href = '<?=base_url()?>site/sent_code';

    $(".process_loader").show();

    $.ajax({
      url:href,
      data: {"email": email, "name": name, "is_resend": true},
      type:'post',
      success:function(res){

        var obj = $.parseJSON(res);

        $(".process_loader").hide();
        swal({title: "<?=$this->lang->line('resent_lbl')?>",text: obj.msg,type: "success"});
        $("#countdown").html("60");
        $("#countdown").parent("span").show();
        resendOTP();
      }

    });

  });


  $(".step_1_btn").on("click",function(e){

    var btn=$(this);

    var $inputs = $(".step_1").find("input");

    var counts=0;

    $inputs.each(function(){
        if($(this).val() != '') {
            $(this).parents(".wizard-form-input").find("p").fadeOut();
        } else {
          counts++;
          $(this).parents(".wizard-form-input").find("p").fadeIn();
        }
    });

    if(counts > 0){
      return false;
    }

    var name=$(".step_1 :input[name='user_name']").val();
    var email=$(".step_1 :input[name='user_email']").val();
    var password=$(".step_1 :input[name='user_password']").val();
    var cpassword=$(".step_1 :input[name='c_password']").val();

    if(IsEmail(email)==false && email!=''){
      $(".step_1 :input[name='user_email']").parents(".wizard-form-input").find("p").find("span").text("<?=$this->lang->line('invalid_email_format')?>");
      $(".step_1 :input[name='user_email']").parents(".wizard-form-input").find("p").fadeIn();
      counts++;
    }
    else{
      $(".step_1 :input[name='user_email']").parents(".wizard-form-input").find("p").fadeOut();
    }
    
    if(password!=cpassword){
      $(".step_1 :input[name='c_password']").parents(".wizard-form-input").find("p").find("span").text("Password and confirm password must be same !!!");
      $(".step_1 :input[name='c_password']").parents(".wizard-form-input").find("p").fadeIn();
      counts++;
    }
    else{
      $(".step_1 :input[name='c_password']").parents(".wizard-form-input").find("p").fadeOut();
    }

    if(counts > 0){
      return false;
    }

    if(counts==0)
    {

      $(".process_loader").show();

      href = '<?=base_url()?>site/check_email';
      $.ajax({
        url:href,
        data: {"email": email},
        type:'post',
        success:function(res){

          var obj = $.parseJSON(res);

          if(obj.success=='1'){
            btn.attr("disabled", true);

            href = '<?=base_url()?>site/sent_code';

            $.ajax({
              url:href,
              data: {"email": email, "name": name, "is_resend": false},
              type:'post',
              success:function(res2){
                var obj2 = $.parseJSON(res2);
                if(obj2.success=='1'){
                  $(".process_loader").hide();
                  swal({title: "<?=$this->lang->line('sent_lbl')?>",text: obj2.msg,type: "success"}, function() {
                      $(".step_1").slideUp();
                      $(".step_2").slideDown();
                      resendOTP();
                  });
                  
                }
                else if(obj2.success=='0'){

                  $(".step_1_btn").attr("disabled", false);

                  $(".process_loader").hide();
                  swal(obj2.msg);
                }

              }

            });
          }
          else if(obj.success=='0'){

            $(".step_1_btn").attr("disabled", false);

            $(".process_loader").hide();
            $(".step_1 :input[name='user_email']").parents(".wizard-form-input").find("p").find("span").text(obj.msg);
            $(".step_1 :input[name='user_email']").parents(".wizard-form-input").find("p").fadeIn();
          }
        },
        error : function(res) {
            swal("Error !");
        }
      });
    }

  });

  $(".btn_back").on("click",function(e){

    swal({
        title: "Are you sure?",
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

          swal.close();

          $(".step_2").slideUp();
          $(".step_1").slideDown();

          $(".step_1_btn").attr("disabled", false);

        }else{
          swal.close();
        }
    });
    
  });

  $(".step_2_btn").on("click",function(e){
      e.preventDefault();

      var email=$(".step_1 :input[name='user_email']").val();
      var code=$(".step_2 :input[name='email_sent_code']").val();

      href = '<?=base_url()?>site/verify_code';

      $.ajax({
        url:href,
        data: {email: email,code: code},
        type:'post',
        success:function(res){
          if($.trim(res)=='true'){
            $("#registerForm").submit();
          }
          else{
            $(".step_2 :input[name='email_sent_code']").next("p").show();
          }
        },
        error : function(res) {
          alert("error");
        }
      });
  });

  $(".btn_register").on("click",function(e){
      e.preventDefault();

      $("#registerForm").submit();
  });



  $("#lost_password_form").submit(function(e)
  {
    e.preventDefault();
    $(".err_password").hide();
    var _btn=$(this).find("button");

    if($("input[name='registered_email']").val()!='')
    {
      _btn.text("<?=$this->lang->line('please_wait_lbl')?>");

      _btn.attr("disabled", true);

      var formData = new FormData($(this)[0]);

      $.ajax({
        url:$(this).attr("action"),
        processData: false,
        contentType: false,
        type: 'POST',
        data: formData,
        success: function(data){
          var obj = $.parseJSON(data);
          if(obj.success=='1'){
            location.reload();
          }
          else if(obj.success=='0'){
            _btn.attr("disabled", false);
            _btn.text("<?=$this->lang->line('reset_btn')?>");
            $(".err_password").parents(".wizard-form-input").find("p").find("span").text(obj.message);
            $(".err_password").parents(".wizard-form-input").find("p").fadeIn();
          }
          else{
            _btn.attr("disabled", false);
            _btn.text("<?=$this->lang->line('reset_btn')?>");
            $(".err_password").parents(".wizard-form-input").find("p").find("span").text(Settings.err_something_went_wrong);
            $(".err_password").parents(".wizard-form-input").find("p").fadeIn();
          }
        },
        error : function(res) {
          alert("error");
        }
      });
    }
    else
    {
      $(".err_password").parents(".wizard-form-input").find("p").fadeIn();
    }
  });

</script>

<?php
  if($this->session->flashdata('response_msg')) {
    $message = $this->session->flashdata('response_msg');
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