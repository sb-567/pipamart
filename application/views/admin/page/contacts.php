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

      <div class="card-body mrg_bottom" style="padding: 0px">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 0px">
          <li role="presentation" class="active"><a href="#subject_list" aria-controls="comments" role="tab" data-toggle="tab"><i class="fa fa-comments"></i> <?=$this->lang->line('sub_list_lbl')?></a></li>
          <li role="presentation"><a href="#contact_list" aria-controls="contact_list" role="tab" data-toggle="tab"><i class="fa fa-envelope"></i> <?=$this->lang->line('contact_form_lbl')?></a></li>
        </ul>

        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="subject_list">
              <div class="col-md-12 mrg-top manage_comment_btn">
                <div class="add_btn_primary"> <a href="<?=site_url('admin/contacts/add')?>" class="btn_edit"><?=$this->lang->line('add_new_lbl')?></a></div>
                <div class="clearfix"></div>
                <br/>
                <table class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th width="100">#</th>
                      <th><?=$this->lang->line('title_lbl')?></th>
                      <th class="cat_action_list" style="width:60px"><?=$this->lang->line('action_lbl')?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      $no=1;
                      foreach ($subjects as $key => $value) {
                          ?>
                        <tr class="item_holder">
                          <td><?=$no++?></td>
                          <td><?=$value->title?></td>
                          <td nowrap="">
                            <a href="<?=site_url('admin/contacts/edit/'.$value->id)?>?redirect=<?=$redirectUrl?>" class="btn btn-primary btn_edit" data-toggle="tooltip" data-tooltip="<?=$this->lang->line('edit_lbl')?>"><i class="fa fa-edit"></i></a>
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
            <div role="tabpanel" class="tab-pane" id="contact_list">
              <div class="col-md-12 mrg-top manage_comment_btn">
                <form method="post" action="">

                  <button class="btn btn-danger btn_edit delete_rec" style="margin-bottom:20px;"><i class="fa fa-trash"></i> <?=$this->lang->line('delete_all_lbl')?></button>  
                  <table  class="datatable table table-striped table-bordered table-hover" style="margin-top: 20px !important">
                    <thead>
                      <tr>
                        <th style="width:40px">
                          <div class="checkbox" style="margin: 0px">
                            <input type="checkbox" name="checkall" id="checkall" value="">
                            <label for="checkall"></label>
                          </div>
                        </th> 
                        <th><?=$this->lang->line('name_lbl')?></th>
                        <th><?=$this->lang->line('email_lbl')?></th>    
                        <th><?=$this->lang->line('subjects_lbl')?></th>    
                        <th><?=$this->lang->line('message_lbl')?></th>
                        <th><?=$this->lang->line('date_lbl')?></th>
                        <th class="cat_action_list" style="width:60px"><?=$this->lang->line('action_lbl')?></th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $no=1;
                        foreach ($conatct_data as $key => $value) {
                            ?>
                          <tr class="item_holder">
                            <td>  
                              <div>
                                  <div class="checkbox" id="checkbox_contact">
                                    <input type="checkbox" name="post_ids[]" id="checkbox<?php echo $no;?>" value="<?php echo $value->id; ?>" class="post_ids">
                                    <label for="checkbox<?php echo $no;?>">
                                    </label>
                                  </div>
                              </div>
                            </td>
                            <td><?=$value->contact_name?></td>
                            <td><?=$value->contact_email?></td>
                            <td><?=$value->title?></td>
                            <td><?=stripslashes($value->contact_msg)?></td>
                            <td nowrap=""><?php echo date('d-m-Y',$value->created_at);?></td>
                            <td nowrap="">
                              <a href="" class="btn btn-danger btn_delete2 btn_edit" data-id="<?=$value->id?>" data-toggle="tooltip" data-tooltip="<?=$this->lang->line('delete_lbl')?>"><i class="fa fa-trash"></i></a>
                            </td>
                          </tr>
                            <?php
                            $no++;
                        }

                      ?>
                    </tbody>
                  </table>
                </form>
            </div>
          </div>

          <div class="clearfix"></div>

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
      var href = 'contacts/delete_subject/'+_id;
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