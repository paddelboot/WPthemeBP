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
	
	neu_js = {
		
		/**
		 * Init JS functions
		 *
		 * @since 0.1a
		 */
		init : function () {
			
			this.action();

		},
		
		/**
		 * Display "Leistungen" details
		 *
		 */
		action : function() {
			
			$( '#action_trigger' ).click( function() {
				
				var data = {
					action : 'action_function',
					detail : $( this ).data( 'id' )
				};
			
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
				
			});		
		}	
	}	
})
( jQuery );

jQuery( document ).ready( function() {
	
	neu_js.init();
	
});