<?php

// validation
global $ct_options;

if ( isset( $_REQUEST['uid'] ) ) {
	// init variables
	$uid = $_REQUEST['uid'];
	if ( ! CT_Hotel_Cart::get( $uid ) ) {
		do_action( 'ct_hotel_booking_wrong_data' ); // ct_redirect_home() - if data is not valid return to home
		exit;
	}

	$cart = new CT_Hotel_Cart();
	$hotel_id = $cart->get_field( $uid, 'hotel_id' );
	$date_from = $cart->get_field( $uid, 'date_from' );
	$date_to = $cart->get_field( $uid, 'date_to' );
	$cart_rooms = $cart->get_field( $uid, 'room' );
	$cart_service = $cart->get_field( $uid, 'add_service' );
	$user_info = ct_get_current_user_info();
	$_countries = ct_get_all_countries();
	$deposit_rate = get_post_meta( $hotel_id, '_hotel_security_deposit', true );
	$deposit_rate = empty( $deposit_rate ) ? 0 : $deposit_rate;
$get_stylesheet_directory = esc_url( get_stylesheet_directory_uri() );
	// function
	if ( ! ct_get_hotel_thankyou_page() ) { ?>
		<h5 class="alert alert-warning"><?php echo esc_html__( 'Please set booking confirmation page in theme options panel.', 'citytours' ) ?></h5>
	<?php } else { ?>

		<form id="booking-form" name="booking_form" action="<?php echo esc_url( ct_get_hotel_thankyou_page() ); ?>">
			<div class="row">
				<div class="col-md-8">
					<?php do_action( 'hotel_checkout_main_before' ); ?>
					<div class="form_title">
						<h3><strong>1</strong><?php echo esc_html__( 'Your Details', 'citytours' ) ?></h3>
						<p><?php echo esc_html__( 'Please fill your detail.', 'citytours' ) ?></p>
					</div>
					<div class="step">
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__( 'First name', 'citytours' ) ?></label>
								<input type="text" class="form-control" name="first_name" value="<?php echo esc_attr( $user_info['first_name'] ) ?>">
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__( 'Last name', 'citytours' ) ?></label>
								<input type="text" class="form-control" name="last_name" value="<?php echo esc_attr( $user_info['last_name'] ) ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__( 'Email', 'citytours' ) ?></label>
								<input type="email" name="email" class="form-control" value="<?php echo esc_attr( $user_info['email'] ) ?>">
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__( 'Confirm email', 'citytours' ) ?></label>
								<input type="email" name="email2" class="form-control">
							</div>
						</div>
					</div>
					 <div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__( 'Telephone', 'citytours' ) ?></label>
								<input type="text" name="phone" class="form-control" value="<?php echo esc_attr( $user_info['phone'] ) ?>">
							</div>
						</div>
					</div>
				</div><!--End step -->

				<div class="form_title">
					<h3><strong>2</strong><?php echo esc_html__( 'Your Address', 'citytours' ) ?></h3>
					<p><?php echo esc_html__( 'Please write your address detail', 'citytours' ) ?></p>
				</div>
				<div class="step">
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__( 'Country', 'citytours' ) ?></label>
								<select class="form-control" name="country" id="country">
									<option value="" selected><?php echo esc_html__( 'Select your country', 'citytours' ) ?></option>
									<?php foreach ( $_countries as $_country ) { ?>
										<option value="<?php echo esc_attr( $_country['code'] ) ?>" <?php selected( $user_info['country_code'], $_country['code'] ); ?>><?php echo esc_html( $_country['name'] ) ?></option>
									<?php } ?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__( 'Street line 1', 'citytours' ) ?></label>
								<input type="text" name="address1" class="form-control" value="<?php echo esc_attr( $user_info['address1'] ) ?>">
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__( 'Street line 2', 'citytours' ) ?></label>
								<input type="text" name="address2" class="form-control" value="<?php echo esc_attr( $user_info['address2'] ) ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label><?php echo esc_html__( 'City', 'citytours' ) ?></label>
								<input type="text" name="city" class="form-control" value="<?php echo esc_attr( $user_info['city'] ) ?>">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label><?php echo esc_html__( 'State', 'citytours' ) ?></label>
								<input type="text" name="state" class="form-control" value="<?php echo esc_attr( $user_info['state'] ) ?>">
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label><?php echo esc_html__( 'Postal code', 'citytours' ) ?></label>
								<input type="text" name="zip" class="form-control" value="<?php echo esc_attr( $user_info['zip'] ) ?>">
							</div>
						</div>
					</div><!--End row -->
				</div><!--End step -->

				<?php if ( ! empty( $ct_options['pay_paypal'] ) ) : ?>
					<div class="form_title">
						<h3><strong>3</strong><?php echo esc_html__( 'Payment Information', 'citytours' ) ?></h3>
						<?php if ( ! empty( $ct_options['credit_card'] ) ) { ?>
						<p><?php echo esc_html__( 'Please select payment type', 'citytours' ) ?></p>
						<?php } else { ?>
						<p><?php echo esc_html__( 'You"ll be redirected to paypal to pay for this tour', 'citytours' ) ?></p>
						<?php } ?>
					</div>
					<div class="step">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<?php if ( ! empty( $ct_options['credit_card'] ) ) { ?>
									<input class="form-radio-control" type="radio" name="payment_info" id="paypal_payment" value="paypal">
									<label for="paypal_payment"><?php echo esc_html__( 'Paypal', 'citytours' ) ?></label>
									<br/>
									<?php } ?>
									<img src="https://www.paypalobjects.com/webstatic/mktg/Logo/AM_SbyPP_mc_vs_ms_ae_UK.png" alt="PayPal Acceptance Mark">
									<a href="https://www.paypal.com/us/webapps/mpp/paypal-popup" class="about_paypal" onclick="javascript:window.open('https://www.paypal.com/us/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;" title="What is PayPal?"><?php echo esc_html__( 'What is PayPal?', 'citytours' ) ?></a>
								</div>

								<div id="paypal-container">
									<p class="paypal_desc"><?php echo esc_html__( 'Pay via PayPal; you can pay with your credit card if you don’t have a PayPal account.', 'citytours' ) ?></p>
								</div>

								<?php 
								if ( ! empty( $ct_options['credit_card'] ) ) { 
								 ?>

								<div class="form-group">
									<input class="form-radio-control" type="radio" name="payment_info" id="cc_payment" value="cc">
									<label for="cc_payment"><?php echo esc_html__( 'Credit Card', 'citytours' ) ?></label>
								</div>

								<?php $billing_credircard = isset($_REQUEST['billing_credircard'])? esc_attr($_REQUEST['billing_credircard']) : ''; ?>
								<!-- Credit Card Payment -->
								<div id="cc-container" style="display:none;">
									<div class="row">
										<div class="col-md-6 col-sm-6">
											<div class="form-group">
												<label><?php echo esc_html__( 'Card Number', 'citytours' ) ?></label>
												<input class="form-control" type="text" size="19" maxlength="19" name="billing_credircard" value="<?php echo $billing_credircard; ?>" />
											</div>
										</div>
										<div class="col-md-6 col-sm-6">
											<div class="form-group">
												<label><?php echo esc_html__( 'Card Type', 'citytours' ) ?></label>
												<select name="billing_cardtype" class="form-control">
													<option value="Visa" selected="selected">Visa</option>
													<option value="MasterCard">MasterCard</option>
													<option value="Discover">Discover</option>
													<option value="Amex">American Express</option>
												</select>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-6 col-sm-6">
											<div class="form-group">
												<label><?php echo esc_html__( 'Expiration Date', 'citytours' ) ?></label>
												<div class="row">
													<div class="col-md-6 col-sm-6">
														<select name="billing_expdatemonth" class="form-control">
															<option value=1>01</option>
															<option value=2>02</option>
															<option value=3>03</option>
															<option value=4>04</option>
															<option value=5>05</option>
															<option value=6>06</option>
															<option value=7>07</option>
															<option value=8>08</option>
															<option value=9>09</option>
															<option value=10>10</option>
															<option value=11>11</option>
															<option value=12>12</option>
														</select>
													</div>
													<div class="col-md-6 col-sm-6">
														<select name="billing_expdateyear" class="form-control">
															<?php
															$today = (int)date('Y', time());
															for($i = 0; $i < 8; $i++) {
															?>
																<option value="<?php echo $today; ?>"><?php echo $today; ?></option>
															<?php
																$today++;
															} ?>
														</select>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-6 col-sm-6">
											<div class="form-group">
												<label><?php echo esc_html__( 'Card Verification Number (CVV)', 'citytours' ) ?></label>
												<input class="form-control" type="text" size="4" maxlength="4" name="billing_ccvnumber" value="" />
											</div>
										</div>
									</div>
								</div>
								<?php 
								}
								 ?>
								<!-- End Credit Card Payment -->
								
								<div class="form-group">									
									<input class="form-radio-control" type="radio" name="payment_info" id="bkash_payment" value="bkash" checked>
									<label for="bkash_payment"><?php echo esc_html__( 'bkash', 'citytours' ) ?></label>								
									<img src="<?php echo $get_stylesheet_directory; ?>/img/bkash_logo.png" alt="bKash Logo">
									<a href="https://www.bkash.com/about/company-profile" class="about_paypal" onclick="javascript:window.open('https://www.bkash.com/about/company-profile','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;" title="What is bKash?"><?php echo esc_html__( 'What is bKash?', 'citytours' ) ?></a>
								</div>

								<div id="bkash-container">
									<p class="bkash_desc"><?php echo esc_html__( 'Pay via bkash to +88 01977717716 number', 'citytours' ) ?></p>
								</div>	
								<!-- End bkash Payment -->
								
								<div class="form-group">									
									<input class="form-radio-control" type="radio" name="payment_info" id="ghuri_bank_account" value="ghuri_bank_account" checked>
									<label for="ghuri_bank_account"><?php echo esc_html__( 'Pay at our Ghuri Bank Account', 'citytours' ) ?></label>								
									<img src="<?php echo $get_stylesheet_directory; ?>/img/easyPayWay.png" alt="Easy Pay Way">
									<a href="https://easypayway.com/index.php" class="about_easypayway" onclick="javascript:window.open('https://easypayway.com/index.php','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;" title="What is bKash?"><?php echo esc_html__( 'What is easy pay way?', 'citytours' ) ?></a>
								</div>
								<!-- End easy pay Payment -->
								
								<div class="form-group">									
									<input class="form-radio-control" type="radio" name="payment_info" id="hotel_payment" value="pay_hotel" checked>
									<label for="hotel_payment"><?php echo esc_html__( 'Pay at hotel', 'citytours' ) ?></label>
								</div>
								
							</div>
						</div>
					</div><!--End step -->
				<?php endif; ?>
					<div id="policy">

						<?php
						if ( ! empty( $ct_options['hotel_terms_page'] ) ) : ?>
							<h4><?php echo esc_html__( 'Cancellation policy', 'citytours' ) ?></h4>
							<div class="form-group">
								<label><input name="agree" value="agree" type="checkbox" checked><?php printf( __('By continuing, you agree to the <a href="%s" target="_blank"><span class="skin-color">Terms and Conditions</span></a>.', 'citytours' ), ct_get_permalink_clang( $ct_options['hotel_terms_page'] ) ) ?></label>
							</div>
						<?php endif; ?>
						<button type="submit" class="btn_1 green medium book-now-btn book-now-btn1"><?php echo esc_html__( 'Book now', 'citytours' ) ?></button>
					</div>
					<?php do_action( 'hotel_checkout_main_after' ); ?>
				</div>
				<aside class="col-md-4">
					<?php do_action( 'hotel_checkout_sidebar_before' ); ?>
					<div class="box_style_1">
						<h3 class="inner"><?php echo esc_html__( '- Summary -', 'citytours' ) ?></h3>
						<table class="table table_summary">
						<tbody>
							<tr>
								<td><?php echo esc_html__( 'Check in', 'citytours' ) ?></td>
								<td class="text-right"><?php echo date( 'j F Y', ct_strtotime( $date_from ) ); ?></td>
							</tr>
							<tr>
								<td><?php echo esc_html__( 'Check out', 'citytours' ) ?></td>
								<td class="text-right"><?php echo date( 'j F Y', ct_strtotime( $date_to ) ); ?></td>
							</tr>
							<tr>
								<td><?php echo esc_html__( 'Rooms', 'citytours' ) ?></td>
								<td class="text-right">
									<?php if ( ! empty( $cart_rooms ) ) {
										foreach ($cart_rooms as $room_id => $room_data ) {
											echo esc_html( $room_data['rooms'] . ' ' . get_the_title( $room_id ) ) . '<br>';
										}
									}?>
								</td>
							</tr>
							<tr>
								<td>
									<?php echo esc_html__( 'Nights', 'citytours' ) ?>
								</td>
								<td class="text-right">
									<?php echo ct_get_day_interval( $date_from, $date_to ) ?>
								</td>
							</tr>
							<tr>
								<td><?php echo esc_html__( 'Adults', 'citytours' ) ?></td>
								<td class="text-right"><?php echo ct_get_cart_field( $uid, 'total_adults' ) ?></td>
							</tr>
							<tr>
								<td><?php echo esc_html__( 'Children', 'citytours' ) ?></td>
								<td class="text-right"><?php echo ct_get_cart_field( $uid, 'total_kids' ) ?></td>
							</tr>
							<?php if ( ! empty( $cart_service ) ) {
								foreach ( $cart_service as $key => $service ) { ?>
									<tr>
										<td><?php echo esc_html( $service['title'] ) ?></td>
										<td class="text-right"><?php echo ct_price( $service['total'] ); ?></td>
									</tr>
							<?php }} ?>
							<tr class="total">
								<td><?php echo esc_html__( 'Total cost', 'citytours' ) ?></td>
								<td class="text-right"><?php $total_price = ct_get_cart_field( $uid, 'total_price' ); if ( ! empty( $total_price ) ) echo ct_price( $total_price ) ?></td>
							</tr>
							<?php if ( ! empty( $deposit_rate ) && $deposit_rate < 100 ) : ?>
								<tr>
									<td><?php echo sprintf( esc_html__( 'Security Deposit (%d%%)', 'citytours' ), $deposit_rate ) ?></td>
									<td class="text-right"><?php if ( ! empty( $total_price ) ) echo ct_price( $total_price * $deposit_rate / 100 ) ?></td>
								</tr>
							<?php endif; ?>
						</tbody>
						</table>
						<button type="submit" class="btn_full book-now-btn"><?php echo esc_html__( 'Book now', 'citytours' ) ?></button>
						<a class="btn_full_outline" href="<?php echo esc_url( get_permalink( $hotel_id ) ) ?>"><i class="icon-right"></i> <?php echo esc_html__( 'Modify your search', 'citytours' ) ?></a>
						<input type="hidden" name="action" value="ct_hotel_submit_booking">
						<input type="hidden" name="order_id" id="order_id" value="0">
						<input type="hidden" name="uid" value="<?php echo esc_attr( $uid ) ?>">
						<?php wp_nonce_field( 'checkout' ); ?>
					</div>
					<?php do_action( 'hotel_checkout_sidebar_after' ); ?>
				</aside>
			</div><!--End row -->
		</form>
		
		<?php
	date_default_timezone_set('Asia/Dhaka');
	//Generate Unique Transaction ID
	function rand_string( $length ) {
		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";	

		$size = strlen( $chars );
		for( $i = 0; $i < $length; $i++ ) {
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}

		return $str;
	}
	$cur_random_value=rand_string(17);

	?> 
	
	<form action="https://www.easypayway.com/secure_pay/paynow.php" method="post" name="booking_form2">
		<input type="hidden" name="store_id" value="ghuri.online">
		<input type="hidden" name="signature_key" value="f6b22412b98bcac79096803f1d7c2f"> <!--put your signature key -->
		<input type="hidden" name="tran_id" value="<?php echo "$cur_random_value"; ?>">
		<input type="hidden" name="amount" value="<?php echo $total_price; ?>">
		<input type="hidden" name="payment_type" value="VISA">
		<input type="hidden" name="currency" value="BDT">
		<input type="hidden" name="cus_name" value="">
		<input type="hidden" name="cus_email" value="">
		<input type="hidden" name="cus_add1" value="">
		<input type="hidden" name="cus_add2" value="">
		<input type="hidden" name="cus_city" value="">
		<input type="hidden" name="cus_state" value="">
		<input type="hidden" name="cus_postcode" value="">
		<input type="hidden" name="cus_country" value="">
		<input type="hidden" name="cus_phone" value="">
		<input type="hidden" name="cus_fax" value="">
		<input type="hidden" name="ship_name" value="">
		<input type="hidden" name="ship_add1" value="">
		<input type="hidden" name="ship_add2" value="">
		<input type="hidden" name="ship_city" value="">
		<input type="hidden" name="ship_state" value="">
		<input type="hidden" name="ship_postcode" value="">
		<input type="hidden" name="ship_country" value="">
		<input type="hidden" name="desc" value="EasyPayWay Payment">
		<input type="hidden" name="success_url" value="<?php echo home_url('/easy-pay-success/'); ?>">
		<input type="hidden" name="fail_url" value = "<?php echo home_url('/easy-pay-fail/'); ?>">
		<input type="hidden" name="cancel_url" value = "<?php echo home_url('/easy-pay-cancel/'); ?>">		
	</form>

		<script>
			$ = jQuery.noConflict();
			var ajaxurl = '<?php echo esc_js( admin_url( 'admin-ajax.php' ) ) ?>';

			$(document).ready(function(){
				$("input#hotel_payment").trigger("click");
				var validation_rules = {
						first_name: { required: true},
						last_name: { required: true},
						email: { required: true, email: true},
						email2: { required: true, equalTo: 'input[name="email"]'},
						phone: { required: true},
						address1: { required: true},
						city: { required: true},
						zip: { required: true},
					};
				//validation form
				$('#booking-form').validate({
					rules: validation_rules,
					submitHandler: function (form) {
						if ( $('input[name="agree"]').length ) {
							if ( $('input[name="agree"]:checked').length == 0 ) {
								alert("<?php echo esc_html__( 'Agree to terms&conditions is required' ,'citytours' ); ?>");
								return false;
							}
						}
						var booking_data = $('#booking-form').serialize();
						var paymentInfo = $('input[name="payment_info"]:checked').val();
						if(paymentInfo == 'paypal'){
							alert(paymentInfo + ' payment currently is not abailable.');
							return false;
						}
						if(paymentInfo == 'cc'){
							alert(paymentInfo + ' payment currently is not abailable.');
							return false;
						}

					if(paymentInfo == 'ghuri_bank_account'){
						document.booking_form2.cus_name.value=document.booking_form.first_name.value+' '+document.booking_form.last_name.value;
						document.booking_form2.cus_email.value=document.booking_form.email.value;
						var country = document.booking_form.country.value;
						var address1 = document.booking_form.address1.value;
						var address2 = document.booking_form.address2.value;
						var city = document.booking_form.city.value;
						var state = document.booking_form.state.value;
						var zip = document.booking_form.zip.value;
						document.booking_form2.cus_add1.value=address1;
						document.booking_form2.cus_add2.value=address2;
						document.booking_form2.cus_city.value=city;
						document.booking_form2.cus_state.value=state;
						document.booking_form2.cus_postcode.value=zip;
						document.booking_form2.cus_country.value=country;
						document.booking_form2.cus_phone.value=document.booking_form.phone.value;
						
						document.booking_form2.ship_name.value=document.booking_form.first_name.value+' '+document.booking_form.last_name.value;
						document.booking_form2.ship_add1.value=address1;
						document.booking_form2.ship_add2.value=address2;
						document.booking_form2.ship_city.value=city;
						document.booking_form2.ship_state.value=state;
						document.booking_form2.ship_postcode.value=zip;
						document.booking_form2.ship_country.value=country;
						document.booking_form2.submit();
						return false;
					}						
						
						$('#overlay').fadeIn();
						$.ajax({
							type: "POST",
							url: ajaxurl,
							data: booking_data,
							success: function ( response ) {
								console.log(response);
								if ( response.success == 1 ) {
									if ( response.result.payment == 'woocommerce' ) {
										<?php if ( function_exists( 'ct_woo_get_cart_page_url' ) && ct_woo_get_cart_page_url() ) { ?>
											window.location.href = '<?php echo esc_js( ct_woo_get_cart_page_url() ); ?>';
										<?php } else { ?>
											alert("<?php echo esc_js( esc_html__( 'Please set woocommerce cart page', 'citytours' ) ); ?>");
										<?php } ?>
										$('#overlay').fadeOut();
									} else {
										if ( response.result.payment == 'paypal' ) {
											$('.book-now-btn1').before('<div class="alert alert-success"><?php echo esc_js( esc_html__( 'You will be redirected to paypal.', 'citytours' ) ) ?><span class="close"></span></div>');
										}
										var confirm_url = $('#booking-form').attr('action');
										if ( confirm_url.indexOf('?') > -1 ) {
											confirm_url = confirm_url + '&';
										} else {
											confirm_url = confirm_url + '?';
										}
										confirm_url = confirm_url + 'booking_no=' + response.result.booking_no + '&pin_code=' + response.result.pin_code;
										if ( response.result.payment_info == 'paypal' ) { 
											confirm_url += '&payment_info=paypal';
										}
										if ( response.result.payment_info == 'bkash' ) { 
											confirm_url += '&payment_info=bkash';
										}
										if ( response.result.payment_info == 'pay_hotel' ) { 
											confirm_url += '&payment_info=pay_hotel';
										}
										$('.book-now-btn').hide();
										window.location.href = confirm_url;
									}
								} else if ( response.success == -1 ) {
									alert( response.result );
									window.location.href = '';
								} else {
									if ( response.order_id != 0 ) { 
										$('#order_id').val( response.order_id );
									}
									alert(response.result);
									$('#overlay').fadeOut();
								}
							}
						});
						return false;
					}
				});

				$('.form-radio-control').on('change', function(){ 
					var thisItem = $(this).val();
					$('.paymentWarningText').remove();
					if ( thisItem == 'cc' ) { 
						$('#cc-container').show();
						$('#paypal-container').hide();
						$('#bkash-container').hide();
						$(this).next('label').after('<span class="paymentWarningText" style="color:red;margin-left: 10px;font-weight:bold;">Currently this option is not available.</span>');
					}
					else if ( thisItem == 'paypal' ) { 
						$('#cc-container').hide();
						$('#paypal-container').show();
						$('#bkash-container').hide();
						$(this).next('label').after('<span class="paymentWarningText" style="color:red;margin-left: 10px;font-weight:bold;">Currently this option is not available.</span>');
					}
					else if ( thisItem == 'bkash' ) { 
						$('#cc-container').hide();
						$('#paypal-container').hide();
						$('#bkash-container').show();
					}
					else { 
						$('#cc-container').hide();
						$('#paypal-container').hide();
						$('#bkash-container').hide();
					}
				});
			});
		</script>

	<?php }
} else {
	echo esc_html__( 'Invalid data. You can not access to this directly.', 'citytours' ); //invalid data
}