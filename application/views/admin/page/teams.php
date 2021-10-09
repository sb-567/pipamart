<style type="text/css">
  .dataTables_wrapper{
    overflow: unset !important;
  }
</style>
<div class="row card_item_block" style="padding-left:30px;padding-right: 30px">
  <div class="col-sm-12 col-xs-12">
    <div class="card">
      <div class="card-header">
        <div class="page_title" style="padding: 0px"><?=$page_title?></div>
      </div>
      <div class="clearfix"></div>
      <!-- card body -->

      <div class="card-body mrg_bottom" style="padding: 20px">
        
        <div class="row">
          <div class="col-md-12 mrg-top manage_comment_btn">
                <div class="add_btn_primary"> <a href="<?=site_url('admin/cms/addteam/')?>" class="btn_edit"><?=$this->lang->line('add_new_lbl')?></a></div>
                <div class="clearfix"></div>
                <br/>
                <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th width="100">#</th>
                      <th>Name</th>
                      <th class="cat_action_list" style="width:60px">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      $no=1;
                      foreach ($data as $key => $value) {
                          ?>
                        <tr class="item_holder">
                          <td><?=$no++?></td>
                          <td><?=$value->name?></td>
                          <td nowrap="">
                            <a href="<?=site_url('admin/cms/addteam/'.$value->id)?>?redirect=<?=$redirectUrl?>" class="btn btn-primary btn_edit" data-toggle="tooltip" data-tooltip="<?=$this->lang->line('edit_lbl')?>"><i class="fa fa-edit"></i></a>
                            <a href="" class="btn btn-danger btn_delete" data-id="<?=$value->id?>" data-toggle="tooltip" data-tooltip="<?=$this->lang->line('delete_lbl')?>"><i class="fa fa-trash"></i></a>
                          </td>
                        </tr>
                          <?php
                      }

                    ?>
                  </tbody>
                </table>
              </div>
        </div>
      </div>
    </div>
  </div>
</div>
<br/>
<div class="clearfix"></div>   

<script type="text/javascript">

  $("#checkall").click(function () {
    $('input:checkbox').not(this).prop('checked', this.checked);
  });

  $('a[data-toggle="tab"]').on('show.bs.tab', function(e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
  });

  var activeTab = localStorage.getItem('activeTab');
  if(activeTab){
    $('.nav-tabs a[href="' + activeTab + '"]').tab('show');
  }


  // for delete contacts subjects
  $(".btn_delete").click(function(e){
      e.preventDefault();
      var _id=$(this).data("id");

      e.preventDefault(); 
      var href = '<?php echo base_url(); ?>admin/cms/delete_team/'+_id;
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
                  alert("<?=$this->lang->line('something_went_wrong_err')?>");
                }

              }
          });
          
        }else{
          swal.close();
        }
      });
  });

  // for delete contacts
  $(".btn_delete2").click(function(e){
      e.preventDefault();
      var _id=$(this).data("id");

      e.preventDefault(); 
      var href = 'contacts/delete_contact/'+_id;
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
                  alert("<?=$this->lang->line('something_went_wrong_err')?>");
                }

              }
          });
          
        }else{
          swal.close();
        }
      });
  });

  $(".delete_rec").click(function(e){
    e.preventDefault();

    var _ids = $.map($('.post_ids:checked'), function(c){return c.value; });

    if(_ids!='')
    {
      var href = '<?=base_url()?>admin/contacts/delete_contact_multiple/'+_ids;
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
                      location.reload();
                  });
                }
                else
                {
                  alert("<?=$this->lang->line('something_went_wrong_err')?>");
                }

              }
          });
          
        }else{
          swal.close();
        }
      });
    }

  });

</script>