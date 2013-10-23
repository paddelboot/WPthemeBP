/**
 * neu WordPress Theme
 * 
 * Javascript class
 * 
 * @version v0.1a;
 * @author Michael Schröder <ms@meilenstein.ms>
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
		 * Do an ajax call
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