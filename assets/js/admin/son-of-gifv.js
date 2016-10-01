( function ( $ ) {

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

			// Convert this to GIFV.
			$.post( Son_of_GIFV_Admin.rest_api_url.convert, { attachment_id:link.data( 'id' ) }, function( results ) {

				// Turn off the spinner
				parent.find( '.spinner' ).removeClass( 'is-active' );

				if ( '' !== results['error'] ) {
					// Show the error message if there is one.
					parent.find( '.error-message' ).removeClass( 'hidden' ).text( results['error'] );
					parent.find( '.please-wait' ).addClass( 'hidden' );
				} else if ( '' !== results['html'] ) {
					// Replace this with the successful HTML template
					link.parent().replaceWith( results['html'] );
				}

			} );
		}

	};

	Son_of_GIFV.init();

} ) ( jQuery );