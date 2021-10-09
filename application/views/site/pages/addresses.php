<?php 
  $this->load->view('site/layout/breadcrumb'); 
  $ci =& get_instance();

  // print_r($addresses);

?>

<div class="product-list-grid-view-area mt-20">
	  <div class="container">
	    <div class="row"> 
			<div class="col-lg-3 col-md-3 mb_40"> 
		        <?php $this->load->view('site/layout/sidebar_my_account'); ?>
			</div>
			<div class="col-lg-9 col-md-9">
				<div class="my_profile_area_detail">
					<div class="checkout-title">
					  <h3><?=$this->lang->line('addresses_lbl')?></h3>
					</div>
					<div class="address_details_block">
					  <?php
					  	if(!empty($addresses))
						{
					  	foreach ($addresses as $key => $value) {
					  ?>
					  <div class="address_details_item">
						<div class="address_list">
						  <div class="home_address"><?=($value->address_type==1) ? $this->lang->line('home_address_val_lbl') : $this->lang->line('office_address_val_lbl')?></div>
						  <span><?=$value->name?> <?=$value->mobile_no?></span>
						  <div class="address_list_edit">
							<a href="javascript:void(0)" class="btn_edit_address" data-stuff='<?php echo htmlentities(json_encode($value)); ?>'><?=$this->lang->line('edit_btn')?></a>
							<a href="javascript:void(0)" class="btn_delete_address" data-id="<?=$value->id?>"><?=$this->lang->line('delete_btn')?></a>
						  </div>
						  <p>
						  	<?=$value->building_name.', '.$value->road_area_colony.', '.$value->city.', '.$value->state.', '.$value->country.' - '.$value->pincode;?>
						  </p>

						</div>            
					  </div>
					  <?php }
						}
							else{
							echo '<div class="col-md-12 text-center" style="padding: 1em 0px 1em 0px">
									<h3>'.$this->lang->line('no_address_lbl').'	
								 </div><div class="clearfix"></div>';
							}
					  ?>
					  <div class="address_details_item" style="border-top:1px solid rgba(0, 0, 0, 0.1);">
						<a href="" class="btn_new_address">
						  <div class="address_list" style="padding: 15px 5px">
							<i class="fa fa-plus"></i> <?=$this->lang->line('add_new_address_lbl')?>
						  </div>
						</a>
					  </div>

					  <div class="ceckout-form add_addresss_block" style="display: none;margin-top:15px;">
						<form action="<?php echo site_url('site/addAddress'); ?>" method="post" name="address_form">
						  <div class="billing-fields">

							<div class="row">
			                    <div class="col-md-6">
			                      <div class="wizard-form-field">
			                        <div class="wizard-form-input has-float-label">
			                          <input type="text" name="billing_name" value="" required="" placeholder="<?=$this->lang->line('name_place_lbl')?>">
			                          <label><?=$this->lang->line('name_place_lbl')?></label>
			                        </div>
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="wizard-form-field">
			                        <div class="wizard-form-input has-float-label">
			                          <input type="email" name="billing_email" value="" required="" placeholder="<?=$this->lang->line('email_place_lbl')?>">
			                          <label><?=$this->lang->line('email_place_lbl')?></label>
			                        </div>
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="wizard-form-field">
			                        <div class="wizard-form-input has-float-label">
			                          <input type="text" name="billing_mobile_no" value="" required="" placeholder="<?=$this->lang->line('phone_no_place_lbl')?>" onkeypress="return isNumberKey(event)" maxlength="15">
			                          <label><?=$this->lang->line('phone_no_place_lbl')?></label>
			                        </div>
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="wizard-form-field">
			                        <div class="wizard-form-input has-float-label">
			                          <input type="text" name="alter_mobile_no" value="" placeholder="<?=$this->lang->line('alt_phone_no_place_lbl')?>" onkeypress="return isNumberKey(event)" maxlength="15">
			                          <label><?=$this->lang->line('alt_phone_no_place_lbl')?></label>
			                        </div>
			                      </div>
			                    </div>
			                    
			                    <div class="col-md-12">
			                      <div class="wizard-form-field">
			                        <div class="wizard-form-input has-float-label">
			                          <textarea placeholder="<?=$this->lang->line('address_place_lbl')?>" name="building_name" style="background: #fff" required=""></textarea>
			                          <label><?=$this->lang->line('address_place_lbl')?></label>
			                        </div>
			                      </div>
			                    </div>
			                    <div class="col-md-12">
			                      <div class="wizard-form-field">
			                        <div class="wizard-form-input has-float-label">
			                          <input type="text" name="road_area_colony" value="" required="" placeholder="<?=$this->lang->line('road_area_colony_lbl')?>">
			                          <label><?=$this->lang->line('road_area_colony_lbl')?></label>
			                        </div>
			                      </div>
			                    </div>
			                    <div class="col-md-12">
			                      <div class="wizard-form-field">
			                        <div class="wizard-form-input has-float-label">
			                          <input type="text" name="landmark" value="" placeholder="<?=$this->lang->line('landmark_place_lbl')?>">
			                          <label><?=$this->lang->line('landmark_place_lbl')?></label>
			                        </div>
			                      </div>
			                    </div>
			                    
			                    <div class="col-md-6">
			                      <select name="country" id="country" data-placeholder="Choose country...." tabindex="-1" style="background: rgba(255,255,255,1) url(assets/site_assets/img/arow.png) no-repeat scroll 97% center;border-radius: 4px;height: 50px;margin-bottom:20px" required="">
			                        <option value="0"><?=$this->lang->line('country_place_lbl')?></option>
			                    <?php 
			                       $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
			                      ?>
			                        <?php 
			                          foreach ($countries as $key => $value) {
			                            ?>
			                            <option value="<?=$value?>"><?=$value?></option>
			                            <?php
			                          }
			                        ?>
			                      </select>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="wizard-form-field">
			                        <div class="wizard-form-input has-float-label">
			                          <input type="text" name="state" value="" required="" placeholder="<?=$this->lang->line('state_place_lbl')?>">
			                          <label><?=$this->lang->line('state_place_lbl')?></label>
			                        </div>
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="wizard-form-field">
			                        <div class="wizard-form-input has-float-label">
			                          <input type="text" name="district" value="" placeholder="<?=$this->lang->line('district_place_lbl')?>">
			                          <label><?=$this->lang->line('district_place_lbl')?></label>
			                        </div>
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="wizard-form-field">
			                        <div class="wizard-form-input has-float-label">
			                          <input type="text" name="city" value="" required="" placeholder="<?=$this->lang->line('city_place_lbl')?>">
			                          <label><?=$this->lang->line('city_place_lbl')?></label>
			                        </div>
			                      </div>
			                    </div>
			                    <div class="col-md-6">
			                      <div class="wizard-form-field">
			                        <div class="wizard-form-input has-float-label">
			                          <input type="text" name="pincode" value="" required="" placeholder="<?=$this->lang->line('zipcode_place_lbl')?>" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" maxlength="7">
			                          <label><?=$this->lang->line('zipcode_place_lbl')?></label>
			                        </div>
			                      </div>
			                    </div>
			                    <div class="col-md-12">
			                      <p>
			                        <label><?=$this->lang->line('address_type_lbl')?><span class="required">*</span></label>
			                      </p>
			                        <div class="clearfix"></div>
			                        <label class="radio-inline">
			                          <input type="radio" name="address_type" value="1" readonly="" style="width: 20px;height: 15px" checked><?=$this->lang->line('home_address_lbl')?>
			                        </label>
			                        <label class="radio-inline">
			                          <input type="radio" name="address_type" readonly="" value="2" style="width: 20px;height: 15px"><?=$this->lang->line('office_address_lbl')?>
			                        </label>
			                    </div>
			                  </div>
							<br/>
							
							<div class="form-fild">
							  <div class="add-to-link">
								<button class="form-button" type="submit" data-text="save"><?=$this->lang->line('save_btn')?></button>
								<button class="form-button close_form" type="button"><?=$this->lang->line('close_btn')?></button>
							  </div>
							</div>
						  </div>               
						</form>
					  </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div id="edit_address" class="modal fade" role="dialog" style="z-index: 99999">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="modal-details">
					<div style="background: none;border:none;">
						<form action="" method="post" id="edit_address_form">
						  <input type="hidden" name="address_id">
						  <div class="billing-fields">
							<div class="row">
				                <div class="col-md-6">
				                  <div class="wizard-form-field">
				                    <div class="wizard-form-input has-float-label">
				                      <input type="text" name="billing_name" value="" required="" placeholder="<?=$this->lang->line('name_place_lbl')?>">
				                      <label><?=$this->lang->line('name_place_lbl')?></label>
				                    </div>
				                  </div>
				                </div>
				                <div class="col-md-6">
				                  <div class="wizard-form-field">
				                    <div class="wizard-form-input has-float-label">
				                      <input type="email" name="billing_email" value="" required="" placeholder="<?=$this->lang->line('email_place_lbl')?>">
				                      <label><?=$this->lang->line('email_place_lbl')?></label>
				                    </div>
				                  </div>
				                </div>
				                
				                <div class="col-md-6">
				                  <div class="wizard-form-field">
				                    <div class="wizard-form-input has-float-label">
				                      <input type="text" name="billing_mobile_no" value="" required="" placeholder="<?=$this->lang->line('phone_no_place_lbl')?>" onkeypress="return isNumberKey(event)" maxlength="15">
				                      <label><?=$this->lang->line('phone_no_place_lbl')?></label>
				                    </div>
				                  </div>
				                </div>
				                <div class="col-md-6">
				                  <div class="wizard-form-field">
				                    <div class="wizard-form-input has-float-label">
				                      <input type="text" name="alter_mobile_no" value="" placeholder="<?=$this->lang->line('alt_phone_no_place_lbl')?>" onkeypress="return isNumberKey(event)" maxlength="15">
				                      <label><?=$this->lang->line('alt_phone_no_place_lbl')?></label>
				                    </div>
				                  </div>
				                </div>
				                
				                <div class="col-md-12">
				                  <div class="wizard-form-field">
				                    <div class="wizard-form-input has-float-label">
				                      <textarea placeholder="<?=$this->lang->line('address_place_lbl')?>" name="building_name" required=""></textarea>
				                      <label><?=$this->lang->line('address_place_lbl')?></label>
				                    </div>
				                  </div>
				                </div>
				                <div class="col-md-12">
				                  <div class="wizard-form-field">
				                    <div class="wizard-form-input has-float-label">
				                      <input type="text" name="road_area_colony" value="" required="" placeholder="<?=$this->lang->line('road_area_colony_place_lbl')?>">
				                      <label><?=$this->lang->line('road_area_colony_place_lbl')?></label>
				                    </div>
				                  </div>
				                </div>
				                <div class="col-md-12">
				                  <div class="wizard-form-field">
				                    <div class="wizard-form-input has-float-label">
				                      <input type="text" name="landmark" value="" placeholder="<?=$this->lang->line('landmark_place_lbl')?>">
				                      <label><?=$this->lang->line('landmark_place_lbl')?></label>
				                    </div>
				                  </div>
				                </div>
				                <div class="col-md-6">
				                  <select name="country" id="country" data-placeholder="Choose country...." tabindex="-1" style="background: rgba(255,255,255,1) url(assets/site_assets/img/arow.png) no-repeat scroll 97% center;border-radius: 4px;height: 50px;margin-bottom:20px" required="">
				                    <option value="0"><?=$this->lang->line('country_place_lbl')?></option>
				                    <?php 
				                      $countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");
				                    ?>
				                    <?php 
				                      foreach ($countries as $key => $value) {
				                        ?>
				                        <option value="<?=$value?>"><?=$value?></option>
				                        <?php
				                      }
				                    ?>
				                  </select>
				                </div>
				                <div class="col-md-6">
				                  <div class="wizard-form-field">
				                    <div class="wizard-form-input has-float-label">
				                      <input type="text" name="state" value="" required="" placeholder="<?=$this->lang->line('state_place_lbl')?>">
				                      <label><?=$this->lang->line('state_place_lbl')?></label>
				                    </div>
				                  </div>
				                </div>
				                <div class="col-md-6">
			                      <div class="wizard-form-field">
			                        <div class="wizard-form-input has-float-label">
			                          <input type="text" name="district" value="" placeholder="<?=$this->lang->line('district_place_lbl')?>">
			                          <label><?=$this->lang->line('district_place_lbl')?></label>
			                        </div>
			                      </div>
			                    </div>
				                <div class="col-md-6">
				                  <div class="wizard-form-field">
				                    <div class="wizard-form-input has-float-label">
				                      <input type="text" name="city" value="" required="" placeholder="<?=$this->lang->line('city_place_lbl')?>">
				                      <label><?=$this->lang->line('city_place_lbl')?></label>
				                    </div>
				                  </div>
				                </div>
				                <div class="col-md-6">
				                  <div class="wizard-form-field">
				                    <div class="wizard-form-input has-float-label">
				                      <input type="text" name="pincode" value="" required="" placeholder="<?=$this->lang->line('zipcode_place_lbl')?>" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')" maxlength="7">
				                      <label><?=$this->lang->line('zipcode_place_lbl')?></label>
				                    </div>
				                  </div>
				                </div>
				                <div class="col-md-12">
				                    <p>
				                      <label><?=$this->lang->line('address_type_lbl')?><span class="required">*</span></label>
				                    </p>
				                      <div class="clearfix"></div>
				                      <label class="radio-inline">
				                        <input type="radio" name="address_type" value="1" readonly="" style="width: 20px;height: 15px" checked><?=$this->lang->line('home_address_lbl')?>
				                      </label>
				                      <label class="radio-inline">
				                        <input type="radio" name="address_type" readonly="" value="2" style="width: 20px;height: 15px"><?=$this->lang->line('office_address_lbl')?>
				                      </label>
				                </div>
				            </div>
							<br/>
							
							<div class="form-fild">
							  <div class="add-to-link">
								<button class="form-button" type="submit" data-text="save"><?=$this->lang->line('save_btn')?></button>
								<button class="form-button" type="button" data-dismiss="modal"><?=$this->lang->line('close_btn')?></button>
							  </div>
							</div>
						  </div>               
						</form>
					  </div>
				</div>
			</div>
		</div>
	</div>
</div>

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
