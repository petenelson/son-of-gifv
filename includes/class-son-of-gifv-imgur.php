<?php

if ( ! class_exists( 'Son_of_GIFV_Imgur' ) ) {

	class Son_of_GIFV_Imgur {

		static public function valid_file_size( $filename ) {
			// TODO
		}

		static public function upload( $filename ) {

			if ( ! file_exists( $filename ) ) {
				return false;
			}

			// TODO 

			// Get the file contents and encode them.
			$encoded_file = base64_encode( file_get_contents( $filename ) );

			// Setup the values for the remote post.
			$url       = apply_filters( 'son-of-gifv-imgur-api-url', 'https://api.imgur.com/3/image' );
			$client_id = apply_filters( 'son-of-gifv-imgur-client-id', 'd36e23f2ed35b96' );

			$response = wp_remote_post( $url,
			 array(
				'headers'    => array( 'Authorization' => 'Client-ID ' . $client_id ),
				'body'       => array( 'image' => $encoded_file ),
				)
			);

			if ( ! is_wp_error( $response ) ) {
				return json_decode( wp_remote_retrieve_body( $response ) );
			} else {
				return false;
			}

		}


	}

}
