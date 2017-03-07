<?php
/**
 * The Main Header.
 */
global $ct_options;
?>
<!DOCTYPE html>
<!--[if IE 7 ]>    <html class="ie7 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8 ]>    <html class="ie8 oldie" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE   ]>    <html class="ie" <?php language_attributes(); ?>> <![endif]-->
<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
<html <?php language_attributes(); ?>>
<head>
	<!-- Meta Tags -->
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php if ( ! function_exists( 'has_site_icon' ) || ! has_site_icon() ) { ?>
	<link rel="shortcut icon" href="<?php echo esc_url( ct_favicon_url() ); ?>" type="image/x-icon" />
	<?php } ?>

	<?php wp_head();?>
</head>
<body <?php body_class(); ?>>
<!--[if lte IE 8]>
	<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a>.</p>
<![endif]-->
<script type="text/javascript">
var admin_ajax = "<?php echo admin_url( 'admin-ajax.php' ); ?>";
</script>
	<?php if ( ! empty( $ct_options['preload'] ) ) : ?>
	<div id="preloader">
		<div class="sk-spinner sk-spinner-wave">
			<div class="sk-rect1"></div>
			<div class="sk-rect2"></div>
			<div class="sk-rect3"></div>
			<div class="sk-rect4"></div>
			<div class="sk-rect5"></div>
		</div>
	</div>
	<!-- End Preload -->
	<?php endif; ?>

	<div class="layer"></div>
	<!-- Mobile menu overlay mask -->

	<!-- Header Plain:  add the class plain to header and change logo.png to logo_sticky.png ======================= -->
	<?php $header_class = '';
	if ( ! empty ( $ct_options['header_style'] ) && ( $ct_options['header_style'] == 'plain' ) ) { $header_class = 'plain'; } ?>

	<header class="sticky <?php echo esc_attr( $header_class ); ?>" style="background:#333">
		<div id="top_line">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-sm-6 col-xs-6"><?php if ( ! empty( $ct_options['phone_no'] ) ) { ?><i class="icon-phone"></i><strong><?php echo esc_html( $ct_options['phone_no'] ) ?></strong><?php } ?></div>

					<div class="col-md-6 col-sm-6 col-xs-6">
						<ul id="top_links">
							<?php dynamic_sidebar('header_language'); ?>
							<?php if ( is_user_logged_in() ) { ?>							    
								<li><a href="<?php echo esc_url( wp_logout_url( ct_get_current_page_url() ) ); ?>"><?php esc_html_e(  'Log out', 'citytours' ) ?></a></li>
								<li><a href="<?php echo esc_url( home_url('/profile/') ) ?>"><?php esc_html_e(  'Profile', 'citytours' ) ?></a></li>
							<?php } else { ?>							
							<li>
								<?php if ( ct_login_url() == '#' ) { ?>
									<div class="dropdown dropdown-access">
										<a href="#" class="dropdown-toggle" data-toggle="dropdown" id="access_link"><?php esc_html_e(  'Log in', 'citytours' ) ?></a>
										<div class="dropdown-menu">
											<div class="text-center">
												<img src="<?php echo esc_url( ct_logo_sticky_url() ) ?>" width="<?php echo esc_attr( ct_get_header_logo_width() ) ?>" height="<?php echo esc_attr( ct_get_header_logo_height() ) ?>" alt="City tours" data-retina="true" class="logo_sticky">
												<div class="login-or"><hr class="hr-or"></div>
											</div>
											<form name="loginform" action="<?php echo esc_url( wp_login_url() )?>" method="post" class="loginform">
											<p class="status" style="color:#000;"></p>
												<div class="form-group">
													<input type="text" name="log" id="username" class="form-control" placeholder="<?php esc_html_e(  'user name', 'citytours' ); ?>">
												</div>
												<div class="form-group">
													<input type="password" name="pwd" class="form-control" id="password" placeholder="<?php esc_html_e(  'password', 'citytours' ); ?>">
												</div>
												<input type="hidden" name="redirect_to" value="<?php echo esc_url( ct_redirect_url() ) ?>">
												<a id="forgot_pw" href="javascript:void(0)"><?php esc_html_e(  'Forgot password?', 'citytours' ); ?></a>
												<input type="submit" value="<?php esc_html_e(  'Log in', 'citytours' ) ?>" class="button_drop">
												<?php if ( get_option('users_can_register') ) { ?>
												<a class="button_drop outline signup-btn" href="#"><?php esc_html_e(  'Sign up', 'citytours' ) ?></a>
												<?php } ?>
												<?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
											</form>
											
											<form id="forgot_password" class="ajax-auth" action="" method="post"> 
											<h1>Forgot Password</h1>
											<p class="status" style="color:#000;"></p>
												<div class="form-group">
													<input id="user_login" type="text" class="required form-control" name="user_login" placeholder="<?php esc_html_e(  'Username or E-mail', 'citytours' ); ?>">													
												</div>												
												<a id="login_popup" href="javascript:void(0)"><?php esc_html_e(  'Log in', 'citytours' ); ?></a>
												<input type="submit" value="<?php esc_html_e(  'Submit', 'citytours' ) ?>" class="button_drop">	
												<?php wp_nonce_field('ajax-forgot-nonce', 'forgotsecurity'); ?>
											</form>											
											
											<?php if ( get_option('users_can_register') ) { ?>
											<form name="registerform" action="<?php echo esc_url( wp_registration_url() )?>" method="post" class="signupform">
												<div class="form-group">
													<input type="text" name="user_login" class="form-control" placeholder="<?php esc_html_e(  'user name', 'citytours' ); ?>">
												</div>
												<div class="form-group">
													<input type="email" name="user_email" class="form-control" placeholder="<?php esc_html_e(  'email address', 'citytours' ); ?>">
												</div>
												<input type="hidden" name="redirect_to" value="<?php echo esc_url( add_query_arg( array('checkemail' => 'confirm'), wp_login_url() ) )?>">
												<input type="submit" value="<?php esc_html_e(  'Sign up', 'citytours' ) ?>" class="button_drop">
												<a class="button_drop outline login-btn" href="#"><?php esc_html_e(  'Log in', 'citytours' ) ?></a>
											</form>
											<?php } ?>
										</div>
									</div><!-- End Dropdown access -->

								<?php } else { ?>									
									<a href="<?php echo esc_url( ct_login_url() ) ?>"><?php esc_html_e(  'Log in', 'citytours' ) ?></a></li>
								<?php } ?>
							</li>							
							<li><a href="<?php echo esc_url( home_url('/register/') ) ?>"><?php esc_html_e(  'Register', 'citytours' ) ?></a></li>
							<?php } ?>
							<li class="dropdown">
							  <a href="#" class="dropbtn"><i class="icon-user-add"></i><?php esc_html_e(  'Business', 'citytours' ) ?></a>
							  <ul class="dropdown-content">
								<li><a href="<?php echo esc_url( home_url('/supplier-login/') ) ?>"><?php esc_html_e(  'Sign In', 'citytours' ) ?></a></li>
								<li><a href="<?php echo esc_url( home_url('/supplier-register/') ) ?>"><?php esc_html_e(  'Sign Up', 'citytours' ) ?></a></li>
							  </ul>
							</li>							
							<?php 
							$wishlist_link = ct_wishlist_page_url();
							$class = ( $wishlist_link == '#' ) ? 'ct-modal-login' : '';
							if ( ! empty( $wishlist_link ) ) : ?>
								<li><a href="<?php echo esc_url( $wishlist_link ); ?>" id="wishlist_link" class="<?php echo esc_attr( $class ) ?>"><?php esc_html_e(  'Wishlist', 'citytours' ) ?></a></li>
							<?php endif; ?>
						</ul>
					</div>
				</div><!-- End row -->
			</div><!-- End container-->
		</div><!-- End top line-->
		<?php require_once('special_deals.php'); ?>
	</header><!-- End Header -->