<?php

	// Get the GIFV information.

	$data = Son_of_GIFV_Template::get_template_data( get_the_id() );

?>
<html>
	<head>
		<title><?php the_title(); ?></title>
	</head>
	<body style="margin: 0; padding: 0;">

	<!-- <?php var_dump( $data ); ?> -->

	<video width="<?php echo esc_attr( $data['attachment_width'] ); ?>" height="<?php echo esc_attr( $data['attachment_height'] ); ?>" autoplay loop>
		<source src="<?php echo esc_url( $data['mp4_url'] ); ?>" type="video/mp4">
	</video>

	</body>
</html>
