<?php

if ( ! class_exists( 'Son_of_GIFV_Converter' ) ) {

	class Son_of_GIFV_Converter {

		static public function setup() {

			// TODO add actions and filters

		}

		static public function gif_to_gifv( $attachment_id ) {
			// TODO
			// does it already have a GIFV?

			// Setup default results.
			$results = array(
				'attachment_id'            => 0,
				'is_gif'                   => false,
				'is_animated_gif'          => false,
				'imgur_id'                 => '',
				'imgur_results'            => false,
				'mp4_attachment_id'        => 0,
				'thumnail_attachment_id'   => 0,
				'error'                    => '',
				);

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
			if ( $results['is_gif'] ) {
				$results['attachment_id'] = absint( $attachment_id );
			} else {
				$results['error'] = sprintf( __( 'Attachment ID %d is not a GIF', 'son-of-gifv' ), $attachment_id );
				return $results;
			}

			// Is it an animated GIF



			// upload GIF to Imgur
			// download MP4
			// sideload MP4
			// download thumbnail
			// flag GIF with GIFV info

			return $results;

		}

		static public function upload_gif_to_imgur( $attachment_id ) {
			// TODO
		}

	}

}