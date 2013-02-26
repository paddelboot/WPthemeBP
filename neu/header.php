<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage pro-wordpress
 * @since Pro WordPress 0.1a
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
	<!--<![endif]-->
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width" />
		<title><?php wp_title( '|', true, 'right' ); ?></title>
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
		<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
		<!--[if lt IE 9]>
		<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
		<![endif]-->
		<link href='<?php echo get_template_directory_uri(); ?>/style.css' rel='stylesheet' type='text/css'>
		<?php wp_head(); ?>
	</head>

	<body <?php body_class(); ?>>

		<div id="container">

			<header class="clearfix">

				<?php
				$header = get_query_var( 'header' );

				if ( $header ) {
					?>
					<section class="top clearfix">
						<div class="container dynamic clearfix">
							<?php
							get_template_part( 'header', 'content-dynamic' );
							?>
						</div>
					</section>
					<?php
				}
				?>

				<section class="middle">

					<nav>
						<?php
						wp_nav_menu( array( 'theme_location' => 'header_main', 'menu_class' => 'sp_main_menu' ) );
						?>
					</nav>

				</section>

				<section class="bottom">

					<div class="container">

						<div id="sub-header"  class="clearfix">

							<div id="logo">
								<a href="<?php echo home_url(); ?>" title="neu Startseite">
									<img src="<?php echo get_template_directory_uri(); ?>/images/neu-logo.png" alt="neu.de">
								</a>
							</div>

							<div id="sub-menu">
								<a href="#blog-anchor">
									<img src="<?php echo get_template_directory_uri(); ?>/images/news.png" alt="<?php _e( 'News', neu_setup_theme::$_obj->textdomain ); ?>">
								</a>
								<a href="/header/kontakt">
									<img src="<?php echo get_template_directory_uri(); ?>/images/kontakt.png" alt="<?php _e( 'Kontakt', neu_setup_theme::$_obj->textdomain ); ?>">
								</a>
								<a href="/header/login">
									<img src="<?php echo get_template_directory_uri(); ?>/images/login.png" alt="<?php _e( 'Anmelden', neu_setup_theme::$_obj->textdomain ); ?>">
								</a>
								<a href="/header/socialfeed">
									<img src="<?php echo get_template_directory_uri(); ?>/images/social.png" alt="<?php _e( 'Aufklappen', neu_setup_theme::$_obj->textdomain ); ?>">
								</a>
							</div>

						</div>

					</div>

				</section>

			</header>
