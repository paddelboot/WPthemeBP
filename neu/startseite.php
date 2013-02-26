<?php
/**
 * neu WordPress Theme
 * 
 * Frontpage file
 * 
 * Template Name: Startseite
 * 
 * @version 0.1a
 * @author Michael Schröder <ms@ts-webdesign.net>
 * 
 * @changelog:
 * 0.1a
 * - Initital Version
 * 
 */
get_header();
?>

<div id="content" class="page home clearfix">
	
	<?php
	
	// Clone original post object
	$orig_post = clone $post;
	
	// Get slider. We can't rely on global $post since
	// this might be a redirect from a single or date view,
	// which is all handled on the front page
	neu_theme::$_obj->slider( get_page_by_path( 'startseite', OBJECT, 'page' ) );
	
	// Get "Leistungen" - teaser
	get_template_part( 'content', 'teaser' );
		
	// Get page textbox
	get_template_part( 'content', 'textbox' );
	
	// Get blog archive
	get_template_part( 'content', 'blog' );
	
	// Revert post object
	$post = clone $orig_post;
	?>

</div>

<?php
get_footer();
?>

