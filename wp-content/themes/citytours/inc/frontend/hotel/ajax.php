<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/*
 * Calculate the price of selected hotel room and return price array data
 */
if ( ! function_exists( 'ct_hotel_update_cart' ) ) {
	function ct_hotel_update_cart() {
		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'update_cart' ) ) {
			print esc_html__( 'Sorry, your nonce did not verify.', 'citytours' );
			exit;
		}
		// validation

		// init variables
		$hotel_id = $_POST['hotel_id'];
		$date_from = $_POST['date_from'];
		$date_from = mysql2date('d-m-Y', $date_from);
		$date_to = $_POST['date_to'];
		$date_to = mysql2date('d-m-Y', $date_to);
		$room_ids = $_POST['room_type_id'];
		$uid = $hotel_id . $date_from . $date_to;
		$cart_data = array();
		$total_adults = 0;
		$total_kids = 0;
		$total_price = 0;

		// function
		foreach ( $room_ids as $room_id ) :
			if ( ! empty( $_POST['rooms'][$room_id] ) ) :
				$rooms = ( ! empty( $_POST['rooms'][$room_id] ) ) ? $_POST['rooms'][$room_id] : 0;
				$adults = ( ! empty( $_POST['adults'][$room_id] ) ) ? $_POST['adults'][$room_id] : 0;
				$kids = ( ! empty( $_POST['kids'][$room_id] ) ) ? $_POST['kids'][$room_id] : 0;
				$price_data = ct_hotel_calc_room_price( $hotel_id, $room_id, $date_from, $date_to, $rooms, $adults, $kids,'','' );
				if ( $price_data && is_array( $price_data ) ) {
					$cart_room_data = array();
					$cart_room_data['rooms'] = $rooms;
					$cart_room_data['adults'] = $adults;
					$cart_room_data['kids'] = $kids;
					$cart_room_data['total'] = $price_data['total_price'];

					$cart_data['room'][$room_id] = $cart_room_data;
					$total_adults += $adults;
					$total_kids += $kids;
					$total_price += $price_data['total_price'];
				} elseif ( $price_data ) {
					wp_send_json( array( 'success'=>0, 'message'=>$price_data ) );
				} else {
					wp_send_json( array( 'success'=>0, 'message'=>__( 'Some validation error is occurred while calculate price.', 'citytours' ) ) );
				}
			endif;
		endforeach;

		if ( ! empty( $_POST['add_service'] ) ) {
			global $wpdb;
			foreach ( $_POST['add_service'] as $key => $value ) {
				$services = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . CT_ADD_SERVICES_TABLE . ' WHERE id=%d AND post_id=%d', $key, $hotel_id ) );
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
		$cart_data['total_adults'] = $total_adults;
		$cart_data['total_kids'] = $total_kids;
		$cart_data['hotel_id'] = $hotel_id;
		$cart_data['date_from'] = $date_from;
		$cart_data['date_to'] = $date_to;
		CT_Hotel_Cart::set( $uid, $cart_data );
		wp_send_json( array( 'success'=>1, 'message'=>'success' ) );
	}
}

