<?php 
    $file_path = base_url().'apis/';
?>
<div class="row" style="padding-left:30px;padding-right: 30px">
      <div class="col-sm-12 col-xs-12">
        <div class="card">
            <div class="card-header">
              <?=$page_title?>
            </div>
                <div class="card-body no-padding">
            
               <pre>
                <code class="html">               
                    <br><b>Home</b> (URL: <?=$file_path?>home) (Parameters: user_id)
                    <br><b>Check Email OTP Status</b> (URL: <?=$file_path?>check_otp_status)
                    <br><b>Get other data</b> (URL: <?=$file_path?>get_data) (Parameters: type[term_of_use, refund_policy, cancel_policy])
                    <br><b>Get Faq</b> (URL: <?=$file_path?>faq) (Parameters: type[faq, payment])
                    <br><b>App Details</b> (URL: <?=$file_path?>app_details) (Parameters: user_id, device_id)
                    <div style="border: 2px solid #FFF;padding: 10px 15px;border-radius:4px;"><p style="font-size:16px;font-weight:600">ALL USERS APIS</p><b>User Login</b> (URL: <?=$file_path?>login) (Parameters: email, password)
                        <br><b>Email Verification</b> (URL: <?=$file_path?>email_verify) (Parameters: email, otp)
                        <br><b>User Registration</b> (URL: <?=$file_path?>register) (Parameters: type(Google, Facebook, Normal), name, email, password, phone, auth_id, device_id, register_platform[web/android/ios])
                        <br><b>User Profile</b> (URL: <?=$file_path?>profile) (Parameters: user_id)
                        <br><b>Edit Profile</b> (URL: <?=$file_path?>edit_profile) (Parameters: id, name, phone, is_remove[true, false]) (File: user_image)
                        <br><b>Change Password</b> (URL: <?=$file_path?>change_password) (Parameters: user_id, old_password, new_password)
                        <br><b>Forgot Password</b> (URL: <?=$file_path?>forgot_password) (Parameters: email)
                        <br><b>My Reviews</b> (URL: <?=$file_path?>my_review) (Parameters: user_id, product_id)
                        <br><b>Users Reviews</b> (URL: <?=$file_path?>users_review) (Parameters: product_id, page, filter_type)
                    </div>
                    <div style="border: 2px solid #FFF;padding: 10px 15px;border-radius:4px;"><p style="font-size:16px;font-weight:600">ALL CONTACT APIS</p><b>Contact Subjects List</b> (URL: <?=$file_path?>contact_subjects) (Parameters: user_id)
                        <br><b>Contact Form</b> (URL: <?=$file_path?>contact_form) (Parameters: contact_name, contact_email, contact_subject, contact_msg)
                    </div>
                    <div style="border: 2px solid #FFF;padding: 10px 15px;border-radius:4px;"><p style="font-size:16px;font-weight:600">ALL LIST & SINGLE APIS</p><b>Brands List</b> (URL: <?=$file_path?>brands) (Parameters: page)
                        <br><b>Category List</b> (URL: <?=$file_path?>categories) (Parameters: page)
                        <br><b>Sub Category List</b> (URL: <?=$file_path?>sub_categories) (Parameters: cat_id, page)
                        <br><b>Offers List</b> (URL: <?=$file_path?>offers) (Parameters: page)
                    </div>
                    <div style="border: 2px solid #FFF;padding: 10px 15px;border-radius:4px;"><p style="font-size:16px;font-weight:600">ALL COUPON APIS</p><b>Coupons List</b> (URL: <?=$file_path?>coupons) (Parameters: user_id, cart_ids, cart_type[main_cart/temp_cart], page)
                        <br><b>Single Coupon</b> (URL: <?=$file_path?>single_coupon) (Parameters: id)
                        <br><b>Apply Coupon</b> (URL: <?=$file_path?>apply_coupon) (Parameters: user_id, coupon_id, cart_ids, cart_type[main_cart/temp_cart])
                        <br><b>Remove Coupon</b> (URL: <?=$file_path?>remove_coupon) (Parameters: user_id, coupon_id, cart_type[main_cart/temp_cart])
                    </div>
                    <div style="border: 2px solid #FFF;padding: 10px 15px;border-radius:4px;"><p style="font-size:16px;font-weight:600">ALL PRODUCT APIS</p><b>Products By Category and Sub Category Wise</b> (URL: <?=$file_path?>productList_cat_sub) (Parameters: cat_id, sub_cat_id, page)
                        <br><b>Products By Brand Wise</b> (URL: <?=$file_path?>products_by_brand) (Parameters: brand_id, page)
                        <br><b>Products By Banner Wise</b> (URL: <?=$file_path?>products_by_banner) (Parameters: banner_id, page)
                        <br><b>Products By Offers Wise</b> (URL: <?=$file_path?>products_by_offer) (Parameters: offer_id, page)
                        <br><b>Single Product</b> (URL: <?=$file_path?>single_product) (Parameters: id, user_id)
                        <br><b>Search Products</b> (URL: <?=$file_path?>search) (Parameters: keyword, page)
                        <br><b>Deal of the day</b> (URL: <?=$file_path?>today_deal) (Parameters: page)
                        <br><b>Get latest products</b> (URL: <?=$file_path?>get_latest_products) (Parameters:  page)
                        <br><b>Get top rated products</b> (URL: <?=$file_path?>get_top_rated_products) (Parameters: page)
                        <br><b>Get recent viewed products</b> (URL: <?=$file_path?>get_recent_viewed_products) (Parameters: user_id, page)
                        <br><b>Product Rating & Reviews</b> (URL: <?=$file_path?>product_review) (Parameters: user_id, product_id, review_desc, rate) (Files: product_images)
                        <br><b>Remove Review Image</b> (URL: <?=$file_path?>remove_review_image) (Parameters: image_id)
                        <br><b>Get ID by slug</b> (URL: <?=$file_path?>get_id_by_slug) (Parameters: product_slug)
                        <br><b>Review Filter Option</b> (URL: <?=$file_path?>review_filter_list) (Parameters: product_id)
                    </div>
                    <div style="border: 2px solid #FFF;padding: 10px 15px;border-radius:4px;"><p style="font-size:16px;font-weight:600">ALL WISHLIST APIS</p><b>Add/Delete Wishlist Items</b> (URL: <?=$file_path?>wishlist) (Parameters: user_id, product_id)
                        <br><b>My Wishlist</b> (URL: <?=$file_path?>my_wishlist) (Parameters: user_id, page)
                        <br><b>Empty Wishlist</b> (URL: <?=$file_path?>empty_wishlist) (Parameters: user_id)
                    </div>
                    <div style="border: 2px solid #FFF;padding: 10px 15px;border-radius:4px;"><p style="font-size:16px;font-weight:600">ALL CART APIS</p><b>Cart Add/Update</b> (URL: <?=$file_path?>cart_add_update) (Parameters: product_id, user_id, product_qty, buy_now [true, false], product_size, device_id(Only for update cart))
                        <br><b>My Cart</b> (URL: <?=$file_path?>my_cart) (Parameters: user_id)
                        <br><b>Remove Cart Item</b> (URL: <?=$file_path?>cart_item_delete) (Parameters: cart_id, user_id)
                        <br><b>Remove Temp Cart</b> (URL: <?=$file_path?>remove_temp_cart) (Parameters: user_id, device_id)
                    </div>
                    <div style="border: 2px solid #FFF;padding: 10px 15px;border-radius:4px;"><p style="font-size:16px;font-weight:600">ALL ORDER APIS</p><b>Order Summary</b> (URL: <?=$file_path?>order_summary) (Parameters: user_id, buy_now[true, false], product_id, product_size, device_id)
                        <br><b>Order Details</b> (URL: <?=$file_path?>order_detail) (Parameters: order_id, product_id)
                        <br><b>My Orders</b> (URL: <?=$file_path?>my_order) (Parameters: user_id, page)
                        <br><b>Order Status Track</b> (URL: <?=$file_path?>order_status) (Parameters: order_id, user_id, product_id)
                        <br><span><b>Cancel Order/Product</b> (URL: <?=$file_path?>order_or_product_cancel) (Parameters: user_id, order_id, product_id(0 for whole order cancel), reason, bank_id(0 for cod payment mode))</span>
                        <br><span><b>Claim Order/Product Refund</b> (URL: <?=$file_path?>claim_refund) (Parameters: user_id, order_id, product_id(0 for whole order claim), bank_id(0 for cod payment mode))</span>
                    </div>
                    <div style="border: 2px solid #FFF;padding: 10px 15px;border-radius:4px;"><p style="font-size:16px;font-weight:600">ALL PAYMENT RELATED APIS</p><br><b>Generate Paypal Payable Amount</b> (URL: <?=$file_path?>generate_paypal_amount) (Parameters: user_id, cart_ids, cart_type[main_cart/temp_cart])
                        <br/><span><b>Payment</b> (URL: <?=$file_path?>payment) (Parameters: user_id, coupon_id, address_id, cart_ids, gateway, payment_id, razorpay_order_id, cart_type[main_cart/temp_cart])</span>
                        <br><span><b>Payment Details</b> (URL: <?=$file_path?>payment_details)</span>
                        <br><span><b>Stripe Valid Checkout Amount</b> (URL: <?=$file_path?>stripe_validate_checkout_amt) (Parameters: user_id, cart_ids, cart_type[main_cart/temp_cart])</span>
                        <br><span><b>Generate Stripe Payment Token</b> (URL: <?=$file_path?>stripe_token) (Parameters: user_id, cart_ids, cart_type[main_cart/temp_cart])</span>
                        <br><span><b>Generate Razorpay Order ID</b> (URL: <?=$file_path?>razorpay_order_id) (Parameters: user_id, cart_ids, cart_type[main_cart/temp_cart])</span>
                    </div>
                    <div style="border: 2px solid #FFF;padding: 10px 15px;border-radius:4px;"><p style="font-size:16px;font-weight:600">ALL ADDRESS APIS</p><b>Get Single Address data</b> (URL: <?=$file_path?>single_address) (Parameters: address_id)
                        <br><b>Add/Edit Address</b> (URL: <?=$file_path?>addedit_address) (Parameters: type(add/edit), id(Only for Edit Address), user_id, pincode, building_name, road_area_colony, city, district, state, country, landmark, name, mobile_no, alter_mobile_no, address_type)
                        <br><b>Get Address List</b> (URL: <?=$file_path?>get_addresses) (Parameters: user_id)
                        <br><b>Change Address</b> (URL: <?=$file_path?>change_address) (Parameters: address_id, user_id)
                        <br><b>Delete Address</b> (URL: <?=$file_path?>delete_address) (Parameters: id, user_id)
                        <br><b>Check Address Available</b> (URL: <?=$file_path?>is_address_avail) (Parameters: user_id)
                        <br><b>Get Country List</b> (URL: <?=$file_path?>get_countries) (Parameters: user_id)
                    </div>
                    <div style="border: 2px solid #FFF;padding: 10px 15px;border-radius:4px;"><p style="font-size:16px;font-weight:600">ALL FILTER APIS</p><b>Get Filter List</b> (URL: <?=$file_path?>filter_list) (Parameters: type[banner, brand, offer, today_deal, recent_viewed_products, search, productList_cat, productList_cat_sub, latest_products, top_rated_products], id, sort, keyword, user_id)</span>
                        <br><b>Price Filter</b> (URL: <?=$file_path?>price_filter) (Parameters: type[banner, brand, offer, today_deal, recent_viewed_products, search, productList_cat, productList_cat_sub, latest_products, top_rated_products], id, keyword, user_id, pre_min, pre_max)</span>
                        <br><b>Brand Filter</b> (URL: <?=$file_path?>brand_filter) (Parameters: type[banner, brand, offer, today_deal, recent_viewed_products, search, productList_cat, productList_cat_sub, latest_products, top_rated_products], id, keyword, user_id, brand_ids)</span>
                        <br><b>Size Filter</b> (URL: <?=$file_path?>size_filter) (Parameters: type[banner, brand, offer, today_deal, recent_viewed_products, search, productList_cat, productList_cat_sub, latest_products, top_rated_products], id, brand_ids, keyword, user_id, sizes)</span>                       
                        <br><b>Apply Filter</b> (URL: <?=$file_path?>apply_filter) (Parameters: type [banner, brand, offer, today_deal, recent_viewed_products, search, productList_cat, productList_cat_sub, latest_products, top_rated_products], user_id, id, brand_ids, sizes, sort, min_price, max_price, keyword)</span>    
                    </div>
                    <div style="border: 2px solid #FFF;padding: 10px 15px;border-radius:4px;"><p style="font-size:16px;font-weight:600">ALL BANK APIS</p><span><b>Get Bank List</b> (URL: <?=$file_path?>get_bank_list) (Parameters: user_id)</span>
                    <br><span><b>Get Single Bank</b> (URL: <?=$file_path?>get_bank_details) (Parameters: bank_id, user_id)</span>
                    <br><span><b>Add/Edit Bank Account</b> (URL: <?=$file_path?>addedit_bank_account) (Parameters: type(add/edit), bank_id(Only for Edit Bank), user_id, bank_name, account_no, bank_ifsc, account_type[saving, current], name, phone, email, is_default)</span>
                    <br><span><b>Delete Bank Account</b> (URL: <?=$file_path?>delete_bank_account) (Parameters: bank_id, user_id)</span>
                    </div>
                    
                </code> 
             </pre>
          
              </div>
            </div>
        </div>
</div>
<br/>
<div class="clearfix"></div>   
