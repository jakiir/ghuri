<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * Calculate the price of cart
 */
if ( ! function_exists( 'ct_tour_update_cart' ) ) {
	function ct_tour_update_cart() {
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'update_cart' ) ) {
			print esc_html__( 'Sorry, your nonce did not verify.', 'citytours' );
			exit;
		}
		// validation
		if ( ! isset( $_POST['tour_id'] ) || ! isset( $_POST['date'] ) ) {
			wp_send_json( array( 'success'=>0, 'message'=>__( 'Some validation error is occurred while calculate price.', 'citytours' ) ) );
		}

		// init variables
		$tour_id = $_POST['tour_id'];
		$date = $_POST['date'];
		$adults = ( isset( $_POST['adults'] ) ) ? $_POST['adults'] : 1;
		$kids = ( isset( $_POST['kids'] ) ) ? $_POST['kids'] : 0;
		$total_price = ct_tour_calc_tour_price( $tour_id, $date, $adults, $kids );

		$uid = $tour_id . $date;
		$cart_data = array();

		// function
		$tour_data = array();
		$tour_data['adults'] = $adults;
		$tour_data['kids'] = $kids;
		$tour_data['total'] = $total_price;
		$cart_data['tour'] = $tour_data;

		if ( ! empty( $_POST['add_service'] ) ) {
			global $wpdb;
			foreach ( $_POST['add_service'] as $key => $value ) {
				$services = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . CT_ADD_SERVICES_TABLE . ' WHERE id=%d AND post_id=%d', $key, $tour_id ) );
				if ( ! empty( $services ) ) {
					$cart_add_service_data = array();
					$cart_add_service_data['title'] = $services->title;
					$cart_add_service_data['price'] = $services->price;
					$qty = 1;
					$qty = ( isset( $_POST['add_service_' . $key] ) ) ? $_POST['add_service_' . $key] : 1;
					$cart_add_service_data['qty'] = $qty;
					$cart_add_service_data['total'] = $cart_add_service_data['price'] * $qty;

					$cart_data['add_service'][$key] = $cart_add_service_data;
					$total_price += $cart_add_service_data['total'];
				}
			}
		}

		$cart_data['total_price'] = $total_price;
		$cart_data['total_adults'] = $adults;
		$cart_data['total_kids'] = $kids;
		$cart_data['tour_id'] = $tour_id;
		$cart_data['date'] = $date;
		CT_Hotel_Cart::set( $uid, $cart_data );
		wp_send_json( array( 'success'=>1, 'message'=>'success' ) );
	}
}

/*
 * Handle submit booking ajax request
 */
