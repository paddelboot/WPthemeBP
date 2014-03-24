<?php
/**
 * neu Wordpress Theme
 * 
 * Contains all the AJAX call distribution
 * 
 * @version: 0.3a
 * @author: Michael Schröder <ms@meilenstein.ms>
 * 
 * Changelog
 *
 * 0.1a
 * - Initial version
 * 
 */
if ( !class_exists( 'neu_ajax' ) ) {

	class neu_ajax {

		/**
		 * The class object
		 *
		 * @static
		 * @since  0.1
		 * @var    string
		 */
		static public $obj = NULL;

		/**
		 * Create class object
		 *
		 * @access public
		 * @return object $class_object;
		 * @since 0.1a
		 */
		public function get_object() {

			if ( NULL == self::$obj ) {
				self::$obj = new self;
			}
			return self::$obj;
		}

		/**
		 * Class constructor
		 * 
		 */
		public function __construct() {

			add_filter( 'wp_ajax_object_add', array( $this, 'object_add' ) );
			add_filter( 'wp_ajax_nopriv_object_add', array( $this, 'object_add' ) );

		}

		/**
		 * Add item to object
		 * 
		 */
		public function object_add() {

			neu_object::$obj->add( $_POST );
		}

	}

}