if ( ! function_exists( 'jk_hotel_update_cart' ) ) {
	function jk_hotel_update_cart() {
		// validation

		// init variables
		$hotel_id = $_POST['hotel_id'];
		$date_from = $_POST['date_from'];
		$arr = explode('/', $date_from);
		$date_from = $arr[0].'-'.$arr[1].'-'.$arr[2];		
		$date_to = $_POST['date_to'];
		$arr2 = explode('/', $date_to);
		$date_to = $arr2[0].'-'.$arr2[1].'-'.$arr2[2];
		//$date_to = mysql2date('m-d-Y', $date_to);
		$room_ids = $_POST['room_type_id'];
		$uid = $hotel_id . $date_from . $date_to;
		$cart_data = array();
		$total_adults = 0;
		$total_kids = 0;
		$total_price = 0;

		// function
		foreach ( $room_ids as $room_id ) :
			if ( ! empty( $_POST['rooms'][$room_id] ) ) :
				$rooms = ( ! empty( $_POST['rooms'][$room_id] ) ) ? $_POST['rooms'][$room_id] : 0;
				$adults = ( ! empty( $_POST['adults'][$room_id] ) ) ? $_POST['adults'][$room_id] : 0;
				$kids = ( ! empty( $_POST['kids'][$room_id] ) ) ? $_POST['kids'][$room_id] : 0;
				$extraBed = ( ! empty( $_POST['extraBed'] ) ) ? $_POST['extraBed'] : 0;
				$extra_bed_no = ( ! empty( $_POST['extra_bed_no'] ) ) ? $_POST['extra_bed_no'] : 0;
				$price_data = ct_hotel_calc_room_price( $hotel_id, $room_id, $date_from, $date_to, $rooms, $adults, $kids);
				if ( $price_data && is_array( $price_data ) ) {
					$cart_room_data = array();
					$cart_room_data['rooms'] = $rooms;
					$cart_room_data['adults'] = $adults;
					$cart_room_data['kids'] = $kids;
					$cart_room_data['total'] = $price_data['total_price'];

					$cart_data['room'][$room_id] = $cart_room_data;
					$total_adults += $adults;
					$total_kids += $kids;
					$total_price += $price_data['total_price'];
				} elseif ( $price_data ) {
					wp_send_json( array( 'success'=>0,'ddd'=>$date_from, 'message'=>$price_data ) );
				} else {
					wp_send_json( array( 'success'=>0, 'message'=>__( 'Some validation error is occurred while calculate price.', 'citytours' ) ) );
				}
			endif;
		endforeach;

		if ( ! empty( $_POST['add_service'] ) ) {
			global $wpdb;
			foreach ( $_POST['add_service'] as $key => $value ) {
				$services = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . CT_ADD_SERVICES_TABLE . ' WHERE id=%d AND post_id=%d', $key, $hotel_id ) );
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
		$cart_data['total_adults'] = $total_adults;
		$cart_data['total_kids'] = $total_kids;
		$cart_data['hotel_id'] = $hotel_id;
		$cart_data['date_from'] = $date_from;
		$cart_data['date_to'] = $date_to;
		CT_Hotel_Cart::set( $uid, $cart_data );
		wp_send_json( array( 'success'=>1, 'uid'=>$uid,'total_price'=>$total_price, 'ddd'=>$price_data, 'message'=>'success' ) );
	}
}

if ( ! function_exists( 'jk_hotel_remove_cart' ) ) {
	function jk_hotel_remove_cart() {
		if(isset($_POST['uid']) && $_POST['uid'] !='' && isset($_POST['room_type_id']) && $_POST['room_type_id'] !='' && isset($_POST['item_price']) && $_POST['item_price'] !=''){
			$uid = $_POST['uid'];						
			$room_type_id = $_POST['room_type_id'];			
			$item_price = $_POST['item_price'];
			$itemsLength = $_POST['itemsLength'];			
			$sessionKey = $uid;			
			unset($_SESSION['cart'][$sessionKey]['room'][$room_type_id]);
			$_SESSION['cart'][$sessionKey]['total_price'] = $_SESSION['cart'][$sessionKey]['total_price'] - $item_price;
			if($itemsLength == 0) $_SESSION['cart'] = '';
			
			wp_send_json( array( 'success'=>1, 'message'=>'success' ) );
		} else {
			wp_send_json( array( 'success'=>0, 'message'=>'fails' ) );
		}
	}
}

/*
 * Handle submit booking ajax request
 */
