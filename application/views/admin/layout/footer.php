    <footer class="app-footer" style="position:relative;">
          <div class="row">
            <div class="col-xs-12">
              <div class="footer-copyright"><?=$this->lang->line('footer_context_lbl')?></div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    
     
    <script type="text/javascript" src="<?=base_url('assets/js/app.js')?>"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <?php
      if($this->session->flashdata('response_msg')) {
        $message = $this->session->flashdata('response_msg');
        ?>
          <script type="text/javascript">

            var _msg='<?=$message['message']?>';
            var _class='<?=$message['class']?>';

            _msg=_msg.replace(/(<([^>]+)>)/ig,"");

            $('.notifyjs-corner').empty();
            $.notify(
              _msg, 
              { position:"top center",className: _class}
            ); 
          </script>
        <?php
      }
    ?>

    <script type="text/javascript">

      function isNumberKey(evt) {
          var charCode = (evt.which) ? evt.which : event.keyCode
          if (charCode != 43 && charCode > 31 && (charCode < 48 || charCode > 57)){
              return false;
          }
          return true;
      }

      $(".loader").show();
      $(document).ready(function(){

        $(".loader").fadeOut("slow");

        $(".datepicker").datepicker();

        new_arrival_orders();
        
        setInterval(function(){
          new_arrival_orders();
        },60000);
        

      });

      function new_arrival_orders() {
          var _href='<?=base_url()?>admin/order/order_notify';

          $.ajax({
            type:'POST',
            url:_href,
            success:function(res){
              var obj = $.parseJSON(atob(res));
              $(".notify_count").text(obj.count);

              $("li.ordering_heading").nextAll("li").remove();

              if(obj.count==0){
                $(".ordering_heading").after('<li class="dropdown-empty">No New Ordered</li>');
                $(".dropdown-empty").after('<li class="dropdown-footer"><a href="<?=site_url('admin/orders')?>"><?=$this->lang->line('view_all_lbl')?> <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>');             
              }
              else{

                $(".ordering_heading").after(obj.content);
                $(".ordering_ul").append('<li class="dropdown-footer"><a href="<?=site_url('admin/orders')?>"><?=$this->lang->line('view_all_lbl')?> <i class="fa fa-angle-right" aria-hidden="true"></i></a></li>');
              }
            }
          });
      }
      

      if($(".dropdown-li").hasClass("active")){
        var _act_page='<?php echo $current_page; ?>';
        $("."+_act_page).next(".cust-dropdown-container").show();
        $("."+_act_page).find(".title").next("i").removeClass("fa-angle-right");
        $("."+_act_page).find(".title").next("i").addClass("fa-angle-down");
      }

      $(document).ready(function(e){
        var _flag=false;

        $(".dropdown-a").click(function(e){

          $(this).parents("ul").find(".cust-dropdown-container").slideUp();

          $(this).parents("ul").find(".title").next("i").addClass("fa-angle-right");
          $(this).parents("ul").find(".title").next("i").removeClass("fa-angle-down");

          if($(this).parent("li").next(".cust-dropdown-container").css('display') !='none'){
              $(this).parent("li").next(".cust-dropdown-container").slideUp();
              $(this).find(".title").next("i").addClass("fa-angle-right");
              $(this).find(".title").next("i").removeClass("fa-angle-down");
          }else{
            $(this).parent("li").next(".cust-dropdown-container").slideDown();
            $(this).find(".title").next("i").removeClass("fa-angle-right");
            $(this).find(".title").next("i").addClass("fa-angle-down");
          }

        });
      });

    </script>

    <script type="text/javascript">

      $(".btn_notification").on("click",function(e){
        e.preventDefault();
        var id=$(this).data("id");
        var sub_id=$(this).data("sub_id");
        var type=$(this).data("type");
        var title=$(this).data("title");
        var image=$(this).data("image");
 
        var href = '<?=base_url()?>admin/pages/direct_send_notification';

        swal({
          title: "<?=$this->lang->line('are_you_sure_msg')?>",
          text: "<?=$this->lang->line('notification_confirm_msg')?>",
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
              type:'POST',
              url:href,
              data:{'id':id, 'type':type, 'sub_id':sub_id, 'title': title, 'image': image},
              dataType:'json',
              success:function(res){
                  if(res.status=='1'){
                    swal({title: "<?=$this->lang->line('successfully_lbl')?>", text: res.message, type: res.class});
                  }
                }
            });
          }
          else{
            swal.close();
          }

        })
      });

      $(".btn_top_action").on("click",function(e){
        e.preventDefault();

        var href = $(this).attr("href");

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
          if(isConfirm) {
            window.location.href=href;
            swal.close();
          }
          else{
            swal.close();
          }
        })
      });

    </script>



</body>
</html>