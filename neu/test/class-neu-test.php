<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * @TODO WP-Version
 * 
 */

require_once( 'wp-tests/bootstrap.php' );
require_once( '../functions.php' );

class neu_test extends WP_UnitTestCase {

	function theme_switching() {

		//return 'neu';
	}

	function setUp() {
		parent::setUp();

//		add_filter( 'template', array( $this, 'theme_switching' ) );
//		add_filter( 'stylesheet', array( $this, 'theme_switching' ) );

		switch_theme( 'neu' );
	}

	function testActiveTheme() {

		$this->assertTrue( 'neu' == wp_get_theme() );
	}

	function testCheckTaxonomyTexte() {

		$this->assertTrue( taxonomy_exists( 'texte' ) );
	}

	function testCheckTaxonomyReferenzen() {

		$this->assertTrue( taxonomy_exists( 'referenzen' ) );
	}

	function testCheckTaxonomyLeistungen() {

		$this->assertFalse( taxonomy_exists( 'leistungen' ) );
	}

	function testCheckTextdomain() {

		$this->assertTrue( 'neu' == neu_setup_theme::$_obj->textdomain );
	}

	function testCheckCategory() {

		$this->assertInternalType( 'string', term_exists( 'kundenreferenzen' ) );
	}

	function testCheckMainmenuHeader() {

		global $_wp_registered_nav_menus;

		$this->assertArrayHasKey( 'header_main', $_wp_registered_nav_menus );
	}

	function testCheckMainmenuFooter() {

		global $_wp_registered_nav_menus;

		$this->assertArrayHasKey( 'footer_main', $_wp_registered_nav_menus );
	}

	function testjQueryIsLoaded() {
			
		do_action( 'wp_enqueue_scripts' );
		
		$this->assertTrue( wp_script_is( 'sliderkit' ) );
	}
	
	function testGetReferenzen() {
		
		global $wp_query;
		
		$this->assertInternalType( 'object', neu_tpl_func::$_obj->get_referenzen( $wp_query ) );
	}

// end testjQueryIsLoaded
// end testThemeInitialization
// end setup
}

?>
