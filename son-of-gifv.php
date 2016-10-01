<?php
/**
 * Plugin Name: Son of GIFV
 * Description: GIF to GIFV converter
 * Version:     1.0.0
 * Author:      Pete Nelson pete@petenelson.com
 * Author URI:  https://petenelson.io
 *
 */


if ( ! defined( 'ABSPATH' ) ) {
	die( 'restricted access' );
}

if ( ! defined( 'SON_OF_GIFV_ROOT' ) ) {
	define( 'SON_OF_GIFV_ROOT', trailingslashit( dirname( __FILE__ ) ) );
}

if ( ! defined( 'SON_OF_GIFV_PATH' ) ) {
	define( 'SON_OF_GIFV_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
}

if ( ! defined( 'SON_OF_GIFV_URL_ROOT' ) ) {
	define( 'SON_OF_GIFV_URL_ROOT', trailingslashit( plugins_url( '/', __FILE__ ) ) );
}

// Load plugin files.
require_once SON_OF_GIFV_ROOT . 'includes\class-son-of-gifv-common.php';
require_once SON_OF_GIFV_ROOT . 'includes\class-son-of-gifv-permalinks.php';
require_once SON_OF_GIFV_ROOT . 'includes\class-son-of-gifv-template.php';
require_once SON_OF_GIFV_ROOT . 'includes\class-son-of-gifv-attachment.php';
require_once SON_OF_GIFV_ROOT . 'includes\class-son-of-gifv-converter.php';
require_once SON_OF_GIFV_ROOT . 'includes\class-son-of-gifv-rest-api.php';
require_once SON_OF_GIFV_ROOT . 'includes\class-son-of-gifv-imgur.php';

// Load CLI commands
if ( defined( 'WP_CLI' ) && WP_CLI ) {
	require_once SON_OF_GIFV_ROOT . 'includes\class-son-of-gifv-cli.php';
}

// Initialize plugin code.
Son_of_GIFV_Common::setup();
Son_of_GIFV_Permalinks::setup();
Son_of_GIFV_Template::setup();
Son_of_GIFV_Attachment::setup();
Son_of_GIFV_REST_API::setup();
Son_of_GIFV_Converter::setup();
