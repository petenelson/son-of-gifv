<?php

if ( ! class_exists( 'Son_of_GIFV_Permalinks' ) ) {

	class Son_of_GIFV_Permalinks {

		static public function setup() {

			add_action( 'init',         'Son_of_GIFV_Permalinks::register_rewrite_rules' );

			add_filter( 'query_vars',   'Son_of_GIFV_Permalinks::add_query_vars' );

		}

		static public function register_rewrite_rules() {

		}

		static public function add_query_vars( $query_vars ) {
			
			return $query_vars;
		}

	}

}

