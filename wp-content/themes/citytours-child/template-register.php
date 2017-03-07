<?php
 /*
 Template Name: Sign-up Page Template
 */
get_header();
if ( have_posts() ) {	
global $wpdb;
if ( 'POST' == $_SERVER['REQUEST_METHOD'] && isset($_POST['register']) && $_POST['regInfo'] == "pass")
    {
		$userID					= '';
		$firstname				= $_POST['first_name'];
        $lastname				= $_POST['last_name'];
		$fullName				= $firstname.' '.$lastname;        
		$uploadImage			= $_FILES['profileImage']['name'];
		$email					= $_POST['email'];
		$phone					= $_POST['phone'];
		$username				= $_POST['username'];
		$password				= $_POST['password'];		
		$country_code			= $_POST['country_code'];
		$address1				= $_POST['address1'];
		$address2				= $_POST['address2'];
		$city					= $_POST['city'];
		$state					= $_POST['state'];
		$zip					= $_POST['zip'];
		$gender					= $_POST['gender'];
		$birth_date				= $_POST['birth_date'];	
		
		if ( !is_user_logged_in() ) {
				$ola_user = username_exists( $username );
				$newUserEmail = email_exists( $email );
				
				if(!$newUserEmail){        
					if ( !$ola_user ) {
						$userData = array(
							'user_login' => $username,
							'first_name' => $firstname,
							'last_name' => $lastname,
							'display_name' => $fullName,
							'user_pass' => $password,
							'user_email' => $email,
							'user_url' => '',
							'role' => 'subscriber'
						);			
						$createUser = wp_insert_user( $userData );			
										
							if($createUser){					
								if($uploadImage) {
									$uploads = wp_upload_dir();
									$usersContent = $uploads['basedir'].DIRECTORY_SEPARATOR."users-content".DIRECTORY_SEPARATOR.$createUser;
									wp_mkdir_p($usersContent);
									@move_uploaded_file($_FILES['profileImage']['tmp_name'],$usersContent.DIRECTORY_SEPARATOR.$_FILES['profileImage']['name']);
									$imageUrl = $uploads['baseurl'].'/'."users-content".'/'.$createUser.$uploadImage;
								}

								add_user_meta( $createUser, 'photo_url', $imageUrl, true );                
								add_user_meta( $createUser, 'phone', $phone, true );
								add_user_meta( $createUser, 'country_code', $country_code, true );
								add_user_meta( $createUser, 'address1', $address1, true );
								add_user_meta( $createUser, 'address2', $address2, true );
								add_user_meta( $createUser, 'city', $city, true );
								add_user_meta( $createUser, 'state', $state, true );
								add_user_meta( $createUser, 'zip', $zip, true );
								add_user_meta( $createUser, 'gender', $gender, true );
								add_user_meta( $createUser, 'birth_date', $birth_date, true );
								
								
								if(!is_user_logged_in()) :
									$creds = array();
									$creds['user_login'] = $username;
									$creds['user_password'] = $password;                
									$creds['remember'] = true;
									$user = wp_signon( $creds, false );
								endif;
												
								$userInfo = $wpdb->insert_id;
								
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
			$new_password = $_POST['password'];
				if($new_password == ''){				
					$updateData = array(
					'ID' => $user_id,						
					'user_email' => $email,
					'display_name' => $fullName,
					'first_name' => $firstname,
					'last_name' => $lastname
					);					
				}
				if($new_password != ''){
					$updateData = array(
					'ID' => $user_id,					
					'user_pass' => $new_password,
					'user_email' => $email,
					'display_name' => $fullName,
					'first_name' => $firstname,
					'last_name' => $lastname
					);	
				}				
				$updateUser = wp_update_user( $updateData );
						
				if($updateUser){					
					if($uploadImage) {
						$uploads = wp_upload_dir();
						$usersContent = $uploads['basedir'].DIRECTORY_SEPARATOR."users-content".DIRECTORY_SEPARATOR.$user_id;
						array_map('unlink', glob("$usersContent/*.*"));
						wp_mkdir_p($usersContent);
						@move_uploaded_file($_FILES['profileImage']['tmp_name'],$usersContent.DIRECTORY_SEPARATOR.$_FILES['profileImage']['name']);
						$imageUrl = $uploads['baseurl'].'/'."users-content".'/'.$user_id.'/'.$uploadImage;
						update_user_meta( $user_id, 'photo_url', $imageUrl );
					}					                
					update_user_meta( $user_id, 'phone', $phone );
					update_user_meta( $user_id, 'country_code', $country_code );
					update_user_meta( $user_id, 'address1', $address1 );
					update_user_meta( $user_id, 'address2', $address2 );
					update_user_meta( $user_id, 'city', $city );
					update_user_meta( $user_id, 'state', $state );
					update_user_meta( $user_id, 'zip', $zip );
					update_user_meta( $user_id, 'gender', $gender );
					update_user_meta( $user_id, 'birth_date', $birth_date );								
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

				<!--<section class="parallax-window" data-parallax="scroll" data-image-src="<?php //echo esc_url( $header_img_scr ) ?>" data-natural-width="1400" data-natural-height="<?php //echo esc_attr( $header_img_height ) ?>">
				<?php //require_once('advance_search.php'); ?>
					<div class="parallax-content-1">
						<div class="animated fadeInDown">
						<h1 class="page-title"><?php //the_title(); ?></h1>
						<?php //echo balancetags( $header_content ); ?>
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
				<div class="<?php echo esc_attr( $content_class ); ?>">
					<form id="register-form" action="#" method="post" enctype="multipart/form-data">
			<div class="row">
				<div class="col-md-12">					
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
								<input type="email" name="email2" class="form-control" value="<?php echo esc_attr( $user_info['email'] ) ?>">
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
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__( 'Username', 'citytours' ) ?></label>
								<input type="text" name="username" <?php if ( is_user_logged_in() ) { echo 'readonly'; } ?> class="form-control" value="<?php echo esc_attr( $user_info['login'] ) ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__( 'Password', 'citytours' ) ?></label>
								<input type="password" name="password" class="form-control" value="<?php echo esc_attr( $user_info['password'] ) ?>">
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__( 'Re-password', 'citytours' ) ?></label>
								<input type="password" name="re_password" class="form-control" value="<?php echo esc_attr( $user_info['re_password'] ) ?>">
							</div>
						</div>
					</div>
					 <div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__( 'Gender', 'citytours' ) ?></label>
									<?php
										$genderList = array(
											"Male"		=> "Male",
											"Female"	=> "Female",
											"Other"		=> "Other"
										);
									?>
								  <select name="gender" id="gender" class="form-control">
									<?php 
										foreach( $genderList as $gKey => $gValue ) {
											$gSelected = ( $gKey == esc_attr( $user_info['gender'] ) ? 'selected="selected"' : null );
											echo "<option $gSelected value='$gKey'>$gValue</option>";
										}
									?>
								  </select>								
							</div>
						</div>
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__( 'Birth date', 'citytours' ) ?></label>
								<input type="text" name="birth_date" class="form-control" value="<?php echo esc_attr( $user_info['birth_date'] ) ?>">
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
								<select class="form-control" name="country_code" id="country_code">
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
				<div class="form_title">
					<h3><strong>3</strong><?php echo esc_html__( 'Your Attachment', 'citytours' ) ?></h3>
					<p><?php echo esc_html__( 'Please attach you document', 'citytours' ) ?></p>
				</div>
				<div class="step">
					<div class="row">
						<div class="col-md-6 col-sm-6">
							<div class="form-group">
								<label><?php echo esc_html__( 'Profile Image', 'citytours' ) ?></label>	
								<input type="file" class="form-control" id="profileImage" onchange="instantPhotoUpload(this)" name="profileImage">
							</div>
						</div>
						<div class="col-md-6 col-sm-6" id="hsc_std_photo">
							<div class="form-group">
								<?php $profileImage = ($user_info['photo_url'] ? $user_info['photo_url'] : get_stylesheet_directory_uri().'/img/noimage.png');?>
								<img style="height: 160px;" class="img-thumbnail img-responsive" align="absmiddle" id="preview_image" src="<?php echo $profileImage; ?>"/>
							</div>
						</div>
					</div>		
				</div><!--End step -->
				
					<div id="policy">
						<input type="hidden" name="regInfo" value="pass"/>
						<?php $buttonName = ( is_user_logged_in() ? 'Update' : 'Register' ); ?>
						<button type="submit" class="btn_1 green medium" name="register"><i class="icon-paper-plane"></i> <?php echo esc_html__( $buttonName, 'citytours' ) ?></button>
					</div>				
				</div>
			</div><!--End row -->
		</form>
				</div>
				<?php if ( 'right' == $sidebar_position ) : ?>
					<aside class="col-md-3 add_bottom_30"><?php generated_dynamic_sidebar(); ?></aside><!-- End aside -->
				<?php endif; ?>
			</div>
		</div><!-- end post -->

		<script>
			$ = jQuery.noConflict();
			var ajaxurl = '<?php echo esc_js( admin_url( 'admin-ajax.php' ) ) ?>';

			$(document).ready(function(){
				<?php if ( is_user_logged_in() ) { ?>
				var validation_rules = {
						first_name: { required: true},
						last_name: { required: true},
						email: { required: true, email: true},
						email2: { required: true, equalTo: 'input[name="email"]'},
						phone: { required: true},
						address1: { required: true},
						city: { required: true},
						zip: { required: true},
						username: { required: true},						
						re_password: {equalTo: 'input[name="password"]'},
						gender: { required: true},
						birth_date: { required: true},
					};
				<?php } else { ?>
					var validation_rules = {
						first_name: { required: true},
						last_name: { required: true},
						email: { required: true, email: true},
						email2: { required: true, equalTo: 'input[name="email"]'},
						phone: { required: true},
						address1: { required: true},
						city: { required: true},
						zip: { required: true},
						username: { required: true},
						password: { required: true},
						re_password: { required: true, equalTo: 'input[name="password"]'},
						gender: { required: true},
						birth_date: { required: true},
						profileImage: { required: true},
					};
				<?php } ?>
				//validation form
				$('#register-form').validate({
					rules: validation_rules,
					/*submitHandler: function (form) {						
						var register_data = $('#register-form').serialize();	
						
						$('#overlay').fadeIn();
						$.ajax({
							type: "POST",
							url: ajaxurl,
							data: register_data,
							success: function ( response ) {
								console.log(response);
								if ( response.success == 1 ) {
									
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
					}*/
				});
			});
			var styleSheetUrl = '<?php echo get_stylesheet_directory_uri(); ?>';
			var abc = 0; 
			function instantPhotoUpload(THIS){
				if (THIS.files && THIS.files[0]) {
					$('#profilePicRemover').remove();
					 abc += 1; //increementing global variable by 1		
					var z = abc - 1;
					var reader = new FileReader();
					reader.onload = imageIsLoaded;
					reader.readAsDataURL(THIS.files[0]);
					$("#hsc_std_photo").append($("<img/>", {id: 'profilePicRemover', src: styleSheetUrl+'/img/remove.png', alt: 'delete'}).click(function() {
						$('#preview_image').attr('src', styleSheetUrl+'/img/noimage.png');
						$('#profilePicRemover').remove();
					}));
				}
			}
			function imageIsLoaded(e) {
				$('#preview_image').attr('src', e.target.result);
			}
		</script>
		
		<style type="text/css">
			.main-menu > div > ul > li > a{color:#000;}
		</style>
		
<?php endwhile;
}
get_footer();