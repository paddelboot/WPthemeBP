<form id="blog_searchform" action="/" method="get">
    <fieldset>
		<input type="submit" id="neu_searchform_submit_button" value="" />
		<input type="text" placeholder="<?php _e( 'Blog durchsuchen', neu_setup_theme::$_obj->textdomain ); ?>"name="s" id="search" value="<?php the_search_query(); ?>" />
    </fieldset>
</form>