<?php
 /*
 Template Name: MailSernder
 */
 
/*
require 'PHPMailer-master/PHPMailerAutoload.php';

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
$mail->AddAddress('even.khan@gmail.com', 'even');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
$mail->addCC('hazzaz77@gmail.com');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

$mail->IsHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Confirmation of Booking in ghuri.online';*/
$get_template_directory_ver = esc_url( get_template_directory_uri() );
$home_url = home_url('/');
$logo_url = $get_template_directory_ver.'/img/logo_sticky.png';

$hotel_id = 507;
$hotelName = get_the_title($hotel_id);
$hotelUrl = get_permalink( $hotel_id );
$hotel_address 	= get_post_meta( $hotel_id, '_hotel_address', true );
$hotel_email 	= get_post_meta( $hotel_id, '_hotel_email', true );
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
			  <div style="font-size:11px;font-weight:bold;">Thank you for your reservation made through ghuri.com. Please print this confirmation and show it upon hotel check in</div>
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
			   style="border:1px solid #85c99d">
			   <tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes">
				<td valign=top style="padding:0pt 3.0pt 2.35pt 10.05pt">
				<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
				line-height:12.55pt"><b><span lang=EN-GB style="font-size:9.0pt;mso-bidi-font-size:
				11.0pt;font-family:"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB">Booking</span></b><b><span
				lang=EN-GB style="font-size:9.0pt;font-family:"Helvetica","sans-serif";
				mso-fareast-font-family:"Times New Roman";color:#85c99d;mso-fareast-language:
				EN-GB"> number</span></b><span lang=EN-GB style="font-size:9.0pt;
				font-family:"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB"></span></p>
				</td>
				<td valign=top style="padding:0pt 3.0pt 2.35pt 10.05pt">
				<p class=MsoNormal align=right style="margin-bottom:0in;margin-bottom:.0001pt;
				text-align:right;line-height:12.55pt"><span lang=EN-GB style="font-size:
				9.0pt;font-family:"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB">GH'.$booking_no.'</span></p>
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
				line-height:12.55pt"><u><span lang=EN-GB style="font-size:9.0pt;mso-bidi-font-size:
				11.0pt;font-family:"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:blue;mso-fareast-language:EN-GB">'.$senderEmail.'</span></u><span
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
				.0001pt;mso-add-space:auto;text-align:center;line-height:normal"><span
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
				line-height:12.55pt"><span lang=EN-GB style="font-size:9.0pt;font-family:
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
				line-height:12.55pt"><u><span lang=EN-GB style="font-size:9.0pt;mso-bidi-font-size:
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
				<td valign=top style="padding:8.35pt 8.35pt 8.35pt 8.35pt">'.$hotel_email.'</td>
			   </tr>
			   <tr style="mso-yfti-irow:4">
				<td valign=top style="padding:8.35pt 8.35pt 8.35pt 8.35pt">
				<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
				line-height:12.55pt"><b><span lang=EN-GB style="font-size:9.0pt;font-family:
				"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB">Travel information:</span></b></p>
				</td>
				<td valign=top style="padding:8.35pt 8.35pt 8.35pt 8.35pt">
				<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
				line-height:12.55pt"><span lang=EN-GB style="font-size:9.0pt;font-family:
				"Helvetica","sans-serif";mso-fareast-font-family:"Times New Roman";
				color:#85c99d;mso-fareast-language:EN-GB"><a
				href="https://www.google.com.bd/maps/@'.$hotel_loc.',12z?hl=bn"
				target="_blank"><span style="mso-bidi-font-size:11.0pt">Show directions </span></a></span></p>
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
				<td valign=top style="border-bottom:none;border-right:none;background:#E6EDF6;padding:8.35pt 3.0pt 3.0pt 10.05pt">
				<p class=MsoNormal style="margin-top:6.7pt;margin-right:0in;margin-bottom:
				3.35pt;margin-left:0in;line-height:12.55pt"><b><span lang=EN-GB
				style="font-size:9.0pt;font-family:"Helvetica","sans-serif";mso-fareast-font-family:
				"Times New Roman";color:#85c99d;mso-fareast-language:EN-GB">'.$roomsInfo.'</span></b><span
				lang=EN-GB style="font-size:9.0pt;font-family:"Helvetica","sans-serif";
				mso-fareast-font-family:"Times New Roman";color:#85c99d;mso-fareast-language:
				EN-GB"></span></p>
				</td>
				<td valign=top style="background:
				#E6EDF6;padding:8.35pt 10.05pt 3.0pt 3.0pt"></td>
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
				color:#85c99d;mso-fareast-language:EN-GB">BDT '.$totalPrice.'</span></p>
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
				<td colspan=2 style="padding:8.35pt 8.35pt 8.35pt 8.35pt;height:198.0pt"></td>
			   </tr>
			  </table>
			  </td>
			 </tr>
			 <tr style="mso-yfti-irow:3;height:16.75pt">
			  <td style="padding:0in 0in 0in 0in;height:16.75pt"></td>
			  <td style="padding:0in 0in 0in 0in;height:16.75pt"></td>
			  <td style="padding:0in 0in 0in 0in;height:16.75pt"></td>
			 </tr>';
			 $roomDetails[515] = array(
				'rooms' => 2,
				'adults' => 1,
				'kids' => 0, 
				'total' => 1555				
			 );
			if(!empty($roomDetails)){
				$cou = 1;
				foreach($roomDetails as $room_id => $roomDetail){					
					$roomName = get_the_title($room_id);
					$total_room_item = $roomDetail['rooms'];
					$total_adults_item = $roomDetail['adults'];
					$total_kids_item = $roomDetail['kids'];
					$total_price_item = $roomDetail['total'];
					$totalVat = ($total_price_item*20)/100;
					$totalsPrice = $total_price_item + $totalVat;						
					 $message .= '<tr>
					 <td colspan="3">
							<table class="MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%;">
					   <tbody><tr>
						<td style="border:solid #CDCDCD 1.0pt;border-bottom:none;background-color:rgba(225,77,103,0.1);color:#000;padding:8.35pt 6.05pt 6.05pt 10.05pt">
						<p class="MsoNormal" style=""><b><span lang="EN-GB" style="font-size:11.5pt;font-family:" helvetica","sans-serif";mso-fareast-font-family:="" "times="" new="" roman";color:#85c99d;>Room '.$cou.', '.$roomName.' ('.$total_adults_item.' Adults)</span></b></p>
						</td>
					   </tr>
						<tr>
					  <td width=584 valign=top style="width:438.25pt;border:solid #CCCCCC 1.0pt;
					  border-top:none;padding:5.0pt 5.0pt 5.0pt 5.0pt">
					  <p class=normal style="margin-top:11.0pt;margin-right:0in;margin-bottom:11.0pt;
					  margin-left:0in;line-height:132%"><span style="font-size:8.5pt;line-height:
					  132%;background:white">A TV, tea and coffee making facilities and an en suite bathroom are included in this room.</span></p>
					  <table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width=159
					   style="width:119.0pt;border-collapse:collapse">
					   <tr>
						<td width=79 valign=top style="width:59.5pt;padding:5.0pt 5.0pt 5.0pt 5.0pt">
						<p class=normal><span style="font-size:8.5pt;background:white">Guest Name:</span></p>
						</td>
						<td width=79 valign=top style="width:59.5pt;padding:5.0pt 5.0pt 5.0pt 5.0pt;margin:0;">
						<p class=normal><span style="font-size:8.5pt;background:white;margin:0;">'.$senderName.'</span></p>
						</td>
					   </tr>
					   <tr>
						<td width=79 valign=top style="width:59.5pt;padding:5.0pt 5.0pt 5.0pt 5.0pt">
						<p class=normal><span style="font-size:8.5pt;background:white">Max persons:</span></p>
						</td>
						<td width=79 valign=top style="width:59.5pt;padding:5.0pt 5.0pt 5.0pt 5.0pt;margin:0;">
						<p class=normal><span style="font-size:8.5pt;background:white;margin:0;">'.$total_adults_item.' Audults '.$total_kids_item.' Children</span></p>
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
					  style="font-size:8.5pt;line-height:115%;background:white">The total price of the reservation will be charged on the day of booking.</span></p>
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
						style="font-size:8.5pt;line-height:100%;background:white">BDT '.$total_price_item.'</span></b></p>
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
						border-top:none;border-right:solid #fff 1.0pt;background-color: rgba(0,0,0,0.2);padding:2pt 4.0pt 4.0pt 4.0pt">
						<p class=normal style="margin-top:7pt;line-height:100%;"><b><span
						style="font-size:10.0pt;color:#fff;">Cost
						of this room:</span></b></p>
						</td>
						<td width=163 valign=top style="width:122.0pt;border-top:none;border-left:
						none;border-bottom:solid #85c99d 1.0pt;border-right:solid #85c99d 1.0pt;background-color: rgba(0,0,0,0.2);padding:2pt 4.0pt 4.0pt 4.0pt">
						<p class=normal style="margin-top:7pt;line-height:100%;"><b><span
						style="font-size:10.0pt;color:#fff;">BDT '.$total_price_item.'</span></b></p>
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
			$message .= '</tbody>';
			$message .= '</table>';
			$message .= '<p>&nbsp;</p>';
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
			$message .= '<tbody><tr><td style="font-weight:400;font-size:12px;color:#b2b3b6;font-weight:bold;text-align:left;font-family:Open sans;line-height:2.8;vertical-align:top">&nbsp;&nbsp;Contact Info:</td></tr></tbody></table>';	
			$message .= '<table width="35%" border="0" cellpadding="0" cellspacing="0" align="right"><tbody><tr style="float:right"><td style="float:left;margin-top:5px">';	
			$message .= '<a style="float:right;margin-right:10px" href="#" target="_blank"><img src="'.$get_template_directory_ver.'/img/icons/youtube_hover.png" class=""></a>';			
			$message .= '<a style="float:right;margin-right:10px" href="#" target="_blank"><img src="'.$get_template_directory_ver.'/img/icons/twitter_hover.png" class=""></a>';
										
			$message .= '<a style="float:right;margin-right:10px" href="#" target="_blank"><img src="'.$get_template_directory_ver.'/img/icons/facebook_hover.png" class=""></a>';
									
			$message .= '</td></tr></tbody></table></td></tr><tr><td style="margin-bottom:15px;color:rgb(178,179,182);font-family:Helvetica,Arial,sans-serif;font-size:14px;font-weight:bold;line-height:1;text-align:left;vertical-align:top;">&nbsp; &nbsp;<img style="display:inline-block;margin-bottom:8px;" src="'.$get_template_directory_ver.'/img/icons/phone_hover.png" class=""><span style="display:inline-block;margin-top:4px;margin-left:7px;vertical-align:top;">01977717716</span><br><img style="display:inline-block;margin-left:10px" src="'.$get_template_directory_ver.'/img/icons/letter_hover.png" class=""><span style="display:inline-block;margin-top:4px;margin-left:7px;vertical-align:top;">info@ghuri.online</span></td></tr><tr><td style="margin-bottom:15px;color:rgb(178,179,182);font-family:Helvetica,Arial,sans-serif;font-size:12px;font-weight:bold;line-height:4;text-align:center;vertical-align:top;">@2016 ghuri.online. All rights reserved</td></tr></tbody></table>';
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
