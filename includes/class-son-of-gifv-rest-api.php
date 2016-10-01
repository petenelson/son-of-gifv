<?php

if ( ! class_exists( 'Son_of_GIFV_REST_API' ) ) {

	class Son_of_GIFV_REST_API {

		static public function setup() {
			add_action( 'rest_api_init', 'Son_of_GIFV_REST_API::add_endpoints' );
		}

		static public function add_endpoints() {
			register_rest_route(
				'son-of-gifv',
				'v1/convert',
				array(
					'callback'              => 'Son_of_GIFV_REST_API::convert_gif_to_gifv',
					//'permission_callback'   => 'is_user_logged_in',
					'methods'  => array( 'GET', 'POST' ),
					'args'     => array(
						'attachment_id' => array(
							'required' => true,
							)
						),

					)
			);
		}

		static public function convert_gif_to_gifv( $request ) {

			$results = Son_of_GIFV_Converter::gif_to_gifv( $request['attachment_id'] );

			return rest_ensure_response( $results );
		}

	}
}
