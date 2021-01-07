<?php
/**
 * Plugin Name:       WP REST API extra
 * Plugin URI:        https://github.com/lewebsimple/wp-rest-api-extra/
 * Description:       Provides the WordPress REST API with extra features.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Pascal Martineau
 * Author URI:        https://lewebsimple.ca/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wp-rest-api-extra
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'WP_REST_API_EXTRA_VERSION', '1.0.0' );
define( 'WP_REST_API_EXTRA_NAMESPACE', 'wp-rest-api-extra/v1' );

require plugin_dir_path( __FILE__ ) . 'includes/menu-by-location.php';
