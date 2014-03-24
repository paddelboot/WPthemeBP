<?php
/**
 * neu.de WordPress Theme
 * 
 * Class loader
 * 
 * @version: 0.1a
 * @author: Michael Schröder <ms@meilenstein.ms>
 * 
 * Changelog
 *
 * 0.1a
 * - Initial version
 * 
 * 
 */

// check for php 5.3 and WP 3.5
$correct_php_version = version_compare( phpversion(), '5.3', '>=' );
$correct_wp_version = version_compare( get_bloginfo( 'version' ), '3.5', '>=' );

if ( ! $correct_php_version || ! $correct_wp_version && TRUE != WP_TESTS_DOMAIN ) {
    echo "This theme requires <strong>PHP 5.3</strong> or higher and WordPress 3.5 or higher.<br>";
    echo "You are running PHP " . phpversion() . " and WordPress " . get_bloginfo( 'version' );
    exit;
}

// Register autoloader function
spl_autoload_register( 'neu_autoloader' );

function neu_autoloader( $class ) {
    
        $class = str_replace( 'neu_', '', $class );
	
	if ( is_file( get_template_directory() . '/classes/' . $class . '.php' ) )
		include ( get_template_directory() . '/classes/' . $class . '.php' );
}

if ( function_exists( 'add_filter' ) ) {
	add_filter( 'after_setup_theme', array( 'neu_setup_theme', 'get_object' ), 1 );
	add_filter( 'after_setup_theme', array( 'neu_core', 'get_object' ), 2 );
	add_filter( 'after_setup_theme', array( 'neu_template_functions', 'get_object' ), 2 );
}

?>