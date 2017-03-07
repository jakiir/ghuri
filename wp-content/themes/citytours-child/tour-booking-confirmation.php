<?php
 /*
 Template Name: Tour Booking confirmation
 */
 echo '<link rel="stylesheet" id="dashicons-css" href="http://159.122.213.21/wp-content/themes/citytours/css/fontello/css/fontello.css?ver=4.5.2" type="text/css" media="all">';
 
 $order = new CT_Hotel_Order( $_REQUEST['booking_no'], $_REQUEST['pin_code'] );
 $order_data = $order->get_order_info();
$get_template_directory_ver = esc_url( get_template_directory_uri() );
$home_url = home_url('/');
$logo_url = $get_template_directory_ver.'/img/logo_sticky.png';

$tour_id = $order_data['post_id'];
$tourName = get_the_title($tour_id);
$hotelUrl = get_permalink( $tour_id );
$tour_address 	= get_post_meta( $tour_id, '_tour_address', true );
$tour_email 	= get_post_meta( $tour_id, '_tour_email', true );
$tour_phone 	= get_post_meta( $tour_id, '_tour_phone', true );
$tour_loc 	= get_post_meta( $tour_id, '_tour_loc', true );
$is_repeated =  get_post_meta( $tour_id, '_tour_repeated', true );
$tour_start_date =  $order_data['date_from'];

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

$booking_no = $order_data['booking_no'];
$pin_code = $order_data['pin_code'];
$pin_code = $order_data['pin_code'];
$senderEmail = $order_data['email'];
$first_name = $order_data['first_name'];
$last_name = $order_data['last_name'];
$senderName = $first_name.' '.$last_name;
$address[] = $order_data['address1'];
$address[] = $order_data['address2'];
$address[] = $order_data['city'];
$address[] = $order_data['state'];
$address[] = $order_data['zip'];
$address[] = $order_data['country'];
$payment_method = $order_data['payment_method'];
if($payment_method == 'bkash'){
	$bookingNo = ($_REQUEST['booking_no'] ? 'GH'.$_REQUEST['booking_no'] : 'GH****');
	$paymentNote = esc_html__( 'Thank you for your reservation made through ghuri.online. We have emailed you the booking confirmation. Please keep this booking reference ('.$bookingNo.') with you. We will confirm with the tour operator and come back to you within 72 hours. After which you may pay via bkash to +88 01977717716 number and mention this booking reference.' );
} else {
	$paymentNote = esc_html__( 'The total price of the reservation will be charged on the day of booking.');
}
$senderAddress = implode(', ', $address);
$date_from = date( 'l, jS F Y', ct_strtotime( $order_data['date_from'] ) );
$date_to = date( 'l, jS F Y', ct_strtotime( $order_data['date_to'] ) );
$diff = abs(strtotime($date_to) - strtotime($date_from));
$years = floor($diff / (365*60*60*24));
$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
$totalDays = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
$totalPrice = $order_data['total_price'];
$totalAdults = $order_data['total_adults'];
if($totalAdults > 1){
	$totalAdultss = $totalAdults.' Adults';
} else {
	$totalAdultss = $totalAdults.' Adult';
}
$totalKids = $order_data['total_kids'];
$order_rooms = $order->get_rooms();
if ( ! empty( $order_rooms ) ) {
	foreach ($order_rooms as $room ) {
		$roomsInfo .= esc_html( $room['rooms'] . ' ' . get_the_title( $room['room_type_id'] ) ) . '<br>';
		$totalRooms+= $room['rooms'];
	}
}

$message = '<html><body>';		
			$message .= '<table bgcolor="#f6f6f6" width="680px" border="0" cellpadding="0" cellspacing="0" align="center"><tbody><tr><td width="100%" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center"><tbody><tr><td width="100%" bgcolor="#ffffff"><table width="580" border="0" cellpadding="0" cellspacing="0" align="center"><tbody><tr><td width="580"><table border="0" cellpadding="0" cellspacing="0" align="left"><tbody><tr><td height="14"></td></tr><tr><td height="50"><a href="'.$home_url.'" target="_blank"><img src="'.$logo_url.'" alt="" border="0" class="CToWUd"></a></td></tr><tr><td height="12"></td></tr></tbody></table><table border="0" cellpadding="0" cellspacing="0" align="right"><tbody><tr><td height="13"><a href="javascript:window.print()"><i class="icon-print"></i>Print</a></td></tr><tr><td height="50" style="font-size:13px;color:#272727;font-weight:light;text-align:right;font-family:Helvetica,Arial,sans-serif;line-height:20px;vertical-align:middle"></td></tr><tr><td height="12"></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" style="border-top:1px solid #ebebeb"><tbody><tr><td width="100%" valign="top"><table width="580" border="0" cellpadding="0" cellspacing="0" align="center" style="margin:24px auto 0;background-color:#fff;border:1px solid #ebebeb"><tbody><tr><td>  </td></tr> <tr><td width="560">  <table width="560" border="0" cellpadding="0" cellspacing="0" align="center"><tbody><tr><td height="10"></td> </tr> <tr><td> </td> </tr><tr><td height="10"></td> </tr><tr><td height="10" style="font-size:13px;line-height:1.9;font-weight:400;font-family:Helvetica,Arial,sans-serif;text-decoration:none;color:#7b7b7b;padding:0 0 0px"><table>
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
				color:#85c99d;font-weight:bold;">'.$totalPrice.' BDT</span></p>
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
echo $message;
			
			/*$mail->Body    = $message;

$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->Send()) {
   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;
   exit;
}

echo 'Message has been sent';*/
?>
