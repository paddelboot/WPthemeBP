<?php

/**
 * neu WordPress theme setup class
 * 
 * Contains all the functions to initialize the theme
 * 
 * @version: 0.2a
 * @author: neu.de, Michael Schröder <ms@meilenstein.ms>
 * 
 * 
 * 
 * @Changelog
 *
 * 0.1a
 * - Initial version
 * 
 * 
 */
if ( !class_exists( 'neu_setup_theme' ) ) {

	class neu_setup_theme {

		/**
		 * The class object
		 *
		 * @static
		 * @since  0.1
		 * @var    string
		 */
		static public $_obj = NULL;

		/**
		 * Textdomain string
		 * 
		 * @var string
		 */
		public $textdomain;

		/**
		 * Currently logged in user
		 * 
		 * @var object 
		 */
		public $user;

		const debug_IE = FALSE;

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
		 * init function to register all used hooks,
		 * load class files and set parameters
		 * such as the database table 
		 *
		 * @access  public
		 * @uses	add_filter, get_site_option, add_theme_support, wp_register_theme_activation_hook, wp_register_theme_deactivation_hook
		 * @return  void
		 * @since   0.1a
		 */
		function __construct() {

//			add_theme_support( 'post-thumbnails' );
//
//			misc::register_theme_activation_hook( 'neu', array( $this, 'setup_theme' ) );
//			misc::register_theme_deactivation_hook( 'neu', array( $this, 'cancel_theme' ) );
//
//			add_filter( 'query_vars', array( $this, 'query_vars' ) );
//			add_filter( 'init', array( $this, 'set_textdomain' ) );
//			add_filter( 'init', array( $this, 'register_menus' ) );
//			add_filter( 'init', array( $this, 'register_taxonomies' ) );
//			add_filter( 'request', array ( $this, 'query_vars' ) );
//			add_filter( 'init', array( $this, 'register_rewrite_rules' ) );
//			add_filter( 'init', array( $this, 'register_sidebars' ) );
//			add_filter( 'init', array( $this, 'post_type_support' ) );
//
//			add_filter( 'init', array( $this, 'register_cpt' ) );
//			add_filter( 'init', array( $this, 'register_image_size' ) );
//
//			add_filter( 'excerpt_more', array( $this, 'more_link' ) );
//
//			add_filter( 'wp_enqueue_scripts', array( $this, 'frontend_scripts' ) );
//			add_filter( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
//			add_filter( 'show_admin_bar', array( $this, 'hide_admin_bar_from_front_end' ) );
		}

		/**
		 * Setup theme. Update roles capabitites.
		 * 
		 */
		public function setup_theme() {
			
		}

		/**
		 * Upon switch theme.
		 * 
		 */
		public function cancel_theme() {
			
		}

		/**
		 * Add specific post type support
		 * 
		 */
		function post_type_support() {

			add_post_type_support( 'page', 'excerpt' );
		}

		/**
		 * Register rewrite rules
		 * Register rewrite endpoints
		 * 
		 */
		public function register_rewrite_rules() {

			add_rewrite_endpoint( 'footer', EP_ALL );
			
			add_rewrite_rule( 'uebersicht-leistungen/([^/]+)/?(details)?/?$', 'index.php?pagename=uebersicht-leistungen&selected=$matches[1]', 'top' );
		}

		/**
		 * Register theme sidebars
		 */
		public function register_sidebars() {

			$args = array(
				'name' => __( 'News/Blog Sidebar', $this->textdomain ),
				'id' => 'news-sidebar',
				'description' => __( 'Sidebar für den News/Blog - Bereich auf der Startseite', $this->textdomain ),
				'class' => '',
				'before_widget' => '<li id="%1$s" class="widget %2$s">',
				'after_widget' => '</li>',
				'before_title' => '<h2 class="widgettitle">',
				'after_title' => '</h2>'
			);
			
			register_sidebar( $args );
		}

		/**
		 * Load admin scripts
		 * 
		 * UNUSED
		 * 
		 * @access	public
		 * @param	string $hook | current admin page
		 * @return	void | Only load on editor pages
		 * @since	0.7b
		 */
		public function admin_scripts( $hook ) {

			//p( $hook );
			//
			// Load admin css on these pages
			$needed = array(
				'settings_page_cpto-options',
			);

			if ( in_array( $hook, $needed ) )
				wp_enqueue_style( 'neu-admin-css', get_template_directory_uri() . '/css/admin.css' );
		}

		/**
		 * Load backend vars for javascript
		 * 
		 * UNUSED
		 * 
		 * @access	public
		 * @global	object $post
		 * @uses	get_option, wp_max_upload_size, json_encode
		 * @return	array $vars | Encoded array of events and galleries to be used on the client side
		 * @since	0.2a
		 */
		public function load_backend_vars() {

			global $post, $typenow;
		}

		/**
		 * Load frontend scripts
		 * 
		 * @TODO: page specific script loading
		 * 
		 */
		public function frontend_scripts() {

			wp_register_script( 'flexslider', get_template_directory_uri() . '/inc/js/jquery.flexslider-min.js' );
			wp_enqueue_script( 'neu-js', get_template_directory_uri() . '/inc/js/neu.js', array( 'jquery', 'json2', 'flexslider' ) );
			
			wp_enqueue_style( 'flexslider-css', get_template_directory_uri() . '/inc/css/flexslider.css' );

			wp_localize_script( 'neu-js', 'neu_vars', $this->load_frontend_vars() );

			//wp_enqueue_style( 'nivo-css', get_template_directory_uri() . '/css/nivo-slider.css' );
		}

		/**
		 * Load php vars into HEAD
		 * 
		 * @access	public
		 * @global	object $post
		 * @global	obejct $wp | WP object
		 * @uses	admin_url, home_url, json_encode
		 * @return	array $vars | Encoded array of events and galleries to be used on the client side
		 * @since	0.2a
		 */
		public function load_frontend_vars() {

			$vars = array(
				'ajaxurl' => admin_url( 'admin-ajax.php' )
			);

			return $vars;
		}

		/**
		 * Get the Textdomain
		 *
		 * @access	public
		 * @return	string | The plugins' textdomain
		 * @since	0.1a
		 */
		public function set_textdomain() {

			if ( empty( $this->textdomain ) )
				$this->textdomain = 'neu';
		}

		/**
		 * Add custom image sizes
		 * 
		 */
		public function register_image_size() {

			add_image_size( 'slider-full', '960', '500' );
			add_image_size( 'slider-medium', '470', '470' );
		}

		/**
		 * Extend query vars
		 * 
		 * @param	array $qvars | current query vars
		 * @return	array $qvars | extended vars
		 */
		public function query_vars( $qvars ) {

			$added_vars = array(
				'selected'
			);

			foreach ( $added_vars as $var )
				array_push( $qvars, $var );
			
			return $qvars;
		}

		/**
		 * Register nav menus
		 * 
		 * @access	public
		 * @uses	register_nav_menu, get_textdomain
		 * @since	0.1a
		 */
		public function register_menus() {

			$menus = array(
				'header_main' => __( 'Hauptmenü der Kopfzeile', $this->textdomain ),
				'footer_main' => __( 'Hauptmenü der Fußzeile', $this->textdomain )
			);

			register_nav_menus( $menus );
		}

		/**
		 * Register post types
		 * 
		 * @since 0.1a
		 */
		public function register_cpt() {

			// 'Termin' post type
			$labels = array(
				'project' => array(
					'name' => __( 'Projekte', $this->textdomain ),
					'singular_name' => __( 'Projekt', $this->textdomain ),
					'supports' => array(
						'custom-fields',
						'editor'
					) ),
				'misc' => array(
					'name' => __( 'Verschiedenes', $this->textdomain ),
					'singular_name' => __( 'Verschiedenes', $this->textdomain ),
					'supports' => array(
						'custom-fields',
						'editor'
					)
				)
			);

			$supports = array(
				'title',
				'thumbnail',
				'excerpt'
			);

			foreach ( $labels as $cpt => $label ) {

				register_post_type( $cpt, array(
					'register_meta_box_cb' => array( ),
					'labels' => $label,
					'supports' => wp_parse_args( $label[ 'supports' ], $supports ),
					'public' => TRUE,
					'rewrite' => array( 'slug' => sanitize_title_with_dashes( $label[ 'singular_name' ] ) ),
					'has_archive' => TRUE,
					'show_in_nav_menus' => TRUE )
				);
			}
		}

		/**
		 * Register custom taxonomy and add standard terms
		 * 
		 */
		public function register_taxonomies() {

			$labels = array( );

			// Text taxonomy
			register_taxonomy( 'texte', array(
				'post'
					), array(
				'hierarchical' => TRUE,
				'labels' => $labels,
				'label' => __( 'Texte', $this->textdomain ),
				'show_ui' => TRUE,
				'query_var' => 'texte',
				'show_in_nav_menus' => TRUE,
				'rewrite' => array( 'slug' => 'texte' )
			) );

			if ( term_exists( 'a', 'text' ) )
				return;

			// Insert standard terms
			$terms = array( 'a', 'b', 'c' );
			
			foreach ( $terms as $term ) {

				wp_insert_term( $term, 'texte' );
			}
		}

		/**
		 * Modified "more"-link for excerpt
		 * 
		 * @global object $post
		 * @param type $more
		 * @return type
		 */
		function more_link( $more ) {

			global $post;

			return '';
		}

		/**
		 * Hide toolbar in frontend by default
		 * 
		 * @return boolean
		 */
		public function hide_admin_bar_from_front_end( $content ) {

			return ( current_user_can( 'administrator' ) ) ? $content : false;
		}

	}

	//neu_setup_theme::get_object();
}
?>
