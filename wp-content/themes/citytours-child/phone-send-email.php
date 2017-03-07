<?php
 echo '<link rel="stylesheet" id="dashicons-css" href="http://159.122.213.21/wp-content/themes/citytours/css/fontello/css/fontello.css?ver=4.5.2" type="text/css" media="all">';
 

$get_template_directory_ver = esc_url( get_template_directory_uri() );
$home_url = home_url('/');
$logo_url = $get_template_directory_ver.'/img/logo_sticky.png';

$senderName = (!empty($_REQUEST['fname']) ? $_REQUEST['fname'] : '');

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
$mail->AddAddress('support@ghuri.online', 'bdsmartapp');  // Add a recipient			
$mail->AddAddress('sales@ghuri.online', 'sales');
$mail->IsHTML(true);                                  // Set email format to HTML
$mail->Subject = 'Mobile number collection in ghuri.online';			

$message = '<html><body>';		
$message .= '<table bgcolor="#f6f6f6" width="680px" border="0" cellpadding="0" cellspacing="0" align="center"><tbody><tr><td width="100%" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center"><tbody><tr><td width="100%" bgcolor="#ffffff"><table width="580" border="0" cellpadding="0" cellspacing="0" align="center"><tbody><tr><td width="580"><table border="0" cellpadding="0" cellspacing="0" align="left"><tbody><tr><td height="14"></td></tr><tr><td height="50"><a href="'.$home_url.'" target="_blank"><img src="'.$logo_url.'" alt="" border="0" class="CToWUd"></a></td></tr><tr><td height="12"></td></tr></tbody></table><table border="0" cellpadding="0" cellspacing="0" align="right"><tbody><tr><td height="13"><a href="javascript:window.print()"><i class="icon-print"></i>Print</a></td></tr><tr><td height="50" style="font-size:13px;color:#272727;font-weight:light;text-align:right;font-family:Helvetica,Arial,sans-serif;line-height:20px;vertical-align:middle"></td></tr><tr><td height="12"></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table><table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" style="border-top:1px solid #ebebeb"><tbody><tr><td width="100%" valign="top"><table width="580" border="0" cellpadding="0" cellspacing="0" align="center" style="margin:24px auto 0;background-color:#fff;border:1px solid #ebebeb"><tbody><tr><td>  </td></tr> <tr><td width="560">  <table width="560" border="0" cellpadding="0" cellspacing="0" align="center"><tbody><tr><td height="10"></td> </tr> <tr><td> </td> </tr><tr><td height="10"></td> </tr><tr><td height="10" style="font-size:13px;line-height:1.9;font-weight:400;font-family:Helvetica,Arial,sans-serif;text-decoration:none;color:#7b7b7b;padding:0 0 0px"><table>
<tbody style="margin-bottom:12px">';
$message .= '<tr style="mso-yfti-irow:1">
  <td width=356 style="width:267.0pt;padding:0in 0in 0in 0in"></td>
  <td width=10 style="width:7.5pt;padding:0in 0in 0in 0in">
  <p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;line-height:
  12.55pt"><span lang=EN-GB style="font-size:9.0pt;font-family:"Helvetica","sans-serif";
  mso-fareast-font-family:"Times New Roman";mso-fareast-language:EN-GB">&nbsp;</span></p>
  </td>
  <td width=356 style="width:267.0pt;padding:0in 0in 0in 0in"></td>
 </tr>
 <tr style="mso-yfti-irow:2;border:1px solid #333;" >
 <td valign=top colspan="3" style="border:none;border-bottom:solid #E6EDF6 1.0pt;
  mso-border-bottom-alt:solid #E6EDF6 .75pt;padding:0in 0in 16.75pt 0in">
	<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 width="100%"
   style="border:1px solid #85c99d;padding-top: 10px;">
   
	<tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes">
		<td colspan="2" valign=top style="padding:0pt 3.0pt 2.35pt 10.05pt;width: 100%;">
		<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
		line-height:12.55pt"><b><span lang=EN-GB style="font-size:9.0pt;width:23%;display:inline-block;">Sender Name</span></b><span lang=EN-GB style="font-size:9.0pt;">  : '.$getFullName.'</span></p>
		</td>
	</tr>
	<tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes">
		<td colspan="2" valign=top style="padding:0pt 3.0pt 2.35pt 10.05pt;width: 100%;">
		<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
		line-height:12.55pt"><b><span lang=EN-GB style="font-size:9.0pt;width:23%;display:inline-block;">Sender Phone</span></b><span lang=EN-GB style="font-size:9.0pt;">  : '.$getPhone.'</span></p>
		</td>
	</tr>
	<tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes">
		<td colspan="2" valign=top style="padding:0pt 3.0pt 2.35pt 10.05pt;width: 100%;">
		<p class=MsoNormal style="margin-bottom:0in;margin-bottom:.0001pt;
		line-height:12.55pt"><b><span lang=EN-GB style="font-size:9.0pt;width:23%;display:inline-block;">Sender Inquiry</span></b><span lang=EN-GB style="font-size:9.0pt;">  : '.$inquiry.'</span></p>
		</td>
	</tr>
   </table>
   </td>
 
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
   $err_message = 'Message could not be sent.';
   $err_message .= 'Mailer Error: ' . $mail->ErrorInfo;
   $results = array('success'=>false, 'meg'=> $err_message);
	$response = json_encode($results);
	echo $response;
	exit;
} else {
	$results = array('success'=>true, 'meg'=> 'Successfully send you mobile number!');
	$response = json_encode($results);
	echo $response;
	exit;
}
?>
