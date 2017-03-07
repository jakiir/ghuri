<?php
get_header();

if ( have_posts() ) {
	global $wpdb;
	while ( have_posts() ) : the_post();
		$post_id = get_the_ID();
		$address = get_post_meta( $post_id, '_hotel_address', true );
		$person_price = get_post_meta( $post_id, '_hotel_price', true );
		if ( empty( $person_price ) ) $person_price = 0;
		$slider = get_post_meta( $post_id, '_hotel_slider', true );
		$star_rating = get_post_meta( $post_id, '_hotel_star', true );
		$minimum_stay = get_post_meta( $post_id, '_hotel_minimum_stay', true );
		
		$hotel_policy 		= get_post_meta( $post_id, '_hotel_hotel_policy', true );
		$additional_info 	= get_post_meta( $post_id, '_hotel_additional_info', true );
		

		$args = array(
			'post_type' => 'room_type',
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key' => '_room_hotel_id',
					'value' => array( $post_id )
				)
			),
			'post_status' => 'publish',
			'suppress_filters' => 0,
		);
		$room_types = get_posts( $args );

		$header_img_scr = ct_get_header_image_src( $post_id );
		if ( ! empty( $header_img_scr ) ) {
			$header_img_height = ct_get_header_image_height( $post_id );
			
					$ct_hotel_vacancies = $wpdb->prefix."ct_hotel_vacancies";					
					$hotelVacancy = "select id, price_per_room, price_per_person,weekend_price_fri,weekend_price_sat,peakseason_price,room_type_id from $ct_hotel_vacancies where hotel_id = $post_id AND price_per_room = (select min(price_per_room) from $ct_hotel_vacancies WHERE hotel_id = $post_id)";					
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
			
			<link rel="stylesheet" href="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/css/flexslider.css">
			
<link rel="stylesheet" href="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/css/lightslider.css">
<script src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/js/lightslider.js"></script>
		<section class="parallax-window" data-parallax="scroll" data-image-src="<?php echo esc_url( $header_img_scr ) ?>" data-natural-width="1400" data-natural-height="<?php echo esc_attr( $header_img_height ) ?>">		
				<div class="parallax-content-2">
					<div class="container">
						<div class="row">
							<div class="col-md-8 col-sm-8">
								<span class="rating">
								<?php ct_rating_smiles( $star_rating, 'icon-star-empty', 'icon-star voted' ); ?>
								</span>
								<h1><?php the_title() ?></h1>
								<span><?php echo esc_html( $address, 'citytours' ); ?></span>
							</div>
							<div class="col-md-4 col-sm-4">
								<div id="price_single_main">
									<?php echo esc_html__( 'from/per night', 'citytours' ) ?> <?php echo ct_price( $discountedPrice, "special" ) ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section><!-- End section -->
			<div id="position">

		<?php } else { ?>
			<div id="position" class="blank-parallax">
		<?php } ?>

			<div class="container"><?php ct_breadcrumbs(); ?></div>
		</div><!-- End Position -->

<div class="container margin_60">
	<div class="row">
		<div class="col-md-8" id="single_tour_desc">
