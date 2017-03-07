<?php
function get_hotels(){
		$term = trim(strip_tags($_GET['term']));		
		$suggestions=array(); 
		$suggestion = array();
		global $wpdb;
		$posts_table = $wpdb->prefix."posts";
		$post_status = "'publish'";
		$post_type = "('hotel')";			
		$query = "SELECT * FROM $wpdb->posts
		WHERE post_title LIKE '%".$term."%'		
		AND post_type IN $post_type
		AND post_status = $post_status
		GROUP BY ID
		ORDER BY post_date DESC";

		$my_posts=$wpdb->get_results($query);
		if ($my_posts) {
		  foreach($my_posts as $post) {
			setup_postdata($post);	
			$suggestion['value'] = stripslashes($post->post_title);	
			$suggestions['locations']= '';
			$suggestions[]= $suggestion;
			
			}
		} 
		$tex_query = "SELECT trm.name,trm.term_id FROM $wpdb->term_relationships as trs		
		INNER JOIN $wpdb->term_taxonomy as tty ON (trs.term_taxonomy_id = tty.term_taxonomy_id)
		INNER JOIN $wpdb->terms as trm ON (tty.term_id = trm.term_id)
		WHERE trm.name LIKE '%".$term."%'
		AND tty.taxonomy = 'hotel_location'
		GROUP BY trm.name
		ORDER BY trm.name ASC";
		$my_term=$wpdb->get_results($tex_query);
		if ($my_term) {
		  foreach($my_term as $terms) {			
			$suggestion['value'] = stripslashes($terms->name);	
			$suggestion['locations'] = $terms->term_id;
			$suggestions[]= $suggestion;			
			}
		}
		if(empty($my_term) && empty($my_posts)){
			$suggestion['value'] = htmlentities(stripslashes('No Item'));
			$suggestions['locations']= '';
			$suggestions[]= $suggestion;
		}
		$response = json_encode($suggestions);
		echo $response;    
    exit;
}

add_action( 'wp_ajax_get_hotels', 'get_hotels' );
add_action( 'wp_ajax_nopriv_get_hotels', 'get_hotels' );

function get_tours(){
		$term = trim(strip_tags($_GET['term']));		
		$suggestions=array(); 
		$suggestion = array();
		global $wpdb;
		$posts_table = $wpdb->prefix."posts";
		$post_status = "'publish'";
		$post_type = "('tour')";			
		$query = "SELECT * FROM $wpdb->posts
		WHERE post_title LIKE '%".$term."%'		
		AND post_type IN $post_type
		AND post_status = $post_status
		GROUP BY ID
		ORDER BY post_date DESC";

		$my_posts=$wpdb->get_results($query);
		if ($my_posts) {
		  foreach($my_posts as $post) {
			setup_postdata($post);	
			$suggestion['value'] = stripslashes($post->post_title);	
			$suggestions['locations']= '';
			$suggestions[]= $suggestion;			
			}
		} 
		$tex_query = "SELECT trm.name,trm.term_id FROM $wpdb->term_relationships as trs		
		INNER JOIN $wpdb->term_taxonomy as tty ON (trs.term_taxonomy_id = tty.term_taxonomy_id)
		INNER JOIN $wpdb->terms as trm ON (tty.term_id = trm.term_id)
		WHERE trm.name LIKE '%".$term."%'
		AND tty.taxonomy = 'tour_location'
		GROUP BY trm.name
		ORDER BY trm.name ASC";
		$my_term=$wpdb->get_results($tex_query);
		if ($my_term) {
		  foreach($my_term as $terms) {			
			$suggestion['value'] = stripslashes($terms->name);	
			$suggestion['locations'] = $terms->term_id;
			$suggestions[]= $suggestion;			
			}
		}
		if(empty($my_term) && empty($my_posts)){
			$suggestion['value'] = htmlentities(stripslashes('No Item'));
			$suggestions['locations']= '';
			$suggestions[]= $suggestion;
		}
		$response = json_encode($suggestions);
		echo $response;    
    exit;
}

add_action( 'wp_ajax_get_tours', 'get_tours' );
add_action( 'wp_ajax_nopriv_get_tours', 'get_tours' );


function sendNameMobile(){
	$nonce = $_REQUEST['security'];
	if ( ! wp_verify_nonce( $nonce, 'phone-send-nonce' ) ) {
		$results = array('success'=>false,'meg'=>'This unsecure data!');
		$response = json_encode($results);
		echo $response;
		exit;
	} else {
		$getFullName = $_POST['full_name'];
		$getPhone = $_POST['phone_no'];
		$inquiry = $_POST['inquiry'];
		require get_stylesheet_directory().'/phone-send-email.php';
		$results = array('success'=>true, 'meg'=> 'Successfully send you mobile number!');
		$response = json_encode($results);
		echo $response;
		exit;
	}	
}

add_action( 'wp_ajax_sendNameMobile', 'sendNameMobile' );
add_action( 'wp_ajax_nopriv_sendNameMobile', 'sendNameMobile' );

