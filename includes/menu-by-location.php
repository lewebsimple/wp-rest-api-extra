<?php

if ( ! defined( 'WPINC' ) ) {
	die;
}

// Register menu_by_location endpoint
add_action( 'rest_api_init', 'wp_rest_api_extra_register_menu_by_location' );
function wp_rest_api_extra_register_menu_by_location() {
	register_rest_route( WP_REST_API_EXTRA_NAMESPACE, '/menu_by_location/(?P<location>[a-zA-Z0-9_-]+)', array(
		'methods'             => WP_REST_Server::READABLE,
		'callback'            => 'wp_rest_api_extra_get_menu_by_location',
		'permission_callback' => '__return_true',
	) );
}

// Callback for menu_by_location
function wp_rest_api_extra_get_menu_by_location( WP_REST_Request $request ) {
	$location  = $request->get_param( 'location' );
	$locations = get_nav_menu_locations();
	if ( ! isset( $locations[ $location ] ) ) {
		return array();
	}

	$wp_menu    = wp_get_nav_menu_object( $locations[ $location ] );
	$menu_items = wp_get_nav_menu_items( $wp_menu->term_id );

	$rev_items = array_reverse( $menu_items );
	$rev_menu  = array();
	$cache     = array();

	foreach ( $rev_items as $item ) {
		$formatted = array(
			'ID'          => abs( $item->ID ),
			'order'       => (int) $item->menu_order,
			'parent'      => abs( $item->menu_item_parent ),
			'title'       => $item->title,
			'url'         => $item->url,
			'attr_title'  => $item->attr_title,
			'target'      => $item->target,
			'classes'     => implode( ' ', $item->classes ),
			'xfn'         => $item->xfn,
			'description' => $item->description,
			'object_id'   => abs( $item->object_id ),
			'object'      => $item->object,
			'type'        => $item->type,
			'type_label'  => $item->type_label,
			'children'    => array(),
		);

		if ( array_key_exists( $item->ID, $cache ) ) {
			$formatted['children'] = array_reverse( $cache[ $item->ID ] );
		}

		if ( $item->menu_item_parent != 0 ) {
			if ( array_key_exists( $item->menu_item_parent, $cache ) ) {
				array_push( $cache[ $item->menu_item_parent ], $formatted );
			} else {
				$cache[ $item->menu_item_parent ] = array( $formatted, );
			}
		} else {
			array_push( $rev_menu, $formatted );
		}

	}

	return array_reverse( $rev_menu );
}
