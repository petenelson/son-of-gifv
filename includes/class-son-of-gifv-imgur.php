<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Son_of_GIFV_Imgur' ) ) {

	class Son_of_GIFV_Imgur {

		static public function upload( $filename ) {

			if ( ! file_exists( $filename ) ) {
				return false;
			}

			// Get the file contents and encode them.
			$encoded_file = base64_encode( file_get_contents( $filename ) );

			// Setup the values for the remote post.
			$url       = apply_filters( 'son-of-gifv-imgur-api-url', 'https://api.imgur.com/3/image' );
			$client_id = apply_filters( 'son-of-gifv-imgur-client-id', '99bd99ab0c1e85a' );

			// POST the file to the Imgur API.
			$response = wp_remote_post( $url,
			 array(
			 	'timeout'    => 15,
				'headers'    => array( 'Authorization' => 'Client-ID ' . $client_id ),
				'body'       => array( 'image' => $encoded_file ),
				)
			);

			if ( ! is_wp_error( $response ) ) {

				// Some error responses don't come back as a WP_Error, so
				// we'll handle this here.
				$response_code    = wp_remote_retrieve_response_code( $response );
				$response_message = wp_remote_retrieve_response_message( $response );

				// Make sure we're getting a 200 response back.
				if ( 200 === absint( $response_code ) ) {
					do_action( 'son-of-gifv-imgur-file-uploaded', $filename, $response );
					return json_decode( wp_remote_retrieve_body( $response ) );
				} else {
					// Send back a WP_Error.
					return new WP_Error( '', $response_code . ' ' . $response_message );
				}

			} else {
				return $response;
			}

		}


	}

}
