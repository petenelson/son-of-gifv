<?php

	// Get the GIFV information.

	$gifv_data  = Son_of_GIFV_Template::get_template_data( get_the_id() );
	$templates  = Son_of_GIFV_Template::get_head_templates();
	$stylesheet = apply_filters( 'son-of-gifv-stylesheet', SON_OF_GIFV_URL_ROOT . 'assets/css/son-of-gifv.css' );

?>
<html>
	<head>
		<title><?php the_title(); ?></title>

		<?php if ( ! empty( $stylesheet ) ) : ?>
			<link rel="stylesheet" type="text/css" href="<?php echo esc_url( $stylesheet ); ?>" />
		<?php endif; ?>

		<?php
			// Output the head templates (ex: meta tags).
			foreach( $templates as $name => $template ) {
				if ( file_exists( $template ) ) {
					include_once $template;
				}
			}

			do_action( 'son-of-gifv-template-head', $gifv_data );
		?>

	</head>
	<body class="son-of-gifv-body">

		<?php do_action( 'son-of-gifv-template-body', $gifv_data ); ?>

		<video poster="<?php echo esc_url( $gifv_data['thumbnail_url']  ); ?>" width="<?php echo esc_attr( $gifv_data['attachment_width'] ); ?>" height="<?php echo esc_attr( $gifv_data['attachment_height'] ); ?>" preload="auto" autoplay="autoplay" muted="muted" loop="loop" webkit-playsinline>
			<source src="<?php echo esc_url( $gifv_data['mp4_url'] ); ?>" type="video/mp4">
		</video>

		<?php do_action( 'son-of-gifv-template-footer', $gifv_data ); ?>

	</body>
</html>
