<?php

get_header();


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div id="content" class="page">
	
	<?php
	if( have_posts() ) : the_post();
	the_content();
	endif;
	
	//echo get_query_var( 'footer' );
	?>
	
	Page.php
	
</div>


<?php
get_footer();
?>
