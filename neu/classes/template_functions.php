<?php

/**
 * neu WordPress Theme
 * 
 * Contains template functions of the theme
 * 
 * @version: 0.1a
 * @author: neu.de, Michael Schröder <ms@meilenstein.ms>
 * 
 * Changelog
 *
 * 0.1a
 * - Initial version
 * 
 */
if ( !class_exists( 'neu_tpl_func' ) ) {

	class neu_tpl_func extends neu_setup_theme {

		/**
		 * The class object
		 *
		 * @static
		 * @since  0.1
		 * @var    string
		 */
		static public $_obj = NULL;

		/**
		 * Create class object
		 *
		 * @access public
		 * @return object $class_object;
		 * @since 0.1a
		 */
		public function get_object() {

			if ( NULL == self::$_obj ) {
				self::$_obj = new self;
			}
			return self::$_obj;
		}

		/**
		 * init function to register all used filters
		 * 
		 */
		public function __construct() {
			
		}
	}
}
?>