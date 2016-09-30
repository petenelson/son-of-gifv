<?php

if ( ! class_exists( 'Son_of_GIFV_Permalinks' ) ) {

	class Son_of_GIFV_Permalinks {

		static public function setup() {

			add_action( 'init',         'Son_of_GIFV_Permalinks::register_rewrite_rules' );

			add_filter( 'query_vars',   'Son_of_GIFV_Permalinks::add_query_vars' );

		}

		static public function register_rewrite_rules() {
			add_rewrite_rule( "^.+/([0-9a-z\-\_]+)\.gifv?", 'index.php?son_of_gifv_name=$matches[1]&_son_of_gifv=1', 'top' );
			add_rewrite_rule( "([0-9a-z\-\_]+)\.gifv", 'index.php?son_of_gifv_name=$matches[1]&_son_of_gifv=1', 'top' );
		}

		static public function add_query_vars( $query_vars ) {
			$query_vars[] = 'son_of_gifv_name';
			$query_vars[] = '_son_of_gifv';
			return $query_vars;
		}

	}

}
