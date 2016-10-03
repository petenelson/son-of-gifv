<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Son_of_GIFV_REST_API' ) ) {

	class Son_of_GIFV_REST_API {

		static public function setup() {
			add_action( 'rest_api_init', 'Son_of_GIFV_REST_API::add_endpoints' );
		}

		/**
		 * Registers a REST API endpoint to convert GIF to GIFV.
		 *
		 * @return void
		 */
		static public function add_endpoints() {
			register_rest_route(
				'son-of-gifv',
				'v1/convert',
				array(
					'callback'              => 'Son_of_GIFV_REST_API::convert_gif_to_gifv',
					'permission_callback'   => 'Son_of_GIFV_REST_API::user_can_upload_files',
					'methods'  => array( 'GET', 'POST' ),
					'args'     => array(
						'attachment_id' => array(
							'required'            => true,
							'sanitize_callback'   => 'absint',
							)
						),

					)
			);
		}

		/**
		 * Permissions callback for the convert endpoint.
		 *
		 * @return boolean
		 */
		static public function user_can_upload_files() {
			return current_user_can( 'upload_files' );
		}

		/**
		 * REST API handler to convert GIF to GIFV.
		 *
		 * @param  object $request The REST request.
		 * @return object          The REST response.
		 */
		static public function convert_gif_to_gifv( $request ) {

			// Convert the attachment.
			$results = Son_of_GIFV_Converter::gif_to_gifv( $request['attachment_id'] );

			// Add the form field template.
			if ( empty( $results['error'] ) ) {
				$template = apply_filters( 'son-of-gifv-template-has-gifv', SON_OF_GIFV_PATH . 'templates/admin/has-gifv-form-fields.php' );
				$results['html'] = Son_of_GIFV_Attachment::get_gifv_form_fields( $template, get_post( $results['attachment_id'] ) );
			}

			// Filter the results.
			$results = apply_filters( 'son-of-gifv-rest-convert-results', $results, $request );

			return rest_ensure_response( $results );
		}

	}
}
