<?php
function mild_global_enqueues() {
	wp_enqueue_script(
		'global',
		get_template_directory_uri() . '/js/global.min.js',
		array( 'jquery' ),
		'1.0.0',
		true
	);

	wp_localize_script(
		'global',
		'global',
		array(
			'ajax' => admin_url( 'admin-ajax.php' ),
		)
	);

	wp_enqueue_style( 'awesomeplete-css', get_template_directory_uri() . '/css/awesomplete.css' );
	wp_enqueue_script( 'awesomplete-js', get_template_directory_uri() . '/js/awesomplete.js' );
}
add_action( 'wp_enqueue_scripts', 'mild_global_enqueues' );

function mild_ajax_search() {

	$results = new WP_Query(
		array(
			's' => stripslashes( $_POST['search'] ),
		)
	);

	relevanssi_do_query( $results );

	$items = array();

	if ( ! empty( $results->posts ) ) {
		foreach ( $results->posts as $result ) {
			$items[] = array(
				'label' => $result->post_title,
				'value' => get_permalink( $result->ID ),
			);
		}
	}

	wp_send_json_success( $items );
}
add_action( 'wp_ajax_search_site', 'mild_ajax_search' );
add_action( 'wp_ajax_nopriv_search_site', 'mild_ajax_search' );