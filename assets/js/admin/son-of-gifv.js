( function ( $ ) {

	var Son_of_GIFV = {

		init: function() {
			this.bindEvents();
		},

		bindEvents: function() {
			var fields = $( '.son-of-gifv-form-fields' );
			if ( fields.length === 0 ) {
				return;
			}

			fields.on( 'click', '.son-of-gifv-convert', _.bind( this.convertToGIFV, this ) );
		},

		convertToGIFV: function( e ) {
			e.preventDefault;

			// Turn on the spinner and hide this link.
			var link = $( e.target );
			link.addClass( 'hidden' ).parent().find( '.spinner' ).addClass( 'is-active' );


			// Convert this to GIFV.
			$.post( Son_of_GIFV_Admin.rest_api_url.convert, { attachment_id:link.data( 'id' ) }, function( results ) {

				if ( '' === results['error'] && '' !== results['html'] ) {
					link.parent().replaceWith( results['html'] );
				}

			} );

		}

	};

	$( document ).ready( function () {
		Son_of_GIFV.init();	
	})

} ) ( jQuery );