<?php
/**
 * neu WordPress Theme
 * 
 * Frontpage file
 * 
 * Template Name: Startseite
 * 
 * @version 0.1a
 * @author Michael Schröder <ms@meilenstein.ms>
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
	
	// Revert post object
	$post = clone $orig_post;
	?>

</div>

<?php
get_footer();
?>

