<?php
 /*
 Template Name: Services
 */
get_header();
if ( have_posts() ) {
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
				<?php require_once('advance_search.php'); ?>
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
				<div class="<?php echo esc_attr( $content_class ); ?>">
					<div class="post-content">
						<div class="vc_row wpb_row row">
							<div class="col-sm-12 ">									
								<div>
									<div class="main_title">
										<h2>All <b>the</b> services we are offering</h2>
										<p>services</p>
									</div>
								</div> 
							</div> 
						</div>

						<div class="vc_row wpb_row row">
							<div class="col-sm-12 ">
								<div class="vc_separator wpb_content_element vc_separator_align_center vc_sep_width_100 vc_sep_pos_align_center vc_separator_no_text vc_sep_color_grey">
									<span class="vc_sep_holder vc_sep_holder_l"><span class="vc_sep_line"></span></span>
									<span class="vc_sep_holder vc_sep_holder_r"><span class="vc_sep_line"></span></span>
								</div>
							</div> 
						</div>
						
						<div class="vc_row wpb_row row add_bottom_60" style="margin-top:10px;">
								<?php 
									global $wpdb;										
									$post_status = "'publish'";
									$post_type = "('ghuri-services')";									
									$query = "SELECT DISTINCT wposts.ID FROM $wpdb->posts wposts									
									WHERE 
									wposts.post_type IN $post_type
									AND wposts.post_status = $post_status 
									GROUP BY wposts.ID
									ORDER BY wposts.post_date DESC LIMIT 0, 6";
									$services_posts=$wpdb->get_results($query);
									if ($services_posts) {
									  foreach($services_posts as $post) {
										setup_postdata($post);				
										$item_id = $post->ID;
										$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' ); 
										
										$person_price = get_post_meta( $item_id, '_tour_price', true );
										?>
								
									<div class="col-md-4 col-sm-6" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: zoomIn;">	
										<div class="tour_container" style="overflow:hidden;position:relative;">
											<div class="img_container">
												<a href="<?php echo get_permalink( $item_id ); ?>">
												<img width="400" height="267" style="width:400px;height:267px;" src="<?php echo $url; ?>" class="attachment-ct-list-thumb size-ct-list-thumb wp-post-image" alt="banner">			<!-- <div class="ribbon top_rated"></div> -->
												<div class="short_info">
													<span class="price"><?php echo get_the_title( $item_id ); ?></span>
												</div>
												</a>
											</div>					
										</div><!-- End box tour -->										
									</div><!-- End col-md-6 -->
								
									<?php
									wp_reset_postdata();
									}
								}
							?>	
						</div>										
				</div>
				</div>
				<?php if ( 'right' == $sidebar_position ) : ?>
					<aside class="col-md-3 add_bottom_30"><?php generated_dynamic_sidebar(); ?></aside><!-- End aside -->
				<?php endif; ?>
			</div>
		</div><!-- end post -->

<?php endwhile;
}
get_footer();