<?php

	// Get the GIFV information.

	$gifv_data = Son_of_GIFV_Template::get_template_data( get_the_id() );

	$general_meta_template  = apply_filters( 'son-of-gifv-twitter-general-template', SON_OF_GIFV_PATH . 'templates/meta-template-twitter.php' );
	$twitter_meta_template  = apply_filters( 'son-of-gifv-twitter-meta-template', SON_OF_GIFV_PATH . 'templates/meta-template-twitter.php' );
	$facebook_meta_template = apply_filters( 'son-of-gifv-facebook-meta-template', SON_OF_GIFV_PATH . './templates/meta-template-facebook.php' );

?>
<html>
	<head>
		<title><?php the_title(); ?></title>

<?php if ( file_exists( $general_meta_template ) ) { include_once $general_meta_template; } ?>
<?php if ( file_exists( $twitter_meta_template ) ) { include_once $twitter_meta_template; } ?>
<?php if ( file_exists( $facebook_meta_template ) ) { include_once $facebook_meta_template; } ?>

	</head>
	<body style="margin: 0; padding: 0;">

	<!-- <?php var_dump( $gifv_data ); ?> -->

	<video width="<?php echo esc_attr( $gifv_data['attachment_width'] ); ?>" height="<?php echo esc_attr( $gifv_data['attachment_height'] ); ?>" autoplay loop>
		<source src="<?php echo esc_url( $gifv_data['mp4_url'] ); ?>" type="video/mp4">
	</video>

	</body>
</html>
