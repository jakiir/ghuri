<?php
 /*
 Template Name: Home Page Custom
 */
get_header();

$ip = $_SERVER['REMOTE_ADDR'];
$details = json_decode(file_get_contents("http://ipinfo.io/{$ip}"));
/*&& $details->country !== 'BD'*/
if ( have_posts() ) {
	while ( have_posts() ) : the_post();
		$post_id = get_the_ID();
		$content_class = 'post-content';
		$slider_active = get_post_meta( $post_id, '_rev_slider', true );
		$slider        = ( $slider_active == '' ) ? 'Deactivated' : $slider_active;
		if ( class_exists( 'RevSlider' ) && $slider != 'Deactivated' && $_REQUEST['skip_video'] !== 'yes' && $_COOKIE["ontime_show_video"] != 'yes' && $details->country !== 'BD') {
			 setcookie("ontime_show_video", 'yes');
			echo '<div id="slideshow">';
			putRevSlider( $slider );
			//require_once('advance_search.php');
			//require_once('special_deals.php');
			echo '</div>';
		} else {
			$header_img_scr = ct_get_header_image_src( $post_id );
			if ( ! empty( $header_img_scr ) ) {
				$header_img_height = ct_get_header_image_height( $post_id );
				$header_content = get_post_meta( $post_id, '_header_content', true );
				
				?>
				
				

				<?php /*?><section class="parallax-window-" data-parallax="scroll-" data-image-src="<?php echo esc_url( $header_img_scr ) ?>" data-natural-width="1400" data-natural-height="<?php echo esc_attr( $header_img_height ) ?>">
					<div class="parallax-content-1">
						<div class="animated fadeInDown">						
						<h1 class="page-title"><?php //the_title(); ?></h1>
						<?php 
							require_once('advance_search.php');						
							require_once('special_deals.php'); 
							//echo balancetags( $header_content ); 
						?>
						</div>
					</div>
				</section><!-- End section --><?php */ ?>
				
				<?php /* ?><div id="slider1_container" style="visibility: hidden; position: relative; margin: 0 auto;
        top: 0px; left: 0px; width: 1300px; height: 500px; overflow: hidden;">
            <!-- Loading Screen -->
            <div u="loading" style="position: absolute; top: 0px; left: 0px;">
                <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block;
                top: 0px; left: 0px; width: 100%; height: 100%;">
                </div>
                <div style="position: absolute; display: block; background: url(<?php echo get_stylesheet_directory_uri(); ?>/img/loading.gif) no-repeat center center;
                top: 0px; left: 0px; width: 100%; height: 100%;">
                </div>
            </div>
            <!-- Slides Container -->
            <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 1300px; height: 500px; overflow: hidden;">
			<?php
				global $wpdb;
				$posts_table = $wpdb->prefix."posts";
				$postmeta_table = $wpdb->prefix."postmeta";
				$post_status = "'publish'";
				$post_type = "('hotel','tour','room_type')";
				$query = "SELECT wposts.* FROM $posts_table wposts
				LEFT JOIN $postmeta_table wpm1 ON (wposts.ID = wpm1.post_id
				AND wpm1.meta_key = 'is_slide')	
				WHERE ((wpm1.meta_value = '1'))
				AND wposts.post_type IN $post_type
				AND wposts.post_status = $post_status
				GROUP BY wposts.ID
				ORDER BY wposts.post_date DESC LIMIT 0, 10";

				$my_posts=$wpdb->get_results($query);
				if ($my_posts) {
				  foreach($my_posts as $post) {
					setup_postdata($post);				
					$item_id = $post->ID;
					$url = wp_get_attachment_url( get_post_thumbnail_id($post->ID), 'thumbnail' ); ?>
					<div>
						<img u="image" src2="<?php echo $url; ?>" />
						<div class="slider_content" style="">
							<p><?php echo $post->post_title; ?></p>
							<a href="<?php echo get_permalink($item_id); ?>" class="btn btn-56 bookNowBtn" style="">Book Now</a>
						</div>
						
					</div>
				<?php
				wp_reset_postdata();
				}
			}
		?>
            </div>            
            <style>
                .jssorb21 {
                    position: absolute;
                }
                .jssorb21 div, .jssorb21 div:hover, .jssorb21 .av {
                    position: absolute;                    
                    width: 19px;
                    height: 19px;
                    text-align: center;
                    line-height: 19px;
                    color: white;
                    font-size: 12px;
                    background: url(<?php echo get_stylesheet_directory_uri(); ?>/img/b21.png) no-repeat;
                    overflow: hidden;
                    cursor: pointer;
                }
                .jssorb21 div { background-position: -5px -5px; }
                .jssorb21 div:hover, .jssorb21 .av:hover { background-position: -35px -5px; }
                .jssorb21 .av { background-position: -65px -5px; }
                .jssorb21 .dn, .jssorb21 .dn:hover { background-position: -95px -5px; }
				.jssora21l, .jssora21r {
                    display: block;
                    position: absolute;                    
                    width: 55px;
                    height: 55px;
                    cursor: pointer;
                    background: url(<?php echo get_stylesheet_directory_uri(); ?>/img/a21.png) center center no-repeat;
                    overflow: hidden;
                }
                .jssora21l { background-position: -3px -33px; }
                .jssora21r { background-position: -63px -33px; }
                .jssora21l:hover { background-position: -123px -33px; }
                .jssora21r:hover { background-position: -183px -33px; }
                .jssora21l.jssora21ldn { background-position: -243px -33px; }
                .jssora21r.jssora21rdn { background-position: -303px -33px; }
            </style>
            <!-- bullet navigator container -->
            <div u="navigator" class="jssorb21" style="bottom: 26px; right: 6px;">
                <!-- bullet navigator item prototype -->
                <div u="prototype"></div>
            </div>
            <!--#endregion Bullet Navigator Skin End -->
            <!-- Arrow Left -->
            <span u="arrowleft" class="jssora21l" style="top: 123px; left: 8px;">
            </span>
            <!-- Arrow Right -->
            <span u="arrowright" class="jssora21r" style="top: 123px; right: 8px;">
            </span>            
        </div>*/?>
				
			<?php } 

				//require_once('advance_search.php');
				//require_once('special_deals.php');

			?>

			<?php if ( ! is_front_page() ) : ?>
				<div id="position" <?php if ( empty( $header_img_scr ) ) echo 'class="blank-parallax"' ?>>
					<div class="container"><?php ct_breadcrumbs(); ?></div>
				</div><!-- End Position -->
			<?php endif; ?>
			
			<!--<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jssor.slider.mini.js"></script>-->
		
		<script>
        /*jQuery(document).ready(function ($) {

            var options = {
                $FillMode: 2,                                       //[Optional] The way to fill image in slide, 0 stretch, 1 contain (keep aspect ratio and put all inside slide), 2 cover (keep aspect ratio and cover whole slide), 4 actual size, 5 contain for large image, actual size for small image, default value is 0
                $AutoPlay: true,                                    //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
                $Idle: 2500,                            //[Optional] Interval (in milliseconds) to go for next slide since the previous stopped if the slider is auto playing, default value is 3000
                $PauseOnHover: 1,                                   //[Optional] Whether to pause when mouse over if a slider is auto playing, 0 no pause, 1 pause for desktop, 2 pause for touch device, 3 pause for desktop and touch device, 4 freeze for desktop, 8 freeze for touch device, 12 freeze for desktop and touch device, default value is 1

                $ArrowKeyNavigation: true,   			            //[Optional] Allows keyboard (arrow key) navigation or not, default value is false
                $SlideEasing: $JssorEasing$.$EaseOutQuint,          //[Optional] Specifies easing for right to left animation, default value is $JssorEasing$.$EaseOutQuad
                $SlideDuration: 600,                               //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500
                $MinDragOffsetToSlide: 20,                          //[Optional] Minimum drag offset to trigger slide , default value is 20
                //$SlideWidth: 600,                                 //[Optional] Width of every slide in pixels, default value is width of 'slides' container
                //$SlideHeight: 300,                                //[Optional] Height of every slide in pixels, default value is height of 'slides' container
                $SlideSpacing: 0, 					                //[Optional] Space between each slide in pixels, default value is 0
                $Cols: 1,                                  //[Optional] Number of pieces to display (the slideshow would be disabled if the value is set to greater than 1), the default value is 1
                $ParkingPosition: 0,                                //[Optional] The offset position to park slide (this options applys only when slideshow disabled), default value is 0.
                $UISearchMode: 1,                                   //[Optional] The way (0 parellel, 1 recursive, default value is 1) to search UI components (slides container, loading screen, navigator container, arrow navigator container, thumbnail navigator container etc).
                $PlayOrientation: 1,                                //[Optional] Orientation to play slide (for auto play, navigation), 1 horizental, 2 vertical, 5 horizental reverse, 6 vertical reverse, default value is 1
                $DragOrientation: 1,                                //[Optional] Orientation to drag slide, 0 no drag, 1 horizental, 2 vertical, 3 either, default value is 1 (Note that the $DragOrientation should be the same as $PlayOrientation when $Cols is greater than 1, or parking position is not 0)
              
                $BulletNavigatorOptions: {                          //[Optional] Options to specify and enable navigator or not
                    $Class: $JssorBulletNavigator$,                 //[Required] Class to create navigator instance
                    $ChanceToShow: 2,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 1,                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
                    $Rows: 1,                                      //[Optional] Specify lanes to arrange items, default value is 1
                    $SpacingX: 8,                                   //[Optional] Horizontal space between each item in pixel, default value is 0
                    $SpacingY: 8,                                   //[Optional] Vertical space between each item in pixel, default value is 0
                    $Orientation: 1,                                //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
                    $Scale: false                                   //Scales bullets navigator or not while slider scale
                },

                $ArrowNavigatorOptions: {                           //[Optional] Options to specify and enable arrow navigator or not
                    $Class: $JssorArrowNavigator$,                  //[Requried] Class to create arrow navigator instance
                    $ChanceToShow: 1,                               //[Required] 0 Never, 1 Mouse Over, 2 Always
                    $AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
                    $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
                }
            };

            var jssor_slider1 = new $JssorSlider$("slider1_container", options);

            //responsive code begin
            //you can remove responsive code if you don't want the slider scales while window resizing
            function ScaleSlider() {
                var bodyWidth = document.body.clientWidth;
                if (bodyWidth)
                    jssor_slider1.$ScaleWidth(Math.min(bodyWidth, 1920));
                else
                    window.setTimeout(ScaleSlider, 30);
            }
            ScaleSlider();

            $(window).bind("load", ScaleSlider);
            $(window).bind("resize", ScaleSlider);
            $(window).bind("orientationchange", ScaleSlider);
            //responsive code end
        });*/
    </script>
			
		<?php } ?>

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
				
				<?php the_content(); ?>
				<?php wp_link_pages('before=<div class="page-links">&after=</div>'); ?>
				<?php if ( comments_open() || get_comments_number() ) {
					comments_template();
				} ?>
			</div><!-- end post -->
		</div>

<?php endwhile;
}
get_footer();
?>