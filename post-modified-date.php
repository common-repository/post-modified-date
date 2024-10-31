<?php
/**
 * Plugin Name: WP Last Updated Date
 * Plugin URI:  http://jeweltheme.com/
 * Description: Post Updated or Modified date for Blog Posts. Will show only those Posts are Modified or Updated
 * Version:     1.0.4
 * Author:      Jewel Theme
 * Author URI:  https://jeweltheme.com
 * Text Domain: post-modified-date
 * Domain Path: languages/
 * License:     GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package post-modified-date
 */

/*
 * don't call the file directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	wp_die( esc_html__( 'You can\'t access this page', 'post-modified-date' ) );
}

$jltpmd_plugin_data = get_file_data(
	__FILE__,
	array(
		'Version'     => 'Version',
		'Plugin Name' => 'Plugin Name',
		'Author'      => 'Author',
		'Description' => 'Description',
		'Plugin URI'  => 'Plugin URI',
	),
	false
);

// Define Constants.
if ( ! defined( 'JLTPMD' ) ) {
	define( 'JLTPMD', $jltpmd_plugin_data['Plugin Name'] );
}

if ( ! defined( 'JLTPMD_VER' ) ) {
	define( 'JLTPMD_VER', $jltpmd_plugin_data['Version'] );
}

if ( ! defined( 'JLTPMD_AUTHOR' ) ) {
	define( 'JLTPMD_AUTHOR', $jltpmd_plugin_data['Author'] );
}

if ( ! defined( 'JLTPMD_DESC' ) ) {
	define( 'JLTPMD_DESC', $jltpmd_plugin_data['Author'] );
}

if ( ! defined( 'JLTPMD_URI' ) ) {
	define( 'JLTPMD_URI', $jltpmd_plugin_data['Plugin URI'] );
}

if ( ! defined( 'JLTPMD_DIR' ) ) {
	define( 'JLTPMD_DIR', __DIR__ );
}

if ( ! defined( 'JLTPMD_FILE' ) ) {
	define( 'JLTPMD_FILE', __FILE__ );
}

if ( ! defined( 'JLTPMD_SLUG' ) ) {
	define( 'JLTPMD_SLUG', dirname( plugin_basename( __FILE__ ) ) );
}

if ( ! defined( 'JLTPMD_BASE' ) ) {
	define( 'JLTPMD_BASE', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'JLTPMD_PATH' ) ) {
	define( 'JLTPMD_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}

if ( ! defined( 'JLTPMD_URL' ) ) {
	define( 'JLTPMD_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );
}

if ( ! defined( 'JLTPMD_INC' ) ) {
	define( 'JLTPMD_INC', JLTPMD_PATH . '/Inc/' );
}

if ( ! defined( 'JLTPMD_LIBS' ) ) {
	define( 'JLTPMD_LIBS', JLTPMD_PATH . 'Libs' );
}

if ( ! defined( 'JLTPMD_ASSETS' ) ) {
	define( 'JLTPMD_ASSETS', JLTPMD_URL . 'assets/' );
}

if ( ! defined( 'JLTPMD_IMAGES' ) ) {
	define( 'JLTPMD_IMAGES', JLTPMD_ASSETS . 'images' );
}

if ( ! class_exists( '\\JLTPMD\\JLT_PMD' ) ) {
	// Autoload Files.
	include_once JLTPMD_DIR . '/vendor/autoload.php';
	// Instantiate JLT_PMD Class.
	include_once JLTPMD_DIR . '/class-post-modified-date.php';
}