<?php
 /*
 Template Name: Supplier Register Template
 */
get_header();
if ( have_posts() ) {	
global $wpdb;
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['register']) && $_POST['regInfo'] == "pass")
    {
		$userID					= '';
		$username				= $_POST['itemname'];
        $fullName				= $_POST['fname'];		      
		$email					= $_POST['email'];
		$mobile					= $_POST['mobile'];
		$country				= $_POST['country'];
		$state					= $_POST['state'];		
		$city					= $_POST['city'];
		$address1				= $_POST['address1'];
		$address2				= $_POST['address2'];
		$regFor					= $_POST['regFor'];
		$fullNa = explode(' ',$fullName);
		$firstname = (!empty($fullNa[0]) ? $fullNa[0] : '');
		$lastname = (!empty($fullNa[1]) ? $fullNa[1] : '');

		if ( !is_user_logged_in() ) {
				$ola_user = username_exists( $username );
				$newUserEmail = email_exists( $email );
				$uniqueId = uniqid();
				if(!$newUserEmail){        
					if ( !$ola_user ) {
						$userData = array(
							'user_login' => $username,
							'first_name' => $firstname,
							'last_name' => $lastname,
							'display_name' => $fullName,
							'user_pass' => $uniqueId,
							'user_email' => $email,
							'user_url' => '',
							'role' => $regFor
						);			
						$createUser = wp_insert_user( $userData );			
										
							if($createUser){	
								               
								add_user_meta( $createUser, 'phone', $mobile, true );
								add_user_meta( $createUser, 'country_code', $country, true );
								add_user_meta( $createUser, 'address1', $address1, true );
								add_user_meta( $createUser, 'address2', $address2, true );
								add_user_meta( $createUser, 'city', $city, true );
								add_user_meta( $createUser, 'state', $state, true );
								
								if(!is_user_logged_in()) :
									$creds = array();
									$creds['user_login'] = $username;
									$creds['user_password'] = $uniqueId;                
									$creds['remember'] = true;
									$user = wp_signon( $creds, false );
								endif;
												
								$userInfo = $wpdb->insert_id;
								
								if($userInfo){
									require get_stylesheet_directory().'/regi-email.php';
								}
								
						}	
					} else {
						$userexists = "Sorry, username already exists!";
					}
			} else {
				$emilexists = "Sorry, email already exists!"; 
			}
		}
		if ( is_user_logged_in() ) {
			$current_user = wp_get_current_user();
			$user_id = $current_user->ID;
			
			$updateData = array(
				'ID' => $user_id,						
				'user_email' => $email,
				'first_name' => $firstname,
				'last_name' => $lastname,
				'display_name' => $fullName				
			);			
			$updateUser = wp_update_user( $updateData );						
			if($updateUser){	                
				update_user_meta( $user_id, 'phone', $mobile );
				update_user_meta( $user_id, 'country_code', $country );
				update_user_meta( $user_id, 'address1', $address1 );
				update_user_meta( $user_id, 'address2', $address2 );
				update_user_meta( $user_id, 'city', $city );
				update_user_meta( $user_id, 'state', $state );								
			}
		}
}
	
	$_countries = ct_get_all_countries();
	$user_info = ct_get_current_user_info();
	while ( have_posts() ) : the_post();
		$post_id = get_the_ID();
		$sidebar_position = ct_get_sidebar_position( $post_id );
		$content_class = 'post-content';
		if ( 'no' != $sidebar_position ) $content_class .= ' col-md-9';

		$slider_active = get_post_meta( $post_id, '_rev_slider', true );
		$slider        = ( $slider_active == '' ) ? 'Deactivated' : $slider_active;
		if ( class_exists( 'RevSlider' ) && $slider != 'Deactivated' ) {
			echo '<div id="slideshow">';
			putRevSlider( $slider );
			echo '</div>';
		} else {
			$header_img_scr = ct_get_header_image_src( $post_id );
			if ( ! empty( $header_img_scr ) ) {
				$header_img_height = ct_get_header_image_height( $post_id );
				$header_content = get_post_meta( $post_id, '_header_content', true );
				?>

				<section class="parallax-window" data-parallax="scroll" data-image-src="<?php echo esc_url( $header_img_scr ) ?>" data-natural-width="1400" data-natural-height="<?php echo esc_attr( $header_img_height ) ?>">
				<?php //require_once('advance_search.php'); ?>
					<div class="parallax-content-1">
						<div class="animated fadeInDown">
						<h1 class="page-title"><?php the_title(); ?></h1>
						<?php echo balancetags( $header_content ); ?>
							<div style="margin-top:120px" class="form-group">
								<button id="hotels" class="btnz btn btn-default btn-lg showform"><i class="icon-building"></i> Hotel</button>
								<button id="tours" class="btnz btn btn-default btn-lg showform"><i class="icon-slideshare"></i> Tour</button>
							</div>
						</div>
						
					</div>
				</section><!-- End section -->
			<?php } ?>
			

			<?php if ( ! is_front_page() ) : ?>
				<div id="position" <?php if ( empty( $header_img_scr ) ) echo 'class="blank-parallax"' ?>>
					<div class="container"><?php ct_breadcrumbs(); ?></div>
				</div><!-- End Position -->
			<?php endif; ?>
		<?php } ?>

