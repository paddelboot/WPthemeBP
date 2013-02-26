/**
 * neu WordPress Theme
 * 
 * Javascript classes
 * 
 * @version v0.2a;
 * @author Michael Schröder <ms@ts-webdesign.net>
 * 
 * 
 * Changelog
 * 
 * 0.1a
 * - Initial version
 * 
 */

jQuery.noConflict();


( function( $ ) {
	
	sp_js = {
		
		/**
		 * Init JS functions
		 *
		 * @since 0.1a
		 */
		init : function () {
			
			this.leistungen_detail();
			this.blog_single();
			this.blog_popup();
			this.blog_more();
			this.blogarchive();
			this.sliderkit()
			this.scroll();

		},
		
		/**
		 * Display "Leistungen" details
		 *
		 */
		leistungen_detail : function() {
			
			$( '#scroll a.leistungen_detail ' ).click( function() {
				
				var data = {
					action : 'leistungen_detail',
					detail : $( this ).data( 'id' )
				};
			
				// Ajax call
				$.when(
				
					//sp_js.ajax_request( data )
					
					).then( function( response ) { 
								
//					console.log( "RESPONSE AFTER REQUEST: " + response );
//				
//					if ( ! response )
//						return false;

					// Insert response into popup AJAX container
					$( this ).parents( 'section' ).insertAfter( response.html );
						
					return false;
				
				});
				
			});
			
			
		},
		
		/**
		 * Load and display single post
		 * 
		 */
		blog_single : function() {
			
			$( '#blog_wrapper' ).on( 'click', 'a.blog_detail', function() {
				
				var data = {
					action : 'posts_single',
					single : $( this ).data( 'id' )
				};
				
				// Ajax call
				var response = sp_js.ajax_request( data );
				
				if ( ! response )
					return false;
									
				// Insert response into popup AJAX container
				$( '#blog section' ).html( response.html );
				
				return false;
				
			});
			
		},	
		
		/**
		 * Popup for monthly archive thumbnails
		 * 
		 */
		blog_popup : function() {
			
			$( '#blog_wrapper' ).on( 'click', 'a.blog_popup', function() {
				
				// Store clicked element in var
				var clicked = $( this );
				// Store destination ajax container in var
				var ajax_container = clicked.parents( 'article' ).find( '.ajax_blog_popup' );
				
				// Hide all open containers
				$( '.ajax_blog_popup' ).hide();
				
				// Show current container
				ajax_container.show();
				
				// Remove active class from link elements and years
				clicked.parents( 'section' ).find( 'a.blog_popup' ).removeClass( 'active' );
				clicked.parents( 'section' ).find( 'h1' ).removeClass( 'active' );
				
				// Set current link active
				clicked.addClass( 'active' );
				
				// Set current year active
				clicked.parents( 'article' ).find( 'h1' ).addClass( 'active' );
				
				var data = {
					action : 'posts_popup',
					month : $( this ).data( 'month' ),
					year : $( this ).data( 'year' )
				};
				
				// Execute ajax request
				var response = sp_js.ajax_request( data );

				// Insert response into popup AJAX container
				ajax_container.html( response.html );
				
				return false;
				
			});
	
		},
		
		/*
		 * "More news" navigation for 
		 * 
		 */
		blog_more : function() {
			
			$( 'a.blog_more ' ).on( 'click', function() {
				
				var page = $( this ).data( 'page' );
				
				// POST data
				var data = {
					action : 'posts_more',
					cat : 'news',
					page : page
				};
				
				// Ajax call
				var response = sp_js.ajax_request( data );
						
				// Insert response HTML
				$( '#blog section article:last' ).after( response.html );
						
				// Remove "more" link if on last page
				if ( true == response.lastpage )
					$( 'a.blog_more' ).remove();
				else
					$( 'a.blog_more' ).response( 'page', page + 1 );
				
				return false;
			});		
		},
		
		/**
		 * Abstracted ajax call
		 *
		 */
		ajax_request : function( data ) {
			
			$.ajax({ 
				type: 'POST',
				url: neu_vars.ajaxurl, 
				data: data,
				async: true,
				success: function( response ) {
					
					// Do a stripslashes
					var string = $("<textarea/>").html( response ).text();
					// Parse response
					var returndata = JSON.parse( string );

					return returndata;					
				}
			});
			
		},
		
		/**
		 * Show or hide blog archive
		 * 
		 */
		blogarchive : function() {
			
			if ( ! $( '#content.home' ).length )
				return;
			
			$( '#blog_archive header a.close, #blog_archive header a.open' ).click( function() {
				
				if ( $( this ).hasClass( 'open' ) ) {
					
					$( this ).hide();
					$( '#blog_archive header a.close' ).show();
					
					$( '#blog_archive>section' ).css({
						'height' : 0, 
						'overflow' : 'hidden'
					}).show();
				
					$( '#blog_archive>section' ).stop().animate( {
					
						height : 400
					}, 2000 );
				}
				else {
					
					$( this ).hide();
					$( '#blog_archive header a.open' ).show();
					
					$( '#blog_archive>section' ).stop().animate( {
					
						height : 0
					}, 1000 );
					
				}

				return false;
			});
		
		},
		
		/**
		 * Init sliderkit
		 * 
		 */
		sliderkit : function() {
			
			if ( $( '#content.home' ).length || $( '#content.leistungen' ).length || $( '#content.referenzen' ).length ) {
				
				$( '#content .sliderkit' ).sliderkit( {
					shownavitems: 5,
					auto: false,
					circular: true,
					debug: true
				});
			
			}
		},
		
		/**
		 * Scoll content according to anchor
		 * 
		 */
		scroll : function() {
			
			$( 'ul.sp_leistungen_menu li a, ul#digit_nav li a' ).click( function() {
				
				// Geht, geht nicht?!=!=!=!=!==!?!?!?!?!?
				$( this ).parents( 'ul li' ).removeClass( 'current_page_item current-menu-item' );
				$( this ).parent( 'li' ).addClass( 'current_page_item current-menu-item' );

				// Scroll into view
				$( this.hash ).scrollIntoView( 1000 );
				
				return false;
			});			
		}	
	}	
})
( jQuery );

jQuery( document ).ready( function() {
	
	sp_js.init();
	
});