function trunck_string($str = "", $len = 150, $more = 'true') {
    if ($str == "") return $str;
    if (is_array($str)) return $str;
    $str = strip_tags($str);	
    $str = trim($str);
    // if it's les than the size given, then return it
    if (strlen($str) <= $len) return $str;
    // else get that size of text
    $str = substr($str, 0, $len);
    // backtrack to the end of a word
    if ($str != "") {
      // check to see if there are any spaces left
      if (!substr_count($str , " ")) {
        if ($more == 'true') $str .= "...";
        return $str;
      }
      // backtrack
      while(strlen($str) && ($str[strlen($str)-1] != " ")) {
        $str = substr($str, 0, -1);
      }
      $str = substr($str, 0, -1);
      if ($more == 'true') $str .= "...";
      if ($more != 'true' and $more != 'false') $str .= $more;
    }
    return $str;
}

$labels = array(
		'name'              => _x( 'Hotel Amenities', 'taxonomy general name', 'citytours' ),
		'singular_name'     => _x( 'Hotel Amenity', 'taxonomy singular name', 'citytours' ),
		'menu_name'         => __( 'Hotel Amenities', 'citytours' ),
		'all_items'         => __( 'All Hotel Amenities', 'citytours' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'new_item_name'     => __( 'New Hotel Amenity', 'citytours' ),
		'add_new_item'      => __( 'Add New Hotel Amenity', 'citytours' ),
		'edit_item'         => __( 'Edit Hotel Amenity', 'citytours' ),
		'update_item'       => __( 'Update Hotel Amenity', 'citytours' ),
		'separate_items_with_commas' => __( 'Separate hotel amenities with commas', 'citytours' ),
		'search_items'      => __( 'Search Hotel Amenities', 'citytours' ),
		'add_or_remove_items'        => __( 'Add or remove hotel amenities', 'citytours' ),
		'choose_from_most_used'      => __( 'Choose from the most used hotel amenities', 'citytours' ),
		'not_found'                  => __( 'No hotel amenities found.', 'citytours' ),
	);
	$args = array(
		'labels'            => $labels,
		'hierarchical'      => false,
		'show_ui'           => true,
		'show_admin_column' => true,
		'meta_box_cb'       => false
	);
register_taxonomy( 'hotel_amenity', array( 'hotel' ), $args );

add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
     // 'manage_options' is a capability assigned only to administrators
     if (!current_user_can('manage_options') && !is_admin()) {
         show_admin_bar(false);
     }
}

//add this within functions.php
function ajax_login_init(){

    wp_register_script('ajax-login-script', get_stylesheet_directory_uri() . '/js/ajax-login-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-login-script');

    wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => home_url('/profile/'),
        'loadingmessage' => __('Sending user info, please wait...')
    ));

    // Enable the user with no privileges to run ajax_login() in AJAX
    add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
}

// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
    add_action('init', 'ajax_login_init');
}


function ajax_login(){

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = true;

    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...')));
    }

    die();
} 
 
function ajax_forgotPassword(){
	 
	// First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-forgot-nonce', 'security' );
	
	global $wpdb;
	
	$account = $_POST['user_login'];
	
	if( empty( $account ) ) {
		$error = 'Enter an username or e-mail address.';
	} else {
		if(is_email( $account )) {
			if( email_exists($account) ) 
				$get_by = 'email';
			else	
				$error = 'There is no user registered with that email address.';			
		}
		else if (validate_username( $account )) {
			if( username_exists($account) ) 
				$get_by = 'login';
			else	
				$error = 'There is no user registered with that username.';				
		}
		else
			$error = 'Invalid username or e-mail address.';		
	}	
	
	if(empty ($error)) {
		// lets generate our new password
		//$random_password = wp_generate_password( 12, false );
		$random_password = wp_generate_password();
 
			
		// Get user data by field and data, fields are id, slug, email and login
		$user = get_user_by( $get_by, $account );
			
		$update_user = wp_update_user( array ( 'ID' => $user->ID, 'user_pass' => $random_password ) );
			
		// if  update user return true then lets send user an email containing the new password
		if( $update_user ) {
			
			$from = 'WRITE SENDER EMAIL ADDRESS HERE'; // Set whatever you want like mail@yourdomain.com
			
			if(!(isset($from) && is_email($from))) {		
			
			require get_stylesheet_directory().'/PHPMailer-master/PHPMailerAutoload.php';
			$mail = new PHPMailer;
			$mail->IsSMTP();                                      // Set mailer to use SMTP
			$mail->Host = 'smtp.mandrillapp.com';                 // Specify main and backup server
			$mail->Port = 587;                                    // Set the SMTP port
			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			$mail->Username = 'bdsmartapp';                // SMTP username
			$mail->Password = 'YOwWTn3LtJdJcP1o-rShYQ';                  // SMTP password
			$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

			$mail->From = 'sales@ghuri.online';
			$mail->FromName = 'Ghuri Sales';
			$mail->AddAddress($user->user_email, 'bdsmartapp');  // Add a recipient			

			$mail->IsHTML(true);                                  // Set email format to HTML

			$mail->Subject = 'Your new password';
			$mail->Body    = 'Your new password is: '.$random_password;
			$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			if(!$mail->Send()) {
			   $error = 'System is unable to send you mail containg your new password.';	
			} else {
				$success = 'Check your email address for you new password.';
			}
			}				
		} else {
			$error = 'Oops! Something went wrong while updaing your account.';
		}
	}
	
	if( ! empty( $error ) )
		echo json_encode(array('loggedin'=>false, 'message'=>__($error)));
			
	if( ! empty( $success ) )
		echo json_encode(array('loggedin'=>false, 'message'=>__($success)));
				
	die();
}
add_action( 'wp_ajax_nopriv_ajaxforgotpassword', 'ajax_forgotPassword' );

