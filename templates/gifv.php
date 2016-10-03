<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get the GIFV information.

$gifv_data  = Son_of_GIFV_Template::get_template_data( get_the_id() );
$templates  = Son_of_GIFV_Template::get_head_templates();

?>
<html>
	<head>
		<title><?php the_title(); ?></title>
		<?php

			// Output only our stylesheet. Because this is a specialized template,
			// we only need our stylesheet and not the rest of the theme
			// templates.
			wp_print_styles( 'son-of-gifv' );

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
			<?php esc_html_e( 'Your browser does not support video', 'son-of-gifv' ); ?>
		</video>

		<?php do_action( 'son-of-gifv-template-footer', $gifv_data ); ?>

	</body>
</html>