if ( ! function_exists( 'ct_tour_submit_booking' ) ) {
	function ct_tour_submit_booking() {
		global $wpdb, $ct_options;

		// validation
		$result_json = array( 'success' => 0, 'result' => '', 'order_id' => 0 );
		$latest_order_id = $wpdb->get_var( 'SELECT id FROM ' . CT_ORDER_TABLE . ' ORDER BY id DESC LIMIT 1' );
		$booking_no = mt_rand( 1000, 9999 );
		$booking_no .= $latest_order_id;
		$pin_code = mt_rand( 1000, 9999 );
		
		if ( isset( $_POST['order_id'] ) && empty( $_POST['order_id'] ) ) {
		if ( ! isset( $_POST['uid'] ) || ! CT_Hotel_Cart::get( $_POST['uid'] ) ) {
			$result_json['success'] = 0;
			$result_json['result'] = esc_html__( 'Sorry, some error occurred on input data validation.', 'citytours' );
			wp_send_json( $result_json );
		}
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'checkout' ) ) {
			$result_json['success'] = 0;
			$result_json['result'] = esc_html__( 'Sorry, your nonce did not verify.', 'citytours' );
			wp_send_json( $result_json );
		}

			if ( isset( $_POST['payment_info'] ) && $_POST['payment_info'] == 'cc' ) { 
		        if ( ! is_valid_card_number( $_POST['billing_credircard'] ) ) {
					$result_json['success'] = 0;
					$result_json['result'] = esc_html__( 'Credit card number you entered is invalid.', 'citytours' );
					wp_send_json( $result_json );
		        }
		        if ( ! is_valid_card_type( $_POST['billing_cardtype'] ) ) {
					$result_json['success'] = 0;
					$result_json['result'] = esc_html__( 'Card type is not valid.', 'citytours' );
					wp_send_json( $result_json );
		        }
		        if ( ! is_valid_expiry( $_POST['billing_expdatemonth'], $_POST['billing_expdateyear'] ) ) {
					$result_json['success'] = 0;
					$result_json['result'] = esc_html__( 'Card expiration date is not valid.', 'citytours' );
					wp_send_json( $result_json );
		        }
		        if ( ! is_valid_cvv_number( $_POST['billing_ccvnumber'] ) ) {
					$result_json['success'] = 0;
					$result_json['result'] = esc_html__( 'Card verification number (CVV) is not valid. You can find this number on your credit card.', 'citytours' );
					wp_send_json( $result_json );
		        }
			}

		// init variables
		$uid = $_POST['uid'];
		$post_fields = array( 'first_name', 'last_name', 'email', 'phone', 'country', 'address1', 'address2', 'city', 'state', 'zip');
		$order_info = ct_order_default_order_data( 'new' );
		foreach ( $post_fields as $post_field ) {
			if ( ! empty( $_POST[ $post_field ] ) ) {
				$order_info[ $post_field ] = sanitize_text_field( $_POST[ $post_field ] );
			}
		}

		$cart_data = CT_Hotel_Cart::get( $uid );
		$order_info['total_price'] = $cart_data['total_price'];
		$order_info['total_adults'] = $cart_data['total_adults'];
		$order_info['total_kids'] = $cart_data['total_kids'];
		$order_info['status'] = 'new'; // new
		$order_info['deposit_paid'] = 1;
		$order_info['mail_sent'] = 0;
		$order_info['post_id'] = $cart_data['tour_id'];
		if ( ! empty( $cart_data['date'] ) ) $order_info['date_from'] = date( 'Y-m-d', ct_strtotime( $cart_data['date'] ) );
		$order_info['booking_no'] = $booking_no;
		$order_info['pin_code'] = $pin_code;
		// calculate deposit payment
		$deposit_rate = get_post_meta( $cart_data['tour_id'], '_tour_security_deposit', true );
		// if woocommerce enabled change currency_code and exchange rate as default
		if ( ! empty( $deposit_rate ) && ct_is_woo_enabled() ) {
			$order_info['currency_code'] = ct_get_def_currency();
			$order_info['exchange_rate'] = 1;
		} else {
			if ( ! isset( $_SESSION['exchange_rate'] ) ) ct_init_currency();
			$order_info['exchange_rate'] = $_SESSION['exchange_rate'];
			$order_info['currency_code'] = ct_get_user_currency();
		}

		// if payment enabled set deposit price field
		if ( ! empty( $deposit_rate ) && ct_is_payment_enabled() ) {
				$decimal_prec = isset( $ct_options['decimal_prec'] ) ? $ct_options['decimal_prec'] : 2;
				$order_info['deposit_price'] = round( $deposit_rate / 100 * $order_info['total_price'] * $order_info['exchange_rate'], $decimal_prec );
				//$order_info['deposit_price'] = $deposit_rate / 100 * $order_info['total_price'] * $order_info['exchange_rate'];
				//$formatter = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
				//$order_info['deposit_price'] = $formatter->parseCurrency( $deposit_rate / 100 * $order_info['total_price'] * $order_info['exchange_rate'], $order_info['currency_code'] );

			$order_info['deposit_paid'] = 0; // set unpaid if payment enabled
			$order_info['status'] = 'pending';
		}
		$order_info['created'] = date( 'Y-m-d H:i:s' );
		$order_info['payment_method'] = $_POST['payment_info'];
		$order_info['post_type'] = 'tour';
		if ( $wpdb->insert( CT_ORDER_TABLE, $order_info ) ) {
			CT_Hotel_Cart::_unset( $uid );
			$order_id = $wpdb->insert_id;
			if ( ! empty( $cart_data['tour'] ) ) {
				$tour_booking_info = array();
				$tour_booking_info['order_id'] = $order_id;
				$tour_booking_info['tour_id'] = $cart_data['tour_id'];
				$tour_booking_info['tour_date'] = $cart_data['date'];
				$tour_booking_info['adults'] = $cart_data['tour']['adults'];
				$tour_booking_info['kids'] = $cart_data['tour']['kids'];
				$tour_booking_info['total_price'] = $cart_data['tour']['total'];
				$wpdb->insert( CT_TOUR_BOOKINGS_TABLE, $tour_booking_info );
			}
			if ( ! empty( $cart_data['add_service'] ) ) {
				foreach ( $cart_data['add_service'] as $service_id => $service_data ) {
					$service_booking_info = array();
					$service_booking_info['order_id'] = $order_id;
					$service_booking_info['add_service_id'] = $service_id;
					$service_booking_info['qty'] = $service_data['qty'];
					$service_booking_info['total_price'] = $service_data['total'];
					$wpdb->insert( CT_ADD_SERVICES_BOOKINGS_TABLE, $service_booking_info );
				}
			}

				if ( ( isset( $_POST['payment_info'] ) && $_POST['payment_info'] == 'paypal' ) || ( ! isset( $_POST['payment_info'] ) ) ) { 
					$result_json['success'] = 1;
					$result_json['result']['order_id'] = $order_id;
					$result_json['result']['booking_no'] = $booking_no;
					$result_json['result']['pin_code'] = $pin_code;
				}
				else if ( isset( $_POST['payment_info'] ) && $_POST['payment_info'] == 'bkash' ) { 
					$result_json['success'] = 1;
					$result_json['result']['order_id'] = $order_id;
					$result_json['result']['booking_no'] = $booking_no;
					$result_json['result']['pin_code'] = $pin_code;
				}
				else if ( isset( $_POST['payment_info'] ) && $_POST['payment_info'] == 'cc' ) { 
					$payment_process_result = ct_credit_card_paypal_process_payment( $order_info );

					if ( $payment_process_result['success'] == 1 ) { 
			$result_json['success'] = 1;
						// $result_json['result']['transaction_id'] = 'paypal';
			$result_json['result']['order_id'] = $order_id;
			$result_json['result']['booking_no'] = $booking_no;
			$result_json['result']['pin_code'] = $pin_code;
		} else {
			$result_json['success'] = 0;
						$result_json['result'] = $payment_process_result['errormsg'];
						$result_json['order_id'] = $order_id;
					}
				}
			} else {
				$result_json['success'] = 0;
			$result_json['result'] = esc_html__( 'Sorry, An error occurred while add your order.', 'citytours' );
		}
		} else if ( isset( $_POST['order_id'] ) && ! empty( $_POST['order_id'] ) && isset( $_POST['payment_info'] ) && $_POST['payment_info'] == 'cc'  ) { 
			$order = new CT_Hotel_Order( $_POST['order_id'] );
			$order_info = $order->get_order_info();

			$payment_process_result = ct_credit_card_paypal_process_payment( $order_info );

			if ( $payment_process_result['success'] == 1 ) { 
				$result_json['success'] = 1;
				// $result_json['result']['transaction_id'] = 'paypal';
				$result_json['result']['order_id'] = $order->order_id;
				$result_json['result']['booking_no'] = $booking_no;
				$result_json['result']['pin_code'] = $pin_code;
			} else { 
				$result_json['success'] = 0;
				$result_json['result'] = $payment_process_result['errormsg'];
				$result_json['order_id'] = $order->order_id;
			}
		} 
		
		if($result_json['success'] == 1){
			
			$get_template_directory_ver = esc_url( get_template_directory_uri() );
			$home_url = home_url('/');
			$logo_url = $get_template_directory_ver.'/img/logo_sticky.png';
			
			$senderName = $_POST['first_name'].' '.$_POST['last_name'];
			$senderEmail = $_POST['email'];
			$senderPhone = $_POST['phone'];
			
			$address[] = $_POST['address1'];
			$address[] = $_POST['address2'];
			$address[] = $_POST['city'];
			$address[] = $_POST['state'];
			$address[] = $_POST['zip'];
			$address[] = $_POST['country'];
			if($_POST['payment_info'] == 'bkash'){
				$bookingNo = ($booking_no ? 'GH'.$booking_no : 'GH****');				
				$paymentNote = esc_html__( 'Thank you for your reservation made through ghuri.online. We have emailed you the booking confirmation. Please keep this booking reference ('.$bookingNo.') with you. We will confirm with the tour operator and come back to you within 72 hours. After which you may pay via bkash to +88 01977717716 number and mention this booking reference.' );
			} else {
				$paymentNote = esc_html__( 'The total price of the reservation will be charged on the day of booking.');
			}
			$senderAddress = '';
			if(!empty($address)){
				$senderAddress = implode(',',$address);
			}
			
			/*$room_booking_info['rooms'] = $room_data['rooms'];
					$room_booking_info['adults'] = $room_data['adults'];
					$room_booking_info['kids'] = $room_data['kids'];
					$room_booking_info['total_price'] = $room_data['total'];*/
			
			
			$total_price = $cart_data['total_price'];
			$total_adults = $cart_data['total_adults'];
			if($total_adults > 1){
				$totalAdultss = $total_adults.' Adults';
			} else {
				$totalAdultss = $total_adults.' Adult';
			}
			//$total_kids = $cart_data['total_kids'];
			$status = 'new'; // new
			$deposit_paid = 1;			
			$tour_id = $cart_data['tour_id'];
			$tourName = get_the_title($tour_id);
			$tourUrl = get_permalink( $tour_id );		
			
			$date_from = date( 'l, jS F Y', ct_strtotime( $cart_data['date_from'] ) );
			$date_to = date( 'l, jS F Y', ct_strtotime( $cart_data['date_to'] ) );
						
			require get_stylesheet_directory().'/PHPMailer-master/PHPMailerAutoload.php';
			$mail = new PHPMailer;

			$mail->IsSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'smtp.mandrillapp.com';                 // Specify main and backup server
			$mail->Port = 587;                                    // Set the SMTP port
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'bdsmartapp';                // SMTP username
			$mail->Password = 'YOwWTn3LtJdJcP1o-rShYQ';                  // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

			$mail->From = 'sales@ghuri.online';
			$mail->FromName = 'Ghuri Sales';
			//$mail->AddAddress('jakir44.du@gmail.com', 'bdsmartapp');  // Add a recipient
			$mail->AddAddress($senderEmail, $senderName);  // Add a recipient
			$mail->AddAddress('sales@ghuri.online', 'sales');
			//$mail->AddAddress('even.khan@gmail.com', 'even');               // Name is optional
			//$mail->AddAddress('hazzaz77@gmail.com', 'S.M. Hazzaz Imtiaz');               // Name is optional
			//$mail->addReplyTo('info@example.com', 'Information');
			//$mail->addCC('hazzaz77@gmail.com');
			//$mail->addBCC('bcc@example.com');

			//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
			//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

			$mail->IsHTML(true);                                  // Set email format to HTML

			$mail->Subject = 'Confirmation of Booking in ghuri.online';
			
			$tour_address 	= get_post_meta( $tour_id, '_tour_address', true );
			$tour_email 	= get_post_meta( $tour_id, '_tour_email', true );	
			
			if($tour_email){
				$mail->addCC($tour_email, $tourName);  // Add a recipient
			}			
			$tour_phone 	= get_post_meta( $tour_id, '_tour_phone', true );
			$tour_loc 	= get_post_meta( $tour_id, '_tour_loc', true );
			$is_repeated =  get_post_meta( $tour_id, '_tour_repeated', true );
			$tour_start_date =  $cart_data['date'];
			if ( ! empty( $is_repeated ) ){
				if ( ! empty( $tour_start_date ) ){
					$tourStartDate = date( 'jS F Y', ct_strtotime( $tour_start_date ) );
				} else {
					$tourStartDate = 'Not mentioned';
				}
			} else {
				$tourStartDate = 'Not mentioned';
			}
			$tour_end_date =  get_post_meta( $tour_id, '_tour_end_date', true );
			
			$message = '<html><body>';		
			$message .= '<table bgcolor="#f6f6f6" width="680px" border="0" cellpadding="0" cellspacing="0" align="center"><tbody><tr><td width="100%" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center"><tbody><tr><td width="100%" bgcolor="#ffffff"><table width="580" border="0" cellpadding="0" cellspacing="0" align="center"><tbody><tr><td width="580"><table border="0" cellpadding="0" cellspacing="0" align="left"><tbody><tr><td height="14"></td></tr><tr><td height="50"><a href="'.$home_url.'" target="_blank"><img src="'.$logo_url.'" alt="" border="0" class="CToWUd"></a></td></tr><tr><td height="12"></td></tr></tbody></table><table border="0" cellpadding="0" cellspacing="0" align="right"><tbody><tr><td height="13"></td></tr><tr><td height="50" style="font-size:13px;color:#272727;font-weight:light;text-align:right;font-family:Helvetica,Arial,sans-serif;line-height:20px;vertical-align:middle"></td></tr><tr><td height="12"></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" style="border-top:1px solid #ebebeb"><tbody><tr><td width="100%" valign="top"><table width="580" border="0" cellpadding="0" cellspacing="0" align="center" style="margin:24px auto 0;background-color:#fff;border:1px solid #ebebeb"><tbody><tr><td>  </td></tr> <tr><td width="560">  <table width="560" border="0" cellpadding="0" cellspacing="0" align="center"><tbody><tr><td height="10"></td> </tr> <tr><td> </td> </tr><tr><td height="10"></td> </tr><tr><td height="10" style="font-size:13px;line-height:1.9;font-weight:400;font-family:Helvetica,Arial,sans-serif;text-decoration:none;color:#7b7b7b;padding:0 0 0px"><table>
			<tbody style="margin-bottom:12px">';
			$message .= '<tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes">  
			  <td colspan="3" style="">
			  <div class="MsoNormal" align="left" style="margin-bottom:0in;margin-bottom:.0001pt;
			  text-align:left;line-height:12.55pt">
			  <strong>Booking confirmation</strong>
			  <br><div style="font-size: 12px;margin-top: 12px;">Dear '.$senderName.',</div><br>
			  <div style="font-size:11px;font-weight:bold;">'.$paymentNote.'</div>
			  </div>
			  </td>
			 </tr>
			 <tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes">
			  <td colspan=2 style="padding:0in 0in 0in 0in"></td>
			  <td width=356 style="width:267.0pt;padding:0in 0in 0in 0in">
			  <p class=MsoNormal align=right style="margin-bottom:0in;margin-bottom:.0001pt;
			  text-align:right;line-height:12.55pt"><b><span lang=EN-GB style="font-size:
			  9.0pt;font-family:"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
			  color:#454545;mso-fareast-language:EN-GB">Best Price Guarantee </span></b></p>
			  </td>
			 </tr>
			 <tr style="mso-yfti-irow:1">
			  <td width=356 style="width:267.0pt;padding:0in 0in 0in 0in"></td>
			  <td width=10 style="width:7.5pt;padding:0in 0in 0in 0in">
			  <p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;line-height:
			  12.55pt"><span lang=EN-GB style="font-size:9.0pt;font-family:"Helvetica","sans-serif";
			  mso-fareast-font-family:"Times New Roman";mso-fareast-language:EN-GB">&nbsp;</span></p>
			  </td>
			  <td width=356 style="width:267.0pt;padding:0in 0in 0in 0in"></td>
			 </tr>
			 <tr style="mso-yfti-irow:2">
			  <td valign=top style="border:none;border-bottom:solid #E6EDF6 1.0pt;
			  mso-border-bottom-alt:solid #E6EDF6 .75pt;padding:0in 0in 16.75pt 0in">
			  <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width="100%"
			   style="border:1px solid #85c99d;padding-top: 10px;">
			   <tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes">
				<td colspan="2" valign=top style="padding:0pt 3.0pt 2.35pt 10.05pt;width: 100%;">
				<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
				line-height:12.55pt"><b><span lang=EN-GB style="font-size:9.0pt;">Booking number</span></b><span lang=EN-GB style="font-size:9.0pt;float:right;">GH'.$booking_no.'</span></p>
				</td>
			   </tr>
			   <tr style="mso-yfti-irow:1">
				<td valign=top style="padding:0pt 3.0pt 2.35pt 10.05pt">
				<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
				line-height:12.55pt"><b><span lang=EN-GB style="font-size:9.0pt;font-family:
				"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB">PIN code </span></b><span
				lang=EN-GB style="font-size:9.0pt;font-family:"Helvetica","sans-serif";
				mso-fareast-font-family:"Times New Roman";color:#85c99d;mso-fareast-language:
				EN-GB"></span></p>
				</td>
				<td valign=top style="padding:0pt 3.0pt 2.35pt 10.05pt">
				<p class=MsoNormal align=right style="margin-bottom:0in;margin-bottom:.0001pt;
				text-align:right;line-height:12.55pt"><span lang=EN-GB style="font-size:
				9.0pt;font-family:"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB">'.$pin_code.'</span></p>
				</td>
			   </tr>
			   <tr style="mso-yfti-irow:2">
				<td valign=top style="padding:0pt 3.0pt 2.35pt 10.05pt">
				<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
				line-height:12.55pt"><b><span lang=EN-GB style="font-size:9.0pt;font-family:
				"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB">E-mail</span></b><span
				lang=EN-GB style="font-size:9.0pt;font-family:"Helvetica","sans-serif";
				mso-fareast-font-family:"Times New Roman";color:#85c99d;mso-fareast-language:
				EN-GB"></span></p>
				</td>
				<td valign=top style="padding:0pt 3.0pt 2.35pt 10.05pt">
				<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
				line-height:12.55pt;text-align:right;"><u><span lang=EN-GB style="font-size:9.0pt;text-align:right;">'.$senderEmail.'</span></u><span
				lang=EN-GB style="font-size:9.0pt;font-family:"Helvetica","sans-serif";
				mso-fareast-font-family:"Times New Roman";color:#85c99d;mso-fareast-language:
				EN-GB"></span></p>
				</td>
			   </tr>
			   <tr style="mso-yfti-irow:3">
				<td valign=top style="padding:0pt 3.0pt 2.35pt 10.05pt">
				<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
				line-height:12.55pt"><b><span lang=EN-GB style="font-size:9.0pt;font-family:
				"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB">Booked by</span></b><span
				lang=EN-GB style="font-size:9.0pt;font-family:"Helvetica","sans-serif";
				mso-fareast-font-family:"Times New Roman";color:#85c99d;mso-fareast-language:
				EN-GB"></span></p>
				</td>
				<td valign=top style="padding:0pt 3.0pt 2.35pt 10.05pt;">
				<p class=MsoNormal align=center style="margin-bottom:0in;margin-bottom:
				.0001pt;mso-add-space:auto;text-align:center;line-height:normal;text-align:right;"><span
				class=SpellE><span lang=EN-GB style="font-size:12.0pt;font-family:"Times New Roman","serif";
				mso-fareast-font-family:"Times New Roman";color:#85c99d;mso-fareast-language:
				EN-GB">'.$senderName.'</span></span><span lang=EN-GB style="font-size:12.0pt;
				font-family:"Times New Roman","serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB"></span></p>
				</td>
			   </tr> 
			   <tr style="mso-yfti-irow:3">
				<td valign=top style="padding:0pt 3.0pt 2.35pt 10.05pt" colspan="2">
				<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
				line-height:12.55pt"><b><span lang=EN-GB style="font-size:9.0pt;font-family:
				"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB">Address:</span></b><span
				lang=EN-GB style="font-size:8.0pt;font-family:"Helvetica","sans-serif";
				mso-fareast-font-family:"Times New Roman";color:#85c99d;mso-fareast-language:
				EN-GB"> '.$senderAddress.'</span></p>
				</td>				
			   </tr>    
			   <tr style="mso-yfti-irow:4">
				<td width=100 valign=top style="border-top:1px solid #85c99d;width:75.0pt;padding:8.35pt 3.0pt 3.0pt 10.05pt">
				<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
				line-height:12.55pt"><b><span lang=EN-GB style="font-size:9.0pt;font-family:
				"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB">Tour Name:</span></b><span
				lang=EN-GB style="font-size:9.0pt;font-family:"Helvetica","sans-serif";
				mso-fareast-font-family:"Times New Roman";color:#85c99d;mso-fareast-language:
				EN-GB"></span></p>
				</td>
				<td width=200 valign=top style="border-top:1px solid #85c99d;width:150.0pt;padding:8.35pt 10.05pt 3.0pt 3.0pt">
				<p class=MsoNormal align=right style="margin-bottom:0in;margin-bottom:.0001pt;
				text-align:right;line-height:12.55pt"><span lang=EN-GB style="font-size:
				9.0pt;font-family:"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB">'.$tourName.'</span></p>
				</td>
			   </tr>
			   <tr>
				<td width=100 valign=top style="width:75.0pt;padding:8.35pt 3.0pt 3.0pt 10.05pt">
				<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
				line-height:12.55pt"><b><span lang=EN-GB style="font-size:9.0pt;font-family:
				"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB">Tour Start Date:</span></b><span
				lang=EN-GB style="font-size:9.0pt;font-family:"Helvetica","sans-serif";
				mso-fareast-font-family:"Times New Roman";color:#85c99d;mso-fareast-language:
				EN-GB"></span></p>
				</td>
				<td width=200 valign=top style="width:150.0pt;padding:8.35pt 10.05pt 3.0pt 3.0pt">
				<p class=MsoNormal align=right style="margin-bottom:0in;margin-bottom:.0001pt;
				text-align:right;line-height:12.55pt"><span lang=EN-GB style="font-size:
				9.0pt;font-family:"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB">'.$tourStartDate.'</span></p>
				</td>
			   </tr>
			   <tr>
				<td width=100 valign=top style="width:75.0pt;padding:8.35pt 3.0pt 3.0pt 10.05pt">
				<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
				line-height:12.55pt"><b><span lang=EN-GB style="font-size:9.0pt;font-family:
				"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB">Your reservation:</span></b><span
				lang=EN-GB style="font-size:9.0pt;font-family:"Helvetica","sans-serif";
				mso-fareast-font-family:"Times New Roman";color:#85c99d;mso-fareast-language:
				EN-GB"></span></p>
				</td>
				<td width=200 valign=top style="width:150.0pt;padding:8.35pt 10.05pt 3.0pt 3.0pt">
				<p class=MsoNormal align=right style="margin-bottom:0in;margin-bottom:.0001pt;
				text-align:right;line-height:12.55pt"><span lang=EN-GB style="font-size:
				9.0pt;font-family:"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB">'.$totalAdultss.'</span></p>
				</td>
			   </tr> 
			  </table>
			  </td>
			  <td style="border:none;border-bottom:solid #E6EDF6 1.0pt;mso-border-bottom-alt:
			  solid #E6EDF6 .75pt;padding:0in 0in 0in 0in;"></td>
			  <td valign=top style="border:none;border-bottom:solid #E6EDF6 1.0pt;
			  mso-border-bottom-alt:solid #E6EDF6 .75pt;padding:0in 0in 0in 0in;width:50%">
			  <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width="100%"
			   style="border:solid #85c99d 1.0pt;">
			   <tr style="mso-yfti-irow:7">
				<td colspan="2" valign=top style="border-bottom:none;border-right:none;background:#E6EDF6;padding:8.35pt 3.0pt 3.0pt 10.05pt">
				<p class=MsoNormal style="margin-top:6.7pt;margin-right:0in;margin-bottom:
				3.35pt;margin-left:0in;line-height:12.55pt"><b><span lang=EN-GB
				style="font-size:9.0pt;font-family:"Helvetica","sans-serif";mso-fareast-font-family:
				"Times New Roman";color:#85c99d;mso-fareast-language:EN-GB">'.$tourName.'</span></b><span
				lang=EN-GB style="font-size:9.0pt;font-family:"Helvetica","sans-serif";
				mso-fareast-font-family:"Times New Roman";color:#85c99d;mso-fareast-language:
				EN-GB"></span></p>
				</td>
			   </tr>
			   <tr style="mso-yfti-irow:8">
				<td valign=top style="background:#E6EDF6;padding:3.0pt 3.0pt 3.0pt 10.05pt">
				<p class=MsoNormal style="margin-top:6.7pt;margin-right:0in;margin-bottom:
				3.35pt;margin-left:0in;line-height:11.7pt"><b><span lang=EN-GB
				style="font-size:9.0pt;font-family:"Helvetica","sans-serif";mso-fareast-font-family:
				"Times New Roman";color:#85c99d;mso-fareast-language:EN-GB">Inclusive of Service Charge & Vat</span></b></p>
				</td>
				<td valign=top style="background:#E6EDF6;padding:3.0pt 10.05pt 3.0pt 3.0pt">-</td>
			   </tr>
			   <tr style="mso-yfti-irow:9">
				<td width="100%" valign=top style="width:100.0%;background:#E6EDF6;padding:3.0pt 3.0pt 3.0pt 10.05pt">
				<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
				line-height:20.95pt"><b><span lang=EN-GB style="font-size:13.5pt;
				font-family:"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB">Total price</span></b></p>
				</td>
				<td nowrap valign=top style="background:#E6EDF6;padding:3.0pt 10.05pt 3.0pt 3.0pt">
				<p class=MsoNormal align=right style="margin-bottom:0in;margin-bottom:.0001pt;
				text-align:right;line-height:20.95pt"><span lang=EN-GB style="font-size:
				13.5pt;font-family:"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;font-weight:bold;">'.$total_price.' BDT</span></p>
				</td>
			   </tr>			   
			   <tr style="mso-yfti-irow:5;mso-yfti-lastrow:yes;">
				<td colspan=2 style="padding:8.35pt 8.35pt 8.35pt 8.35pt;height:154pt;max-height:154pt;display:block;"></td>
			   </tr>
			  </table>
			  </td>
			 </tr>
			 <tr style="mso-yfti-irow:3;height:16.75pt">
			  <td style="padding:0in 0in 0in 0in;height:16.75pt"></td>
			  <td style="padding:0in 0in 0in 0in;height:16.75pt"></td>
			  <td style="padding:0in 0in 0in 0in;height:16.75pt"></td>
			 </tr>';			
			$message .= '</tbody>';
			$message .= '</table>';			
			$message .= '</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table>';
			$message .= '<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">';
			$message .= '<tbody><tr><td width="100%" valign="top"></td></tr></tbody></table>';
			$message .= '<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">';
			$message .= '<tbody><tr><td width="100%" valign="top">';
			$message .= '<table height="60" width="100%" border="0" cellspacing="0" align="center">';
			$message .= '<tbody><tr><td>';
			$message .= '<table width="580" border="0" cellpadding="0" cellspacing="0" align="center">';  
			$message .= '<tbody><tr><td>';  
			$message .= '<table width="42%" border="0" cellpadding="0" cellspacing="0" align="left">'; 
			$message .= '<tbody><tr><td style="font-weight:400;font-size:15px;color:#b2b3b6;font-weight:bold;text-align:left;font-family:Open sans;line-height:2.8;vertical-align:top">&nbsp;&nbsp;Contact Info:</td></tr></tbody></table>';	
			$message .= '<table width="35%" border="0" cellpadding="0" cellspacing="0" align="right"><tbody><tr style="float:right"><td style="float:left;margin-top:5px">';	
			$message .= '<a style="float:right;margin-right:10px" href="#" target="_blank"><img src="'.$get_template_directory_ver.'/img/icons/youtube_hover.png" class=""></a>';			
			$message .= '<a style="float:right;margin-right:10px" href="#" target="_blank"><img src="'.$get_template_directory_ver.'/img/icons/twitter_hover.png" class=""></a>';
										
			$message .= '<a style="float:right;margin-right:10px" href="#" target="_blank"><img src="'.$get_template_directory_ver.'/img/icons/facebook_hover.png" class=""></a>';
									
			$message .= '</td></tr></tbody></table></td></tr><tr><td style="margin-bottom:15px;color:rgb(178,179,182);font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:bold;line-height:1;text-align:left;vertical-align:top;">&nbsp; &nbsp;<img style="display:inline-block;margin-bottom:8px;" src="'.$get_template_directory_ver.'/img/icons/phone_hover.png" class=""><span style="display:inline-block;margin-top:4px;margin-left:7px;vertical-align:top;"><a href="tel:01977717716" value="+8801977717716" style="color:rgb(178,179,182);text-decoration: none;" target="_blank">01977717716</a></span><br><img style="display:inline-block;margin-left:10px" src="'.$get_template_directory_ver.'/img/icons/letter_hover.png" class=""><span style="display:inline-block;margin-top:4px;margin-left:7px;vertical-align:top;">info@ghuri.online</span></td></tr><tr><td style="margin-bottom:15px;color:rgb(178,179,182);font-family:Helvetica,Arial,sans-serif;font-size:12px;font-weight:bold;line-height:4;text-align:center;vertical-align:top;">@2016 ghuri.online. All rights reserved</td></tr></tbody></table>';
			$message .= '</td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody>';
			$message .= "</table>";
			$message .= "</body></html>";						
			$mail->Body    = $message;
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			if(!$mail->Send()) {
			  $result_json['mail_sent'] = 0;
			}
			$result_json['mail_sent'] = 1;
		}

		wp_send_json( $result_json );
	}
}