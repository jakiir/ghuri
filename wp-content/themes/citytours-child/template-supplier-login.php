<?php
 /*
 Template Name: Supplier Login Template
 */
get_header();
if ( have_posts() ) {	
	
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
				<div class="<?php echo esc_attr( $content_class ); ?>" style="margin:0 auto;width:33%;">
					<form name="loginform" id="loginFormCus" class="login-form loginform" action="<?php echo esc_url( wp_login_url() )?>" method="post">
							<p class="status" style="color:red;"></p>
								<?php if ( ! empty( $_GET['login'] ) && ( $_GET['login'] == 'failed' ) ) { ?>
									<div class="alert alert-info"><span class="message"><?php esc_html_e(  'Invalid username or password','citytours' ); ?></span></div>
								<?php } ?>								
								<div class="form-group">
									<?php if ( isset( $_GET['checkemail'] ) ) {
										esc_html_e( 'Check your e-mail for the confirmation link.', 'citytours' );
									} else {
										esc_html_e( 'Please login to your account.', 'citytours' );
									} ?>
								</div>
								<div class="form-group">
									<label class="required-star"><?php esc_html_e(  'Username', 'citytours' ); ?></label>
									<input type="text" name="log" id="username" class="form-control required" placeholder="<?php esc_html_e(  'Username', 'citytours' ); ?>" value="<?php echo empty($_GET['user']) ? '' : esc_attr( $_GET['user'] ) ?>">
								</div>
								<div class="form-group">
									<label class="required-star"><?php esc_html_e(  'Password', 'citytours' ); ?></label>
									<input type="password" name="pwd" id="password" class="form-control required" placeholder="<?php esc_html_e(  'Password', 'citytours' ); ?>">
								</div>
								<div class="form-group">
									<input type="checkbox" name="rememberme" tabindex="3" value="forever" id="rememberme" class="pull-left"> <label for="rememberme" class="pl-8"><?php esc_html_e(  'Remember my details', 'citytours' ); ?></label>
									<div class="small pull-right"><a href="<?php echo esc_url( add_query_arg( 'action', 'lostpassword', $login_url ) ); ?>"><?php esc_html_e(  'Forgot password?', 'citytours' ); ?></a></div>
								</div>
								<button type="submit" class="btn_full"><?php esc_html_e( 'Sign in', 'citytours')?></button>
								<input type="hidden" name="redirect_to" value="<?php echo esc_url( ct_start_page_url() ) ?>">
								<?php if ( get_option('users_can_register') ) { ?>
									<br><?php esc_html_e(  "Don't have an account?", 'citytours' ) ?> 
									<a href="<?php echo esc_url( $signup_url ); ?>" class=""><?php esc_html_e(  "Register", 'citytours' ) ?></a>
								<?php } ?>
								<?php wp_nonce_field( 'ajax-login-nonce', 'security' ); ?>
							</form>
				</div>
				<?php if ( 'right' == $sidebar_position ) : ?>
					<aside class="col-md-3 add_bottom_30"><?php generated_dynamic_sidebar(); ?></aside><!-- End aside -->
				<?php endif; ?>
			</div>
		</div><!-- end post -->
<?php endwhile;
}
get_footer();
?>
<script>
	$ = jQuery.noConflict();
	var ajaxurl = '<?php echo esc_js( admin_url( 'admin-ajax.php' ) ) ?>';
	$(function() {
		$("#loginFormCus").validate({
			errorPlacement: function() {
				return false;
			}
		});
	});
	
</script>