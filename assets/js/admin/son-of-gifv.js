( function ( $ ) {

	'use strict';

	var Son_of_GIFV = {

		init: function() {
			if ( 'undefined' !== typeof( _ ) ) {
				$( 'body' ).on( 'click', '.son-of-gifv-convert', _.bind( this.convertToGIFV, this ) );
			}
		},

		convertToGIFV: function( e ) {
			e.preventDefault();

			// Turn on the spinner and hide this link.
			var link = $( e.target );
			var parent = link.addClass( 'hidden' ).parent();

			parent.find( '.spinner' ).addClass( 'is-active' );

			// Show the please wait message.
			parent.find( '.please-wait' ).removeClass( 'hidden' );

			var self = this;

			// Convert this to GIFV.
			$.ajax( {
				url: Son_of_GIFV_Admin.rest_api_url.convert,
				method: 'POST',
				beforeSend: function ( xhr ) {
					xhr.setRequestHeader( 'X-WP-Nonce', Son_of_GIFV_Admin.rest_api_nonce );
				},
				data: {
					attachment_id:link.data( 'id' )
				}
			} ).done ( function( results ) {

				// Turn off the spinner
				parent.find( '.spinner' ).removeClass( 'is-active' );

				if ( '' !== results['error'] ) {
					// Show the error message if there is one.
					self.showError( parent, results['error'] );
				} else if ( '' !== results['html'] ) {
					// Replace this with the successful HTML template
					link.parent().replaceWith( results['html'] );
				}

			} ).fail( function( xhr ) {
				// Show the error message.
				var error = xhr.responseText;
				if ( xhr.responseJSON && xhr.responseJSON.message ) {
					error = xhr.responseJSON.message;
				}
				self.showError( parent, error );
			} );
		},

		showError: function( parent, error ) {

			// Turn off the spinner
			parent.find( '.spinner' ).removeClass( 'is-active' );

			// Show the error message if there is one.
			parent.find( '.error-message' ).removeClass( 'hidden' ).text( error );
			parent.find( '.please-wait' ).addClass( 'hidden' );

		}

	};

	Son_of_GIFV.init();

} ) ( jQuery );