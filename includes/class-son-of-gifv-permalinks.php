<?php

if ( ! class_exists( 'Son_of_GIFV_Permalinks' ) ) {

	class Son_of_GIFV_Permalinks {

		/**
		 * Setup WordPress actions and filters.
		 *
		 * @return void
		 */
		static public function setup() {

			add_action( 'init',                    'Son_of_GIFV_Permalinks::register_rewrite_rules' );
			add_filter( 'query_vars',              'Son_of_GIFV_Permalinks::add_query_vars' );
			add_filter( 'user_trailingslashit',    'Son_of_GIFV_Permalinks::user_trailingslashit', 10 , 2 );

		}

		/**
		 * Adds rewrite rules for .gifv links.
		 *
		 * @return void
		 */
		static public function register_rewrite_rules() {
			add_rewrite_rule( "^.+/([0-9a-z\-\_]+)\.gifv?", 'index.php?son_of_gifv_name=$matches[1]&_son_of_gifv=1', 'top' );
			add_rewrite_rule( "([0-9a-z\-\_]+)\.gifv", 'index.php?son_of_gifv_name=$matches[1]&_son_of_gifv=1', 'top' );
		}

		/**
		 * Adds query vars to support the .gifv rewrite rules.
		 *
		 * @param $query_vars array The list of query vars.
		 * @return array            Updated list of query vars.
		 */
		static public function add_query_vars( $query_vars ) {
			$query_vars[] = 'son_of_gifv_name';
			$query_vars[] = '_son_of_gifv';
			return $query_vars;
		}

		/**
		 * Removes the trailing slash from .gifv links.
		 *
		 * @param  string $url  The relative URL.
		 * @param  string $type The type of URL.
		 * @return string       The modified URL.
		 */
		static public function user_trailingslashit( $url, $type ) {

			$find = '.gifv/';

			// Does this end with .gifv/ ?
			if ( strpos( $url, $find ) === strlen( $url ) - strlen( $find ) ) {
				// Remove the trailing slash.
				$url = substr( $url, 0, strlen( $url ) - 1 );
			}

			return $url;
		}
	}

}
