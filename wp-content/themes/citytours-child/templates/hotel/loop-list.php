<?php global $post_id;
$wishlist = array();
if ( is_user_logged_in() ) {
	$user_id = get_current_user_id();
	$wishlist = get_user_meta( $user_id, 'wishlist', true );
}
if ( ! is_array( $wishlist ) ) $wishlist = array();
$price = get_post_meta( $post_id, '_hotel_price', true );
if ( empty( $price ) ) $price = 0;
$brief = get_post_meta( $post_id, '_hotel_brief', true );
if ( empty( $brief ) ) {
	$brief = apply_filters('the_content', get_post_field('post_content', $post_id));
	$brief = wp_trim_words( $brief, 20, '' );
}
$star = get_post_meta( $post_id, '_hotel_star', true );
$star = ( ! empty( $star ) )?round( $star, 1 ):0;
$review = get_post_meta( $post_id, '_review', true );
$review = ( ! empty( $review ) )?round( $review, 1 ):0;
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
$wishlist_link = ct_wishlist_page_url();
?>
<div class="strip_all_tour_list wow fadeIn" data-wow-delay="0.1s">
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-4">
			<?php if ( ! empty( $wishlist_link ) ) : ?>
			<div class="wishlist">
				<a class="tooltip_flip tooltip-effect-1 btn-add-wishlist" href="#" data-post-id="<?php echo esc_attr( $post_id ) ?>"<?php echo ( in_array( ct_hotel_org_id( $post_id ), $wishlist) ? ' style="display:none;"' : '' ) ?>><span class="wishlist-sign">+</span><span class="tooltip-content-flip"><span class="tooltip-back"><?php esc_html_e(  'Add to wishlist', 'citytours' ); ?></span></span></a>
				<a class="tooltip_flip tooltip-effect-1 btn-remove-wishlist" href="#" data-post-id="<?php echo esc_attr( $post_id ) ?>"<?php echo ( ! in_array( ct_hotel_org_id( $post_id ), $wishlist) ? ' style="display:none;"' : '' ) ?>><span class="wishlist-sign">-</span><span class="tooltip-content-flip"><span class="tooltip-back"><?php esc_html_e(  'Remove from wishlist', 'citytours' ); ?></span></span></a>
			</div>
			<?php endif; ?>
			<div class="img_list">
			
				<?php 
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
					$room_type_id = $room_types[0]->ID;
					$getPrice = get_post_meta( $room_type_id, '_room_price',true );
					$room_price = (!empty($getPrice) ? $getPrice : $price );
					
					global $wpdb;
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
					
				
					$gallery_imgs = get_post_meta( $room_type_id, '_gallery_imgs' );
					if(!empty($gallery_imgs) && isset($_GET['rooms'])){
						$hotelImages = wp_get_attachment_image( $gallery_imgs[0], 'full' );
					} else {
						$hotelImages = get_the_post_thumbnail( $post_id, array( 330, 220 ) );
					}
$locations = ( isset( $_REQUEST['locations'] ) ) ? ( is_array( $_REQUEST['locations'] ) ? $_REQUEST['locations'] : array( $_REQUEST['locations'] ) ):array();
$adults = ( isset( $_REQUEST['adults'] ) ? $_REQUEST['adults'] : '' );
$hotel_price = get_post_meta( $post_id, '_hotel_price', true );

				
				?>
			
				<a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
					<!-- <div class="ribbon popular" ></div> -->
					<?php echo $hotelImages; ?>
					<?php
						if ( ! empty( $tour_type ) ) {
							$icon_class = get_tax_meta($tour_type[0]->term_id, 'ct_tax_icon_class', true);
							echo '<div class="short_info">' . ( empty( $icon_class ) ? '' : '<i class="' . $icon_class . '"></i>' ) . $tour_type[0]->name . ' </div>';
						}
					?>
				</a>
			</div>
		</div>
		<div class="clearfix visible-xs-block"></div>
		<div class="col-lg-5 col-md-5 col-sm-5">
			<div class="tour_list_desc">
				<?php if ( ! empty( $review ) ) : ?>
					<div class="score"><?php echo esc_html( $review_content ) ?><span><?php echo esc_html( $doubled_review ) ?></span></div>
				<?php endif; ?>				
				<h3><?php echo esc_html( get_the_title( $post_id ) );?></h3>
				<div class="rating"><?php ct_rating_smiles( $star, 'icon-star-empty', 'icon-star voted' )?></div>
				<ul class="locations">
				<?php 
					$location_hotels = get_the_terms( $post_id, 'hotel_location' );					
					if ( ! $location_hotels || is_wp_error( $location_hotels ) ) $location_hotels = array();
					$counter = 0;
					foreach ( $location_hotels as $location_hotel ) :
						$term_id = $location_hotel->term_id;
						$icon_class = get_tax_meta($term_id, 'ct_tax_icon_class', true);
						if($counter==4){ echo '</ul><ul class="aminities hiddenAminities">'; }
						echo '<li>';
						if ( ! empty( $icon_class ) ) echo '<i class="' . esc_attr( $icon_class ) . '"></i>';
						echo esc_html( $location_hotel->name );
						echo '</li>';
						$counter++;
					endforeach;
				?>
				</ul>
				<p>
					<?php 
						$get_person = get_post_meta( $room_type_id, '_room_person',true );
						for($i=0;$i<$get_person;$i++){
							echo '<i class="icon-user"></i>';
						}
					?>
				</p>
			</div>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-3">
			<div class="price_list">
				<div style="font-size: 24px;line-height: 27px;">					
					 <s class="oldprice listPageOldPrice">BDT <?php echo ct_price( $realPrice, "special" ); ?></s><small ><?php //echo esc_html__( '*Hotel minimum price', 'citytours' ) ?></small>
					BDT <?php echo ct_price( $discountedPrice, "special" ); ?><small ><?php echo esc_html__( '*From/Per night', 'citytours' ) ?></small>
					<!--<p><a href="<?php //echo esc_url( get_permalink( $post_id ) ); ?>" class="btn_1"><?php //echo esc_html__( 'Details', 'citytours' ) ?></a></p>-->
					<p><a href="<?php echo esc_url( get_permalink( $post_id ) ); ?>" class="btn btn-56"><?php echo esc_html__( 'Book now', 'citytours' ) ?></a></p>
				</div>
			</div>
		</div>
	</div>
</div><!--End strip -->