<h2 class="available" id="anchor-available-rooms">Hotel Amenities</h2>
			<div id="single_tour_feat">
				<ul>
					<?php
						/*require_once(get_template_directory() . '/inc/lib/tax-meta-class/Tax-meta-class.php');
						$hotel_facilities = get_the_terms( $post_id, 'hotel_facility' );
						if ( ! $hotel_facilities || is_wp_error( $hotel_facilities ) ) $hotel_facilities = array();
						foreach ( $hotel_facilities as $hotel_term ) :
							$term_id = $hotel_term->term_id;
							$icon_class = get_tax_meta($term_id, 'ct_tax_icon_class', true);
							echo '<li>';
							if ( ! empty( $icon_class ) ) echo '<i class="' . esc_attr( $icon_class ) . '"></i>';
							echo esc_html( $hotel_term->name );
							echo '</li>';
						endforeach;*/
						require_once(get_template_directory() . '/inc/lib/tax-meta-class/Tax-meta-class.php');
						$hotel_amenities = get_the_terms( $post_id, 'hotel_amenity' );						
						if ( ! $hotel_amenities || is_wp_error( $hotel_amenities ) ) $hotel_amenities = array();
						$counter = 0;
						foreach ( $hotel_amenities as $hotel_amenity ) :
							$term_id = $hotel_amenity->term_id;
							$icon_class = get_tax_meta($term_id, 'ct_tax_icon_class', true);
							if($counter==4){ echo '</ul><ul class="aminities hiddenAminities">'; }
							echo '<li>';
							if ( ! empty( $icon_class ) ) echo '<i class="' . esc_attr( $icon_class ) . '"></i>';
							echo esc_html( $hotel_amenity->name );
							echo '</li>';
							$counter++;
						endforeach;
						?>
				</ul>
				<div class="showall">
					<div class="load_area">
						<a class="btn_1 green" onclick="showAllAminity(this)" style="margin-bottom:0px">Show All</a>
					</div>
				</div>
			</div>
			<script type="text/javascript">
				function showAllAminity(TheItem){
					var thisEle = $(TheItem);
					if(thisEle.text() == 'Show All' ){ thisEle.text('Hide All'); } else { thisEle.text('Show All'); }
					$('ul.aminities').toggleClass("hiddenAminities");
				}
			</script>
			<?php 
			$atta_args = array(
			   'post_type' => 'attachment',
			   'numberposts' => 35,
			   'post_status' => null,
			   'post_parent' => $post_id
			  );
			  $attachments = get_posts( $atta_args );			 
			?>
			
			<div class="clearfix" style="max-width:960px;max-height:500px;margin-bottom: 75px;">
                <ul id="image-gallery" class="gallery list-unstyled cS-hidden">
					<?php  
						if ( ! empty( $attachments ) ) :
							foreach ( $attachments as $attachment ) {  ?>
							<li data-thumb="<?php echo esc_url( wp_get_attachment_url( $attachment->ID ) ); ?>"> 
								<img src="<?php echo wp_get_attachment_image( $attachment->ID, 'full' ); ?>" />
							</li>
							<?php 
							}
						endif;
					if ( ! empty( $room_types ) ) :
						foreach( $room_types as $post ) : setup_postdata( $post ); 
						$room_type_id = get_the_ID();
						$gallery_imgs = get_post_meta( $room_type_id, '_gallery_imgs' );						
						foreach ( $gallery_imgs as $gallery_img ) { ?>
							<li data-thumb="<?php echo esc_url( wp_get_attachment_url( $gallery_img ) ); ?>"> 
								<img src="<?php echo wp_get_attachment_image( $gallery_img, 'full' ); ?>" />
							</li>
						<?php }						
							wp_reset_postdata();
						endforeach;						
					endif;					 
					?>                    
                </ul>
            </div>
			
			<?php if ( ! empty( $slider ) ) : ?>
				<?php //echo do_shortcode( $slider ); ?>
				<hr>
			<?php endif; ?>

			<div class="row">
				<div class="col-md-3">
					<h3><?php echo esc_html__( 'About Hotel', 'citytours') ?></h3>
				</div>
				<div class="col-md-9">
					<?php the_content(); ?>
				</div>
			</div>

			<hr>
			<div class="row"> 
				<div class="col-md-12"> 
					<h2 class="available" id="anchor-room-section"><?php echo esc_html__( 'Available Rooms', 'citytours' ) ?></h2> 
					<?php if ( ! empty( $room_types ) ) : ?>				
					
						<?php 						
						$roomsExtra = array();
						 $carts = $_SESSION['cart'];
						 if(!empty($carts)){
							 foreach($carts as $key=>$cart){							
								$roomsExtra[] = $cart;
							 }
						 }
						
						
						$is_first = true;
						$counter = 0;
						foreach( $room_types as $post ) : setup_postdata( $post ); ?>
							<?php if ( $is_first ) { $is_first = false; } else { echo '<hr>'; } 
							$room_type_id = get_the_ID();
							$getPrice = get_post_meta( $room_type_id, '_room_price',true );
							?>							
							
							<?php $gallery_imgs = get_post_meta( $room_type_id, '_gallery_imgs' );?>
					<div class="reservation reservation_table ng-scope" data-ng-repeat="room in hDetails.rooms track by $index">
    <div class="row">
        <div class="col-md-12">
            <div class="media">
				<h3 class="media-heading ng-binding" data-toggle="modal" data-target="#room<?php echo $counter; ?>"><?php the_title() ?></h3>
				<ul class="list_icons">
						<?php 						
						$hotel_facilities = get_the_terms( $room_type_id, 'hotel_facility' );
						if ( ! $hotel_facilities || is_wp_error( $hotel_facilities ) ) $hotel_facilities = array();
						foreach ( $hotel_facilities as $hotel_term ) :
							$term_id = $hotel_term->term_id;
							$icon_class = get_tax_meta($term_id, 'ct_tax_icon_class', true);
							echo '<li>';
							if ( ! empty( $icon_class ) ) echo '<i class="' . esc_attr( $icon_class ) . '"></i>';
							echo esc_html( $hotel_term->name );
							echo '</li>';
						endforeach; ?>
					</ul>  
                <div class="media-left avail_room">                   
                    <div class="flexslider-container" >
                        <div class="flexslider">
                            <ul class="slides" id="room_slider">      
								<?php if ( ! empty( $gallery_imgs ) ) : 
								foreach ( $gallery_imgs as $gallery_img ) :
								?>
								<li style="width: 100%; float: left; margin-right: -100%; position: relative; opacity: 1; display: block;">
								<img class="media-object room-thumb" width="100" height="100" data-toggle="modal" data-target="#room<?php echo $counter; ?>" src="<?php echo esc_url( wp_get_attachment_url( $gallery_img ) ); ?>" draggable="false">								
								</li>
								<?php endforeach; endif; ?>
                            </ul>                            
                        </div>
                    </div>
					<?php 				
					$get_discount_price = get_post_meta( $room_type_id, '_room_discount_price',true );
					$discount_price = ($get_discount_price ? $get_discount_price : 0);
					if($discount_price > 0){
					?>					
                    <div class="room_ribbon ng-hide">						
                        <p class="ribbon-green ng-binding">-<?php echo $discount_price; ?>%</p>
                    </div>
					<?php } ?>
					
					<div style="clear:both"></div>
					
					
                </div>
				
				
				
                <div class="media-body"> 
					<blockquote>
					<p class="room_p" style="margin:5px 0px"> <span class="ng-binding"><?php echo trunck_string(get_the_content(), 180, true); ?></span> <span data-toggle="modal" data-target="#room<?php echo $counter; ?>" style="color: #e14d67;cursor:pointer"> Read More</span> </p>					
					</blockquote>
					<?php 
						$get_bed_details = get_post_meta( $room_type_id, '_room_bed_details',true );
						$get_master_bed = get_post_meta( $room_type_id, '_room_master_bed',true );
						$get_couple_bed = get_post_meta( $room_type_id, '_room_couple_bed',true );
						$get_person = get_post_meta( $room_type_id, '_room_max_adults',true );
					?>
					
					<ul class="room_capacity">
						<li style="width: 69%;"><strong>Bed :</strong> <?php echo $get_bed_details; ?></li>						
						<li style="width: 30%;"><strong>Person :</strong> <?php 
							$get_person = get_post_meta( $room_type_id, '_room_max_adults',true );
							for($i=0;$i<$get_person;$i++){
								echo '<i class="icon-user"></i>';
							}
						?>
						</li>
					</ul>
					<ul class="list_ok">
					<?php 
					$room_extra_facilities 	= get_post_meta( $room_type_id, '_room_extra_facilities');
					if($room_extra_facilities){
						foreach($room_extra_facilities as $key=>$extra_facility){
							echo '<li>'.$extra_facility.'</li>';
						}
					}					 
					?>
					</ul>
					<!--<p>
						<?php 
							/*$get_person = get_post_meta( $room_type_id, '_room_person',true );
							for($i=0;$i<$get_person;$i++){
								echo '<i class="icon-user"></i>';
							}*/
						?>
					</p>-->
					<!--<p><span data-toggle="modal" data-target="#room<?php echo $counter; ?>" style="color: #e14d67;cursor:pointer">Read More...</span> </p>-->
                <?php 
					global $wpdb;
					$ct_hotel_vacancies = $wpdb->prefix."ct_hotel_vacancies";
					$hotelVacancy = "SELECT * FROM $ct_hotel_vacancies WHERE hotel_id = $post_id AND room_type_id = $room_type_id";
					$hotelVacancies=$wpdb->get_results($hotelVacancy);					
					if(!empty($hotelVacancies[0]->price_per_room)){
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
						$realPrice = $getPrice;
					}
				?> 
			   <p class="price-33" uib-tooltip="Note-Room tariff are inclusive of Service Charge &amp; Vat"> BDT <span class="ng-binding"> <?php if($get_discount_price > 0) { ?><s class="oldprice ng-binding ng-hide"><?php echo ct_price( $realPrice, "special" ); ?></s><?php } ?> <?php echo ct_price( $discountedPrice, "special" ); ?> </span> per night
                    <br> </p>							
						<p class="" style="font-size:10px;margin-top: 5px;">*Inclusive of Service Charge & Vat</p>	

				<div class="bookNowNnoOfRoom" style="margin-top: 15px;">
					
					
						<div class="ava_price">
							<div class="input-group"> 
								<span class="input-group-addon room_no">No. of Room</span>
								<select type="text" class="form-control room_no1">
									<?php 									
										for($i=1;$i<=$hotelVacancies[0]->rooms;$i++){
											$selected = '';
											if(!empty($roomsExtra[0]['room'][$room_type_id]['rooms']))
											$selected = ($roomsExtra[0]['room'][$room_type_id]['rooms'] == $i ? 'selected="selected"' : null);
									?>
										<option <?php echo $selected; ?> value="<?php echo $i; ?>" class="ng-binding ng-scope"><?php echo $i; ?> </option>
									<?php } ?>									
								</select>
							</div>
						</div>
						<div class="bookNow">
							<button type="submit" data-itemId="<?php echo $room_type_id; ?>" data-title="<?php the_title() ?>" data-price="<?php echo $discountedPrice; ?>" class="btn btn-56 bookNowBtn">Book Now</button>
						</div>	
					</div>
                </div>
            </div>
        </div>
    </div>   
   
	
    <!--********** Room Detais Modal Area**************-->
    <div class="modal fade" id="room<?php echo $counter; ?>">
        <div class="modal-dialog madal-size" role="document">
            <div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"><?php the_title(); ?></h4>
				</div>
                <div class="modal-body booking_modal">
                    <div class="panel booking_area">
                        <div class="reservation reservation_table">
                            <div class="row">
                                <div class="col-md-12">									      
										<?php if ( ! empty( $gallery_imgs ) ) : ?>										
										<img class="media-object room-thumb popupHotelImg" alt="" width="100%" height="auto" style="margin-bottom:20px;border-radius: 4px;border:1px solid #e14d67;" data-toggle="modal" data-target="#room<?php echo $counter; ?>" src="<?php echo esc_url( wp_get_attachment_url( $gallery_imgs[0] ) ); ?>" draggable="false">						
										
										<?php endif; ?>
									
								
                                    <?php the_content(); ?>
                                </div>
                            </div>
                            <div class="divider"></div>
                        </div>
                    </div>
                    <!--booking area-->
                </div>
            </div>
        </div>
    </div>
    <!--********** End Of Room Detais Modal Area**************-->
    <div class="divider"></div>
