<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Son_of_GIFV_Template' ) ) {

	class Son_of_GIFV_Template {

		static public function setup() {
			add_filter( 'template_include', 'Son_of_GIFV_Template::gifv_template' );
			add_action( 'init',             'Son_of_GIFV_Template::register_template_styles' );
		}

		/**
		 * Load the GIFV template for GIFV links.
		 *
		 * @param  string $template The original template.
		 * @return string           Updated template.
		 */
		static public function gifv_template( $template ) {

			if ( is_main_query() && '1' === get_query_var( '_son_of_gifv' ) && ! is_404() ) {
				$template = apply_filters( 'son-of-gifv-template-gifv', SON_OF_GIFV_PATH . 'templates/gifv.php' );

				// Load our inline styles for the template.
				if ( is_singular() ) {

					$gifv_data = self::get_template_data( get_the_id() );

					// Add inline styles for our template.
					if ( ! empty( $gifv_data ) ) {
						$styles = ".son-of-gifv-body video {
							width: " . absint( $gifv_data['attachment_width'] ) . "px;
							height: " . absint( $gifv_data['attachment_height'] ) . "px;
						}";

						wp_add_inline_style( 'son-of-gifv', $styles );
					}
				}

			}

			return $template;
		}

		/**
		 * Gets data for the template.
		 *
		 * @param  int $attachment_id The attachment ID.
		 * @return array
		 */
		static public function get_template_data( $attachment_id ) {

			$attachment = get_post( $attachment_id );
			if ( ! empty( $attachment ) ) {

				// Build the data array to be used by the frontend templates.
				$data = array(
					'id'                 => $attachment_id,
					'mp4_id'             => get_post_meta( $attachment_id, 'son_of_gifv_mp4_id', true ),
					'thumbnail_id'       => get_post_meta( $attachment_id, 'son_of_gifv_thumbnail_id', true ),
					'mp4_url'            => '',
					'thumbnail_url'      => '',
					'attachment_width'   => 320,
					'attachment_height'  => 200,
					'permalink'          => Son_of_GIFV_Attachment::gifv_url( $attachment_id ),
					// Bug in get_the_excerpt() https://core.trac.wordpress.org/ticket/36934, so we'll just grab the post field for now.
					'caption'            => get_post_field( 'post_excerpt', $attachment_id ),
					'domain'             => str_replace( 'http://', '', str_replace( 'https://', '', get_site_url() ) ),
				);

				// Get the URL for the MP4.
				if ( ! empty( $data['mp4_id'] ) ) {
					$data['mp4_url'] = wp_get_attachment_url( $data['mp4_id'] );
				}

				// Get the URL for the thumbnail.  This is primarily used in the
				// meta tags for Twitter cards and opengraph.
				if ( ! empty( $data['thumbnail_id'] ) ) {
					$data['thumbnail_url'] = wp_get_attachment_url( $data['thumbnail_id'] );
				}

				// Get the height and width of the GIF, used in the MP4 video tag.
				$metadata = wp_get_attachment_metadata( $attachment_id );
				if ( ! empty( $metadata ) ) {
					$data['attachment_width']  = $metadata['width'];
					$data['attachment_height'] = $metadata['height'];
				}

				return apply_filters( 'son-of-gifv-template-data', $data, $attachment_id );
			} else {
				return false;
			}

		}

		/**
		 * Gets the list of templates used in the GIFV template head section.
		 *
		 * @return array
		 */
		static public function get_head_templates() {

			$templates = array(
				'general'     => SON_OF_GIFV_PATH . 'templates/meta-template-general.php',
				'opengraph'   => SON_OF_GIFV_PATH . 'templates/meta-template-opengraph.php',
				'twitter'     => SON_OF_GIFV_PATH . 'templates/meta-template-twitter.php',
				);

			return apply_filters( 'son-of-gifv-templates-head', $templates );
		}

		static public function register_template_styles() {
			wp_register_style(
				'son-of-gifv',
				SON_OF_GIFV_URL_ROOT . 'assets/css/son-of-gifv.css',
				array(),
				Son_of_GIFV_Common::VERSION
			);
		}

	}

}