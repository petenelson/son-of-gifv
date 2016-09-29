<?php

if ( ! class_exists( 'Son_of_GIFV_CLI' ) ) {

	class Son_of_GIFV_CLI {


	}

}



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
