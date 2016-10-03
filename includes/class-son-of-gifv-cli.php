<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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

			if ( ! empty( $results['error'] ) ) {
				WP_CLI::Error( $results['error'] );
			} else {
				WP_CLI::Success( sprintf( 'GIFV created for ID %d, URL %s', $results['attachment_id'], $results['gifv_url'] ) );
			}

		}


	}

}

WP_CLI::add_command( 'gifv', 'Son_of_GIFV_CLI' );