<div class="container margin_60">
	<div class="<?php if ( 'no' != $sidebar_position ) echo 'row' ?>">
		<?php if ( 'left' == $sidebar_position ) : ?>
			<aside class="col-md-3 add_bottom_30"><?php generated_dynamic_sidebar(); ?></aside><!-- End aside -->
		<?php endif; ?>
		<div class="<?php //echo esc_attr( $content_class ); ?>">
			<form id="supplier-register" action="#" method="post" enctype="multipart/form-data">
				<div class="row">
					<div class="col-md-12">					
						<div class="form_title">
							<h3><strong>1</strong><?php echo esc_html__( 'Your Details', 'citytours' ) ?></h3>
							<p><?php echo esc_html__( 'Please fill your detail.', 'citytours' ) ?></p>
						</div>
						<div class="step">
							<div class="row">
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
								  <label class="col-md-3 control-label required-star">
								  <span class="modulelabel" id="hotelslabel" style="display: none;">Hotel</span><span class="modulelabel" id="tourslabel" style="display: inline;"> Tour </span> <span class="modulelabel" id="carslabel" style="display: none;">Cab</span>
								  Operator Name</label>
								  <div class="col-md-8">
									<input class="form-control required" type="text" placeholder="Name" name="itemname" value="<?php echo esc_attr( $user_info['login'] ) ?>">
								  </div>
								</div>
							</div>							
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
								  <label class="col-md-3 control-label required-star">Full Name </label>
								  <div class="col-md-8">
									<input class="form-control required" type="text" placeholder="Full Name" name="fname" value="<?php echo esc_attr( $user_info['first_name'].' '.$user_info['last_name'] ) ?>">
								  </div>
								</div>
							</div>							
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
								  <label class="col-md-3 control-label required-star">Email </label>
								  <div class="col-md-8">
									<input class="form-control required email" type="email" placeholder="Email" name="email" value="<?php echo esc_attr( $user_info['email'] ) ?>">
								  </div>
								</div>
							</div>							
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
								  <label class="col-md-3 control-label required-star">Mobile</label>
								  <div class="col-md-8">
									<input class="form-control required" type="text" placeholder="Phone" name="mobile" value="<?php echo esc_attr( $user_info['phone'] ) ?>">
								  </div>
								</div>
							</div>					
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
								  <label class="col-md-3 control-label required-star">Country</label>								  
								  <div class="col-md-8"> 
									<select name="country" class="form-control required" id="country">
									  <option value=""> Select Country </option>
										<option value="AF">Afghanistan</option>
										<option value="AL">Albania</option>
										<option value="DZ">Algeria</option>
										<option value="AS">American Samoa</option>
										<option value="AU">Australia</option>
										<option value="BD">Bangladesh</option>
										<option value="BY">Belarus</option>
										<option value="BE">Belgium</option>
										<option value="BZ">Belize</option>
										<option value="BM">Bermuda</option>
										<option value="BT">Bhutan</option>
										<option value="BO">Bolivia</option>
										<option value="BA">Bosnia and Herzegovina</option>
										<option value="BW">Botswana</option>
										<option value="BV">Bouvet Island</option>
										<option value="BR">Brazil</option>
										<option value="IO">British Indian Ocean Territory</option>
										<option value="BN">Brunei</option>
										<option value="BG">Bulgaria</option>
										<option value="BF">Burkina Faso</option>
										<option value="BI">Burundi</option>
										<option value="KH">Cambodia</option>
										<option value="CM">Cameroon</option>
										<option value="CA">Canada</option>
										<option value="CV">Cape Verde</option>
										<option value="KY">Cayman Islands</option>
										<option value="CF">Central African Republic</option>
										<option value="TD">Chad</option>
										<option value="CL">Chile</option>
										<option value="CN">China</option>
										<option value="CX">Christmas Island</option>
										<option value="CC">Cocos (Keeling) Islands</option>
										<option value="CO">Colombia</option>
										<option value="KM">Comoros</option>
										<option value="CG">Congo</option>
										<option value="CR">Costa Rica</option>
										<option value="CI">Cote d'ivoire (Ivory Coast)</option>
										<option value="HR">Croatia</option>
										<option value="CU">Cuba</option>
										<option value="CW">Curacao</option>
										<option value="CY">Cyprus</option>
										<option value="CZ">Czech Republic</option>
										<option value="CD">Democratic Republic of the Congo</option>
										<option value="EG">Egypt</option>
										<option value="ET">Ethiopia</option>
										<option value="FK">Falkland Islands (Malvinas)</option>
										<option value="FO">Faroe Islands</option>
										<option value="FJ">Fiji</option>
										<option value="FI">Finland</option>
										<option value="FR">France</option>
										<option value="GF">French Guiana</option>
										<option value="PF">French Polynesia</option>
										<option value="TF">French Southern Territories</option>
										<option value="GA">Gabon</option>
										<option value="GM">Gambia</option>
										<option value="GE">Georgia</option>
										<option value="DE">Germany</option>
										<option value="GH">Ghana</option>
										<option value="GI">Gibraltar</option>
										<option value="GR">Greece</option>
										<option value="GL">Greenland</option>
										<option value="GD">Grenada</option>
										<option value="GP">Guadaloupe</option>
										<option value="GU">Guam</option>
										<option value="GT">Guatemala</option>
										<option value="GG">Guernsey</option>
										<option value="GN">Guinea</option>
										<option value="GW">Guinea-Bissau</option>
										<option value="GY">Guyana</option>
										<option value="HT">Haiti</option>
										<option value="HM">Heard Island and McDonald Islands</option>
										<option value="HN">Honduras</option>
										<option value="HK">Hong Kong</option>
										<option value="HU">Hungary</option>
										<option value="IS">Iceland</option>
										<option value="IN">India</option>
										<option value="ID">Indonesia</option>
										<option value="IR">Iran</option>
										<option value="IQ">Iraq</option>
										<option value="IE">Ireland</option>
										<option value="IM">Isle of Man</option>
										<option value="IL">Israel</option>
										<option value="IT">Italy</option>
										<option value="JM">Jamaica</option>
										<option value="JP">Japan</option>
										<option value="JE">Jersey</option>
										<option value="JO">Jordan</option>
										<option value="KZ">Kazakhstan</option>
										<option value="KE">Kenya</option>
										<option value="KI">Kiribati</option>
										<option value="XK">Kosovo</option>
										<option value="KW">Kuwait</option>
										<option value="KG">Kyrgyzstan</option>
										<option value="LA">Laos</option>
										<option value="LV">Latvia</option>
										<option value="LB">Lebanon</option>
										<option value="LS">Lesotho</option>
										<option value="LR">Liberia</option>
										<option value="LY">Libya</option>
										<option value="LI">Liechtenstein</option>
										<option value="LT">Lithuania</option>
										<option value="LU">Luxembourg</option>
										<option value="MO">Macao</option>
										<option value="MK">Macedonia</option>
										<option value="MG">Madagascar</option>
										<option value="MY">Malasia</option>
										<option value="MW">Malawi</option>
										<option value="MV">Maldives</option>
										<option value="ML">Mali</option>
										<option value="MT">Malta</option>
										<option value="MH">Marshall Islands</option>
										<option value="MQ">Martinique</option>
										<option value="MR">Mauritania</option>
										<option value="MU">Mauritius</option>
										<option value="YT">Mayotte</option>
										<option value="MX">Mexico</option>
										<option value="FM">Micronesia</option>
										<option value="MD">Moldava</option>
										<option value="MC">Monaco</option>
										<option value="MN">Mongolia</option>
										<option value="ME">Montenegro</option>
										<option value="MS">Montserrat</option>
										<option value="MA">Morocco</option>
										<option value="MZ">Mozambique</option>
										<option value="MM">Myanmar (Burma)</option>
										<option value="NA">Namibia</option>
										<option value="NR">Nauru</option>
										<option value="NP">Nepal</option>
										<option value="NL">Netherlands</option>
										<option value="NC">New Caledonia</option>
										<option value="NZ">New Zealand</option>
										<option value="NI">Nicaragua</option>
										<option value="NE">Niger</option>
										<option value="NG">Nigeria</option>
										<option value="NU">Niue</option>
										<option value="NF">Norfolk Island</option>
										<option value="KP">North Korea</option>
										<option value="MP">Northern Mariana Islands</option>
										<option value="NO">Norway</option>
										<option value="OM">Oman</option>
										<option value="PK">Pakistan</option>
										<option value="PW">Palau</option>
										<option value="PS">Palestine</option>
										<option value="PA">Panama</option>
										<option value="PG">Papua New Guinea</option>
										<option value="PY">Paraguay</option>
										<option value="PE">Peru</option>
										<option value="PH">Phillipines</option>
										<option value="PN">Pitcairn</option>
										<option value="PL">Poland</option>
										<option value="PT">Portugal</option>
										<option value="PR">Puerto Rico</option>
										<option value="QA">Qatar</option>
										<option value="RE">Reunion</option>
										<option value="RO">Romania</option>
										<option value="RU">Russia</option>
										<option value="RW">Rwanda</option>
										<option value="BL">Saint Barthelemy</option>
										<option value="SH">Saint Helena</option>
										<option value="KN">Saint Kitts and Nevis</option>
										<option value="LC">Saint Lucia</option>
										<option value="MF">Saint Martin</option>
										<option value="PM">Saint Pierre and Miquelon</option>
										<option value="VC">Saint Vincent and the Grenadines</option>
										<option value="WS">Samoa</option>
										<option value="SM">San Marino</option>
										<option value="ST">Sao Tome and Principe</option>
										<option value="SA">Saudi Arabia</option>
										<option value="SN">Senegal</option>
										<option value="RS">Serbia</option>
										<option value="SC">Seychelles</option>
										<option value="SL">Sierra Leone</option>
										<option value="SG">Singapore</option>
										<option value="SX">Sint Maarten</option>
										<option value="SK">Slovakia</option>
										<option value="SI">Slovenia</option>
										<option value="SB">Solomon Islands</option>
										<option value="SO">Somalia</option>
										<option value="ZA">South Africa</option>
										<option value="GS">South Georgia and the South Sandwich Islands</option>
										<option value="KR">South Korea</option>
										<option value="SS">South Sudan</option>
										<option value="ES">Spain</option>
										<option value="LK">Sri Lanka</option>
										<option value="SD">Sudan</option>
										<option value="SR">Suriname</option>
										<option value="SJ">Svalbard and Jan Mayen</option>
										<option value="SZ">Swaziland</option>
										<option value="SE">Sweden</option>
										<option value="CH">Switzerland</option>
										<option value="SY">Syria</option>
										<option value="TW">Taiwan</option>
										<option value="TJ">Tajikistan</option>
										<option value="TZ">Tanzania</option>
										<option value="TH">Thailand</option>
										<option value="TL">Timor-Leste (East Timor)</option>
										<option value="TG">Togo</option>
										<option value="TK">Tokelau</option>
										<option value="TO">Tonga</option>
										<option value="TT">Trinidad and Tobago</option>
										<option value="TN">Tunisia</option>
										<option value="TR">Turkey</option>
										<option value="TM">Turkmenistan</option>
										<option value="TC">Turks and Caicos Islands</option>
										<option value="TV">Tuvalu</option>
										<option value="UG">Uganda</option>
										<option value="UA">Ukraine</option>
										<option value="AE">United Arab Emirates</option>
										<option value="GB">United Kingdom</option>
										<option value="US">United States</option>
										<option value="UM">United States Minor Outlying Islands</option>
										<option value="UY">Uruguay</option>
										<option value="UZ">Uzbekistan</option>
										<option value="VU">Vanuatu</option>
										<option value="VA">Vatican City</option>
										<option value="VE">Venezuela</option>
										<option value="VN">Vietnam</option>
										<option value="VG">Virgin Islands, British</option>
										<option value="VI">Virgin Islands, US</option>
										<option value="YE">Yemen</option>
										<option value="ZM">Zambia</option>
										<option value="ZW">Zimbabwe</option>
									  </select>
								  </div>
								</div>
							</div>
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
								  <label class="col-md-3 control-label">Division</label>
								  <div class="col-md-8">
									<input class="form-control" type="text" placeholder="Division" name="state" value="<?php echo esc_attr( $user_info['state'] ) ?>">
								  </div>
								</div>
							</div>
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
								  <label class="col-md-3 control-label required-star">City</label>
								  <div class="col-md-8">
									<input class="form-control required" type="text" placeholder="City" name="city" value="<?php echo esc_attr( $user_info['city'] ) ?>">
								  </div>
								</div>
							</div>
							<div class="col-md-12 col-sm-12">
								<div class="form-group">
								  <label class="col-md-3 control-label required-star">Address</label>
								  <div class="col-md-8">
									<input class="form-control form required" type="text" placeholder="Address" name="address1" value="<?php echo esc_attr( $user_info['address1'] ) ?>">
								  </div>
								</div>
							</div>

							<div class="col-md-12 col-sm-12">
								<div class="form-group">
								  <label class="col-md-3 control-label">Address 2</label>
								  <div class="col-md-8">
									<input class="form-control form" type="text" placeholder="Address 2" name="address2" value="<?php echo esc_attr( $user_info['address2'] ) ?>">
								  </div>
								</div>
							</div>
							<div class="col-md-12 col-sm-12">
								<div id="policy">
									<input type="hidden" name="regInfo" value="pass">
									<input type="hidden" name="regFor" id="regFor" value="">
									<input type="hidden" name="partner_type" id="partner_type" value="">
									<button type="submit" class="btn_1 green medium" name="register"><i class="icon-paper-plane"></i> Register</button>
								</div>
							</div>
						</div><!--End step -->
					</div>
					</div>
				</div><!--End row -->
			</form>
				</div>
				<?php if ( 'right' == $sidebar_position ) : ?>
					<aside class="col-md-3 add_bottom_30"><?php generated_dynamic_sidebar(); ?></aside><!-- End aside -->
				<?php endif; ?>
			</div>
			
			<div class="row">
				<div class="col-sm-12 ">						
					<div>
						<div class="main_title">
							<h2>Some <b>good</b> reasons</h2>
						</div>
					</div>
					
					<div class="vc_row wpb_row vc_inner row">
						<div class="wow zoomIn wpb_column col-sm-12 col-md-4 animated" style="visibility: visible; animation-name: zoomIn;">
							<div class="vc_column-inner ">
								<div class="wpb_wrapper">
									<div class="ct-icon-box  feature_home">
										<i class="icon_set_1_icon-41"></i>
										<h3>Best price guaranteed</h3>
										<p>&nbsp;</p>
										<p><a class="btn_1 outline" href="#">Read more</a></p>
									</div>
								</div>
							</div>
						</div>
						
						<div class="wow zoomIn wpb_column col-sm-12 col-md-4 animated" style="visibility: visible; animation-name: zoomIn;">
							<div class="vc_column-inner ">
								<div class="wpb_wrapper">
									<div class="ct-icon-box  feature_home">
										<i class="icon_set_1_icon-30"></i>
										<h3>Visa assistance</h3>
										<p>&nbsp;</p>
										<p><a class="btn_1 outline" href="#">Read more</a></p>
									</div>
								</div>
							</div>
						</div>
						
						<div class="wow zoomIn wpb_column col-sm-12 col-md-4 animated" style="visibility: visible; animation-name: zoomIn;">
							<div class="vc_column-inner ">
								<div class="wpb_wrapper">
									<div class="ct-icon-box  feature_home">
										<i class="icon_set_1_icon-57"></i>
										<h3>Phone, Email &amp; Chat Support</h3>
										<p>&nbsp;</p>
										<p><a class="btn_1 outline" href="#">Read more</a></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div> 
			</div>
			
		</div><!-- end post -->
		<style type="text/css">
			.form-group{overflow:hidden;}
		</style>
		
<?php endwhile;
}
get_footer();
?>

<script type="text/javascript">
	  $(function(){			
		 $("#supplier-register").hide();
		$("#hotelslabel").hide();
		$("#tourslabel").hide();
		$("#carslabel").hide();
		$(".showform").on("click",function(){
			var module = $(this).prop('id');
			$('#regFor').val(module+'user');
			$('#partner_type').val(module);
			$("#applyfor").val(module);
			$(".modulelabel").hide();
			$("#"+module+"label").show();
			$("#supplier-register").slideDown();
		});
		
		var selectedVal = '<?php echo esc_attr( $user_info['country_code'] ) ?>';
		if(selectedVal !='')
		$("#country option[value="+selectedVal+"]").attr("selected","selected");
	
		$("#supplier-register").validate({
			errorPlacement: function() {
				return false;
			}
		});
	
	  });	  
</script>