</div>

			<?php $counter++; wp_reset_postdata(); ?>
		<?php endforeach ?>
	<?php endif; ?>
				</div>
			</div>
			
			<hr>
			
			<div class="row">
				<div class="col-md-3">
					<h3><?php echo esc_html__( 'Hotel Policy', 'citytours') ?></h3>
				</div>
				<div class="col-md-9">
					<?php echo $hotel_policy; ?>
				</div>         
			</div>
			
			<hr>
			
			<div class="row">
				<div class="col-md-3">
					<h3><?php echo esc_html__( 'Additional Info', 'citytours') ?></h3>
				</div>
				<div class="col-md-9">
					<?php echo $additional_info; ?>
				</div>
			</div>
			
			<!--<div class="row">
				<div class="col-md-12">
					<h3><?php echo esc_html__( 'Available Rooms', 'citytours' ) ?></h3>
				</div>
				<div class="col-md-12">
					<?php if ( ! empty( $room_types ) ) : ?>
						<?php 
						$is_first = true;
						foreach( $room_types as $post ) : setup_postdata( $post ); ?>
							<?php if ( $is_first ) { $is_first = false; } else { echo '<hr>'; } 
							$room_type_id = get_the_ID();
							?>							
							
							<?php $gallery_imgs = get_post_meta( $room_type_id, '_gallery_imgs' );?>
							<?php if ( ! empty( $gallery_imgs ) ) : ?>
								<div class="carousel magnific-gallery leftColumn col-md-4">
									<?php foreach ( $gallery_imgs as $gallery_img ) {
										echo '<div class="item"><a href="' . esc_url( wp_get_attachment_url( $gallery_img ) ) . '">' . wp_get_attachment_image( $gallery_img, 'full' ) . '</a></div>';
									} ?>
								</div>
								<div class="rightColumn col-md-12">
									<h4><?php the_title() ?></h4>									
									<?php the_content() ?>
									<ul class="list_icons">
										<?php 
										$hotel_facilities = get_the_terms( $room_type_id, 'hotel_facility' );
										if ( ! $hotel_facilities || is_wp_error( $hotel_facilities ) ) $hotel_facilities = array();
										foreach ( $hotel_facilities as $hotel_term ) :
											$term_id = $hotel_term->term_id;
											$icon_class = get_tax_meta($term_id, 'ct_tax_icon_class', true);
											echo '<li>';
											if ( ! empty( $icon_class ) ) echo '<i class="' . esc_attr( $icon_class ) . '"></i>';
											echo esc_html( $hotel_term->name );
											echo '</li>';
										endforeach; ?>
									</ul>
								</div>
								
							<?php endif; ?>
							<?php wp_reset_postdata(); ?>
						<?php endforeach ?>
					<?php endif; ?>

				</div><!-- End col-md-9  -->
			<!--</div><!-- End row  -->

			<hr>

			<?php
			global $ct_options;
			if ( ! empty( $ct_options['hotel_review'] ) ) :
				$review_fields = ! empty( $ct_options['hotel_review_fields'] ) ? explode( ",", $ct_options['hotel_review_fields'] ) : array("Position", "Comfort", "Price", "Quality");
				$review = get_post_meta( ct_hotel_org_id( $post_id ), '_review', true );
				// $review = round( ( ! empty( $review ) ) ? (float) $review : 0, 1 );
				$doubled_review = number_format( round( $review * 2, 1 ), 1 );
				$review_content = '';
				if ( $doubled_review >= 9 ) {
					$review_content = esc_html__( 'Superb', 'citytours' );
				} elseif ( $doubled_review >= 8 ) {
					$review_content = esc_html__( 'Very good', 'citytours' );
				} elseif ( $doubled_review >= 7 ) {
					$review_content = esc_html__( 'Good', 'citytours' );
				} elseif ( $doubled_review >= 6 ) {
					$review_content = esc_html__( 'Pleasant', 'citytours' );
				} else {
					$review_content = esc_html__( 'Review Rating', 'citytours' );
				}
				$review_detail = get_post_meta( ct_hotel_org_id( $post_id ), '_review_detail', true );
				if ( ! empty( $review_detail ) ) {
					$review_detail = is_array( $review_detail ) ? $review_detail : unserialize( $review_detail );
				} else {
					$review_detail = array_fill( 0, count( $review_fields ), 0 );
				}
				?>
				<div class="row">
					<div class="col-md-3">
						<h3><?php echo esc_html__( 'Reviews', 'citytours') ?></h3>
						<a href="#" class="btn_1 add_bottom_15" data-toggle="modal" data-target="#myReview"><?php echo esc_html__( 'Leave a review', 'citytours') ?></a>
					</div>
					<div class="col-md-9">
						<div id="score_detail"><span><?php echo esc_html( $doubled_review ) ?></span><?php echo esc_html( $review_content ) ?> <small><?php echo sprintf( esc_html__( '(Based on %d reviews)' , 'citytours' ), ct_get_review_count( $post_id ) ) ?></small></div>
						<div class="row" id="rating_summary">
							<div class="col-md-6">
								<ul>
									<?php for ( $i = 0; $i < ( count( $review_fields ) / 2 ); $i++ ) { ?>
									<li><?php echo esc_html( $review_fields[ $i ], 'citytours' ); ?>
										<div class="rating"><?php echo ct_rating_smiles( $review_detail[ $i ] ) ?></div>
									</li>
									<?php } ?>
								</ul>
							</div>
							<div class="col-md-6">
								<ul>
									<?php for ( $i = $i; $i < count( $review_fields ); $i++ ) { ?>
									<li><?php echo esc_html( $review_fields[ $i ], 'citytours' ); ?>
										<div class="rating"><?php echo ct_rating_smiles( $review_detail[ $i ] ) ?></div>
									</li>
									<?php } ?>
								</ul>
							</div>
						</div><!-- End row -->
						<hr>
						<div class="guest-reviews">
							<?php
								$per_page = 10;
								$review_count = ct_get_review_html($post_id, 0, $per_page);
							?>
						</div>
						<?php if ( $review_count >= $per_page ) { ?>
							<a href="#" class="btn_1 more-review" data-post_id="<?php echo esc_attr( $post_id ) ?>"><?php echo esc_html__( 'LOAD MORE REVIEWS', 'citytours' ) ?></a>
						<?php } ?>
					</div>
				</div>

			<?php  endif; ?>

		</div><!--End  single_tour_desc-->

		<aside class="col-md-4">
		<div class="hotelSingleSidebar" style="">
		<div class="box_style_1 expose_old">
			<h3 class="inner"><?php echo esc_html__( 'Check Availability', 'citytours' ) ?></h3>
			<?php if ( ct_get_hotel_cart_page() ) : 
			
			$date_from = (isset($_GET['date_from']) ? $_GET['date_from'] : '');
			$date_to = (isset($_GET['date_to']) ? $_GET['date_to'] : '');
			$adults = (isset($_GET['adults']) ? $_GET['adults'] : '');
			$kids = (isset($_GET['kids']) ? $_GET['kids'] : '');
			$rooms = (isset($_GET['rooms']) ? $_GET['rooms'] : '');
			
			?>
			<form method="get" id="booking-form" action="<?php echo esc_url( ct_get_hotel_cart_page() ); ?>">				
			
				<input type="hidden" name="hotel_id" value="<?php echo esc_attr( $post_id ) ?>">
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label><i class="icon-calendar-7"></i> <?php echo esc_html__( 'Check in', 'citytours' ) ?></label>
							<input class="date-pick form-control checkInDate" data-date-format="<?php echo ct_get_date_format('html'); ?>" type="text" value="<?php echo (!empty($roomsExtra[0]['date_from']) ? mysql2date('d/m/Y', $roomsExtra[0]['date_from']) : $date_from); ?>" name="date_from">
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						 <div class="form-group">
							<label><i class="icon-calendar-7"></i> <?php echo esc_html__( 'Check out', 'citytours' ) ?></label>
							<input class="date-pick form-control checkOutDate" data-date-format="<?php echo ct_get_date_format('html'); ?>" type="text" value="<?php echo (!empty($roomsExtra[0]['date_to']) ? mysql2date('d/m/Y', $roomsExtra[0]['date_to']) : $date_to); ?>" name="date_to">
						</div>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-6 col-sm-6">
						<div class="form-group">
							<label><i class="icon-user"></i> <?php echo esc_html__( 'Adults', 'citytours' ) ?></label>
							<input class="form-control" type="text" value="<?php echo $adults; ?>" id="no_adults" name="no_adults">
						</div>
					</div>
					<div class="col-md-6 col-sm-6">
						 <div class="form-group">
							<label><i class="icon-user"></i> <?php echo esc_html__( 'Children', 'citytours' ) ?></label>
							<input class="form-control" type="text" value="<?php echo $kids; ?>" id="no_children" name="no_children">
						</div>
					</div>
					<?php 
					/*$no_of_extra_bed = get_post_meta( $post_id, '_hotel_max_extra_bed', true);
					if($no_of_extra_bed > 0){
						$per_extra_bed_price = get_post_meta( $post_id, '_hotel_per_extra_bed_price', true);
					?>
					<div class="col-md-12 col-sm-12">
						 <div class="form-group">
							<input type="hidden" class="per_extra_bed_price" value="<?php echo $per_extra_bed_price; ?>"/>
							<div class="input-group"> 
								<span class="input-group-addon extra_bed_no"><i class="icon_set_2_icon-104"></i> No. of Extra Bed</span>
								<select type="text" class="form-control extra_bed" id="extraBed">
									<?php 													
										for($i=0;$i<=$no_of_extra_bed;$i++){											
									?>
										<option value="<?php echo $i; ?>" class="ng-binding ng-scope"><?php echo $i; ?> </option>
									<?php } ?>											
								</select>
							</div>
						</div>
					</div>
					<?php }*/ ?>
				</div>
				<br>
				<!--<button type="submit" class="btn_full book-now"><?php //echo esc_html__( 'Check now', 'citytours' ) ?></button>-->
				<?php if ( ! empty( $ct_options['wishlist'] ) ) : ?>
				<?php if ( is_user_logged_in() ) {
					$user_id = get_current_user_id();
					$wishlist = get_user_meta( $user_id, 'wishlist', true );
					if ( empty( $wishlist ) ) $wishlist = array();?>
						<a class="btn_full_outline btn-add-wishlist" href="#" data-post-id="<?php echo esc_attr( $post_id ) ?>"<?php echo ( in_array( ct_hotel_org_id( $post_id ), $wishlist) ) ? ' style="display:none;"' : '' ?>><i class=" icon-heart"></i> <?php echo esc_html__( 'Add to wishlist', 'citytours' ) ?></a>
						<a class="btn_full_outline btn-remove-wishlist" href="#" data-post-id="<?php echo esc_attr( $post_id ) ?>"<?php echo ( ! in_array( ct_hotel_org_id( $post_id ), $wishlist) ) ? ' style="display:none;"' : '' ?>><i class=" icon-heart"></i> <?php esc_html_e(  'Remove from wishlist', 'citytours' ); ?></a>
				<?php } else { ?>
						<div><?php esc_html_e(  'To save your wishlist please login.', 'citytours' ); ?></div>
						<?php if ( empty( $ct_options['login_page'] ) ) { ?>
							<a href="#" class="btn_full_outline"><?php esc_html_e(  'login', 'citytours' ); ?></a>
						<?php } else { ?>
							<a href="<?php echo esc_url( ct_get_permalink_clang( $ct_options['login_page'] ) ); ?>" class="btn_full_outline"><?php esc_html_e(  'login', 'citytours' ); ?></a>
						<?php } ?>
				<?php } ?>
				<?php endif; ?>
			</form>
			<?php else : ?>
				<?php echo wp_kses_post( sprintf( __( 'Please set hotel booking page on <a href="%s">Theme Options</a>/Hotel Main Settings', 'citytours' ), esc_url( admin_url( 'themes.php?page=CityTours' ) ) ) ); ?>
			<?php endif; ?>
			
			<ul class="list-group" id="cartItems" style="clear:both;margin-top:15px;">
				<?php 					
					$checkOut = '';
					$totalNoRoom = 0;
					$roomIds = [];
					$total_price = (!empty($roomsExtra[0]['total_price']) ? $roomsExtra[0]['total_price'] : '');
					 $carts = $_SESSION['cart'];
					 if(!empty($carts)){
						 foreach($carts as $key=>$cart){
							$cartFromDate = $cart['date_from'];
							$cartToDate =  $cart['date_to'];
							$cartHotelId =  $cart['hotel_id'];
							$checkOut = $key;
							if(!empty($cart['room'])){
							 foreach($cart['room'] as $roomKey=>$cart_room){								
								 if(is_array($cart_room)){									
									echo '<li data-total-price="'.$cart_room['total'].'" class="list-group-item itemId_'.$roomKey.'"><span class="badge link removeCartItem" data-uid="'.$checkOut.'" data-itemid="'.$roomKey.'"><i class="icon-trash-7"></i></span><span class="badge itemNoOfRoom">'.$cart_room['rooms'].'</span> '.get_the_title($roomKey).'</li>';
									$rooms = $cart_room['rooms'];
									$adults = $cart_room['adults'];
									$kids = $cart_room['kids'];
									$itemRoom[$roomKey] = array(
										'rooms' => $rooms,
										'adults' => $adults,
										'kids' => $kids
									);
									$totalNoRoom += $rooms;
									$roomIds[] = $roomKey;
								 } 
							 }
							}							
						 }
					 }
				?>
			</ul>
			<?php if($total_price !='' ){ ?>
			<a class="btn_full btn_1 add_bottom_15" href="javascript:void(0)" id="checkNowBtn" data-action="<?php echo $checkOut; ?>">Book <span class="totalNoOfRoom"><?php echo $totalNoRoom; ?></span> Room(s) * 1 Day(s)<br><small class="">Price: BDT <span class="totalRoomPrice"><?php echo $total_price; ?></span></small></a> 
			<?php } else { ?>
			<a class="btn_full btn_1 add_bottom_15" href="javascript:void(0)" style="display:none;" id="checkNowBtn" data-action="<?php echo $checkOut; ?>">Book <span class="totalNoOfRoom"><?php echo $totalNoRoom; ?></span> Room(s) * 1 Day(s)<br><small class="">Price: BDT <span class="totalRoomPrice"><?php echo $total_price; ?></span></small></a>
			<?php } ?>
			
		</div><!--/box_style_1 -->
		
		
		<?php if ( is_active_sidebar( 'sidebar-hotel' ) ) : ?>
			<?php dynamic_sidebar( 'sidebar-hotel' ); ?>
		<?php endif; ?>
		</div>
		</aside>
	</div><!--End row -->
