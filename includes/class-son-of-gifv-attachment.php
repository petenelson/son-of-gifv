<?php

if ( ! class_exists( 'Son_of_GIFV_Attachment' ) ) {

	class Son_of_GIFV_Attachment {

		static public function setup() {
			add_action( 'pre_get_posts', 'Son_of_GIFV_Attachment::update_main_query' );

			add_filter( 'attachment_fields_to_edit', 'Son_of_GIFV_Attachment::attachment_fields_to_edit', 10, 2 );
		}

		static public function update_main_query( $query ) {
			if ( $query->is_main_query() && '1' === $query->get( '_son_of_gifv' ) ) {
				$attachment_name = $query->get( 'son_of_gifv_name' );

				$args = array(
					'posts_per_page'   => 1,
					'post_type'        => 'attachment',
					'post_status'      => 'inherit',
					'post_mime_type'   => 'image/gif',
					'name'             => $attachment_name,
					'meta_query'       => array(
						array(
							'key'     => 'son_of_gifv_mp4_id',
							'type'    => 'numeric',
							'compare' => '>',
							'value'   => 0,
							),
						array(
							'key'     => 'son_of_gifv_thumbnail_id',
							'type'    => 'numeric',
							'compare' => '>',
							'value'   => 0,
							)
						),
					);


				$query->parse_query( $args );
				$query->set( '_son_of_gifv', '1' );

			}
		}

		/**
		 * Returns true if the attacment ID as a corresponding MP4 and
		 * thumbnail attachment.
		 *
		 * @param  int  $attachment_id The attachment ID.
		 * @return boolean
		 */
		static public function has_gifv( $attachment_id ) {
			$mp4_id        = get_post_meta( $attachment_id, 'son_of_gifv_mp4_id', true );
			$thumbnail_id  = get_post_meta( $attachment_id, 'son_of_gifv_thumbnail_id', true );
			if ( ! empty( $mp4_id ) && ! empty( $thumbnail_id ) ) {

				return
					'video/mp4'  === get_post_field( 'post_mime_type', $mp4_id ) &&
					'image/jpeg' === get_post_field( 'post_mime_type', $thumbnail_id);

			}
		}

		static public function is_gif( $attachment_id ) {
			return 'image/gif' === get_post_mime_type( $attachment_id );
		}

		static public function is_animated_gif( $attachment_id ) {

			if ( ! self::is_gif( $attachment_id ) ) {
				return false;
			}

			$filename = get_attached_file( $attachment_id );

			// From https://stackoverflow.com/questions/280658/can-i-detect-animated-gifs-using-php-and-gd

			// Open the file.
			$fh = @fopen( $filename, 'rb' );
			if( ! $fh ) {
				return false;
			}
			$count = 0;
			//an animated gif contains multiple "frames", with each frame having a
			//header made up of:
			// * a static 4-byte sequence (\x00\x21\xF9\x04)
			// * 4 variable bytes
			// * a static 2-byte sequence (\x00\x2C)

			// We read through the file til we reach the end of the file, or we've found
			// at least 2 frame headers
			while( !feof( $fh ) && $count < 2 ) {
				$chunk = fread( $fh, 1024 * 100 ); //read 100kb at a time
				$count += preg_match_all( '#\x00\x21\xF9\x04.{4}\x00[\x2C\x21]#s', $chunk, $matches );
			}
			fclose( $fh );
			return $count > 1;
		}

		/**
		 * Sideloads a downloaded temporary file into a new WordPress attachment.
		 *
		 * @param  string $local_filename         Full path to the local file.
		 * @param  string $attachment_file_name   The file name for the WordPress attachment.
		 * @param  string $attachment_description Optional description for the file.
		 * @return int                            The new attachment ID.
		 */
		static public function sideload_file( $local_filename, $attachment_file_name, $attachment_description = '' ) {

			// sideload the binary data
			$file_array = array(
				'name' => $attachment_file_name,
				'tmp_name' => $local_filename,
				);

			$results = media_handle_sideload( $file_array, 0, $attachment_description );

			if ( ! is_wp_error( $results ) ) {
				return $results;
			} else {
				return false;
			}
		}

		/**
		 * Downloads a URL to a local file.
		 * @param  string $url            The URL to the file.
		 * @param  string $local_filename The requested local file name.
		 * @return string                 The full local path to the downloaded file.
		 */
		static public function download_file( $url, $local_filename ) {

			// Download the file.
			$response = wp_remote_get( $url );

			if ( ! is_wp_error( $response ) ) {
				// Get the file contents.
				$contents  = wp_remote_retrieve_body( $response );

				// Save the contents to a file.
				$temp_file = self::binary_data_to_file( $contents, trailingslashit( wp_upload_dir()['basedir'] ), $local_filename );

				return $temp_file;
			}
		}

		/**
		 * Writes binary data to a unique filename specified by the
		 * directory and filename.
		 *
		 * @param  binary $binary_data The binary file contents.
		 * @param  string $directory   The destination directory for the file.
		 * @param  string $file_name   The requested file name.
		 * @return string              The full path of the file that was written.
		 */
		static public function binary_data_to_file( $binary_data, $directory, $file_name ) {

			// Write the binary data to a temporary file.
			$temp_file = trailingslashit( $directory ) . wp_unique_filename( $directory, $file_name );

			$fh = fopen( $temp_file, 'wb' );
			fputs( $fh, $binary_data );
			fclose( $fh );

			return $temp_file;
		}

		static public function gifv_url( $attachment_id ) {
			if ( self::has_gifv( $attachment_id ) ) {
				$attachment = get_post( $attachment_id );
				return site_url( $attachment->post_name . '.gifv' );
			}
		}

		static public function attachment_fields_to_edit( $form_fields, $post ) {
			// TODO make the chimichangas.

			// sample code to update later
			// ob_start();
			// output_posts_related_to( $posts, $users );
			// $related_to_html = ob_get_clean();

			// $form_fields['related_to_posts'] = array(
			// 	'label' => __( 'Related To', 'son-of-gifv' ),
			// 	'input' => 'html',
			// 	'html'  => $related_to_html,
			// 	);

			// return $form_fields;


			return $form_fields;
		}


	}

}