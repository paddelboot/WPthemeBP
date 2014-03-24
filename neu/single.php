<?php

get_header();


/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<div id="content" class="single">
	
	<?php
	if( have_posts() ) : the_post();
	the_content();
	endif;
	?>
	
	single.php
	
</div>


<?php
get_footer();
?>
