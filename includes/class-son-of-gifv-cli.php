<?php

if ( ! class_exists( 'Son_of_GIFV_CLI' ) ) {

	/**
	 * GIF to GIFV Converter
	 */
	class Son_of_GIFV_CLI extends WP_CLI_Command {

		/**
		 * Converts a GIF to a GIFV
		 *
		 * ## OPTIONS
		 *
		 * <id>
		 * : The attachment ID to convert.  Must be an animated GIF.
		 *
		 * @synopsis <id>
		 */
		public function convert( $args, $assoc_args ) {

			$results = Son_of_GIFV_Converter::gif_to_gifv( $args[0] );

			var_dump( $results );

			if ( ! empty( $results['error'] ) ) {
				WP_CLI::Error( $results['error'] );
			}

		}


	}

}

WP_CLI::add_command( 'gifv', 'Son_of_GIFV_CLI' );


function son_of_gifv_imgr_upload() {

	$local_file = dirname( __FILE__ ). '/giddy.gif'; //path to a local file on your server

	$encoded_file = base64_encode(file_get_contents($local_file));


	$post_fields = array (

	);

	$response = wp_remote_post( 'https://api.imgur.com/3/image',
	 array(
	 	'headers'    => array( 'Authorization' => 'Client-ID d36e23f2ed35b96' ),
		'body'       => array( 'image' => $encoded_file ),
	 )
	);

	var_dump( $response );

}

// WP_CLI::add_command( 'gifv upload', 'son_of_gifv_imgr_upload' );
