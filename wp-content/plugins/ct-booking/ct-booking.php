<?php
/**
 * Plugin Name: CTBooking
 * Plugin URI: http://www.soaptheme.net/ctbooking/
 * Description: A booking system
 * Version: 1.0
 * Author: Soaptheme
 * Author URI: http://www.soaptheme.net
 */
if ( ! function_exists( 'ct_register_hotel_post_type' ) ) {
	function ct_register_hotel_post_type() {
		$labels = array(
			'name'                => _x( 'Hotels', 'Post Type General Name', 'citytours' ),
			'singular_name'       => _x( 'Hotel', 'Post Type Singular Name', 'citytours' ),
			'menu_name'           => __( 'Hotels', 'citytours' ),
			'all_items'           => __( 'All Hotels', 'citytours' ),
			'view_item'           => __( 'View Hotel', 'citytours' ),
			'add_new_item'        => __( 'Add New Hotel', 'citytours' ),
			'add_new'             => __( 'New Hotel', 'citytours' ),
			'edit_item'           => __( 'Edit Hotels', 'citytours' ),
			'update_item'         => __( 'Update Hotels', 'citytours' ),
			'search_items'        => __( 'Search Hotels', 'citytours' ),
			'not_found'           => __( 'No Hotels found', 'citytours' ),
			'not_found_in_trash'  => __( 'No Hotels found in Trash', 'citytours' ),
		);
		$args = array(
			'label'               => __( 'hotel', 'citytours' ),
			'description'         => __( 'Hotel information pages', 'citytours' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'author' ),
			'taxonomies'          => array( ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
		);
		register_post_type( 'hotel', $args );
	}
}

/*
 * register room post type
 */
if ( ! function_exists( 'ct_register_room_type_post_type' ) ) {
	function ct_register_room_type_post_type() {
		$labels = array(
			'name'                => _x( 'Room Types', 'Post Type Name', 'citytours' ),
			'singular_name'       => _x( 'Room Type', 'Post Type Singular Name', 'citytours' ),
			'menu_name'           => __( 'Room Types', 'citytours' ),
			'all_items'           => __( 'All Room Types', 'citytours' ),
			'view_item'           => __( 'View Room Type', 'citytours' ),
			'add_new_item'        => __( 'Add New Room', 'citytours' ),
			'add_new'             => __( 'New Room Types', 'citytours' ),
			'edit_item'           => __( 'Edit Room Types', 'citytours' ),
			'update_item'         => __( 'Update Room Types', 'citytours' ),
			'search_items'        => __( 'Search Room Types', 'citytours' ),
			'not_found'           => __( 'No Room Types found', 'citytours' ),
			'not_found_in_trash'  => __( 'No Room Types found in Trash', 'citytours' ),
		);
		$args = array(
			'label'               => __( 'room types', 'citytours' ),
			'description'         => __( 'Room Type information pages', 'citytours' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'author' ),
			'taxonomies'          => array( ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			//'show_in_menu'        => 'edit.php?post_type=hotel',
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'rewrite' => array('slug' => 'room-type', 'with_front' => true)
		);
		if ( current_user_can( 'manage_options' ) ) {
			$args['show_in_menu'] = 'edit.php?post_type=hotel';
		}
		register_post_type( 'room_type', $args );
	}
}

/*
 * register Location taxonomy
 */
if ( ! function_exists( 'ct_register_hotel_location_taxonomy' ) ) {
	function ct_register_hotel_location_taxonomy(){
		$labels = array(
				'name'              => _x( 'Locations', 'taxonomy general name', 'citytours' ),
				'singular_name'     => _x( 'Location', 'taxonomy singular name', 'citytours' ),
				'menu_name'         => __( 'Locations', 'citytours' ),
				'all_items'         => __( 'All Locations', 'citytours' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'new_item_name'     => __( 'New Location', 'citytours' ),
				'add_new_item'      => __( 'Add New Location', 'citytours' ),
				'edit_item'         => __( 'Edit Location', 'citytours' ),
				'update_item'       => __( 'Update Location', 'citytours' ),
				'separate_items_with_commas' => __( 'Separate Locations with commas', 'citytours' ),
				'search_items'      => __( 'Search Locations', 'citytours' ),
				'add_or_remove_items'        => __( 'Add or remove Locations', 'citytours' ),
				'choose_from_most_used'      => __( 'Choose from the most used Locations', 'citytours' ),
				'not_found'                  => __( 'No Locations found.', 'citytours' ),
			);
		$args = array(
				'labels'            => $labels,
				'hierarchical'      => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'meta_box_cb'       => false
			);
		register_taxonomy( 'hotel_location', array( 'hotel' ), $args );
	}
}

if ( ! function_exists( 'ct_register_tour_location_taxonomy' ) ) {
	function ct_register_tour_location_taxonomy(){
		$labels = array(
				'name'              => _x( 'Locations', 'taxonomy general name', 'citytours' ),
				'singular_name'     => _x( 'Location', 'taxonomy singular name', 'citytours' ),
				'menu_name'         => __( 'Locations', 'citytours' ),
				'all_items'         => __( 'All Locations', 'citytours' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'new_item_name'     => __( 'New Location', 'citytours' ),
				'add_new_item'      => __( 'Add New Location', 'citytours' ),
				'edit_item'         => __( 'Edit Location', 'citytours' ),
				'update_item'       => __( 'Update Location', 'citytours' ),
				'separate_items_with_commas' => __( 'Separate Locations with commas', 'citytours' ),
				'search_items'      => __( 'Search Locations', 'citytours' ),
				'add_or_remove_items'        => __( 'Add or remove Locations', 'citytours' ),
				'choose_from_most_used'      => __( 'Choose from the most used Locations', 'citytours' ),
				'not_found'                  => __( 'No Locations found.', 'citytours' ),
			);
		$args = array(
				'labels'            => $labels,
				'hierarchical'      => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'meta_box_cb'       => false
			);
		register_taxonomy( 'tour_location', array( 'tour' ), $args );
	}
}

/*
 * register hotel facility taxonomy
 */
if ( ! function_exists( 'ct_register_hotel_facility_taxonomy' ) ) {
	function ct_register_hotel_facility_taxonomy(){
		$labels = array(
				'name'              => _x( 'Hotel Facilities', 'taxonomy general name', 'citytours' ),
				'singular_name'     => _x( 'Hotel Facility', 'taxonomy singular name', 'citytours' ),
				'menu_name'         => __( 'Hotel Facilities', 'citytours' ),
				'all_items'         => __( 'All Hotel Facilities', 'citytours' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'new_item_name'     => __( 'New Hotel Facility', 'citytours' ),
				'add_new_item'      => __( 'Add New Hotel Facility', 'citytours' ),
				'edit_item'         => __( 'Edit Hotel Facility', 'citytours' ),
				'update_item'       => __( 'Update Hotel Facility', 'citytours' ),
				'separate_items_with_commas' => __( 'Separate hotel facilities with commas', 'citytours' ),
				'search_items'      => __( 'Search Hotel Facilities', 'citytours' ),
				'add_or_remove_items'        => __( 'Add or remove hotel facilities', 'citytours' ),
				'choose_from_most_used'      => __( 'Choose from the most used hotel facilities', 'citytours' ),
				'not_found'                  => __( 'No hotel facilities found.', 'citytours' ),
			);
		$args = array(
				'labels'            => $labels,
				'hierarchical'      => false,
				'show_ui'           => true,
				'show_admin_column' => true,
				'meta_box_cb'       => false
			);
		register_taxonomy( 'hotel_facility', array( 'room_type', 'hotel' ), $args );
	}
}

// Post Types for Tour
/*
 * register tour post type
 */
if ( ! function_exists( 'ct_register_tour_post_type' ) ) {
	function ct_register_tour_post_type() {
		$labels = array(
			'name'                => _x( 'Tours', 'Post Type General Name', 'citytours' ),
			'singular_name'       => _x( 'Tour', 'Post Type Singular Name', 'citytours' ),
			'menu_name'           => __( 'Tours', 'citytours' ),
			'all_items'           => __( 'All Tours', 'citytours' ),
			'view_item'           => __( 'View Tour', 'citytours' ),
			'add_new_item'        => __( 'Add New Tour', 'citytours' ),
			'add_new'             => __( 'New Tour', 'citytours' ),
			'edit_item'           => __( 'Edit Tours', 'citytours' ),
			'update_item'         => __( 'Update Tours', 'citytours' ),
			'search_items'        => __( 'Search Tours', 'citytours' ),
			'not_found'           => __( 'No Tours found', 'citytours' ),
			'not_found_in_trash'  => __( 'No Tours found in Trash', 'citytours' ),
		);
		$args = array(
			'label'               => __( 'tour', 'citytours' ),
			'description'         => __( 'Tour information pages', 'citytours' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'author' ),
			'taxonomies'          => array( ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
		);
		register_post_type( 'tour', $args );
	}
}

/*
 * register tour type taxonomy
 */
if ( ! function_exists( 'ct_register_tour_type_taxonomy' ) ) {
	function ct_register_tour_type_taxonomy(){
		$labels = array(
				'name'              => _x( 'Tour Types', 'taxonomy general name', 'citytours' ),
				'singular_name'     => _x( 'Tour Type', 'taxonomy singular name', 'citytours' ),
				'menu_name'         => __( 'Tour Types', 'citytours' ),
				'all_items'         => __( 'All Tour Types', 'citytours' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'new_item_name'     => __( 'New Tour Type', 'citytours' ),
				'add_new_item'      => __( 'Add New Tour Type', 'citytours' ),
				'edit_item'         => __( 'Edit Tour Type', 'citytours' ),
				'update_item'       => __( 'Update Tour Type', 'citytours' ),
				'separate_items_with_commas' => __( 'Separate tour types with commas', 'citytours' ),
				'search_items'      => __( 'Search Tour Types', 'citytours' ),
				'add_or_remove_items'        => __( 'Add or remove tour types', 'citytours' ),
				'choose_from_most_used'      => __( 'Choose from the most used tour types', 'citytours' ),
				'not_found'                  => __( 'No tour types found.', 'citytours' ),
			);
		$args = array(
				'labels'            => $labels,
				'hierarchical'      => true,
				'show_ui'           => true,
				'show_admin_column' => true,
				'meta_box_cb'       => false,
				'rewrite' => array('slug' => 'tour-type', 'with_front' => true)
			);
		register_taxonomy( 'tour_type', array( 'tour' ), $args );
	}
}

/*
 * register tour facility taxonomy
 */
if ( ! function_exists( 'ct_register_tour_facility_taxonomy' ) ) {
	function ct_register_tour_facility_taxonomy(){
		$labels = array(
				'name'              => _x( 'Tour Facilities', 'taxonomy general name', 'citytours' ),
				'singular_name'     => _x( 'Tour Facility', 'taxonomy singular name', 'citytours' ),
				'menu_name'         => __( 'Tour Facilities', 'citytours' ),
				'all_items'         => __( 'All Tour Facilities', 'citytours' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'new_item_name'     => __( 'New Tour Facility', 'citytours' ),
				'add_new_item'      => __( 'Add New Tour Facility', 'citytours' ),
				'edit_item'         => __( 'Edit Tour Facility', 'citytours' ),
				'update_item'       => __( 'Update Tour Facility', 'citytours' ),
				'separate_items_with_commas' => __( 'Separate tour facilities with commas', 'citytours' ),
				'search_items'      => __( 'Search Tour Facilities', 'citytours' ),
				'add_or_remove_items'        => __( 'Add or remove tour facilities', 'citytours' ),
				'choose_from_most_used'      => __( 'Choose from the most used tour facilities', 'citytours' ),
				'not_found'                  => __( 'No tour facilities found.', 'citytours' ),
			);
		$args = array(
				'labels'            => $labels,
				'hierarchical'      => false,
				'show_ui'           => true,
				'show_admin_column' => true,
				'meta_box_cb'       => false
			);
		register_taxonomy( 'tour_facility', array( 'tour' ), $args );
	}
}

/*
 * init custom post_types
 */
if ( ! function_exists( 'ct_init_custom_post_types' ) ) {
	function ct_init_custom_post_types(){
		global $ct_options;
		if ( empty( $ct_options['disable_hotel'] ) ) {
			ct_register_hotel_post_type();
			ct_register_room_type_post_type();
			ct_register_hotel_location_taxonomy();
			ct_register_tour_location_taxonomy();
			ct_register_hotel_facility_taxonomy();
		}

		if ( empty( $ct_options['disable_tour'] ) ) {
			ct_register_tour_post_type();
			ct_register_tour_type_taxonomy();
			ct_register_tour_facility_taxonomy();
		}
	}
}

/*
 * hide Add Hotel Submenu on sidebar
 */
if ( ! function_exists( 'ct_hd_add_hotel_box' ) ) {
	function ct_hd_add_hotel_box() {
		if ( current_user_can( 'manage_options' ) ) {
			global $submenu;
			unset($submenu['edit.php?post_type=hotel'][10]);
		}
	}
}

add_action( 'init', 'ct_init_custom_post_types', 0 );
add_action('admin_menu', 'ct_hd_add_hotel_box');