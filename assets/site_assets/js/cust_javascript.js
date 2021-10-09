// Doument ready stage
$(window).on("load",function() {
    // Animate loader off screen
    $(".se-pre-con").fadeOut("slow");
});

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode != 43 && charCode > 31 && (charCode < 48 || charCode > 57)){
        return false;
    }
    return true;
}

$(document).ready(function(event) {

    var base_url = Settings.base_url;

    var currency_code = Settings.currency_code;

    // for search form

    $("#search_form").on("submit",function(e){
        if($(this).find("select").val()==''){
            $(this).find("select").attr("disabled",true);
        }
    });

    $("input[name='payment_method']").click(function(e) {
        var _val = $(this).val();
        $(".payment_method .pay-box").hide();
        $(this).parent(".payment_method").find(".pay-box").slideDown("100");
    });

    // end search form

    $(".unavailable_override").hover(function(event){
      $(this).parent(".single-product3").hover();
    });

    // add to cart
    $(".btn_cart").on("click",function(e) {
        e.preventDefault();
        var btn = $(this);
        var _id = $(this).data("id");
        var _maxunit = $(this).data("maxunit");

        href = base_url + 'site/cart_action';

        $.ajax({
            url: href,
            data: {"product_id": _id},
            type: 'post',
            success: function(res) {
                if ($.trim(res) == 'login_now') {
                    window.location.href = base_url + "login-register";
                } else {
                    var obj = $.parseJSON(res);

                    $("#cartModal .modal-body").html(obj.html_code);
                    $("#cartModal").modal("show");

                    $('.radio-group .radio_btn').on("click",function() {
                        $(this).parent().find('.radio_btn').removeClass('selected');
                        $(this).addClass('selected');
                        var val = $(this).attr('data-value');
                        $(this).parent().find('input').val(val);
                    });

                    $("input[name='product_qty']").blur(function() {
                        if ($(this).val() <= 0) {
                            $(this).val(1);
                        } else if ($(this).val() > _maxunit) {
                            var limit_items=Settings.err_cart_item_buy;
                            alert(limit_items.replace("###", _maxunit));
                            $(this).val(_maxunit);
                        }
                    });

                    $("#cartForm").submit(function(event) 
                    {
                        event.preventDefault();
                        $(".process_loader").show();

                        var formData = $(this).serialize();
                        var _form = $(this);

                        $.ajax({
                                type: 'POST',
                                url: base_url + 'site/add_to_cart',
                                data: formData
                            })
                            .done(function(response) {

                                var res = $.parseJSON(response);
                                $(".process_loader").hide();
                                $("#cartModal").modal("hide");
                                if(res.success == '1') {
                                    swal({
                                        title: res.lbl_title,
                                        text: res.msg,
                                        type: "success"
                                    }, function() {
                                        location.reload();
                                    });
                                }
                                else{
                                    swal({
                                        title: Settings.err_something_went_wrong,
                                        text: res.msg,
                                        type: "error"
                                    }, function() {
                                        location.reload();
                                    });
                                }
                            })
                            .fail(function(response) {
                                $(".process_loader").hide();
                                swal({
                                    title: Settings.err_something_went_wrong,
                                    text: res.msg,
                                    type: "error"
                                }, function() {
                                    location.reload();
                                });
                            });

                    });

                }
            },
            error: function(res) {
                alert("error");
            }
        });
    });

    $(".btn_remove_cart").on("click",function(e) {
        e.preventDefault();
        var href = $(this).attr("href");

        swal({
            title: Settings.confirm_msg,
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
                        type: 'POST',
                        url: href
                    })
                    .done(function(response) {

                        var res = $.parseJSON(response);
                        $(".process_loader").hide();
                        if (res.success == '1') {
                            swal({
                                title: res.lbl_title,
                                text: res.msg,
                                type: "success"
                            }, function() {
                                location.reload();
                            });
                        } else {
                            swal({
                                title: Settings.err_something_went_wrong,
                                text: res.msg,
                                type: "error"
                            }, function() {
                                location.reload();
                            });
                        }

                    })
                    .fail(function(response) {
                        $(".process_loader").hide();
                        swal({
                            title: Settings.err_something_went_wrong,
                            text: res,
                            type: "error"
                        }, function() {
                            location.reload();
                        });
                    });

            } else {
                swal.close();
            }
        });

    });

    // for wishlist

    $(".btn_wishlist").on("click",function(e) {
        e.preventDefault();
        var btn = $(this);
        var _id = $(this).data("id");

        href = base_url + 'site/wishlist_action';

        $.ajax({
            url: href,
            data: {"product_id": _id},
            type: 'post',
            success: function(res) {
                if ($.trim(res) == 'login_now') {
                    window.location.href = base_url + "login-register";
                } else {
                    var obj = $.parseJSON(res);

                    if (obj.is_favorite) {
                        btn.css("background-color", "#ff5252");
                        btn.attr('data-original-title', obj.icon_lbl);

                        $('.notifyjs-corner').empty();
                        $.notify(
                            obj.msg, {
                                position: "top right",
                                className: 'success'
                            }
                        );

                    } else {
                        btn.css("background-color", "#363F4D");
                        btn.attr('data-original-title', obj.icon_lbl);
                        $('.notifyjs-corner').empty();
                        $.notify(
                            obj.msg, {
                                position: "top right",
                                className: 'success'
                            }
                        );
                    }
                }
            },
            error: function(res) {
                alert(Settings.err_something_went_wrong);
            }

        });
    });

    $(".btn_remove_wishlist").click(function(e) {
        e.preventDefault();

        var _id=$(this).data("id");

        swal({
            title: Settings.confirm_msg,
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
            var btn = $(this);

            href = base_url + 'site/wishlist_action';
            
            $.ajax({
              url:href,
              data: {product_id: _id},
              type:'post',
              success:function(res){
                  if(res=='login_now'){
                    window.location.href = base_url + "login-register";
                  }
                  else{
                    location.reload();
                  }
                },
                error : function(res) {
                    alert(Settings.err_something_went_wrong);
                }
            });
          }else{
            swal.close();
          }
        });

    });
    // end wishlist

    

    // to all about address module

    $(".address_radio").on("click",function(e) {
        $("input[name='order_address']").val($(this).val());
        $(".ceckout-form").hide();
        $(".bank_form").hide();
    });


    $(".btn_new_address").on("click",function(e) {
        e.preventDefault();
        $(".ceckout-form").toggle();
        $(".bank_form").toggle();
    });

    $(".btn_edit_address").on("click",function(e){

        var data=$(this).data('stuff');
        console.log(data['address_type']);
        $('#edit_address').find("input[name='address_id']").val(data['id']);
        $('#edit_address').find("input[name='billing_name']").val(data['name']);
        $('#edit_address').find("input[name='billing_mobile_no']").val(data['mobile_no']);
        $('#edit_address').find("input[name='alter_mobile_no']").val(data['alter_mobile_no']);
        $('#edit_address').find("input[name='billing_email']").val(data['email']);
        $('#edit_address').find("textarea[name='building_name']").val(data['building_name']);
        $('#edit_address').find("input[name='road_area_colony']").val(data['road_area_colony']);

        $('#edit_address').find("input[name='landmark']").val(data['landmark']);
        $('#edit_address').find("input[name='pincode']").val(data['pincode']);
        $('#edit_address').find("input[name='city']").val(data['city']);
        $('#edit_address').find("input[name='district']").val(data['district']);
        $('#edit_address').find("input[name='state']").val(data['state']);
        $('#edit_address').find('#country option[value="'+data['country']+'"]').prop('selected', true);

        $('#edit_address').find("input[name=address_type][value='"+data['address_type']+"']").prop("checked",true);

        $('#edit_address').modal({
            backdrop: 'static',
            keyboard: false
        })
    });

    $("#edit_address_form").submit(function(e){
        e.preventDefault();

        $(".process_loader").show();

        var formData = new FormData($(this)[0]);

        var href = base_url + 'site/edit_address';
        
        $.ajax({
            url: href,
            processData: false,
            contentType: false,
            type: 'POST',
            data: formData,
            success: function(data){

              var obj = $.parseJSON(atob(data));
              $(".process_loader").hide();
              $('#edit_address').modal("hide");

              if(obj.status==1){
                swal({ title: obj.title, text: obj.msg, type: obj.class}, function(){ location.reload(); });
              }
              else{
                swal(Settings.err_something_went_wrong, obj.msg);
              }

            }
        });

    });

    // end address module

    $(".btn_new_account").on("click",function(e) {
        e.preventDefault();
        $(".bank_form_new").toggle();
        $(".bank_form").toggle();
    });

    // remove bank account
    $(".btn_remove_bank").on("click",function(e) {
        e.preventDefault();

        var _id = $(this).data("id");

        swal({
                title: Settings.confirm_msg,
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

                    href = base_url + 'site/remove_bank_account';

                    $.ajax({
                        type: 'POST',
                        url: href,
                        data: {
                            bank_id: _id
                        },
                        success: function(res) {
                            var obj = $.parseJSON(res);
                            if (obj.success == '1') {
                                swal({
                                    title: "Deleted!",
                                    text: obj.message,
                                    type: "success"
                                }, function() {
                                    location.reload();
                                });
                            } else {
                                swal({ title: Settings.err_something_went_wrong, text: obj.message, type: "error" }, function(){ location.reload(); });
                            }
                        }
                    });
                } else {
                    swal.close();
                }

            });

    });

    // for contact form
    $("#contact_form").submit(function(e) {
        e.preventDefault();

        $(".process_loader").show();

        $('.btn_send').attr("disabled", true);

        var formData = $(this).serialize();

        var _form = $(this);

        $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData
            })
            .done(function(response) {

                var res = $.parseJSON(response);

                $('.notifyjs-corner').empty();

                $(".process_loader").hide();

                if (res.success == '1') {

                    _form.find("input").val('');
                    _form.find("textarea").val('');

                    _form.find("select").val('');

                    swal({
                        title: "Done!",
                        text: res.msg,
                        type: "success"
                    }, function() {
                        location.reload();
                    });
                } else {

                    swal(Settings.err_something_went_wrong, res.msg);
                    $('.btn_send').attr("disabled", false);
                }

            })
            .fail(function(data) {

            });

    });

    $("#partner_form").submit(function(e) {
        e.preventDefault();

        $(".process_loader").show();

        $('.btn_send').attr("disabled", true);

        var formData = $(this).serialize();

        var _form = $(this);

        $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData
            })
            .done(function(response) {

                var res = $.parseJSON(response);

                $('.notifyjs-corner').empty();

                $(".process_loader").hide();

                if (res.success == '1') {

                    _form.find("input").val('');
                    _form.find("textarea").val('');

                    _form.find("select").val('');

                    swal({
                        title: "Done!",
                        text: res.msg,
                        type: "success"
                    }, function() {
                        location.reload();
                    });
                } else {

                    swal(Settings.err_something_went_wrong, res.msg);
                    $('.btn_send').attr("disabled", false);
                }

            })
            .fail(function(data) {

            });

    });

    // remove review
    $(".btn_remove_review").on("click",function(e) {
        e.preventDefault();

        var _id = $(this).data("id");

        swal({
                title: Settings.confirm_msg,
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

                    href = base_url + 'site/remove_review';

                    $.ajax({
                        type: 'POST',
                        url: href,
                        data: {
                            review_id: _id
                        },
                        success: function(res) {
                            var obj = $.parseJSON(res);
                            if (obj.success == '1') {
                                swal({
                                    title: "Deleted!",
                                    text: obj.message,
                                    type: "success"
                                }, function() {
                                    location.reload();
                                });
                            } else {
                                swal(Settings.err_something_went_wrong, obj.message);
                            }
                        }
                    });
                } else {
                    swal.close();
                }
            });
    });

    $(".btn_cancel_form").on("click",function(e) {
        e.preventDefault();
        $(".bank_form").hide();
    });



    // to close address form
    $(".close_form").on("click",function(e) {
        e.preventDefault();
        $('form[name="address_form"]')[0].reset();
        $(".add_addresss_block").hide();
    });


    $(".btn_delete_address").on("click",function(e) {

        e.preventDefault();

        var _id = $(this).data("id");

        swal({
            title: Settings.confirm_msg,
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
                href = base_url + 'site/delete_address/' + _id;
                window.location.href = href;
            } else {
                swal.close();
            }
        });

    });

    // for rating
    $('#stars li').on('mouseover', function() {
        var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

        // Now highlight all the stars that's not after the current hovered star
        $(this).parent().children('li.star').each(function(e) {
            if (e < onStar) {
                $(this).addClass('hover');
            } else {
                $(this).removeClass('hover');
            }
        });

    }).on('mouseout', function() {
        $(this).parent().children('li.star').each(function(e) {
            $(this).removeClass('hover');
        });
    });


    /* 2. Action to perform on click */
    $('#stars li').on('click', function() {

        $(".inp_rating").val(parseInt($(this).data('value'), 10));

        var onStar = parseInt($(this).data('value'), 10); // The star currently selected
        var stars = $(this).parent().children('li.star');

        for (i = 0; i < stars.length; i++) {
            $(stars[i]).removeClass('selected');
        }

        for (i = 0; i < onStar; i++) {
            $(stars[i]).addClass('selected');
        }

    });
    // end

    // for coupon code

    $(".btn_apply_coupon").on("click",function(e) {

        e.preventDefault();

        href = base_url + 'site/apply_coupon';

        var coupon_id=$(this).data("coupon");
        var cart_ids=$(this).data("cart");
        var cart_type=$(this).data("type");
        
        $.ajax({
            url: href,
            type: 'post',
            data: {'coupon_id' : coupon_id, 'cart_ids' : cart_ids, 'cart_type' : cart_type},
            success: function(data) {
                var obj = $.parseJSON(data);
                $("#coupons_detail").modal("hide");
                $(".code_err").hide();
                
                if(obj.success == '1') {
                    $('.notifyjs-corner').empty();
                    $.notify(obj.msg, {position: "top right",className: 'success'});

                    $(".order-total").find("span").html(currency_code + ' ' + obj.payable_amt);
                    $(".msg_2").html(obj.you_save_msg);
                    $(".apply_msg").show();
                    $("input[name='coupon_id']").val(obj.coupon_id);
                    $(".apply_button").hide();
                    $(".remove_coupon").show();
                }
                else if(obj.success=='-1'){
                    swal({ title: Settings.err_something_went_wrong, text: obj.msg, type: "error" }, function(){ location.reload(); });
                }
                else {
                    swal(obj.msg);
                }
            },
            error: function(res) {
                alert("error");
            }

        });
        
    });

    // for remove coupon code

    $(".remove_coupon a").on("click",function(e) {
        e.preventDefault();

        var cart_type='';
        if($("input[name='buy_now']").val()=='false'){
            cart_type='main_cart';
        }
        else{
            cart_type='temp_cart';
        }

        href = base_url + 'site/remove_coupon/'+cart_type;

        var coupon_id=$("input[name='coupon_id']").val();
        var cart_ids=$("input[name='cart_ids']").val();

        swal({
            title: Settings.confirm_msg,
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
                    url: href,
                    type: 'post',
                    data: {'coupon_id' : coupon_id, 'cart_ids' : cart_ids},
                    success: function(data){

                        swal.close();

                        var obj = $.parseJSON(data);

                        $(".code_err").hide();
                
                        if(obj.success == '1'){
                            $('.notifyjs-corner').empty();
                            $.notify(obj.msg, {position: "top right",className: 'success'});

                            $(".order-total").find("span").html(currency_code + ' ' + obj.payable_amt);

                            $(".msg_2").html(obj.you_save_msg);

                            $(".apply_msg").show();

                            $(".apply_button").show();
                            $(".remove_coupon").hide();
                        }
                        else if(obj.success=='-1'){
                            swal({ title: Settings.err_something_went_wrong, text: obj.msg, type: "error" }, function(){ location.reload(); });
                        }
                        else {
                            swal(obj.msg);
                        }
                    }
                });
            } else {
                swal.close();
            }
        });

    });


    // place order
    $(".btn_place_order").on("click", function(e) {
        e.preventDefault();

        var _count = 0;

        var btn = $(this);

        var _formData = $("form[name='place_order']").serializeArray();

        /*console.log(_formData);*/

        if (_formData[2]['value'] != '0') {

            var _payment_method = _formData[4]['value'];

            if (_payment_method == 'cod') {

                btn.attr("disabled", true);

                if ($(".input_txt").val() != '') {
                    btn.attr("disabled", false);
                    _count = 0;
                    $(".input_txt").css("border-color", "#ccc");
                    var _sum = parseInt($("._lblnum1").text()) + parseInt($("._lblnum2").text());
                    if (parseInt($(".input_txt").val()) != _sum) {
                        swal("Enter correct value !!!");

                        var x = Math.floor((Math.random() * 10) + 1);
                        var y = Math.floor((Math.random() * 10) + 1);

                        $("._lblnum1").text(x);
                        $("._lblnum2").text(y);
                        $(".input_txt").val('');
                        _count++;
                    }
                } else {
                    _count++;
                    $(".input_txt").css("border-color", "red");
                    btn.attr("disabled", false);
                }

                if (_count == 0) {

                    $(".process_loader").show();

                    href = base_url + 'site/place_order';

                    $.ajax({
                        type: 'POST',
                        url: href,
                        data: $("form[name='place_order']").serialize(),
                        success: function(data) {

                            btn.attr("disabled", false);

                            var obj = $.parseJSON(data);

                            $(".process_loader").hide();

                            if (obj.success == '1') {

                                $("#orderConfirm .ord_no_lbl").text(obj.order_unique_id);

                                $("#orderConfirm .btn_track").on("click",function(e) {
                                    window.location.href = base_url + 'my-orders/' + obj.order_unique_id;
                                });

                                $("#orderConfirm").fadeIn();

                                if(_formData[0]['value']=='true'){
                                    if (history.pushState) {
                                        var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + location.search + '&order_unique_id='+obj.order_unique_id;
                                        window.history.pushState({path:newurl},'',newurl);
                                    }
                                }
                            }
                            else if (obj.success == '-2') {
                                swal({
                                    title: Settings.err_something_went_wrong,
                                    text: obj.msg,
                                    type: "error"
                                }, function() {
                                    window.location.href = base_url + "my-cart";
                                });
                            }
                            else
                            {
                                swal({
                                    title: Settings.err_something_went_wrong,
                                    text: obj.msg,
                                    type: "error"
                                }, function() {
                                    location.reload();
                                });
                            }

                        },
                        error: function (jqXHR, exception) {

                            $(".process_loader").hide();

                            var msg = '';
                            if (jqXHR.status === 0) {
                                msg = 'Not connect.\n Verify Network.';
                            } else if (jqXHR.status == 404) {
                                msg = 'Requested page not found. [404]';
                            } else if (jqXHR.status == 500) {
                                msg = 'Internal Server Error [500].';
                            } else if (exception === 'parsererror') {
                                msg = 'Requested JSON parse failed.';
                            } else if (exception === 'timeout') {
                                msg = 'Time out error.';
                            } else if (exception === 'abort') {
                                msg = 'Ajax request aborted.';
                            } else {
                                msg = 'Uncaught Error.\n' + jqXHR.responseText;
                            }
                            swal(msg);
                        },
                    });
                }
            } 
            else if (_payment_method == 'paypal') {
                $(this).attr("disabled", true);
                $(".process_loader").show();
                $(".input_txt").css("border-color", "#ccc");
                href = base_url + 'paypal/create_payment_with_paypal';
                $("form[name='place_order']").attr("action", href).submit();
            } 
            else if (_payment_method == 'stripe') {
                btn.attr("disabled", true);
                $(".input_txt").css("border-color", "#ccc");
                $("#stripeModal").modal("show");
            }
            else if (_payment_method == 'razorpay')
            {
                $(this).attr("disabled", true);
                $(".input_txt").css("border-color", "#ccc");

                var href = base_url + 'razorpay/generate_ord';

                $.ajax({
                    url: href,
                    type: 'post',
                    data: _formData,
                    success: function(res) {

                        btn.attr("disabled", false);

                        var obj = $.parseJSON(res);
                        if(obj.success=='1'){
                            callRazorPayScript(obj.key, obj.site_name, obj.description, obj.logo, obj.amount, obj.user_name, obj.user_email, obj.user_phone, obj.theme_color, obj.razorpay_order_id)
                        }
                        else if(obj.success=='-2'){
                            swal({
                                title: Settings.err_something_went_wrong,
                                text: obj.message,
                                type: "error"
                            }, function() {
                                window.location.href = base_url + "my-cart";
                            });
                        }
                        else{
                            swal({
                                title: Settings.err_something_went_wrong,
                                text: obj.message,
                                type: "error"
                            }, function() {
                                location.reload();
                            });
                        }

                    }
                });
            }
        }else {
            swal(Settings.err_shipping_address);
        }

    });

    // download invoice button
    $(".btn_download").on("click",function(e) {
        e.preventDefault();
        var _id = $(this).data("id");

        href = base_url + 'download-invoice/' + _id;

        window.open(href);
    });


    // for order progress timeline
    $(".dot").on("click",function(e) {

        if ($(this).data("status") != 'disable_dot') {
            $(this).addClass('active_dot').siblings().removeClass('active_dot');
            $(this).nextAll().addClass('deactive_dot');

            $(this).removeClass('deactive_dot');
            $(this).prevAll().removeClass('deactive_dot');
            $(this).prevAll().addClass('active_dot');
            $(this).addClass('active_dot');
        }
    });

    // for cancel order
    $('#orderCancel, #claimRefund').on('hidden.bs.modal', function() {
        $("body").css("overflow-y", "auto");
        $(".bank_form").hide();
        $(".bank_details").hide();
        $(".msg_holder").html('');
        $("textarea[name='reason']").css("border-color", "#ccc");
        $("textarea").val('');
    });

    $(".product_cancel").on("click",function(e) {

        e.preventDefault();

        if ($(this).data("gateway") != 'cod') {
            $(".bank_details").show();
        } else {
            $(".bank_details").hide();
        }

        var _title = Settings.product_cancel_confirm;

        if ($(this).data("product") == '0') {
            _title = Settings.ord_cancel_confirm;
        }

        $("#orderCancel .cancelTitle").text(_title);
        $("#orderCancel .order_unique_id").text($(this).data("unique"));
        $("#orderCancel").modal("show");

        $("body").css("overflow-y", "hidden");

        var order_id = $(this).data("order");
        var product_id = $(this).data("product");

        $("#orderCancel input[name='order_id']").val(order_id);
        $("#orderCancel input[name='product_id']").val(product_id);

        $("#orderCancel input[name='gateway']").val($(this).data("gateway"));

    });


    // single product cancel

    $(".cancel_order").on("click",function(e) {
        e.preventDefault();
        var _btn = $(this);

        var dataStaff=$(this).data('stuff');

        _btn.attr("disabled", true);

        _btn.text(dataStaff['please_wait_lbl']);

        var _reason = $("textarea[name='reason']").val();

        var _bank_id = $(this).parents("#orderCancel").find("input[name='bank_acc_id']:checked").val();

        var flag = false;
        $('.notifyjs-corner').empty();

        if (_reason == '') {
            $("textarea[name='reason']").css("border-color", "red");
            flag = true;

            $.notify(
                dataStaff['cancel_ord_reason_err'], {
                    position: "top right",
                    className: 'error'
                }
            );
        }

        if ((_bank_id == '' || typeof _bank_id == "undefined") && $(this).parents("#orderCancel").find("input[name='gateway']").val() != 'cod') {
            flag = true;

            $.notify(
                dataStaff['cancel_ord_bank_err'], {
                    position: "top right",
                    className: 'error'
                }
            );
        }

        if (flag) {
            _btn.attr("disabled", false);
            _btn.text(dataStaff['cancel_ord_btn']);
        }

        if(!flag) {

            $(".process_loader").show();

            var order_id = $(this).parents("#orderCancel").find("input[name='order_id']").val();
            var product_id = $(this).parents("#orderCancel").find("input[name='product_id']").val();


            var href = base_url + 'site/cancel_product';


            $.ajax({
                type: 'POST',
                url: href,
                data: {
                    "order_id": order_id,
                    "product_id": product_id,
                    'reason': _reason,
                    'bank_id': _bank_id
                },
                success: function(res) {

                    $(".process_loader").hide();
                    var obj = $.parseJSON(res);

                    _btn.attr("disabled", false);
                    _btn.text(dataStaff['cancel_ord_btn']);

                    if (obj.success == 1) {

                        $("#orderCancel").modal("hide");
                        swal({
                            title: dataStaff['cancelled_lbl'],
                            text: obj.msg,
                            type: "success"
                        }, function() {
                            location.reload();
                        });
                    }
                }
            });
        }
    });


    $(".btn_claim").on("click",function(e) {
        e.preventDefault();

        if ($(this).data("gateway") != 'cod') {
            $(".bank_details").show();
        } else {
            $(".bank_details").hide();
        }

        $("#claimRefund").modal("show");

        var order_id = $(this).data("order");
        var product_id = $(this).data("product");

        $("#claimRefund input[name='order_id']").val(order_id);
        $("#claimRefund input[name='product_id']").val(product_id);

        $("body").css("overflow-y", "hidden");

    });

    $(".claim_refund").on("click",function(e) {
        e.preventDefault();

        var _btn = $(this);

        var dataStaff=$(this).data('stuff');

        $(".process_loader").show();

        var _bank_id = $(this).parents("#claimRefund").find("input[name='bank_acc_id']:checked").val();

        var flag = false;

        $('.notifyjs-corner').empty();

        if ((_bank_id == '' || typeof _bank_id == "undefined") && $(this).parents("#orderCancel").find("input[name='gateway']").val() != 'cod') {
            flag = true;

             $(".process_loader").hide();

            $.notify(
                dataStaff['bank_err'], {
                    position: "top right",
                    className: 'error'
                }
            );
        }

        if (!flag) {

            var order_id = $(this).parents("#claimRefund").find("input[name='order_id']").val();
            var product_id = $(this).parents("#claimRefund").find("input[name='product_id']").val();

            var href = base_url + 'site/claim_refund';

            $.ajax({
                type: 'POST',
                url: href,
                data: {
                    "order_id": order_id,
                    "product_id": product_id,
                    'bank_id': _bank_id
                },
                success: function(res) {

                    var obj = $.parseJSON(res);
                    $(".process_loader").hide();
                    if (obj.success == 1) {

                        $("#claimRefund").modal("hide");
                        
                        swal({
                            title: dataStaff['done_lbl'],
                            text: obj.msg,
                            type: "success"
                        }, function() {
                            location.reload();
                        });
                    }
                }
            });
        }

        
    });


    // for quick view

    $(".btn_quick_view").on("click",function(e) {

        e.preventDefault();

        var btn = $(this);
        var _id = $(this).data("id");

        href = base_url + 'site/quick_view';
        $(".process_loader").show();

        $.ajax({
            url: href,
            data: {"product_id": _id},
            type: 'post',
            success: function(res) {

                $(".process_loader").fadeOut();

                var obj = $.parseJSON(res);

                $("#productQuickView .modal-body").html(obj.html_code);
                $("#productQuickView").modal("show");

                $('.modal-tab-menu-active').slick({
                    infinite: true,
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    arrows: false,
                    dots: true,
                    loop: true
                });


                $('.modal').on('shown.bs.modal', function(e) {
                    $('.modal-tab-menu-active').resize();
                });

                $(".img_click > a").on("click",function(e) {
                    var _id = $(this).attr("href");

                    $("#productQuickView").find(".tab-pane").removeClass("active");
                    $("#productQuickView").find(".tab-pane").removeClass("in");

                    $("#productQuickView").find(_id).addClass("active");
                    $("#productQuickView").find(_id).addClass("in");

                });

            }
        });

    });

    // for product page

    $(".list_order").change(function(e) {

        var param=$('#sort_filter_form').serialize();
        
        if(history.pushState) {
          var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?'+param;
          window.history.pushState({path:newurl},'',newurl);
        }

        var target = "#products_list";

        $('html, body').animate({
            scrollTop: ($(target).offset().top)
        }, 100);

        setTimeout(location.reload(), 1000);
    });

    $('.shop-tab a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTabProduct', $(e.target).attr('href'));
    });

    var activeTabProduct = localStorage.getItem('activeTabProduct');

    if (activeTabProduct) {
        $('.shop-tab a[href="' + activeTabProduct + '"]').tab('show');
        $(".shop-product-area .tab-content").find("div").removeClass("active");
        $(".shop-product-area .tab-content").find(activeTabProduct).addClass('active');
    }
    
    $('.discription-tab-menu a[data-toggle="tab"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTabDiscription', $(e.target).attr('href'));
    });

    var activeTabDiscription = localStorage.getItem('activeTabDiscription');

    if (activeTabDiscription) {
        $('.discription-tab-menu a[href="' + activeTabDiscription + '"]').tab('show');
        $(".iscription-tab-content .tab-content").find("div").removeClass("active");
        $(".iscription-tab-content .tab-content").find(activeTabDiscription).addClass('active');
    }


    $("form input").blur(function(e) {

        if($(this).val()!= '')
        {
            $(this).parents(".wizard-form-input").find("p").fadeOut();
        }
        else{

            $(this).parents(".wizard-form-input").find("p").fadeIn();
        }
    });


    // for filters

    function removeURLParameter(url, parameter) {
        
        //prefer to use l.search if you have a location/link object
        var urlparts = url.split('?');
        if (urlparts.length >= 2) {

            var prefix = encodeURIComponent(parameter) + '=';
            var pars = urlparts[1].split(/[&;]/g);

            //reverse iteration as may be destructive
            for (var i = pars.length; i-- > 0;) {
                //idiom for string.startsWith
                if (pars[i].lastIndexOf(prefix, 0) !== -1) {
                    pars.splice(i, 1);
                }
            }

            url = urlparts[0] + '?' + pars.join('&');
            return url;
        } else {
            return url;
        }
    }


    $(".remove_filter").on("click",function(e) {
        e.preventDefault();

        localStorage.removeItem("products_list");

        var uri = window.location.toString();

        var action = $(this).data("action");

        var url = '';

        if (action == 'sort') {
            url = removeURLParameter(uri, 'sort');
            window.location.href = url;
        } else if (action == 'price') {
            url = removeURLParameter(uri, 'price_filter');
            window.location.href = url;
        }else if (action == 'brands') {
            id = $(this).data("id");
            $('.brand_sort[value=' + id + ']').prop('checked', false);
            $("#brand_sort").submit();
        }else if (action == 'size') {
            id = $(this).data("id");
            $('.size_sort[value=' + id + ']').prop('checked', false);
            $("#size_sort").submit();
        }

    });

    // end filter


    // for logout
    $(".btn_logout").on("click",function(e) {
        e.preventDefault();
        var href = $(this).attr("href");
        swal({
            title: Settings.confirm_msg,
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
                            type: 'POST',
                            url: href
                        })
                        .done(function(response) {
                            $(".process_loader").hide();
                            location.reload();
                        })
                        .fail(function(response) {
                            $(".process_loader").hide();
                            swal(Settings.err_something_went_wrong);
                        });

                } else {
                    swal.close();
                }
            });

    });
});

