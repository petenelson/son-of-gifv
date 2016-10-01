<?php

if ( ! class_exists( 'Son_of_GIFV_Admin' ) ) {

	class Son_of_GIFV_Admin {

		static public function setup() {
			add_action( 'admin_init',                 'Son_of_GIFV_Admin::register_admin_scripts' );
			add_action( 'admin_init',                 'Son_of_GIFV_Admin::plugin_upgrade' );
			add_action( 'admin_enqueue_scripts',      'Son_of_GIFV_Admin::enqueue_admin_scripts' );
		}

		/**
		 * Registers the admin Javascript.
		 *
		 * @return void
		 */
		static public function register_admin_scripts() {
			wp_register_script(
				'son-of-gifv-admin',
				SON_OF_GIFV_URL_ROOT . 'assets/js/admin/son-of-gifv.js',
				array( 'jquery' ),
				Son_of_GIFV_Common::VERSION,
				true
			);
		}

		/**
		 * Enqueues the admin Javascript.
		 *
		 * @return void
		 */
		static public function enqueue_admin_scripts() {

			wp_enqueue_script( 'son-of-gifv-admin' );

			// Localized data for the admin script.
			$data = array(
				'rest_api_nonce' => wp_create_nonce( 'wp_rest' ),
				'rest_api_url'   => array(
					'convert' => rest_url( 'son-of-gifv/v1/convert' ),
					)
				);

			wp_localize_script( 'son-of-gifv-admin', 'Son_of_GIFV_Admin', $data );

		}

		/**
		 * Triggers the son-of-gifv-plugin-upgrade action if the version number
		 * has changed.
		 *
		 * @return void
		 */
		static public function plugin_upgrade() {

			$current_version = get_option( 'son-of-gifv-version' );

			// Create the initial option if it doesn't exist.
			if ( false === $current_version ) {
				add_option( 'son-of-gifv-version', Son_of_GIFV_Common::VERSION, '', 'no' );
			}

			// Trigger a notification if the plugin was installed or updated.
			if ( $current_version !== Son_of_GIFV_Common::VERSION ) {
				do_action( 'son-of-gifv-plugin-upgrade', Son_of_GIFV_Common::VERSION, $current_version );

				// Update the version number in the database
				update_option( 'son-of-gifv-version', Son_of_GIFV_Common::VERSION );
			}
		}

	}

}
