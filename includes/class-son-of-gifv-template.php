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
				$template = SON_OF_GIFV_PATH . 'templates/gifv.php';
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

			$data = array(
				'mp4_id'             => get_post_meta( $attachment_id, 'son_of_gifv_mp4_id', true ),
				'thumbnail_id'       => get_post_meta( $attachment_id, 'son_of_gifv_thumbnail_id', true ),
				'mp4_url'            => '',
				'thumbnail_url'      => '',
				'attachment_width'   => 320,
				'attachment_height'  => 200,
				);


			if ( ! empty( $data['mp4_id'] ) ) {
				$data['mp4_url'] = wp_get_attachment_url( $data['mp4_id'] );
			}

			if ( ! empty( $data['thumbnail_id'] ) ) {
				$data['thumbnail_url'] = wp_get_attachment_url( $data['thumbnail_id'] );
			}

			$attachment_src = wp_get_attachment_image_src( $attachment_id, 'full' );
			if ( ! empty( $attachment_src ) ) {
				$data['attachment_width']  = $attachment_src[1];
				$data['attachment_height'] = $attachment_src[2];
			}

			return $data;

		}

	}

}