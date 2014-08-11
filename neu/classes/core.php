<?php
/**
 * neu WordPress theme core class
 * 
 * Contains all the core functionality of the theme
 * 
 * @version: 0.1a
 * @author: neu.de, Michael Schröder <ms@meilenstein.ms>>
 * 
 * Changelog
 *
 * 0.1a
 * - Initial version
 * 
 * 
 */
if ( !class_exists( 'neu_core' ) ) {

    class neu_core {

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
         * @uses	add_filter, get_site_option, add_core_support, wp_register_core_activation_hook, wp_register_core_deactivation_hook
         * @return  void
         * @since   0.1a
         */
        function __construct() {

            //add_filter( 'the_content', array( $this, 'insert_column' ) );
            add_filter( 'init', array( $this, 'register_shortcodes' ) );

            add_filter( 'template_include', array( $this, 'template_include' ) );

            add_filter( 'wp_ajax_posts_more', array( $this, 'ajax_posts_more' ) );
            add_filter( 'wp_ajax_nopriv_posts_more', array( $this, 'ajax_posts_more' ) );

	            add_filter( 'nav_menu_css_class', array( $this, 'class_nav_menu_items' ), 10, 2 );
        }

        /**
         * Make sure menu items are highlighted
         * on post type single views
         * 
         * @param array $classes | Classes applied to current nav item
         * @param WP_Post object $item | current nav item
         * @return array $classes | Classes applied to current nav item
         */
        public function class_nav_menu_items( $classes, $item ) {

            // Leistungen parent page
            $highlight = FALSE;

            // Referenzen header menu, highlighting for page "Referenzen"

            if ( home_url( '/atelier-uebersicht/' ) == $item->url && __( 'Atelier', jschumacher_setup_theme::$obj->textdomain ) == $item->title && 'atelier' == get_post_type() )
                $highlight = TRUE;

            if ( home_url( '/schmuck-uebersicht/' ) == $item->url && __( 'Schmuck', jschumacher_setup_theme::$obj->textdomain ) == $item->title && 'schmuck' == get_post_type() )
                $highlight = TRUE;

            if ( home_url( '/uhr-uebersicht/' ) == $item->url && __( 'Uhren', jschumacher_setup_theme::$obj->textdomain ) == $item->title && 'uhr' == get_post_type() )
                $highlight = TRUE;

            if ( home_url( '/trauring-uebersicht/' ) == $item->url && __( 'Trauringe', jschumacher_setup_theme::$obj->textdomain ) == $item->title && 'trauring' == get_post_type() )
                $highlight = TRUE;

            if ( TRUE == $highlight ) {
                $classes[ ] = 'current-menu-item';
                $classes[ ] = 'current_page_item';
            }

            return $classes;
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
         * Image slider 
         * 
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
            <div class="flexslider">

                <ul class="slides">
                    <?php
                    foreach ( $attachments as $attachment ) :
                        ?>

                        <li><a title="<?php echo $attachment->post_name; ?>" href="#"></a></li>
                        <?php
                    endforeach;
                    ?>
                </ul>

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

           extract( shortcode_atts( array(
                'weite' => '48',
                'pos' => 'links',
                'padding' => '',
                'einzug' => '2',
                'klasse' => ''
                            ), $atts ) );

            // Column types
            if ( 'links' == $pos ) {

                $float = 'left';
                $padding = 'padding-right: ' . $einzug . '%';
            }
            if ( 'mitte' == $pos ) {

                $float = 'left';
                $padding = 'padding: 0 ' . $einzug . '%';
            }
            if ( 'rechts' == $pos ) {

                $float = 'right';
                $padding = 'padding-left: ' . $einzug . '%';
            }

            // This is not supposed to be self-enclosing
            if ( NULL !== $content ) {

                return '<div class="column float' . $float . ' justify box_content ' . $klasse . '" style="width: ' . $weite . '%; ' . $padding . '">' . apply_filters( 'the_content', $content ) . '</div>';
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

        /**
         * Debug function
         * 
         * @param type $array
         * @param type $text
         */
        public static function p( $array, $text = FALSE ) {

            echo "<span style='color:black;'><b>{$text}</b></span>" . "<pre style='background: lightgrey; color: black;'>" . print_r( $array, TRUE ) . "</pre>";
        }

    }

}

// Helper functions
if ( !function_exists( 'p' ) ) {

    function p( $array, $text = FALSE ) {

        return neu_core::p( $array, $text );
    }

}

if ( !function_exists( 'init_var' ) ) {

    function init_var( $var, $index, $default = FALSE, $override_set_empty = FALSE ) {

        return neu_core::init_var( $var, $index, $default, $override_set_empty );
    }

}
