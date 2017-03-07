<?php global $post_list, $current_view, $post_id;
if ( empty( $post_list ) ) :
	echo '<h5 class="empty-list">' . esc_html__( 'No available hotels', 'citytours' ) . '</h5>';
else :
foreach( $post_list as $post_obj ) :
	$post_id = $post_obj['hotel_id'];
	if(isset($_GET['rooms'])){
		ct_get_template( 'loop-search-' . $current_view . '.php', '/templates/hotel/');
	} else {
		ct_get_template( 'loop-' . $current_view . '.php', '/templates/hotel/');
	}
endforeach;
endif; ?>