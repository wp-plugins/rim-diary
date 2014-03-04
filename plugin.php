<?php
/*
Plugin Name: Tim Hortons Rim Diary
Plugin URI: http://portfolio.planetjon.ca/projects/rim-diary/
Description: Track your Tim Hortons rim rolls and share your winnings with the world.
Version: 1.0.1
Requires at least: 3.5.0
Tested up to: 3.8.1
Author: Jonathan Weatherhead
Author URI: http://jonathanweatherhead.com
Text Domain: rim-diary
Domain Path: /languages/
*/

if( ! rim_diary_meets_requirements() ) {
	add_action( 'admin_notices', 'rim_diary_requirements_notice' );
	return;
}

include_once( plugin_dir_path( __file__ ) . 'core-plugin.php' );

if( is_admin() )
	include_once( plugin_dir_path( __file__ ) . 'admin-plugin.php' );

function rim_diary_requirements_notice() {
	printf( '<div class="error"><p>%s</p></div>', __( 'Tim Hortons Rim Diary requires PHP 5.3 or later to run. Please update your server.', 'rim-diary' ) );
}

function rim_diary_meets_requirements() {
	return true; //version_compare( PHP_VERSION, '5.3.0' ) >= 0;
}

?>