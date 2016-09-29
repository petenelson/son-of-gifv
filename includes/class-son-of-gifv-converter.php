<?php

if ( ! class_exists( 'Son_of_GIFV_Converter' ) ) {

	class Son_of_GIFV_Converter {

		static public function setup() {

			// TODO add actions and filters

		}

		/**
		 * Returns the default results for the conversion process.
		 *
		 * @return array
		 */
		static public function get_default_results() {
			return array(
				'attachment_id'            => 0,
				'is_gif'                   => false,
				'is_animated_gif'          => false,
				'filename'                 => '',
				'imgur_id'                 => '',
				'imgur_results'            => false,
				'mp4_attachment_id'        => 0,
				'thumnail_attachment_id'   => 0,
				'error'                    => '',
			);
		}

		static public function gif_to_gifv( $attachment_id ) {
			// TODO
			// does it already have a GIFV?

			// Setup default results.
			$results = self::get_default_results();

			// Verify it's an attachment.
			$post = get_post( $attachment_id );
			if ( empty( $post ) ) {
				$results['error'] = sprintf( __( 'ID %s does not exist', 'son-of-gifv' ), $attachment_id );
				return $results;
			}

			// Valid ID, we can store it.
			$attachment_id = absint( $attachment_id );
			$results['attachment_id'] = $attachment_id;

			if ( 'attachment' !== $post->post_type ) {
				$results['error'] = sprintf( __( 'ID %d is not an attachment', 'son-of-gifv' ), $attachment_id );
				return $results;
			}

			// Is it a GIF?
			$results['is_gif'] = Son_of_GIFV_Attachment::is_gif( $attachment_id );
			if ( ! $results['is_gif'] ) {
				$results['error'] = sprintf( __( 'Attachment ID %d is not a GIF', 'son-of-gifv' ), $attachment_id );
				return $results;
			}

			// Is it an animated GIF
			$results['is_animated_gif'] = Son_of_GIFV_Attachment::is_animated_gif( $attachment_id );
			if ( ! $results['is_animated_gif'] ) {
				$results['error'] = sprintf( __( 'Attachment ID %d is not an animated GIF', 'son-of-gifv' ), $attachment_id );
				return $results;
			}

			// So far, so good.
			$results['filename'] = get_attached_file( $attachment_id );

			// upload GIF to Imgur

			// TODO download MP4
			// TODO sideload MP4
			// TODO download thumbnail
			// TODO flag GIF with GIFV info

			return $results;

		}

		static public function upload_gif_to_imgur( $filename ) {
			// TODO
		}

	}

}