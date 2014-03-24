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
if( !class_exists( 'neu_template_functions' ) ) {

    class neu_template_functions extends neu_setup_theme {

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

            if( NULL == self::$_obj ) {
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

        public function slider( $query ) {

            global $wp;
            ?>
            <!-- Main container -->
            <div class="flexslider full clearfix">

                <ul class="slides">

                    <?php
                    while( $query->have_posts() ) : $query->the_post();

                        ?>
                        <li class="parent">

                            <?php

                            $args = array(
                                'post_type' => 'attachment',
                                'post_mime_type' => 'image',
                                'numberposts' => 30,
                                'post_status' => null,
                                'post_parent' => get_the_ID(),
                                'exclude' => get_post_thumbnail_id(),
                                'orderby' => 'menu_order',
                                'order' => 'ASC'
                            );

                            $attachments = get_posts( $args );

                            foreach( $attachments as $attachment ) :

                                // Get image uri
                                $image = wp_get_attachment_image_src( $attachment->ID );

                                if( FALSE == $image )
                                    $image[ 0 ] = $attachment->guid;

                                // Element marked as "active"?    
                                if( trailingslashit( urldecode( init_var( $_GET, 'active' ) ) ) == trailingslashit( get_attachment_link( $attachment->ID ) . 'slide/' . $i ) )
                                    $class = 'active';
                                else
                                    $class = '';
                                ?>

                                <a href="<?php echo get_attachment_link( $attachment->ID ); ?>">

                                    <div class="active_wrapper <?php echo $pattern[ $i ] . ' ' . $class; ?>" title="<?php echo $attachment->post_title; ?>" data-id="<?php echo $attachment->ID; ?>">

                                        <img class="item" src="<?php echo $image[ 0 ]; ?>" alt="<?php echo $attachment->post_title; ?>" title="<?php echo $attachment->post_title; ?>"/>

                                    </div>

                                </a>

                                <?php

                            endforeach;
                            
                            ?>
                        </li>
                        
                        <?php
                        
                    endwhile;
                    ?>

                </ul>

            </div>
            <?php
        }

    }

}
?>