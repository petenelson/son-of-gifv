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

		static public function download_mp4( $url ) {
			// TODO
		}

		static public function sideload_mp4( $url ) {
			// TODO
		}

	}

}