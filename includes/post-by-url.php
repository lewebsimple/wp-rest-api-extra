<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

// Register post-by-url endpoint
add_action( 'rest_api_init', 'wp_rest_api_extra_register_post_by_url' );
function wp_rest_api_extra_register_post_by_url() {
	register_rest_route( WP_REST_API_EXTRA_NAMESPACE, '/post-by-url(?:/(?P<url>.*?))?', array(
		'methods'             => WP_REST_Server::READABLE,
		'callback'            => 'wp_rest_api_extra_get_post_by_url',
		'permission_callback' => '__return_true',
	) );
}

// Callback for post-by-url
function wp_rest_api_extra_get_post_by_url( WP_REST_Request $request ) {
	$post_id    = url_to_postid( get_home_url() . '/' . $request->get_param( 'url' ) );
	$post_type  = get_post_type( $post_id );
	$controller = new WP_REST_Posts_Controller( $post_type );
	$request    = new WP_REST_Request( 'GET', "/wp/v2/{$post_type}s/$post_id" );
	$request->set_url_params( array( 'id' => $post_id ) );

	return $controller->get_item( $request );
}
