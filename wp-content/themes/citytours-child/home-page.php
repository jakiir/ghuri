<?php
 /*
 Template Name: Home Page Custom
 */
get_header('home');
echo 'Jakir';
if ( have_posts() ) {
	while ( have_posts() ) : the_post();
		$post_id = get_the_ID();
		$content_class = 'post-content'; ?>	

		<div class="<?php echo esc_attr( $content_class ); ?>">
			<div class="post nopadding clearfix homePageBanner">
				<?php if ( has_post_thumbnail() ) {
				require_once('advance_search.php');				
				the_post_thumbnail( 'full', array('class' => 'img-responsive') );} ?>
				
				<div class="vc_row wpb_row vc_row-fluid margin_60 inner-container">
					<div class="container">
						<div class="row">
							<div class="col-sm-12 ">			
								<div>
									<div class="main_title">
										<h2>Ghuri <b>Top</b> Tours</h2>
									</div>
								</div>
								<div class="tour-list row add-clearfix">
								<?php 			
									global $wpdb;
									$posts_table = $wpdb->prefix."posts";		
									$post_status = "'publish'";
									$post_type = "('tour')";									
									$query = "SELECT DISTINCT wposts.ID FROM $wpdb->posts wposts
									LEFT JOIN $wpdb->postmeta wpm1 ON (wposts.ID = wpm1.post_id
									AND wpm1.meta_key = 'top')									
									WHERE 
									((wpm1.meta_value = '1'))
									AND wposts.post_type IN $post_type
									AND wposts.post_status = $post_status 
									GROUP BY wposts.ID
									ORDER BY wposts.post_date DESC LIMIT 0, 6";

									$my_posts=$wpdb->get_results($query);
									if ($my_posts) {
									  foreach($my_posts as $post) {
										setup_postdata($post);				
										$item_id = $post->ID;
										$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' ); 
										
										$person_price = get_post_meta( $item_id, '_tour_price', true );
										?>
								
									<div class="col-md-4 col-sm-6 wow zoomIn animated home_page_product" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: zoomIn;">	
										<div class="tour_container" style="overflow:hidden;position:relative;">
											<div class="img_container">
												<a href="<?php echo get_permalink( $item_id ); ?>">
												<img width="400" height="267" style="width:400px;height:267px;" src="<?php echo $url; ?>" class="attachment-ct-list-thumb size-ct-list-thumb wp-post-image" alt="banner">			<!-- <div class="ribbon top_rated"></div> -->
												<div class="short_info">
													<span class="price">BDT <span><sup></sup>&nbsp;<?php echo ct_price( $person_price, "special" ); ?></span></span>
												</div>
												</a>
											</div>
											<div class="tour_title">
												<h3><?php echo trunck_string(get_the_title( $item_id ),20,true); ?></h3>
												<div class="rating">
													<i class="icon-smile"></i>
													<i class="icon-smile"></i>
													<i class="icon-smile"></i>
													<i class="icon-smile"></i>
													<i class="icon-smile"></i>
													<small>(0)</small>
												</div><!-- end rating -->
												<div class="wishlist">
													<a class="tooltip_flip tooltip-effect-1 btn-add-wishlist" href="#" data-post-id="<?php echo $item_id; ?>"><span class="wishlist-sign">+</span><span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
													<a class="tooltip_flip tooltip-effect-1 btn-remove-wishlist" href="#" data-post-id="<?php echo $item_id; ?>" style="display:none;"><span class="wishlist-sign">-</span><span class="tooltip-content-flip"><span class="tooltip-back">Remove from wishlist</span></span></a>
												</div><!-- End wish list-->
											</div>											
											<!--<div class="hotel_ribbon ng-hide">						
												<p class="ribbon-green ng-binding">-15%</p>
											</div>-->									
										</div><!-- End box tour -->										
									</div><!-- End col-md-6 -->
								
									<?php
									wp_reset_postdata();
									}
								}
							?>	
								</div>							
								<div>
									<p class="text-center add_bottom_30"><a class="btn_1 medium" href="<?php echo home_url('/tour/'); ?>"><i class="icon-eye-7"></i>View all tours</a></p>
								</div> 
							</div>
							
							<div class="col-sm-12 ">			
								<div>
									<div class="main_title">
										<h2>Ghuri <b>Top</b> Hotels</h2>
									</div>
								</div>
								<div class="tour-list row add-clearfix">
								<?php 			
									global $wpdb;
									$posts_table = $wpdb->prefix."posts";		
									$post_status = "'publish'";
									$post_type = "('hotel')";
									$query = "SELECT DISTINCT wposts.ID FROM $wpdb->posts wposts
									LEFT JOIN $wpdb->postmeta wpm1 ON (wposts.ID = wpm1.post_id
									AND wpm1.meta_key = 'top')
									WHERE 
									((wpm1.meta_value = '1'))
									AND wposts.post_type IN $post_type
									AND wposts.post_status = $post_status 
									GROUP BY wposts.ID
									ORDER BY wposts.post_date DESC LIMIT 0, 6";
									
									$my_posts=$wpdb->get_results($query);
									if ($my_posts) {
									  foreach($my_posts as $post) {
										setup_postdata($post);				
										$item_id = $post->ID;
										$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' ); 
										$get_discount_price = '';
										
										$ct_hotel_vacancies = $wpdb->prefix."ct_hotel_vacancies";
																				
										$hotelVacancy = "select id, price_per_room, price_per_person,weekend_price_fri,weekend_price_sat,peakseason_price,room_type_id from $ct_hotel_vacancies where hotel_id = $item_id AND price_per_room = (select min(price_per_room) from $ct_hotel_vacancies WHERE hotel_id = $item_id)";
										$hotelVacancies=$wpdb->get_results($hotelVacancy);										
										if(!empty($hotelVacancies[0]->price_per_room)){											
											$get_discount_price = get_post_meta( $hotelVacancies[0]->room_type_id, '_room_discount_price',true );
											$price_per_room = $hotelVacancies[0]->price_per_room;
											$price_per_person = $hotelVacancies[0]->price_per_person;
											$realPrice = $price_per_room + $price_per_person;
											if(date('D') == 'Fri' && $hotelVacancies[0]->weekend_price_fri !== '0.00') $realPrice = $hotelVacancies[0]->weekend_price_fri;
											if(date('D') == 'Sat' && $hotelVacancies[0]->weekend_price_sat !== '0.00') $realPrice = $hotelVacancies[0]->weekend_price_sat;
											if(date('n') >= 4 && date('n') <= 10 && $hotelVacancies[0]->peakseason_price !== '0.00') $realPrice = $hotelVacancies[0]->peakseason_price;
											if(!empty($get_discount_price)){
												$discountPrice = 100-$get_discount_price;
												$discountedPrice = ($discountPrice*$realPrice)/100;
											} else {
												$discountedPrice = $realPrice;
											}
										} else {
											//$realPrice = $person_price;
										}
										?>
								
									<div class="col-md-4 col-sm-6 wow zoomIn animated home_page_product" data-wow-delay="0.1s" style="visibility: visible; animation-delay: 0.1s; animation-name: zoomIn;">	
										<div class="tour_container" style="overflow:hidden;position:relative;">
											<div class="img_container">
												<a href="<?php echo get_permalink( $item_id ); ?>">
												<img width="400" height="267" style="width:400px;height:267px;" src="<?php echo $url; ?>" class="attachment-ct-list-thumb size-ct-list-thumb wp-post-image" alt="banner">			<!-- <div class="ribbon top_rated"></div> -->
												<div class="short_info hotel">
													From/Per night
													<span class="price">BDT <span><sup></sup>&nbsp;<?php echo ct_price( $discountedPrice, "special" ); ?></span></span>
												</div>
												</a>
											</div>
											<div class="tour_title">
												<h3><?php echo trunck_string(get_the_title( $item_id ),20,true); ?></h3>
												<div class="rating">
													<i class="icon-smile"></i>
													<i class="icon-smile"></i>
													<i class="icon-smile"></i>
													<i class="icon-smile"></i>
													<i class="icon-smile"></i>
													<small>(0)</small>
												</div><!-- end rating -->
												<div class="wishlist">
													<a class="tooltip_flip tooltip-effect-1 btn-add-wishlist" href="#" data-post-id="<?php echo $item_id; ?>"><span class="wishlist-sign">+</span><span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
													<a class="tooltip_flip tooltip-effect-1 btn-remove-wishlist" href="#" data-post-id="<?php echo $item_id; ?>" style="display:none;"><span class="wishlist-sign">-</span><span class="tooltip-content-flip"><span class="tooltip-back">Remove from wishlist</span></span></a>
												</div><!-- End wish list-->
											</div>	
											<?php if($get_discount_price !='' && $get_discount_price !=0) { ?>
												<div class="hotel_ribbon ng-hide">						
													<p class="ribbon-green ng-binding">-<?php echo $get_discount_price; ?>%</p>
												</div>	
											<?php } ?>
										</div><!-- End box tour -->										
									</div><!-- End col-md-6 -->
								
									<?php
									wp_reset_postdata();
									}
								}
							?>	
								</div>							
								<div>
									<p class="text-center add_bottom_30"><a class="btn_1 medium" href="<?php echo home_url('/hotel/'); ?>"><i class="icon-eye-7"></i>View all hotels</a></p>
								</div> 
							</div>
							
						</div>
					</div>
				</div>
				
				<div class="vc_row wpb_row vc_row-fluid white_bg margin_60 inner-container">
					<div class="container">
						<div class="row">
							<div class="col-sm-12">			
								<div>
									<div class="main_title">
										<h2>Other <b>Popular</b> tours</h2>
									</div>
								</div>
								<div class="vc_row wpb_row vc_inner row add_bottom_45">
								
									<div class="wpb_column col-sm-12 col-md-4">
										<div class="vc_column-inner ">
											<div class="wpb_wrapper"><div class="other_tours">
												<ul>												
													<?php		
														global $wpdb;
														$posts_table = $wpdb->prefix."posts";		
														$post_status = "'publish'";
														$post_type = "('tour')";									
														$query = "SELECT DISTINCT wposts.ID FROM $wpdb->posts wposts
														LEFT JOIN $wpdb->postmeta wpm1 ON (wposts.ID = wpm1.post_id
														AND wpm1.meta_key = 'popular')									
														WHERE 
														((wpm1.meta_value = '1'))
														AND wposts.post_type IN $post_type
														AND wposts.post_status = $post_status 
														GROUP BY wposts.ID
														ORDER BY wposts.post_date DESC LIMIT 0, 6";
														$my_posts=$wpdb->get_results($query);
														if ($my_posts) {
														  foreach($my_posts as $post) {
															setup_postdata($post);				
															$item_id = $post->ID;
															$person_price = get_post_meta( $item_id, '_tour_price', true );
													?>
															<li>
																<a href="<?php echo get_permalink( $item_id ); ?>">
																	<i class=""></i><?php echo trunck_string(get_the_title( $item_id ),45,true); ?>
																	<span class="other_tours_price">&nbsp;<?php echo ct_price( $person_price, "special" ); ?> BDT</span>
																</a>
															</li>
														
															<?php
															wp_reset_postdata();
															}
														}
													?>
												</ul>
											</div>
											</div>
										</div>
									</div><!--end wpb_column col-sm-12 col-md-4 -->
									
									<div class="wpb_column col-sm-12 col-md-4">
										<div class="vc_column-inner ">
											<div class="wpb_wrapper"><div class="other_tours">
												<ul>
													<?php		
														global $wpdb;
														$posts_table = $wpdb->prefix."posts";		
														$post_status = "'publish'";
														$post_type = "('tour')";									
														$query = "SELECT DISTINCT wposts.ID FROM $wpdb->posts wposts
														LEFT JOIN $wpdb->postmeta wpm1 ON (wposts.ID = wpm1.post_id
														AND wpm1.meta_key = 'popular')									
														WHERE 
														((wpm1.meta_value = '1'))
														AND wposts.post_type IN $post_type
														AND wposts.post_status = $post_status 
														GROUP BY wposts.ID
														ORDER BY wposts.post_date DESC LIMIT 6, 6";
														$my_posts=$wpdb->get_results($query);
														if ($my_posts) {
														  foreach($my_posts as $post) {
															setup_postdata($post);				
															$item_id = $post->ID;
															$person_price = get_post_meta( $item_id, '_tour_price', true );
													?>
															<li>
																<a href="<?php echo get_permalink( $item_id ); ?>">
																	<i class=""></i><?php echo trunck_string(get_the_title( $item_id ),45,true); ?>
																	<span class="other_tours_price">&nbsp;<?php echo ct_price( $person_price, "special" ); ?> BDT</span>
																</a>
															</li>
														
															<?php
															wp_reset_postdata();
															}
														}
													?>
												</ul>
											</div>
											</div>
										</div>
									</div><!--end wpb_column col-sm-12 col-md-4 -->
									
									<div class="wpb_column col-sm-12 col-md-4">
										<div class="vc_column-inner ">
											<div class="wpb_wrapper"><div class="other_tours">
												<ul>
													<?php		
														global $wpdb;
														$posts_table = $wpdb->prefix."posts";		
														$post_status = "'publish'";
														$post_type = "('tour')";									
														$query = "SELECT DISTINCT wposts.ID FROM $wpdb->posts wposts
														LEFT JOIN $wpdb->postmeta wpm1 ON (wposts.ID = wpm1.post_id
														AND wpm1.meta_key = 'popular')									
														WHERE 
														((wpm1.meta_value = '1'))
														AND wposts.post_type IN $post_type
														AND wposts.post_status = $post_status 
														GROUP BY wposts.ID
														ORDER BY wposts.post_date DESC LIMIT 12, 6";
														$my_posts=$wpdb->get_results($query);
														if ($my_posts) {
														  foreach($my_posts as $post) {
															setup_postdata($post);				
															$item_id = $post->ID;
															$person_price = get_post_meta( $item_id, '_tour_price', true );
													?>
															<li>
																<a href="<?php echo get_permalink( $item_id ); ?>">
																	<i class=""></i><?php echo trunck_string(get_the_title( $item_id ),45,true); ?>
																	<span class="other_tours_price">&nbsp;<?php echo ct_price( $person_price, "special" ); ?> BDT</span>
																</a>
															</li>
														
															<?php
															wp_reset_postdata();
															}
														}
													?>
												</ul>
											</div>
											</div>
										</div>
									</div><!--end wpb_column col-sm-12 col-md-4 -->		
									
								</div>
							</div> 
						</div>
					</div>
				</div>
			</div><!-- end post -->
		</div>

<?php endwhile;
}
get_footer('home');
?>