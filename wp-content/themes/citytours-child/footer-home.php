<?php 
/**
* Footer
 */
global $ct_options;

if (current_user_can('manage_options') && is_admin()) { ?>
	 <style>.logged-in header {top: 32px !important; }</style>
<?php } ?>
<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-3">
                <?php if ( is_active_sidebar( 'sidebar-footer-1' ) ) : ?>
                    <?php dynamic_sidebar( 'sidebar-footer-1' );?>
                <?php endif; ?>
            </div>
            <div class="col-md-3 col-sm-3">
                <?php if ( is_active_sidebar( 'sidebar-footer-2' ) ) : ?>
                    <?php dynamic_sidebar( 'sidebar-footer-2' );?>
                <?php endif; ?>
            </div>
            <div class="col-md-3 col-sm-3">
                <?php if ( is_active_sidebar( 'sidebar-footer-3' ) ) : ?>
                    <?php dynamic_sidebar( 'sidebar-footer-3' );?>
                <?php endif; ?>
            </div>
            <div class="col-md-2 col-sm-3">
                <?php if ( is_active_sidebar( 'sidebar-footer-4' ) ) : ?>
                    <?php dynamic_sidebar( 'sidebar-footer-4' );?>
                <?php endif; ?>
            </div>
        </div><!-- End row -->
        <div class="row">
            <div class="col-md-12">
                <div id="social_footer">
                    <ul>
                        <?php $social_links = array( 'facebook', 'twitter', 'google', 'instagram', 'pinterest', 'vimeo', 'youtube-play', 'linkedin', 'ghuri-app' ); ?>
                        <?php foreach( $social_links as $social_link ) : ?>
                            <?php if ( ! empty( $ct_options[ $social_link ] ) ) : ?>
                                <li><a target="_blanck" class="href-<?php echo esc_attr( $social_link ) ?>" href="<?php echo esc_url( $ct_options[ $social_link ] ) ?>"><i class="icon-<?php echo esc_attr( $social_link ) ?>"></i></a></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                    <?php if ( ! empty( $ct_options['copyright'] ) ) { ?>
                    <p>&copy; <?php echo esc_html( $ct_options['copyright'] ); ?></p>
                    <?php } ?>
                </div>
            </div>
        </div><!-- End row -->
    </div><!-- End container -->
</footer><!-- End footer -->


<!-- Modal -->
<div class="modal fade" id="request_callback" tabindex="-1" role="dialog" aria-labelledby="request_callback_label">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<form id="sendNameMobile" onSubmit="return sendNameMobile(this);">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="request_callback_label">Request Callback</h4>
		  </div>
		  <div class="modal-body">
					<div class="alert messageShow" style="display:none;"></div>
				  <div class="form-group">
					<!--<label for="full_name">Name:</label>-->			
					<input type="text" class="form-control" placeholder="Type your name" id="full_name">
				  </div>
				  <div class="form-group">
					<!--<label for="phone_no">Phone:</label>-->			
					<input type="tel" class="form-control" placeholder="Type your phone" id="phone_no">
				  </div>
				  <div class="form-group">
					<!--<label for="phone_no">Inquiry:</label>-->			
					<textarea class="form-control" rows="3" name="inquiry" placeholder="Type your inquiry" id="inquiry"></textarea>
				  </div>		  
				  <?php wp_nonce_field( 'phone-send-nonce', 'security' ); ?>
		  </div>
		  <div class="modal-footer">			
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="submit" class="btn btn-56- requestCalBtn" style="background:#e14d67;color:#fff;">
				<img class="" width="20" height="auto" src="<?php echo $telephone; ?>">
				<i class="icon-spin3 pending" style="display:none"></i> Request Callback
			</button>
		  </div>
		</form>
    </div>
  </div>
</div>


<div id="toTop"></div><!-- Back to top button -->
<div id="overlay"><i class="icon-spin3 animate-spin"></i></div>
<link rel="stylesheet" href="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/css/jquery-ui.css">
<script src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/js/jquery-ui.js"></script>
<script src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/js/custom_js.js"></script>	
<?php wp_footer(); ?>
</body>
</html>