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
				'imgur_response'           => false,
				'mp4_attachment_id'        => 0,
				'thumbnail_attachment_id'  => 0,
				'error'                    => '',
			);
		}

		static public function has_gifv( $attachment_id ) {
			
		}

		/**
		 * Creates a GIFV attachment for an animated GIF.
		 *
		 * @param  int $attachment_id The attachment ID.
		 * @return array              Results of the conversion process.
		 */
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
			$imgur_response = Son_of_GIFV_Imgur::upload( $results['filename'] );

			// Check if the upload worked.
			if ( empty( $imgur_response ) ) {
				$results['error'] = __( 'Unable to upload image to Imgur', 'son-of-gifv' );
				return $results;
			} else {
				$results['imgur_response'] = $imgur_response;
			}

			// Excellent, let's store the results so far to the attachment
			// so we have it for future reference.
			self::store_convert_results( $attachment_id, $results );

			// Download the MP4.
			$results = self::download_mp4( $results );

			// Store the current results of the conversion.
			self::store_convert_results( $attachment_id, $results );

			// Break out of here if we don't have the MP4.
			if ( ! empty( $results['error'] ) ) {
				return $results;
			}

			// Download the thumbnail.
			$results = self::download_thumbnail( $results );

			// Store the IDs separately.
			if ( ! empty( $results['mp4_attachment_id'] ) ) {
				update_post_meta( $attachment_id, 'son_of_gifv_mp4_id', $results['mp4_attachment_id'] );
			}

			if ( ! empty( $results['thumbnail_attachment_id'] ) ) {
				update_post_meta( $attachment_id, 'son_of_gifv_thumbnail_id', $results['thumbnail_attachment_id'] );
			}

			// Store the final results of the conversion.
			self::store_convert_results( $attachment_id, $results );

			return $results;

		}

		static public function download_mp4( $results ) {

			if ( ! empty( $results['imgur_response']->data ) && ! empty( $results['imgur_response']->data->mp4 ) ) {

				// Make the local temp .mp4 filename match the .gif filename.
				$local_mp4_filename = basename( $results['filename'], '.gif' ) . '.mp4';

				// Download the URL locally.
				$local_mp4 = Son_of_GIFV_Attachment::download_file( $results['imgur_response']->data->mp4, $local_mp4_filename );

				if ( ! empty( $local_mp4 ) ) {

					// Sideload the MP4 into the media library.
					$title = sprintf( __( 'MP4 for %s', 'son-of-gifv' ), basename( $results['filename'] ) );
					$mp4_id = Son_of_GIFV_Attachment::sideload_file( $local_mp4, basename( $local_mp4_filename ), $title );

					// Store the MP4 attachment ID.
					if ( ! empty( $mp4_id ) ) {
						$results['mp4_attachment_id'] = $mp4_id;
					} else {
						$results['error'] = sprintf( __( 'Unable to sideload %s', 'son-of-gifv' ), $local_mp4 );
					}

				} else {
					$results['error'] = sprintf( __( 'Unable to download MP4 %s', 'son-of-gifv' ), $results['imgur_response']->data->mp4 );
				}

			}

			return $results;
		}

		static public function download_thumbnail( $results ) {

			if ( ! empty( $results['imgur_response']->data ) && ! empty( $results['imgur_response']->data->id ) ) {

				// It looks like the thumbnail is the ID plus 'h.jpg' at the end.
				$id = trim( $results['imgur_response']->data->id );

				// Build the thumbnail URL.
				$thumbnail_url = apply_filters( 'son-of-gifv-imgur-thumbnail-url', "https://i.imgur.com/{$id}h.jpg", $results['imgur_response'] );

				// Download the thumbnail locally.
				$local_thumbnail = Son_of_GIFV_Attachment::download_file( $thumbnail_url, basename( $results['filename'] ) . '.jpg' );

				if ( ! empty( $local_thumbnail ) ) {

					// Sideload the thumbnail into the media library.
					$title = sprintf( __( 'Thumbnail for %s', 'son-of-gifv' ), basename( $results['filename'] ) );
					$thumbnail_id = Son_of_GIFV_Attachment::sideload_file( $local_thumbnail, basename( $local_thumbnail ), $title );

					// Store the thumbnail attachment ID.
					if ( ! empty( $thumbnail_id ) ) {
						$results['thumbnail_attachment_id'] = $thumbnail_id;
					} else {
						$results['error'] = sprintf( __( 'Unable to sideload %s', 'son-of-gifv' ), $local_thumbnail );
					}

				} else {
					$results['error'] = sprintf( __( 'Unable to download thumbnail %s', 'son-of-gifv' ), $thumbnail_url );
				}
			}

			return $results;
		}

		static public function store_convert_results( $attachment_id, $results ) {
			update_post_meta( $attachment_id, 'son_of_gifv_convert_results', $results );			
		}

	}

}