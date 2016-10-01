<?php

if ( ! class_exists( 'Son_of_GIFV_Common' ) ) {

	class Son_of_GIFV_Common {

		const VERSION = '1.0.0';

		static public function setup() {
			add_action( 'admin_init',                 'Son_of_GIFV_Common::register_admin_scripts' );
			add_action( 'admin_enqueue_scripts',      'Son_of_GIFV_Common::enqueue_admin_scripts' );
		}

		static public function register_admin_scripts() {
			wp_register_script( 'son-of-gifv-admin', SON_OF_GIFV_URL_ROOT . 'assets/js/admin/son-of-gifv.js' );
		}

		static public function enqueue_admin_scripts() {
			wp_enqueue_script( 'son-of-gifv-admin' );
		}

	}

}