</div><!--End container -->
<?php if ( ! empty( $ct_options['hotel_review'] ) ) : ?>
<div class="modal fade" id="myReview" tabindex="-1" role="dialog" aria-labelledby="myReviewLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
				<h4 class="modal-title" id="myReviewLabel"><?php echo esc_html__( 'Write your review', 'citytours' ) ?></h4>
			</div>
			<div class="modal-body">
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ) ?>" name="review" id="review-form">
					<?php wp_nonce_field( 'post-' . $post_id, '_wpnonce', false ); ?>
					<input type="hidden" name="post_id" value="<?php echo esc_attr( $post_id ); ?>">
					<input type="hidden" name="action" value="submit_review">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<input name="booking_no" id="booking_no" type="text" placeholder="<?php echo esc_html__( 'Booking No', 'citytours' ) ?>" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<input name="pin_code" id="pin_code" type="text" placeholder="<?php echo esc_html__( 'Pin Code', 'citytours' ) ?>" class="form-control">
							</div>
						</div>
					</div>
					<!-- End row -->
					<hr>
					<div class="row">
						<?php for ( $i = 0; $i < ( count( $review_fields ) ); $i++ ) { ?>
							<div class="col-md-6">
								<div class="form-group">
									<label><?php echo esc_html( $review_fields[ $i ], 'citytours' ); ?></label>
									<select class="form-control" name="review_rating_detail[<?php echo esc_attr( $i ) ?>]">
										<option value="0"><?php esc_html_e( "Please review", 'citytours' ); ?></option>
										<option value="1"><?php esc_html_e( "Low", 'citytours' ); ?></option>
										<option value="2"><?php esc_html_e( "Sufficient", 'citytours' ); ?></option>
										<option value="3"><?php esc_html_e( "Good", 'citytours' ); ?></option>
										<option value="4"><?php esc_html_e( "Excellent", 'citytours' ); ?></option>
										<option value="5"><?php esc_html_e( "Super", 'citytours' ); ?></option>
									</select>
								</div>
							</div>
						<?php } ?>
					</div>
					<!-- End row -->
					<div class="form-group">
						<textarea name="review_text" id="review_text" class="form-control" style="height:100px" placeholder="<?php esc_html_e( "Write your review", 'citytours' ); ?>"></textarea>
					</div>
					<input type="submit" value="Submit" class="btn_1" id="submit-review">
				</form>
				<div id="message-review" class="alert alert-warning">
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>

