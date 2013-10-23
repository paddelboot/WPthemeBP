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
 * @TODO:
 * 
 * - Check WordPress version  and php >= 3.5
 * 
 */

// Register autoloader function
spl_autoload_register( 'neu_autoloader' );

function neu_autoloader( $class ) {
	
	if ( is_file( get_template_directory() . '/classes/class-' . $class . '.php' ) )
		include ( get_template_directory() . '/classes/class-' . $class . '.php' );
}

if ( function_exists( 'add_filter' ) ) {
	add_filter( 'after_setup_theme', array( 'neu_setup_theme', 'get_object' ), 1 );
	add_filter( 'after_setup_theme', array( 'neu_core', 'get_object' ), 2 );
	add_filter( 'after_setup_theme', array( 'neu_tpl_func', 'get_object' ), 2 );
}

?>