var loadExternalScript = function(path) {
    var result = $.Deferred(),
        script = document.createElement("script");

    script.async = "async";
    script.type = "text/javascript";
    script.src = path;
    script.onload = script.onreadystatechange = function(_, isAbort) {
      if (!script.readyState || /loaded|complete/.test(script.readyState)) {
        if (isAbort)
          result.reject();
        else
          result.resolve();
      }
    };

    script.onerror = function() {
      result.reject();
    };

    $("head")[0].appendChild(script);

    return result.promise();
};

var callRazorPayScript = function(key, title, desc, logo, amount, name, email, contact, theme, order_id) {
      
  loadExternalScript('https://checkout.razorpay.com/v1/checkout.js').then(function() { 
    var options = {
      key: key,
      protocol: 'https',
      hostname: 'api.razorpay.com',
      amount: amount,
      order_id: order_id,
      name: title,
      description: desc,
      image: logo,
      prefill: {
        name: name,
        email: email,
        contact: contact,
      },
      theme: { color: theme},
      handler: function (transaction, response){
        $("#razorpayForm").append("<input name='razorpay_payment_id' type='hidden' value='"+transaction.razorpay_payment_id+"'>");
        $("#razorpayForm").submit();
      }
    };
    window.rzpay = new Razorpay(options);
    rzpay.open();
  });
}