<!-- Modal -->
<div class="modal fade" id="miniCartPopUp" tabindex="-1" role="dialog" aria-labelledby="miniCartModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="miniCartModalLabel">Hotel Cart</h4>
      </div>
      <div class="modal-body">
        <ul class="list-group" id="miniCartItems" style="clear:both;margin-top:15px;">
				<?php 					
					$checkOut = '';
					$totalNoRoom = 0;
					$roomIds = [];
					$total_price = (!empty($roomsExtra[0]['total_price']) ? $roomsExtra[0]['total_price'] : '');
					 $carts = $_SESSION['cart'];
					 if(!empty($carts)){
						 foreach($carts as $key=>$cart){
							$cartFromDate = $cart['date_from'];
							$cartToDate =  $cart['date_to'];
							$cartHotelId =  $cart['hotel_id'];
							$checkOut = $key;
							if(!empty($cart['room'])){
							 foreach($cart['room'] as $roomKey=>$cart_room){								
								 if(is_array($cart_room)){									
									echo '<li data-total-price="'.$cart_room['total'].'" class="list-group-item itemId_'.$roomKey.'"><span class="badge link removeCartItem" data-uid="'.$checkOut.'" data-itemid="'.$roomKey.'"><i class="icon-trash-7"></i></span><span class="badge itemNoOfRoom">'.$cart_room['rooms'].'</span> '.get_the_title($roomKey).'</li>';
									$rooms = $cart_room['rooms'];
									$adults = $cart_room['adults'];
									$kids = $cart_room['kids'];
									$itemRoom[$roomKey] = array(
										'rooms' => $rooms,
										'adults' => $adults,
										'kids' => $kids
									);
									$totalNoRoom += $rooms;
									$roomIds[] = $roomKey;
								 } 
							 }
							}							
						 }
					 }
				?>
			</ul>
			<?php if($total_price !='' ){ ?>
			<a class="btn_full btn_1 add_bottom_15" href="javascript:void(0)" id="miniCheckNowBtn" data-action="<?php echo $checkOut; ?>">Book <span class="totalNoOfRoomPopUp"><?php echo $totalNoRoom; ?></span> Room(s) * 1 Day(s)<br><small class="">Price: BDT <span class="totalRoomPricePopUp"><?php echo $total_price; ?></span></small></a> 
			<?php } else { ?>
			<a class="btn_full btn_1 add_bottom_15" href="javascript:void(0)" style="display:none;" id="miniCheckNowBtn" data-action="<?php echo $checkOut; ?>">Book <span class="totalNoOfRoomPopUp"><?php echo $totalNoRoom; ?></span> Room(s) * 1 Day(s)<br><small class="">Price: BDT <span class="totalRoomPricePopUp"><?php echo $total_price; ?></span></small></a>
			<?php } ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script src="<?php echo esc_url( get_stylesheet_directory_uri() ); ?>/js/jquery.flexslider.js"></script>
