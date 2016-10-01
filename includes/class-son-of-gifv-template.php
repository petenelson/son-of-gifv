<?php

if ( ! class_exists( 'Son_of_GIFV_Template' ) ) {

	class Son_of_GIFV_Template {

		static public function setup() {
			add_filter( 'template_include', 'Son_of_GIFV_Template::gifv_template' );
		}

		/**
		 * Load thge GIFV template for GIFV links.
		 *
		 * @param  string $template The original template.
		 * @return string           Updated template.
		 */
		static public function gifv_template( $template ) {

			if ( is_main_query() && '1' === get_query_var( '_son_of_gifv' ) ) {
				$template = apply_filters( 'son-of-gifv-template-gifv', SON_OF_GIFV_PATH . 'templates/gifv.php' );
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

				if ( ! empty( $data['mp4_id'] ) ) {
					$data['mp4_url'] = wp_get_attachment_url( $data['mp4_id'] );
				}

				if ( ! empty( $data['thumbnail_id'] ) ) {
					$data['thumbnail_url'] = wp_get_attachment_url( $data['thumbnail_id'] );
				}

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

		static public function get_head_templates() {

			$templates = array(
				'general'     => SON_OF_GIFV_PATH . 'templates/meta-template-general.php',
				'opengraph'   => SON_OF_GIFV_PATH . 'templates/meta-template-opengraph.php',
				'twitter'     => SON_OF_GIFV_PATH . 'templates/meta-template-twitter.php',
				);

			return apply_filters( 'son-of-gifv-templates-head', $templates );
		}

	}

}