if ( ! function_exists( 'ct_hotel_submit_booking' ) ) {
	function ct_hotel_submit_booking() {
		global $wpdb, $ct_options;

		// validation
		$result_json = array( 'success' => 0, 'result' => '', 'order_id' => 0 );

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
		$post_fields = array( 'first_name', 'last_name', 'email', 'phone', 'country', 'address1', 'address2', 'city', 'state', 'zip', 'special_requirements');
		$order_info = ct_order_default_order_data( 'new' );
		foreach ( $post_fields as $post_field ) {
			if ( ! empty( $_POST[ $post_field ] ) ) {
				$order_info[ $post_field ] = sanitize_text_field( $_POST[ $post_field ] );
			}
		}

		$latest_order_id = $wpdb->get_var( 'SELECT id FROM ' . CT_ORDER_TABLE . ' ORDER BY id DESC LIMIT 1' );
		$booking_no = mt_rand( 1000, 9999 );
		$booking_no .= $latest_order_id;
		$pin_code = mt_rand( 1000, 9999 );

		$cart_data = CT_Hotel_Cart::get( $uid );
		$order_info['total_price'] = $cart_data['total_price'];
		$order_info['total_adults'] = $cart_data['total_adults'];
		$order_info['total_kids'] = $cart_data['total_kids'];
		$order_info['status'] = 'new'; // new
		$order_info['deposit_paid'] = 1;
		$order_info['mail_sent'] = 0;
		$order_info['post_id'] = $cart_data['hotel_id'];
		$order_info['date_from'] = date( 'Y-m-d', ct_strtotime( $cart_data['date_from'] ) );
		$order_info['date_to'] = date( 'Y-m-d', ct_strtotime( $cart_data['date_to'] ) );
		$order_info['booking_no'] = $booking_no;
		$order_info['pin_code'] = $pin_code;
		$order_info['post_type'] = 'hotel';
		$dateFrom = date( 'Y-m-d', ct_strtotime( $cart_data['date_from'] ) );
		$dateTo = date( 'Y-m-d', ct_strtotime( $cart_data['date_to'] ) );
		$diff = abs(strtotime($dateTo) - strtotime($dateFrom));
		$years = floor($diff / (365*60*60*24));
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
		$totalDays = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
		
		// calculate deposit payment
		$deposit_rate = get_post_meta( $cart_data['hotel_id'], '_hotel_security_deposit', true );
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
				//$order_info['deposit_price'] = $deposit_rate / 100 * $order_info['total_price'] * $order_info['exchange_rate'];
				$decimal_prec = isset( $ct_options['decimal_prec'] ) ? $ct_options['decimal_prec'] : 2;
				$order_info['deposit_price'] = round( $deposit_rate / 100 * $order_info['total_price'] * $order_info['exchange_rate'], $decimal_prec );
			$order_info['deposit_paid'] = 0; // set unpaid if payment enabled
			$order_info['status'] = 'pending';
		}
		$order_info['created'] = date( 'Y-m-d H:i:s' );
		$order_info['payment_method'] = $_POST['payment_info'];
		if ( $wpdb->insert( CT_ORDER_TABLE, $order_info ) ) {
			CT_Hotel_Cart::_unset( $uid );
			$order_id = $wpdb->insert_id;
			if ( ! empty( $cart_data['room'] ) ) {
				$totalRooms = 0;
				$totalAdults = 0;
				$totalKids = 0;
				$totalPrice = 0;
				$roomDetails = $cart_data['room'];
				foreach ( $cart_data['room'] as $room_id => $room_data ) {
					$room_booking_info = array();
					$room_booking_info['order_id'] = $order_id;
					$room_booking_info['hotel_id'] = $cart_data['hotel_id'];
					$room_booking_info['room_type_id'] = $room_id;
					$room_booking_info['rooms'] = $room_data['rooms'];
					$room_booking_info['adults'] = $room_data['adults'];
					$room_booking_info['kids'] = $room_data['kids'];
					$room_booking_info['total_price'] = $room_data['total'];
					 $totalRooms+= $room_data['rooms'];
					 $totalAdults+= $room_data['adults'];
					 $totalKids+= $room_data['kids'];
					 $totalPrice+= $room_data['total'];
					 $roomsInfo .= esc_html( $room_data['rooms'] . ' ' . get_the_title( $room_id ) ) . '<br>';
					$wpdb->insert( CT_HOTEL_BOOKINGS_TABLE, $room_booking_info );
				}
				$totalVat = ($totalPrice*20)/100;
				$totalPriceWithVat = $totalVat + $totalPrice;
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
				else if ( isset( $_POST['payment_info'] ) && $_POST['payment_info'] == 'pay_hotel' ) { 
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
				$paymentNote = esc_html__( 'Please pay via bkash to +88 01977717716 number and mention the booking reference ('.$bookingNo.') with in the next 72 hours. Otherwise your booking will be cancelled.' );
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
			$total_kids = $cart_data['total_kids'];
			$status = 'new'; // new
			$deposit_paid = 1;			
			$hotel_id = $cart_data['hotel_id'];
			$hotelName = get_the_title($hotel_id);
			$hotelUrl = get_permalink( $hotel_id );		
			
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
			$mail->AddAddress('jakir44.du@gmail.com', 'bdsmartapp');  // Add a recipient
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
			
			$hotel_address 	= get_post_meta( $hotel_id, '_hotel_address', true );
			$hotel_email 	= get_post_meta( $hotel_id, '_hotel_email', true );
			if($hotel_email){
			$mail->addCC($hotel_email, $hotelName);  // Add a recipient
			}
			$hotel_phone 	= get_post_meta( $hotel_id, '_hotel_phone', true );
			$hotel_loc 	= get_post_meta( $hotel_id, '_hotel_loc', true );
			$message = '<html><body>';		
			$message .= '<table bgcolor="#f6f6f6" width="680px" border="0" cellpadding="0" cellspacing="0" align="center"><tbody><tr><td width="100%" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center"><tbody><tr><td width="100%" bgcolor="#ffffff"><table width="580" border="0" cellpadding="0" cellspacing="0" align="center"><tbody><tr><td width="580"><table border="0" cellpadding="0" cellspacing="0" align="left"><tbody><tr><td height="14"></td></tr><tr><td height="50"><a href="'.$home_url.'" target="_blank"><img src="'.$logo_url.'" alt="" border="0" class="CToWUd"></a></td></tr><tr><td height="12"></td></tr></tbody></table><table border="0" cellpadding="0" cellspacing="0" align="right"><tbody><tr><td height="13"></td></tr><tr><td height="50" style="font-size:13px;color:#272727;font-weight:light;text-align:right;font-family:Helvetica,Arial,sans-serif;line-height:20px;vertical-align:middle"></td></tr><tr><td height="12"></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" style="border-top:1px solid #ebebeb"><tbody><tr><td width="100%" valign="top"><table width="580" border="0" cellpadding="0" cellspacing="0" align="center" style="margin:24px auto 0;background-color:#fff;border:1px solid #ebebeb"><tbody><tr><td>  </td></tr> <tr><td width="560">  <table width="560" border="0" cellpadding="0" cellspacing="0" align="center"><tbody><tr><td height="10"></td> </tr> <tr><td> </td> </tr><tr><td height="10"></td> </tr><tr><td height="10" style="font-size:13px;line-height:1.9;font-weight:400;font-family:Helvetica,Arial,sans-serif;text-decoration:none;color:#7b7b7b;padding:0 0 0px"><table>
			<tbody style="margin-bottom:12px">';
			$message .= '<tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes">  
			  <td colspan="3" style="">
			  <div class="MsoNormal" align="left" style="margin-bottom:0in;margin-bottom:.0001pt;
			  text-align:left;line-height:12.55pt">
			  <strong>Booking confirmation</strong>
			  <br><div style="font-size: 12px;margin-top: 12px;">Dear '.$senderName.',</div><br>
			  <div style="font-size:11px;font-weight:bold;">Thank you for your reservation made through ghuri.online. Please print this confirmation and show it upon hotel check in</div>
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
				<td valign=top style="padding:0pt 3.0pt 2.35pt 10.05pt">
				<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
				line-height:12.55pt"><b><span lang=EN-GB style="font-size:9.0pt;font-family:
				"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB">Address:</span></b><span
				lang=EN-GB style="font-size:9.0pt;font-family:"Helvetica","sans-serif";
				mso-fareast-font-family:"Times New Roman";color:#85c99d;mso-fareast-language:
				EN-GB"></span></p>
				</td>
				<td valign=top style="padding:0pt 3.0pt 2.35pt 10.05pt;">
				<p class=MsoNormal align=center style="margin-bottom:0in;margin-bottom:
				.0001pt;mso-add-space:auto;text-align:center;line-height:normal"><span
				class=SpellE><span lang=EN-GB style="font-size:12.0pt;font-family:"Times New Roman","serif";
				mso-fareast-font-family:"Times New Roman";color:#85c99d;mso-fareast-language:
				EN-GB">'.$senderAddress.'</span></span><span lang=EN-GB style="font-size:12.0pt;
				font-family:"Times New Roman","serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB"></span></p>
				</td>
			   </tr>    
			   <tr style="mso-yfti-irow:4">
				<td width=100 valign=top style="border-top:1px solid #85c99d;width:75.0pt;padding:8.35pt 3.0pt 3.0pt 10.05pt">
				<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
				line-height:12.55pt"><b><span lang=EN-GB style="font-size:9.0pt;font-family:
				"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB">Your reservation:</span></b><span
				lang=EN-GB style="font-size:9.0pt;font-family:"Helvetica","sans-serif";
				mso-fareast-font-family:"Times New Roman";color:#85c99d;mso-fareast-language:
				EN-GB"></span></p>
				</td>
				<td width=200 valign=top style="border-top:1px solid #85c99d;width:150.0pt;padding:8.35pt 10.05pt 3.0pt 3.0pt">
				<p class=MsoNormal align=right style="margin-bottom:0in;margin-bottom:.0001pt;
				text-align:right;line-height:12.55pt"><span lang=EN-GB style="font-size:
				9.0pt;font-family:"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB">'.$totalDays.' Nights, '.$totalRooms.' Room, '.$totalAdults.' adults, '.$totalKids.' Children </span></p>
				</td>
			   </tr>
			   <tr style="mso-yfti-irow:5">
				<td colspan=2 valign=top style="padding:3.0pt 10.05pt 3.0pt 10.05pt">
				<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
				 width="100%" style="width:100.0%;mso-cellspacing:0in;mso-yfti-tbllook:
				 1184;mso-padding-alt:0in 0in 0in 0in">
				 <tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes;mso-yfti-lastrow:yes">
				  <td width=75 style="width:56.25pt;padding:0in 0in 0in 0in">
				  <p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
				  line-height:12.55pt"><b><span lang=EN-GB style="font-size:9.0pt;
				  font-family:"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				  mso-fareast-language:EN-GB">Check-in:</span></b><span lang=EN-GB
				  style="font-size:9.0pt;font-family:"Helvetica","sans-serif";mso-fareast-font-family:
				  "Times New Roman";mso-fareast-language:EN-GB"></span></p>
				  </td>
				  <td style="padding:0in 0in 0in 0in">
				  <p class=MsoNormal align=right style="margin-bottom:0in;margin-bottom:
				  .0001pt;text-align:right;line-height:12.55pt"><span lang=EN-GB
				  style="font-size:9.0pt;font-family:"Helvetica","sans-serif";mso-fareast-font-family:
				  "Times New Roman";mso-fareast-language:EN-GB">'.$date_from.' <i><span
				  style="color:#555555">(14:00)</span></i></span></p>
				  </td>
				 </tr>
				</table>
				</td>
			   </tr>
			   <tr style="mso-yfti-irow:6">
				<td colspan=2 valign=top style="padding:3.0pt 10.05pt 8.35pt 10.05pt">
				<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
				 width="100%" style="width:100.0%;">
				 <tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes;mso-yfti-lastrow:yes">
				  <td width=75 style="width:56.25pt;padding:0in 0in 0in 0in">
				  <p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
				  line-height:12.55pt"><b><span lang=EN-GB style="font-size:9.0pt;
				  font-family:"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				  mso-fareast-language:EN-GB">Check-out:</span></b><span lang=EN-GB
				  style="font-size:9.0pt;font-family:"Helvetica","sans-serif";mso-fareast-font-family:
				  "Times New Roman";mso-fareast-language:EN-GB"></span></p>
				  </td>
				  <td width=237 style="width:177.75pt;padding:0in 0in 0in 0in">
				  <p class=MsoNormal align=right style="margin-bottom:0in;margin-bottom:
				  .0001pt;text-align:right;line-height:12.55pt"><span lang=EN-GB
				  style="font-size:9.0pt;font-family:"Helvetica","sans-serif";mso-fareast-font-family:
				  "Times New Roman";mso-fareast-language:EN-GB">'.$date_to.' <i><span
				  style="color:#555555">(12:00)</span></i></span></p>
				  </td>
				 </tr>
				</table>
				</td>
			   </tr>  
			   <tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes">
				<td colspan=2 style="border-top:1px solid #85c99d;padding:8.35pt 8.35pt 8.35pt 8.35pt">
				<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
				line-height:normal"><b><u><span lang=EN-GB style="font-size:13.5pt;
				font-family:"Times New Roman","serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB"><a
				href="'.$hotelUrl.'" 
				target="_blank" title="Hotel information"><span style="font-size:12.0pt;
				font-family:"Helvetica","sans-serif";color:#0000EE">'.$hotelName.'</span></a></span></u></b></p>
				</td>
			   </tr>
			   <tr style="mso-yfti-irow:1">
				<td valign=top style="padding:8.35pt 8.35pt 8.35pt 8.35pt">
				<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
				line-height:12.55pt"><b><span lang=EN-GB style="font-size:9.0pt;font-family:
				"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB">Address:</span></b><span
				lang=EN-GB style="font-size:9.0pt;font-family:"Helvetica","sans-serif";
				mso-fareast-font-family:"Times New Roman";color:#85c99d;mso-fareast-language:
				EN-GB"></span></p>
				</td>
				<td valign=top style="padding:8.35pt 8.35pt 8.35pt 8.35pt">
				<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
				line-height:12.55pt;text-align:right;"><span lang=EN-GB style="font-size:9.0pt;font-family:
				"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB">'.$hotel_address.'</span>,
				</span></p>
				</td>
			   </tr>
			   <tr style="mso-yfti-irow:2">
				<td valign=top style="padding:8.35pt 8.35pt 8.35pt 8.35pt">
				<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
				line-height:12.55pt"><b><span lang=EN-GB style="font-size:9.0pt;font-family:
				"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB">Phone:</span></b><span
				lang=EN-GB style="font-size:9.0pt;font-family:"Helvetica","sans-serif";
				mso-fareast-font-family:"Times New Roman";color:#85c99d;mso-fareast-language:
				EN-GB"></span></p>
				</td>
				<td valign=top style="padding:8.35pt 8.35pt 8.35pt 8.35pt">
				<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
				line-height:12.55pt;text-align:right;"><u><span lang=EN-GB style="font-size:9.0pt;mso-bidi-font-size:
				11.0pt;font-family:"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:blue;mso-fareast-language:EN-GB">'.$hotel_phone.'</span></u><span
				lang=EN-GB style="font-size:9.0pt;font-family:"Helvetica","sans-serif";
				mso-fareast-font-family:"Times New Roman";color:#85c99d;mso-fareast-language:
				EN-GB"></span></p>
				</td>
			   </tr>
			   <tr style="mso-yfti-irow:3">
				<td valign=top style="padding:8.35pt 8.35pt 8.35pt 8.35pt">
				<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
				line-height:12.55pt"><b><span lang=EN-GB style="font-size:9.0pt;font-family:
				"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB">E-mail:</span></b></p>
				</td>
				<td valign=top style="padding:8.35pt 8.35pt 8.35pt 8.35pt;text-align:right;">'.$hotel_email.'</td>
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
				"Times New Roman";color:#85c99d;mso-fareast-language:EN-GB">'.$roomsInfo.'</span></b><span
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
				color:#85c99d;font-weight:bold;">BDT '.$totalPrice.'</span></p>
				</td>
			   </tr>
			   <tr style="mso-yfti-irow:10;mso-yfti-lastrow:yes">
				<td colspan=2 style="padding:3.0pt 10.05pt 8.35pt 5.0pt">
				<p class=MsoNormal style="line-height:12.55pt"><span lang=EN-GB style="font-size:9.0pt;
				font-family:"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#333333;mso-fareast-language:EN-GB">Please note:  Extra bed  are not added to this total</span></p>
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
			if(!empty($roomDetails)){
				$cou = 1;
				foreach($roomDetails as $room_id => $roomDetail){					
					$roomName = get_the_title($room_id);
					$total_room_item = $roomDetail['rooms'];
					$total_adults_item = $roomDetail['adults'];
					$total_kids_item = $roomDetail['kids'];
					$room_max_adults = get_post_meta( $room_id, '_room_max_adults',true );
					if($room_max_adults == 1){
						$max_adults = '+'.$room_max_adults.' Adult';
					}
					else if($room_max_adults > 1){
						$max_adults = ' +'.$room_max_adults.' Adults';
					} else {
						$max_adults = '';
					}
					if($total_kids_item == 1){
						$totalKidss = ' +'.$total_kids_item.' Child';
					}
					else if($total_kids_item > 1){
						$totalKidss = '+'.$total_kids_item.' Children';
					} else {
						$totalKidss = '';
					}					
					$total_price_item = $roomDetail['total'];
					$totalVat = ($total_price_item*20)/100;
					$totalsPrice = $total_price_item + $totalVat;
					$eachRoomPrice = $total_price_item/$total_room_item;
					$hotel_facilities = get_the_terms( $room_id, 'hotel_facility' );
					if ( ! $hotel_facilities || is_wp_error( $hotel_facilities ) ) $hotel_facilities = array();
					foreach ( $hotel_facilities as $hotel_term ) :						
						$room_facilities[] = esc_html( $hotel_term->name );						
					endforeach;
					$all_room_facilities = implode(', ', $room_facilities);
				for($i=0;$i<$total_room_item;$i++){					
					 $message .= '<tr>
					 <td colspan="3">
							<table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%;">
					   <tbody><tr>
						<td style="border:solid #CDCDCD 1.0pt;border-bottom:none;background-color:rgba(225,77,103,0.1);color:#000;padding:8.35pt 6.05pt 6.05pt 10.05pt">
						<p class="MsoNormal" style=""><b><span lang="EN-GB" style="font-size:11.5pt;font-family:" helvetica","sans-serif";mso-fareast-font-family:="" "times="" new="" roman";color:#85c99d;>Room '.$cou.', '.$roomName.'</span></b></p>
						</td>
					   </tr>
						<tr>
					  <td width=584 valign=top style="width:438.25pt;border:solid #CCCCCC 1.0pt;
					  border-top:none;padding:5.0pt 5.0pt 5.0pt 5.0pt">
					  <p class=normal style="margin-top:11.0pt;margin-right:0in;margin-bottom:11.0pt;
					  margin-left:0in;line-height:132%"><span style="font-size:8.5pt;line-height:
					  132%;background:white">'.$all_room_facilities.' are included in this room.</span></p>
					  <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0
					   style="border-collapse:collapse;width:100%;">
					   <tr>
						<td width=79 valign=top style="width:20%;padding:0;margin:0;">
						<p class=normal style="margin:0;"><span style="font-size:8.5pt;background:white;margin:0;">Guest Name:</span></p>
						</td>
						<td width=79 valign=top style="width:80%;padding:0;margin:0;">
						<p class=normal style="margin:0;"><span style="font-size:8.5pt;background:white;margin:0;">'.$senderName.'</span></p>
						</td>
					   </tr>
					   <tr>
						<td width=79 valign=top style="width:59.5pt;padding:0;margin:0;">
						<p class=normal style="margin:0;"><span style="font-size:8.5pt;background:white;">Max persons:</span></p>
						</td>
						<td width=79 valign=top style="width:59.5pt;padding:0;margin:0;">
						<p class=normal style="margin:0;"><span style="font-size:8.5pt;background:white;">'.$max_adults.'</span></p>
						</td>
					   </tr>
					  </table>
					  </td>  
					 </tr>
					 <tr>
					  <td width=584 valign=top style="width:438.25pt;border:solid #CCCCCC 1.0pt;
					  border-top:none;padding:5.0pt 5.0pt 5.0pt 5.0pt">
					  <h4 style="margin:0;line-height:132%;page-break-after:auto"><b><span
					  style="font-size:8.5pt;line-height:132%;color:black;background:white">Meal
					  plan:</span></b><a name=h.fetmscay2l3y></a></h4>
					  <p class=normal style="margin-left:30px;text-indent:-.25in;margin-top:6px;margin-bottom:4px;"><span
					  style="font-size:8.5pt;line-height:115%;background:white">&#9679;<span
					  style="font:7.0pt "Times New Roman"">&nbsp;&nbsp; </span></span><span
					  style="font-size:8.5pt;line-height:115%;background:white">Breakfast Included</span></p>
					  <h4 style="margin:0;line-height:132%;page-break-after:auto"><b><span
					  style="font-size:8.5pt;line-height:132%;color:black;background:white;">Prepayment:</span></b><a
					  name=h.6q050zp8zjyq></a></h4>
					  <p class=normal style="margin-left:30px;text-indent:-.25in;margin-top:6px;margin-bottom:4px;"><span
					  style="font-size:8.5pt;line-height:115%;background:white">&#9679;<span
					  style="font:7.0pt "Times New Roman"">&nbsp;&nbsp; </span></span><span
					  style="font-size:8.5pt;line-height:115%;background:white">'.$paymentNote.'</span></p>
					  <h4 style="margin:0;line-height:132%;page-break-after:auto"><b><span
					  style="font-size:8.5pt;line-height:132%;color:black;background:white">Cancellation
					  policy:</span></b><a name=h.1ed94mkgr05t></a></h4>
					  <p class=normalCxSpFirst style="margin-left:30px;text-indent:-.25in;margin-top:6px;margin-bottom:4px;"><span
					  style="font-size:8.5pt;line-height:115%;background:white">&#9679;<span
					  style="font:7.0pt "Times New Roman"">&nbsp;&nbsp; </span></span><span
					  style="font-size:8.5pt;line-height:115%;background:white">Hotel Standard cancellation policy.</span></p>
					  <table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0 width=100%
					   style="border-collapse:collapse;border:none;margin-top: 15px;">
					   <tr>
						<td width=395 valign=top style="width:296.2pt;border:solid #85c99d 1.0pt;
						padding:4.0pt 4.0pt 4.0pt 4.0pt">
						<p class=normal style="margin-top:7pt;line-height:100%;"><span
						style="font-size:8.5pt;line-height:100%;background:white">Room price</span></p>
						</td>
						<td width=163 valign=top style="width:122.0pt;border:solid #85c99d 1.0pt;
						border-left:none;padding:4.0pt 4.0pt 4.0pt 4.0pt">
						<p class=normal style="margin-top:7pt;line-height:100%;"><b><span
						style="font-size:8.5pt;line-height:100%;background:white">BDT '.$eachRoomPrice.'</span></b></p>
						</td>
					   </tr>
					   <tr>
						<td width=395 valign=top style="width:296.2pt;border-bottom:solid #565a5c 1.0pt;border:solid #85c99d 1.0pt;
						border-top:none;padding:4.0pt 4.0pt 4.0pt 4.0pt">
						<p class=normal style="margin-top:7pt;line-height:100%;"><span
						style="font-size:8.5pt;line-height:100%;background:white">Inclusive of Service Charge & Vat</span></p>
						</td>
						<td width=163 valign=top style="width:122.0pt;border-top:none;border-left:
						none;border-bottom:solid #85c99d 1.0pt;border-right:solid #85c99d 1.0pt;
						padding:4.0pt 4.0pt 4.0pt 4.0pt">
						<p class=normal style="margin-top:7pt;line-height:100%;"><b><span
						style="font-size:8.5pt;line-height:100%;background:white">-</span></b></p>
						</td>
					   </tr>
					   <tr>
						<td width=395 valign=top style="width:296.2pt;border:solid #85c99d 1.0pt;
						border-top:none;border-right:solid #fff 1.0pt;background-color:rgba(225,77,103,0.1);padding:2pt 4.0pt 4.0pt 4.0pt">
						<p class=normal style="margin-top:7pt;line-height:100%;"><b><span
						style="font-size:10.0pt;color:#000;">Cost
						of this room:</span></b></p>
						</td>
						<td width=163 valign=top style="width:122.0pt;border-top:none;border-left:
						none;border-bottom:solid #85c99d 1.0pt;border-right:solid #85c99d 1.0pt;background-color:rgba(225,77,103,0.1);padding:2pt 4.0pt 4.0pt 4.0pt">
						<p class=normal style="margin-top:7pt;line-height:100%;"><b><span
						style="font-size:10.0pt;color:#000;">BDT '.$eachRoomPrice.'</span></b></p>
						</td>
					   </tr>
					  </table>
					  <p class=normal style="line-height:100%"></p>
					  </td>  
					 </tr>
					  </table>
						</td>
					 </tr> 
					 <tr>
					  <td style="padding:0in 0in 0in 0in;height:16.75pt"></td>
					  <td style="padding:0in 0in 0in 0in;height:16.75pt"></td>
					  <td style="padding:0in 0in 0in 0in;height:16.75pt"></td>
					 </tr>';
					 $cou++;
				}
				}
			}
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

/*
 * update room list based on hotel_id
 */
if ( ! function_exists( 'ct_ajax_hotel_get_hotel_room_list' ) ) {
	function ct_ajax_hotel_get_hotel_room_list() {
		$hotel_id = ( ! empty ( $_POST['hotel_id'] ) ) ? $_POST['hotel_id'] : 0;
		ct_hotel_get_room_list( $hotel_id );
	}
}
