<?php
/**
 * Geier Völlger Architekten WordPress Theme
 * 
 * Contains all the additional functions of the theme
 * 
 * @version: 0.1a
 * @author: neu.de, Michael Schröder <ms@ts-webdesign.net>
 * 
 * Changelog
 *
 * 0.1a
 * - Initial version
 * 
 * 
 */
if ( !class_exists( 'neu_theme' ) ) {

	class neu_theme {

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

			//add_filter( 'the_content', array( $this, 'insert_column' ) );
			add_filter( 'init', array( $this, 'register_shortcodes' ) );

			add_filter( 'template_include', array( $this, 'template_include' ) );

			add_filter( 'wp_ajax_posts_more', array( $this, 'ajax_posts_more' ) );
			add_filter( 'wp_ajax_nopriv_posts_more', array( $this, 'ajax_posts_more' ) );

		}


		/**
		 * Load additonal news for blog
		 * 
		 */
		public function ajax_posts_more() {

			$paged = intval( init_var( $_POST, 'page' ) );
			$json = array( );

			$args = array(
				'post_type' => 'post',
				'posts_per_page' => 3,
				'category_name' => 'news',
				'paged' => $paged
			);

			$news = new WP_Query( $args );

			$json[ 'lastpage' ] = ( $paged >= $news->max_num_pages ) ? TRUE : FALSE;

			ob_start();

			while ( $news->have_posts() ) : $news->the_post();
				?>

				<article class="clearfix">

					<?php
					if ( has_post_thumbnail() )
						the_post_thumbnail( 'blog-thumbnail' );
					?>

					<time>
						<?php
						echo '<span class="day">' . get_the_date( 'j' ) . '</span>';
						echo '<span class="month">' . get_the_date( 'M' ) . '</span><br>';
						echo '<span class="year">' . get_the_date( 'Y' ) . '</span>';
						?>
					</time>

					<?php
					the_title( '<h2>', '</h2><br>' );

					the_excerpt();
					?>
				</article>

				<?php
			endwhile;

			$posts = ob_get_clean();

			$json[ 'html' ] = $posts;

			echo json_encode( $json );

			exit;
		}

		/**
		 * Include specific templates
		 * 
		 * @global type $wp_query
		 * @param type $template
		 * @return type
		 */
		public function template_include( $template ) {

			return $template;
		}

		/**
		 * Register column shortcode
		 * 
		 */
		public function register_shortcodes() {

			add_shortcode( 'column', array( $this, 'column_shortcode' ) );
		}

		/**
		 * Image slider frontpage
		 * 
		 * @access	public
		 * @uses	sanitize_title, have_posts, the_post, the_title, has_post_thumbnail, the_post_thumbnail, get_the_title, rewind_posts, the_title, the_permalink
		 * @global	object $post
		 * @param	string $cat | Category slug/name
		 * @since	0.3a 
		 */
		public function slider( $post, $size = 'slider-full' ) {

			// Get attachments
			$args = array(
				'post_type' => 'attachment',
				'post_mime_type' => 'image',
				'numberposts' => null,
				'post_status' => null,
				'post_parent' => $post->ID,
				'exclude' => get_post_thumbnail_id( $post->ID ),
				'orderby' => 'menu_order',
				'order' => 'ASC'
			);

			$attachments = get_posts( $args );
			?>
			<!-- Main container -->
			<div class="sliderkit">

				<div class="sliderkit-nav">
					<div class="sliderkit-nav-clip" style="width: 69px; height: 13px;">
						<ul style="width: 70px;">
			<?php
			foreach ( $attachments as $attachment ) :
				?>

								<li><a title="<?php echo $attachment->post_name; ?>" href="#"></a></li>
				<?php
			endforeach;
			?>
						</ul>
					</div>
				</div>

				<!-- Panels container -->
				<div class="sliderkit-panels">  
					<div class="sliderkit-panels-wrapper" style="position: relative;">

						<!-- Panel divs -->
			<?php
			foreach ( $attachments as $attachment ) {
				?>

							<div class="sliderkit-panel">
				<?php
				// Get according size
				$image = wp_get_attachment_image_src( $attachment->ID, $size );

				if ( FALSE == $image )
					$image[ 0 ] = $attachment->guid;
				?>
								<img src="<?php echo $image[ 0 ]; ?>" alt="" title="#htmlcaption_<?php echo $attachment->ID; ?>"/>
							</div>

				<?php
			}
			?>
					</div>
				</div>

			</div>
			<?php
		}

		/**
		 * Register "column" shortcode
		 * 
		 * @param type $atts
		 * @param type $content
		 * @return type
		 */
		public function column_shortcode( $atts, $content = NULL ) {

			p( $atts, "SHORTCODE EXECUTED" );

			extract( shortcode_atts( array(
						'width' => '100'
							), $atts ) );

			// Not self-enclosing
			if ( NULL !== $content ) {

				return '<div style="width: ' . $width . '%; float: left">' . $content . '</div>';
			}
		}

		/**
		 * For not getting annoyed too much by PHP notices. This function should
		 * help to keep the "flow" of the code, i.e. limiting the amount of conditional
		 * statements in HTML blocks, etc.
		 * 
		 * Example use: selected( self::init_var( $var2, $index ), $var )
		 * Instead of: if( !empty( $var2[ $index ] ) ) : selected( $var2[ $index ], $var ); endif;
		 * Example 2: <input type="text" value="<?php echo init_var( $_POST, 'this_field', 'Please fill out this field', TRUE ); ?>" name="this_field"> 
		 * Instead of: urgh, never mind.
		 * 
		 * @access	public
		 * @param	var $var | the variable to check
		 * @param	string $index | the index of the variable
		 * @param	string, boolean $default | what to set the index with if not yet set
		 * @param	bool $override_set_empty | Set var if it is already set, but empty
		 * @return	var $var[ $index ] | the value of $var[ $index ]
		 * @since	0.1a
		 */
		public static function init_var( $var, $index, $default = FALSE, $override_set_empty = FALSE ) {

			// is the $index of $var not yet set or (optional) set but empty?
			if ( !isset( $var[ $index ] ) || ( TRUE == $override_set_empty && empty( $var[ $index ] ) ) )
				$var[ $index ] = ( FALSE === $default ) ? FALSE : $default;

			return $var[ $index ];
		}

	}

}

// Helperfunctions
if ( !function_exists( 'init_var' ) ) {

	function init_var( $var, $index, $default = FALSE, $override_set_empty = FALSE ) {

		return neu_theme::init_var( $var, $index, $default, $override_set_empty );
	}

}