<?php 
//$_SESSION['cart'] = '';
$roomIdss = implode(',',$roomIds);
//print_r($_SESSION);
?>
<script>
var ajaxurl = '<?php echo esc_js( admin_url( 'admin-ajax.php' ) ) ?>';
$ = jQuery.noConflict();
$(document).ready(function(){
	
	if (window.matchMedia('(max-width: 1000px)').matches) {
		var no_adultsVal = $('#no_adults').val();
		if(no_adultsVal == ''){
			$('#no_adults').val(1);
		}
	}
	
	itemsId = [<?php echo $roomIdss; ?>];
	itemsIds = [<?php echo $roomIdss; ?>];
	itemsIdr = [<?php echo $roomIdss; ?>];
	rooms = {};
	adults = {};
	kids = {};
	$(document).on("click",".bookNowBtn",function() {		
		var thisItem = $(this);
		var no_adults = ($('#no_adults').val() ? $('#no_adults').val() : 0); 
		var no_children = ($('#no_children').val() ? $('#no_children').val() : 0);
		$('#no_adults').css('border','1px solid #ccc');
		if(no_adults ==0 ){
			$('#no_adults').css('border','1px solid red');
			alert('Please, type minimum 1 adult!');
			return false;
		}
		/*var extraBed = ($('#extraBed').val() ? $('#extraBed').val() : 0); 
		var per_extra_bed_price = ($('.per_extra_bed_price').val() ? $('.per_extra_bed_price').val() : 0); 
		console.log(extraBed);*/
		
		var roomTitle = thisItem.data('title');
		var itemId = thisItem.data('itemid');
		var roomPrice = thisItem.data('price');	
		var hotelId = '<?php echo $post_id; ?>';
		var noOfRoomr = thisItem.parent().parent().find('.room_no1').val();		
		var totalPrice = roomPrice * noOfRoomr;
				
		<?php if($roomIdss !=''){ 
		foreach($itemRoom as $keys=>$itemRo){ ?>
		rooms[<?php echo $keys; ?>] = <?php echo $itemRo['rooms']; ?>;
		adults[<?php echo $keys; ?>] = <?php echo $itemRo['adults']; ?>;
		kids[<?php echo $keys; ?>] = <?php echo $itemRo['kids']; ?>;
		<?php } } ?>
		
		if (jQuery.inArray(itemId, itemsId) == -1){
			itemsId.push(itemId);
		}				
		rooms[itemId] = noOfRoomr;		
		adults[itemId] = no_adults;
		kids[itemId] = no_children;	
		
		var date_from = $('input.checkInDate').val();
		var date_to = $('input.checkOutDate').val();
		$.ajax({
			url: ajaxurl,
			type: "POST",
			data: {				
				action: 'jk_hotel_update_cart',
				hotel_id:hotelId,
				date_from:date_from,
				date_to:date_to,
				room_type_id:itemsId,
				rooms:rooms,
				adults:adults,
				kids:kids
			},
			success: function(response){
				if (response.success == 1) {
					if (jQuery.inArray(itemId, itemsIds) != -1){						
					  $('#cartItems li.itemId_'+itemId).find('.itemNoOfRoom').html(noOfRoomr);
					  $('#cartItems li.itemId_'+itemId).attr('data-total-price', totalPrice);
					} else {	
						$('#cartItems').append('<li data-total-price="'+totalPrice+'" class="list-group-item list_room_price itemId_'+itemId+'"><span data-itemid="'+itemId+'" class="badge link removeCartItem" data-uid="'+response.uid+'" data-itemid="'+itemsId+'"><i class="icon-trash-7"></i></span><span class="badge itemNoOfRoom">'+noOfRoomr+'</span> '+roomTitle+'</li>');
					}
					
					if (window.matchMedia('(max-width: 1000px)').matches) {
						if (jQuery.inArray(itemId, itemsIds) != -1){						
						  $('#miniCartItems li.itemId_'+itemId).find('.itemNoOfRoomPopUp').html(noOfRoomr);
						  $('#miniCartItems li.itemId_'+itemId).attr('data-total-price', totalPrice);
						} else {
							$('#miniCartItems').append('<li data-total-price="'+totalPrice+'" class="list-group-item list_room_price_popup itemId_'+itemId+'"><span data-itemid="'+itemId+'" class="badge link removeCartItem" data-uid="'+response.uid+'" data-itemid="'+itemsId+'"><i class="icon-trash-7"></i></span><span class="badge itemNoOfRoomPopUp">'+noOfRoomr+'</span> '+roomTitle+'</li>');
						}
						
						$('#miniCheckNowBtn').show();
						$("#miniCheckNowBtn").attr('data-action',response.uid);
						
						var total_price = getTotalPrice('.list_room_price_popup');		
						$('.totalRoomPricePopUp').html(response.total_price);	
						var total_room = getTotalRoom('.itemNoOfRoomPopUp');
						$('.totalNoOfRoomPopUp').html(total_room);
						
						$('#miniCartPopUp').modal('show');
						
					} 
					
					if (jQuery.inArray(itemId, itemsIds) == -1){						
					  itemsIds.push(itemId);
					  itemsIdr.push(itemId);
					}
					
					var total_price = getTotalPrice('.list_room_price');		
					$('.totalRoomPrice').html(response.total_price);	
					var total_room = getTotalRoom('.itemNoOfRoom');
					$('.totalNoOfRoom').html(total_room);	
					
					$('#checkNowBtn').show();
					$("#checkNowBtn").attr('data-action',response.uid);
					//location.reload();
					
					
					
				} else {
					alert(response.message);
					console.log(response.message);
				}
			}
		});
		
		return false;
	});
	$(document).on("click",".removeCartItem",function() {
		var thisItems = $(this);
		var itemId = thisItems.data('itemid');
		var index = itemsId.indexOf(itemId);		
		if (index > -1) {
			itemsId.splice(index, 1);
			itemsIds.splice(index, 1);
		}		
		rooms[itemId] = 0;		
		adults[itemId] = 0;
		kids[itemId] = 0;		
		/*var date_from = '<?php echo (!empty($roomsExtra[0]['date_from']) ?  mysql2date('d/m/Y', $roomsExtra[0]['date_from']) : ''); ?>';
		var date_to = '<?php echo (!empty($roomsExtra[0]['date_to']) ? mysql2date('d/m/Y', $roomsExtra[0]['date_to']) : ''); ?>';
		if(date_from ==''){
			var date_from = $('input.checkInDate').val();
		}
		if(date_to ==''){
			var date_to = $('input.checkInDate').val();
		}
		var date_from = thisItems.data('from-date');
		var date_to = thisItems.data('to-date');
		var hotel_id = thisItems.data('hotel_id');
		*/		
		var uid = thisItems.data('uid');
		var item_total_price = thisItems.parent().data('total-price');
		
		$.ajax({
			url: ajaxurl,
			type: "POST",
			data: {				
				action: 'jk_hotel_remove_cart',
				uid:uid,
				room_type_id:itemId,	
				item_price:item_total_price,
				itemsLength:itemsId.length
			},
			success: function(response){						
				if (response.success == 1) {
					//thisItems.parent().remove();
					$('.itemId_'+itemId).remove();
					if(itemsId.length == 0){
						$('#checkNowBtn').hide();
					}
					if (window.matchMedia('(max-width: 1000px)').matches) {	
						if(itemsId.length == 0){
							$('#miniCheckNowBtn').hide();
							$('#miniCartItems').text('Cart is empty now!');
						}

						var total_price = getTotalPrice('.list_room_price_popup');		
						$('.totalRoomPricePopUp').html(total_price);	
						var total_room = getTotalRoom('.itemNoOfRoomPopUp');
						$('.totalNoOfRoomPopUp').html(total_room);
						
					}
					
					
					var total_price = getTotalPrice('.list_room_price');		
					$('.totalRoomPrice').html(total_price);	
					var total_room = getTotalRoom('.itemNoOfRoom');
					$('.totalNoOfRoom').html(total_room);					
						
				} else {
					alert(response.message);
				}
			}
		});
		
		/*$.ajax({
			url: ajaxurl,
			type: "POST",
			data: {				
				action: 'jk_hotel_update_cart',
				hotel_id:hotel_id,
				date_from:date_from,
				date_to:date_to,
				room_type_id:itemsIdr,
				rooms:rooms,
				adults:adults,
				kids:kids
			},
			success: function(response){	
				console.log(response);
				if (response.success == 1) {
					thisItems.parent().remove();
					if(itemsId.length == 0){
						$('#checkNowBtn').hide();
					}
					
					var total_price = getTotalPrice('.list-group-item');		
					$('.totalRoomPrice').html(total_price);	
					var total_room = getTotalRoom('.itemNoOfRoom');
					$('.totalNoOfRoom').html(total_room);					
						
				} else {
					alert(response.message);
				}
			}
		});*/	
		return false;
	});
	$(document).on("click","#checkNowBtn",function(e) {
		e.preventDefault();
		var thisItem = $(this);
		var actionUrl = thisItem.data('action');
		if(actionUrl != ''){
			var checkOutUrl = '<?php echo home_url('hotel-checkout-page/?uid='); ?>'+actionUrl;
			document.location.href=checkOutUrl;
		} else {
			alert('Sorry, Your cart is empty now!');
		}		
	});
	
	$(document).on("click","#miniCheckNowBtn",function(e) {
		e.preventDefault();
		var thisItem = $(this);
		var actionUrl = thisItem.data('action');
		if(actionUrl != ''){
			var checkOutUrl = '<?php echo home_url('hotel-checkout-page/?uid='); ?>'+actionUrl;
			document.location.href=checkOutUrl;
		} else {
			alert('Sorry, Your cart is empty now!');
		}		
	});
	
	

	/*$('input.date-pick').datepicker({
		startDate: "today"
	});
	$('input[name="date_from"]').datepicker( 'setDate', 'today' );
	$('input[name="date_to"]').datepicker( 'setDate', '+1d' );*/
	$('#booking-form').submit(function(){
		var minimum_stay = 0;
		<?php if ( ! empty( $minimum_stay ) ) { echo 'minimum_stay=' . $minimum_stay .';'; } ?>
		var date_from = $('input[name="date_from"]').datepicker('getDate').getTime();
		var date_to = $('input[name="date_to"]').datepicker('getDate').getTime();
		var one_day = 1000*60*60*24;
		if ( date_from + one_day * minimum_stay > date_to ) {
			alert( "<?php echo esc_js( sprintf( __( 'Minimum stay for this hotel is %d nights. Have another look at your dates and try again.', 'citytours' ), $minimum_stay ) ) ?>" );
			return false;
		}
	});
	
	$('#image-gallery').lightSlider({
		gallery:true,
		item:1,
		thumbItem:9,
		slideMargin: 0,
		speed:500,
		auto:true,
		loop:true,
		onSliderLoad: function() {
			$('#image-gallery').removeClass('cS-hidden');
		}  
	});

	$('.flexslider').flexslider({
		animation: "slide",
		start: function(slider){
		  $('body').removeClass('loading');
		}
	});
	
});

function getTotalPrice(selector){
  var tempValues = 0; 
  $(selector).each(function(){
     var th= $(this);
     tempValues += Number(th.attr('data-total-price'));
   });
  return tempValues;
}
function getTotalRoom(selector){
  var tempValues = 0;
  $(selector).each(function(){
     var th= $(this);
     tempValues += Number(th.text());
   });
  return tempValues;
}
</script>

<?php endwhile;
}
get_footer();