function query_set_only_author( $wp_query ) {
    global $current_user;
	$current_userRole = $current_user->roles[0];
	if(empty($current_userRole)) $current_userRole = $current_user->roles[1];
    if ( is_admin() && $current_userRole == 'hoteluser' || is_admin() && $current_userRole == 'touruser') {
        $wp_query->set( 'author', $current_user->ID );
    }
}
add_action('pre_get_posts', 'query_set_only_author' );

add_action( 'init', 'ghuri_services' );
function ghuri_services() {

	$labels = array(
		'name'               => _x( 'Services', 'post type general name' ),
		'singular_name'      => _x( 'Services', 'post type singular name' ),
		'menu_name'          => _x( 'Services', 'admin menu' ),
		'name_admin_bar'     => _x( 'Services', 'add new on admin bar' ),
		'add_new'            => _x( 'Add New', 'ghuri-services' ),
		'add_new_item'       => __( 'Add New Services' ),
		'new_item'           => __( 'New Services' ),
		'edit_item'          => __( 'Edit Services' ),
		'view_item'          => __( 'View Services' ),
		'all_items'          => __( 'All Services' ),
		'search_items'       => __( 'Search Services' ),
		'parent_item_colon'  => __( 'Parent Services:' ),
		'not_found'          => __( 'No Services found.' ),
		'not_found_in_trash' => __( 'No Services found in Trash.' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'ghuri-services'),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => 5,
		'supports'           => array( 'title', 'editor', 'comments', 'trackbacks', 'author', 'excerpt', 'custom-fields', 'thumbnail' )
	);
	register_post_type( 'ghuri-services', $args );
	
}

add_action( 'init', 'ghuri_news' );
function ghuri_news() {

	$labels = array(
		'name'               => _x( 'News', 'post type general name' ),
		'singular_name'      => _x( 'News', 'post type singular name' ),
		'menu_name'          => _x( 'News', 'admin menu' ),
		'name_admin_bar'     => _x( 'News', 'add new on admin bar' ),
		'add_new'            => _x( 'Add New', 'ghuri-news' ),
		'add_new_item'       => __( 'Add New News' ),
		'new_item'           => __( 'New News' ),
		'edit_item'          => __( 'Edit News' ),
		'view_item'          => __( 'View News' ),
		'all_items'          => __( 'All News' ),
		'search_items'       => __( 'Search News' ),
		'parent_item_colon'  => __( 'Parent News:' ),
		'not_found'          => __( 'No News found.' ),
		'not_found_in_trash' => __( 'No News found in Trash.' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'ghuri-news'),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => 6,
		'supports'           => array( 'title', 'editor', 'comments', 'trackbacks', 'author', 'excerpt', 'custom-fields', 'thumbnail' )
	);
	register_post_type( 'ghuri-news', $args );
	
}

add_action( 'init', 'ghuri_cars' );
function ghuri_cars() {

	$labels = array(
		'name'               => _x( 'Cars', 'post type general name' ),
		'singular_name'      => _x( 'Cars', 'post type singular name' ),
		'menu_name'          => _x( 'Cars', 'admin menu' ),
		'name_admin_bar'     => _x( 'Cars', 'add new on admin bar' ),
		'add_new'            => _x( 'Add New', 'cars' ),
		'add_new_item'       => __( 'Add New Cars' ),
		'new_item'           => __( 'New Cars' ),
		'edit_item'          => __( 'Edit Cars' ),
		'view_item'          => __( 'View Cars' ),
		'all_items'          => __( 'All Cars' ),
		'search_items'       => __( 'Search Cars' ),
		'parent_item_colon'  => __( 'Parent Cars:' ),
		'not_found'          => __( 'No Cars found.' ),
		'not_found_in_trash' => __( 'No Cars found in Trash.' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'cars'),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => 30,
		'supports'           => array( 'title', 'editor', 'comments', 'trackbacks', 'author', 'excerpt', 'custom-fields', 'thumbnail' )
	);
	register_post_type( 'cars', $args );
	
}

function ghuri_widgets_init() {
	
	register_sidebar( array(
		'name' => __( 'Language' ),
		'id' => 'header_language',
		'description' => __( 'header language' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );
}
add_action( 'widgets_init', 'ghuri_widgets_init' );