<?php

if ( ! class_exists( 'Son_of_GIFV_Attachment' ) ) {

	class Son_of_GIFV_Attachment {

		static public function setup() {

			// TODO add actions and filters

		}

		static public function has_gifv( $attachment_id ) {
			// TODO
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


	}

}